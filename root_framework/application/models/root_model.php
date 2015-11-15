<?

class root_model extends CI_Model {

    public $collection_name = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLangId(){
        return 0;
    }

    public function getTableNameById($item_id){

        $sql = " 
            SELECT
                table.table_id AS table_id,
                table.table_name AS table_name
            FROM 
                table
            WHERE
                table.table_id = ?
            LIMIT 
                0,1
            ";
        $param_ar = array($item_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["table_id"]==""){
            resDie(array(),"Table not found : id : ".$table_id);
        }
        return $result_ar[0]["table_name"];
    }

    public function startByCollection($collection_name){    
        $this->collection_name = $collection_name;    
    }

    public function getSortbyId($sortby_id=""){
    
        $sortbyArray = $this->getSortby();
        foreach ($sortbyArray as $index => $row) {
          if($row["id"]==trim($sortby_id)){
            return $row["id"];
          }
        }
   
        foreach ($sortbyArray as $index => $row) {
          if($row["default"]==1){     
              return $row["id"];
          }
        }
        return "";
    }

    public function getSortbyStr($sortby_id=""){

        $sortbyValue = "";
        $sortbyArray = $this->getSortby();
        foreach ($sortbyArray as $index => $row) {
          if($row["id"]==@trim($sortby_id)){
            $sortbyValue = $row["value"];
          }
        }

        if($sortbyValue==""){
            foreach ($sortbyArray as $index => $row) {
              if($row["default"]==1){
                  $sortbyValue = $row["value"];
              }
            }
        }
        return $sortbyValue;
    }

    public function getPageNavSql($cur_page,$per_page,$sortBy_id=""){


        $cur_page = intval($cur_page);
        $per_page = intval($per_page);

        $orderBy_str = "";
        if($sortBy_id!=""){
            $sortBy_str = $this->getSortbyStr($sortBy_id);
            $orderBy_str = " ORDER BY ".$sortBy_str." ";
        }

        $limitStr = "";
        $real_curPage = ($cur_page-1);
        if($real_curPage<0){
            $real_curPage=0;   
        }
        
        //limit get
        if($per_page<0){
         $per_page = 0;   
        }
        if($per_page>100){
         $per_page = 100;   
        }
        
        $start_num = ($real_curPage*$per_page);
        $limitStr = " LIMIT ".$start_num.", ".$per_page." ";
        
        return $orderBy_str.$limitStr;
    }
    
    public function getValidFieldAllow($filedAllow,$inputData){

        $dbData =array();
        foreach ($filedAllow as $index => $value) {
            if(@$value!=""){
                $dbData[$value] = @$inputData[$value];
            }
        }
        return $dbData;
    }


    public function countSql($sql_str,$param_ar=array()){
        $sql = '';
        
        $haveParam = false;
        if($sql_str!=""){
            $sql = $sql_str;
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $haveParam = true;   
            }
        }
       
        if($haveParam==true){
            $result = $this->db->query($sql,$param_ar);
        }else{
            $result = $this->db->query($sql);
        }
        
        if(!$result){
            echo "<br>ERROR : countFrom() : Can not count this sql : ".$sql;
            exit();
        }
    
        return $result->result_array();    
    }
    
    public function countFrom($from_str,$param_ar=array()){
        $sql = 'SELECT COUNT(*) AS count ';
        
        $haveParam = false;
        if($from_str!=""){
            $sql .= $from_str;
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $haveParam = true;   
            }
        }
       
        
        if($haveParam==true){
            $result = $this->db->query($sql,$param_ar);
        }else{
            $result = $this->db->query($sql);
        }
        
        if(!$result){
            echo "<br>ERROR : countFrom() : Can not count this sql : ".$sql;
            exit();
        }
    
        $resultPrint = $result->result_array();
        
        return $resultPrint[0]["count"];       
    }
        
    public function count($where_str="",$param_ar=array()){
        
        $sql = 'SELECT COUNT(*) AS count FROM '.$this->collection_name." ";
        
        $haveParam = false;
        if($where_str!=""){
            $sql .= $where_str;
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $haveParam = true;   
            }
        }
       
       
        if($haveParam==true){
             $result = $this->db->query($sql,$param_ar);
        }else{
             $result = $this->db->query($sql);
        }
        
        if(!$result){
            echo "<br>ERROR : count() : Can not count this sql : ".$sql;
            exit();
        }
    
        $resultPrint = $result->result_array();
        
        return $resultPrint[0]["count"];     
    }
    
    public function getFields($tableName=""){
        if($tableName==""){
            $tableName = $this->collection_name;
        }
        
        $sql ="SHOW COLUMNS FROM ".$tableName;
        $result = $this->db->query($sql);
        
        if(!$result){
            echo "<br>Cannot get field from this collection : ".$this->collection_name; 
            exit();
        }
        
        $resultPRINT = $result->result_array();
        
        $data_ar = array();
        foreach($resultPRINT as $key => $row){
            $data_ar[$row["Field"]] = "";
        }
        return $data_ar;   
              
    }
    
    public function selectOne($select_ar,$where_str="",$param_ar=array()){
        $where_str .= " LIMIT 0, 1 ";
        $result = $this->select($select_ar,$where_str,$param_ar); 
        if(!$result){
            return false;
        }else{
           return $result[0];
        }
    }
    
    public function selectDistinct($select_ar,$where_str="",$param_ar=array()){
        
        $sql = "SELECT  DISTINCT ";
        $count = 0;
        if(!is_array($select_ar)){
            if(trim($select_ar)=="*"){
                $sql .=" * ";
            }
        }else{
            foreach($select_ar as $key => $value){

                if($count==0){
                    $count++;  
                    $sql .= $value;
                }else{
                    $sql .=", ".$value;
                }
            }
        }
        $sql .= " FROM ".$this->collection_name." ";
            
        $haveParam = false;
        if(@$where_str!=""){
            $sql .= $where_str;   
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $param_select = $param_ar; 
                $haveParam = true;
            }
        }
        
            
        if($haveParam==true){
             $result = $this->db->query($sql,$param_ar);
        }else{
             $result = $this->db->query($sql);
        }
            
        if(!$result){
            //echo "<br>Select not complete : ";
            return false;
        }
        
        return $result->result_array(); 
    }
    
    public function select($select_ar,$where_str="",$param_ar=array()){
        
        $sql = "SELECT ";
        $count = 0;
        if(!is_array($select_ar)){
            if(trim($select_ar)=="*"){
                $sql .=" * ";
            }
        }else{
            foreach($select_ar as $key => $value){

                if($count==0){
                    $count++;  
                    $sql .= $value;
                }else{
                    $sql .=", ".$value;
                }
            }
        }
        $sql .= " FROM ".$this->collection_name." ";
            
        $haveParam = false;
        if(@$where_str!=""){
            $sql .= $where_str;   
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $param_select = $param_ar; 
                $haveParam = true;
            }
        }
        
        if($haveParam==true){
             $result = $this->db->query($sql,$param_ar);
        }else{
             $result = $this->db->query($sql);
        }
            
        if(!$result){
            //echo "<br>Select not complete : ";
            return false;
        }
        
        return $result->result_array(); 
    }
    
    public function safeQuery($sql,$param_ar=array()){
        
        $result = $this->db->query($sql,$param_ar);
        if(!$result){
            //echo "<br>Select not complete : ";
            return false;
        }
        return $result->result_array(); 
        
    }
    
    public function insert($insert_ar,$default_value=""){
        
        /*
        $fr_ar = $this->getFields();
        $param_insert_ar = array();
        foreach($fr_ar as $key => $value){  
            if(@$insert_ar[$key]==""){
                $param_insert_ar[$key] = $default_value;
                //array_push($param_insert_ar,$default_value);
            }else{
                $param_insert_ar[$key] = $insert_ar[$key];
                //array_push($param_insert_ar,$insert_ar[$key]);
            }
        }
        */
        
       if(!$this->db->insert($this->collection_name, $insert_ar)){
         return false;   
       }
       return $this->db->insert_id(); 
        
    }
    
    public function insertToTable($tableName,$insert_ar,$default_value=""){ 
        
        $fr_ar = $this->getFields($tableName);
      
        $param_insert_ar = array();
        foreach($fr_ar as $key => $value){
            
            if(@$insert_ar[$key]==""){
                array_push($param_insert_ar,$default_value);
            }else{
                array_push($param_insert_ar,$insert_ar[$key]);
            }
        }    
        
       if(!$this->db->insert($tableName, $insert_ar)){
         return false;   
       }
       return $this->db->insert_id(); 
        
    }
    
    
    public function update($update_ar,$where_str="",$param_ar= array()){
        
        $sql = "UPDATE ".$this->collection_name." ";

        $count = 0;
        $param_update_ar = array();
        foreach($update_ar as $key => $value){
            if($count==0){
                $count++;
                 $sql .= " SET ".$key." = ? ";
            }else{
                 $sql .= ", ".$key." = ? ";
            }
            array_push($param_update_ar,$value);
        }
        
        $haveParam = false;
        if(@$where_str!=""){
            $sql .= $where_str;
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $haveParam = true;
                foreach($param_ar as $key => $value){
                    array_push($param_update_ar,$value);
                }
            }
        }
        
        if($haveParam==true){
            $result = $this->db->query($sql,$param_update_ar);
        }else{
            $result = $this->db->query($sql);
        }
        
        //var_dump($result);
        if(!$result){
            return false;
        }
        return true;
        
    }
    
    public function updateToTable($tableName,$update_ar,$where_str="",$param_ar= array()){
        
        $sql = " UPDATE ".$tableName." ";

        $count = 0;
        $param_update_ar = array();
        foreach($update_ar as $key => $value){
            if($count==0){
                $count++;
                 $sql .= " SET ".$key." = ? ";
            }else{
                 $sql .= ", ".$key." = ? ";
            }
            array_push($param_update_ar,$value);
        }
        
        $haveParam = false;
        if(@$where_str!=""){
            $sql .= $where_str;
            if(is_array($param_ar)&&(sizeof($param_ar)>0)){
                $haveParam = true;
                foreach($param_ar as $key => $value){
                    array_push($param_update_ar,$value);
                }
            }
        }
        
        if($haveParam==true){
            $result = $this->db->query($sql,$param_update_ar);
        }else{
            $result = $this->db->query($sql);
        }
        
        //var_dump($result);
        if(!$result){
            return false;
        }
        return true;
        
    }
    
    public function delete($where_str,$param_ar){
      
        return $this->deleteToTable($this->collection_name,$where_str,$param_ar);
    }

    public function deleteToTable($tableName,$where_str,$param_ar){
        $sql = "DELETE FROM ".$tableName." ";
        $sql .= $where_str;
        
        if(is_array($param_ar)&&(sizeof($param_ar)>0)){
            $result = $this->db->query($sql,$param_ar);
        }else{
            $result = $this->db->query($sql);
        }

        if(!$result){
            return false;
        }
        return true;
    }
    
    public function removeRow($where_str,$param_ar){
        return $this->delete($where_str,$param_ar);
    }

    public function removeMultiRow($fieldName,$dataArray=array()){

        if((@$dataArray=="")||(sizeof($dataArray)<0)){
            return array();
        }
        $success = array();
        $errors = array();
        foreach ($dataArray as $index => $value) {
            $where_str = " WHERE ".$fieldName." = ? ";
            $result =  $this->removeRow($where_str,array($value));
            if($result){
                array_push($success,$value);
            }else{
                array_push($errors,$value);
            }
        }

        $resultData["total"] = sizeof($dataArray);
        $resultData["success"] = $success;
        $resultData["errros"] = $errors;
        return $resultData;
    }

    public function trans_start(){
        $this->db->trans_start();
    }

    public function trans_complete($error_msg=""){
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            resDie(array(),$error_msg);
        }else{
            $this->db->trans_commit();
        }
    }

    public function trans_rollback(){
        $this->db->trans_rollback();
    }

    
    public function db_trans_start(){
        $this->db->trans_start();
    }

    public function db_trans_complete($error_msg=""){
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            resDie(array(),$error_msg);
        }else{
            $this->db->trans_commit();
        }
    }

    public function db_trans_rollback(){
        $this->db->trans_rollback();
    }


    public function getUniqIdArrayForDelete($primary_field,$inputIdArray){

        $idArray = array();
        foreach ($inputIdArray as $index => $row) {
            if(is_numeric(@$row[$primary_field])){
               if(!in_array(@$row[$primary_field],$idArray)){
                    array_push($idArray,@$row[$primary_field]);
               }
            }
        }
        return $idArray;
    }

}

?>