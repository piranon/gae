<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class item extends base_controller {

     function __construct()
	{
		parent::__construct();

    }

    public function index(){
        $this->lists();
    }

    public function lists(){

        $cur_page = 1;
        $per_page = 10;

        $this->load->model("root_item_model");

        $total_row = $this->root_item_model->getListsTotalRow($WhereStr="",$param_ar=array(),$joinStr="") ;

        $dataList = $this->root_item_model->getLists($cur_page,$per_page);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page);

        resOk($dataList);

    }


    public function search(){

        $search_txt = "title";
        $cur_page = 1;
        $per_page = 10;
        $sortby_id = "product_lastest_create";

        $where_str = " product_detail.title LIKE ? ";
        $param_ar = array("%".$search_txt."%");

        $this->load->model("root_item_model");

       $total_row = $this->root_item_model->getListsTotalRow($where_str,$param_ar);
        $dataList = $this->root_item_model->getLists($cur_page,$per_page,$sortby_id,$where_str,$param_ar);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);

        resOk($dataSend);

    }

    public function getid($product_id = 228){
  
       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->getId($product_id) ;

       resOk($dataLIst);

    }
 
    public function getshortid($product_id = 228){


       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->getShortId($product_id) ;

       resOk($dataLIst);

    }

    public function getdatabyid($product_id = 223){


       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->getDataById($product_id) ;

       resOk($dataLIst);

    }


    public function getshortdatabyid($product_id = 230){


       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->getShortDataById($product_id) ;

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


        $this->load->model("root_item_model");
        $product_id = $this->root_item_model->add($dbData);
        $newProductData = $this->root_item_model->getId($product_id);

        resOk($newProductData);
        //$this->root_product_model->edit($dbData,2);

    }  


     public function edit($product_id=233){

        $dbData = array();
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 126.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something111";


        $this->load->model("root_item_model");
        $this->root_item_model->edit($dbData,$product_id);

        $newProductData = $this->root_item_model->getId($product_id);
    
        resOk($newProductData);
      
    }  

    public function enable($product_id){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->enable($product_id_array) ;

       resOk($dataLIst);

    }

    public function hide($product_id){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->hide($product_id_array) ;

       resOk($dataLIst);

    }

    public function delete($product_id_array){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_item_model");

       $dataLIst = $this->root_item_model->delete($product_id_array) ;

      // print_r($dataLIst) ;

       resOk($dataLIst);

    }


    public function enablestock($product_id = 2){


       $this->load->model("product_model");

        $dataLIst = $this->product_model->enableStock($product_id) ;

       //print_r($dataLIst) ;

       resOk($dataLIst);


    }

    public function disablestock($product_id = 2){

       $this->load->model("product_model");

        $dataLIst = $this->product_model->disableStock($product_id) ;

       resOk($dataLIst);


    }

    public function disablelifetime($product_id = 222){

       $this->load->model("product_model");

        $dataLIst = $this->product_model->disableLifeTime($product_id) ;

       resOk($dataLIst);


    }

    public function enablelifetime($product_id = 222){

        $this->load->model("product_model");

        $dataLIst = $this->product_model->enableLifeTime($product_id) ;

        resOk($dataLIst);

    }

    function test(){

        $this->load->model("root_item_model");

        $dataLIst = $this->root_item_model->getListsTotalRow() ;

    }

}


?>

