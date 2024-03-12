<section class="container">
	<div class="row">
		<div class="col-md-2 col-sm-12 text-center"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="surge-success">
				<img src="../document/surge/img/success-icon.png" class="surgeant-icon">
				<!---- <h2 class="success-txt">Your KYC is verified Successfully</h2> ---->
				<h2 class="success-txt"><?php echo base64_decode($lists['msg']); ?></h2>
				<p class="">Please proceed to continue</p>
				<?php if($lenderSocialProductType=="borrowerEmi"){
					$path = "Borrowwer_emi/info";
				}else if($lenderSocialProductType=="borrowerBullet"){
					$path = "Borrowwer_bullet/info";
				}else if($lenderSocialProductType=="lender"){
					$path = "surgeInvestmentPlans";
				} ?>
				<div class="text-center"><a href="<?php echo $path; ?>" class="surge-plans-btn">Proceed</a></div>
				
			</div>
		</div>
	</div>
</section>