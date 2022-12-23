<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
            <?=getNotificationHtml();?>
		</div>
	</div>


	<div class="white-box">
	<div class="col-md-12 p-b-30">
	</div>

            <form method="post" action="<?php echo base_url(); ?>borroweraction/takeliveproposal">
                <ul class="proposal-listing myproposal-listing">
                    <li>
                        <div class="box">
                            <div class="title">
                                <div class="name"><?php echo $this->session->userdata('name'); ?></div>
                                <div class="cscore">Credit Score <span>720</span></div>
                                <div class="lefttime"><p>Time Left : <span>7 Hours</span></p></div>
                                <div class="count"><i class="fa fa-question-circle rateinfo" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."></i><span>Antworks Rating</span>(7/10)</div>
                            </div>
                            <div class="loan">
                                <div class="amount"><span>Loan Required</span>Rs. <?php echo $proposal->loan_amount; ?></div>
                                <div class="amount fund-grph"><span>Purpose</span>
                                    <select class="form-control">
                                        <option>Appliance Purchase</option>
                                    </select>
                                </div>
                                <div class="amount fund-grph">
                                    <span class="pie" data-peity='{ "fill": ["#99d683", "#f2f2f2"]}'>0</span>
                                    <p>0 % Funded<br>
                                        <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $proposal->loan_amount; ?> Needed</p>
                                </div>
                            </div>
                            <div class="desc">
                                <ul>
                                    <li><b>Borrower Interest Prefrence (%)</b> - <?php echo $proposal->min_interest_rate; ?> %</li>
                                    <li><b>Tenor</b> - <?php echo $proposal->tenor_months; ?> months</li>
                                    <!--li><b>Purpose</b> - Appliance Purchase</li-->
                                    <li><b>Monthly Income</b> - </li>
                                    <li><b>Current EMI's</b> - 0</li>
                                </ul>
                            </div>
                            <input type="hidden" name="proposal_id" id="proposal_id" value="<?php echo $proposal->proposal_id; ?>">
                            <input type="submit" class="btn btn-success" value="Go Live">
                        </div>

                    </li>

                </ul>
            </form>

	</div>