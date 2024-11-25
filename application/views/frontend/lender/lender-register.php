<section class="sec-pad login-register loginbg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xs-12 whitebg pull-right">
                <!--      --><?//=getNotificationHtml();?>
                <div class="col-md-12 np">
                    <form role="form" action="<?php echo base_url(); ?>lender-register" method="post" class="f1"  onsubmit="return userFunctionvalidate()">
                        <p class="text-right">Already have an Antworks Account <a href="<?php echo base_url(); ?>login/lender">Log in</a></p>
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
                                <p>Occuption Details</p>
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

                            <div class="col-md-6 col-xs-6">
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
                            </div>
                            <div class="f1-buttons">
                                <button type="button" class="btn btn-next">Next</button>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-6 col-xs-12">
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
                                    <?php if($states){foreach ($states AS $state){
                                        echo "<option value='".$state['code']."'>".$state['state']."</option>";
                                    }} ?>
                                    </select>
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
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="button" class="btn btn-next">Next</button>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="col-md-6 col-xs-12">
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

                            <div id="oocup1">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">

                                        <select class="form-control" name="employed_company1" id="employed_company1" >
                                            <option value="">Select Employment</option>
                                            <option value="Government">Government</option>
                                            <option value="PSUs">PSUs</option>
                                            <option value="MNC">MNC</option>
                                            <option value="Public Limited Company">Public Limited Company</option>
                                            <option value="Private Limited Company">Private Limited Company</option>
                                            <option value="Partnership">Partnership</option>
                                            <option value="Proprietorship">Proprietorship</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <span class="validation error-validation" id="error_employed_company1"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Company Name" name="company_name1" id="company_name1" onkeyup="showResult1(this.value)" >
                                        <span class="validation error-validation" id="error_company_name1"></span>
                                    </div>
                                    <div id="livesearch1" class="col-md-12" style="display:none"></div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">

                                        <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income1" id="net_monthly_income1" maxlength="10" onkeypress="return isNumberKey(event)" >
                                        <span class="validation error-validation" id="error_net_monthly_income1"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup2">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">

                                        <select class="form-control" name="industry_type2" id="industry_type2" >
                                            <option value="">Select Industry</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Trading">Trading</option>
                                            <option value="Service">Service</option>
                                            <option value="MNC">MNC</option>
                                            <option value="KPO">KPO</option>
                                            <option value="BPO">BPO</option>
                                            <option value="Software">Software</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <span class="validation error-validation" id="error_industry_type2"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Total Experience" type="text" name="total_experience2" id="total_experience2" >
                                        <span class="validation error-validation" id="error_total_experience2"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Turnover Last Year" name="turnover_last_year2" id="turnover_last_year2" >
                                        <span class="validation error-validation" id="error_turnover_last_year2"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Turnover Last Two Year" name="turnover_last2_year2" id="turnover_last2_year2" >
                                        <span class="validation error-validation" id="error_turnover_last2_year2"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup3">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control" name="professional_type3" id="professional_type3" >
                                            <option value="">Select Professional</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Teacher">Teacher</option>
                                            <option value="CA">CA</option>
                                            <option value="CS">CS</option>
                                            <option value="Architect">Architect</option>
                                            <option value="Lawyer">Lawyer</option>
                                            <option value="Other Consultant">Other Consultant</option>
                                        </select>
                                        <span class="validation error-validation" id="error_professional_type3"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Total Experiance" type="text" name="total_experience3" id="total_experience3" >
                                        <span class="validation error-validation" id="error_total_experience3"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Turnover Last Year" type="text" name="turnover_last_year3" id="turnover_last_year3" >
                                        <span class="validation error-validation" id="error_turnover_last_year3"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Turnover Last 2 Year" name="turnover_last2_year3" id="turnover_last2_year3" >
                                        <span class="validation error-validation" id="error_turnover_last2_year3"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup4">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control" name="company_type4" id="company_type4" >
                                            <option value="">Select Employment</option>
                                            <option value="Government">Government</option>
                                            <option value="PSUs">PSUs</option>
                                            <option value="MNC">MNC</option>
                                            <option value="Public Limited Company">Public Limited Company</option>
                                            <option value="Private Limited Company">Private Limited Company</option>
                                            <option value="Partnership">Partnership</option>
                                            <option value="Proprietorship">Proprietorship</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <span class="validation error-validation" id="error_company_type4"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Company Name" name="company_name4" id="company_name4" onkeyup="showResult4(this.value)">
                                        <span class="validation error-validation" id="error_company_name4"></span>
                                    </div>
                                </div>
                                <div id="livesearch4" class="col-md-12" style="display:none"></div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income4" id="net_monthly_income4" maxlength="10" onkeypress="return isNumberKey(event)" >
                                        <span class="validation error-validation" id="error_net_monthly_income4"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup5">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="form-control" name="pursuing5" id="pursuing5" >
                                            <option value="">Select </option>
                                            <option value="Graduation">Graduation</option>
                                            <option value="Postgraduation">Postgraduation</option>
                                            <option value="Doctoral">Doctoral</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Diploma">Diploma</option>
                                        </select>
                                        <span class="validation error-validation" id="error_pursuing5"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Institute Name" type="text" name="institute_name5" id="institute_name5" >
                                        <span class="validation error-validation" id="error_institute_name5"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Monthly Income" type="text" name="net_monthly_income5" id="net_monthly_income5" maxlength="10" onkeypress="return isNumberKey(event)" >
                                        <span class="validation error-validation" id="error_net_monthly_income5"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup6">
                                <div id="livesearch6" class="col-md-12" style="display:none"></div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Monthly Income" type="text" name="net_monthly_income6" id="" maxlength="10" onkeypress="return isNumberKey(event)" >
                                        <span class="validation error-validation" id="error_net_monthly_income6"></span>
                                    </div>
                                </div>

                            </div>

                            <div id="oocup7">
                                <div id="livesearch7" class="col-md-12" style="display:none"></div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Monthly Income" type="text" name="net_monthly_income7" id="net_monthly_income7" maxlength="10" onkeypress="return isNumberKey(event)" >
                                        <span class="validation error-validation" id="error_net_monthly_income7"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="f1-buttons">
                                <div class="terms-condtns">
                                    <label><input type="checkbox" name="term_and_condition" id="term_and_condition">I have read, understood, and I agree to the <a href="<?php echo base_url(); ?>term-and-conditions" target="_blank">Terms of Use</a> and <a href="<?php echo base_url(); ?>privacy-and-policy" target="_blank">Privacy Policy</a>. I undertake not to lend more than 10 lakh on all Peer to Peer (P2P) Platform.</label>
                                    <span id="error_term_and_condition" class="validation error-validation"></span>
                                </div>
                                <button type="button" class="btn btn-previous">Previous</button>
                                <input type="hidden" name="max_loan_preference" value="<?php echo $this->input->post('max_loan_preference') ?>">
                                <input type="hidden" name="max_tenor" value="<?php echo $this->input->post('max_tenor') ?>">
                                <input type="hidden" name="max_interest_rate" value="<?php echo $this->input->post('max_interest_rate') ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
								<input type="hidden" name="source" id="source" value="lenderRegistration">
                                <button type="submit" class="btn btn-submit">Submit</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- /.col-md-12 -->
            </div>
            <div class="col-md-6 col-xs-12">
            <div class="sliderbox">
                <p class="top-txt">Sign up for an Antwork and create your Lender account</p>
                <h2 class="top-hd">AntworksMoney India's largest P2P network connecting Borrowers and Lenders.</h2>
                <ul class="top-highlight">
                    <divdiv id="myslider" class="owl-theme">
                        <div class="item"><ul class="top-highlight">
                                <li><img src="<?php echo base_url(); ?>assets/img/investor-icon.png">Wide P2P Network <span>Widest P2P network at Antworks P2P.</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/investor-icon.png">Instant Registration <span>Create your Lender Account instantly at Antwork Money.</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/hassle-free-loan.png">Transparency <span>No hidden charges applicable at Antwork P2P.</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/best-p2p.png">The best P2P marketplace <span>Antwork Money has emerged as the best P2P Market place</span></li>
                            </ul></div>
                        <div class="item"><ul class="top-highlight">
                                <li><img src="<?php echo base_url(); ?>assets/img/easy-process.png">Simple & Easy process <span>At Antwork Money P2P marketplace, easy and simple process for lending is followed</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/higher-interest.png">Higher interest earning <span>Earn good rate of interest on the disbursed loans</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/attractive-offers.png">Attractive offers <span>Antwork Money provides better lending offers to choose resulting in more profit</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/competitive-interest.png">Smart Invest<span>Manage your portfolio easily with attractive user friendly options. Make smart investment for better returns</span></li>

                            </ul></div>
                        <div class="item"><ul class="top-highlight">
                                <li><img src="<?php echo base_url(); ?>assets/img/paperless-processing.png">Paperless Processing <span>It saves time and makes loan disbursement speedy</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/simple-loan-process.png">Dependable platform <span>100% dependable P2P financial solution services</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/247loan-application.png">Trending Financial Products <span>Multiple loan products provides more choice of loan to borrowers</span></li>
                                <li><img src="<?php echo base_url(); ?>assets/img/hassle-free.png">Hassle free process <span>The worry-free process makes lending speedy attracting more borrowers</span></li>
                            </ul></div>
                    </divdiv>
                </ul>
                <a href="" class="btn-signup">Ready to get started? Sign up today!</a>
                <ul class="howwork">
                    <li><a href="<?php echo base_url(); ?>how-it-works" target="_blank">How it works?</a></li>
                    <li><a href="javascript:void(0)<?php //echo base_url();browse-borrowers ?>">Browse Borrowers</a></li>
                </ul>
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
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/scripts-lender.js"></script>
