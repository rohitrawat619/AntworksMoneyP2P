<section class="sec-pad login-register loginbg">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-xs-12 whitebg pull-right">
                  <?=getNotificationHtml();?>
            <div class="col-md-12 np">
                <form role="form" action="<?php echo base_url(); ?>borrower-register" method="post" class="f1 validate-password" id="borrower_registration" onsubmit="return userFunctionvalidate()">
                    <p class="text-right">Already have an Antworks Account <a href="<?php echo base_url(); ?>login/borrower">Log in</a></p>
                    <h2 class="register-hd">Register yourself in 3 easy steps in less than 5 mins.</h2>
                    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="33.33333" data-number-of-steps="3" style="width: 33.33333%;"></div>
                        </div>
                        <div class="f1-step active" id="step_1">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Personal Details</p>
                        </div>
                        <div class="f1-step" id="step_2">
                            <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                            <p>Residental Details</p>
                        </div>
                        <div class="f1-step" id="step_3">
                            <div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                            <p>Occupation/Loan Details</p>
                        </div>
                    </div>
                    <fieldset>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Full name as per your PAN card" class="f1-first-name form-control" id="name">
                                <span class="validation error-validation" id="error_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <input class="form-control" name="dob" id="datepicker" readonly="" placeholder="Date of Birth" type="text">
                                <span class="validation error-validation" id="error_datepicker"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
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
                                <?php if($qualification){foreach ($qualification AS $quali){
                                    echo "<option value='".$quali['id']."'>".$quali['qualification']."</option>";
                                }} ?>
                                </select>
                                <span class="validation error-validation" id="error_highest_qualification"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
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
								<div class="countdown"></div>
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

                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" type="password" name="password" id="password" onclick="showpasswordstrength();">
                                <div class="password_strength" style="display: none;"><span style="color: #286090;">Use at least one letter, one capital letter, one number , one special character and minimum 8 characters long.</span>
                                    <meter max="4" id="password-strength-meter"></meter>
                                    <p id="password-strength-text"></p>
                                </div>
                                <span class="validation error-validation" id="error_password"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm Password" type="password" name="cpassword" id="cpassword">
                                <span class="validation error-validation" id="error_cpassword"></span>
                            </div>
                        </div>

                        <div class="f1-buttons">
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address 1" name="address1" id="address1" rows="3" autocomplete="off">
                                <span class="validation error-validation" id="error_address1"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">

                                <input type="text" class="form-control" placeholder="Address 2" name="address2" id="address2" rows="3" autocomplete="off">
                                <span class="validation error-validation" id="error_address2"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">

                                <select class="form-control" name="state_code" id="state" onChange="get_city()" />
                                <option value="">Select State</option>
                                <?php if($states){foreach ($states AS $state){
                                    echo "<option value='".$state['code']."'>".$state['state']."</option>";
                                }} ?>
                                </select>
                                <span class="validation error-validation" id="error_state"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">

                                <select class="form-control" name="city" id="city" />

                                </select>
                                <span class="validation error-validation" id="error_city"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">

                                <input class="form-control" type="text" placeholder="Pincode" name="pincode" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" >
                                <span class="validation error-validation" id="error_pincode"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <select class="form-control" name="present_residence" id="present_residence"/>
                                    <option value="">--Select Present Residence--</option>
                                    <?php if($present_residence_type){foreach ($present_residence_type AS $present_residence){
                                        echo "<option value='".$present_residence['id']."'>".$present_residence['residence_name']."</option>";
                                    }} ?>
                                </select>
                                <span class="validation error-validation" id="error_present_residence"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous">Previous</button>
                                <button type="button" class="btn btn-next">Next</button>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">

                                <select class="form-control" name="occupation" id="occupation" onchange="occupation_value();" />
                                <option value="">Select Occuption</option>
                                <?php if($occuptions){foreach ($occuptions AS $occuption){
                                    echo "<option value='".$occuption['id']."'>".$occuption['name']."</option>";
                                }} ?>
                                </select>
                                <span class="validation error-validation" id="error_occupation"></span>
                            </div>
                        </div>
                        <div id="occuption_change_value">
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <input class="form-control" placeholder="Loan Amount" type="text" name="loan_amount_borrower" id="loan_amount_borrower" value="<?php echo $this->input->post('loan_amount_borrower');?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                <span class="validation error-validation" id="error_loan_amount_borrower"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <select class="form-control" name="tenor_borrower" id="tenor_borrower">
                                    <option value="">--Select</option>
                                    <?php for($i = 6; $i<37; $i++){?>
                                        <option value="<?php echo $i;?>" <?php if($this->input->post('tenor_borrower') == $i){echo "selected"; } ?>><?php echo $i;?> Months</option>
                                    <? } ?>
                                </select>
                                <span class="validation error-validation" id="error_tenor_borrower"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <select class="form-control" name="borrower_interest_rate" id="borrower_interest_rate">
                                    <option value="">--Select</option>
                                    <?php for($i = 6; $i<37; $i++){?>
                                        <option value="<?php echo $i;?>" <?php if($this->input->post('emi_borrower') == $i){echo "selected"; } ?>><?php echo $i;?> %</option>
                                    <? } ?></select>
                                <span class="validation error-validation" id="error_borrower_interest_rate"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <select name="p2p_product_id" id="p2p_product_id" class="form-control">
                                    <option value="">Select Purpose</option>
                                    <? foreach ($loan_types AS $loan_type){?>
                                    <option value="<?=$loan_type['p2p_product_id']?>"><?=$loan_type['loan_purpose']?></option>
									<? } ?>
                                </select>
                                <span class="validation error-validation" id="error_p2p_product_id"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control" type="text" placeholder="Loan Description" name="borrower_loan_desc" id="borrower_loan_desc"></textarea>
                                <span class="validation error-validation bt24" id="error_borrower_loan_desc"></span>
                            </div>
                        </div>

                        <div class="f1-buttons">
                            <div class="terms-condtns">
                                <label><input type="checkbox" name="term_and_condition" id="term_and_condition"> I have read, understood, and I agree to the <a href="<?php echo base_url(); ?>term-and-conditions" target="_blank">Terms of Use</a> and <a href="<?php echo base_url(); ?>privacy-and-policy" target="_blank">Privacy Policy</a>. I undertake not to borrow more than 10 lakh on all Peer to Peer (P2P) Platform.</label>
                                <span id="error_term_and_condition" class="validation error-validation"></span>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <input type="hidden" name="source" id="source" value="borrowerRegistration">
                            <button type="submit" class="btn btn-submit">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!-- /.col-md-12 -->
        </div>
		<div class="col-md-6 col-xs-12">
		<div class="sliderbox">
			<p class="top-txt">Sign up at Antwork P2P and create your Borrower Account</p>
			<h2 class="top-hd">Antworks P2P - India's largest P2P network connecting Borrowers and Lenders.</h2>
			<ul class="top-highlight">
                <div id="myslider" class="owl-theme">
                <div class="item"><ul class="top-highlight">
                        <li><img src="<?php echo base_url(); ?>assets/img/investor-icon.png">Instantly reach out to Investors <span>Start bidding or reaching out to Lenders instantly on Registration.</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/hassle-free-loan.png">Hassle free & speedy registration <span>Antworks P2P offer speedy and hassle-free account registration</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/verified-profile.png">Verified profile for better response <span>Your profile is verified and rated by Antworks P2P Financing to improve your success rate.</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/loan-approval.png">Loan Approval <span>Get your loan approved and disbursed in 72 hrs on Antworks P2P Financing</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/loan-disbursement.png">Loan Disbursement <span>Save more money with Antworks, No hidden charges.</span></li>
                    </ul></div>
                <div class="item"><ul class="top-highlight">
                        <li><img src="<?php echo base_url(); ?>assets/img/hassle-free-loan.png">Hassle-free Loan <span>Availing loan made hassle free only at Antworks P2P Financing.</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/speedy-processing.png">Speedy processing <span>Now save your precious time with the speedy loan processing by Antworks P2P Finance </span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/competitive-interest.png">Competitive Interest rates <span>Grab the benefit of comparatively lower rate of interest on loans</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/max-loan-amount.png">Maximum loan amount <span>Antworks P2P helps you avail maximum amount of loan from all interested lenders</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/collateral-free.png">Collateral Free Loans <span>Antworks P2P support you in getting collateral free loans</span></li>
                    </ul></div>
                <div class="item"><ul class="top-highlight">
                        <li><img src="<?php echo base_url(); ?>assets/img/maximum-tenure.png">Maximum Tenure <span>Tenure of 3-24 months or even more can be chosen easily</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/simple-loan-process.png">Simple Loan Process <span>Antworks P2P has made loan process online simple and hassle-free</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/247loan-application.png">24x7 Loan application <span>No time restriction, apply P2P loan anytime</span></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/secure-process.png">Secure process  <span>Safety & security standard followed for data protection</span></li>
                    </ul></div>
                </div>
			</ul>
			<a href="" class="btn-signup">Ready to get started? Sign up today!</a>
			<ul class="howwork">
				<li><a href="<?php echo base_url(); ?>how-it-works" target="_blank">How it works?</a></li>
				<li><a href="<?php echo base_url('browse-lenders');?>" >Browse Lenders</a></li>
			</ul>
		</div>
		</div>

	</div>
</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
<script>

    var strength = {
        0: "Worst",
        1: "Bad",
        2: "Weak",
        3: "Good",
        4: "Strong"
    }
</script>
<script>
    var password = document.getElementById('password');
    var meter = document.getElementById('password-strength-meter');
    var text = document.getElementById('password-strength-text');
    password.addEventListener('input', function() {
        var val = password.value;
        var result = zxcvbn(val);

        // Update the password strength meter
        meter.value = result.score;

        // Update the text indicator
        if (val !== "") {
            text.innerHTML = "Strength: " + strength[result.score];
        } else {
            text.innerHTML = "";
        }
    });</script>

<script>
    function showpasswordstrength() {
        $(".password_strength").show();
    }
    $("body").mouseup(function(){
        $(".password_strength").hide();
    });
</script>

<script>
    $(document).ready(function() {
        var owl = $('#myslider');
        owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,
            pagination: false,
            dots: false,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0:{
                    items:1,
                },
                600:{
                    items:1,
                },
                1000:{
                    items:1,
                }
            }
        });
        $('.play').on('click', function() {
            owl.trigger('play.owl.autoplay', [1000])
        })
        $('.stop').on('click', function() {
            owl.trigger('stop.owl.autoplay')
        })
    })
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/scripts.js"></script>
