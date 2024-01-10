<?php 
$mobile = $this->session->userdata("mobile");

?>
<section class="container">
<?= getNotificationHtml(); ?>

	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="<?php echo $logo_path; ?>" class="surgeant-icon">
				<form action="otpAadhaarProcessing" class="otp-form" method="post" name="otp-form">
				  <div class="title">
					<p class="otpverify">OTP Verification</p>
					<p class="otpinfo"><?php echo base64_decode($lists['msg']); ?></p>
					<p class="otpmsg">Please enter Aadhaar OTP to verify</p>
				  </div>
				  <div class="otp-input-fields">
					<input type="number" class="otp__digit otp__field__1" maxlength="1" autocomplete="one-time-code">
					<input type="number" class="otp__digit otp__field__2" maxlength="1">
					<input type="number" class="otp__digit otp__field__3" maxlength="1">
					<input type="number" class="otp__digit otp__field__4" maxlength="1">
					<input type="number" class="otp__digit otp__field__5" maxlength="1">
					<input type="number" class="otp__digit otp__field__6" maxlength="1">
					
				  </div>
				   <input type="hidden" class="" value="<?php echo $this->input->get('transactionId'); ?>" id="transactionId" name="transactionId" >
				  <input type="hidden" class="" value="<?php echo $this->input->get('fwdp'); ?>" id="fwdp" name="fwdp" >
				  <input type="hidden" class=""  value="<?php echo $this->input->get('codeVerifier'); ?>" id="codeVerifier" name="codeVerifier" >
				  <input type="hidden" class=""  value="<?php echo $this->input->get('kyc_unique_id'); ?>" id="kyc_unique_id" name="kyc_unique_id" >
				  <input type="hidden" class="" id="adhaarOtp" name="adhaarOtp" >
				 
				  <div class="result"><p id="_otp" class="_notok"></p></div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
if ('OTPCredential' in window) {
  window.addEventListener('DOMContentLoaded', e => {
    const input = document.querySelector('input[autocomplete="one-time-code"]');
    if (!input) return;
    const ac = new AbortController();
    const form = input.closest('form');
    if (form) {
      form.addEventListener('submit', e => {
        ac.abort();
      });
    }
    navigator.credentials.get({
      otp: { transport:['sms'] },
      signal: ac.signal
    }).then(otp => {
      //  alert("otp");
   //   input.value = otp.code;
	/****************/
				 // Autofill OTP fields with static value "644554"
  const otpFields = document.querySelectorAll('.otp__digit');
  const staticOTPValue = otp.code; //"644554";
  otpFields.forEach(function(field, index) {
    if (staticOTPValue[index]) {
      field.value = staticOTPValue[index];
    }	});
		$("#adhaarOtp").val(staticOTPValue);
				/**************/
      if (form) form.submit();
    }).catch(err => {
      console.log(err);
    });
  });
}
</script>


<script>
	/****************
				 // Autofill OTP fields with static value "644554"
  const staticOTPValue = otp.code; //"644554";
  otpFields.forEach(function(field, index) {
    if (staticOTPValue[index]) {
      field.value = staticOTPValue[index];
    }	});
				/**************/
document.addEventListener('DOMContentLoaded', function() {
  const otpFields = document.querySelectorAll('.otp__digit');
 const singleTextField = document.getElementById('adhaarOtp'); // Replace 'single-text-field' with the actual ID of your single text field
  otpFields.forEach(function(field, index) {
    field.addEventListener('input', function(event) {

      // Automatically move focus to the next OTP field
      if (index < otpFields.length - 1 && field.value.length === 1) {
        otpFields[index + 1].focus();
      }				
			  field.value = field.value.slice(0, 1);
		updateSingleTextFieldValue();
      // Automatically submit the form when the last OTP digit is entered
      if (index === otpFields.length - 1 && field.value.length === 1) {
        document.forms['otp-form'].submit();
      }
    });

    field.addEventListener('keydown', function(event) {
				
		field.value = field.value.slice(0, 1);

      // Handle backspace key
      if (event.key === 'Backspace' && index > 0 && field.value.length === 0) {
        otpFields[index - 1].focus();
      }
			updateSingleTextFieldValue();
    });
  });

			function updateSingleTextFieldValue() {
    // Concatenate the values of all OTP fields into the single text field
    singleTextField.value = Array.from(otpFields).map(field => field.value).join('');
			
  }
});


</script>