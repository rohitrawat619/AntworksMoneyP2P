<style>
	.marz-t-30 {margin-top:30px;}
	.payout-main {max-width:500px; margin:0 auto; margin-bottom:20px;}
	.payout-main .form-horizontal .form-group {min-height:auto;}
	.payout-main p {text-align:center;}
	.payout-main p:first-child {font-size:16px;}
	.payout-main p:first-child span {font-weight:600;}
	.payout-bx {border: 1px solid #00477a; padding:0 0 50px 0; margin-top:15px;}
	.payout-hd {background: #01548f; text-transform:uppercase; color:#fff; padding:5px 15px; font-size:18px; margin-bottom:15px;}
	.payout-main .form-horizontal {margin-left: 15px; margin-right: 20px;}
	
	@media(max-width:767px){
		
	}
	
</style>

<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
			<?=getNotificationHtml();?>
        </div>
    </div>
    <div class="white-box">
		<div class="col-md-12">
			<div class="payout-main">
				<p>Amount Available for Payout Rs. <span><?php echo $avilable_amount; ?></span></p>
				<p>*Subject to availability of free funds in your investment account</p>
				<div class="payout-bx">
					<div class="payout-hd">Payout Request</div>
					<form class="form-horizontal" method="post" action="<?php echo base_url() ?>lenderaction/payout_lender">
					  <div class="form-group">
						<label for="bank" class="col-sm-4 control-label">Bank Name:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="bank_name" value="<?=$bank_details['bank_name']?>" id="bank_name" readonly>
						</div>
					  </div>
						<div class="form-group">
							<label for="bank" class="col-sm-4 control-label">Account Number:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="account_number" id="account_number" value="<?=$bank_details['account_number']?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="bank" class="col-sm-4 control-label">IFSC CODE:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?=$bank_details['ifsc_code']?>" readonly>
							</div>
						</div>
					  <div class="form-group">
						<label for="amount" class="col-sm-4 control-label">Amount in Rs.:</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" name="amount" id="amount" onkeypress="return isNumberKey(event)">
						</div>
					  </div>
					  <div class="form-group">
						<label for="amount" class="col-sm-4 control-label">Payment Remarks:</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" name="payment_remarks">
						</div>
					  </div>
					  
					  
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						  <input type="hidden" name="avilable_amount" id="avilable_amount" value="<?php echo $avilable_amount; ?>">
						  <button type="reset" class="btn btn-default">Reset</button>
						   <input type="submit" class="btn btn-primary" onclick="return payOutlender()" name="submit" value="submit">

						</div>
					  </div>
					</form>
				</div>
			</div>
			<p>-Payout requests placed till 3:30 PM on trading days will be processed on same day. Payout requests placed after 3:30 PM will be processed on next trading day. In case of Bank holidays the requests will be processed on next bank working day excluding Saturdays.</p>
			<p>-Payout requests are subject to availablility of clear funds in your trading account.</p>
			<p>-In case the bank account mentioned is incorrect, you are requested to contact customer service. Write to support@antworksmoney.com</p>
		</div>
</div>
</section>
