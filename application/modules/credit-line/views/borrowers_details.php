<style>
.borrower-hd {font-size:30px; text-align:center; margin-bottom:30px;} 
.borrower-hd span {font-weight:600;} 
.borrower-profile {margin:0 auto; padding:50px; text-align:center; width:100%; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #cecaca; border-radius:60px; margin-top:160px;}
.borrowerpic img {width:150px; height:150px; border-radius:150px; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #d4d4d4; margin-top:-120px;}
.borrower-criteria {margin:0 0 30px 0; padding:0;}
.borrower-criteria li{display:inline-block; padding-right:20px; color:#7e7e7e; font-size:14px; font-weight:600;}
.borrower-criteria li span {color:#000; font-size:18px; display:block;}
.borrower-criteria li:last-child{padding-right:0;}
.lending-box {margin:50px 0;}
.borrower-btn {text-align:center;}
.borrower-btn button {border-radius:30px; padding:10px 50px;}
.other-amount {margin-top:30px; font-size:18px;}
.amount-entr {width:60%; display:inline-block; text-align:center; padding:25px 10px; border-radius:50px!important;}
.btn-submit-amount {margin-top:15px;}
</style>
<section class="sec-pad service-box-one service">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
				<div class="col-md-2"></div>
                <div class="col-md-7">
                <p class="borrower-hd">Your friend <span><?= $borrower_name; ?></span> has requested for a loan of INR <span><?= $loan_amount; ?></span> on Antworks P2P platform. Details of the borrower are as follows:</p>
                    <div class="borrower-profile">
						<!-- <div class="borrowerpic"><img src="<?=base_url()?>assets/img/borrower-pic.png"></div>  -->
						<div class="borrowerpic"><img src="https://<?=$profile_pic?>" alt="Profile Pic"/></div>
					<!--	<h2 class="borrowerpic">Irshad Ahmed</h2> !-->
					<p class="borrowerpic"><span>Name:</span> <?= $borrower_name; ?> Credit Score : <?=$credit_score?></p>
						<ul class="borrower-criteria">
							<li>
							<span>Loan Amount:</span> <?= $loan_amount; ?>
							</li>
							<li>
							<span>ROI</span> <?= $roi; ?>
							</li>
							<li>
								<span>Tenure</span> <?= $tenure; ?>
							</li>
						</ul>
						<p>Already Received</p>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
							<span class="sr-only">20% Complete</span>
						  </div>
						</div>
						<p>20% Complete</p>
					</div>
                </div>
            </div>
			<div class="col-md-12 lending-box">
    			<div class="col-md-2"></div>
   				 	<div class="col-md-7 borrower-btn">
        			<p class="borrower-hd">How much you wish to lend <span><?= $borrower_name; ?></span></p>
        			<button type="button" class="btn btn-primary lend-amount" data-amount="2500"><i class="fa fa-rupee"></i> 2500</button>
        			<button type="button" class="btn btn-danger lend-amount" data-amount="3500"><i class="fa fa-rupee"></i> 3500</button>
        			<button type="button" class="btn btn-danger lend-amount" data-amount="5000"><i class="fa fa-rupee"></i> 5000</button>
        			<p class="other-amount">Other Amount</p>
        			<input type="number" class="form-control amount-entr" id="enter_amount" placeholder="Enter Amount">
					<div class="row">
    				<button type="button" class="btn btn-primary btn-submit-amount" id="submit_amount">Submit</button>
					</div>
					<input type="hidden" id="selected-borrower-id" value="<?=$borrower_id?>">	
    			</div>
			</div>

        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('.lend-amount').click(function() {
            var selectedAmount = $(this).data('amount');
            $('.amount-entr').val(selectedAmount);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#submit_amount').click(function() {
            var borrowerId = $('#selected-borrower-id').val();
            var selectedAmount = $('#enter_amount').val();
			if (selectedAmount === '') {
                alert("Please fill in the amount.");
                return; // Exit the function if the amount is empty
            }
					
            $.ajax({
                url: "<?php echo base_url('credit-line/Social_profile/insert_lender_data'); ?>",
                type: "POST",
                data: { borrower_id: borrowerId, selected_amount: selectedAmount },
                dataType: "json",
                success: function(response) {
					// Borrower Data insert Message show 

					// alert(JSON.stringify(response.msg));

					if (response.status==1) {

                        window.location.href = "<?php echo base_url('credit-line/social_profile/registration_borrower'); ?>";
                    } else {
                        alert("Insertion failed. " + response.error_msg);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while sending the request.");
                }
            });
        });
    });
</script>
