var app = angular.module('app', ['ngRoute', 'ui.list','GAESERVICE']);
app.config(function ($routeProvider, $locationProvider, $httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    /*
    $routeProvider
            .when('/', {
                //templateUrl: "list-page.html"
            })
            .when('/page/:cur_page/:per_page', {
                templateUrl: "list-page.html",
                controller: 'pageController',
                pageIndex: 1
            })
            .otherwise({
                //templateUrl: "list-page.html"
            });
    */
});

              
app.controller('pageController', function ($scope, $rootScope, $location, $routeParams, LISTPROVIDER,GAEAPI) {
    
    /*
    $rootScope.$on('$routeChangeSuccess',function (scope, event, currRoute, prevRoute) {
        // when route changed 
        console.log("\n-----------------");
        console.log($routeParams.cur_page);
        console.log($routeParams.per_page);
        //alert("routeChangeSuccess");
    });
    */

    LISTPROVIDER.start($scope);
    LISTPROVIDER.setSearchEnable(1);
    LISTPROVIDER.setSortbyEnable(1);
    LISTPROVIDER.sectionDisplay(1,1,1);
    LISTPROVIDER.actionBoxDisplay(1,1,1);
    LISTPROVIDER.setDefaultPerPage(2);
    LISTPROVIDER.setMaxPageNav(5);
    LISTPROVIDER.setCellRender(function(){
        return "{{ itemData.product_name }}";
    });
    
    LISTPROVIDER.onPageChange(function(routeParams){

        LISTPROVIDER.addLoadStack();
        GAEAPI.get("product/sortby",dataSend).then(function (res) {
            LISTPROVIDER.deLoadStack();
            LISTPROVIDER.setSortbyData(res.data);
        });
        
        var dataSend = {
            "cur_page":routeParams.cur_page,
            "per_page":routeParams.per_page,
            "txt_sortby":routeParams.sortby
        };
        var api_call = "product/lists";
        if(routeParams.search!=""){
            api_call = "product/search";
            dataSend.txt_search = routeParams.search;
        }
        LISTPROVIDER.addLoadStack();
        GAEAPI.get(api_call,dataSend).then(function (res) {
            LISTPROVIDER.deLoadStack();
            console.log("res.data : "+res.data);
            LISTPROVIDER.setFiledId("product_id");
            LISTPROVIDER.setTotalRow(res.data.total_rows);
            LISTPROVIDER.setDataList(res.data.dataList);
        });

    });
    LISTPROVIDER.onClearLoadStack(function(){
        alert("clear");
    });
    LISTPROVIDER.onCreateNew(function(){
        console.log("onCreateNew");
    });
    LISTPROVIDER.onDelete(function(idArray){
        console.log("onDelete : "+idArray);
    });
    LISTPROVIDER.onView(function(id){
        console.log("onView : "+id);
    });
    LISTPROVIDER.onEdit(function(id){
        console.log("onEdit : "+id);
    });

});


