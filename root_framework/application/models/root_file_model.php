<?

class root_file_model extends root_model {

    public $current_server_id = "1";
    public $protocal = "http://";

	public function __construct()
    {
        parent::__construct();
        $this->startByCollection("file");
    }

    public function getRootFilesPathName(){
        return 'root_files/';
    }

    public function getRootFilesPathStr($server_id){
        return root_APPPATH().$this->getRootFilesPathName();
    }

    public function generateDirPath($newFileId){
        $id_str = trim($newFileId);

        $dir_str = "";
        $loopDir = 3;
        $maxForDir = 3;
        $totalLength = $loopDir*$maxForDir;

        $id_str_len = strlen($id_str);
        if($id_str_len<$totalLength){
            $loopAdd_number = $totalLength-$id_str_len;
            for($i=0;$i<$loopAdd_number;$i++){
                $id_str = "0".$id_str;
            }
        }

        $newDir_str = "";
        $count=0;
        do{
            $startIndex = $totalLength-(($count+1)*$maxForDir);
            $getNumber = $maxForDir;
            $uPath = substr($id_str,$startIndex,$getNumber);
            if($count==0){
                $newDir_str = $count.$uPath; 
            }else{
                $newDir_str = $count.$uPath."/".$newDir_str;
            }
            $count++;
        }while($startIndex>0);

        return $newDir_str."/";
    }

    protected function getSelectFieldArray_veryShort(){
        $field["file_id"] = "file.file_id";
        $field["file_name"] = "file.file_name";
        $field["file_url"] = "CONCAT('".$this->protocal."',server.full_url,'".$this->getRootFilesPathName()."',file.file_dir, file.file_name)";
        $field["file_create_time"] = "file.create_time";
        return $field;
    }

    protected function getSelectFieldArray_short(){
        $field = $this->getSelectFieldArray_veryShort();
        $field["file_purename"] = "file.file_purename";
        $field["file_ext"] = "file.file_ext";
        $field["file_size"] = "file.file_size";
        $field["file_dir"] = "file.file_dir";
        $field["file_update_time"] = "file.update_time";
        return $field;
    }

    protected function getSelectFieldStr_extend(){
        $field["file_description"] = "file.description";
        $field["file_server_id"] = "file.server_id";
        return $field;
    }

    public function getId($item_id,$is_full_data=true){

        $result = $this->getFileDataById($item_id,$is_full_data);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getFileDataById($image_id,$is_full_data=true){
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($is_full_data==true){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldStr_extend());
        }

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                file
                    LEFT JOIN server ON ( server.server_id = file.server_id )
            WHERE
                file.file_id = ?
                AND file.status > 0
            LIMIT 
                0,1
            ";
        $param_ar = array($image_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        if(@$result_ar[0]["file_id"]==""){
            return false;
        }
        return $result_ar[0];
    }

    public function getImageShortDataById($image_id){
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                image
                    LEFT JOIN server ON ( server.server_id = image.server_id )
            WHERE
                image.image_id = ?
                AND image.status > 0
            LIMIT 
                0,1
            ";
        $param_ar = array($image_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        if(@$result_ar[0]["image_id"]==""){
            return false;
        }
        $result_ar[0]["image_crop_rect_data"] = json_decode(@$result_ar[0]["image_crop_rect_data"],true);
        $result_ar[0]["image_size_using"] = json_decode(@$result_ar[0]["image_size_using"],true);
        return $result_ar[0];
    }

    public function upload($inputFileName="",$maxNumber=-1){
        return $this->uploadWithData($inputFileName,array(),$maxNumber);
    }

    public function uploadWithData($inputFileName="",$inputfileData=array(), $maxNumber=-1){
        
        $uploadedFilesData = $this->start_uploadFiles($inputFileName,$maxNumber);
        $this->updateDataAfterUploaded($uploadedFilesData,$inputfileData);
        return $this->dbDataForUploadedFilesData($uploadedFilesData);
    }

    protected function getUploadSuccessIdArray($uploadedFilesData){
        $fileId_array = array();
        $successFiles = @$uploadedFilesData["successFiles"];
        if(is_array($successFiles)&&(sizeof($successFiles)>0)){
            foreach ($uploadedFilesData["successFiles"] as $key => $value) {
                if($value["db_file_id"]!=""){
                    array_push($fileId_array, $value["db_file_id"]);
                }
            }
        }
        return $fileId_array;
    }

    protected function dbDataForUploadedFilesData($uploadedFilesData){

        $successArray = $this->getUploadSuccessIdArray($uploadedFilesData);
        if(sizeof($successArray)<=0){
            return $uploadedFilesData;
        }
        $whereIn_str = join(',',$successArray);
        $getNumber = sizeof($successArray);

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());

        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray)."
            FROM 
                file
                    LEFT JOIN server ON ( server.server_id = file.server_id )
            WHERE
                file.file_id IN ($whereIn_str) 
            LIMIT 
                0, $getNumber
            ";

        $param_ar = array();
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        $uploadedFilesData["successFiles"] = $result_ar;
        return $uploadedFilesData;
    }
   

    protected function start_uploadFiles($inputFileName,$maxNumber=-1){

        $max_fileSizeAllowKB = 5000;

        $this->load->library('upload');
        $fileArray  = $this->upload->getFileInputArray($inputFileName,$maxNumber);
        if(@$_FILES[$inputFileName]==""){
            $returnData["warning"] = "no-file";
            $returnData["successFiles"] = array();
            return $returnData;
        }
        $filesBuffer = @$_FILES[$inputFileName];

    
        $successData = array();
        $errorsData = array();
        foreach($fileArray as $index => $fileData){

            $config = array();
            $config['allowed_types'] = 'gif|jpg|png|pdf|zip|rar|svg|rtf';
            $config['max_size'] =  $max_fileSizeAllowKB;

            $validFileData = $this->upload->getValidateFileData($fileData,$config);
            $is_upload_complete = false;
            if($this->upload->is_validfile($validFileData)){
                
                $newFileId = $this->getNewFileId($fileData);
                $dirImage = $this->generateDirPath($newFileId);
                $full_dirImage = $this->getRootFilesPathStr($this->current_server_id).$dirImage;
                $this->upload->makeDir($full_dirImage);

                $new_origin_name = $newFileId."t".time();
                $config['file_name'] = $new_origin_name;
                $config['upload_path'] = $full_dirImage;

                $_FILES[$inputFileName]['name']= $fileData['name'];
                $_FILES[$inputFileName]['type']= $fileData['type'];
                $_FILES[$inputFileName]['tmp_name']= $fileData['tmp_name'];
                $_FILES[$inputFileName]['error']= $fileData['error'];
                $_FILES[$inputFileName]['size']= $fileData['size']; 

                $this->upload->initialize($config);
                if (!$this->upload->do_upload($inputFileName))
                {
                    $is_upload_complete = false;
                }
                else
                {
                    $is_upload_complete = true;
                }
                
            }
            if($is_upload_complete==true){
                $fileData_success = $this->upload->data();
                $success_file_path = $fileData_success["full_path"];

                $fileData_success["new_origin_name"] = $new_origin_name;
                $fileData_success["file_dir"] = $dirImage;
                $fileData_success["file_size_byte"] = intval($fileData['size']);
                $fileData_success["db_file_id"] = $newFileId;
                $fileData_success["db_file_purename"] = $new_origin_name;

                array_push($successData,$fileData_success);
            }else{
                $error["client_name"] = $_FILES[$inputFileName]['name'];
                $error["file_size"] =  round((@intval($_FILES[$inputFileName]['size'])/1024),2);
                if(@$validFileData["msg"]!=""){
                    $error_msg = @$validFileData["msg"];
                }else{
                    $error_msg = strip_tags($this->upload->display_errors());
                    $this->removeMultiRow("file_id",array($newFileId));
                    $this->recurseRemoveDir($full_dirImage);
                }
                $error["error_msg"] = $error_msg;
                array_push($errorsData,$error);
            }
        }

        $_FILES[$inputFileName] = $filesBuffer;
        
        $returnData["count"] = sizeof($fileArray);
        $returnData["success"] = sizeof($successData);
        $returnData["errors"] = sizeof($errorsData);
        $returnData["successFiles"] = $successData;
        $returnData["errorsFiles"] = $errorsData;
        return $returnData;
    }

     private function updateDataAfterUploaded($uploadFilesData,$inputfileData=array()){
        if(empty($uploadFilesData["successFiles"])){
            return;
        }
        $successFiles = $uploadFilesData["successFiles"];
        if((!is_array($successFiles))&&(sizeof($successFiles)<=0)){
            return;
        }
        foreach ($successFiles as $key => $value) {
            if(@$value["db_file_id"]!=""){
                $updateData = array();
                $updateData["file_name"] = $value["file_name"];
                $updateData["file_dir"] = $value["file_name"];
                $updateData["file_ext"] = $value["file_ext"];
                $updateData["file_dir"] = $value["file_dir"];
                $updateData["file_type"] = $value["file_type"];
                $updateData["file_purename"] = $value["db_file_purename"];

                if(is_array($inputfileData)&&(sizeof($inputfileData)>0)){
                    foreach ($inputfileData as $ipf_key => $ipf_value) {
                        $updateData[$ipf_key] = $ipf_value;
                    }
                }
                $this->updateDataById($value["db_file_id"],$updateData);
            }
        }
        
    }

    private function getNewFileId($fileData){
        $insertData = array(
                "file_id"=>"",
                "server_id"=>$this->current_server_id,
                "title"=>$fileData["name"],
                "file_size"=>$fileData["size"],
                "status"=>0,
                "create_time"=>time(),
                "update_time"=>time(),
                "ip_address"=>$this->input->ip_address(),
            );
        
        $newFileId = $this->insert($insertData);
        if(!$newFileId){
            $error = array("error"=>"Cannot insert new file to database!");
            resDie($error,$this->methodPlace());
            exit();
        }
        return $newFileId;
    }

    public  function recurseRemoveDir($dir) {
      $files = @array_diff(scandir($dir), array('.','..'));
      if(is_array($files)&&(sizeof($files)>0)){
          foreach ($files as $file) {
            (is_dir("$dir/$file")) ? recurseRemoveDir("$dir/$file") : unlink("$dir/$file");
          }
      }
      if(file_exists($dir)){
        return @rmdir($dir);
      }
      return false;
    }

    public function updateDataById($newFileId,$updateData){
        return $this->update($updateData," WHERE file_id = ? ",array($newFileId));
    }


    // FILE RELATION
    public function addFileToObject($file_id,$object_table_id,$object_id,$relation_index="",$relation_key=""){

        $insertData = array(
                "file_id"=>$file_id,
                "holder_object_table_id"=>$object_table_id,
                "holder_object_id"=>$object_id,
                "key"=>$relation_key,
                "index"=>$relation_index,
                "create_time"=>time(),
                "update_time"=>time()
            );

        $newRelation_id = $this->insertToTable("file_to_object",$insertData);
        if(!$newRelation_id){
            return false;
        }
        return $newRelation_id;
    }

    public function cleanFileRelationByKey($object_table_id,$object_id,$relation_index="",$relation_key=""){

        $where_str = " 
        WHERE
             file_to_object.holder_object_table_id = ? 
             AND file_to_object.holder_object_id = ?
             AND file_to_object.key = ?
             AND file_to_object.index = ?
        ";
        $param_ar = array($object_table_id,$object_id,$relation_key,$relation_index);
        return $this->deleteToTable("file_to_object",$where_str, $param_ar); 
    }

    public function getImageSvgByHolder($object_table_id,$object_id,$relation_key=""){

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_veryShort());
        
        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray).",
                file_to_object.key AS file_key,
                file_to_object.index AS file_index
            FROM 
                file_to_object
                    INNER JOIN file ON ( file.file_id = file_to_object.file_id )
                    INNER JOIN server ON ( server.server_id = file.server_id )
            WHERE
                file_to_object.holder_object_table_id = ?
                AND file_to_object.holder_object_id = ?
            ORDER BY 
                file_to_object.index ASC
            ";
        $param_ar = array($object_table_id,$object_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        if(@$result_ar[0]["file_id"]==""){
            return array();
        }
        return $result_ar;
    }


}