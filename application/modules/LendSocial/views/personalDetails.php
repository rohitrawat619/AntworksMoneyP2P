<?php 
$pan_status = $lists['sessionData']['pan_status'];
if($pan_status==1){
$pan_status = "disabled";
}else{
$pan_status = "";
}
//echo $pan_status;
?>
<section class="container mainsurge-plans">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="surge-plans">
				<div class="row text-center">
					<img src="<?php echo $logo_path; ?>" class="surgelogo">
					<h2>Personal Details</h2>
				</div>
				<form role="form" action="accountDetails" method="post" class="f1"  onsubmit="return userFunctionvalidate()">
					<div class="f1-steps">
						<div class="f1-progress">
							<div class="f1-progress-line" data-now-value="33.33333" data-number-of-steps="3" style="width: 33.33333%;"></div>
						</div>
						<div class="f1-step active" id="step_1">
							<div class="f1-step-icon"><i class="fa fa-user"></i></div>
							<p>Personal Details</p>
						</div>
						<div class="f1-step" id="step_2">
							<div class="f1-step-icon"><i class="fa fa-key"></i></div>
							<p>Account Details</p>
						</div>
					</div>
					<div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input type="text" name="name" placeholder="Full name as per PAN card" <?php echo $pan_status; ?> value="<?php echo $lists['sessionData']['name']; ?>" class="f1-first-name form-control" id="name">
								<span class="validation error-validation" id="error_name"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                   
									<input class="form-control hasDatepicker" <?php echo $pan_status; ?> name="date_of_birth" id="datepicker" value="<?php echo $lists['sessionData']['date_of_birth']; ?>" placeholder="Date of Birth" type="date">
                                    <span class="validation error-validation" id="error_datepicker"></span>
                                </div>
                            </div>

											<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<?php $gender = $lists['sessionData']['gender']; ?>
							<select <?php echo $pan_status; ?> class="form-control" name="gender" id="gender">
								<option value="">Select Gender</option>
								<option value="male" <?php echo ($gender === 'male') ? 'selected' : ''; ?>>Male</option>
								<option value="female" <?php echo ($gender === 'female') ? 'selected' : ''; ?>>Female</option>
								<option value="other" <?php echo ($gender === 'other') ? 'selected' : ''; ?>>Other</option>
							</select>
							<span class="validation error-validation" id="error_gender"></span>
						</div>
					</div>

						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input class="form-control" <?php echo $pan_status; ?> placeholder="Email" type="text" name="email_id" id="email_id" value="<?php echo $lists['sessionData']['email_id']; ?>" onkeyup="checkExist(this.value)">
								<span class="validation error-validation" id="error_email"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							
								<div class="form-group">
									<input class="form-control" readonly="" id="mobile" value="<?php echo $lists['sessionData']['mobile']; ?>" maxlength="10" onkeypress="return isNumberKey(event)">
									<span class="validation error-validation" id="error_mobile"></span>
								</div>
							
						</div>
												<div class="col-md-6 col-xs-12">
							
								<div class="form-group">
									<input class="form-control" name="aadhaar"  id="aadhaar" value="<?php echo $lists['sessionData']['aadhaar']; ?>" placeholder="Aadhaar No" maxlength="14" onkeypress="return isNumberKey(event)">
									<span class="validation error-validation" id="error_aadhaar"></span>
								</div>
							
						</div>
						

						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input class="form-control" <?php echo $pan_status; ?> type="text" name="pan_card" placeholder="Pancard No" id="pan_card" value="<?php echo $lists['sessionData']['pan_card']; ?>" maxlength="10" onkeyup="checkExistpan(this.value)">
								<span class="validation error-validation" id="error_pan"></span>
							</div>
						</div>
							<input  type="hidden" name="mobile"  id="mobile" value="<?php echo $lists['sessionData']['mobile']; ?>" >
							<input  type="hidden" name="id"  id="id" value="<?php echo $lists['sessionData']['id']; ?>" >
							<input  type="hidden" name="form"  id="form" value="personalDetail" >
						
						<div class="f1-buttons">
							<button type="submit" class="btn btn-next">Next</button>
						</div>
					</div>

				
				</form>
				
			</div>
		</div>
	</div>
</section>

