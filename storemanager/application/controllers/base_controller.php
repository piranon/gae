<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class base_controller extends root_controller {

	public function __construct(){
        parent::__construct();
        $package_path = root_APPPATH()."storemanager_api/v1/application/";
        $this->load->add_package_path($package_path);

    }

	protected function baseView($pathName="",$viewData=array()){
		
		$this->viewStart($viewData);
		$this->load->view($pathName);
		$this->viewEnd();
	}

	protected function viewStart($viewData=array()){
		$this->load->view("base/pageHeader",array("viewData"=>$viewData));
	}

	protected function viewEnd(){
		$this->load->view("base/pageFooter");
	}

	protected function viewPopupStart($viewData=array()){
		$this->load->view("base/pageHeader-popup",array("viewData"=>$viewData));
	}

	protected function viewPopupEnd(){
		$this->load->view("base/pageFooter-popup");
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