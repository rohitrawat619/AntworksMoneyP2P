
<style>

.model-loanbox {width:100%; float:left; border: 1px solid #e1e1e1; border-radius:10px; box-shadow: 1px 1px 10px 5px #e8e8e8; padding:20px 20px; margin:30px 0;}

.model-creditloan-dtls {width:100%; float:left;}

.model-creditloan-dtls li {display:inline-block; width:50%; float:left; padding:15px 0; font-size:12px;}

.model-creditloan-dtls li span {display:block; font-weight:bold; font-size:16px;}

@media(max-width:767px){

.model-creditloan-dtls li span {font-size:14px; font-weight:bold;}

}
.e-signbox-loanbox-active {background: #5b3583; color: #fff;}

</style>


<?php
function calculateRepaymentAmount($principal, $annualInterestRate, $timeInDays) {
    
    $timeInYears = $timeInDays / 365;

    $interest = ($principal * $annualInterestRate * $timeInYears) / 100;
    $repaymentAmount= $principal + $interest;
    return ceil($repaymentAmount);
    
}
?>

<section class="container">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="creditloan-box" style="padding-bottom: 85px;">
				<h2 class="creditloan-box-hd">Antpay Credit Line</h2>
				<ul class="creditloan-dtls bordr-btm">
					<li>Available Limit<span>Rs. <?=$loan_details['available_limit']?></span></li>
					<li>Amount Outstanding<span>Rs.<?=$loan_details['use_limit']?> </span></li>
				</ul>
				<!-- <a href="#" class="creditshare-btn">Looking for a higher loan amount, share on social <i class="fa fa-arrow-right"></i></a> -->
			</div>
		</div>
		<div class="col-md-12 col-xs-12 ">
		<?php foreach($loan_details['loan_list'] as $loan){
			if($loan->borrower_disbursement_request==null && $loan->disbursed_flag==null && $loan->loan_status==null){
				$text="Your loan amount is ready for disbursement";
			}
			else if($loan->borrower_disbursement_request!=null && $loan->disbursed_flag!=null && $loan->loan_status!=null){
				$text="Congratulations your loan has been disbursed";
			}
			else{
				$text="Your loan disbursement request has been submitted successfully";
			}
			if($loan->repayment_date==null){
				$loan->repayment_date="NA";
			}
			if($loan->due_status==null){
				$loan->due_status="NA";
			}
			?>

		<div class="e-signbox-loanbox">
		
			<p class="credit-lender">Lender Name: Antworks P2P</p>
			<p class="credit-loanno" data-loan_no="<?=$loan->loan_no?>">Loan Application No: <?=$loan->loan_no?></p>
			<ul class="creditloan-dtls">
				<li>Amount Approved<span>Rs. <?=$loan->disburse_amount?></span></li>
				<li>Loan Tenure<span><?=$loan->approved_tenor?></span></li>
				<li>Repayment Amount<span>Rs. <?=$loan->repayment_amount?></span></li>
				<li>Interest Rate<span><?=$loan->approved_interest?></span></li>
				<li>Repayment Date<span><?=$loan->repayment_date?></span></li>
				<li>Repayment Status<span><?=$loan->due_status?></span></li>
			</ul>
			
			<p class="credit-disbursement"><i class="fa fa-check-circle"></i><?=$text?></p>
			<?php
			if($loan->borrower_disbursement_request==null && $loan->disbursed_flag==null && $loan->loan_status==null){
				echo "<div class='row text-right'><a href='#' class='maincreditline-btn' data-loan_no='$loan->loan_no' data-toggle='modal' data-target='.bs-example-modal-lg'>Disburse Now</a></div>";
			}
			else if($loan->borrower_disbursement_request!=null && $loan->disbursed_flag!=null && $loan->loan_status!=null){
				echo "<div class='row text-right'><a href='#' class='maincreditline-btn'>Pay Now</a></div>";
			}
			else{
				
			}
			?>
			</div>
			<?php  } ?>
		
	</div>
</section>

<section class="container">
<div class="row">
 <div class="col-md-12 col-xs-12">
 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <?php foreach($partner_loan_plans as $partner_loan_plan) {?>
                    <div class="col-md-4 col-xs-12">
                        <div class="model-loanbox">
                            <ul class="model-creditloan-dtls" data-id="<?=$partner_loan_plan['id']?>">
                                <li>Amount Approved<span>Rs. <?=$partner_loan_plan['amount']?></span></li>
                                <li>Loan Tenure<span><?=$partner_loan_plan['tenor']?> Days</span></li>
                                <li>Repayment Amount<span>Rs. <?php echo calculateRepaymentAmount($partner_loan_plan['amount'],$partner_loan_plan['interest'],$partner_loan_plan['tenor']); ?></span></li>
                                <li>Interest Rate<span><?=$partner_loan_plan['interest']?>%</span></li>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-md-12 col-xs-12">
                        <!-- Submit Plan Details button -->
                        <button type="button" class="btn btn-primary submit-plan-details-btn" data-dismiss="modal">Submit Plan Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</section>




<script>
    $('.model-loanbox').click(function() {
        $('.model-loanbox').removeClass('e-signbox-loanbox-active');
        $(this).addClass('e-signbox-loanbox-active');
    });

	$(document).ready(function() {
        $('.submit-plan-details-btn').click(function() {
            if ($('.model-loanbox.e-signbox-loanbox-active').length === 0) {
                alert('Please select a loan plan before submitting.');
                return false;
            }
			var selectedId=$('.e-signbox-loanbox-active').find('.model-creditloan-dtls').data('id');
			// console.log(selectedId);return;

        $.ajax({
            url: 'disburse',
            type: 'POST',
			data: {
			selectedId:selectedId
			},
            success: function(response) {
				console.log(response);
				var resp =  JSON.parse(response);
                // Process the response data
               // alert(resp.msg); // Log the response for testing
				location.reload();
                // You can update the HTML or perform actions based on the response here
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX request fails
                console.error(error);
            }
        });
        });
    });
</script>