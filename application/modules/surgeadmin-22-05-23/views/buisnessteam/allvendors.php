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

<div class="box-body table-responsive no-padding">
    <h2 style="text-align:center; border-bottom:2px solid green;">All Venders</h2>
    <hr>
              <table id="test2" class="table table-bordered table-hover">
              <tr>
              <th>Vid</th>  
            <th>Company Name</th>
            <th>Address</th>
            <th>phone</th>
            <th>email</th>
            <th>Action</th>
        </tr>
        <?php      
   
     if(@$row)
    {
        foreach($row as $row1) { ?>
        <tr>
            <td><?php echo $row1['VID']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['Address']; ?></td>
            <td><?php echo $row1['Phone']; ?></td>
            <td><?php echo $row1['Email']; ?></td>
            

       
<td><a style="background-color:green; color:black; padding: 0.5em 2rem;" href="<?= base_url(); ?>Surgeadmin/editvendor1/<?= $row1['VID']; ?>"> Edit</a></td>
<td><a style="background-color:red; color:black; padding: 0.5em;" href="<?= base_url(); ?>Surgeadmin/deletevender/<?=$row1['VID']; ?>">Delete</a></td>

           </tr> 
           <?php }
    }else {
         echo "Sorry There are no Vendors yet!"; } ?>
</table>
        </div>