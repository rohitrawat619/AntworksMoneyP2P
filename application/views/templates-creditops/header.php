<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="Nishant Singh @ Lopamudra Creative">
<link rel="icon" type="image/png" sizes="16x16" href="https://www.antworksmoney.com/assets/img/favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url();?>assets-admin/plugins/images/favicon.png">
<title>Antworks Money Admin</title>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url();?>assets-admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Footable CSS -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
<link href="<?=base_url();?>assets-admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<!-- Dropzone css -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
<!-- toast CSS -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
<!-- morris CSS -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?=base_url();?>assets-admin/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=base_url();?>assets-admin/css/style.css" rel="stylesheet">
<link href="<?=base_url();?>assets-admin/css/mystyle.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?=base_url();?>assets-admin/css/colors/default.css" id="theme"  rel="stylesheet">
<!-- Date picker plugins css -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>assets-admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<!--alerts CSS -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<!--Magnific Popup CSS -->
<link href="<?=base_url();?>assets-admin/css/magnific-popup.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets-admin/css/jquery-ui.css"/>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- jQuery -->
<script src="<?=base_url();?>assets-admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<body class="fix-header">
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
<!-- Top Navigation -->
<nav class="navbar navbar-default navbar-static-top m-b-0">
  <div class="navbar-header"> 
    
    <!-- .Logo -->
    <ul class="nav navbar-top-links navbar-left">
      <li><a href="<?=base_url();?>login/" class="logotext"><!--This is logo text--><img src="<?=base_url();?>assets-admin/plugins/images/admin-logo.png" alt="home" class="light-logo" alt="home" /></a></li>
    </ul>
    <!-- /.Logo --> 
    
    <!-- top right panel -->
    <ul class="nav navbar-top-links navbar-right pull-right">

      <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php echo $this->session->userdata('user_name');?></b> </a>
        
		<ul class="dropdown-menu dropdown-user animated flipInY">
		  <!-- User image -->
              <li class="user-header">
                <!--img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"-->
				<img src="<?=base_url();?>assets-admin/plugins/images/users/varun.jpg" alt="home" class="img-circle" alt="home" />
                <p>
                  <?php echo $this->session->userdata('user_name');?><br>
                  <small>Last Login: Oct. 20 Saturday, 2018</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="">
                  <a href="#" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i> Sign Out</a>
                </div>
              </li>
			
			
          <!--li><a href="<?=base_url().'bidding/changepassword';?>"><i class="ti-user"></i> Change Password  </a></li>
          <li role="separator" class="divider"></li>
          <li><a href="<?=base_url();?>login/logout/"><i class="fa fa-power-off"></i> Logout</a></li-->
        </ul>
      </li> 
    </ul>
    <!-- top right panel --> 
    
  </div>
</nav>
<!-- End Top Navigation --> 
