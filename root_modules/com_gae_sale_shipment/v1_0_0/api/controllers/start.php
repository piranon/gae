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

}

?>