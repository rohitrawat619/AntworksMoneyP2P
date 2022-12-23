<link rel="stylesheet" href="<?= base_url(); ?>assets-admin/css/bid-list.css">
<?= getNotificationHtml(); ?>
<div class="row">
	<div class="mytitle row">
		<div class="left col-md-12">
			<div class="col-md-8"><h1><?= $pageTitle; ?></h1> Showing profiles as per the preference criteria
			</div>
		</div>
	</div>

	<div class="col-md-12 col-xs-12" style="pointer-events: none;">
		<div class="row">
			<div class="white-box">
                <div class="col-md-12">
                    <h3>Preference Criteria</h3>
                        <table class="table no-bdrs">
                            <tr>
                                <td class="col-md-6"><h5 style="margin-bottom: 35px;">Product Preference</h5>
                                    <?php $product_ids = array();
                                    foreach ($p2p_loan_type AS $p2p_loan) {
                                        $product_ids[] = $p2p_loan['p2p_product_id'];
                                    }
                                    $ids = implode(',', $product_ids); ?>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="product_preference[]" id="product_preference_all"
                                               value="<?= $ids ?>" <? if ($ids == $lender_preferences['product_preference']) {
                                            echo "checked";
                                        } ?>> All
                                    </label>
                                    <?php $p_preferences = explode(',', $lender_preferences['product_preference']);
                                    foreach ($p2p_loan_type AS $p2p_loan) { ?>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="product_reference_inner"
                                                   name="product_preference[]"
                                                   id="product_preference_<?= $p2p_loan['p2p_product_id'] ?>"
                                                   value="<?= $p2p_loan['p2p_product_id'] ?>" <? if (in_array($p2p_loan['p2p_product_id'], $p_preferences)) {
                                                echo "checked";
                                            } ?>>
                                            <?= $p2p_loan['loan_name'] ?>
                                        </label>
                                    <? } ?>
                                </td>

                                <td class="col-md-6"><h5>Loan Amount Preference</h5>
                                    <div class="row">
                                        <div class="col-md-6">Min.
                                            <select class="form-control" name="loan_amount_minimum"
                                                    id="loan_amount_minimum">
                                                <? for ($i = 2500; $i <= 50000; $i = $i + 2500) { ?>
                                                    <option
                                                            value="<?= $i; ?>" <? if ($i == $lender_preferences['loan_amount_minimum']) {
                                                        echo "selected";
                                                    } ?>><?= $i ?></option>
                                                <? } ?>
                                            </select></div>
                                        <div class="col-md-6">Max.
                                            <select class="form-control" name="loan_amount_maximum"
                                                    id="loan_amount_maximum">
                                                <? for ($i = 2500; $i <= 50000; $i = $i + 2500) { ?>
                                                    <option
                                                            value="<?= $i; ?>" <? if ($i == $lender_preferences['loan_amount_maximum']) {
                                                        echo "selected";
                                                    } ?>><?= $i ?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><h5 style="margin-top: 25px;">Antworks Rating Preference</h5>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <select id="min_antworks_rating" name="min_antworks_rating" class="form-control">
                                                <option value="">select</option>
                                                <? for ($i = 5; $i <= 8; $i++) { ?>
                                                    <option
                                                            value="<?= $i ?>" <? if ($i == $lender_preferences['min_antworks_rating']) {
                                                        echo "selected";
                                                    } ?>>More than <?= $i; ?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </div>
			</div>
		</div>
	</div>

	
	<div class="col-md-12 col-xs-12">
		<div class="white-box">
			<div class="col-md-12">
				<div class="row">
					<form method="get" action="<?php echo base_url() . "bidding/searchbyLender"; ?>">
						<div class="col-md-4">
							<div class="">
								<input type="text" class="form-control" name="name_borrower_id"
									   placeholder="Search by Name / Borrower ID">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<button style="width:100%; float:right;" type="submit" class="btn btn-primary">Search
								</button>
							</div>
						</div>
						<div class="col-md-2">
							<div class="btn-filter" role="button" data-toggle="collapse" href="#borrowerdtls"
								 aria-expanded="false" aria-controls="borrowerdtls">Advance Filter <i
									class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel panel-default panel-filter block1 right-panel ">
				<div class="collapse" id="borrowerdtls">
					<div class="col-md-12">
						<div class="panel-wrapper collapse in">
							<input type="hidden" name="auto_investment" id="auto_investment_lender" value="<?=$auto_investment?>">
							<form action="<?= base_url(); ?>bidding/advancesearch/" method="get">
								<div style="background-color:#91bc37; margin-top: 20px">
									<div class="panel-body" style="background-color:#9ecb3c;">
										<div class="col-md-12"><h2 class="box-title m-b-0">Filter</h2>
											<hr/>
										</div>
										<div class="col-md-6">
											<div class="form-group col-md-12">
												<h5 class="m-t-10">Loan Range</h5>
												<hr/>
												<div class="col-md-12">
													<div id="slider-range" class="col-sm-12 m-b-10 ">
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<label for="" class="control-label">Min</label>
														<input type="text" name="min_loan" class="form-control" id="min"
															   placeholder="0">
													</div>
													<div class="col-sm-6">
														<label for="" class="control-label">Max</label>
														<input type="text" name="max_loan" class="form-control"
															   placeholder="1000000" id="max">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group col-md-12">
												<h5 class="m-t-10">Interest Range</h5>
												<hr/>
												<div class="col-md-12">
													<div id="slider-range2" class="col-sm-12 m-b-10 ">
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<label for="" class="control-label">Min</label>
														<input type="text" class="form-control" id="min2"
															   name="min_interest_rate" placeholder="12">
													</div>
													<div class="col-sm-6">
														<label for="" class="control-label">Max</label>
														<input type="text" class="form-control" placeholder="36"
															   id="max2" name="max_interest_rate">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="panel-body" style="background-color:#91bc37; padding-top:0;">
										<div class="row">
											<div class="col-md-3">
												<h5 class="m-t-10">Product Type</h5>
												<select class="form-control" name="product_type" id="product_type">
													<option value="">Select product Type</option>
													<?php foreach ($p2p_loan_type as $loan) {
														$ids = $loan['p2p_product_id'];
													}
													echo '<option value="' . implode(',', $ids) . '">All</option>';
													foreach ($loan_types as $loan) {
														echo '<option value="' . $loan['p2p_product_id'] . '">' . $loan['loan_name'] . '</option>';
													}
													?>
												</select>
											</div>
											<div class="col-md-2">
												<h5 class="m-t-10">Antworks Rating</h5>
												<select class="form-control" name="antworks_rating"
														id="antworks_rating">
													<option value="">Select Antworks Rating</option>
													<option value="All">All</option>
													<?
													for ($ar = 1; $ar <= 10; $ar++) {
														echo '<option value="' . $ar . '">' . $ar . '</option>';
													}
													?>
												</select>
											</div>
											<div class="col-md-2 m-t-30">
												<div class="form-group">
													<div class="m-b-5">
														<button style="width:100%; float:right;" type="submit"
																class="btn btn-primary">Search
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-xs-12">
		<div class="row">				
			<div class="white-box text-right">
				<div id="btnContainer" class="right">
					<button class="btn" onclick="listView()"><i class="fa fa-bars"></i> List</button>
					<button class="btn active" onclick="gridView()"><i class="fa fa-th-large"></i> Grid</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="white-box">
	<ul id="proposal_list_ul" class="proposal-listing myproposal-listing">
		<?php foreach ($proposal_list AS $proposal) { ?>
			<li class="column">
				<div class="box" <?php if ($proposal['time_left'] < 0) {
					echo 'style="pointer-events: none; background-color: #e7dfdf;"';
				} ?>>
					<div class="title">
						<div class="name"><?php $fname = explode(' ', $proposal['name']);
							echo ucfirst(strtolower($fname[0])); ?>
							<div class="borrower-id text-left">
								<span>Borrower ID:</span><?php echo $proposal['b_borrower_id'] ?>
							</div>
							<ul class="prs-n-dtls">
								<li><?php echo $proposal['age'] ?></li>
								<li><?php if ($proposal['gender'] == 1) {
										echo "Male";
									}
									if ($proposal['gender'] == 2) {
										echo "Female";
									} ?>
								</li>
								<li><?php echo $proposal['r_city']; ?></li>
							</ul>
						</div>
						<?php
						$experian = $this->Biddingmodel->getExperainscoere($proposal['borrower_id']);
						$userrating = $this->Biddingmodel->getUserrating($proposal['borrower_id']);
						?>
						<div class="cscore">Credit Score
							<span><?php echo $experian['experian_score'] ?></span>
						</div>
						<div class="lefttime">
							<p>Time Left :
								<span><?php if ($proposal['time_left'] < 0) echo 'expired'; else echo $proposal['time_left'] . ' Days'; ?>
                    </span>
							</p>
						</div>
						<div class="count">
							<?php if ($userrating['antworksp2p_rating'] > 0) {?>
							<i class="fa fa-question-circle rateinfo" data-html="true" data-container="body"
							   data-toggle="popover" data-placement="top" data-content="Our proprietary algorithm analyses various parameters derived from customers credit records, KYC and Banking Details such as leverage ratio, credit utilization, outstanding amount, delinquencies etc. It then assigns weightage to each parameters based on reliability of information and independent verifiability of the data and judge the overall profile and rate it on a scale of 1-10 points. Higher the rating, stronger is the borrower profile.
								<div>1-3<b>Very High</b></div><div>4-7<b>Moderate</b></div><div>8-10<b>Very Low</b></div>">
							</i>
							<? } ?>
							<span>Antworks Rating</span><?php if ($userrating['antworksp2p_rating'] == 0) {
								echo "N/A";
							} else { ?>(<? echo round($userrating['antworksp2p_rating'], 1, PHP_ROUND_HALF_UP) . "/10)";
							} ?>
						</div>
					</div>
					<div class="purpose-loan"><span>Loan Purpose:</span><?= $proposal['loan_purpose'] ?></div>

					<div class="loan">
						<div class="amount">
							<span>Loan Required</span>Rs. <?php echo $proposal['loan_amount'] ?>
						</div>
						<div class="amount fund-grph">
							<span class="pie"
								  data-peity="{ &quot;fill&quot;: [&quot;#99d683&quot;, &quot;#f2f2f2&quot;]}"
								  style="display: none;"><?php echo $proposal['total_bid_amount']; ?>,<?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?></span>
							<p><?php echo round(($proposal['total_bid_amount'] * 100) / $proposal['loan_amount'], 2); ?>
								% Funded
								<br>
								<i class="fa fa-inr"
								   aria-hidden="true"></i> <?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?>
								Needed
							</p>
						</div>
						<a target="_blank"
						   href="<?php echo base_url(); ?>bidding/borrower_profile_details/<?php echo $proposal['b_borrower_id'] ?>"
						   class="btn btn-details btn-success">Details</a>
						<button class="btn btn-primary pull-right btn-shortlist"
								onclick="return addShortlist(<?php echo $proposal['proposal_id'] ?>)">
							<i class="fa fa-star"></i>
						</button>
					</div>

					<div class="desc">
						<ul>
							<li>
								<b>Borrower Interest Preference (%)</b> - <?php echo $proposal['min_interest_rate'] ?> %
							</li>
							<li>
								<b>Recommended Interest (%)</b> - <?php echo $proposal['prefered_interest_min'] ?>
								-<?php echo $proposal['prefered_interest_max'] ?> %
							</li>
							<li>
								<b>Tenor</b> - <?php echo $proposal['tenor_months'] ?> months
							</li>
							<!--li><b>Purpose</b> - Appliance Purchase</li-->
							<li>
								<b>Monthly Income</b>
								-<?php echo $proposal['occuption_details']['net_monthly_income'] ?>
							</li>
							<li>
								<b>Current EMI's</b> - <?php echo $proposal['occuption_details']['current_emis'] ?>
							</li>
						</ul>
					</div>
					<div class="actions">
						<form action="<?php echo base_url(); ?>bidding/submitproposal"
							  id="proposal_id_<?php echo $proposal['proposal_id'] ?>"
							  onsubmit="return submitproposal(<?php echo $proposal['proposal_id']; ?>)" method="post"
							  class="bidnow-form">
							<div class="row">
								<div class="col-md-4">
									<label>Amount</label>
									<input type="text" placeholder="Enter Amount" name="loan_amount"
										   id="loan_amount_<?php echo $proposal['proposal_id'] ?>"
										   class="form-control <? if ($proposal['p2p_product_id'] == 2) {
											   echo "consumer_loan_bid_loan_amount";
										   } else {
											   echo "bid_loan_amount";
										   } ?>"
										   onkeypress="return isNumberKey(event)" <? if ($proposal['p2p_product_id'] == 2) {
										echo "value = '" . $proposal['loan_amount'] . "'";
										echo 'readonly';
									} ?>>
									<span id="error_loan_amount_<?php echo $proposal['proposal_id'] ?>"
										  class="error-validation">
                            </span>
								</div>
								<div class="col-md-3">
									<label>Interest Rate</label>
									<select class="form-control" name="interest_rate"
											id="interest_rate_<?php echo $proposal['proposal_id'] ?>" <? if ($proposal['p2p_product_id'] == 2) {
										echo "disabled";
									} ?>>
										<option value="">Interest Rate</option>
										<?php for ($i = 12; $i <= 36; $i += 3) { ?>
											<option
												value="<?= $i; ?>" <? if ($proposal['p2p_product_id'] == 2 && $i == 18) {
												echo "selected";
											} ?>><?= $i; ?>%
											</option>
										<?php } ?>
									</select>
									<span id="error_interest_rate_<?php echo $proposal['proposal_id'] ?>"
										  class="error-validation"></span>
								</div>
								<div class="col-md-3">
									<label>Tenor</label>
									<select class="form-control" name="accepted_tenor"
											id="accepted_tenor_<?php echo $proposal['proposal_id'] ?>" <? if ($proposal['p2p_product_id'] == 2) {
										echo "disabled";
									} ?>>
										<option value="">Tenor</option>
										<?php for ($j = 6; $j <= 36; $j += 3) { ?>
											<option
												value="<?= $j; ?>" <? if ($proposal['p2p_product_id'] == 2 && $j == 6) {
												echo "selected";
											} ?>><?= $j; ?> Months
											</option>
										<?php } ?>
									</select>
									<span id="error_accepted_tenor_<?php echo $proposal['proposal_id'] ?>"
										  class="error-validation">
                        </span>
								</div>
								<div class="col-md-2">
									<label></label>
									<input type="hidden" name="proposal_id"
										   id="proposal_id_<?php echo $proposal['proposal_id'] ?>"
										   value="<?php echo $proposal['proposal_id'] ?>">
									<input type="hidden" name="loan_required"
										   id="loan_required_<?php echo $proposal['proposal_id'] ?>"
										   value="<?php echo $proposal['loan_amount'] ?>">
									<input type="hidden" name="p2p_product_id"
										   id="p2p_product_id<?php echo $proposal['proposal_id'] ?>"
										   value="<?php echo $proposal['p2p_product_id'] ?>">
									<input type="submit" name="bid_now" id="bid_now" value="Bid Now"
										   class="btn btn-primary bid_now">
								</div>
							</div>
						</form>
					</div>
				</div>
			</li>
		<? } ?>
	</ul>
	<?php echo $pagination; ?>
</div>
<script src="<?= base_url(); ?>assets-admin/js/bid-list.js"></script>
<script>
	$('body').on('click', function (e) {
		$('[data-toggle=popover]').each(function () {
			// hide any open popovers when the anywhere else in the body is clicked
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
			}
		});
	});

</script>


