<?  
  $docs_dir_url = root_sitefiles_url()."flat-ui/UI/pro/docs/";
?>
    
    <h1 class="demo-headline text-gae-primary">Basic Elements</h1>

    <div class="container">
       <div class="demo-row demo-buttons">
        <div class="demo-title">
          <h2 class="demo-panel-title">GAEUI</h2>
        </div>
    </div> <!-- /row -->

    <div class="container">
       <div class="demo-row demo-buttons">
	        <div class="demo-title">
	          <h3 class="demo-panel-title">PageLoading</h3>
	        </div>
	        <div class="demo-content">
             <script type="text/javascript">
              function showPageLoading(){
                  GAEUI.pageLoading.play();
                  setTimeout(function(){
                    GAEUI.pageLoading.stop();
                  },2000);
              }
            </script>
            <button onclick="showPageLoading()" class="btn btn-primary">GAEUI.pageLoading.play()</button>

        	</div>
    	</div> <!-- /row -->

       <div class="demo-row demo-buttons">
	        <div class="demo-title">
	          <h3 class="demo-panel-title">PageLoading with progress</h3>
	        </div>
	        <div class="demo-content">
	            <script type="text/javascript">

	              function submitPageLoadinWithProgress(){
	                  
                
	              }

	            </script>
	            <form>

	            	 <button onclick="submitPageLoadinWithProgress()" class="btn btn-primary">submi with pageLoading</button>
	            </form>
	           

	        </div>
    	</div> <!-- /row -->
   	</div>
