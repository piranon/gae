<?php

class Start extends base_module_controller
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function add()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('category_name', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $category_category_name = t_Post('category_name');
        $category_parent_id = t_Post('parent_id');
        $category_sort_index= t_Post('sort_index');
        $extra_field_label_color= t_Post('label_color');
        $extra_field_font_color= t_Post('font_color');

        // Business logic
        $dbData = array();
        $dbData['parent_id'] = $category_parent_id;
        $dbData['name'] = $category_category_name;
        $dbData['sort_index'] = $category_sort_index;
        $dbData['status'] = self::STATUS_ACTIVE;
        $dbData['create_time'] = time();

        $this->mLoadModel('referral_model');
        $this->mLoadModel('referral_type_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');
        $this->mLoadModel('extra_field_model');

        try {
            $dbData['referral_type_id'] = $this->referral_type_model->get_referral_type_id('product-category');
            $referral_id = $this->referral_model->insert($dbData);
            $table_id = $this->table_model->get_table_id('referral');
            $this->image_model->upload_image($referral_id, $table_id);
            $this->extra_field_model->insert_color(
                $referral_id,
                $table_id,
                $extra_field_label_color,
                $extra_field_font_color
            );
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk(['time' => time()]);
    }

    public function update()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('category_name', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $category_category_name = t_Post('category_name');
        $category_parent_id = t_Post('parent_id');
        $category_sort_index= t_Post('sort_index');
        $extra_field_label_color= t_Post('label_color');
        $extra_field_font_color= t_Post('font_color');
        $referral_id = t_Post('id');

        // Business logic
        $dbData = array();
        $dbData['parent_id'] = $category_parent_id;
        $dbData['name'] = $category_category_name;
        $dbData['sort_index'] = $category_sort_index;
        $dbData['status'] = self::STATUS_ACTIVE;
        $dbData['create_time'] = time();

        $this->mLoadModel('referral_model');
        $this->mLoadModel('referral_type_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');
        $this->mLoadModel('extra_field_model');

        try {
            $this->referral_model->update(array_filter($dbData), $referral_id);
            $table_id = $this->table_model->get_table_id('referral');
            $this->image_model->upload_image($referral_id, $table_id);
            $this->extra_field_model->update_color(
                $referral_id,
                $table_id,
                $extra_field_label_color,
                $extra_field_font_color
            );
        } catch (Exception $e) {
            resDie($e->getMessage());
        }
        // Response
        resOk(['time' => time()]);
    }

    public function listing()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('table_model');
        $this->mLoadModel('referral_model');
        $this->mLoadModel('image_model');
        $this->mLoadModel('extra_field_model');

        $table_id = $this->table_model->get_table_id('referral');
        $referrals = $this->referral_model->get_referrals($table_id);

        $response = [];
        foreach ($referrals as $referral) {
            $referral = array_merge($referral, $this->image_model->get_image($table_id, $referral['referral_id']));
            $extra_fields = $this->extra_field_model->get_extra_fields($table_id, $referral['referral_id']);
            foreach ($extra_fields as $extra_field) {
                if ($extra_field['field_name'] === 'label_color' && !$extra_field['field_value']) {
                    $extra_field['field_value'] = '#eee';
                }
                if ($extra_field['field_name'] === 'font_color' && !$extra_field['field_value']) {
                    $extra_field['field_value'] = '#666';
                }
                $referral[$extra_field['field_name']] = $extra_field['field_value'];
            }
            $cate_child = $this->referral_model->get_cate_child($referral['referral_id'], 2);
            $referral['cate_lv'] = 1;
            $referral['cate_child_count'] = count($cate_child);
            $referral['cate_child'] = $cate_child;
            $response[] = $referral;
        }

        // Response
        resOk($response);
    }

    public function update_status()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('id', 'trim|required');
        $this->form_validation->set_rules('status', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $referral_id = t_Post('id');
        $referral_status = t_Post('status');

        // Business logic
        $dbData = array();
        $dbData['update_time'] = time();
        switch ($referral_status) {
            case self::STATUS_INACTIVE:
                $dbData['status'] = self::STATUS_INACTIVE;
                break;
            case self::STATUS_ACTIVE:
                $dbData['status'] = self::STATUS_ACTIVE;
                break;
            case self::STATUS_BLOCK:
                $dbData['status'] = self::STATUS_BLOCK;
                break;
        }

        $this->mLoadModel('referral_model');

        try {
            $this->referral_model->update($dbData, $referral_id);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }
        // Response
        resOk();
    }

    public function bulk_delete()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $referral_ids = t_Post('ids');

        // Business logic
        $referral_ids = explode(',', $referral_ids);
        if (!is_array($referral_ids)) {
            resDie("Cannot delete referral data");
        }

        $this->mLoadModel('table_model');
        $this->mLoadModel('referral_model');
        $this->mLoadModel('image_model');

        try {
            $table_id = $this->table_model->get_table_id('referral');
            $this->referral_model->batch_update($referral_ids, self::STATUS_INACTIVE);

            foreach ($referral_ids as $referral_id) {
                $this->image_model->delete_image($referral_id, $table_id);
            }
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function bulk_show()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $referral_ids = t_Post('ids');

        // Business logic
        $referral_ids = explode(',', $referral_ids);
        if (!is_array($referral_ids)) {
            resDie("Cannot delete referral data");
        }

        $this->mLoadModel('referral_model');

        try {
            $this->referral_model->batch_update($referral_ids, self::STATUS_ACTIVE);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function bulk_hide()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $referral_ids = t_Post('ids');

        // Business logic
        $referral_ids = explode(',', $referral_ids);
        if (!is_array($referral_ids)) {
            resDie("Cannot delete referral data");
        }

        $this->mLoadModel('referral_model');

        try {
            $this->referral_model->batch_update($referral_ids, self::STATUS_BLOCK);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }
}
