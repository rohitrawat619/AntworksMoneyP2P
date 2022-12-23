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

</style>
<?=getNotificationHtml();?>
<section class="sec-pad">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 whitebg userlogin">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Change Password</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="login">
                        <form action="<?php echo base_url(); ?>login/action_change_password" onsubmit="return enc_change_password()" method="post">
                            <div class="col-md-6 col-xs-12 bdr-rite">
                                <p class="login-hd">Change Password of your profile</p>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">Password<span>*</span></label>
                                                <input class="form-control" type="password" name="pwd" id="pwd" value="">
                                                <span id="error_pwd"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_email">Confirm Password<span>*</span></label>
                                                <input class="form-control" type="password" name="cpwd" id="cpwd" value="">
                                                <span id="error_cpwd"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">

                                            <input type="hidden" name="verify_hash" value="<?php echo $this->input->get('verify-hash');?>">
                                            <input type="hidden" name="hash" value="<?php echo $this->input->get('hash');?>">
                                            <input type="hidden" name="token" value="<?php echo $this->input->get('token');?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-6 col-xs-12">
                            <p class="login-hd">Don’t have an account ?</p>
                            <p>Create your Account Now</p>
                            <div class="col-md-3">
                                <a href="<?php echo base_url(); ?>lender" type="submit" class="btn btn-primary">As Lender</a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url(); ?>" type="submit" class="btn btn-success">As Borrower</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script src="<?=base_url();?>assets/js/encryption-login.js"></script>
