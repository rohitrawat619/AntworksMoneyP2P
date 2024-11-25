<?= getNotificationHtml(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <!-- .left-right-aside-column-->
            <div class="page-aside">
                <div class="m-t-30">

                </div>
                <!-- .left-aside-column-->
                <!-- /.left-aside-column-->
                <div class="">
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list"
                                   data-page-size="100">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Loan No</th>
                                    <th>Borrower Name</th>
                                    <th>Borrower Email</th>
                                    <th>Borrower Mobile</th>
                                    <th>Loan Applied Date</th>
                                    <th>Loan Amount</th>
                                    <th>Rate of Interest</th>
                                    <th>Tenure</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? if ($list) {
                                    $i = 1;
                                    foreach ($list as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $row['loan_no']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['mobile']; ?></td>
                                            <td><?= date('Y-m-d', strtotime($row['date_created'])); ?></td>
                                            <td><?= $row['approved_loan_amount']; ?></td>
                                            <td><?= $row['approved_interest']; ?> %</td>
                                            <td><?= $row['approved_tenor']; ?>Month</td>

                                        </tr>
                                        <? $i++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9">No Records Found!</td>
                                    </tr>
                                <? } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <?php

                                        //echo $pagination;

                                        ?></td>
                                </tr>

                                </tr>
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
<div class="row">
    <div class="col-md-12">
        <div class="white-box p-0">
            <a href="<?= base_url('p2padmin/send_to_escrow_for_disbursement') ?>">
                <button class="btn btn-primary">Disburse Loan</button>
            </a>
        </div>
    </div>
</div>

<script>
    $(window).load(function () {
        $('li').removeClass('active1');
        $('.user div').removeClass('collapse');
        $('.list-users').addClass('active1');
    });
</script>