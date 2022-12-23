<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
    table {
        border:1px solid grey
    }
    table td {
        padding: 10px;
        text-align:left;
    }
    table th {
        text-align:center
    }
    tr:nth-child(even) {
        background:#ddf2ff
    }
    tr:nth-child(odd) {
        background: #FFF
    }
	.grievance li {padding-bottom:15px;}
	.contact-form input, .contact-form textarea {border: 1px solid #DCD8D8 !important;}
</style>
<section class="sec-pad service-box-one service">
    <div class="container">
        <!-- /.sec-title -->
        <div class="row">
            <div class="col-md-12">
                <div class="sec-title medium">
                    <h2>Grievance Redressal policy</h2>
                    <span class="decor-line"> <span class="decor-line-inner"></span> </span> </div>
                <!-- /.sec-title -->
                <div class="modal-body">
                <ol class="grievance">
					<li>Any issues that the participants (lenders / borrowers) might have during the course of their journey with http://antworksp2p.com should be addressed by writing an email to the Antworks support team.</li>
					<li>The customer support team should identify the type of enquiry (i.e. borrower related / lender related / website or app related, etc) and forward it to the appropriate team internally within 24 hours.</li>
					<li>The appropriate team should respond to the enquiry within 24 hours; if it’s a technical issue which requires some rectification, timeline of the same should be informed to the borrower / lender.</li>
					<li>If the participants enquiries / complaints are not addressed within 5 working days, grievances should be addressed to the grievance officer.</li>
					<li>The grievance officer is Shantanu Tewary available on shantanu[at]antworksmoney[dot]com and +91-9717544770</li>
					<li>If the participants enquiries / complaints are still not addressed after 10 working days, grievances should be marked by mail to the Director, Mr. Subhayu Ghose at subhayu[at]antworksmoney[dot]com</li>
					<li>Any and all complaints / comments received through any other medium other than email (such as Facebook, whatsapp, twitter, etc) should also be handled within the same timelines as mentioned above. The first line of escalation will be the grievance officer followed by the Director, Mr. Subhayu Ghose.</li> 
				</ol>
				<div class="col-md-7">
					<form action="<?php base_url(); ?>grievance-redressal/grievance-redressal-form" onsubmit="return validate_contact()" method="post" class="contact-form">
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
                                <div class="col-md-7">
                                    <div  style="overflow:hidden;">
                                        <div style="width:302px; margin:auto;">
                                            <div class="g-recaptcha" data-sitekey="6LfUYaIUAAAAAOqrko0_kXnnOV_1Lln02V8BrXHH"></div>
                                            <span id="captcha" style="color:red"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <input type="submit" name="Submit" class="thm-btn" value="Submit Now">
                                </div>
								<br><br><br>
							</div><!-- /.col-md-6 -->
						</div><!-- /.row -->
						<div class="form-result"></div><!-- /.form-result -->
					</form>
		</div>
				
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>