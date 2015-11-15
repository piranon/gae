<?
	//start file
class start extends base_module_controller{
	

    public function index(){
        $this->mLoadView("home");
    }

    public function test(){

        $viewData["example_data"]= "hello123";
        $this->mLoadView("form/test",$viewData);
    }

}

?>