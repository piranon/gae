<?

class root_coupon_model extends root_model {

    /* << BASIC FUNCTION : START >> */

     function __construct()
    {
        parent::__construct();
        $this->load->model("root_product_model");

    }

    public function getTableId(){

        return $this->root_product_model->getTableId() ;

    }

    public function getSortby(){

        return $this->root_product_model->getSortby() ;

    }

    public function getProductTypeId(){

        return 3 ;

    }


    public function getListsTotalRow($WhereStr="",$param_ar,$joinStr=""){
              
        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);
        return $this->root_product_model->getListsTotalRow($WhereStr,$param_ar,$joinStr) ;

    }

    public function getLists($cur_page,$per_page,$sortBy_id="",$WhereStr="",$input_paramAr=array(),$joinStr="",$extend_field=array()){

        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);

        return $this->root_product_model->getLists($cur_page,$per_page,$sortBy_id,$WhereStr,$input_paramAr,$joinStr,$extend_field) ;

    }


    public function getId($product_id){

        
        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);
        return $this->root_product_model->getId($product_id) ; 
  
    }
    
    public function getShortId($product_id){
        
        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);
        return $this->root_product_model->getShortId($product_id) ;

    }


    public function getDataById($product_id,$extend_field=true){
        
        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);
        return $this->root_product_model->getDataById($product_id) ;
    }

    public function getShortDataById($product_id){

        $product_type_id = $this->getProductTypeId();
        $this->root_product_model->setProductTypeId($product_type_id);
        return $this->root_product_model->getDataById($product_id,false) ;
    }

    public function add($dbData){

        $local_dbData = $this->makeDbDataForDbTable($dbData,"product",array("product_type_id"));
        $dbData["product_type_id"] =  $this->getProductTypeId() ;

        return $this->root_product_model->add($dbData) ;

    }

    public function edit($dbData,$product_id){

        return $this->root_product_model->edit($dbData,$product_id) ;

    }

    public function enable($deleteIdArray=array()){
        ///return $this->updateStatus($deleteIdArray,0);
         return $this->root_product_model->enable($deleteIdArray) ;

    }

    public function hide($deleteIdArray=array()){

          return $this->root_product_model->hide($deleteIdArray) ;
    }

    public function delete($deleteIdArray=array()){

         return $this->root_product_model->delete($deleteIdArray) ;
    }

    /* << BASIC FUNCTION : END >> */

    public function getPrimaryImage($product_id,$limit=-1){
        
        return $this->root_image_model->getImageByHolder($this->getTableId(),$product_id,0,$limit);
    }

     //MORE FUNCTOIN
}

?>