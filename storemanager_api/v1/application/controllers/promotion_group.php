<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion_group extends base_controller {

     function __construct()
	{
		parent::__construct();

    $this->load->model("root_promotion_group_model");

    $this->load->library('form_validation');


    }

    public function sortby()
    {

       $dataLIst = $this->root_promotion_group_model->getSortby() ;

       if($dataLIst){

           resOk($dataLIst) ;

       }


        resdie($dataLIst) ;  

    }

    public function getshortid()
    {
  
        // Form validation
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $promotion_group_id = t_Request('promotion_group_id') ;

        // Business logic

       $ProductGroupDataLIst = $this->root_promotion_group_model->getShortDataById($promotion_group_id) ; 

        // response

        if(!$ProductGroupDataLIst){

            resdie(array(),"can not get promotion_group data") ;

        }
           
        resOk($ProductGroupDataLIst);


    }

    public function getid()
    {

        // authentication none
        
        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->formcheck();
        // Receiving parameter

        $promotion_group_id = t_Request('promotion_group_id') ;

        // Business logic

        $ProductGroupDataLIst = $this->root_promotion_group_model->getId($promotion_group_id) ; 

        // response

        if(!$ProductGroupDataLIst){

            resdie(array(),"can not get promotion_group data") ;

        }

        resOk($ProductGroupDataLIst);

        
    

    }

    public function lists(){

        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('cur_page','required|numeric');
        $this->form_validation->set_rules('per_page','required|numeric');
     //   $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $cur_page = t_Request('cur_page') ;
        $per_page = t_Request('per_page') ;
        $promotion_group_id = t_Request('promotion_group_id') ;

        // Business logic  
         
        $total_row = $this->root_promotion_group_model->getListsTotalRow($promotion_group_id);

        $dataList = $this->root_promotion_group_model->getLists($cur_page,$per_page,$promotion_group_id);

        $ProductGroupDataLIst = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);

        // response

        if(!$ProductGroupDataLIst){

            resdie(array(),'can not get promotion_group data') ;

        }

        resOk($dataList);


    }


    public function getdatabyid()
    {
        
        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_group_id = t_Request('promotion_group_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_group_model->getDataById($promotion_group_id) ;

        // response

        if(!$dataLIst){

            resdie(array(),'can not get promotion_group data') ;

        }

           resok($dataLIst) ;

    }


    public function getshortdatabyid()
    {

        // authentication none 

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_group_id = t_Request('promotion_group_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_group_model->getShortDataById($promotion_group_id) ;

        // response

        if(!$dataLIst){

            resdie(array(),'can not get promotion_group data') ;

        }

           resok($dataLIst) ;

    }

    public function add(){

        // authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('TypePromotionGroup','required|numeric');
        $this->form_validation->set_rules('namePromotionGroup','required');
        $this->form_validation->set_rules('descriptionPromotionGroup','required');
         $this->form_validation->set_rules('ParentidPromotionGroup','required|numeric');
        $this->form_validation->set_rules('lifetimePromotionGroup','required|numeric'); //min_length[10]
        $this->formcheck();

        // Receiving parameter

        $TypePromotionGroup = t_Post('TypePromotionGroup') ;  
        $namePromotionGroup = t_Post('namePromotionGroup') ;
        $descriptionPromotionGroup = t_Post('descriptionPromotionGroup') ;
        $ParentidPromotionGroup = t_Post('ParentidPromotionGroup') ;
        $lifetimePromotionGroup = t_Post('lifetimePromotionGroup') ;

        // Business logic
           
        $dbData = array();
        $dbData['promotion_group_type_id'] = $TypePromotionGroup;
        $dbData['name'] = $namePromotionGroup;
        $dbData['description'] = $descriptionPromotionGroup ;
        $dbData['parent_id'] = $ParentidPromotionGroup ;
        $dbData['lifetime_id'] = $lifetimePromotionGroup ;

        $promotion_group_id = $this->root_promotion_group_model->add($dbData);

        $newPromotionGroupData = $this->root_promotion_group_model->getId($promotion_group_id);

        if(!$newPromotionGroupData){

            resdie(array(),"can not add promotion_group");

        }

        //response

        resOk($newPromotionGroupData);
       
    }

    public function edit()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('idPromotionGroup','required');
        $this->form_validation->set_rules('namePromotionGroup','required');
        $this->form_validation->set_rules('descriptionPromotionGroup','required');
        $this->form_validation->set_rules('lifetimePromotionGrpup','required|numeric'); 
        $this->formcheck();


        // Receiving parameter

        $idPromotionGroup = t_Post('idPromotionGroup') ;
        $namePromotionGroup = t_Post('namePromotionGroup') ;
        $descriptionPromotionGroup = t_Post('descriptionPromotionGroup') ;
        $lifetimePromotionGrpup = t_Post('lifetimePromotionGrpup') ;

        // Business logic

        $dbData = array();
        $dbData['name'] = $namePromotionGroup;
        $dbData['description'] = $descriptionPromotionGroup ;
        $dbData['lifetime_id'] = $lifetimePromotionGrpup ;

        $this->root_promotion_group_model->edit($dbData,$idPromotionGroup);

        $updatePromotionGroupData = $this->root_promotion_group_model->getId($idPromotionGroup);

        if(!$updatePromotionGroupData){

            resdie(array(),"can not update promotion_group");

        }

        //response

        resOk($updatePromotionGroupData);

    }


   public function enable(){

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_group_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_group_id_json = t_Post("promotion_group_id_json");
        $promotion_group_id_json = json_decode($promotion_group_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_group_model->enable($promotion_group_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not enable promotion_group");

        }

            resOk($dataLIst);

    }

    public function hide(){


         // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_group_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_group_id_json = t_Post("promotion_group_id_json");
        $promotion_group_id_json = json_decode($promotion_group_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_group_model->hide($promotion_group_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not enable promotion_group");

        }

            resOk($dataLIst);

        

    }

    public function delete($product_id_array=array()){


        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_group_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_group_id_json = t_Post("promotion_group_id_json");
        $promotion_group_id_json = json_decode($promotion_group_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_group_model->delete($promotion_group_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not enable promotion_group");

        }

            resOk($dataLIst);

    }

}


?>

