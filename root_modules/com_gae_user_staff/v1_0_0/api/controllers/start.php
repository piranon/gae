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
        $this->form_validation->set_rules('email', 'trim|required');
        $this->form_validation->set_rules('first_name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'trim|required');
        $this->form_validation->set_rules('group_id', 'trim|required');
        $this->form_validation->set_rules('password', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $staff_first_name = t_Post('first_name');
        $staff_last_name = t_Post('last_name');
        $staff_email = t_Post('email');
        $staff_password = t_Post('password');
        $staff_group_id = t_Post('group_id');
        $staff_is_shop_admin = t_Post('is_shop_admin');

        // Business logic
        $dbData = array();
        $dbData['staff_group_id'] = $staff_group_id;
        $dbData['first_name'] = $staff_first_name;
        $dbData['last_name'] = $staff_last_name;
        $dbData['email'] = $staff_email;
        $dbData['password'] = $staff_password;
        $dbData['status'] = 1;
        $dbData['is_shop_admin'] = $staff_is_shop_admin;
        $dbData['create_time'] = time();


        $this->mLoadModel('staff_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');
        $this->mLoadModel('staff_mathto_staff_group_model');

        try {
            $staff_id = $this->staff_model->insert($dbData);
            $table_id = $this->table_model->get_table_id('staff');
            $this->image_model->upload_image_profile($staff_id, $table_id);
            $this->staff_mathto_staff_group_model->create_mathto_staff_group($staff_group_id, $staff_id);
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
        $this->form_validation->set_rules('email', 'trim|required');
        $this->form_validation->set_rules('first_name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'trim|required');
        $this->form_validation->set_rules('group_id', 'trim|required');
        $this->form_validation->set_rules('password', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $staff_id = t_Post('id');
        $staff_first_name = t_Post('first_name');
        $staff_last_name = t_Post('last_name');
        $staff_email = t_Post('email');
        $staff_password = t_Post('password');
        $staff_group_id = t_Post('group_id');
        $staff_is_shop_admin = t_Post('is_shop_admin');

        // Business logic
        $dbData = array();
        $dbData['staff_group_id'] = $staff_group_id;
        $dbData['first_name'] = $staff_first_name;
        $dbData['last_name'] = $staff_last_name;
        $dbData['email'] = $staff_email;
        $dbData['password'] = $staff_password;
        $dbData['is_shop_admin'] = $staff_is_shop_admin;
        $dbData['update_time'] = time();

        $this->mLoadModel('staff_model');
        $this->mLoadModel('table_model');
        $this->mLoadModel('image_model');
        $this->mLoadModel('staff_mathto_staff_group_model');

        try {
            $this->staff_model->update($dbData, $staff_id);
            $table_id = $this->table_model->get_table_id('staff');
            $this->image_model->upload_image_profile($staff_id, $table_id);
            $this->staff_mathto_staff_group_model->create_mathto_staff_group($staff_group_id, $staff_id);
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

        $this->mLoadModel('staff_mathto_staff_group_model');
        $this->mLoadModel('staff_model');
        $staff = $this->staff_model->get_staff_by_id($id);
        $staff['groups'] = $this->staff_mathto_staff_group_model->get_staffs($id);

        // Response
        resOk($staff);
    }

    public function listing()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('staff_mathto_staff_group_model');
        $this->mLoadModel('staff_model');
        $staffs = $this->staff_model->get_staffs();

        $response = [];
        foreach ($staffs as $staff) {
            $staff['groups'] = $this->staff_mathto_staff_group_model->get_staffs($staff['staff_id']);
            $response[] = $staff;
        }

        // Response
        resOk($response);
    }

    function list_group()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('staff_group_model');
        $staff_groups = $this->staff_group_model->get_staff_groups();

        // Response
        resOk($staff_groups);
    }

    public function bulk_delete()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $staff_ids = t_Post('ids');

        // Business logic
        $staff_ids = explode(',', $staff_ids);
        if (!is_array($staff_ids)) {
            resDie("Cannot delete staff data");
        }

        $this->mLoadModel('table_model');
        $this->mLoadModel('staff_model');
        $this->mLoadModel('image_model');

        try {
            $table_id = $this->table_model->get_table_id('staff');
            $this->staff_model->batch_delete($staff_ids);

            foreach ($staff_ids as $staff_id) {
                $this->image_model->delete_image_profile($staff_id, $table_id);
            }
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }

    public function update_status()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('id', 'trim|required');
        $this->form_validation->set_rules('status', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $staff_id = t_Post('id');
        $staff_status = t_Post('status');

        // Business logic
        $status_active = 1;
        $status_blocked = 2;

        $dbData = array();
        $dbData['status'] = $staff_status == $status_active ? $status_blocked : $status_active;
        $dbData['update_time'] = time();

        $this->mLoadModel('staff_model');

        try {
            $this->staff_model->update($dbData, $staff_id);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }
        // Response
        resOk();
    }

    public function get_shop_admin()
    {
        // Form validation
        $this->form_validation->onlyGet();
        $this->form_validation->allRequest();
        $this->formCheck();

        // Business logic
        $this->mLoadModel('staff_model');
        $shop_admin = $this->staff_model->get_shop_admin();

        $response = [];

        if ($shop_admin) {
            $response = [
                'id' => $shop_admin['staff_id']
            ];
        }

        // Response
        resOk($response);
    }
}
