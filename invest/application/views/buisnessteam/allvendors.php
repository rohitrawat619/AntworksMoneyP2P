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
            <th>Company Name</th>
        </tr>
    </thead>
    <tbody>
       
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['Company_Name']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td ALIGN=CENTER><?php echo $row['Company_Name']; ?></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/editvendor1?VID='.$row['VID'])?>">Modify Vendor Details</a></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/editrep1?VID='.$row['VID'])?>">Auth Represntative Details</a></td>
        </tr>
        <?php }}
        else { echo "Sorry There are no Vendors yet!"; } ?>
    </tbody>
</table>
