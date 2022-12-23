<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle . ' -' . $notification['instance']; ?>
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

				<form action="<?= base_url() ?>p2padmin/emailnotification/updatenotification" method="post">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<select name="user_type" id="user_type" class="form-control">
										<option value="">Select User</option>
										<option value="lender" <? if ($notification['user_type'] == 'lender') {
											echo "Selected";
										} ?>>Lender
										</option>
										<option value="borrower" <? if ($notification['user_type'] == 'borrower') {
											echo "Selected";
										} ?>>borrower
										</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<select name="communication_type" id="communication_type" class="form-control">
										<option value="">Select Communication Type</option>
										<option value="transaction" <? if ($notification['communication_type'] == 'transaction') {
											echo "Selected";
										} ?>>Transaction
										</option>
										<option value="promotional" <? if ($notification['communication_type'] == 'promotional') {
											echo "Selected";
										} ?>>Promotional
										</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" placeholder="Instance" name="instance" id="instance"
										   class="form-control" value="<?= $notification['instance']; ?>">
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
								<textarea name="sms_content" id="sms_content" class="form-control"
										  placeholder="SMS Content"><?= $notification['sms_content']; ?></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
								<textarea name="notification_content" id="notification_content" class="form-control"
										  placeholder="Notification Content"><?= $notification['notification_content']; ?></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea id="email_content" name="email_content" cols="174" rows="10">
											<?= $notification['email_content']; ?>
                    				</textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<select name="status" id="status" class="form-control">
										<option value="">Select Status</option>
										<option value="1" <? if ($notification['status'] == '1') {
											echo "Selected";
										} ?>>Active
										</option>
										<option value="0" <? if ($notification['status'] == '0') {
											echo "Selected";
										} ?>>Inactive
										</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="id" value="<?= $notification['id']; ?>">
									<input type="submit" name="submit" class="btn btn-primary"
										   value="Update Notification">
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
</div>
