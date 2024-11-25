<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- owl carousel --
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		---->
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
	.banner-desc {padding-top: 18%; padding-left:0px;}
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
	.hero-content h1 span{font-family: 'Poppins', sans-serif; font-size: 42px; color: #1b3855; font-weight: 600; line-height: 1; letter-spacing: -1px; display: block; margin-left: 7px;}
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
						<h1 class="wow fadeInLeft" data-wow-delay="0s"><span>Unlocking prosperity for all</span></h1>
						<p class="wow fadeInLeft" data-wow-delay="0.1s" style="margin-bottom: 20px;">
							Unlock your financial potential with smart investments.
						</p>
						<a class="btn btn-action wow fadeInUp" data-wow-delay="0.2s" href="javascript:void(0);">Investment Rate 12%p.a.</a>
						<p class="banr-txt">Click here to participate in <span>Surge Lenders Club</span></p>
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
											<label style="display: inline-block;" for="remember">I agree to the <a href="https://www.antworksp2p.com/Term_and_conditions_surge" target="_blank">terms and conditions</a></label>
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
						<img src="../assets/img/surge_icons/earn.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Earn upto 18% p.a.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/surge_icons/withdraw.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Withdraw Anytime.</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/surge_icons/no-fee.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>No Deposit Fee</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img class="icon-2" src="../assets/img/surge_icons/cooling-period.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Verified Borrowers</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img class="icon-3" src="../assets/img/surge_icons/min-amount.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Diversified Portfolio</h1>
					</div>
				</div>

				<div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
					<div class="services-icon">
						<img src="../assets/img/surge_icons/max-amount.png" alt="Service" width="60" height="60">
					</div>
					<div class="services-description">
						<h1>Investment starting <i class="fa fa-rupee"></i>1000 Upto 10 Lac</h1>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<section class="faq-facts">
    <div class="container">
		<div class="services-content">
			<h1 class="wow fadeInUp text-center" style="visibility: visible; animation-name: fadeInUp;">Frequently Asked Questions (FAQ)</h1>
		</div>
        
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ1">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts1" class="accordion collapsed" aria-expanded="false" aria-controls="credit-facts1">
                                    1. What is Surge?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ1" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                Surge is an investment option build to offer you the opportunity to earn upto 18% p.a. by lending directly to the borrowers. This is done via an RBI-licensed/regulated peer to peer investing platform, antworksp2p.com (Antworks P2P Financing Pvt Ltd).
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ2">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts2" aria-expanded="false" aria-controls="credit-facts2">
                                    2. How will my money be deployed between different borrowers?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ2" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                We work around multiple data points derived through income, occupation, credit behavior and other details to assess via the risk engine to select the borrowers to whom money can be lent. Investors’ funds are distributed between multiple borrowers to mitigate risk and diversified investments.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ3">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts3" aria-expanded="false" aria-controls="credit-facts3">
                                    3. Who can invest in Surge? Can NRIs invest?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ3" aria-expanded="false">
                            <div class="panel-body">
                                Any Indian above 18 years (resident or non-resident) with an active PAN and Indian bank account can invest in the platform.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ4">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts4" aria-expanded="false" aria-controls="credit-facts4">
                                    4. Is there a fee for investing in Surge?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ4" aria-expanded="false">
                            <div class="panel-body">
                                No, there is no fees/charges for investing in the schemes available in Surge.
                            </div>
                        </div>
                    </div>
                
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="credit-factsQ5">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#credit-facts5" aria-expanded="true" aria-controls="credit-facts5">
                                    5. What are the risks with P2P investments?
                                </a>
                            </h4>
                        </div>
                        <div id="credit-facts5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="credit-factsQ5">
                            <div class="panel-body">
                                Like any Investment scheme there is a risk, and that's in some instances borrower don't repay the loan. For that, we work to ensure that we keep the risk to a minimum, by ensuring that every borrower your money is lent to is identity checked, credit-checked, risk assessed and every possible parameters are checked. Your investment is also diversified across multiple borrowers to minimize risk as much as possible. and all of the borrowers have to sign the legally binding loan agreement. If a borrower ends up defaulting even after the recovery process is initiated, Antworks P2P will earn no income till you get your indicated returns back. Do reach out to us after you've read the terms & conditions and have questions before you make your first investment.
                            </div>
                        </div>
                    </div>
                    
                    

                </div>
            </div>
        </div>
    </div>
</section>

<!----
<section class="blogs-main" style="padding-bottom: 10px;">
	<div class="container wow fadeInUp animated animated" data-wow-delay="0.3s"><h2 class="blogs-hd" style="margin-bottom: 30px;">Testimonials</h2></div>
	<div class="container">

		<div id="browse-lenders" class="owl-carousel owl-theme">
			<div class="item">
				<div class="lender-row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="star-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
						<div class="comntday">2 days ago</div>
						<div class="lendername">A C</div>
						<div class="member-year">Member Since 2019</div>
					</div>
					<div class="col-md-12 col-sm-1 col-xs-12">
						<h2 class="lender-maincomnt">So happy that I started investment with Antworks P2P</h2>
						<p class="lender-comt">I have a very enriched experience with Antworks P2P. I registered on the website. The registration process is smooth and hassle free. I got returns above 24% in just 8 months of my investment. They have the best in class products for your investment. I highly recommend Antworks  P2P.</p>
						<p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>
					</div>
				</div>
			</div>

			<div class="item">
				<div class="lender-row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="star-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
						<div class="comntday">2 days ago</div>
						<div class="lendername">V S</div>
						<div class="member-year">Member Since 2019</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="lender-maincomnt">My money is working for me. WOW!</h2>
						<p class="lender-comt">I was sceptical about p2p investments as it is fairly new in India. One of friend recommended Antworks p2p for investment and I thought to give a shot. Believe me, I couldn�t be more apt about my decision. I started with a small amount to check their platform and found that it is reliable to generate good return. Just like my friend I also recommend people to go for Antworks p2p.</p>
						<p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>
					</div>
				</div>
			</div>

			<div class="item">
				<div class="lender-row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="star-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
						<div class="comntday">2 days ago</div>
						<div class="lendername">H P</div>
						<div class="member-year">Member Since 2019</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="lender-maincomnt">Highly recommended for folks looking for high returns</h2>
						<p class="lender-comt">I was searching for some good investment option on web and stumble upon Antworkp2p.com. I visited their website and got a call in evening about the whole thing. Their executive helped me in understanding of P2p investment and got me registered as Investor. I started with INR 50000 and choose to invest on my own. I was surprised by the featured they provide to lender to monitor and review the performance of their portfolio. I realised a fairly good return on my investment with 5 months of time.</p>
						<p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>
					</div>
				</div>
			</div>

			<div class="item">
				<div class="lender-row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="star-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
						<div class="comntday">2 days ago</div>
						<div class="lendername">A K</div>
						<div class="member-year">Member Since 2019</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="lender-maincomnt">Best in class alternate investment opportunity </h2>
						<p class="lender-comt">I was looking for alternate investment options and I invested 25K on antworksp2p on recommendation from a close friend of mine. They have a very good dashboard features to monitor investment. You can choose who you want to lend your money. You can choose upto 36% ROI to maximise your returns. They have a very good system in place to view and analyse verified borrowers to manage the investment risk.</p>
						<p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>
					</div>
				</div>
			</div>

			<div class="item">
				<div class="lender-row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="star-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
						<div class="comntday">2 days ago</div>
						<div class="lendername">V P</div>
						<div class="member-year">Member Since 2019</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 class="lender-maincomnt">Getting best returns in P2P domain with Antworks P2P</h2>
						<p class="lender-comt">Antworks p2p is highly reliable and much awaited platform in p2p domain. I started investing on their platform on late 2020 and since them I have been consistently lending to borrowers on their platform. I use the Antworks rating to judge borrowers profile and then lend them money. Their rating helped me in mitigating the default risk on my investment. I highly recommend Antworks p2p platform to earn better returns and thus maximise your earning potential.</p>
						<p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>  ----->

<section class="blogs-main" style="padding-bottom: 10px;">

                <div class="container wow fadeInUp animated animated" data-wow-delay="0.3s"><h2 class="blogs-hd" style="margin-bottom: 30px;">Testimonials</h2></div>

                <div class="container">

 

                                <div id="browse-lenders" class="owl-carousel owl-theme">

                                                <div class="item">

                                                                <div class="lender-row">

                                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                                                <img class="testimonials-img" src="../assets/img/user.png">

                                                                                </div>

                                                                                <div class="col-md-9 col-sm-9 col-xs-12">

                                                                                                <!--div class="comntday">2 days ago</div-->

                                                                                                <div class="lendername">A C</div>

                                                                                </div>

                                                                                <div class="col-md-12 col-sm-1 col-xs-12">

                                                                                                <h2 class="lender-maincomnt">So happy that I started investment with Antworks P2P</h2>

                                                                                                <div class="member-year">Member Since 2019</div>

                                                                                                <p class="lender-comt">I have a very enriched experience with Antworks P2P. I registered on the website. The registration process is smooth and hassle free. I got returns above 24% in just 8 months of my investment. They have the best in class products for your investment. I highly recommend Antworks  P2P.</p>

                                                                                                <div class="star-rating">

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                </div>

                                                                                                <p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>

                                                                                </div>

                                                                </div>

                                                </div>

 

                                                <div class="item">

                                                                <div class="lender-row">

                                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                                                <img class="testimonials-img" src="../assets/img/user.png">

                                                                                </div>

                                                                                <div class="col-md-9 col-sm-9 col-xs-12">

                                                                                                <div class="lendername">V S</div>

                                                                                </div>

                                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                                                <h2 class="lender-maincomnt">My money is working for me. WOW!</h2>

                                                                                                <div class="member-year">Member Since 2019</div>

                                                                                                <p class="lender-comt">I was sceptical about p2p investments as it is fairly new in India. One of friend recommended Antworks p2p for investment and I thought to give a shot. Believe me, I couldn�t be more apt about my decision. I started with a small amount to check their platform and found that it is reliable to generate good return. Just like my friend I also recommend people to go for Antworks p2p.</p>

                                                                                                <div class="star-rating">

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                </div>

                                                                                                <p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>

                                                                                </div>

                                                                </div>

                                                </div>

 

                                                <div class="item">

                                                                <div class="lender-row">

                                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                                                <img class="testimonials-img" src="../assets/img/user.png">

                                                                                </div>

                                                                                <div class="col-md-9 col-sm-9 col-xs-12">

                                                                                                <div class="lendername">H P</div>

                                                                                </div>

                                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                                                <h2 class="lender-maincomnt">Highly recommended for folks looking for high returns</h2>

                                                                                                <div class="member-year">Member Since 2019</div>

                                                                                                <p class="lender-comt">I was searching for some good investment option on web and stumble upon Antworkp2p.com. I visited their website and got a call in evening about the whole thing. Their executive helped me in understanding of P2p investment and got me registered as Investor. I started with INR 50000 and choose to invest on my own. I was surprised by the featured they provide to lender to monitor and review the performance of their portfolio. I realised a fairly good return on my investment with 5 months of time.</p>

                                                                                                <div class="star-rating">

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                </div>

                                                                                                <p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>

                                                                                </div>

                                                                </div>

                                                </div>

 

                                                <div class="item">

                                                                <div class="lender-row">

                                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                                                <img class="testimonials-img" src="../assets/img/user.png">

                                                                                </div>

                                                                                <div class="col-md-9 col-sm-9 col-xs-12">

                                                                                                <div class="lendername">A K</div>

                                                                                </div>

                                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                                                <h2 class="lender-maincomnt">Best in class alternate investment opportunity </h2>

                                                                                                <div class="member-year">Member Since 2019</div>

                                                                                                <p class="lender-comt">I was looking for alternate investment options and I invested 25K on antworksp2p on recommendation from a close friend of mine. They have a very good dashboard features to monitor investment. You can choose who you want to lend your money. You can choose upto 36% ROI to maximise your returns. They have a very good system in place to view and analyse verified borrowers to manage the investment risk.</p>

                                                                                                <div class="star-rating">

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                </div>

                                                                                                <p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>

                                                                                </div>

                                                                </div>

                                                </div>

 

                                                <div class="item">

                                                                <div class="lender-row">

                                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                                                <img class="testimonials-img" src="../assets/img/user.png">

                                                                                </div>

                                                                                <div class="col-md-9 col-sm-9 col-xs-12">

                                                                                                <div class="lendername">V P</div>

                                                                                </div>

                                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                                                <h2 class="lender-maincomnt">Getting best returns in P2P domain with Antworks P2P</h2>

                                                                                                <div class="member-year">Member Since 2019</div>

                                                                                                <p class="lender-comt">Antworks p2p is highly reliable and much awaited platform in p2p domain. I started investing on their platform on late 2020 and since them I have been consistently lending to borrowers on their platform. I use the Antworks rating to judge borrowers profile and then lend them money. Their rating helped me in mitigating the default risk on my investment. I highly recommend Antworks p2p platform to earn better returns and thus maximise your earning potential.</p>

                                                                                                <div class="star-rating">

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                                <i class="fa fa-star"></i>

                                                                                                </div>

                                                                                                <p class="recommended"><i class="fa fa-check"></i> Yes, I recommend this platform.</p>

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
<script src="https://www.antworksp2p.com/assets/assets/owl.carousel-2/owl.carousel.min.js"></script>
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
<script>
	var owl = $('#browse-lenders');
	owl.owlCarousel({
		items: 3,
		loop: true,
		margin: 0,
		autoplay: true,
		dots: false,
		nav: false,
		autoplayTimeout: 10000,
		autoplayHoverPause: false
	});
	$('.play').on('click', function () {
		owl.trigger('play.owl.autoplay', [1000])
	});
	$('.stop').on('click', function () {
		owl.trigger('stop.owl.autoplay')
	})
</script>
