angular.module('GAEAPI', [])
    .service('GAEAPI', function ($http, $q) {
    var $rootScope ={};
    var loadStack = 0;
    var onCompleteLoadStack_callback = null;
    var GAESERVICE = {
        start:function(rootScope){
            var self = this;
            $rootScope = rootScope;
            $rootScope.currentPageImage = {};

            $rootScope.callRectImage = function(imageUrl,sizeNumber){
                return self.callImageUrl(imageUrl,"rect",sizeNumber);
            };
            $rootScope.callThumbImage = function(imageUrl,sizeNumber){
                return self.callImageUrl(imageUrl,"thumb",sizeNumber);
            };
            $rootScope.callImageUrl = function(imageUrl,type,sizeNumber){
                return self.callImageUrl(imageUrl,type,sizeNumber);
            };
            $rootScope.getTimeStr = function(timestamp){
                return self.getTimeStr(timestamp);
            };

            $rootScope.root_url = function(){
                return GURL.root_url();
            };
            $rootScope.base_url = function(){
                return GURL.base_url();
            };
            $rootScope.base_ngservices_url = function(){
                return GURL.base_ngservices_url();
            };
        },
        getTimeStr:function(timestamp){
            
            var a = new Date(timestamp * 1000);
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var date = a.getDate();
            var hour = a.getHours();
            var min = a.getMinutes();
            var sec = a.getSeconds();
            var time = date + ' ' + month + ' ' + year + ' time ' + hour + ':' + min + ':' + sec ;
            return time;
        },
        root_url:function(){
            return GURL.root_url();
        },
        base_url:function(){
            return GURL.base_url();
        },
        base_api_url:function(){
            return GURL.base_api_url();
        },
        callImageUrl:function(imageUrl,type,sizeNumber){
            var sizeStr = "";
            if(type=="rect"){
                sizeStr = "r"+sizeNumber+"_";
            }else if(type=="thumb"){
                sizeStr = "t"+sizeNumber+"_";
            }
            var lastSlashPos = imageUrl.lastIndexOf("/")+1;
            var newImageUrl = imageUrl.slice(0, lastSlashPos)+sizeStr+imageUrl.slice(lastSlashPos);
            console.log("newImageUrl : "+newImageUrl);
            return newImageUrl;
        },
        addLoadStack:function(){
            loadStack +=1;
        },
        deLoadStack:function(){
            loadStack -=1;
            if(loadStack<=0){
                loadStack =0;
                if(onCompleteLoadStack_callback){
                    onCompleteLoadStack_callback($scope.listViewDisplay);
                }
            }
        },
        onCompleteLoadStack:function(callback){
            onCompleteLoadStack_callback = callback;
        },
        bindArrayWithFieldname:function(fieldName,dataArray){
            var newArray = [];
            if(angular.isArray(dataArray)){
                for(var key in dataArray){
                    var newObject  = {};
                    newObject[fieldName] = dataArray[key];
                    newArray.push(newObject);
                }
            }
            return newArray;
        },
        pushArrayByUniqueId:function(originArray,newObj,keyCheck){
          var isUnique = true;
          try{            
            var keyCheck_value = newObj[keyCheck];
            for(var key in originArray){
                if(originArray[key][keyCheck]==keyCheck_value){
                  isUnique = false;
                }
            }
            if(isUnique==true){
              originArray.push(newObj);
            }
          }catch(e){
            isUnique = false;
          }
          return isUnique;
        },
        deleteArrayByArrayId:function(originArray,delArrayId,keyCheck){
            var copyDataList =originArray.slice();
            var newArray = [];
            for(var key in copyDataList){
                for(var key_del in delArrayId){
                    if(copyDataList[key][keyCheck]!=delArrayId[key_del][keyCheck]){
                        newArray.push(copyDataList[key]);
                    }
                }
            }
            originArray = newArray;
            return newArray;
        },
        getArrayJsonOnlyId:function(originArray,keyCheck){
            var copyArray = originArray.slice();
            var newArray = [];
            for(var key in copyArray){
                var addObj = {};
                addObj[keyCheck] = copyArray[key][keyCheck];
                newArray.push(addObj);
            }
            return newArray;
        },
        get:function(apiName,dataArray){
            return this.call('GET',apiName,dataArray);
        },
        post:function(apiName,dataArray){
            return this.call('POST',apiName,dataArray);
        },
        call:function(methodName,apiName,dataArray){
            var self = this;
            var promise_send = {
                callback:function(response){},
                then: function (callback) {
                    this.callback=callback;
                }
            };


            var callUrl = self.base_api_url()+ apiName+"?t_"+new Date().getTime();
            var req = {
                    method: methodName,
                    url: callUrl,
                    responseType: 'text'
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
            self.addLoadStack();

            /*
            var promise = $http(req).then(
                function (response) {
                    console.log("promise : response : ",response);
                    if(promise_send.callback){
                         promise_send.callback(response.data);
                         self.deLoadStack();
                    }
                }
            );
            */

            self.jqAjax(methodName,callUrl,dataArray,function(data){
                //console.log("promise : response : ",data);
                if(promise_send.callback){
                    var res = {};
                    try{
                        res = angular.fromJson(data);
                    }catch(e){
                        console.log("Data Error : from url : "+callUrl);
                        console.log(data);
                    }
                    self.deLoadStack();
                    promise_send.callback(res);
                    
                }
            });

            return promise_send;
        },
        jqAjax:function(methodName,url,dataArray,callback){
            var self = this;
            /*
            var formData = new FormData();
            $("#form_send input").each(function(index,ele){
                if(ele.type=="file"){
                    formData.enctype = 'multipart/form-data';
                    if(ele.files.length>1){
                        for(var i=0;i<ele.files.length;i++){
                            formData.append(ele.name, ele.files[i]);
                        }
                    }else{
                        formData.append(ele.name, ele.files[0]);
                    }
                }else{
                    formData.append(ele.name, ele.value);
                }
            });
            */
            
            var formData = new FormData();
            if(methodName=="POST"){
                for(var key in dataArray){
                    formData.append(key,dataArray[key]);
                }
            }else{

                var formSendDataString = '';
                var formDataCount= 0;
                 for(var key in dataArray){
                   if(formDataCount>0){
                        formSendDataString += "&";
                    }
                    formSendDataString += key+"="+encodeURIComponent(dataArray[key]);
                    formDataCount++;
                }
                formData = formSendDataString;
            }

            var headersObj = {};
        
            var url_submit = url;
            $.ajax({
                url: url_submit,
                headers: headersObj,
                type: methodName,
                data: formData,
                cache: false,
                dataType: 'text',
                processData: false,
                contentType: false,
                success: function(data, textStatus, jqXHR)
                {
                    if(typeof data.error === 'undefined')
                    {
                    }else{
                        console.log('ERRORS: url_submit : '+url_submit+" : data.error : ",data.error);
                    }
                    if(callback){callback(data);}
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('ERRORS: url_submit : '+url_submit+" : textStatus : ",textStatus);
                },
                xhr: function()
                {
                    var xhr = new window.XMLHttpRequest();
                    //Upload progress
                    xhr.upload.addEventListener("progress", function(evt){
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        console.log("Upload progress : "+percentComplete);
                      }
                    }, false);
                    //Download progress
                    xhr.addEventListener("progress", function(evt){
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with download progress
                        console.log("Download progress : "+percentComplete);
                      }
                    }, false);
                    return xhr;
                }
            });

        }
    };
    return GAESERVICE;
})
.run(['$route','$rootScope','GAEAPI','$http', function($route,$rootScope,GAEAPI,$http)  {

    GAEAPI.start($rootScope);
    
}])
.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}])
.directive('dynamicImage', function(GAEAPI) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var sizeNumber = attrs.dimgSize;
            var imageType = attrs.dimgType;
            var imageUrl = attrs.dimgSrc;
            var preImageUrl = GAEAPI.callImageUrl(imageUrl,imageType,100);
            var realImageUrl = GAEAPI.callImageUrl(imageUrl,imageType,sizeNumber);
            var call_dynamic_src = true;
            if(angular.isDefined(sizeNumber)){
                if(sizeNumber<=100){
                    call_dynamic_src = false;
                }
            }
            if(call_dynamic_src==true){
                element.attr('src', preImageUrl);
                var myImage = new Image();
                myImage.onload = function() {
                    element.attr('src', realImageUrl);
                };
                myImage.src = realImageUrl;
            }else{
                element.attr('src', realImageUrl);
            }
        }
    };

})
.directive('dynamicImageBg', function(GAEAPI) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var sizeNumber = attrs.dimgSize;
            var imageType = attrs.dimgType;
            var imageUrl = attrs.dimgSrc;
            var bgSize = attrs.dimgBgSize;
            var preImageUrl = GAEAPI.callImageUrl(imageUrl,imageType,100);
            var realImageUrl = GAEAPI.callImageUrl(imageUrl,imageType,sizeNumber);
            var call_dynamic_src = true;
            if(angular.isDefined(sizeNumber)){
                if(sizeNumber<=100){
                    call_dynamic_src = false;
                }
            }
            if(angular.isUndefined(bgSize)){
                bgSize = "cover";
            }

            function getCssObj(cssImageUrl,cssBgSize){

                 var cssObj ={
                    "background-image": "url('"+cssImageUrl+"')",
                    "background-size": cssBgSize,
                    "background-repeat": "no-repeat",
                    "background-position": "50% 50%",
                };
                return cssObj;
            }
            if(call_dynamic_src==true){
                element.css(getCssObj(preImageUrl,bgSize));
                var myImage = new Image();
                myImage.onload = function() {
                    element.css(getCssObj(realImageUrl,bgSize));
                };
                myImage.src = realImageUrl;
            }else{
                element.css(getCssObj(realImageUrl,bgSize));
            }
        }
    };
});


