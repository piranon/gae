<?

class root_promotion_model extends root_model {

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
                "id" => "promotion_lastest_create", 
                "label" => "lastest",
                "value" => "promotion.promotion_id DESC",
                "default" => 1
            ),
            array(
                "id" => "promotion_oldest_create",
                "label" => "oldest",
                "value" => "promotion.promotion_id ASC",
                "default" => 0
            ),
            array(
                "id" => "promotion_short_title_id_a-z",
                "label" => "parent_id_A-Z",
                "value" => "promotion.short_title ASC",
                "default" => 0
            ),
            array(
                "id" => "promotion_description_z-a",
                "label" => "title_Z-A",
                "value" => "promotion.description DESC",
                "default" => 0
            )
        );
        return $sortData;
    }

    public function getSelectFieldArray_short(){
        $field["promotion_promotion_id"] = "promotion.promotion_id";
        $field["promotion_group_id"] = "promotion.promotion_group_id";
        $field["promotion_name"] = "promotion.name";
        $field["promotion_short_title "] = "promotion.short_title  ";
        $field["promotion_description"] = "promotion.description";
        $field["promotion_tags"] = "promotion.tags";
        return $field;
    }

    protected function getSelectFieldArray_extend(){

        return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        $field["promotion_promotion_id"] = "promotion.promotion_id";
        $field["promotion_group_id"] = "promotion.promotion_group_id";
        $field["promotion_name"] = "promotion.name";
        return $field;
    }


    public function getListsTotalRow($WhereStr="",$joinStr=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }

        $sql = " 
            SELECT
                 COUNT( DISTINCT promotion.promotion_id ) as count 
            FROM 
                promotion
                    ".$joinStr."
            WHERE
                promotion.status > 0
            "
            .$WhereStr ;

        $result_ar = $this->db->query($sql)->result_array();
        return intval(@$result_ar[0]["count"]);

      // return $sql ;


    }

    public function getLists($cur_page,$per_page,$WhereStr="",$extend_table = "",$sortBy_id="",$extend_field=array(),$joinStr=""){

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
                promotion
                    ".$joinStr."
            WHERE
                promotion.status > 0 
            "
            .$WhereStr
            .$orderAndLimit_str;

        $result_ar = $this->db->query($sql)->result_array();

        if($extend_table){


            $this->load->model("root_promotion_row_model");

            foreach ($result_ar as $index => $row) {
   
                $promotion_id = $result_ar[$index]['promotion_promotion_id'] ;

                $WhereStr =  "promotion_row.promotion_id = {$promotion_id}" ; 

                $total_row = $this->root_promotion_row_model->getListsTotalRow($WhereStr);
                
                $result_ar[$index]["promotion_row_array"] = $this->root_promotion_row_model->getLists($cur_page=1,$per_page=$total_row,$WhereStr,$sortBy_id="")  ;

            }

        }


        return $result_ar ;
    }


    public function getId($promotion_id){

        if(!$promotion_id){

           return false ;

        }

        $result = $this->getDataById($promotion_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }
    
    public function getShortId($promotion_id){
        
        $result = $this->getShortDataById($promotion_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getDataById($promotion_id,$extend_field=false){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion
            WHERE
                promotion.status > 0
            AND
                promotion.promotion_id = {$promotion_id}
            LIMIT 
                0,1
            ";

        $result_ar = $this->db->query($sql)->result_array();

        $this->load->model("root_promotion_row_model");

        $WhereStr =  "promotion_row.promotion_id = {$promotion_id}" ;   

        $total_row = $this->root_promotion_row_model->getListsTotalRow($WhereStr);

        $WhereStr = "promotion_row.promotion_id = {$promotion_id}" ;
            
        $result_ar[0]["promotion_row_array"] = $this->root_promotion_row_model->getLists($cur_page=1,$per_page=$total_row,$WhereStr,$sortBy_id="")  ;

        $dataResult = @$result_ar;
        if(@$dataResult[0]["promotion_promotion_id"]==0){
            return false;
        }  
        return $dataResult  ;

    }

    public function getShortDataById($promotion_id){
        return $this->getDataById($promotion_id,false);
    }

    public function add($dbData){


        $promotion_group_id = $dbData['promotion_group_id'] ;

        $TypeIdPromotionGroup = $this->checkTypeIdPromotionGroup($promotion_group_id) ;

        if($TypeIdPromotionGroup == 1){

            return false ;

        }


        $local_dbData = $this->makeDbDataForDbTable($dbData,"promotion",array("shop_id","status","create_time","update_time","promotion_id"));

        $local_dbData["shop_id"] = $this->currentShopId();
        $local_dbData["status"] = 1;
        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();
        
        $promotion_id = $this->insertToTable("promotion",$local_dbData);

        return $promotion_id;
    }

    public function edit($dbData,$promotion_id){

        //$this->getId($product_id); // for check exists id

        $local_dbData = $this->makeDbDataForDbTable($dbData,"promotion",array("promotion_id","shop_id","status","create_time","update_time"));
        $local_dbData["update_time"] = time();

        $updateResult = $this->updateToTable("promotion",$local_dbData," WHERE promotion.promotion_id = ? ",array($promotion_id));

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

        $primary_field = "promotion_id";

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

    private function updateSimpleDataById($updateData,$promotion_id){
        $updateData["update_time"] = time();
        return $this->updateToTable("promotion",$updateData," WHERE promotion.promotion_id = ? ",array($promotion_id));
    }

    private function checkTypeIdPromotionGroup($promotion_group_id)
    {

            $result = $this->db->select('promotion_group_type_id')
                               ->Where('promotion_group_id' , $promotion_group_id)
                               ->get('promotion_group') 
                               ->row_array() ;

            if(!$result){                  

                return false ;

            }

            return $result['promotion_group_type_id'] ;

    }

}

?>