<?
class MY_Upload extends CI_Upload
{
	public function __construct($props = array())
    {
        parent::__construct($props);
    }
    
    public function do_custom_upload($inputFileName,$maxUploadNumber=-1)
	{
		
		$fileCount = count(@$_FILES[$inputFileName]['name']);
		//echo "fileCount : ".$fileCount." : ";

		$filesBuffer = $_FILES[$inputFileName];

		$is_multiple_files = false;
		if(is_array(@$_FILES[$inputFileName]['name'])){
			$is_multiple_files = true;
		}

		if($fileCount<=0){
        	return array();
        }
        if($maxUploadNumber>=0){
        	$fileCount = $maxUploadNumber;
        }
       
       
        $successData = array();
        $errorsData = array();
        for($i=0; $i<$fileCount; $i++)
        {   
        	if($is_multiple_files){      
            	$_FILES[$inputFileName]['name']= $filesBuffer['name'][$i];
            	$_FILES[$inputFileName]['type']= $filesBuffer['type'][$i];
            	$_FILES[$inputFileName]['tmp_name']= $filesBuffer['tmp_name'][$i];
            	$_FILES[$inputFileName]['error']= $filesBuffer['error'][$i];
            	$_FILES[$inputFileName]['size']= $filesBuffer['size'][$i];  
        	}
            if ( ! $this->do_upload($inputFileName))
            {
            	$error["client_name"] = $_FILES[$inputFileName]['name'];
            	$error["file_size"] =  round(($_FILES[$inputFileName]['size']/1024),2);
            	$error["error_msg"] = "";
                array_push($errorsData,$error);
            }
            else
            {
                array_push($successData,$this->data());
            }
        }
        // restore value for filed
        $_FILES[$inputFileName] = $filesBuffer;

        $errorsData = $this->generateErrorMsgToErrorData($errorsData);
        
        $returnData["count"] = $fileCount;
        $returnData["success"] = sizeof($successData);
        $returnData["errors"] = sizeof($errorsData);
        $returnData["successFiles"] = $successData;
        $returnData["errorsFiles"] = $errorsData;
        return $returnData;
	}

	public function generateErrorMsgToErrorData($errorsData){

		$error_allStr = $this->display_errors("","<p>");
        if($error_allStr!=""){
        	$error_allStr_array = explode("<p>",$error_allStr,sizeof($errorsData));
    	}
        foreach ($errorsData as $key => $value) {
        	$errorsData[$key]["error_msg"] =strip_tags($error_allStr_array[$key]); 
        }
		return $errorsData;
	}

    public function getFileInputArray($inputFileName,$maxNumber=-1){
        $filesArray = array();
        $fileInputs = @$_FILES[$inputFileName];
        $loopNum = sizeof(@$fileInputs["name"]);
        if($maxNumber>=0){
            if($loopNum>$maxNumber){
                $loopNum = $maxNumber;
            }
        }
        if($loopNum==1){
            $fileNameArray = @$fileInputs["name"];
            if(!is_array($fileNameArray)){
                return  array($fileInputs);
            }
        }

        for ($i=0;$i<$loopNum;$i++) {
            $fileData = array();
            foreach($fileInputs as $key =>$value){
                $fileData[$key] = $fileInputs[$key][$i];
            }
            array_push($filesArray,$fileData);
        }

        return $filesArray;
    }

    public function getValidateImageFileData($files,$config){
        
        if(!empty($config['max_size'])){
            $size_kb = intval($files["size"]);
            $size_mb = $size_kb/1024;

            $max_size = intval($config['max_size']);
            if($size_mb>$max_size){
                $resultData = array();
                $resultData["ok"] = 0;
                $resultData["msg"] = "file size not allowed";
                return $resultData;
            }
        }
        if(!empty($config['allowed_types'])){
            $path = trim($files["name"]);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            $allowed_types = trim($config['allowed_types']);
            $allowed_types_array  = explode("|", $allowed_types);
            
            $resultData = array();
            if(!in_array($ext,$allowed_types_array)){
                $resultData = array();
                $resultData["ok"] = 0;
                $resultData["msg"] = "file type not allowed";
                return $resultData;
            }
        }


        if(@exif_imagetype($files['tmp_name'])){
            $imageSize = getimagesize($files['tmp_name']);
            $imageW = $imageSize[0];
            $imageH = $imageSize[1];

            $size_is_allow = true;
            if(!empty($config['width'])){
                $max_width = intval($config['width']);
                if($imageW>$max_width){
                    $size_is_allow = false;
                }
            }
            if(!empty($config['height'])){
                $max_height = intval($config['height']);
                if($imageH>$max_height){
                    $size_is_allow = false;
                }
            }
            if(!$size_is_allow){
                $resultData = array();
                $resultData["ok"] = 0;
                $resultData["msg"] = "file width and height not allowed";
                return $resultData;
            }
        }

        $resultData = array();
        $resultData["ok"] = 1;
        $resultData["msg"] = 'complete';
        return $resultData;
    }

     public function getValidateFileData($files,$config){
        
        if(!empty($config['max_size'])){
            $size_kb = intval($files["size"]);
            $size_mb = $size_kb/1024;

            $max_size = intval($config['max_size']);
            if($size_mb>$max_size){
                $resultData["ok"] = 0;
                $resultData["msg"] = "file size not allowed";
                return $resultData;
            }
        }
        if(!empty($config['allowed_types'])){
            $path = trim($files["name"]);
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            $allowed_types = trim($config['allowed_types']);
            $allowed_types_array  = explode("|", $allowed_types);
            
            $resultData = array();
            if(!in_array($ext,$allowed_types_array)){
                $resultData["ok"] = 0;
                $resultData["msg"] = "file type not allowed";
                return $resultData;
            }
        }
        $resultData["ok"] = 1;
        $resultData["msg"] = 'complete';
        return $resultData;
    }

    public function makeDir($path){
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }
    }

    public function is_validfile($validFileData){
        if(intval(@$validFileData["ok"])!=1){
            return false;
        }
        return true;
    }
	
}
?>