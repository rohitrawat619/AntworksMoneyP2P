<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?= $pageTitle; ?></h1>
		<?= getNotificationHtml(); ?>
	</div>
</div>

<div class="white-box">
	<div class="col-md-12">
		<div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

			<div class="table-responsive">
				<table id="example23" class="table table-bordered table-hover table-striped">
					<thead>
					<tr>
						<th>Loan No.</th>
						<th>Lender Name.</th>
						<th>Amount</th>
						<th>Tenor</th>
						<th>Rate of Interest</th>
						<th>Bidding Date</th>
					</tr>
					</thead>
					<tbody>
					<?php if ($pendingbids) {
						foreach ($pendingbids AS $bidding) { ?>
							<tr>
								<td><?php echo $bidding['loan_no']; ?></td>
								<td><?php echo $bidding['borrower_name']; ?></td>
								<td><?php echo $bidding['bid_loan_amount']; ?></td>
								<td><?php echo $bidding['accepted_tenor']; ?></td>
								<td><?php echo $bidding['interest_rate']; ?>%</td>
								<td><?php echo $bidding['proposal_added_date']; ?></td>
							</tr>
						<?php }
					} else {
						echo "<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>No Result Found</td>
                    </tr>";
					} ?>
					<tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>


</div>
