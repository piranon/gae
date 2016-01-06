<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends base_controller {

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

      //  print_r($total_row) ;

    }

    public function getid($product_id = 228){
  
       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->getId($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);

    }
 
    public function getshortid($product_id = 228){


       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->getShortId($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);

    }

    public function getdatabyid($product_id = 223){


       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->getDataById($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);

    }


    public function getshortdatabyid($product_id = 228){


       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->getShortDataById($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);

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

        $this->load->model("root_product_model");
        $product_id = $this->root_product_model->add($dbData);
        $newProductData = $this->root_product_model->getId($product_id);

        resOk($newProductData);
        //$this->root_product_model->edit($dbData,2);

    }  


     public function edit($product_id=234){

        $dbData = array();
        $dbData["product_type_id"] = 3;
        $dbData["code"] = md5(time()."-".time());
        $dbData["price"] = 12022.00;
        $dbData["compare_price"] = 200.00;
        $dbData["title"] = " product title for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["description"] = " this is product description description  for : ".date("Y/m/d  h : s : i ")." : timestamp : ".time();
        $dbData["tags"] = "item, something";

        $this->load->model("root_product_model");
        $this->root_product_model->edit($dbData,$product_id);

        $newProductData = $this->root_product_model->getId($product_id);
    
        resOk($newProductData);
      
    }  

    public function enable($product_id_array=array()){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->enable($product_id_array) ;

       resOk($dataLIst);

    }

    public function hide($product_id=array()){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->hide($product_id_array) ;

       resOk($dataLIst);

    }

    public function delete($product_id_array=array()){

       $product_id_array = array(
                           array('product_id' => 229),
                           array('product_id' => 230)) ;

       $this->load->model("root_product_model");

       $dataLIst = $this->root_product_model->delete($product_id_array) ;

      // print_r($dataLIst) ;

       resOk($dataLIst);

    }


    public function enablestock($product_id = 230){


       $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->enableStock($product_id) ;

       //print_r($dataLIst) ;

       resOk($dataLIst);


    }

    public function disablestock($product_id = 230){

       $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->disableStock($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);


    }

    public function disablelifetime($product_id = 230){

       $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->disableLifeTime($product_id) ;

       print_r($dataLIst) ;

       resOk($dataLIst);


    }

    public function enablelifetime($product_id = 230){

        $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->enableLifeTime($product_id) ;

        print_r($dataLIst) ;

        resOk($dataLIst);

    }

    public function enablepackage($product_id = 230){

        $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->enablePackage($product_id) ;

        print_r($dataLIst)  ;

        resOk($dataLIst);

    }

    public function disablePackage($product_id = 230){

        $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->disablePackage($product_id) ;

        print_r($dataLIst)  ;

        resOk($dataLIst);

    }


    // public function getpackageidforproduct($product_id=228)
    // {

    //     $this->load->model("root_product_model");

    //     $dataLIst = $this->root_product_model->getPackageIdForProduct($product_id) ;

    //     print_r($dataLIst) ;

    //     resOk($dataLIst);

    // }

    // public function getproductidforpackage($package_id=11)
    // {

    //     $this->load->model("root_product_model");

    //     $dataLIst = $this->root_product_model->getProductIdForPackage($package_id);

    //     print_r($dataLIst) ;

    // } 

    public function getarrayimage($product_id=231)
    {

        $max_amount = -1 ;
        $this->load->model("root_product_model");

        $dataLIst = $this->root_product_model->getImageArray($product_id,$max_amount) ;
        resOk($dataLIst);

    }

    public function saveimagearray($product_id="",$image_id_array=array())
    {

        $product_id = 231 ;

        $image_id_array = array(array("image_id"=>25),array("image_id"=>26));

        $this->load->model("root_product_model");
        $dataLIst = $this->root_product_model->saveImageArray($product_id,$image_id_array) ;
        resOk($dataLIst);

    }

    public function deleteimagearray($product_id=231,$image_id_array=array())
    {

        $image_id_array = array(array("image_id"=>25),array("image_id"=>26));

        $this->load->model("root_product_model");
        $dataLIst = $this->root_product_model->deleteImageArray($product_id,$image_id_array) ;
        resOk($dataLIst);

    }

    public function cleanimage($product_id=231)
    {

        $this->load->model("root_product_model");
        $dataLIst = $this->root_product_model->cleanImageRelationByKey($product_id) ;
        resOk($dataLIst);

    }

    public function file(){

      $this->load->model("root_file_model");
      $uploadFileData = $this->root_file_model->upload("file_pdf");
      resOk($uploadFileData);

    }



   // public function getPackageIdForProduct($product_id)


   //  function getListsTotalRow(){

   //    $this->load->model("root_product_model");

   //    $condition_data = $this->root_product_model->test() ;

   //   print_r($condition_data)  ;

   //    echo '<br>' ;

   //   // unset($condition_data['fields']["product_title"]) ;

   // //   $test2 = $this->product_model->test2($condition_data) ;

   //  //  print_r($test2)  ;


   //  }

}


?>

