<?php

class Start extends base_module_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    function testrequest(){
        $print_data["allheaders"] = getallheaders();
        $print_data["REQUEST_METHOD"] = @$_SERVER['REQUEST_METHOD'];
        $print_data["REQUEST"] = $_REQUEST;
        $print_data["GET"] = $_GET;
        $print_data["POST"] = $_POST;
        $print_data["FILES"] = $_FILES;
        $print_data["IP_ADDRESS"] = getenv("REMOTE_ADDR");
        $print_data["timestamp"] = time();
        resOk($print_data);
    }

}
