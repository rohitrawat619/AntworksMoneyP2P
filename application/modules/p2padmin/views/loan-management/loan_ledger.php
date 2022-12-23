<div class="table-responsive">
		<table class="table m-t-30 table-bordered p2ploans" data-page-size="100">
			<tr>
				<th class="p2ploans-hd" colspan="8">Loan #<?=$lenderLedger['loan_no'] ?> ledger</th>
			</tr>
			<tr>
				<th class="col-md-2">SN</th>
				<th class="col-md-2">Date</th>
				<th class="col-md-2">Particular</th>
				<th class="col-md-2">Reference 1</th>
				<th class="col-md-2">Debit</th>
				<th class="col-md-2">Credit</th>
				<th class="col-md-2">Balance</th>
				<th class="col-md-2">Narration</th>
			</tr>
            <?php
			if($lenderLedger){
				unset($lenderLedger['loan_no']);
				$i = 1;
				$total_debit = 0;
				$total_credit = 0;
			  foreach ($lenderLedger AS $ledger)
			  {?>
				  <tr>
					  <td><?= $i ?></td>
					  <td><?=$ledger['date'] ?></td>
					  <td><?=$ledger['particular'] ?></td>
					  <td><?=$ledger['reference'] ?></td>
					  <td><?=$ledger['debit'] ?></td>
					  <td><?=$ledger['credit'] ?></td>
					  <td><?=$ledger['balance'] ?></td>
					  <td><?=$ledger['narration'] ?></td>
				  </tr>
			   <? $total_debit += (int)$ledger['debit']; $total_credit += (int)$ledger['credit'];  $i++; }}?>
			<tr>
				<td colspan="4"></td>
				<td><?= $total_debit?$total_debit:''; ?></td>
				<td><?= $total_credit?$total_credit:''; ?></td>
				<td colspan="2"></td>
			</tr>
		</table>

</div>
