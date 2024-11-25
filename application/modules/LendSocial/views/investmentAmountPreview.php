  <?= getNotificationHtml();

	//echo "<pre>"; print_r($lists);
	function addPercent($input) {
   
	if($lists['lender_processing_fee_percent']!="" && $lists['lender_processing_fee_percent']!=0){
		 $percent = (($lists['lender_processing_fee_percent']) / 100); // Calculating 5%
    $result = $input + ($input * $percent);
	 return $result;
	}else{
		return $input;
	}
   
}
  ?>
  
<section class="container mainsurge-plans">
	<div class="row">
			<div class="col-md-3 col-xs-12"></div>
			<div class="col-md-6 col-xs-12">
			
							<form action="investmentAmount" method="post" >
			<div class="surge-plans">
				<h2>Registration Fee</h2>
				<div class="surge-badge"><img src=""></div>
				<ul>
					<li><i class="fa fa-check-circle"></i> Invest Amount: <?php echo $lists['a'] ?> days</li>
					<li><i class="fa fa-check-circle"></i> Lender Registration Fee : <i class="fa fa-rupee"></i><?php echo $lists['partner_registration_fee_charges'] ?></li>
					<li><i class="fa fa-check-circle"></i> Lender Processing Fee : <i class="fa fa-rupee"></i><?php echo $lists['lender_processing_fee_rupee'] ?></li>
					<li><i class="fa fa-check-circle"></i> Lender Processing Fee %:<?php echo $lists['lender_processing_fee_percent'] ?></li>
							<li><i class="fa fa-check-circle"></i> Lender Platform Fee: <?php echo $lists['lender_platform_fee_percentage'] ?> % p.a</li>
</ul>

				
				<input type="hidden" name="scheme_id" value="<?php echo $lists['id']; ?>" id="scheme_id"  >
						<div class="col-md-12 col-xs-12"><input type="submit" value="Next" class="surge-plans-btn"></div>
						
				<p class="remarks-txt"></p>
			</div>
					</form>
		</div>
			<div class="col-md-3 col-xs-12"></div>
		
		
	</div>
</section>