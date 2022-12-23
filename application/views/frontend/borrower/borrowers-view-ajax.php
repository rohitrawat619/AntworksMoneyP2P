<? if($borrowers_list){ error_reporting(0);
//  echo "<pre>";
//  print_r($borrowers_list); exit;
  //unset($borrowers_list[0][5]);
  $i = 1;
  foreach($borrowers_list as $row)
  {
//    if($row['profilepic'])
//    {
//      $user_image = "uploads/users/".$row['profilepic'];
//    }
//    else
//    {
//      $user_image = "assets/img/team/team-8.png";
//    }
      if($i == 1 || $i%4 == 0){
          echo '<div class="row">';
      }
    ?>



    <div class="col-md-3 col-sm-6 borrowers-th">
      <div class="single-team-member">
        <div class="img-box"><i class="fa fa-user fa-4x" aria-hidden="true"></i>


            <div class="box">
              <div class="content">

              </div>

            </div>


        </div>
        <div class="text-box">
          <h3>
            <?php echo $row['name']; ?>
          </h3>
           Occupation -
               <?=$row['occupation_name'];?>


          <p>City - <?=$row['r_city'];?></p>
          <p>State - <?=$row['state'];?>
          </p>
          <p>Total Loan Applied -
            <?=$row['loan_amount']?>
          </p>
          <p>Bidding Status - <?  if($row['bidding_status']=='1'){echo "Open"; }else { echo "Open";}?>
          </p>
       <a href="<?=base_url();?>login/lender">View Details</a>
        </div>
        <!-- /.text-box -->
      </div>
      <!-- /.single-team-member -->
    </div>

    <!-- /.col-md-3 -->

  <?
      if($i%4 == 0){
          echo '</div>';
      }
  $i++; }?>

    <div class="col-md-12 col-sm-6" style="text-align: center">
        <br/>
        <br/>
        <br/>
        <a href="<?php echo base_url(); ?>login/lender"><button type="button" class="thm-btn">More Borrowers</button></a>
    </div>
<?php  }
else{?>
  <div class="col-md-3 col-sm-6">
    <div class="single-team-member">
      <p>No records found!</p>
    </div>
    <!-- /.single-team-member -->
  </div>
  <!-- /.col-md-3 -->
<? }?>