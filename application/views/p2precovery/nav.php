<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="dashboard"><a href="<?=base_url();?>p2precovery/dashboard/"><i class="fa fa-dashboard"></i> <span>Dashboard</span>

                </a>
            </li>
			<li><a href="<?=base_url();?>p2precovery/loanlist/"><span class="fa fa-calculator"></span> Loan List</a></li>
			<li><a href="<?=base_url();?>p2precovery/loanlist_due_30/"><span class="fa fa-calculator"></span> Loan Due 30 Days</a></li>
			<li><a href="<?=base_url();?>p2precovery/loanlist_due_30_60"><span class="fa fa-calculator"></span> Loan Due 30-60 Days</a></li>
			<li><a href="<?=base_url();?>p2precovery/loanlist_due_60_90"><span class="fa fa-calculator"></span> Loan Due 60-90 Days</a></li>
			<li><a href="<?=base_url();?>p2precovery/loanlist_due_90"><span class="fa fa-calculator"></span> Loan Due > 90 Days</a></li>
			<li><a href="<?=base_url();?>p2precovery/pendigApproval/"><span class="fa fa-calculator"></span> Panding Approval EMI</a></li>
			<li><a href="<?=base_url();?>p2precovery/lenderofflinepayment/"><span class="fa fa-calculator"></span>Lender Ofline Payment</a></li>
			<li><a href="<?=base_url();?>p2precovery/downloadLoans/"><span class="fa fa-calculator"></span>Download Loans</a></li>
			<li><a href="<?=base_url();?>p2padmin/p2pmis/"><span class="fa fa-calculator"></span>Reconciliation</a></li>

			<li class="treeview">
				<a href="#">
					<i class="fa fa-user"></i>
					<span>Borrower/Lender List</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li class="profile1"><a href="<?=base_url().'p2precovery/downloadBorrower/';?>"> Borrower List</a></li>
					<li class="profile2"><a href="<?=base_url().'p2precovery/downloadLender/';?>"></span> Lender List</a></li>
				</ul>
			</li>
            <li><a href="<?=base_url();?>p2padmin/changepassword"><span class="fa fa-sign-out"></span> Change Password</a></li>
			<li><a href="<?=base_url();?>login/Logoutadmin/"><span class="fa fa-sign-out"></span> Logout</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
