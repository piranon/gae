<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class base_module_controller extends base_controller {


	private $moduleViewData = "";
	public $curModule = null;

	public function __construct(){
        parent::__construct();
    }

    public function startByModule($curModule){
    	$this->curModule = $curModule;
    }

	//overide
	protected function baseView($pathName="",$viewData=array()){
	}

	protected function viewStart($viewData=array()){
	}

	protected function viewEnd(){
	}

	protected function viewPopupStart($viewData=array()){
	}

	protected function viewPopupEnd(){
	}

	//new function
	public function mLoadView($viewPath="",$viewData=array(),$return = FALSE){
		$module_path =  $this->curModule->path;
		$view_file_path = $module_path."app/views/".$viewPath;
	

		$viewData["curModule"]= $this->curModule;
		if($return==true){
			return $this->load->themeable($view_file_path,$viewData,true);
		}else{
			$this->moduleViewData .= $this->load->themeable($view_file_path,$viewData,true);
			return $this->moduleViewData;
		}
	}

	public function getMView(){
		return $this->moduleViewData;
	}

	public function mLoadModel($class_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."api/models/".$class_name;
		

		$this->load->model("module_model");
		$obj = $this->module_model->processModuleModel($class_file_path,$class_name);
		if($not_overide==false){
			$this->{$class_name} = $obj;
		}
		$obj->startByModule($this->curModule);
		return $obj;
	}

	public function mLoadLibrary($class_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."/".$class_name;
	

		$this->load->model("module_model");
		$obj = $this->module_model->processModuleLibrary($class_file_path,$class_name);
		if($not_overide==false){
			$this->{$class_name} = $obj;
		}
		return $obj;
	}

}

?>
