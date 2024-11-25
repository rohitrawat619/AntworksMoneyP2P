<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
	function get_action(form)
	{
		var v = grecaptcha.getResponse();
		if(v.length == 0)
		{
			document.getElementById('captcha').innerHTML="You can't leave Captcha Code empty";
			return false;
		}
		else
		{
			document.getElementById('captcha').innerHTML="Captcha completed";
			return true;
		}
	}
</script>
<style>
	.jarallax {position: relative; background-image: url("../images/banner_bg1.jpg"); background-size: cover; background-repeat: no-repeat; background-position: 50% 50%;}
	.banner-overlay:before {content: ""; background-color:rgba(0, 0, 0, 0.5); top:0; right:0; bottom:0; left:0; position:absolute;}
	.form-box {background-color:rgba(0, 0, 0, 0.4); padding:30px 20px; font-family: 'Poppins', sans-serif;}
	.form-box h2 {color:#fff; font-size:16px; margin-bottom:30px; font-weight:bold; text-align:center;}
	.form-box .input-field {margin-bottom:10px;}
	.form-box .btn-submit {padding:0px 15px; font-weight:bold; background:#3563a9; border-radius:0px; color:#fff; line-height:50px; width:100%; font-size:12px;}
	.form-box .form-control {background:#fff; border:solid 0px #fff; color:#000; margin-top:0px; margin-bottom:20px; line-height:28px; height:auto;}
	.form-box select {height:40px !important; color:#939393 !important;}
	.banner-desc {padding-top: 10%; padding-left:0px;}
	.banner-desc h1 {color:#fff !important;}
	.banner-desc p {color:#fff !important;}
	.banner-desc span {color:#fff !important;}
	.banner-section.personalloan1 .hero-content {padding: 30px 0 30px 0 !important;}
	.form-box .terms label {font-size:12px; line-height:20px; color:#fff;}
	.form-box .terms p {font-size:10px; text-align:left; margin-left:15px; margin-bottom:20px; margin-top:-5px;}
	.banner-section.personalloan1 {background: url(../assets/img/surge-banner.jpg) !important; background-repeat:no-repeat !important; background-position: 50% 60% !important; background-size: cover !important;}
	 body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;}
	.hero-content .banr-txt {font-size:15px!important; font-weight:600!important; color:#fff!important; margin-top:15px;}
	.hero-content .banr-txt span {font-weight:600 !important; color:#28f706!important; font-style: italic;}
	.disclaimer {text-align:justify;}
	.disclaimer p {margin-bottom:10px;}
	.hero-content {width: 100%; padding: 260px 0 120px 0;}
	.hero-content h1 {font-family: 'Poppins', sans-serif; font-size: 120px; color: #1b3855; font-weight: 800; letter-spacing: -1px; margin-bottom: 2px; text-transform: uppercase; margin-left: -10px;}
	.hero-content h1 span{font-family: 'Poppins', sans-serif; font-size: 60px; color: #1b3855; font-weight: 600; line-height: 1; letter-spacing: -1px; display: block; margin-left: 7px;}
	.hero-content p {font-size: 26px;}
	.lender-section-v2 .hero-content h1 {font-family: 'Roboto', sans-serif; font-size: 65px; color: #FFFFFF; font-weight: 800; letter-spacing: 2px; margin-bottom: 20px; text-transform: uppercase; margin-left: -10px;}
	.btn-action {background: #b51e37; font-size: 18px; border-radius: 0; letter-spacing: 2px; padding: 8px 21px; outline: none; color:#fff;}
	.services-content h1 {font-family: 'Poppins', sans-serif; font-size: 28px; color:#111!important; font-weight: 600; letter-spacing: 0; line-height: 1.4; margin-top: 40px; margin-bottom: 30px;}
	.services .services-description h1 {font-family: 'Poppins', sans-serif; font-size: 18px; color:#111!important; font-weight: 600; letter-spacing: 0; line-height: 1.4; margin-top: 20px; margin-bottom: 20px;}
	.panel-title {padding:10px;}
	.panel-title a {color: #000; font-size: 14px; font-weight: 600;}
	.panel-title > a:before {float: right !important; font-family: FontAwesome; content:"\f068"; padding-right: 5px;}
	.panel-title > a.collapsed:before {float: right !important; content:"\f067";}
	.panel-title > a:hover, .panel-title > a:active, .panel-title > a:focus  {text-decoration:none;}
	.faq-facts {background: #f4f4f4; padding: 10px 0 50px 0;}
	.panel-default>.panel-heading+.panel-collapse>.panel-body {line-height: 26px;}
	
	@media only screen and (min-width: 767px){
	.personalloan1 .hero-content {padding: 110px 0 20px 0 !important;}
	.banner-desc {padding-left:30px;}
	.form-box {padding:30px 38px;}
	.form-box .btn-submit {font-size:14px;}
	.hero-content {width: 100%; padding: 260px 0 120px 0; overflow: hidden;}
	}
	@media only screen and (max-width: 767px){
	.banner-section.personalloan1 {background-position: 20% 0% !important; background-size: 250% auto !important;}
	.form-box .btn-submit {padding: 10px 15px !important; line-height: normal !important; white-space: normal !important;}
	}
</style>
<div id="main" class="main">
<section>
	<div class="jarallax">
		<div class="banner-section personalloan1 banner-overlay">
			<div class="container">
				<div class="hero-content">
					<div class="col-md-8 nopadding banner-desc">
						<h1 class="wow fadeInLeft" data-wow-delay="0s"><span>Be the</span> Bank</h1>
						<p class="wow fadeInLeft" data-wow-delay="0.1s" style="margin-bottom: 20px;">
							Now loan your money to the world yourself.
						</p>
						<a class="btn btn-action wow fadeInUp" data-wow-delay="0.2s" href="javascript:void(0);">Get return upto 24%</a>
						<p class="banr-txt">Click here to participate in <span>Business Loan Lenders Club</span></p>
					</div>
					<div class="col-md-4 nopadding">
						<div class="form-box">
							<form id="contact-form" method="GET" action="<?php echo base_url();?>landing-campaign/smtp/lendercon-send-mail.php" role="form" onsubmit="return get_action(this)">
								<input type="hidden" name="type" value="1">
								<input type="hidden" name="loan_name" value="1">

								<div class="row">
									<div class="col-md-12">
										<h2>Register as Lender</h2>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-field">
											<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Full Name *" required="required" data-error="Full Name is required." />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-field">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email *" required="required" data-error="Valid email is required." />
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-field">
											<input type="text"  min="0" class="form-control" id="mobile" name="mobile" placeholder="Contact no." maxlength="10" onkeypress="return isNumberKey(event)" required="required"  />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-field">
											<input type="text" class="form-control" name="referal_code" placeholder="Please Enter Referral Code">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12 terms" style="margin-bottom: 20px; text-align: left;">
										<div class="form-group">
											<input id="remember" name="remember" value="1" type="checkbox" required="">
											<label style="display: inline-block;" for="remember">I agree to the <a href="https://antworksp2p.com/term-and-conditions" target="_blank">terms and conditions</a></label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 text-center">
										<div  style="overflow:hidden;">
											<div style="width:302px; margin:auto;">
												<div class="g-recaptcha" data-theme="clean" data-sitekey="6Lf4LE4UAAAAAOqdz4oEoqqqaKvvll3kBS2cTbW2"></div>
												<span id="captcha" style="color:red"></span>
											</div>
										</div>
									</div>
									<input type='hidden' name='product_type' value='lender1'>
									<div class="col-md-12">
										<input type="submit" class="btn btn-submit" value="REGISTER AS LENDER" style="margin-top: 20px; font-size:13px;">
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="services-section text-center" id="services"><!-- Services section (small) with icons -->
	<div class="container">
		<div class="col-md-8 col-md-offset-2 nopadding">
			<div class="services-content">
				<h1 class="wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">The advantages of Lending through us:</h1>
			</div>
		</div>
		<div class="col-md-12 text-center">
			<div class="services">

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/icons/feature_icon-2.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Access to a huge database of pre-verified borrowers.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/icons/feature_icon-6.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Regular updates on portfolios.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/icons/feature_icon-7.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Detailed periodic profile management reports.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img class="icon-2" src="../assets/img/icons/feature_icon-8.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Investment management services.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img class="icon-3" src="../assets/img/icons/feature_icon-9.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Access to our best Personal Financial Advisor.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/icons/feature_icon-5.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>The fun of earning while sitting at home.</h1>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<section class="faq-facts">
    <div class="container">
		<div class="services-content">
			<h1 class="wow fadeInUp text-center" style="visibility: visible; animation-name: fadeInUp;">We help you learn everything about credit</h1>
		</div>
        
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ1">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts1" class="accordion collapsed" aria-expanded="false" aria-controls="credit-facts1">
                                    1. Few Good Habits to Increase Your Credit Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ1" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                A good Credit Score has its own importance. If you are suffering from loan application rejections, you can follow a few of the good habits that can help you to boost your Credit Score. With a focussed approach and discipline, It is possible to improve your credit score. Just try to make payment on time for your existing outstanding, keep a close check on your spending, available credit limit, and make advance payments on your loan dues.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ2">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts2" aria-expanded="false" aria-controls="credit-facts2">
                                    2. Key Factors Having Impact on Your CIBIL Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ2" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                There are a number of the factors affecting Credit score. The key factors impacting your Credit score are Utilization of credit limit, Repayment history, Existing loan, new loans, Credit Cards, and mismanagement of financials. An individual can follow healthy financial habits to improve or maintain a good Credit score.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ3">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts3" aria-expanded="false" aria-controls="credit-facts3">
                                    3. Availing Loans with Low CIBIL Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ3" aria-expanded="false">
                            <div class="panel-body">
                                Although low CREDIT score is the key cause of loan rejection, there are a few sources that can help you to avail certain loans with a low CREDIT score. Securing personal loan or other types of loan is not impossible. All it needs is the smart management of your financials and you can get your need of loan accomplished.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts4" aria-expanded="false" aria-controls="credit-facts4">
                                    4. Irresponsible Behaviour Lowering Your Credit Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ4" aria-expanded="false">
                            <div class="panel-body">
                                There are few reckless behaviors responsible for impacting an individual credit score. As soon as you realize about your low credit score, you need to be careful. Just have control on your Irresponsible financial habits like overspending on your cards, delayed payments and work on the measures to boost your Credit Score.
                            </div>
                        </div>
                    </div>
                
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ5">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts5" aria-expanded="true" aria-controls="credit-facts5">
                                    5. How to Improve Your Credit Score?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ5">
                            <div class="panel-body">
                                Don’t get stressed out after learning about your poor Credit Score. It can be easily improved over the time by following some of the important healthy financial habits. Just read about the factors playing a very vital role in the improvement of your CREDIT score. Follow them strictly and you will notice noteworthy improvement over a period of time.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ6">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts6" aria-expanded="false" aria-controls="credit-facts6">
                                    6. Myths Prevailing About CREDIT Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ6">
                            <div class="panel-body">
                                The CREDIT score proves to be a very important parameter for the financial institutions helping them to know about the credit history of customers applying for the different types of loans. There are different myths spread in the financial market about Credit but as an alert customer, you can learn the real facts and enjoy easy loans with good Credit score.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ7">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts7" aria-expanded="false" aria-controls="credit-facts7">
                                    7. Avoiding Being Trapped in Heavy Debts
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ7">
                            <div class="panel-body">
                                Debts are like a trap that follows you for long and sometime ruins your career. Hence, every individual should avoid falling into debts. It is essential to keep control on your unnecessary spending, make timely payment, and develop good financial management habits. Read about the tips to maintain your good CREDIT score to enjoy hassle-free loans for any type of financial need.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ8">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts8" aria-expanded="false" aria-controls="credit-facts8">
                                    8. Top Tips to Maintain Healthy Credit Score
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ8">
                            <div class="panel-body">
                                Because Credit Score plays unavoidable role in the approval of a loan applied, it is necessary to maintain good credit score. Since, the need for the different types of loans keeps on arising from time to time, it is highly recommended to keep a check on your reckless money spending behaviours. Read about the top tips to ensure your Credit Score does not become low in any condition.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="blogs-main">
	<div class="container">
		<div class="col-md-12 col-xs-12 wow fadeInUp animated animated" data-wow-delay="0.3s"><h2 class="blogs-hd">Trending Blogs</h2></div>
		<? foreach ($list as $row)
		{?>

			<div class="col-md-4 col-xs-12 wow fadeInUp animated animated" data-wow-delay="0.3s">
				<div class="blog-block">
					<img src="<?php echo $row['blog_fetured_image'] ?>" alt="Fullerton India">
					<div class="blog-content">
						<ul class="blog-cat"><li>P2P. P2P Borrower.</li></ul>
						<a href="<?php echo $row['guid']; ?>" rel="bookmark" title="Permanent Link to Is it Better to Borrow Loan Against Fixed Deposit Instead of Liquidating?" class="blog-block-title"><?=$row['post_title'];?></a>
						<p><?php $stringCut = substr($row['post_content'], 0, 160); echo $stringCut .'...'; ?>
							<a href="<?php echo base_url(); echo "blog/"; echo $row['post_name']; ?>" target="_blank" class="btn btn-blog">Read More</a>
						</p>
					</div>
				</div>
			</div>
		<? }?>

	</div>
</section>
<section class="lender-comnt">
	<div class="container">
		<h2 class="lender-comnt-hd">Don't want to miss anything?</h2>
		<p class="partners-hd-txt">Sign up with your email address and get updated with our latest updates and offers</p>
		<div class="subscribe">
			<form method="post" action="<?php echo base_url(); ?>borroweraction/subscribedEmail" onsubmit="return subscribedEmail()">
				<div class="input-group">
					<input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
					<span id="subscribed_message"></span>
					<span class="input-group-btn">
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
			 <button class="btn btn-theme" type="submit">Subscribe</button>
			 </span>
				</div>
			</form>
		</div>
	</div>
</section>
</div>
<script src="<?=base_url();?>assets/assets/noUiSlider.9.1.0/nouislider.js"></script>
<script src="<?=base_url();?>assets/js/wNumb.js"></script>
<script src="<?=base_url();?>assets/js/home-page.js"></script>
<script src="<?=base_url();?>assets/js/plugins.js"></script>
<script src="https://www.antworksp2p.com/landing-campaign/assets/js/menu.js"></script>
<script src="https://www.antworksp2p.com/landing-campaign/assets/js/custom.js"></script>
<script>
/* ----- Jarallax Init ----- */

$('.jarallax').jarallax({
  speed: 0.7
});

/* ----- Jarallax Personal Homepage Init ----- */

$('.personal-jarallax').jarallax({
  speed: 0.7
});
</script>
