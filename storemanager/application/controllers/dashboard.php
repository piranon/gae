<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends base_controller {

	public function index()
	{
		$this->menu();
	}

	public function menu($menu_id=""){

		if($menu_id==""){
			$menu_id = 10;
		}

		$shop_id = $this->onlyShop();		
		$this->load->model("menu_model");
		$menuData = $this->menu_model->getCurrentMenuData($shop_id);

		$viewData["menuData"] = $menuData;
		$viewData["menu_id"]= $menu_id;

		$this->viewStart($viewData);
		$this->load->view('menu/content');
		$this->viewEnd();
	}

	
}

?>