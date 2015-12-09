<?  
  $docs_dir_url = root_sitefiles_url()."flat-ui/UI/pro/docs/";
?>
<style type="text/css">
  .container{  position: relative;  margin: 0px auto; padding: 40px 0px; }
</style>
<script type="text/javascript">
    function redirectTo(url){
      window.location.href = url;
    }
</script>
 <div class="container" >
        <div class="demo-content">
        <ul class="nav nav-tabs">
            <li  ><a href="#"  onclick="redirectTo('<?=$curModule->app_url();?>start/allui')" >ALL UI Element</a></li>
            <li class="active"><a href="#" onclick="redirectTo('<?=$curModule->app_url();?>start/gaeui')">GAEUI Component</a></li>
        </ul> <!-- /tabs -->
      </div>
    </div> <!-- /row -->

    <div class="container">
       	<div class="demo-row demo-buttons">
        	<div class="demo-title">
         		<h2 class="demo-panel-title text-gae-primary">GAEUI</h2>
        	</div>
    	</div> <!-- /row -->

       <div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">PageLoading</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){
	 
	            	$("#submitBtn_showPageLoading").click(function(){
	                  GAEUI.pageLoading().play();
	                  setTimeout(function(){
	                    GAEUI.pageLoading().stop();
	                  },2000);
	              	});

	            });

	            </script>
	            <div id="submitBtn_showPageLoading" class="btn btn-primary">GAEUI.pageLoading().play()</div>
        	</div>
    	</div> <!-- /row -->

       <div class="demo-row demo-buttons">
	        <div class="demo-title">
	          <h3 class="demo-panel-title">PageLoading with progress</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">
	            
	            $(function(){

	            	$("#submitBtn_withPageloading_progress").click(function(){
	              
						var file_upload_mutilple = $("#file_upload_for_pageLoading").get(0);		
						var dataSend = {
							"file_upload_mutilple[]":file_upload_mutilple
						};

						GAEUI.pageLoading().play();
						CUR_MODULE.apiPost("start/testrequest",dataSend).then(function(res){
							GAEUI.pageLoading().stop();
							console.log("res ",res);
							GAEUI.notification.playComplete("Upload Complete!");
						}).onProgress(function(percent){
							GAEUI.pageLoading().updateProgress(percent);
						});
	             	});
	              	
	            });

	            </script>
	      		<div class="form-group">
	              <div class="fileinput fileinput-new" data-provides="fileinput">
	                <div class="input-group">
	                  <div class="form-control uneditable-input" data-trigger="fileinput">
	                    <span class="fui-clip fileinput-exists"></span>
	                    <span class="fileinput-filename"></span>
	                  </div>
	                  <span class="input-group-btn btn-file">
	                    <span class="btn btn-default fileinput-new" data-role="select-file">Select file</span>
	                    <span class="btn btn-default fileinput-exists" data-role="change"><span class="fui-gear"></span>&nbsp;&nbsp;Change</span>
	                    <input id="file_upload_for_pageLoading" type="file" multiple>
	                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>&nbsp;&nbsp;Remove</a>
	                  </span>
	                </div>
	              </div>
	            </div>
            	
            	<button id="submitBtn_withPageloading_progress" class="btn btn-primary">Submit with pageLoading And Progress</button>

            	 <div class="demo-type-example">
		            <p><small>ลองเลือกไฟล์ ขนาดใหญ่ หรือ รูปหลายๆ แล้วลอง submit จะสังเกตว่ามีตัวเลข progress วิ่งตาม</small></p>
          		</div>
	    
	        </div>
    	</div> <!-- /row -->

    	<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">Notification</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){

	            	$("#btn_notification_playComplete").click(function(){
	                  	GAEUI.notification().playComplete("Hello");
	              	});

	              	$("#btn_notification_playInfo").click(function(){
	                  	GAEUI.notification().playInfo("Hello info");
	              	});

	              	$("#btn_notification_playWarning").click(function(){
	                  	GAEUI.notification().playWarning("Hello info");
	              	});

	              	$("#btn_notification_playDanger").click(function(){
	                  	GAEUI.notification().playError("Hello info");
	              	});

	              	$("#btn_notification_playHtml").click(function(){
	                  	GAEUI.notification().playHTML('<div style=" margin:0px; background:white; position:absolute; top:0px; left:0px; width:100%;"><h2>Hello info</h2></div>');
	              	});

	            });

	            </script>
	            <div id="btn_notification_playComplete" class="btn btn-block btn-ori-primary">GAEUI.notification().playComplete()</div>

	            <div id="btn_notification_playInfo" class="btn btn-block btn-info">GAEUI.notification().playInfo()</div>

	            <div id="btn_notification_playWarning" class="btn btn-block btn-warning">GAEUI.notification().playWarning()</div>

	            <div id="btn_notification_playDanger" class="btn btn-block btn-danger">GAEUI.notification().playError()</div>

	             <div id="btn_notification_playHtml" class="btn btn-block btn-inverse">GAEUI.notification().playHTML()</div>
        	</div>
    	</div> <!-- /row -->

    	<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">ConfirmBox</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){
	            	
	            	$("#btn_confirmBox_play").click(function(){
	                  	GAEUI.confirmBox().play("Are you sure?","please confirm your action.",function(bool){
	                  		console.log("bool : "+bool);
	                  		if(!bool){
	                  			GAEUI.confirmBox().stop();
	                  		}else{
	                  			GAEUI.confirmBox().shake();
	                  		}
	                  		
	                  	},"Done");
	              	});

	            });

	            </script>
	            <div id="btn_confirmBox_play" class="btn btn-block btn-ori-primary">GAEUI.confirmBox().play()</div>

        	</div>
   		</div><!-- /row -->

   		<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">ConfirmBox - Stack </h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){
	            	
	            	$("#btn_confirmBox_play_with_stack").click(function(){
	                  	openConfirm(0);
	              	});

	              	function openConfirm(count){
	              		count++;
	              		GAEUI.confirmBox("id_"+count).play("Confirm stackof "+count," press create to create new stack : "+count,function(bool){
	                  		console.log("bool : "+bool);
	                  		if(bool){
	                  			openConfirm(count);
	                  		}else{
	                  			GAEUI.confirmBox("id_"+count).stop();
	                  		}
	                  	},"Create stack");
	              	}
	            });

	            </script>
	            <div id="btn_confirmBox_play_with_stack" class="btn btn-block btn-ori-primary">GAEUI.confirmBox(id).play()</div>

        	</div>
   		</div><!-- /row -->

   		<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">Alert</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){

	            	$("#btn_alert").click(function(){
	                  	GAEUI.alert().play("this is message","message description");
	              	});
	            });

	            </script>
	            <div id="btn_alert" class="btn btn-block btn-ori-primary">GAEUI.alert().play()</div>

        	</div>
   		</div><!-- /row -->


   		<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">Modal</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){

	            	var count = 0;
	            	$("#btn_modal_play").click(function(){

	            		var modalHTML  = 'message description<br><br><div id="btn_for_mydone_modal" class="pcb_btn_done btn btn-sm  btn-primary btn-gae-manager btn_for_mydone_modal">Done</div>';
	                  	
	                  	GAEUI.modal().play(null,modalHTML,function(){
	                  		$("#btn_for_mydone_modal").click(function(){
	              				GAEUI.modal().stop();
	              			});
	                  	});
	                  	
	              	});

	            });

	            </script>
	            <div id="btn_modal_play" class="btn btn-block btn-ori-primary">GAEUI.modal.play()</div>

        	</div>
   		</div><!-- /row -->

   		<div class="demo-row demo-buttons">
	        <div class="demo-title">
	          	<h3 class="demo-panel-title">Modal - stack</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	            $(function(){

	            	var count = 0;
	            	$("#btn_modal_play_withStack").click(function(){

	            		var modalHTML  = 'message description<br><br><div id="btn_for_mydone_modal" class="pcb_btn_done btn btn-sm  btn-default btn-gae-manager btn_for_mydone_modal">Done</div><div id="btn_for_myCreateNewStack" class="pcb_btn_done btn btn-sm  btn-primary btn-gae-manager ">Create new</div>';

	            		var modalHTML_2  = 'message description<br><br><div id="btn_for_mydone_modal_2" class="pcb_btn_done btn btn-sm  btn-default btn-gae-manager btn_for_mydone_modal">Close</div>';
	                  	
	                  	GAEUI.modal("myModal_1").play(null,modalHTML,function(){

	                  	});

	                  	$("#btn_for_mydone_modal").click(function(){
	              			GAEUI.modal("myModal_1").stop();
	              		});

              			$("#btn_for_myCreateNewStack").click(function(){
              				GAEUI.modal("myModal_2").play(null,modalHTML_2,function(){
              					$("#btn_for_mydone_modal_2").click(function(){
              						GAEUI.modal("myModal_2").stop();
              					});
              				});
              			});
	                  	
	              	});

	            });

	            </script>
	            <div id="btn_modal_play_withStack" class="btn btn-block btn-ori-primary">GAEUI.modal(id).play()</div>

        	</div>
   		</div><!-- /row -->
   		<div class="clear"></div>
</div><!--content-->

