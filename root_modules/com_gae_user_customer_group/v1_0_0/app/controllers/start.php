<?
	//start file
class start extends base_module_controller{
	

    public function index(){
        $this->load->model("module_model");
        $this->mLoadView("start/example",array("myData"=>"This is MyData"));
        $module_array = $this->module_model->getAllModuleList();
        return;
    }

    public function test(){
        $this->mLoadLibrary("my_lib1");

        $callString = $this->my_lib1->getCallString();
        $content = $this->my_lib1->getContent();
        
        $viewData["callString"] = $callString;
        $viewData["content"] = $content;

        $this->mLoadView("start/content",$viewData);

        $car_spec_lib = $this->mLoadLibrary("car_spec_lib",true);
    
    }

    public function test_imageupload(){

        $viewData = array();
        $this->mLoadView("start/test_imageupload",$viewData);

    }

    public function single_imageupload(){

        $viewData = array();
        $this->mLoadView("start/single_imageupload",$viewData);

    }

     public function multiple_imageupload(){

        $viewData = array();
        $this->mLoadView("start/multiple_imageupload",$viewData);

    }



}

?>