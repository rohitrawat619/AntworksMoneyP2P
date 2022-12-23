<?=getNotificationHtml();?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/CryptoJS/rollups/sha512.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
<style>




    .modal-profile-pic {
        width: 100%;
        height: 140px;
        margin: 0 auto;
        background: #fff;

    }
	.profile-username {margin-bottom:0; margin-top: 35px;}
	#update_lender_image p .small, small {font-size:11px;}
	#update_image {margin-top: 20px; width: auto; font-size: 12px; padding: 4px 10px; text-transform: inherit;}

    #mediaFile {
        position: absolute;
        top: -1000px;
    }

    #profile {
        border-radius: 100%;
        width: 160px;
        height: 160px;
        margin: 0 auto;
        position: relative;
        top: -20px;
        margin-bottom: -30px;
        cursor: pointer;
        background: #f4f4f4;
        display: table;
        background-size: cover;
        background-position: center center;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.35);
    }
    #profile .dashes {
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 100%;
        width: 100%;
        height: 100%;
        border: 4px dashed #ddd;
        opacity: 1;
    }
    #profile label {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        padding: 0 30px;
        color: grey;
        opacity: 1;
    }
    #profile.dragging {
        background-image: none !important;
    }
    #profile.dragging .dashes {
        -webkit-animation-duration: 10s;
        animation-duration: 10s;
        -webkit-animation-name: spin;
        animation-name: spin;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;
        animation-timing-function: linear;
        opacity: 1 !important;
    }
    #profile.dragging label {
        opacity: 0.5 !important;
    }
    #profile.hasImage .dashes, #profile.hasImage label {
        opacity: 0;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    h1 {
        text-align: center;
        font-size: 28px;
        font-weight: normal;
        letter-spacing: 1px;
    }

    .stat {
        width: 50%;
        text-align: center;
        float: left;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
    .stat .label {
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .stat .num {
        font-size: 21px;
        padding: 3px 0;
    }

    .editable {
        position: relative;
    }
    .editable i {
        position: absolute;
        top: 10px;
        right: -20px;
        opacity: 0.3;
    }

    button {
        width: 100%;
        -webkit-appearance: none;
        line-height: 40px;
        color: #fff;
        border: none;
        background-color: #ea4c89;
        margin-top: 30px;
        font-size: 13px;
        -webkit-font-smoothing: antialiased;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

</style>
<div class="row">
  <div class="col-md-12 col-xs-12">
	<div class="mytitle row">
		<div class="left col-md-12">
			<h1 id="pagetitle"><?=$pageTitle;?></h1>
		</div>
	</div>

	<div class="white-box">


		    <div class="form-bg">
			<!--div class="col-md-12">
				<div class="progress progress-profile m-b-10">
					<div class="progress-bar progress-bar-success" style="width:30%;" role="progressbar">30%</div>100%
				</div>
			</div-->
			<div class="row">
			<div class="col-md-3">
				<div class="box box-primary prof-pic">
					<div class="box-body box-profile">
                      <form id="update_lender_image" action="<?php echo base_url().'lenderaction/updateProfilePic'; ?>" method="post" enctype="multipart/form-data">
                          <div class="browse-btn">
                              <div class="table">
                                  <div class="table-cell">
                                      <div class="modal-profile-pic">
                                          <div id="profile">
                                              <div class="dashes"></div>
                                              <label>Click to browse or drag an image here</label></div>
                                          <button id="update_image" class="btn btn-primary hide">Update</button>
                                      </div>
                                  </div>
                              </div>
                              <input type="file" name="selfiImage" id="mediaFile" value="<?php if($selfiImage){echo base_url().'assets/lender-documents'.$selfiImage;} ?>" />
                          </div>
                      </form>
					  <h3 class="profile-username text-center"><?=$profileinfo->name;?></h3>
					  <p><small><strong>Last Login:</strong> <?=$last_login_time?></small></p>
					  <ul class="prof-edit"><li><a href="javascript:void(0)" onclick="return resetPassword()">Reset Password</a></li></ul>
					  <a href="<?php echo base_url(); ?>login/logout/" class="btn btn-primary"><i class="fa fa-power-off"></i> <b>Sign Out</b></a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
            <div class="basic-details">
                <div class="col-md-9">
                  <div class="nav-tabs-custom">
                      <fieldset disabled="disabled">
                        <!-- Post -->
                        <div class="row">
                        <div class="col-md-12">
                            <h3 class="lender-prof-hd"><i class="ti-user"></i> Basic Details</h3>
							<div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12">Full Name*</label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?=$profileinfo->name;?>" name="name" class="form-control">
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="name_error" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12">Email*</label>
                              <div class="col-md-12">
                                <input type="text" value="<?=$profileinfo->email;?>" class="form-control" readonly="readonly">
                                <span class="help-block with-errors"><ul class="list-unstyled"><li id="username-error" class="errors-class"></li></ul></span>
                              </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12">Phone No*</label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?=$profileinfo->mobile;?>" class="form-control" readonly="readonly">
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="mobile-error" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                            </div>
                            </div>
							<div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12">Gender*</label>
                              <div class="col-md-12">
                                <select class="form-control" name="gender" id="gender" />
                                    <? 	if($profileinfo->gender == 1)
                                        {
                                            $male = " selected";
                                        }
                                        if($profileinfo->gender == 2)
                                        {
                                            $female = " selected";
                                        }
                                    ?>
                                    <option value="Male" <?=$male;?>>Male</option>
                                    <option value="Female" <?=$female;?>>Female</option>

                                </select>
                                <span class="help-block with-errors"><ul class="list-unstyled"><li id="gender-error" class="errors-class"></li></ul></span>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12">Date of Birth*</label>
                              <div class="col-md-12">
                                  <input type="text" name="dob" id="datepicker-autoclose" value="<?=$profileinfo->dob;?>" class="form-control">
                                  <span class="help-block with-errors"><ul class="list-unstyled"><li id="datepicker-autoclose-error" class="errors-class"></li></ul></span>
                              </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                              <label class="col-md-12">Pan*</label>
                              <div class="col-md-12">
                                  <input type="text" name="pan" value="<?=$profileinfo->pan;?>" class="form-control">
                              </div>
                            </div>
                            </div>
                            </div>
							<div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12">Occupation*</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="occupation" id="occupation" />
                                        <?  $occupation_details = $this->Lendermodelbackend->get_occuption();
                                        foreach($occupation_details as $row){
                                            $sel = "";
                                            if($row->id == $profileinfo->occupation)
                                            {
                                                $sel = " selected";
                                            }
                                            echo '<option value="'.$row->id.'" '.$sel.'>'.$row->name.'</option>';
                                        }
                                        ?>
                                        </select>
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="occupation-error" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- /.post -->

                      <!-- /.tab-pane -->
                          <div class="row">
                              <div class="col-md-12">
                                <h3 class="lender-prof-hd"><i class="ti-home"></i> Address Details</h3>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12">Address</label>
                                        <div class="col-md-12">
                                            <input type="text" name="address1" id="address1" value="<?=$profileinfo->address1;?>" class="form-control">
                                            <span class="help-block with-errors"><ul class="list-unstyled"><li id="address1_error" class="errors-class"></li></ul></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-12">City</label>
                                        <div class="col-md-12">
                                            <input type="text" name="city" id="city" value="<?=$profileinfo->city;?>" class="form-control">
                                            <span class="help-block with-errors"><ul class="list-unstyled"><li id="city_error" class="errors-class"></li></ul></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-12">State</label>
                                <div class="col-md-12">
                                    <input type="text" name="state" id="state" value="<?=$profileinfo->state;?>" class="form-control">
                                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="account_number_error" class="errors-class"></li></ul></span>
                                </div>
                            </div>
                        </div>
                                <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-12">Pincode</label>
                                <div class="col-md-12">
                                    <input type="text" name="pincode" id="pincode" value="<?=$profileinfo->pincode;?>" class="form-control">
                                    <span class="help-block with-errors"><ul class="list-unstyled"><li id="pincode_error" class="errors-class"></li></ul></span>
                                </div>
                            </div>
                        </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                <h3 class="lender-prof-hd"><i class="ti-briefcase"></i> Account Details</h3>
                                <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="col-md-12">Bank Name</label>
                                          <div class="col-md-12">
                                              <input type="text" name="bank_no" id="bank_no" value="<?=$profileinfo->bank_name;?>" class="form-control">
                                              <span class="help-block with-errors"><ul class="list-unstyled"><li id="account_number_error" class="errors-class"></li></ul></span>
                                          </div>
                                      </div>
                                  </div>
                                <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="col-md-12">Account Number</label>
                                          <div class="col-md-12">
                                              <input type="text" name="account_number" id="account_number" value="<?=$profileinfo->account_number;?>" class="form-control">
                                              <span class="help-block with-errors"><ul class="list-unstyled"><li id="account_number_error" class="errors-class"></li></ul></span>
                                          </div>
                                      </div>
                                  </div>
                                <div class="col-md-4">
                              <div class="form-group">
                                  <label class="col-md-12">Ifsc Code</label>
                                  <div class="col-md-12">
                                      <input type="text" name="ifsc_code" id="ifsc_code" value="<?=$profileinfo->ifsc_code;?>" class="form-control">
                                      <span class="help-block with-errors"><ul class="list-unstyled"><li id="ifsc_code_error" class="errors-class"></li></ul></span>
                                  </div>
                              </div>
                          </div>
                              </div>
                          </div>

                      <!-- /.tab-pane -->



                    </fieldset>
                    <!-- /.tab-content -->
                  </div>
                  <!-- /.nav-tabs-custom -->


                </div>
                </div>
            <div class="change-password hide">

                    <div class="col-md-9">
                        <div class="col-md-10"></div><div class="col-md-2 changepassword-close"> <button class="right"><i class="fa fa-times" aria-hidden="true"></i></button></div>
                        <form id="change_password_lender" method="post" onsubmit="return enc_change_password_lender()" action="<?=base_url()?>lenderaction/changePassword">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Old Password*</label>
                                    <div class="col-md-12">
                                        <input type="password" name="old_pwd" id="old_pwd" class="form-control">
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="error_old_pwd" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">New Password*</label>
                                    <div class="col-md-12">
                                        <input type="password" name="pwd" id="pwd" class="form-control">
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="error_pwd" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Confirm Password*</label>
                                    <div class="col-md-12">
                                        <input type="password" name="cpwd" id="cpwd" class="form-control">
                                        <span class="help-block with-errors"><ul class="list-unstyled"><li id="error_cpwd" class="errors-class"></li></ul></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

		  </div>


    </div>
  </div>
</div>
</div>

<script>
$(window).load(function() {
	$('li').removeClass('active1');
	//$('.user div').removeClass('collapse');
	$('.profile').addClass('sidebarmenu-active');
});
</script>

<script>
    // ----- On render -----
    $(function() {
        var selfiImage = "<?php if($selfiImage){echo base_url().'assets/lender-documents/'.$selfiImage;} else{echo '';} ?>"
        if(selfiImage)
        {
            $('#profile').css('background-image', 'url(' + selfiImage + ')').addClass('hasImage');
        }
        else{

        }
        $('#profile').addClass('dragging').removeClass('dragging');
    });

    $('#profile').on('dragover', function() {
        $('#profile').addClass('dragging')
    }).on('dragleave', function() {
        $('#profile').removeClass('dragging')
    }).on('drop', function(e) {
        $('#profile').removeClass('dragging hasImage');

        if (e.originalEvent) {
            var file = e.originalEvent.dataTransfer.files[0];
            console.log(file);

            var reader = new FileReader();

            //attach event handlers here...

            reader.readAsDataURL(file);
            reader.onload = function(e) {
                $('#profile').css('background-image', 'url(' + reader.result + ')').addClass('hasImage');
                $('#update_image').removeClass('hide');
            }

        }
    })
    $('#profile').on('click', function(e) {
        $('#mediaFile').click();
    });
    window.addEventListener("dragover", function(e) {
        e = e || event;
        e.preventDefault();
    }, false);
    window.addEventListener("drop", function(e) {
        e = e || event;
        e.preventDefault();
    }, false);
    $('#mediaFile').change(function(e) {

        var input = e.target;
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = function(e) {
                $('#profile').css('background-image', 'url(' + reader.result + ')').addClass('hasImage');
                $('#update_image').removeClass('hide');
            }
        }
    })
</script>
<script>
    $("input").keypress(function () {
        $("#error_"+this.id).html("");
    });
    function resetPassword() {
     $("#pagetitle").html('Change Password');
     $(".basic-details").hide();
     $(".change-password").removeClass('hide');
    }
    $(".changepassword-close").click(function () {
        $("#pagetitle").html('My Profile');
        $(".basic-details").show();
        $(".change-password").addClass('hide');
    })
</script>
<script src="<?=base_url();?>assets/js/encryption-login.js"></script>