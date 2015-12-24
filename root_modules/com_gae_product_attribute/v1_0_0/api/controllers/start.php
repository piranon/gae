<?php

class Start extends base_module_controller
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;
    const REFERRAL_TYPE = 'product-category';

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
        $this->form_validation->set_rules('attribute_type_id', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $attribute_category_name = t_Post('category_name');
        $attribute_parent_id = t_Post('parent_id');
        $attribute_type_id= t_Post('attribute_type_id');

        // Business logic
        $dbData = array();
        $dbData['parent_id'] = $attribute_parent_id;
        $dbData['attribute_type_id'] = $attribute_type_id;
        $dbData['name'] = $attribute_category_name;
        $dbData['status'] = self::STATUS_ACTIVE;
        $dbData['create_time'] = time();

        $this->mLoadModel('attribute_model');
        $this->mLoadModel('attribute_type_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        try {
            $referral_id = $this->attribute_model->insert($dbData);
            $table_id = $this->table_model->get_table_id('attribute');
            $this->image_model->upload_image($referral_id, $table_id);
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
        $attribute_category_name = t_Post('category_name');
        $attribute_parent_id = t_Post('parent_id');
        $attribute_type_id= t_Post('attribute_type_id');
        $attribute_id = t_Post('id');

        // Business logic
        $dbData = array();
        $dbData['parent_id'] = $attribute_parent_id;
        $dbData['name'] = $attribute_category_name;
        $dbData['attribute_type_id'] = $attribute_type_id;
        $dbData['create_time'] = time();

        $this->mLoadModel('attribute_model');
        $this->mLoadModel('attribute_type_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        try {
            $this->attribute_model->update(array_filter($dbData), $attribute_id);
            $table_id = $this->table_model->get_table_id('attribute');
            $this->image_model->upload_image($attribute_id, $table_id);
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
        $this->mLoadModel('attribute_model');
        $this->mLoadModel('attribute_type_model');
        $this->mLoadModel('image_model');

        $table_id = $this->table_model->get_table_id('attribute');
        $attributes = $this->attribute_model->get_attributes();

        $response = [];
        $response['items'] = [];
        foreach ($attributes as $attribute) {
            $attribute = array_merge($attribute, $this->image_model->get_image($table_id, $attribute['attribute_id']));
            $cate_child = $this->attribute_model->get_cate_child($attribute['attribute_id'], 2);
            $attribute['cate_child_count'] = count($cate_child);
            $attribute['cate_child'] = $cate_child;
            $response['items'][] = $attribute;
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
        $attribute_id = t_Post('id');
        $attribute_status = t_Post('status');

        // Business logic
        $dbData = array();
        $dbData['update_time'] = time();
        switch ($attribute_status) {
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

        $this->mLoadModel('attribute_model');

        try {
            $this->attribute_model->update($dbData, $attribute_id);
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
        $attribute_ids = t_Post('ids');

        // Business logic
        $attribute_ids = explode(',', $attribute_ids);
        if (!is_array($attribute_ids)) {
            resDie("Cannot delete attribute data");
        }

        $this->mLoadModel('table_model');
        $this->mLoadModel('attribute_model');
        $this->mLoadModel('image_model');

        try {
            $table_id = $this->table_model->get_table_id('attribute');
            $this->attribute_model->batch_update($attribute_ids, self::STATUS_INACTIVE);

            foreach ($attribute_ids as $attribute_id) {
                $this->image_model->delete_image($attribute_id, $table_id);
            }
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function bulk_update_type()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->form_validation->set_rules('type', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $attribute_ids = t_Post('ids');
        $attribute_type = t_Post('type');

        // Business logic
        $attribute_ids = explode(',', $attribute_ids);
        if (!is_array($attribute_ids)) {
            resDie("Cannot delete referral data");
        }

        $this->mLoadModel('attribute_model');

        try {
            $this->attribute_model->batch_update_type($attribute_ids, $attribute_type);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }
}
