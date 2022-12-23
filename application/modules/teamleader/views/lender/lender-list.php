<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-12">
    <div class="white-box p-0"> 
      <!-- .left-right-aside-column-->
      <div class="page-aside">
          <div class="m-t-30">
             <!-- <div class="right-page-header">
                  <form method="" action="<?php /*echo base_url(); */?>creditops/lender_search">
                      <div class="col-md-12">
                          <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="email" placeholder="Email" class="form-control" id="pan">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="text" name="lender_id" placeholder="Lender_ID"  class="form-control" id="pan">
                              </div>
                          </div>
                          <div class="col-md-3">    
                            <div class="form-group">
                                <input type="text" name="mobile" placeholder="Phone no" class="form-control" id="pan">
                            </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <input type="submit" id="search" value="Search" name="search" class="btn btn-primary">
                              </div>
                          </div>

                      </div>

                  </form>
              </div>-->
          </div>
        <!-- .left-aside-column-->
        <!-- /.left-aside-column-->
        <div class="">
          <div class="right-page-header">
          </div>
          <div class="clearfix"></div>
          <div class="scrollable">
            <div class="table-responsive">
              <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Lender ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Added date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
				  <? 	if($list){
					  	$i=1;
                      	foreach($list as $row){
							if($row['status']==1)
							{
								$status = '<span class="label label-success">Verified</span>';
							}
							else if($row['status']==0)
							{
								$status = '<span class="label label-danger">Not Verified</span>';
							}
                  ?>
                  <tr>
                    <td><?=$i;?></td>
                    <td><?=$row['lender_id'];?></td>
                    <td><a href="<?=base_url();?>teamleader/viewlender/<?=$row['user_id'];?>"> <?= $row['name'] ;?></a></td>
                    <td><?=$row['email'];?></td>
                    <td><?=$row['mobile'];?></td>
                    <td><?=(date('Y')-date('Y',strtotime($row['dob'])));?></td>
                    <td><?=$ff = date('Y-m-d', strtotime($row['created_date']));?></td>
                    <td><?=$status;?></td>
                    <td><a href="<?=base_url();?>management/delete_user/<?=$row['user_id'];?>" onclick="return confirm_delete()"><button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline" title="Delete"><i class="ti-close" aria-hidden="true"></i></button></a></td>
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
