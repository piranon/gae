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
    }
</script>
