<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Client List</li>
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

			<form action="<?= base_url() ?>kyc_module/action_add_edit_client" method="post">
				<div class="row">
					<div class="col-md-12">
						
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" placeholder="Name" name="name" id="name"
									   class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="email" placeholder="Email" name="email" id="email"
									   class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" pattern="[0-9]{10}" placeholder="Mobile" name="mobile" id="mobile"
									   class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" placeholder="Company Name" name="company_name" id="company_name"
									   class="form-control">
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<select name="status" id="status" class="form-control">
									<option>Select Status</option>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-primary" value="Add Client">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">

		</div>
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>
