app.factory('GAESERVICE', function ($http, $q) {

    var serviceHost = 'http://localhost/gae/storecenter/';
    var apiHost = 'http://128.199.139.181/gae/storecenter_api/v1/';
    //var apiHost = 'http://localhost/gae/storecenter_api/v1/';
    var GAESERVICE = {
        checkEmailExist: function (dataArray) {
            return this.apiPost('register/exists_email',dataArray);
        },
        checkUserExist: function (dataArray) {
            return this.apiPost('register/exists_storename',dataArray);
        },
        register_serway_list: function (name) {
            var data  = {
                 txt_serway_name: name
            };
            return this.apiGet('register/sign_serway_data',data);
        },
        register_sub_serway_list: function (id) {
            var data  = {
                 txt_serway_id: id
            };
            return this.apiGet('register/sub_serway_data',data);
        },
        owner_login: function (dataArray) {
            return this.apiPost('owner/login',dataArray);
        },
        owner_forgot_password: function (dataArray) {
            return this.apiPost('owner/forgot_password',dataArray);
        },
        register_post: function (dataArray){
            var data = {
                txt_registerData: dataArray
              };
            return this.apiPost('register/register_post',data);
        },
        apiGet:function(apiName,dataArray){
            return this.apiCall('GET',apiName,dataArray);
        },
        apiPost:function(apiName,dataArray){
            return this.apiCall('POST',apiName,dataArray);
        },
        apiCall:function(methodName,apiName,dataArray){

            //var apiDataLog  = apiName+" : method : "+methodName;
            //console.log("apiCall : "+apiDataLog+" : data : "+JSON.stringify(dataArray));
            var promise_send = {
                callback:function(response){},
                then: function (callback) {
                    this.callback=callback;
                }
            };
            var req = {
                    method: methodName,
                    url: apiHost + apiName+"?t_"+new Date().getTime(),
                };
            if(methodName=='GET'){
                req.params=dataArray;
            }else if(methodName=='POST'){
                req.transformRequest = angular.identity;
                req.headers = {'Content-Type': undefined};

                var formdata = new FormData();
                for(var key in dataArray){
                    formdata.append(key,dataArray[key]);
                }
                req.data = formdata;
            }
            
            var promise = $http(req).then(function (response) {
               //console.log(apiDataLog+" : result : "+JSON.stringify(response));
                if(promise_send.callback){
                     promise_send.callback(response.data);
                }
            });
            return promise_send;
        }
    };
    return GAESERVICE;
});

