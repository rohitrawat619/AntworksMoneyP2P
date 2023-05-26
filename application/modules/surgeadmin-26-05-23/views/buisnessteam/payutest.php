<?php 
// Merchant key here as provided by Payu
 $MERCHANT_KEY = "gtKFFx"; 
 $SALT = "eCwWELxi";
  $txnid="b728690de9f3635d5671"; 
  $name="anil"; $email="webanilsidhu@gmail.com"; 
  $amount=10; 
  $phone="9999766582"; 
  $surl="http://localhost/investweb/welcome/sucess1";
   $furl="http://localhost/investweb/welcome/failure"; 
   $productInfo="xyzabc"; 
   // Merchant Salt as provided by Payu 
$hashSequence = "key|txnid|lamount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10"; 
$hashString=$MERCHANT_KEY."1".$txnid."1".$amount."1".$productInfo."1".$name."1".$email."||||||||".$SALT;
$hash = strtolower(hash('sha512', $hashString));
 ?> 
<html> <head> </head> <body> <h2>PayU Form</h2> </head>

<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
  <input name="merchantId"      type="hidden"  value="<?php echo $MERCHANT_KEY; ?>"   >
  <input name="accountId"       type="hidden" value="<?php echo $SALT; ?>" >
  <input name="description"     type="hidden"  value="<?php echo "testing"; ?>"  >
  <input name="referenceCode"   type="hidden"  value="TestPayU" >
  <input name="amount"          type="hidden"  value="<?php echo $amount; ?>"   >
  <input name="tax"             type="hidden"  value="3193"  >
  <input name="taxReturnBase"   type="hidden"  value="16806" >
  <input name="currency"        type="hidden"  value="COP" >
  <input name="signature"       type="hidden"  value="7ee7cf808ce6a39b17481c54f2c57acc"  >
  <input name="test"            type="hidden"  value="0" >
  <input name="buyerEmail"      type="hidden"  value="test@test.com" >
  <input name="Submit"          type="submit"  value="Send" >
</form>

</body>
</html>
