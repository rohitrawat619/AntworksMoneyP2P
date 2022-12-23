<?=getNotificationHtml();?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <!-- .left-aside-column-->

                <!-- /.left-aside-column-->
                <div class="">
                    <div class="right-page-header">
                        <h3>Repaymant Details</h3>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered" data-page-size="50">
                                <thead>
                                <tr>

                                    <th colspan="2">Borrower Detail</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>Borrower Id</td>

                                    <td><?=ucwords($list->BORROWER_ID);?></td>
                                </tr>
                                <tr>
                                    <td>Borrower Name</td>
                                    <td><?=ucwords($list->BORROWERNAME);?> <?=ucwords($list->BORROWERLASTNAME);?></td>
                                </tr>
                                <tr>
                                    <td>Father  Name</td>
                                    <td><?=ucwords($list->BORROWERFATHERNAME);?> </td>
                                </tr>
                                <tr>
                                    <td>Date Of Birth</td>
                                    <td><?=ucwords($list->BORROWERDOB);?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?=ucwords($list->BORROWEREMAIL);?> </td>
                                </tr>
                                <tr>
                                    <td>Borrower Mobile</td>
                                    <td><?=ucwords($list->BORROWERMOBILE);?> </td>
                                </tr>
                                <tr>
                                    <td>Borrower Pan</td>
                                    <td><?=ucwords($list->BORROWERR_pan);?> </td>
                                </tr>
                                <tr>
                                    <td>Borrower Aadhar</td>
                                    <td><?=ucwords($list->BORROWERR_aadhaar);?> </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><?=ucwords($list->BORROWERR_City);?> </td>
                                </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered" data-page-size="50">
                                <thead>
                                <tr>

                                    <th colspan="2">Lender Details</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>Name</td>

                                    <td><?=ucwords($list->LENDER_fNAME);?> <?=ucwords($list->LENDER_last_name);?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>

                                    <td><?=ucwords($list->LENDER_email);?> </td>
                                </tr>

                                <tr>
                                    <td>Mobile</td>

                                    <td><?=ucwords($list->LENDER_mobile);?></td>
                                </tr><tr>
                                    <td>Pan Card</td>

                                    <td><?=ucwords($list->LENDER_PAN);?></td>
                                </tr>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered" data-page-size="50">
                                <thead>
                                <tr>

                                    <th colspan="2">Emi Details Table</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>Bank Name</td>

                                    <td><?=ucwords($list->bank_name);?> </td>
                                </tr>
                                <tr>
                                    <td>Branch Name</td>

                                    <td><?=ucwords($list->branch_name);?> </td>
                                </tr>

                                <tr>
                                    <td>Account No.</td>

                                    <td><?=ucwords($list->account_number);?> </td>
                                </tr>
                                <tr>
                                    <td>Ifsc Code</td>

                                    <td><?=ucwords($list->ifsc_code);?> </td>
                                </tr>
                                <tr>
                                    <td>Account Type</td>

                                    <td><?=ucwords($list->account_type);?> </td>
                                </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Emi Date</th>
                                    <th>Emi Amount(INR)</th>
                                    <th>Emi Interest Compound(INR)</th>
                                    <th>Emi Principal Component(INR)</th>
                                    <th>Emi Outstanding Balance(INR)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? 	if($list){
                                    $emi_details = $this->Managementmodel->show_emi_borrower($list->bid_registration_id);
//
                                    $i=1;
                                    foreach($emi_details as $emi){
                                        ?>
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td> <?=$emi->emi_date;?></a></td>
                                            <td> <?=$emi->emi_amount;?></a></td>
                                            <td> <?=$emi->emi_interest;?></a></td>
                                            <td> <?=$emi->emi_principal;?></a></td>
                                            <td> <?=$emi->emi_balance;?></a></td>
                                            <td> <? if($emi->status==1){echo "Paid";} else{echo "Unpaid";}?></a></td>
                                            <td>

                                                <form action="<?php echo base_url() ?>management/send_to_escrow" method="post">
                                                 <input type="hidden" name="emi_id" id="emi_id" value="<?php echo $emi->id; ?>">
                                                <input type="submit" name="send_to_escrow" id="send_to_escrow" value="Send to Escrow" class="btn btn-primary">
                                                </form>
                                            </td>

                                        </tr>
                                        <? $i++;}}else
                                {?>
                                    <tr>
                                        <td colspan="9">No Records Found!</td>
                                    </tr>
                                <? }?>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>




                </div>
                <!-- .left-aside-column-->

            </div>
            <!-- /.left-right-aside-column-->
        </div>
    </div>
</div>

<script>
    $(window).load(function() {
        $('li').removeClass('active1');
        $('.adminbidding div').removeClass('collapse');
        $('.admin-bidding-home').addClass('active1');
    });


</script>
