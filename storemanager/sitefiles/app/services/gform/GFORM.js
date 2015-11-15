angular.module('GFORM', [])
        .factory('GFORM', function ($http, $q) { // API 
            var $scope ={};
            var formErrorData = {};
            var openTag = '<span class="gform-valid-msg "> * ';
            var closeTag = '</span>';
            var inputFieldData = {};
            var callback_onFileChange = {};
            var PROMISE = {
                start:function(scope){
                	var self = this;
                    $scope = scope;
                    $scope.gform = {};
                    $scope.form = {};
                    self.clearFormValidData();
                    $scope.gform.has_error = {};
                    $scope.gform.valid = {};
                    $scope.gform.fileData = {};
                    $scope.gform.hiddenInputExtend = {};
                    $scope.gform.hiddenInputExtend_HTML = "";
                    self.resetInputForValidate();
                    $scope.gform.getFormInput = function(fieldName,label,initValue,inputType,attrType){
                    	return self.getFormInput(fieldName,label,initValue,inputType,attrType);
                    };
                },
                setFormErrorData:function(data){
                	var self = this;
                	self.clearFormValidData();
                	formErrorData = data;
                	for(var key in formErrorData){
                		$scope.gform.has_error[key] = "has-error";
                		$scope.gform.valid[key] =  openTag+formErrorData[key]+closeTag;
                	}
               	},
               	clearFormValidData:function(){
               		var self = this;
               		for(var key in inputFieldData){
               			self.cleanFieldError(key);
                	}
               	},
               	cleanFieldError:function(fieldName){
		         	$scope.gform.has_error[fieldName] = "";
				    $scope.gform.valid[fieldName] = "";
               	},
                setFiledErrorLayout:function(openTagStr,closeTagStr){
                	openTag = openTagStr;
                	closeTagStr = closeTagStr;
                },
                undefinedToBlank:function(value){
                    if (!angular.isDefined(value)){
                       return "";
                    }
                    return value;
                },
                watchAndCleanAllField:function(){
                	console.log("watchAndCleanAllField ",inputFieldData);
                	var self = this;
               		for(var key in inputFieldData){
               			self.watchAndClean(key);
                	}
                },
                watchAndClean:function(fieldName,callback){
                	console.log("watchAndClean : fieldName : "+fieldName);
                	var self = this;
                	$scope.$watch("form."+fieldName,function(newValue,oldValue){
                        try{
                            self.cleanFieldError(fieldName);
                            if(callback){callback();}
                        }catch(e){}
				    });
                },
                initWatchField:function(fieldName,initValue,callback){
                	console.log("watchAndClean : fieldName : "+fieldName);
                	var self = this;
                	self.watchAndClean(fieldName,callback);
                	if(angular.isDefined(initValue)){
                		$scope.form[fieldName] = initValue;
                	}
                },
                addFieldError:function(fieldName,error){
                	var self = this;
                	var dataError = formErrorData;
                	  dataError[fieldName] = error;
                	  self.setFormErrorData(dataError);
                },
                resetInputForValidate:function(fieldName,type){
                	inputFieldData = {};
                },
                addInputForValidate:function(fieldName,type,guideText){
                	//console.log(fieldName+" : "+type+" : "+guideText);
                	var type = this.undefinedToBlank(type);
                	var guideText = this.undefinedToBlank(guideText);
                	inputFieldData[fieldName] = type;
                },
                getFormInput:function(fieldName,label,inputType,attrType,guideText){

                	var self = this;
                	var guideText = self.undefinedToBlank(guideText);
                	var attrType_str = "text";
                	if(attrType=="password"){
                		attrType_str = "password";
                	}else if(attrType=="email"){
                		attrType_str = "email";
                	}else if(attrType=="number"){
                		attrType_str = "number";
                	}

                	var input_html = "";
                	if(inputType=="textarea"){
                		input_html = ' <textarea  class="form-control" id="'+fieldName+'" name="'+fieldName+'" ng-model="form.'+fieldName+'" placeholder="'+label+'"></textarea>';
                	}else{
                		inputType = "input";
                		input_html = '<input type="'+attrType_str+'" class="form-control" id="'+fieldName+'" name="'+fieldName+'" ng-model="form.'+fieldName+'" placeholder="'+label+'" >';
                	}
                	var holder_html =  '<div class="form-group {{ gform.has_error.'+fieldName+'}}"><label class="control-label" for="'+fieldName+'">'+label+'</label><span class="pull-right" compile="gform.valid.'+fieldName+'"></span><span class="gform-guideText-msg pull-right" ng-if="( gform.valid.'+fieldName+'==\'\' || gform.valid.'+fieldName+'=== \'undefined\'  )" >'+guideText+'</span>'+input_html+'</div>';

                	self.addInputForValidate(fieldName,inputType,guideText);
                	return holder_html;
                },
                getScopeVal:function(scopeValue){
                   return this.getScopeValue(scopeValue);
                },
                getScopeValue:function(scopeValue){
                    var valueReturn = "";
                    try{
                        valueReturn = angular.copy(scopeValue);
                    }catch(e){
                        valueReturn = "";
                    }
                    if(angular.isUndefined(valueReturn)){
                        valueReturn = "";
                    }
                    return valueReturn;
                },
                formCheck:function(){
                    var errorCount = 0;
                    try{
                        for(var key in formErrorData){
                            errorCount++;
                        }
                    }catch(e){}
                    if(errorCount==0){
                        return true;
                    }else{
                        return false;
                    }                
                },
                has_error:function(){
                    if(this.formCheck()==true){
                        return false;
                    }else{
                        return true;
                    }
                },
                setInitImageSvg:function(modelName,svgUrl){
                    
                    if(angular.isUndefined(svgUrl)){
                        $scope.gform.fileData[modelName] = "";
                    }
                    $.get(svgUrl,function(reqData){
                        //$scope.gform.fileData[modelName+"_url"] = svgUrl;
                        $scope.gform.fileData[modelName] = svgUrl;
                    });

                },
                generateUploadInputHTML:function(){
                    var strHTML = '';
                    var inputExtendArray = $scope.gform.hiddenInputExtend;

                    if(angular.isObject(inputExtendArray)){
                        for(var key in inputExtendArray){
                            var value = inputExtendArray[key];
                            var multiple_str = "";
                            var onchangeStr = "";
                            if(value==1){
                                multiple_str = "multiple";
                                onchangeStr = ' onchange="angular.element(this).scope().onChangeFileToUpload(this,\''+key+'\')" ';
                            }else{ 
                                onchangeStr = ' file-model="form.'+key+'" ';
                            }
                            strHTML +='<input class="form-upload-inputfile" id="'+key+'" '+onchangeStr+'  type="file" '+multiple_str+'>';
                        }
                    }
                    $scope.gform.hiddenInputExtend_HTML = strHTML;

                },
                onFileChange:function(model_name_str,callback){
                    callback_onFileChange[model_name_str] = callback;
                },
                setImageUploadButton:function(model_name_str,isMultiple){

                    var self = this;
                    if(isMultiple==true){
                        $scope.gform.hiddenInputExtend[model_name_str] = 1;
                    }else{
                        $scope.gform.hiddenInputExtend[model_name_str] = 0;
                    }
                   
                    self.generateUploadInputHTML();

                    if(isMultiple==true){
                        $scope.onChangeFileToUpload = function(element,imageUploadId){
                            try{
                               var count = 0;
                               for(var index in element.files){
                                  var photofile = element.files[index];
                                  var reader = new FileReader();
                                  reader.onload = function(e) {
                                      $scope.$apply(function(scope) {
                                        var fileData = e.target.result;
                                        $scope.gform.fileData[imageUploadId] =fileData;
                                        var callback = callback_onFileChange[model_name_str];

                                        var fileReturn = {};
                                        fileReturn.fileIndex = count;
                                        fileReturn.fileData = fileData;
                                        count++;
                                        if(angular.isDefined(callback)){
                                            if(callback){callback(fileReturn);}
                                        }
                                      });
                                  };
                                  reader.readAsDataURL(photofile);
                               }
                            }catch(e){}
                            $scope.$apply(function(scope) {
                                $scope.form[model_name_str] = element.files;
                                //console.log("$scope.form."+model_name_str+" ,",$scope.form[model_name_str]);
                            });
                        };
                    }else{
                        $scope.$watch("form."+model_name_str, function (newValue, oldValue) {
                            try{
                               //console.log("newValue : ",newValue);
                               var photofile = newValue;
                               var reader = new FileReader();
                               reader.onload = function(e) {    
                                  $scope.$apply(function(scope) {
                                    var fileData = e.target.result;
                                    $scope.gform.fileData[model_name_str] =fileData;
                                    var callback = callback_onFileChange[model_name_str];

                                    var fileReturn = {};
                                    fileReturn.fileIndex = 0;
                                    fileReturn.fileData = fileData;

                                    if(angular.isDefined(callback)){
                                        if(callback){callback(fileReturn);}
                                    }
                                  });
                               };
                              reader.readAsDataURL(photofile);
                            }catch(e){}
                        });
                    }
                }
            };
            return PROMISE;
        }).
 		run(['GFORM', function(GFORM)  {
 			//GFORM.clearFormValidData();
          //$route.reload();
        }])
        .directive('gformExtend', function () {
            var glist_url = GURL.base_ngservices_url()+"gform/";
            return {
                restrict: 'AE',
                scope: true,
                templateUrl: glist_url+'gform-layout.html',
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
        })
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
        .directive('uploadfile', function (GFORM) {
            return {
              restrict: 'A',
              link: function(scope, element, attrs) {
                GFORM.setImageUploadButton(attrs.uploadfile);
                element.bind('click', function(e) {
                    var eleId  = attrs.uploadfile;
                    document.getElementById(eleId).click();
                });
              }
            };
        })
        .directive('uploadfiles', function (GFORM) {
            return {
              restrict: 'A',
              link: function(scope, element, attrs) {
                GFORM.setImageUploadButton(attrs.uploadfiles,true);
                element.bind('click', function(e) {
                    var eleId  = attrs.uploadfiles;
                    document.getElementById(eleId).click();
                });
              }
            };
        });

        

