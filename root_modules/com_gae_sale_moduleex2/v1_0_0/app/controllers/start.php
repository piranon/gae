<?
	//start file
class start extends base_module_controller{
	

    public function index(){
        $this->load->model("module_model");
        $this->mLoadView("form/shipment",array("something"=>"this is something"));
        $module_array = $this->module_model->getAllModuleList();
        return;
    }

    public function test(){
        $this->mLoadView("form/test");
        return;
    }

}

?>