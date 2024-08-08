<style>
#company_list {
    display: none;
    max-height: 150px; /* Set a max-height for the company list */
    overflow-y: auto; /* Make the company list scrollable */
}
</style>

<?php 
$pan_status = $lists['sessionData']['pan_status'];
if($pan_status==1){
$pan_status = "readonly";
}else{
$pan_status = "";
}
//echo $pan_status;
// echo json_encode($lists['sessionData']);
?>
<?= getNotificationHtml(); ?>
<section class="container mainsurge-plans">

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="surge-plans">
				<div class="row text-center">
					<img src="<?php echo $sub_logo_path; ?>" class="surgelogo">
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
							 <label for="name" >Full Name</label>
								<input type="text" name="name" placeholder="Full name as per PAN card" <?php echo $pan_status; ?> value="<?php echo $lists['sessionData']['name']; ?>" class="f1-first-name form-control" id="name">
								<span class="validation error-validation" id="error_name"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                   <label for="date_of_birth" >Date Of Birth</label>
									<input class="form-control hasDatepicker" <?php echo $pan_status; ?> name="date_of_birth" id="datepicker" value="<?php echo $lists['sessionData']['date_of_birth']; ?>" placeholder="Date of Birth" type="date">
                                    <span class="validation error-validation" id="error_datepicker"></span>
                                </div>
                            </div>

											<div class="col-md-6 col-xs-12">
						<div class="form-group">
						 <label for="gender" >Gender</label>
							<?php $gender = $lists['sessionData']['gender']; ?>
							<select <?php echo $pan_status; ?> class="form-control" name="gender" id="gender">
								<option>Select Gender</option>
								<option value="male" <?php echo ($gender === 'male') ? 'selected' : ''; ?>>Male</option>
								<option value="female" <?php echo ($gender === 'female') ? 'selected' : ''; ?>>Female</option>
								<option value="other" <?php echo ($gender === 'other') ? 'selected' : ''; ?>>Other</option>
							</select>
							<span class="validation error-validation" id="error_gender"></span>
						</div>
					</div>

						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="email_id" >Email ID</label>
								<input class="form-control" <?php echo $pan_status; ?> placeholder="Email" required type="text" name="email_id" id="email_id" value="<?php echo $lists['sessionData']['email_id']; ?>" onkeyup="checkExist(this.value)">
								<span class="validation error-validation" id="error_email"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							
								<div class="form-group">
								 <label for="mobile" >Mobile</label>
									<input class="form-control" readonly="" id="mobile" value="<?php echo $lists['sessionData']['mobile']; ?>" maxlength="10" onkeypress="return isNumberKey(event)">
									<span class="validation error-validation" id="error_mobile"></span>
								</div>
							
						</div>
												<div class="col-md-6 col-xs-12">
							
								<div class="form-group">
								 <label for="aadhaar" >Aadhaar Number</label>
									<input class="form-control" name="aadhaar"  id="aadhaar" value="<?php echo $lists['sessionData']['aadhaar']; ?>" placeholder="Aadhaar No" maxlength="14" onkeypress="return isNumberKey(event)">
									<span class="validation error-validation" id="error_aadhaar"></span>
								</div>
							
						</div>
						

						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="pan_card" >PAN No.</label>
								<input class="form-control" <?php echo $pan_status; ?> type="text" required name="pan_card" placeholder="Pancard No" id="pan_card" value="<?php echo $lists['sessionData']['pan_card']; ?>" maxlength="10" onkeyup="checkExistpan(this.value)">
								<span class="validation error-validation" id="error_pan"></span>
							</div>
						</div>
						<!---------starting of borrower details--------->
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="highest_qualification" >Highest Qualification</label>
								<!--<input class="form-control" <?php // echo $highest_qualification; ?> type="text" name="highest_qualification" placeholder="Highest Qualification" id="highest_qualification" value="<?php echo $lists['sessionData']['highest_qualification']; ?>">
								<span class="validation error-validation" id="highest_qualification"></span>-->
								
								<select class="form-control" name="highest_qualification" id="highest_qualification" />
                                    <option value="">Select Qualification</option>
                                    <?php if($qualification){foreach ($qualification AS $quali){
										if($quali['id']== $lists['sessionData']['highest_qualification']){
											$selected = "selected";
										}else{
											$selected = "";
										}
                                        echo "<option $selected value='".$quali['id']."'>".$quali['qualification']."</option>";
                                    }} ?>
                                    </select>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="r_address" >Address</label>
								<input class="form-control" <?php echo $r_address; ?> type="text" name="r_address" placeholder="Address" id="r_address" value="<?php echo $lists['sessionData']['r_address']; ?>" >
								<span class="validation error-validation" id="r_address"></span>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="r_state" >State</label>
								<!--<input class="form-control" <?php // echo $r_state; ?> type="text" name="r_state" placeholder="r_state" id="r_state" value="<?php echo $lists['sessionData']['r_state']; ?>" >
								<span class="validation error-validation" id="r_state"></span>-->
								
								<select class="form-control" name="r_state" id="state" onChange="get_city()" />
                                    <option value="">Select State</option>
                                    <?php if($states){foreach ($states AS $state){
										if($state['state']== $lists['sessionData']['r_state']){
											$selected = "selected";
										}else{
											$selected = "";
										}
										$value = $state['state'] . ',' . $state['code'];
                                        echo "<option $selected value='".$value."'>".$state['state']."</option>";
                                    }} ?>
                                    </select>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="r_city" >City</label>
								<input class="form-control" <?php echo $r_city; ?> type="text" name="r_city" placeholder="City" id="r_city" value="<?php echo $lists['sessionData']['r_city']; ?>" >
								<span class="validation error-validation" id="r_city"></span>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="r_pincode" >Pincode</label>
								<input class="form-control" <?php echo $r_pincode; ?> type="text" name="r_pincode" placeholder="Pincode" id="r_pincode" value="<?php echo $lists['sessionData']['r_pincode']; ?>" >
								<span class="validation error-validation" id="r_pincode"></span>
							</div>
						</div>
						
						
						
						<!--<div class="col-md-6 col-xs-12">
							<div class="form-group">
							 <label for="r_state_code" >Stat</label>
								<input class="form-control" <?php // echo $r_state_code; ?> type="text" name="r_state_code" placeholder="r_state_code" id="r_state_code" value="<?php // echo $lists['sessionData']['r_state_code']; ?>" >
								<span class="validation error-validation" id="r_state_code"></span>
							</div>
						</div>-->
								<!-------------ending of borrower details--------------->
								
								
								
								
								<!-----------------starting of borrower company details----------------------------->
								<!--<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input class="form-control" <?php // echo $occuption_id; ?> type="text" name="occuption_id" placeholder="occuption_id" id="occuption_id" value="<?php // echo $lists['sessionData']['occuption_id']; ?>" >
								<span class="validation error-validation" id="occuption_id"></span>
							</div>
						</div>-->
						
						
						<div class="col-md-6 col-xs-12">
						 <label for="company_type" >Company Type</label>
							<div class="form-group">
								<!--<input class="form-control" <?php // echo $company_type; ?> type="text" name="company_type" placeholder="company_type" id="company_type" value="<?php // echo $lists['sessionData']['company_type']; ?>" >-->
							
																<?php
								// Define an array of options
								$options = [
									'' => 'Select Company Type',
									'Government' => 'Government',
									'PSUs' => 'PSUs',
									'MNC' => 'MNC',
									'Public Limited Company' => 'Public Limited Company',
									'Private Limited Company' => 'Private Limited Company',
									'Partnership' => 'Partnership',
									'Proprietorship' => 'Proprietorship',
									'Others' => 'Others'
								];
								?>

								<select class="form-control" required name="company_type" id="company_type">
									<?php foreach ($options as $value => $label): 
									
										if($value== $lists['sessionData']['company_type']){
											$selected = "selected";
										}else{
											$selected = "";
										}
									?>
									
										<option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
									<?php endforeach; ?>
								</select>

								<span class="validation error-validation" id="company_type"></span>
							</div>
						</div>
						
						
						<!--<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input class="form-control" <?php // echo $company_name; ?> type="text" name="company_name" placeholder="Company Name" id="company_name" value="<?php // echo $lists['sessionData']['company_name']; ?>" >
								<ul id='company_list'></ul>
								<span class="validation error-validation" id="company_name"></span>
							</div>
						</div>-->
						
						<div class="col-md-6 col-xs-12">
    <div class="form-group">
	 <label for="company_name" >Company Name</label>
	 <?php
		if($lists['sessionData']['company_code']=="" || $lists['sessionData']['company_code']<=0){
			$company_code =0;
		}else{
			$company_code = $lists['sessionData']['company_code'];
		}
	 ?>
        <input class="form-control" type="text" name="company_name" required placeholder="Company Name" id="company_name" value="<?php echo $lists['sessionData']['company_name']; ?>">
		
		<input class="" type="hidden" name="company_code" placeholder="company_code" id="company_code" value="<?php echo $company_code; ?>">
        <ul id='company_list' style="display:none"></ul>
        <span class="validation error-validation" id="company_name_error"></span>
    </div>
</div>
						
						
						<!--<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input class="form-control" <?php // echo $company_code; ?> type="text" name="company_code" placeholder="company_code" id="company_code" value="<?php // echo $lists['sessionData']['company_code']; ?>" >
								<span class="validation error-validation" id="company_code"></span>
							</div>
						</div>-->
						
						
						<div class="col-md-6 col-xs-12">
							 <label for="salary_process" >Salary Process</label>
							<div class="form-group">
								<!--<input class="form-control" <?php // echo $occuption_id; ?> type="text" name="occuption_id" placeholder="occuption_id" id="occuption_id" value="<?php // echo $lists['sessionData']['occuption_id']; ?>" >-->
								
								<select class="form-control" name="salary_process" id="salary_process">
    <?php
								// Define an array of options
					$options = [
						'' => 'Salary Process',
						'cheque' => 'Cheque',
						'accountTransfer' => 'Account Transfer',
						'cash' => 'Cash'
					];
	foreach ($options as $value => $label): 
			
			if($value== $lists['sessionData']['salary_process']){
											$selected = "selected";
										}else{
											$selected = "";
										}
	?>
	
        <option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
    <?php endforeach; ?>
</select>
								<span class="validation error-validation" id="salary_process"></span>
							</div>
						</div>
						
						
						<div class="col-md-6 col-xs-12">
								 <label for="net_monthly_income" >Net Monthly Income</label>
							<div class="form-group">
							<!----- <label for="name">Net Monthly Income</label> ---->


								<input class="form-control" <?php echo $net_monthly_income; ?> type="text" name="net_monthly_income" placeholder="Net Monthly Income" id="net_monthly_income" value="<?php echo $lists['sessionData']['net_monthly_income']; ?>" >
								<span class="validation error-validation" id="net_monthly_income"></span>
							</div>
						</div>
								<!-------------ending of borrower company detail--------------->
						
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
<script>
$(document).ready(function(){
    $('#company_name').on('input', function(){
        var keyword = $(this).val();
        $.ajax({
            type: 'GET',
            url: 'get_company_list',
            data: {keyword: keyword},
            success: function(response){
				// alert(response);
                var resp = JSON.parse(response);
                var output = '';

                if (resp.length > 0) {
                    $.each(resp, function(index, company){
                        output += '<li onclick="selectCompany(\'' + company['company_name'] + '\',\''+company['id']+'\')">' + company['company_name'] + '</li>';
                    });
                }
                $('#company_list').html(output);

                // Display the company list only when there is user input
                if (keyword.trim() !== '') {
                    $('#company_list').show();
                } else {
                    $('#company_list').hide();
                }
            }
        });
    });

});

function selectCompany(companyName,companyId) {
    console.log("function runs");
	//alert(companyId);
	$('#company_code').val(companyId);
    $('#company_name').val(companyName);
    $('#company_list').html('');
    $('#company_list').hide(); // Hide the company list after selection
}
</script>

<script>
        function autoCapitalize(inputId) {
            $('#' + inputId).on('keyup', function() {
                $(this).val($(this).val().toUpperCase());
            });
        }
        
       
        autoCapitalize('pan_card');
		
    </script>