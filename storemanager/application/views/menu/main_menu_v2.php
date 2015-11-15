<style type="text/css">
	.header_menu{ background: #FF5000; width: 100%; min-height: 60px; padding: 0px; }
	.header_menu a{ text-decoration: none; }
		.mainmenu_root{ padding: 20px 10px; text-align: center;  }
		.mainmenu_root .btn_root{ font-size: 16px; padding: 6px 8px; margin: 10px 16px; text-align: center;   color: #fff; border-radius: 10px;   }
		.mainmenu_root .btn_root:hover{ background: rgba(0,0,0,0.3); }
		.mainmenu_root .btn_root.active{ background: rgba(0,0,0,0.3); }

		.mainmenu_sub{ padding: 16px 0px; margin: 0px; text-align: center; background: rgba(0,0,0,0.15);   }
		.mainmenu_sub .btn_sub{ font-size: 16px; padding: 6px 30px; width: 120px;  margin: 10px 10px; text-align: center;   color: #fff; border-radius: 20px; background: #FF5000; }
		.mainmenu_sub .btn_sub:hover{  background: rgba(0,0,0,0.3); }
		.mainmenu_sub .btn_sub.active{ background: rgba(0,0,0,0.3); }

		.mainmenu_addon{ background: #333333; min-height: 80px; }
		.mainmenu_addon .menu_div{ padding: 20px 0px; text-align: center;}
		.mainmenu_addon .menu_div .btn_sub{ font-size: 16px; padding: 6px 10px; width: 120px;  margin: 10px 10px; text-align: center;   color: #fff; border-radius: 20px; }
		.mainmenu_addon .menu_div .btn_sub:hover{ background: rgba(0,0,0,0.8); }
		.mainmenu_addon .menu_div .btn_sub.active{ background: rgba(0,0,0,0.8); }
</style>


<div class="header_menu" >
	<div ng-controller="pageMainMenu" >
		<div class="mainmenu_root">
			<a href="#" class="btn_root {{ row.css_active_btn }}" ng-repeat="(index, row)  in mainmenu_root">{{row.menu_label}}</a>
		</div>
		<div class="mainmenu_sub">
			<div class="menu_div">
				<a href="<?=base_url()."dashboard/menu/";?>{{row.menu_id}}" class="btn_sub {{row.css_active_btn}}"  ng-repeat="(index, row)  in mainmenu_sub">{{row.menu_label }}</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="mainmenu_addon">
			<div class="menu_div">
				<a href="<?=base_url()."dashboard/module/";?>{{row.module_id}}" class="btn_sub {{row.css_active_btn}}" ng-repeat="(index, row)  in mainmenu_addon">{{row.addon_menu.label}}</a>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var menu_id = '<?=nTob(@$viewData["menu_id"]); ?>';
	var module_id = '<?=nTob(@$viewData["module_id"]); ?>';
</script>
<script src="<?php echo base_ngservices_url(); ?>GAEAPI.js"></script>
<script src="<?php echo base_ngservices_url(); ?>pageloading/PAGELOADING.js"></script>
<script type="text/javascript">
var header_main_menu = angular.module('app_pageHeader', ['ngRoute','ngAnimate','GAEAPI']);
              
header_main_menu.controller('pageMainMenu', function ($scope, $rootScope, $location, $routeParams,  GAEAPI) {
	$scope.menu_id = menu_id;
	$scope.module_id = module_id;
	$scope.mainmenu_root = [];
	$scope.mainmenu_sub = [];
	$scope.mainmenu_addon = [];

	//PAGELOADING.play();
    GAEAPI.get("home/main_menu").then(function (res) {
    	console.log("home/main_menu : ",res);
		 var total_main_menu = res.data.main_menu;
		 if($scope.module_id!=""){
 			total_main_menu = makeMenuActive("module",$scope.module_id,total_main_menu);
 		 }else{
 			total_main_menu = makeMenuActive("menu",$scope.menu_id,total_main_menu);
 		 }
    	 $scope.$apply(function(){
    	 	 $scope.mainmenu_root = total_main_menu;
    	 	 $scope.mainmenu_sub = total_main_menu[0].menu_sub;
    	 });    	
    });


    function makeMenuActive(type,item_id,main_menu){

    	var css_active_btn = "active";
    	for(var root_index in main_menu){
    		var root_row = main_menu[root_index];
    		var menu_sub = root_row["menu_sub"];
    		for(sub_index in menu_sub){
    			var sub_row = menu_sub[sub_index];
    			if(type=="menu"){
    				if(sub_row["menu_id"]==item_id){
    					root_row.css_active_btn = css_active_btn;
    					sub_row.css_active_btn = css_active_btn;
    					$scope.$apply(function(){
    						$scope.mainmenu_addon = sub_row["menu_addon"];
    					});
    					return main_menu;
    					break;
    				}
    			}else if(type=="module"){
	    			var menu_addon = sub_row["menu_addon"];
	    			for(addon_index in menu_addon){
	    				var addon_row = menu_addon[addon_index];
	    				console.log("module_id : "+addon_row["module_id"]+" : module_id : "+module_id);

	    				if(addon_row["module_id"]==module_id){
	    					root_row.css_active_btn = css_active_btn;
	    					sub_row.css_active_btn = css_active_btn;
	    					addon_row.css_active_btn = css_active_btn;

	    					$scope.$apply(function(){
	    						$scope.mainmenu_addon = menu_addon;
	    					});
	    					return main_menu;
	    					break;
	    				}
	    			}
    			}
    		}
    	}
    	return main_menu;
    }

});

</script>