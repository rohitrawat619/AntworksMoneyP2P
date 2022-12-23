<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="Dinesh Kumar Sharma">
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
<!-- daterange picker -->
<link rel="stylesheet" href="<?=base_url();?>assets-p2padmin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<!-- Date picker plugins css -->
<link href="<?=base_url();?>assets-admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
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
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
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
    <ul class="nav navbar-top-links navbar-left">
      <li><a href="<?=base_url();?>login/" class="logotext"><!--This is logo text--><img src="<?=base_url();?>assets-admin/plugins/images/admin-logo.png" alt="home" class="light-logo" alt="home" /></a></li>
    </ul>

    <ul class="nav navbar-top-links navbar-right pull-right">

     	<?
        $login_time = $this->Requestmodel->lastLogintime($this->session->userdata('email'));
        $progile_pic = $this->Requestmodel->lenderProfilepic($this->session->userdata('user_id'));

     	 if($progile_pic)
			{
				$user_image = base_url()."assets/lender-documents/".$progile_pic;
			}
			else
			{
				$user_image =  base_url()."assets/img/users/user.png";
			}
		?>
      <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php echo $this->session->userdata('name');?></b> </a>
        
		<ul class="dropdown-menu dropdown-user animated flipInY">
              <li class="user-header">
				<img src="<?=$user_image?>" alt="home" class="img-circle" alt="home" />
                <p>
                  <?php echo $this->session->userdata('user_name');?><br>
                  <small>Last Login: <?=$login_time?></small>
                </p>
              </li>
              <li class="user-footer pull-left">
                <div class="">
                  <a href="<?=base_url();?>login/logout/" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i> Sign Out</a>
                </div>
              </li>
			<li class="user-footer pull-right">
                <div class="">
                  <a href="<?=base_url();?>lender/help-center" class="btn btn-default btn-flat"><i class="fa fa-phone"></i> Help </a>
                </div>
              </li>
        </ul>
      </li> 
    </ul>
	  <? $auto_investment = $this->Requestmodel->preferences($this->session->userdata('user_id')); ?>
	  <ul class="nav navbar-top-links navbar-right pull-right" style="text-align: center">
		  <div class="onoffswitch" style="pointer-events: none">
			  <input type="checkbox" name="investment" class="onoffswitch-checkbox"
					 id="" <?php if ($auto_investment['auto_investment'] == 1) {
				  echo "checked";
			  } ?>>
			  <label class="onoffswitch-label" for="myonoffswitch">
				  <span class="onoffswitch-inner"></span>
				  <span class="onoffswitch-switch"></span>
			  </label>
		  </div>
		  <p style="color: #fff; font-size: 11px">Auto Investment</p>
	  </ul>
  </div>
</nav>
