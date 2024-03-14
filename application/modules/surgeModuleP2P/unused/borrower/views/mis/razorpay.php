<div class="row">
	<section class="content-header">
		<h1>
			<?php echo $pageTitle; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Mis List</li>
		</ol>
	</section>
	<section class="content" style="min-height: 50px; max-height: 65px;">
		<div class="col-md-12">
			<form action="<?php echo base_url() ?>p2padmin/mis/uploadRazorpaypayments" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="col-md-4">
						<input type="file" name="pnbResponsefile" id="pnbResponsefile" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-4">
						<input type="submit" name="submitpnbfile" id="submitpnbfile" value="Update Razorpay Payments" class="form-control">
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
