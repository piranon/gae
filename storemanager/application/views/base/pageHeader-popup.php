<!DOCTYPE html>
<html lang="en">
  <head>
    <title>GAE STOREMANGER</title>
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
    <script src="<?php echo root_ngservices_url(); ?>gaeapi/GAEAPI.js"></script>
    <link rel="stylesheet" href="<?php echo root_sitefiles_url(); ?>flat-ui/flat-ui-custom.css" /> 
    <script src="<?=root_sitefiles_url(); ?>flat-ui/UI/pro/docs/assets/js/application.js"></script>
    <link rel="shortcut icon" href="<?=root_sitefiles_url(); ?>ui/flat-ui/dist/img/favicon.ico">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="../dist/js/vendor/html5shiv.js"></script>
      <script src="../dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?= $this->load->view('gaeui/html_element'); ?>
    <ui-page-loading></ui-page-loading>
    <script type="text/javascript">
        GURL.init("<?=root_url();?>","<?=base_url();?>","<?=base_api_url();?>");
    </script>

    <style type="text/css">
        body{ width: 100%; min-width:470px; max-width: 1440px; padding: 0px; margin: 0px auto; }
        #pageHeader{ padding: 0px; margin: 0px; height: 0px; display: none; }
        #pageContent{ width: 100%; max-width: 100%; padding: 0px; margin: 0px;}
    </style>
    <div  id="pageHeader">
    </div>
    <script  src="<?php echo base_sitefiles_url(); ?>module_bar/MODULE_BAR.js"></script>
    <div id="gae_manager_view-header-real_location"></div>
    <div id="pageContent">
    <!--pageContent :: START -->
       <div id="gae_manager_view-left-real_location"></div>
       <div id="gae_manager_view-right-real_location"></div>
