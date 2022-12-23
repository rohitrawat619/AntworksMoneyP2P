<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-12">
    <div class="white-box p-0"> 
      <!-- .left-right-aside-column-->
      <div class="page-aside">
          <div class="m-t-30">
              <div class="right-page-header">
                  <form method="post" action="<?php echo base_url(); ?>p2padmin/search">
                      <div class="col-md-12">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" readonly name="start_date" id="datepicker-autoclose" placeholder="Starting date" class="form-control" id="start_date">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" readonly name="end_date" id="datepicker-autoclose2" placeholder="End date" class="form-control" id="end_date">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="pan" placeholder="Pancard" class="form-control" id="pan">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="email" placeholder="Email" class="form-control" id="email">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="mobile" placeholder="Mobile" class="form-control" id="mobile">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="submit" id="search" value="Search" name="search" class="btn btn-primary">
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
          </div>
        <!-- .left-aside-column-->
        <!-- /.left-aside-column-->
        <div class="">
          <div class="clearfix"></div>
          <div class="scrollable">
            <div class="table-responsive">
              <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Loan No</th>
                    <th>Borrower Name</th>
                    <th>Loan Applied Date</th>
                    <th>Loan Amount</th>
                    <th>Rate of Interest</th>
                    <th>Tenure</th>
                    <th>City</th>
                    <th>Response</th>
                    <th>Time Remaining</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
				  <? 	if($list){
					  	$i=1;
                      	foreach($list as $row){
                  ?>
                  <tr>
                    <td><?=$i;?></td>
                    <td><?= $row['PLRN'] ;?></td>
                    <td><?=$row['Borrowername'];?></td>
                    <td><?= date('Y-m-d', strtotime($row['date_added']));?></td>
                    <td><?=$row['loan_amount'];?></td>
                    <td><?=$row['accepted_interest_rate'];?>%</td>
                    <td><?=$row['tenor_months'];?> Months</td>
                    <td><?=$row['borrower_city'];?></td>
                    <td><div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                 aria-valuemin="0" aria-valuemax="100" style="width:<?php if($row['bids_by_lender']){
                                     $loan_amount_percent = 0;
                                     foreach ($row['bids_by_lender'] AS $bid){
                                      $loan_amount_percent += $bid['loan_amount'];
                                     }
                            } ?><?=$loan_amount_percent?>%">
                                <?=$loan_amount_percent?>%
                            </div>
                        </div></td>
                      <td><?php
                          $loan_date = date('Y-m-d', strtotime($row['date_added']));
                          $date = new DateTime($loan_date);
                          $date->modify("+14 day");
                          $future_14_days = $date->format("Y-m-d");

                          $current_date = date('Y-m-d');

                          $seconds = strtotime($future_14_days) - strtotime($current_date);

                          echo $days    = floor($seconds / 86400);

                          ?> Days</td>
                    <td>Active</td>
                    <td><a href="<?php echo base_url(); ?>p2padmin/viewapplication/<?php echo $row['PLRN']?>"><input type="button" class="btn btn-primary" value="View"></a></td>

                  </tr>
                  <? $i++;}}else
				  {?>
                  <tr>
                  	<td colspan="9">No Records Found!</td>
                  </tr>
                  <? }?>
                </tbody>
                <tfoot>
                  <tr> <td colspan="12">
                      <?php

                      //echo $pagination;

                      ?></td></tr>
                    
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- .left-aside-column--> 
        
      </div>
      <!-- /.left-right-aside-column--> 
    </div>
  </div>
</div>

<script>
$(window).load(function() {
	$('li').removeClass('active1');
	$('.user div').removeClass('collapse');
	$('.list-users').addClass('active1');
});
</script>