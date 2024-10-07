<?php
// print_r($schemeList);
//print_r($lists['scheme_id']);
?>
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); ?>
	<div class="box">
				<div class="row">
	     	<div class="col-md-12">
		<?php // echo"<pre>"; print_r(count($lists['partnersData'])); echo"</pre>"; 
			if($lists['id']!=""){
					$edit= true;
					$path= "update_loan_plan";
					$partner_list_status = "disabled";
			}else{
				$edit=false;
					$path= "add_loan_plan";
			}
		//	echo "<pre>";
		 //	print_r($lists['partnersData'][0]['Company_Name']);
		?>
		
		<form class="form form-material" 
			  action="../borrower/<?php echo $path; ?>/"  method="POST"  > 
			<div class="col-md-12" >
			<h2><?php echo ($edit == true) ? 'Update Loan Plan' : 'Add Loan Plan'; ?></h2>

				
			
				<div class="box-body">
					<div class="row">

					
					 <div class="col-md-6 form-group">
        <label for="scheme_id">Scheme:</label><br>
        <select  class="form-control" name="scheme_id" id="scheme_id" >
		<option value="">Select Scheme</option>
		<?php for($i=0; $i<count($schemeList); $i++){
				if($schemeList[$i]['id'] == $lists['scheme_id']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
						
			echo '<option '.$selected.' value="'.$schemeList[$i]['id'].'">'.$schemeList[$i]['Scheme_Name'].'</option>';
		}
			?>
		
		</select>
    </div> 

    <!-- start  -->
    <div class="col-md-6 form-group">
        <label for="amount"> Amount:</label><br>
		
        <input  class="form-control" class="form-control"type="text" onkeypress="allowNumericInput(event);" required value="<?php echo $lists['amount']; ?>"  id="amount" name="amount" placeholder="Enter Amount"  min="<?php echo htmlspecialchars((int)$LenderSchemeData['minimum_loan_amount'], ENT_QUOTES); ?>" 
        step="<?php echo htmlspecialchars((int)$LenderSchemeData['step_up_value'], ENT_QUOTES); ?>" pattern="\d*">
		
    </div>
	 <!-- end  -->

    
    <div class="col-md-6 form-group">
        <label for="interest">Interest Rate (% p.a):</label><br>
        <input  class="form-control"type="text" id="interest" onkeypress="allowNumericInput(event);" required value="<?php echo $lists['interest']; ?>" name="interest" placeholder="Enter Interest Rate">
    </div>

	
	<div class="col-md-6 form-group">
        <label for="tenor">Tenure (days):</label><br>
        <select  class="form-control" name="tenor" id="tenor" >
		<option value="">Choose Plan Tenure</option>
            <option value="30" <?php echo($lists['tenor']=='30'? "selected" : ""); ?>>30 Days</option>
            <option value="60" <?php echo($lists['tenor']=='60'? "selected" : ""); ?> >60 Days</option>
            <option value="90" <?php echo($lists['tenor']=='90'? "selected" : ""); ?> >90 Days</option>
		</select>
    </div>
	<?php	if($edit==false){  
	
		if($this->session->userdata('role_id')==10){ // 10: super admin role;
			
		
	?>
	
	<div class="col-md-6 form-group">
        <label for="password">Partner:</label><br>
        <select  class="form-control" name="partner_id" id="partner_id" <?php echo $partner_list_status;?> >
		<option value="">Select Partner</option>
		<?php for($i=0; $i<count($lists['partnersData']); $i++){
				if($lists['partner_id']==$lists['partnersData'][$i]['VID']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
						
			echo '<option '.$selected.' value="'.$lists['partnersData'][$i]['VID'].'">'.$lists['partnersData'][$i]['Company_Name'].'</option>';
		}
			?>
		
		</select>
    </div>
	
	
	<?php
			}else{ ?>
			
			<input type="hidden" name="partner_id" id="partner_id" value="<?php echo $this->session->userdata('partner_id'); ?>" >
			<?php 
			}
	}else{  ?>
			<input type="hidden" name="partner_id" id="partner_id" value="<?php echo $lists['partner_id']; ?>" >
	 <?php	}  ?>
	
	  
	
					</div>
				</div>
				<div class="row">
					<div class="box-footer text-right">
						<input  class="form-control"type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
						
					
					
								<?php if($edit==true){ ?>
								<input class="form-control" class="form-control" type="hidden" value="<?php echo base64_encode(base64_encode($lists['id'])); ?>" id="id" name="id">
						<input   type="submit" name="submit" id="" value="Update Loan Plan" class="btn btn-success"/>
								<?php }else{?>
						<input   type="submit" name="submit" id="" value="Add Loan Plan" class="btn btn-success"/>
								<?php } ?>
					</div>
				</div>

			</div>
		</form>
	</div>
	</div>
	</div>


	
</section>

<script>
    function previewImage() {
        var input = document.getElementById('partner_logo_file');
        var preview = document.getElementById('partner_logo_imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


<script>

 function allowNumericInput(event) {
            const inputChar = String.fromCharCode(event.keyCode);
			//alert(inputChar);
            // Allow only numeric input (0-9) and some control keys
            if (!/^\d$/.test(inputChar) && ![8, 9, 13, 27, 37, 39].includes(event.keyCode)) {
                event.preventDefault();
            }
        }
		
		 function allowAlphabeticInput(event) {
            const inputChar = String.fromCharCode(event.keyCode);

            // Allow only alphabetic input and some control keys
            if (!/^[a-zA-Z\s]$/.test(inputChar) && ![8, 9, 13, 27, 37, 39].includes(event.keyCode)) {
                event.preventDefault();
            }
			
			
        }
		
function validateEmail() {
    var email = document.getElementById("email").value;
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (regex.test(email)) {
        return true;
    } else {
        alert("Invalid Email Address"); 
		return false;
    }
}

function validateMobileNumber() {
    var mobileNumber = document.getElementById("mobile").value;
    var regex = /^[0-9]{10}$/; // 

    if (regex.test(mobileNumber)) { 
		return true;// alert("Valid Mobile Number");
    } else {
        alert("Invalid Mobile Number");
		return false;
    }
}
</script>

