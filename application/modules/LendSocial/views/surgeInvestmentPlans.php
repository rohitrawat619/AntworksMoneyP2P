  <?= getNotificationHtml(); ?>
<section class="container surgebg">
	<div class="row">
		<div class="col-md-12 col-xs-12 text-center">
			<img src="<?php echo $lender_logo_path; ?>" class="surgelogo">
			<!-- <h2 class="main-headr">Build short-term wealth with AntPay</h2>
			<p class="main-subheadr">Here is what you get</p> -->
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../document/surge/img/earn.png" class="topfeature">
			<p class="sub-subheadr">Earn upto 12% p.a</p>
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../document/surge/img/withdraw.png" class="topfeature">
			<p class="sub-subheadr">Withdraw anytime</p>
		</div>
		<div class="col-md-4 col-xs-4 text-center">
			<img src="../document/surge/img/deposit.png" class="topfeature">
			<p class="sub-subheadr">No deposit fee</p>
		</div>
	</div>
</section>

<section class="container mainsurge-plans">

<a href='lenderDashboard'> Home</a>

	<div class="row">
			<?php  //  echo "<pre>"; print_r($lists['allSchemeList']['schemes']);

					foreach($lists['allSchemeList']['schemes'] as $data){
							//	echo json_encode($data)."<hr>";
									?>
			<div class="col-md-6 col-xs-12">
			
							<form action="investmentAmount" method="post" >
			<div class="surge-plans">
				<h2><?php echo $data['Scheme_Name'] ?></h2>
				<div class="surge-badge"><img style="display:none;" src="../document/surge/img/surge-badge.png"></div>
				<ul>
					<li><i class="fa fa-check-circle"></i> Cooling Period : <?php echo $data['Cooling_Period'] ?> days</li>
					<li><i class="fa fa-check-circle"></i> Interest Rate : <?php echo $data['Interest_Rate'] ?>% p.a</li>
					<li><i class="fa fa-check-circle"></i> Minimum investment amount : <i class="fa fa-rupee"></i><?php echo $data['Min_Inv_Amount'] ?></li>
					<li><i class="fa fa-check-circle"></i> Maximum investment amount : <i class="fa fa-rupee"></i><?php echo $data['Max_Inv_Amount'] ?></li>
							<li><i class="fa fa-check-circle"></i> Lockin Period : <?php echo $data['Lockin_Period'] ?> days</li>
</ul>

				
				<input type="hidden" name="scheme_id" value="<?php echo $data['id']; ?>" id="scheme_id"  >
				
				<input type="hidden" name="Min_Inv_Amount" value="<?php echo $data['Min_Inv_Amount']; ?>" id="Min_Inv_Amount"  >
				
				<input type="hidden" name="Max_Inv_Amount" value="<?php echo $data['Max_Inv_Amount']; ?>" id="Max_Inv_Amount"  >
						<div class="col-md-12 col-xs-12 text-right"><input type="submit" value="Invest Now" class="surge-plans-btn"></div>
						
				<p class="remarks-txt">*10%p.a pre-mature interest rate to apply on redemption before lockin period</p>
			</div>
					</form>
		</div>
								<?php
																}
								?>
		
		
		<div class="col-md-12 col-xs-12">
			<p>Offered in partnership with Antworks P2P Fianncing Pvt. ltd., bearing RBI License No. N-14.03483. Refer to the Terms and Conditions before investing.</P>
		</div>
	</div>
</section>