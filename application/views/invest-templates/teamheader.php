
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Buisness Team Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url('bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('bower_components/font-awesome/css/font-awesome.min.css')?>">
  <!-- <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css"> -->
  <link rel="stylesheet" href="<?=base_url('bower_components/Ionicons/css/ionicons.min.css')?>">
  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
  <link rel="stylesheet" href="<?=base_url('bower_components/jvectormap/jquery-jvectormap.css')?>">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> -->
  <link rel="stylesheet" href="<?=base_url('dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css"> -->
  <link rel="stylesheet" href="<?=base_url('dist/css/skins/_all-skins.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?=base_url('welcome/teamdashboard')?>" class="logo">
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
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          
          <li class="dropdown notifications-menu">
      
          
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
       
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          
            </a>
            <ul class="dropdown-menu">
            
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                
                  <!-- end task item -->
                 
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
              <img src="<?=base_url('dist/img/user2-160x160.jpg')?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php  $udata = $this->session->userdata('Teamloginsession'); echo strtoupper($udata['fullname']); ?></span>
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
                  <a href="<?=base_url('welcome/teamdashboard')?>" class="btn btn-default btn-flat">Home</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('welcome/logout')?>" class="btn btn-default btn-flat">Sign out</a>
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
          <img src="<?=base_url('dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
		  <p></p>
        </div>
        <div class="pull-left info">
          <p><?php echo strtoupper($udata['fullname']); ?></p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
        
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
         
		<li><a  href="<?=base_url('welcome/teamdashboard')?>"><i class="fa fa-dashboard"></i> <span>Home</span></a></li> 
        <li><a href="<?=base_url('welcome/allvendors')?>"><i class="fa fa-dashboard"></i> <span>Partners</span></a></li>
		<li><a href="<?=base_url('welcome/allschemes')?>"><i class="fa fa-dashboard"></i> <span>Schemes</span></a></li>
    

    <li><a href="<?=base_url('welcome/register_partner')?>">
            <i class="fa fa-edit"></i>
            <span>Add Vendor</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>
  <li><a href="<?=base_url('welcome/add_representative')?>">
            <i class="fa fa-edit"></i>
            <span>Add Representative</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>
  <li><a href="<?=base_url('welcome/vend_addscheme')?>">
            <i class="fa fa-edit"></i>
            <span>Add Schemes</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>
  <li><a href="<?=base_url('welcome/allrepersentative')?>">
            <i class="fa fa-envelope"></i>
            <span>Redemption Requests</span>
            <span class="pull-right-container">
            </span>
          </a>
  </li>

  <li><a href="<?=base_url('welcome/Home')?>">
            <i class="fa fa-files-o"></i>
            <span>Testing</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">Test</span>
            </span>
          </a>
  </li>
  
    
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

