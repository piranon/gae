angular.module('ui.list', [])
        .factory('LISTPROVIDER', function ($http, $q) { // API 
            var $scope ={};
            var PROMISE = {
                controllerName:"listController",
                serviceHost: 'http://localhost/pluginlist/new/',
                start:function(scope){
                    $scope = scope;
                    var listViewDisplay = {
                        pageNavData:{},
                        createEnable:1,
                        searchEnable:1,
                        sortbyEnable:1,
                        actionBarDisplay:1,
                        checkbox:1,
                        contentBox:1,
                        actionBox:1,
                        default_per_page:20,
                        last_cur_page:-1,
                        last_per_page:-1,
                        lastPageNum:-1,
                        last_sortby:"",
                        last_search:"",
                        search_text:"",
                        search_url:"",
                        msgNoResult:"No result.",
                        keyFieldId:"",
                        pageNavNumber:5,
                        loadStack:0
                    };
                    $scope.listViewDisplay = listViewDisplay;
                    $scope.html = 'Hello {{ itemData }}';
                    var pageNavData ={};
                    pageNavData.extend_url = "";
                    $scope.listViewDisplay.pageNavData = pageNavData;
                },
                setCreateEnable:function(createEnable){
                    if(!createEnable){ createEnable = 0; }
                    $scope.listViewDisplay.createEnable = createEnable;
                },
                setSearchEnable:function(searchEnable){
                    if(!searchEnable){ searchEnable = 0; }
                    $scope.listViewDisplay.searchEnable = searchEnable;
                },
                setSortbyEnable:function(sortbyEnable){
                    if(!sortbyEnable){ sortbyEnable = 0; }
                    $scope.listViewDisplay.sortbyEnable = sortbyEnable;
                },
                sectionDisplay:function(checkbox,contentBox,actionBox){
                    if(!checkbox){ checkbox = 0; }
                    if(!contentBox){ contentBox = 0;}
                    if(!actionBox){ actionBox = 0; }
                    
                    $scope.listViewDisplay.checkbox = checkbox;
                    $scope.listViewDisplay.contentBox = contentBox;
                    $scope.listViewDisplay.actionBox = actionBox;
                },
                actionBoxDisplay:function(viewButton,editButton,deleteButton){
                    if(!viewButton){ viewButton = 0; }
                    if(!editButton){ editButton = 0;}
                    if(!deleteButton){ deleteButton = 0; }
                    var actionBoxDisplay = {
                        viewButton:viewButton,
                        editButton:editButton,
                        deleteButton:deleteButton
                    };
                    $scope.listViewDisplay.actionBoxDisplay = actionBoxDisplay;
                },
                setCellRender:function(cellRenderFunction){
                    $scope.listViewDisplay.itemCellRenderhtml = cellRenderFunction();
                },
                cellRender:function(itemData){
                },
                setSortbyData:function(dataList){

                    var pageNavData = $scope.listViewDisplay.pageNavData;
                    var search_url = $scope.listViewDisplay.search_url;
                    var sortbyData = dataList;
                    var currentSoryByData = {};
                    var rowHTML = "";

                    for(key in dataList){
                        var sortByItem = dataList[key];
                        if(typeof pageNavData.sortby_id === "undefined"){
                            if(sortByItem.default==1){
                                currentSoryByData = sortByItem; 
                                rowHTML += '<li class="disabled"><a href="">'+sortByItem.label+'</a></li>';
                            }else{
                                rowHTML += '<li ><a href="#page/'+pageNavData.cur_page+"/"+pageNavData.per_page+"/"+sortByItem.id+pageNavData.extend_url+search_url+'">'+sortByItem.label+'</a></li>';
                            }

                        }else{
                            if(pageNavData.sortby_id==sortByItem.id){
                                currentSoryByData = sortByItem; 
                                rowHTML += '<li class="disabled"><a href="">'+sortByItem.label+'</a></li>';
                            }else{
                                rowHTML += '<li ><a href="#page/'+pageNavData.cur_page+"/"+pageNavData.per_page+"/"+sortByItem.id+pageNavData.extend_url+search_url+'">'+sortByItem.label+'</a></li>';
                            }
                        }
                    }
                    $scope.listViewDisplay.currentSoryByData = currentSoryByData;
                    var strHTML = '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" > Sort by : '+currentSoryByData.label+' <span class="caret"></span></button>';
                    strHTML +='<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">'+rowHTML+'</ul>';
                    $scope.listViewDisplay.sortbyDropdownRenderHTML = strHTML;
                    $scope.listViewDisplay.pageNavData = pageNavData;

                },
                setFiledId:function(filedId){
                    $scope.listViewDisplay.keyFieldId = filedId;
                },
                setDataList:function(dataList){
                    var self = this;
                    var keyFieldId = $scope.listViewDisplay.keyFieldId;
                    var newItemsList = [];
                    for(index in dataList){
                        var itemData = dataList[index];
                        for(key in itemData){
                            if(key==keyFieldId){
                                itemData.filedId = itemData[key];
                                itemData.checkboxIsSelected = false;
                                newItemsList.push(itemData);
                            }
                        }
                    }
                    $scope.listViewDisplay.itemsList = newItemsList;
                },
                checkboxSelectAll:function(){
                    var dataList = $scope.listViewDisplay.itemsList;
                    for(index in dataList){
                        dataList[index].checkboxIsSelected = true;
                    }
                    $scope.listViewDisplay.itemsList = dataList;
                },
                checkboxUnselectAll:function(){
                    var dataList = $scope.listViewDisplay.itemsList;
                    for(index in dataList){
                        dataList[index].checkboxIsSelected = false;
                    }
                    $scope.listViewDisplay.itemsList = dataList;
                },
                getSelectedIds:function(){
                    var dataList = $scope.listViewDisplay.itemsList;
                    var seletedItems = [];
                    for(index in dataList){
                        if(dataList[index].checkboxIsSelected == true){
                            seletedItems.push(dataList[index].filedId);
                        }
                    }
                    return seletedItems;
                },
                deleteSelectedIds:function(seletedItems){
                    if($scope.listViewDisplay.onDelete_callback){
                        $scope.listViewDisplay.onDelete_callback(seletedItems);
                    }
                },
                onDelete:function(callback){
                    $scope.listViewDisplay.onDelete_callback = callback;
                },
                viewById:function(id){
                    if($scope.listViewDisplay.onView_callback){
                        $scope.listViewDisplay.onView_callback(id);
                    }
                },
                onView:function(callback){
                    $scope.listViewDisplay.onView_callback = callback;
                },
                editById:function(id){
                    if($scope.listViewDisplay.onEdit_callback){
                        $scope.listViewDisplay.onEdit_callback(id);
                    }
                },
                onEdit:function(callback){
                    $scope.listViewDisplay.onEdit_callback = callback;
                },
                onPageChange:function(callback){
                    //alert("set-onPageChange");
                    $scope.listViewDisplay.pageChange_callback = callback;
                },
                callCreateNew:function(){
                    if($scope.listViewDisplay.createNew_callback){
                        $scope.listViewDisplay.createNew_callback();
                    }
                },
                onCreateNew:function(callback){
                    $scope.listViewDisplay.createNew_callback = callback;
                },
                callPageChange:function(routeParams){
                    //alert("set-callPageChange");
                    if($scope.listViewDisplay.pageChange_callback){
                        $scope.listViewDisplay.pageChange_callback(routeParams);
                    }
                },
                addLoadStack:function(){
                    $scope.listViewDisplay.loadStack +=1;
                },
                deLoadStack:function(){
                    $scope.listViewDisplay.loadStack -=1;
                    if($scope.listViewDisplay.loadStack<=0){
                        $scope.listViewDisplay.loadStack =0;
                         if($scope.listViewDisplay.clearLoadStack_callback){
                            $scope.listViewDisplay.clearLoadStack_callback($scope.listViewDisplay);
                        }
                    }
                },
                onClearLoadStack:function(callback){
                    $scope.listViewDisplay.clearLoadStack_callback = callback;
                },
                setMaxPageNav:function(max_number){ 
                    $scope.listViewDisplay.pageNavNumber = max_number;
                },
                setTotalRow:function(total_row){
                    total_row = parseInt(total_row);
                    var pageNavData =  $scope.listViewDisplay.pageNavData;
                    pageNavData.total_row = total_row;
                    var per_page = parseInt(pageNavData.per_page);
                    var cur_page = parseInt(pageNavData.cur_page);
                    var total_page = Math.ceil(total_row/per_page);
                    var allowPrevBtn = 1;
                    var allowNextBtn = 1;
                    if(cur_page<=1){
                        allowPrevBtn = 0;
                    }
                    if(cur_page>=total_page){
                        allowNextBtn = 0;
                    }
                    if(isNaN(total_page)){
                        total_page = 0;
                    }

                    var max_nav_btn = $scope.listViewDisplay.pageNavNumber;
                    var start_pageIndex = 1;
                    var end_pageIndex = total_page;
                    var half_max_nav_btn = Math.floor(max_nav_btn/2);
                    var add_page_num = max_nav_btn-1;

                    if((total_page>max_nav_btn)&&(max_nav_btn>=0)){
                        if(cur_page<half_max_nav_btn){
                            start_pageIndex = 1;
                            end_pageIndex = start_pageIndex+add_page_num;
                        }else if(cur_page>(total_page-half_max_nav_btn)){
                            start_pageIndex = (total_page-max_nav_btn)+1;
                            end_pageIndex = total_page;
                        }else{
                            start_pageIndex = cur_page-half_max_nav_btn;
                            if((max_nav_btn%2)==0){
                                start_pageIndex +=1;
                            }
                            if(start_pageIndex<1){
                                start_pageIndex = 1;
                            }
                            end_pageIndex = start_pageIndex+add_page_num;
                        }
                    }

                    console.log("total_page : "+total_page+" : max_nav_btn : "+max_nav_btn);
                    console.log("cur_page : "+cur_page+" : half_max_nav_btn : "+half_max_nav_btn);
                    console.log("start_pageIndex : "+start_pageIndex+" : end_pageIndex : "+end_pageIndex);

                    var pageBtn_array = [];
                    for(i=start_pageIndex;i<=end_pageIndex;i++){
                        var pageData = {};
                        pageData.pageNum = i;
                        pageBtn_array.push(pageData);
                    }

        
                    pageNavData.cur_page = cur_page;
                    pageNavData.frist_page = 1;
                    pageNavData.last_page = total_page;
                    pageNavData.prev_page = parseInt(cur_page)-1;
                    pageNavData.next_page = parseInt(cur_page)+1;
                    pageNavData.per_page = per_page;
                    pageNavData.total_row = total_row;
                    pageNavData.total_page = total_page; 
                    pageNavData.allowPrevBtn = allowPrevBtn;
                    pageNavData.allowNextBtn = allowNextBtn;
                    pageNavData.pageBtn_array = pageBtn_array;
                
                    this.generateCurrentPageUrl();

                    $scope.listViewDisplay.pageNavData = pageNavData;
    
                },
                generateCurrentPageUrl:function(){   

                    var pageNavData =  $scope.listViewDisplay.pageNavData;

                    var url_after_cur_page = "/"+pageNavData.per_page;
                    if(pageNavData.sortby_id){
                        url_after_cur_page +="/"+pageNavData.sortby_id; 
                    }
                    if(pageNavData.extend_url){
                        url_after_cur_page += pageNavData.extend_url;
                    }
                    url_after_cur_page += $scope.listViewDisplay.search_url;
                    
                    var current_page_url = pageNavData.cur_page+url_after_cur_page;

                    pageNavData.current_page_url = current_page_url;
                    pageNavData.url_after_cur_page = url_after_cur_page;

                    $scope.listViewDisplay.pageNavData = pageNavData;

                    return current_page_url;
                },
                setCurrentPageNav:function(cur_page,per_page){

                    var pageNavData = {};
                    if((cur_page<1)||(typeof cur_page === "undefined")){
                        cur_page = 1;
                    }
                    if((per_page<1)||(typeof per_page === "undefined")){
                        per_page = $scope.listViewDisplay.default_per_page;
                    }

                    $scope.listViewDisplay.pageNavData.cur_page = cur_page;
                    $scope.listViewDisplay.pageNavData.per_page = per_page;
                },
                setMsgNoResult:function(msg){
                    $scope.listViewDisplay.msgNoResult = msg;
                },
                setDefaultPerPage:function(per_page){
                    $scope.listViewDisplay.default_per_page = per_page;
                },
                setCurrentSortby:function(sortby){
                    $scope.listViewDisplay.pageNavData.sortby_id = sortby;
                },
                setExtendUrlText:function(extend_url){
                    $scope.listViewDisplay.pageNavData.extend_url = extend_url;
                },
                setSearchText:function(search_text){
                    
                    if(typeof search_text === "undefined"){
                        search_text = "";
                    }
                    var con_str = "?";
                    if($scope.listViewDisplay.pageNavData.extend_url.trim()!=""){
                        con_str = "&";
                    }
                    var search_url = con_str+"search="+search_text;
                    if(search_text==""){
                        search_url = "";
                    }
                    $scope.listViewDisplay.search_text = search_text.trim();
                    $scope.listViewDisplay.search_url = search_url;
                    
                    $scope.listViewDisplay.txt_search = search_text;
                    
                    
                },
                clearSearchText:function(){
                    $scope.listViewDisplay.search_text = "";
                    $scope.listViewDisplay.search_url = "";
                }

            };
            return PROMISE;
        })
        .config(function ($routeProvider, $locationProvider, $compileProvider, $httpProvider) {
            $httpProvider.defaults.useXDomain = true;
            delete $httpProvider.defaults.headers.common['X-Requested-With'];
            $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

            $compileProvider.debugInfoEnabled(false);

            $routeProvider
                .when('/', {
                    templateUrl: "list-page.html",
                    controller: 'listController'
                })
                .when('/page/:cur_page/:per_page', {
                    templateUrl: "list-page.html",
                    controller: 'listController'
                })
                .when('/page/:cur_page/:per_page/:sortby', {
                    templateUrl: "list-page.html",
                    controller: 'listController'
                })
                .otherwise({
                    templateUrl: "list-page.html",
                    controller: 'listController'
                });

        })
        .controller('listController', function ($scope, $rootScope, $location, $routeParams, LISTPROVIDER) {
            
            $scope.$on('$routeChangeSuccess',function (scope, event, currRoute, prevRoute) {
                // when route changed 
                var last_cur_page = $scope.listViewDisplay.last_cur_page;
                var last_per_page = $scope.listViewDisplay.last_per_page;
                var last_sortby = $scope.listViewDisplay.pageNavData.last_sortby;
                var last_search = $scope.listViewDisplay.pageNavData.last_search;
                var cur_page = $routeParams.cur_page;
                var per_page = $routeParams.per_page;
                var sortby = $routeParams.sortby;
                var search = $routeParams.search;

                if((last_cur_page != cur_page)||(last_per_page != per_page)||(last_sortby != sortby)||(last_search != search)){
                    $scope.listViewDisplay.last_cur_page = cur_page;
                    $scope.listViewDisplay.last_per_page = per_page;
                    $scope.listViewDisplay.last_sortby = sortby;
                    $scope.listViewDisplay.last_search = search;

                    LISTPROVIDER.setCurrentPageNav(cur_page,per_page);

                    $routeParams.cur_page = $scope.listViewDisplay.pageNavData.cur_page;
                    $routeParams.per_page = $scope.listViewDisplay.pageNavData.per_page;
                    LISTPROVIDER.setSearchText(search);
                    $routeParams.search = $scope.listViewDisplay.search_text;

                    LISTPROVIDER.setCurrentSortby(sortby);
                    LISTPROVIDER.callPageChange($routeParams);
                }
            });
            
            $scope.listViewDisplay.checkboxSelectAll = function(){
                LISTPROVIDER.checkboxSelectAll();
            };

            $scope.listViewDisplay.checkboxUnselectAll = function(){
                LISTPROVIDER.checkboxUnselectAll();
            };
            $scope.listViewDisplay.deleteSelectedIds = function(){
                var seletedItems = LISTPROVIDER.getSelectedIds();
                LISTPROVIDER.deleteSelectedIds(seletedItems);
            };
            $scope.listViewDisplay.deleteById = function(id){
                var seletedItems = [id];
                LISTPROVIDER.deleteSelectedIds(seletedItems);
            };
            $scope.listViewDisplay.viewById = function(id){
                LISTPROVIDER.viewById(id);
            };
            $scope.listViewDisplay.editById = function(id){
                LISTPROVIDER.editById(id);
            };

            /*
            $scope.$watch('listViewDisplay.txt_search', function () {
                alert("checkboxs : changed : "+$scope.master);
            });
            */

            $scope.listViewDisplay.searchClicked = function(){
                
                var txt_search =  $scope.listViewDisplay.txt_search;
                if((txt_search=="")||(typeof txt_search === "undefined")){
                    LISTPROVIDER.setTotalRow(0);
                }

                LISTPROVIDER.setSearchText(txt_search);
                var pageNavData = $scope.listViewDisplay.pageNavData;
                pageNavData.cur_page = 1;
                pageNavData.per_page = $scope.listViewDisplay.default_per_page;
                $scope.listViewDisplay.pageNavData = pageNavData;
                LISTPROVIDER.generateCurrentPageUrl();
                var current_page_url = $scope.listViewDisplay.pageNavData.current_page_url;
                window.location.href = "#page/"+current_page_url;
            };

            $scope.listViewDisplay.createNewBtnClicked = function(){
                LISTPROVIDER.callCreateNew();
            };

        })
        .directive('uiList', function (LISTPROVIDER) {
            var serviceHost = LISTPROVIDER.serviceHost;
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: serviceHost + 'list-layout.html'
            };
        })
        .directive('uiListNav', function (LISTPROVIDER) {
            var serviceHost = LISTPROVIDER.serviceHost;
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: serviceHost + 'list-nav.html'
            };
        })
        .directive('compile', function ($compile) {
            return function(scope, element, attrs) {
                scope.$watch(
                  function(scope) {
                    return scope.$eval(attrs.compile);
                  },
                  function(value) {
                    element.html(value);
                    $compile(element.contents())(scope);
                  }
                );
            };
        });

        

