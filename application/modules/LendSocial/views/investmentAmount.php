
<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="<?php echo $logo_path; ?>" class="surgeant-icon">
				<h2 class="success-">Choose an investment amount</h2>
				<form role="form" action="processingInvestmentPayment" method="post">
					<div class="col-md-12 col-xs-12 text-left">
						<div class="col-md-12 col-xs-12">
							<div class="form-group">
								<label>Investment Amount (Min.1000)</label>
								<input type="text" name="amount" placeholder="Enter Amount" class="form-control">
								<input type="hidden" name="scheme_id" value="<?php echo $lists['scheme_id']; ?>">
								<span class="validation error-validation" id="error_name"></span>
							</div>
						</div>
						<div class="col-md-12 col-xs-12">
							<label>Recommended</label><br>
							<button type="button" class="btn btn-default">25000</button>
							<button type="button" class="btn btn-default">35000</button>
							<button type="button" class="btn btn-default">50000</button>
						</div>
						<div class="col-md-12 col-xs-12">
							<div class="checkbox">
								<input id="input1" name="checked[]" type="checkbox" value="I1">
								<label>I Agree to Terms of use</label>
							</div>
						</div>
					</div>
					<div class="text-center"><input type="submit" value="Proceed" class="surge-plans-btn" ></div>
					
				</form>
			</div>
		</div>
	</div>
</section>



<script>
   $(document).ready(function () {
      // Function to update the amount input field
      function updateAmount(value) {
         $("input[name='amount']").val(value);
      }

      // Event handler for button clicks
      $(".btn").on("click", function () {
         // Get the value associated with the clicked button
         var buttonValue = $(this).text();
		
         // Update the amount input field
         updateAmount(buttonValue);
      });
   });
</script>
