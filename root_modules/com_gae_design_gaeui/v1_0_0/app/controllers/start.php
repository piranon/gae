<?php

class Start extends base_module_controller
{

    public function index()
    {
       $this->gaeui();
    }

    public function allui(){
    	$this->mLoadView("doc/allui-doc");
    }

    public function gaeui(){
    	$this->mLoadView("doc/gaeui-doc");
    }

   

}
