
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
			<p class="credit-loanno">Loan Application No: <?=$loan->loan_no?></p>
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
				echo "<div class='row text-right'><a href='#' class='maincreditline-btn'>Disburse Now</a></div>";
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


<script>

$(document).ready(function() {
    $('.maincreditline-btn').on('click', function(event) {
        event.preventDefault();

        // Perform AJAX request to fetch loan details from PHP script
        $.ajax({
            url: 'disburse', // Path to your PHP file
            type: 'POST',

            success: function(response) {
				console.log(response);
				var resp =  JSON.parse(response);
                // Process the response data
                alert(resp.msg); // Log the response for testing
				//location.reload();
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

