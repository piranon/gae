angular.module('PAGELOADING', [])
        .factory('PAGELOADING', function ($http, $q, $timeout) { // API 
            var $scope ={};
            var TimeOut = null;
            var domElementArray = [];
            var contentHtml = "";
            var PROMISE = {
                    start:function(scope){
                        $scope = scope;
                        var pageloadingData = {
                                show:false
                        };
                        $scope.pageloadingData = pageloadingData;
                    },
                    play:function(type,msg){
                        var self = this;
                        $scope.pageloadingData.show = true;
                    },
                    stop:function(){
                        $timeout(function(){
                            $scope.pageloadingData.show = false;  
                        }, 50);
                    }
                };
            return PROMISE;
        })
        .run(['$route','$rootScope','PAGELOADING', function($route,$rootScope,PAGELOADING)  {
          PAGELOADING.start($rootScope);
        }])
        .directive('uiPageLoading', function () {
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: GURL.base_ngservices_url() + 'pageloading/pageloading-layout.html'
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


