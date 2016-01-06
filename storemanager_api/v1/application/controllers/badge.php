<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class badge extends base_controller {

     function __construct()
	{
		parent::__construct();

    $this->load->model("root_badge_model");
    $this->load->library('form_validation');

    }

    public function sortby()
    {

       $dataLIst = $this->root_badge_model->getSortby() ;

       if($dataLIst){

           resOk($dataLIst) ;

       }


        resdie($dataLIst) ;  

    }

    public function getdata_by_tableid()
    {

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $table_id = t_Request('txt_table_id') ;

        // Business logic

       $dataLIst = $this->root_badge_model->getAllForTable($table_id) ; 

        // response

        if(!$dataLIst){

            resdie(array(),"can not get data") ;

        }
           
        resOk($dataLIst);    

    }

    public function getdata_by_badgegroup_id()
    {

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_badge_group_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $badge_group_id  = t_Request('txt_badge_group_id') ;

        // Business logic

       $dataLIst = $this->root_badge_model->getAllForGroup($badge_group_id) ; 

        // response

        if(!$dataLIst){

            resdie(array(),"can not get data") ;

        }
           
        resOk($dataLIst);    

    }

    public function getdata_by_badgegrouptype()
    {

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_badge_group_type_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $badge_group_type_id  = t_Request('txt_badge_group_type_id') ;

        // Business logic

       $dataLIst = $this->root_badge_model->getAllForGroupType($badge_group_type_id) ; 

        // response

        if(!$dataLIst){

            resdie(array(),"can not get data") ;

        }
           
        resOk($dataLIst);    

    }

    public function get_data_for_holder(){

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->form_validation->set_rules('txt_product_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $Data = array() ;
       $Data['table_id']  = t_Request('txt_table_id') ;
       $Data['product_id']  = t_Request('txt_product_id') ;

        // Business logic

       $dataLIst = $this->root_badge_model->getAllWithRelationForHolder($Data) ; 

        // response

        if(!$dataLIst){

            resdie(array(),"can not get data") ;

        }
           
        resOk($dataLIst);    

    }

    public function addholder()
    {

       // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_id','required|numeric');
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->form_validation->set_rules('txt_product_id','required');
        $this->formcheck();

        // Receiving parameter
           
        $txt_badge_id = t_Post('txt_badge_id') ;
        $txt_table_id = t_Post('txt_table_id') ;
        $txt_product_id = t_Post('txt_product_id') ;

        // Business logic
           
        $dbData = array();
        $dbData['badge_id'] = $txt_badge_id;
        $dbData['holder_object_table_id'] = $txt_table_id ;
        $dbData['holder_object_id'] = $txt_product_id ;

        $ResDataID = $this->root_badge_model->addMathtoForHolder($dbData);

        $ResData = $this->root_badge_model->getHolder($ResDataID);  //getAllWithRelationForHolder

        if(!$ResData){

            resdie(array(),"can not add badge group");

        }

        // response

        resOk($ResData);

    }

    public function subholder()
    {

       // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_sub_badge_id','required|numeric');
        $this->form_validation->set_rules('txt_sub_table_id','required|numeric');
        $this->form_validation->set_rules('txt_sub_project_id','required');
        $this->formcheck();

        // Receiving parameter
           
        $txt_badge_id = t_Post('txt_sub_badge_id') ;
        $txt_table_id = t_Post('txt_sub_table_id') ;
        $txt_project_id = t_Post('txt_sub_project_id') ;

        // Business logic
           
        $dbData = array();
        $dbData['badge_id'] = $txt_badge_id;
        $dbData['holder_object_table_id'] = $txt_table_id ;
        $dbData['holder_object_id'] = $txt_project_id ;

        $ResData = $this->root_badge_model->subMathtoForHolder($dbData);

        resOk($ResData);

    }

    public function cleargroup(){


        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->form_validation->set_rules('txt_product_id','required|numeric');
        $this->form_validation->set_rules('txt_group_id','required');
        $this->formcheck();

        // Receiving parameter
           
        $txt_table_id = t_Post('txt_table_id') ;
        $txt_product_id = t_Post('txt_product_id') ;
        $txt_group_id = t_Post('txt_group_id') ;

        // Business logic

           
        $dbData = array();
        $SendData['table_id'] = $txt_table_id;
        $SendData['product_id'] = $txt_product_id ;
        $SendData['group_id'] = $txt_group_id ;

        $ResDataID = $this->root_badge_model->clearMathtoByGroupForHolder($SendData);

        //response

        resOk($ResDataID);
    
    } 

    public function clearholder(){

        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->form_validation->set_rules('txt_product_id','required|numeric');
        $this->formcheck();

        // Receiving parameter
           
        $txt_table_id = t_Post('txt_table_id') ;
        $txt_product_id = t_Post('txt_product_id') ;

        // Business logic

           
        $dbData = array();
        $SendData['table_id'] = $txt_table_id;
        $SendData['product_id'] = $txt_product_id ;

        $ResDataID = $this->root_badge_model->clearMathtoForHolder($SendData);

        //response

        resOk($ResDataID);   

    }

    public function saveholder()
    {

        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_table_id','required|numeric');
        $this->form_validation->set_rules('txt_product_id','required|numeric');
        $this->form_validation->set_rules('txt_badge_id_json ','require');
        $this->formcheck();

        // Receiving parameter
           
        $txt_table_id = t_Post('txt_table_id') ;
        $txt_product_id = t_Post('txt_product_id') ;
        $txt_badge_id_json = t_Post('txt_badge_id_json') ;

        // Business logic

           
        $dbData = array();
        $SendData['table_id'] = $txt_table_id;
        $SendData['product_id'] = $txt_product_id ;
        $SendData['badge_id_json'] = json_decode($txt_badge_id_json,true);

        $ResDataID = $this->root_badge_model->saveMathtoForHolder($SendData);

        //response

        resOk($ResDataID);     

    }

    public function addgroup(){

        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_group_type','required|numeric');
        $this->form_validation->set_rules('txt_badge_check_type','required|numeric');
        $this->form_validation->set_rules('txt_namebagegroup','required');
        $this->formcheck();

        // Receiving parameter
           
        $txt_badge_group_type = t_Post('txt_badge_group_type') ;
        $txt_badge_check_type = t_Post('txt_badge_check_type') ;
        $txt_namebagegroup = t_Post('txt_namebagegroup') ;
        $txt_table_id = t_Post('txt_table_id') ;
        // Business logic

           
        $dbData = array();
        $dbData['badge_group_type_id'] = $txt_badge_group_type;
        $dbData['badge_check_type_id'] = $txt_badge_check_type ;
        $dbData['name'] = $txt_namebagegroup ;
        $dbData['table_id'] = $txt_table_id ;

        $ResDataID = $this->root_badge_model->addGroup($dbData);

        $ResData = $this->root_badge_model->getdataBadgeGroupByID($ResDataID);

        if(!$ResData){

            resdie(array(),"can not add badge group");

        }

        //response

        resOk($ResData);
    }

    public function editgroup()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_group_id','required|numeric');
        $this->form_validation->set_rules('txt_badge_group_type','required|numeric');
        $this->form_validation->set_rules('txt_badge_check_type','required|numeric');
        $this->form_validation->set_rules('txt_namebagegroup','required');
        $this->formcheck();

        // Receiving parameter
        
        $badge_group_id = t_Post('txt_badge_group_id') ;
        $txt_badge_group_type = t_Post('txt_badge_group_type') ;
        $txt_badge_check_type = t_Post('txt_badge_check_type') ;
        $txt_namebagegroup = t_Post('txt_namebagegroup') ;
        $txt_table_id = t_Post('txt_table_id') ;
        // Business logic

           
        $dbData = array();
        $dbData['badge_group_type_id'] = $txt_badge_group_type;
        $dbData['badge_check_type_id'] = $txt_badge_check_type ;
        $dbData['name'] = $txt_namebagegroup ;
        $dbData['table_id'] = $txt_table_id ;

        $this->root_badge_model->editGroup($dbData,$badge_group_id);

        $ResData = $this->root_badge_model->getdataBadgeGroupByID($badge_group_id);

        if(!$ResData){

            resdie(array(),"can not update badge_group");

        }

        //response

        resOk($ResData);

    }

    public function deletegroup()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_group_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $badge_group_id_json = t_Post("txt_badge_group_id_json");
        $badge_group_id_json = json_decode($badge_group_id_json,true);

       // Business logic

        $dataLIst = $this->root_badge_model->deleteGroup($badge_group_id_json) ;

       //response

        resOk($dataLIst);

    }

    public function add()
    {

        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_group_id','required|numeric');
        $this->form_validation->set_rules('txt_name','required');
        $this->form_validation->set_rules('txt_title','required');
        $this->form_validation->set_rules('txt_title2','required');
        $this->formcheck();

        // Receiving parameter
           
        $txt_badge_group_id = t_Post('txt_badge_group_id') ;
        $txt_name = t_Post('txt_name') ;
        $txt_title = t_Post('txt_title') ;
        $txt_title2 = t_Post('txt_title2') ;


        // Business logic
           
        $dbData = array();
        $dbData['badge_group_id'] = $txt_badge_group_id;
        $dbData['name'] = $txt_name ;
        $dbData['title'] = $txt_title ;
        $dbData['title2'] = $txt_title2 ;

        $ResDataID = $this->root_badge_model->add($dbData);

        $ResData = $this->root_badge_model->getdataBadgeByID($ResDataID);

        if(!$ResData){

            resdie(array(),"can not add badge group");

        }

        //response

        resOk($ResData);  

    }

    public function edit()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_id','required|numeric');
        $this->form_validation->set_rules('txt_badge_group_id','required|numeric');
        $this->form_validation->set_rules('txt_name','required');
        $this->form_validation->set_rules('txt_title','required');
        $this->form_validation->set_rules('txt_title2','required');
        $this->formcheck();

        // Receiving parameter
        
        $badge_id = t_Post('txt_badge_id') ;   
        $txt_badge_group_id = t_Post('txt_badge_group_id') ;
        $txt_name = t_Post('txt_name') ;
        $txt_title = t_Post('txt_title') ;
        $txt_title2 = t_Post('txt_title2') ;

        // Business logic
           
        $dbData = array();
        $dbData['badge_group_id'] = $txt_badge_group_id;
        $dbData['name'] = $txt_name ;
        $dbData['title'] = $txt_title ;
        $dbData['title2'] = $txt_title2 ;

        $this->root_badge_model->edit($dbData,$badge_id);

        $ResData = $this->root_badge_model->getdataBadgeByID($badge_id);

        if(!$ResData){

            resdie(array(),"can not update badge_group");

        }

        //response

        resOk($ResData);

    }

    public function delete()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('txt_badge_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $badge_id_json = t_Post("txt_badge_id_json");
        $badge_id_json = json_decode($badge_id_json,true);

       // Business logic

        $dataLIst = $this->root_badge_model->delete($badge_id_json) ;// deletebadge

       //response

        resOk($dataLIst);

    }


}


?>

