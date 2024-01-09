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
                            <li><a href="javascript:void(0)" class="active">Login As Lenders</a></li>
                        </ul>
                    </div>
     <form action="<?php echo base_url(); ?>login/verify-lender-login" onsubmit="return enc_lender()" method="post">
                        <div class="form-group">
                            <span class="help-block with-errors">
                            <ul class="list-unstyled">
                              <li id="login_type1-error" class="errors-class"></li>
                            </ul>
                            </span>
                        </div>
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
<!--                            <div class="col-md-12">-->
<!--                                <div class="pull-right"> <a href="--><?php //echo base_url(); ?><!--login/recover-password">Forget your Password?</a> </div>-->
<!--                            </div>-->
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