<div class="mytitle row hidden">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>

	
	
	<div class="white-box m-t-30">
		<div class="col-md-12 text-center p-b-30">
			<div class="unsucs-icon animated swing"><i class="icon-ghost"></i></div>
			<p class="pay-f animated swing">Ooops</p> 
			<p class="pay-f animated swing">Something went wrong. We are re-trying.</p>
			<i class="fa fa-spinner fa-pulse fa-3x"></i>
		</div>
		
		<div class="col-md-12 text-center hidden">
			<p>Look like there is some technical fault. Please visit again to proceed.</p>
			<a href="<?=base_url();?>Borrowernew/payment" class="btn btn-success btn-proceed">Create Escrow Account</a>
		</div>
	</div>