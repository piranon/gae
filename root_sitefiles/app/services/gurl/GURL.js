 var GURL = {
        projectName:"",
        apiVersion:"v1",
        data:{},
        init:function(root_url,base_url,base_api_url){
          var self = this;
          self.data.root_url = root_url;
          self.data.base_url =base_url;
          self.data.base_api_url = base_api_url;  
        },
        root_url:function(){
            var self = this;
            return self.data.root_url;
        },
        base_url:function(){
            var self = this;
            return self.data.base_url;
        },
        base_api_url:function(){
            var self = this;
            return self.data.base_api_url;
            //return "http://128.199.139.181/gae/storeconsole_api/v1/";
        },
        base_sitefiles_url:function(){
            var self = this;
            return self.base_url()+"sitefiles/";
        },
        base_ngservices_url:function(){
            var self = this;
            return self.base_sitefiles_url()+"app/services/";
        },
        base_ngview_url:function(){
            var self = this;
            return self.base_sitefiles_url()+"app/views/";
        }
    };
