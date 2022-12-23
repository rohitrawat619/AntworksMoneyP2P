<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
		</div>
	</div>
	
	
	<div class="white-box">
		<div class="col-md-12 col-xs-12 m-b-20 m-t-30">
			<?php if($emi_details['paid_to_emi_amount']){?>
				<div class="col-md-4 col-xs-12"><p>Due Amount</p></div>
				<form id="form_emi_payment">
					<div class="col-md-2 col-xs-4">
						<strong>
							<i class="fa fa-rupee"></i>
							<?php echo $emi_details['paid_to_emi_amount'] ?>
						</strong></div>
					<div class="col-md-4 col-xs-4">
						<input type="hidden" name="emi_ids" id="emi_ids" value="<?=$emi_details['emi_id']?>">
						<input type="hidden" name="loan_id" id="loan_id" value="<?=$emi_details['disburse_loan_id']?>">
						<input type="hidden" name="paid_to_emi_amount" id="paid_to_emi_amount" value="<?=$emi_details['paid_to_emi_amount']?>">
						<input class="btn btn-success" id="repayment_amount_payment" value="Pay EMI" type="submit"/>
					</div>
				</form>
			<?} else{?>
				<div class="col-md-2 col-xs-12">
					<strong>
						No pending EMI is due
					</strong></div>
			<?} ?>

		</div>
	</div>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script>
		document.getElementById('repayment_amount_payment').onclick = function(e){
			var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
			var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
			var options = {
				"key": "<?php echo $api_key; ?>",
				"amount": "<?php echo $emi_details['paid_to_emi_amount']*100 ?>",
				"name": "Antworks P2P Financing",
				"description": "Repayment",
				"receipt": "KK",
				"image": "<?php echo base_url(); ?>assets/img/p2p-logo.png",
				"handler": function (response){
					//console.log(response);
					if(response.razorpay_payment_id != '')
					{
					    var emi_ids = $("#emi_ids").val();
					    var loan_id = $("#loan_id").val();
					    var paid_to_emi_amount = $("#paid_to_emi_amount").val();
						$.ajax({
							type	: "POST",
							url	: "<?php echo base_url(); ?>borrowerresponse/emi_payment_response",
							data	: {[csrfName]: csrfHash, razorpay_payment_id:response.razorpay_payment_id, emi_ids:emi_ids, loan_id:loan_id, paid_to_emi_amount:paid_to_emi_amount},
							datatype : 'json',
							success: function(data) {
								var response = $.parseJSON(data);
								if(response.status == 1)
								{
									csrfName = response.csrfName;
									csrfHash = response.csrfHash;
									alert("Youe EMI successful added");
									window.location.reload();
								}
							}
						});
					}
					else{
						alert("Please Make Payment First");
					}
				},
				"prefill": {
					"name": "<?php echo $this->session->userdata('name'); ?>",
					"email": "<?php echo $this->session->userdata('email'); ?>",
					"contact": "<?php echo $this->session->userdata('mobile'); ?>",
				},
				"theme": {
					"color": "#00518c"
				}
			};
			var rzp1 = new Razorpay(options);
			rzp1.open();
			e.preventDefault();
		}
	</script>
