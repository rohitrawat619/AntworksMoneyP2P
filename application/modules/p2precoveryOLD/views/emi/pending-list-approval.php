<style>
	.btntransparent{
		background: transparent;
		border: none;
		display: inline-block
	}

</style>
<section class="content">
	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<?=getNotificationHtml();?>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="m-t-30">
					<div class="m-t-30">
						<div class="right-page-header">
							<form method="post" id="search_emi">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<input type="button" id="search_by_emi" value="Search" name="search_by_emi" class="btn btn-primary">
											<a href="javascript:void(0)" onclick="return clearForm(event)">clear</a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" name="search" placeholder="Search" class="form-control" id="search">
											<div id="display"></div>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
							<thead>
							<tr>
								<th>No</th>
								<th>Borrower ID</th>
								<th>Loan ID</th>
								<th>Loan Amount</th>
								<th>Emi Amount</th>
								<th>Paid Emi Amount</th>
								<th>Action</th>
								<!-- <th>Send sms</th>-->
							</tr>
							</thead>

							<tbody id="emi_search_list">

							</tbody>
							<tbody id="emi_list">
							<? 	if($pending_approval){
								$i=1;
								foreach($pending_approval as $row){
									?>
									<tr id="tr_<?php echo $row['emi_payment_due_id'] ?>">
										<td><?=$i;?></td>
										<td><?=$row['b_borrower_id'];?></td>
										<td><?=$row['loan_no'];?></td>
										<td><?=$row['approved_loan_amount'];?></td>
										<td><?=@$row['emi_amount'];?></td>
										<td><?=@$row['emi_payment_amount']; ?></td>
										<td><?=@$row['referece']; ?></td>
										<td><?=@$row['remarks']; ?></td>
										<td><button class="btntransparent" onclick="return acceptPending(<?php echo $row['emi_payment_due_id'] ?>, <?php echo $row['emi_id']?>)"><i class="fa fa-check" aria-hidden="true"></i></button>
											<button class="btntransparent" onclick="return delcinePending(<?php echo $row['emi_payment_due_id'] ?>)"><i class="fa fa-times" aria-hidden="true"></i></button></td>
									</tr>
									<? $i++;}}else
							{?>
								<tr>
									<td colspan="9">No Records Found!</td>
								</tr>
							<? }?>
							</tbody>
							<tbody id="emi_page">
							<tr>
								<td colspan="12">
									<?php
									//echo $pagination;

									?>

								</td></tr>

							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">

		</div>
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>
<script>
    function acceptPending(emi_payment_due_id, emi_id) {
        if (confirm('Do you want to approve this')) {
            $.ajax({
                async: true,
                type: "POST",
                url: baseURL+"p2precovery/acceptpendingApprovel",
                data: {emi_payment_due_id:emi_payment_due_id, emi_id:emi_id},
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 1)
                    {
                    	$('#tr_'+emi_payment_due_id).remove();
                        alert(response.msg);
                    }
                    else{
                        alert(response.msg);
                    }
                }
            });
        }

    }

    function delcinePending(emi_payment_due_id) {
        if (confirm('Do you want to disapprove this')) {

        }
    }
</script>
