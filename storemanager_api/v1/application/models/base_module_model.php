<?

class base_module_model extends base_model {

	public $curModule = null;

	public function startByModule($curModule){
    	$this->curModule = $curModule;
    }

    public function mLoadModel($model_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."api/models/".$model_name;
		
		$this->load->model("module_model");
		$obj = $this->module_model->processModuleModel($class_file_path,$model_name);
		if($not_overide==false){
			$this->{$model_name} = $obj;
		}
		$obj->startByModule($this->curModule);
		return $obj;
	}

	public function mLoadLibrary($class_name,$not_overide=false){
		$module_path =  $this->curModule->path;
		$class_file_path = $module_path."libraries/".$class_name;
	

		$this->load->model("module_model");
		$obj = $this->module_model->processModuleLibrary($class_file_path,$class_name);
		if($not_overide==false){
			$this->{$class_name} = $obj;
		}
		return $obj;
	}
}

?>