<button id="rzp-button1-netbanking" type="button">E-mandate via netbanking</button>
<button id="rzp-button1-debitcard" type="button">E-mandate via debit card</button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  function initiatePayment(paymentType) {
    $.ajax({
      url: 'create_order',
      type: 'POST',
      data: {
        payment_type: paymentType
      },
      success: function(response) {
        response = JSON.parse(response); 
        if (response.status === 1) {
          var options = {
            "key": RAZORPAY_KEY,
            "order_id": response.order_id,
            "customer_id": response.customer_id,
            "recurring": "1",
            "callback_url": "http://localhost/antworksp2p.com/e_nach/nach_controller/fetch_token_by_payment_id",
            "notes": {
              "note_key 1": "Beam me up Scotty",
              "note_key 2": "Tea. Earl Gray. Hot."
            },
            "theme": {
              "color": "#F37254"
            }
          };
          var rzp1 = new Razorpay(options);
          rzp1.open();
        }
        else if(response.status === 0){
          alert(response.messages);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error in AJAX request:', error);
      }
    });
  }

  document.getElementById('rzp-button1-netbanking').onclick = function (e) {
    e.preventDefault();
    initiatePayment('netbanking');
  }

  document.getElementById('rzp-button1-debitcard').onclick = function (e) {
    e.preventDefault();
    initiatePayment('debitcard');
  }
</script>
