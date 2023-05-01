<?php 
if($this->session->userdata('Teamloginsession'))
{
    $udata = $this->session->userdata('Teamloginsession');
   // echo 'Welcome'.' '.$udata['fullname'];
}
else
{
    redirect(base_url('welcome/businessTeamlogin'));
}
?>

<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
              <th>Representative Name</th>
              <th>Designation</th>
              <th>Phone</th>
              <th>Email</th>
        </tr>
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['RepName']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td><?php echo $row['RepName']; ?></td>
            <td><?php echo $row['RepDesignation']; ?></td>
            <td><?php echo $row['Repphone']; ?></td>
            <td><?php echo $row['Repemail']; ?></td>
            <td><a class="nav-link" href="<?php echo base_url('welcome/editrep2?RID='.$row['RID'])?>"><span class="label label-success">Modify</span></a></td>
            </tr>
        <?php }}
        else { echo "Sorry There are no Representative Added for this Partner yet!"; } ?>
        	<?php
						if($this->session->flashdata('success')) {	?>
						 <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p>
						<?php } ?>
    </tbody>    
        </table>
        </div>