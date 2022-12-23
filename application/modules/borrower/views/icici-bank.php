<style>
.bank-hd a {font-size:12px; color:#000; margin-left:35px;}
.field-icon {float: right; margin-left: -25px; margin-top: -25px; position: relative; z-index: 2;}
.bank-login {margin:20px 0; box-shadow:0 2px 2px #f2f2f2;}
.bank-login .fa-angle-left {margin-right:10px;}
.bank-login .fa-angle-right {margin-left:10px;}
.bank-login .form-group {margin-bottom:15px;}
</style>
<div class="mytitle row">
	<div class="left col-md-4">
		<h1 class="hidden"><?=$pageTitle;?></h1>
		<img src="<?=base_url();?>assets-admin/plugins/images/bank-logo/icici-bank-hd.png">
		<p class="bank-hd"><a href="#">www.icicibank.com</a></p>
	</div>
</div>
	
<div class="white-box">
	<div class="col-md-3"></div>
	<div class="col-md-5">
		<form class="bank-login">
		  <div class="form-group">
			<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
		  </div>
		  <div class="form-group">
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		  </div>
		  <div class="form-group">
			<input id="password-field" type="password" class="form-control" name="password" value="" placeholder="Re-enter Password">
            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
		  </div>
		  <div class="text-right">
			  <button type="submit" class="btn btn-default"><i class="fa fa-angle-left"></i>Back</button>
			  <button type="submit" class="btn btn-success">Next<i class="fa fa-angle-right"></i></button>
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