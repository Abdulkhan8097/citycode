<?php $session = session(); ?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="msapplication-TileColor" content="#ff685c">
		<meta name="theme-color" content="#32cafe">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		
		

		<!-- Title -->
		<?php include_title(); ?>
        <?php include_metas(); ?>

		<!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('admin/images/city-logo.jpg'); ?>">
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

        <!-- Lightbox css -->
        <link href="<?php echo base_url('admin/libs/magnific-popup/magnific-popup.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url('admin/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url('admin/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url('admin/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('admin/css/app.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Sweet Alert-->
        <link href="<?php echo base_url('admin/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />

         <!-- Summernote css -->
        <link href="<?php echo base_url('admin/libs/summernote/summernote-bs4.min.css'); ?>" rel="stylesheet" type="text/css" />

		<script src="<?php echo base_url('/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('/js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


  </head>
  
  
      <?php if($session->get('isAdminLoggedIn')){ ?>
		<body data-sidebar="dark">
			<!-- Begin page -->
			<div id="layout-wrapper">

        
	        <?php  echo view('admin/topmenu'); ?>
	        <?php if(LEFTPANEL){ ?>
	        <?php  echo view('admin/leftpanel'); ?>
	        <div class="main-content">  
	        <?php } ?>
	        <?php }else{ ?>
	            <body>
	        <?php }   ?>