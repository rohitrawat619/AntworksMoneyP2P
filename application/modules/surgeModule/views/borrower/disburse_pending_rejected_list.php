<!-- Main content -->
<style type="text/css">
    strong {
        background: #fafafa;
        color: #666;
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        text-decoration: none;
        border: 1px solid #ddd;
    }

    .myform-inline {
        margin-top: 3px;
    }

    .myform-inline .form-group input {
        max-width: 136px;
    }
</style>


<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <?= getNotificationHtml(); ?>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="example" class="table table-bordered table-hover box">
                <thead>
                    <tr>
                        <th>S.no.</th>
                        <th>Created Date</th>
                        <th>Borrower Id</th>
                        <th>Borrower Name</th>
                        <th>Loan No</th>
                        <th>Mobile</th>
                        <th>Amount</th>
                        <th>Basic Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (@lists) {
                        $i = 1;
                        foreach ($lists as $list) {
                            if ($list['status'] == 2) {
                    ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $list['date_created']; ?></td>
                                    <td><?php echo $list['borrower_id']; ?></td>
                                    <td><?php echo $list['name']; ?></td>
                                    <td><?php echo $list['loan_no']; ?></td>
                                    <td><?php echo $list['mobile']; ?></td>
                                    <td>₹<?php echo $list['approved_loan_amount']; ?></td>
                                    <td><?php echo $list['approved_interest']; ?></td>
                                    
                                </tr>
                    <?php
                            }
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="8">No records found</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <nav aria-label="Page navigation">
                <ul class="setPaginate pull-right pagination">
                    <li><?php echo @$links; ?></li>
                </ul>
            </nav>
        </div>
    </div>
</section>
<!-- /.content -->

<script>
    $(function() {
        $('input[name="created_at"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "paging": false,
            "searching": false,
            "showNEntries": false,
        });
    });
</script>
