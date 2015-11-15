<?php

class module_model extends base_model {


    public $module_model_history = array();
    public $module_library_history = array();

    public function getShopActiveModule($shop_id){
        return $this->getAllModuleList();
    }

    public function getAllModuleList(){
    	$resultData = array();

            $moduleData = array();
            $moduleData["module_id"] = "1";
            $moduleData["module_bundle_id"] = "com.gae.sale.example1";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "2";
            $moduleData["module_bundle_id"] = "com.gae.sale.moduleex2";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

             //SELL
            $moduleData = array();
            $moduleData["module_id"] = "31";
            $moduleData["module_bundle_id"] = "com.gae.sell.shipment";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "32";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);


            //PRODUCT
            $moduleData = array();
            $moduleData["module_id"] = "21";
            $moduleData["module_bundle_id"] = "com.gae.product.management";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "22";
            $moduleData["module_bundle_id"] = "com.gae.product.collection";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "23";
            $moduleData["module_bundle_id"] = "com.gae.product.productset";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);


            $moduleData = array();
            $moduleData["module_id"] = "25";
            $moduleData["module_bundle_id"] = "com.gae.product.category";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "26";
            $moduleData["module_bundle_id"] = "com.gae.product.attribute";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "27";
            $moduleData["module_bundle_id"] = "com.gae.product.brand";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "28";
            $moduleData["module_bundle_id"] = "com.gae.product.menufacturer";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "29";
            $moduleData["module_bundle_id"] = "com.gae.product.vendor";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            //USER
            $moduleData = array();
            $moduleData["module_id"] = "12";
            $moduleData["module_bundle_id"] = "com.gae.user.staff";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "13";
            $moduleData["module_bundle_id"] = "com.gae.user.staff.group";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "14";
            $moduleData["module_bundle_id"] = "com.gae.user.customer";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "15";
            $moduleData["module_bundle_id"] = "com.gae.user.customer.group";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);
           

        return $resultData;
    }

    public function getId($item_id){

        $result = $this->getDataById($item_id);
        if(!$result){
            resDie(array(),"module_model : data-not-foud");
        }   
        return $result;
    }

    public function getDataById($module_id){
    	$module_array = $this->getAllModuleList();
    	foreach ($module_array as $index => $row) {
    		if($row["module_id"]==$module_id){
    			return  $row;
    			break;
    		}
    	}
    	return false;
    }


    public function getShopActiveModuleConfigData($shop_id){

        $module_array = $this->getShopActiveModule($shop_id);
        return $this->getMoudleConfigByModuleArray($module_array);
    }

    public function getMoudleConfigByModuleArray($module_array){
        $resultData = array();
        if((!is_array($module_array))&&(sizeof($module_array)<=0)){
            return $resultData;
        }
        foreach ($module_array as $index => $row) {
            $config_data = $this->getModuleConfigData($row);
            if($config_data){
                $config_data["module_id"] = $row["module_id"];
                array_push($resultData,$config_data);  
            }
        }
        return $resultData;
    }


    public function getModulePath($moduleData){

        $module_id = $moduleData["module_id"];
        $module_bundle_id = $moduleData["module_bundle_id"];
        $module_version = $moduleData["module_version"];

        $module_bundle_id_path = str_replace(".","_",$module_bundle_id);
        $module_version_path = "v".str_replace(".","_",$module_version);

        $module_path = root_modules_path().$module_bundle_id_path."/".$module_version_path."/";

        return $module_path;
    }

    public function getModuleUrl($moduleData){

        $module_id = $moduleData["module_id"];
        $module_bundle_id = $moduleData["module_bundle_id"];
        $module_version = $moduleData["module_version"];

        $module_bundle_id_path = str_replace(".","_",$module_bundle_id);
        $module_version_path = "v".str_replace(".","_",$module_version);

        $module_path = root_modules_url().$module_bundle_id_path."/".$module_version_path."/";

        return $module_path;
    }

    public function getModuleConfigData($moduleData){

        $module_path = $this->getModulePath($moduleData);
        $module_url = $this->getModuleUrl($moduleData);
        $modult_register_file = $module_path."register.php";
        if(!file_exists($modult_register_file)){
            return false;    
        }

        $curModule = new stdClass();
        $curModule->path = $module_path;
        $curModule->file_url = $module_url."staticfiles/";

        $config = array();
        require($modult_register_file);
        return $config;
        
    }

    public function getModuleViewController($module_id,$controllerName="",$functionName=""){
    	return $this->getModuleControllerWithType("app",$module_id,$controllerName,$functionName);   
    }

    public function getModuleApiController($module_id,$controllerName="",$functionName=""){
    	return $this->getModuleControllerWithType("api",$module_id,$controllerName,$functionName);   
    }

    public function getModuleControllerWithType($type,$module_id,$controllerName="",$functionName=""){

    	$moduleData = $this->getId($module_id);

    	$controllerName = trim(strtolower($controllerName));
    	if($controllerName==""){
    		$controllerName = "start";
    	}

    	$functionName = trim(strtolower($functionName));
    	if($functionName==""){
    		$functionName = "index";
    	}


    	$module_path = $this->getModulePath($moduleData);
        $module_url = $this->getModuleUrl($moduleData);
        $module_run_file = $module_path.$type."/controllers/".$controllerName.".php";
        if(!file_exists($module_run_file)){
        	echo "module controller file not found !!";
            return false;    
        }


        $curModule = new stdClass();
        $curModule->id = $module_id;
        $curModule->bundle_id = $moduleData["module_bundle_id"];
        $curModule->version = $moduleData["module_version"];
        $curModule->path = $module_path;
        $curModule->url = $module_url;
        $curModule->app_url = base_url()."module/app/".$module_id."/";
        $curModule->file_url = $module_url."staticfiles/";
        $curModule->api_url = base_api_url()."module/api/".$module_id."/";

        require($module_run_file);

        $c_controller = new $controllerName();
    	$c_controller->startByModule($curModule);
        try{
		  
          if(method_exists($c_controller,$functionName)){
            $c_controller->{$functionName}();
          }else{
            echo "Undefine function from module controller :  ".$controllerName."->".$functionName;
          }
        }catch(MyException $e){}
		return $c_controller->getMView();    

    }

    public function processModuleModel($classPath,$className){

        $class_run_file = $classPath.".php";
        if(!file_exists($class_run_file)){
            echo "module controller file not found !!";
            return false;    
        }

        if(@nTob($this->module_model_history[$className])!=""){
            return $this->module_model_history[$className];
        }

        require($class_run_file);
        $c_class = new $className();

        $this->module_model_history[$className] = $c_class;
        return $c_class;
    }
    
    public function processModuleLibrary($classPath,$className){
        $class_run_file = $classPath.".php";
        if(!file_exists($class_run_file)){
            echo "module library file not found !!";
            return false;    
        }

        if(@nTob($this->module_library_history[$className])!=""){
            return $this->module_library_history[$className];
        }

        require($class_run_file);
        $c_class = new $className();

        $this->module_library_history[$className] = $c_class;
        return $c_class;
    }

}

?>