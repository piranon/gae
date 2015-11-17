<?php

class Start extends base_module_controller
{
    public function add()
    {
        // Form validation
        $this->load->library('form_validation');
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('username', 'trim|required');
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
        $dbData['status'] = 1;
        $dbData['create_time'] = time();

        $this->mLoadModel('customer_model');
        $customer_id = $this->customer_model->insert($dbData);

        if (!$customer_id) {
            resDie("Cannot insert customer data");
        }
        $this->processImageProfile($customer_id);
        $new_customer_data = $this->customer_model->get_customer_by_id($customer_id);

        // Response
        resOk($new_customer_data);
    }

    private function processImageProfile($customer_id)
    {
        $field_name = 'profile_pic';
        if (empty($_FILES[$field_name])) {
            return true;
        }

        $this->mLoadModel('table_model');
        $table_id = $this->table_model->get_table_id('customer');
        if (null === $table_id) {
            resDie("Cannot get table id");
        }

        $max_number = 1;
        $object_table_id = $table_id;
        $object_id = $customer_id;
        $type_id = 1;

        $this->load->model("root_image_model");
        $this->root_image_model->uploadImageMatchToObject(
            $field_name,
            $object_table_id,
            $object_id,
            $type_id,
            $max_number
        );
    }
}
