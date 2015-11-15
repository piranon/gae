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
?>
<div class="card_info_list">
	<? 
	foreach ($mainmenu_addon as $index => $row) {
		$itemData = $row["addon_card_info"];
	?>
		<div class="item">
	        <a href="<?=base_url()."module/app/".$row['module_id']; ?>">
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
	?>
	<div class="clear"></div>
</div>
