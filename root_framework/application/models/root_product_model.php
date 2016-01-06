<?

class root_product_model extends root_model {

    private $currentProductTypeId = null;

    public function setProductTypeId($type_id){
        $this->currentProductTypeId = $type_id;
    }

    public function getProductTypeId(){
        return  $this->currentProductTypeId;
    }
    /* << BASIC FUNCTION : START >> */

    public function getTableId(){
        return  202;
    }

    public function getSortby(){

        $sortData = array(
            array(
                "id" => "product_lastest_create", 
                "label" => "lastest",
                "value" => "product.create_time DESC",
                "default" => 1
            ),
            array(
                "id" => "product_oldest_create",
                "label" => "oldest",
                "value" => "product.create_time ASC",
                "default" => 0
            ),
            array(
                "id" => "product_title_a-z",
                "label" => "title_A-Z",
                "value" => "product_detail.title ASC",
                "default" => 0
            ),
            array(
                "id" => "product_title_z-a",
                "label" => "title_Z-A",
                "value" => "product_detail.title DESC",
                "default" => 0
            )
        );
        return $sortData;
    }

    public function getSelectFieldArray_short(){
        $field["product_id"] = "product.product_id";
        $field["product_type_id"] = "product.product_type_id";
        $field["product_price"] = "product.price";
        $field["product_title"] = "product_detail.title";
        $field["product_create_time"] = "product.create_time";
        $field["product_update_time"] = "product.update_time";
        return $field;
    }

    protected function getSelectFieldArray_extend(){
        $field["product_tags"] = "product_detail.tags";
        $field["product_description"] = "product_detail.description";
        return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        $field["product_id"] = "product.product_id";
        $field["product_type_id"] = "product.product_type_id";
        $field["product_price"] = "product.price";
        $field["product_title"] = "product_detail.title";
        $field["product_create_time"] = "product.create_time";
        $field["product_update_time"] = "product.update_time";
        return $field;
    }


    public function getListsTotalRow($WhereStr="",$input_paramAr=array(),$joinStr=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        $ex_WhereStr = "";
        $ex_paramAr = array();
        $product_type_id = $this->getProductTypeId() ;
        if($this->getProductTypeId()!=null){
            $ex_WhereStr = " AND product.product_type_id = {$product_type_id} ";
         //   $ex_paramAr = array($this->getProductTypeId());
        }

        $sql = " 
            SELECT
                 COUNT( DISTINCT product.product_id ) as count 
            FROM 
                product
                    INNER JOIN product_detail ON product_detail.product_id = product.product_id
                    ".$joinStr."
            WHERE
                product.status > 0
            "
            .$WhereStr
            .$ex_WhereStr;

        $param_ar = array();
        $param_ar = array_merge($param_ar,$input_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return intval(@$result_ar[0]["count"]);

        // return $sql ;


    }

    public function getLists($cur_page,$per_page,$sortBy_id="",$WhereStr="",$input_paramAr=array(),$joinStr="",$extend_field=array()){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        $ex_WhereStr = "";
        $ex_paramAr = array();
        if($this->getProductTypeId()!=null){
            $ex_WhereStr = " AND product.product_type_id = ? ";
            $ex_paramAr = array($this->getProductTypeId());
        }
        
        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        $fieldArray = array_merge($fieldArray, $extend_field);

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                product
                    INNER JOIN product_detail ON product_detail.product_id = product.product_id
                    ".$joinStr."
            WHERE
                product.status > 0
            "
            .$WhereStr
            .$ex_WhereStr
            .$orderAndLimit_str;

        $param_ar = array();
        $param_ar = array_merge($param_ar,$input_paramAr,$ex_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(sizeof($result_ar)>0){
            foreach ($result_ar as $key => $value) {
                $product_id = @$value["product_id"];
                $result_ar[$key]["product_image"] = $this->getPrimaryImage($product_id,2);
            }
        }


        return $result_ar;
    }


    public function getId($product_id){

        $result = $this->getDataById($product_id,true);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }
    
    public function getShortId($product_id){
        
        $result = $this->getShortDataById($product_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getDataById($product_id,$extend_field=false){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }

        $ex_WhereStr = "";
        $ex_paramAr = array();
        if($this->getProductTypeId()!=null){
            $ex_WhereStr = " AND product.product_type_id = ? ";
            $ex_paramAr = array($this->getProductTypeId());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                product
                    INNER JOIN product_detail ON product_detail.product_id = product.product_id
            WHERE
                product.product_id = ?
                AND product.status > 0
                ".$ex_WhereStr."
            LIMIT 
                0,1
            ";

        $param_ar = array($product_id);
        $param_ar = array_merge($param_ar,$ex_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        $dataResult = @$result_ar[0];
        if(@$dataResult["product_id"]==""){
            return false;
        }  
        return $dataResult;

    }

    public function getShortDataById($product_id){
        return $this->getDataById($product_id,false);
    }

    public function add($dbData){

        $local_dbData = $this->makeDbDataForDbTable($dbData,"product",array("shop_id","status","create_time","update_time"));
        $local_dbData["shop_id"] = $this->currentShopId();
        $local_dbData["status"] = 1;
        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();
        
        $product_id = $this->insertToTable("product",$local_dbData);
        if($product_id){
           $this->edit($dbData,$product_id);
        }
        return $product_id;
    }

    public function edit($dbData,$product_id){

        //$this->getId($product_id); // for check exists id

        $local_dbData = $this->makeDbDataForDbTable($dbData,"product",array("product_type_id","shop_id","status","create_time","update_time"));
        $local_dbData["update_time"] = time();

        $updateResult = $this->updateToTable("product",$local_dbData," WHERE product.product_id = ? ",array($product_id));
        if($updateResult){
            $this->editDetail($dbData,$product_id);
        }
        return $updateResult;
    }

    public function enable($deleteIdArray=array()){
        return $this->updateStatus($deleteIdArray,1);
        return $deleteIdArray ;
    }

    public function hide($deleteIdArray=array()){
        return $this->updateStatus($deleteIdArray,2);
       //return $deleteIdArray ;
    }

    public function delete($deleteIdArray=array()){
        return $this->updateStatus($deleteIdArray,0);
    }

    private function updateStatus($deleteIdArray=array(),$status=0){

        if(!in_array($status, array(0,1,2))){
            resDie("updateStatus is avaliable for 0,1,2");
        }

        $primary_field = "product_id";

        if(!(is_array($deleteIdArray)&&(sizeof($deleteIdArray)>0))){
            resDie(array(),"delete-is-not-array");
        }

        $idArray = $this->getUniqIdArrayForDelete($primary_field,$deleteIdArray);

        $deleteDataArray = array();
        $success_count = 0;
        if(sizeof($idArray)>0){
            foreach ($idArray as $index => $value) {
                $deleteRow = array();
                $deleteRow[$primary_field] = $value;
                if($value==0){
                    $deleteRow["result"] = 0;
                }else{
                    if($this->getDataById($value)){
                        $result =$this->updateSimpleDataById(array("status"=>$status),$value);
                        $deleteRow["result"] = 1;
                        $success_count++;
                    }else{
                        $deleteRow["result"] = 0;
                    }
                }
                array_push($deleteDataArray,$deleteRow);
            }
        }

        $deleteResult = array();
        $deleteResult["total"] = sizeof($idArray);
        $deleteResult["success"] = $success_count;
        $deleteResult["detail"] = $deleteDataArray;
        return $deleteResult;
    }

    /* << BASIC FUNCTION : END >> */

    public function getPrimaryImage($product_id,$limit=-1){
        $this->load->model("root_image_model");
        return $this->root_image_model->getImageByHolder($this->getTableId(),$product_id,0,$limit);
    }

    //MORE FUNCTOIN
    private function addNewDetail($product_id){

        $dbData = array();
        $dbData["shop_id"] = $this->currentShopId();
        $dbData["product_id"] = $product_id;
        $dbData["status"] = 1;
        $dbData["create_time"] = time();
        $dbData["update_time"] = time();

        $product_detail_id = $this->insertToTable("product_detail",$dbData);
        return $product_detail_id;
    }

    private function updateSimpleDataById($updateData,$product_id){
        $updateData["update_time"] = time();
        return $this->updateToTable("product",$updateData," WHERE product.product_id = ? ",array($product_id));
    }


    private function checkExistsDetailId($product_id){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        $sql = " 
            SELECT
                product_detail.product_detail_id AS product_detail_id
            FROM 
                product_detail
            WHERE
                product_detail.product_id = ?
                AND product_detail.status > 0 
            LIMIT 
                0,1
            ";

        $param_ar = array($product_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        $dataResult = @$result_ar[0];
        if(@$dataResult["product_detail_id"]==""){
            return false;
        }  
        return @$dataResult["product_detail_id"];

    }

    public function getExistsDetailId($product_id){

        $product_detail_id = $this->checkExistsDetailId($product_id);
        if(!$product_detail_id){
            $product_detail_id = $this->addNewDetail($product_id);
        }
        return $product_detail_id;
    }


    public function editDetail($dbData,$product_id){

        $product_detail_id = $this->getExistsDetailId($product_id);
        $local_dbData = $this->makeDbDataForDbTable($dbData,"product_detail",array("shop_id","status","create_time","update_time"));
        $local_dbData["update_time"] = time();
        $updateResult =  $this->updateToTable("product_detail",$local_dbData," WHERE product_detail.product_detail_id = ? ",array($product_detail_id));
        return $updateResult;
    }


    public function enableStock($product_id){

        return $this->updateSimpleDataById(array("is_stock_enable"=>1),$product_id);

    } 

    public function disableStock($product_id){

        return $this->updateSimpleDataById(array("is_stock_enable"=>0),$product_id);


    } 


    public function enableLifeTime($product_id){

        return $this->updateSimpleDataById(array("is_lifetime_enable"=>1),$product_id);

    }

    public function disableLifeTime($product_id){

        $this->load->model("root_lifetime_model");
        $this->root_lifetime_model->clearLifeTimeForProduct($product_id);

        return $this->updateSimpleDataById(array("is_lifetime_enable"=>0),$product_id);
    }


    public function enablePackage($product_id){

  
       $this->updateSimpleDataById(array("is_package_enable"=>1),$product_id);

       $ProductIdPackage = $this->checkIdProductPackage($product_id) ;

       $dbData = array() ;

       $dbData['shop_id'] = $this->currentShopId();

       $dbData['product_id'] = $product_id ;

       $dbData['status'] =  1 ;

       $dbData["create_time"] = time();

       $dbData["update_time"] = time();


        if(!$ProductIdPackage)
        {

           return  $this->insertToTable("package", $dbData);

        }

    }  

    public function disablePackage($product_id){
  
       $res['dis_product_success'] =  $this->updateSimpleDataById(array("is_package_enable"=>0),$product_id);
       $dbData["status"] = 0;
       $res['dis_packege_success'] = $this->updateToTable("package",$dbData," WHERE package.product_id = {$product_id} ") ;
       $res['dis_matchpackege_success'] = $this->updateToTable("product_matchto_package",$dbData," WHERE product_matchto_package.product_id = {$product_id} ") ;

       return $res ;

    }

    public function checkIdProductPackage($product_id){

            $ProductIdPackage = $this->db->select("product_id") 
                                     ->where('product_id', $product_id )
                                     ->where('status', 1)
                                     ->get("package") 
                                     ->row_array() ;
           
           if(!$ProductIdPackage){

                return false ;

           }else{

                return $ProductIdPackage  ;
           }

    }

    //<<!-- IMAGE : START -->
    private function getImageMatchToTypeId(){
        return 0;
    }

    public function getImageArray($object_id,$max_amount)
    {

       $object_table_id = $this->getTableId() ;

       $type_id = $this->getImageMatchToTypeId();

       $limit = $max_amount ;

       $this->load->model("root_image_model");

       return  $this->root_image_model->getImageByHolder($object_table_id,$object_id,$type_id,$limit) ;

    }

    public function saveImageArray($product_id,$image_id_array)
    {   

        $this->cleanImageRelationByKey($product_id);

        $index = 0;
        $datalist = array() ;
        foreach ($image_id_array as $value ) {
           $datalist = $this->addImage($product_id,$value['image_id'],$index) ;
           $index++;
        }   

        if($datalist){

            return true ;

        }else{

            return false ;
        }    

    }

    public function addImage($product_id,$image_id,$index=0){
        $object_table_id = $this->getTableId() ;
        $type_id = $this->getImageMatchToTypeId();
        $this->load->model("root_image_model");
        $datalist = $this->root_image_model->addImageToObject($image_id,$object_table_id,$product_id,$type_id,$index) ;
        return $datalist;
    }

    public function deleteImageArray($product_id,$image_id_array)
    {
        $object_table_id = $this->getTableId() ;

        $this->load->model("root_image_model"); 
        
        foreach ($image_id_array as $value ) {
            
            $res = $this->root_image_model->deleteImageToObject($object_table_id,$product_id,$value['image_id']) ;

        } 

        return $res ;   

    }

    public function cleanImageRelationByKey($object_id){

        $this->load->model("root_image_model"); 

        $object_table_id = $this->getTableId() ;

        $type_id = $this->getImageMatchToTypeId();

        return $this->root_image_model->cleanImageRelationByKey($object_table_id,$object_id,$type_id) ;

    }
    //<<!-- IMAGE : END -->


    //<<!-- FILE PDF : START -->
    private function getPDFMatchToTypeId(){
        return 102;
    }

    public function getPDFArray($product_id,$max_amount)
    {

       $object_table_id = $this->getTableId() ;

       $type_id = $this->getPDFMatchToTypeId();

       $limit = $max_amount ;

       $this->load->model("root_file_model");

       return  $this->root_file_model->getFileByHolder($object_table_id,$product_id,$type_id,$limit) ;

    }

    public function savePDFArray($product_id,$file_id_array)
    {   

        $this->cleanPDFRelationByKey($product_id);

        $index = 0;
        $datalist = array() ;
        foreach ($file_id_array as $value ) {
           $datalist = $this->addPDF($value['file_id'],$product_id,$index) ;
           $index++;
        }   

        if($datalist){

            return true ;

        }else{

            return false ;
        }    

    }

    public function addPDF($product_id,$file_id,$index=0){
        $object_table_id = $this->getTableId() ;
        $type_id = $this->getPDFMatchToTypeId();
        $this->load->model("root_file_model");
        $datalist = $this->root_file_model->addFileToObject($file_id,$object_table_id,$product_id,$type_id,$index) ;
        return $datalist;
    }

    public function deletePDFArray($product_id,$file_id_array)
    {
        $object_table_id = $this->getTableId() ;
        $this->load->model("root_file_model"); 
        foreach ($file_id_array as $value ) {
            $res = $this->root_file_model->deleteFileToObject($object_table_id,$product_id,$value['file_id']) ;
        }
        return $res ;   

    }

    public function cleanPDFRelationByKey($object_id){

        $this->load->model("root_file_model"); 

        $object_table_id = $this->getTableId() ;

        $type_id = $this->getPDFMatchToTypeId();

        return $this->root_file_model->cleanFileRelationByKey($object_table_id,$object_id,$type_id) ;

    }
    
     //<<!-- FILE PDF : END -->
   

}

?>