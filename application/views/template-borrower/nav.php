<div class="side-mini-panel">
<ul class="mini-nav">
<div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>

<!-- .Dashboard -->
<li class="selected"> <a href="javascript:void(0"><i class="ti-menu"></i> </a>
  <div class="sidebarmenu"> 
    <ul class="nav navbar-nav">
            <li class="dashboard"><a href="<?=base_url();?>borrower/dashboard/"><span class="fa fa-dashboard"></span>Dashboard</a></li>
            <?php $result =  $this->Borrowermodelbackend->liveProposal(); if($result == 0){ ?>
            <li class="dashboard"><a href="<?=base_url();?>borrower/list-my-proposal"><span class="fa fa-file-text-o"></span>List my Proposal</a></li>
            <?php } ?>
            <li class="panel panel-default user" id="dropdown">
                <a data-toggle="collapse" href="#dropdown-b1"><span class="fa fa-cogs"></span>Proposal Status<span class="caret"></span></a>
                <div id="dropdown-b1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="nav navbar-nav">
                            <li class="list-users"><a href="<?=base_url();?>borrower/live-listing">Live Listing</a></li>
          					<li class="list-roles"><a href="<?=base_url();?>borrower/proposal-history">Proposal History</a></li>
                        </ul>
                    </div>
                </div>
            </li>
			
			<li class="panel panel-default user" id="dropdown">
                <a data-toggle="collapse" href="#dropdown-b2"><span class="fa fa-files-o"></span>Document<span class="caret"></span></a>
                <div id="dropdown-b2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="nav navbar-nav">
                            <li class="panel panel-default bidding-loan" id="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvl2">Loan Agreement <span class="caret"></span></a>
								<div id="dropdown-lvl2" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li class="pending-sign"><a href="<?=base_url();?>borrower/pending-signature">Pending for Signature</a></li>
											<li class="loanagrmnt-copy"><a href="<?=base_url();?>borrower/loan_agreement_copies">Loan Agreement Copies</a></li>
										</ul>
									</div>
								</div>
							</li>
          					<li class="list-roles"><a href="<?=base_url();?>borrower/kyc">KYC</a></li>
                        </ul>
                    </div>
                </div>
            </li>
			
			<li class="panel panel-default user" id="dropdown">
                <a data-toggle="collapse" href="#dropdown-b3"><span class="fa fa-inr"></span>Loan Statement<span class="caret"></span></a>
                <div id="dropdown-b3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="nav navbar-nav">
                            <li class="list-users"><a href="<?=base_url();?>borrower/ongoing_loan">Ongoing Loans</a></li>
          					<li class="list-roles"><a href="<?=base_url();?>borrower/closed_loan">Closed Loans</a></li>
                        </ul>
                    </div>
                </div>
            </li>
			
			<li class="panel panel-default banks" id="dropdown">
                <a data-toggle="collapse" href="#dropdown-lvl4">
                    <span class="fa fa-pencil"></span>Request<span class="caret"></span>
                </a>
                <div id="dropdown-lvl4" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="nav navbar-nav">
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/change-address">Change in Address</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/e_kyc">E-KYC</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/kyc_updation">KYC Updation</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/make_payment">Make Payment</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/closer_request">Foreclosure Request</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/loanrestructuring">Loan Restructuring</a></li>
                            <li class="banks-home"><a href="<?=base_url();?>borrower/borrowerrequest/e_nach">E-Nach</a></li>
                        </ul>
                    </div>
                </div>
            </li>
		    
            <li><a href="<?=base_url();?>login/logout/"><span class="fa fa-power-off"></span>Logout</a></li>

        </ul>
  </div>
</li>
</ul>
</div>
<div id="page-wrapper">
<div class="container-fluid p-l-0 p-r-0">
