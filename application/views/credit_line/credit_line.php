<?php
if($get_borrower_details['current_step_details']->step=="ALL STEPS DONE"){
	$link='dashboard';
}
else{
	$link='waiting';
}
?>
<section class="container creditlinebg">
	<div class="row">
		<div class="col-md-12 text-center">
			<img src="../assets/img/buddy-credit-line.png" class="creditlinelogo">
			<h2 class="creditline-headr">Credit Line</h2>
			<p class="creditline-subheadr">Here is what you get</p>
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../assets/img/earn.png" class="topfeature">
			<p class="creditline-subheadr">Easy Digital Onboarding</p>
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../assets/img/withdraw.png" class="topfeature">
			<p class="creditline-subheadr">Instant Credit Decesining</p>
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../assets/img/deposit.png" class="topfeature">
			<p class="creditline-subheadr">Disbursal to Linked A/C</p>
		</div>
	</div>
</section>
<section class="container creditline-feature">
	<div class="row">
		<div class="col-md-12">
			<h2 class="creditline-hd">Antpay presents Buddy - credit line for your daily needs.</h2>
			<div class="maincreditline">
				<h2>Antpay presents Buddy - credit line for your daily needs.</h2>
				<ul>
					<li><i class="fa fa-check-circle"></i> Low processing fees and interest rates.</li>
					<li><i class="fa fa-check-circle"></i> Quick online approval</li>
					<li><i class="fa fa-check-circle"></i> Any time access to funds - Draw down and Repay anytime.</li>
				</ul>
				<div class="col-md-12 text-right"><a href="<?=$link?>" class="maincreditline-btn">Apply Now</a></div>
			</div>
		</div>
	</div>
</section>