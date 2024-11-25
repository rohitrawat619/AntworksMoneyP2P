<?php
$info = base64_decode($_GET);
$txn_id = uniqid();
$si_details = json_encode(array(
    'billingCycle' => "MONTHLY",
    'billingInterval' => "1",
    'billingAmount' => "100.00",
    'billingCurrency' => "INR",
    'paymentStartDate' => "2022-11-18",
    'paymentEndDate' => "2022-12-01",

));
$hash_string = "yhV8Cx|" . $txn_id . "|1.00|Antworks_2022|Vikas Kumar|chota.bheem@gmail.com|||||||||||$si_details|hyp6aBliBVpzSiodnTcT1VXY59rb36Xz";
$hash = hash('SHA512', $hash_string);
?>

<html>
<body>
<form action='https://test.payu.in/_payment' method='post' enctype="application/x-www-form-urlencoded">
    <input type="hidden" name="key" value="<?=$request_info['key']?>"/>
    <input type="hidden" name="txnid" value="<?=$request_info['txnid']?>"/>
    <input type="hidden" name="amount" value="<?=$request_info['amount']?>"/>
    <input type="hidden" name="productinfo" value="<?=$request_info['productinfo']?>"/>
    <input type="text" name="firstname" value="<?=$request_info['firstname']?>"/>
    <input type="text" name="email" value="<?=$request_info['email']?>"/>
    <input type="text" name="phone" value="<?=$request_info['phone']?>"/>
    <input type="hidden" name="surl" value="<?=$request_info['surl']?>"/>
    <input type="hidden" name="furl" value="<?=$request_info['furl']?>"/>
    <input type="hidden" name="api_version" value="<?=$request_info['api_version']?>"/>
    <input type="hidden" name="si" value="<?=$request_info['si']?>"/>
    <input type="hidden" name="si_details" value='<?=$request_info['si_details']?>'/>
    <input type="hidden" name="hash" value="<?=$request_info_with_hash['hash']?>"/>


    <input type="submit" value="submit" id="btnHotelSearch">
</form>
<script type="text/javascript">
    $(function () {
        $('#btnHotelSearch').click(function () {
            // $('#Hotel').val(0);

        });
    });
</script>