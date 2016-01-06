$(function(){
	/* 
	require
	var mainmenu_root = JSON.parse('<?=json_encode($mainmenu_root);?>');
	var menu_id = parseInt('<?=$menu_id; ?>');
	var module_id = parseInt('<?=$module_id; ?>');
	*/
	function log(var1){
		console.log(var1);
	}
	var last_root_menu_id = 0;
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
				renderMainMenu_sub(row.menu_sub,row.menu_id);
			}
 			btn_ele.appendTo(location_eleId);
		}

		$(location_eleId+' .btn').each(function( index, element ) {
			var row = menu_array[index];
			$(element).hover(function(){
				resetMenuPanel();
				renderMainMenu_sub(row.menu_sub,row.menu_id);
			});

		});
	}
	
	var last_menu_sub_id_hover = menu_id;
	var master_menu_addon = null;
	function renderMainMenu_sub(menu_array,menu_root_id){
		
		var location_eleId = '#gae_mainMenuBtn_sub_div';
		var addon_section_ele = $(".addon_section");
		if(last_root_menu_id!=menu_root_id){
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
					last_menu_sub_id_hover = menu_id;
					master_menu_addon = row.menu_addon;
					renderMainMenu_addon(row.menu_addon,row.menu_id);
	 			}
			}
			$(location_eleId).append('<div class="clear"></div>');
		}
		last_root_menu_id = menu_root_id;

		$(location_eleId+' .btn').each(function( index, element ) {
			var row = menu_array[index];
			$(element).hover(function(){
				$(location_eleId+' .btn').removeClass("hover_active");
				if(last_menu_sub_id_hover==row.menu_id){
					$(element).addClass("hover_active");
				}else{
					$(element).clearQueue();
					$(element).delay(100).delay(50,function(){
						renderMainMenu_addon(row.menu_addon,row.menu_id);
					});
					last_menu_sub_id_hover = row.menu_id;
				}
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
				$("#gae_module_bar_title").html(row.addon_menu.label);
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

	function resetMenuPanel(){
		$(".menu_btn_addon_div").html('');
	}


	/* start */

	renderMainMenu_root(mainmenu_root);
	if(module_id==0){
		$(".addon_section").fadeIn(200);
		$(".sub_section").mouseleave(function(){
			renderMainMenu_root(mainmenu_root);

			var location_eleId = '#gae_mainMenuBtn_sub_div';
			$(location_eleId+' .btn').each(function( index, element ) {
				$(location_eleId+' .btn').removeClass("hover_active");
			});
			if(master_menu_addon){
				renderMainMenu_addon(master_menu_addon,menu_id);
			}
			
		});
	}else{

		setTimeout(function(){
			$(".sub_section").mouseleave(function(){
				if($(".addon_section").css("display")!="none"){
					//$(".addon_section").finish();
					$(".addon_section").clearQueue();
					$(".addon_section").delay(100).fadeOut(100,function(){
						renderMainMenu_root(mainmenu_root);
					});
				}

				var location_eleId = '#gae_mainMenuBtn_sub_div';
				$(location_eleId+' .btn').each(function( index, element ) {
					$(location_eleId+' .btn').removeClass("hover_active");
				});
			});

			$(".sub_section").hover(function(){
				if($(".addon_section").css("display")=="none"){
					//$(".addon_section").finish();
					$(".addon_section").clearQueue();
					$(".addon_section").delay(100).fadeIn(100,function(){

					});	
				}
			});

		},600);

	}
	$("#gae_mainMenuBtn_addon_div").hover(function(){
		$("#"+this.id).fadeIn("fast");
	});
	

});