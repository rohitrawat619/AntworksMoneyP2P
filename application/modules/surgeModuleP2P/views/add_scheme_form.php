<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); ?>
	<div class="box">

		<?php // echo"<pre>"; print_r($lists); echo"</pre>"; 
			if($lists['id']!=""){
					$edit= true;
					$path= "update_scheme";
			}else{
				$edit=false;
					$path= "add_scheme";
			}
			//  echo "<pre>"; print_r($lists);
		 //	print_r($lists['partnersData'][0]['Company_Name']);
		?>
		
		<form class="form form-material" action="../surge/<?php echo $path; ?>/" method="POST">
    <div class="col-md-12">
        <h2><?php echo ($edit == true) ? 'Update Scheme' : 'Add Scheme'; ?></h2>

         <div class="box-body">
            <div class="row">
                                    
                                 
                                  	<div class="col-md-6 form-group">
        <label for="password">Partner:</label><br>
        <select  class="form-control" name="Vendor_ID" id="Vendor_ID" >
		<option value="">Select Partner</option>
		<?php for($i=0; $i<count($lists['partnersData']); $i++){
				if($lists['Vendor_ID']==$lists['partnersData'][$i]['VID']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
						
			echo '<option '.$selected.' value="'.$lists['partnersData'][$i]['VID'].'">'.$lists['partnersData'][$i]['Company_Name'].'</option>';
		}
			?>
		
		</select>
    </div>
                                    <div class="col-md-6 form-group">
                        <label for="scheme_name">
						Scheme_Name:</label><br>
                        <input class="form-control" value="<?php echo $lists['Scheme_Name']; ?>" type="text" id="Scheme_Name" name="Scheme_Name" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Min_Inv_Amount">
						Min_Inv_Amount:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Min_Inv_Amount']; ?>" onkeyup="getDiversificationFactorValues(this.value);" id="Min_Inv_Amount" name="Min_Inv_Amount" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Max_Inv_Amount">
						Max Inv. Amount:</label><span id="max_investment_amount_suggestion">-</span> <br>
                        <input class="form-control" type="text" value="<?php echo $lists['Max_Inv_Amount']; ?>" onkeyup="getDivisibleValues();" id="Max_Inv_Amount" name="Max_Inv_Amount" required>
                    </div>
					
								   <div class="col-md-6 form-group">
                        <label for="step_up_value">
						Step Up Value:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['step_up_value']; ?>"  readonly id="step_up_value" 
						name="step_up_value" required>
                    </div>
					
					
					<div class="col-md-6 form-group">
						<label for="diversification_factor">Diversification Factor:</label><br>
						<select class="form-control" name="diversification_factor" id="diversification_factor" required>
							<option value="">Select Diversification Factor</option>
							<!-- Options will be dynamically added here -->
						</select>
					</div>

					
					
					   <div class="col-md-6 form-group">
                        <label for="minimum_loan_amount">
						Minimum Loan Amount:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['minimum_loan_amount']; ?>"  readonly id="minimum_loan_amount" 
						name="minimum_loan_amount" required>
                    </div>
							
                                   
                                    <div class="col-md-6 form-group">
                        <label for="lockin">
						Lockin:</label> <br>

						<input class="form-input" type="radio" name="Lockin" value="1"  required <?php echo ($lists['Lockin'] == 1) ? 'checked' : ''; ?>> Yes    
						<input  class="form-input" type="radio" name="Lockin" value="0" required <?php echo ($lists['Lockin'] == 0) ? 'checked' : ''; ?>> No
                    </div>
					
					 <div class="col-md-6 form-group">
                        <label for="Aggregate_Amount">
						Aggregate_Amount:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Aggregate_Amount']; ?>" id="Aggregate_Amount" name="Aggregate_Amount" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Cooling_Period">
						Cooling_Period: (Days)</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Cooling_Period']; ?>" id="Cooling_Period" name="Cooling_Period" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Interest_Rate">
						Interest_Rate:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Interest_Rate']; ?>"  onkeyup="hikeRate(this.value);" id="Interest_Rate" 
						name="Interest_Rate" required>
                    </div>
                                    <div class="col-md-6 form-group" style="display:none;" >
                        <label for="hike_rate">
						hike_rate:</label><br>

                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="interest_type">
						Interest_Type:</label><br>
						
                        
						<select class="form-control" id="Interest_Type" name="Interest_Type" required>
							<option value="">Interest Type</option>
							<option value="Simple"  <?php echo(($lists['Interest_Type']=="Simple") ? "selected" : ""); ?>>Simple</option>
						</select>
                    </div>
					
					
					 <div class="col-md-6 form-group">
                        <label for="payout_type">
						Payout Type:</label><br>
						
                        
						<select class="form-control" id="payout_type" name="payout_type" required>
							<option value="">Payout Type</option>
							<option value="monthly"  <?php echo(($lists['payout_type']=="monthly") ? "selected" : ""); ?>>Monthly</option>
							<option value="maturity"  <?php echo(($lists['payout_type']=="maturity") ? "selected" : ""); ?>>Maturity</option>
						</select>
                    </div>
					
                                    <div class="col-md-6 form-group" style="display:none">
                        <label for="withrawl_anytime">
						Withrawl_Anytime:</label><br>
                        
						<input type="radio" name="Withrawl_Anytime" value="1" <?php echo ($lists['Withrawl_Anytime'] == 1) ? 'checked' : ''; ?>> Yes
						<input type="radio" name="Withrawl_Anytime" value="0" <?php echo ($lists['Withrawl_Anytime'] == 0) ? 'checked' : ''; ?>> No
                    </div>
					

                                    <div class="col-md-6 form-group" style="display:none;" >
										<div >
                        <label for="pre_mat_rate">
						Pre_Mat_Rate:</label><br>
                        
						</div>
                    </div>
					 <input class="form-control" type="hidden" value="<?php echo $lists['Pre_Mat_Rate']; ?>" id="Pre_Mat_Rate" name="Pre_Mat_Rate" required>
                                    <div class="col-md-6 form-group">
                        <label for="lockin_period">
						Lockin_Period: (Days)</label><br>
							<select class="form-control" id="Lockin_Period" name="Lockin_Period" required>
							<option value="">Select Lockin Period</option>
							<option value="40"  <?php echo(($lists['Lockin_Period']=="40") ? "selected" : ""); ?>>40 Days</option>
							<option value="70"  <?php echo(($lists['Lockin_Period']=="70") ? "selected" : ""); ?>>70 Days</option>
							<option value="100"  <?php echo(($lists['Lockin_Period']=="100") ? "selected" : ""); ?>>100 Days</option>
							<option value="375"  <?php echo(($lists['Lockin_Period']=="375") ? "selected" : ""); ?>>375 Days</option>
						</select>
                             </div>
                                    <div class="col-md-6 form-group">
                        <label for="Tenure">
						Tenure: (Days)</label><br>
							<select class="form-control" id="Tenure" name="Tenure" required>
							<option value="">Select Tenure</option>
							<option value="30"  <?php echo(($lists['Tenure']=="30") ? "selected" : ""); ?>>30 Days</option>
							<option value="90"  <?php echo(($lists['Tenure']=="90") ? "selected" : ""); ?>>90 Days</option>
							<option value="180"  <?php echo(($lists['Tenure']=="180") ? "selected" : ""); ?>>180 Days</option>
							<option value="360"  <?php echo(($lists['Tenure']=="360") ? "selected" : ""); ?>>360 Days</option>
						</select>
            
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="auto_redeem">
						Auto_Redeem:</label><br>
                        
						<input type="radio" name="Auto_Redeem" value="1" <?php echo ($lists['Auto_Redeem'] == 1) ? 'checked' : ''; ?>> Yes
						<input type="radio" name="Auto_Redeem" value="0" <?php echo ($lists['Auto_Redeem'] == 0) ? 'checked' : ''; ?>> No
                    </div>
					
					
					
					
                                   <div class="col-md-6 form-group">
                        <label for="status">
						Scheme Status:</label> <br>

						<input class="form-input" type="radio" name="status" value="1"  required <?php echo ($lists['status'] == 1) ? 'checked' : ''; ?>> Active    
						<input  class="form-input" type="radio" name="status" value="0" required <?php echo ($lists['status'] == 0) ? 'checked' : ''; ?>> InActive
                    </div>
                     
 <div class="col-md-6 form-group">
                        <label for="scheme_descripiton">
						Scheme Description:</label><br>
                        <textarea class="form-control"  type="text" id="scheme_descripiton" onkeyup="validate_scheme_description();" name="scheme_descripiton" required><?php echo $lists['scheme_descripiton']; ?></textarea>
					<span id="scheme_descripiton_error" style="font-weight:bold;"></span>
				   </div>	

			
							
													<div class="col-md-3 form-group">
    <label for="Lender Registration Fees" id="lender_partner_management_fee"> Lender Management Fee:
	<?php 
		if($lists['type_of_lender_management_fee']=="InPercentage"){
			echo "<b> ". $lists['lender_management_fee_percentage']."%</b>";
		}else if($lists['type_of_lender_management_fee']=="InRupee"){
			echo "<b> &#8377;". $lists['lender_management_fee_rupee']."</b>";
		}
	 ?>
	</label><br>
   <select onchange="showHideLenderTypeOfManagementFee(this.value)" required class="form-control" name="type_of_lender_management_fee">
    <option value="">Select</option>
    <option  value="None"<?php echo ($lists['type_of_lender_management_fee'] == "None") ? " selected" : ""; ?>>None</option>
    <option value="InPercentage"<?php echo ($lists['type_of_lender_management_fee'] == "InPercentage") ? " selected" : ""; ?>>In Percentage</option>
    <option value="InRupee"<?php echo ($lists['type_of_lender_management_fee'] == "InRupee") ? " selected" : ""; ?>>In Rupee</option>
</select>
    
    <div id="type_of_lender_management_fee_div">------</div>
</div>



<div class="col-md-6 form-group">
		<label for="occuption_id">Occupation:</label><br>
		<select  class="form-control" required name="occuption_id" id="occuption_id" >
		<option value="">Select Occupation</option>
		<?php 
			
		foreach($occupation_list as $occupation_listValue){
					 if($occupation_listValue['id']==$lists['occuption_id']){
					$selected = "selected";
					}else{
					$selected = "";
					} 
		echo'<option '.$selected.' value="'.$occupation_listValue['id'].'">'.$occupation_listValue['name'].'</option>';
		}
		?>
		</select>
		</div>		

<div class="col-md-6 form-group">
		<label for="borrower_classifier">Borrower Classifier:</label><br>
		<select  class="form-control" id="select2"  multiple name="borrower_classifier[]" id="borrower_classifier" >
		<option value="">Select Borrower Classifier</option>
		<?php 

		foreach($borrower_classifier as $borrower_classifierValue){
			
				/* 	 if($borrower_classifierValue['id']==$lists['borrower_classifier']){
					$selected = "selected";
					}else{
					$selected = "";
					}  	 */			
					 $selected = in_array($borrower_classifierValue['id'], explode(",",$lists['borrower_classifier'])) ? "selected" : ""; 
					  // <?php echo in_array($value, $selectedOptions) ? 'selected' : '';

		echo'<option '.$selected.' value="'.$borrower_classifierValue['id'].'">'.$borrower_classifierValue['name'].'</option>';
		}
		?>
		</select>
		</div>
							
        <div class="row" id="updateButtonId">
        <div class="col-md-12">
            <div class="box-footer text-right">
                <input type="hidden" class="form-control csrf-security" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <?php if ($edit == true) : ?>
                    <input type="hidden" class="form-control" value="<?php echo $lists['id']; ?>" id="id" name="id">
                <?php endif; ?>
                <input type="submit" name="submit" value="<?php echo ($edit == true) ? 'Update Scheme' : 'Add Scheme'; ?>" class="btn btn-success"/>
            </div>
        </div>
        </div>
		
		
    </div>
	
	<input class="form-control" type="hidden" value="<?php echo $lists['Interest_Rate']; ?>" id="hike_rate" name="hike_rate" required>
<input class="form-control" type="hidden" value="0" id="Pre_Mat_Rate" name="Pre_Mat_Rate" >
<input class="form-control" type="hidden" value="0" id="Withrawl_Anytime" name="Withrawl_Anytime" >

</form>

	</div>
</div>

	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	
</section>

<script>
$(document).ready(function() {
var lenderManagementFeeType = '<?php echo $lists['type_of_lender_management_fee']; ?>';
showHideLenderTypeOfManagementFee(lenderManagementFeeType);
});
</script>




<script>
function getDivisibleValues() {
    // Check if the amount is divisible by stepUp
	
	var amount = $("#Max_Inv_Amount").val();
	var stepUp = $("#step_up_value").val();
	
	
    const isDivisible = amount % stepUp === 0;

    if (isDivisible) {
       
		   $("#max_investment_amount_suggestion").text("Input value is correct");
    } else {
        // Calculate the lower and next divisible values
        const lowerDivisible = Math.floor(amount / stepUp) * stepUp;
        const nextDivisible = Math.ceil(amount / stepUp) * stepUp;
			$("#max_investment_amount_suggestion").text("suggestion value "+lowerDivisible+" and "+nextDivisible);
      
    }
}

</script>

<script>
function getDiversificationFactorValues(minInvestment) {
    $.ajax({
        url: 'findValuesViaInvestmentFunction',
        type: 'POST',
        data: {
            minInvestment: minInvestment
        },
        success: function(response) {
            const data = JSON.parse(response);
            $('#diversification_factor').empty().append('<option value="">Select Diversification Factor</option>');

            // Iterate through the returned data to populate the select box
            if (Array.isArray(data)) {
                $.each(data, function(index, item) {
                    $('#diversification_factor').append('<option value="' + item.diversification_factor_value + '">' + item.diversification_factor_value + '</option>');
					
                });
				// $("#step_up_value").val(data.step_up_value);
				// $("#diversification_factor_value").val(data.diversification_factor_value);
				// $("#minimum_loan_amount").val(data.minimum_loan_amount);
            } else {
                console.error('Expected an array in the response');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


</script>

<script>
function showHideLenderTypeOfManagementFee(lenderManagementFeeType) { // type_of_Lender_management_fee
//$("#type_of_lender_management_fee_div").html('-'+lenderManagementFeeType+'-'); return false;
 if(lenderManagementFeeType=="InRupee"){		    
      $("#type_of_lender_management_fee_div").html('<label for="lender_management_fee_rupee">Amount:</label><input type="number" required name="lender_management_fee_rupee"  value="<?php echo $lists['lender_management_fee_rupee']; ?>" class="form-input">');
		}else if(lenderManagementFeeType=="InPercentage"){
		$("#type_of_lender_management_fee_div").html('<label for="lender_management_fee_percentage">Percentage:</label><input type="number" required name="lender_management_fee_percentage"  value="<?php echo $lists['lender_management_fee_percentage']; ?>" class="form-input">');
		}else{
			$("#type_of_lender_management_fee_div").html('--');
		}
} 

</script>

<script>
       //  $("#updateButtonId").hide();
		function hikeRate(hike_rate){ 
	$("#hike_rate").val(hike_rate);
} </script>

<script>
function validate_scheme_description(){
 const error = document.getElementById('scheme_descripiton_error');
 const textarea = document.getElementById('scheme_descripiton');

const wordCount = textarea.value.trim().split(/\s+/).length;

    if (wordCount > 100) { //alert(wordCount);
        error.textContent =  'Words: '+wordCount+'\n\r Please limit your text to 100 words.';
		error.style.color = 'red';
		$("#updateButtonId").hide();
      //  event.preventDefault(); // Prevent form submission
    } else {
		$("#updateButtonId").show();
		
	//	alert(wordCount);
        error.textContent = 'Words: '+wordCount; // Clear error message
		error.style.color='green';
    }
}
</script>