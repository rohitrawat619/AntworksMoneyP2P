Select Scheme You want to invest in :
<?php 
if($this->session->userdata('UserLoginSession'))
{
    $udata = $this->session->userdata('UserLoginSession');
    $sdata = $this->session->userdata('scheme');
    var_dump($sdata);
    // exit;
}
else
{
    redirect(base_url('welcome/login'));
}
 ?>

  <table>
    <thead>
        <tr>
            <th>Scheme Name</th>
            <th>Minimum Ammount</th>
            <th>Max Ammount</th>
            <th>Interest Rate</th>
        </tr>
    </thead>
    <tbody>
       
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['Scheme_Name']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td ALIGN=CENTER><?php echo $row['Scheme_Name']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Min_Inv_Amount']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Max_Inv_Amount']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Interest_Rate']; ?></td>
            <td ALIGN=CENTER><a class="nav-link" href="<?php echo base_url('welcome/investinit1?SID='.$row['SID'].'&UID='.$udata['uid'].'&VID='.$udata['vid'])?>">Invest</a></td>
        </tr>
        <?php }}
        else { echo "Sorry There are no schemes yet!"; } ?>
    </tbody>
</table>

