<?php

class Start extends base_module_controller
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
        $this->form_validation->set_rules('username', 'trim|required');
        $this->form_validation->set_rules('email', 'trim|required');
        $this->form_validation->set_rules('first_name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'trim|required');
        $this->form_validation->set_rules('password', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $customer_username = t_Post('username');
        $customer_first_name = t_Post('first_name');
        $customer_last_name = t_Post('last_name');
        $customer_birthday = t_Post('birthday');
        $customer_gender = t_Post('gender');
        $customer_email = t_Post('email');
        $customer_phone = t_Post('phone');
        $customer_tag = t_Post('tag');
        $customer_password = t_Post('password');

        // Business logic
        $dbData = array();
        $dbData['user_name'] = $customer_username;
        $dbData['first_name'] = $customer_first_name;
        $dbData['last_name'] = $customer_last_name;
        $dbData['birthday'] = $customer_birthday;
        $dbData['gender_type_id'] = $customer_gender;
        $dbData['email'] = $customer_email;
        $dbData['password'] = $customer_password;
        $dbData['phone'] = $customer_phone;
        $dbData['tag'] = $customer_tag;
        $dbData['status'] = Customer_model::STATUS_ACTIVE;
        $dbData['create_time'] = time();

        $this->mLoadModel('customer_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        try {
            $customer_id = $this->customer_model->insert($dbData);
            $table_id = $this->table_model->get_table_id('customer');
            $this->image_model->upload_image_profile($customer_id, $table_id);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function update()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('username', 'trim|required');
        $this->form_validation->set_rules('email', 'trim|required');
        $this->form_validation->set_rules('first_name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'trim|required');
        $this->form_validation->set_rules('password', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $customer_username = t_Post('username');
        $customer_first_name = t_Post('first_name');
        $customer_last_name = t_Post('last_name');
        $customer_birthday = t_Post('birthday');
        $customer_gender = t_Post('gender');
        $customer_email = t_Post('email');
        $customer_phone = t_Post('phone');
        $customer_tag = t_Post('tag');
        $customer_password = t_Post('password');
        $customer_id = t_Post('id');

        // Business logic
        $dbData = array();
        $dbData['user_name'] = $customer_username;
        $dbData['first_name'] = $customer_first_name;
        $dbData['last_name'] = $customer_last_name;
        $dbData['birthday'] = $customer_birthday;
        $dbData['gender_type_id'] = $customer_gender;
        $dbData['email'] = $customer_email;
        $dbData['password'] = $customer_password;
        $dbData['phone'] = $customer_phone;
        $dbData['tag'] = $customer_tag;
        $dbData['update_time'] = time();

        $this->mLoadModel('customer_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');

        try {
            $this->customer_model->update($dbData, $customer_id);
            $table_id = $this->table_model->get_table_id('customer');
            $this->image_model->upload_image_profile($customer_id, $table_id);
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
        $this->mLoadModel('customer_model');
        $customers = $this->customer_model->get_customers();

        // Response
        resOk($customers);
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

        $this->mLoadModel('customer_model');
        $customer = $this->customer_model->get_customer_by_id($id);

        // Response
        resOk($customer);
    }

    public function bulk_delete()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $customer_ids = t_Post('ids');

        // Business logic
        $customer_ids = explode(',', $customer_ids);
        if (!is_array($customer_ids)) {
            resDie("Cannot delete customer data");
        }

        $this->mLoadModel('table_model');
        $this->mLoadModel('customer_model');
        $this->mLoadModel('image_model');

        try {
            $table_id = $this->table_model->get_table_id('customer');
            $this->customer_model->batch_delete($customer_ids);

            foreach ($customer_ids as $customer_id) {
                $this->image_model->delete_image_profile($customer_id, $table_id);
            }
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }
}
