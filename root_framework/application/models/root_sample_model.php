<?

class root_sample_model extends root_model {

	public function getRegister_sign_serway_data(){

		function someFnc($header_id,$loopNumber){

            $subDataArray = array();
            for($i=0;$i<$loopNumber;$i++){
                $sub_exampleData = array(
                    "serway_id"=>"100".$i,
                    "image_url"=>root_sitefiles_url()."images/testimages/testRect.png",
                    "title"=>array(
                            "en"=>"Are you already selling? - ".$i,
                            "th"=>"ปัจจุบันท่านขายสินค้าอยู่หรือไม่ -".$i,
                        )
                );
                array_push($subDataArray,$sub_exampleData);
            }

            $serwayDataArray = array(
                "serway_id"=>$header_id."0",
                "select_type"=>"radio",
                "image_url"=>root_sitefiles_url()."images/testimages/testRect.png",
                "title"=>array(
                        "en"=>"Are you already selling?",
                        "th"=>"ปัจจุบันท่านขายสินค้าอยู่หรือไม่",
                    ),
                "sub_data"=>array(
                        "main"=>$subDataArray,
                        "extra"=>$subDataArray
                    )
            );

            $extraDataArray = array(
                array(
                        "serway_id"=>"10",
                        "image_url"=>root_sitefiles_url()."images/testimages/testRect.png",
                        "title"=>array(
                                "en"=>"I'm not sure yet / Other",
                                "th"=>"ยังไม่แน่ใจ หรือไม่ตรงกับสินค้าที่มี",
                            ),
                    )
            );

            $serwayDataArray["sub_data"]["main"] = $subDataArray;
            $serwayDataArray["sub_data"]["extra"] = $extraDataArray;
            return $serwayDataArray;
        }


        $dataSend = array(
            "sign_serway1"=>someFnc(1,3),
            "sign_serway2"=>someFnc(2,6)
        );
        return $dataSend;
	}

	public function getRegister_sub_serway_data(){

		function someFnc($header_id,$loopNumber){

            $subDataArray = array();
            for($i=0;$i<$loopNumber;$i++){
                $serway_id = "1".$header_id.$i;
                $sub_exampleData = array(
                    "serway_id"=>$serway_id,
                    "image_url"=>root_sitefiles_url()."images/testimages/testRect.png",
                    "title"=>array(
                            "en"=>"Are you already selling? - ".$i,
                            "th"=>"ปัจจุบันท่านขายสินค้าอยู่หรือไม่ -".$i,
                        )
                );
                $sub_exampleData["support_data"] = getCateImageButtonArray($i); 
                array_push($subDataArray,$sub_exampleData);
            }
            return $subDataArray;
        }

        function getCateImageButtonArray($i){

            $imageNameArray = array("bird","camera","apple","bag","amulet","bicycle","beerhall","coffee","computer","bathrooms","beerhall","drug","fastfoods","doll","dog","games","gun","hats","haircut","graduation","golf");
            $imageName = $imageNameArray[$i];
            $cateImage["normal"] = root_sitefiles_url()."images/testcategory/".$imageName."_white.svg";
            $cateImage["hover"] = root_sitefiles_url()."images/testcategory/".$imageName.".svg";
            $cateImage["active"] = root_sitefiles_url()."images/testcategory/".$imageName."_color.svg";
            $cateImage["inactive"] = root_sitefiles_url()."images/testcategory/".$imageName."_inactive.svg";
            return array("category_button_images"=>$cateImage);
        }

        $extraDataArray = array(
                array(
                        "serway_id"=>"10",
                        "image_url"=>root_sitefiles_url()."images/testimages/testRect.png",
                        "title"=>array(
                                "en"=>"Other",
                                "th"=>"ไม่มีประเภทที่ตรงกับสินค้าที่มี",
                            ),
                    )
            );

        $dataSend = array();
        $dataSend["main"] = someFnc(8,21);
        $dataSend["extra"] = $extraDataArray;

        return $dataSend;
	}

	public function getModulePackagePlaneList(){

		$planDataArray = array();
		$moduleItem = array(
			"product_id"=>"100",
			"image"=>"",
			"type"=>"package",
			"name"=>"eco",
            "level"=>"1",
			"price"=>"490",
			"currency"=>"THB",
            "is_selected"=>"1",
		);
		array_push($planDataArray,$moduleItem);

		$moduleItem = array(
			"product_id"=>"101",
			"image"=>"",
			"type"=>"package",
			"name"=>"business",
            "level"=>"2",
			"price"=>"990",
			"currency"=>"THB",
            "is_selected"=>"0",
		);
		array_push($planDataArray,$moduleItem);

		$moduleItem = array(
			"product_id"=>"102",
			"image"=>"",
			"type"=>"package",
			"name"=>"first",
            "level"=>"3",
			"price"=>"2990",
			"currency"=>"THB",
            "is_selected"=>"0",
		);
		array_push($planDataArray,$moduleItem);

        /*
		$moduleItem = array(
			"product_id"=>"103",
			"image"=>root_sitefiles_url()."images/testimages/custom-plan.svg",
			"type"=>"package",
			"name"=>"custom plan",
			"price"=>"0",
			"currency"=>"THB",
		);
		array_push($planDataArray,$moduleItem);
        */

		return $planDataArray;

	}

    public function featureItemGenerate($curpage,$index){

        $imageNameArray = array("bird","camera","apple","bag","amulet","bicycle","beerhall","coffee","computer","bathrooms","beerhall","drug","fastfoods","doll","dog","games","gun","hats","haircut","graduation","golf");

        $cIndex = $index;
        $arraySize = (sizeof($imageNameArray)-1);
        do{
            if($cIndex>$arraySize){
                $cIndex = $cIndex - sizeof($imageNameArray);
            }

        }while ($cIndex>$arraySize);
        
        $imageName = $imageNameArray[$cIndex];

        $moduleItem = array(
            "feature_id"=>$curpage."0".$index,
            "image"=>root_sitefiles_url()."images/testcategory/".$imageName."_color.svg",
            "support_data"=>$this->getImageButtonArray($imageName),
            "type"=>"feature",
            "name"=>"feature - name - ".$index,
            "price"=>100+($index*10),
            "currency"=>"THB",
            "is_selected"=>rand(0,1),
        );
        return $moduleItem;
    }

    public function getPackageFeatureList($curpage,$perpage){
        $moduleArray = array();

        $startIndex = (($curpage-1)*$perpage);
        $endIndex = $startIndex+$perpage;

        if($endIndex>28){
           $endIndex = 28; 
        }

        $loop = $perpage;
        for($i=$startIndex;$i<$endIndex;$i++){
            $moduleData = $this->featureItemGenerate($curpage,$i);
            array_push($moduleArray,$moduleData);
        }
        return $moduleArray;
    }

    public function getImageButtonArray($imageName){
            $imageArray = array();
            $imageArray["normal"] = root_sitefiles_url()."images/testcategory/".$imageName."_white.svg";
            $imageArray["hover"] = root_sitefiles_url()."images/testcategory/".$imageName.".svg";
            $imageArray["active"] = root_sitefiles_url()."images/testcategory/".$imageName."_color.svg";
            $imageArray["inactive"] = root_sitefiles_url()."images/testcategory/".$imageName."_inactive.svg";
            $dataSend["image_button"] = $imageArray;
            return $dataSend;
    }

	public function moduleItemGenerate($curpage,$index){

		$imageNameArray = array("bird","camera","apple","bag","amulet","bicycle","beerhall","coffee","computer","bathrooms","beerhall","drug","fastfoods","doll","dog","games","gun","hats","haircut","graduation","golf");

		$cIndex = $index;
        $arraySize = (sizeof($imageNameArray)-1);
		do{
			if($cIndex>$arraySize){
				$cIndex = $cIndex - sizeof($imageNameArray);
			}

		}while ($cIndex>$arraySize);
		
        $imageName = $imageNameArray[$cIndex];

		$moduleItem = array(
			"product_id"=>$curpage."0".$index,
			"image"=>root_sitefiles_url()."images/testcategory/".$imageName."_color.svg",
            "support_data"=>$this->getImageButtonArray($imageName),
			"type"=>"addon",
			"name"=>"addon - name - ".$index,
			"price"=>100+($index*10),
			"currency"=>"THB",
            "is_selected"=>rand(0,1),
		);
        return $moduleItem;
	}

	public function getModuleAddonList($curpage,$perpage){
		$moduleArray = array();

        $startIndex = (($curpage-1)*$perpage);
        $endIndex = $startIndex+$perpage;

        if($endIndex>32){
           $endIndex = 32; 
        }

        $loop = $perpage;
		for($i=$startIndex;$i<$endIndex;$i++){
			$moduleData = $this->moduleItemGenerate($curpage,$i);
			array_push($moduleArray,$moduleData);
		}
		return $moduleArray;
	}

    public function getPlanCompareList(){

        function getCompareRow($i,$type){
            $compareRowData = array(
                "title"=>"Compare Title ".$i,
                "description"=>"หัวข้อเปรียบเทียบ ".$i
                );

            if($type=="text"){
                $compareRowData["display_type"] = "text";
                $compareRowData["data"] = array(
                        array(
                            "id"=>$i."00",
                            "value"=>"test-1-".$i
                            ),
                        array(
                            "id"=>$i."01",
                            "value"=>"test-2-".$i
                            ),
                        array(
                            "id"=>$i."02",
                            "value"=>"test-3-".$i
                            )
                    );
            }else{
                $compareRowData["display_type"] = "mark";
                $compareRowData["data"] = array(
                        array(
                            "id"=>$i."00",
                            "value"=>0
                            ),
                        array(
                            "id"=>$i."01",
                            "value"=>1
                            ),
                        array(
                            "id"=>$i."02",
                            "value"=>1,
                            )
                    );
            }
            return $compareRowData;
        }

        
        $dataBody = array();
        for($i=0;$i<16;$i++){
            if(($i%3)==0){
                $compareRow = getCompareRow($i,"text");
            }else{
                $compareRow = getCompareRow($i,"mark");
            }
            array_push($dataBody,$compareRow);
        }

        $compareData = array();
        $compareData["header"]  = array(
                "title"=>"Compare Title ".$i,
                "description"=>"หัวข้อเปรียบเทียบ ".$i,
                "display_type"=>"text"
                );
        $compareData["header"]["data"] = $this->getModulePackagePlaneList(); 
        $compareData["body"] = $dataBody;

        $pageData = array();
        $pageData["title_en"] = "Compare plan";
        $pageData["title_th"] = "เปรียบเทียบแผนหลักของร้านค้า";
        $pageData["data"] = $compareData;
        
        return $pageData;
    }



    public function getCustomerFeatureGroupList($curpage,$perpage){

        $featureGroupArray = array();
        for($i=1;$i<=6;$i++){
            $groupData = array(
                    "feature_group_id"=>"10".$i,
                    "name"=>"Feature Group name ".$i,
                );
            array_push($featureGroupArray,$groupData);
        }
        return $featureGroupArray;
    }

    public function getSelectSubmitAddonData($curpage,$perpage){

        $moduleArray = array();

        $startIndex = (($curpage-1)*$perpage);
        $endIndex = $startIndex+$perpage;

        if($endIndex>16){
           $endIndex = 16; 
        }

        $loop = $perpage;
        for($i=$startIndex;$i<$endIndex;$i++){
            $moduleData["feature_data"] = $this->featureItemGenerate($curpage,$i);

            $addon_array = array();
            //$loopNumber = intval(rand(1,5));
            $loopNumber = ($i%5)+1;
            for ($j=0;$j<$loopNumber;$j++) {
                $addon_data = $this->moduleItemGenerate(($i+1),($j+1));
                $addon_data["selected_shop"] = array(
                    array("shop_id"=>"100","is_select"=>1),
                    array("shop_id"=>"106","is_select"=>rand(0,1)),
                    array("shop_id"=>"202","is_select"=>rand(0,1)),
                );
                array_push($addon_array,$addon_data);
            }
            $moduleData["feature_data"]["addon_data"] = $addon_array;
            array_push($moduleArray,$moduleData);
        }
        return $moduleArray;

    }

    public function getRandomAddonDataArray($index=0){

        $addon_array = array();
        $loopNumber = ($index%5)+1;
        for ($i=0;$i<$loopNumber;$i++) {
            $addon_data = $this->moduleItemGenerate(($index+1),($i+1));
            array_push($addon_array,$addon_data);
        }
        return $addon_array;
    }

    public function getFeatureForUpgradePackageArray($curpage,$perpage){
        $moduleArray = array();

        $startIndex = (($curpage-1)*$perpage);
        $endIndex = $startIndex+$perpage;

        if($endIndex>16){
           $endIndex = 16;
        }

        $loop = $perpage;
        for($i=$startIndex;$i<$endIndex;$i++){
            $moduleData["feature_data"] = $this->featureItemGenerate($curpage,$i);
            array_push($moduleArray,$moduleData);
        }
        return $moduleArray;
    }



}

?>