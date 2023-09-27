<style>	
.borrower-hd {font-size:30px; text-align:center; margin-bottom:30px;} 
.borrower-hd span {font-weight:600;} 
.borrower-profile {margin:0 auto; padding:50px; text-align:center; width:100%; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #cecaca; border-radius:60px; margin-top:160px;}
.borrowerpic img {width:150px; height:150px; border-radius:150px; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #d4d4d4; margin-top:-120px;}
.borrower-criteria {margin:0 0 30px 0; padding:0;}
.borrower-criteria li{display:inline-block; padding-right:20px; color:#7e7e7e; font-size:14px; font-weight:600;}
.borrower-criteria li span {color:#000; font-size:18px; display:block;}
.borrower-criteria li:last-child{padding-right:0;}
.lending-box {margin:50px 0;}
.borrower-btn {text-align:center;}
.borrower-btn button {border-radius:30px; padding:10px 50px;}
.other-amount {margin-top:30px; font-size:18px;}
.amount-entr {width:60%; display:inline-block; text-align:center; padding:25px 10px; border-radius:50px!important;}
.btn-submit-amount {margin-top:15px;}

.register-hd {font-size:28px; font-weight:600; color:#000;}

.f1 {padding: 25px; background: #fff; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;}
.f1 h3 { margin-top: 0; margin-bottom: 5px; text-transform: uppercase;}
.f1 .form-group {margin-bottom: 5px;}
.f1-steps { overflow: hidden; position: relative; margin: 20px 30px 0 30px; }
.f1-progress { position: absolute; top: 24px; left: 12%; width: 75%; height: 4px; background: #ddd;}
.f1-progress-line { position: absolute; top: 0; left: 0; height: 4px; background: #004566;}
.f1-step { position: relative; float: left; width:50%; padding: 0; text-align: center;}
.f1-step-icon {display: inline-block;  text-align:center; width: 40px; height: 40px; margin-top: 4px; background: #ddd; font-size: 16px; color: #fff; line-height: 40px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;}
.f1-step.activated .f1-step-icon {background: #fff; border: 1px solid #004566; color: #fff; line-height: 48px; width: 48px; height: 48px; margin-top: 0; background: #004566;}
.f1-step.active .f1-step-icon {width: 48px; height: 48px; margin-top: 0; background: #004566; font-size: 22px; line-height: 48px;}
.f1-step p {color: #ccc;}
.f1-step.activated p {color:#004566;}
.f1-step.active p {color:#004566;}
.f1 fieldset {display: none; text-align:left;}
.f1-buttons {text-align: right;}
.f1 .input-error { border-color: red !important;}
.f1 fieldset [class^="col-"] {padding:0 5px;}
.f1 label {font-size:14px; color:#595959; font-weight:400;}
.f1 label span {color:#fe0000; font-size:15px;}
.pas-tips {font-size:11px; color: #222; line-height:12px; display: inline-block; margin-top:5px;}
#send_otp button {float:right; border: none; background: #014667; color:#fff; margin-top:-10px; border-radius:3px; font-size:11px; padding:5px 10px;}
.f1-buttons button {background:#b61e37; width:96px; color:#fff; border-radius:20px;}
.f1-buttons {width:100%; float:left; padding:10px 0;}
.f1-buttons button:hover {color:#fff;}
.f1-buttons .btn-previous {float:left;}
.f1-step .f1-progress-line {display:none;}
</style>
<section class="sec-pad service-box-one service">
    <div class="container">
        <!-- /.sec-title -->
        <div class="row">
            <div class="col-md-12">
				<div class="col-md-2"></div>
					<div class="col-md-8">
						<div class="col-md-12 col-xs-12 whitebg pull-right">
							<div class="col-md-12 np">
								<!-- <form action="registration_borrower"   method="post" class="f1" id="borrower_registration_payment"  onsubmit="return userFunctionvalidate()">  -->
							<form role="form" action="borrower_payment"  method="post" class="f1" onsubmit="return userFunctionvalidate()">
								<?php
									$error_message = $this->session->flashdata('error_message');
									if ($error_message) {
										echo '<div id="errorDiv" class="alert alert-danger">' . $error_message . '</div>';
									}
								?>
									<h2 class="register-hd">Register yourself in 2 easy steps in less than 5 mins.</h2>
									<div class="f1-steps">
										<div class="f1-progress">
											<div class="f1-progress-line" data-now-value="33.33333" data-number-of-steps="3" style="width: 33.33333%;"></div>
										</div>
										<div class="f1-step active" id="step_1">
											<div class="f1-step-icon"><i class="fa fa-user"></i></div>
											<p>Personal Details</p>
										</div>
										<div class="f1-step" id="step_2">
											<div class="f1-step-icon"><i class="fa fa-bank"></i></div>
											<p>Banking Details</p>
										</div>
									</div>
									
									<fieldset>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<input type="text" name="name" placeholder="Full name as per PAN card" class="f1-first-name form-control" id="name">
												<span class="validation error-validation" id="error_name"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<input class="form-control" name="dob" id="datepicker" readonly="" placeholder="Date of Birth" type="text">
												<span class="validation error-validation" id="error_datepicker"></span>
											</div>
										</div>
									<!--	<div class="col-md-6 col-xs-6">
											<div class="form-group">
												<select class="form-control" name="gender" id="gender" >
													<option value="">Select Gender</option>
													<option value="1">Male</option>
													<option value="2">Female</option>
													<option value="3">Other</option>
												</select>
												<span class="validation error-validation" id="error_gender"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-6">
											<div class="form-group">
												<select class="form-control" name="highest_qualification" id="highest_qualification" />
												<option value="">Select Qualification</option>
												<option value='1'>Undergraduate</option><option value='2'>Graduate</option><option value='3'>Post Graduate</option><option value='4'>Professional</option><option value='5'>Other</option>                                    </select>
												<span class="validation error-validation" id="error_highest_qualification"></span>
											</div>
										</div> !-->
										<div class="col-md-6 col-xs-12">
											<div class="form-group">
											<input type="hidden" name="borrower_id" value="<?php echo $borrower_id ?>">
												<input class="form-control" placeholder="Email" type="text" name="email" id="email" value="" onkeyup="checkExist(this.value)">
												<span class="validation error-validation" id="error_email"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="col-md-10 col-xs-10 mno">
												<div class="form-group">
													<input class="form-control" placeholder="Mobile" type="text" name="mobile" id="mobile" value="" maxlength="10" onkeypress="return isNumberKey(event)">
													<span class="validation error-validation" id="error_mobile"></span>
												</div>
											</div>
											<div class="col-md-2 col-xs-2 otp-borrower" id="resend_otp_borrower">
												<div class="form-group otp-borrower">
													<button class="btn btn-primary" name="resend_otp" id="resend_otp" onclick="sendOtp()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
													<span class="validation error-validation" id="error_resend_otp"></span>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-xs-6" id="verify_otp_main" style="display: none">
											<div class="form-group">
												<input class="form-control" type="text" name="verify_otp" placeholder="Verify OTP" id="verify_otp" maxlength="6" onkeyup="verifyOtp(this.value);" onkeypress="return isNumberKey(event)">
												<span class="validation error-validation" id="error_verify_otp"></span>
											</div>
										</div>

										<div class="col-md-6 col-xs-12">
											
											<div class="form-group">
												<input class="form-control" type="text" name="pan" placeholder="Pancard No" id="pan" value="" maxlength="10" onkeyup="checkExistpan(this.value)">
												<span class="validation error-validation" id="error_pan"></span>
											
											</div>
										</div>

									<!--	<div class="col-md-6 col-xs-6">
											<div class="form-group">
												<input class="form-control" placeholder="Password" type="password" name="password" id="password" onclick="showpasswordstrength();">
												<div class="password_strength" style="display: none;"><span style="color: #286090;">Use at least one letter, one capital letter, one number , one special character and minimum 8 characters long.</span>
													<meter max="4" id="password-strength-meter"></meter>
													<p id="password-strength-text"></p>
												</div>
												<span class="validation error-validation" id="error_password"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-6">
											<div class="form-group">
												<input class="form-control" placeholder="Confirm Password" type="password" name="cpassword" id="cpassword">
												<span class="validation error-validation" id="error_cpassword"></span>
											</div>
										</div> !-->
									<!--	<div class="f1-buttons">
											<button type="button" class="btn btn-next">Next</button>
										</div> !-->
										<div class="f1-buttons">
   										<button type="button" class="btn btn-next" id="nextButton">Next</button>
										</div>

									</fieldset>

									<fieldset>
										<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input class="form-control" placeholder="Account No." type="text" name="account" id="account" value="" onkeyup="checkExist(this.value)">
													<span class="validation error-validation" id="error_account"></span>
												</div>
											</div>

											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input class="form-control" placeholder="Confirm Account No." type="text" name="confirmaccount" id="confirmaccount" value="" onkeyup="checkExist(this.value)">
													<span class="validation error-validation" id="error_confirmaccount"></span>
													<div id="accountMatchError" style="color: red; display: none;">Account numbers do not match.</div>
												</div>
											</div>
											
											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input class="form-control" placeholder="IFSC Code" type="text" name="ifsc" id="ifsc" value="" onkeyup="checkExist(this.value)">
													<span class="validation error-validation" id="error_ifsc"></span>
												</div>
											</div>

									<!--	<div class="col-md-6 col-xs-12">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Address 1" name="address1" id="address1" rows="3" autocomplete="off">
												<span class="validation error-validation" id="error_address1"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">

												<input type="text" class="form-control" placeholder="Address 2" name="address2" id="address2" rows="3" autocomplete="off">
												<span class="validation error-validation" id="error_address2"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">

												<select class="form-control" name="state_code" id="state" onChange="get_city()" />
												<option value="">Select State</option>
												<option value='01'>JAMMU and KASHMIR</option><option value='02'>HIMACHAL PRADESH</option><option value='03'>PUNJAB</option><option value='04'>CHANDIGARH</option><option value='05'> UTTRANCHAL</option><option value='06'>HARAYANA</option><option value='07'> DELHI</option><option value='08'>RAJASTHAN</option><option value='09'>UTTAR PRADESH</option><option value='10'>BIHAR</option><option value='11'>SIKKIM</option><option value='12'>ARUNACHAL PRADESH</option><option value='13'>NAGALAND</option><option value='14'>MANIPUR</option><option value='15'>MIZORAM</option><option value='16'>TRIPURA</option><option value='17'> MEGHALAYA</option><option value='18'>ASSAM</option><option value='19'>WEST BENGAL</option><option value='20'>JHARKHAND</option><option value='21'>ORRISA</option><option value='22'>CHHATTISGARH</option><option value='23'>MADHYA PRADESH</option><option value='24'>GUJRAT</option><option value='25'>DAMAN and DIU</option><option value='26'>DADARA and NAGAR HAVELI</option><option value='27'>MAHARASHTRA</option><option value='28'>ANDHRA PRADESH</option><option value='29'>KARNATAKA</option><option value='30'>GOA</option><option value='31'>LAKSHADWEEP</option><option value='32'>KERALA</option><option value='33'>TAMIL NADU</option><option value='34'>PONDICHERRY</option><option value='35'>ANDAMAN and NICOBAR ISLANDS</option><option value='36'>TELANGANA</option>                                    </select>
												<span class="validation error-validation" id="error_state"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">

												<select class="form-control" name="city" id="city" />

												</select>
												<span class="validation error-validation" id="error_city"></span>
											</div>
										</div>
										<div class="col-md-6 col-xs-12">
											<div class="form-group">

												<input class="form-control" type="text" placeholder="Pincode" name="pincode" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" >
												<span class="validation error-validation" id="error_pincode"></span>
											</div>
										</div> !-->
										<div class="col-md-12 col-xs-12">
											<div class="f1-buttons">
												<div class="terms-condtns">
													<label><input type="checkbox" name="term_and_condition" id="term_and_condition">I have read, understood, and I agree to the <a href="https://www.antworksp2p.com/term-and-conditions" target="_blank">Terms of Use</a> and <a href="https://www.antworksp2p.com/privacy-and-policy" target="_blank">Privacy Policy</a>. I undertake not to lend more than 10 lakh on all Peer to Peer (P2P) Platform.</label>
													<span id="error_term_and_condition" class="validation error-validation"></span>
												</div>
											<!--	<button type="button" class="btn btn-previous">Previous</button>!-->
												<input type="hidden" name="max_loan_preference" value="">
												<input type="hidden" name="max_tenor" value="">
												<input type="hidden" name="max_interest_rate" value="">
												<input type="hidden" name="ci_csrf_token" value="">
												
												<button type="submit" class="btn btn-next">Submit</button>
										<!--	<button type="submit" class="btn btn-submit" onclick="return checkAccountMatch1() && validation1()">Submit</button> !-->

											</div>
										</div>
									</fieldset>
								</form>
							</div>
						<!-- /.col-md-12 -->
						</div>
					</div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>


<script type="text/javascript" src="<?=base_url()?>assets/js/scripts-lender-social.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $("#btn-next").click(function() {
        // Gather form data
        var formData = $("form.f1").serialize();
        // Send AJAX request
        $.ajax({
            url: "credit-line/social_profile/registration_borrower", // Replace with your server URL
            type: "POST",
            data: formData,
            success: function(response) {
                // Process the response from the server
                if (response.status === 1) {
                    
                } else {
                    
                }
            },
            error: function() {
                // Handle error
            }
        });
    });
});

$(document).ready(function() {
   
    $("#pan, #ifsc").on('keyup', function() {
        this.value = this.value.toUpperCase();
    });
    function hideErrorMessage() {
        var errorDiv = document.getElementById('errorDiv');
        if (errorDiv) {
            setTimeout(function() {
                errorDiv.style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    }
    hideErrorMessage();
});

</script>
