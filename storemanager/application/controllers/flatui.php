<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class flatui extends base_controller {

	public function index()
	{
		$this->baseView("FlatDoc/doc");
	}

	protected function baseView($pathName="",$viewData=array()){
		$this->viewStart($viewData);
		$this->load->view($pathName);
		$this->viewEnd();
	}

	protected function viewStart($viewData=array()){
		$this->load->view("FlatUIBase/pageHeader",array("viewData"=>$viewData));
	}

	protected function viewEnd(){
		$this->load->view("FlatUIBase/pageFooter");
	}
}

?>