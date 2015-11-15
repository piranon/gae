<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class connect extends base_controller {
   	public function __construct(){
        parent::__construct();
    }
    
    public function testrequest(){
      
        $print_data["allheaders"] = getallheaders();
        $print_data["REQUEST_METHOD"] = @$_SERVER['REQUEST_METHOD'];
        $print_data["REQUEST"] = $_REQUEST;
        $print_data["GET"] = $_GET;
        $print_data["POST"] = $_POST;
        $print_data["FILES"] = $_FILES;
        $print_data["IP_ADDRESS"] = getenv("REMOTE_ADDR");
        $print_data["timestamp"] = time();
        /*
        $print_data["base_shop_id"] = $this->base_shop_id();
        $print_data["base_owner_id"] = $this->base_owner_id();
        $print_data["base_project_os"] = $this->base_project_os();
        $print_data["base_project_udid"] = $this->base_project_udid();
        */
        resOk($print_data);
    }

    public function test1(){

        $framework_path = root_framework_path()."application/";
        //echo "framework_path : ".$framework_path;

        //$this->load->add_package_path($framework_path);
        $this->load->model("some_model");
        $this->some_model->call();
        
        $this->load->model("root_shop_model");
        $this->root_shop_model->call();
        //$_GET["txt_username"]= "sdfsd";

        $this->load->library('form_validation');
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_username','trim|required|numeric');
        $this->form_validation->set_rules('txt_password', 'required');
        $this->formCheck();
        
        resOk();
        
    }   

    public function test2(){

        $this->load->model("root_shop_model");
        $this->root_shop_model->call();
    
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txt_username','trim|required');
        $this->form_validation->set_rules('txt_password', 'required');
        $this->formCheck();
        
        resOk();
    } 

     public function test3(){

        $exampleJson =  array(
            "txt_email"=>"g2store@gmail.com",
            "txt_password"=>"pwd123456",
            "txt_storeName"=>"g2 Store",
            "txt_fristName"=>"someone",
            "txt_lastName"=>"sometime",
            "txt_country"=>"1",
            "txt_mobilePhone"=>"0812345678",
            "txt_accepTerm"=>"1",
            "txt_serway"=>array(
                array(
                    "serway_id"=>"10",
                    "sub_data"=>array(array("serway_id"=>"1001"))
                ),
                array(
                    "serway_id"=>"20",
                    "sub_data"=>array(array("serway_id"=>"1000"),array("serway_id"=>"1002"))
                ),
                array(
                    "serway_id"=>"30",
                    "sub_data"=>array(array("serway_id"=>"1003"))
                ) 
            ),
        );

        $dataSend = array("registerData"=>$exampleJson);
        resOk($dataSend);
    }

    public function single_upload(){
        $this->load->library("form_validation");
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules("txt_name","required");
        $this->form_validation->requireFile("txt_file");
        $this->formCheck();

        $this->load->model("image_model");
        $result = $this->image_model->upload('txt_file');
        if($result["rs"]==1){
            resOk($result["data"]);
        }else{
            resDie($result["data"]);
        }
        
    }

    public function upload(){

        $this->load->library("form_validation");
        $this->form_validation->onlyPost();
        $this->form_validation->requireFile('txt_file');
        $this->formCheck();

        $dataSend["FILES"] = $_FILES;
        $this->load->model("root_image_model");
        $uploadData = $this->root_image_model->upload('txt_file');
        resOk($uploadData);
    }

    public function upload_image(){

        $this->load->library("form_validation");
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules("txt_name","required|trim");
        $this->form_validation->requireFile('txt_file');
        $this->formCheck();

        $txt_name = t_Request("txt_name"); 

        //$dataSend["FILES"] = $_FILES;
        $this->load->model("root_image_model");
        $uploadData = $this->root_image_model->uploadWithData('txt_file',array("title"=>$txt_name));
        /*
        foreach ($uploadData["successFiles"] as $key => $value) {
            if(@$value["db_file_id"]!=""){
                $this->root_image_model->updateDataById($value["db_file_id"],array("title"=>$txt_name));
            }
        }
        */
        $this->logSave();
        resOk($uploadData);

    }

}

?>