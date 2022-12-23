<style>
.bank-hd a {font-size:12px; color:#000; margin-left:35px;}
.field-icon {float: right; margin-left: -25px; margin-top: -25px; position: relative; z-index: 2;}
.bank-login {margin:20px 0; box-shadow:0 2px 2px #f2f2f2;}
.bank-login .fa-angle-left {margin-right:10px;}
.bank-login .fa-angle-right {margin-left:10px;}
.bank-login .form-group {margin-bottom:15px;}
.or{width: 90%; border-right: 1px solid #ccc;}
@media (max-width:767px ) {
    .or{width: 100%; border-right: none; border-bottom: 1px solid #ccc; padding-bottom: 30px; margin-bottom: 30px;}
}
</style>
<div class="white-box">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="or">
        <p>Login to you Bank using Internet Banking</p>
        <p style="font-size: 11px;">(We DO NOT save your Login details, your transaction details are safe<br>with us and are used for your Profile purpose only)</p>
        <form action="https://finapp.whatsloan.yodlee.in/authenticate/whatsloan/" method="POST">
            <input type="text" name="app" value="10003600" hidden/>
            <input type="text" name="rsession" hidden value="<?php echo $_SESSION['userSession'] ?>"/>
            <input type="text" name="token" hidden value="<?php echo $token ?>" />
            <input type="text" name="redirectReq" hidden value="true"/>
            <input type="text" id="extraParams" hidden name="extraParams" value="callback=<?php echo base_url(); ?>borrowerprocess/returnResponse"/>
            <input class="btn btn-success" type="submit"value="Proceed" name="submit" />
        </form>
        </div>
    </div>

	<div class="col-md-4">
        <p>Upload your PDF Bank Statement to help us do an analysis.</p>
		<form class="form-group" action="<?php echo base_url(); ?>borrowerprocess/statementParseAndCommit" method="post" enctype="multipart/form-data">
		  <div class="form-group">
			<input type="file" class="form-control" id="bank_statement_file" name="bank_statement_file">
		  </div>
		  <div class="form-group">
			<input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $account_info['bank_name'] ?>" readonly>
		  </div>

		  <div class="text-right">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <button type="skip" class="btn btn-info pull-left" onclick="return skip_bank_statement()">Skip</button>
			  <button type="submit" class="btn btn-success">Submit</button>
		  </div>
		</form>
	</div>

</div>
<script>
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>
<script>
    function skip_bank_statement() {
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
            type	: "POST",
            url	: "<?php echo base_url(); ?>borrowerresponse/skip_bank_statement",
            data	: {[csrfName]: csrfHash},
            datatype : 'json',
            success: function(data) {
                var response = $.parseJSON(data);
                if(response.status == 1)
                {
                    csrfName = response.csrfName;
                    csrfHash = response.csrfHash;
                    window.location.href = "<?php echo base_url(); ?>borrowerprocess/profile-confirmation";
                }
            }
        });
        return false;
    }
</script>
