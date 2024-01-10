<?php	/*
try { 
    eval("echo 'hello';");
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}
echo phpinfo()."--------------"; */
?>
<section class="container">
<?= getNotificationHtml(); ?>
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="<?php echo $logo_path; ?>" class="surgeant-icon">
				<h2 class="success-">Sign In</h2>
			<!--	<form role="form" action="" method="post"> ---->
				<form role="form" action="otp" method="post" id="otpForm">
					<div class="col-md-12 col-xs-12 text-left">
					<div class="col-md-3 col-xs-12"></div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<label>Mobile</label>
								<input type="number" name="mobile"  id="mobile" placeholder="Enter Mobile" class="form-control" >
								<span class="validation error-validation" id="error_mobile"></span>
							</div>
						</div>
						<div class="col-md-3 col-xs-12"></div>
					
					</div>
					<div class="text-center"><input type="submit" class="surge-plans-btn" value="Send OTP"></div>
				</form> 
				


			</div>
		</div>
	</div>
</section>

<script>
$(document).ready(function() {
   $('#mobile').on('input', function() {
    // Remove non-numeric characters using a regular expression
    $(this).val(function(_, value) {
      return value.replace(/\D/g, '');
    });
			// Limit the input to a maximum of 10 digits
    var inputValue = $(this).val();
    if (inputValue.length > 10) {
      $(this).val(inputValue.slice(0, 10));
    }
  
  });
});
</script>