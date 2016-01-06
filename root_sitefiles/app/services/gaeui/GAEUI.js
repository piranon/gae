 var GAEUI_CLASS = function(){

 	function check_isInIFrame(){
		return window.frameElement && window.frameElement.nodeName == "IFRAME";
	}
 	function whichTransitionEvent(){
  		var t,el = document.createElement("fakeelement");
		var transitions = {
		    "transition"      : "transitionend",
		    "OTransition"     : "oTransitionEnd",
		    "MozTransition"   : "transitionend",
		    "WebkitTransition": "webkitTransitionEnd"
		}
		for (t in transitions){
		    if (el.style[t] !== undefined){
		      return transitions[t];
		    }
		}
	}
	var transitionEvent = whichTransitionEvent();

 	var GAEUI_OBJ = {
 		data:{
 			is_alert_created:false
 		},
 		doAnimateCss:function(element,animate_class,callback){
 			var animationClass = animate_class;		    
		    element.bind('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function (e) {
		       element.removeClass(animationClass);
		       try{
	 				if(callback){callback(element);}
	 			}catch(e){}
		    });
			
			element.removeClass(animationClass);
			element.finish();
			element.clearQueue();
			
			try{
	 			if(element.timeOut){
	 				clearTimeout(element.timeOut);
	 			}
	 		}catch(e){}
			element.timeOut = setTimeout(function(){
				element.addClass(animationClass);
			},50);
 		},
 		alert_count:0,
 		alert_dict:{},
 		alert:function(title,content){
 			
 			var parent = this;

 			var alert_obj = null;
 			var stack_dict = parent.alert_dict;
 			
 			var id = "id_"+parent.alert_count;
 			parent.alert_count++;

 			alert_obj = {
 				main_id:id,
 				main_ele:null,
 				sub_ele:null,
 				init:function(){
 					var self = this;
 					var htmlStr = $('#gaeui_pageAlert').html();
 					var main_ele = $('<div/>', {
								    'id':'gaeui_pageAlert_id'+id,
								    'class':'gaeui_pageWrapModal',
								    'html':htmlStr});
 					main_ele.appendTo('body');
 					self.main_ele = main_ele;
 					
 					var sub_ele = {};
 					sub_ele.pcb_body_id = "#"+self.main_ele.get(0).id+" "+self.data.body_eleId;
	 				sub_ele.pcb_body = $(sub_ele.pcb_body_id);
	 				sub_ele.title_ele = $(sub_ele.pcb_body_id+" .pcb_title");
	 				sub_ele.content_ele = $(sub_ele.pcb_body_id+" .pcb_content");
	 				sub_ele.btn_done = $(sub_ele.pcb_body_id+" .pcb_button_div .pcb_btn_done");
	 				self.sub_ele =sub_ele;
 				},
 				data:{
 					ele:null,
	 				body_eleId:".pcb_body",
	 				is_loaded: false,
	 				doneBtn_class:""
	 			},
	 			play:function(title,content){
	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.alert().play(title,content);
						}catch(e){}
						return;
					}
	 				var self = this;
	 				self.playHTML(title,content);
	 			},
	 			playHTML:function(title,content){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.alert().playHTML(title,content);
						}catch(e){}
						return;
					}

	 				var self = this;
	 				if(title){
						self.sub_ele.title_ele.show();
						self.sub_ele.title_ele.html(title);
					}else{
						self.sub_ele.title_ele.hide();
					}
					if(content){
						self.sub_ele.content_ele.show();
						self.sub_ele.content_ele.html(content);
					}else{
						self.sub_ele.content_ele.hide();
					}

					if(!self.data.is_alert_created){
						self.data.is_alert_created = true;
						self.sub_ele.btn_done.click(function(){
							parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});
							self.main_ele.fadeOut(200,function(){
							});
						});	
					}

					self.main_ele.finish();
					self.main_ele.clearQueue();
					parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});
					self.main_ele.fadeIn(100,function(){
						self.sub_ele.pcb_body.show(function(){
						});
					});
	 			}
 			};

 			alert_obj.init();
 			return alert_obj;
 		},
 		pageLoading_obj:null,
 		pageLoading:function(){
 			var parent = this;
 			if(parent.pageLoading_obj!=null){
 				return parent.pageLoading_obj;
 			}
 			var pageLoading_obj = {
	 				data:{
		 			eleId:"#gaeui_pageLoading",
		 			currentProgress:0,
		 			isLoadAnimate:false
		 		},
		 		play:function(callback){

		 			if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.pageLoading().play(callback);
						}catch(e){}
						return;
					}

		 			var self = this;
		 			self.updateProgress(0);
		 			ele = $(self.data.eleId);
		 			ele.finish();
	 				ele.clearQueue();
		 			ele.fadeIn(100,function(){
		 				self.data.isLoadAnimate = true;
		 				self.playLoadLabel(0);
		 				if(callback){callback();}
		 			});
		 		},
		 		updateProgress:function(percent){

		 			if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.pageLoading().updateProgress(percent);
						}catch(e){}
						return;
					}

		 			var self = this;
		 			self.data.currentProgress = parseInt(percent);
		 			var ele = $(self.data.eleId+" .pld_body .pld_load_progress");
		 			var resultStr = self.data.currentProgress+"%";
		 			if(percent==0){
		 				ele.finish();
	 					ele.clearQueue();
		 				ele.html("");
		 				return;
		 			}
		 			ele.animateNumber({ number: percent });
		 		},
		 		stop:function(callback){

		 			if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.pageLoading().stop(callback);
						}catch(e){}
						return;
					}

		 			var self = this;
		 			$(self.data.eleId).fadeOut(200,function(){
		 				self.stopLoadLabel();
		 				if(callback){callback();}
		 			});
		 		},
		 		playLoadLabel:function(count){

		 			if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.pageLoading().playLoadLabel(count);
						}catch(e){}
						return;
					}

		 			var self = this;
		 			if(!self.data.isLoadAnimate){ return; }
		 			var extendStr = "";
		 			if(count>2){ count =0; }
		 			for (var i = 0; i < count; i++) {
		 				extendStr += ".";
		 			}
		 			count++;
		 			$(self.data.eleId+" .pld_body .pld_load_label").html("Please wait."+extendStr);
		 			setTimeout(function(){
		 				self.playLoadLabel(count);
					},250); 
		 		},
		 		stopLoadLabel:function(){

		 			if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.pageLoading().stopLoadLabel(count);
						}catch(e){}
						return;
					}

		 			var self = this;
		 			self.data.isLoadAnimate = false;
		 		}
 			}
 			parent.pageLoading_obj = pageLoading_obj;
 			return pageLoading_obj;

 		},
 		notification_obj:null,
 		notification:function(){
 			var parent = this;
 			
 			if(parent.notification_obj!=null){
 				return parent.notification_obj;
 			}

 			var notification_obj = {
	 			data:{
	 				notiEleId:"#gaeui_pageNotification",
	 				notiEle_onCreate:false
	 			},
	 			getTempateHTML:function(classname,msg){
	 				var htmlStr='';
	 				htmlStr +='<div class="dialog dialog-'+classname+'">';
	 				htmlStr += msg;
	 				htmlStr +='</div>';
	 				return htmlStr;
	 			},
	 			playComplete:function(msg,callback){
	 				var self = this;
	 				var contentHTML = self.getTempateHTML('success',msg);
	 				self.playHTML(contentHTML,callback,null,2500);
	 			},
	 			playInfo:function(msg,callback){
	 				var self = this;
	 				var contentHTML = self.getTempateHTML('info',msg);
	 				self.playHTML(contentHTML,callback);
	 			},
	 			playWarning:function(msg,callback){
	 				var self = this;
	 				var contentHTML = self.getTempateHTML('warning',msg);
	 				self.playHTML(contentHTML,callback);
	 			},
	 			playError:function(msg,callback){
	 				var self = this;
	 				var contentHTML = self.getTempateHTML('danger',msg);
	 				self.playHTML(contentHTML,callback,380,3500);
	 			},
	 			playHTML:function(contentHTML,callback,animate_timeMs,show_timeMs){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.notification().playHTML(contentHTML,callback,animate_timeMs,show_timeMs);
						}catch(e){}
						return;
					}

	 				var self = this;
	 				if(!animate_timeMs){
	 					animate_timeMs = 500;
	 				}
	 				if(!show_timeMs){
	 					show_timeMs = 3000;
	 				}
	 				var notiEle = $(self.data.notiEleId);
	 				var total_height = notiEle.height();
	 				notiEle.finish();
	 				notiEle.clearQueue();
	 				notiEle.hide();
	 				notiEle.html(contentHTML);
	 				notiEle.css({ top:-total_height+"px"});
	 				notiEle.fadeOut(50,function(){
	 					notiEle.show();
	 					notiEle.animate({ "top": "+="+total_height+"px" }, animate_timeMs,"easeOutCubic");
	 					if(!self.data.notiEle_onCreate){
	 						self.data.notiEle_onCreate = true;
	 						notiEle.click(function(){
	 							self.stop();
	 						});
	 					}
	 					try{
		 					if(callback){callback();}
		 				}catch(e){}
	 				}).delay(show_timeMs).delay(50,function(){
	 					self.stop();
	 				});
	 			},
	 			stop:function(callback){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.notification().stop(callback);
						}catch(e){}
						return;
					}

	 				var self = this;
	 				var notiEle = $(self.data.notiEleId);
	 				var total_height = notiEle.height();
	 				notiEle.finish();
	 				notiEle.clearQueue();
	 				notiEle.animate({ "top": "-="+total_height+"px" }, 300,"easeInOutExpo",function(){
						notiEle.hide();
						notiEle.html('');
						try{
	 						if(callback){callback();}
	 					}catch(e){}
	 				});
	 			}
 			}

 			parent.notification_obj = notification_obj;
 			return notification_obj;
 		},
 		modal_dict:{},
 		modal:function(id){
 			var parent = this;
 			var stack_dict = parent.modal_dict;
 			if(!id){
 				id = "default-1000";
 			}

 			var modal_obj = null;
 			try{
 				if(stack_dict[id]){
 					modal_obj =  stack_dict[id];
 					console.log("modal_id : old : "+modal_obj.main_id);
 					return modal_obj;
 				}
 			}catch(e){}

 			modal_obj = {
 				main_id:id,
 				main_ele:null,
 				sub_ele:null,
 				init:function(){
 					var self = this;
 					var htmlStr = $('#gaeui_pageModal').html();
 					var main_ele = $('<div/>', {
								    'id':'gaeui_pageModal_id'+id,
								    'class':'gaeui_pageWrapModal',
								    'style':'z-index:1060;',
								    'html':htmlStr});
 					main_ele.appendTo('body');
 					self.main_ele = main_ele;
 					
 					var sub_ele = {};
 					sub_ele.pcb_body_id = "#"+self.main_ele.get(0).id+" "+self.data.body_eleId;
	 				sub_ele.pcb_body = $(sub_ele.pcb_body_id);
	 				sub_ele.title_ele = $(sub_ele.pcb_body_id+" .pcb_title");
	 				sub_ele.content_ele = $(sub_ele.pcb_body_id+" .pcb_content");
	 				self.sub_ele =sub_ele;
 				},
 				data:{
 					ele:null,
	 				body_eleId:".pcb_body",
	 				is_loaded: false,
	 				doneBtn_class:""
	 			},
	 			play:function(title,content,callback){
	 				var self = this;
	 				self.playHTML(title,content,callback);
	 			},
	 			playHTML:function(title,content,callback){
	 				
	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.modal(id).playHTML(title,content,callback);
						}catch(e){}
						return;
					}

	 				var self = this;
	 		
	 				if(title){
	 					self.sub_ele.title_ele.html(title);
	 				}else{
	 					self.sub_ele.title_ele.html("Confirm?");
	 				}
	 				if(content){
	 					self.sub_ele.content_ele.html(content);
	 				}else{
	 					self.sub_ele.content_ele.html("Are you sure for this action.");
	 				}
	 			
	 				self.main_ele.finish();
	 				self.main_ele.clearQueue();
	 				self.main_ele.fadeIn(200,function(){
	 					self.sub_ele.pcb_body.show(function(){
	 						try{
								if(callback){callback(self);}
							}catch(e){}
	 					});
	 				});
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});

	 			},
	 			shake:function(){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.modal(id).shake();
						}catch(e){}
						return;
					}

	 				var self = this;
	 				// do shake
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'shake',function(){
	 					try{
							if(callback){callback(parent);}
						}catch(e){}
	 				});
	 			},
	 			stop:function(callback){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.modal(id).stop();
						}catch(e){}
						return;
					}

	 				var self = this;
	 				self.main_ele.finish();
	 				self.main_ele.clearQueue();
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});
	 				self.main_ele.fadeOut(200,function(){
	 					self.sub_ele.content_ele.html('');
	 					//stack_dict[self.main_id] = null;
	 					//delete stack_dict[self.main_id];
	 				});
	 			}
 			};
 			modal_obj.init();
 			stack_dict[id] = modal_obj;
 			console.log("modal_id : new : "+modal_obj.main_id);
 			return stack_dict[id];
 		},
 		confirmBox_dict:{},
 		confirmBox:function(id){
 			var parent = this;
 			var stack_dict = parent.confirmBox_dict;
 			if(!id){
 				id = "default-1000";
 			}
 			var confirmBox_obj = null;
 			try{
 				if(stack_dict[id]){
 					confirmBox_obj =  stack_dict[id];
 					return confirmBox_obj;
 				}
 			}catch(e){}

 			confirmBox_obj = {
 				main_id:id,
 				main_ele:null,
 				sub_ele:null,
 				init:function(){
 					var self = this;
 					var htmlStr = $('#gaeui_pageConfirmBox').html();
 					var main_ele = $('<div/>', {
								    'id':'gaeui_pageConfirmBox_id'+id,
								    'class':'gaeui_pageWrapModal',
								    'style':'z-index:1060;',
								    'html':htmlStr});
 					main_ele.appendTo('body');
 					self.main_ele = main_ele;
 					
 					var sub_ele = {};
 					sub_ele.pcb_body_id = "#"+self.main_ele.get(0).id+" "+self.data.body_eleId;
	 				sub_ele.pcb_body = $(sub_ele.pcb_body_id);
	 				sub_ele.title_ele = $(sub_ele.pcb_body_id+" .pcb_title");
	 				sub_ele.content_ele = $(sub_ele.pcb_body_id+" .pcb_content");
	 				sub_ele.btn_cancel = $(sub_ele.pcb_body_id+" .pcb_button_div .pcb_btn_cancel");
	 				sub_ele.btn_done = $(sub_ele.pcb_body_id+" .pcb_button_div .pcb_btn_done");
	 				self.sub_ele =sub_ele;
 				},
 				data:{
 					ele:null,
	 				body_eleId:".pcb_body",
	 				is_loaded: false,
	 				doneBtn_class:""
	 			},
	 			play:function(title,content,callback,doneBtn_name){
	 				var self = this;
	 				self.playHTML(title,content,callback,doneBtn_name);
	 			},
	 			playHTML:function(title,content,callback,doneBtn_name){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.confirmBox(id).playHTML(title,content,callback,doneBtn_name);
						}catch(e){}
						return;
					}
	 				
	 				var self = this;
	 		
	 				if(title){
	 					self.sub_ele.title_ele.html(title);
	 				}else{
	 					self.sub_ele.title_ele.html("Confirm?");
	 				}
	 				if(content){
	 					self.sub_ele.content_ele.html(content);
	 				}else{
	 					self.sub_ele.content_ele.html("Are you sure for this action.");
	 				}
	 				if(doneBtn_name){
	 					self.sub_ele.btn_done.html(doneBtn_name);
	 				}else{
	 					self.sub_ele.btn_done.html("Yes");
	 				}	
	 			
					self.sub_ele.btn_cancel.click(function(){
						try{
							if(callback){callback(false);}
						}catch(e){}
						//self.stop();
					});

					self.sub_ele.btn_done.click(function(){
						try{
							if(callback){callback(true);}
						}catch(e){}
					});	

	 				self.main_ele.finish();
	 				self.main_ele.clearQueue();
	 				self.main_ele.fadeIn(200,function(){
	 					self.sub_ele.pcb_body.show(function(){
	 						
	 					});
	 				});
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});
	 			},
	 			shake:function(callback){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.confirmBox(id).shake(callback);
						}catch(e){}
						return;
					}

	 				var self = this;
	 				// do shake
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'shake',function(){
	 					try{
							if(callback){callback(parent);}
						}catch(e){}
	 				});
	 			},
	 			stop:function(callback){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.confirmBox(id).stop(callback);
						}catch(e){}
						return;
					}

	 				console.log("stop");
	 				var self = this;
	 				self.sub_ele.content_ele.html('');
	 				self.main_ele.finish();
	 				self.main_ele.clearQueue();
	 				parent.doAnimateCss(self.sub_ele.pcb_body,'jellyBox',function(){});
	 				self.main_ele.fadeOut(200,function(){
	 					delete stack_dict[self.main_id];
	 				});
	 				
	 			},
	 			disableDoneBtn:function(){

	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.confirmBox(id).disableDoneBtn();
						}catch(e){}
						return;
					}

	 				var self = this;
	 				self.sub_ele.btn_done.addClass("disabled");

	 			},
	 			enableDoneBtn:function(){
	 				if(check_isInIFrame()){
						try{
							window.top.parent.GAEUI.confirmBox(id).enableDoneBtn();
						}catch(e){}
						return;
					}

	 				var self = this;
	 				self.sub_ele.btn_done.removeClass("disabled");
	 			}
 			};
 			confirmBox_obj.init();
 			stack_dict[id] = confirmBox_obj;
 			return stack_dict[id];
 		}

 	};
 	return GAEUI_OBJ;
 }
var GAEUI = new GAEUI_CLASS();

//GAEUI.confirmBox("id1").play();
//GAEUI.comfirmBox("id2").stop();

