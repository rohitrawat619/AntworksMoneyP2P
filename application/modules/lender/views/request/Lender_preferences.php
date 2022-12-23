<section class="sec-pad sec-pad-30">
	<div class="col-md-12">
		<div class="row">
			<div class="mytitle row">
				<div class="left col-md-12">
					<h1 id="pagetitle"><?= $pageTitle; ?></h1>
					<?= getNotificationHtml(); ?>
				</div>
			</div>
			<div class="white-box">
                <div class="col-md-12">
					<table class="table">
						<tr>
							<td style="border: none;">Auto Investment <div class="onoffswitch">
									<input type="checkbox" name="auto_investment" class="onoffswitch-checkbox"
										   id="myonoffswitch" <?php if ($auto_investment['auto_investment'] == 1) {
										echo "checked";
									} ?>>
									<label class="onoffswitch-label" for="myonoffswitch">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div></td>
						</tr>

					</table>
				</div>
				<div class="col-md-12">
					<h3>Investment Criteria</h3>
					<form method="post" id="validationPreference" onsubmit="return validationPreference()"
						  action="<?php echo base_url() ?>lenderaction/updateLenderpreference">
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
											<? for ($i = 1500; $i <= 50000; $i = $i + 1000) { ?>
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

								<td><h5 style="margin-top: 25px;">Lending Club Application</h5>

									<?php if ($lender_clubs) {
										$l_club = explode(',', $lender_preferences['landing_club']);
										foreach ($lender_clubs AS $lender_club) { ?>
											<label class="checkbox-inline"style="padding: 0;">
												<input type="radio" name="landing_club"
													   id="landing_club_<?= $lender_club['id'] ?>"
													   value="<?= $lender_club['id'] ?>" <? if (in_array($lender_club['id'], $l_club)) {
													echo "checked";
												} ?>>
												<?= $lender_club['club_name'] ?>
											</label>
										<? }
									} ?>
								</td>
							</tr>
							<tr>
								<td><h5 style="margin-top: 25px;">Would you like to opt for Auto Reinvest option</h5>

									<label class="checkbox-inline">
										<input type="radio" id="reinvest_1" name="reinvest"
											   value="1" <? if ($lender_preferences['reinvest'] == 1) {
											echo "checked";
										} ?>> Yes
									</label>
									<label class="checkbox-inline">
										<input type="radio" id="reinvest_0" name="reinvest"
											   value="0" <? if ($lender_preferences['reinvest'] == 0) {
											echo "checked";
										} ?>> No
									</label>
								</td>

								<td><h5 style="margin-top: 25px;">Are you a mobile Retailer</h5>

									<label class="checkbox-inline">
										<label data-toggle="collapse" data-target="#collapseExample"
											   aria-expanded="false"
											   aria-controls="collapseExample">
											<input type="radio" name="mobile_retailer" id="mobile_retailer_1"
												   value="1" <? if ($lender_preferences['mobile_retailer'] == 1) {
												echo "checked";
											} ?>> Yes
										</label>
										<label class="checkbox-inline">
											<input type="radio" id="mobile_retailer_0" name="mobile_retailer"
												   value="0" <? if ($lender_preferences['mobile_retailer'] == 0) {
												echo "checked";
											} ?>> No
										</label>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="collapse" id="collapseExample">
										<p class="form-inline">
											Would you like to lend under self finance scheme
											<label class="checkbox-inline">
												<input type="radio" id="selffinance_1" name="selffinance"
													   value="1" <? if ($lender_preferences['selffinance'] == 1) {
													echo "checked";
												} ?>> Yes
											</label>
											<label class="checkbox-inline">
												<input type="radio" id="selffinance_0" name="selffinance"
													   value="0" <? if ($lender_preferences['selffinance'] == 0) {
													echo "checked";
												} ?>> No
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
														   onkeypress="return isNumberKey(event)"
														   value="<?= $lender_preferences['annual_turnover'] ?>">
													<p class="error-message"></p></td>
												<td><input type="text" class="form-control" name="year_in" id="year_in"
														   placeholder="2020" onkeypress="return isNumberKey(event)"
														   value="<?= $lender_preferences['year_in'] ?>">
													<p class="error-message"></p></td>
												<td><input type="text" class="form-control" name="place_to"
														   id="place_to"
														   placeholder="Place to"
														   value="<?= $lender_preferences['place_to'] ?>">
													<p class="error-message"></p></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
						<button type="submit" class="btn btn-primary pull-right">Update</button>
					</form>
				</div>

			</div>

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
<script>
	$("#myonoffswitch").change(function () {
		var auto_invest_val = 0;
		if ($('#myonoffswitch').is(":checked")) {
			auto_invest_val = 1;
		} else {
			auto_invest_val = 0;
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>lenderaction/requestautoinvest",
			data: {auto_invest_val: auto_invest_val},
			success: function (data) {
				var response = $.parseJSON(data);
				alert(response.message);
			}
		})
	})
</script>
