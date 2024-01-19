<!-- Main content -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>

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
                            if ($list['status'] == 0 && $list['status'] == NULL) {
                    ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($list['date_created'])); ?></td>
                                    <td><?php echo $list['borrower_id']; ?></td>
                                    <td><?php echo $list['name']; ?></td>
                                    <td><?php echo $list['loan_no']; ?></td>
                                    <td><?php echo $list['mobile']; ?></td>
                                    <td>₹<?php echo $list['approved_loan_amount']; ?></td>
                                    <td><?php echo $list['approved_interest']; ?></td>
                                    <td>
                                        <?php
                                        if ($list['status'] == 0 && $list['status'] == NULL) {
                                            echo "<span class='btn btn-success' onclick=approve_disburse_request('" . $list['id'] . "') >Approve</span>  ";
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td><button class="btn btn-danger " onclick="rejectLoan(<?php echo $list['id']; ?>)">Reject</button></td>
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
    function approve_disburse_request(ids) {
        const newStatus = 1;
        var confirmation=confirm("Do you want to approve ? ");
        if(confirmation){
        $.ajax({
            type: 'POST',
            url: 'update_disburse_status',
            data: {
                ids: ids,
                status: newStatus
            },
            success: function(response) {
                // console.log("runs");
                console.log(response);
                location.reload();
            },
            error: function() {
                alert('Error occurred during the AJAX request');
            }
        });
    }
}

    function rejectLoan(loanId) {
        var status=2;
        var confirmation=confirm("Do you want to reject ? ");
        if(confirmation){
        $.ajax({
            url: 'update_disburse_status', 
            method: 'POST',
            data: {ids: loanId ,status:status},
            success: function(response) {
                console.log(response);
                // Add logic to handle success response
            },
            error: function(error) {
                console.error('Error rejecting loan:', error);
                // Add logic to handle error response
            }
        });
    }
}
</script>

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
