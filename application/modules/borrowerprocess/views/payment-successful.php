<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="container">
	<div class="white-box">
		<div class="col-md-12 text-center m-b-40">
			<div class="col-md-2"></div>
			<div class="col-md-7">
				<div class="sucs-icon"><img class="img-checked" src="<?=base_url();?>assets/img/checked.png" alt="User profile picture"></div>
				<p class="thnks-pay">Thank You!</p> 
				<p>Thanks a bunch for filling that out. It means a lot to us, just like you do! We really appreciate you giving us a moment of your time today. Thanks for being you.</p>
				<a href="<?=base_url();?>borrowerprocess/kyc-updation" class="btn btn-retry">Kyc</a>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "<?php echo base_url();?>borrowerprocess/kyc-updation";
        }, 5000);
    });
</script>