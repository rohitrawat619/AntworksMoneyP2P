
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/bower_components/font-awesome/css/font-awesome.min.css')?>">
 
  <!-- Ionicons -->

  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/bower_components/Ionicons/css/ionicons.min.css')?>">
  <!-- jvectormap -->

  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/bower_components/jvectormap/jquery-jvectormap.css')?>">
  <!-- Theme style -->
 
  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
  <link rel="stylesheet" href="<?=base_url('assets-p2padmin/dist/css/skins/_all-skins.min.css')?>">

  
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

     <!-- jQuery 3 -->
<script src="<?=base_url('assets-p2padmin/bower_components/jquery/dist/jquery.min.js')?>"></script>

<!-- Bootstrap 3.3.7 -->

<script src="<?=base_url('assets-p2padmin/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
      </head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?=base_url('Surgeadmin/teamdashboard')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>INV</b>ST</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Investment</b>Module</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
   
          
          <li class="dropdown notifications-menu">
      
          
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
       
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          
            </a>
            <ul class="dropdown-menu">
            
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                
                 
                 
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
               
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url('assets-p2padmin/dist/img/user2-160x160.jpg')?>" class="user-image" alt="User Image">
			  <span class="hidden-xs"><?php echo $this->session->userdata('email'); ?></span>
            </a>
  </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="fa fa-gears"></i>
            </a>
            <ul class="dropdown-menu">
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url('Surgeadmin/teamdashboard')?>" class="btn btn-default btn-flat">Home</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('Surgeadmin/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
       
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
         <img src="<?=base_url('assets-p2padmin/dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
		  <p></p>
        </div>
        <div class="pull-left info">
      <!--<p><?php echo $this->session->userdata('email');?></p> -->
	  <h3 style="margin-top:1px;">Admin</h3>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
        
      </form>
    
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
         
		<li><a  href="<?=base_url('Surgeadmin/teamdashboard')?>"><i class="fa fa-home"></i> <span>Home</span></a></li> 
        <li><a href="<?=base_url('Surgeadmin/allpartner')?>"><i class="fa fa-users"></i> <span>Partner</span></a></li>
		<li><a href="<?=base_url('Surgeadmin/allschemes')?>"><i class="fa fa-briefcase"></i> <span>Schemes</span></a></li>
    
  
  <li><a href="<?=base_url('Surgeadmin/allrepersentative')?>">
            <i class="fa fa-user-plus"></i>
            <span>All Repersentative</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>

  <li><a href="<?=base_url('Surgeadmin/Investmentlist')?>">
            <i class="fa fa-credit-card-alt"></i>
            <span>Investment list</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>

 <!-- <li><a href="<?=base_url('Surgeadmin/redemptionlist')?>">
            <i class="fa fa-user-circle-o"></i>
            <span>Redemption list</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li> -->

 <li class="treeview">
  <a href="#">
    <i class="fa fa-money"></i>
    <span>Redemption</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>

  <ul class="treeview-menu">
    <li><a href="<?=base_url('Surgeadmin/redemptionlist_request')?>"><i class="fa fa-ellipsis-v"></i>Redemption Request</a></li>
    <li><a href="<?=base_url('Surgeadmin/redemption_pending')?>"><i class="fa fa-ellipsis-v"></i>Pending for Redemption</a></li>
    <li><a href="<?=base_url('Surgeadmin/redemption_process')?>"><i class="fa fa-ellipsis-v"></i>Redemption in Process</a></li>
    <li><a href="<?=base_url('Surgeadmin/redeem')?>"><i class="fa fa-ellipsis-v"></i>Redeem</a></li>

  </ul>

 </li> 

  <!-- <li><a href="<?=base_url('Surgeadmin/disbursmentlist')?>">
            <i class="fa fa-address-book"></i>
            <span>Disbursment list</span>
            <span class="pull-right-container">
            </span>
          </a>
      </li>

  <li><a href="<?=base_url('Surgeadmin/disburse')?>">
            <i class="fa fa-folder-open"></i>
            <span>Disbursed List</span>
            <span class="pull-right-container">
            </span>
          </a>
     </li>


  <li><a href="<?=base_url('Surgeadmin/dipending')?>">
            <i class="fa fa-folder"></i>      
            <span>Disbursment Pending List</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

