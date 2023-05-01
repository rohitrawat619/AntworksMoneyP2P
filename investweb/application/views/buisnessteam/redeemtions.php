<?php 
if($this->session->userdata('Teamloginsession'))
{
    $udata = $this->session->userdata('Teamloginsession');
    // echo "<pre>";
    // print_r($data);
    // exit;
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
              <th>Vendor Name</th>
            <th>Investment Note</th>
            <th>Investment Amount</th>
            <th>Redemption Amount</th>
            <th>Investment Date</th>
            <th>Redemtion Date</th>
            <th>Action</th>
        </tr>
        <?php      
    //    echo "<pre>";
    //    print_r($data);
   
    if(isset($data['0']['0']['IID']))
    {
        foreach($data as $rows){ 
          foreach($rows as $row) { ?>
        <tr>
            <td><?php echo $row['Vendor']; ?></td>
            <td><?php echo $row['Investment_ID']; ?></td>
            <td><?php echo $row['Investment_Amt']; ?></td>
            <td><?php echo $row['rvalue']['rvalue']; ?></td>
            <td><?php echo $row['Investment_date']; ?></td>
            <td><?php echo $row['Redeem_date']; ?></td>
             <td><a class="nav-link" href="<?php echo base_url('welcome/redemptionsrqsts1?Investment_ID='.$row['Investment_ID'].'&scheme='.$row['op'])?>"><span class="badge bg-red">Proceed</span></a></td>
             </tr>
        <?php } }
        }
        else { echo "Sorry There are no redemtion requests yet!"; } ?>
</table>
        </div>
        <?php
						if($this->session->flashdata('redeemfinal')) {	?>
						 <h4 class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('redeemfinal')?></h4>
						<?php } ?>