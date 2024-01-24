<section class="container">
	<div class="row">
		<div class="col-md-1 col-xs-12"></div>
		<div class="col-md-10 col-xs-12 e-signbox-loanbox">
			<ul class="creditloan-dtls">
				<li>Sanction Amount<span>Rs. <?php //echo $credit_line_sanction_details['approved_loan']?></span></li>
				<li>Loan Tenure<span><?php //echo $credit_line_sanction_details['approved_tenor']?> Months</span></li>
				<li>ROI<span><?php //echo $credit_line_sanction_details['amount_to_pay']?> P.A</span></li>
				<li>EMI<span>Rs. <?php //echo $credit_line_sanction_details['approved_interest_rate']?></span></li>
			</ul>
		</div>
	</div>
</section>


<section class="container">
	<div class="row">
		<div class="col-md-1 col-xs-12"></div>
		<div class="col-md-10 col-xs-12 e-signbox">
			<div class="e-signbox-txt">
            <!-- echo $loan_agreement->agreement; -->
				<?php echo $loan_agreement->agreement?>
							</div>
		</div>
	</div>
	<div class="row">
        <div class="col-md-1 col-xs-12"></div>
        <div class="col-md-10 col-xs-12 text-right">
            <a href="#" class="e-signbox-btn" id="eSignButton">Accept and E-Sign</a>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#eSignButton').click(function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
			console.log("button clicked");

            // Perform AJAX call when the button is clicked
            $.ajax({
                url: 'e_sign_send_otp_ajax', // Replace with the actual PHP file handling the OTP sending logic
                type: 'POST',
                success: function(response) {
					console.log(response);
					var resp =  JSON.parse(response);
					if(resp.status==1){
						window.location.href = 'otp';
					}
					// window.location.href = 'otp';
                    // if (response.status === 'success') {
                    //     // Handle success response, for example, display a success message
                    //     alert('OTP has been sent to your email.');
                    // } else {
                    //     // Handle other conditions, such as error in sending OTP
                    //     alert('Failed to send OTP. Please try again later.');
                    // }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
