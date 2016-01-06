<?

class root_badge_model extends root_model {

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
        $field["badge_group_id"] = "badge_group.badge_group_id";
        $field["badge_group_group_type_id"] = "badge_group.badge_group_type_id";
        $field["badge_group_check_type_id"] = "badge_group.badge_check_type_id";
        $field["badge_group_table_id"] = "badge_group.table_id";
        $field["badge_group_name "] = "badge_group.name  ";
        $field["badge_group_create_time"] = "badge_group.create_time";
        $field["badge_group_update_time"] = "badge_group.update_time";
        return $field;
    }


    public function getSelectFieldArray_Matchobject()
    {

        $field["badge_matchto_object_matchto_object_id"] = "badge_matchto_object.badge_matchto_object_id";
        $field["badge_matchto_object_badge_id "] = "badge_matchto_object.badge_id ";
        $field["badge_matchto_object_table_id"] = "badge_matchto_object.holder_object_table_id";
        $field["badge_matchto_object_object_id"] = "badge_matchto_object.holder_object_id";
        return $field ;

    }

    protected function getSelectFieldArray_extend(){
        $field["badge_badge_id"] = "badge.badge_id";
        $field["badge_badge_group_id"] = "badge.badge_group_id";
        $field["badge_name"] = "badge.name";
        $field["badge_title"] = "badge.title";
        $field["badge_title2"] = "badge.title2";
        $field["badge_create_time"] = "badge.create_time" ;
        $field["badge_update_times"] = "badge.update_time";
        return $field;
    }

    protected function getSelectFieldArray_veryShot(){
        $field["badge_group_group_type_id"] = "badge_group.badge_group_type_id";
        $field["badge_group_check_type_id"] = "badge_group.badge_check_type_id";
        $field["badge_group_table_id"] = "badge_group.table_id";
        $field["badge_group_name "] = "badge_group.name  ";
        return $field;
    }

    public function getAllForTable($DataID)
    {

        $tableName = "badge_group" ;

        $CountStr = $tableName.".badge_group_id" ;

        $WhereStr = $tableName.".table_id={$DataID}" ;

        $joinStr = "" ;

        $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr) ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_short() ;

        $result_ar = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        if($result_ar){

            $CountStr = "badge.badge_id" ;

            $tableName = "badge" ;
            
            $fieldArray = array();
            $fieldArray = $this->getSelectFieldArray_extend() ;
           
            $tableNameGroupType = "badge_group_type" ;
            $tableNamecheckType = "badge_check_type" ;
            $WhereStrGroupType =  "badge_group_type_id" ;
            $WhereStrcheckType = "badge_check_type_id" ;
            $field = "name" ;

            foreach ($result_ar as $index => $row) {

                $badge_group_type_id = $result_ar[$index]['badge_group_group_type_id'] ;

                 $result_ar[$index]['group_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrGroupType,$tableNameGroupType,$badge_group_type_id) ;

                $badge_check_type_id = $result_ar[$index]['badge_group_check_type_id'] ;

                $result_ar[$index]['check_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrcheckType,$tableNamecheckType,$badge_check_type_id) ;
   
                $badge_group_id = $result_ar[$index]['badge_group_id'] ;

                $WhereStr =  "badge.badge_group_id = {$badge_group_id}" ; 

                $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr);
                
                $result_ar[$index]["badge_row_array"] = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false)  ;

            }

         }

        $dataResult = $result_ar ;

        return  $dataResult ;

    }

    public function getAllForGroup($DataID)
    {

        $tableName = "badge_group" ;

        $CountStr = $tableName.".badge_group_id" ;

        $WhereStr = $tableName.".badge_group_id={$DataID}" ;

        $joinStr = "" ;

        $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr) ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_short() ;

        $result_ar = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        if($result_ar){

            $CountStr = "badge.badge_id" ;

            $tableName = "badge" ;

            $fieldArray = array();
            $fieldArray = $this->getSelectFieldArray_extend() ;

            $tableNameGroupType = "badge_group_type" ;
            $tableNamecheckType = "badge_check_type" ;
            $WhereStrGroupType =  "badge_group_type_id" ;
            $WhereStrcheckType = "badge_check_type_id" ;
            $field = "name" ;

            foreach ($result_ar as $index => $row) {

                $badge_group_type_id = $result_ar[$index]['badge_group_group_type_id'] ;

                 $result_ar[$index]['group_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrGroupType,$tableNameGroupType,$badge_group_type_id) ;

                $badge_check_type_id = $result_ar[$index]['badge_group_check_type_id'] ;

                $result_ar[$index]['check_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrcheckType,$tableNamecheckType,$badge_check_type_id) ;
   
                $badge_group_id = $result_ar[$index]['badge_group_id'] ;

                $WhereStr =  "badge.badge_group_id = {$badge_group_id}" ; 

                $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr);
                
                $result_ar[$index]["badge_row_array"] = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false)  ;

            }

         }

        $dataResult = $result_ar ;

        return  $dataResult ;

    }

    public function getAllForGroupType($DataID)
    {

        $tableName = "badge_group" ;

        $CountStr = $tableName.".badge_group_id" ;

        $WhereStr = $tableName.".badge_group_type_id={$DataID}" ;

        $joinStr = "" ;

        $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr) ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_short() ;

        $result_ar = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        if($result_ar){

            $CountStr = "badge.badge_id" ;

            $tableName = "badge" ;

            $fieldArray = array();
            $fieldArray = $this->getSelectFieldArray_extend() ;

            $tableNameGroupType = "badge_group_type" ;
            $tableNamecheckType = "badge_check_type" ;
            $WhereStrGroupType =  "badge_group_type_id" ;
            $WhereStrcheckType = "badge_check_type_id" ;
            $field = "name" ;

            foreach ($result_ar as $index => $row) {

                $badge_group_type_id = $result_ar[$index]['badge_group_group_type_id'] ;

                 $result_ar[$index]['group_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrGroupType,$tableNameGroupType,$badge_group_type_id) ;

                $badge_check_type_id = $result_ar[$index]['badge_group_check_type_id'] ;

                $result_ar[$index]['check_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrcheckType,$tableNamecheckType,$badge_check_type_id) ;
   
                $badge_group_id = $result_ar[$index]['badge_group_id'] ;

                $WhereStr =  "badge.badge_group_id = {$badge_group_id}" ; 

                $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr);
                
                $result_ar[$index]["badge_row_array"] = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false)  ;

            }

         }

        $dataResult = $result_ar ;

        return  $dataResult ;

    }

  public function getAllWithRelationForHolder($Data)
    {

        $table_id = $Data['table_id'] ;

        $product_id = $Data['product_id'] ;
  
        $tableName = "badge_matchto_object" ;

        $CountStr = $tableName.".badge_matchto_object_id" ;

        $WhereStr = $tableName.".holder_object_table_id={$table_id} AND ".$tableName.".holder_object_id={$product_id}" ;

        $joinStr = "" ;

        $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr) ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_Matchobject() ;

        $result_ar = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        if($result_ar){

            $CountStr = "badge.badge_id" ;

            $tableName = "badge" ;

            $joinStr = "INNER JOIN badge_group ON badge_group.badge_group_id = ".$tableName.".badge_group_id" ;

            $fieldArray = array();
            $fieldArray = $this->getSelectFieldArray_short() ;

            $tableNameGroupType = "badge_group_type" ;
            $tableNamecheckType = "badge_check_type" ;
            $WhereStrGroupType =  "badge_group_type_id" ;
            $WhereStrcheckType = "badge_check_type_id" ;
            $field = "name" ;

            foreach ($result_ar as $index => $row) {

                $badge_id = $result_ar[$index]['badge_matchto_object_badge_id'] ;

                $WhereStr =  "badge.badge_id = {$badge_id}" ; 

                $total_row = $this->getListsTotalRow($CountStr,$tableName,$WhereStr,$joinStr);
                
                $result_ar[$index]["badge_row_array"] = $this->getLists($cur_page="",$per_page=$total_row,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=true)  ;

                $badge_group_type_id = $result_ar[$index]['badge_row_array'][0]['badge_group_group_type_id'] ;

                 $result_ar[$index]['badge_row_array'][0]['group_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrGroupType,$tableNameGroupType,$badge_group_type_id) ;

                $badge_check_type_id = $result_ar[$index]['badge_row_array'][0]['badge_group_check_type_id'] ;

                $result_ar[$index]['badge_row_array'][0]['check_type_name'] = $this->getCheckTypeAndGroupType($field,$WhereStrcheckType,$tableNamecheckType,$badge_check_type_id) ;
   

            }

         }

        $dataResult = $result_ar ;

        return  $dataResult ;

    }

    public function addMathtoForHolder($dbData)
    {

        $ResDataID = $this->checkDataInBadgeAndBadgeGroup($dbData) ; // ckeck table_id same or not same start

        if($dbData["holder_object_table_id"] != $ResDataID[0]["badge_group_table_id"]){

            resdie(array(),"table_id is not match") ;

        } // ckeck table_id same or not same end


        if($ResDataID[0]["badge_group_check_type_id"] == 1){ // check type sigle or not start

             $Data['table_id'] = $dbData['holder_object_table_id'] ;
             $Data['product_id'] = $dbData['holder_object_id']  ;
             $Data['group_id'] = $ResDataID[0]["badge_group_id"]  ;
 
             $this->clearMathtoByGroupForHolder($Data) ;

        } // check type sigle or not end
   
        $tableName="badge_matchto_object" ;

        $local_dbData = $this->makeDbDataForDbTable($dbData,$tableName,array("badge_matchto_object_id","status","create_time","update_time"));

        $local_dbData["status"] = 1;
        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();


        $ResDataID = $this->addData($local_dbData,$tableName) ;

        if(!$ResDataID){

            resdie(array(),"! sumthing error in add process") ;

        }

        return $ResDataID ;

    }

    public function subMathtoForHolder($dbData)
    {

        $badge_id = $dbData['badge_id'] ;
        $table_id = $dbData['holder_object_table_id']  ;
        $project_id = $dbData['holder_object_id']  ;

        $tableName = "badge_matchto_object" ;

        $WhereStr = array('badge_id' => $badge_id , 'holder_object_table_id' => $table_id , 'holder_object_id' => $project_id );

        return $this->deleteData($tableName,$WhereStr) ;

    }

    public function clearMathtoByGroupForHolder($Data)
    {

        $table_id = $Data['table_id'] ;
        $product_id = $Data['product_id'] ;
        $group_id = $Data['group_id'] ;

        $tableName = "badge_matchto_object" ;

        $joinStr = "INNER JOIN badge ON badge.badge_id = badge_matchto_object.badge_id " ;

        $WhereStr = "badge_matchto_object.holder_object_table_id = {$table_id}
                    AND badge.badge_group_id = {$group_id}
                    AND badge_matchto_object.holder_object_id = {$product_id}" ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_Matchobject() ;

        $ResDataID = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

         if($ResDataID){

                $badge_matchto_object_id = $ResDataID[0]['badge_matchto_object_matchto_object_id'] ;

                $WhereStr = array("badge_matchto_object_id" => $badge_matchto_object_id) ;

                $ResData = $this->deleteData($tableName,$WhereStr) ;

                return $ResData ;

        }



    }

    public function clearMathtoForHolder($Data_array)
    {

        $table_id = $Data_array['table_id'] ;
        $product_id = $Data_array['product_id'] ;

        $tableName = "badge_matchto_object" ;

        $joinStr = "INNER JOIN badge ON badge.badge_id = badge_matchto_object.badge_id " ;

        $WhereStr = "badge_matchto_object.holder_object_table_id = {$table_id}
                    AND badge_matchto_object.holder_object_id = {$product_id}" ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_Matchobject() ;

        $ResDataID = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        if(!$ResDataID){

            resDie(array(),"data not match") ;

        }

            $badge_matchto_object_id = $ResDataID[0]['badge_matchto_object_matchto_object_id'] ;

            $WhereStr = array("badge_matchto_object_id" => $badge_matchto_object_id) ;

            $ResData = $this->deleteData($tableName,$WhereStr) ;


        return $ResData ;

    }

    public function saveMathtoForHolder($Data_array)
    {

        $table_id = $Data_array['table_id'] ;
        $product_id = $Data_array['product_id'] ;

        $tableName = "badge_matchto_object" ;

        foreach ($Data_array['badge_id_json'] as $index => $value) {

                $WhereStr = array("holder_object_table_id" => $table_id,"holder_object_id" => $product_id , "badge_id" => $value) ;

                $ResData = $this->deleteData($tableName,$WhereStr) ;

        }

        return $ResData ;

    }

    public function addGroup($dbData){

        $tableName="badge_group" ;

        $dbData['table_id'] = $this->checkDataTableId($dbData['table_id'],$enable=true) ;

        $local_dbData = $this->makeDbDataForDbTable($dbData,$tableName,array("badge_group_id","create_time","update_time"));

        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();

        $this->checknumGroupAndType($local_dbData) ;

        $ResDataID = $this->addData($local_dbData,$tableName) ;

        if(!$ResDataID){

            resdie(array(),"! sumthing error in addgroup process") ;

        }

        return $ResDataID ;

    }

    public function editGroup($dbData,$DataID){


        $tableName="badge_group" ;

        $dbData['table_id'] = $this->checkDataTableId($dbData['table_id'],$enable=true) ;

        $local_dbData = $this->makeDbDataForDbTable($dbData,$tableName,array("badge_group_id","create_time","update_time"));
        $local_dbData["update_time"] = time();

        $this->checknumGroupAndType($local_dbData) ;

        $WhereStr = " WHERE ".$tableName.".badge_group_id = ? " ;

        $param_array = array($DataID) ;

        $ResDataID = $this->editData($local_dbData,$tableName,$WhereStr,$param_array) ;

        return $ResDataID ;


    }

    public function deleteGroup($DataID_array)
    {

        $tableName = "badge_group" ;

        $success = 0 ;

        $fail = 0 ;

        foreach ($DataID_array as $index => $data) {
            
            $badge_group_id = $data['badge_group_id'] ;

            $WhereStr = array("badge_group_id" => $badge_group_id) ;

            $ResData = $this->deleteData($tableName,$WhereStr) ;

            if($ResData){

                $success++ ;

            }else{

                $fail++ ;

            }
            
        }

        $dataResult['success'] = $success ; 

        $dataResult['fail'] = $fail ; 

        return $dataResult ;


    }

    public function add($dbData)
    {

        $tableName="badge" ;

        $local_dbData = $this->makeDbDataForDbTable($dbData,$tableName,array("badge_id","create_time","update_time"));

        $local_dbData["create_time"] = time();
        $local_dbData["update_time"] = time();

        $ResDataID = $this->addData($local_dbData,$tableName) ;

        if(!$ResDataID){

            resdie(array(),"! sumthing error in add process") ;

        }

        return $ResDataID ;

    }

    public function edit($dbData,$DataID){


        $tableName="badge" ;

         $local_dbData = $this->makeDbDataForDbTable($dbData,$tableName,array("badge_id","create_time","update_time"));
        $local_dbData["update_time"] = time();

        $WhereStr = " WHERE ".$tableName.".badge_id = ? " ;

        $param_array = array($DataID) ;

        $ResDataID = $this->editData($local_dbData,$tableName,$WhereStr,$param_array) ;

        return $ResDataID ;


    }


    public function delete($DataID_array)
    {

     $tableName = "badge" ;

        $success = 0 ;

        $fail = 0 ;

        foreach ($DataID_array as $index => $data) {
            
            $badge_id = $data['badge_id'] ;

            $WhereStr = array("badge_id" => $badge_id) ;

            $ResData = $this->deleteData($tableName,$WhereStr) ;

            if($ResData){

                $success++ ;

            }else{

                $fail++ ;

            }
            
        }

        $dataResult['success'] = $success ; 

        $dataResult['fail'] = $fail ; 

        return $dataResult ;

    }

  public function getdataBadgeGroupByID($DataID)
    {

          $tableName = "badge_group" ;

          $WhereStr = $tableName.".badge_group_id = {$DataID}" ;

          $joinStr = "" ;

         $fieldArray = array();
         $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

         $dataResult = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

         return $dataResult ;  


    }

    public function getdataBadgeByID($DataID,$tableName="")
    {

          $tableName = "badge" ;

          $WhereStr = $tableName.".badge_id = {$DataID}" ;

          $joinStr = "" ;

         $fieldArray = array();
         $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());

         $dataResult = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

         return $dataResult ;  

    }


    public function getListsTotalRow($CountStr="",$tableName,$WhereStr="",$joinStr=""){

        if(!$tableName){

             resDie(array(),"required table name") ;

        }

        $sql = " 
            SELECT
                 COUNT( DISTINCT ".$CountStr.") as count 
            FROM 
                ".$tableName."
                ".$joinStr."
            WHERE
            "
            .$WhereStr ;

        $result_ar = $this->db->query($sql)->result_array();
        return intval(@$result_ar[0]["count"]);

      // return $sql ;


    }

    public function getLists($cur_page,$per_page,$tableName,$fieldArray,$WhereStr="",$sortBy_id="",$joinStr="",$extend_field){

        $fieldArray = array_merge($fieldArray, $fieldArray);
        if($extend_field){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_extend());
        }


        if(!$tableName){

             resDie(array(),"required table name") ;

        }

        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                ".$tableName."
                ".$joinStr."
            WHERE
            "
            .$WhereStr
            .$orderAndLimit_str;

        $result_ar = $this->db->query($sql)->result_array();

        return $result_ar ;
    }

    public function getHolder($DataID){


        $tableName = "badge_matchto_object" ;

        $WhereStr = $tableName.".badge_matchto_object_id={$DataID}" ;

        $joinStr = "INNER JOIN badge ON badge.badge_id = badge_matchto_object.badge_id
                    INNER JOIN badge_group ON badge_group.badge_group_id = badge.badge_group_id
                       " ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_short();
        $result_ar = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=true) ;

        return $result_ar ;  

    }

  
    /* << BASIC FUNCTION : END >> */


     //MORE FUNCTOIN

    private function addData($local_dbData,$tableName)
    {

        $ResDataID = $this->insertToTable($tableName,$local_dbData);

        return $ResDataID;

    }

    private function editData($local_dbData,$tableName,$WhereStr,$param_array)
    {

        $ResDataID = $this->updateToTable($tableName,$local_dbData,$WhereStr,$param_array);

        return $ResDataID;

    }

    private function deleteData($tableName,$WhereStr)
    {

        if($this->db->delete($tableName,$WhereStr)){

           $ResData = true ;

        }else{

           $ResData = false ;

        }

        return $ResData ;

    }

    private function checknumGroupAndType($num)
    {

        if(!in_array($num['badge_group_type_id'], array(1,2))){
            resDie("badge_group is avaliable for 1,2");
        }else if(!in_array($num['badge_check_type_id'], array(1,2))){
            resDie("badge_check is avaliable for 1,2");
        }

    }

    private function getCheckTypeAndGroupType($field,$WhereStr,$tableName,$DataID)
    {


            $result = $this->checkRowArray($field,$WhereStr,$tableName,$DataID) ;

            return $result['name'] ;

    }

    private function checkTableId($dbData)
    {

            $field = "badge_matchto_object_id" ;

            $WhereStr = "" ;

            $result = $this->checkRowArray($field,$WhereStr,$tableName,$DataID) ;

            return $result['table_id'] ;

    }

    private function checkDataTableId($Data,$enable)
    {

        if($Data == "" AND $enable == true){

            $Data = $this->getTableId();

        }

        return $Data ;

    }

    private function checkDataInBadgeAndBadgeGroup($dbData){

        $DataID = $dbData['badge_id'] ;

        $joinStr = "INNER JOIN badge_group ON badge_group.badge_group_id = badge.badge_group_id" ;

        $tableName = "badge" ;

        $WhereStr = "badge.badge_id = {$DataID}" ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_short() ;

        $ResDataID = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        return $ResDataID ;

    }

    private function checkDataInBadgeMatchToObject($dbData){

        $badge_id = $dbData['badge_id'] ;
        $table_id = $dbData['holder_object_table_id'] ;
        $product_id = $dbData['holder_object_id']  ;

        $joinStr = "" ;

        $tableName = "badge_matchto_object" ;

        $WhereStr = "badge_matchto_object.badge_id = {$badge_id} 
                     AND badge_matchto_object.holder_object_table_id = {$table_id} 
                     AND badge_matchto_object.holder_object_id = {$product_id}" ;

        $fieldArray = array();
        $fieldArray = $this->getSelectFieldArray_Matchobject() ;

        $ResDataID = $this->getLists($cur_page="",$per_page=1,$tableName,$fieldArray,$WhereStr,$sortBy_id="",$joinStr,$extend_field=false) ;

        return $ResDataID ;

    }

    private function checkRowArray($field,$WhereStr,$tableName,$DataID)
    {

            $result = $this->db->select($field)
                               ->Where($WhereStr, $DataID)
                               ->get($tableName) 
                               ->row_array() ;

            if(!$result){                  

                return false ;

            }

            return $result ;

    }

}

?>