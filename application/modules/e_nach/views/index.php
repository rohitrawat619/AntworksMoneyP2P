<button id="rzp-button1-netbanking" type="button">E-mandate via netbanking</button>
<button id="rzp-button1-debitcard" type="button">E-mandate via debit card</button>

<!-- <button id="rzp-button1">Pay</button> -->

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var options = {
    "key": "<?=RAZORPAY_NACH_KEY;?>",
    "order_id": "<?= $payment_details['order_id'] ?>",
    "customer_id": "<?= $payment_details['customer_id'] ?>",
    "recurring": "1",
    "callback_url": "http://localhost/antworksp2p.com/e_nach/nach_controller/paymentIdCallback",
    "notes": {
      "note_key 1": "Beam me up Scotty",
      "note_key 2": "Tea. Earl Gray. Hot."
    },
    "theme": {
      "color": "#F37254"
    }
  };
  var rzp1 = new Razorpay(options);

  document.getElementById('rzp-button1-netbanking').onclick = function (e) {
    rzp1.open();
    e.preventDefault();
  }

  document.getElementById('rzp-button1-debitcard').onclick = function (e) {
    rzp1.open();
    e.preventDefault();
  }
</script>

