<head>
	<style type="text/css"></style>
</head>

<?= getNotificationHtml(); ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>documentmanagement/dashboard"><i class="fa fa-dashboard"></i> Home</a>
		</li>
		<li class="active">Borrower List</li>
	</ol>
</section>

<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="row">
			<?php if ($list){ ?>
			<div class="col-md-12">
				<h3 class=""><i class="ti-user"></i> Profile Summary</h3>
				<div class="col-md-6 profile-devider">
					<div class="borrower-record">
						<div class="table-responsive">
							<table class="table bdr-rite">
								<tbody>
								<tr>
									<td>Name</td>
									<td><strong><?php echo $list['Borrowername']; ?></strong></td>
								</tr>
								<tr>
									<td>Mobile</td>
									<td><strong><p id="borrower_mobile"><?php echo $list['borrower_mobile']; ?></p>
										</strong></td>
								</tr>
								<tr>
									<td>Employment</td>
									<td><strong><?php echo $list['Occuption_name']; ?></strong></td>
								</tr>
								<tr>
									<td>Age</td>
									<td>
										<strong><?= (date('Y') - date('Y', strtotime($list['borrower_dob']))); ?></strong>
									</td>
								</tr>
								<tr>
									<td>Gender</td>
									<td><strong><?php if ($list['borrower_gender'] == 1) {
												echo "Male";
											} else {
												echo "Female";
											} ?></strong></td>
								</tr>
								<tr>
									<td>Residence Type</td>
									<td><strong>Residential</strong></td>
								</tr>
								<tr>
									<td>Marital Status</td>
									<td><strong><?php if ($list['marital_status'] == 1) {
												echo "Unmarried";
											} else {
												echo "Married";
											} ?></strong></td>
								</tr>
								<tr>
									<td>PAN Details</td>
									<td><strong><?= $list['borrower_pan'] ?></strong></td>
								</tr>
								<tr>
									<td>PAN Name</td>
									<td>
										<?php
										if ($panresponse) {
											$presponse = json_decode($panresponse, true);
											if ($presponse['status']) {
												echo $presponse['error'];
											}
											if ($presponse['status-code'] == 101) {
												echo $presponse['result']['name'];
											}
											if ($presponse['status-code'] == 102) {
												echo $presponse['result'];
											}
										} ?>

									</td>
								</tr>
								<tr>
									<td>Appdetails</td>
									<td><a target="_blank"
										   href="<?php echo base_url(); ?>p2padmin/p2pborrower/appdetails/<?php echo $list['b_borrower_id'] ?>"><input
													type="button" class="btn btn-primary" value="View"></a></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-6 profile-devider">
					<div class="borrower-record">
						<div class="table-responsive">
							<table class="table">
								<tbody>
								<tr>
									<td>Education</td>
									<td><strong><?php echo $list['borrower_qualification']; ?></strong></td>
								</tr>
								<tr>
									<td>Purpose of Loan</td>
									<td>
										<strong> <?php echo $list['loan_description']; ?></strong>
									</td>
								</tr>
								</tbody>
							</table>
						</div>


					</div>
				</div>
			</div>
			<div class="col-md-12">
				<h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>

				<ul class="list-group">
					<?php foreach ($list['borrower_kyc_document'] AS $borrower_kyc) { ?>
						<li class="list-group-item"><i class="fa fa-check-square-o"
													   aria-hidden="true"></i> <?php echo ucfirst($borrower_kyc['docs_type']) ?>
						</li>
					<?php } ?>

				</ul>


				<div class="col-md-12">

					<div class="table-responsive">
						<table id="demo-foo-addrow" class="table table-striped table-bordered" data-page-size="100">

							<thead>
							<tr>

								<th>Document Type</th>
								<th>Image</th>
								<th>Download Doc</th>
								<th>Action</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody>

							<?
							if ($list['borrower_kyc_document']) {
								foreach ($list['borrower_kyc_document'] as $row) {

									?>
									<tr>
										<td><?= ucwords($row['docs_type']); ?></td>
										<input type="hidden" name="id" id="docname_" value="<?= $row['id']; ?>">

										<td>
											<a href="<?= base_url(); ?>assets/borrower-documents/<?= $row['docs_name'] ?>"
											   target="_blank">

												<img
													src="<?= base_url(); ?>assets/borrower-documents/<?= $row['docs_name']; ?>"
													height="100px" width="150px">
											</a>
										</td>

										<td><a href=""><a
													href="<?= base_url(); ?>assets/borrower-documents/<?= $row['docs_name'] ?>"
													target="_blank" download>download</a></td>
										<td>
											<button type="submit" id="verify" style="font-size:14px"
													onclick="myFunction(<?= $row['id']; ?>)"><i class="fa fa-check"
																								style="font-size:14px;color:green"></i>
											</button>
											<?php if ($row['verify'] == 0) {
												?>
												<button id="uncheck" style="font-size:14px"
														onclick="myFunction2(<?= $row['id']; ?>)"><i class="fa fa-close"
																									 style="font-size:14px;color:red"></i>
												</button>

												<?php
											}
											?>
											<div id="comment<?= $row['id']; ?>" style="display: none;">
												<br>

												<lable>Comments</lable>
												<br>

												<textarea class="form-control" name="v_comment"
														  id="v_comment<?= $row['id']; ?>" rows="2"
														  cols="30"></textarea>

												<button type="submit" id="submit_comment" class="btn btn-primary"
														onclick="updatecomment('<?= $row['id']; ?>','<?= $list['borrower_email']; ?>')">
													Submit
												</button>


											</div>
										</td>

										<?php
										if ($row['verify'] == 0) {
											?>
											<td>Unverified<br><?= ucwords($row['comment']); ?></td>
											<?php
										} else if ($row['verify'] == 1) {
											?>
											<td>Verified</td>
											<?php
										}
										?>
									</tr>
								<? }
							} ?>
							</tbody>
							<tfoot>

							</tfoot>
						</table>

					</div>

					<div id="wrapper">

						<div id='menu_div'>

							<div id="form_div">
								<form method="post"
									  action="<?php echo base_url(); ?>documentmanagement/borrower/add_docs_borrower"
									  id="file_form" enctype="multipart/form-data">
									<div id="file_div">
										<div class="col-md-12" style="margin-bottom: 10px;">
											<input type="file" name="file[]" style="display: inline-block;">
											<select name="docs_type[]">
												<option value=''>Select</option>
												<option value='pancard'>pancard</option>
												<option value='aadhaar'>aadhaar</option>
												<option value='voter'>voter</option>
												<option value='electricity_bill'>electricity bill</option>
												<option value='bank_statement'>bank statement</option>
												<option value='loan_aggrement'>loan aggrement</option>
											</select>
											<i class="fa fa-close"
											   style="font-size:14px;color:red; cursor: pointer; border: 1px solid #ccc; padding:3px 5px; border-radius: 3px;"
											   onclick=remove_file(this);></i>

										</div>
									</div>

									<input type="hidden" name="borrower_id" value="<?php echo $list['borrower_id']; ?>">
									<input type="hidden" name="b_borrower_id"
										   value="<?php echo $list['b_borrower_id']; ?>">
									<input type="hidden" name="application_no" value="<?php echo $list['PLRN']; ?>">
									<div class="col-md-12" style="margin-bottom: 10px;">
										<input type="button" class="btn btn-primary" onclick="add_file();"
											   value="ADD MORE">
										<input type="submit" class="btn btn-primary" name="submit" value="submit"></div>
								</form>
							</div>

						</div>
					</div>

				</div>
				<div class="col-md-12">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="personinfo">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion"
									   href="#personDetails" aria-expanded="true" aria-controls="personDetails">
										Banking Details
									</a>
								</h4>
							</div>
							<div id="personDetails" class="panel-collapse collapse in" role="tabpanel"
								 aria-labelledby="personinfo">
								<div class="panel-body">
									<div class="row">

										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Bank Name<span>:</span></label>
												<div class="col-md-9">
													<p class="form-control-static"
													   id="bank_name"><?php echo $list['bank_name'] ?></p>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">A/C<span>:</span></label>
												<div class="col-md-9">
													<p class="form-control-static"
													   id="account_number"><?php echo $list['account_number'] ?></p>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Ifsc Code<span>:</span></label>
												<div class="col-md-9">
													<p class="form-control-static"
													   id="ifsc_code"><?php echo $list['ifsc_code'] ?></p>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Bank Account
													Name<span>:</span></label>
												<div class="col-md-9">
													<p class="form-control-static"
													   id="borrower_name"><?php if ($bankaccountresponse) {
															$bresponse = json_decode($bankaccountresponse, true);
															echo $bresponse['result']['accountName'];
														} ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="residentalinfo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
									   href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										Residental Details
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
								 aria-labelledby="residentalinfo">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Address:</label>
												<div class="col-md-9">
													<p class="form-control-static"><?php echo $list['r_address'] . ' ' . $list['r_address1'] ?></p>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">City:</label>
												<div class="col-md-9">
													<p class="form-control-static"><?php echo $list['borrower_city'] ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">State:</label>
												<div class="col-md-9">
													<p class="form-control-static"><?php echo $list['r_state'] ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Post Code:</label>
												<div class="col-md-9">
													<p class="form-control-static"><?php echo $list['r_pincode']; ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
									<!--/row-->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Country:</label>
												<div class="col-md-9">
													<p class="form-control-static">India</p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="businessinfo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
									   href="#businessDetails" aria-expanded="false" aria-controls="businessDetails">
										Business Details
									</a>
								</h4>
							</div>
							<div id="businessDetails" class="panel-collapse collapse" role="tabpanel"
								 aria-labelledby="businessinfo">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Type of Business:</label>
												<div class="col-md-9"><p
														class="form-control-static"><?php echo $list['Occuption_name']; ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Monthly Income:</label>
												<div class="col-md-9"><p
														class="form-control-static"><?php echo $list['Occuption_name']; ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">


					<div class="clearfix"></div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

						<div class="table-responsive">
							<table id="example23" class="table table-bordered table-hover table-striped">
								<thead>
								<tr>
									<th>Loan No.</th>
									<th>Lender Name</th>
									<th>Rate of Interest (%)</th>
									<th>Tenure (in months)</th>
									<th>Loan Amount</th>
									<th>View Aggrement</th>
								</tr>
								</thead>
								<tbody>
								<?php if ($list['bids_by_lender']) {
									foreach ($list['bids_by_lender'] AS $bids) { ?>
										<tr>
											<td><?php echo $bids['loan_no'] ?></td>
											<td><?php echo $bids['lender_name']; ?></td>
											<td><?php echo $bids['interest_rate']; ?></td>
											<td><?php echo $bids['accepted_tenor']; ?></td>
											<td><?php echo $bids['bid_loan_amount']; ?></td>
											<td>
												<?php $aggrement = $this->Documents->getLoanaggrement($bids['loan_no']); if($aggrement){?>
												<a href="<?php echo base_url(); ?>borrower-loan-aggrement/<?= $aggrement['doc_name']?>" target="_blank">View Loanaggrement</a>
												<?} else{?>
													<form method="post" action="<?= base_url(); ?>documentmanagement/borrower/generateLoanaggrement">
														<input type="hidden" name="b_borrower_id" value="<?= $b_borrower_id; ?>">
														<input type="hidden" name="loan_no" value="<?= $bids['loan_no']; ?>">
														<input type="submit" class="btn btn-primary" name="generate_loan_aggrement" value="Generate Loanaggrement">
													</form>
												<?}?>
											</td>
										</tr>
									<?php }
								} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
</section>
<script type="text/javascript">
    function myFunction(docid) {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatedoc",
            dataType: "html",
            data: "doc_id=" + docid,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response['status'] == 1) {
                    alert(response['response']);
                    window.location.reload();

                } else {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script type="text/javascript">

    function myFunction2(docid) {
        $('#comment' + docid).show();
    }

</script>
<script type="text/javascript">
    function updatecomment(docid, email) {

        var comment = $('#v_comment' + docid).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatecomment",
            dataType: "html",
            data: "doc_id=" + docid + "&comment=" + comment + "&email=" + email,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response['status'] == 1) {
                    alert(response['response']);
                    window.location.reload();

                } else {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        var i = 0;
        $(".upload-mfile-btn").click(function () {
            i = i + 1;
            var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="docs_type[]" placeholder="Enter Document Name"/><br><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
            $('.upload-mfile').before(domElement);
        });


    });
</script>


<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
    function add_file() {
        $("#file_div").append("<div class='col-md-12' style='margin-bottom:10px; display: inline-block;'><input type='file' name='file[]' style='float: left;'><select name='docs_type[]'><option>Select</option><option value='pancard'>pancard</option><option value='aadhaar'>aadhaar</option><option value='voter'>voter</option><option value='electricity_bill'>electricity bill</option><option value='bank_statement'>bank statement</option><option value='loan_aggrement'>loan aggrement</option></select> <i class='fa fa-close' style='font-size:14px;color:red; cursor: pointer; border: 1px solid #ccc; padding:3px 5px; border-radius: 3px;' onclick=remove_file(this);></i></div>");
    }

    function remove_file(ele) {
        $(ele).parent().remove();
    }
</script>
