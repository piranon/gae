<?

class root_promotion_row_model extends root_model {

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
                "id" => "promotion_row_lastest_create", 
                "label" => "lastest",
                "value" => "promotion_row.promotion_row_id DESC",
                "default" => 1
            ),
            array(
                "id" => "promotion_row_oldest_create",
                "label" => "oldest",
                "value" => "promotion_row.promotion_row_id ASC",
                "default" => 0
            ),
            array(
                "id" => "promotion_row_object_id_create",
                "label" => "lastest",
                "value" => "promotion_row.object_id DESC",
                "default" => 0
            ),
            array(
                "id" => "promotion_row_object_id_create",
                "label" => "oldest",
                "value" => "promotion_row.object_id ASC",
                "default" => 0
            ),

        );
        return $sortData;
    }

    public function getSelectFieldArray_short(){
        $field["promotion_id"] = "promotion_row.promotion_id";
        $field["promotion_row_id"] = "promotion_row.promotion_row_id";
        $field["promotion_row__object_table_id"] = "promotion_row.object_table_id";
        $field["promotion_row_product_id"] = "promotion_row.object_id";
        $field["promotion_row_amount"] = "promotion_row.amount";
        $field["promotion_row_percent_by_amount"] = "promotion_row.percent_by_amount";
        $field["promotion_row_price"] = "promotion_row.price";
        $field["promotion_row_create_time"] = "promotion_row.create_time";
        $field["promotion_row_update_time"] = "promotion_row.update_time";
        return $field;
    }

    protected function getSelectFieldArray_extend(){

       // return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        $field["promotion_row_id"] = "promotion_row.promotion_row_id";
        $field["promotion_row__object_table_id"] = "promotion_row.object_table_id";
        $field["promotion_row_create_time"] = "promotion_row.create_time";
        $field["promotion_row_update_time"] = "promotion_row.update_time";
        return $field;
    }


    public function getListsTotalRow($WhereStr="",$joinStr=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }


        $sql = " 
            SELECT
                 COUNT( DISTINCT promotion_row.promotion_row_id ) as count 
            FROM 
                promotion_row
            WHERE
                promotion_row.status > 0
            "
            .$WhereStr ;

        $result_ar = $this->db->query($sql)->result_array();
        return intval(@$result_ar[0]["count"]);

      // return $sql ;


    }

    public function getLists($cur_page,$per_page,$WhereStr="",$sortBy_id="",$extend_field=array()){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        
        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        $fieldArray = array_merge($fieldArray, $extend_field);

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion_row
            WHERE
                promotion_row.status > 0 
            "
            .$WhereStr
            .$orderAndLimit_str;


        $result_ar = $this->db->query($sql)->result_array();

        return $result_ar;
    }


    public function getId($promotion_row_id){

        $result = $this->getDataById($promotion_row_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }
    
    public function getShortId($promotion_row_id){
        
        $result = $this->getShortDataById($promotion_row_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getDataById($promotion_row_id,$extend_table=false,$extend_field=false){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion_row
            WHERE
                promotion_row.status > 0  
            AND 
                promotion_row.promotion_row_id = {$promotion_row_id}
            LIMIT 
                0,1
            ";

        $result_ar = $this->db->query($sql)->result_array();

        if($extend_table){      

                $this->load->model("root_promotion_model");

                $promotion_id = $result_ar[0]['promotion_id'] ;

                $WhereStr =  "promotion.promotion_id = {$promotion_id}" ;   

                $total_row = $this->root_promotion_model->getListsTotalRow($WhereStr);
                    
                $result_ar[0]["promotion_array"] = $this->root_promotion_model->getLists($cur_page=1,$per_page=$total_row,$WhereStr,$sortBy_id="")  ;

        }


        $dataResult = @$result_ar[0];
        if(@$dataResult["promotion_row_id"]==""){
            return false;
        }  
        return $dataResult  ;

    }

    public function getShortDataById($promotion_row_id){
        return $this->getDataById($promotion_row_id,false);
    }

    public function add($dbData){

        $promotion_id = $dbData['promotion_id'] ;

        $ResDataPromotionRow = $this->getPromotionInrow($promotion_id) ;

        if($ResDataPromotionRow){

            $this->checkSinglePromotion($promotion_id) ;

        }

        $local_dbData = $this->makeDbDataForDbTable($dbData,"promotion_row",array("shop_id","status","create_time","update_time","promotion_row_id"));

        $local_dbData["shop_id"] = $this->currentShopId();
        $local_dbData["status"] = 1;
        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();
        $local_dbData["object_table_id"] =$this->getTableId() ;
        
        $promotion_row_id = $this->insertToTable("promotion_row",$local_dbData);

        return $promotion_row_id;
    }

    public function edit($dbData,$promotion_row_id){

        //$this->getId($product_id); // for check exists id

        $local_dbData = $this->makeDbDataForDbTable($dbData,"promotion_row",array("shop_id","status","create_time","update_time"));
        $local_dbData["update_time"] = time();

        $updateResult = $this->updateToTable("promotion_row",$local_dbData," WHERE promotion_row.promotion_row_id = ? ",array($promotion_row_id));
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

        $primary_field = "promotion_row_id";

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


     //MORE FUNCTOIN

    private function updateSimpleDataById($updateData,$promotion_row_id){
        $updateData["update_time"] = time();
        return $this->updateToTable("promotion_row",$updateData," WHERE promotion_row.promotion_row_id = ? ",array($promotion_row_id));
    }

    private function getPromotionInrow($promotion_id)
    {


        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion_row
            WHERE
                promotion_row.status > 0  
            AND 
                promotion_row.promotion_id = {$promotion_id}
            LIMIT 
                0,1
            ";

        $result_ar = $this->db->query($sql)->result_array();

        $dataResult = @$result_ar[0];
        if(@$dataResult["promotion_row_id"]==""){
            return false;
        }  
        return $dataResult  ;

    }

    private function checkSinglePromotion($promotion_id)
    {

        $this->load->model("root_promotion_model");

        $ResDataPromotion = $this->root_promotion_model->getId($promotion_id) ;

        if($ResDataPromotion){

            $this->load->model("root_promotion_group_model");

            $promotion_group_id = $ResDataPromotion[0]['promotion_group_id'] ;

            $ResDataPromotionGroup = $this->root_promotion_group_model->getId($promotion_group_id) ;

            if($ResDataPromotionGroup[0]['promotion_group_promotion_group_type_id'] == 1){

                 resDie(array(),'promotion group is single') ;

            }

        }

    }
   

}

?>