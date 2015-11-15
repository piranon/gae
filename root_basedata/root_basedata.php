<?  
    error_reporting(E_ALL); ini_set('display_errors', '1');
    
    require_once("database.php");
    /* URL GENERATE */
    /*<--********** VERY IMPORTANT DONT TOUCH  ************-->*/
    /*<--********** VERY IMPORTANT DONT TOUCH  ************-->*/
    /*<--********** VERY IMPORTANT DONT TOUCH  ************-->*/


    @$GLOBALS['root_APPPATH'] = $root_APPPATH;
    function root_APPPATH(){
        return @$GLOBALS['root_APPPATH'];
    }

    function root_plugins_path(){
        return root_APPPATH()."root_plugins/";
    }

    function root_modules_path(){
        return root_APPPATH()."root_modules/";
    }

    function root_framework_dirname(){
        return "root_framework";
    }

    function root_framework_path(){
        return root_APPPATH().root_framework_dirname()."/";
    }

    function root_framework_app_path(){
        return root_APPPATH().root_framework_dirname()."/application/";
    }

    function base_framework_app_path(){
        return APPPATH;
    }

    function require_root_controller(){
        require_once(root_framework_app_path()."controllers/root_controller.php");
    }

    function require_root_model(){
        require_once(root_framework_app_path()."models/root_model.php");
    }

    function root_system_path(){
        return root_framework_path()."system/";
    }

    function require_base_controller(){
        require_once(base_framework_app_path()."controllers/base_controller.php");
    }

    function require_base_model(){
        require_once(base_framework_app_path()."models/base_model.php");
    }

    function get_base_api_url($project_name){
        return $project_name."_api/v1/";
    }

    function generate_siteurl_data(){
        
        $currrentUrl = $_SERVER['REQUEST_URI'];
        $pathArray  = explode("/",$currrentUrl,5);
        $start_str = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $start_str .=$_SERVER['HTTP_HOST'];

        $root_site_url = $start_str;
        $base_site_url = $start_str;
        $project_name = "";

        $loop = 3;
        for($i=0;$i<$loop;$i++){
            if($i<($loop-1)){
                $root_site_url .=@$pathArray[$i]."/";
            }else{
                $project_name = @$pathArray[$i];
            }
            $base_site_url .=@$pathArray[$i]."/";
        }

        if(@$GLOBALS['root_site_url']==""){
            @$GLOBALS['root_site_url'] = $root_site_url;
        }


        if(@$GLOBALS['base_site_url']==""){
            @$GLOBALS['base_site_url'] = $base_site_url;
        }

        if(@$GLOBALS['base_api_url']==""){
            @$GLOBALS['base_api_url'] = $root_site_url.get_base_api_url($project_name);
        }

    }
    generate_siteurl_data();

    function root_url(){
        return @$GLOBALS['root_site_url'];
    }

    function root_sitefiles_url(){
        return root_url()."root_sitefiles/";
    }

    function root_modules_url(){
        return root_url()."root_modules/";
    }

    function root_ngservices_url(){
        return root_sitefiles_url()."app/services/";
    }

    function root_fontcss_url(){
        //return "http://128.199.139.181/gae/root_sitefiles/css/fonts.css";
        return root_sitefiles_url()."css/fonts.php";
        //return "http://128.199.139.181/gae/root_sitefiles/css/fonts.php";
    }

    function root_filesdir_url(){
        return root_url()."files/";
    }

    function root_imagesdir_url(){
        return root_url()."images/";
    }
    
    /* Base URL Helper */

    function base_app_id(){
        return @$GLOBALS['base_app_id'];
    }

    function base_project_name(){
        return @$GLOBALS['base_project_name'];
    }
   
    function base_api_url(){
        return @$GLOBALS['base_api_url'];
    }

    function base_sitefiles_url(){
        return base_url()."sitefiles/";
    }

    /*
    function base_filesdir_url(){
        return base_site_url()."images/";
    }

    function base_imagesdir_url(){
        return base_site_url()."images/";
    }
    */
    
    function base_ngapp_url(){
        return base_sitefiles_url()."app/";
    }

    function base_ngservices_url(){
        return base_ngapp_url()."services/";
    }

    function base_ngctr_url(){
        return base_sitefiles_url()."app/controllers/";
    }

    function base_ngcontroller_url(){
        return base_ngctr_url();
    }

    function base_ngcss_url(){
        return base_sitefiles_url()."app/css/";
    }

    function base_ngview_url(){
        return base_sitefiles_url()."app/views/";
    }

    function base_nganimation_url(){
        return base_sitefiles_url()."app/animations/";
    }

    function load_base_nganimation($animationsName){
        echo '<link rel="stylesheet" href="'.base_nganimation_url().strtolower($animationsName).'.css" />';
        echo '<script src="'.base_nganimation_url().strtolower($animationsName).'.js"></script>';
    }

    
    /* REQUEST SECTION */
    function getValueForId($value=""){
        if($value==""){
            resDie(array(),"No id");
        }
        if(!is_numeric($value)){
            resDie(array(),"Id is not currect");
        }
        
        return intval($value);
    }

    function t_Request($string){
        return trim(@$_REQUEST[$string]);
    }

    function  t_Post($string){
        return trim(@$_POST[$string]);
    }
    
    function t_Get($string){
        return trim(@$_GET[$string]);
    }
    

    function t_GetInt($string){
        return intval(t_Request($string));
    }
    
    function trimSpaceBarBetweenWord($string){
        return preg_replace('/\s+/', ' ', $string);
    }

    function getFileExt($fileName){
        $filename = basename($fileName);
        return strtolower(substr($filename, strrpos($filename, '.') + 1));   
    }

    function nTob($value=""){
        if($value==null){
            return "";
        }
        return $value;
    }

    /* Check get parameter */
    function getPageLimitStr($curPage=1,$perPage=20){
        
        $curPage = intval($curPage);
        $perPage = intval($perPage);
        
       
        $limitStr = "";
        $real_curPage = ($curPage-1);
        if($real_curPage<0){
            $real_curPage=0;   
        }
        
        //limit get
        if($perPage<0){
         $perPage = 0;   
        }
        if($perPage>100){
         $perPage = 100;   
        }
        
        $start_num = ($real_curPage*$perPage);
        $limitStr = " LIMIT ".$start_num.", ".$perPage." ";
        
        return $limitStr;
        
    }

    /* RESPOSE SECTION */
    function printHeader(){
        /*
        header("Connection: Keep-Alive:max=0");
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        */
        header('Content-Type: text/html; charset=utf-8');
        header("Access-Control-Allow-Headers: access_shop_id, access_os, access_udid");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
    }

    function root_ci_methodPlace($msg=""){
        $ci =& get_instance();
        $ci->router->class; // gets class name (controller)
        $ci->router->method;

        $msgSend = $ci->router->class.":".$ci->router->method;
        if($msg!=""){
            $msgSend .=" | ".$msg;
        }
        return $msgSend;
    }

    function resOk($dataSend_ar=array(), $msg=""){
        printHeader();
        
        $msgSend = root_ci_methodPlace($msg);

        echo json_encode(array("ok"=>1, "msg"=>$msgSend, "data"=>$dataSend_ar),JSON_PRETTY_PRINT);
        exit();
        
    }

    
    function resDie($dataSend_ar=array(), $msg=""){
        printHeader();
        
        $msgSend = root_ci_methodPlace($msg);

        echo json_encode(array("ok"=>0, "msg"=>$msgSend, "data"=>$dataSend_ar),JSON_PRETTY_PRINT);
        exit();
        
    }



    function dataOk($data){
        return array(
            "rs"=>1,
            "data"=>$data
        );
    }

    function dataDie($data){
        return array(
            "rs"=>0,
            "data"=>$data
        );
    }

    function dataListSendFormat($total_rows,$dataList_ar,$curPage,$perPage,$sortby_id=""){
        
        $dataSend["total_rows"] = $total_rows;
        $dataSend["result_rows"] = sizeof($dataList_ar);
        $dataSend["cur_page"]=$curPage;
        $dataSend["per_page"]=$perPage;
        $dataSend["sortby_id"] = $sortby_id;
        $dataSend["dataList"] = $dataList_ar;

        return $dataSend;
    }

    //seq 
    function getTimeCacheStr(){

        $deleyTime = 10000;
        $timeStamp = intval(time()/$deleyTime);
        $timeStamp  = $timeStamp*$deleyTime;
        return "t_".$timeStamp;
    }

    //sql support 
    function fieldArrayToSql($fileArray){
        $select_str = "";
        $count=0;
        foreach ($fileArray as $key => $value) {
            if($count>0){
              $select_str .= ",";  
            }
            $select_str .=  $value." AS ".$key;
            $count++;
        }
        return $select_str;
    }

    function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function getTagStringFormat($tagString){

        $tagArray = explode(",", $tagString);
        $return_str = "";
        if((is_array($tagArray))&&(sizeof($tagArray)>0)){
            foreach ($tagArray as $key => $value) {
               $tagName = trimSpaceBarBetweenWord(trim($value));
               if($tagName!=""){
                    $return_str .= $tagName.","; 
               }
            }
        }
        return $return_str;
    }

    function getGdbArrayByKeyname($array_input,$keyname){
        if((!is_array($array_input))&&(@sizeof($array_input)<=0)){
            return array();
        }
        $newArray = array();
        foreach($array_input as $key => $value){
            if(@$value[$keyname]!=""){

                $idValue = $value[$keyname];
                $isUniqValue = true;
                foreach ($newArray as $index => $newVaue){
                    if($newVaue==$idValue){
                        $isUniqValue = false;
                    }
                }
                if($isUniqValue==true){
                    array_push($newArray,$idValue);
                }
            }
        }
        return $newArray;
    }

    function getDiffArrayByPrimaryKey($origin_array,$compare_array,$primary_key){

        $newArray=array();
        $sameValueArray = array();
        
        foreach ($origin_array as $key1 => $value1) {
            foreach ($compare_array as $key2 => $value2) {
                if($value1[$primary_key]==$value2[$primary_key]){
                    array_push($sameValueArray,$value1);
                }
            }
        }
        foreach ($origin_array as $key1 => $value1) {
           $is_uniq = true;
           foreach ($sameValueArray as $key2 => $value2) {
                if($value1[$primary_key]==$value2[$primary_key]){
                   $is_uniq = false;
                }
           }
           if($is_uniq){
            array_push($newArray,$value1);
           }
        }
        foreach ($compare_array as $key1 => $value1) {
            $is_uniq = true;
            foreach ($sameValueArray as $key2 => $value2) {
                if($value1[$primary_key]==$value2[$primary_key]){
                   $is_uniq = false;
                }
            }
            if($is_uniq){
                array_push($newArray,$value1);
            }
        }
        return $newArray;
    }

?>