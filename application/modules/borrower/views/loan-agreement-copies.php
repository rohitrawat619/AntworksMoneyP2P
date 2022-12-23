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
                <?php if($aggrements){foreach($aggrements AS $bidding){?>
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

    <div class="col-md-12 m-t-40 collapse loanagreement" id="loanagreement">
        <div id='loanagreements'>
        </div>


    </div>
</div>

</div>

<script>
    function getLoanaggrement(bid_registration_id) {
        $("#loanagreements").remove();
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

                }
                if(aggrement_json_parse['status'] == 2)
                {
                    alert('No Record Found');
                }
                if(aggrement_json_parse['status'] == 0)
                {
                    alert(aggrement_json_parse['status']);
                    window.location.reload();
                }
            }
        });
    }
</script>
