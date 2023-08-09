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

 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#investlist').DataTable();
    });
    </script>

<script src="<?=base_url('assets-p2padmin\dist\js/xlsx.full.min.js')?>"></script>

<div class="row">
<div class="col-md-12">
<div class="box-body table-responsive no-padding">
    <h2 style="text-align:center;">Redemption Request List</h2>

  <?php
if($this->session->flashdata('flashmsg')): ?>
<p><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
<?php endif ?>

    <div class="table-responsive">
    <div class="table-responsive">
        <div class="filter-container" style="margin: 30px auto -30px auto; width: 300px; position: relative; z-index: 9;">
           <center><label for="date-filter">Date:</label>
            <input type="date" id="dateFilter" placeholder="yyyy-mm-dd"></center>
        </div>
    <table id="investlist" class="table table-hover" style="margin-top: 40px;">
        <thead>
        <tr>
          
            <th>S.no.</th>
            <th>Created Date</th>
            <th>Lender Id</th>
            <th>Investment No</th>
            <th>Lender Name</th>
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
            <td><?php echo $row1['created_date']; ?></td>
            <td><?php echo $row1['lender_id']; ?></td>
            <td><?php echo $row1['investment_No']; ?></td>
            <td><?php echo $row1['name']; ?></td>
            <td><?php echo $row1['mobile']; ?></td>
            <td>₹<?php echo $row1['amount']; ?></td>
            <td><?php echo $row1['basic_rate']; ?></td>
            <td><?php echo $row1['source']; ?></td>
            <td><?php echo $row1['pre_mat_rate']; ?></td>
            <td><?php echo $row1['total_current_value']; ?></td>
            <td><?php echo $row1['total_no_of_days']; ?></td>
            <td>
                <?php if ($row1['redemption_status'] == 1) { ?>
                <span class="label label-default">Redemption Request</span>
              
                        <?php } ?>
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
         }}
        else { echo "Sorry There are no redemption Request list yet!"; } ?>
        </tbody>    
        </table>
        
        <div style="margin-left:930px;">
        <button id="downloadExcelBtn" class="btn btn-success"><i class="fa fa-download"></i> Excel</button>
        </div>
        </div><div class="clearfix"></div>
    </div>
  </div>
</div>

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
</script>
