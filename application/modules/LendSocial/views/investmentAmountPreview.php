  <?= getNotificationHtml(); ?>
  
<section class="container mainsurge-plans">
	<div class="row">

			<div class="col-md-6 col-xs-12">
			
							<form action="investmentAmount" method="post" >
			<div class="surge-plans">
				<h2>Registration Fee</h2>
				<div class="surge-badge"><img src=""></div>
				<ul>
					<li><i class="fa fa-check-circle"></i> Cooling Period : <?php echo $data['Cooling_Period'] ?> days</li>
					<li><i class="fa fa-check-circle"></i> Interest Rate : <?php echo $data['Interest_Rate'] ?>% p.a</li>
					<li><i class="fa fa-check-circle"></i> Minimum investment amount : <i class="fa fa-rupee"></i><?php echo $data['Min_Inv_Amount'] ?></li>
					<li><i class="fa fa-check-circle"></i> Maximum investment amount : <i class="fa fa-rupee"></i><?php echo $data['Max_Inv_Amount'] ?></li>
							<li><i class="fa fa-check-circle"></i> Lockin Period : <?php echo $data['Lockin_Period'] ?> days</li>
</ul>

				
				<input type="hidden" name="scheme_id" value="<?php echo $data['id']; ?>" id="scheme_id"  >
						<div class="col-md-12 col-xs-12 text-right"><input type="submit" value="Invest Now" class="surge-plans-btn"></div>
						
				<p class="remarks-txt">*10%p.a pre-mature interest rate to apply on redemption before lockin period</p>
			</div>
					</form>
		</div>
		
		
	</div>
</section>