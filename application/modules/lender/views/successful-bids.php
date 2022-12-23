<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
        <?=getNotificationHtml();?>
    </div>
</div>

<div class="white-box">
    <div class="col-md-12">
        <div class="col-md-12 col-sm-12 col-xs-12 m-t-30">

            <div class="table-responsive">
                <table id="example23" class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Loan No.</th>
                        <th>Borrower Name</th>
                        <th>Amount</th>
                        <th>Tenor</th>
                        <th>Rate of Interest</th>
                        <th>Bidding Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($successfullbids){foreach($successfullbids AS $bidding){?>
                        <tr>
                            <form action="<?php echo base_url(); ?>lenderaction/acceptance_lender" method="post">
                                <td><?php echo $bidding['loan_no']; ?></td>
                                <td><?php echo $bidding['borrower_name']; ?></td>
                                <td><?php echo $bidding['bid_loan_amount']; ?></td>
                                <td><?php echo $bidding['accepted_tenor']; ?></td>
                                <td><?php echo $bidding['interest_rate']; ?>%</td>
                                <td><?php echo $bidding['proposal_added_date']; ?></td>
                                <td>
                                    <?php if($bidding['borrower_signature'] == 0){?>
                                       Borrower didn't signature this proposal
                                    <?}?>
                                    <?php if($bidding['lender_signature'] == 0 && $bidding['borrower_signature'] == 1){?>
                                        <button class="btn btn-primary" type="button" value="<?php echo $bidding['bid_registration_id']; ?>" onclick="getLoanaggrement(this.value)">Accept Aggrement</button>
                                    <?php }  ?>
                                    <?php if($bidding['lender_signature'] == 1){?>
                                        <button class="btn btn-primary" type="button" value="<?php echo $bidding['bid_registration_id']; ?>" onclick="getLoanaggrement_copies(this.value)">View Loan Aggrement</button>
                                    <?php } ?>
                                </td>
                            </form>
                        </tr>
                    <?php }} else{
                        echo "<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>No Bid received</td>
                    </tr>";
                    }?>
                    <tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    </div>
<div class="white-box">
        <div class="col-md-12 m-t-40 collapse loanagreement" id="loanagreement" style="display: inline-block">

        </div>
        <div id="action" style="display: none;">
            <input type='hidden' name='bid_registration_id' id='bid_registration_id' value='<?= $this->input->post('bid_registration_id') ?>'>
            <input type='button' class='btn btn-primary' id='accept_loan_aggrement' value='Accept' onclick='accept_loan_aggrement()'>
            <input type='button' class='btn btn-primary' id='reject_loan_aggrement' value='Reject'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <input type='text' class='form-control' name='loan_aggrement_otp' id='loan_aggrement_otp' onkeyup='verify_otp_loan_aggrement(this.value)' placeholder='Submit Valid OTP'  style='display: none'>
                <div id='otp_validation_error'></div>
            </div>
            <input type='button' class='btn btn-primary' id='resent_otp' value='Resent Otp' onclick='accept_loan_aggrement()' style='display: none'>
        </div>
    <!-- Loan Aggrement Copies -->
    <div class="col-md-12 m-t-40 collapse loanagreement_copies" id="loanagreement_copies" style="display: inline-block">

    </div>
    </div>
    <script>
        function getLoanaggrement(bid_registration_id) {
            if ($('#loanagreement').is(':empty')){
                $("#loanagreement").html("");
                $("#loanagreement_copies").html("");
                $("#action").hide();
                $("#bid_registration_id").val(bid_registration_id);
                $.ajax({
                    async: true,
                    type: "POST",
                    url: baseURL+"loanaggrement/generateLoanaggrement",
                    data: {bid_registration_id:bid_registration_id},
                    success: function (data) {
                        var aggrement_json_parse = JSON.parse(data);

                        if(aggrement_json_parse['status'] == 1)
                        {
                            $("#loanagreement").html(aggrement_json_parse['agreement']);
                            $("#action").show();

                        }
                        if(aggrement_json_parse['status'] == 2)
                        {
                            $("#action").hide();
                            alert('No Record Found');
                        }
                        if(aggrement_json_parse['status'] == 0)
                        {
                            $("#action").hide();
                            window.location.reload();
                        }
                    }
                });
            }
            else{
                $("#action").hide();
                $("#loanagreement").html("");
            }

        }
        function getLoanaggrement_copies(bid_registration_id) {
            if ($('#loanagreement_copies').is(':empty')){
                $("#loanagreement_copies").html("");
                $("#loanagreement").html("");
                $("#action").hide();
                $("#bid_registration_id").val(bid_registration_id);
                $.ajax({
                    async: true,
                    type: "POST",
                    url: baseURL+"loanaggrement/generateLoanaggrement",
                    data: {bid_registration_id:bid_registration_id},
                    success: function (data) {
                        var aggrement_json_parse = JSON.parse(data);

                        if(aggrement_json_parse['status'] == 1)
                        {
                            $("#loanagreement_copies").html(aggrement_json_parse['agreement']);

                        }
                        if(aggrement_json_parse['status'] == 2)
                        {
                            $("#action").hide();
                            alert('No Record Found');
                        }
                        if(aggrement_json_parse['status'] == 0)
                        {
                            $("#action").hide();
                            window.location.reload();
                        }
                    }
                });
            }
            else{
                $("#action").hide();
                $("#loanagreement_copies").html("");
            }
        }
    </script>

    <script>
        function accept_loan_aggrement() {
            var bid_registration_id = $("#bid_registration_id").val();
            $.ajax({
                async: true,
                type: "POST",
                url: baseURL+"lenderaction/sendotpSignatuereaccept",
                data: {bid_registration_id:bid_registration_id},
                success: function (data) {
                    if(data == 2)
                    {
                        $("#otp_validation_error").html('<p style="color: red">You aready tried 3 times please try after 10 min.</p>')
                        $("#accept_loan_aggrement").hide();
                        $("#reject_loan_aggrement").hide();
                        $("#loan_aggrement_otp").hide();
                        $("#resent_otp").hide();
                    }
                    else{
                        $("#accept_loan_aggrement").hide();
                        $("#reject_loan_aggrement").hide();
                        $("#loan_aggrement_otp").show();
                        $("#resent_otp").show();
                    }

                }
            });
        }
    </script>

    <script>
    function verify_otp_loan_aggrement(otp) {
        if(otp.length==6){
            var bid_registration_id = $("#bid_registration_id").val();
            $.ajax({
                type: "POST",
                url: baseURL+"lenderaction/verify_signature/",
                data: {otp:otp,bid_registration_id:bid_registration_id, aggree:true},
                async: true,
                success: function (data) {
                    result = JSON.parse(data);
                    if(result['response'] == "Not")
                    {
                        $("#otp_validation_error").html('<p style="color: red">OTP Not Verified</p>');
                    }
                    if(result['response'] == "Expired"){

                        $("#otp_validation_error").html('<p style="color: red">OTP Expired, Please Resend and try again</p>');
                    }
                    if(result['response'] == "verify"){
                        $('#loan_aggrement_otp').attr("readonly", true);
                        $("#resent_otp").hide();
                        window.location.href= '<?php echo base_url(); ?>lender/successfullbids';
                    }
                }
            });
        }


    }
</script>
