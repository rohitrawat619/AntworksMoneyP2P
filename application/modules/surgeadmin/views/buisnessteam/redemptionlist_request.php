<?php 
if($this->session->userdata('session_data'))
{
    $udata = $this->session->userdata('session_data');

}
else
{
    redirect(base_url('Surgeadmin/login'));
}
 ?>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#investlist').DataTable();
    });
    </script>

<script src="<?=base_url('assets-p2padmin\dist\js/xlsx.full.min.js')?>"></script>

<section class="content">
<div class="box">
<div class="box-body">

<div class="row">
<div class="col-md-12">
<div class="box-body table-responsive no-padding">
    <h2 style="text-align:center;">Redemption Request List</h2>

  <?php
if($this->session->flashdata('flashmsg')): ?>
<p><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
<?php endif ?>

    <div class="table-responsive">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="row">
        <div class="col-md-6">
            <b>To:</b> <input type="text" id="min" name="min" class="form-control">
        </div>
        <div class="col-md-6">
            <b>From:</b> <input type="text" id="max" name="max" class="form-control">
        </div>
        </div>
    </div>
    <table id="investlist" class="table table-hover" style="margin-top: 40px;">
        <thead>
        <tr>
          
            <th>S.no.</th>
            <th>Created Date</th>
            <th>Lender Id</th>
            <th>Lender Name</th>
            <th>Investment No</th>
            <th>Mobile</th>
            <th>Amount</th>
            <th>Basic Rate</th>
            <th>Source</th>
            <th>Pre Mature RATE</th>
            <th>Current Value</th>
            <th>Days</th>
            <th>Status</th>
            <th></th>
          
        </tr>
        </thead>
        <tbody>
                <?php      
   
    if(@$row)
    {
     $i=1;
        foreach($row as $row1) { ?>
        <tr>
        
         
            <td><?php echo $i; ?></td>
            <td><?php echo date('Y-m-d', strtotime($row1['created_date'])); ?></td>
            <td><?php echo $row1['lender_id']; ?></td>
            <td><?php echo $row1['name']; ?></td>
            <td><?php echo $row1['investment_No']; ?></td>
            <td><?php echo $row1['mobile']; ?></td>
            <td>₹<?php echo $row1['amount']; ?></td>
            <td><?php echo $row1['basic_rate']; ?></td>
            <td><?php echo $row1['source']; ?></td>
            <td><?php echo $row1['pre_mat_rate']; ?></td>
            <td><?php echo $row1['total_current_value']; ?></td>
            <td><?php echo $row1['total_no_of_days']; ?></td>
            <td> 
                <?php if($row1['redemption_status'] == 5){
                          echo"<span class='label label-danger'>Pending For Redemption</span>";  
                }
                 if($row1['redemption_status'] == 1) {
                     echo"<span class='label label-default'>Redemption Request   </span>  ";        
                }
                 
                       
                         ?>
                      
            </td>
         
           
            <td>
                <?php if ($row1['redemption_status'] == 1) { ?>
                 <a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/redemptionapproved/<?= $row1['reinvestment_id']; ?>/5" class="btn btn-success" onclick="return confirm('Are You Sure Want To Approve This')">Approve</a>
                 <?php } ?>
                </td>

          <!--  <td>
                <?php if ($row1['redemption_status'] == 1) { ?>
                <a class="btn btn-danger" href="<?= base_url(); ?>Surgeadmin/decline/<?= $row1['reinvestment_id']; ?>/3" class="btn btn-danger" onclick="return confirm('Are You Sure Want To Decline This')"> Declined</a>
                <?php } ?>
            </td> -->
            
            
        </tr>
        <?php $i++;
         }
     }else { echo "Sorry There are no redemption Request list yet!"; } ?>
        </tbody>    
        </table>
        
        <div style="margin-left:930px;">
        <button id="downloadExcelBtn" class="btn btn-success"><i class="fa fa-download"></i> Excel</button>
        </div>
        </div><div class="clearfix"></div>
    </div>
  </div>
</div>


</div>
</div>
</section>


<script>
$(document).ready(function() {
    $('#investlist').DataTable();

   
    $('#downloadExcelBtn').on('click', function() {
      
        var tableData = $('#investlist').DataTable().data().toArray();

       
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(tableData);

       
        XLSX.utils.book_append_sheet(wb, ws, 'Disbursement List');

       
        XLSX.writeFile(wb, 'Redemption_list.xlsx');
    });

     
       $('#dateFilter').on('keyup', function() {
        var dateValue = $(this).val().trim();
        $('#investlist').DataTable().column(1).search(dateValue).draw();
    });
});


// $(document).ready(function() {
       // $('#investlist').DataTable();
     var table = $('#investlist').DataTable({
           initComplete: function() {
                var api = this.api();
                $('#min, #max').on('change', function() {
                    api.draw();
                });
            },
           
        });

    
        $('#min').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            onSelect: function() {
                table.draw();
            },
        });
        $('#max').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            onSelect: function() {
                table.draw();
            },
        });

      
       
       $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
      
            var min = $('#min').val();
            var max = $('#max').val();
            var date = data[1]; 

            if ((min === "" && max === "") ||
                (min === "" && date <= max) ||
                (min <= date && max === "") ||
                (min <= date && date <= max)
            ) {
                return true;
            }

            return false;
        });


</script>
