
<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Product List</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<?= getNotificationHtml(); ?>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="m-t-30">
						<div style="text-align: right">
							<a href="<?= base_url() ?>kyc_module/addClient">
								<button class="btn btn-primary">Add New Client Secret for KYC</button>
							</a>
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
									<th style="width: 70px">Sr. No.</th>
									<th>Client ID</th>
									<th>Client Secret</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Company Name</th>
									<th>Status</th>
									<th>Action</th>
									<th>Reset Key</th>
								</tr>
								</thead>

								<tbody id="">

								</tbody>
								<tbody id="laon_list">
								<?php if ($client_list) {
									$i = 1;
									foreach ($client_list AS $list) {
										?>
										<tr>
											<td><?= $i ?></td>
											<td><?=$list['api_key'];?></td>
											<td><?=$list['api_secret'];?></td>
											<td><?=$list['name'];?></td>
											<td><?=$list['email'];?></td>
											<td><?=$list['mobile'];?></td>
											<td><?=$list['company_name'];?></td>
											<td><?php echo ($list['status'] == 1)?'<div class="btn btn-success">Active</div>':'<div class="btn btn-danger">Inactive</div>'?></td>
											<td><a href="<?= base_url('kyc_module/update_client/').$list['id']?>" class="btn btn-success">Edit</a></td>
											<td><a href="#" class="btn btn-warning">Reset Secret</a></td>
										</tr>
										<?php $i++;
									}
								} else { ?>

									<tr>
										<td></td>
										<td>No Record Found</td>
										<td></td>
									</tr>
								<?php } ?>
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
	<div class="modal" tabindex="-1" role="dialog" id="myModal">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Modal title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Modal body text goes here.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
		  </div>
		</div>
	  </div>
	</div>
</div>




<script type="text/javascript">
    $('.openBtn').on('click', function () {
			$('#myModal').modal('show');
		
        /* var loan_disbursement_id = $(this).attr('id');
        $('.modal-body').load('<?php echo base_url(); ?>p2padmin/loanmanagement/createLoanledger/' + loan_disbursement_id, function () {
            $('#myModal').modal({show: true});
        }); */
    });
</script>
