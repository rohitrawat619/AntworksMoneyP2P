<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="dashboard"><a href="<?=base_url();?>p2padmin/dashboard/"><i class="fa fa-dashboard"></i> <span>Dashboard</span>

                </a>
            </li>
			
			 <li class="profile1"><a href="<?=base_url();?>p2padmin/mis/"><i class="fa fa-user"></i> <span>MIS </span>

                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile1"><a href="<?=base_url().'p2padmin/p2pborrower/borrowers';?>"> Borrower List</a></li>
                    <li class="profile2"><a href="<?=base_url().'p2padmin/p2plender/lenders';?>"></span> Lender List</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Appliction Status</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile3"><a href="<?=base_url().'p2padmin/p2papplication/activeapplication';?>">Processing</a></li>
                    <li class="profile4"><a href="<?=base_url().'p2padmin/p2papplication/approval_pending_application';?>">Approval Pending</a></li>
                    <li class="profile5"><a href="<?=base_url().'p2padmin/p2papplication/partially_approve_application';?>">Partially Approved</a></li>
                    <li class="profile6"><a href="<?=base_url().'p2padmin/p2papplication/approved_application';?>">Approved</a></li>
                    <li class="profile7"><a href="<?=base_url().'p2padmin/p2papplication/rejected_application';?>">Rejected</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Loan Status</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile8"><a href="<?=base_url().'p2padmin/#';?>">Agreement Signing Status</a></li>
                    <li class="profile9"><a href="<?=base_url().'p2padmin/#';?>">Verification Status</a></li>
                    <li class="profile10"><a href="<?=base_url().'p2padmin/#';?>">Loan Document Status</a></li>
                    <li class="profile11"><a href="<?=base_url().'p2padmin/#';?>">Pending for Disbursement</a></li>
                    <li class="profile12"><a href="<?=base_url().'p2padmin/#';?>">Disbursed</a></li>
                    <li class="profile13"><a href="<?=base_url().'p2padmin/#';?>">Rejected</a></li>
                </ul>
            </li>
			<li><a href="<?=base_url();?>p2padmin/loanmanagement/loanlist"><span class="fa fa-sign-out"></span> Loan List</a></li>
			<li><a href="<?=base_url();?>p2padmin/loanmanagement/trialBalance"><span class="fa fa-sign-out"></span> Trial Balance</a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Transaction Statement</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="profile14"><a href="<?=base_url().'p2padmin/#';?>">Disbursed Statement</a></li>
                    <li class="profile15"><a href="<?=base_url().'p2padmin/#';?>">Re-Payment Statement</a></li>
                    <li class="profile16"><a href="<?=base_url().'p2padmin/#';?>">Loan Document Status</a></li>
                    <li class="profile17"><a href="<?=base_url().'p2padmin/#';?>">Prepayment Statement</a></li>
                    <li class="profile18"><a href="<?=base_url().'p2padmin/#';?>">Foreclosure Statement</a></li>
                </ul>
            </li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>Notification</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li class="profile3"><a href="<?=base_url().'p2padmin/emailnotification';?>">Notification List</a></li>
					<li class="profile4"><a href="<?=base_url().'p2padmin/emailnotification/addnotification';?>">Add Notification</a></li>
				</ul>
			</li>
            <li><a href="<?=base_url();?>p2padmin/p2pborrower/downloadBorrowers"><span class="fa fa-address-book"></span> Download Users</a></li>
            <li><a href="<?=base_url();?>p2padmin/changepassword"><span class="fa fa-sign-out"></span> Change Password</a></li>
            <li><a href="<?=base_url();?>login/Logoutadmin/"><span class="fa fa-sign-out"></span> Logout</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
