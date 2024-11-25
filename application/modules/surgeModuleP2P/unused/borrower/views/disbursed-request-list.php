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
                                    <th>Action</th>
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
                                            <td>
											<?php if($row['loan_status'] == 1){?>
											<a href="javascript:void(0)" class="btn btn-success">Amt. Disbursed</a></td> 
											<?php }else{?>
											<a href="javascript:void(0)" data-loan_no="<?= $row['loan_no']; ?>" data-disburse_amount="<?= $row['approved_loan_amount']; ?>" class="btn btn-primary disburse">Disburse</a></td>
											<?php }?>
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

<script>
$(document).ready(function(){
  // disburse 
  $('.disburse').click(function(event){
      // loan loan_no
      var loan_no = $(this).data('loan_no');
      var disburse_amount = $(this).data('disburse_amount');
	
      // Confirm box
	  if (confirm('Are you sure you want to Disburse Loan?')) {
        $.ajax({
            url: '<?= base_url('p2padmin/loan_disbursed')?>',
            type: "POST",
            data: { loan_no:loan_no,disburse_amount:disburse_amount },
			dataType: 'json',
            success: function (response) {
				alert(response.message);
				location.reload(true);
            }
        });
    }
  });
});
    $(window).load(function () {
        $('li').removeClass('active1');
        $('.user div').removeClass('collapse');
        $('.list-users').addClass('active1');
    });
</script>