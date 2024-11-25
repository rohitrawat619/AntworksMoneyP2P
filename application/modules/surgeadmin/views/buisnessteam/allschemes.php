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

        $('#scheme').DataTable();
    });
</script>


 <div class="row">
    <div class="col-md-12">
         <div class="box-body table-responsive no-padding">
            
     <div style="float:right; padding:5px;"><button type="button"><a href="Surgeadmin/vend_addschemenow">+Add Scheme</a></button></div>
            <h2 style="text-align:center;">All Schemes</h2>

                <?php if($this->session->flashdata('flashmsg')): ?>
           <p style="background-color:yellow; font-size:medium;"><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
           <?php endif ?>
  <div class="table-responsive">
    <table id="scheme" class="table table-hover">
        <thead>
        <tr>
            <th>Serial No.</th>
            <th>Scheme id</th>
            <th>Scheme Name</th>
            <th>Partner Name</th>
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
            <th>Status</th>
            <th></th>     
            <th></th>   
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
            <td ><?php echo $row1['id'] ?></td>
            <td ><?php echo $row1['Scheme_Name']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['Min_Inv_Amount']; ?></td>
            <td><?php echo $row1['Max_Inv_Amount']; ?></td>
            <td><?php echo $row1['Interest_Rate']; ?>%</td>
            <td><?php echo $row1['hike_rate']; ?>%</td>
            <td><?php echo $row1['Lockin']; ?></td>
            <td><?php echo $row1['Lockin_Period']; ?></td>
            <td><?php echo $row1['Cooling_Period']; ?></td>
            <td><?php echo $row1['Pre_Mat_Rate']; ?>%</td>
            <td><?php echo $row1['Withrawl_Anytime']; ?></td>
            <td><?php echo $row1['Auto_Redeem']; ?></td>
            <td><?php echo $row1['Interest_Type']; ?></td>
            
 <td><a class="btn btn-<?= $row1['status'] == 0 ? 'warning' : 'success'; ?>" href="<?= base_url(); ?>Surgeadmin/statusupdate/<?= $row1['id']; ?>/<?= $row1['status']; ?>"> <?= $row1['status'] == 0 ? 'Inactive' : 'Active'; ?></a></td>
 <td><!----<a class="btn btn-primary" href="<?= base_url(); ?>Surgeadmin/editschemes/<?= $row1['id']; ?>"> Edit</a>---></td>
 <td>-</td> 
<td><a class="btn btn-info" href="<?= base_url(); ?>Surgeadmin/schemelogs/<?=$row1['id']; ?>">logs</a></td>

        </tr>
        <?php $i++;
         }}
        else { echo "Sorry There are no schemes yet!"; } ?>
        </tbody>     
        </table>
        
         </div><div class="clearfix"></div>
     </div>
 </div>
</div>

</body>