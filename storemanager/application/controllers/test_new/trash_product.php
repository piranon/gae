<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trash_product extends base_controller {

     function __construct()
	{
		parent::__construct();
        $this->load->model("root_trash_product_model");
    }

    public function index(){
        $this->lists();
    }

    public function lists(){

        $cur_page = 1;
        $per_page = 10;

        $total_row = $this->root_trash_product_model->getListsTotalRow($WhereStr="",$param_ar=array(),$joinStr="") ;

        $dataList = $this->root_trash_product_model->getLists($cur_page,$per_page);

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

       $total_row = $this->root_trash_product_model->getListsTotalRow($where_str,$param_ar);
        $dataList = $this->root_trash_product_model->getLists($cur_page,$per_page,$sortby_id,$where_str,$param_ar);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);

        resOk($dataSend);

    }

    public function getid($product_id = 228){
  
       $dataLIst = $this->root_trash_product_model->getId($product_id) ;

       resOk($dataLIst);

    }
 
    public function getshortid($product_id = 228){


       $dataLIst = $this->root_trash_product_model->getShortId($product_id) ;

       resOk($dataLIst);

    }

    public function getdatabyid($product_id = 223){


       $dataLIst = $this->root_trash_product_model->getDataById($product_id) ;

       resOk($dataLIst);

    }


    public function getshortdatabyid($product_id = 230){


       $dataLIst = $this->root_trash_product_model->getShortDataById($product_id) ;

       resOk($dataLIst);

    }

    public function pushback($product_id_array=array())
    {

         $product_id_array = array(
                             array('product_id' => 500),
                             array('product_id' => 600)) ;


        $dataLIst = $this->root_trash_product_model->pushBack($product_id_array) ;

        resOk($dataLIst);

    }

    public function remove($product_id_array=array())
    {

        $product_id_array = array(
                            array('product_id' => 230),
                            array('product_id' => 225),
                            array('product_id' => 223),
                            array('product_id' => 227),
                            array('product_id' => 228)
                            ) ;

        $dataLIst = $this->root_trash_product_model->remove($product_id_array) ;

        resOk($dataLIst);

    }

    public function removeproductbefore($timestamp = "")
    {

        $timestamp = 1550456065 ;

        $dataLIst = $this->root_trash_product_model->removeProductBefore($timestamp) ;

        resOk($dataLIst);

    } 
     
    function test(){

        $dataLIst = $this->root_trash_product_model->getListsTotalRow() ;

    }

}


?>

