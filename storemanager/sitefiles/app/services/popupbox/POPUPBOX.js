angular.module('POPUPBOX', [])
        .factory('POPUPBOX', function ($http, $window, $q, $timeout,$sce, $rootScope) { // API 
            var $scope ={};
            var TimeOut = null;
            var domElementArray = [];
            var contentHtml = "";
            var confirm_callback = null;
            var childWindow_callback = {};
            var currentKeyId;
            var syncValue = {};
            var popupIframe_updateSize_callback = null;
            var injectIframeData = {};
            var PROMISE = {
                    syncKeyId:function(keyId){
                        console.log("syncKeyId : "+keyId);
                        var self = this;
                        currentKeyId = keyId;
                        self.start($rootScope,keyId);
                        return self;
                    },
                    getCurrentKeyId:function(){
                        return currentKeyId;
                    },
                    start:function(scope,keyId){
                        var self = this;
                        $scope = scope;
                        var popupBoxData = {
                                show:false
                        };
                        $scope.popupBoxData = {};
                        $scope.popupBoxData = popupBoxData;
                        $scope.popupBoxData.currentSize = {};
                        $scope.popupBoxData.currentSize.width = 0;
                        $scope.popupBoxData.currentSize.height = 100;
                        $scope.popupBoxData.addedIframe = {};
                        self.resetPopup();

                        $scope.popupBoxData.closeBtnClicked = function(){
                            self.stop();
                        };
                        $scope.popupBoxData.confirmBtnClicked = function(){
                            if(confirm_callback){confirm_callback(true);}
                            self.stop();
                        };
                        $scope.popupBoxData.cancelBtnClicked = function(){
                            if(confirm_callback){confirm_callback(false);}
                            self.stop();
                        };

                        // child window section
                        $scope.popupBoxData.onChildRequest = function(key,obj,closePopup,keyId,childWindow){
                            self.onChildRequest(key,obj,closePopup,keyId,childWindow);
                        };

                        $scope.popupBoxData.updatePopupSize = function(docSize,keyId){
                            self.updatePopupSize(docSize,keyId);
                        };

                        $scope.popupBoxData.currentHeight = function(){
                            var currentHeight =  500;
                            console.log("currentHeight : "+currentHeight);
                            return currentHeight;
                        };

                        $scope.popupBoxData.stop = function(){
                            self.stop();
                        };

                        $scope.$watch('popupBoxHeight',function(newValue,oldValue){
                                console.log("popupBoxHeight : new, old : "+newValue+" : "+oldValue);
                        });

                        $(window).resize(function(){
                            self.setParentPopupSize(keyId);
                        });
                        self.setParentPopupSize(keyId);
                    },
                    onIframeCallback:function(callback,keyId){
                        if(angular.isDefined(keyId)){
                            childWindow_callback[keyId] = callback;
                        }else{
                            childWindow_callback["default"] = callback;
                        }  
                    },
                    setSyncVal:function(key,obj){
                        this.setSyncValue(key,obj);
                    },
                    setSyncValue:function(key,obj){
                        syncValue[key]=obj;
                    },
                    syncToParent:function(key,value,closePopup,keyId){

                        var self = this;
                        var childWindow = syncValue;
                        try{
                            var parentScope = $window.parent.angular.element($window.frameElement).scope();
                            parentScope.popupBoxData.onChildRequest(key,value,closePopup,keyId,childWindow);
                        }catch(e){}
                    },
                    callParent:function(key,value,closePopup,keyId){
                        var self = this;
                        if(angular.isUndefined(keyId)){
                           keyId = self.getCurrentKeyId();
                        }
                        self.syncToParent(key,value,closePopup,keyId);
                    },
                    onChildRequest:function(key,value,closePopup,keyId,childWindow){
                        var self = this;
                        if(closePopup==true){
                            self.stop();
                        }
                        var callback = null;
                        if(angular.isDefined(keyId)){
                            callback = childWindow_callback[keyId];
                        }else{
                            callback = childWindow_callback["default"];
                        }
                        if(callback){
                            callback(key,value,childWindow,keyId);
                        }
                    },
                    onChildResize:function(windowSize,docSize,keyId){
                        //console.log("window : w "+windowSize.width+", h :"+windowSize.height);
                        //console.log("docSize : w "+docSize.width+", h :"+docSize.height);

                        if(angular.isUndefined(keyId)){
                           keyId = this.getCurrentKeyId();
                        }
                        try{
                            var parentScope = $window.parent.angular.element($window.frameElement).scope();
                            parentScope.popupBoxData.updatePopupSize(docSize,keyId);
                        }catch(e){}

                    },
                    updatePopupSize:function(docSize,keyId){
                        //newHeight -= 82;
                                    
                        $scope.$apply(function() {
                                 console.log("updatePopupSize == keyId : ",keyId);
                                var keyIdChild_updatesize_callback = null;
                                if(angular.isDefined(keyId)){

                                    if(angular.isDefined(injectIframeData[keyId].keyIdChild_updatesize_callback)){
                                        keyIdChild_updatesize_callback = injectIframeData[keyId].keyIdChild_updatesize_callback;
                                    }else{
                                        keyIdChild_updatesize_callback = null;
                                    }
                                }
                                if(keyIdChild_updatesize_callback!=null){
                                    keyIdChild_updatesize_callback(docSize);
                                }else{
                                    if(popupIframe_updateSize_callback){
                                        popupIframe_updateSize_callback(docSize);
                                    }
                                }
                        });
                        /*
                        var jDocsize_height = $(document).height();
                        console.log("updatePopupSize : jDocsize height : ",jDocsize_height);
                        console.log("updatePopupSize : docSize.height : "+docSize.height);
                        console.log("keyId : "+keyId+" : updatePopupSize : newHeight : "+newHeight+ " : height : "+$scope.popupBoxHeight);
                        //console.log("updatePopupSize 2 : "+keyId);
                        */
                    },
                    resetPopup:function(){
                        $scope.popupBoxData.type = {};
                        $scope.popupBoxData.type.normal = false;
                        $scope.popupBoxData.type.confirm = false;
                        $scope.popupBoxData.type.iframe = false;

                        $scope.popupBoxData.iframeData = {};
                        $scope.popupBoxData.contentHTML = "";
                        $scope.popupBoxData.bodyStyle  = "";
                    },
                    play:function(msg){
                        var self = this;
                        self.resetPopup();
                        $scope.popupBoxData.contentHTML = msg;
                        $scope.popupBoxData.type.normal = true;
                        $scope.popupBoxData.show = true;
                    },
                    playConfirm:function(msg,callback,maxWidth){
                        var self = this;
                        self.resetPopup();
                        confirm_callback = callback;
                        $scope.popupBoxData.type.confirm = true;
                        $scope.popupBoxData.bodyStyle = self.getMaxWidthStr(maxWidth);
                        $scope.popupBoxData.contentHTML = msg;
                        $scope.popupBoxData.show = true;
                    },
                    playIframe:function(iframeUrl,callback,maxWidth){
                        var self = this;
                        $timeout(function(){
                            $("body").css("overflow", "hidden");
                            self.resetPopup(); 
                            self.onIframeCallback(callback);
                            $scope.popupBoxData.type.iframe = true;
                            $scope.popupBoxData.iframeData.url = iframeUrl;
                            $scope.popupBoxData.iframeData.content =$sce.trustAsResourceUrl(iframeUrl);
                            $scope.popupBoxData.bodyStyle = self.getMaxWidthStr(maxWidth);
                            $scope.popupBoxData.show = true;

                        },50);

                         popupIframe_updateSize_callback = function(docSize){

                            var newHeight = parseInt(docSize.height);
                            var windowH = $(window).height()-200;
                            if(newHeight>windowH){
                                $(".popupBox-body").css("top", "0px");
                            }
                            $scope.popupBoxData.currentSize.height = newHeight;
                            $scope.popupBoxHeight = newHeight;

                        };
                        
                    },
                    playInjectIframe:function(keyId,iframeUrl,callback,maxHeight){
                        
                        childWindow_callback[keyId] = callback;
                        injectIframeData[keyId] = {};
                        injectIframeData[keyId].keyIdChild_updatesize_callback = function(docSize){
                            var newHeight = parseInt(docSize.height);
                            console.log("keyIdChild_updatesize_callback :: "+newHeight+" : maxHeight : "+maxHeight);
                            if(newHeight>maxHeight){
                                newHeight = maxHeight;
                            }
                            $("#"+keyId).css({"height":newHeight+"px"});
                        };
                       
                        $("#"+keyId).css({"width":"100%"});
                        $("#"+keyId).attr({"src":iframeUrl});

                    },
                    stop:function(){
                        $timeout(function(){
                            $("body").css("overflow", "scroll");
                            $scope.popupBoxData.show = false;
                        },50);
                    },
                    setParentPopupSize:function(keyId){
                        var windowSize = {};
                        windowSize.width = $(window).width();
                        windowSize.height = $(window).height();

                        var docSize = {};
                        docSize.width = $("body").width();
                        docSize.height = $("body").height();
                        this.onChildResize(windowSize,docSize,keyId);
                    },
                    syncSize:function(keyId){
                        this.syncPopupSize(keyId);
                    },
                    syncPopupSize:function(keyId){
                        var self = this;
                        console.log("syncPopupSize : currentKeyId : "+keyId+" : ");
                        if(angular.isUndefined(keyId)){
                           keyId = this.getCurrentKeyId();
                        }
                        $timeout(function(){
                            self.setParentPopupSize(keyId);
                        },50);
                    },
                    getMaxWidthStr:function(maxWidth){
                        var maxWidth_str = "";
                        if(angular.isDefined(maxWidth)){
                            if(angular.isNumber(maxWidth)){
                                maxWidth_str = "max-width:"+maxWidth+"px;";
                            }else{
                                maxWidth_str = "max-width:"+maxWidth+";";
                            }
                        }
                        return maxWidth_str;
                    },
                    parentStop:function(){
                         try{
                            var parentScope = $window.parent.angular.element($window.frameElement).scope();
                            return parentScope.popupBoxData.stop();
                        }catch(e){}
                    }
                };
            return PROMISE;
        })
        .run(function($rootScope,POPUPBOX){
            //POPUPBOX.syncKeyId($rootScope);
        })
        .controller('popupBoxController', function ($window,$scope, $rootScope, $location, $routeParams, POPUPBOX) {
            POPUPBOX.start($scope);
        })
        .directive('uiPopupBox', function () {
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: GURL.base_ngservices_url() + 'popupbox/popupbox-layout.html'
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
