<style>
.bank-hd a {font-size:12px; color:#000; margin-left:35px;}
.field-icon {float: right; margin-left: -25px; margin-top: -25px; position: relative; z-index: 2;}
.bank-login {margin:20px 0; box-shadow:0 2px 2px #f2f2f2;}
.bank-login .fa-angle-left {margin-right:10px;}
.bank-login .fa-angle-right {margin-left:10px;}
.bank-login .form-group {margin-bottom:15px;}
</style>
	
<div class="white-box">
	<div class="col-md-3"></div>
	<div class="col-md-5">
		<form class="bank-login" action="<?php echo base_url(); ?>borrowerprocess/bank_account_verification" method="post" onsubmit="return bankAccountverification()">
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
