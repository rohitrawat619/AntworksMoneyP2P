<?= getNotificationHtml(); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($list) {
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
                                            <td>
    <?php if($row['loan_status'] == 1){?>
        <a href="javascript:void(0)" class="btn btn-success">Amt. Disbursed</a>
    <?php } else {?>
        <a href="javascript:void(0)" data-loan_no="<?= $row['loan_no']; ?>" data-disburse_amount="<?= $row['approved_loan_amount']; ?>" class="btn btn-primary disburse">Disburse</a>
    <?php }?>
</td>

                                        </tr>
                                        <?php $i++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9">No Records Found!</td>
                                    </tr>
                                <?php } ?>
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


<!-- modal starts -->

<div id="disburseModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Loan Disbursement</h4>
            </div>
            <div class="modal-body">
                <form id="disburseForm">
                    <div class="form-group">
                        <label for="disburseAmount">Disburse Amount:</label>
                        <input type="text" class="form-control" id="disburseAmount" name="disburseAmount" required>
                    </div>
                    <div class="form-group">
                        <label for="disburseROI">Rate of Interest (%):</label>
                        <input type="text" class="form-control" id="disburseROI" name="disburseROI" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Disburse</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- modal ends -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>$(document).ready(function(){
    // disburse 
    
    $('.disburse').click(function(event){
        console.log("click");
        // loan loan_no
        var loan_no = $(this).data('loan_no');
        var disburse_amount = $(this).data('disburse_amount');
        
        // Set modal data attributes
        $('#disburseModal').attr('data-loan_no', loan_no);
        $('#disburseModal').attr('data-disburse_amount', disburse_amount);
        
        // Show the modal
        $('#disburseModal').modal('show');
    });

    // Handle form submission
    $('#disburseForm').submit(function(event){
        event.preventDefault();
        
        // Get data from modal
        var loan_no = $('#disburseModal').data('loan_no');
        var disburse_amount = $('#disburseModal').data('disburse_amount');
        var disburseAmount = $('#disburseAmount').val();
        var disburseROI = $('#disburseROI').val();
        
        // Confirm box
        if (confirm('Are you sure you want to Disburse Loan?')) {
            // Make AJAX request
            $.ajax({
                url: 'loan_disbursed',
                type: "POST",
                data: { loan_no: loan_no, disburse_amount: disburseAmount, disburseAmount: disburseAmount, disburseROI: disburseROI },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    location.reload(true);
                }
            });

            // Hide the modal
            $('#disburseModal').modal('hide');
        }
    });
    
});

$(window).load(function () {
    $('li').removeClass('active1');
    $('.user div').removeClass('collapse');
    $('.list-users').addClass('active1');
});
</script>
