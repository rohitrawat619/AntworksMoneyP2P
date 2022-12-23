<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
		</div>
	</div>
	
	
	<div class="white-box">
		<div class="table-responsive kyc-main">
		<table class="table m-t-30 table-bordered kyc-main">
			<tr>
				<th>Loan Id</th>
				<th>Date of Disbursement</th>
				<th>Lender Name</th>
				<th>Loan Amount</th>
				<th>ROI</th>
				<th>EMI Amount</th>
				<th>No. of EMI</th>
			</tr>
            <?php if($list){foreach ($list AS $list){?>
			<tr>
				<td><?php echo $list['loan_no']; ?></td>
				<td><?php echo $list['admin_acceptance_date']; ?></td>
				<td>Lender Name</td>
				<td>Loan Amount</td>
				<td>ROI</td>
				<td><?php  ?></td>
				<td><?php  ?></td>
				<td><?php echo $list['proposal_status']; ?></td>
			</tr>
            <?php }} ?>
            <tr>
                <td colspan="7" class="text-center">No Record Found</td>
            </tr>
		</table>
	</div>
	</div>