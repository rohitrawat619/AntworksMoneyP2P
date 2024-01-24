<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="dashboard"><a href="<?=base_url();?>p2padmin/dashboard/"><i class="fa fa-dashboard"></i> <span>Dashboard</span>

                </a>
            </li>
            <li><a href="<?=base_url();?>p2padmin/p2pborrower/borrowers"><span class="fa fa-sign-out"></span>  ALL Borrower</a></li>
            <li class="treeview">
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
            <li class="treeview">
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
            <li><a href="<?=base_url();?>p2padmin/p2pborrower/downloadBorrowers"><span class="fa fa-address-book"></span> Download Users</a></li>
            <li><a href="<?=base_url();?>p2padmin/changepassword"><span class="fa fa-sign-out"></span> Change Password</a></li>
            <li><a href="<?=base_url();?>login/Logoutadmin/"><span class="fa fa-sign-out"></span> Logout</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
