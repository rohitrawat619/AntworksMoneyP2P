Here are your investments
<?php 
if($this->session->userdata('venloginsession'))
{
    $udata = $this->session->userdata('venloginsession');
}
else
{
    redirect(base_url('welcome/login'));
}
 ?>

<style>
 th, td {
  padding-top: 10px;
  padding-bottom: 20px;
  padding-left: 30px;
  padding-right: 20px;
}
</style>
   <table>
    <thead>
        <tr>
            <th>Scheme Name</th>
            <th>Invested Amount</th>
            <th>Return Rate</th>
            <th>Current Value</th>
            <th>Invested Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>  
        <?php      
    //    echo "<pre>";
    //    print_r($data);
    // var_dump($data);
      // exit;
      
    if(isset($data['0']['tablename']))
      {
        foreach($data as $row){ ?>
        <tr>
            <td ALIGN=CENTER><?php  echo $row['tablename']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Investment_Amt']; ?></td>
            <td ALIGN=CENTER><?php echo $row['cvalue']['Interest']; ?></td>
            <td ALIGN=CENTER><?php echo $row['cvalue']['value']; ?></td>
            <td ALIGN=CENTER><?php echo $row['Investment_date']; ?></td>
            <td ALIGN=CENTER>
                <?php if($row['Status']== 2)
                {  echo "Processing";  }  
                if($row['Status']== 3)
                {  echo "Redeemed";  }  
                if($row['Status']== 1)
                {  echo "Active";  }  
             ?></td>
             
            
        </tr>
        <?php }}
        else { echo "Sorry There are no investments yet!"; } ?>
    </tbody>
</table>
