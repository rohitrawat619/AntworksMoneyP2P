<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
        <?=getNotificationHtml();?>
    </div>
</div>


<div class="white-box">
    <div class="col-md-12">
    </div>
    <div class="col-md-12">
        <div class="table-responsive kyc-main">
            <table class="table m-t-30 table-bordered kyc-main">
                <tr>
                    <th>PLRN No.</th>
                    <th>Lender Name.</th>
                    <th>Amount</th>
                    <th>Rate of Interest</th>
                    <th>Action</th>
                </tr>
                <?php if($approved_info){foreach($approved_info AS $bidding){?>
                    <tr>
                        <form action="<?php echo base_url(); ?>borroweraction/accept_borrower_signature" method="post">
                            <td><?php echo $bidding['PLRN']; ?></td>
                            <td><?php echo $bidding['lender_name']; ?></td>
                            <td><?php echo $bidding['bid_loan_amount']; ?></td>
                            <td><?php echo $bidding['interest_rate']; ?>%</td>
                            <td>
<!--                                <input type="hidden" name="bid_registration_id" id="bid_registration_id" value="--><?php //echo $bidding['bid_registration_id']; ?><!--">-->
<!--                                <input type="submit" name="aggree" id="aggree--><?php //echo $bidding['bid_registration_id']; ?><!--" class="btn btn-success m-r checking" value="Accept">-->
<!--                                <input type="submit" name="reject" id="reject--><?php //echo $bidding['bid_registration_id']; ?><!--" class="btn btn-mainnxt checking" value="Reject">-->
                                <button class="btn btn-primary" role="button" data-toggle="collapse" href="#loanagreement" value="<?php echo $bidding['bid_registration_id']; ?>" onclick="getLoanaggrement(this.value)" aria-expanded="false" aria-controls="loanagreement">View Loan Agreement</button>
                            </td>
                        </form>
                    </tr>
                <?php }} else{
                    echo "<tr>
                        <td colspan='5' class='text-center'>No record found</td>
                    </tr>";
                }?>
            </table>
        </div>
    </div>

    <div class="col-md-12 m-t-40 collapse loanagreement" id="loanagreement" style="text-align: left">
        <div id='loanagreements'>
        </div>


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
    </div>

<script>
   function getLoanaggrement(bid_registration_id) {
        $("#loanagreements").remove();
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
                   $("#loanagreement").append(aggrement_json_parse['agreement']);
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
</script>

<script>
    function accept_loan_aggrement() {
        var bid_registration_id = $("#bid_registration_id").val();
        $.ajax({
            async: true,
            type: "POST",
            url: baseURL+"borroweraction/sendotpSignatuereaccept",
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
                url: baseURL+"borroweraction/verify_signature/",
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
                        $("#otp_validation_error").html('<p style="color: red">Your OTP is verified.</p>');
                        $('#loan_aggrement_otp').attr("readonly", true);
                        $("#resent_otp").hide();
                        window.location.href= '<?php echo base_url(); ?>borrower/loan_agreement_copies';
                    }
                }
            });
        }


    }
</script>
