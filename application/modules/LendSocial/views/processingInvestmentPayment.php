<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php
//echo"<pre>"; 
//print_r($lists);
$generateOrderResp = $lists['generateOrderResp'];
$sessionData = $lists['sessionData'];
?>

<div class="col-md-2 col-xs-12"></div>
<div class="col-md-8 col-xs-12 text-center">
	<div class="surge-success">
	<!----	<img class="success-txt" src="repeat.png">   ---->
		<img src="../document/surge/img/repeat.png" class="surgeant-icon">
		<h2 class="success-txt">
			<div id="waitTextId" ></div>
		</h2>
	</div>
</div>

<div class="clearfix"></div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
      var options = {
         key: '<?php echo $generateOrderResp['api_key']; ?>',
         amount: <?php echo $generateOrderResp['amount']; ?>, // Amount in paisa (e.g., 100 INR)
         currency: 'INR',
         name: 'Antworks money (Surge)',
         description: 'Payment for Order #<?php echo $generateOrderResp['order_id']; ?> Partner Name: <?php echo $sessionData['sessionData']; ?>',
         order_id: '<?php echo $generateOrderResp['order_id']; ?>',
		  prefill: {
              //  name: 'Dheeraj Dutta',
            //    email: 'dheeraj.dutta2002@gmail.com',
                contact: '<?php echo $sessionData['mobile']; ?>' // Prefilled phone number
            },
         handler: function (response) {
            // Handle the success or failure response from Razorpay
			
			var jsonStringResp = JSON.stringify(response);
			var parsedData = JSON.parse(jsonStringResp);
			
			$("#waitTextId").text('Please wait, don`t refesh your screen');
			//alert(jsonStringResp);
			/*var parsedData = JSON.parse(response);

				// Access the properties of the JavaScript object
				var paymentId = parsedData.razorpay_payment_id;
				var orderId = parsedData.razorpay_order_id;
				var signature = parsedData.razorpay_signature;
				var statusCode = parsedData.status_code;
				*/
			
			/****************start of ajax function***********
			// Make an AJAX call to your server with the payment details
            $.ajax({
               url: 'lenderInvestmentProcessing/', // Replace with your server endpoint
               type: 'POST',
               data: {
				  mobile: '<?php echo $sessionData['mobile']; ?>',
                  amount: '<?php echo $generateOrderResp['amount']; ?>',
                  razorpay_order_id: parsedData.razorpay_order_id,
                  razorpay_payment_id: parsedData.razorpay_payment_id,
                  razorpay_signature: parsedData.razorpay_signature,
                  lender_id: '<?php echo $sessionData['lender_id']; ?>',
                  scheme_id: '<?php echo $lists['scheme_id']; ?>',
                  ant_txn_id: '<?php echo $generateOrderResp['ant_txn_id']; ?>', 	
               },
			   
			 
               success: function (serverResponse) {
                  // Handle the response from your server after processing the payment
				  
                  console.log(serverResponse);
               },
               error: function (error) {
                  // Handle AJAX error
                  console.error('AJAX Error:', error);
               }
            });
					/****************end of ajax function******/
					
					
					/****************start of form submission***********/
// Create a form element
var form = document.createElement('form');
form.action = 'lenderInvestmentProcessing'; // Replace with your server endpoint
form.method = 'POST';

// Add form fields
var createHiddenField = function (name, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
};

form.appendChild(createHiddenField('mobile', '<?php echo $sessionData['mobile']; ?>'));
form.appendChild(createHiddenField('amount', '<?php echo $generateOrderResp['amount']; ?>'));
form.appendChild(createHiddenField('razorpay_order_id', parsedData.razorpay_order_id));
form.appendChild(createHiddenField('razorpay_payment_id', parsedData.razorpay_payment_id));
form.appendChild(createHiddenField('razorpay_signature', parsedData.razorpay_signature));
form.appendChild(createHiddenField('lender_id', '<?php echo $sessionData['lender_id']; ?>'));
form.appendChild(createHiddenField('scheme_id', '<?php echo $lists['scheme_id']; ?>'));
form.appendChild(createHiddenField('ant_txn_id', '<?php echo $generateOrderResp['ant_txn_id']; ?>'));

// Append the form to the document body
document.body.appendChild(form);

// Submit the form
form.submit();

// Remove the form from the document body (optional)
document.body.removeChild(form);

/****************end of form submission*******/

		//	alert(signature);
            console.log(response);
         },
      };

      var rzp = new Razorpay(options);
      rzp.open();
   
</script>