<?

class root_imagegallery_model extends root_model {

	  public function __construct()
    {
        parent::__construct();
        $this->startByCollection("imagegallery");
    }

    public function getSortby(){

        $sortData = array(
           
            array(
              "id"=>"imagegallery_lastest_create",
              "label"=>"lastest",
              "value"=>"imagegallery.create_time DESC",
              "default"=>1
            ),
             array(
              "id"=>"imagegallery_oldest_create",
              "label"=>"oldest",
              "value"=>"imagegallery.create_time ASC",
              "default"=>0
            ),
            array(
              "id"=>"imagegallery_title_a-z",
              "label"=>"name_A-Z",
              "value"=>"imagegallery.title ASC",
              "default"=>0
            ),
            array(
              "id"=>"imagegallery_title_z-a",
              "label"=>"name_Z-A",
              "value"=>"imagegallery.title DESC",
              "default"=>0
            )
        );
        return $sortData;
    }

    protected function getSelectFieldArray_short(){
        $field["imagegallery_id"] = "imagegallery.imagegallery_id";
        $field["imagegallery_name"] = "imagegallery.name";
        $field["imagegallery_title"] = "imagegallery.title";
        $field["imagegallery_create_time"] = "imagegallery.create_time";
        $field["imagegallery_update_time"] = "imagegallery.update_time";
        return $field;
    }

    protected function getSelectFieldStr_extend(){
        $field["imagegallery_description"] = "imagegallery.description";
        return $field;
    }

    public function getListsTotalRow($WhereStr,$input_paramAr){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }
        $sql = " 
            SELECT
                 COUNT( DISTINCT imagegallery.imagegallery_id ) as count 
            FROM 
                imagegallery
            WHERE
                imagegallery.status > 0
            "
            .$WhereStr;
        $param_ar = array();
        $param_ar = array_merge($input_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return intval(@$result_ar[0]["count"]);

    }

    public function getLists($WhereStr,$input_paramAr,$cur_page,$per_page,$sortBy_id=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }
        $orderAndLimit_str = $this->getPageNavSql($cur_page,$per_page,$sortBy_id);
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                imagegallery
            WHERE
                imagegallery.status > 0
            "
            .$WhereStr
            .$orderAndLimit_str;

        $param_ar = array();
        $param_ar = array_merge($input_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return $result_ar;
    }

    public function getId($item_id){

        $result = $this->getDataById($item_id);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }

    public function getDataById($item_id){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldStr_extend());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                imagegallery
            WHERE
                imagegallery.status > 0
                AND imagegallery.imagegallery_id = ?
            LIMIT 
                0,1
            ";
        $param_ar = array($item_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["imagegallery_id"]==""){
            return false;
        }
        return $result_ar[0];

    }

    public function add($dbData){

        $fieldAllow = array(
            "name",
            "title",
            "description",
            );
        $dbData = $this->getValidFieldAllow($fieldAllow,$dbData);
        $dbData["status"] = 1;
        $dbData["create_time"] = time();
        $dbData["update_time"] = time();

        $gallery_id = $this->insert($dbData);
        if(!$gallery_id){
          resDie("cannot-insert!");
        }
        return $gallery_id;
    }

    public function edit($dbData,$item_id){
        $fieldAllow = array(
            "name",
            "title",
            "description",
            );
        $dbData = $this->getValidFieldAllow($fieldAllow,$dbData);
        $result = $this->updateDataById($dbData,$item_id);

        if(!$result){
            resDie(array(),"data-update-not-found");
        }
        $imageData = $this->getId($item_id);
        return $imageData;
    }

    protected function updateDataById($updateData,$item_id){
    
        $updateData["update_time"] = time();
        return $this->update($updateData," WHERE imagegallery_id = ? ",array($item_id));
    }


    public function delete($deleteIdArray=array()){

        if(!(is_array($deleteIdArray)&&(sizeof($deleteIdArray)>0))){
            resDie(array(),"delete-is-not-array");
        }

        $idArray = array();
        foreach ($deleteIdArray as $index => $row) {
            if(is_numeric(@$row["imagegallery_id"])){
               if(!in_array(@$row["imagegallery_id"],$idArray)){
                    array_push($idArray,@$row["imagegallery_id"]);
               }
            }
        }

        $deleteDataArray = array();
        $success_count = 0;
        if(sizeof($idArray)>0){
            foreach ($idArray as $index => $value) {
                $deleteRow = array();
                $deleteRow["imagegallery_id"] = $value;
                if($value==0){
                    $deleteRow["result"] = 0;
                }else{
                    if($this->getDataById($value)){
                        $result =$this->updateDataById(array("status"=>0),$value);
                        $this->makeImageInGalleryIdDelete($value);
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

    protected function makeImageInGalleryIdDelete($imagegallery_id){

        $imageDbData = array();
        $imageDbData["status"] = 0;
        $imageDbData["update_time"] = time();
        $this->updateToTable("image",$imageDbData,"WHERE image.imagegallery_id = ? ",array($imagegallery_id));

    }


}