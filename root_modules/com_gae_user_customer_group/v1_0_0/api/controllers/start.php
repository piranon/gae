<?php

class start extends base_module_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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
}
