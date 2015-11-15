<?

class root_access_model extends root_model {

    public $object_table_id = 608;

    public function __construct()
    {
        parent::__construct();
     	$this->startByCollection("access");   
    }

     public function getAccessDataById($table_id,$access_id){
        $sql = " 
            SELECT
                access.access_id AS access_id,
                access.token AS access_token,
                access.holder_object_table_id AS holder_object_table_id,
                access.holder_object_id AS holder_object_id,
                access.create_time AS create_time,
                access.update_time AS update_time,
                access.session_id AS session_id,
                access.ip_address AS ip_address
            FROM 
                access
            WHERE
                access.status > 0
                AND access.holder_object_table_id  =?
                AND access.access_id = ?
            LIMIT 
                0,1
            ";
        $param_ar = array($table_id,$access_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["access_token_id"]==""){
            return false;
        }
        return $result_ar[0];
    }

    public function getAccessDataByToken($table_id,$access_token){
        $sql = " 
            SELECT
                access.access_id AS access_id,
                access.token AS access_token,
                access.holder_object_table_id AS holder_object_table_id,
                access.holder_object_id AS holder_object_id,
                access.create_time AS create_time,
                access.update_time AS update_time,
                access.session_id AS session_id,
                access.ip_address AS ip_address
            FROM 
                access
            WHERE
                access.status > 0
                AND access.holder_object_table_id = ?
                AND access.token = ?
            LIMIT 
                0,1
            ";
        $param_ar = array($table_id,$access_token);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["access_id"]==""){
            return false;
        }
        return $result_ar[0];
    }

    public function createAccessData($table_id,$item_id){

        $dbData = array();
        $dbData["token"] = $this->generateAccessToken($table_id,$item_id);
        $dbData["holder_object_table_id"] = $table_id;
        $dbData["holder_object_id"] = $item_id;
        $dbData["status"] = 1;
        $dbData["create_time"] = time();
        $dbData["update_time"] = time();
        $dbData["session_id"] = $this->session->userdata('session_id');
        $dbData["ip_address"] = $this->input->ip_address();

        $access_id = $this->db->insert("access",$dbData);
        if(!$access_id){
            resDie(array(),"Cannot Insert Access token");
        }
        $dbData["access_id"] = $access_id;
        $dbData["access_token"] = $dbData["token"];

        $this->setAccessTokenToCookie($dbData["access_token"]);

        return $dbData;
    }

    public function stopAccessByToken($table_id,$access_token){

        $accessData = $this->getAccessDataByToken($table_id,$access_token);
        if($accessData){
            $access_id = $accessData["access_id"];
            $dbData = array();
            $dbData["status"] = 0;
            $this->updateDataById($dbData,$access_id);
        }
        return true;
    }

    protected function updateDataById($updateData,$item_id){
        $updateData["update_time"] = time();
        return $this->update($updateData," WHERE access_id = ? ",array($item_id));
    }

    public function generateAccessToken($table_id,$object_id){

        $session_id = $this->session->userdata('session_id');
        $ip_address = $this->input->ip_address();

        $secret_key = md5(generateRandomString(12)."-".$session_id."-".$ip_address);

        $access_token_str1 = md5(md5($table_id."-".$object_id)."-".$secret_key."-".time());
        $access_token_str2 = md5($secret_key."-".md5($table_id."-".$object_id)."-".time());
        $access_token_key = $access_token_str1.$access_token_str2;
        return $access_token_key;
    }

    //PUBLIC ACCESS
    public function getCurrentAccessToken(){

        $current_access_token = t_Request('txt_access_token');
        if($current_access_token==""){
            $headers = apache_request_headers();    
            if(@$headers["Authorization"]!=""){
                
                $Bearer_str  =@$headers["Authorization"];
                $Bearer_str = trimSpaceBarBetweenWord(@$Bearer_str);
                $Bearer_str_array = explode(" ", $Bearer_str);
                if(strtolower(trim($Bearer_str_array[0]))=="bearer"){
                    $Bearer_access_token = trim(@$Bearer_str_array[1]);
                    if($Bearer_access_token!=""){
                        $current_access_token = $Bearer_access_token;
                    } 
                }
            }
        }
        
        if($current_access_token==""){
            $current_access_token = $this->getAccessTokenFromCookie();
        }
        return trim($current_access_token);
    }

    public function setAccessTokenToCookie($access_token){

        $this->load->helper('cookie');
        $cookie = array(
            'name' => 'access_token',
            'value' => $access_token,
            'expire' => time()+86500,
            'path'   => '/',
        );
        return $this->input->set_cookie($cookie);
    }

    public function getAccessTokenFromCookie(){

        $this->load->helper('cookie');
        $this->input->cookie('access_token',true);
        return get_cookie('access_token');
    }


    //CHECk ALLOW USER TYPE
    public function onlyGaeStaff(){
        $access_token = $this->getCurrentAccessToken();
    }

    public function onlyOwner(){
        $access_token = $this->getCurrentAccessToken();
    }

    public function onlyStaff(){
        $access_token = $this->getCurrentAccessToken();
    }

    public function onlyCustomer(){
        $access_token = $this->getCurrentAccessToken();
    }



}
?>