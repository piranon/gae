
this is shipment form : <?=$something; ?>
<hr>

api_url : <?=$curModule->api_url; ?>
<hr>

show image from local : 
<br>
<img src="<?=$curModule->file_url;?>icon/card_info.png"/>
<hr>
<div ng-app="module_app">
<div ng-controller="test_request" >
	<div class="call">
		call : {{ api_call }}	
	</div>
	<hr>
	<div class="result">
		{{ testrequest }}	
	</div>
</div>
</div>

<script type="text/javascript">

var module_app = angular.module('module_app', ['ngRoute','ngAnimate','GAEAPI','GFLASH','NOTIBOX','POPUPBOX','PAGELOADING','GFORM','GLIST']);
module_app.controller('test_request', function ($scope, $rootScope ,  GAEAPI) {

	$scope.testrequest = "Loading..";
	$scope.api_call = "module/api/"+module_id+"/start/testrequest";
	GAEAPI.get($scope.api_call).then(function (res) {
		$scope.$apply(function(){
			$scope.testrequest = res;
		});
		
	});

});
</script>
