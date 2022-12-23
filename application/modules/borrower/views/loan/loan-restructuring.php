<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>


<div class="white-box">
<div class="table-responsive">
	<table id="" class="table m-t-30 table-hover contact-list "
		   data-page-size="100">
		<thead>
		<tr>
			<th>SR</th>
			<th>Loan account no</th>
			<th>Lender Name</th>
			<th>Amount</th>
			<th>Repayment Date</th>
			<th>Extension time</th>
			<th>Fees Payable</th>
			<th>Request</th>
			<th>Request Status</th>
		</tr>
		</thead>

		<tbody id="">

		</tbody>
		<tbody id="laon_list">
		<?php if ($loan_list) {
			$i = 1;
			foreach ($loan_list AS $loan) {
				?>
				<tr <?  if($loan['status'] !== NULL) {?>style="background-color: #f6f6f6; pointer-events:none" <?}?>>
					<td><?= $i ?></td>
					<td><?php echo $loan['loan_no'] ?></td>
					<td><?php echo $loan['name'] ?></td>
					<td><?=$loan['loan_amount'];?></td>
					<td><?php echo $loan['emi_date'] ?></td>
					<td><select name="extension_time" id="extension_time_<?=$loan['loan_id']?>" class="">
							<? for($i = 1; $i <=5; $i++){?>
								<option value="<?=$i; ?>" <? if($i == $loan['extension_time']){ echo "selected";}?>><?=$i;?> Months</option>
							<?}?>
						</select></td>
					<td>INR 1000 on each repayment extension</td>
					<td><?  if($loan['status'] == NULL) {?><button class="btn btn-primary" onclick="return requestloanRestructuring(<?php echo $loan['loan_id']?>)">Request</button><?}?></td>
					<td><? if($loan['status'] === '0'){echo "Request pending";} if($loan['status'] === '1'){echo "Request approved";} if($loan['status'] === '2'){echo "Request rejected";} ?></td>

				</tr>
				<?php $i++;
			}
		} else { ?>

			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>No Record Found</td>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="12">
				<?php

				echo $pagination;

				?></td>
		</tr>
		</tfoot>
	</table>
</div>
</div>
<script type="text/javascript">
function requestloanRestructuring(loan_id) {
	var extension_time = $("#extension_time_"+loan_id).val();
	if(confirm("Are you want to extends you loan for "+extension_time+" month ?"))
	{
		if(loan_id)
		{
			$.ajax({
				type	: "POST",
				url	: "<?php echo base_url(); ?>borroweraction/loanRestructuring",
				data	: {loan_id:loan_id, extension_time:extension_time},
				datatype : 'json',
				success: function(data) {
					var response = $.parseJSON(data);
					alert(response.message);
					window.location.reload();
				}
			});
		}
	}
	else{
		return false;
	}

}
</script>
