<?

class MY_Form_validation extends CI_Form_validation
{
    private $allowForMethod = "";
    
    /*
    function MY_Form_validation()
    {
        parent::CI_Form_validation();
    }
    */
    
    public function __construct()
    {
        parent::__construct();

        $_GET["fixbug_for_ci_form_validation_time_by_GET"] = time();
        $_REQUEST["fixbug_for_ci_form_validation_time_by_REQUEST"] = time();
        $_POST["fixbug_for_ci_form_validation_time_by_POST"] = time();

        $this->set_message('required', 'required');
        $this->set_message('numeric', 'numeric'); 
        $this->set_message('valid_email', 'valid_email');
        $this->set_message('is_unique', 'is_unique');
        $this->set_message('min_length', 'min_length');
        $this->set_message('max_length', 'max_length');
        $this->set_message('matches', 'matches'); 
        $this->set_message('alpha', 'alpha');
        $this->set_message('alpha_numeric', 'alpha_numeric');
        $this->set_message('alpha_dash', 'alpha_dash');
        $this->set_message('isexists_username', 'username_already_exits');
        $this->set_message('isexists_email', 'email_already_exits');
        $this->set_message('isnot_exists_email', 'email_not_found');
        $this->set_message('devicetype_check', 'incorrect');
    }
    
    public function set_rules($input_name,$input_name_display,$rule=NULL){
        
        if($rule==NULL){
            $rule = $input_name_display;
            parent::set_rules($input_name,$input_name,$rule);
        }else{
            parent::set_rules($input_name,$input_name_display,$rule);
        }
        
    }
    
    public function getErrorsArray()
    {
        if($this->allowForMethod==""){
            $this->onlyPOST();
            $this->allowForMethod = "";
        }
        return $this->_error_array;
    }

    public function allRequest(){
        $this->allowForMethod = "ALL";
        foreach($_GET as $key => $value){
            $_POST[$key] = $value;
        }
    }

    public function onlyPost(){
        $this->allowForMethod = "POST";
        if (strtoupper(@$_SERVER['REQUEST_METHOD'])!= 'POST') 
        {
            resDie(array(),"Avaliable for only POST Method !");   
        }
    }

    public function onlyGet(){
        $this->allowForMethod = "GET";
        if (strtoupper(@$_SERVER['REQUEST_METHOD'])!= 'GET') 
        {
            resDie(array(),"Avaliable for only GET Method !");   
        }
    }

    public function onlyDelete(){
        $this->allowForMethod = "DELETE";
        if (strtoupper(@$_SERVER['REQUEST_METHOD'])!= 'DELETE') 
        {
            resDie(array(),"Avaliable for only DELETE Method !");   
        }
    }
    //overwrite function
    public function is_unique($str, $field)
    {
        list($table, $field)=explode('.', $field);
        $this->CI->load->database('default');

        $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));

        return $query->num_rows() === 0;
    }

    //Added validate function below
    public function requireFile($file_inputname){
        if(@empty($_FILES[$file_inputname]["name"])){
            $this->_error_array[$file_inputname] = 'required';
        }
    }

    public function makeFormError($input_name,$error_name){
        if(@$this->_error_array[$input_name]==""){
            $this->_error_array[$input_name] = $error_name;
        }
    }

}

?>