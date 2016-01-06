<?
	function makeMenuActive($type,$item_id,$main_menu){
		$resultData = array();
		$mainmenu_addon = array();
		$css_active_btn = "active";
    	foreach($main_menu as $root_index => $root_row){
    		$menu_sub = $root_row["menu_sub"];
    		foreach($menu_sub as $sub_index => $sub_row){
    			$mainmenu_addon = nTob(@$sub_row["menu_addon"]);

    			if($type=="menu"){
    				if($sub_row["menu_id"]==$item_id){
    					
    					$root_row["css_active_btn"] = $css_active_btn;
    					$sub_row["css_active_btn"] = $css_active_btn;

    					$main_menu[$root_index]["css_active_btn"] = $css_active_btn;
    					$menu_sub[$sub_index]["css_active_btn"] = $css_active_btn;

    					$resultData["mainmenu_root"] = $main_menu;
    					$resultData["mainmenu_sub"] = $menu_sub;
    					$resultData["mainmenu_addon"] = $mainmenu_addon;
    					return $resultData;
    					break;
    				}
    			}else if($type=="module"){
    				
    				if(is_array($mainmenu_addon)&&(sizeof($mainmenu_addon)>0)){
	    				foreach ($mainmenu_addon as $addon_index => $addon_row) {
	    					if($addon_row["module_id"]==$item_id){
	    						
	    						$main_menu[$root_index]["css_active_btn"] = $css_active_btn;
	    						$menu_sub[$sub_index]["css_active_btn"] = $css_active_btn;
	    						$mainmenu_addon[$addon_index]["css_active_btn"] = $css_active_btn;

	    						$resultData["sub_menu_id"] = $sub_row["menu_id"];
	    						$resultData["mainmenu_root"] = $main_menu;
	    						$resultData["mainmenu_sub"] = $menu_sub;
	    						$resultData["mainmenu_addon"] = $mainmenu_addon;
	    						return $resultData;
	    						break;
	    					}else{

	  							$sub_addonData = @$addon_row["module_data"]["sub_module"];
	  						
	    						foreach ($sub_addonData as $sub_addon_index => $sub_addon_row) {
	    							$sub_module_id = @$sub_addon_row["module_data"]["module_id"];
	    							if($sub_module_id==$item_id){

	    								$main_menu[$root_index]["css_active_btn"] = $css_active_btn;
	    								$menu_sub[$sub_index]["css_active_btn"] = $css_active_btn;
	    								$mainmenu_addon[$addon_index]["css_active_btn"] = $css_active_btn;

	    								$resultData["sub_menu_id"] = $sub_row["menu_id"];
			    						$resultData["mainmenu_root"] = $main_menu;
			    						$resultData["mainmenu_sub"] = $menu_sub;
			    						$resultData["mainmenu_addon"] = $mainmenu_addon;
			    						return $resultData;
			    						break;

	    							}
	    						}
								
								
	    					}
	    				}
    				}
    			}
    		}
    	}

	}

	$menuData = $viewData["menuData"];
	$main_menu = $menuData["main_menu"];

	$menu_id = nTob(@$viewData["menu_id"]);
	$module_id = nTob(@$viewData["module_id"]); 

	if($module_id!=""){
		$menuResult = makeMenuActive("module",$module_id,$main_menu);
		$menu_id = $menuResult["sub_menu_id"];
	}else{
		$menuResult = makeMenuActive("menu",$menu_id,$main_menu);
	}
	$module_id = intval($module_id);
	$mainmenu_root =  $menuResult["mainmenu_root"];
	$mainmenu_sub =  $menuResult["mainmenu_sub"];
	$mainmenu_addon =  $menuResult["mainmenu_addon"];
	
	//resOk($menuData);
	//exit();
	
?>
<script type="text/javascript">
	var mainmenu_root = JSON.parse('<?=json_encode($mainmenu_root);?>');
	var menu_id = parseInt('<?=$menu_id; ?>');
	var module_id = parseInt('<?=$module_id; ?>');
</script>
<link href="<?php echo base_sitefiles_url(); ?>main_menu/main_menu.css" rel="stylesheet">
<script  src="<?php echo base_sitefiles_url(); ?>main_menu/main_menu.js"></script>
<div class="gae_pageMainmenu">
	<div class="root_section">
		<div id="gae_mainMenuBtn_root_div" class="menu_btn_root_div"></div>
		<div class="clear"></div>
	</div>
	<div class="sub_section">
		<div id="gae_mainMenuBtn_sub_div" class="menu_btn_sub_div"></div>
		<div class="clear"></div>
		<div class="addon_section">
			<div id="gae_mainMenuBtn_addon_div" class="menu_btn_addon_div"></div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="gae_module_bar_section" style="z-index:0;">
		<div class="gae_module_bar_body">
			<div id="gae_module_bar_title" class="gae_module_bar_box"></div>
			<div id="gae_module_bar_btn_box_left"class="gae_module_bar_box gae_module_btn_box_left fadein"></div>
			<div id="gae_module_bar_btn_box_right" class="gae_module_bar_box gae_module_btn_box_right "></div>
			<div class="clear"></div>
		</div>
	</div>
</div>


