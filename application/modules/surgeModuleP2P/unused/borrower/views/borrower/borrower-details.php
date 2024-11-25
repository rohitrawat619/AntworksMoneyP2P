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
        <h4><i class="fa fa-info"></i> Borrower Basic Filter:</h4>
        <table>
            <tr>
                <? if ($basic_response['dob'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                AGE
            </tr>
            <tr>
                <? if ($basic_response['pincode'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Pincode
            </tr>
            <tr>
                <? if ($basic_response['Qualification'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Qualification
            </tr>
            <tr>
                <? if ($basic_response['Occupation'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Occupation
            </tr>
            <tr>
                <? if ($basic_response['Company'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Company
            </tr>
            <tr>
                <? if ($basic_response['salary'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Salary
            </tr>
            <tr>
                <? if ($basic_response['credit_score'] == 1) {
                    echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-window-close-o" aria-hidden="true"></i>';

                }
                ?>
                Credit Score
            </tr>
        </table>
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
                                    <td>Email</td>
                                    <td><strong><p id="borrower_email"><?php echo $list['borrower_email']; ?></p>
                                        </strong></td>
                                    <?php /*if ($list['borrower_status'] == 0) { */ ?><!--
											<input type="text" name="update_email" id="update_email"
												   class="form-control" value="<?php /*echo $list['borrower_email']; */ ?>">
											<input type="button" type="button" name="send_verification_mail"
												   id="send_verification_mail"
												   onclick="return sendVerificationlink(<?php /*echo $list['borrower_id']; */ ?>)"
												   value="Send Verification Mail">
										<? /* } else { */ ?>
											<td>Email</td>
											<td><strong><p
															id="borrower_email"><?php /*echo $list['borrower_email']; */ ?></p>
												</strong></td>
										--><? /* } */ ?>

                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td><strong><p id="borrower_mobile"><?php echo $list['borrower_mobile']; ?></p>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td>Employment</td>
                                    <td><strong><?php echo $list['occuption_id']; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td>
                                        <strong>
                                            <? if ($list['dob']) {
                                                echo(date('Y') - date('Y', strtotime($list['dob'])));
                                            } ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>DOB</td>
                                    <td>
                                        <strong><?= $list['dob']; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><strong><?= $list['gender'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>PAN Details</td>
                                    <td><strong><?= $list['pan'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Pan Status</td>
                                    <td><strong><?= $panresponse['status'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Pan Match</td>
                                    <td>
                                        <strong><?= $panresponse['name_match'] == 1 ? 'Pan Name Match' : 'Pan name not match or invalid pan'; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pan API Name</td>
                                    <td>
                                        <strong><?= $panresponse['name']; ?></strong>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td>Name match ?</td>
                                    <td>
                                        <strong><?/* if ($panresponse['name'] == $list['bank_registered_name'] && $panresponse['name'] == $panresponse['name'] && $panresponse['name'] == $list['bank_registered_name']){ echo "Name Match successfully"; } */?></strong>
                                    </td>
                                </tr>-->
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
                                    <td><strong><?php echo $list['highest_qualification']; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Experian Score</td>
                                    <?php
                                    $messqge = $experian_details['experian_response'];
                                    //										if (stripos($messqge, "SYS100005") !== false || $current_step['msg'] == 'Experian Step is not complete') {
                                    ?>
                                    <!--<td>
                                        <form
                                                action="<?php echo base_url() . 'p2padmin/p2pborrower/reinitiateExperian' ?>"
                                                method="post">
                                            <input type="hidden" name="borrower_id" id="borrower_id"
                                                   value="<?php echo $list['borrower_id']; ?>">
                                            <input type="hidden" name="b_borrower_id" id="borrower_id"
                                                   value="<?php echo $list['b_borrower_id']; ?>">
                                            <input type="submit" name="submit" value="submit">
                                        </form>
                                    </td>-->
                                    <?
									
                                    //										} else {
                                    if ($experian_details['experian_score'] > 300) { ?>
                                        <td>
                                            <a href="<?php echo base_url() . 'p2padmin/p2pborrower/view_experian_response/' . $list['b_borrower_id']; ?>"> <?php echo $experian_details['experian_score'] ?></a>
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
                                    <td>Address</td>
                                    <td><?php echo $list['r_address'] . ' ' . $list['r_address1'] ?></td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><?php echo $list['r_city']; ?></td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><?php echo $list['r_state_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Pincode</td>
                                    <td><?php echo $list['r_pincode']; ?></td>
                                </tr>
                                <tr>
                                    <p class="form-control-static"
                                       id="borrower_name">  <?php if ($bankaccountresponse) {
                                            $bresponse = json_decode($bankaccountresponse, true);
//                                            pr($bresponse);
                                            echo $bresponse['result']['registered_name'];
                                        } //echo $list['bank_registered_name']  ?>
                                    </p>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <? if ($steps['step_1'] == 2){ ?>
            <div class="col-md-12">
                <div class="col-md-12">
                    <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>"
                          enctype="multipart/form-data">
                        <div class="col-md-4 form-group">
                            <input type="file" name="borrower_pan" id="borrower_pan" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="text" name="remarks" class="form-control" placeholder="Remarks" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="hidden" name="step" value="step_1">
                            <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                            <input type="submit" name="submit_pan" value="Update PAN" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                <?
                } ?>

                <? if ($steps['step_8'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_8">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_video_kyc" class="btn btn-primary"
                                           value="Reinitiate Video KYC">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">-OR-</div>
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_8">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="skip_video_kyc" class="btn btn-primary"
                                           value="Skip Reinitiate Video KYC">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <? if ($steps['step_2'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="text" name="remarks" class="form-control" placeholder="Remarks"
                                           required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_2">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="skip_step_2" class="btn btn-primary"
                                           value="Skip Credit Decision">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">-OR-</div>
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_2">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_credit_decisioning" class="btn btn"
                                           value="Reinitiate Credit Decisioning">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <? if ($steps['step_3'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_3">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_e_nach" class="btn btn-primary"
                                           value="Reinitiate Enach">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">-OR-</div>
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="text" name="remarks" class="form-control" placeholder="Remarks"
                                           required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_3">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="skip_enach" class="btn btn-primary"
                                           value="Skip Enach">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <? if ($steps['step_4'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_4">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_loan_aggrement" class="btn btn-primary"
                                           value="Reinitiate Loan Aggrement">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <? if ($steps['step_5'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_5">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_e_sign" class="btn btn-primary"
                                           value="Reinitiate E-sign">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <? if ($steps['step_6'] == 2) { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url('p2padmin/p2pborrower/action_update_steps') ?>">
                                <div class="col-md-4 form-group">
                                    <input type="hidden" name="step" value="step_6">
                                    <input type="hidden" name="borrower_id" value="<?= $list['borrower_id']; ?>">
                                    <input type="submit" name="reinitiate_e_sign" class="btn btn-primary"
                                           value="Reinitiate E-sign">
                                </div>
                            </form>
                        </div>
                    </div>
                <? } ?>

                <div class="col-md-12">
                    <h3>Credit Decision Response</h3>
                    <table class="table table-bordered">
                         <tr>
                             <td>CreditCategory</td>
                             <td><?=($credit_decision_response['CreditCategory'])?$credit_decision_response['CreditCategory']:'Not Found'?></td>
                         </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <h3>Bank Details</h3>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Bank Name</strong></td>
                            <td><?php echo $list['bank_name'] ?></td>
                            <td><strong>A/C</strong></td>
                            <td><?php echo $list['account_number'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Ifsc Code</strong></td>
                            <td><?php echo $list['ifsc_code'] ?></td>
                            <td><strong>Bank Account Name</strong></td>
                            <td><?php echo $list['bank_registered_name'] //if ($bankaccountresponse) { $bresponse = json_decode($bankaccountresponse, true); echo $bresponse['result']['accountName'];} ?></td>
                        </tr>
                    </table>
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
                <?php } ?>
            </div>
        </div>
</section>
<div id="script_razorpay"></div>
