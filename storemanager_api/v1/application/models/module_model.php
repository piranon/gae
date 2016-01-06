<?php

class module_model extends base_module_model {


    public $module_model_history = array();
    public $module_library_history = array();

    //<!-- GET MODULE DATA : START --->
    public function getShopActiveModule($shop_id){
        return $this->getShopActiveModuleRelation($shop_id,0);
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

            $moduleData = array();
            $moduleData["module_id"] = "3";
            $moduleData["module_bundle_id"] = "com.gae.design.gaeui";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "4";
            $moduleData["module_bundle_id"] = "com.gae.design.gaeimage";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            //SUB MODULE
            $moduleData = array();
            $moduleData["module_id"] = "4";
            $moduleData["module_bundle_id"] = "com.gae.sale.submodule_ex";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "41";
            $moduleData["module_bundle_id"] = "com.gae.sale.submodule_ex.example1";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["parent_id"] = "4";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "42";
            $moduleData["module_bundle_id"] = "com.gae.sale.submodule_ex.example2";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["parent_id"] = "4";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "43";
            $moduleData["module_bundle_id"] = "com.gae.sale.submodule_ex.example3";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["parent_id"] = "4";
            array_push($resultData,$moduleData);

             //SELL
            $moduleData = array();
            $moduleData["module_id"] = "31";
            $moduleData["module_bundle_id"] = "com.gae.sell.shipment";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            //PAYMENT
            $moduleData = array();
            $moduleData["module_id"] = "32";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "320";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment.bdp";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "32";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "321";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment.cod";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "32";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "322";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment.mnp";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "32";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "323";
            $moduleData["module_bundle_id"] = "com.gae.sell.payment.pap";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "32";
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
            $moduleData["module_id"] = "11";
            $moduleData["module_bundle_id"] = "com.gae.user.customer.address.book";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

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

            $moduleData = array();
            $moduleData["module_id"] = "16";
            $moduleData["module_bundle_id"] = "com.gae.deal.dealmanager";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "17";
            $moduleData["module_bundle_id"] = "com.gae.file.image";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "18";
            $moduleData["module_bundle_id"] = "com.gae.file.imagegallery";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "19";
            $moduleData["module_bundle_id"] = "com.gae.promotion.manager";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "20";
            $moduleData["module_bundle_id"] = "com.gae.promotion.manager.form101";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "19";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "501";
            $moduleData["module_bundle_id"] = "com.gae.modulemanager";
            $moduleData["module_version"] = "1.0.0";
            array_push($resultData,$moduleData);

            $moduleData = array();
            $moduleData["module_id"] = "502";
            $moduleData["module_bundle_id"] = "com.gae.menumanager";
            $moduleData["module_version"] = "1.0.0";
            $moduleData["module_parent_id"] = "19";
            array_push($resultData,$moduleData);
           

        return $resultData;
    }


    public function getShopActiveModuleRelation($shop_id,$level_num=-1){

        $module_array =  $this->getAllModuleList($shop_id);

        $root_module = array();
        $sub_module = array();

        foreach ($module_array as $index => $row) {
            if(intval(@$row["module_parent_id"])==0){
                array_push($root_module,$row); 
            }else{
                array_push($sub_module,$row); 
            }
        }

        if($level_num<0){
            
            $result_array = array();
            foreach($root_module as $root_index =>$root_row){
                $sub_for_root = array();
                foreach ($sub_module as $sub_index => $sub_row) {
                    if($sub_row["module_parent_id"]==$root_row["module_id"]){
                        array_push($sub_for_root,$sub_row);
                    }
                }
                $root_row["sub_module"] = $sub_for_root;
                array_push($result_array,$root_row);
            }
            return $result_array;

        }else if($level_num==0){
            return $root_module;

        }else if($level_num==1){
            return $sub_module;
        }

    }

    public function getSubModuleByModule($module_id){

        $shop_id = $this->currentShopId();

        $module_array = $this->getShopActiveModuleRelation($shop_id,1);

        $result_array = array();
        foreach ($module_array as $index => $row) {
            if(intval(@$row["module_parent_id"])==$module_id){

                array_push($result_array,$row);
            }
        }

        return $this->getMoudleConfigByModuleArray($result_array);
    }
    //<!-- GET MODULE DATA : END --->


    public function getId($item_id){

        $result = $this->getDataById($item_id);
        if(!$result){
            resDie(array(),"module_model : data-not-foud");
        }   
        return $result;
    }

    public function getDataById($module_id){

        $shop_id = $this->currentShopId();

        $module_array = $this->getAllModuleList($shop_id);
        foreach ($module_array as $index => $row) {
            if($row["module_id"]==$module_id){
                return  $row;
                break;
            }
        }
        return false;
    }


    public function getShopActiveModuleConfigData($shop_id){

        $module_array = $this->getShopActiveModuleRelation($shop_id);
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
                $sub_module = @$row["sub_module"];
                $config_data["module_data"] = $row;
                $config_data["module_data"]["sub_module"] = $this->getMoudleConfigByModuleArray($sub_module);
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
        $module_register_file = $module_path."register.php";
        if(!file_exists($module_register_file)){
            return false;    
        }


        $curModule = $this->getCurModuleObject($moduleData);
        $this->startByModule($curModule);
        
        $config = array();
        require($module_register_file);
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

        $curModule = $this->getCurModuleObject($moduleData);
        require_once($module_run_file);

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

    public function getCurModuleObject($moduleData){

        $module_id = $moduleData["module_id"];
        $module_path = $this->getModulePath($moduleData);
        $module_url = $this->getModuleUrl($moduleData);

        require_once(root_plugins_path()."modules/cur_module.php");

        $curModule = new cur_module();
        $curModule->id = $module_id;
        $curModule->bundle_id = $moduleData["module_bundle_id"];
        $curModule->version = $moduleData["module_version"];
        $curModule->path = $module_path;
        $curModule->url = $module_url;
        $curModule->init();
        return $curModule;
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