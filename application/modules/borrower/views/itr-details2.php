<style>
.itr-details .form-group {margin-bottom:5px; min-height:54px;}
.regi-forgot a:last-child {margin-left:15px;}
</style>
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="white-box">
	<div class="col-md-12">
		<div class="col-md-2"></div>
		<div class="col-md-6 p-t-40 p-b-30 m-t-30 m-b-30">
			<form class="form-horizontal itr-details text-left">
			  <div class="form-group">
				<label for="pan" class="col-sm-4 control-label">PAN Number</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="pan">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">Date of Birth</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="years" placeholder="1">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">Password*</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="years" placeholder="1">
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-4 control-label"></label>
				<div class="col-sm-8 regi-forgot">
				  <a href="#">New User? Register Now</a>
				  <a href="#">Forgot Password?</a>
				</div>
			  </div>
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10 text-right">
				  <button type="submit" class="btn btn-success">Next</button>
				  <button type="cancel" class="btn btn-default">Cancel</button>
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>