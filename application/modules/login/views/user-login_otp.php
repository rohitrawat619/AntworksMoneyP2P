<style>
    .userlogin {margin:60px 0; min-height:300px;}
    .userlogin .form-group label {font-weight:300; width: 100%;}
    .userlogin .form-group label a {float:right; font-size:12px;}
    .userlogin .nav-tabs li a {padding:5px 15px;}
    .userlogin .nav-tabs li.active a {background-color: #00518c; color: #fff;}
    .login-hd {font-size:13px; font-weight:600; color:#000; border-bottom:1px solid #e2e2e2; padding:15px 0 5px 0; margin:20px 0 30px 0;}
    .bdr-rite {border-right:1px solid #e2e2e2;}
    .userlogin .form-group {margin-bottom: 15px;}

    @media(max-width:767px){

    }
 .coundown {
    font-size: 21px;
    font-weight: 600;
    color: #000;
    margin-top: 6px;
}
</style>
<?=getNotificationHtml();?>
<section class="sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 whitebg userlogin">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login With OTP </a></li>
                    <li role="presentation"><a href="#loginWithPassword" aria-controls="resetpasswrd" role="tab" data-toggle="tab">Login With Password</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="login">
                        <form action="<?php echo base_url(); ?>login/verify_user_login_by_otp"  method="post">
                            <div class="col-md-6 col-xs-12 bdr-rite">
                                <p class="login-hd">Sign in to Antworks P2P</p>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">Mobile<span>*</span> <span style="color:red" id="error_mobile"></span> </label>
                                                <input class="form-control" type="text" name="mobile" id="mobile">
												<button type="button" class="btn btn-primary" id="resend_otp" onclick="sendLoginOtp()" >Send OTP <i class="fa fa-paper-plane" ></i></button>
												<div class="countdown"></div>
																							 
										 </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">OTP<span>*</span></label>
                                                <input class="form-control"  type="password" name="otp" id="otp" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <input type="hidden" name="hash_value" id="hash_value" value="<?php echo $salt_key;?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                       
                    </div>
                    <div role="tabpanel" class="tab-pane" id="loginWithPassword">
                       
                        <form action="<?php echo base_url(); ?>login/verify_user_login" onsubmit="return enc_user_login()" method="post">
                            <div class="col-md-6 col-xs-12 bdr-rite">
                                <p class="login-hd">Sign in to Antworks P2P</p>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">Email<span>*</span></label>
                                                <input class="form-control" type="text" name="user" id="user">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">Password<span>*</span></label>
                                                <input class="form-control" type="password" name="pwd" id="pwd" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <input type="hidden" name="hash_value" id="hash_value" value="<?php echo $salt_key;?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                       
                    
                    </div>
					 <div class="col-md-6 col-xs-12">
                            <p class="login-hd">Don’t have an account ?</p>
                            <p>Create your Account Now</p>
                            <div class="col-md-3">
                                <a href="<?php echo base_url(); ?>lender" type="submit" class="btn btn-primary">As Lender</a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>borrower" type="submit" class="btn btn-success">As Borrower</a>
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/scripts.js"></script>
<script src="<?=base_url();?>assets/js/encryption-login.js"></script>
