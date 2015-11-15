<link href="<?php echo base_sitefiles_url(); ?>css/main_menu.css" rel="stylesheet">
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
?>
<div class="header_menu" >
	
	<div class="mainmenu_root">
		<? 
			if(is_array($mainmenu_root)&&(sizeof($mainmenu_root)>0)){
				foreach ($mainmenu_root as $index => $row) {
		?>
		<a href="<?=base_url()."dashboard/"; ?>" class="btn_root <?=@$row['css_active_btn'];?>"><?=$row["menu_label"]; ?></a>
		<?
				}
			}
		?>
	</div>
	<div class="mainmenu_sub">
		<div class="menu_div">
			<? 
				if(is_array($mainmenu_sub)&&(sizeof($mainmenu_sub)>0)){
					foreach ($mainmenu_sub as $index => $row) {
			?>
			<a href="<?=base_url().'dashboard/menu/'.$row['menu_id'];?>" class="btn_sub <?=@$row['css_active_btn'];?>" ><?=$row["menu_label"]; ?></a>
			<?
					}
				}
			?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="mainmenu_addon">
		<?
			$addon_count = sizeof($mainmenu_addon);
			$div_size = $addon_count*(80+(6*2)+(6*2));
		?>
		<div class="menu_div" style="width:<?=$div_size;?>px;">
			<? 
				if(is_array($mainmenu_addon)&&(sizeof($mainmenu_addon)>0)){
					foreach ($mainmenu_addon as $index => $row) {
			?>
			<a href="<?=base_url()."module/app/".$row['module_id']; ?>" >
				<div  class="btn_sub <?=@$row['css_active_btn'];?>">
					<? 
						if(@$row['css_active_btn']!=""){
							$image_btn_src = @$row["addon_menu"]["image"]["active"];
						}else{
							$image_btn_src = @$row["addon_menu"]["image"]["normal"];
						}
					?>
					<img src="<?=$image_btn_src; ?>" />
					<div class="clear"></div>
					<div><?=$row["addon_menu"]["label"]; ?></div>
				</div>

			</a>
			<?
					}
				}
			?>
			<div class="clear"></div>
		</div>
	</div>
</div>

