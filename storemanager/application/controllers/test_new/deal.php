<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class deal extends base_controller {

     function __construct()
	{
		parent::__construct();

      $this->load->model("root_deal_model");

    }

    public function index(){
        $this->lists();
    }

    public function lists(){

        // $cur_page = 1;
        // $per_page = 10;

        // $total_row = $this->root_deal_model->getListsTotalRow() ;

        // $dataList = $this->root_deal_model->getLists($cur_page,$per_page);

        // $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);

        // resOk($dataList);


        $cur_page = 1 ;
        $per_page = 10 ;

        $total_row = $this->root_deal_model->getListsTotalRow();
        $dataList = $this->root_deal_model->getLists($cur_page,$per_page);

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

        $this->load->model("product_model");

       $total_row = $this->product_model->getListsTotalRow($where_str,$param_ar);
        $dataList = $this->product_model->getLists($cur_page,$per_page,$sortby_id,$where_str,$param_ar);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);

        resOk($dataSend);

    }

    public function getid($product_id = 223){
  
       $dataLIst = $this->root_deal_model->getId($product_id) ;

       resOk($dataLIst);

    }
 
    public function getshortid($product_id = 223){


       $this->load->model("product_model");

       $dataLIst = $this->root_deal_model->getShortId($product_id) ;

       resOk($dataLIst);

    }

    public function getdatabyid($product_id = 223){

       $this->load->model("root_deal_model");

       $dataLIst = $this->root_deal_model->getDataById($product_id) ;

       resOk($dataLIst);

    }


    public function getshortdatabyid($product_id = 223){


       $this->load->model("root_deal_model");

       $dataLIst = $this->root_deal_model->getShortDataById($product_id) ;

       resOk($dataLIst);

    }

     public function add(){

        $dbData = array();
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 120.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something";


        $this->load->model("root_deal_model");
        $product_id = $this->root_deal_model->add($dbData);
        $newProductData = $this->root_deal_model->getId($product_id);

        resOk($newProductData);
        //$this->root_product_model->edit($dbData,2);

    }  


     public function edit($product_id=223){

        $dbData = array();
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 90.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something111";


        $this->load->model("root_deal_model");
        $this->root_deal_model->edit($dbData,$product_id);

        $newProductData = $this->root_deal_model->getId($product_id);
    
        resOk($newProductData) ;
      
    }  

   
    function test(){

        $this->load->model("root_deal_model");

        $product_id = 230 ;

         $dataLIst = $this->root_deal_model->enableLifeTime() ;

        print_r($dataLIst) ;

    }

}


?>

