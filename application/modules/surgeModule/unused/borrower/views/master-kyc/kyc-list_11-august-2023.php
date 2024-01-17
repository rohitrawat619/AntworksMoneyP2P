<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master KYC</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <?=getNotificationHtml();?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list " data-page-size="100">
                        <tr>
                            <th>Date</th>
                            <th>Anchor</th>
                            <th>Information Collected</th>
                            <th>Kyc Information Received</th>
                            <th>Type of kyc</th>
                            <th>Kyc status</th>
                            <th>View Download</th>
                        </tr>
                        <? if ($lists){
                            foreach ($lists as $list){ ?>
                                <tr>
                                    <td><?=date('D-M-Y', strtotime($list['created_date']))?></td>
                                    <td>Antpay</td>
                                    <td>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Name</td>
                                                <td>Dob</td>
                                                <td>Pan</td>
                                                <td>Aadhar</td>
                                                <td>Account no</td>
                                            </tr>
                                            <tr>
                                                <td> <?=$list['registered_name']?></td>
                                                <td> </td>
                                                <td> <?=$list['pan']?></td>
                                                <td> <?=$list['aadhar']?></td>
                                                <td> <?=$list['account_no']?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Name aadhar</td>
                                                <td>Name pan</td>
                                                <td>Name a/c</td>
                                                <td>Pan no</td>
                                                <td>Dob pan</td>
                                                <td>Dob aadhar</td>
                                                <td>Aadhar no</td>
                                                <td>Liveness check slots</td>
                                                <td>Face match slots</td>
                                            </tr>
                                            <tr>
                                                <td><?=$list['aadhar_registered_name'] ?></td>
                                                <td><?=$list['pan_registered_name'] ?></td>
                                                <td><?=$list['bank_registered_name'] ?></td>
                                                <td><?=$list['pan'] ?></td>
                                                <td></td>
                                                <td><?=$list['aadhar_dob'] ?></td>
                                                <td><?=$list['aadhar'] ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td><?=$list['kyc_step']?></td>
                                    <td><?=$list['']?></td>
                                    <td><a href="javascript:void(0)">Download</a> </td>
                                </tr>

                        <? } } ?>

                    </table>
                </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
</div>
