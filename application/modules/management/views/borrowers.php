<style type="text/css">
  .navi {
    width: 500px;
    margin: 5px;
    padding:2px 5px;
    border:1px solid #eee;
  }

  .show {
    color: blue;
    margin: 5px 0;
    padding: 3px 5px;
    cursor: pointer;
    font: 15px/19px Arial,Helvetica,sans-serif;
  }
  .show a {
    text-decoration: none;
  }
  .show:hover {
    text-decoration: underline;
  }


  ul.setPaginate li.setPage{
    padding:15px 10px;
    font-size:14px;
  }

  ul.setPaginate{
    margin:0px;
    padding:0px;
    height:100%;
    overflow:hidden;
    font:12px 'Tahoma';
    list-style-type:none;
  }

  ul.setPaginate li.dot{padding: 3px 0;}

  ul.setPaginate li{
    float:left;
    margin:0px;
    padding:0px;
    margin-left:5px;
  }



  ul.setPaginate li a
  {
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #cccccc;
    color: #999999;
    display: inline-block;
    font: 15px/25px Arial,Helvetica,sans-serif;
    margin: 5px 3px 0 0;
    padding: 0 5px;
    text-align: center;
    text-decoration: none;
  }

  ul.setPaginate li a:hover,
  ul.setPaginate li a.current_page
  {
    background: none repeat scroll 0 0 #0d92e1;
    border: 1px solid #000000;
    color: #ffffff;
    text-decoration: none;
  }

  ul.setPaginate li a{
    color:black;
    display:block;
    text-decoration:none;
    padding:5px 8px;
    text-decoration: none;
  }

</style>
<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-12">
    <div class="white-box p-0"> 
      <!-- .left-right-aside-column-->
      <div class="page-aside"> 
        <!-- .left-aside-column-->
        <!-- /.left-aside-column-->
        <div class="">
          <div class="right-page-header">
            <div class="pull-right">
              <input type="text" id="demo-input-search2" placeholder="search users" class="form-control">
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="scrollable">
            <div class="table-responsive">
              <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="100">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Age</th>
                    <th>Added date</th>
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
                    <td><a href="<?=base_url();?>management/edit_user/<?=$row['id'];?>"> <?=$fullname;?></a></td>
                    <td><?=$row['email'];?></td>
                    <td><?=$row['mobile'];?></td>
                    <td><span class="label label-info"><?=ucwords($this->Managementmodel->rolebyid($row['role']));?></span></td>
                    <td><?=(date('Y')-date('Y',strtotime($row['dob'])));?></td>
                    <td><?=$ff = date('Y-m-d', strtotime($row['date_added']));?></td>
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
                  <tr>
                    <td colspan="2"><button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#add-contact">Add New Contact</button></td>
                    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                      <form action="<?=base_url();?>management/register_user/" method="post" enctype="multipart/form-data" novalidate="novalidate" onsubmit="return add_user_valid()">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">Add New User</h4>
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

                  <tr> <td colspan="12">
                      <?php

                      echo $displayPaginationBelowborrower;

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