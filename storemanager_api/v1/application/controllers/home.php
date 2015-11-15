<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends base_controller {

    
    public function main_menu(){
	
		$shop_id = $this->onlyShop();

		$this->load->model("menu_model");
		$menuData = $this->menu_model->getCurrentMenuData($shop_id);
    	resOk($menuData);

	}


}

?>