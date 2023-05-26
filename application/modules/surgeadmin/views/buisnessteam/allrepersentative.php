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
    <center><h3 style="border-bottom:5px solid blue;">All Representative</h3></center>

    <?php if($this->session->flashdata('flashmsg')): ?>
        <p style="background-color:yellow; font-size:medium;"><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
           <?php endif ?>

              <table id="test2" class="table table-bordered table-hover">
              <tr>
                <th>Rid</th>
              <th>RepName</th>
            <th>vender</th>
            <th>RepDesignation</th>
            <th>Repphone</th>
            <th>Repemail</th>
            <th>password</th>
            <th>created_date</th>
            <th>Action</th>
        </tr>
        <?php      
   if(@$row)
   {
 
foreach($row as $row1)   { ?>

        <tr>
            <td><?php echo $row1['rid']; ?></td>
            <td><?php echo $row1['RepName']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
            <td><?php echo $row1['RepDesignation']; ?></td>
            <td><?php echo $row1['Repphone']; ?></td>
            <td><?php echo $row1['Repemail']; ?></td>
            <td><?php echo $row1['password']; ?></td>
            <td><?php echo $row1['created_date']; ?></td>
            <td><a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/editrepersent/<?= $row1['rid']; ?>"> Edit</a></td>
<td><a class="btn btn-danger" href="<?= base_url(); ?>Surgeadmin/deleterepersent/<?=$row1['rid']; ?>">Delete</a></td>

             </tr>
        <?php } }
        
        else { echo "Sorry There are no redemtion requests yet!"; } ?>
</table>
        </div>
        <?php
						if($this->session->flashdata('redeemfinal')) {	?>
						 <h4 class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('redeemfinal')?></h4>
						<?php } ?>