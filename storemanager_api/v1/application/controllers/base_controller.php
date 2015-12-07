<?php 

class base_controller extends root_controller {

	public function __construct(){
        parent::__construct();
    }
 
 	public function onlyGaeStaff(){
 		//$this->load->model("access_model");

 	}

 	public function onlyOwner(){
 		//$this->load->model("access_model");
        return 5;

 	}

 	public function onlyStaff(){
 		//$this->load->model("access_model");
        return 2;
 	}

    public function onlyShop(){
        return 2;
    }

 	public function onlyCustomer(){
 		//$this->load->model("access_model");

 	}

}

require_once("base_module_controller.php");

?>