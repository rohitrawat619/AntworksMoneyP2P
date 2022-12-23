
<link rel="stylesheet" href="<?=base_url();?>assets/css/microfinance-pool.css">
<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css">
<!-- Banner -->
<section class="banner">
	<div class="container">
		<div class="row">
			<img src="<?php echo base_url();?>assets/img/financialpool-banner.jpg">
		</div>
	</div>
</section>
<!-- /Banner -->
<!-- Page Content -->
<!-- /.row -->
<section class="mainbox">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="top-hd">
					<img src="<?php echo base_url();?>assets/img/mfi-icon.png">
					<span>MFI</span>
				</div>
				<p class="top-p">Partnered MFI with Strong Footprint to ensure commitment and engagement.</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="top-hd">
					<img src="<?php echo base_url();?>assets/img/debt-icon.png">
					<span>Debt</span>
				</div>
				<p class="top-p">Pool amount to be Invested to verified borrowers sourced by MFI; completely debt oriented pool.</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="top-hd">
					<img src="<?php echo base_url();?>assets/img/interest-icon.png">
					<span>Interest</span>
				</div>
				<p class="top-p">Opportunity to lock-in pre-tax high return of 15% p.a. on capital invested.</p>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="top-hd">
					<img src="<?php echo base_url();?>assets/img/tax-icon.png">
					<span>Tax</span>
				</div>
				<p class="top-p">A per the Tax bracket of participating lnvestor.</p>
			</div>

		</div>
	</div>
</section>
<section class="intro features">
	<div class="container">
		<div class="row">
			<table class="table table-bordered">
				<tr>
					<td class="col-md-2">Scheme</td>
					<td class="col-md-10">Antworks P2P Microfinance Pool 1</td>
				</tr>
				<tr>
					<td>Investment Philosophy</td>
					<td>To generate regular interest income by investing pool amount towards Micro Finance leading to rural borrowers. <strong>This intervention would serve a social cause in terms of augmenting the income generation
							capacity of the borrower families.</strong> Capital will be lent to verified borrowers provided by partnering Micro Finance Institution, which will also provide a <strong>loan repurchase obligation.</strong></td>
				</tr>
				<tr>
					<td>Scheme Category</td>
					<td>Theme-Social/MFI</td>
				</tr>
				<tr>
					<td>Max. Pool Size</td>
					<td>INR 10 CR</td>
				</tr>
				<tr>
					<td>Launch Date</td>
					<td>01 April 2022</td>
				</tr>
				<tr>
					<td>Closure Date</td>
					<td>31 March 2023</td>
				</tr>
				<tr>
					<td>Min. Subscription Amount</td>
					<td>INR 50000</td>
				</tr>
				<tr>
					<td>Max. Subscription Amount</td>
					<td>INR 5000000</td>
				</tr>
				<tr>
					<td>Return on Investment</td>
					<td>15% p.a.</td>
				</tr>
				<tr>
					<td>Door to Door Tenor</td>
					<td>Investment would be for a Fixed period of 14 Months from date of subscription</td>
				</tr>
				<tr>
					<td>Redemption</td>
					<td>On maturity, Investor will have an option to redeem Return/Princpal/Principal + Return/or Stay Invested with us</td>
				</tr>
				<tr>
					<td>Investment Management</td>
					<td>Pooled amount will be invested to borrowers on an <strong>RBI registered NBFC-P2P (Antworks P2P Financing Pvt. Ltd.)</strong> platform. Investment made under any account would be in completely transparent process. Account holder/Investor would be able to monitor his/her investment performance using login credentials. Investors would also be communicated regularly on the borrowers profiles, portfolio performance and new offers provided by P2P Company.</td>
				</tr>
			</table>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="enquerybox">
				<h2 class="inq-hd"></h2>
				<div class="col-md-2"></div>
				<form class="col-md-8 enquerybox-in" method="post" action="<?php echo base_url();?>micro/process">
					<?= getNotificationHtml(); ?>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Full Name</label>
							<input type="text" name="full_name" class="form-control" id="name">
							<span class="validation error-validation" id="error_name"></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Email ID</label>
							<input type="email" name="email" class="form-control" id="email">
							<span class="validation error-validation" id="error_email"></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputPassword1">Mobile No.</label>
							<input type="text" name="mobile" class="form-control" id="mobile" maxlength="10">
							<span class="validation error-validation" id="error_mobile"></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputPassword1">Occupation</label>
							<select class="form-control" name="occupation" id="occupation" required="required">
								<option value="" selected="" disabled="">Occupation *</option>
								<option value="1">Salaried</option>
								<option value="2">Self Employed Professional</option>
								<option value="3">Self employed Business</option>
								<option value="4">Retired</option>
								<option value="5">Student</option>
								<option value="6">Home Maker</option>
								<option value="7">Others</option>
							</select>
							<span class="validation error-validation" id="error_occupation"></span>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-field">
							<label for="exampleInputPassword1">Investment Amount</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-inr"></i></div>
								<input type="text" class="form-control" style="margin-bottom:0px; padding-left:10px;" id="investment_amount" name="investment_amount" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" placeholder="Investment Amount *" required="required" data-error="Investment Amount is required.">
								<span class="validation error-validation" id="error_investment_amount"></span>
							</div>
						</div>
					</div>

					<div class="col-md-4"><label></label>
						<div class="micro-submit"><button type="submit" class="btn btn-primary">Submit Now</button></div></div>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="footr-disclmr">
	<div class="container">
		<p><span>Disclaimer:</span> Strictly private and confidential-not for publication. This is not an offer document or prospectus and does not constitute an offer under the applicable laws. Investment in Micro Finance Pool 1  is subject to the credit risk, and repayment risk of the party availing/consuming the fund. Please read the offer document carefully before investing. This information is only for the consumption by the client/Investor and such material should not be redistributed.</p>

	</div>
</section>


