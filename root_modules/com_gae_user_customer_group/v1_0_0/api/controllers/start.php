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
        resOk(['time' => time()]);
    }

    public function update()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('name', 'trim|required');
        $this->form_validation->set_rules('customer_ids', 'trim|required');
        $this->form_validation->set_rules('id', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $group_name = t_Post('name');
        $group_description = t_Post('description');
        $group_customer_ids = t_Post('customer_ids');
        $group_id = t_Post('id');

        // Business logic
        $dbData = array();
        $dbData['name'] = $group_name;
        $dbData['description'] = $group_description;
        $dbData['update_time'] = time();

        $this->mLoadModel('customer_group_model');
        $this->mLoadModel('customer_mathto_customer_group_model');

        try {
            $mathTo = $this->customer_mathto_customer_group_model->createInsertData(
                $group_id,
                $group_customer_ids
            );
            $this->customer_group_model->update($dbData, $group_id);
            $this->customer_mathto_customer_group_model->delete($group_id);
            $this->customer_mathto_customer_group_model->insert_batch($mathTo);

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
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        $table_id = $this->table_model->get_table_id('customer');
        $customers = $this->customer_model->get_customers();

        $response = [];
        foreach ($customers as $customer) {
            $customer = array_merge($customer, $this->image_model->get_image($table_id, $customer['customer_id']));
            $response[] = $customer;
        }

        // Response
        resOk($response);
    }

    function bulk_delete()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $customer_group_ids = t_Post('ids');

        // Business logic
        $customer_group_ids = explode(',', $customer_group_ids);
        if (!is_array($customer_group_ids)) {
            resDie("Cannot delete customer data");
        }

        $this->mLoadModel('customer_group_model');

        try {
            $this->customer_group_model->batch_delete($customer_group_ids);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function detail()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Receiving parameter
        $id = (int)t_Request('id');

        // Business logic
        if (!is_int($id) || $id <= 0) {
            resDie('id should be integer');
        }

        $this->mLoadModel('customer_group_model');
        $this->mLoadModel('customer_mathto_customer_group_model');
        $this->mLoadModel('customer_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        $customer_group = $this->customer_group_model->get_group_by_id($id);
        if ($customer_group) {
            $table_id = $this->table_model->get_table_id('customer');
            $customers = $this->customer_mathto_customer_group_model->get_customers($id);
            $customer_group['customers'] = [];
            foreach ($customers as $customer) {
                $customer = array_merge($customer, $this->image_model->get_image($table_id, $customer['customer_id']));
                $customer_group['customers'][] = $customer;
            }
        }

        // Response
        resOk($customer_group);
    }

    function bulk_delete_customer()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('id', 'trim|required');
        $this->form_validation->set_rules('customerIds', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $customer_group_id = t_Post('id');
        $customer_customer_ids = t_Post('customerIds');

        // Business logic
        $customer_customer_ids = explode(',', $customer_customer_ids);
        if (!is_array($customer_customer_ids)) {
            resDie("Cannot delete customer data");
        }

        $this->mLoadModel('customer_mathto_customer_group_model');

        try {
            $this->customer_mathto_customer_group_model->delete_customer($customer_group_id, $customer_customer_ids);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }
}
