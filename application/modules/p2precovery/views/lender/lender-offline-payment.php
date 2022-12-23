<style>
	.btntransparent {
		background: transparent;
		border: none;
		display: inline-block
	}

</style>
<section class="content">
	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<?= getNotificationHtml(); ?>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="m-t-30">
					<div class="m-t-30">
						<div class="right-page-header">
							<form method="post" id="search_emi">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" readonly name="start_date" id="daterange-btn"
												   placeholder="Filter by date" class="form-control filter-by-date">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<input type="button" id="search_by_emi" value="Search" name="search_by_emi"
												   class="btn btn-primary">
											<a href="javascript:void(0)" onclick="return clearForm(event)">clear</a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" name="search" placeholder="Search" class="form-control"
												   id="search">
											<div id="display"></div>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
							<thead>
							<tr>
								<th>No</th>
								<th>Created Date</th>
								<th>Lender ID</th>
								<th>Lender Name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Transaction Id</th>
								<th>Transaction Type</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Action</th>
								<!-- <th>Send sms</th>-->
							</tr>
							</thead>

							<tbody id="emi_search_list">

							</tbody>
							<tbody id="offline_list">
							<? if ($offline_list) {
								$i = 1;
								foreach ($offline_list as $row) {
									?>
									<tr id="tr_<?php echo $row['offline_id'] ?>">
										<td><?= $i; ?></td>
										<td><?= $row['created_date']; ?></td>
										<td><?= $row['lender_id']; ?></td>
										<td><?= $row['name']; ?></td>
										<td><?= $row['mobile']; ?></td>
										<td><?= $row['email']; ?></td>
										<td><?= $row['transactionId']; ?></td>
										<td><?= $row['transaction_type']; ?></td>
										<td><?= $row['amount']; ?></td>
										<td><? if ($row['approved_or_not'] == 0) {
												echo "Not Approved";
											}
											if ($row['approved_or_not'] == 1) {
												echo "Approved";
											}
											if ($row['approved_or_not'] == 2) {
												echo "Declined";
											} ?></td>
										<td>
											<? if ($row['approved_or_not'] == 0){ ?>
											<button class="btntransparent"
													onclick="return acceptPending(<?php echo $row['user_id'] ?>, <?php echo $row['offline_id'] ?>)">
												<i class="fa fa-check" aria-hidden="true"></i></button>
											<button class="btntransparent"
													onclick="return delcinePending(<?php echo $row['offline_id'] ?>)"><i
													class="fa fa-times" aria-hidden="true"></i></button>
										</td>
										<? } ?>
									</tr>
									<? $i++;
								}
							} else {
								?>
								<tr>
									<td colspan="9">No Records Found!</td>
								</tr>
							<? } ?>
							</tbody>
							<tbody id="emi_page">
							<tr>
								<td colspan="12">
									<?php
									echo $pagination;

									?>

								</td>
							</tr>

							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">

		</div>
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>
<script>
	function acceptPending(user_id, offline_id) {
		if (confirm('Do you want to approve this')) {
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL + "p2precovery/lenderofflinepayment/acceptoffline",
				data: {user_id: user_id, offline_id: offline_id},
				success: function (data) {
					var response = JSON.parse(data);
					if (response.status == 1) {
						$('#tr_' + offline_id).remove();
						alert(response.message);
					} else {
						alert(response.message);
					}
				}
			});
		}

	}

	function delcinePending(offline_id) {
		if (confirm('Do you want to disapprove this')) {
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL + "p2precovery/lenderofflinepayment/declineoffline",
				data: {offline_id: offline_id},
				success: function (data) {
					var response = JSON.parse(data);
					if (response.status == 1) {
						$('#tr_' + offline_id).remove();
						alert(response.message);
					} else {
						alert(response.message);
					}
				}
			});
		}
	}
</script>
