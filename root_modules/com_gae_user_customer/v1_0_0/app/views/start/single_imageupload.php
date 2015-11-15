<a href="<?=$this->curModule->app_url;?>start/index">Back to home</a>
<hr>

<div>
	<h3>Upload single file</h3>
	<div>
		<input id="file_upload_single" type="file" name="file_upload_single">
	</div>
	<hr>
	<div>
		<input id="submit_btn" type="button" value="SUBMIT">
	</div>
</div>

<script type="text/javascript">
	$(function(){

		$("#submit_btn").click(function(){

			var file_upload_single = $("#file_upload_single").get(0).files[0];
			var dataSend = {
				"txt_data_payload":"14",
				"file_upload_single":file_upload_single
			};

			CUR_MODULE.apiPost("start/single_imageupload",dataSend).then(function(res){
				console.log("res ",res);
				// see result from log
			}).onProgress(function(percent){
				console.log("progress : percent : "+percent);
			});

		});

	});
	
</script>