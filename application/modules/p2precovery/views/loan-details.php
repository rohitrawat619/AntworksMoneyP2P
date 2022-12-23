<?= getNotificationHtml(); ?>

<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>p2padmin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Borrower List</li>
	</ol>
</section>
<section class="content">
	<!-- Default box -->
	<div class="box">
		<div class="row">
			<?php if ($loan) { ?>
				<div class="col-md-12">
					<div class="col-md-6 profile-devider">
						<h3>Borrower Details</h3>
						<div class="borrower-record">
							<div class="table-responsive">
								<table class="table bdr-rite">
									<tbody>
									<tr>
										<td>Borrower ID</td>
										<td><?php echo $loan['b_borrower_id']; ?></td>
									</tr>
									<tr>
										<td>Borrower Name</td>
										<td><?php echo $loan['b_name']; ?></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><p id="b_email"><?php echo $loan['b_email']; ?></p>
										</td>
									</tr>
									<tr>
										<td>Mobile</td>
										<td><p id="b_mobile">******<?php echo "******".$newstring = substr($loan['b_mobile'], -4); ?><?php //echo $loan['b_mobile']; ?></p>
										</td>
									</tr>
									<tr>
										<td>Borrower PAN</td>
										<td>
											<?= $loan['b_pan']; ?>
										</td>
									</tr>
									<tr>
										<td>Borrower Address</td>
										<td><?= $loan['b_address'] ?></td>
									</tr>
									<tr>
										<td>Borrower City</td>
										<td><?= $loan['b_city'] ?></td>
									</tr>
									<tr>
										<td>Borrower State</td>
										<td><?= $loan['b_state'] ?></td>
									</tr>
									<tr>
										<td>Borrower Pincode</td>
										<td><?= $loan['b_pincode'] ?></td>
									</tr>
									<tr>
										<td>Borrower Contact Details</td>
										<td><a target="_blank"
											   href="<?php echo base_url(); ?>p2padmin/p2pborrower/appdetails/<?php echo $loan['b_borrower_id'] ?>"><input
														type="button" class="btn btn-primary" value="View"></a></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6 profile-devider">
						<h3>Lender Details</h3>
						<div class="borrower-record">
							<div class="table-responsive">
								<table class="table">
									<tbody>
									<tr>
										<td>Lender ID</td>
										<td><?php echo $loan['l_lender_id']; ?></td>
									</tr>
									<tr>
										<td>Lender Name</td>
										<td>
											<?php echo $loan['l_name']; ?>
										</td>
									</tr>
									<tr>
										<td>Lender PAN</td>
										<td><?= $loan['l_pan']; ?></td>
									</tr>
									<tr>
										<td>Lender Email</td>
										<td><?php echo $loan['l_email'] ?></td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">

					<div class="col-md-12">
						<h3>Loan Details</h3>
						<div class="table-responsive">
							<table class="table bdr-rite">
								<tbody>
								<tr>
									<td>Loan NO</td>
									<td><?php echo $loanno; ?></td>
								</tr>
								<tr>
									<td>Loan Amount</td>
									<td>INR/- <?php echo $loan['loan_amount']; ?></td>
								</tr>
								<tr>
									<td>Tenor</td>
									<td><?php echo $loan['accepted_tenor']; if($loan['accepted_tenor'] == 1){echo " Month";} else{echo " Months"; } ?></td>
								</tr>
								<tr>
									<td>Interest Rate</td>
									<td><?php echo $loan['interest_rate']; ?> %</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-12">


					<div class="clearfix"></div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

						<div class="table-responsive">
							<table id="example23" class="table table-bordered table-hover table-striped">
								<thead>
								<tr>
									<th>No.</th>
									<th>EMI DATE</th>
									<th>EMI Amount</th>
									<th>Emi Interest</th>
									<th>Emi Principal</th>
									<th>Emi Balance</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php if ($loan['emi_details']) {
									$i = 1;
									foreach ($loan['emi_details'] AS $emi) { ?>
										<tr id="tr_<?php echo $emi['id'] ?>">
											<td><?= $i; ?></td>
											<td><a href="javascript:void(0)" id="<?php echo $emi['id'] ?>"
												   class="openBtn"><?php echo $emi['emi_date']; ?></a></td>
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
										<?php $i++;
									}
								} ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-10"></div>
					<div class="col-md-2"><input type="button" class="btn btn-primary" value="Call Borrower" id="callNow"></input> </div>
				</div>
				<div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<select class="form-control" name="select_status">
								<option>Status</option>
								<option>Phone Not Pick</option>
								<option>Reminder</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group"><input type="datetime-local" name="reminder" class="form-control"></div>
					</div>
					<div class="col-md-8">
						<div class="form-group"><textarea name="remarks" placeholder="Remarks"
														  class="form-control"></textarea></div>
					</div>
					<div class="col-md-2">
						<div class="form-group"><input type="button" name="saveremark" id="saveremark" value="Save"
													   class="btn btn-primary"></div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<div>
				<div class="modal fade bs-example-modal-lg" id="myModal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header" style="border-color: transparent">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">


							</div>
							<div class="modal-footer" style="border-color: transparent">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<script type="text/javascript">
		$('.openBtn').on('click', function () {
			/*$('.modal-body').load('content.html',function(){
				$('#myModal').modal({show:true});
			})*/
			var emi_id = $(this).attr('id');
			$('.modal-body').load('<?php echo base_url(); ?>p2precovery/emidetail/' + emi_id, function () {
				$('#myModal').modal({show: true});
			});
		});
	</script>
	<script>
		$("#callNow").click(function (){
			alert("wait call is in processing");
		})
	</script>

	<script>
		$("#saveremark").click(function (){
			alert("Remark Saved");
		})
	</script>


