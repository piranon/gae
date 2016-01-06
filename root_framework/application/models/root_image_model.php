<?

class root_image_model extends root_model {

    public $current_server_id = "1";
    public $sizeArray;

    public $protocal = "http://";

    public function __construct()
    {
        parent::__construct();
        $this->startByCollection("image");

        $this->sizeArray = array(
            array("rect","r100_",100),
            array("rect","r200_",200),
            array("rect","r300_",300),
            array("rect","r400_",400),
            array("rect","r600_",600),
            array("rect","r800_",800),
            array("rect","r1000_",900),
            array("thumb","t100_",100,100),
            array("thumb","t200_",200,200),
            array("thumb","t300_",300,300),
            array("thumb","t400_",400,300),
            array("thumb","t600_",600,600),
            array("thumb","t800_",800,800),
            array("thumb","t1000_",900,900),
        );
    }

    public function getSortby(){

        $sortData = array(
           
            array(
              "id"=>"image_lastest_create",
              "label"=>"lastest",
              "value"=>"image.create_time DESC",
              "default"=>1
            ),
             array(
              "id"=>"image_oldest_create",
              "label"=>"oldest",
              "value"=>"image.create_time ASC",
              "default"=>0
            ),
            array(
              "id"=>"image_title_a-z",
              "label"=>"name_A-Z",
              "value"=>"image.title ASC",
              "default"=>0
            ),
            array(
              "id"=>"image_title_z-a",
              "label"=>"name_Z-A",
              "value"=>"image.title DESC",
              "default"=>0
            )
        );
        return $sortData;
    }

    public function getListsTotalRow($WhereStr,$input_paramAr,$joinStr=""){

        if(trim($WhereStr)!=""){
            $WhereStr = " AND ".$WhereStr." ";
        }
        $sql = " 
            SELECT
                 COUNT( DISTINCT image.image_id ) as count 
            FROM 
                image
                    LEFT JOIN server ON ( server.server_id = image.server_id )
                    ".$joinStr."
            WHERE
                image.status > 0
            "
            .$WhereStr;
        $param_ar = array();
        $param_ar = array_merge($input_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return intval(@$result_ar[0]["count"]);

    }

    public function getLists($WhereStr,$input_paramAr,$cur_page,$per_page,$sortBy_id="",$joinStr="",$extend_field=array()){

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
                image
                    LEFT JOIN server ON ( server.server_id = image.server_id )
                    ".$joinStr."
            WHERE
                image.status > 0
            "
            .$WhereStr
            .$orderAndLimit_str;

        $param_ar = array();
        $param_ar = array_merge($input_paramAr);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        return $result_ar;
    }

    public function getSizeUsingArray(){

        $sizeArray = array();
        foreach ($this->sizeArray as $key => $row) {
            $sizeRowData= array();
            $sizeRowData["type"] = @$row[0];
            $sizeRowData["name"] = @$row[1];

            if($row[0]=="rect"){
                $sizeRowData["width"] = @$row[2];
                $sizeRowData["height"] = @$row[2];
            }else{
                $sizeRowData["width"] = @$row[2];
                $sizeRowData["height"] = @$row[3];
            }
            array_push($sizeArray, $sizeRowData);
        }
        return $sizeArray;
    }

    public function getRootImagePathName(){
        return 'root_images/';
    }

    public function getRootImagesUrl($server_id){
        return root_url().$this->getRootImagePathName();
    }
    public function getRootImagesPath($server_id){
        return root_APPPATH().$this->getRootImagePathName();
    }

    public function generateDirPath($newImageId){
        $id_str = trim($newImageId);

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

    public function makeDir($path){
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }
    }

    protected function getSelectFieldArray_short(){
        $field["image_id"] = "image.image_id";
        $field["image_file_name"] = "image.file_name";
        $field["image_title"] = "image.title";
        $field["image_file_dir"] = "image.file_dir";
        $field["image_width"] = "image.width";
        $field["image_height"] = "image.height";
        $field["image_url"] = "CONCAT('".$this->protocal."',server.full_url,'".$this->getRootImagePathName()."',image.file_dir, image.file_name)";
        $field["image_create_time"] = "image.create_time";
        $field["image_update_time"] = "image.update_time";
        return $field;
    }

    protected function getSelectFieldStr_extend(){
        $field["image_file_dir"] = "image.file_dir";
        $field["image_crop_rect_data"] = "image.crop_rect_data";
        $field["image_size_using"] = "image.size_using";
        $field["image_description"] = "image.description";
        $field["image_server_id"] = "image.server_id";
        return $field;
    }

    public function getId($item_id,$is_full_data=true){

        $result = $this->getImageDataById($item_id,$is_full_data);
        if(!$result){
            resDie(array(),"data-not-foud");
        }   
        return $result;
    }


    public function getImageDataById($image_id,$is_full_data=true){
        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        if($is_full_data==true){
            $fieldArray = array_merge($fieldArray, $this->getSelectFieldStr_extend());
        }

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

    public function edit($imageData,$image_id){

        $fieldUpdate = array(
            "title",
            "description",
            );
        $dbData = $this->getValidFieldAllow($fieldUpdate,$imageData);
        $result = $this->updateDataById($dbData,$image_id);

        if(!$result){
            resDie(array(),"data-update-not-found");
        }

        $imageData = $this->getId($image_id);
        return $imageData;
    }

    public function delete($deleteIdArray=array()){

        if(!(is_array($deleteIdArray)&&(sizeof($deleteIdArray)>0))){
            resDie(array(),"delete-is-not-array");
        }

        $idArray = array();
        foreach ($deleteIdArray as $index => $row) {
            if(is_numeric(@$row["image_id"])){
               if(!in_array(@$row["image_id"],$idArray)){
                    array_push($idArray,@$row["image_id"]);
               }
            }
        }

        $deleteDataArray = array();
        $success_count = 0;
        if(sizeof($idArray)>0){
            foreach ($idArray as $index => $value) {
                $deleteRow = array();
                $deleteRow["image_id"] = $value;

                if($this->getImageDataById($value)){
                    $result =$this->updateDataById(array("status"=>0),$value);
                    $deleteRow["result"] = 1;
                    $success_count++;
                }else{
                    $deleteRow["result"] = 0;
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

    public function upload($inputFileName="",$maxNumber=-1){
        return $this->uploadWithData($inputFileName,array(),$maxNumber);
    }

    public function uploadWithData($inputFileName="",$inputfileData=array(), $maxNumber=-1){
        
        $uploadedFilesData = $this->start_uploadImages($inputFileName,$maxNumber);
        $uploadedFilesData = $this->makeImagesMultipleSize($uploadedFilesData,$this->sizeArray);
        $this->updateDataAfterUploaded($uploadedFilesData,$inputfileData);
        return $this->dbDataForUploadedFilesData($uploadedFilesData);
    }

    protected function getUploadSuccessIdArray($uploadedFilesData){
        $imageId_array = array();
        $successFiles = @$uploadedFilesData["successFiles"];
        if(is_array($successFiles)&&(sizeof($successFiles)>0)){
            foreach ($uploadedFilesData["successFiles"] as $key => $value) {
                if($value["db_file_id"]!=""){
                    array_push($imageId_array, $value["db_file_id"]);
                }
            }
        }
        return $imageId_array;
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
                image
                    LEFT JOIN server ON ( server.server_id = image.server_id )
            WHERE
                image.image_id IN ($whereIn_str) 
            LIMIT 
                0, $getNumber
            ";

        $param_ar = array();
        $result_ar = $this->db->query($sql,$param_ar)->result_array();

        $uploadedFilesData["successFiles"] = $result_ar;
        return $uploadedFilesData;
    }

    protected function start_uploadImages($inputFileName,$maxNumber=-1){

        $max_fileSizeAllowKB = 5000;
        $max_sizeAllowPx = 20000;
        $max_sizeResizePx = 1200;

        $this->load->library('upload');
        $fileArray  = $this->upload->getFileInputArray($inputFileName,$maxNumber);

        if(@$_FILES[$inputFileName]==""){
            $returnData["count"] = 0;
            $returnData["success"] = 0;
            $returnData["errors"] = 1;
            $returnData["successFiles"] = array();
            $returnData["errorsFiles"] = "file input not found : ".$inputFileName;
            return $returnData;
        }

        $filesBuffer = $_FILES[$inputFileName];

        $successData = array();
        $errorsData = array();
        foreach($fileArray as $index => $fileData){

            $config = array();
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] =  $max_fileSizeAllowKB;
            $config['max_width']  = $max_sizeAllowPx;
            $config['max_height']  = $max_sizeAllowPx;

            $validFileData = $this->upload->getValidateImageFileData($fileData,$config);
            $is_upload_complete = false;
            if($this->upload->is_validfile($validFileData)){
                
                $newImageId = $this->getNewImageId($fileData);
                $dirImage = $this->generateDirPath($newImageId);
                $full_dirImage = $this->getRootImagesPath($this->current_server_id).$dirImage;
                $this->upload->makeDir($full_dirImage);

                $new_origin_name = $newImageId."t".time();
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
                }else{
                    $is_upload_complete = true;
                }
            }
            if($is_upload_complete==true){

                $fileData_success = $this->upload->data();
                $success_file_path = $fileData_success["full_path"];
                $this->do_imageResize($success_file_path,$max_sizeResizePx,$max_sizeResizePx);

                $imageSize = getimagesize($success_file_path);
                $fileData_success["resize_image_width"] = $imageSize[0];
                $fileData_success["resize_image_height"] = $imageSize[1];
                $fileData_success["new_origin_name"] = $new_origin_name;
                $fileData_success["file_dir"] = $dirImage;
                $fileData_success["file_size_byte"] = intval($fileData['size']);
                $fileData_success["db_file_id"] = $newImageId;
                $fileData_success["db_file_purename"] = $new_origin_name;
                array_push($successData,$fileData_success);
            }else{
                $error["client_name"] = $_FILES[$inputFileName]['name'];
                $error["file_size"] =  round((@intval($_FILES[$inputFileName]['size'])/1024),2);
                if(@$validFileData["msg"]!=""){
                    $error_msg = @$validFileData["msg"];
                }else{
                    $error_msg = strip_tags($this->upload->display_errors());
                    $this->removeMultiRow("image_id",array($newImageId));
                    $this->recurseRemoveDir($full_dirImage);
                }
                $error["error_msg"] = $error_msg;
                array_push($errorsData,$error);
            }
        }

        $_FILES[$inputFileName] = $filesBuffer;
        
        $returnData= array();
        $returnData["count"] = sizeof($fileArray);
        $returnData["success"] = sizeof($successData);
        $returnData["errors"] = sizeof($errorsData);
        $returnData["successFiles"] = $successData;
        $returnData["errorsFiles"] = $errorsData;
        return $returnData;
    }

    protected function makeImagesMultipleSize($uploadData,$sizeArray){

        $successFiles = @$uploadData["successFiles"];
        if(is_array($successFiles)&&(sizeof($successFiles)>0)){
          
            $file_index = 1;
            foreach($successFiles as $file_index => $fileData){

                $resizeImage_filePath  = @$uploadData["successFiles"][$file_index]["file_path"];
                $resizeImage_fullPath  = @$uploadData["successFiles"][$file_index]["full_path"];
                $new_origin_name = $uploadData["successFiles"][$file_index]["new_origin_name"];

                $imageSize = getimagesize($resizeImage_fullPath);
                $imageW = $imageSize[0];
                $imageH = $imageSize[1];

                foreach($sizeArray as $size_index =>$size_value){

                    $modeType = strtolower(trim(@$size_value[0]));
                    $prefix_str = trim(@$size_value[1]);
                    $sWidth = intval(@$size_value[2]);
                    $sHeight = intval(@$size_value[3]);

                    if($sHeight<=0){
                        $sHeight = $sWidth;
                    }
                    $newImageName = $resizeImage_filePath.$prefix_str.$new_origin_name.$fileData["file_ext"];
                    if($modeType=="rect"){
                        $cropData = $this->createRectImage($resizeImage_fullPath,$newImageName,$sWidth);
                    }else if($modeType=="thumb"){
                        $this->createResizeImage($resizeImage_fullPath,$newImageName,$sWidth,$sHeight);
                    }
                }

                if(is_array($cropData)){
                    $uploadData["successFiles"][$file_index]["image_crop_rect_data"] = json_encode($cropData);
                }

                $file_index++;
            }
        }
        return $uploadData;
    }

    private function getNewImageId($fileData){
        $insertData = array(
                "image_id"=>"",
                "server_id"=>$this->current_server_id,
                "title"=>$fileData["name"],
                "file_size"=>$fileData["size"],
                "status"=>1,
                "create_time"=>time(),
                "update_time"=>time(),
                "ip_address"=>$this->input->ip_address(),
            );

        $newImageId = $this->insert($insertData);
        if(!$newImageId){
            $error = array("error"=>"Cannot insert new image to database!");
            resDie($error,$this->methodPlace());
            exit();
        }
        return $newImageId;
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
                $imageW  = $value["resize_image_width"];
                $imageH = $value["resize_image_height"];
                $updateData = array();
                $updateData["file_name"] = $value["file_name"];
                $updateData["file_dir"] = $value["file_name"];
                $updateData["file_ext"] = $value["file_ext"];
                $updateData["file_dir"] = $value["file_dir"];
                $updateData["file_purename"] = $value["db_file_purename"];
                $updateData["type"] = $value["image_type"];
                $updateData["crop_rect_data"] = $value["image_crop_rect_data"];
                $updateData["size_using"] = json_encode($this->getSizeUsingArray());
                $updateData["width"] = $imageW;
                $updateData["height"] = $imageH;
                $updateData["ratio"] = floatVal($imageW)/floatVal($imageH);

                if(is_array($inputfileData)&&(sizeof($inputfileData)>0)){
                    foreach ($inputfileData as $ipf_key => $ipf_value) {
                        $updateData[$ipf_key] = $ipf_value;
                    }
                }
                $this->updateDataById($updateData,$value["db_file_id"]);
            }
        }
        
    }

    protected function updateDataById($updateData,$image_id){
        //$this->db->where('image_id', $image_id);
        //return $this->db->update('image', $updateData); 
        $updateData["update_time"] = time();
        return $this->update($updateData," WHERE image_id = ? ",array($image_id));
    }


    protected function createResizeImage($source_image,$newImageName,$width,$height){

        $this->load->library('image_lib');
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['new_image'] = $newImageName;
        $config['maintain_ratio'] = TRUE;
        $config['width']    = $width;
        $config['height']   = $height;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    protected function do_imageResize($source_image,$width,$height){
     
        $this->load->library('image_lib');
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['maintain_ratio'] = TRUE;
        $config['width']    = $width;
        $config['height']   = $height;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    protected function createRectImage($source_image,$newImageName,$resize_to){

        $imageSize = getimagesize($source_image);
        $imageW = $imageSize[0];
        $imageH = $imageSize[1];

        if($imageW>$imageH){
            $rect_max_size = $imageH;
            $ex_width = $imageW-$imageH;
            $cp_x = intval($ex_width/2);
            $cp_y = 0;
        }else{
            $rect_max_size = $imageW;
            $ex_height = $imageH-$imageW;
            $cp_x = 0;
            $cp_y = intval($ex_height/2);
        }

        $cp_w = $rect_max_size;
        $cp_h = $rect_max_size;

        return $this->cropAndResize($source_image,$newImageName,$cp_x,$cp_y,$cp_w,$cp_h,$resize_to);

    }

    protected function cropAndResize($source_image,$newImageName,$cp_x,$cp_y,$cp_w,$cp_h,$resize_to){

        $cropImageData =$this->do_cropImage($source_image,$newImageName,$cp_x,$cp_y,$cp_w,$cp_h);
        $this->do_imageResize($cropImageData["source"],$resize_to,$resize_to);

        return $cropImageData["cropData"];
    }

    protected function do_cropImage($source_image,$newImageName,$cp_x,$cp_y,$cp_w,$cp_h){

        $imageSize = getimagesize($source_image);
        $imageW = $imageSize[0];
        $imageH = $imageSize[1];

        $sum_xw = ($cp_x+$cp_w);
        $sum_yh = ($cp_y+$cp_h);
        if($sum_xw>$imageW){
            $cp_w = $cp_w-($sum_xw-$imageW);
        }
        if($sum_yh>$imageH){
            $cp_h = $cp_h-($sum_yh-$imageH);
        }

        $this->load->library('image_lib');
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['new_image'] = $newImageName;
        $config['maintain_ratio'] = FALSE;
        $config['x_axis'] = $cp_x;
        $config['y_axis'] = $cp_y;
        $config['width'] = $cp_w;
        $config['height'] = $cp_h;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->crop();

        $cropData =array();
        $cropData["cx"]= $cp_x;
        $cropData["cy"]= $cp_y;
        $cropData["cw"]= $cp_w;
        $cropData["ch"]= $cp_h;

        /*
        $cropData["cx"]= ($cp_x/$imageW)*100;
        $cropData["cy"]= ($cp_y/$imageH)*100;
        $cropData["cw"]= ($cp_w/$imageW)*100;
        $cropData["ch"]= ($cp_h/$imageH)*100;
        $cropData["width"]= $imageW;
        $cropData["height"]= $imageH;
        */

        $imageData["source"] = $newImageName;
        $imageData["cropData"] = $cropData;
        return $imageData;
    }


    protected function do_rotate($source_image,$newImageName,$rotateDegree){

        $this->load->library('image_lib');
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['new_image'] = $newImageName;
        $config['rotation_angle'] = $rotateDegree;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->rotate();

        return $newImageName;
    }

    public function checkValidRotateValue($rotateDegree,$resDieWhenError=true){
        if(!in_array($rotateDegree,array(90,180,270))){
            if($resDieWhenError){
                resDie(array(),"rotate allow for only 90, 180, 270 degree  ");
            }
            return false;
        }
        return true;
    }

    public function rotateImageById($imageId,$rotateDegree){

        $this->checkValidRotateValue($rotateDegree);

        $imageData = $this->getId($imageId);
        $full_dirImage = $this->getRootImagesPath($imageData["image_server_id"]).$imageData["image_file_dir"];
        $source_imagePath = $full_dirImage.$imageData["image_file_name"];

        $imagePathArray = $this->getImagesPathInDir($full_dirImage);
        foreach ($imagePathArray as $key => $value) {
            $this->do_rotate($value,$value,$rotateDegree);
        }

        $imageSize = getimagesize($source_imagePath);
        $imageW = $imageSize[0];
        $imageH = $imageSize[1];


        $cropData = $imageData["image_crop_rect_data"];
        $cx = $cropData["cx"];
        $cy = $cropData["cy"];
        $cw = $cropData["ch"];
        $ch = $cropData["cw"];

        if($rotateDegree==90){
            $new_cw = $ch;
            $new_ch = $cw;
            $new_cx = $imageW - ( $new_cw+$cy);
            $new_cy = $cx;

        }else if($rotateDegree==180){
            $new_cw = $cw;
            $new_ch = $ch;
            $new_cx = $imageW - ($new_cw+$cx);
            $new_cy = $imageH - ($new_ch+$cy);

        }else if($rotateDegree==270){
            $new_cw = $ch;
            $new_ch = $cw;
            $new_cx = $cy;
            $new_cy = $imageH - ($new_ch+$cx);
        }

        $newCropData = array();
        $newCropData["cx"] = $new_cx;
        $newCropData["cy"] = $new_cy;
        $newCropData["cw"] = $new_cw;
        $newCropData["ch"] = $new_ch;


        $dbData["width"] = $imageW;
        $dbData["height"] = $imageH;
        $dbData["ratio"] = floatVal($imageW)/floatVal($imageH);
        $dbData["crop_rect_data"] = json_encode($newCropData);
        $this->updateDataById($dbData,$imageId);
        $imageData = $this->getId($imageId);

        $rotateData["rotate_degree"] = $rotateDegree;
        $rotateData["rotate_image_paths"] = $imagePathArray;
        $rotateData["image_data"] = $imageData;
        return $rotateData;
    }


    public function checkCropDataFormat($cropData){
        $check_array = array("cx","cy","cw","ch");
        $error_array = array();
        foreach ($check_array as $key => $value) {
            $row_value = @$cropData[$value];
            if(!is_numeric($row_value)){
                $error_array[$value] = "numeric";
            }
        }
        if(sizeof($error_array)>0){
            resDie($error_array,"crop-data-incorrect");
        }
        return $cropData;
    }

    public function checkCropRectDataFormat($cropData){
        $check_array = array("cx","cy","rect_size");
        $error_array = array();
        foreach ($check_array as $key => $value) {
            $row_value = @$cropData[$value];
            if(!is_numeric($row_value)){
                $error_array[$value] = "numeric";
            }
        }
        if(sizeof($error_array)>0){
            resDie($error_array,"crop-data-incorrect");
        }
        return $cropData;
    }

    public function cropRectImageById($imageId,$cropRectData){
        $cropRectData = $this->checkCropRectDataFormat($cropRectData);

        $cropData = array();
        $cropData["cx"] = $cropRectData["cx"];
        $cropData["cy"] = $cropRectData["cy"];
        $cropData["cw"] = $cropRectData["rect_size"];
        $cropData["ch"] = $cropRectData["rect_size"];
        //$cropData["width"] = $cropRectData["width"];
        //$cropData["height"] = $cropRectData["height"];

        $cropResultData = $this->startCropImageById($imageId,$cropData,true);
        if(sizeof(@$cropResultData["cropData"])>0){
            $dbData["crop_rect_data"] = json_encode($cropResultData["cropData"]);
            $this->updateDataById($dbData,$imageId);
        }
        $imageData = $this->getId($imageId);
        return $imageData ;
    }

    public function cropImageById($imageId,$cropData){

        $cropResultData = $this->startCropImageById($imageId,$cropData);
        if(sizeof(@$cropResultData["cropData"])>0){
            $dbData["crop_rect_data"] = json_encode($cropResultData["cropData"]);
            $this->updateDataById($dbData,$imageId);
        }

        $imageData = $this->getId($imageId);
        return $imageData ;
    }

    public function startCropImageById($imageId,$cropData,$isRect=false){

        $cropData = $this->checkCropDataFormat($cropData);
        
        $cx = $cropData["cx"];
        $cy = $cropData["cy"];
        $cw = $cropData["cw"];
        $ch = $cropData["ch"];

        $imageData = $this->getId($imageId);
        $db_image_size_using = $imageData["image_size_using"];

        $full_dirImage = $this->getRootImagesPath($imageData["image_server_id"]).$imageData["image_file_dir"];
        $source_imagePath = $full_dirImage.$imageData["image_file_name"];

        if(!file_exists($source_imagePath)){
            resDie(array(),"image-soure-file-not-found");
        }

        if($isRect==true){
            
            $imageSize = getimagesize($source_imagePath);
            $imageW = $imageSize[0];
            $imageH = $imageSize[1];

            $max_rec_size = $imageH;
            if($imageW<$imageH){
                $max_rec_size = $imageW;
            }

            $diff_cx_cw = $cw-$cx;
            if($diff_cx_cw>$max_rec_size){
               $cw = $cw-($diff_cx_cw-$max_rec_size);
            }

            $diff_cy_ch = $ch-$cy;
            if($diff_cy_ch>$max_rec_size){
               $ch = $ch-($diff_cy_ch-$max_rec_size);
            }
        }


        $imagePathArray = array();
        $imageSizeUsingArray = $this->getSizeUsingArray();
        $imageSizeUsingArray_crop = array();

        foreach ($imageSizeUsingArray as $key => $value) {
            if($value["type"]=="rect"){
                array_push($imageSizeUsingArray_crop,$value);
            }
        }

        if(sizeof($db_image_size_using)>0){
            foreach ($db_image_size_using as $key => $value) {
                if($value["type"]=="rect"){
                    $is_foundExistName = false;
                    foreach ($imageSizeUsingArray_crop as $usingCropIndex => $usingCropRow){
                        if($value["name"]==$usingCropRow["name"]){
                            $is_foundExistName = true;
                        }
                    }
                    if(!$is_foundExistName){
                        array_push($imageSizeUsingArray_crop,$value);
                    }
                }
            }
        }

        $cropData = array();
        foreach ($imageSizeUsingArray_crop as $key => $value) {
            $crop_imagePath = $full_dirImage.$value["name"].$imageData["image_file_name"];
            $resize_to = intval($value["width"]);
            $cropData = $this->cropAndResize($source_imagePath,$crop_imagePath,$cx,$cy,$cw,$ch,$resize_to);
        }

        $resultData = array();
        $resultData["cropData"] = $cropData;
        $resultData["imageData"] = $imageData;
        return $resultData;
    }

    protected function getImagesPathInDir($dir){
        $imagePathArray = array();
        $fileArray = scandir($dir);
        foreach ($fileArray as $key => $value) {
            $filePath = $dir.$value;
            if(@exif_imagetype($filePath)){
                array_push($imagePathArray, $filePath);
            }
        }
        return $imagePathArray;
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

    // FILE RELATION

    public function uploadImageMatchToObject($fileInputName,$object_table_id,$object_id,$type_id,$maxNumber=1){
        return $this->uploadImageToObject($fileInputName,$object_table_id,$object_id,$type_id,$maxNumber);
    }
    public function uploadImageToObject($fileInputName,$object_table_id,$object_id,$type_id,$maxNumber=1){

        $uploadData = $this->upload($fileInputName,$maxNumber);    
        if(sizeof($uploadData["successFiles"])>0){
            foreach ($uploadData["successFiles"] as $index => $value) {
                $image_id = $value["image_id"];
                $cleanResult = $this->cleanImageRelationByKey($object_table_id,$object_id,$type_id);
                $relation_result = $this->addImageToObject($image_id,$object_table_id,$object_id,$type_id,$index);
            }

            $uploadData["cleanResult"] = $cleanResult;
            $uploadData["relation_result"] = $relation_result;
        }
        return $uploadData;
    }

    public function addImageToObject($image_id,$object_table_id,$object_id,$type_id="",$sort_index=""){

        $insertData = array(
                "image_id"=>$image_id,
                "holder_object_table_id"=>$object_table_id,
                "holder_object_id"=>$object_id,
                "sort_index"=>$sort_index,
                "status"=>1,
                "type_id"=>$type_id,
                "create_time"=>time(),
                "update_time"=>time()
            );

        //$newRelation_id = 0;
        $newRelation_id = $this->insertToTable("image_matchto_object",$insertData);
        if(!$newRelation_id){
            return false;
        }
        return $newRelation_id;
    }

    public function deleteImageToObject($object_table_id,$object_id,$image_id)
    {
        $deleteImageId = array(
            'holder_object_table_id'=> $object_table_id,
            'holder_object_id'=> $object_id,
            'image_id' => $image_id
        ); 
        return $this->db->delete('image_matchto_object', $deleteImageId);
    }

    public function cleanImageRelationByKey($object_table_id,$object_id,$type_id=""){

        $where_str = "
        WHERE
             image_matchto_object.holder_object_table_id = ? 
             AND image_matchto_object.holder_object_id = ?
             AND image_matchto_object.type_id = ?
        ";
        $param_ar = array($object_table_id,$object_id,$type_id);
        return $this->deleteToTable("image_matchto_object",$where_str, $param_ar);
    }

    public function getImageByHolder($object_table_id,$object_id,$type_id="",$limit=-1){

        $limit_sql_str = "";
        if($limit>=0){
          $limit_sql_str = " LIMIT 0 , ".intval($limit)." ";  
        }

        $fieldArray = array();
        $fieldArray = array_merge($fieldArray, $this->getSelectFieldArray_short());
        
        $sql = " 
            SELECT
                ".fieldArrayToSql($fieldArray).",
                image_matchto_object.sort_index AS image_sort_index,
                image_matchto_object.image_matchto_object_id AS relation_id
            FROM 
                image_matchto_object
                    INNER JOIN image ON ( image.image_id = image_matchto_object.image_id )
                    INNER JOIN server ON ( server.server_id = image.server_id )
            WHERE
                image_matchto_object.holder_object_table_id = ?
                AND image_matchto_object.holder_object_id = ?
                AND image_matchto_object.type_id = ?
            ORDER BY 
                image_matchto_object.sort_index ASC
            ".$limit_sql_str;

        $param_ar = array($object_table_id,$object_id,$type_id);
        $result_ar = $this->db->query($sql,$param_ar)->result_array();
        if(@$result_ar[0]["image_id"]==""){
            return array();
        }
        return $result_ar;
    }


}

?>