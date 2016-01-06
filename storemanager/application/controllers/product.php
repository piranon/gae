<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends base_controller {

     function __construct()
	{
		parent::__construct();

    }


	function addproduct()
    {

        $dbData = array();
        $dbData['product_type_id'] = "3" ;
        $dbData['shop_id'] = "2" ;
        $dbData['code'] = "004" ;
        $dbData['barcode'] = "0011122" ;
        $dbData['price'] = "90000" ;
        $dbData['compare_price'] = "6000" ;
        $dbData['quantity'] = "3" ; 
        $dbData['description'] = "<font color = 'red'>ddddd</font> <br> test test test test " ;
        
        $this->load->model('product_model');


       try {

              $product_id  =  $this->product_model->add($dbData);


        } catch (Exception $e) {

            resDie($e->getMessage());
        }

        // Response
        resOk();
        //end format insetr 

    }  


    function editproduct(){

        $product_id = 225 ;

        $dbData = array();
        $dbData['product_type_id'] = "3" ;
        $dbData['shop_id'] = "4" ;
        $dbData['code'] = "00223" ;
        $dbData['barcode'] = "0011122" ;
        $dbData['price'] = "1255" ;
        $dbData['compare_price'] = "6000" ;
        $dbData['quantity'] = "3" ;
        $dbData['title'] = "hhhhhh" ;
        $dbData['description'] = "6666666" ;
        $dbData['mobile_title'] = "kkkkkk" ;
        $dbData['mobile_description'] = "vvvvvv" ;
        $dbData['search_title'] = "ggggg" ;
        $dbData['search_description'] = "8888888ssssssss" ;
        $dbData['tag'] = "qqqqq" ;

        $this->load->model('product_model');

       try {
           
            $this->product_model->edit($dbData,$product_id);

        } catch (Exception $e) {

            resDie($e->getMessage());
        }

        // Response
        resOk();
        //end format insetr  
            

    }

     function editproductdetail(){

        $product_id = 233 ;

        $dbData['description'] = "30000" ;
    
        $this->load->model('product_model');

       try {

            $this->product_model->editDetail($dbData,$product_id);

        } catch (Exception $e) {

            resDie($e->getMessage());
        }

        // Response
        resOk();
        //end format insetr  
            

    }

    public function add(){

        $dbData = array();
        $dbData["product_type_id"] = 1;
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 120.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something";
        $dbData["create_time"] = 123;
        $dbData["create_222_time"] = 222;


        $this->load->model("root_product_model");
        $product_id = $this->root_product_model->add($dbData);
        $newProductData = $this->root_product_model->getId($product_id);

        resOk($newProductData);
        //$this->root_product_model->edit($dbData,2);

    }  


     public function edit($product_id=11){

        $dbData = array();
        $dbData["product_type_id"] = 3;
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 120.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something";
        $dbData["create_time"] = 123;
        $dbData["create_222_time"] = 222;


        $this->load->model("root_product_model");
        $this->root_product_model->edit($dbData,$product_id);

        $newProductData = $this->root_product_model->getId($product_id);
    
        resOk($newProductData);
      
    }  


    public function lists(){

        $cur_page = 1;
        $per_page = 10;

        $this->load->model("root_product_model");
        $total_row = $this->root_product_model->getListsTotalRow();
        $dataList = $this->root_product_model->getLists($cur_page,$per_page);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);
        resOk($dataSend);

    }


    public function search(){

        $search_txt = "title";
        $cur_page = 1;
        $per_page = 10;
        $sortby_id = "product_lastest_create";

        $where_str = " product_detail.title LIKE ? ";
        $param_ar = array("%".$search_txt."%");

        $this->load->model("root_product_model");
        $total_row = $this->root_product_model->getListsTotalRow($where_str,$param_ar);
        $dataList = $this->root_product_model->getLists($cur_page,$per_page,$sortby_id,$where_str,$param_ar);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);
        resOk($dataSend);

    }

}


?>

