<?

	$config = array(
			"injection"=>array(
					"sub_menu_id"=>11
				),
			"menu_display"=>array(
					"addon_menu"=>array(
					"label"=>"Payment",
					"image"=>array(
							"normal"=>$curModule->file_url."icon/menu_normal.png",
							"hover"=>$curModule->file_url."icon/menu_normal.png",
							"active"=>$curModule->file_url."icon/menu_active.png",
							"selected"=>$curModule->file_url."icon/menu_active.png"
						)
					),
					"addon_card_info"=>array(
						"label"=>"Payment",
						"primary_image"=>$curModule->file_url."icon/card_info.png",
						"detail"=>array(
							"name"=>"Payment",
							"title_1"=>"หน้าจัดการชำระเงิน",
							"title_2"=>"กำหนดค่าต่างๆรูปแบบชำระเงิน"
						)
					)
				)
		); 

?>

