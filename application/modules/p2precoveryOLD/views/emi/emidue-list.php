<style type="text/css">
	.row {
		margin-right: -15px;
		margin-left: -8px;
	}

	.center {
		margin: auto;
		width: 450px;
		padding: 20px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		position: absolute;
		z-index: 99;
		background: #fff;
		left: 50%;
		margin-left: -180px;
	}

	#close {
		position: absolute;
		top: 5px;
		right: 15px;
		border-radius: 45px;
		border: none;
		padding: 5px 12px;
	}

	.hideform {
		display: none;
	}
</style>


	<!-- Main content -->
	<section class="content">
		<div class="box">


			<!-- Default box -->

			<div class="box-header with-border">
				<?= getNotificationHtml(); ?>
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
												<input type="text" readonly name="start_date" id="daterange-btn"
													   placeholder="Filter by date" class="form-control filter-by-date">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<input type="button" id="search_by_emi" value="Search"
													   name="search_by_emi" class="btn btn-primary">
												<a href="javascript:void(0)" onclick="return clearForm(event)">clear</a>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="search" placeholder="Search"
													   class="form-control" id="search">
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
							<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list "
								   data-page-size="100">
								<thead>
								<tr>
									<th>No</th>
									<th>Borrower ID</th>
									<th>Loan ID</th>
									<th>Borrower Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>City</th>
									<th>Loan Amount</th>
									<th>Emi Date</th>
									<th>Emi Amount</th>
									<th>Send sms</th>
									<th>Pay Emi</th>
								</tr>
								</thead>

								<tbody id="emi_search_list">

								</tbody>
								<tbody id="emi_list">
								<? if ($week) {
									$i = 1;
									foreach ($week as $row) {
										?>
										<tr>
											<td><?= $i; ?></td>
											<td><?= $row['b_borrower_id']; ?></td>
											<td><?= $row['loan_no']; ?></td>
											<td><?= $row['name']; ?></td>
											<td><?= $row['email']; ?></td>
											<td><?= $row['mobile']; ?></td>
											<td><?= $row['r_city']; ?></td>
											<td><?= $row['bid_loan_amount']; ?></td>
											<td><?= @$row['emi_detil']->emi_date; ?></td>
											<td><?= @$row['emi_detil']->emi_amount; ?></td>
											<td>
												<form method="post"
													  action="<?php echo base_url(); ?>p2precovery/sendsms">
													<input type="hidden" name="mobile" value="9351969196">
													<input type="hidden" name="loan_no" value="<?= $row['loan_no']; ?>">
													<input type="hidden" name="emi_date"
														   value="<?= @$row['emi_detil']->emi_date; ?>">
													<input type="hidden" name="emi_amount"
														   value="<?= @$row['emi_detil']->emi_amount; ?>">
													<input type="hidden" name="account_number"
														   value="<?= $row['account_number']; ?>">
													<input type="submit" name="submit" value="Send"
														   class="btn btn-info">
												</form>
											</td>
											<td><a class="btn btn-success"
												   href="<?= base_url(); ?>p2precovery/sendemi/<?= $row['bid_registration_id']; ?>">Payment </a>

											</td>
										</tr>
										<? $i++;
									}
								} else {
									?>
									<tr>
										<td colspan="9">No Records Found!</td>
									</tr>
								<? } ?>
								</tbody>
								<tbody id="emi_page">
								<tr>
									<td colspan="12">
										<?php

										echo $pagination;


										?>

									</td>
								</tr>

								</tr>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>

			<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">

<form method="post" action="<?php echo base_url(); ?>recovery/dashboard/insertEmi">

      
        
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Pay EMI</h4>

<input type="hidden" name="emi_id" value="">
<input type="hidden" name="loan_id" value="" >
      <div class="modal-body">
        <div class="form-group">
                <lable>Referece No:</lable>
                <input type="text" name="referece" class="form-control">
            </div>
            <div class="form-group">
                <lable>Amount:</lable>
                <input type="text" name="amount"  class="form-control">
            </div>
             <div class="form-group">
                <lable>Bank:</lable>
                <input type="text" name="bank"  class="form-control">
            </div>
            <div class="form-group">
            <div id="filterDate2">
              <div class="input-group date" data-date-format="dd.mm.yyyy">
                <input  type="text" name="emi_date" class="form-control" placeholder="dd.mm.yyyy">
                <div class="input-group-addon" >
                  <span class="glyphicon glyphicon-th"></span>
                </div>
              </div>
              
            </div>    
          </div>
            <div class="form-group">
                <lable>Payment Mode:</lable>
                <select class="form-control" name="mode">
                  <option value="Online">Online</option>
                  <option value="Link">Razorpay Link</option>
                  <option value="Razorpay NACH<">Razorpay NACH</option>
                  <option value="Sign Desk NACH">Sign Desk NACH</option>
                  <option value="Recovery Agency">Recovery Agency</option>
                </select>
            </div>
            <div class="form-group">
                <lable>Remarks:</lable>
                <textarea name="remarks"  class="form-control"></textarea> 
            </div>
                
      </div>
      <div class="modal-footer">
        <input type="submit" value="Submit" class="btn btn-primary pull-right">
      </div>
    </div>
    </form>
  </div>
</div> -->
			<!-- /.box-body -->
			<div class="box-footer">

			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

	</section>
