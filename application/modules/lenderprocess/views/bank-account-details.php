<div class="mytitle row hidden">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="white-box m-t-30">
    <div class="col-md-4"></div>
	<div class="col-md-4">
		<p class="p-b-20 p-t-20">Bank Account Details</p>
		<form class="" method="post" name="bank_account_detaiils" id="bank_account_detaiils" action="<?php echo base_url(); ?>lenderaction/addaccountdetails"  onsubmit="return bankAccountverification()">
            <!--<div class="form-group">
                <select name="bank_name" id="bank_name" class="form-control">
                    <option value="">--Select Bank--</option>
                    <?php /*if($bank_list){ foreach ($bank_list AS $bank){*/?>
                        <option value="<?/*=$bank['value']*/?>"><?/*=$bank['name']*/?></option>
                    <?/*}}*/?>
                </select>
            </div>-->
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
        if(bank_name == '' || account_no == '' || caccount_no == '' || ifsc_code == '')
        {
            alert("All fields are mendatory");
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