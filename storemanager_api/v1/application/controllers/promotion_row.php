<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promotion_row extends base_controller {

     function __construct()
	{
		parent::__construct();

    $this->load->model("root_promotion_row_model");

    $this->load->library('form_validation');


    }

    public function sortby()
    {

       $dataLIst = $this->root_promotion_row_model->getSortby() ;

       if($dataLIst){

           resOk($dataLIst) ;

       }


        resdie($dataLIst) ;  

    }

    public function getshortid()
    {
  
        // Form validation
        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_row_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

       $promotion_row_id = t_Request('promotion_row_id') ;

        // Business logic

       $ProductRowDataLIst = $this->root_promotion_row_model->getShortDataById($promotion_row_id) ; 

        // response

        if(!$ProductRowDataLIst){

            resdie(array(),"can not get promotion_row data") ;

        }
           
        resOk($ProductRowDataLIst);

    }

    public function getid()
    {

        // authentication none
        
        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_row_id','required|numeric');
        $this->formcheck();
        // Receiving parameter

        $promotion_row_id = t_Request('promotion_row_id') ;

        // Business logic

        $ProductRowDataLIst = $this->root_promotion_row_model->getId($promotion_row_id) ; 

        // response

        if(!$ProductRowDataLIst){

            resdie(array(),"can not get promotion_row data") ;

        }

        resOk($ProductRowDataLIst);


    }

    public function lists(){

        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('cur_page','required|numeric');
        $this->form_validation->set_rules('per_page','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $cur_page = t_Request('cur_page') ;
        $per_page = t_Request('per_page') ;
        $promotion_row_id = t_Request('promotion_row_id') ;

        // Business logic

        $where_str =  "promotion_row.promotion_row_id = {$promotion_row_id}" ;    
         
        $total_row = $this->root_promotion_row_model->getListsTotalRow($where_str);

        $dataList = $this->root_promotion_row_model->getLists($cur_page,$per_page,$where_str);

        $ProductRowDataLIst = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);

        // response

        if(!$ProductRowDataLIst){

            resdie(array(),'can not get promotion_row data') ;

        }

        resOk($ProductRowDataLIst);


    }

    public function getdatabyid()
    {
        
        // authentication none

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_row_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_row_id = t_Request('promotion_row_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_row_model->getDataById($promotion_row_id) ;

        // response

        if(!$dataLIst){

            resdie(array(),'can not get promotion_row data') ;

        }

           resok($dataLIst) ;

    }


    public function getshortdatabyid()
    {

        // authentication none 

        // Form validation

        $this->form_validation->allRequest();
        $this->form_validation->set_rules('promotion_row_id','required|numeric');
        $this->formcheck();

        // Receiving parameter

        $promotion_row_id = t_Request('promotion_row_id') ;

        // Business logic

        $dataLIst = $this->root_promotion_row_model->getShortDataById($promotion_row_id) ;

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
        $this->form_validation->set_rules('promotion_id','required|numeric');
        $this->form_validation->set_rules('action_type','required');
        $this->form_validation->set_rules('product_id','required|numeric');
        $this->form_validation->set_rules('amount','required|numeric');
        $this->form_validation->set_rules('percent_by_amount','required|numeric'); //min_length[10]
        $this->form_validation->set_rules('price','required|numeric') ;
        $this->formcheck();

        // Receiving parameter
           
        $promotion_id = t_Post('promotion_id') ;
        $action_type = t_Post('action_type') ;
        $product_id = t_Post('product_id') ;
        $amount= t_Post('amount') ;
        $percent_by_amount = t_Post('percent_by_amount') ;
        $price = t_Post('price') ;

        // Business logic
           
        $dbData = array();
        $dbData['promotion_id'] = $promotion_id;
        $dbData['action_type'] = $action_type ;
        $dbData['object_id'] = $product_id ;
        $dbData['amount'] = $amount ;
        $dbData['percent_by_amount'] = $percent_by_amount ;
        $dbData['price'] = $price ;

        $promotion_row_id = $this->root_promotion_row_model->add($dbData);

        $newPromotionRowData = $this->root_promotion_row_model->getId($promotion_row_id);

        if(!$newPromotionRowData){

            resdie(array(),"can not add promotion_row");

        }

        //response

        resOk($newPromotionRowData);
       
    }

    public function edit()
    {

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_row_id','required|numeric');
        $this->form_validation->set_rules('promotion_id','required|numeric');
        $this->form_validation->set_rules('action_type','required');
        $this->form_validation->set_rules('product_id','required|numeric');
        $this->form_validation->set_rules('amount','required|numeric');
        $this->form_validation->set_rules('percent_by_amount','required|numeric'); //min_length[10]
        $this->form_validation->set_rules('price','required|numeric') ;
        $this->formcheck();


        // Receiving parameter

        $promotion_row_id = t_Post('promotion_row_id') ;
        $promotion_id = t_Post('promotion_id') ;
        $action_type = t_Post('action_type') ;
        $product_id = t_Post('product_id') ;
        $amount= t_Post('amount') ;
        $percent_by_amount = t_Post('percent_by_amount') ;
        $price = t_Post('price') ;

        // Business logic

        $dbData = array();
        $dbData['promotion_row_id'] = $promotion_row_id;
        $dbData['promotion_id'] = $promotion_id;
        $dbData['action_type'] = $action_type ;
        $dbData['object_id'] = $product_id ;
        $dbData['amount'] = $amount ;
        $dbData['percent_by_amount'] = $percent_by_amount ;
        $dbData['price'] = $price ;

        $this->root_promotion_row_model->edit($dbData,$promotion_row_id);

        $updatePromotionRowData = $this->root_promotion_row_model->getId($promotion_row_id);

        if(!$updatePromotionRowData){

            resdie(array(),"can not update promotion_row");

        }

        //response

        resOk($updatePromotionRowData);

    }


    public function enable(){

        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_row_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_row_id_json = t_Post("promotion_row_id_json");
        $promotion_row_id_json = json_decode($promotion_row_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_row_model->enable($promotion_row_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not enable promotion_row");

        }

            resOk($dataLIst);

    }

    public function hide(){



        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_row_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_row_id_json = t_Post("promotion_row_id_json");
        $promotion_row_id_json = json_decode($promotion_row_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_row_model->hide($promotion_row_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not hide promotion_row");

        }

            resOk($dataLIst);

        

    }

    public function delete($product_id_array=array()){



        // authentication none

        // Form validation

        $this->form_validation->onlyPost();
        $this->form_validation->set_rules('promotion_row_id_json','required');
        $this->formcheck();

        // Receiving parameter

        $promotion_row_id_json = t_Post("promotion_row_id_json");
        $promotion_row_id_json = json_decode($promotion_row_id_json,true);

       // Business logic

        $dataLIst = $this->root_promotion_row_model->delete($promotion_row_id_json) ;

       //response

        if(!$dataLIst){

            resdie(array(),"can not delete promotion_row");

        }

            resOk($dataLIst);


    }

}


?>

