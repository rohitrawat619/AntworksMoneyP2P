<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
	
	<div class="container">
	<div class="white-box">

        <div class="col-md-12 text-center">


            <p><b>Thank You!! <?php echo $this->session->userdata('name'); ?> for submitting your loan application.</b></p>

            <p>On payment of the registration fee your loan application will be processed further.</p>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-2">
					<input class="btn btn-success" id="borrower_submit_payment_button" type="submit" Value="PAY &#8377; 590.00 "/>
					<p style="font-size: 11px">Non-refundable registration fee</p>
				</div>
				<form method="post" id="form_coupon_code">
					<div class="col-md-2">
						<input type="text" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code" class="form-control">
						<span id="error_coupon_code"></span>
					</div><div class="col-md-1">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>

			</div>
            <p class="m-t-30">Why should you pay?</p>
            <p style="font-size: 11px">In order to enhance your experience and ensure your security, we do a lot of work at the backend. This is just a one time fee that will be adjusted in the Processing Fee, when your loan gets disbursed.</p>

        </div>

	</div>

	</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('borrower_submit_payment_button').onclick = function(e){
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var options = {
            "key": "<?=$api_key; ?>",
			"order_id": "<?=$order_id; ?>",
            "amount": "59000",
            "name": "Antworks P2P Financing",
            "description": "Regitration Fees",
            "image": "<?php echo base_url(); ?>assets/img/p2p-logo.png",
            "handler": function (response){
                //console.log(response);
                if(response.razorpay_payment_id != '')
                {
                    $.ajax({
                        type	: "POST",
                        url	: "<?php echo base_url(); ?>borrowerresponse/payment_response",
                        data	: {[csrfName]: csrfHash, razorpay_payment_id:response.razorpay_payment_id,  razorpay_order_id:response.razorpay_order_id, razorpay_signature:response.razorpay_signature},
                        datatype : 'json',
                        success: function(data) {
                            var response = $.parseJSON(data);
                            if(response.status == 1)
                            {
                                csrfName = response.csrfName;
                                csrfHash = response.csrfHash;
                                window.location.href = "<?php echo base_url(); ?>borrowerprocess/payment-successful";
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
        e.preventDefault();
    }
</script>

<script>
    $("#form_coupon_code").submit(function (){
		var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    	var coupon_code = $("#coupon_code").val();
    	if(coupon_code == "")
		{
          alert("Please enter coupon code");
          return false;
		}
    	else{
			$.ajax({
				type	: "POST",
				url	: "<?php echo base_url(); ?>borrowerresponse/couponcode",
				data	: {[csrfName]: csrfHash, coupon_code:coupon_code},
				dataType: "json",
				success: function(response) {
					console.log(response);
					if(response.status == 1)
					{
						alert(response.msg);
						window.location.href = "<?=base_url('borrowerprocess/kyc-updation');?>"
					}
					else{
						alert(response.msg);
					}

				}
			});
			return false;
		}
	})
</script>

