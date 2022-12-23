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
            <div class="form-group">
                <select name="bank_name" id="bank_name" class="form-control" readonly>
                 <option value="">--Select Bank--</option>
                 <?php if($bank_list){ foreach ($bank_list AS $bank){?>
                 <option value="<?=$bank['value']?>"<?php if($bank['value'] == $verified['bank_name']){echo "selected";} ?>><?=$bank['name']?></option>
                 <?}}?>
                </select>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" id="caccount_no" value="<?=$verified['account_number']?>" name="caccount_no" placeholder="Confirm Account No" readonly>
            </div>
		  <div class="form-group">
			<input type="text" class="form-control" id="ifsc_code" value="<?=$verified['ifsc_code']?>" name="ifsc_code" placeholder="Ifsc Code" readonly>
		  </div>
		  <div class="text-right">
			  <a href="<?php echo base_url(); ?>lenderprocess/create-escrow-account"><button type="submit" class="btn btn-success">Next<i class="fa fa-angle-right"></i></button></a>
		  </div>
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