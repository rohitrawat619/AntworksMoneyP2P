<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>

</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
            <?=getNotificationHtml();?>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <thead>
                        <tr>
						<tr>
							<th>SR</th>
							<th>Loan account no</th>
							<th>Lender Name</th>
							<th>Borrower Name</th>
							<th>Amount</th>
							<th>Repayment Date</th>
							<th>Extension time</th>
							<th>Approve/rejected</th>
						</tr>
                        </thead>
						<tbody id="laon_list">
						<?php if ($loan_list) {
							$i = 1;
							foreach ($loan_list AS $loan) {
								?>
								<tr <?  if($loan['status'] !== '0') {?>style="background-color: #f6f6f6; pointer-events:none" <?}?>>
									<td><?= $i ?></td>
									<td><?php echo $loan['loan_no'] ?></td>
									<td><?php echo $loan['lender_name'] ?></td>
									<td><?php echo $loan['name'] ?></td>
									<td><?=$loan['loan_amount'];?></td>
									<td><?php echo $loan['emi_date'] ?></td>
									<td><?=$loan['extension_time'];?> Month</td>
									<td><?if($loan['status'] === '0'){?>
											<button class="btn btn-primary" onclick="return requestloanRestructuring(<?php echo $loan['loan_id']?>, 'Approve')">Approve</button>
											<button class="btn btn-primary" onclick="return requestloanRestructuring(<?php echo $loan['loan_id']?>, 'Reject')">Reject</button>
										<?}
										else{
											if($loan['status'] === '1'){echo "Accepted";} if($loan['status'] === '2'){ echo "Rejected";}
										}
										?>
									</td>
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
								<td>No Record Found</td>
							</tr>
						<?php } ?>
						</tbody>
                        <tfoot>
                        <tr>
                            <td colspan="12">
                                <?php

                                //echo $pagination;

                                ?></td></tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
<script type="text/javascript">
	function requestloanRestructuring(loan_id, action) {

		if(confirm("Are you confirm to "+action+" ?"))
		{
			if(loan_id)
			{
				$.ajax({
					type	: "POST",
					url	: "<?php echo base_url(); ?>superlender/actionLoanrestructuring",
					data	: {loan_id:loan_id, action:action},
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