<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class module extends base_controller {

    public function api($module_id="",$controllerName="",$functionName=""){
    	$this->load->model("module_model");
		$this->module_model->getModuleApiController($module_id,$controllerName,$functionName);
	}


}

?>