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

<table>
    <thead>
        <tr>
            <th>Representative Name</th>
            <th>Designation</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
       
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['RepName']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td ALIGN=CENTER><?php echo $row['RepName']; ?></td>
            <td ALIGN=CENTER><?php echo $row['RepDesignation']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Repphone']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Repemail']; ?></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/editrep2?RID='.$row['RID'])?>">Modify Representative Details</a></td>
        </tr>
        <?php }}
        else { echo "Sorry There are no Representative Added for this Partner yet!"; } ?>
        	<?php
						if($this->session->flashdata('success')) {	?>
						 <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p>
						<?php } ?>
    </tbody>
</table>
