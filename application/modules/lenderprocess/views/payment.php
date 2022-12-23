
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
	
	<div class="container">
        <div class="white-box">

            <div class="col-md-12 text-center">


                <p><b>Thank You!! <?php echo $this->session->userdata('user_name'); ?> for submitting your loan application.</b></p>

                <p>On payment of the registration fee your loan application will be processed further.</p>

                <input class="btn btn-success" id="lender_submit_payment_button" type="submit" Value="PAY &#8377; 590.00 "/>
                <p style="font-size: 11px">Non-refundable registration fee</p>
                <p class="m-t-30">Why should you pay?</p>
                <p style="font-size: 11px">In order to enhance your experience and ensure your security, we do a lot of work at the backend. This is just a one time fee that will be adjusted in the Processing Fee, when your loan gets disbursed.</p>

            </div>

        </div>

	</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('lender_submit_payment_button').onclick = function(e){
        var amount = 59000; // Amount In Paise
        var options = {
            "key": "<?=$api_key?>",
			"order_id": "<?=$order_id; ?>",
            "amount": amount,
            "name": "ANTWORKS P2P Financial PVT. LTD.",
            "description": "Registration Fees",
            "image": "https://www.antworksmoney.com/assets/img/logo128.png",
            "handler": function (response){
                //console.log(response); //return false;
                if(response.razorpay_payment_id != '')
                {
                    $.ajax({
                        type	: "POST",
                        url	: "<?php echo base_url(); ?>lenderresponse/payment_response",
                        data	: {razorpay_payment_id:response.razorpay_payment_id, razorpay_order_id:response.razorpay_order_id, razorpay_signature:response.razorpay_signature},
                        datatype : 'json',
                        success: function(data) {
                            if(data==1)
                            {
                                window.location.href = "<?php echo base_url(); ?>lenderprocess/payment-successful";
                            }
                        }
                    });
                }
                else{
                    alert("Please Make Payment First");
                }
            },
            "prefill": {
                "name": "<?php echo $this->session->userdata('user_name'); ?>",
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
