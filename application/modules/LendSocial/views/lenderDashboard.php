<?php
$investmentData = $lists['investmentList'];
//echo "<pre>";
//print_r($investmentData);
?>
<section class="container">
	<div class="row">
		<div class="col-md-12 col-xs-12 text-center">
			<div class="surge-success col-md-12 col-sm-12">
				<div class="col-md-12 col-sm-12 text-center"><img src="<?php echo $logo_path; ?>" class="surgeant-icon"></div>
				<div class="col-md-12 col-sm-12">
					<ul class="investment-box">
						<li><?php echo $investmentData['investment_details']['total_investment_amount']; ?> <span>Total Investment</span></li>
						<li><?php echo $investmentData['investment_details']['total_current_value']; ?> <span>Current value</span></li>
						<li><?php echo $investmentData['investment_details']['total_return']; ?> <span>Total Return</span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-xs-12"><a href="sign_out">Sign Out</a>
		<h2 class="dash-hd">Investment More</h2>
			<div class="surge-list text-center">
				<p class="moreinvest">You are eligible for more investment options</p>
				<div class=""><a href="surgeInvestmentPlans" class="surge-plans-btn">Invest Now</a></div>
			</div>
		</div>
		
	</div>
	<div class="row">
	
			<?php 
			if(count($investmentData['investment_details']['current_investment'])>0){
			?>
		<div class="col-md-12 col-xs-12"><h2 class="dash-hd">View Current Investments</h2></div>
			<?php } ?>
				<?php foreach($investmentData['investment_details']['current_investment'] as $current_investment){ ?>
					<form action="redeemRequestPreview" method="post" >
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="surge-list">
					<p class="investmentno">Investment No.: <?php echo $current_investment['investment_No']; ?></p>
					<p class="investmentname"><?php echo $current_investment['scheme_name']; ?></p>
					<ul class="invest-details">
						<li>Investment Amount <span>Rs. <?php echo $current_investment['amount']; ?></span></li>
						<li>Interest Value <span><?php echo $current_investment['final_interest']; ?></span></li>
						<li>Investment Date <span><?php echo $current_investment['investment_date']; ?></span></li>
						<li>Investment Rate <span><?php echo $current_investment['hike_rate']; ?></span></li>
					</ul>
				<div class=""><input type="submit" value="Redeem" class=" surge-redeem-btn-color"></div>
				</div>
						<input type="hidden" name="investment_no" value="<?php echo $current_investment['investment_No']; ?>" id="investment_no"  >
						
			</div> 	</form>
						<?php } ?>
			
		</div>



	<div class="row">
		<div class="col-md-12 col-xs-12"><h2 class="dash-hd">View Past Investments</h2></div>

				<?php foreach($investmentData['investment_details']['past_investment'] as $past_investment){ ?>
			<div class="col-md-6 col-xs-12">
				<div class="surge-list">
					<p class="investmentno">Investment No.: <?php echo $past_investment['investment_No']; ?></p>
					<p class="investmentname"><?php echo $past_investment['scheme_name']; ?></p>
					<ul class="invest-details">
						<li>Investment Amount <span>Rs. <?php echo $past_investment['amount']; ?></span></li>
						
						<li>Investment Date <span><?php echo $past_investment['investment_date']; ?></span></li>
						<li>Redemption Date <span><?php echo $past_investment['redemption_date']; ?></span></li>
						<li>Status <span><?php echo redemptionStatus($past_investment['redemption_status']); ?></span></li>
					</ul>
				</div>
			</div>
						<?php } ?>
				

			
			
		</div>
</section>

<?php
 function redemptionStatus($status){
	if($status==1){ 
			return "Requested";
	}
	else if($status=="2" || $status==5){
				return "In Process";
	}else if($status==4){
		return "Redeemed";
	}
	
	return null;
	
}
?>