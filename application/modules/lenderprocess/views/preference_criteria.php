<style>
    .preference-criteria {
		color: #000;
		font-size: 13px;
	}

	input[type="checkbox"], input[type="radio"] {
		margin: 0;
	}

	/*.red {color: #d9534f;}
	.blue {color: #337ab7;}
	.green {color: #5cb85c;}
	.yellow {color: #cc8116;}
	.red, .blue, .green, .yellow {font-size: 16px;}
	.r-star {margin-top: -30px; display: inline-block;}
	.remarks {margin-top:40px; padding-top:15px; border-top:1px solid #333;}*/

	#preferencecriteria {
		padding-right: 15px;
	}

	.mytitle {
		padding-top: 100px;
	}

	.preference-criteria .table > tbody > tr > td {
		padding: 10px;
	}

	.preference-criteria h5 {
		margin: 0;
        margin-bottom: 10px;
	}

	@media (max-width: 767px) {

	}

	.onoffswitch {
		position: relative;
		width: 141px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
	}

	.onoffswitch-checkbox {
		display: none;
	}

	.onoffswitch-label {
		display: block;
		overflow: hidden;
		cursor: pointer;
		border: 2px solid #999999;
		border-radius: 20px;
	}

	.onoffswitch-inner {
		display: block;
		width: 200%;
		margin-left: -100%;
		transition: margin 0.3s ease-in 0s;
	}

	.onoffswitch-inner:before, .onoffswitch-inner:after {
		display: block;
		float: left;
		width: 50%;
		height: 30px;
		padding: 0;
		line-height: 30px;
		font-size: 14px;
		color: white;
		font-family: Trebuchet, Arial, sans-serif;
		font-weight: bold;
		box-sizing: border-box;
	}

	.onoffswitch-inner:before {
		content: "ON";
		padding-left: 10px;
		background-color: #34A7C1;
		color: #FFFFFF;
	}

	.onoffswitch-inner:after {
		content: "OFF";
		padding-right: 10px;
		background-color: #EEEEEE;
		color: #331212;
		text-align: right;
	}

	.onoffswitch-switch {
		display: block;
		width: 18px;
		margin: 6px;
		background: #FFFFFF;
		position: absolute;
		top: 0;
		bottom: 0;
		right: 107px;
		border: 2px solid #999999;
		border-radius: 20px;
		transition: all 0.3s ease-in 0s;
	}

	.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
		margin-left: 0;
	}

	.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
		right: 0px;
	}
</style>

<section class="sec-pad sec-pad-30">
	<div class="container">
		<div class="mytitle row hidden">
			<div class="left col-md-4">
				<h1><?= $pageTitle; ?></h1>
			</div>
		</div>
		<div class="white-box preference-criteria">
			<form method="post" id="validationPreference" onsubmit="return validationPreference()"
				  action="<?php echo base_url() ?>lenderaction/savelenderPreference">
				<table class="table">
					<tr>
						<td style="border: none;"><h5>Auto Invest</h5>

							<div class="onoffswitch">
								<input type="checkbox" name="auto_investment" class="onoffswitch-checkbox"
									   id="myonoffswitch" value="1" checked>
								<label class="onoffswitch-label" for="myonoffswitch">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</td>
					</tr>
				</table>


				<table class="table no-bdrs hd-m">
					<div class="row">
						<div class="col-md-12"><h2>Preference Criteria</h2></div>
					</div>
					<tr>
						<td class="col-md-6"><h5 style="margin-bottom: 35px;">Product Preference</h5>

							<?php $product_ids = array();
							foreach ($p2p_loan_type AS $p2p_loan) {
								$product_ids[] = $p2p_loan['p2p_product_id'];
							}
							$ids = implode(',', $product_ids); ?>
							<label class="checkbox-inline">
								<input type="checkbox" name="product_preference[]" id="product_preference_all"
									   value="<?= $ids ?>"> All
							</label>
							<?php foreach ($p2p_loan_type AS $p2p_loan) { ?>
								<label class="checkbox-inline">
									<input type="checkbox" class="product_reference_inner" name="product_preference[]"
										   id="product_preference_<?= $p2p_loan['p2p_product_id'] ?>"
										   value="<?= $p2p_loan['p2p_product_id'] ?>">
									<?= $p2p_loan['loan_name'] ?>
								</label>
							<? } ?>
						</td>

						<td class="col-md-6"><h5>Loan Amount Preference</h5>

							<div class="row">
							<div class="col-md-6">Min.
								<select class="form-control" name="loan_amount_minimum" id="loan_amount_minimum">
									<option value="2500">2500</option>
									<option value="5000">5000</option>
									<option value="10000">10000</option>
									<option value="15000">15000</option>
									<option value="20000">20000</option>
									<option value="25000">25000</option>
									<option value="30000">30000</option>
									<option value="35000">35000</option>
									<option value="40000">40000</option>
									<option value="45000">45000</option>
									<option value="50000">50000</option>
								</select></div>
							<div class="col-md-6">Max.
								<select class="form-control" name="loan_amount_maximum" id="loan_amount_maximum">
									<option value="2500">2500</option>
									<option value="5000">5000</option>
									<option value="10000">10000</option>
									<option value="15000">15000</option>
									<option value="20000">20000</option>
									<option value="25000">25000</option>
									<option value="30000">30000</option>
									<option value="35000">35000</option>
									<option value="40000">40000</option>
									<option value="45000">45000</option>
									<option value="50000">50000</option>
								</select>
							</div>
                            </div>
						</td>
					</tr>
					<tr>
						<td><h5>Antworks Rating Preference</h5>
                            <div class="col-md-9"><div class="row">
                                <select id="min_antworks_rating" name="min_antworks_rating" class="form-control">
                                    <option value="">select</option>
                                    <option value="5">More than 5</option>
                                    <option value="6">More than 6</option>
                                    <option value="7">More than 7</option>
                                    <option value="8">More than 8</option>
                                </select>
                            </div></div>
						</td>


						<td><h5>Lending Club Application</h5>
							<?php foreach ($lender_clubs AS $lender_club) { ?>
								<label class="checkbox-inline">
									<input type="radio" name="landing_club" id="landing_club_<?= $lender_club['id'] ?>"
										   value="<?= $lender_club['id'] ?>">
									<?= $lender_club['club_name'] ?>
								</label>
							<? } ?>
						</td>
					</tr>
					<tr>
						<td><h5>Would you like to opt for Auto Reinvest option</h5>
							<label class="checkbox-inline">
								<input type="radio" id="reinvest_1" name="reinvest" value="1"> Yes
							</label>
							<label class="checkbox-inline">
								<input type="radio" id="reinvest_0" name="reinvest" value="0"> No
							</label>
						</td>

						<td><h5>Are you a mobile Retailer</h5>
							<label class="checkbox-inline">
								<label data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
									   aria-controls="collapseExample">
									<input type="radio" name="mobile_retailer" id="mobile_retailer_1" value="1"> Yes
								</label>
								<label class="checkbox-inline">
									<input type="radio" id="mobile_retailer_0" name="mobile_retailer" value="0"> No
								</label>
						</td>

						<td>
							<div class="collapse" id="collapseExample">
								<p class="form-inline">
									Would you like to lend under self finance scheme
									<label class="checkbox-inline">
										<input type="radio" id="selffinance_1" name="selffinance" value="1"> Yes
									</label>
									<label class="checkbox-inline">
										<input type="radio" id="selffinance_0" name="selffinance" value="0"> No
									</label>
								</p>
								<table class="table table-bordered" id="selffinance-box" disabled>
									<tr>
										<td>Annual Turnover</td>
										<td>Year in</td>
										<td>Place to</td>
									</tr>
									<tr>
										<td><input type="text" class="form-control" name="annual_turnover"
												   id="annual_turnover" placeholder="Annual Turnover"
												   onkeypress="return isNumberKey(event)">
											<p class="error-message"></p></td>
										<td><input type="text" class="form-control" name="year_in" id="year_in"
												   placeholder="2020" onkeypress="return isNumberKey(event)">
											<p class="error-message"></p></td>
										<td><input type="text" class="form-control" name="place_to" id="place_to"
												   placeholder="Place to">
											<p class="error-message"></p></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
				<input type="checkbox" name="term_condition" checked><span style="margin: 13px">I accept <a href="">Term and Conditions</a></span>
				<button type="submit" class="btn btn-primary pull-right">Submit</button>
			</form>

		</div>
	</div>
</section>
<script type="text/javascript">
	$(".product_reference_inner").change(function () {
		if ($('.product_reference_inner:checked').size() > 2) {

			this.checked = false;
		}
	})
</script>
<script type="text/javascript">
	function validationPreference() {
		var isValidate = true;
		if ($('#myonoffswitch').is(":checked")) {
			if (!$('#product_preference_all').is(":checked")) {
				alert("Please choose Product Preference");
				isValidate = false;
				return false;
			}
		} else {
			if ($('.product_reference_inner:checked').size() == 0) {
				isValidate = false;
				alert("Please choose Product Preference");
				return false;
			}
		}
		if (parseInt($("#loan_amount_maximum").val()) < parseInt($("#loan_amount_minimum").val())) {
			isValidate = false;
			alert("Please check loan amount preference");
			return false;
		}
		if ($("#min_antworks_rating").val() == "") {
			isValidate = false;
			alert("Please select antworks rating");
			return false;
		}
		if (!$("input[name=landing_club]:checked").val()) {
			isValidate = false;
			alert("Please choose landing club");
			return false;
		}
		if (!$("input[name=reinvest]:checked").val()) {
			isValidate = false;
			alert("Please choose reinvestment");
			return false;
		}
		if (!$("input[name=mobile_retailer]:checked").val()) {
			isValidate = false;
			alert("Please choose mobile retailer");
			return false;
		}

		if ($("input[name=mobile_retailer]:checked").val() == 1) {
			if (!$("input[name=selffinance]:checked").val()) {
				isValidate = false;
				alert("Please choose self finance scheme");
				return false;
			}
			if ($("#annual_turnover").val() == "") {
				isValidate = false;
				alert("Please enter annual turnover");
				return false;
			}
			if ($("#year_in").val() == "") {
				isValidate = false;
				alert("Please enter year in");
				return false;
			}
			if ($("#place_to").val() == "") {
				isValidate = false;
				alert("Please enter place to");
				return false;
			}
		}
		if (isValidate == true) {
			return true;
		} else {
			return false;
		}

	}
</script>
<script>
	$(document).ready(function () {
		$("#product_preference_all").prop('checked', true);
		$('.product_reference_inner').each(function () {
			$("#" + this.id).prop('disabled', true);
		});

	});
	$("#myonoffswitch").change(function () {
		if ($('#myonoffswitch').is(":checked")) {
			$("#product_preference_all").prop('disabled', false);
			$("#product_preference_all").prop('checked', true);
			$('.product_reference_inner').each(function () {
				$("#" + this.id).prop('disabled', true);
			});
		} else {
			$("#product_preference_all").prop('checked', false);
			$("#product_preference_all").prop('disabled', true);
			$('.product_reference_inner').each(function () {
				$("#" + this.id).prop('disabled', false);
			});
		}

	})
</script>
