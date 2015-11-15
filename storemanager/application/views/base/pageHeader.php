<!DOCTYPE html>
<html>
<head>
    <title>GETAPPEASY STORE CENTER</title>
    <meta name="fragment" content="!">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link href="<?php echo root_sitefiles_url(); ?>js/angular-notify/angular-notify.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo root_sitefiles_url(); ?>/bootstrap/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,200italic,300italic,600,600italic,700,700italic,400italic,900,900italic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo base_sitefiles_url(); ?>css/base.css" />  
    <script type="text/javascript" src="<?php echo root_sitefiles_url(); ?>js/jquery/jquery.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-route.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-animate.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular/angular-cookies.min.js"></script>
    <script src="<?php echo root_sitefiles_url(); ?>js/angular-notify/angular-notify.min.js"></script>
    <script src="<?php echo root_ngservices_url(); ?>gurl/GURL.js"></script>
</head>
<style type="text/css">
    body{ background: #fff; color: #000;}
    #pageContent{ min-width: 680px;}
</style>
<body >
    <ui-page-loading></ui-page-loading>
    <script type="text/javascript">
        GURL.init("<?=root_url();?>","<?=base_url();?>","<?=base_api_url();?>");
    </script>
    <div  id="pageHeader">
        <?= $this->load->view('menu/main_menu'); ?>
    </div>
    <div id="pageContent">
    <!--pageContent :: START -->

