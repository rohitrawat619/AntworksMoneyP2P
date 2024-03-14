<script src='https://www.google.com/recaptcha/api.js'></script>
<style>.contact-form input, .contact-form textarea {
   
    border: 1px solid #DCD8D8 !important;
  
}</style>
<div class=" sec-pad service-box-one service">
  <div class="container">

    <div class="col-md-7">
			<div class="sec-title">
				<h2>Contact Us</h2>
				<span class="decor-line">
					<span class="decor-line-inner"></span>
				</span>
			</div>
			<form action="<?php base_url(); ?>contact-us/contact-us-mail" method="post" onsubmit="return validate_contact()" class="contact-form">
				<div class="row">
					<div class="col-md-6">
						<div class="form-grp">
							<input type="text" name="name" id="name" placeholder="Your Name *" required />
                                <span class="help-block with-errors"><ul class="list-unstyled"><li id="name-error" class="errors-class"></li></ul></span>
						</div><!-- /.form-grp -->
					</div><!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-grp">
							<input type="text" name="email" id="email" placeholder="Email Address *" required /><span class="help-block with-errors"><ul class="list-unstyled"><li id="email-error" class="errors-class"></li></ul></span>
						</div><!-- /.form-grp -->
					</div><!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-grp">
							<input type="text" name="mobile" maxlength="10" onkeypress="return isNumberKey(event)" id="mobile" placeholder="Phone" required /><span class="help-block with-errors"><ul class="list-unstyled"><li id="mobile-error" class="errors-class"></li></ul></span>
						</div><!-- /.form-grp -->
					</div><!-- /.col-md-6 -->
					<div class="col-md-6">
						<div class="form-grp">
							<input type="text" name="subject" id="subject" placeholder="Subject*"  required /><span class="help-block with-errors"><ul class="list-unstyled"><li id="subject-error" class="errors-class"></li></ul></span>
						</div><!-- /.form-grp -->
					</div><!-- /.col-md-6 -->
					<div class="col-md-12">
						<div class="form-grp">
							<textarea name="message" id="message" placeholder="Message*"></textarea><span class="help-block with-errors"><ul class="list-unstyled"><li id="message-error" class="errors-class"></li></ul></span>						
						</div><!-- /.form-grp -->
                        <div class="col-md-6">
                            <div  style="overflow:hidden;">
                                <div style="width:302px; margin:auto;">
                                    <div class="g-recaptcha" data-sitekey="6LfUYaIUAAAAAOqrko0_kXnnOV_1Lln02V8BrXHH"></div>
                                    <span id="captcha" style="color:red"></span>
                                </div>
                            </div>
                        </div>
						<button type="submit" name="ContactSubmit" class="thm-btn">Submit Now</button>
						<br><br><br>
					</div><!-- /.col-md-6 -->
				</div><!-- /.row -->
				<div class="form-result"></div><!-- /.form-result -->
			</form>
		</div><!-- /.col-md-8 -->
		<div class="col-md-5">
			<div class="sec-title">
				<h2>Get In Touch With Us</h2>
				<span class="decor-line">
					<span class="decor-line-inner"></span>
				</span>
			</div>
			<div class="contact-info-box">

				<ul class="info-items">
					<li>
						<div class="icon-box">
							<div class="inner-box">
								<i class="fn-icon-international-delivery"></i>
							</div><!-- /.inner-box -->
						</div><!-- /.icon-box -->
						<div class="text-box">
							<h3>Registered Address :</h3>
							<p>UL-03, Eros EF3 Mal, Sector-20 A, Mathura Road, Faridabad,121001, Haryana</p>
						</div><!-- /.text-box -->
					</li>
					<li>
						<div class="icon-box">
							<div class="inner-box">
								<i class="fn-icon-international-delivery"></i>
							</div><!-- /.inner-box -->
						</div><!-- /.icon-box -->
						<div class="text-box">
							<h3>Corporate Address :</h3>
							<p>Unit 165, Tower-B1, Spaze iTech Park Sector-49, Sohna Road, Gurgaon Haryana 122018</p>
						</div><!-- /.text-box -->
					</li>
<!--					<li>-->
<!--						<div class="icon-box">-->
<!--							<div class="inner-box">-->
<!--								<i class="fa fa-envelope"></i>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="text-box">-->
<!--							<h3>Ask Anything Here :</h3>-->
<!--							<p>support@antworksmoney.com</p>-->
<!--						</div>-->
<!--					</li>-->
					<li>
						<div class="icon-box">
							<div class="inner-box">
								<i class="fn-icon-phone-call"></i>
							</div><!-- /.inner-box -->
						</div><!-- /.icon-box -->
						<div class="text-box">
							<h3>Call Us:</h3>
							<p> 7042307683</p>
						</div><!-- /.text-box -->
					</li>
				</ul><!-- /.info-items -->
			</div><!-- /.contact-info-box -->
		</div><!-- /.col-md-8 -->
    <!-- /.col-md-9 -->
     
  </div>
  <!-- /.row --> 
</div>