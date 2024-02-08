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
                            if ($list['status'] == 0 && $list['status'] == NULL) {
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
                                    <td>
                                    <button class="btn btn-success" onclick="openApprovalModal(<?php echo $list['id']; ?>)">Approve</button>

                                    </td>
                                    <td>
                                    <button class="btn btn-danger" onclick="rejectLoan(<?php echo $list['id']; ?>)">Reject</button>
                                    </td>
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

<!-- Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approvalModalLabel">Enter Amount and ROI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="approvalForm">
          <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" class="form-control" id="amount" required>
          </div>
          <div class="mb-3">
            <label for="roi" class="form-label">ROI</label>
            <input type="text" class="form-control" id="roi" required>
          </div>
          <button type="submit" class="btn btn-primary">Approve</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
  function openApprovalModal(ids) {
    $('#approvalModal').modal('show');

    $('#approvalForm').submit(function (e) {
      e.preventDefault();

      const amount = $('#amount').val();
      const roi = $('#roi').val();
      const status = 1;
    // console.log(ids+" "+amount+" "+roi+" "+status);return;
      $.ajax({
        type: 'POST',
        url: '../update_disburse_status',
        data: {
          ids: ids,
          status: status,
          amount: amount,
          roi: roi
        },
        success: function (response) {
          console.log(response);
		  var resp = JSON.parse(response);
		 // alert(resp.status);
		  if(resp.status=1){
			  alert(resp.message);
			  location.reload();
		  }else{
			   alert(resp.message);
		  }
          //
        },
        error: function () {
          alert('Error occurred during the AJAX request');
        }
      });

      
      $('#approvalModal').modal('hide');
    });
  }



    function rejectLoan(loanId) {
        var status=2;
        var confirmation=confirm("Do you want to reject ? ");
        if(confirmation){
        $.ajax({
            url: '../update_disburse_status', 
            method: 'POST',
            data: {ids: loanId ,status:status},
            success: function(response) {
                console.log(response);
                
            },
            error: function(error) {
                console.error('Error rejecting loan:', error);
               
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
