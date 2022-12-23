<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-12">
    <div class="white-box p-0"> 
      <!-- .left-right-aside-column-->
      <div class="page-aside"> 
        <!-- .left-aside-column-->
        <!--<div class="right-aside">-->
          <div class="right-page-header">
            <div class="pull-right">
              <input type="text" id="demo-input-search2" placeholder="search users" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="scrollable">
            <div class="table-responsive">
              <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Antworks Rating</th>
                    <th>Status</th>
                    <th>Action</th>
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
							
							$fullname = $row['first_name'];
							if($row['middle_name']){
								$fullname .= " ".$row['middle_name'];
							}if($row['last_name']){
								$fullname .= " ".$row['last_name'];
							}
                  ?>
                  <tr>
                    <td><?=$i;?></td>
                    <td><?=$fullname;?></td>
                    <td><?=$row['email'];?></td>
                    <td><?=$row['antworks_rating'];?></td>
                    <td><?=$status;?></td>
                    <td><a><button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline" data-toggle="modal" data-target=".credit_ops" title="Update Details"><i class="fa fa-edit" aria-hidden="true" style="font-size:15px"></i></button></a></td>
                  </tr>
                  <? $i++;}}else
				  {?>
                  <tr>
                  	<td colspan="9">No Records Found!</td>
                  </tr>
                  <? }?>
                </tbody>
                <tfoot>
                  <tr>
                    <div class="modal fade in credit_ops" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                      <form action="<?=base_url();?>management/update_user_details/" method="post" enctype="multipart/form-data" novalidate="novalidate" onsubmit="return add_user_valid()">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Update User Details</h4>
                          </div>
                          <div class="modal-body">
                            <from class="form-horizontal form-material">
                              <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="username" id="username" class="form-control" placeholder="Type Username">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="username-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="password-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Type First Name">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="first_name-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Type Middle Name">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="middle_name-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Type Last Name">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="last_name-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="email-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="mobile" id="mobile" onkeypress="return isNumberKey(event);" class="form-control" placeholder="Phone" maxlength="10">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="mobile-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="dob" class="form-control" id="datepicker-autoclose" placeholder="DOB">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="datepicker-autoclose-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                   	<select class="form-control" name="gender" id="gender" />
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="gender-error" class="errors-class"></li></ul></span>
                                </div>	
                                <div class="col-md-12 m-b-20">
                                   	<select class="form-control" name="state_code" id="state" onChange="get_city()" />
                                        <option value="">Select State</option>
                                        <? $statelist = $this->Requestmodel->state_list();
                                        foreach($statelist as $row)
                                        {
                                            echo '<option value="'.$row['state_code'].'">'.$row['state_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="state-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                               		<select class="form-control" name="city" id="city" />
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="city-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="address-error" class="errors-class"></li></ul></span>
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <select class="form-control form-control-line" name="role">
                                      <?	$rolelist = $this->Managementmodel->activerolelist();
                                            foreach($rolelist as $row){
                                                $active="";
                                                if($row['role_id']==$editlist['role']){$active=" selected";}
                                      ?>
                                      <option value="<?=$row['role_id'];?>" <?=$active;?>><?=ucwords($row['role']);?></option>
                                      <? }?>
                                    </select>
                                </div>
                                <div class="col-md-12 m-b-20">
                                  <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                    <input type="file" name="profilepic" id="profilepic" class="upload">
                                  </div>
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="profilepic-error" class="errors-class"></li></ul></span>
                                </div>
                              </div>
                            </from>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-info waves-effect">Save</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </form>
                        <!-- /.modal-content --> 
                      </div>
                      <!-- /.modal-dialog --> 
                    </div>
                   
                    <td colspan="7"><div class="text-right">
                         <? if($this->Managementmodel->countusers()>10){?><ul class="pagination"></ul><? }?>
                      </div></td>
                    
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        <!--</div>-->
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