<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
		<?=getNotificationHtml();?>
	</div>
</div>
<section class="sec-pad sec-pad-30">
	<div class="white-box">
		<form action="<?php echo base_url(); ?>lender/help" method="post">
		  <div class="form-group col-md-6">
			<label>Full Name</label>
			<input type="text" class="form-control" name="name" id="name" placeholder="Full Name">
		  </div>
		  <div class="form-group col-md-6">
			<label>Email address</label>
			<input type="text" class="form-control" id="email" name="email" placeholder="Email">
		  </div>
		  <div class="form-group col-md-6">
			<label>Phone No</label>
			<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Phone No">
		  </div>
		  
		  <div class="form-group col-md-6">
			<label>Subject</label>
			<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
		  </div>
		  <div class="form-group col-md-12">
			<div class="form-grp">
				<textarea name="message" class="form-control" id="message" placeholder="Message*"></textarea>
			</div>
		  </div>
		  
		  <div class="col-md-12 text-right">
			  <button type="submit" class="btn btn-primary">Submit</button>
		  </div>
		</form>
	</div>
</section>
