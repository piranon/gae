<?php

class start extends base_module_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function add()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('name', 'trim|required');
        $this->form_validation->set_rules('customer_ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $group_name = t_Post('name');
        $group_description = t_Post('description');
        $group_customer_ids = t_Post('customer_ids');

        // Business logic
        $dbData = array();
        $dbData['name'] = $group_name;
        $dbData['description'] = $group_description;
        $dbData['status'] = 1;
        $dbData['create_time'] = time();

        $this->mLoadModel('customer_group_model');
        $this->mLoadModel('customer_mathto_customer_group_model');

        try {
            $customer_group_id = $this->customer_group_model->insert($dbData);
            $mathTo = $this->customer_mathto_customer_group_model->createInsertData(
                $customer_group_id,
                $group_customer_ids
            );
            $this->customer_mathto_customer_group_model->insert_batch($mathTo);

        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function listing()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('customer_group_model');
        $this->mLoadModel('customer_mathto_customer_group_model');

        $groups = $this->customer_group_model->get_customer_groups();

        $response = [];
        foreach ($groups as $group) {
            $group['create_time'] = date('Y-m-d H:i:s', $group['create_time']);
            $group['update_time'] = $group['update_time'] > 0 ? date('Y-m-d H:i:s', $group['update_time']) : 0;
            $group['count_customers'] = $this->customer_mathto_customer_group_model->count_customer(
                    $group['customer_group_id']
            );
            $response[] = $group;
        }

        // Response
        resOk($response);
    }


    function customer_list()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('customer_model');
        $customers = $this->customer_model->get_customers();

        // Response
        resOk($customers);
    }

    function bulk_delete()
    {
        echo '<pre>';
        print_r($_POST);
    }
}
