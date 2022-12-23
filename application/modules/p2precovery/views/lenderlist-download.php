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

							<form method="post" id="search_emi" action="<?php echo base_url(); ?>p2precovery/lenderSearch">
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
											<input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date" required>
										</div>
									</div>

									<div class="col-md-1">
										<div class="form-group">
											<input type="submit" id="submit" value="download" name="submit" class="btn btn-primary">
										</div>
									</div>

								</div>
							</form>
						</div>
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
