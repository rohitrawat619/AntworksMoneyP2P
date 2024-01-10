<?php 
$account_status = $lists['sessionData']['account_status'];
if($account_status==1){
$account_status = "disabled";
}else{
$account_status = "";
}
//echo $account_status;
?>
<section class="container mainsurge-plans">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="surge-plans">
				<div class="row text-center">
					<img src="<?php echo $logo_path; ?>" class="surgelogo">
					<h2>Account Details</h2>
				</div>
				<form role="form" action="verifyKYC" method="post" class="f1"  onsubmit="return userFunctionvalidate()">
					<div class="f1-steps">
						<div class="f1-progress">
							<div class="f1-progress-line" data-now-value="99.33333" data-number-of-steps="3" style="width: 99.33333%;"></div>
						</div>
						<div class="f1-step active" id="step_1">
							<div class="f1-step-icon"><i class="fa fa-user"></i></div>
							<p>Personal Details</p>
						</div>
						<div class="f1-step active" id="step_2">
							<div class="f1-step-icon"><i class="fa fa-key"></i></div>
							<p>Account Details</p>
						</div>
					</div>
				

					<div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Account No" <?php echo$account_status; ?> value="<?php echo $lists['sessionData']['account_number']; ?>" name="account_number" id="account_number" rows="3" autocomplete="off">
								<span class="validation error-validation" id="error_address1"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">

								<input type="text" class="form-control" placeholder="Confirm Account No" <?php echo$account_status; ?> value="<?php echo $lists['sessionData']['account_number']; ?>"  id="account_number_confirm" rows="3" autocomplete="off">
								<span class="validation error-validation" id="error_account_number"></span>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">

								<input class="form-control" type="text" placeholder="IFSC Code" name="ifsc_code" <?php echo$account_status; ?> value="<?php echo $lists['sessionData']['ifsc_code']; ?>" id="ifsc_code" onkeypress="return isNumberKey(event)" >
								<span class="validation error-validation" id="error_pincode"></span>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">

								<input class="form-control" type="text" placeholder="Bank Name" name="bank_name" <?php echo$account_status; ?> value="<?php echo $lists['sessionData']['bank_name']; ?>" id="bank_name" onkeypress="return isNumberKey(event)" >
								<span class="validation error-validation" id="error_bank_name"></span>
							</div>
						</div>
						
						<div class="col-md-12 col-xs-12">
							<div class="f1-buttons">
								
							<a href="personalDetails"><button type="button" class="btn btn-previous">Previous</button> </a>
								
								<input type="hidden" name="ci_csrf_token" value="">
								<input  type="hidden" name="mobile"  id="mobile" value="<?php echo $lists['sessionData']['mobile']; ?>" >
							<input  type="hidden" name="id"  id="id" value="<?php echo $lists['sessionData']['id']; ?>" >
							<input  type="hidden" name="form"  id="form" value="accountDetail" >
								<button type="submit" id="submitBtn" class="btn btn-submit">Submit</button>
							</div>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
	$("#submitBtn").hide();
	validateAccountNumbers();
    $('#account_number, #account_number_confirm').on('input', function() {
        validateAccountNumbers();
    });

    function validateAccountNumbers() {
			
        var accountNumber = $('#account_number').val();
        var confirmAccountNumber = $('#account_number_confirm').val();
			//	alert(confirmAccountNumber);
        if (accountNumber !== confirmAccountNumber) {
			$("#submitBtn").hide();	
            $('#error_account_number').text('Account numbers do not match');
        } else {
				$("#submitBtn").show();
            $('#error_account_number').text('');
        }
    }
});
</script>
