<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="../document/surge/img/success-icon.png" class="surgeant-icon">
				<!---- <h2 class="success-txt">Your KYC is verified Successfully</h2> ---->
				<h2 class="success-txt"><?php echo base64_decode($lists['msg']); ?></h2>
				<p class="">Please proceed to continue</p>
				<div class="text-center"><a href="surgeInvestmentPlans" class="surge-plans-btn">Proceed</a></div>
			</div>
		</div>
	</div>
</section>