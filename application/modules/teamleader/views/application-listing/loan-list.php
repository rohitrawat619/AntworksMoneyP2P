<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-12">
    <div class="white-box p-0"> 
      <!-- .left-right-aside-column-->
      <div class="page-aside">
          <div class="m-t-30">
              <div class="right-page-header">
                  <form method="post" action="<?php echo base_url(); ?>creditops/approved_search/">
                      <div class="col-md-12">
                          <div class="col-md-3">
							  <div class="form-group">
								  <input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date">
							  </div>
						  </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="loan_id" placeholder="Loan ID" class="form-control" id="pan">
                              </div>
                          </div>
						  <div class="col-md-3">
							  <div class="form-group">
								  <input type="text" name="name" placeholder="Brrower Name" class="form-control" id="b_name">
							  </div>
						  </div>


                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="submit" id="search" value="Search" name="submit" class="btn btn-primary">
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
				  	<th>Lender Name</th>
                    <th>Borrower Name</th>
                    <th>Loan Applied Date</th>
                    <th>Loan Amount</th>
                    <th>Response</th>
                    <th>Rate of Interest</th>
                    <th>Tenure</th>
				  	<th>Accept Borrower</th>
			  		<th>Accept Lender</th>
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
                    <td><?= $row['loan_no'] ;?></td>
					  <td><?php
						 echo $row['lenderName'];?></td>
                    <td><?=$row['borrowerName'];?></td>
					  <td><?php
						  $pubdate=$row['date_added'];
						  $da = strtotime($pubdate);
						  echo $dat = date('Y-m-d', $da);
						  ?>
					  </td>
                    <td><?=$row['loan_amount'];?></td>
					  <td><div class="progress">
							  <div class="progress-bar" role="progressbar" aria-valuenow="70"
								   aria-valuemin="0" aria-valuemax="100" style="width:<?php if($row['bids_by_lender']){
								  $loan_amount_percent = 0;
								  foreach ($row['bids_by_lender'] AS $bid){
									  $loan_amount_percent += $bid['loan_amount'];
								  }
							  } ?><?=$loan_amount_percent?>%">
								  <?=$row['loan_amount'];?>%
							  </div>
						  </div></td>
                    <td><?=$row['accepted_interest_rate'];?>%</td>
                    <td><?=$row['tenor_months'];?> Months</td>

					  <td><?php
							  if ($row['borrower_signature'] == 1) {
								  echo "<i class='fa fa-check'></i>";
							  } else {
								  echo "<i class='fa fa-times'></i>";
							  }
						  ?>
					  </td>
					  <td><?php
							  if ($row['lender_signature'] == 1) {
								  echo "<i class='fa fa-check'></i>";
							  } else {
								  echo "<i class='fa fa-times'></i>";
							  }
						  ?></td>
                    <td><a href="<?php echo base_url(); ?>creditops/viewapplication/<?php echo $row['PLRN']?>"><input type="button" class="btn btn-primary" value="View"></a></td>

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

                      echo $pagination;

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

