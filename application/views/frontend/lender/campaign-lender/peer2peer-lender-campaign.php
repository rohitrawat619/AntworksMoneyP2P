<link rel="stylesheet" href="<?=base_url();?>assets/css/campaign-style.css">
<div class="container-fluid" style="position: relative;">
	<div class="row">
		<div class="textoverlay">
			<div class="bannertext"><span>My business suffered due to lockdown.</span>
				You can help me restart my business
				by providing me a business Loan.</div>
			<div class="support"><a href="<?=base_url();?>home/lender_lending_campaign_inner">Support Now</a></div>
			<div class="description"><p>Antworks is raising INR 10 Crore to ensure a brighter future more 5000 small businesses in India. <a href="https://antworksp2p.com/home/lender_lending_campaign_inner" class="knowmore">Know More</a> </p></div>
			<ul class="support-ratio"><li>Amount raise <div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 6%;">
							<span class="sr-only">6% Complete</span>
						</div>
					</div>
				</li> <li>Supporter <div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 6%;">
							<span class="sr-only">6% Complete</span>
						</div>
					</div></li></ul>
		</div>

		<div class="owl-carousel owl-theme" id="campaign_owl_carousel">
			<div class="item"><img src="<?=base_url();?>assets/images/banner.jpg"></div>
			<div class="item"><img src="<?=base_url();?>assets/images/banner2.jpg"></div>
			<div class="item"><img src="<?=base_url();?>assets/images/banner3.jpg"></div>
			<div class="item"><img src="<?=base_url();?>assets/images/banner4.jpg"></div>
		</div>
	</div>
</div>

<section class="lender_benefits_main">
	<div class="container">
		<div class="col-md-6 lender-mainbg">
			<div class="row">
				<h3 class="lender-mainbg-hd">Benefits of Lender</h3>
				<h3 class="lender-mainbg-hd">Get Return <span>24</span>% p.a.</h3>
				<p class="lender-befts-txt">Get More Lending offers to Choose from wide range of Borrowers.</p>
				<a href="#" class="btn-started">Get Started</a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<ul class="lender-benefits">
					<li><img src="<?=base_url();?>assets/img/profits.png" alt="Higher Returns"><p>Higher Returns</p></li>
					<li><img src="<?=base_url();?>assets/img/tactical.png" alt="Higher Returns"><p>Simplified Process</p></li>
					<li><img src="<?=base_url();?>assets/img/piggy-bank.png" alt="Higher Returns"><p>Smart Invest</p></li>
					<li><img src="<?=base_url();?>assets/img/verified.png" alt="Higher Returns"><p>Verified Borrowers</p></li>
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
			<img src="<?=base_url();?>assets/img/p2pbanner.png" alt="What is Peer to Peer Lending?">
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
					<img src="<?php echo $row['blog_fetured_image'] ?>" alt="Antworks P2P">
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
<script src="<?=base_url();?>assets/js/home-page-lender.js"></script>
<!-- Start of Async Drift Code -->
<script>
    "use strict";

    !function() {
        var t = window.driftt = window.drift = window.driftt || [];
        if (!t.init) {
            if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
            t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ],
                t.factory = function(e) {
                    return function() {
                        var n = Array.prototype.slice.call(arguments);
                        return n.unshift(e), t.push(n), t;
                    };
                }, t.methods.forEach(function(e) {
                t[e] = t.factory(e);
            }), t.load = function(t) {
                var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
                o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
                var i = document.getElementsByTagName("script")[0];
                i.parentNode.insertBefore(o, i);
            };
        }
    }();
    drift.SNIPPET_VERSION = '0.3.1';
    drift.load('mkmma7hmc8yy');
</script>
<!-- End of Async Drift Code -->
