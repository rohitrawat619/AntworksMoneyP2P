<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
            <?=getNotificationHtml();?>
		</div>
	</div>


	<div class="white-box">
		<div class="col-md-8">
			<div class="payout-main m-t-40">
				<div class="payout-bx">
					  <div class="form-group">
						<label for="bank-details" class="col-sm-4 control-label">Current Bank Details:</label>
						<div class="col-sm-8">
                            <? if($bank_details['bank_name']){?><p>Bank Name- <?=$bank_details['bank_name']?></p><? } ?>
                            <p>Account Number- <?=$bank_details['account_number']?></p>
                            <p>IFSC Code- <?=$bank_details['ifsc_code']?></p>
						</div>
					  </div>
				</div>
			</div>
		</div>
        <div class="col-md-12">Change Bank Details</div>
		<div class="col-md-8">
            <form class="bank-login" action="<?php echo base_url(); ?>borrower/borrowerrequest/action_request_change_bank" method="post" onsubmit="return bankAccountverification()">
                <div class="form-group">
                    <input type="password" class="form-control" id="account_no" name="account_no" placeholder="Account No">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="caccount_no" name="caccount_no" placeholder="Confirm Account No">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Ifsc Code">
                </div>
                <div class="text-right">
                    <input type="hidden" class="form-control" id="borrower_id" name="borrower_id" value="<?=$bank_details['borrower_id']?>">
                    <button type="submit" class="btn btn-success">Submit<i class="fa fa-angle-right"></i></button>
                </div>
            </form>
        </div>
	</div>
<script>
    function bankAccountverification() {
        var account_no = $("#account_no").val();
        var caccount_no = $("#caccount_no").val();
        var ifsc_code = $("#ifsc_code").val();
        var regex = /^[A-Za-z]{4}\d{7}$/;
        if(account_no == '' || caccount_no == '' || ifsc_code == '')
        {
            alert("All fields are mandatory");
            return false;
        }
        if(account_no.length < 4 || account_no.length > 22)
        {
            alert("The account number must be between 5 and 22 characters.");
            return false;
        }
        if(account_no != caccount_no)
        {
            alert("Please enter correct account no");
            return false;
        }
        else {
            return true;
        }
    }
</script>
