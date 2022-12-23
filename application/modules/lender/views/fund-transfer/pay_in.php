<div class="mytitle row ">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
		<?=getNotificationHtml();?>
	</div>
</div>


<div class="white-box">
	<div class="col-md-12"><p style="color: red;font-size: 10px; text-align: center">Note: Subject to realization of funds into account</p></div>
	<div class="col-md-7 col-sm-7" style="border-right:1px solid #ccc;">
		<div class="col-md-11 col-sm-11">
			<form action="<?php echo base_url()."/lenderaction/offlinePayment" ?>" method="post">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="form-group">
							<label><strong>Transaction Id</strong></label>
							<input type="text" class="form-control" name="transactionId" id="transactionId">
						</div>
					</div>
					<div class="col-xs-12 col-md-12">
						<div class="form-group">
							<label><strong>Payable Amount</strong></label>
							<input type="text" class="form-control" name="amount" id="amount">
						</div>
					</div>
					<div class="col-xs-12 col-md-12">
						<div class="form-group">
							<label><strong>NEFT/IMPS</strong></label>
							<select class="form-control" name="transaction_type" id="transaction_type">
								<option value="">Select</option>
								<option value="NEFT">NEFT</option>
								<option value="IMPS">IMPS</option>
								<option value="RTGS">RTGS</option>
							</select>
						</div>
					</div>
<!--					<div class="col-xs-6 col-md-6 pull-right">-->
<!--						<div class="form-group">-->
<!--							<label><strong>Date</strong></label>-->
<!--							<input type="text" class="form-control" name="date" id="date" placeholder="Date">-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="col-xs-6 col-md-6 pull-right">-->
<!--						<div class="form-group">-->
<!--							<label><strong>Bank Name</strong></label>-->
<!--							<input type="text" class="form-control" name="CVC" placeholder="Bank Name" required="">-->
<!--						</div>-->
<!--					</div>-->
					<div class="col-xs-12 col-md-12">
						<input class="btn btn-primary pull-right" type="submit" name="submit" id="submit" value="Submit">
					</div>
				</div>
			</form>

			<div class="row bankdetails">
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-12 col-md-3">
						<div class="form-group">
							<label><strong>Bank Name</strong></label>
						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="form-group">
							<p>180011110000</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-12 col-md-3">
						<div class="form-group">
							<label><strong>A/C Name</strong></label>
						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="form-group">
							<p>Antworks P2P Financing Pvt. Ltd. Lenders Funding Account</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-12 col-md-3">
						<div class="form-group">
							<label><strong>A/C Number</strong></label>
						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="form-group">
							<p>0004102000040062</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-12 col-md-3">
						<div class="form-group">
							<label><strong>IFSC</strong></label>
						</div>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="form-group">
							<p>IBKL0000004</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>


	<div class="col-md-5 col-sm-5 onlinefund">
		<h3 class="m-t-10">Fund Online</h3>
		<p>(Using Razorpay Payment Gateway)</p>
		<div class="col-xs-12 col-md-12">
			<form class="" method="post">
				<div class="form-group">
					<label for="amount" class="col-sm-4 control-label">Amount in Rs.:</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" name="funding_amount" id="funding_amount">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-11 m-t-15 text-right">
						<button type="submit" id="lender_submit_payment_button" class="btn btn-primary">Submit</button>
					</div>
				</div>
		</div>
	</div>

</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('lender_submit_payment_button').onclick = function(e){
		$.ajax({
			type	: "POST",
			url	: "<?php echo base_url(); ?>lenderaction/createRazorpayfundingorder",
			data	: {amount:($("#funding_amount").val()*100)},
			datatype : 'json',
			success: function(data) {
				var order_response = JSON.parse(data)
				if(order_response.status == 1)
				{
                    var order_id = order_response.order_id;
					var amount = ($("#funding_amount").val()*100); // Amount In Paise
					var options = {
						"key": "<?=$api_key;?>",
						"order_id": order_id,
						"amount": amount,
						"name": "P2P Financial PVT. LTD.",
						"description": "Funding Amount",
						"image": "https://antworksp2p.com/assets/img/logo.png",
						"handler": function (response){
							// console.log(response); return false;
							if(response.razorpay_payment_id != '')
							{
								$.ajax({
									type	: "POST",
									url	: "<?php echo base_url(); ?>lenderresponse/add_amount_in_escrow",
									data	: {razorpay_payment_id:response.razorpay_payment_id, razorpay_order_id:response.razorpay_order_id, razorpay_signature:response.razorpay_signature},
									datatype : 'json',
									success: function(data) {
										if(data==1)
										{
											window.location.href = "<?php echo base_url(); ?>bidding/live_bids";
										}
										else{
											alert("Invalid Approach, Please check back");
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
						},
						"readonly":{
							"contact": "true",
							"email": "true"
						}
					};
					var rzp1 = new Razorpay(options);
					rzp1.open();
				}
			}
		});

        e.preventDefault();
    }
</script>
