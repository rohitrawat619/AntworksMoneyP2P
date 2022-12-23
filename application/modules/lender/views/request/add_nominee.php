<style>
	.marz-t-30 {margin-top:30px;}
	.payout-main .form-horizontal .form-group {min-height:auto;}
	.payout-main p {text-align:center;}
	.payout-main p:first-child {font-size:16px;}
	.payout-main p:first-child span {font-weight:600;}
	.payout-hd {background: #01548f; text-transform:uppercase; color:#fff; padding:5px 15px; font-size:18px; margin-bottom:15px;}
	.payout-main .form-horizontal {margin-left: 15px; margin-right: 20px;}
	.nom-adrs {min-height:50px;}
	@media(max-width:767px){}
</style>

<section class="sec-pad sec-pad-30">
<div class="col-md-12">
    <div class="row">
        <div class="mytitle row">
            <div class="left col-md-12">
                <h1 id="pagetitle"><?=$pageTitle;?></h1>
				<?=getNotificationHtml();?>
            </div>
        </div>
		<div class="white-box">
		
		<div class="row">
			<div class="payout-main">
				<div class="payout-bx">
					<form class="form-horizontal" method="post" action="<?php echo base_url()?>lenderaction/addNominee">
					  
					  
					  <div class="col-md-6">
						  <div class="form-group">
							<label for="amount" class="col-sm-12">Nominee Full Name:</label>
							<div class="col-sm-12">
							  <input type="text" name="full_name" id="full_name" class="form-control">
							</div>
						  </div>
					  </div>
					  <div class="col-md-6">
						  <div class="form-group">
							<label for="amount" class="col-sm-12">Nominee Pan Number:</label>
							<div class="col-sm-12">
							  <input type="text" id="pan" name="pan" class="form-control">
							</div>
						  </div>
					  </div>
					  <div class="col-md-6">
						  <div class="form-group">
							<label for="amount" class="col-sm-12">Date of Birth:</label>
							<div class="col-sm-12">
							  <input class="form-control" name="dob" id="datepicker-autoclose" readonly="" placeholder="Select Date of Birth" type="text">
							</div>
						  </div>
					  </div>
					  <div class="col-md-6">
						  <div class="form-group">
							<label for="amount" class="col-sm-12">Nominee Email Address:</label>
							<div class="col-sm-12">
							  <input type="text" id="email" name="email" class="form-control">
							</div>
						  </div>
					  </div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="amount" class="col-sm-12">Nominee Mobile No:</label>
								<div class="col-sm-12">
									<input type="text" id="mobile" name="mobile" class="form-control">
								</div>
							</div>
						</div>

					  <div class="col-md-12">
						  <div class="form-group">
							<label for="amount" class="col-sm-4">Nominee Address:</label>
							<div class="col-sm-12">
							  <textarea class="form-control nom-adrs" name="address" id="address" placeholder="Write Nominee Address"></textarea>
							</div>
						  </div>
					  </div>
					  <div class="form-group">
						<div class="col-md-12 text-right">
						  <button type="submit" class="btn btn-primary">Submit</button>
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
