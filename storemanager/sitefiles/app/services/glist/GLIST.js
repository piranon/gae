angular.module('GLIST', [])
        .factory('GLIST', function ($http, $q) { // API 
            var $scope ={};
            var PROMISE = {
                controllerName:"listController",
                start:function(scope){
                    $scope = scope;
                    var listViewDisplay = {
                        pageNavData:{},
                        createEnable:1,
                        searchEnable:1,
                        sortbyEnable:1,
                        navBarZeroPageisHide:0,
                        toolbarDisplay:{
                            headerEnable:1,
                            footerEnable:1
                        },
                        navBarDisplay:{
                            headerEnable:1,
                            footerEnable:1
                        },
                        actionBarDisplay:{
                            headerEnable:1,
                            footerEnable:1,
                            deleteAllBtnEnable:1
                        },
                        noResultEnable:1,
                        checkbox:1,
                        contentBox:1,
                        actionBox:1,
                        sectionSize:{
                            checkbox:4,
                            contentBox:60,
                            actionBox:30
                        },
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
                    $scope.listViewDisplay.listIsVisible = 0;
                },
                setToolBarDisplay:function(headerEnable,footerEnable){
                    $scope.listViewDisplay.toolbarDisplay.headerEnable = headerEnable;
                    $scope.listViewDisplay.toolbarDisplay.footerEnable = footerEnable;
                },
                setNavBarDisplay:function(headerEnable,footerEnable){
                    $scope.listViewDisplay.navBarDisplay.headerEnable = headerEnable;
                    $scope.listViewDisplay.navBarDisplay.footerEnable = footerEnable;                   
                },
                setNavBarZeroPageisHide:function(enable){
                    $scope.listViewDisplay.navBarZeroPageisHide = enable;                
                },
                setActionBarDisplay:function(headerEnable,footerEnable){
                    $scope.listViewDisplay.actionBarDisplay.headerEnable = headerEnable;
                    $scope.listViewDisplay.actionBarDisplay.footerEnable = footerEnable;
                },
                setActionBarDeleteAllEnable:function(enable){
                    $scope.listViewDisplay.actionBarDisplay.deleteAllBtnEnable = enable;
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
                setNoResultEnable:function(enable){
                    if(!enable){ enable = 0; }
                    $scope.listViewDisplay.noResultEnable = enable;
                },
                sectionDisplay:function(checkbox,contentBox,actionBox){
                    if(!checkbox){ checkbox = 0; }
                    if(!contentBox){ contentBox = 0;}
                    if(!actionBox){ actionBox = 0; }
                    
                    $scope.listViewDisplay.checkbox = checkbox;
                    $scope.listViewDisplay.contentBox = contentBox;
                    $scope.listViewDisplay.actionBox = actionBox;


                    var sectionSize = $scope.listViewDisplay.sectionSize;
                    sectionSize.checkbox = 4;
                    sectionSize.contentBox = 60;
                    sectionSize.actionBox = 30;

                    var extend_width = 0;
                    if(checkbox==1){
                        extend_width += sectionSize.checkbox;
                    }
                    if(actionBox==1){
                        extend_width += sectionSize.actionBox;
                    }

                    console.log("extend_width : "+extend_width+" : checkbox : "+checkbox+" : actionBox : "+actionBox);
                    if(contentBox==1){

                        if(extend_width<=0){
                            sectionSize.contentBox = 100;
                        }else{
                            sectionSize.contentBox = (100-6)-extend_width;
                        }
                    }
                    $scope.listViewDisplay.sectionSize = sectionSize;
                    
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

                    var self = this;
                    var pageNavData = $scope.listViewDisplay.pageNavData;
                    var search_url = $scope.listViewDisplay.search_url;
                    var sortbyData = dataList;
                    var currentSoryByData = {};
                    var rowHTML = "";

                    for(key in dataList){
                        var sortByItem = dataList[key];
                        if(self.undefinedToBlank(pageNavData.sortby_id) == ""){
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
                setFiledId:function(fieldId){
                    this.setFieldId(fieldId);
                },
                setFieldId:function(fieldId){
                    $scope.listViewDisplay.keyFieldId = fieldId;
                },
                setDataList:function(dataList){
                    var self = this;
                    var keyFieldId = $scope.listViewDisplay.keyFieldId;
                    var newItemsList = [];
                    for(index in dataList){
                        var itemData = dataList[index];
                        for(key in itemData){
                            if(key==keyFieldId){
                                itemData.fieldId = itemData[key];
                                itemData.checkboxIsSelected = false;
                                newItemsList.push(itemData);
                            }
                        }
                    }
                    $scope.listViewDisplay.itemsList = newItemsList;
                },
                getCurrentDataList:function(){
                    return $scope.listViewDisplay.itemsList;
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
                            seletedItems.push(dataList[index].fieldId);
                        }
                    }
                    return seletedItems;
                },
                getSelectedIdsCount:function(){
                    var idArray = this.getSelectedIds();
                    return idArray.length;
                },
                deleteSelectedIds:function(seletedItems){
                    if((!angular.isDefined(seletedItems))||(seletedItems=="")){
                        if($scope.listViewDisplay.getSelectedIdsCount()<=0 ){
                            return;
                        }
                    }
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
                    $scope.listViewDisplay.listIsVisible = 1;
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
                         if($scope.listViewDisplay.completeLoadStack_callback){
                            $scope.listViewDisplay.completeLoadStack_callback($scope.listViewDisplay);
                        }
                    }
                },
                onCompleteLoadStack:function(callback){
                    $scope.listViewDisplay.completeLoadStack_callback = callback;
                },
                setMaxPageNav:function(max_number){ 
                    $scope.listViewDisplay.pageNavNumber = max_number;
                },
                setTotalRow:function(total_row){
                    var self = this;
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

                    if($scope.listViewDisplay.navBarZeroPageisHide==1){
                        if(pageNavData.total_page<=1){
                            self.setNavBarDisplay(0,0);
                        }
                    }
    
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
                },
                undefinedToBlank:function(value){
                    if (typeof value == 'undefined'){
                       return "";
                    }
                    return value;
                }
            };
            return PROMISE;
        })
        .config(function ($routeProvider, $locationProvider, $compileProvider, $httpProvider) {
            $httpProvider.defaults.useXDomain = true;
            delete $httpProvider.defaults.headers.common['X-Requested-With'];
            $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
            //$compileProvider.debugInfoEnabled(true);
            var templateUrl_value = GURL.base_ngservices_url()+'glist/list-page.html';
            if(angular.isDefined(GURL.glistTemplateUrl)){
                templateUrl_value = GURL.glistTemplateUrl;
            }
        
            $routeProvider
                .when('/', {
                    templateUrl: templateUrl_value,
                    controller: 'listController'
                })
                .when('/page/:cur_page/:per_page', {
                    templateUrl: templateUrl_value,
                    controller: 'listController'
                })
                .when('/page/:cur_page/:per_page/:sortby', {
                    templateUrl: templateUrl_value,
                    controller: 'listController'
                });
        }).
        run(function($route){
        })
        .controller('listController', function ($scope, $rootScope, $location, $routeParams, GLIST) {
           
            $scope.$on('$routeChangeSuccess',function (scope, event, currRoute, prevRoute) {
                // when route changed 
                
                var last_cur_page = $scope.listViewDisplay.last_cur_page;
                var last_per_page = $scope.listViewDisplay.last_per_page;
                var last_sortby = $scope.listViewDisplay.last_sortby;
                var last_search = $scope.listViewDisplay.last_search;
                var cur_page = $routeParams.cur_page;
                var per_page = $routeParams.per_page;
                var sortby = GLIST.undefinedToBlank($routeParams.sortby);
                var search = GLIST.undefinedToBlank($routeParams.search);

                if((last_cur_page != cur_page)||(last_per_page != per_page)||(last_sortby != sortby)||(last_search != search)){
                    
                    $scope.listViewDisplay.last_cur_page = cur_page;
                    $scope.listViewDisplay.last_per_page = per_page;
                    $scope.listViewDisplay.last_sortby = sortby;
                    $scope.listViewDisplay.last_search = search;

                    GLIST.setCurrentPageNav(cur_page,per_page);

                    $routeParams.cur_page = $scope.listViewDisplay.pageNavData.cur_page;
                    $routeParams.per_page = $scope.listViewDisplay.pageNavData.per_page;
                    GLIST.setSearchText(search);
                    $routeParams.search = $scope.listViewDisplay.search_text;

                    GLIST.setCurrentSortby(sortby);
                    GLIST.callPageChange($routeParams);
                }
        
            });
            
            $scope.listViewDisplay.checkboxSelectAll = function(){
                GLIST.checkboxSelectAll();
            };

            $scope.listViewDisplay.checkboxUnselectAll = function(){
                GLIST.checkboxUnselectAll();
            };
            $scope.listViewDisplay.deleteSelectedIds = function(){
                var seletedItems = GLIST.getSelectedIds();
                GLIST.deleteSelectedIds(seletedItems);
            };
            $scope.listViewDisplay.deleteById = function(id){
                var seletedItems = [id];
                GLIST.deleteSelectedIds(seletedItems);
            };
            $scope.listViewDisplay.viewById = function(id){
                GLIST.viewById(id);
            };
            $scope.listViewDisplay.editById = function(id){
                GLIST.editById(id);
            };

            $scope.listViewDisplay.getSelectedIdsCount = function(){
               return GLIST.getSelectedIdsCount();
            }

            $scope.listViewDisplay.searchClicked = function(){
                
                var txt_search =  $scope.listViewDisplay.txt_search;
                if((txt_search=="")||(typeof txt_search === "undefined")){
                    GLIST.setTotalRow(0);
                }

                GLIST.setSearchText(txt_search);
                var pageNavData = $scope.listViewDisplay.pageNavData;
                pageNavData.cur_page = 1;
                pageNavData.per_page = $scope.listViewDisplay.default_per_page;
                $scope.listViewDisplay.pageNavData = pageNavData;
                GLIST.generateCurrentPageUrl();
                var current_page_url = $scope.listViewDisplay.pageNavData.current_page_url;
                window.location.href = "#page/"+current_page_url;
            };

            $scope.listViewDisplay.createNewBtnClicked = function(){
                GLIST.callCreateNew();
            };
        })
        .directive('uiList', function () {
            var glist_url = GURL.base_ngservices_url()+"glist/";
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: glist_url+'list-layout.html'
            };
        })
        .directive('uiListNav', function () {
            var glist_url = GURL.base_ngservices_url()+"glist/";
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: glist_url+ 'list-nav.html'
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

        

