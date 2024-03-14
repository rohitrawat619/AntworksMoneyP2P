<?=getNotificationHtml();?>
<div class="row">
  <div class="col-md-4 col-xs-12">
    <div class="white-box">
      <div class="user-bg"> <img width="100%" alt="" src=""> </div>
      <div class="user-btm-box"> 
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-6 b-r"><strong>Name</strong>
            <p><?=$lender['lender_id'];?></p>
          </div>
            <div class="col-md-6 b-r"><strong>Name</strong>
            <p><?=$lender['name'];?></p>
          </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-6 b-r"><strong>Email ID</strong>
            <p><?=$lender['email'];?></p>
          </div>
          <div class="col-md-6"><strong>Phone</strong>
            <p><?=$lender['mobile'];?></p>
          </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- .row -->
        <div class="row text-center m-t-10">
          <div class="col-md-12"><strong>Address</strong>
            <p><?=$lender['address'];?><br/>
              <?=$lender['city'];?>, India.</p>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-xs-12">
    <div class="white-box"> 
      <!-- .tabs -->
      <ul class="nav nav-tabs tabs customtab">
       <li class="active tab"><a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a> </li>
<!--        <li class="tab"><a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Edit Detail</span> </a> </li>-->
      </ul>
      <!-- /.tabs -->
      <div class="tab-content"> 
        <!-- .tabs2 -->
        <div class="tab-pane active" id="profile">
          <div class="row">
            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong> <br>
              <p class="text-muted"><?=$lender['name'];;?></p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong> <br>
              <p class="text-muted"><?=$lender['mobile'];?></p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong> <br>
              <p class="text-muted"><?=$lender['email'];?></p>
            </div>
            <div class="col-md-3 col-xs-6"> <strong>Location</strong> <br>
              <p class="text-muted"><?=$lender['city'];?></p>
            </div>
          </div> 
        
        </div>
        <!-- /.tabs2 --> 
        <!-- .tabs3 -->
        <div class="tab-pane" id="settings">
          <form class="form-horizontal form-material" action="<? echo base_url();?>management/update_user/<? echo $lender['user_id'];?>" method="post" onsubmit="return edit_user_valid()" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-md-12">Change Password</label>
              <div class="col-md-12">
                <input type="text" name="password" name="password" class="form-control form-control-line">
                <span class="help-block with-errors"><ul class="list-unstyled"><li id="password-error" class="errors-class"></li></ul></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-12">First Name</label>
              <div class="col-md-12">
                <input type="text" name="name" id="name" value="<?=$lender['name'];?>" class="form-control form-control-line">
                <span class="help-block with-errors"><ul class="list-unstyled"><li id="first_name-error" class="errors-class"></li></ul></span>
              </div>
            </div>

            <div class="form-group">
              <label for="example-email" class="col-md-12">Email</label>
              <div class="col-md-12">
                <input type="email" name="email" id="email" value="<?=$lender['email'];?>" class="form-control form-control-line">
                <span class="help-block with-errors"><ul class="list-unstyled"><li id="email-error" class="errors-class"></li></ul></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-12">Phone No</label>
              <div class="col-md-12">
                <input type="text" name="mobile" id="mobile" value="<?=$lender['mobile'];?>" class="form-control form-control-line">
                <span class="help-block with-errors"><ul class="list-unstyled"><li id="mobile-error" class="errors-class"></li></ul></span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-12">Date of Birth</label>
              <div class="col-md-12">
                  <input type="text" name="dob" id="datepicker-autoclose" value="<?=$lender['dob'];?>" class="form-control form-control-line">
                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="datepicker-autoclose-error" class="errors-class"></li></ul></span>
              </div>
            </div>
            <div class="form-group">
                <label class="col-md-12">State</label>
                <div class="col-md-12">
                    <select class="form-control" name="state_code" id="state" onChange="get_city()" />
                        <option value=""></option>
                        <? $statelist = $this->P2padminmodel->get_state();
                        foreach($statelist as $row)
                        {
							$sel = "";
							if($row['state_code'] == $lender['state'])
							{
								$sel = " selected";
							}
                            echo '<option value="'.$row['state_code'].'" '.$sel.'>'.$row['state_name'].'</option>';
                        }
                        ?>
                    </select>
                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="state-error" class="errors-class"></li></ul></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12">City</label>
                <div class="col-md-12">
                     <select class="form-control" name="city" id="city" />
                        <option value="<?=$lender['city'];?>"><?=$lender['city'];?></option>
                    </select>
                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="city-error" class="errors-class"></li></ul></span>
                </div>
            </div>
            <div class="form-group">
              <label class="col-md-12">Address</label>
              <div class="col-md-12">
                   <input type="text" name="address" id="address" class="form-control form-control-line" placeholder="Address" value="<?=$lender['address1'];?>">
                   <span class="help-block with-errors"><ul class="list-unstyled"><li id="address-error" class="errors-class"></li></ul></span>
              </div>
            </div>
            <div class="form-group">
              <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Change Contact Image</span>
                <input type="file" name="profilepic" id="profilepic" class="upload">
              </div>
              <span class="help-block with-errors"><ul class="list-unstyled"><li id="profilepic-error" class="errors-class"></li></ul></span>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-success">Update Profile</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.tabs3 --> 
      </div>
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