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
              <table class="table table-hover">
              <tr>
              <th>SID</th>
            <th>Scheme Name</th>
            <th>Minimum Ammount</th>
            <th>Max Ammount</th>
             <th>Lockin</th>
            <th>Interest Rate</th>
            <th>Locking Period</th>
           <th>Cooling Period</th>
           <th>Pre mature interest Rate</th>
           <th>Withdrawel Anytime</th>
           <th>Auto Redeem</th>
           <th>Invest Type</th>
           <th>Action</th>
            
        </tr>
                <?php      
    //    echo "<pre>";
    //    print_r($data);
    //    exit;
    if(@$row)
    {
     $i=1;
        foreach($row as $row1) { ?>
        <tr>
        
            <td ><?php echo $row1['id'] ?></td>
            <td ><?php echo $row1['Scheme_Name']; ?></td>
            <td><?php echo $row1['Min_Inv_Amount']; ?></td>
            <td><?php echo $row1['Max_Inv_Amount']; ?></td>
            <td><?php echo $row1['Interest_Rate']; ?></td>
            <td><?php echo $row1['Lockin']; ?></td>
            <td><?php echo $row1['Lockin_Period']; ?></td>
            <td><?php echo $row1['Cooling_Period']; ?></td>
            <td><?php echo $row1['Pre_Mat_Rate']; ?></td>
            <td><?php echo $row1['Withrawl_Anytime']; ?></td>
            <td><?php echo $row1['Auto_Redeem']; ?></td>
            <td><?php echo $row1['Interest_Type']; ?></td>
           


            <td><a style="background-color:green; color:black; padding: 0.5em 2rem;" href="<?= base_url(); ?>Surgeadmin/editscheme2/<?= $row1['id']; ?>"> Edit</a></td>
<td><a style="background-color:red; color:black; padding: 0.5em;" href="<?= base_url(); ?>Surgeadmin/deletescheme/<?=$row1['id']; ?>">Delete</a></td>

        </tr>
        <?php $i++;
         }}
        else { echo "Sorry There are no schemes yet!"; } ?>
                
        </table>
        </div>