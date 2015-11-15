angular.module('NOTIBOX', ['cgNotify'])
        .factory('NOTIBOX', function ($window,$http, $q, $timeout,notify) { // API 
            var $scope ={};
            var notiTimeOut = null;
            var notiElementArray = [];
            var notiContentHtml = "";
            var childWindow_callback = null;
            var PROMISE = {
                    start:function(scope){
                        $scope = scope;
                        var notiboxData = {
                                show:false
                        };
                        $scope.notiboxData = notiboxData;
                    },
                    syncToParent:function(obj){
                        var playIsComplete = false;
                        try{
                            var NOTIBOX_parent = $window.parent.NOTIBOX_iframe_service;
                            NOTIBOX_parent.callAlert();
                            playIsComplete = true;
                        }catch(e){
                            playIsComplete = false;
                        }
                    },
                    play:function(msg,classStr){
                        var self = this;
                        var playIsComplete = false;
                        try{
                            var NOTIBOX_parent = $window.parent.NOTIBOX_iframe_service;
                            NOTIBOX_parent.notify(msg,classStr);
                            playIsComplete = true;
                        }catch(e){
                            playIsComplete = false;
                        }

                        if(!playIsComplete){
                            self.notify(msg,classStr);
                        }
                    },
                    notify:function(msg,classStr){
                        var self = this;
                        notify({
                            message: msg,
                            classes: classStr,
                            templateUrl: '',
                            position: 'center',
                            duration: 2500
                        });
                    },
                    stop:function(){
                        notify.closeAll();
                    },
                    callAlert:function(){
                        alert("NOTIBOX callAlert");
                    }
                };
            return PROMISE;
        })
        .run(function($window,NOTIBOX){
            $window.NOTIBOX_iframe_service = NOTIBOX;
        });


