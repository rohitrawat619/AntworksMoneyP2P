<div class="table-responsive">
		<table class="table m-t-30 table-bordered p2ploans" data-page-size="100">
			<tr>
				<th class="p2ploans-hd" colspan="8">Investment Account</th>
			</tr>
			<tr>
				<th class="col-md-2">SN</th>
				<th class="col-md-2">Title</th>
				<th class="col-md-2">Date</th>
				<th class="col-md-2">amount</th>
				<th class="col-md-2">Reference</th>
			</tr>
            <?php
			if($lenderInvestments){ $i = 1;
			  $amount = 0;
			  foreach ($lenderInvestments AS $lenderInvestment)
			  {
//			  	$amount = ($lenderInvestment['operator'] == '+')?
//					          $amount+$lenderInvestment['amount']
//				           :
//					$amount-$lenderInvestment['amount']
//				;
			  	?>
				  <tr>
					  <td><?= $i ?></td>
					  <td><?=$lenderInvestment['title'] ?></td>
					  <td><?=$lenderInvestment['date_added'] ?></td>
					  <td><?=$lenderInvestment['amount']; ?></td>
					  <td><?=$lenderInvestment['remark'] ?></td>
				  </tr>
			<?php $i++; }} ?>
		</table>

</div>
