<?

class root_owner_model extends root_model {

    public function __construct()
    {
        parent::__construct();
     	$this->startByCollection("owner");   
    }

    public function onlyOwner(){

    	$ownerData = $this->getCurrentOwner();
    	if(!$ownerData){
    		$error = array(
    			"user_type"=>"owner",
    			"error"=>"require_login"
    			);
    		resDie($error,"owner:require_login");
    	}
    	return $ownerData;

    }

    public function getCurrentOwner(){
    	$this->load->library("session");
   		$ownerData = $this->session->userdata('ownerData');
    	if(intval(@$ownerData["owner_id"])==0){
    		return false;
    	}
    	return $ownerData;
    }

    public function setCurrentOwner($ownerData){
    	$this->load->library("session");
    	$this->session->set_userdata('ownerData',$ownerData);
    }

    public function clearCurrentOwner(){
    	$this->load->library("session");
    	$this->session->set_userdata('ownerData','');
    }



}
?>