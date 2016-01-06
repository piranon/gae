<?

class root_promotion_group_model extends root_model {

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
                "value" => "promotion_group.promotion_group_id DESC",
                "default" => 1
            ),
            array(
                "id" => "promotion_oldest_create",
                "label" => "oldest",
                "value" => "promotion_group.promotion_group_id ASC",
                "default" => 0
            ),
            array(
                "id" => "promotion_parent_id_a-z",
                "label" => "parent_id_A-Z",
                "value" => "promotion_group.parent_id ASC",
                "default" => 0
            )
        );
        return $sortData;
    }

    public function getSelectFieldArray_short(){
        $field["promotion_group_id"] = "promotion_group.promotion_group_id";
        $field["promotion_group_promotion_group_type_id"] = "promotion_group.promotion_group_type_id";
        $field["promotion_group_name"] = "promotion_group.name";
        $field["promotion_group_description"] = "promotion_group.description";
        $field["promotion_group_lifetime_id"] = "promotion_group.lifetime_id";
        $field["promotion_group_create_time"] = "promotion_group.create_time";
        $field["promotion_group_update_time"] = "promotion_group.update_time";
        $field["id"] = "promotion_group.promotion_group_id";
        return $field;
    }

    protected function getSelectFieldArray_extend(){

        return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        $field["promotion_group_id"] = "promotion_group.promotion_group_id";
        $field["promotion_group_promotion_group_type_id"] = "promotion_group.promotion_group_type_id";
        $field["promotion_group_name"] = "promotion_group.name";
        return $field;
    }


    public function getListsTotalRow($promotion_group_id="",$joinStr=""){

        if($promotion_group_id){ 

            $WhereStr =  "AND promotion_group.promotion_group_id = {$promotion_group_id}" ;  

        }else{

            $WhereStr = "" ;

        }

        $sql = " 
            SELECT
                 COUNT( DISTINCT promotion_group.promotion_group_id ) as count 
            FROM 
                promotion_group
            WHERE 
                promotion_group.status > 0
            ".$WhereStr ;

        $result_ar = $this->db->query($sql)->result_array();
        return intval(@$result_ar[0]["count"]);

      // return $sql ;


    }

    public function getLists($cur_page,$per_page,$promotion_group_id="",$sortBy_id="",$extend_field=false){


        if($promotion_group_id){ 

            $WhereStr_promotion_group =  "AND promotion_group.promotion_group_id = {$promotion_group_id}" ;  

            $WhereStr_promotion =  "promotion.promotion_group_id = {$promotion_group_id}" ;

        }else{


            $WhereStr_promotion_group =  "" ;  

            $WhereStr_promotion =  "" ;

        }

        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){

           $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());

        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion_group
            WHERE
                promotion_group.status > 0 
            "
            .$WhereStr_promotion_group
            .$orderAndLimit_str;

        $result_ar = $this->db->query($sql)->result_array();

        $this->load->model("root_promotion_model");


        $total_row = $this->root_promotion_model->getListsTotalRow($WhereStr_promotion);

        foreach ($result_ar as $index => $row) {

            if($row["promotion_group_promotion_group_type_id"] == 1){

            $promotion_group_id = $row["promotion_group_id"];

            $WhereStr_promotion = "promotion.promotion_group_id = {$promotion_group_id}" ;
            
            $result_ar[$index]['promotion_array'] = $this->root_promotion_model->getLists($cur_page=1,$per_page=$total_row,$WhereStr_promotion,$sortBy_id="")  ;

            }
        }

        return $result_ar;
    }


    public function getId($promotion_group_id){

        $result = $this->getDataById($promotion_group_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }
    
    public function getShortId($promotion_group_id){
        
        $result = $this->getShortDataById($promotion_group_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getDataById($promotion_group_id,$extend_field=false){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                promotion_group
            WHERE
                promotion_group.status > 0 
            AND
                promotion_group.promotion_group_id = {$promotion_group_id}
            LIMIT 
                0,1
            ";

        $result_ar = $this->db->query($sql)->result_array();

        if($result_ar[0]['promotion_group_promotion_group_type_id'] == 2){

                $this->load->model("root_promotion_model");

                $WhereStr =  "promotion.promotion_group_id = {$promotion_group_id}" ;   

                $total_row = $this->root_promotion_model->getListsTotalRow($WhereStr);

                $result_ar[0]["promotion_array"] = $this->root_promotion_model->getLists($cur_page=1,$per_page=$total_row,$WhereStr,$sortBy_id="")  ;

        }


        return $result_ar  ;

    }

    public function getShortDataById($promotion_group_id){
        return $this->getDataById($promotion_group_id,false);
    }

    public function add($dbData){


        $local_dbData = $this->makeDbDataForDbTable($dbData,"promotion_group",array("shop_id","status","create_time","update_time"));
        $local_dbData["shop_id"] = $this->currentShopId();
        $local_dbData["status"] = 1;
        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();
        
        $promotion_group_id = $this->insertToTable("promotion_group",$local_dbData);

        return $promotion_group_id;
    }

    public function edit($dbData,$promotion_group_id){

        //$this->getId($product_id); // for check exists id

        $dbData["update_time"] = time();

        $updateResult = $this->updateToTable("promotion_group",$dbData," WHERE promotion_group.promotion_group_id = ? ",array($promotion_group_id));

        return $updateResult;
    }

    public function enable($deleteIdArray=array()){
        return $this->updateStatus($deleteIdArray,1);
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

        $primary_field = "promotion_group_id";

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
        return $this->updateToTable("promotion_group",$updateData," WHERE promotion_group.promotion_group_id = ? ",array($promotion_id));
    }



   

}

?>