<style>
    .loginbg {background-image: linear-gradient(90deg, #004566 50%, #fff 50%);}
    .login-tab {margin-bottom:20px !important;}
    .login-tab li {display:inline-block; margin:10px 5px 10px 0; border: 1px solid #ccc;}
    .login-tab li a {display:inline-block; padding:15px 20px; color:#000; font-size:15px;}
    .login-tab li a.active {color:#fff; background:#1795be; box-shadow:1px 1px 25px #898989;}
    .star {color:#f20;}
    .login-register input, .login-register label {color:#000; font-size:16px;}
    .btn-logsig {text-align:right; margin-top: 15px;}
    .btn-logsig button {background:#b61e37; width:80px; padding:6px 15px; border: none; border-radius:20px; color:#fff; font-size:14px;}
    .login-register .top-txt {font-size:20px; color:#fff;}
    .top-hd {font-size:26px; font-weight:bold; color:#fff; line-height:inherit; margin-bottom:15px;}
    .top-highlight {position:relative;}
    .top-highlight>li {font-size:14px; color:#fff; margin-bottom:15px; padding-left:60px; min-height:54px;}
    .top-highlight>li>span {font-size:13px; color:#fff; display:block;}
    .owl-carousel .owl-item img{max-width: 100% !important; width: 54px !important;
        float: left;}
    .login-register .btn-signup {background:#b61e37; padding:7px 20px; font-size:16px; color:#fff; border-radius:20px; display:inline-block;}
    .howwork li {display:inline-block; padding:30px 15px;}
    .howwork li a {display:block; color:#fff;}
    @media(max-width:767px){
        .loginbg {background-image: linear-gradient(180deg, #004566 60%, #fff 40%);}
        .login-register .top-txt {font-size: 15px; line-height:inherit;}
        .top-hd {font-size: 18px;}
        .login-register .btn-signup {padding:7px 20px; font-size:14px;}
        .login-tab {margin-bottom:20px !important;}
        .login-tab li {margin:5px 0;}
        .login-tab li a {padding:7px 8px; font-size:12px;}
        .login-register .pull-right a {font-size:10px; margin-top:-5px; margin-bottom:10px; display:inline-block;}
        .whitebg {margin-top:10%; display:table;}
        .howwork li {padding: 10px 15px;}
    }

</style>

<section class="sec-pad login-register loginbg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <p class="top-txt">Sign up for an Antwork and create your Borrower account</p>
                <h2 class="top-hd">AntworksMoney India's largest P2P network connecting Borrowers and Lenders.</h2>
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
                    <li><a href="<?php echo base_url();?>how-it-works">How it works?</a></li>
                    <li><a href="<?php echo base_url();?>how-it-works">Browse Lenders</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-xs-12 whitebg">
                <?=getNotificationHtml();?>

                <div class="col-md-12">
                    <div class="col-md-12">
                        <ul class="login-tab">
                            <li><a href="javascript:void(0)" class="active">Login As Borrower</a></li>

                        </ul>
                    </div>
                    <form action="<?php echo base_url(); ?>login/verify-borrower-login" onsubmit="return enc_borrower()" method="post">
                        <div class="form-group">
                    <span class="help-block with-errors">
                    <ul class="list-unstyled">
                      <li id="login_type1-error" class="errors-class"></li>
                    </ul>
                    </span> </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Login<span class="star">*</span></label>
                                        <div class="login-rform">
                                            <input type="text" class="form-control" name="user" id="user" placeholder=" Email ID*">
                                            <i class="fa fa-user"></i> </div>
                                        <span class="help-block with-errors">
                                    <ul class="list-unstyled">
                                      <li id="username-error" class="errors-class"></li>
                                    </ul>
                                    </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password<span class="star">*</span></label>
                                        <div class="login-rform">
                                            <input type="password" class="form-control" name="pwd" id="pwd" placeholder=" Password*">
                                            <i class="fa fa-lock"></i> </div>
                                        <span class="help-block with-errors">
                                <ul class="list-unstyled">
                                  <li id="password-error" class="errors-class"></li>
                                </ul>
                                </span>
                                    </div>
                                </div>
                                <div class="clearfix submit-box">
<!--                                    <div class="col-md-12">-->
<!--                                        <div class="pull-right"> <a href="--><?php //echo base_url(); ?><!--login/recover-password/">Forget your Password?</a> </div>-->
<!--                                    </div>-->
                                    <div class="col-md-12 btn-logsig">
                                        <button class="" type="submit">Login</button>
                                        <a href="<?php echo base_url(); ?>">SignUp</a>
                                    </div>

                                </div>
                                 <input type="hidden" name="hash_value" id="hash_value" value="<?php echo $salt_key;?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    </form>
                </div>
                <!-- /.col-md-12 -->

            </div>
        </div>
    </div>
</section>
<!-- /.sec-pad -->


<script src="<?=base_url();?>assets/js/encryption-login.js"></script>
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