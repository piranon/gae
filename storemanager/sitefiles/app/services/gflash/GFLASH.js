angular.module('GFLASH', ['ngCookies'])
        .factory('GFLASH', function ($http, $q, $cookies, $timeout) { // API 
            var PROMISE = {
                    set_flashdata:function(key,value){
                        var expireDate = new Date();
                        expireDate.setDate(expireDate.getSeconds() + 10);
                        $cookies.put(key, angular.toJson(value),{'expires': expireDate ,path: '/'});
                    },
                    flashdata:function(key){
                         var value = $cookies.get(key);
                         $cookies.remove(key,{path: '/'});
                         if(angular.isUndefined(value)){
                            return "";
                         }else{
                            return angular.fromJson(value);
                         }
                    }
                };
            return PROMISE;
        });


