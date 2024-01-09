<?php $path = "/surgeModule/";
				$this->load->library('uri');
$controller_name = $this->uri->segment(3);

/* Assuming $user_permissions is an array containing the user's permissions
$arrayData = 'dashboard,partners,partners_list,add_partners_fodrm,lender,scheme,scheme_list,add_scheme_form,user,user_list,add_user_form,redemption,redemption_list_pending,redemption_list_generate_bank_file,redemption_list_under_process,redemption_list_redeemed,investment,ticket
'; */
$user_permissions = explode(',',str_replace(["\n", "\r"],'',$this->session->userdata('admin_access')));
 
//echo $controller_name;

				?>
<aside class="main-sidebar">
		
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
	
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
		 <li >
		</li>
		<?php if(in_array('dashboard', $user_permissions)){ ?>
            <li class="dashboard <?php echo ($controller_name === 'dashboard') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/dashboard';?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span>

                </a>
            </li>
			<?php } ?>
					<!----
			 <li class="profile1"><a href="<?=base_url();?>p2padmin/mis/"><i class="fa fa-user"></i> <span>MIS </span>

                </a>
            </li>  ---->
				<?php if(in_array('partners', $user_permissions)){?>
            <li  class="commoneSection treeview <?php echo ($controller_name === 'partners_list' || $controller_name === 'add_partners_form') ? 'active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Partners Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
				<?php if(in_array('partners_list', $user_permissions)){ ?>
				<li class="profile1 <?php echo ($controller_name === 'partners_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/partners_list';?>">Partners List</a></li> <?php } ?>
				<?php if(in_array('add_partners_form', $user_permissions)){ ?>
                    <li class="profile2 <?php echo ($controller_name === 'add_partners_form') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/add_partners_form';?>"></span>Add Partners</a></li>  <?php } ?>
                </ul>
            </li>
				<?php } ?>
				
				<?php if(in_array('user', $user_permissions)){?>
		     <li class="commoneSection treeview <?php echo ($controller_name === 'user_list' || $controller_name === 'add_user_form') ? 'active' : ''; ?> ">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
				<?php if(in_array('user_list', $user_permissions)){?>
                    <li class="profile1 <?php echo ($controller_name === 'user_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/user_list';?>">User List</a></li> <?php } ?>
					
					<?php if(in_array('add_user_form', $user_permissions)){?>
                    <li class="profile2 <?php echo ($controller_name === 'add_user_form') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/add_user_form';?>"></span>Add User</a></li> <?php } ?>
					
                </ul>
            </li>
		   <?php } ?>
				
				<?php if(in_array('scheme', $user_permissions)){?>
			  <li class="commoneSection treeview <?php echo ($controller_name === 'scheme_list' || $controller_name === 'add_scheme_form') ? 'active' : ''; ?> ">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span>Scheme Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
				<?php if(in_array('scheme_list', $user_permissions)){?>
                <ul class="treeview-menu">
                    <li class="profile1 <?php echo ($controller_name === 'scheme_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/scheme_list';?>">Scheme List</a></li>  <?php } ?>
					<?php if(in_array('add_scheme_form', $user_permissions)){?>
                    <li class="profile2 <?php echo ($controller_name === 'add_scheme_form') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/add_scheme_form';?>"></span>Add Scheme</a></li>  <?php } ?>
                </ul>
            </li>
					<?php } ?>
				
				<?php if(in_array('lender', $user_permissions)){?>
			  <li class="lenderSection treeview <?php echo ($controller_name === 'lender_list' || $controller_name === 'add_lender') ? 'active' : ''; ?> ">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Lender Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1 <?php echo ($controller_name === 'lender_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/lender_list';?>">Lender List</a></li>
					  <li class="profile1 <?php echo ($controller_name === 'investment_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/investment_list';?>">Investment List</a></li>
					
					<!----
                    <li class="profile2 <?php echo ($controller_name === 'add_lender') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/add_lender';?>"></span>Add Lender</a></li> ---->
                </ul>
            </li>
						<?php } ?>
			
			<?php /* if(in_array('investment', $user_permissions)){?>
			  <li class="treeview <?php echo ($controller_name === 'investment_list' || $controller_name === 'add_investment') ? 'active' : ''; ?> ">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Investment Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1 <?php echo ($controller_name === 'investment_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/investment_list';?>">Investment List</a></li>
                  </ul>
            </li>		<?php } */ ?>
			
			<?php if(in_array('redemption', $user_permissions)){?>
		     <li class="lenderSection treeview <?php echo (strpos($controller_name, 'redemption') !== false) ? 'active' : ''; ?> ">
                <a href="#">
                    <i class="fa fa-trophy"></i>
                    <span>Redemption Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
				<?php if(in_array('redemption_list_pending', $user_permissions)){?>
				<li class="profile1 <?php echo ($controller_name === 'redemption_list_pending') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/redemption_list_pending';?>">Pending List</a></li>  <?php } ?>
				
				<?php if(in_array('redemption_list_generate_bank_file', $user_permissions)){?>
				<li class="profile1 <?php echo ($controller_name === 'redemption_list_generate_bank_file') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/redemption_list_generate_bank_file';?>">Generate Bank File List</a></li>  <?php } ?>
				
				<?php if(in_array('redemption_list_under_process', $user_permissions)){?>
				<li class="profile1 <?php echo ($controller_name === 'redemption_list_under_process') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/redemption_list_under_process';?>">Under Process List</a></li>  <?php } ?>
				
				<?php if(in_array('redemption_list_redeemed', $user_permissions)){?>
				<li class="profile1 <?php echo ($controller_name === 'redemption_list_redeemed') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/redemption_list_redeemed';?>">Redeemed List</a></li>   <?php } ?>
                </ul>
            </li>		<?php } ?>
					
					<?php if(in_array('ticket', $user_permissions)){?>
			  <li class="lenderSection treeview <?php echo ($controller_name === 'ticket_list' || $controller_name === 'raise_ticket' || $controller_name === 'ticket_detail_form') ? 'active' : ''; ?> ">
                <a href="#" >
                    <i class="fa fa-ticket"></i>
                    <span>Ticket Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1 <?php echo ($controller_name === 'ticket_list') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/ticket_list';?>">Ticket List</a></li>
                    <li class="profile2 <?php echo ($controller_name === 'raise_ticket') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/raise_ticket';?>"></span>Raise Ticket</a></li>
                </ul>
            </li>		<?php } ?>
			
			
			
			<!-------------------starting of borrowerSection------------------>
			
				  <li class="borrowerSection treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Borrower</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url();?>p2padmin/p2pborrower/borrowers"><span class="fa fa-sign-out"></span>  ALL Borrower</a></li>
					<li><a href="<?=base_url();?>p2padmin/p2pborrower/downloadBorrowers"><span class="fa fa-address-book"></span> Download Users</a></li>
                </ul>
            </li>
				

		   <li class="borrowerSection treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Process Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1"><a href="<?=base_url().'p2padmin/p2pborrower/step_1';?>">Stage-1 KYC</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_2';?>">Stage-2 credit decision</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_3';?>">Stage-3 E-NACH</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_4';?>">STAGE-4 LOAN AGREEMENT</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_5';?>">STAGE-5 E SIGN</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_6';?>">STAGE-6 DISBURSMENT REQUEST</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2pborrower/step_7';?>">STAGE-7 NBSP DISBURSMENT(LOAN NUMEBER/LOAN SCHEDULE GENERATE)</a></li>
                </ul>
            </li>
            <li class="borrowerSection treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Basic Filter</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1"><a href="<?=base_url().'p2padmin/basicfilter';?>"> Basic Filter Rule</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/basicfilter/report';?>"> Basic Filter Report</a></li>
                </ul>
            </li>
			<li class="borrowerSection treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Disbursement</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url();?>p2padmin/list_for_disbursement"><span class="fa fa-address-book"></span> Disbursement Request</a></li>
                    <li><a href="<?=base_url();?>p2padmin/disbursement_request_list"><span class="fa fa-address-book"></span> Disbursement</a></li>
                </ul>
            </li>
					<!--------------------ending of borrowerSection-------------------->
			
					<!-------
		     <li class=" <?php echo ($controller_name === 'change_password') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/change_password';?>"><a href="<?=base_url().$path.'surge/change_password';?>"><i class="fa fa-key"></i> <span>Change Password</span>   --------->

                </a>
            </li>
			
					     <li class=" <?php echo ($controller_name === 'sign_out') ? 'active' : ''; ?>"><a href="<?=base_url().$path.'surge/sign_out';?>"><a href="<?=base_url().$path.'surge/sign_out';?>"><i class="fa fa-sign-out"></i>
						 <span>Sign Out (<?php echo $this->session->userdata('user_name'); ?>)</span>

                </a>
            </li>
			
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: 200px; overflow: auto;">

<style>
.commoneSection{
	background-color:#30d73338;
	color:white;
}

.lenderSection{
	background-color:#3ad3ec38;
	color:white;
}

.borrowerSection{
	background-color:#f013134f;
	color:black;
}
</style>