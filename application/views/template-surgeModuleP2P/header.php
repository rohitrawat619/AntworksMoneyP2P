<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lend Social | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/Ionicons/css/ionicons.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/plugins/iCheck/all.css">

    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/assets/css/mystyle.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script>
        var baseURL = "<?php echo base_url(); ?>";
    </script>
	<!-- jQuery 3 -->
	<script src="<?=base_url();?>assets-p2padmin/bower_components/jquery/dist/jquery.min.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<style>
       

        .message-container_ticket {
          //  max-width: 800px;
            margin: 10px auto;
            overflow: hidden;
			
        }

        .message_ticket {
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            max-width: 80%;
        }

        .left-message_ticket {
            background-color: #e0e0e0;
            float: left;
        }

        .right-message_ticket {
            background-color: #4caf50;
            color: #fff;
            float: right;
        }
    </style>
	
</head>
<body class="hold-transition skin-blue sidebar-mini" >
<div id="wrapper" class="wrapper" style="overflow:hidden; font-family:Segoe UI">
<!-- Top Navigation -->
    <header class="main-header">

        <!-- Logo -->
        <a href="javascript:void(0)" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Lend Social</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Lend Social</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
			
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
			<a href="<?php echo base_url();?>surgeModule/surge/sign_out">
				<span class="btn btn-default" ><i class="fa fa-sign-out"></i>
						 <span>Sign Out (<?php echo $this->session->userdata('user_name'); ?>)</span>
									 </span> </a>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->

