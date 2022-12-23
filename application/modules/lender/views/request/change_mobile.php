<style>
	.payout-main .form-horizontal .form-group {min-height:auto;}

	@media(max-width:767px){
		
	}
	
</style>

<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
        </div>
    </div>
    <div class="white-box">
		<div class="col-md-6">
			<div class="payout-main">
				<div class="payout-bx">
					<form class="form-horizontal" method="post">
					  
					  <div class="form-group" id="send_otp_user">
						<label for="amount" class="col-sm-4 control-label">Enter Your Mobile No.:</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" onkeypress="return isNumberKey(event)" name="mobile" id="mobile">
						</div>
					  </div>
						<div class="form-group hidden" id="verify_mobile">
							<label for="amount" class="col-sm-4 control-label">Enter OTP:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" onkeypress="return isNumberKey(event)" name="otp" id="otp">
							</div>
						</div>
					  
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						  <button type="button" id="button_verify_otp" onclick="return verifyOtpchangemobile()" class="btn btn-primary pull-right hidden">Verify OTP</button>
						  <button type="button" id="button_send_otp" onclick="return sendOtpchangemobile()" class="btn btn-primary pull-right">Send OTP</button>
						</div>
					  </div>
					</form>
				</div>
			</div>
		</div>
		</div>		
</section>
