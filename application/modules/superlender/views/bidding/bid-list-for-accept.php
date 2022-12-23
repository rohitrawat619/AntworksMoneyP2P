<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<div class="">
			<p>Switch Lender- </p><select class="form-control" id="lender_id" name="lender_id" onchange="return selectLenderforacceptbid(this.value)">
				<option value="">All Lender</option>
				<? if ($lender_list) {
					foreach ($lender_list AS $lender) { ?>
						<option
								value="<?= $lender['lender_id'] ?>" <? if (@$lenderId == $lender['lender_id']) {
							echo "selected";
						} ?>><?= $lender['name'] ?></option>
					<? }
				} ?>
			</select>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<?= getNotificationHtml(); ?>

			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
							<thead>
							<tr>
							<tr>
								<th>Loan No.</th>
								<th>Lender Name</th>
								<th>Borrower Name</th>
								<th>Amount</th>
								<th>Tenor</th>
								<th>Rate of Interest</th>
								<th>Bidding Date</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody id="laon_list">
							<?php if ($successfullbids) {
								foreach ($successfullbids AS $bidding) { ?>
									<tr>
										<form action="<?php echo base_url(); ?>Superlender/actionAcceptbid"
											  method="post">
											<td><?php echo $bidding['loan_no']; ?></td>
											<td><?php echo $bidding['lender_name']; ?></td>
											<td><?php echo $bidding['borrower_name']; ?></td>
											<td><?php echo $bidding['bid_loan_amount']; ?></td>
											<td><?php echo $bidding['accepted_tenor']; ?></td>
											<td><?php echo $bidding['interest_rate']; ?>%</td>
											<td><?php echo $bidding['proposal_added_date']; ?></td>
											<td>
												<?php if ($bidding['borrower_signature'] == 0) { ?>
													Borrower didn't signature this proposal
												<? } ?>
												<?php if ($bidding['lender_signature'] == 0 && $bidding['borrower_signature'] == 1) { ?>
													<input type="hidden" name="bid_registration_id" id="bid_registration_id" value="<?php echo $bidding['bid_registration_id']; ?>">
													<input type="submit" name="agree" id="agree" value="Agree" class="btn btn-primary">
													<input type="submit" name="reject" id="reject" value="Reject" class="btn btn-primary">

												<?php } ?>
											</td>
										</form>
									</tr>
								<?php }
							} else {
								echo "<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>No Bid received</td>
									</tr>";
							} ?>
							<tr>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="12">
									<?php

									//echo $pagination;

									?></td>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
</div>
<!-- /.box -->
<script type="text/javascript">
	function requestloanRestructuring(loan_id, action) {

		if (confirm("Are you confirm to " + action + " ?")) {
			if (loan_id) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>superlender/actionLoanrestructuring",
					data: {loan_id: loan_id, action: action},
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
