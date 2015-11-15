<?
	
class car extends base_module_controller{
	

    public function index(){
         
         $this->mLoadView("car/index");
    }

    public function content(){
        $this->mLoadView("car/content");
    }

}

?>