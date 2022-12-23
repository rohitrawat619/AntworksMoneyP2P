<div class="table-responsive">
	<table id="example23" class="table table-bordered table-hover table-striped">
		<thead>
		<tr>
			<th>Loan No- <?= $emi['loan_no']; ?></th>
			<th>EMI No- <?= $emi['id']; ?></th>
		</tr>
		</thead>
	</table>
	<table id="example23" class="table table-bordered table-hover table-striped">
		<thead>
		<tr>
			<th>EMI DATE</th>
			<th>EMI Amount</th>
			<th>Emi Interest</th>
			<th>Emi Principal</th>
			<th>Emi Balance</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><?php echo $emi['emi_date']; ?></td>
			<td><?php echo $emi['emi_amount']; ?></td>
			<td><?php echo $emi['emi_interest']; ?></td>
			<td><?php echo $emi['emi_principal']; ?></td>
			<td><?php echo $emi['emi_balance']; ?></td>
			<td><?php if ($emi['status'] == 1) {
					echo "Paid";
				} else {
					echo "Unpaid";
				} ?></td>
		</tr>
		</tbody>
	</table>
	<?php if (isset($emi['is_verified'])) { ?>
		<p><strong>EMI Payment Details</strong></p>
		<table id="example23" class="table table-bordered table-hover table-striped">
			<thead>
			<tr>
				<th>EMI Payment Date</th>
				<th>EMI ID</th>
				<th>Reference</th>
				<th>Emi Payment Amount</th>
				<th>Emi Payment Mode</th>
				<th>Remarks</th>
				<th>IS Verified</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><?php echo $emi['emi_payment_date']; ?></td>
				<td><?php echo $emi['id']; ?></td>
				<td><?php echo $emi['referece']; ?></td>
				<td><?php echo $emi['emi_payment_amount']; ?></td>
				<td><?php echo $emi['emi_payment_mode']; ?></td>
				<td><?php echo $emi['remarks']; ?></td>
				<td><?php if ($emi['is_verified'] == 1) {
						echo "Verified";
					} else {
						echo "Not Verified";
					} ?></td>
			</tr>
			</tbody>
		</table>
	<? } ?>

</div>
<?php if (!isset($emi['is_verified']) || $emi['is_verified'] == 2) { ?>
	<div class="row">
		<div class="col-md-12"><p><strong>Pay Offline</strong></p></div>
		<div class="col-md-12">

			<form action="<?php echo base_url() ?>p2precovery/updateEmi" method="post">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control" name="transaction_id" id="transaction_id"
							   placeholder="Transaction ID/Reference">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="amount" placeholder="EMI Amount" class="form-control" id="amount"
							   onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<select class="form-control" name="mode" id="mode">
							<option value="">Select Payment Mode</option>
							<option value="online">Online</option>
							<option value="link">Razorpay Link</option>
							<option value="razorpay_nach">Razorpay NACH</option>
							<option value="sign_desk_nACH">Sign Desk NACH</option>
							<option value="recovery_agency">Recovery Agency</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="date" id="datetimepicker1" placeholder="EMI Date Time"
							   class="form-control datepicker">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="remarks" placeholder="Remarks" class="form-control" id="remarks"></textarea>
					</div>
				</div>
				<div class="col-md-12 text-right">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="emi_id" value="<?= $emi['id']; ?>" id="emi_id">
								<input type="hidden" name="loan_no" value="<?= $emi['loan_no']; ?>" id="loan_no">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>

					</div>
				</div>


			</form>
			<form method="post" action="<?php echo base_url(); ?>p2precovery/sendPaymentlink">
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<select class="form-control" name="purpose" id="purpose" onchange="changePurpose(this.value)">
								<option value="">Select</option>
								<option value="extend_loan">Extend Loan</option>
								<option value="partially_payment">Partially Payment</option>
								<option value="emi_payment">EMI Payment</option>
								<option value="foreclosure">Foreclosure</option>
							</select>
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="partially_amount" id="partially_amount" class="form-control"
							   placeholder="Partially Amount" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="expire_by" id="expire_by" class="form-control datepicker"
							   placeholder="Expire By">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="description" placeholder="Description" class="form-control"
								  id="description"></textarea>
					</div>
				</div>
				<div class="col-md-12 text-right">
					<div class="form-group">
						<input type="hidden" name="emi_id" value="<?= $emi['id']; ?>">
						<input type="hidden" name="loan_no" value="<?= $emi['loan_no']; ?>">
						<button type="submit" id="payment_link" class="btn btn-primary">Send Payment Link / SMS</button>
					</div>
				</div>
			</form>
		</div>
		<? if (($emi['p2p_sub_product_id'] = 3 or $emi['p2p_sub_product_id'] = 6) and $emi['emi_date'] < date('Y-m-d')) { ?>
			<div class="col-md-12">
				<table id="" class="table m-t-30 table-hover contact-list " data-page-size="100">
					<thead>
					<tr>
						<th>Extension time</th>
						<th>Fees Payable</th>
						<th>Request</th>
						<th>Request Status</th>
					</tr>
					</thead>

					<tbody id="">

					</tbody>

					<tbody id="laon_list">
					<tr>
						<td><select name="extension_time" id="extension_time_<?= $emi['disburse_loan_id'] ?>" class="">
								<? for ($i = 1; $i <= 5; $i++) { ?>
									<option value="<?= $i; ?>" <? if ($i == $emi['extension_time']) {
										echo "selected";
									} ?>><?= $i; ?> Months
									</option>
								<? } ?>
							</select></td>
						<td>INR 1000 on each repayment extension</td>
						<td><? if ($emi['loan_retraction_status'] == NULL) { ?>
								<button class="btn btn-primary"
										onclick="return requestloanRestructuring(<?php echo $emi['disburse_loan_id'] ?>)">
									Request</button><? } ?></td>
						<td><? if ($emi['loan_retraction_status'] === '0') {
								echo "Request pending";
							}
							if ($emi['loan_retraction_status'] === '1') {
								echo "Request approved";
							}
							if ($emi['loan_retraction_status'] === '2') {
								echo "Request rejected";
							} ?></td>
					</tr>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="12">
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
		<? } ?>
	</div>
<?php } ?>
<script
		src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('.datepicker').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
	});
</script>
<script>
	function changePurpose(purpose){
		if(purpose == 'partially_payment')
		{
			$("#partially_amount").prop('disabled', false);
		}
		else{
			$("#partially_amount").prop('disabled', true);
		}
	}
</script>
<script>
	function requestloanRestructuring(loan_id) {
		var extension_time = $("#extension_time_" + loan_id).val();
		if (confirm("Are you want to extends you loan for " + extension_time + " month ?")) {
			if (loan_id) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>p2precovery/requestLoanrestructuring",
					data: {loan_id: loan_id, extension_time: extension_time},
					datatype: 'json',
					success: function (data) {
						var response = $.parseJSON(data);
						alert(response.message);
						window.location.reload();
					}
				});
			}
		} else {
			return false;
		}
	}
</script>
