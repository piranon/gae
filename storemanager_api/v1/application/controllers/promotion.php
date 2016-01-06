<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion extends base_controller {

     function __construct()
	{
		parent::__construct();

    $this->load->model("root_promotion_model");
    $this->load->library('form_validation');

    }

    public function sortby()
    {

       $dataLIst = $this->root_promotion_model->getSortby() ;

       if($dataLIst){

           resOk($dataLIst) ;

       }


        resdie($dataLIst) ;  

    }


    public function getshortid()
    {

          // Form validation
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_promotion_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $promotion_id = t_Request('txt_promotion_id') ;

        // Business logic

       $PromotionDataLIst = $this->root_promotion_model->getShortDataById($promotion_id) ; 

        // response

        if(!$PromotionDataLIst){

            resdie(array(),"can not get promotion data") ;

        }
           
        resOk($PromotionDataLIst);       

    }

    public function getid()
    {

        // authentication none
        
        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_promotion_id','required|numeric');
        $this->formcheck();
        // Receiving parameter

        $promotion_id = t_Request('txt_promotion_id') ;

        // Business logic

        $PromotionDataLIst = $this->root_promotion_model->getId($promotion_id) ; 

        // response

        if(!$PromotionDataLIst){

            resdie(array(),"can not get promotion data") ;

        }

        resOk($PromotionDataLIst);


    }


    public function lists(){

        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('cur_page','required|numeric');
        $this->form_validation->set_rules('per_page','required|numeric');
        $this->form_validation->set_rules('txt_promotion_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $cur_page = t_Request('cur_page') ;
        $per_page = t_Request('per_page') ;
        $promotion_id = t_Request('txt_promotion_id') ;

        // Business logic

        $where_str =  "promotion.promotion_id = {$promotion_id}" ;    
         
        $total_row = $this->root_promotion_model->getListsTotalRow($where_str);

        $dataList = $this->root_promotion_model->getLists($cur_page,$per_page,$where_str,$extend_table=true);

        $PromotionDataLIst = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);

        // response

        if(!$PromotionDataLIst){

            resdie(array(),'can not get promotion data') ;

        }

        resOk($dataList);


    }


    public function getdatabyid()
    {
        
        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_promotion_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_id = t_Request('txt_promotion_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_model->getDataById($promotion_id) ;

        // response

        if(!$dataLIst){

            resdie(array(),'can not get promotion data') ;

        }

           resok($dataLIst) ;

    }

    public function getshortdatabyid()
    {

        // authentication none 

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('txt_promotion_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_id = t_Request('txt_promotion_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_model->getShortDataById($promotion_id) ;

        // response

        if(!$dataLIst){

            resdie(array(),'can not get promotion_row data') ;

        }

           resok($dataLIst) ;

    }

    public function add(){


// authentication none
         
        // Form validation
        
        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->form_validation->set_rules('namePromotion','required');
        $this->form_validation->set_rules('titlePromotion','required');
        $this->form_validation->set_rules('descriptionPromotion','required');
        $this->form_validation->set_rules('tagsPromotion','required') ;
        $this->formcheck();

        // Receiving parameter
           
        $promotion_group_id = t_Post('promotion_group_id') ;
        $namePromotion = t_Post('namePromotion') ;
        $titlePromotion = t_Post('titlePromotion') ;
        $descriptionPromotion= t_Post('descriptionPromotion') ;
        $tagsPromotion = t_Post('tagsPromotion') ;

        // Business logic
           
        $dbData = array();
        $dbData['promotion_group_id'] = $promotion_group_id;
        $dbData['name'] = $namePromotion ;
        $dbData['short_title'] = $titlePromotion ;
        $dbData['description'] = $descriptionPromotion ;
        $dbData['tags'] = $tagsPromotion ;

        $promotion_id = $this->root_promotion_model->add($dbData);

        $newPromotionData = $this->root_promotion_model->getId($promotion_id);

        if(!$newPromotionData){

            resdie(array(),"can not add promotion");

        }

        //response

        resOk($newPromotionData);
    }

    public function edit()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_id','required|numeric');
        $this->form_validation->set_rules('promotion_group_id','required|numeric');
        $this->form_validation->set_rules('namePromotion','required');
        $this->form_validation->set_rules('titlePromotion','required');
        $this->form_validation->set_rules('descriptionPromotion','required');
        $this->form_validation->set_rules('tagsPromotion','required') ;
        $this->formcheck();

        // Receiving parameter
           
        $promotion_id = t_Post('promotion_id') ;
        $promotion_group_id = t_Post('promotion_group_id') ;
        $namePromotion = t_Post('namePromotion') ;
        $titlePromotion = t_Post('titlePromotion') ;
        $descriptionPromotion= t_Post('descriptionPromotion') ;
        $tagsPromotion = t_Post('tagsPromotion') ;

        // Business logic
           
        $dbData = array();
        $dbData['promotion_group_id'] = $promotion_group_id ;
        $dbData['name'] = $namePromotion ;
        $dbData['short_title'] = $titlePromotion ;
        $dbData['description'] = $descriptionPromotion ;
        $dbData['tags'] = $tagsPromotion ;

        $this->root_promotion_model->edit($dbData,$promotion_id);

        $updatePromotionRowData = $this->root_promotion_model->getId($promotion_id);

        if(!$updatePromotionRowData){

            resdie(array(),"can not update promotion");

        }

        //response

        resOk($updatePromotionRowData);

    }

    public function enable(){

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_id_json = t_Post("promotion_id_json");
        $promotion_id_json = json_decode($promotion_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_model->enable($promotion_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not enable promotion");

        }

            resOk($dataLIst);

    }

    public function hide(){



        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_id_json = t_Post("promotion_id_json");
        $promotion_id_json = json_decode($promotion_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_model->hide($promotion_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not hide promotion");

        }

            resOk($dataLIst);

        

    }

    public function delete($product_id_array=array()){



        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_id_json = t_Post("promotion_id_json");
        $promotion_id_json = json_decode($promotion_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_model->delete($promotion_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not delete promotion");

        }

            resOk($dataLIst);


    }

}


?>

