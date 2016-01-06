<?

class root_trash_product_model extends root_model {

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

        return null ;

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

     //MORE FUNCTOIN

    public function pushBack($product_id_array)
    {

          $updateField['status']  = 0 ; 

          $DataProduct_id = "" ;

          foreach ($product_id_array as $value) {
          
              $product_id =  $value['product_id'] ;

              return $this->updateToTable("product",$updateField," WHERE product.product_id = {$product_id} ") ;

          }


    }


    public function remove($product_id_array){


          foreach ($product_id_array as $value) {
          
              $product_id =  $value['product_id'] ;
       

              $res['product_matchto_package'] = $this->db->delete('product_matchto_package', array('product_matchto_package.product_id' => $product_id,'status =' => 0)) ;

              $res['package'] = $this->db->delete('package', array('package.product_id' => $product_id,'status =' => 0)) ;

              $res['image_matchto_object'] = $this->db->delete('image_matchto_object', array('image_matchto_object.holder_object_id' => $product_id,'status =' => 0)) ;

          }

          return $res ;

    }

    public function removeProductBefore($timestamp){


          $res['product_matchto_package'] = $this->db->delete('product_matchto_package', array('product_matchto_package.create_time <' => $timestamp,'status =' => 0)) ;

          $res['package'] = $this->db->delete('package', array('package.create_time <' => $timestamp,'status =' => 0)) ;

          $res['image_matchto_object'] = $this->db->delete('image_matchto_object' , array('image_matchto_object.create_time <' => $timestamp,'status =' => 0)) ;

          return $res ;

    }
}

?>