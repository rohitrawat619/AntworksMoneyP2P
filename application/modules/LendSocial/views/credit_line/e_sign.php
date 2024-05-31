<style>
    .e-signbox-loanbox {width:100%; float:left; border: 1px solid #e1e1e1; border-radius:10px; box-shadow: 1px 1px 10px 5px #e8e8e8; padding:30px 30px; margin:20px 10px;}

.e-signbox-loanbox-active {background: #5b3583; color: #fff;}
</style>
<section class="container">
    <h3><center>choose your loan option</center></h3>
<div class="row">

<div class="col-md-4 col-xs-12">

<div class="e-signbox-loanbox">

                <ul class="creditloan-dtls">

                                <li>Amount Approved<span>Rs. 2500</span></li>

                                <li>Loan Tenure<span>30 Days</span></li>

                                <li>Repayment Amount<span>Rs. 2550</span></li>

                                <li>Interest Rate<span>2%</span></li>

                </ul>

</div>

</div>

<div class="col-md-4 col-xs-12">

<div class="e-signbox-loanbox">

                <ul class="creditloan-dtls">

                                <li>Amount Approved<span>Rs. 2500</span></li>

                                <li>Loan Tenure<span>60 Days</span></li>

                                <li>Repayment Amount<span>Rs. 2600</span></li>

                                <li>Interest Rate<span>2%</span></li>

                </ul>

</div>

</div>

<div class="col-md-4 col-xs-12">

<div class="e-signbox-loanbox e-signbox-loanbox">

                <ul class="creditloan-dtls ">

                                <li>Amount Approved<span>Rs. 2500</span></li>

                                <li>Loan Tenure<span>90 Days</span></li>

                                <li>Repayment Amount<span>Rs. 2650</span></li>

                                <li>Interest Rate<span>2%</span></li>

                </ul>

</div>

</div>

</div>


</section>


<section class="container">
	<div class="row">
		<div class="col-md-1 col-xs-12"></div>
		<div class="col-md-10 col-xs-12 e-signbox">
			<div class="e-signbox-txt">
				<?php echo $view_loan_agreement['msg']->agreement?>
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

        $('.e-signbox-loanbox').click(function() {
            // Remove the active class from all boxes
            $('.e-signbox-loanbox').removeClass('e-signbox-loanbox-active');
            // Add the active class to the clicked box
            $(this).addClass('e-signbox-loanbox-active');
        });


        $('#eSignButton').click(function(e) {
            e.preventDefault(); // Prevent the default behavior of the anchor tag
			console.log("button clicked");

            var selectedBox = $('.e-signbox-loanbox-active');
            if (selectedBox.length === 0) {
                alert('Please select a loan option before proceeding.');
                return;
            }

            var data = {
                amountApproved: selectedBox.find('li:contains("Amount Approved") span').text(),
                loanTenure: selectedBox.find('li:contains("Loan Tenure") span').text(),
                repaymentAmount: selectedBox.find('li:contains("Repayment Amount") span').text(),
                interestRate: selectedBox.find('li:contains("Interest Rate") span').text()
            };

            console.log("Selected Box Data:", data);
            return false;

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
