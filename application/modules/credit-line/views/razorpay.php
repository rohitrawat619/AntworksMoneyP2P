
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
<div class=" sec-pad service-box-one service">
 <div class="container">
   <div class="col-md-12 text-center">
           <div class="sec-title">
               <h2>Payment Lender</h2>
               <span class="decor-line">
                   <span class="decor-line-inner"></span>
               </span>
            </div>        

       <form action="<?php echo base_url(); ?>credit-line/social_profile/thanks" method="POST">
            <script
                   src="https://checkout.razorpay.com/v1/checkout.js"
                   data-key="rzp_test_YL7LZ4LtCobrH7"
                   data-amount="<?=$borrower_details['amount'] * 100; ?>"
                   data-buttontext="Pay Now"
                   data-name="Antworks Capital LLP"
                   data-description="Payment Description"
                   data-image="https://www.antworksmoney.com/assets/img/logo128.png"
                   data-prefill.name="<?=$borrower_details['name'] ?>"
                   data-prefill.email="<?=$borrower_details['email'] ?>"
                   data-theme.color="#00518c"
           ></script>
           <input type="hidden" value="Hidden Element" name="hidden">
       </form>
       </div><!-- /.col-md-8 -->

    </div>
 <!-- /.row --> 
</div>
