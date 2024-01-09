<style>
	.box {background: #0000 !important;}
	.select2-container {min-width: 351px;}
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="../user_guide\_static\js\custom.js" type="text/javascript" charset="utf-8"></script> <!---- Custom JS  ---->
<script type="text/javascript">

	$(function () {
	   var currentDate = new Date();
      var maxDate = new Date();
      maxDate.setDate(currentDate.getDate() + 7); // Set maxDate to 7 days ahead
		$('#datetimepicker').datetimepicker({
			format: 'd-m-Y H:i',
			minDate: currentDate, // Set minDate to the current date
            maxDate: maxDate, // Set maxDate to 7 days ahead
		    step: 5,
			  allowTimes: getValidTimes(currentDate, maxDate) // Use custom function to 
		});
	});

function getValidTimes(minDate, maxDate) {
    var validTimes = [];
    var currentTime = new Date(minDate);

    while (currentTime <= maxDate) {
        var formattedTime = currentTime.getHours() + ':' + (currentTime.getMinutes() < 10 ? '0' : '') + currentTime.getMinutes();
        validTimes.push(formattedTime);
        currentTime.setMinutes(currentTime.getMinutes() + 5); // Increment by 5 minutes
    }

    return validTimes;
}

$('document').ready(function(){
		//	call_now();
		});
</script>
<!-- Main content -->
<section class="content" style="background-color:#86D7FF4F;">
	<?= getNotificationHtml(); ?>
	<div class="box">

		
		<div class="col-md-4 col-xs-12"></div>
		
		Source of Leads = <?php echo $user_list['name']; ?>
		Created Date = <?php echo $user_list['created_date']; ?>
		<form class="form form-material" id="app_user_data_form"
			  action="<?php echo base_url(); ?>premiumplan/userdetailUpdate/" method="POST">
			<div class="col-md-12" style="background-color:#86D7FF4F;" >
				<h2>Profile Summary</h2>
			
				<div class="box-body">
					<div class="row">
						<div class="col-md-4 form-group">
							<label>First Name</label>
							<input class="form-control" placeholder="Enter Name" type="text" name="fname" id="fname"
								   value="<?php 
								   if(isset($_GET['fname'])){
									   echo $_GET['fname'];
								   }else{
								   echo $user_list['fname']; } ?>">
						</div>
						<div class="col-md-4 form-group">
							<label>Last Name</label>
							<input class="form-control" placeholder="Enter Name" type="text" name="lname" id="lname"
								   value="<?php 
								    if(isset($_GET['lname'])){
									   echo $_GET['lname'];
								   }else{
								   echo $user_list['lname']; }
								   ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Email</label>
							<input class="form-control" placeholder="Enter Email" type="text" name="email" id="email"
								   value="<?php echo $user_list['email']; ?>">
						</div>
						<div class="col-md-4 form-group">
							<label>Pancard*</label>

							<input type="text" class="form-control" placeholder="Pan Card" name="pan" id="pan"
								   value="<?php echo $user_list['pan']; ?>" style="text-transform:uppercase">

						</div>

						<div class="col-md-4 form-group">
							<label>Mobile</label>
							<?php 
							$newstring = substr($user_list['mobile'], -4); 
							?>
							<input class="form-control" placeholder="Enter Mobile" type="text" name="mobile"
								   value="XXXXXX<?php echo $newstring;?>" disabled>
						</div>
						<div class="col-md-4 form-group">
							<label>Altername Number</label>
							<input class="form-control"  type="text" name="alternatemobile"
								   value="<?php echo $user_list['alternatemobile']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Loan Amount</label>
							<input class="form-control" placeholder="Loan Amount" type="text" name="loan_amount"
								   value="<?php echo $user_list['loan_amount']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Location</label>
							<input class="form-control" placeholder="Location" type="text" name="address1"
								   value="<?php echo $user_list['address1']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>State</label>
							   <select name="state" id="state" class="form-control">
									<option value="">Select State</option>
									<?php
									foreach($state as $row)
									{
									 echo '<option value="'.$row->state_code.'">'.$row->state_name.'</option>';
									}
									?>
								</select>
						</div>

						<div class="col-md-4 form-group">
							<label>City</label>
						     <select name="city" class="form-control"> </select>
									
						</div>

						<div class="col-md-4 form-group">
							<label>Pincode</label>
							<input class="form-control" placeholder="Pincode" type="text" name="pin"
								   value="<?php echo $user_list['pin']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Type Of Loan</label>
							<select name="product_type" class="form-control" id="occupation-selector">
								<option value="">--Select--</option>
								<option value="1"<?php if ($user_list['product_type'] == '1') {
									echo "selected";
								} ?>>Housing Loan
								</option>
								<option value="4"<?php if ($user_list['product_type'] == '4') {
									echo "selected";
								} ?>>Loan Against Property
								</option>
								<option value="7"<?php if ($user_list['product_type'] == '7') {
									echo "selected";
								} ?>>Business Loan
								</option>
								<option value="10"<?php if ($user_list['product_type'] == '10') {
									echo "selected";
								} ?>>Personal Loan
								</option>

							</select>
						</div>

						<div class="col-md-4 form-group">
							<label>Date of Birth</label>
							<input class="form-control hasDatepicker" id="datepicker-autoclose"
								   placeholder="Enter Date of Birth" type="date" name="dob"
								   value="<?php echo $user_list['dob']; ?>" max="2020-12-31">
						</div>

						<div class="col-md-4 form-group">
							<label>Residence type</label>
							<select name="residence_type" class="form-control" id="occupation-selector">
								<option value="">--Select--</option>
								<option value="3"<?php if ($user_list['residence_type'] == '3') {
									echo "selected";
								} ?>>Rented
								</option>
								<option value="6"<?php if ($user_list['residence_type'] == '6') {
									echo "selected";
								} ?>>Company provided
								</option>
								<option value="7"<?php if ($user_list['residence_type'] == '7') {
									echo "selected";
								} ?>>Self Owned
								</option>
								<option value="8"<?php if ($user_list['residence_type'] == '8') {
									echo "selected";
								} ?>>Owned by Spouse
								</option>
								<option value="9"<?php if ($user_list['residence_type'] == '9') {
									echo "selected";
								} ?>>Owned by Parents
								</option>
								<option value="10"<?php if ($user_list['residence_type'] == '10') {
									echo "selected";
								} ?>>Other
								</option>

							</select>
						</div>

						<div class="col-md-4 form-group">
							<label>Years In Current Residence</label>
							<input class="form-control" placeholder="" type="text" name="year_in_curr_residence"
								   value="<?php echo $user_list['year_in_curr_residence']; ?>">
						</div>

						<div class="col-md-4 form-group">
							<label>Is it your permanent Residence</label>
							<select name="is_parmanent_address" class="form-control" id="occupation-selector">
								<option value="">--Select--</option>
								<option value="yes"<?php if ($user_list['is_parmanent_address'] == 'yes') {
									echo "selected";
								} ?>>Yes
								</option>
								<option value="no"<?php if ($user_list['is_parmanent_address'] == 'no') {
									echo "selected";
								} ?>>No
								</option>

							</select>
						</div>

						<div class="col-md-4 form-group" id="occupation">
							<label>Occupation</label>
							<select name="occupation" class="form-control" id="ddlPassport">
								<option value="">--Select--</option>
								 <option value="Salaried"<?php if($user_list['occupation']=="Salaried"){echo "selected";} ?>>Salaried</option>
                                <option value="Self Employed Professional"<?php if($user_list['occupation']=="Self Employed Professional"){echo "selected";} ?>>Self Employed Professional</option>
                                <option value="Self employed Business"<?php if($user_list['occupation']=="Self employed Business"){echo "selected";} ?>>Self employed Business</option>
                                <option value="Retired" <?php if($user_list['occupation']=="Retired"){echo "selected";} ?>>Retired</option>
                                <option value="Student" <?php if($user_list['occupation']=="Student"){echo "selected";} ?>>Student</option>
                                <option value="Home Maker" <?php if($user_list['occupation']=="Home Maker"){echo "selected";} ?>>Home Maker</option>
                                <option value="Others"<?php if($user_list['occupation']=="Others"){echo "selected";} ?>>Others</option>
							</select>
						</div>

						<div class="col-md-4 form-group" id='occ11' style="display: none">
							<label>Company Type</label>
							<select class="form-control" name="company_type" id="company_type">
								<option value="">Select Company Type</option>
								<option value="Private Limited company" <?php if($user_list['company_type']=="Private Limited company"){echo "selected";} ?>>Private Limited company</option>
								<option value="MNC" <?php if($user_list['company_type']=="MNC"){echo "selected";} ?>>MNC</option>
								<option value="PSUs" <?php if($user_list['company_type']=="PSUs"){echo "selected";} ?>>PSUs</option>
								<option value="Government" <?php if($user_list['company_type']=="Government"){echo "selected";} ?>>Government</option>
								<option value="Public Limited Company" <?php if($user_list['company_type']=="Public Limited Company"){echo "selected";} ?>>Public Limited Company</option>
								<option value="Proprietorship" <?php if($user_list['company_type']=="Proprietorship"){echo "selected";} ?>>Proprietorship</option>
								<option value="Partnership" <?php if($user_list['company_type']=="Partnership"){echo "selected";} ?>>Partnership</option>
								<option value="Others" <?php if($user_list['company_type']=="Others"){echo "selected";} ?>>Others</option>
							</select>
						</div>
                         <?php if($user_list['occupation']=="Salaried")
						 { ?>
					<div class='form-group col-md-4'>
                      <label>Name of Company</label> 
                        <input type='text' value="<?php echo $user_list['company_name']; ?>" name='company_name' id='company_name' class='form-control' placeholder="company_name">
                    </div>
							 
						<?php } ?>
						<div class="col-md-4 form-group" id='occ12' style="display: none">
							<label>Name of Company</label>
							<select class="itemName form-control" id="company_name" name="company_name"></select>
						</div>

						<div class="col-md-4 form-group" id='occ13' style="display: none">
							<label>ITR/Form 16 Status*</label>
							<select class="form-control" name="itr_form_16_status" id="itr_form_16_status">
								<option value="">--Select ITR/Form 16 Status --</option>
								<option value="1">Yes</option>
								<option value="0">No</option>

							</select>
						</div>

					<div class="col-md-4 form-group" id='occ14' style="display: none">
                        <label>Mode Of Salary</label>
                            <select class='form-control' name='mode_of_salary' id='mode_of_salary'>
                                <option value=''>--Select Mode Of Salary--</option>
                                <option value='cash'<?php if ($user_list['mode_of_salary'] == "cash") {
									echo "selected";} ?>>Cash</option>
                                <option value='cheque' <?php if($user_list['mode_of_salary']=="cheque"){echo "selected";} ?>>Cheque</option>
                                <option value='ac transfer' <?php if($user_list['mode_of_salary']=="ac transfer"){echo "selected";} ?>>A/C Transfer</option>
                                <option value='others' <?php if($user_list['mode_of_salary']=="others"){echo "selected";} ?>>Others</option>
                            </select>
                      
                    </div>

                      <div class='form-group col-md-4' id='occ15' style="display: none">
                      <label>Working Since</label> 
                        <input type='text' value="<?php echo $user_list['working_since']; ?>" name='working_since' id='working_since' class='form-control' placeholder="Working Since">
                    </div>

                     <div class='form-group col-md-4' id='occ16' style="display: none">
                        <label>Designation</label>
                        <input type='text' value="<?php echo $user_list['designation']; ?>" name='designation' id='designation' class='form-control' placeholder="Designation">
                    </div>

                    <div class='form-group col-md-4' id='occ17' style="display: none">
                        <label>Salary Account</label>
                        <input type='text' value="<?php echo $user_list['salary_account']; ?>" name='salary_account' id='salary_account' class='form-control'>
                    </div>

                    <div class='form-group col-md-4' id='occ21' style="display: none">
                        <label>Profession type</label>
                            <select class='form-control' name='profession_type' id='profession_type'>
                                <option value=''>--Select --</option>
                                <option value='Doctor' <?php if($user_list['profession_type']=="Doctor"){echo "selected";} ?>>Doctor</option>
                                <option value='Teacher' <?php if($user_list['profession_type']=="Teacher"){echo "selected";} ?>>Teacher</option>
                                <option value='CA' <?php if($user_list['profession_type']=="CA"){echo "selected";} ?>>CA</option>
                                <option value='CS' <?php if($user_list['profession_type']=="Cs"){echo "selected";} ?>>CS</option>
                                <option value='Architect' <?php if($user_list['profession_type']=="Architect"){echo "selected";} ?>>Architect</option>
                                <option value='Lawyer' <?php if($user_list['profession_type']=="Lawyer"){echo "selected";} ?>>Lawyer</option>
                                <option value='Other' <?php if($user_list['profession_type']=="Other"){echo "selected";} ?>>Other Consultant</option>
                            </select>
                      
                    </div>


						<div class="col-md-4 form-group">
							<label>Total experience in years</label>
							<input class="form-control" placeholder="experiance" type="text" name="experiance"
								   value="<?php echo $user_list['experiance']; ?>">
						</div>
					<div class='form-group col-md-4' id='occ23' style="display: none">
                        <label>Last 2 Years ITR Amount</label>
                        <input placeholder='Last 2 Years ITR Amount' name='last2yearitramount' id='last2yearitramount' value='<?php echo $user_list['last2yearitramount']; ?>' class='form-control' type='text'> 
                    </div>

                    <div class='form-group col-md-4' id='occ24' style="display: none">
                        <label>Gross turnover last year</label>
                        <input placeholder='Gross turnover in INR' name='turnover1' id='turnover1' value='<?php echo $user_list['turnover1']; ?>' class='form-control' type='text'> 
                    </div>
                    <div class='form-group col-md-4' id='occ25' style="display: none">
                        <label>Gross turnver year before last year</label>
                        <input placeholder='Gross turnver in INR' name='turnover2' id='turnover2' value='<?php echo $user_list['turnover2']; ?>'  class='form-control' type='text'>
                    </div>

                   <div class='form-group col-md-4' id='occ26' style="display: none">
                        <label>Office ownership</label>
                            <select class='form-control' name='office_ownership' id='office_ownership'>
                                <option value=''>--Select --</option>
                                <option value='Owned' <?php if($user_list['office_ownership']=="Owned"){echo "selected";} ?>>Owned</option>
                                <option value='Rented' <?php if($user_list['office_ownership']=="Rented"){echo "selected";} ?>>Rented</option>
                            </select>
                     
                    </div>
                    
                      <div class='col-md-4' id='occ27' style="display: none">
                            <label>Audit done for financials?</label>
                            <div class='col-md-12'>
                                <select class='form-control' name='audit_done' id='audit_done'>
                                    <option value=''>--Select --</option>
                                    <option value='Yes'<?php if($user_list['audit_done']=="Yes"){echo "selected";} ?>>Yes</option>
                                    <option value='No'<?php if($user_list['audit_done']=="No"){echo "selected";} ?>>No</option>
                                </select>
                            
                        </div>
                    </div>

						<div class="col-md-4 form-group" id="occ28">
							<label>Office Location</label>
							<input class="form-control" placeholder="Office Location" type="text" name="officeaddress"
								   value="<?php echo $user_list['officeaddress']; ?>">
						</div>

					 <div class='form-group col-md-4' id='occ31' style="display: none">
                        <label>Industry type</label>
                            <select class=' form-control' name='industry_type' id='industry_type'>
                                <option value=''>--Select --</option>
                                <option value='Manufacturing' <?php if($user_list['industry_type']=="Manufacturing"){echo "selected";} ?>>Manufacturing</option>
                                <option value='Trading' <?php if($user_list['industry_type']=="Trading"){echo "selected";} ?>>Trading</option>
                                <option value='Service' <?php if($user_list['industry_type']=="Service"){echo "selected";} ?>>Service</option>
                                <option value='KPO' <?php if($user_list['industry_type']=="KPO"){echo "selected";} ?>>KPO</option>
                                <option value='BPO' <?php if($user_list['industry_type']=="BPO"){echo "selected";} ?>>BPO</option>
                                <option value='Software' <?php if($user_list['industry_type']=="Software"){echo "selected";} ?>>Software</option>
                                <option value='Others' <?php if($user_list['industry_type']=="Others"){echo "selected";} ?>>Others</option>
                            </select>
                      
                    </div>

                    <div class='form-group col-md-4' id='occ41' style="display: none">
                        <label>I am pursuing</label>
                            <select class='form-control' name='persuing' id='persuing'>
                                <option value=''>-- Select Cource --</option>
                                <option value='Graduation' <?php if($user_list['persuing']=="Graduation"){echo "selected";} ?>>Graduation</option>
                                <option value='Postgraduation' <?php if($user_list['persuing']=="Postgraduation"){echo "selected";} ?>>Postgraduation</option>
                                <option value='Doctoral' <?php if($user_list['persuing']=="Doctoral"){echo "selected";} ?>>Doctoral</option>
                                <option value='Professional' <?php if($user_list['persuing']=="Professional"){echo "selected";} ?>>Professional</option>
                                <option value='Diploma' <?php if($user_list['persuing']=="Diploma"){echo "selected";} ?>>Diploma</option>
                            </select>
                      
                    </div>	

                      <div class='form-group col-md-4' id='occ42' style="display: none">
                        <label>My Institution</label>
                            <input type='text' name='educational_institute_name' value='<?php echo $user_list['educational_institute_name']; ?>' id='educational_institute_name' class='form-control'>
                    </div>


					<div class="form-group col-md-4">
                        <label>Monthly Income</label>
                       
                            <select name="income" class="form-control">
                                <option value="">--Select--</option>
                                    <option value="10000" <?php if($user_list['income'] == '10000'){echo "selected";} ?>>Less than 12000</option>
                                    <option value="15000" <?php if($user_list['income'] == '15000'){echo "selected";} ?>>12000-15000</option>
                                    <option value="25000" <?php if($user_list['income'] == '25000'){echo "selected";} ?>>15000-25000</option>
                                    <option value="40000" <?php if($user_list['income'] == '40000'){echo "selected";} ?>>25000-40000</option>
                                    <option value="60000" <?php if($user_list['income'] == '60000'){echo "selected";} ?>>40000-60000</option>
                                    <option value="70000" <?php if($user_list['income'] == '70000'){echo "selected";} ?>>Above 60000</option>
                            </select>
                    </div>
						<div class="col-md-4 form-group">
							<label>Cibil Score</label>
							<input class="form-control" type="text" name="cibil_score"
								   value="<?php echo $user_list['cibil_socre']; ?>" readonly>
						</div>

						<div class="col-md-4 form-group">
							<label>Outstanding Loan Details*</label>
							<select name="outstanding_loan_details" class="form-control" id="outstanding">
								<option value="">--Select--</option>
								<option value="1"<?php if ($user_list['outstanding_loan_details'] == '1') {
									echo "selected";
								} ?>>Yes
								</option>
								<option value="0"<?php if ($user_list['outstanding_loan_details'] == '0') {
									echo "selected";
								} ?>>No
								</option>

							</select>
						</div>

						<div class="col-md-4 form-group" id="out51" style="display:none">
							<label>Brief(Loan/EMI/Any Delay)</label>
							<textarea name="brief_outstanding_loan_details" id="brief_outstanding_loan_details"
									  class="form-control"></textarea>
						</div>


					<!----
						<div class="col-md-4 form-group">
							<label>Reminder</label>
							<input class="form-control" placeholder="Reminder Date" type="text" id="datetimepicker"
								 readonly  name="reminder_date" value="<?php echo @$user_list['reminder_date']; ?>"/>
						</div> ----->

<div class="col-md-4 form-group">
							<label>Hot Lead Status</label>
							<select class='form-control' name='hot_lead_status' id='hot_lead_status'>
								<option value=''>-- Select Hot Lead Status --</option>
									
								<option value='15' <?php if ($user_list['hot_lead_status'] == "15") {
									echo "selected";
								} ?>>Payment Done
								</option>
								<option value='3' <?php if ($user_list['hot_lead_status'] == "3") {
									echo "selected";
								} ?>>Phone Not Picked
								</option>
								<option value='7' <?php if ($user_list['hot_lead_status'] == "7") {
									echo "selected";
								} ?>>Not Interested
								</option>


							</select>
						</div>

						<div class="col-md-4 form-group">
							<label>Comment</label>
							<input class="form-control" placeholder="Enter Comment" type="text" name="comment"
								   id="comment">
						</div>

						<div class="col-md-4 form-group">
							<label>Interested In Insurance</label>
							<div class="col-md-12">
								<input type="radio" value="Yes"> Yes
								<input type="radio" value="No"> No
							</div>
						</div>
						
							<div class="col-md-4 form-group">
							<label id="<?php echo $this->session->userdata('user_id'); ?>label" style="display:none;color:red;" >Please Wait...</label>
<button id="<?php echo $this->session->userdata('user_id'); ?>button"  type="button" class="btn btn-danger" onclick='getCreditScoreApiCall("<?php echo $user_list['mobile']; ?>","<?php echo $user_list['fname']; ?>","<?php echo $user_list['lname']; ?>","free","<?php echo $this->session->userdata('user_id'); ?>","ppJS")' >Show Score</button>
						</div> 
							
						<div class="col-md-4 form-group">
							<label>Interested In Freedom Plan</label>
							<div class="col-md-12">
								<input type="radio" value="Yes"> Yes
								<input type="radio" value="No"> No
							</div>
						</div>
						
						<div class="col-md-4 form-group">
							<label>New to Cibil</label>
							<select name="new_to_cibil" class="form-control" id="new_to_cibil">
								<option value="">--Select--</option>
								<option value="Yes"<?php if ($user_list['new_to_cibil'] == 'Yes') {
									echo "selected";
								} ?>>Yes
								</option>
								<option value="No"<?php if ($user_list['new_to_cibil'] == 'No') {
									echo "selected";
								} ?>>No
								</option>

							</select>
						</div>
						
						<div class="col-md-4 form-group">
							<label>Previous Comment</label>
							<div class="col-md-12">
							<ul>
								<?php
								if (!$this->input->get('batch_no')) {
									$lead_id = $user_list['id'];

									$previous_comment = $this->Premiumplanmodel->getPreviouscomment($lead_id);
									foreach ($previous_comment as $comment) {
										?>
										<li><?php echo $comment->created_date; ?>
											- <?php echo $comment->comment; ?></li>
										<?php
									}
								}
								?>
							</ul>
							</div>
						</div>
								
						<div class="col-md-4 form-group">
							<label>Payment History</label>
							<div class="col-md-12">
							<ul>
								<?php
								
									$lead_id = $user_list['id'];

									$previous_payment = $this->Premiumplanmodel->getPaymentDetails($lead_id);
									foreach ($previous_payment as $payment) {
										?>
										<li><?php echo $payment->payment_id; ?>
											- <?php echo $payment->amount; ?></li>
											- <?php echo $payment->created_date; ?></li>
										<?php
									
								}
								?>
							</ul>
							</div>
						</div>



					</div>
				</div>
				<div class="row">
					<div class="box-footer text-right">
						<input type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
						<input class="form-control" type="hidden" name="mobile" id="mobile"
							   value="<?php echo $user_list['mobile']; ?>">
						<input class="form-control" type="hidden" name="id" value="<?php echo $user_list['id']; ?>">

						<?php if ($user_list['lead_id']) { ?>
							<input class="form-control" type="hidden" name="lead_id"
								   value="<?php echo $user_list['lead_id']; ?>">
						<?php } ?>
						<?php if ($this->input->get('batch_no')) { ?>
							<input class="form-control" type="hidden" name="batch_no"
								   value="<?php echo $this->input->get('batch_no'); ?>">
						<?php } ?>
						<input type="hidden" name="lead_open_time" id="lead_open_time"
							   value="<?php echo $date = date('Y-m-d H:i:s'); ?>">
						<input type="button" name="submit" id="saveRemarkHotLead" value="Update User" class="btn btn-success"/>
					</div>
				</div>

			</div>
		</form>
	</div>


	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	<div class="box">
		<div class="box-body">
			<div class="col-md-12 form-group">
				<input type="button" class="btn btn-primary" value="Call Now" onclick="call_now()" id="call_now">
                
               <!--<input type="button" class="btn btn-primary" value="Transfer to CC" id="transfer_to_cc">

				 <input type="button" name="sendtosms" id="sendtosms" value="Sens P2P SMS" class="btn btn-primary"/>
				<input type="button" name="sendtosmsPremium" id="sendtosmsPremium" value="Send Membership Plan SMS" class="btn btn-primary"/> -->
			</div>
		</div>
	</div>
	<!--<div class="box-footer clearfix"></div>-->
	
	<div class="box">
		<div class="box-body">
			<div class="col-md-12 form-group">
				<? if ($user_list->status != 15) { ?>
				<div class="col-md-6 form-group">
					<select class="form-control" id="payment_service" name="payment_service">
						<option>Select Payment Links</option>
						<? foreach ($payment_service_list as $payment){?>
							<option value="<?=$payment['id']?>"><?=$payment['product']?></option>
						<?}?>
					</select>
				</div>
				<div class="col-md-6 form-group">
					<input type="button" name="send_link" id="send_link" value="Send Payment Link"
						   class="btn btn-primary"/>
				</div>
				<? } ?>


			</div>
		</div>
		<a target="_blank" href="https://www.antworksmoney.com/creditcounselor/ccounsellor/PDFReportPP?id=<?php echo base64_encode($user_list['mobile']) ?>&t=<?php echo base64_encode($user_list['table']) ?>"><button type="submit"  class="btn btn-success">View PDF</button></a>
	</div>
	<!-- /.box-body -->

</section>
<!-- /.content -->
<!--<script type="text/javascript">
	$("#report").click(function () {
			//if ($(this).val() == "1") {
			//	$("#out51").show();

			//} else {
				$("#report").hide();
			//}

        //  beforeSend: function () {
		//		$(".preloader").show();
		//	},
		//	complete: function () {
		//		$(".preloader").hide();
			//},


		});
	
</script> -->


