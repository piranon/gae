<?php

class Start extends base_module_controller
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

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
            $response[] = $referral;
        }

        // Response
        resOk($response);
    }
}
