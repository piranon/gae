<?php 

class base_controller extends root_controller {

	public function __construct(){
        parent::__construct();
    }
 
 	//<<-- AUTHENTICATION : START -->>
	public function onlyGaeStaff(){
 		//$this->load->model("access_model");

 	}

 	protected function currentOwnerId(){
 		return 5;
 	}

 	protected function currentStaffId(){
 		return 2;
 	}

 	protected function currentShopId(){
 		return 2;
 	}

 	protected function currentCustomerId(){
 		return 1;
 	}


 	public function onlyOwner(){
 		//$this->load->model("access_model");
        return $this->currentOwnerId();
 	}

 	public function onlyStaff(){
 		//$this->load->model("access_model");
        return $this->currentStaffId();
 	}

    public function onlyShop(){
        return $this->currentShopId();
    }

 	public function onlyCustomer(){
 		//$this->load->model("access_model");
 		$this->currentCustomerId();

 	}

 	//<<-- AUTHENTICATION : END -->>

}

require_once("base_module_controller.php");

?>