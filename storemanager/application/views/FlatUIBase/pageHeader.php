<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Flat UI Pro</title>
    <meta charset="utf-8">
    <meta name="fragment" content="!">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo root_sitefiles_url(); ?>js/angular-notify/angular-notify.css" rel="stylesheet">
    <!-- Loading Bootstrap -->
    <link href="<?=root_sitefiles_url(); ?>flat-ui/UI/pro/dist/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?=root_sitefiles_url(); ?>flat-ui/UI/pro/dist/css/flat-ui-pro.css" rel="stylesheet">
    <link href="<?=root_sitefiles_url(); ?>flat-ui/UI/pro/docs/assets/css/docs.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,200italic,300italic,600,600italic,700,700italic,400italic,900,900italic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo base_sitefiles_url(); ?>css/base.css" />  
    <script type="text/javascript" src="<?php echo root_sitefiles_url(); ?>js/jquery/jquery.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-route.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-animate.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-cookies.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular-notify/angular-notify.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/jquery/jquery.animateNumber.min.js"></script>
    <script src="<?php echo root_ngservices_url(); ?>gurl/GURL.js"></script>
    <script src="<?php echo root_ngservices_url(); ?>gaeui/GAEUI.js"></script>
    <link rel="stylesheet" href="<?php echo root_sitefiles_url(); ?>flat-ui/flat-ui-custom.css" /> 
    <link rel="shortcut icon" href="<?=root_sitefiles_url(); ?>ui/flat-ui/dist/img/favicon.ico">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="../dist/js/vendor/html5shiv.js"></script>
      <script src="../dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <style type="text/css">
        /* btn  : START*/
        .rad_btn{
            color: white;
            margin: 0px 10px;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
            min-width: 30px;
            min-height: 30px;
            border: 0px;
            background-color: #ff5000;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
        }
        .rad_btn:active{ outline: 0; } 
        .rad_btn:focus{ outline: 0; }

        /* btn  : END*/
        /* pageLoading : START */
        #pageLoading{
            position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; background:rgba(0,0,0,0.6); margin:0px; padding: 10px; display: none; z-index: -1;
        }
        #pageLoading .pld_body{ position: relative;  width: 280px; min-height: 200px; margin: auto; top: 40%; margin-top:-100px;}
        #pageLoading .pld_body .pld_load_label{ color: #fff; text-align: left;  width: 200px;  margin: auto; font-size: 36px; padding-left:10; }
        #pageLoading .pld_body .pld_load_progress{ color: #fff; text-align: center;  width: 176px;  margin: auto;}
        /* pageModal : END */

        /* pageModal : START */
        #pageModal{ position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; background:rgba(0,0,0,0.6); margin:0px;padding: 10px; display: none; z-index: -1;
        }
        #pageModal .pml_body{  position: relative;  width: 470px; min-height: 100px; margin: auto; top: 40%; margin-top:-100px; background: #fff;  padding:20px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
        }
        #pageModal .pml_body .pml_title{ position: relative;  height: 30px; 
            padding: 0px 20px;
            color: #ff5000;
            font-family: "Source Sans Pro";
            font-size: 20px;
            font-weight: 700;
            line-height: 30px;
            text-align: center;
        }
        #pageModal .pml_body .pml_detail{
            position: relative; margin: 0px; margin-top: 4px;  min-height: 22px;  padding: 0px 20px;
            text-align: center; 
            color: #333;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
            background: #f0f;
        }
        #pageModal .pml_body .pml_button_div{ margin: 0px; margin-top: 20px; background: #ff0; padding: 0px; }
        #pageModal .pml_body .pml_button_div .pml_btn{width: 120px; margin: 0px 10px; }
        #pageModal .pml_body .pml_button_div .pml_btn.cancel{ }
        #pageModal .pml_body .pml_button_div .pml_btn.done{ }
         
        /* pageModal : END */

    </style>
    <div id="pageLoading">
        <div class="pld_body">
            <div class="pld_load_label user-interact-false"></div>
            <div class="pld_load_progress"></div>
        </div>
    </div>
    <div id="pageModal">
        <div class="pml_body">
            <div class="pml_title">Reset Point</div>
            <div class="pml_detail">ล้างแต้มจากสมาชิกที่เลือกทั้งหมด ให้เป็น 0</div>
            <div class="pml_button_div">
                <div class="btn pml_btn cancel rad_btn">Cancel</div>
                <div class="btn pml_btn done rad_btn">Done</div>
            </div>
        </div>
    </div>
    <ui-page-loading></ui-page-loading>
    <script type="text/javascript">
        GURL.init("<?=root_url();?>","<?=base_url();?>","<?=base_api_url();?>");
    </script>
    <div  id="pageHeader">
    </div>
    <div id="pageContent">
    <!--pageContent :: START -->

