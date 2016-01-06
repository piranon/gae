<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class package extends base_controller {

     function __construct()
	{
		parent::__construct();

       $this->load->model("root_package_model");

    }

    public function index(){
        $this->lists();
    }

    public function getpackageidforproduct($product_id=228)
    {

        $dataId = $this->root_package_model->getPackageIdForProduct($product_id) ;
        resOk($dataId);

    }

    public function getproductidforpackage($package_id=12)
    {
        $dataId = $this->root_package_model->getProductIdForPackage($package_id);
        resOk($dataId) ;
    } 

    public function addproductforpackage($package_id=12,$product_id=223,$amount=5)
    {

         $Dbdata = array() ;

         $Dbdata['package_id'] = $package_id ;

         $Dbdata['product_id'] = $product_id ;

         $Dbdata['amount'] = $amount ;

        $NewPackageData = $this->root_package_model->addProductForPackage($Dbdata);

        resOk($NewPackageData) ;

    }

    public function subproductforpackage($package_id=12,$product_id=223,$amount=3)
    {

        $NewPackageData = $this->root_package_model->subProductForPackage($package_id,$product_id,$amount) ;

         resOk($NewPackageData) ;

    }

    public function search(){

        $cur_page = 1;
        $per_page = 10;
        $sortby_id = "update_time";

        $this->load->model("root_package_model");

        $package_id = 12 ;

        $where_str = " product_matchto_package.package_id = {$package_id} ";

        $total_row = $this->root_package_model->getListsTotalRow($where_str,$joinStr="") ;
        $dataList = $this->root_package_model->getLists($cur_page,$per_page,$sortby_id,$where_str);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);

        resOk($dataSend) ;

    }

    public function getallproductforpackage()
    {

        $sortby_id = "update_time";

        $this->load->model("root_package_model");

        $package_id = 12 ;

        $where_str = " product_matchto_package.package_id = {$package_id} ";

        $total_row = $this->root_package_model->getListsTotalRow($where_str,$joinStr="") ;
        $cur_page =  1 ;
        $per_page =  $total_row  ;
        $dataList = $this->root_package_model->getLists($cur_page,$per_page,$sortby_id,$where_str);

        $dataSend = dataListSendFormat($total_row, $dataList, $cur_page, $per_page,$sortby_id);


        resOk($dataSend) ;      

    }

    public function gettotalamountforpackage($package_id=12)
    {

        $sortby_id = "update_time";

        $this->load->model("root_package_model");

        $where_str = " product_matchto_package.package_id = {$package_id} ";

        $dataSend = $this->root_package_model->getTotalAmountForPackage($package_id,$where_str,$joinStr="") ;

 
        resOk($dataSend) ;


    }

    function test($package_id=12,$product_id=224){

         $this->load->model("root_package_model");

        $where_str = " product_matchto_package.package_id = {$package_id} ";

        $condition_data = $this->root_package_model->getListsTotalRow($where_str,$joinStr="") ;

         print_r($condition_data)  ;


     // unset($condition_data['fields']["product_title"]) ;

   //   $test2 = $this->product_model->test2($condition_data) ;

    //  print_r($test2)  ;


    }

}


?>

