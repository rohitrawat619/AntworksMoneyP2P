<?php $this->router->fetch_class(); ?>
<footer class="footer has-dot-pattern sec-pad-30">
	<div class="container">
		<div class="" style="margin-bottom: 0px !important; padding:10px">
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="single-footer-widget link-widget">
					<div class="menu-footer-menu-container">
						<ul id="menu-footer-menu" class="menu">
							<li><a href="<?php echo base_url(); ?>about-us">About Us</a></li>
							<li><a href="<?php echo base_url(); ?>fees-and-charges">Fees & Charges</a></li>
							<li><a href="<?php echo base_url('lender/portfolio-performance'); ?>">Portfolio Performance</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="single-footer-widget link-widget">
					<div class="menu-footer-menu-container">
						<ul id="menu-footer-menu" class="menu">
							<li><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
							<li><a href="<?php echo base_url(); ?>privacy-and-policy">Privacy Policy</a></li>
							<li><a href="<?php echo base_url(); ?>affiliates">Affiliates</a></li>

						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="single-footer-widget link-widget">
					<div class="menu-footer-menu-container">
						<ul id="menu-footer-menu" class="menu">
							<li><a href="<?php echo base_url(); ?>how-it-works">How it works</a></li>
							<li><a href="<?php echo base_url(); ?>term-and-conditions">Term & Conditions</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="single-footer-widget link-widget">
					<div class="menu-footer-menu-container">
						<ul id="menu-footer-menu" class="menu">
							<li><a href="<?php echo base_url(); ?>fair-practices-code">Fair Practices Code</a></li>
							<li><a href="<?php echo base_url(); ?>faq">FAQs - Investor Antworks Money </a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->

	</div>
	<!-- /.container -->

</footer>
<!-- /.footer -->

<section class="footer-bottom">
	<div class="container">
		<div class="copyright pull-left">
			<div class="disclaimer">

				<p><strong>Disclaimer: </strong>Reserve Bank of India does not accept any responsibility for the
					correctness of any of the statements or representations made or opinions expressed by Antworks P2P
					Financing Private Limited, and does not provide any assurance for repayment of the loans lent on it.
					Antworks P2P Financing Private Limited is having a valid certificate of registration dated April 01,
					2019 issued by the Reserve Bank of India under Section 45 IA of the Reserve Bank of India Act, 1934.
					However, the RBI does not accept any responsibility or guarantee about the present position as to
					the financial soundness of the company or for the correctness of any of the statements or
					representations made or the opinions expressed by the company and for repayment of deposits /
					discharge of liabilities by the company.</p>
				<p>The information contained herein is only to enable the Lender to make a considered decision. Any
					decision taken by the Lender on the basis of this information is the sole responsibility of the
					Lender and Antworks P2P Financing is not liable. This information does not include any sensitive
					personal data or information of the Borrower. Antworks P2P Financing only facilitates a virtual
					meeting place between the Borrowers and the Lenders on its online platform. The decision to lend is
					entirely at the discretion of the Lender and Antworks P2P Financing does not guarantee that the
					Borrowers will receive any loans from the Lenders. Antworks P2P Financing merely aids and assist the
					Lenders and the Borrowers listed on its website to make and receive loans and charges a service fee
					from the Lenders and the Borrowers for such assistance. Antworks P2P Fianncing is only an
					‘Intermediary’ under the provisions of the Information Technology Act, 1999.</p>

			</div>
			<?php if($this->uri->segment(1) == 'personal-loan'){?>
			<p class="text-center">Registered Address: UL03, EF3 Mall, Sector-20A, Faridabad, Haryana 121007, India</p>
			<?php } ?>
			<p>Copyrights © Antworks P2P Financing 2019-<?= date('Y'); ?> All Rights Reserved.</p>
		</div>
		<!-- /.copyright pull-left -->
		<div class="social pull-right">
			<ul class="list-inline">
				<li><a target="_blank" href="https://www.facebook.com/antworksmoney"><i class="fa fa-facebook"></i></a>
				</li>
				<li><a target="_blank" href="https://twitter.com/AntworksMoney"><i class="fa fa-twitter"></i></a></li>
				<li><a target="_blank" href="https://www.linkedin.com/company-beta/13288601"><i
							class="fa fa-linkedin"></i></a></li>
			</ul>

			<!-- /.list-inline -->
		</div>
		<div class="clearfix">
			<span class="pull-right" style="margin-top: 20px;"></span>
		</div>
		<!-- /.social pull-right -->
	</div>
	<!-- /.container -->
</section>
<!-- /.footer-bottom -->

<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
<script src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>

<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<script src="<?= base_url(); ?>assets/assets/owl.carousel-2/owl.carousel.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<script src="<?= base_url(); ?>assets/js/validate.js"></script>
<script src="<?= base_url(); ?>assets/js/tinynav.min.js"></script>
<?php if ($this->router->fetch_class() == 'Emi_calculator') { ?>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/materialize.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.formset.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/materialize.forms.js"></script>
<?php } ?>
<script>
	var owl = $('#campaign_owl_carousel');
	owl.owlCarousel({
		items: 1,
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
</body></html>
