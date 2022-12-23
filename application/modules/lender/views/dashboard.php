<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?= getNotificationHtml(); ?>
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12">
		<div class="mytitle row">
			<div class="left col-md-12">
				<h1>Dashboard</h1>
			</div>
		</div>
		<div class="white-box">
			<div class="row">
				<div class="col-lg-3 col-sm-3 col-xs-12">
					<div class="white-box analytics-info">
						<h3 class="box-title">Live Proposal</h3>
						<ul class="list-inline two-part">
							<li>
								<div id="sparklinedash"></div>
							</li>
							<li class="text-right"><i class="ti-arrow-up text-success"></i> <span
									class="counter text-success"><?php echo $liveproposal; ?></span></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-12">
					<div class="white-box analytics-info">
						<h3 class="box-title">Live Borrower</h3>
						<ul class="list-inline two-part">
							<li>
								<div id="sparklinedash2"></div>
							</li>
							<li class="text-right"><i class="ti-arrow-up text-purple"></i> <span
									class="counter text-purple"><?php echo $liveBorrower; ?></span></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-12">
					<div class="white-box analytics-info">
						<h3 class="box-title">Bid Received</h3>
						<ul class="list-inline two-part">
							<li>
								<div id="sparklinedash3"></div>
							</li>
							<li class="text-right"><i class="ti-arrow-up text-info"></i> <span
									class="counter text-info"><?php echo $totalbidrecieved; ?></span></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3 col-xs-12">
					<div class="white-box analytics-info">
						<h3 class="box-title">Average ROI</h3>
						<ul class="list-inline two-part">
							<li>
								<div id="sparklinedash4"></div>
							</li>
							<li class="text-right"><i class="ti-arrow-up text-danger"></i> <span
									class="counter text-danger"><?php echo round($totalAvgintrestrate['interest_rate'], 2); ?></span>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-12 hidden">
				<p>Note: It should be running or animated type.</p>
				<div class="stat-item"><h6>Live Proposal</h6> <b>35.40%</b></div>
				<div class="stat-item"><h6>Live Lender</h6> <b>15.40%</b></div>
				<div class="stat-item"><h6>Total Received</h6> <b>75.50%</b></div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-7 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<div class="white-box">
							<h3 class="box-title">User Profile</h3>
							<ul class="list-inline two-part">
								<li><i class="icon-people text-info"></i></li>
								<li class="text-right"><span class="counter">100%</span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<a href="<?= base_url(); ?>bidding/live-bids">
							<div class="white-box">
								<h3 class="box-title">Live Bids</h3>
								<ul class="list-inline two-part">
									<li><i class="icon-folder text-purple"></i></li>
									<li class="text-right"><span class="counter"><?php echo $totalLivebids; ?></span>
									</li>
								</ul>
							</div>
						</a>
					</div>
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<a href="<?php echo base_url(); ?>lender/my-performance">
						<div class="white-box">
							<h3 class="box-title">My Performance</h3>
							<ul class="list-inline two-part">
									<li><i class="icon-graph text-danger"></i></li>
									<li class="text-right"><span class=""></span></li>
							</ul>
						</div>
						</a>
					</div>
					<div class="col-lg-6 col-sm-6 col-xs-12">
						<a href="<?php echo base_url(); ?>lender/request/escrow-account-statement">
						<div class="white-box">
							<h3 class="box-title">Escrow Account Statement</h3>
							<ul class="list-inline two-part">

									<li><i class="ti-wallet text-success"></i></li>
									<li class="text-right"><span class=""></span></li>

							</ul>
						</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-5 col-sm-12 col-xs-12">
				<div class="white-box">
					<h3 class="box-title">Notifications</h3>
										<ul class="feeds">
											<?php if($notifications){foreach ($notifications as $notification){?>
											<li>
												<div class="bg-info"><i class="fa fa-bell-o text-white"></i></div><?= $notification['instance']?><span class="text-muted"><?= date('d M'); ?></span></li>
											<li>
											<?}}else{echo "Notification list is empty";} ?>

<!--												<div class="bg-success"><i class="ti-server text-white"></i></div> Server #1 overloaded.<span class="text-muted">2 Hours ago</span></li>-->
<!--											<li>-->
<!--												<div class="bg-warning"><i class="ti-shopping-cart text-white"></i></div> New order received.<span class="text-muted">31 May</span></li>-->
<!--											<li>-->
<!--												<div class="bg-danger"><i class="ti-user text-white"></i></div> New user registered.<span class="text-muted">30 May</span></li>-->
<!--											<li>-->
<!--												<div class="bg-inverse"><i class="fa fa-bell-o text-white"></i></div> New Version just arrived. <span class="text-muted">27 May</span></li>-->
<!--											<li>-->
<!--												<div class="bg-purple"><i class="ti-settings text-white"></i></div> You have 4 pending tasks. <span class="text-muted">27 May</span></li>-->
										</ul>
				</div>
			</div>
		</div>

	</div>
</div>
<script>
	$(window).load(function () {
		$('li').removeClass('active1');
		$('.dashboard').addClass('sidebarmenu-active');
	});
</script>
