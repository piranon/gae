<?
	
	$menuData = $viewData["menuData"];
	$main_menu = $menuData["main_menu"];

	$menu_id = nTob(@$viewData["menu_id"]);
	$module_id = nTob(@$viewData["module_id"]); 

	if($module_id!=""){
		$menuResult = makeMenuActive("module",$module_id,$main_menu);
	}else{
		$menuResult = makeMenuActive("menu",$menu_id,$main_menu);
	}

	$mainmenu_root =  $menuResult["mainmenu_root"];
	$mainmenu_sub =  $menuResult["mainmenu_sub"];
	$mainmenu_addon =  $menuResult["mainmenu_addon"];
	//print_r($mainmenu_addon);
	$menuData = @$viewData["menuData"];


	$card_info_array = array();
	if(is_array($mainmenu_addon)&&(sizeof($mainmenu_addon)>0)){
		foreach ($mainmenu_addon as $index => $row) {
			$itemData = $row["addon_card_info"];
			if(is_array($itemData)&&(sizeof($itemData)>1)&&(nTob(@$itemData[0]["label"])!="")){
				foreach ($itemData as $itd_index => $itd_row) {
					$itd_row["module_id"] = $row['module_id'];
					array_push($card_info_array,$itd_row);
				}
			}else{
				$itemData["module_id"] = $row['module_id'];
				array_push($card_info_array,$itemData);
			}
		}
	}

?>
<div class="card_info_list">
	<? 
	if(is_array($card_info_array)&&(sizeof($card_info_array)>0)){
		foreach ($card_info_array as $index => $row) {

			$itemData = $row;
			$module_on_start_link = base_url()."module/app/".$row['module_id'];
			if(nTob(@$itemData["on_start"])!=""){
				$module_on_start_link = $module_on_start_link."/".$itemData["on_start"];
			}
	?>
		<div class="item">
	        <a href="<?=$module_on_start_link; ?>">
	            <div class="cover">
	                <img src="<?=@$itemData["primary_image"]; ?>">
	            </div>
	            <div class="descriotion">
	                <div class="dh1"><?=@$itemData["detail"]["name"]; ?></div>
	                <div class="dh2"><?=@$itemData["detail"]["title_1"]; ?></div>
	                <div class="dh3"><?=@$itemData["detail"]["title_2"]; ?></div>
	            </div>
	            <div class="clear"></div>
	        </a>
	    </div>
	<?
		} 
	}else{

	?>
	 <div style="text-align:center; "><h3>No module installed!</h3></div>
	<?
	}
	?>
	<div class="clear"></div>
</div>
