
var MODULE_BAR_CLASS = function(){
	var count_id = 0;
	var MODULE_BAR_OBJ  = {
		init:function(){

		},
		addButtonLeft:function(class_name,name_str,onClick_callback){
			var self = this;
			self.addButton("left",class_name,name_str,onClick_callback);
		},
		addButtonRight:function(class_name,name_str,onClick_callback){
			var self = this;
			self.addButton("right",class_name,name_str,onClick_callback);
		},
		addButton:function(position,class_name,name_str,callback){

			var btn_ele = $('<button/>', {
								    'id':'gae_module_bar_btn_'+name+"_"+count_id,
								    'class':"btn btn-sm btn-gae-manager  "+class_name,
								    'style':"margin:0px 10px;",
								    'html':name_str
								});
			if(position=="right"){
				btn_ele.appendTo('#gae_module_bar_btn_box_right');
				btn_ele.css({"margin-left":"-10px;"});
			}else{
				btn_ele.appendTo('#gae_module_bar_btn_box_left');
				btn_ele.css({"margin-right":"-10px;"});	
			}
			btn_ele.click(function(){
				try{
	 				if(callback){callback(btn_ele);}
	 			}catch(e){}
			});
			count_id++;
		}
	};
	MODULE_BAR_OBJ.init();
	return MODULE_BAR_OBJ;
};

var MODULE_BAR = new MODULE_BAR_CLASS();