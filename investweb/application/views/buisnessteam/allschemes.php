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
            <th>Scheme Name</th>
            <th>Minimum Ammount</th>
            <th>Max Ammount</th>
            <th>Interest Rate</th>
        </tr>
                <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(isset($data['0']['Scheme_Name']))
    {
        foreach($data as $row){ ?>
        <tr>
            <td ><?php echo $row['Scheme_Name']; ?></td>
            <td><?php echo $row['Min_Inv_Amount']; ?></td>
            <td><?php echo $row['Max_Inv_Amount']; ?></td>
            <td><?php echo $row['Interest_Rate']; ?></td>
            <td><a class="nav-link" href="<?php echo base_url('welcome/editscheme1?SID='.$row['SID'])?>"><span class="label label-success">Modify</span></a></td>
           
            <!-- <td ALIGN=CENTER><span class="label label-success"><a class="nav-link" href="<?php echo base_url('welcome/editscheme1?SID='.$row['SID'])?>">Modify</a></span></td> -->
            <!-- <td ALIGN=CENTER><a class="nav-link" href="<?php //echo base_url('welcome/editscheme1?SID='.$row['SID'])?>">Modify Scheme Details</a></td> -->
        </tr>
        <?php }}
        else { echo "Sorry There are no schemes yet!"; } ?>
                
        </table>
        </div>