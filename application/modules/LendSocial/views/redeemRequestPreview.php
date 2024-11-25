<?php 
//print_r($lists['redeemRequestPreviewData']['redemption_request']);
$redeemReqestData = $lists['redeemRequestPreviewData']['redemption_request'];
?>
<section class="container">

<div class="row">
		<div class="col-md-12 col-xs-12"><h2 class="dash-hd">Redemption Request</h2></div>


					<form action="redeemRequestProcessing" method="post" >
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="surge-list">
					<ul class="invest-details">
						<li>Investment No</li> <li> <span><?php echo $redeemReqestData['investment_No']; ?></span></li>
						
						<li>Scheme Name</li> <li> <span><?php echo $redeemReqestData['scheme_Name']; ?></span></li>
						
						<li>Amount</li> <li> <span><i class="fa fa-rupee"></i><?php echo $redeemReqestData['final_amount']; ?></span></li>
						
						<li>Bank Name</li> <li> <span><?php echo $redeemReqestData['bank_name']; ?></span></li>
						
						<li>Account No.</li> <li> <span>XXXXX-<?php echo substr($redeemReqestData['account_number'],-4); ?></span></li>
						
						<li>Investment Date</li> <li> <span><?php echo $redeemReqestData['investment_date']; ?></span></li>

					</ul>
				<div class="">
				</div>
						
						<input type="hidden" name="investment_no" value="<?php echo $redeemReqestData['investment_No']; ?>" id="investment_no"  >
						<div class=""><input type="submit" value="Redeem Request" class=" surge-redeem-btn-color"></div>
			</div> 	</form>
						
			
		</div></section>