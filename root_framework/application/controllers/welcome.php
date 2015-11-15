<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view("base/pageHeader");
		$this->load->view('home/welcome');
		$this->load->view("base/pageFooter");
	}
    
    public function sayhello()
	{
		$this->load->model("some_model");
		$this->some_model->call();
	}

}

