<div class="mytitle row">
    <div class="left col-md-6">
        <h1><?=$pageTitle;?></h1>
        <p>Please check below to information.</p>
    </div>
</div>
<?php if($list){?>
<div class="white-box prsnl-dtls">
    <h3 class="borrower-prof-hd"><i class="ti-user"></i> Profile Summary</h3>
    <div class="row">
        <div class="col-md-6 profile-devider">
            <div class="borrower-record">
                <div class="table-responsive">
                    <table class="table bdr-rite">
                        <tbody><tr>
                            <td>Employment</td>
                            <td><strong><?php echo $list['Occuption_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td><strong><?=(date('Y')-date('Y',strtotime($list['borrower_dob'])));?></strong></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><strong><?php if($list['borrower_gender'] == 1) {echo "Male";} else{ echo "Female";} ?></strong></td>
                        </tr>
                        <tr>
                            <td>Residence Type</td>
                            <td><strong>Residential</strong></td>
                        </tr>
                        <tr>
                            <td>Marital Status</td>
                            <td><strong><?php if($list['marital_status'] == 1) {echo "Unmarried";} else{ echo "Married";} ?></strong></td>
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
                            <td><strong><?php echo $list['borrower_qualification']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Purpose of Loan</td>
                            <td>
                                <strong> <?php echo $list['loan_description']; ?></strong>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="white-box prsnl-dtls">
    <h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>
    <div class="row">
        <ul class="documnt-verify">
            <?php foreach ($list['borrower_kyc_document'] AS $borrower_kyc){?>
                <li><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo ucfirst($borrower_kyc['docs_type']) ?></li>
           <?php } ?>

        </ul>


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
                                        <label class="control-label col-md-3">Name<span>:</span></label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $list['Borrowername'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Gender<span>:</span></label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php if($list['borrower_gender'] == 1) {echo "Male";} else{ echo "Female";} ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date of Birth<span>:</span></label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $list['borrower_dob'] ?></p>
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
                                            <p class="form-control-static"><?php echo $list['borrower_email'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Mobile<span>:</span></label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $list['borrower_mobile'] ?></p>
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
                                            <p class="form-control-static"><?php echo $list['r_address'].' '.$list['r_address1'] ?></p>
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
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#businessDetails" aria-expanded="false" aria-controls="businessDetails">
                                Business Details
                            </a>
                        </h4>
                    </div>
                    <div id="businessDetails" class="panel-collapse collapse" role="tabpanel" aria-labelledby="businessinfo">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Type of Business:</label>
                                        <div class="col-md-9"><p class="form-control-static"><?php echo $list['Occuption_name']; ?></p></div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Monthly Income:</label>
                                        <div class="col-md-9"><p class="form-control-static"><?php echo $list['Occuption_name']; ?></p></div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="white-box prsnl-dtls">
<div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

    <div class="table-responsive">
        <table id="example23" class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
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
            </tr>
            </thead>
            <tbody>
            <?php if($list['bids_by_lender']){foreach ($list['bids_by_lender'] AS $bids){?>
            <tr>
                <td><?php echo $list['PLRN'] ?></td>
                <td><?php echo $bids['lender_name']; ?></td>
                <td><?php echo $list['date_added']; ?></td>
                <td><?php echo $list['loan_amount']; ?></td>
                <td><?php echo $list['min_interest_rate']; ?></td>
                <td><?php echo $bids['loan_amount']; ?></td>
                <td><?php echo $list['tenor_months']; ?></td>
                <td><?php echo $list['borrower_city']; ?></td>
                <td><?php echo $bids['bid_loan_amount']; ?></td>
                <td><div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70"
                             aria-valuemin="0" aria-valuemax="100" style="width:<?=$bids['loan_amount']?>%">
                            <?=$bids['loan_amount']?>%
                        </div>
                    </div></td>
                <td><?php
                    $loan_date = date('Y-m-d', strtotime($list['date_added']));
                    $date = new DateTime($loan_date);
                    $date->modify("+14 day");
                    $future_14_days = $date->format("Y-m-d");

                    $current_date = date('Y-m-d');

                    $seconds = strtotime($future_14_days) - strtotime($current_date);

                    echo $days    = floor($seconds / 86400);

                    ?> Days</td>
                <td><a href="#" class="btn btn-success m-r">Accept</a><a href="#" class="btn btn-mainnxt">Decline</a></td>
            </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
</div>

</div>
<?php } ?>

