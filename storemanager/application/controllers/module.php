<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class module extends base_controller {

	public function index()
	{
		$this->menu();
	}

	public function app($module_id="",$controllerName="",$functionName="")
	{
		$shop_id = $this->onlyShop();		
		$this->load->model("menu_model");
		$menuData = $this->menu_model->getCurrentMenuData($shop_id);

		$this->load->model("module_model");
		$viewContent = $this->module_model->getModuleViewController($module_id,$controllerName,$functionName);
		$subModuleArray = $this->module_model->getSubModuleByModule($module_id);

		$viewData["viewType"] = "normal";
		$viewData["menuData"] = $menuData;
		$viewData["module_id"]= $module_id;
		$viewData["subModuleArray"]= $subModuleArray;
		$viewData["viewContent"] = $viewContent;

		$this->viewStart($viewData);
		$this->load->view('module/connect_js');
		$this->load->view('module/content');
		$this->viewEnd();
		
	}

	public function app_popup($module_id="",$controllerName="",$functionName=""){

		$shop_id = $this->onlyShop();		
		$this->load->model("menu_model");
		$menuData = $this->menu_model->getCurrentMenuData($shop_id);

		$this->load->model("module_model");
		$viewContent = $this->module_model->getModuleViewController($module_id,$controllerName,$functionName);
		$subModuleArray = $this->module_model->getSubModuleByModule($module_id);

		$viewData["viewType"] = "popup";
		$viewData["menuData"] = $menuData;
		$viewData["module_id"]= $module_id;
		$viewData["subModuleArray"]= $subModuleArray;
		$viewData["viewContent"] = $viewContent;

		$this->viewPopupStart($viewData);
		$this->load->view('module/connect_js');
		$this->load->view('module/content');
		$this->viewPopupEnd();
	}
}

?>