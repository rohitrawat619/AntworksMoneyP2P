<div class="mytitle row">
		<div class="left col-md-6">
			<h1><?=$pageTitle;?></h1>
			<p>Please check below to your profile information.</p>
		</div>
	</div>
	
	<div class="white-box prsnl-dtls">
		<h3 class="borrower-prof-hd"><i class="ti-user"></i> Profile Summary</h3>
		<div class="row">
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table bdr-rite">
							<tbody><tr>
								<td>Employment</td>
								<td><strong><?php echo $borrower_info['occuption_name']; ?></strong></td>
							</tr>
							<tr>
								<td>Age</td>
								<td><strong><?php echo $borrower_info['age']; ?> years</strong></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><strong><?php if($borrower_info['gender'] == 1){echo "Male";}else if($borrower_info['gender'] == 2){echo "Female";} else{echo "Others";} ?></strong></td>
							</tr>
							<tr>
								<td>Residence Type</td>
								<td><select class="form-control" name="residence_type" id="residence_type">
                                        <option value="">--Select--</option>
                                        <option value="3">Rented</option>
                                        <option value="6">Company provided</option>
                                        <option value="7">Self Owned</option>
                                        <option value="8">Owned by Spouse</option>
                                        <option value="9">Owned by Parents</option>
                                        <option value="10">Other</option>
                                    </select></td>
							</tr>
							<tr>
								<td>Marital Status</td>
								<td><strong><?php if($borrower_info['gender'] == 1){echo "Married";}else{echo "Unmarried";} ?></strong></td>
							</tr>
							<tr>
								<td>No. of Dependents</td>
								<td><select class="form-control" name="residence_type" id="residence_type">
                                        <option value="">--Select--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">More than 5</option>
                                    </select>
                                </td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table">
							<tbody><tr>
								<td>Education</td>
								<td><strong><?php echo $borrower_info['qualification']; ?></strong></td>
							</tr>
							<tr>
								<td>Designation</td>
								<td><input type="text" name="designation" id="designation" class="form-control"></td>
							</tr>
							<tr>
								<td>Co. Name</td>
								<td><strong><?php echo $occuptionDetails['company_name'] ?></strong></td>
							</tr>
							<tr>
								<td>Current Job<br> Stability
								</td>
								<td><strong><select class="form-control" name="residence_type" id="residence_type">
                                            <option value="">--Select--</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                            <option value="11">More than 10 Years</option>
                                        </select></strong></td>
							</tr>
							<tr>
								<td>Purpose of Loan</td>
								<td>
									<div class="col-md-9">
										<?php echo $currentopen_proposal['loan_description']; ?>
									</div>
								</td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
			<div class="col-md-3 hidden">
				<div class="strength-risk">
					<div class="strenght-area">
						<h3 class="title">
							Strengths <i class="fa fa-plus" aria-hidden="true"></i>
						</h3>
						<ul>
							<li>Parental House</li>
							<li>Business is registered</li>
							<li>Less number of enquiries</li>
							<li>Good average monthly balance</li>
						</ul>
					</div>
					<div class="strenght-area risk">
						<h3 class="title">
							Risk <i class="fa fa-minus" aria-hidden="true"></i>
						</h3>
						<ul>
							<li>High expenditure to income ratio</li>
							<li>Business premises is rented</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>

	<div class="white-box prsnl-dtls">
            <div class="row">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="personinfo">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#personDetails" aria-expanded="true" aria-controls="personDetails">
                                    Person Details
                                </a>
                            </h4>
                        </div>
                        <div id="personDetails" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="personinfo">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Full Name<span>:</span></label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['Borrower_name']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Gender<span>:</span></label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php if($borrower_info['gender'] == 1){echo "Male";}else if($borrower_info['gender'] == 2){echo "Female";} else{echo "Others";} ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Date of Birth<span>:</span></label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['dob']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email<span>:</span></label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Mobile<span>:</span></label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['mobile']; ?></p>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Residental  Details
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="residentalinfo">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Address:</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['r_address']. ' '.$borrower_info['r_address1']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">City:</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['r_city']; ?></p>
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
                                                <p class="form-control-static"><?php echo $borrower_info['state_name']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Post Code:</label>
                                            <div class="col-md-9">
                                                <p class="form-control-static"><?php echo $borrower_info['r_pincode']; ?></p>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#businessDetails" aria-expanded="false" aria-controls="businessDetails">
                                    Occuption Details
                                </a>
                            </h4>
                        </div>
                        <div id="businessDetails" class="panel-collapse collapse" role="tabpanel" aria-labelledby="businessinfo">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Type of Business:</label>
                                            <div class="col-md-9"><p class="form-control-static"><?php echo $borrower_info['occuption_name']; ?></p></div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Annual Salary:</label>
                                            <div class="col-md-9"><p class="form-control-static"><?php echo $occuptionDetails['net_monthly_income'] ?></p></div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
			<h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>
			<div class="row">
				<ul class="documnt-verify">
                    <?php foreach($kycDoctype AS $doctype){?>

                        <li><i class="fa fa-check-square-o" aria-hidden="true"></i><?php echo str_replace('_', ' ', $doctype['docs_type']) ?></li>
                    <?php } ?>

					
				</ul>
                <form method="post" action="<?php echo base_url(); ?>borrowerprocess/confirm_profile_confirmation">
                <button type="submit" name="live_listing" id="live_listing" class="btn btn-primary pull-right">Live Listing</button>
                </form>



			</div>
		</div>
	
	
	