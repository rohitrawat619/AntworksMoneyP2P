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

<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="row">
            <div class="box-body sme-profile">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#company-details" aria-expanded="false" aria-controls="company-details"
                                   id="companydetails" class="collapsed">
                                    KYC Check Status
                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="company-details" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <table class="table table-bordered">

                                        <tr>
                                            <td><b>Pan Valid</b></td>
                                            <td><? echo $panresponse['name'] ?></td>
                                            <td>
                                                <? if($steps['step_1'] == 1){
                                                   echo '<button class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>';
                                                }else{
                                                    echo '<button class="btn btn-primary"><i class="fa fa-times" aria-hidden="true"></i></button>';
                                                } ?>
                                            </td>
                                            <td>
                                                <? if(1 == 1){?>
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
                                                <? } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Bank Account values</b></td>
                                            <td><? echo $list['bank_registered_name']  ?></td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="col-sm-7 col-md-7">
                                                        <div class="input-group">
                                                            <div id="radioBtn" class="btn-group">
                                                                <a class="btn btn-primary btn-sm notActive"
                                                                   data-toggle="happy" data-title="Y">YES</a>
                                                                <a class="btn btn-primary btn-sm active"
                                                                   data-toggle="happy" data-title="N">NO</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="button" class="btn btn-primary" value="Admin Action">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- /Company Details -->
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <style>
                .panel-group .panel {
                    background: #fff;
                    border: 1px solid #dbdbdb;
                    border-radius: 2px;
                    transition-timing-function: ease-out;
                    transition: .4s;
                }

                .panel-default > .panel-heading {
                    background: #fff;
                }

                .panel-default > .panel-heading + .panel-collapse > .panel-body {
                    border-top-color: transparent;
                }

                .panel-title > .small, .panel-title > .small > a, .panel-title > a, .panel-title > small, .panel-title > small > a {
                    padding: 18px 24px;
                    display: block;
                    font-weight: 600;
                }

                .collapse.in {
                    box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
                }

                .panel-group .panel + .panel {
                    margin-top: 15px;
                }

                .panel-title > a > i {
                    float: right;
                }
            </style>

        </div>
</section>
<div id="script_razorpay"></div>
<style>
    #radioBtn .notActive {
        color: #3276b1;
        background-color: #fff;
    }
</style>
