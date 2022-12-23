<?=getNotificationHtml();?>
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
                        <tr>
                            <td>Experian Credit Score</td>
                            <td><strong></strong></td>
                        </tr>
                        <tr>
                            <td>Antworks Rating</td>
                            <td><strong></strong></td>
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
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table id="demo-foo-addrow" class="table table-striped table-bordered" data-page-size="100">

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
                            if($doc){ foreach($doc as $row){

                                ?>
                                <tr>
                                    <td><?=ucwords($row['docs_type']);?></td>

                                    <input type="hidden" name="docname" id="docname_" value="<?=$row['id'];?>">
                                    <td><a href="<?=base_url();?>assets/borrower-documents/<?=$row['docs_name']?>" target="_blank"><img src="<?=base_url();?>assets/borrower-documents/<?=$row['docs_name'];?>" height="100px" width="150px"></a></td>
                                    <td></td>
                                    <td>
                                        <?php if($row['verify'] == 0){
                                            ?>
                                            <button type="submit" id="verify" style="font-size:14px" onclick="myFunction(<?=$row['id'];?>)"><i class="fa fa-check"  style="font-size:14px;color:green"></i></button>

                                            <button id="uncheck" style="font-size:14px" onclick="myFunction2(<?=$row['id'];?>)"><i class="fa fa-close" style="font-size:14px;color:red"></i></button>

                                            <?php
                                        }else{
                                            echo "Verified";
                                        }
                                        ?>
                                        <div id="comment<?=$row['id'];?>" style="display: none;">
                                            <br>

                                            <lable>Comments</lable>
                                            <br>

                                            <textarea  class="form-control" name="v_comment" id="v_comment<?=$row['id'];?>" rows="2" cols="30" ></textarea>

                                            <button type="submit" id="submit_comment" class="btn btn-primary" onclick="updatecomment('<?=$row['id'];?>','<?=$list['borrower_email'];?>')">Submit</button>


                                        </div>
                                    </td>

                                    <?php
                                    if($row['verify'] == 0)
                                    {
                                        ?>
                                        <td>Unverified<br><?=ucwords($row['comment']);?></td>
                                        <?php
                                    }
                                    else if($row['verify'] == 1) {
                                        ?>
                                        <td>Verified</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            <? }}?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>

                    </div>
                    <form action="<?php echo base_url(); ?>creditops/documentverification/add_docs_borrower" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-4 upload-mfile">
                        <div class="form-group">
                            <label class="col-md-12">&nbsp;</label>
                            <div class="col-md-12"><a href="javascript:" class="upload-mfile-btn"><i class="fa fa-plus"></i> Upload more files</a></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-4">
                    <div class="form-group">
                        <input type="hidden" name="borrower_id" value="<?php echo $list['borrower_id']; ?>">
                        <input type="hidden" name="application_no" value="<?php echo $list['PLRN']; ?>">
                        <div class="col-md-12"><input type="submit" class="btn btn-primary" name="submit" value="submit"></div>
                    </div>
                </div>
            </form>
        </div>
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

                <th>Status</th>
                <th>View Aggrement</th>
            </tr>
            </thead>
            <tbody>
            <?php if($list['bids_by_lender']){foreach ($list['bids_by_lender'] AS $bids){?>
            <tr>
                <td><?php echo $list['PLRN'] ?></td>
                <td><?php echo $list['loan_no'] ?></td>
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
                <!--<td><?php
/*                    $loan_date = date('Y-m-d', strtotime($list['date_added']));
                    $date = new DateTime($loan_date);
                    $date->modify("+14 day");
                    $future_14_days = $date->format("Y-m-d");

                    $current_date = date('Y-m-d');

                    $seconds = strtotime($future_14_days) - strtotime($current_date);

                    echo $days    = floor($seconds / 86400);

                    */?> Days</td>-->
                <td>
                    <?php if($bids['bid_proposal_status'] == 1){?>
                        <form action="<?php echo base_url(); ?>creditops/accept_bid" method="post">
                            <input type="hidden" name="application_no" value="<?php echo $list['PLRN'] ?>">
                            <input type="hidden" name="bid_registration_id" value="<?php echo $bids['bid_registration_id'] ?>">
                            <input type="submit" name="accept" value="Accept" class="btn btn-success m-r">
                        </form>
                    <?php } else{
                        echo 'Accepted';
                    }?>


                </td>
                <td></td>
            </tr>
            <?php }} ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php } ?>

<script type="text/javascript">
    function myFunction(docid)
    {
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatedoc",
            dataType: "html",
            data: "doc_id="+docid,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if(response['status'] == 1)
                {
                    alert(response['response']);
                    window.location.reload();

                }
                else
                {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script type="text/javascript">

    function myFunction2(docid)
    {
        $('#comment'+docid).show();
    }

</script>
<script type="text/javascript">
    function updatecomment(docid,email)
    {

        var comment =  $('#v_comment'+docid).val();
        $.ajax({
            type: "POST",
            url: "<?=base_url();?>p2padmin/documentverification/updatecomment",
            dataType: "html",
            data: "doc_id="+docid +"&comment="+comment+"&email="+email,
            async: false,
            success: function (data) {
                var response = JSON.parse(data);
                if(response['status'] == 1)
                {
                    alert(response['response']);
                    window.location.reload();

                }
                else
                {
                    alert(response['response']);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        var i=0;
        $(".upload-mfile-btn").click(function() {
            i=i+1;
            var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="doc_name[]" placeholder="Enter Document Name"/><br><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
            $('.upload-mfile').before(domElement);
        });



    });
</script>
