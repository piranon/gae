<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test_dec2 extends base_controller {

	public function index()
	{
		echo "TEST DEC2";
	}

	public function stock(){

		$product_id = 222;
		$this->load->model("root_stock_model");
		$enable_result = $this->root_stock_model->enableForProduct($product_id);

		$this->root_stock_model->addStockForProduct($product_id,10);
		$total_number = $this->root_stock_model->getTotalStockNumberForProduct($product_id);

		$dataSend = array();
		$dataSend["enable_result"] = $enable_result;
		$dataSend["total_number"] = $total_number;
		resOk($dataSend);
	}

	public function time(){

		$product_id = 222;
		$this->load->model("root_product_time_model");
		$enable_result = $this->root_product_time_model->enableForProduct($product_id);
		//$enable_result = $this->root_product_time_model->disableForProduct($product_id);

		$timeData = $this->root_product_time_model->setTimeForProduct($product_id,time(),time()+3600);
		$timeData = $this->root_product_time_model->getTimeDictForProduct($product_id);

		$dataSend = array();
		$dataSend["enable_result"] = $enable_result;
		$dataSend["timeData"] = $timeData;
		resOk($dataSend);

	}
}

?>