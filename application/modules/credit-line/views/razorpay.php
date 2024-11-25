
<style>.contact-form input, .contact-form textarea {
   
   border: 1px solid #DCD8D8 !important;
 
}
.razorpay-payment-button {
        background-color: blue;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        
    }

    /* Hover effect */
    .razorpay-payment-button:hover {
        background-color: #E3563E;
    }
</style>
<?php
$name = $borrower_details['name'];
$email = $borrower_details['email'];
$mobile = $borrower_details['mobile'];
$amount = ($borrower_details['amount']);
$lender_id = $borrower_details['borrower_id'];

?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
 function pay_now(){
        
                var options = {
            "key": "<?=$api_key?>",
            "amount": "<?=($amount*100) ?>",
            "currency": "INR",
            "name": "Antworks P2P Financing",
            "description": "Regitration Fees",
            "image": "<?php echo base_url(); ?>assets/img/p2p-logo.png",
            
            "handler": function(response) {
                if (response.razorpay_payment_id != '') {
                            $.ajax({
                                type: "POST",
                                url: "payment_process",
                                data: "razorpay_payment_id=" + response.razorpay_payment_id+"&lender_id=<?php echo $lender_id?>",
                                datatype: 'json',
                                success: function (data) {
                                    if (data == 1) {
                                        window.location.href = "<?php echo base_url(); ?>credit-line/Social_profile/thanks";
                                    }
                                }
                            });
                        } else {
                            alert("Please Make Payment First");
                        }

            },
            "prefill": {
                "name": "<?=$name ?>",
                "email": "<?=$email ?>",
                "contact": "<?=$mobile ?>"
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#00518c"
            }
        };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
               }
               $(document).ready(function() {
                 pay_now();
                });        

</script>

<div class=" sec-pad service-box-one service">
 <div class="container">
   <div class="col-md-12 text-center">
           <div class="sec-title">
               <h2>Payment Lender</h2>
               <span class="decor-line">
                   <span class="decor-line-inner"></span>
               </span>
            </div>        

<form>
    <input type="button" class="razorpay-payment-button" name="btn" id="btn" value="Pay Now" onclick="pay_now()">
</form>

       </div><!-- /.col-md-8 -->

    </div>
 <!-- /.row -->
</div>



