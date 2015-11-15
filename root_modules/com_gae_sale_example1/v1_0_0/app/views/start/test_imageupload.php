<a href="<?=$this->curModule->app_url;?>start/index">Back to home</a>
<hr>

<div>
	<h3>Upload single file</h3>
	<div>
		<input id="file_upload_single" type="file" name="file_upload_single">
	</div>
	<hr>

	<h3>Upload multiple files</h3>
	<div>
		<input id="file_upload_mutilple" type="file" name="file_upload_mutilple" multiple>
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
			var file_upload_mutilple = $("#file_upload_mutilple").get(0);
			
			var dataSend = {
				"txt_data_payload":"14",
				"file_upload_single":file_upload_single,
				"file_upload_mutilple[]":file_upload_mutilple
			};

			CUR_MODULE.apiPost("start/testrequest",dataSend).then(function(res){
				console.log("res ",res);
				// see result from log
			});

		});

	});
	
</script>