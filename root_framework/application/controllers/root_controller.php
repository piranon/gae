<?php 

class root_controller extends CI_Controller {
    
	public $controllerName;

	public function __construct(){
        parent::__construct();
        $this->load->add_package_path(root_framework_path()."application/");
        $this->start();

    }

    //<<-- AUTHENTICATION : START -->>
    public function currentGaeStaffId(){
        $this->load->model("root_model");
        return $this->root_model->currentGaeStaffId();
    }

    public function currentOwnerId(){
         $this->load->model("root_model");
        return $this->root_model->currentOwnerId();
    }
    
    public function currentShopId(){
        $this->load->model("root_model");
        return $this->root_model->currentShopId();
    }

    public function currentStaffId(){
        $this->load->model("root_model");
        return $this->root_model->currentStaffId();
    }

    public function currentCustomerId(){
        $this->load->model("root_model");
        return $this->root_model->currentGaeStaffId();
    }

    public function onlyGaeStaff(){
        return $this->currentGaeStaffId();
    }

    public function onlyOwner(){
        //$this->load->model("access_model");
        return $this->currentOwnerId();
    }

    public function onlyShop(){
        return $this->currentShopId();
    }

    public function onlyStaff(){
        //$this->load->model("access_model");
        return $this->currentStaffId();
    }

    public function onlyCustomer(){
        //$this->load->model("access_model");
       return $this->currentCustomerId();
    }

    //<<-- AUTHENTICATION : END -->>

    protected function getLangId(){
        $this->load->model("root_model");
        return $this->root_model->getLangId();
    }

    protected function getCurrentShopId(){
        $this->load->model("shop_model");
        return $this->shop_model->getCurrentShopId();
    }


	protected function baseView($pathName="",$viewData=array()){
		$this->load->view("base/pageHeader",$viewData);
		$this->load->view($pathName);
		$this->load->view("base/pageFooter");
	}

	protected function start(){
		$this->controllerName = $this->router->fetch_class();
	}

    protected function currentClass(){
        return $this->router->fetch_class();
    }

	protected function currentFunction(){
		return $this->router->fetch_method();
	}
    
    protected function methodPlace(){
        return $this->currentClass().":".$this->currentFunction();
    }

    protected function formCheck($msg="",$formErrorsAdd=array()){
        if($msg==""){
            $msg= "form-invalid";
        }
        $formErrors = array();
		if ($this->form_validation->run() == FALSE){
            $formErrors = $this->form_validation->getErrorsArray();
		}
    
        array_merge($formErrors,$formErrorsAdd);
        
        if(sizeof($formErrors)>0){
            resDie($formErrors,$msg);   
        }
    }

    protected function logSave($userType="",$user_id=""){
        $this->load->model("root_log_model");
        $this->root_log_model->logSave($userType,$user_id);
    }

    protected function resOk($dataArray=array()){

        resOk($dataArray,$this->methodName());
    }

    protected function resDie($dataArray=array()){

        resDie($dataArray,$this->methodName());
    }


    protected function db_trans_start(){
        $this->load->model("root_model");
        $this->root_model->trans_start();
    }

    protected function db_trans_complete(){
        $this->load->model("root_model");
        $this->root_model->trans_complete();
    }

    protected function db_trans_rollback(){
        $this->load->model("root_model");
        $this->root_model->trans_rollback();
    }

 
}