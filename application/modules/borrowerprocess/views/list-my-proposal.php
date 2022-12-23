<link href="<?=base_url();?>assets/css/proposal-list.css" rel="stylesheet">
<style>.proposal-listing .title .name {
        font-size: 24px;}</style>
<?php //echo "<pre>"; print_r($rating); exit; ?>
<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
		</div>
	</div>
	

	<div class="white-box">
        <form method="post" action="<?php echo base_url(); ?>borrowerprocess/takeliveproposal">
		<ul class="proposal-listing myproposal-listing">
            <li style="float: none; margin: 0 auto; display: block;">
                <div class="box">
                    <div class="title">
                        <div class="name"><?php echo $this->session->userdata('name'); ?>
                            <ul class="prs-n-dtls">
                                <li><?php echo $borrower_info['age'] ?></li>
                                <li><?php if($borrower_info['gender'] == 1){echo "Male";} if($proposal['gender'] == 2){echo "Female";}?></li>
                                <li><?php echo $borrower_info['r_city']; ?></li>
                            </ul>
                        </div>
                        <div class="cscore">Credit Score
                            <span><?php echo $rating['experian_score']; ?></span>
                        </div>
                        <div class="lefttime">
                            <p>Time Left :
                                <span><?php echo $proposal['time_left'] ?> Days</span>
                            </p>
                        </div>
                        <div class="count">
                            <i class="fa fa-question-circle rateinfo" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="" title=""></i>
                            <span>Antworks Rating</span>(<?php echo $rating['antworksp2p_rating']; ?>/10)
                        </div>
                    </div>
                    <div class="purpose-loan"><span>Purpose:</span><?php echo $proposal['loan_description'] ?></div>
                    <div class="loan">
                        <div class="amount">
                            <span>Loan Required</span>Rs. <?php echo $proposal['loan_amount'] ?>
                        </div>
                        <div class="amount fund-grph">
                            <span class="pie" data-peity="{ &quot;fill&quot;: [&quot;#99d683&quot;, &quot;#f2f2f2&quot;]}" style="display: none;">0</span>
                            <p>0 % Funded
                                <br>
                                <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?> Needed
                            </p>
                        </div>
                    </div>
                    <div class="desc">
                        <ul>
                            <li>
                                <b>Borrower Interest Prefrence (%)</b> - <?php echo $proposal['min_interest_rate'] ?> %
                            </li>
                            <li>
                                <b>Recommended Interest (%)</b> - <?php echo $proposal['prefered_interest_min'] ?>-<?php echo $proposal['prefered_interest_max'] ?> %
                            </li>
                            <li>
                                <b>Tenor</b> - <?php echo $proposal['tenor_months'] ?> months
                            </li>
                            <!--li><b>Purpose</b> - Appliance Purchase</li-->
                            <li>
                                <b>Monthly Income</b> -<?php echo $occuptionDetails['net_monthly_income'] ?>
                            </li>
                            <li>
                                <b>Current EMI's</b> - <?php echo $occuptionDetails['current_emis'] ?>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="proposal_id" id="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                    <div class="text-right">
                    <input type="submit" class="btn btn-success" value="Go Live">
                    </div>
                </div>
            </li>
		
		</ul>
        </form>
	</div>