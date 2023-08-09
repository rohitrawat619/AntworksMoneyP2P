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

        $('#vendor').DataTable();
        
    });
</script>




<div class="row">
    <div class="col-md-12">
   

<div class="box-body table-responsive no-padding">
<div style="float:right; padding:5px;"><button type="button"><a href="Surgeadmin/partner_reg">+Add Partner</a></button></div>
 <h2 style="text-align:center;">All Partner</h2>
  <?php 
   
    if($this->session->flashdata('flashmsg')): ?>
      <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
        <p><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']);  ?></p>
        <?php endif ?>
      </div>
      
    <hr>
          <table id="vendor" class="table table-bordered table-hover">
  <thead>
              <tr>
              <th>Vid</th>  
            <th>Partner Name</th>
            <th>Address</th>
            <th>phone</th>
            <th>email</th>
            <th>Action</th>
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
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['Address']; ?></td>
            <td><?php echo $row1['Phone']; ?></td>
            <td><?php echo $row1['Email']; ?></td>
            

       
<td><a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/editvendor/<?= $row1['VID']; ?>" > Edit</a></td>
<td><a class="btn btn-danger" href="<?= base_url(); ?>Surgeadmin/deletevender/<?=$row1['VID']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete This')">Delete</a></td>


           </tr> 
           <?php $i++;
           }
    }else {
         echo "Sorry There are no Partner yet!"; } ?>
  </tbody>
</table>
        </div><div class="clearfix"></div>
    </div>
</div>