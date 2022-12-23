<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="dashboard"><a href="<?=base_url();?>p2padmin/dashboard/"><i class="fa fa-dashboard"></i> <span>Dashboard</span>

					</a>
				</li>

				<li class="profile1"><a href="<?=base_url().'teamleader/borrowers';?>"> <span class="fa fa-user"></span></i>Borrower List</a></li>
				<?php if($this->session->userdata('email') == 'navin.singh@antworksmoney.com'){?>
                <li class="profile2"><a href="<?=base_url().'teamleader/lenders';?>"> <span class="fa fa-user"></span> Lender List</a></li>
				<?php }?>
				<!--<li><a href="<?=base_url();?>p2padmin/p2pborrower/downloadBorrowers"><span class="fa fa-address-book"></span> Download Users</a></li>-->
                <li><a href="<?=base_url();?>p2padmin/changepassword"><span class="fa fa-sign-out"></span> Change Password</a></li>
				<li><a href="<?=base_url();?>login/Logoutadmin/"><span class="fa fa-sign-out"></span> Logout</a></li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
