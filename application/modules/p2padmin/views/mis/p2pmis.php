<?= getNotificationHtml(); ?>
<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>p2padmin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">P2P Mis Report</li>
	</ol>
</section>
<section class="content">

	<!-- Default box -->
	<div class="box-default">
		<form action="<?= base_url(); ?>p2padmin/p2pmis/generateMis" method="post">
			<div class="col-md-12">

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="amount_lying_funding_account" id="amount_lying_funding_account"
							   class="form-control"
							   placeholder="Amount lying in Escrow account (Funding)" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="amount_lying_collection_account" id="amount_lying_collection_account"
							   class="form-control"
							   placeholder="Amount lying in Escrow account (Collection)" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="amount_lying_razorpay" id="amount_lying_razorpay" class="form-control"
							   placeholder="Amount lying in Razor pay" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="premium_listing_charges" id="premium_listing_charges" class="form-control"
							   placeholder="Premium Listing Charges" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="razorpay_charges" id="razorpay_charges" class="form-control"
							   placeholder="Razor pay charges - CUMULATIVE" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="partial_payment_received" id="partial_payment_received" class="form-control"
							   placeholder="Partial payment received - CUMULATIVE"
							   onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="rtgs_received" id="rtgs_received" class="form-control"
							   placeholder="RTGS received - CUMULATIVE" onkeypress="return isNumberKey(event)">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="total_disbursement_during_day" id="total_disbursement_during_day" class="form-control"
							   placeholder="Total Disbursment during the day bank statement" onkeypress="return isNumberKey(event)">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="total_collection_during_day" id="total_collection_during_day" class="form-control"
							   placeholder="Total collection during the day bank statement" onkeypress="return isNumberKey(event)">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="submit" name="submit" value="Generate MIS" class="btn btn-primary">
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
