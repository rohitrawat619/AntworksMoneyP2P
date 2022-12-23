<div class="side-mini-panel">
    <ul class="mini-nav">
        <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>

        <!-- .Dashboard -->
        <li class="selected"> <a href="javascript:void(0)"><i class="ti-menu"></i> </a>
            <div class="sidebarmenu">
                <ul class="nav navbar-nav">

                    <li class="dashboard"><a href="<?=base_url();?>lender/dashboard"><span class="fa fa-dashboard"></span> Dashboard</a></li>

                    <li class="profile"><a href="<?=base_url().'lender/profile/';?>"><span class="fa fa-user"></span> My Profile</a></li>
                    <li class="panel panel-default bidding-main" id="dropdown">
                        <a data-toggle="collapse" href="#dropdown-lvl2">
                            <span class="fa fa-gavel"></span> Bid Now <span class="caret"></span>
                        </a>
                        <div id="dropdown-lvl2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li class="panel panel-default bidding-loan" id="dropdown">
                                        <a data-toggle="collapse" href="#dropdown-sub1">
                                            Loan Listing <span class="caret"></span>
                                        </a>
                                        <div id="dropdown-sub1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <li class="live-bids" type="submit" name="LIVE" id="live"><a href="<?=base_url();?>bidding/live-bids">Live Bids</a></li>
                                                    <li class="favorite-bids"><a href="<?php echo base_url(); ?>bidding/favourite-bids">Favorite</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="panel panel-default bidding-mybids" id="dropdown">
                                        <a data-toggle="collapse" href="#dropdown-sub2">My Bids <span class="caret"></span></a>
                                        <div id="dropdown-sub2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <li class="pending-bid" type="submit" name="mybids" id="mybids"><a href="<?php echo base_url();?>lender/pendingbid">Pending Bids</a></li>
                                                    <li class="success-bids" type="submit" name="mybids" id="mybids"><a href="<?php echo base_url();?>lender/successfullbids">Accept Agreement</a></li>
                                                    <li class="accepted-bids" type="submit" name="acceptedbids" id="acceptedbids"><a href="<?php echo base_url();?>lender/acceptedbids">View Loan Agreement</a></li>
                                                    <li class="unsuccess-bids"><a href="<?php echo base_url();?>lender/unsuccessfullbids">Unsuccessful Bids</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="panel panel-default banks" id="dropdown">
                        <a data-toggle="collapse" href="#dropdown-lvl3">
                            <span class="fa fa-bank"></span> Portfolio <span class="caret"></span>
                        </a>
                        <div id="dropdown-lvl3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/account/my-performance">My Performance</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/account/loan-summary">Loan Summary</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/escrow-account-statement">Investment Account Statement</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="panel panel-default banks" id="dropdown">
                        <a data-toggle="collapse" href="#dropdown-fund">
                            <span class="fa fa-bank"></span> Fund Transfer <span class="caret"></span>
                        </a>
                        <div id="dropdown-fund" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/pay-in">Pay In</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/pay-out">Pay Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="panel panel-default banks" id="dropdown">
                        <a data-toggle="collapse" href="#dropdown-lvl4">
                            <span class="fa fa-pencil"></span> Request <span class="caret"></span>
                        </a>
                        <div id="dropdown-lvl4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/change-address">Change Address</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/change-mobile-no">Change Mobile No.</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/tds-statement">TDS Statement</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/add-nominee">Add Nominee</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/kyc-updation">KYC Updation</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/loanrestructuring">Loan Restructuring</a></li>
                                    <li class="banks-home"><a href="<?php echo base_url(); ?>lender/request/preferences">Loan Preferences</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </li>
    </ul>
</div>
<style>
    .navbar-nav .panel-body {
        padding: 10px;
    }
    .navbar-nav {
        display: block;
        width: 100%;
        margin: 5px 0px;
    }
    .navbar-nav>li {
        float: none !important;
        display: block;
        width: 100%;
    }
    .panel {
        margin-bottom:0px !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
    .active1 {
        background: #eee;
    }

    .navbar-nav > li > a {
        padding-top: 10px;
        padding-bottom: 10px;
    }

</style>
<div id="page-wrapper">
    <div class="container-fluid p-l-0 p-r-0">
