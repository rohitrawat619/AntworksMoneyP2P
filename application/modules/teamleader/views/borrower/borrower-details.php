<?= getNotificationHtml(); ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<section class="content-header">
	<h1>
		<?php echo $pageTitle; ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>p2padmin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Borrower List</li>
	</ol>
</section>
<div class="pad margin no-print">
	<div class="callout callout-info" style="margin-bottom: 0!important;">
		<h4><i class="fa fa-info"></i> Borrower Current Step:</h4>
		<?php echo $current_step['msg'] ?>
	</div>
</div>
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="row">
			<?php if ($list) { ?>
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
										<?php if ($list['borrower_status'] == 0) { ?>
											<input type="text" name="update_email" id="update_email"
												   class="form-control" value="<?php echo $list['borrower_email']; ?>">
											<input type="button" type="button" name="send_verification_mail"
												   id="send_verification_mail"
												   onclick="return sendVerificationlink(<?php echo $list['borrower_id']; ?>)"
												   value="Send Verification Mail">
										<? } else { ?>
											<td>Email</td>
											<td><strong><p
															id="borrower_email"><?php echo $list['borrower_email']; ?></p>
												</strong></td>
										<? } ?>

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
										<td>DOB</td>
										<td>
											<strong><?= $list['borrower_dob']; ?></strong>
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
										<td>PAN Response</td>
										<td>
											<?php if ($list['step_3'] <> 0) { ?>
												<form method="post" id="update_pan">

													<div class="col-md-12">
														<div class="col-md-6">
															<div class="form-group">
																<input type='text' name='name' placeholder="Borrower Name" value="<?=$list['Borrowername'];?>" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<input type='text' name='pan' class="form-control" placeholder="Pan No">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<input type='date' name='dob' id='dob'
																	   class="form-control">
															</div>
														</div>
														<input type='hidden' name='borrower_id'
															   value='<?= $list['borrower_id'] ?>'>
														<input type='hidden' name='b_borrower_id'
															   value=<?= $list['b_borrower_id'] ?>>
														<div class="col-md-4">
															<div class="form-group">
																<input type='button' name='submit'
																	   class="btn btn-primary" value='update' onclick="return updatepan();">
															</div>
														</div>

													</div>


												</form>
											<?php }
											if ($panresponse) {
												$presponse = json_decode($panresponse, true);
												echo $presponse['verified_data']; echo "<br>";
											} ?>
											<? if ( $list['step_3'] == 3 && $presponse['verified_data'] == "PAN format is correct and PAN number is correct matching against DOB. However, Name is Incorrect."){
                                              echo "<button class='btn btn-primary' onclick='return verifyPanstep(". $list['borrower_id'] .")'><i class='fa fa-check-square' aria-hidden='true'></i></button>";
											}?>
										</td>
									</tr>
									<tr>
										<td>E-KYC</td>
										<td><?php if($e_kyc){echo "Ekyc Done";} ?></td>
										<td><?php if($e_kyc){echo $e_kyc['aadhar_no']; } ?></td>
										<td><?php if($e_kyc){$response = json_decode($e_kyc['response'], true); echo $response['response_status']['message']; }?></td>
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
									<tr>
										<td>Experian Score</td>
										<?php
										$messqge = $experian_details['experian_response'];
//										if (stripos($messqge, "SYS100005") !== false || $current_step['msg'] == 'Experian Step is not complete') {
											?>
											<!--<td>
												<form
														action="<?php /*echo base_url() . 'teamleader/reinitiateExperian' */?>"
														method="post">
													<input type="hidden" name="borrower_id" id="borrower_id"
														   value="<?php /*echo $list['borrower_id']; */?>">
													<input type="hidden" name="b_borrower_id" id="borrower_id"
														   value="<?php /*echo $list['b_borrower_id']; */?>">
													<input type="submit" name="submit" value="submit">
												</form>
											</td>-->
											<?
//										} else {
											if ($experian_details['experian_score'] > 300) { ?>
												<td>
													<a href="<?php echo base_url() . 'teamleader/view_experian_response/' . $list['b_borrower_id']; ?>"> <?php echo $experian_details['experian_score'] ?></a>
												</td>
												<?
											} else {
												echo "<td>" . $experian_details['experian_score'] . "</td>";
//											}
										}
										?>


									</tr>
									<tr>
										<td>Experian Message</td>
										<td><?php echo $experian_details['experian_response'] ?></td>
									</tr>
									<tr>
										<td>Bank statement response</td>
										<td>
											<a target="_blank"
											   href="<?php echo base_url(); ?>teamleader/bankstatement_response/<?php echo $list['borrower_id'] ?>"><input
														type="button" class="btn btn-primary" value="View"></a>
										</td>
									</tr>
									<tr>
										<td>Appdetails</td>
										<td><a target="_blank"
											   href="<?php echo base_url(); ?>teamleader/appdetails/<?php echo $list['b_borrower_id'] ?>"><input
														type="button" class="btn btn-primary" value="View"></a></td>
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
						<?php foreach ($list['borrower_kyc_document'] as $borrower_kyc) { ?>
							<li class="list-group-item"><i class="fa fa-check-square-o"
														   aria-hidden="true"></i> <?php echo ucfirst($borrower_kyc['docs_type']) ?>
							</li>
						<?php } ?>

					</ul>

					<form action="<?php echo base_url(); ?>creditops/documentverification/add_docs_borrower"
						  method="post" enctype="multipart/form-data">
						<div class="col-md-12">

							<div class="table-responsive">
								<table id="demo-foo-addrow" class="table table-striped table-bordered"
									   data-page-size="100">

									<thead>
									<tr>

										<th>Document Type</th>
										<th>Image</th>
										<th>Response</th>
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

												<input type="hidden" name="docname" id="docname_"
													   value="<?= $row['id']; ?>">
												<td>
													<a href="<?= base_url(); ?>assets/borrower-documents/<?= $row['docs_name'] ?>"
													   target="_blank"><img
																src="<?= base_url(); ?>assets/borrower-documents/<?= $row['docs_name']; ?>"
																height="100px" width="150px"></a></td>
												<td></td>
												<td>
													<button type="submit" id="verify" style="font-size:14px"
															onclick="myFunction(<?= $row['id']; ?>)"><i
																class="fa fa-check"
																style="font-size:14px;color:green"></i>
													</button>
													<?php if ($row['verify'] == 0) {
														?>
														<button id="uncheck" style="font-size:14px"
																onclick="myFunction2(<?= $row['id']; ?>)"><i
																	class="fa fa-close"
																	style="font-size:14px;color:red"></i></button>

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

														<button type="submit" id="submit_comment"
																class="btn btn-primary"
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
							<div class="col-md-6 col-sm-4 upload-mfile">
								<div class="form-group">
									<label class="col-md-12">&nbsp;</label>
									<div class="col-md-12"><a href="javascript:" class="upload-mfile-btn"><i
													class="fa fa-plus"></i> Upload more files</a></div>
								</div>
							</div>

						</div>
						<div class="col-md-6 col-sm-4">
							<div class="form-group">
								<input type="hidden" name="borrower_id" value="<?php echo $list['borrower_id']; ?>">
								<input type="hidden" name="application_no" value="<?php echo $list['PLRN']; ?>">
								<div class="col-md-12"><input type="submit" class="btn btn-primary" name="submit"
															  value="submit"></div>
							</div>
						</div>
					</form>
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
										<!--/span-->
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">A/C<span>:</span></label>
												<div class="col-md-9">
													<p class="form-control-static"
													   id="account_number"><?php echo $list['account_number'] ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
										<!--/span-->
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
													   id="borrower_name"><?php echo $list['bank_registered_name'] //if ($bankaccountresponse) { $bresponse = json_decode($bankaccountresponse, true); echo $bresponse['result']['accountName'];} ?>
													</p>
												</div>
											</div>
										</div>
										<div class="col-md-6" id="verify_banking">
											<div class="form-group">
												<label class="control-label col-md-3">Bank Verified<span>:</span></label>
												<div class="col-md-9">
													<? if($list['is_bank_verified'] == 0){ ?>
														<input type="button" name="verify_bank" id="verify_bank"
															   class="btn btn-primary" value="Verify BANK"
															   onclick="return verifyBank(<?php echo $list['borrower_id'] ?>)">
													<? }
													if ($list['is_bank_verified'] == 1){ echo "Bank is verified"; }?>
												</div>
											</div>
										</div>
										<div class="col-md-6" id="initiate_enach">
											<div class="form-group">
												<label class="control-label col-md-3">Initiate
													E-nach<span>:</span></label>
												<div class="col-md-9">
													<input type="button" name="e_nach" id="e_nach"
														   class="btn btn-primary" value="Initiate E-nach"
														   onclick="return ititiateEnach(<?php echo $list['borrower_id'] ?>)">
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
															class="form-control-static"><?php echo $list['occuption_details']['net_monthly_income']; ?></p>
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="applicationinfo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
									   href="#applicationDetails" aria-expanded="false"
									   aria-controls="applicationDetails">
										Application Details
									</a>
								</h4>
							</div>
							<div id="applicationDetails" class="panel-collapse collapse" role="tabpanel"
								 aria-labelledby="applicationinfo">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="table-responsive">
													<table id="example23"
														   class="table table-bordered table-hover table-striped">
														<thead>
														<tr>
															<th>Application No.</th>
															<th>Loan Applied Date</th>
															<th>Loan Amount</th>
															<th>Rate of Interest</th>
															<th>Tenure</th>

														</tr>
														</thead>
														<tbody>

														<tr>
															<td><?php echo $list['PLRN'] ?></td>
															<td><?php echo $list['date_added']; ?></td>
															<td><?php echo $list['loan_amount']; ?></td>
															<td><?php echo $list['min_interest_rate']; ?></td>

															<td><?php echo $list['tenor_months']; ?></td>
														</tr>

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="businessinfo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
									   href="#borrowerRequestdetails" aria-expanded="false"
									   aria-controls="borrowerRequestdetails">
										Borrower Requests
									</a>
								</h4>
							</div>
							<div id="borrowerRequestdetails" class="panel-collapse collapse" role="tabpanel"
								 aria-labelledby="borrowerRequestdetail">
								<div class="panel-body">
									<div class="row">
										<!--/span-->
										<div class="col-md-12">
											<div class="form-group">
												<div class="table-responsive">
													<table id="example23"
														   class="table table-bordered table-hover table-striped">
														<thead>
														<tr>
															<th>SN</th>
															<th>Type</th>
															<th>Request</th>
															<th>Action</th>
														</tr>
														</thead>
														<tbody>
														<?php $i = 1;
														foreach ($borrower_requests as $borrower_request) {
															$requestdata = json_decode($borrower_request['address_data'], true);
															?>
															<tr>
																<td><?= $i; ?></td>
																<td><?= "Address"; //echo $borrower_request['type'];   ?></td>
																<td><?php foreach ($requestdata as $key => $request) {
																		echo $key . '-' . $request . ' ,<br>';
																	} ?></td>
																<td>
																	<button type="button" class="btn btn-primary"
																			onclick="return acceptborrowerRequest(<?= $borrower_request['id'] ?>, <?= $borrower_request['borrower_id'] ?>)">
																		<i class="fa fa-check" aria-hidden="true"></i>
																	</button>
																</td>
															</tr>
															<?php $i++;
														} ?>
														</tbody>
													</table>
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
									<th>Application No.</th>
									<th>Loan No.</th>
									<th>Lender Name</th>
									<th>Loan Applied Date</th>
									<th>Loan Amount</th>
									<th>Rate of Interest</th>
									<th>EMI Amount</th>
									<th>Tenure</th>
									<th>City</th>
									<th>Approved Loan Amount</th>
									<th>Response</th>
									<th>Time Remaining</th>
									<th>Status</th>
									<th>View Aggrement</th>
								</tr>
								</thead>
								<tbody>
								<?php if ($list['bids_by_lender']) {
									foreach ($list['bids_by_lender'] as $bids) { ?>
										<tr>
											<td><?php echo $list['PLRN'] ?></td>
											<td><?php echo $bids['loan_no'] ?></td>
											<td><?php echo $bids['lender_name']; ?></td>
											<td><?php echo $list['date_added']; ?></td>
											<td><?php echo $list['loan_amount']; ?></td>
											<td><?php echo $list['min_interest_rate']; ?></td>
											<td><?php echo $bids['loan_amount']; ?></td>
											<td><?php echo $list['tenor_months']; ?></td>
											<td><?php echo $list['borrower_city']; ?></td>
											<td><?php echo $bids['bid_loan_amount']; ?></td>
											<td>
												<div class="progress">
													<div class="progress-bar" role="progressbar" aria-valuenow="70"
														 aria-valuemin="0" aria-valuemax="100"
														 style="width:<?= $bids['loan_amount'] ?>%">
														<?= $bids['loan_amount'] ?>%
													</div>
												</div>
											</td>
											<td><?php
												$loan_date = date('Y-m-d', strtotime($list['date_added']));
												$date = new DateTime($loan_date);
												$date->modify("+14 day");
												$future_14_days = $date->format("Y-m-d");

												$current_date = date('Y-m-d');

												$seconds = strtotime($future_14_days) - strtotime($current_date);

												echo $days = floor($seconds / 86400);

												?> Days
											</td>
											<td>
												<?php if ($bids['bid_status_name'] == 1) { ?>
													<form action="<?php echo base_url(); ?>creditops/accept_bid"
														  method="post">
														<input type="hidden" name="application_no"
															   value="<?php echo $list['PLRN'] ?>">
														<input type="hidden" name="bid_registration_id"
															   value="<?php echo $bids['bid_registration_id'] ?>">
														<input type="submit" name="accept" value="Accept"
															   class="btn btn-success m-r">
													</form>
												<?php } else {
													echo $bids['bid_status_name'];
												} ?>


											</td>
											<td></td>
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
<div id="script_razorpay"></div>
