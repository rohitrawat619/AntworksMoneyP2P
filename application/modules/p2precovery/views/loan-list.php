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
							<form method="post" id="search_emi" action="<?php echo base_url(); ?>p2precovery/search">
								<div class="col-md-12">
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<input type="text" readonly name="start_date" id="daterange-btn"-->
<!--												   placeholder="Filter by date" class="form-control filter-by-date">-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<input type="text" name="b_borrower_id" id="b_borrower_id"-->
<!--												   placeholder="Borrower ID" class="form-control">-->
<!--										</div>-->
<!--									</div>-->
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" name="loan_no" id="loan_no"
												   placeholder="Loan No" class="form-control">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="submit" name="search" value="Search Loan" placeholder="Search" class="form-control"
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
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list "
							   data-page-size="100">
							<thead>
							<tr>
								<th>SR</th>
								<th>Lender Name</th>
								<th>Borrower Name</th>
								<th>Loan Id</th>
								<th>Date of Disbursement</th>
								<th>Principal Outstanding</th>
								<th>Each EMI Amount</th>
								<th>Number of EMI Serviced</th>
								<th>Tenure</th>
								<th>Next Repay</th>
							</tr>
							</thead>

							<tbody id="">

							</tbody>
							<tbody id="laon_list">
							<?php if ($loan_list) {
								$i = 1;
								foreach ($loan_list AS $laon) {
									?>
									<tr>
										<td><?= $i ?></td>
										<td><?php echo $laon['lender_name'] ?></td>
										<td><?php echo $laon['borrower_name'] ?></td>
										<td><a href="<?php echo base_url(); ?>p2precovery/loandetails/<?php echo $laon['loan_no'] ?>" target="_blank" class="openBtn"
											   id="<?php echo $laon['loan_disbursement_id']; ?>"><?php echo $laon['loan_no'] ?></a>
										</td>
										<td><?php echo $laon['disbursement_date'] ?></td>
										<td><?php echo $laon['principal_outstanding'] ?></td>
										<td><?php echo $laon['emi_amount'] ?></td>
										<td><?php echo $laon['number_of_emi_serviced'] ?></td>
										<td><?php echo $laon['tenor_months'] ?></td>
										<td><?php echo $laon['next_repay'] ?></td>
										<!--<td><button class="btn-danger" ondblclick="return deleteLoan(<?php //echo $laon['loan_disbursement_id']; ?>, '<?php //echo $laon['loan_no'] ?>')">Delete</button></td> -->
									</tr>
									<?php $i++;
								}
							} else { ?>

								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Record Found</td>
								</tr>
							<?php } ?>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="12">
									<?php

									echo $pagination;

									?></td>
							</tr>

							</tr>
							</tfoot>
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
	function deleteLoan(loanId, loanNumber){
		if (confirm('Do you want to delete this loan ? '+ loanNumber)) {
			$.ajax({
				async: true,
				type:"POST",
				url: baseURL+"p2precovery/deleteLoan",
				dataType: 'json',
				data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', loanId:loanId, loanNumber:loanNumber},
				success: function(result){
                   alert(result.msg);
                   window.location.reload();
				}});
		}
	}
</script>
