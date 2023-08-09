<?php 
if($this->session->userdata('session_data'))
{
    $udata = $this->session->userdata('session_data');

}
else
{
    redirect(base_url('Surgeadmin/businessTeamlogin'));
}
 ?>

 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function() {
$('#scheme_log').DataTable();
});
  </script>



<div class="box-body table-responsive no-padding">
    <center><h2>Scheme log Details</h2></center>

                <?php if($this->session->flashdata('flashmsg')): ?>
           <p style="background-color:yellow; font-size:large;"><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
           <?php endif ?>

              <table id="scheme_log" class="table table-bordered table-striped table-hover">
                <thead>
              <tr>
              <th>SID</th>
            <th>Scheme Name</th>
            <th>Vendor</th>
            <th>Minimum Ammount</th>
            <th>Max Ammount</th>
             <th>Interest Rate</th>
             <th>Hike Rate</th>
            <th>Lockin</th>
            <th>Locking Period</th>
           <th>Cooling Period</th>
           <th>Pre mature interest Rate</th>
           <th>Withdrawel Anytime</th>
           <th>Auto Redeem</th>
           <th>Invest Type</th>
           <th>Scheme Created Date</th>
           <th>Updated Date</th>
            
        </tr>
                </thead>
                <tbody>
                <?php      
   
    if(@$row)
    {
     $i=1;
        foreach($row as $row1) { ?>
        <tr>
        
            <td><?php echo $row1['id'] ?></td>
            <td><?php echo $row1['Scheme_Name']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['Min_Inv_Amount']; ?></td>
            <td><?php echo $row1['Max_Inv_Amount']; ?></td>
            <td><?php echo $row1['Interest_Rate']; ?></td>
            <td><?php echo $row1['hike_rate']; ?></td>
            <td><?php echo $row1['Lockin']; ?></td>
            <td><?php echo $row1['Lockin_Period']; ?></td>
            <td><?php echo $row1['Cooling_Period']; ?></td>
            <td><?php echo $row1['Pre_Mat_Rate']; ?></td>
            <td><?php echo $row1['Withrawl_Anytime']; ?></td>
            <td><?php echo $row1['Auto_Redeem']; ?></td>
            <td><?php echo $row1['Interest_Type']; ?></td>
            <td><?php echo $row1['scheme_created_date']; ?></td>
            <td><?php echo $row1['created_date']; ?></td>
           


           <!-- <td><a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/viewschemelogs/<?= $row1['id']; ?>"> view log details</a></td> -->

        </tr>
        <?php $i++;
         }}
        else { ?>
         <tr>

<td colspan="16">
            No scheme logs found!
            <td>
         </tr>
        <?php } ?>
        </tbody>  
        </table>
        </div>