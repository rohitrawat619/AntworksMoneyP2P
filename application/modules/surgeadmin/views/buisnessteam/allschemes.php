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
    <center><h2 style="border-bottom:3px solid green;">All Schemes</h2></center>

                <?php if($this->session->flashdata('flashmsg')): ?>
           <p style="background-color:yellow; font-size:medium;"><?php echo $this->session->flashdata('flashmsg'); unset($_SESSION['flashmsg']); ?></p>
           <?php endif ?>

              <table class="table table-hover">
              <tr>
              <th>SID</th>
            <th>Scheme Name</th>
            <th>Vendor</th>
            <th>Minimum Ammount</th>
            <th>Max Ammount</th>
             <th>Interest Rate</th>
            <th>Lockin</th>
            <th>Locking Period</th>
           <th>Cooling Period</th>
           <th>Pre mature interest Rate</th>
           <th>Withdrawel Anytime</th>
           <th>Auto Redeem</th>
           <th>Invest Type</th>
           <th>Action</th>
            
        </tr>
                <?php      
   
    if(@$row)
    {
     $i=1;
        foreach($row as $row1) { ?>
        <tr>
        
            <td ><?php echo $row1['id'] ?></td>
            <td ><?php echo $row1['Scheme_Name']; ?></td>
            <td><?php echo $row1['Company_Name']; ?></td>
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
           


            <td><a class="btn btn-success" href="<?= base_url(); ?>Surgeadmin/editschemes/<?= $row1['id']; ?>"> Edit</a></td>
<td><a class="btn btn-danger" href="<?= base_url(); ?>Surgeadmin/deletescheme/<?=$row1['id']; ?>">Delete</a></td>

        </tr>
        <?php $i++;
         }}
        else { echo "Sorry There are no schemes yet!"; } ?>
                
        </table>
        </div>