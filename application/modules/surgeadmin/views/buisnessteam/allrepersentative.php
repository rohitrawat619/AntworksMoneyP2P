
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

        $('#redemption').DataTable();
    });
</script>

<div class="row">
<div class="col-md-12">
<div class="box-body table-responsive no-padding">
<div style="float:right; padding: 5px;"><button type="button"><a href="Surgeadmin/reg_representative">+Add Repersentative</a></button></div>
    <h3 style="text-align:center;">All Representative</h3>

    <?php if($this->session->flashdata('flashmsg')): ?>
        <p style="background-color:yellow; font-size:medium;"><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']) ?></p>
           <?php endif ?>
        
              <table id="redemption" class="table table-bordered table-hover">
                <thead>
              <tr>
                <th>Rid</th>
              <th>RepName</th>
            <th>Partner Name</th>
            <th>RepDesignation</th>
            <th>Repphone</th>
            <th>Repemail</th>
            <th>created_date</th>
            <th>Action</th>
            <th></th>
        </tr>
                </thead>
                <tbody>
        <?php      
   if(@$row)
   {
    $i=1;
foreach($row as $row1)   { ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row1['RepName']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['RepDesignation']; ?></td>
            <td><?php echo $row1['Repphone']; ?></td>
            <td><?php echo $row1['Repemail']; ?></td>
            <td><?php echo $row1['created_date']; ?></td>
            <td><a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/editrepersent/<?= $row1['rid']; ?>"> Edit</a></td>
            <td><a class="btn btn-danger" href="<?= base_url(); ?>Surgeadmin/deleterepersent/<?=$row1['rid']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete This')">Delete</a></td>

             </tr>
        <?php $i++;
         } }
        
        else { echo "Sorry There are no redemtion requests yet!"; } ?>
                </tbody>
</table>
        </div><div class="clearfix"></div>
       </div>
</div>



