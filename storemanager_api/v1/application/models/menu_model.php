<?php

class menu_model extends base_model {

    public function getCurrentMenuData($shop_id){

        $menuData = $this->getAllMenuData($shop_id);
        $menuData["main_menu"] = $this->getAddonDataToMenuArray($menuData["main_menu"],$shop_id);
        return $menuData;

    }

    public function getAddonDataToMenuArray($menuDataArray,$shop_id){

        $this->load->model("module_model");
        $addonConfigArray = $this->module_model->getShopActiveModuleConfigData($shop_id);

        foreach ($addonConfigArray as $index => $row) {
            
            $injection = $row["injection"];
            $sub_menu_id = $injection["sub_menu_id"];
            $menu_display = $row["menu_display"]; 
            $menu_display["module_id"] = $row["module_id"];

            $menuDataArray = $this->addTempDataToMenu($menuDataArray,$sub_menu_id,"menu_addon",$menu_display);
        }

        return $menuDataArray;
    }

    public function addTempDataToMenu($menuDataArray,$menu_id,$keyname,$dataForAdd){

        $resultData = $menuDataArray;
        foreach ($menuDataArray as $index => $row) {
            $cur_row = @$row[$keyname];
            if((!is_array($cur_row))&&(sizeof($cur_row)<=0)){
                $resultData[$index][$keyname] = array();
            }

            if($row["menu_id"]==$menu_id){
                
                array_push($resultData[$index][$keyname],$dataForAdd);
                return $resultData;  
                break;
            }else{
                
                $menu_sub = @$row["menu_sub"];
                if(is_array($menu_sub)&&(sizeof($menu_sub)>0)){
                    $menu_sub = $this->addTempDataToMenu($menu_sub,$menu_id,$keyname,$dataForAdd);
                }

                $resultData[$index]["menu_sub"] = $menu_sub;
                 
            }
      
        }
        return $resultData;
    }



    public function getAllMenuData($shop_id){

        $resultData = array();
        $resultData["main_menu"] = array(
                array(
                    "menu_id"=>1,
                    "menu_name"=>"dashboard",
                    "menu_label"=>"Dashboard",
                    "menu_sub"=>array(
                        array(
                            "menu_id"=>10,
                            "menu_name"=>"home",
                            "menu_label"=>"Home",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>11,
                            "menu_name"=>"sale",
                            "menu_label"=>"Sale",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>12,
                            "menu_name"=>"product",
                            "menu_label"=>"Product",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>13,
                            "menu_name"=>"inventory",
                            "menu_label"=>"Inventory",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>14,
                            "menu_name"=>"promotion",
                            "menu_label"=>"Promotions",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>15,
                            "menu_name"=>"coupon",
                            "menu_label"=>"Coupon",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>16,
                            "menu_name"=>"deal",
                            "menu_label"=>"Deal",
                            "menu_sub"=>array(),
                        ),
                        array(
                            "menu_id"=>17,
                            "menu_name"=>"customer",
                            "menu_label"=>"Customer",
                            "menu_sub"=>array(),
                        )
                    )
                ),
                array(
                    "menu_id"=>2,
                    "menu_name"=>"website",
                    "menu_label"=>"Website",
                    "menu_sub"=>array(),
                ),
                array(
                    "menu_id"=>3,
                    "menu_name"=>"application",
                    "menu_label"=>"Application",
                    "menu_sub"=>array(),
                ),
                array(
                    "menu_id"=>4,
                    "menu_name"=>"mobile",
                    "menu_label"=>"Mobile",
                    "menu_sub"=>array(),
                )
            );
        return $resultData;
    }

}

?>