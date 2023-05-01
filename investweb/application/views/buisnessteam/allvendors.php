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
              <table id="test2" class="table table-bordered table-hover">
              <tr>
            <th>Company Name</th>
        </tr>
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['Company_Name']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td><?php echo $row['Company_Name']; ?></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/editvendor1?VID='.$row['VID'])?>"><span class="label label-success">Modify Vendor</span></a></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/editrep1?VID='.$row['VID'])?>"><span class="label label-success">Represntative Details</span></a></td>
           </tr>
        <?php }}
        else { echo "Sorry There are no Vendors yet!"; } ?>
</table>
        </div>