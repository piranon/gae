<?
class root_log_model extends root_model {

	public function __construct()
    {
        parent::__construct();
        $this->startByCollection("log");
    }

	public function logSave($userType="",$user_id=""){
		
		$userType = strtolower(trim($userType));
        if($userType=="")
        {
            $userType = "guess";
        }

        if(!in_array($userType, array('guess','gaestaff','staff','owner','customer')))
        {
            $errors = array(
                "error" =>"userType in correct!"
            );
            resDie($errors,$this->methodPlace());
        }
        
        $is_https = 0;
        if(@$_SERVER["HTTPS"] == "on"){
            $is_https = 1;
        }

        $this->load->library('session');

        $logData["method_type"] = strtoupper(trim($this->input->server('REQUEST_METHOD')));
        $logData["url_call"] = base_url(uri_string());
        $logData["header_data"] = json_encode(getallheaders());
        $logData["request_data"] = json_encode($_REQUEST);
        $logData["get_data"] = json_encode($_GET);
        $logData["post_data"] = json_encode($_POST);
        $logData["file_data"] = json_encode($_FILES);
        

        $logData["shop_id"] = 1;

        $logData["is_https"] = $is_https;
        $logData["user_type"] = $userType;
        $logData["user_id"] = $user_id;
        $logData["controller_name"] = $this->router->fetch_class();
        $logData["function_name"] = $this->router->fetch_method();
        $logData["base_app_id"] = base_app_id();
        $logData["create_time"] = time();
        $logData["session_id"] = $this->session->userdata('session_id');
        $logData["ip_address"] = $this->input->ip_address();

        return $this->insert($logData);

	}

}