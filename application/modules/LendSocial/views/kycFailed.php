
<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="../document/surge/img/failed-icon.png" class="surgeant-icon">
				<h2 class="success-txt" style="color:red">Your KYC is verification failed</h2>
				<p class=""><?php echo base64_decode($lists['msg']); ?></p>
				<div class="text-center"><a href="personalDetails" class="surge-plans-btn">Proceed</a></div>
			</div>
		</div>
	</div>
</section>