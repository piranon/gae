<?
	//start file
class start extends base_module_controller{
	   
    function index(){

    }

    function testrequest(){
        $print_data["allheaders"] = getallheaders();
        $print_data["REQUEST_METHOD"] = @$_SERVER['REQUEST_METHOD'];
        $print_data["REQUEST"] = $_REQUEST;
        $print_data["GET"] = $_GET;
        $print_data["POST"] = $_POST;
        $print_data["FILES"] = $_FILES;
        $print_data["IP_ADDRESS"] = getenv("REMOTE_ADDR");
        $print_data["timestamp"] = time();
        resOk($print_data);
    }

    function test_model(){
        $mship_model = $this->mLoadModel("mship_model",true);

        $dataResult["msg"] = $mship_model->callSomeThing();
        $dataResult["all_menu"] = $mship_model->getAllMenu();
        resOk($dataResult);

    }

    function test_car(){

        $this->mLoadModel("mcar_model");
        $this->mcar_model->call();

        $dataResult["carData"] = $this->mcar_model->getData();
        $dataResult["relateShipData"] = $this->mcar_model->getRateShipData();
        resOk($dataResult);
    }

    function test_lib(){

        $this->mLoadLibrary("my_lib");
        resOk();
    }


    function single_imageupload(){

        $this->load->model("root_image_model");

        $maxNumber = 1;
        $uploadData = $this->root_image_model->upload("file_upload_single",$maxNumber);
        resOk($uploadData);
    }

    function multiple_imageupload(){

        $this->load->model("root_image_model");

        $maxNumber = 5;
        // set to infinity : $maxNumber = -1;
        $uploadData = $this->root_image_model->upload("file_upload_multiple",$maxNumber); 
        resOk($uploadData);
    }


    function imageupload_for_category(){

        $this->load->model("root_image_model");

        $maxNumber = 1;
        $object_table_id = 356; //table id : referral
        $object_id = 100; // referral_id : category type
        $type_id = 1;

        //upload and match to table that we want
        $uploadData = $this->root_image_model->uploadImageMatchToObject("file_upload_single",$object_table_id,$object_id,$type_id,$maxNumber);

        //to get image for that's object
        $referralImageArray =  $this->root_image_model->getImageByHolder($object_table_id,$object_id,$type_id);
            
        $dataSend = array();
        $dataSend["uploadData"] = $uploadData; 
        $dataSend["referralImageArray "] = $referralImageArray; 
        resOk($dataSend);

    }




}

?>