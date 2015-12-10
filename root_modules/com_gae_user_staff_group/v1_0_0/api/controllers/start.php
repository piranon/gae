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
        $this->form_validation->set_rules('name', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $group_name = t_Post('name');
        $group_description = t_Post('description');

        // Business logic
        $dbData = array();
        $dbData['name'] = $group_name;
        $dbData['description'] = $group_description;
        $dbData['status'] = 1;
        $dbData['create_time'] = time();

        $this->mLoadModel('staff_group_model');

        try {
            $this->staff_group_model->insert($dbData);
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
        $this->form_validation->set_rules('id', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $group_name = t_Post('name');
        $group_description = t_Post('description');
        $group_id = t_Post('id');

        // Business logic
        $dbData = array();
        $dbData['name'] = $group_name;
        $dbData['description'] = $group_description;
        $dbData['update_time'] = time();

        $this->mLoadModel('staff_group_model');

        try {
            $this->staff_group_model->update($dbData, $group_id);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk(['time' => time()]);
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

        $this->mLoadModel('staff_group_model');
        $staff = $this->staff_group_model->get_staff_group_by_id($id);

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
        $this->mLoadModel('staff_group_model');
        $this->mLoadModel('staff_mathto_staff_group_model');

        $groups = $this->staff_group_model->get_staff_groups();

        $response = [];
        foreach ($groups as $group) {
            $group['create_time'] = date('Y-m-d H:i:s', $group['create_time']);
            $group['update_time'] = $group['update_time'] > 0 ? date('Y-m-d H:i:s', $group['update_time']) : 0;
            $group['count_staffs'] = $this->staff_mathto_staff_group_model->count_staff(
                $group['staff_group_id']
            );
            $response[] = $group;
        }

        // Response
        resOk($response);
    }

    public function bulk_delete()
    {
        // Form validation
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('ids', 'trim|required');
        $this->formCheck();

        // Receiving parameter
        $staff_group_ids = t_Post('ids');

        // Business logic
        $staff_group_ids = explode(',', $staff_group_ids);
        if (!is_array($staff_group_ids)) {
            resDie("Cannot delete staff data");
        }

        $this->mLoadModel('staff_group_model');

        try {
            $this->staff_group_model->batch_delete($staff_group_ids);
        } catch (Exception $e) {
            resDie($e->getMessage());
        }

        // Response
        resOk();
    }
}
