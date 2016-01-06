 
 var CUR_MODULE_CLASS = function(){

     var CUR_MODULE_OBJ = {
            init:function(){
                
            },
            data:{
                id:"",
                bundel_id:"",
                version:"",
                app_url:"",
                app_popup_url:"",
                api_url:"",
                file_url:"",
                base_module_app_url:"",
                base_module_app_popup_url:"",
                base_module_api_url:""
            },
            id:function(){
                var self = this;
                return self.data.id;  
            },
            bundel_id:function(){
                var self = this;
                return self.data.bundel_id; 
            },
            version:function(){
                var self = this;
                return self.data.version;
            },
            app_url:function(){
                var self = this;
                return self.data.app_url;  
            },
            app_popup_url:function(){
                var self = this;
                return self.data.app_popup_url;  
            },
            api_url:function(){
                var self = this;
                return self.data.api_url;  
            },
            file_url:function(){
                var self = this;
                return self.data.file_url; 
            },
            apiGet:function(moduleApiName,dataArray){
                var self = this;
                var apiUrl = self.api_url()+moduleApiName;
                return self.ajax().get(apiUrl,dataArray);
            },
            apiPost:function(moduleApiName,dataArray){
                var self = this;
                var apiUrl = self.api_url()+moduleApiName;
                return self.ajax().post(apiUrl,dataArray);
            },
            ajax:function(){

                var loadStack = 0;
                var onCompleteLoadStack_callback = null;
                var SERVICE = {
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
                    get:function(apiUrl,dataArray){
                        return this.callByUrl('GET',apiUrl,dataArray);
                    },
                    post:function(apiUrl,dataArray){
                        return this.callByUrl('POST',apiUrl,dataArray);
                    },
                    callByUrl:function(methodName,callUrl,dataArray){
                        var self = this;

                        var progressObj = {
                            callback:function(percent){},
                            onProgress:function(callback){
                                this.callback=callback;
                            }
                        };
                        var promise_send = {
                            callback:function(response){},
                            then: function (callback) {
                                this.callback=callback;
                                return progressObj;
                            }
                        };
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
                        },progressObj);

                        return promise_send;
                    },
                    jqAjax:function(methodName,url,dataArray,callback,progressObj){
                        var self = this;
                        var formData = new FormData();
                        if(methodName=="POST"){
                            for(var key in dataArray){
                                var ele = dataArray[key];
                                var is_files_data = false;
                                try{
                                    if(ele.type=="file"){
                                        is_files_data = true;
                                        formData.enctype = 'multipart/form-data';
                                        if(ele.files.length>1){
                                            for(var i=0;i<ele.files.length;i++){
                                                formData.append(key, ele.files[i]);
                                            }
                                        }else{
                                            formData.append(key, ele.files[0]);
                                        }
                                    }
                                }catch(e){}

                                if(!is_files_data){
                                    formData.append(key, ele);
                                }
                                
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
                                    var percentComplete = (evt.loaded / evt.total)*100;
                                    //Do something with upload progress
                                    progressObj.callback(percentComplete);
                                    //console.log("Upload progress : "+percentComplete);
                                  }
                                }, false);
                                //Download progress
                                xhr.addEventListener("progress", function(evt){
                                  if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    //Do something with download progress
                                    progressObj.callback(percentComplete);
                                    //console.log("Download progress : "+percentComplete);
                                  }
                                }, false);
                                return xhr;
                            }
                        });

                    }
                };
                return SERVICE;
            }
        };

    return CUR_MODULE_OBJ;
 }
 var CUR_MODULE = new CUR_MODULE_CLASS();


