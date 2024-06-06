<?php // print_r($lists);?>
<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="<?php echo $lender_logo_path; ?>" class="surgeant-icon">
				<h2 class="success-">Choose an investment amount</h2>
				<form role="form" action="processingInvestmentPayment" onsubmit="return validateForm();" method="post">
					<div class="col-md-12 col-xs-12 text-left">
						<div class="col-md-12 col-xs-12">
							<div class="form-group">
								<label>Investment Amount (Min.<?php echo $lists['Min_Inv_Amount']; ?>)</label>
								<input type="text" name="amount" placeholder="Enter Amount" class="form-control" id="amount">
								<input type="hidden" name="scheme_id" value="<?php echo $lists['scheme_id']; ?>">
								<span class="validation error-validation" id="error_name">*</span>
							</div>
						</div> <br>
						<div class="col-md-12 col-xs-12">
							<label>Recommended</label><br>
							<button type="button" class="btn btn-default">25000</button>
							<button type="button" class="btn btn-default">35000</button>
							<button type="button" class="btn btn-default">50000</button>
						</div>
						<div class="col-md-12 col-xs-12">
							<div class="checkbox">
								<input id="input1" name="checked[]" type="checkbox" value="I1">
								<label for="input1" >I Agree to Terms of use</label>
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

	function validateForm(){
		$("#error_name").text("");
		 var amount = parseFloat(document.getElementById("amount").value);
		 var minInvestmentAmount = parseFloat("<?php echo $lists['Min_Inv_Amount']; ?>");
		 var maxInvestmentAmount = parseFloat("<?php echo $lists['Max_Inv_Amount']; ?>");
		// alert(amount);
		  // alert(minInvestmentAmount); //return false;
		 if(amount<minInvestmentAmount){
			
			 $("#error_name").text("Amount should be not be less than min amount:"+minInvestmentAmount); return false;
			 //alert("Amount should be not be less than min amount:"+minInvestmentAmount); return false;
		 }else if(amount>maxInvestmentAmount){
			  
			 $("#error_name").text("Amount should not be greater max amount:"+maxInvestmentAmount); return false;
			// alert("Amount should not be greater max amount:"+maxInvestmentAmount); return false;
		 }else if(isNaN(amount) || amount==""){
			 $("#error_name").text("Please Enter Amount"); return false;
			//alert("Exact Amount"+amount); return false;
		 }else if(!document.getElementById("input1").checked) {
			  $("#error_name").text("Please agree to the terms of use."); 
       //  alert("Please agree to the terms of use.");
        return false;
			}
	}
	
   $(document).ready(function () {
	   
	   $('#amount').on('input', function() {
        // Replace any non-numeric characters with empty string
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
	   
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

<style>
.error-validation {
    color: red; /* Set color to red for validation errors */
}
</style>