<script type="text/javascript">
	function log(var1){
		console.log(var1);
	}
</script>
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
	//print_r($mainmenu_addon);
?>
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
		<div id="gae_module_topbar_section">
			<div id="gae_module_topbar_label"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		
		var mainmenu_root = JSON.parse('<?=json_encode($mainmenu_root);?>');
		var menu_id = parseInt('<?=$menu_id; ?>');
		var module_id = parseInt('<?=$module_id; ?>');

		

		var mainmenu_ele_array = [];
		function renderMainMenu_root(menu_array){

			var location_eleId = '#gae_mainMenuBtn_root_div';
			$(location_eleId).html('');
			for(var index in menu_array){
				var row = menu_array[index];
				var htmlStr = row.menu_label;
				var class_str = "btn btn-main_menu";
		
				var btn_ele = $('<a/>', {
										'id':'root_menu_btn_'+row.menu_id,
									    'class':class_str,
									    'href':"#",
									    'html':htmlStr});
				if(index==0){
					btn_ele.addClass("active");
					renderMainMenu_sub(row.menu_sub,row.menu_name);
				}
	 			btn_ele.appendTo(location_eleId);
			}

			$(location_eleId+' .btn').each(function( index, element ) {
				var row = menu_array[index];
				$(element).hover(function(){
					console.log("element_id : "+index);
					resetMenuPanel();
					if(row.menu_sub.length>0){
						renderMainMenu_sub(row.menu_sub,row.menu_name);
					}
				});

			});
		}
		renderMainMenu_root(mainmenu_root);

		if(module_id==0){
			$(".addon_section").fadeIn(200);
			$(".sub_section").mouseleave(function(){
				renderMainMenu_root(mainmenu_root);
			});
		}else{

			setTimeout(function(){
				$(".sub_section").mouseleave(function(){
					if($(".addon_section").css("display")!="none"){
						//$(".addon_section").finish();
						$(".addon_section").clearQueue();
						$(".addon_section").delay(300).fadeOut(200,function(){
							renderMainMenu_root(mainmenu_root);
						});
					}
				});

				$(".sub_section").hover(function(){
					if($(".addon_section").css("display")=="none"){
						//$(".addon_section").finish();
						$(".addon_section").clearQueue();
						$(".addon_section").delay(300).fadeIn(200,function(){

						});	
					}
				});

			},600);

		}
		
		

		function renderMainMenu_sub(menu_array,root_menu_id){
			console.log('menu_array : ',menu_array);
			var location_eleId = '#gae_mainMenuBtn_sub_div';
			var addon_section_ele = $(".addon_section");
			$(location_eleId).html('');
			for(var index in menu_array){
				var row = menu_array[index];
				var htmlStr = row.menu_label;
				var btn_ele = $('<a/>', {
										'id':'sub_menu_btn_'+row.menu_id,
									    'class':'btn btn-main_menu',
									    'href':GURL.base_url()+"dashboard/menu/"+row.menu_id,
									    'html':htmlStr});
	 			btn_ele.appendTo(location_eleId);
	 			if(menu_id==row.menu_id){
	 				btn_ele.addClass("active");
	 				renderMainMenu_addon(row.menu_addon,row.menu_id);
	 			}
			}
			$(location_eleId).append('<div class="clear"></div>');

			$(location_eleId+' .btn').each(function( index, element ) {
				var row = menu_array[index];
				$(element).hover(function(){
					console.log("element_id : "+index+" : ",row.menu_addon);
					renderMainMenu_addon(row.menu_addon,row.menu_id);
				});
			});
		}

		var submenu_addon_render_last_id = null;
		function renderMainMenu_addon(menu_array,menu_id){

			if(submenu_addon_render_last_id==menu_id){
				return;
			}
			submenu_addon_render_last_id = menu_id;

			var location_eleId = '#gae_mainMenuBtn_addon_div';
	
			$(location_eleId).html('');
			for(var index in menu_array){

				var row = menu_array[index];
				var htmlStr = getHtmlStr(row.addon_menu.image.normal,row.addon_menu.label);
				var btn_ele = $('<a/>', {
										'id':'addon_menu_btn_'+row.module_id,
									    'class':'btn jellyBox_small btn-main_menu-addon',
									    'href':GURL.base_url()+"module/app/"+row.module_id,
									    'html':htmlStr});
				if(module_id==row.module_id){
					btn_ele.addClass("active");
					$("#gae_module_topbar_label").html(row.addon_menu.label);
				}
	 			btn_ele.appendTo(location_eleId);

			}
			$(location_eleId).append('<div class="clear"></div>');
			$(location_eleId+' .btn').each(function( index, element ) {
				var row = menu_array[index];
			});

			function getHtmlStr(imageSrc,label){
				var htmlStr = '<img src="'+imageSrc+'" /><div class="clear"></div><div class="addon_label">'+label+'</div>';
				return htmlStr;
			}
		}

		$("#gae_mainMenuBtn_addon_div").hover(function(){
			$("#"+this.id).fadeIn("fast");
		});

		function resetMenuPanel(){
			$(".menu_btn_sub_div").html('<div style="height:40px;"></div>');
			$(".menu_btn_addon_div").html('');
		}
	});
</script>

