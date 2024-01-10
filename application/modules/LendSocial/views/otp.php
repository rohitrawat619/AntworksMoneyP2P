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
				<form action="verifyOtp" class="otp-form" method="post" name="otp-form">
				  <div class="title">
					<p class="otpverify">OTP Verification</p>
					<p class="otpinfo"><?php echo $lists['otpMsg']; ?></p>
					<p class="otpmsg">Please enter OTP to verify</p>
				  </div>
				  <div class="otp-input-fields">
					<input type="number" id="mainFieldOtp" class="otp__digit otp__field__1" maxlength="1"  autocomplete="one-time-code">
					<input type="number" class="otp__digit otp__field__2" maxlength="1">
					<input type="number" class="otp__digit otp__field__3" maxlength="1">
					<input type="number" class="otp__digit otp__field__4" maxlength="1">
					<input type="number" class="otp__digit otp__field__5" maxlength="1">
					<input type="number" class="otp__digit otp__field__6" maxlength="1">
					
				  </div>
				  <input type="hidden" class="" id="otp" name="otp" >
				  <input type="hidden" class=""  id="otp" name="mobile" value="<?php echo $mobile; ?>" >
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
		$("#otp").val(staticOTPValue);
				/**************/
      if (form) form.submit();
    }).catch(err => {
      console.log(err);
    });
  });
}
</script>

<script>
/****************/
// Autofill all OTP fields with a pasted value

function autofillOTPFields(pastedValue) {
  const otpFields = document.querySelectorAll('.otp__digit');

  // Clear all OTP fields before autofilling
  otpFields.forEach(function (field) {
    field.value = "";
  });

  // Autofill each OTP field with a character from the pasted value
  for (let i = 0; i < otpFields.length && i < pastedValue.length; i++) {
    otpFields[i].value = pastedValue[i];
  }

  // If you want to set the pasted value in an additional input (e.g., with id="otp")
  document.getElementById("mainFieldOtp").value = pastedValue;
  
}


document.querySelector('#mainFieldOtp').addEventListener('paste', function (event) {
    // Access the pasted text from the clipboard
    const pastedText = (event.clipboardData || window.clipboardData).getData('text');

    // Call the autofillOTPFields function with the pasted text
    autofillOTPFields(pastedText);

	 // Add a delay before submitting the form
  setTimeout(function () {
    // Submit the form using JavaScript
    document.forms['otp-form'].submit();
  }, 500); // Adjust the delay time (in milliseconds) as needed
		
});

/**************/

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
 const singleTextField = document.getElementById('otp'); // Replace 'single-text-field' with the actual ID of your single text field
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