<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
		<?=getNotificationHtml();?>
    </div>
</div>

<div class="white-box">
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Live Proposal</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?=round($liveproposal, 2)?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Live Lender</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash2"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple"><?=round($livelender, 2)?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Bid Received</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash3"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info"><?=round($totalbidrecieved, 2)?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Average ROI</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash4"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="counter text-danger"><?=round($totalAvgintrestrate['interest_rate'], 1)?> <i class="ti-percent text-danger"></i></span></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<div class="white-box">
    <div class="col-md-12">
        <div class="row">
            <div class="white-box livefeed">
                <h3 class="box-title">Live Feed</h3>
                <div class="stats-row">
                    <div class="stat-item"><h6>PLNR</h6><b><?php echo $proposal_info['PLRN']; ?></b></div>
                    <div class="stat-item"><h6>Loan Amount</h6><b><?php echo $proposal_info['loan_amount']; ?></b></div>
                    <div class="stat-item"><h6></h6><b><?php echo $proposal_info['proposal_status_name'] ?></b></div>
                    <div class="stat-item"><h6>Time Left</h6><b><?php if($proposal_info['RemainingDays'] < 0){echo "Expired";} else{ echo $proposal_info['RemainingDays'] ."Days"; }?></b></div>
					<?php if($proposal_info['RemainingDays'] < 0 || empty($proposal_info)){ ?>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
							Add New Proposal
						</button>

						<!-- Modal -->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<form action="<?php echo base_url(); ?>borroweraction/addNewproposal" method="post" onsubmit="return addNewproposal()">
									<div class="modal-content">
										<div class="modal-header" style="border-color: transparent">

											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<h5 class="modal-title" id="exampleModalLongTitle">Add new proposal</h5>
										</div>
										<div class="modal-body">
											<div class="col-md-6 col-xs-6">
												<div class="form-group">
													<input class="form-control" placeholder="Loan Amount" type="text" name="loan_amount_borrower" id="loan_amount_borrower" value="<?php echo $this->input->post('loan_amount_borrower');?>" maxlength="10" onkeypress="return isNumberKey(event)" >
													<span class="validation error-validation" id="error_loan_amount_borrower"></span>
												</div>
											</div>
											<div class="col-md-6 col-xs-6">
												<div class="form-group">
													<select class="form-control" name="tenor_borrower" id="tenor_borrower">
														<option value="">Select Tenor</option>
														<?php for($i = 6; $i<37; $i++){?>
															<option value="<?php echo $i;?>" <?php if($this->input->post('tenor_borrower') == $i){echo "selected"; } ?>><?php echo $i;?> Months</option>
														<? } ?>
													</select>
													<span class="validation error-validation" id="error_tenor_borrower"></span>
												</div>
											</div>
											<div class="col-md-6 col-xs-6">
												<div class="form-group">
													<select class="form-control" name="borrower_interest_rate" id="borrower_interest_rate">
														<option value="">Select Interest Rate</option>
														<?php for($i = 6; $i<37; $i++){?>
															<option value="<?php echo $i;?>" <?php if($this->input->post('emi_borrower') == $i){echo "selected"; } ?>><?php echo $i;?> %</option>
														<? } ?></select>
													<span class="validation error-validation" id="error_borrower_interest_rate"></span>
												</div>
											</div>
											<div class="col-md-12 col-xs-12">
												<div class="form-group">
													<select name="p2p_product_id" id="p2p_product_id" class="form-control">
														<option value="">Select Purpose</option>
														<option value="1">Cash loan/to meet short term cash flow need</option>
														<option value="2">Consumer financing/to buy consumer product</option>
														<option value="3">Personal loan/to meet various personal financial commitments </option>
														<option value="4">Business loan/to meet various Business financial commitments</option>
													</select>
													<span class="validation error-validation" id="error_p2p_product_id"></span>
												</div>
											</div>
											<div class="col-md-12 col-xs-12">
												<div class="form-group">
													<textarea class="form-control" type="text" placeholder="Loan Description" name="borrower_loan_desc" id="borrower_loan_desc"></textarea>
													<span class="validation error-validation bt24" id="error_borrower_loan_desc"></span>
												</div>
											</div>

											<div class="f1-buttons">
												<div class="terms-condtns">
													<label><input type="checkbox" name="term_and_condition" id="term_and_condition"> I have read, understood, and I agree to the <a href="<?php echo base_url(); ?>term-and-conditions" target="_blank">Terms of Use</a> and <a href="<?php echo base_url(); ?>privacy-and-policy" target="_blank">Privacy Policy</a>. I undertake not to borrow more than 10 lakh on all Peer to Peer (P2P) Platform.</label>
													<span id="error_term_and_condition" class="validation error-validation"></span>
												</div>
											</div>
										</div>
										<div class="modal-footer" style="border-color: transparent">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
											<button type="submit" class="btn btn-submit">Add New Proposal</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php }?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>Bid Received</th>
                        <th>Average Ratio Interest</th>
                        <th>Total Views</th>
                        <th>Total Likes</th>
                    </tr>
                    <tr>
                        <td><?php echo $currentproposelBids; ?></td>
                        <td><?php echo $avrageInterstrate['interest_rate']?round($avrageInterstrate['interest_rate'], 2).'%':'no record found'; ?></td>
                        <td><?=$total_views?></td>
                        <td><?=$total_likes?></td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

            <div class="table-responsive">
                <table id="example23" class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>PLNR</th>
                        <th>Lender Name.</th>
                        <th>Amount</th>
                        <th>Rate of Interest</th>
                        <th>Bidding Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($bidding_info){foreach($bidding_info AS $bidding){?>
                        <tr>
                            <form action="<?php echo base_url(); ?>borroweraction/accept_bid_borrower" method="post">
                                <td><?php echo $bidding['PLRN']; ?></td>
                                <td><?php echo $bidding['lender_name']; ?></td>
                                <td><?php echo $bidding['bid_loan_amount']; ?></td>
                                <td><?php echo $bidding['interest_rate']; ?>%</td>
                                <td><?php echo $bidding['proposal_added_date']; ?></td>
                                <td>
                                    <?php if($bidding['borrower_acceptance'] == 0){?>
                                        <input type="hidden" name="bid_registration_id" id="bid_registration_id" value="<?php echo $bidding['bid_registration_id']; ?>">
                                        <input type="submit" name="aggree" id="aggree<?php echo $bidding['bid_registration_id']; ?>" class="btn btn-success m-r checking" value="Accept">
                                        <input type="submit" name="reject" id="reject<?php echo $bidding['bid_registration_id']; ?>" class="btn btn-mainnxt checking" value="Reject">
                                    <?php }  ?>
                                    <?php if($bidding['borrower_acceptance'] == 1){?>
                                        <b>Accepted</b>
                                    <?php } ?>

                                    <?php if($bidding['borrower_acceptance'] == 2){?>
                                        <b>Rejected</b>
                                    <?php } ?>
                                </td>
                            </form>
                        </tr>
                    <?php }} else{
                        echo "<tr>
                        <td colspan='6' class='text-center'>No Bid received</td>
                    </tr>";
                    }?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12 m-t-30 hidden">
            <h3 class="box-title">Bid Rules:</h3>
            <div id="bidrules">
                <div class="col-sm-12">

                </div>
            </div>
        </div>


    </div>
</div>
<script>
 function addNewproposal() {
     validation = true;
     if($("#loan_amount_borrower").val() == '')
     {
         $("#error_loan_amount_borrower").html('<p>Please enter Required Loan Amount</p>');
         $("#loan_amount_borrower").addClass('input-error');
         validation = false;
     }
     if($("#loan_amount_borrower").val() != '' && $("#loan_amount_borrower").val() >1000000)
	 {
         $("#error_loan_amount_borrower").html('<p>Amount should not be > 1000000</p>');
         $("#loan_amount_borrower").addClass('input-error');
         validation = false;
	 }
     if($("#tenor_borrower").val() == '')
     {
         $("#error_tenor_borrower").html('<p>Please select Tenor</p>');
         $("#tenor_borrower").addClass('input-error');
         validation = false;
     }
     if($("#borrower_interest_rate").val() == '')
     {
         $("#error_borrower_interest_rate").html('<p>Please select expected Interest Rate</p>');
         $("#borrower_interest_rate").addClass('input-error');
         validation = false;
     }
     if($("#p2p_product_id").val() == '')
     {
         $("#error_p2p_product_id").html('<p>Please Select a Loan Purpose</p>');
         $("#p2p_product_id").addClass('input-error');
         validation = false;
     }
     if($("#borrower_loan_desc").val() == '')
     {
         $("#error_borrower_loan_desc").html('<p>Please describe the purpose in ‘Loan Description’</p>');
         $("#borrower_loan_desc").addClass('input-error');
         validation = false;
     }
     if($('#term_and_condition').is(":not(:checked)"))
     {
         $("#error_term_and_condition").html('<p>Please accept Terms and condition</p>');
         validation = false;
     }
     if(validation == true)
	 {
       return true;
	 }
     else{
       return  false;
	 }
 }

</script>
