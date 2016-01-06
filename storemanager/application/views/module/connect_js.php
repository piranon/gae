<script src="<?php echo root_ngservices_url(); ?>cur_module/CUR_MODULE.js"></script>
<script type="text/javascript">
	CUR_MODULE.data = {
            id:"<?=$this->curModule->id; ?>",
            bundel_id:"<?=$this->curModule->bundle_id; ?>",
            version:"<?=$this->curModule->version; ?>",
            app_url:"<?=$this->curModule->app_url; ?>",
            app_popup_url:"<?=$this->curModule->app_popup_url; ?>",
            api_url:"<?=$this->curModule->api_url; ?>",
            file_url:"<?=$this->curModule->file_url; ?>",
            base_module_app_url:"<?=$this->curModule->file_url; ?>",
            base_module_app_popu_url:"<?=$this->curModule->file_url; ?>",
            baes_module_api_url:"<?=$this->curModule->file_url; ?>"
    }

    $(function(){

        try{
            $("#gae_module_bar_btn_box_left").append($(".gae_manager_view-module_bar-left").html());
            //$(".gae_manager_view-module_bar-left").appendTo($("#gae_module_bar_btn_box_left")).show();
        }catch(e){}

        try{
            $("#gae_module_bar_btn_box_right").append($(".gae_manager_view-module_bar-right").html());
            //$(".gae_manager_view-module_bar-right").appendTo($("#gae_module_bar_btn_box_right")).show();
        }catch(e){}

    	try{
    		$(".gae_manager_view-header").appendTo($("#gae_manager_view-header-real_location")).show();
    	}catch(e){}

    	try{
    		$(".gae_manager_view-left").appendTo($("#gae_manager_view-left-real_location")).show();
    	}catch(e){}

    	try{
    		$(".gae_manager_view-right").appendTo($("#gae_manager_view-right-real_location")).show();
    	}catch(e){}

    	try{
    		$(".gae_manager_view-footer").appendTo($("#gae_manager_view-footer-real_location")).show();
    	}catch(e){}
    

        
    });

</script>
