<style>
    .e-signbox-loanbox {width:100%; float:left; border: 1px solid #e1e1e1; border-radius:10px; box-shadow: 1px 1px 10px 5px #e8e8e8; padding:30px 30px; margin:20px 10px;}

.e-signbox-loanbox-active {background: #5b3583; color: #fff;}
</style>


<?php
function calculateRepaymentAmount($principal, $annualInterestRate, $timeInDays) {
    
    $timeInYears = $timeInDays / 365;

    $interest = ($principal * $annualInterestRate * $timeInYears) / 100;
    $repaymentAmount= $principal + $interest;
    return round($repaymentAmount);
    
}

//print_r($partner_loan_plans); die();
?>
<section class="container">
<div class="row">
    <h3><center>choose your plan</center></h3>

<?php foreach($partner_loan_plans as $partner_loan_plan) {?>

<div class="col-md-4 col-xs-12">

<div class="e-signbox-loanbox">

                <ul class="creditloan-dtls" data-id="<?=$partner_loan_plan['id']?>">

                                <li>Amount Approved<span>Rs. <?=$partner_loan_plan['amount']?></span></li>

                                <li>Loan Tenure<span><?=$partner_loan_plan['tenor']?> Days</span></li>

                                <li>Repayment Amount<span>Rs. <?php echo calculateRepaymentAmount($partner_loan_plan['amount'],$partner_loan_plan['interest'],$partner_loan_plan['tenor']); ?></span></li>

                                <li>Interest Rate<span><?=$partner_loan_plan['interest']?>%</span></li>

                </ul>

</div>

</div>
<?php } ?>

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
            $('.e-signbox-loanbox').removeClass('e-signbox-loanbox-active');
            $(this).addClass('e-signbox-loanbox-active');
        });


        $('#eSignButton').click(function(e) {
            e.preventDefault(); 
			console.log("button clicked");


            var selectedBox = $('.e-signbox-loanbox-active');
            
            if (selectedBox.length === 0) {
                alert('Please select a loan option before proceeding.');
                return;
            }

            var selectedId=selectedBox.find('.creditloan-dtls').data('id');

            // console.log("Selected Box Data:", data);
            // return;
           
            $.ajax({
                url: 'e_sign_send_otp_ajax',
                type: 'POST',
                data: {
                    selectedId: selectedId
                }, 
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
