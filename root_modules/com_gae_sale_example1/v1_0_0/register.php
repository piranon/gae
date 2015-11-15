<?

	$config = array(
			"injection"=>array(
					"sub_menu_id"=>10
				),
			"menu_display"=>array(
					"addon_menu"=>array(
						"label"=>"Example1",
						"image"=>array(
							"normal"=>$curModule->file_url."icon/menu_normal.png",
							"hover"=>$curModule->file_url."icon/menu_normal.png",
							"active"=>$curModule->file_url."icon/menu_active.png",
							"selected"=>$curModule->file_url."icon/menu_active.png"
						)
					),
					"addon_card_info"=>array(
						"label"=>"Example1",
						"primary_image"=>$curModule->file_url."icon/card_info.png",
						"detail"=>array(
							"name"=>"Example1",
							"title_1"=>"ตัวอย่าง module ที่ 1",
							"title_2"=>"ระรายเอียด ตัวอย่างที่ 1"
						)
					)
				)
		); 

?>

