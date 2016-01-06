<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product_model extends base_controller {

	//// Product EXample start ///////////
	public function add($data){

		$product_id = $this->insertToTable("product",$data);
		if($product_id){
			$product_detail_id = $this->registerDetailByProduct($product_id);
		}
		return $product_id;
	}

	public function registerDetailByProduct($product_id){

		$this->getExistsDetailIdByProduct($product_id);
	}

	public function getExistsDetailIdByProduct($product_id){

		$product_detail_id= $this->checkExistsDetailIdByProduct($product_id);
		if(!$product_detail_id){
			 $product_detail_id = $this->insertToTable("product",$data);
		}	
		return $product_detail_id;
	}
	public function checkExistsDetailIdByProduct($product_id){

		// find exits product SELECT $product_id
		return $product_detail_id;
	}

	public function enableStock($product_id){

		$this->load->model("root_stock_model");
		return $this->root_stock_model->enableForProduct($product_id);

	}

}

?>