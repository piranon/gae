<link rel="stylesheet" href="<?=$curModule->file_url; ?>/css/base.css">
<!--การเรียกไฟล์ css จาก module staticfiles -->  
<script src="<?=$curModule->file_url; ?>js/example.js"></script>
<!--การเรียกไฟล์ js จาก module staticfiles -->

<div class="article_ele">
	<h3>Menu Link</h3>
	<div class="description"> ตัวอย่าง การเชื่อมโยงระหว่าง  page view  จากตัวอย่างนี้จะทำการเรียกไปยังแต่ละ controller ที่อยู่ใน module/{version}/app/{controler-name}</div>
	<div class="example_data"> 
		<div class="menu_link_div">
		
			<a class="menu_btn" href="<?=$curModule->app_url; ?>start/index">start index</a>
			<a class="menu_btn" href="<?=$curModule->app_url; ?>start/test">start test</a>
			<a class="menu_btn" href="<?=$curModule->app_url; ?>car/index">car index</a>
			<a class="menu_btn" href="<?=$curModule->app_url; ?>car/content">car content</a>
		</div>
	</div>  
</div><!--END : article_ele-->

<div class="article_ele">
	<h3>For upload file</h3>
	<div class="description"> ตัวอย่าง ของการ upload file คลิ๊ก เหล่านี้ เพื่อดูตัวอย่าง</div>
	<div class="example_data"> 
		<div class="menu_link_div">
			<a class="menu_btn" href="<?=$curModule->app_url; ?>start/test_imageupload">test imageUpload</a>
			<a class="menu_btn" href="<?=$curModule->app_url; ?>start/single_imageupload">single imageUpload</a>
			<a class="menu_btn" href="<?=$curModule->app_url; ?>start/multiple_imageupload">multiple imageUpload</a>
		</div>
	</div>  
</div><!--END : article_ele-->


<div class="article_ele">
	<h3>View Data</h3>
	<div class="description"> ตัวอย่าง การรับค่าในหน้า view ( ค่าที่ส่งมาจาก controller ) จะอยู่ใน $viewData เสมอ  </div>
	<div class="example_data"> 
		<div>this is example 1 form : <?=$viewData["myData"]; ?></div>
		<hr>
		<div>
			<div class="label">var_dump : $viewData </div>
			<div class="value"><? var_dump($viewData); ?></div>
		</div>
	</div>  
</div><!--END : article_ele-->

<div class="article_ele">
	<h3>Current Module</h3>
	<div class="description"> ตัวอย่าง การใช้งาน curModule : แสดงข้อมูลของ module ปัจจุบัน </div>
	<div class="example_data"> 

		<div>
			<span class="label">module_id :</span>
			<span class="value"><?=$curModule->id; ?></span>
		</div>
		<hr>

		<div>
			<span class="label">module_bundle_id :</span>
			<span class="value"><?=$curModule->bundle_id; ?></span>
		</div>
		<hr>

		<div>
			<span class="label">module_version :</span>
			<span class="value"><?=$curModule->version; ?></span>
		</div>
		<hr>

		<div>
			<span class="label">app_url :</span>
			<span class="value"><?=$curModule->app_url; ?></span>
			<div class="hint">ใช้เพื่อแสดง site path เพื่อเข้าถึง webapp ของ module ปัจจุบัน นิยมใช้เพื่อทำการ link ไปยัง page ต่างๆ ใน module ( จะเรียกไปยัง {module}/{version}/app ) </div>
		</div>
		<hr>

		<div>
			<span class="label">api_url :</span>
			<span class="value"><?=$curModule->api_url; ?></span>
			<div class="hint">ใช้เพื่อแสดง site path  เพื่อเข้าถึง  api ของ module ปัจจุบัน ( จะเรียกไปยัง {module}/{version}/api ) </div>
		</div>
		<hr>

		<div>
			<span class="label">file_url :</span>
			<span class="value"><?=$curModule->file_url; ?></span>
			<div class="hint">ใช้เพื่อแสดง site path  ของ module staticfiles ปัจจุบัน จะใช้ในกรณีต้องการเรียก file js,css หรือ image ส่วนตัว ( จะเรียกไปยัง {module}/{version}/staticfiles ) </div>
		</div>
		<hr>

		<div>
			<div class="label">var_dump : $curModule </div>
			<div class="value"><? var_dump($curModule); ?></div>
		</div>
		<hr>
		
	</div>  
</div><!--END : article_ele-->


<div class="article_ele">
	<h3>Get Module Local Image ( staticfiles folder )</h3>
	<div class="description"> ตัวอย่าง การแสดงรูป ใน staticfiles folder ( local file )  </div>
	<div class="example_data"> 
		<img src="<?=$curModule->file_url;?>icon/card_info.png"/>
	</div>  
</div><!--END : article_ele-->


<div class="article_ele">
	<h3>Call to Module API  BY GET  ( by ajax )</h3>
	<div class="description"> ตัวอย่าง การเชื่อมต่อ api แบบ GET ด้วย CUR_MODULE ( jquery )</div>
	<div class="example_data"> 
		<div id="my_result_001"></div>
	</div>  
</div><!--END : article_ele-->
<script type="text/javascript">
	$(function(){
		CUR_MODULE.apiGet("start/testrequest").then(function (res) {
    		console.log("res",res);
    		$("#my_result_001").html(JSON.stringify(res));
    	});
	});
    /*
	with progress
	CUR_MODULE.apiGet("start/test_model").then(function (res) {
    	console.log("res",res);
    	$("#my_result_001").html(JSON.stringify(res));
    }).onProgress(function(percent){
    	console.log("progress : "+percent);
    });
    */
</script><!--END : script : article_ele-->



<div class="article_ele">
	<h3>Call to Module API BY GET WITH PARAMETER ( by ajax )</h3>
	<div class="description"> ตัวอย่าง การเชื่อมต่อ  api แบบ GET แล้วแนบ parameter CUR_MODULE ( jquery )</div>
	<div class="example_data"> 
		<div id="my_result_002"></div>
	</div>  
</div><!--END : article_ele-->
<script type="text/javascript">
    $(function(){
    	var dataSend = {
			"my_param1":"123456",
			"my_param2":"567890"
		}
		CUR_MODULE.apiGet("start/testrequest",dataSend).then(function (res) {
    		console.log("res",res);
    		$("#my_result_002").html(JSON.stringify(res));
	    }).onProgress(function(percent){
	    	console.log("progress : "+percent);
	    });
	});
</script><!--END : script : article_ele-->


<div class="article_ele">
	<h3>Call to Module API BY POST WITH PARAMETER ( by ajax )</h3>
	<div class="description"> ตัวอย่าง การเชื่อมต่อ  api แบบ POST แล้วแนบ parameter CUR_MODULE ( jquery ) สังเกตว่าจะเปลี่ยนจาก CUR_MODULE.apiGET() เป็น CUR_MODULE.apiPost()</div>
	<div class="example_data"> 
		<div id="my_result_003"></div>
	</div>  
</div><!--END : article_ele-->
<script type="text/javascript">
    $(function(){
    	var dataSend = {
			"my_param1":"123456",
			"my_param2":"567890"
		}
		CUR_MODULE.apiPost("start/testrequest",dataSend).then(function (res) {
    		console.log("res",res);
    		$("#my_result_003").html(JSON.stringify(res));
	    }).onProgress(function(percent){
	    	console.log("progress : "+percent);
	    });
	});
</script><!--END : script : article_ele-->
<!-- 

ANGULAR JS

-->
<div ng-app="module_app">
	<div ng-controller="test_request" >

		<div class="article_ele">
			<h3>Call to api ( main system ) BY GET </h3>
			<div class="description"> ตัวอย่าง การเชื่อมต่อ api ด้วย GAEAPI ( ANGULAJS ) แบบ GET </div>
			<div class="example_data"> 
				<div class="call">
					call : {{ api_call }}	
				</div>
				<hr>
				<div class="result">
					{{ ang_result_001 }}	
				</div> 
			</div>  
		</div><!--END : article_ele-->

		<div class="article_ele">
			<h3>Call to api ( main system ) BY GET WITH PARAM </h3>
			<div class="description"> ตัวอย่าง การเชื่อมต่อ api ด้วย GAEAPI ( ANGULAJS ) แบบ GET แล้วแนบ PARAMETER </div>
			<div class="example_data"> 
				<div class="call">
						call : {{ api_call }}	
				</div>
				<hr>
				<div class="result">
					{{ ang_result_002 }}	
				</div> 
			</div>  
		</div><!--END : article_ele-->


		<div class="article_ele">
			<h3>Call to api ( main system ) BY POST WITH PARAM </h3>
			<div class="description"> ตัวอย่าง การเชื่อมต่อ api ด้วย GAEAPI ( ANGULAJS ) แบบ POST แล้วแนบ PARAMETER </div>
			<div class="example_data"> 
				<div class="call">
					call : {{ api_call }}	
				</div>
				<hr>
				<div class="result">
					{{ ang_result_003 }}	
				</div>
			</div>  
		</div><!--END : article_ele-->

	</div>
</div><!-- end :: ng-app : module_app-->


<script src="<?=base_ngservices_url(); ?>GAEAPI.js"></script>
<!--การเรียก service จาก main system -->
<script type="text/javascript">
var module_app = angular.module('module_app', ['ngRoute','ngAnimate','GAEAPI']);
module_app.controller('test_request', function ($scope, $rootScope ,  GAEAPI) {

	

	$scope.ang_result_001 = "Loading..";
	$scope.ang_result_002 = "Loading..";
	$scope.ang_result_003 = "Loading..";

	$scope.api_call = "connect/testrequest";
	GAEAPI.get($scope.api_call).then(function (res) {
		$scope.$apply(function(){
			$scope.ang_result_001 = res;
		});		
	});


	var dataSend ={
		"my_param1":"123456",
		"my_param2":"567890"
	}
	// GET WITH PARAM
	GAEAPI.get($scope.api_call).then(function (res) {
		$scope.$apply(function(){
			$scope.ang_result_002 = res;
		});		
	});

	// POST WITH PARAM
	GAEAPI.post($scope.api_call,dataSend).then(function (res) {
		$scope.$apply(function(){
			$scope.ang_result_003 = res;
			
		});		
	});

});
</script>





