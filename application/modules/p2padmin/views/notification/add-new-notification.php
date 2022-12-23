<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Notification List</li>
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

			<form action="<?= base_url() ?>p2padmin/emailnotification/actionaddnotification" method="post">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<select name="user_type" id="user_type" class="form-control">
									<option>Select User</option>
									<option value="lender">Lender</option>
									<option value="borrower">borrower</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select name="communication_type" id="communication_type" class="form-control">
									<option>Select Communication Type</option>
									<option value="transaction">Transaction</option>
									<option value="promotional">Promotional</option>
								</select>
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
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" placeholder="Instance" name="instance" id="instance"
									   class="form-control">
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<textarea name="sms_content" id="sms_content" class="form-control"
										  placeholder="SMS Content"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea name="notification_content" id="notification_content" class="form-control"
										  placeholder="Notification Content"></textarea>
							</div>
						</div>

						<div class="col-md-12">
							<lebel>Email Notification</lebel>
							<div class="form-group">
									 <textarea id="email_content" name="email_content" cols="174" rows="10">

                    				</textarea>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-primary" value="Add Notification">
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
