<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Borrower List</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<?=getNotificationHtml();?>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="m-t-30">
						<div class="right-page-header">
							<form method="post" id="search_admin" action="<?php echo base_url() ?>p2padmin/loanmanagement/searchtrailBalance">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="submit" class="btn btn-primary">
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">

								<thead>
								<tr>
									<th colspan="3">Trial balance of
										<?= $this->input->post('start_date')?$this->input->post('start_date'):'' ?></th>
								</tr>
								<tr>
									<th></th>
									<th>Debit</th>
									<th>Credit</th>
								</tr>
								</thead>

								<tbody id="borrower_search_list">

								</tbody>
								<tbody id="borrower_list">
								<?php if($trial_balance) { $total_debit = 0; $total_credit = 0;foreach ($trial_balance AS $balance){?>
									<tr>
										<td><?php echo $balance['particular'] ?></td>
										<td><?php echo $balance['debit'] ?></td>
										<td><?php echo $balance['credit'] ?></td>
									</tr>
								<? $total_debit += (int)$balance['debit']; $total_credit += (int)$balance['credit']; }?>
								<tr>
									<td></td>
									<td><?= $total_debit?$total_debit:''; ?></td>
									<td><?= $total_credit?$total_credit:''; ?></td>

								</tr>
								<?php }  else{ ?>

									<tr>
										<td></td>
										<td></td>
										<td>No Record Found</td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot>
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
</div>
