<section class="product-bannerp2p businessloan-banr">
	<div class="container">
		<div class="col-md-4 col-md-offset-8">
			<!-- Tab panes -->
			<div class="productform">
				<h4 class="prodbanr-hd">Register Now</h4>
				<form action="<?php echo base_url(); ?>borrower-registration" method="post">
					<div class="col-xs-12 fullname">
						<input type="text" name="FullName" class="form-control" placeholder="Your Full Name" />
					</div>
					<div class="col-xs-12">
						<input type="text" name="Mobile" class="form-control" placeholder="Mobile No" />
					</div>
					<div class="col-md-12 col-xs-12">
						<label>Need a Loan of</label>
						<div class="slider_bg">
							<div id="interest-calcb"  class="noUi-target noUi-ltr noUi-horizontal"></div>
							<input type="text" name="loan_amount_borrower" id="interest-range-calcb" value="10000"/>
						</div>
					</div>
					<div class="col-md-12 col-xs-12">
						<label>For Months</label>
						<div class="slider_bg">
							<div id="tenor-calcb"  class="noUi-target noUi-ltr noUi-horizontal"></div>
							<input type="text" name="tenor_borrower" id="tenor-range-calcb" value="6" />
						</div>
					</div>
					<div class="col-md-12 col-xs-12">
						<label>ROI (Rate of Interest) %</label>
						<div class="slider_bg">
							<div id="emi-calcb"  class="noUi-target noUi-ltr noUi-horizontal"></div>
							<input id="slider_emib" name="emi_borrower" value="" type="text">
						</div>
					</div>
					<div class="col-xs-12">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
						<input type="submit" class="getstarted-btn" value="Get Started"/>
					</div>
				</form>
			</div>
		</div>

	</div>
	</div>
</section>

<section class="lender_benefits_main">
	<div class="container">
		<div class="col-md-6 lender-mainbg">
			<div class="row">
				<h3 class="lender-mainbg-hd">Benefits of Borrower</h3>
				<h3 class="lender-mainbg-hd">Get ROI Starting <span>12</span>% p.a.</h3>
				<p class="lender-befts-txt">Based on credibility, borrowers are offered the best ROI from wide range of Lenders.</p>
				<a href="#" class="btn-started">Get Started</a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<ul class="lender-benefits">
					<li><img src="<?php echo base_url();?>assets/img/loss.png" alt="Higher Returns"><p>Lower ROI</p></li>
					<li><img src="<?php echo base_url();?>assets/img/tactical.png" alt="Higher Returns"><p>Simplified Process</p></li>
					<li><img src="<?php echo base_url();?>assets/img/loan-processing.png" alt="Higher Returns"><p>24x7 <span>Loan Processing</span></p></li>
					<li><img src="<?php echo base_url();?>assets/img/verified.png" alt="Higher Returns"><p>Verified Lenders</p></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="watp2p sec-pad m-sec-pad">
	<div class="container">
		<div class="col-md-6">
			<h2 class="watp2p-hd">What is Peer to Peer Lending?</h2>
			<p>Need a personal loan while you have been out of job? Your Credit Score is low? Or You don’t have a Credit history? Get best P2P loan offers on Antworks P2P Financing.</p>
			<p>We intend to provide a credible alternative to traditional banking system with an online market place that uses technology and a more efficient funding process to lower interest cost for Borrowers, increase earnings for Lenders and deliver better experience to Borrowers and Lenders.</p>
			<p>Antworks P2P is one of the fastest growing financial services portal in India. We welcome your feedback and suggestions to improve our services.</p>
		</div>
		<div class="col-md-6">
			<img src="<?php echo base_url();?>assets/img/p2pbanner.png" alt="What is Peer to Peer Lender?">
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

<script src="<?=base_url();?>assets/assets/noUiSlider.9.1.0/nouislider.js"></script>
<script src="<?=base_url();?>assets/js/wNumb.js"></script>
<script src="<?=base_url();?>assets/js/home-page.js"></script>
