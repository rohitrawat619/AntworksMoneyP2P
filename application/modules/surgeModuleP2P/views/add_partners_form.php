<?php if($this->session->userdata('role_id')!=11 AND  $this->session->userdata('role_id') !=12){
	$adminReadonlyStatus= "";
		}else{
			$adminReadonlyStatus = "readonly";
		}
	?>
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); 
  // echo"<pre>"; print_r($lists); die(); 
    ?>
	<div class="box">
		<div class="row">
			<div class="col-md-12">


		<?php // print_r($lists); 
			if($lists['VID']!=""){
					$edit= true;
					$path= "update_partner";
			}else{
				$edit=false;
					$path= "add_partner";
			}
		?>
		
		<form class="form form-material" 
			  action="../surge/<?php echo $path; ?>/" method="POST"  onsubmit="return validateMobileNumber() && validateEmail()" enctype="multipart/form-data" > 
			<div class="col-md-12" >
				<h2></h2>
			
				<div class="box-body">
					<div class="row">

					
					  

    <div class="col-md-6 form-group">
        <label for="Company_Name">Company Name:</label><br>
        <input  <?php echo$adminReadonlyStatus; ?> class="form-control" class="form-control"type="text" onkeypress="allowNonNumericInput(event);" required value="<?php echo $lists['Company_Name']; ?>"  id="Company_Name" name="Company_Name" placeholder="Enter Company Name">
		<br><br>
    </div>

    <div class="col-md-6 form-group">
        <label for="Address">Address:</label><br>
        <textarea <?php echo$adminReadonlyStatus; ?> class="form-control" style="height:34px;" class="form-control"type="text" required id="Address" name="Address" placeholder="Enter Address"><?php echo $lists['Address']; ?></textarea><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="Phone">Mobile:</label><br>
        <input <?php echo$adminReadonlyStatus; ?>  class="form-control"type="text" id="phone" onkeypress="allowNumericInput(event);" required value="<?php echo $lists['Phone']; ?>" name="Phone" placeholder="Enter Mobile"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="Email">Email:</label><br>
        <input <?php echo$adminReadonlyStatus; ?> class="form-control"type="text" id="email" required value="<?php echo $lists['Email']; ?>" name="Email" placeholder="Enter Email"><br><br>
    </div>

    <div class="col-md-6 form-group hideContent">
        <label for="key">Key:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['key']; ?>" id="key" name="key" placeholder="Enter Key"><br><br>
    </div>

    <div class="col-md-3 form-group hideContent">
        <label for="level">Level:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['level']; ?>" id="level" name="level" placeholder="Enter Level"><br><br>
    </div>

    <div class="col-md-3 form-group hideContent ">
        <label for="ignore_limits">Ignore Limits:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['ignore_limits']; ?>" id="ignore_limits" name="ignore_limits" placeholder="Enter Ignore Limits"><br><br>
    </div>

    <div class="col-md-3 form-group hideContent">
        <label for="is_private_key">Is Private Key:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['is_private_key']; ?>" id="is_private_key" name="is_private_key" placeholder="Enter Private Key"><br><br>
    </div>

    <div class="col-md-3 form-group hideContent ">
        <label for="ip_addresses">IP Addresses:</label><br>
        <input  class="form-control"type="text" id="ip_addresses" value="<?php echo $lists['ip_addresses']; ?>" name="ip_addresses" placeholder="Enter IP Addresses"><br><br>
    </div>
			
			<hr>
  
	<div class="col-md-3 form-group">
	 <label for="partner_logo">Logo:</label><br>
	<input type="file" accept=".png,.jpg,.jpeg,.bmp" name="partner_logo_file" id="partner_logo_file" onchange="previewImage('partner_logo_file','partner_logo_imagePreview')" />
    <img src="<?php echo str_replace("D:/public_html/antworksp2p.com","",$lists['logo_path']); ?>" alt="Preview" id="partner_logo_imagePreview" style=" max-width: 200px; max-height: 200px;" />
		</div>
		
		<div class="col-md-3 form-group">
        <label for="color">Header Color: </label><br>
        <input  class="form-control"type="color" required id="color" style="background-color:<?php echo $lists['color']; ?>;" value="<?php echo $lists['color']; ?>" name="color" placeholder="Color"><br><br>
    </div>
			<div class="row">
	<div class="col-md-3 form-group">
        <label for="background_color">Button Color:</label><br>
        <input  class="form-control"type="color" required id="background_color" style="background-color:<?php echo $lists['background_color']; ?>;" value="<?php echo $lists['background_color']; ?>" name="background_color" placeholder="Background Color">
    </div>
	
	<div class="col-md-3 form-group">
        <label for="font_family" id="previewFontFamily" >Font Family:</label><br>
		<select id="fontFamilyDropdown" class="form-control"  name="font_family" >
		</select>
    </div>
	
		
		
		
						
					<div class="col-md-2 form-group"> 
					<?php if($role=="10"){ //10:super admin ?>
        <label for="partner_type">Partners Type:</label><br>
        <select  class="form-control"type="text" required id="partner_type" onchange="onPartnerTypeChange(this.value)"  name="partner_type" >
				<option>Select Partner Type</option>
				<option  value="borrower" <?php echo (($lists['partner_type'] == "borrower") ? 'selected' : ''); ?>>Borrower</option>
				<option  value="lender" <?php echo (($lists['partner_type'] == "lender") ? 'selected' : ''); ?>>Lender</option>
			<?php /*	<option  value="both" <?php echo (($lists['partner_type'] == "both") ? 'selected' : ''); ?>>Both</option>  */ ?>
		</select>		<?php } ?>
						</div>
						
						
		<div class="col-md-3 form-group" id="BorrowerPartnerRegistrationFeeDiv1">
        <label >Borrower Registration Fee :</label><br>
        <label  class="form-control"  ><?php echo $lists['borrower_partner_registration_fee']; ?></label><br><br>
    </div>
               </div>
			   		</div>
					
				</div>
				</div>
				</div>
				</div>
				</div>
			   <hr>
<!-----------------start of admin block---------------->	
			<?php if($this->session->userdata('role_id')!=11 AND  $this->session->userdata('role_id') !=12){ ?>
			

	
	<!----start of section---------->
<div class="box">
	<div class="row">
		<div class="col-md-12">

			<div class="box-body">
				<div class="">
		<div class="row" id="BorrowePlatformDiv" >
<div class="col-md-3 form-group">
    <label for="Borrower Registration Fees" id="borrower_platform_registration_feeCheckbox"> Borrower Platform Registration Fee</label><br>
    <input class="form-input" type="radio" name="borrower_platform_registration_feeCheckbox"  onclick="showHideBorrowerFeesAmount(this.value)" value="1" required <?php echo ($lists['borrower_platform_registration_fee'] >= 1) ? 'checked' : ''; ?>> Yes
    <input class="form-input" type="radio" name="borrower_platform_registration_feeCheckbox" onclick="showHideBorrowerFeesAmount(this.value)" value="0" required <?php echo ($lists['borrower_platform_registration_fee'] < 1) ? 'checked' : ''; ?>> No

    <?php echo (($lists['borrower_platform_registration_fee'] >= 1) ? '<b> &#8377;'. $lists['borrower_platform_registration_fee']."</b>": ''); ?>
    <div id="borrowerFees">
		<label for="borrower_platform_registration_fee">Amount:</label><input type="number" name="borrower_platform_registration_fee" value="<?php echo $lists['borrower_platform_registration_fee']; ?>" class="form-input">
	</div>
</div>

 <div class="col-md-2 form-group ">
        <label for="is_private_key">Borrower Processing Fee &#8377;:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['borrower_processing_fee_rupee']; ?>" name="borrower_processing_fee_rupee" id="borrower_processing_fee_rupee"  placeholder="Fee In &#8377;"><br><br>
    </div>
	
	<div class="col-md-2 form-group ">
        <label for="is_private_key">Borrower Processing Fee %:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['borrower_processing_fee_percent']; ?>" name="borrower_processing_fee_percent" id="borrower_processing_fee_percent"  placeholder="Fee In %"><br><br>
    </div>
	
	<div class="col-md-3 form-group" id="disbursmentMethodDiv">
        <label for="lender_product_name">Disbursment Method:</label><br>
        <select  class="form-control"type="text" required id="disbursment_method"  name="disbursment_method" >
				<option>Select Disbursment Method</option>
				<option  value="automatic" <?php echo (($lists['disbursment_method'] == "automatic") ? 'selected' : ''); ?>>Automatic</option>
				<option  value="manual" <?php echo (($lists['disbursment_method'] == "manual") ? 'selected' : ''); ?>>Manual</option>
				<option  value="both" <?php echo (($lists['disbursment_method'] == "hybrid") ? 'selected' : ''); ?>>Hybrid</option>
		</select>
		
		<!------
		1. Manual
		2. Automatic
		3. Hybrid
		----->
    </div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-------------end of section----------------->	
					
					
					
					
							<hr>
	
	<!----start of section---------->
<div class="box">
	<div class="row">
		<div class="col-md-12">

			<div class="box-body">
				<div class="">
				<div class="row" id="LenderPlatformDiv" >
	<div class="col-md-2 form-group">
    <label for="Lender Registration Fees" id="lender_partner_registration_fee"> Lender Registration Fee</label><br>
    <input class="form-input" type="radio" name="lender_partner_registration_feeCheckbox" onclick="showHideLenderFeesAmount(this.value)" value="1" required <?php echo ($lists['lender_partner_registration_fee'] >= 1) ? 'checked' : '';  ?>> Yes
    <input class="form-input" type="radio" name="lender_partner_registration_feeCheckbox" onclick="showHideLenderFeesAmount(this.value)" value="0" required <?php echo ($lists['lender_partner_registration_fee'] == 0) ? 'checked' : ''; ?>> No

    <?php echo (($lists['lender_partner_registration_fee'] >= 1) ? '<b> &#8377;'. $lists['lender_partner_registration_fee']."</b>": ''); ?>
    <div id="lenderFees">
	'<label for="lender_partner_registration_fee">Amount:</label><input style="width:120px;" type="number" name="lender_partner_registration_fee"  value="<?php echo $lists['lender_partner_registration_fee']; ?>" class="form-input">
	</div>
</div>

	 <div class="col-md-2 form-group ">
        <label for="is_private_key">Lender Processing Fee &#8377;:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['lender_processing_fee_rupee']; ?>" name="lender_processing_fee_rupee" id="lender_processing_fee_rupee"  placeholder="Fee In &#8377;"><br><br>
    </div>
	
	<div class="col-md-2 form-group ">
        <label for="is_private_key">Lender Processing Fee %:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['lender_processing_fee_percent']; ?>" name="lender_processing_fee_percent" id="lender_processing_fee_percent"  placeholder="Fee In %"><br><br>
    </div>
	
	
	<div class="col-md-3 form-group">
    <label for="Lender Registration Fees" id="lender_partner_registration_fee"> Lender Platform Fee:
	<?php 
		if($lists['type_of_Lender_platform_fee']=="InPercentage"){
			echo "<b> ". $lists['lender_platform_fee_percentage']."%</b>";
		}else if($lists['type_of_Lender_platform_fee']=="InRupee"){
			echo "<b> &#8377;". $lists['lender_platform_fee_rupee']."</b>";
		}
	 ?>
	</label><br>
   <select onchange="showHideLenderTypeOfPlatformFee(this.value)" class="form-control" name="type_of_Lender_platform_fee">
    <option value="">Select</option>
    <option  value="None"<?php echo ($lists['type_of_Lender_platform_fee'] == "None") ? " selected" : ""; ?>>None</option>
    <option value="InPercentage"<?php echo ($lists['type_of_Lender_platform_fee'] == "InPercentage") ? " selected" : ""; ?>>In Percentage</option>
    <option value="InRupee"<?php echo ($lists['type_of_Lender_platform_fee'] == "InRupee") ? " selected" : ""; ?>>In Rupee</option>
</select>
    
    <div id="type_of_Lender_platform_fee_div"></div>
</div>

	<div class="col-md-3 form-group">
	 <label for="lender_pg_charges_bearer"> Lender PG Charges Bearer: </label>
	 <select  class="form-control" id="lender_pg_charges_bearer" name="lender_pg_charges_bearer" >
    <option value="">Select</option>
    <option value="lender"<?php echo ($lists['lender_pg_charges_bearer'] == "lender") ? " selected" : ""; ?>>Lender</option>
    <option value="partner"<?php echo ($lists['lender_pg_charges_bearer'] == "partner") ? " selected" : ""; ?>>Partner</option>
		</select>
				</div>
			</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-------------end of section----------------->	
	<?php }else{ ?>
<div class="box">
	<div class="row">
	<div class="box-body">
		<div class="col-md-4 form-group" id="BorrowerPartnerRegistrationFeeDiv">
        <label for="borrower_partner_registration_fee">Borrower Registration Fee :</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['borrower_partner_registration_fee']; ?>" name="borrower_partner_registration_fee" id="borrower_partner_registration_fee"  placeholder="Fee In Rupee"><br><br>
    </div>
			
					</div>
					</div>
					</div>
	<?php } ?>
<!------------------------end of admin block------------------->




	
	
			<!-----------------start of lender ------------------->
					
			<?php if (in_array($lists['partner_type'], ['lender', 'both'])){ ?>
<div class="box">
	<div class="row">
	<div class="box-body">
			<div class="col-md-8 form-group"><b>Lender Link: 
			<button class="btn btn-outline-secondary " type="button" onclick="copyLink('copyMessageLender','linkInputIdLender','Lender')">Copy</button>
					<small id="copyMessageLender" class="form-text text-muted"></small>
			</b>
		<a target="_blank" href="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("lender");?>" >
		<input type="text" class="form-control"  id="linkInputIdLender" value="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("lender");?>" readonly> </a>
					
					
					</div>
							
							
						
					<div class="col-md-4 form-group">
        <label for="lender_product_name">Lender Product Name:</label><br>
        <input  class="form-control"type="text" required id="lender_product_name" value="<?php echo $lists['lender_product_name']; ?>" name="lender_product_name" placeholder="Lender Product Name"><br><br>
    </div>	
			
			<div class="col-md-3 form-group">
	 <label for="partner_lender_product_logo_file">Lender Product Logo:</label><br>
	<input type="file" accept=".png,.jpg,.jpeg,.bmp" name="partner_lender_product_logo_file" id="partner_lender_product_logo_file" onchange="previewImage('partner_lender_product_logo_file','partner_lender_product_logo_imagePreview')" />
    <img src="<?php echo str_replace("D:/public_html/antworksp2p.com","",$lists['lender_logo_path']); ?>" alt="Preview" id="partner_lender_product_logo_imagePreview" style=" max-width: 200px; max-height: 200px;" />
		</div>
					
	</div>
	</div>
	</div>
			<?php } ?>
				<!----------------end of lender------------------>
					
					
					<!-----------------start of borrower ------------------->
			
			<?php if (in_array($lists['partner_type'], ['borrower', 'both'])){ ?>
			<div class="box">
			<div class="row">
			<div class="box-body">
			<div class="col-md-12 form-group">Borrower Links:</div>
					<div class="col-md-6 form-group"><b>Bullet Link: 
			<button class="btn btn-outline-secondary " type="button" onclick="copyLink('copyMessageBulletBorrower','linkInputIdBulletBorrower',' Bullet')">Copy</button>
					<small id="copyMessageBulletBorrower" class="form-text text-muted"></small>
			</b>
		<a target="_blank" href="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("borrowerBullet");?>" >
		<input type="text" class="form-control"  id="linkInputIdBulletBorrower" value="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("borrowerBullet");?>" readonly> </a>
					
					</div>
					
			<div class="col-md-6 form-group"><b>EMI Link: 
			<button class="btn btn-outline-secondary " type="button" onclick="copyLink('copyMessageEmiBorrower','linkInputIdEmiBorrower',' EMI')">Copy</button>
					<small id="copyMessageEmiBorrower" class="form-text text-muted"></small>
			</b>
		<a target="_blank" href="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("borrowerEmi");?>" >
		<input type="text" class="form-control"  id="linkInputIdEmiBorrower" value="https://www.antworksp2p.com/LendSocial/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>&p=<?php echo base64_encode("borrowerEmi");?>" readonly> </a>
					
					</div>				
							
							
							
					<div class="col-md-6 form-group">
        <label for="borrower_product_name">Borrower Product Name:</label><br>
        <input  class="form-control"type="text" required id="borrower_product_name" value="<?php echo $lists['borrower_product_name']; ?>" name="borrower_product_name" placeholder="Borrower Product Name"><br><br>
			</div>		
	<div class="col-md-6 form-group">
	 <label for="partner_logo">Borrower Product Logo:</label><br>
	<input type="file" accept=".png,.jpg,.jpeg,.bmp" name="partner_borrower_product_logo_file" id="partner_borrower_product_logo_file" onchange="previewImage('partner_borrower_product_logo_file','partner_borrower_product_logo_imagePreview')" />
    <img src="<?php echo str_replace("D:/public_html/antworksp2p.com","",$lists['borrower_logo_path']); ?>" alt="Preview" id="partner_borrower_product_logo_imagePreview" style=" max-width: 200px; max-height: 200px;" />
		</div>
		
		</div>
		</div>

			<?php } ?>
						<!----------------end of borrower---------------------->
					
				<div class="row">
				<div class="col-md-12">
					<div class="box-footer text-right">
						<input  class="form-control"type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
						
					<input type="hidden" value="1" name="status" id="status" >
					
								<?php if($edit==true){ ?>
								<input class="form-control" class="form-control" type="hidden" value="<?php echo $lists['VID']; ?>" id="VID" name="VID">
						<input   type="submit" name="submit" id="saveRemarkHotLead" value="Update Partner" class="btn btn-success"/>
								<?php }else{?>
						<input   type="submit" name="submit" id="saveRemarkHotLead" value="Add Partner" class="btn btn-success"/>
								<?php } ?>
					</div>
				</div>
				

		</form>
	</div>
	
				

<script>
    function copyLink(copyMessageVar,linkInputId,label) {
        /* Get the text field */
        var linkInputId = document.getElementById(linkInputId);

        /* Select the text field */
        linkInputId.select();
        linkInputId.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Display the copy message */
        var copyMessage = document.getElementById(copyMessageVar);
        copyMessage.innerHTML = label+" Link copied!";
        
        /* Clear the message after a short delay */
        setTimeout(function() {
            copyMessage.innerHTML = "";
        }, 2000);
    }
</script>

	
	
</section>

<script>
    function previewImage(logo_file,partner_logo_imagePreview) {
        var input = document.getElementById(logo_file);
        var preview = document.getElementById(partner_logo_imagePreview);

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
function onPartnerTypeChange(value){
	 // alert(value);
	if(value=="lender" || value==""){
	$("#disbursmentMethodDiv").hide();
	$("#BorrowePlatformDiv").hide();
	$("#LenderPlatformDiv").show();
	
	$("#BorrowerPartnerRegistrationFeeDiv").hide();
	$("#BorrowerPartnerRegistrationFeeDiv1").hide();
	}else if(value=="both"){
		$("#disbursmentMethodDiv").show();
		$("#BorrowePlatformDiv").show();
	$("#LenderPlatformDiv").show();
	$("#BorrowerPartnerRegistrationFeeDiv").show();
	$("#BorrowerPartnerRegistrationFeeDiv1").show();
	}else{
	$("#disbursmentMethodDiv").show();
	$("#BorrowePlatformDiv").show();
	$("#LenderPlatformDiv").hide();
	$("#BorrowerPartnerRegistrationFeeDiv").show();
	$("#BorrowerPartnerRegistrationFeeDiv1").show();
	}
	
}
$(document).ready(function() {
	onPartnerTypeChange("<?php echo $lists['partner_type']; ?>");
showHideBorrowerFeesAmount(<?php echo $lists['borrower_platform_registration_fee']; ?>);

showHideLenderFeesAmount(<?php echo $lists['lender_partner_registration_fee']; ?>);

showHideLenderTypeOfPlatformFee('<?php echo $lists['type_of_Lender_platform_fee']; ?>');

});
</script>

<script>
// List of font families you want to include in the dropdown
const fontFamilies = [
'Select Font Family,""',
    'Arial, sans-serif',
    'Times New Roman, serif',
    'Courier New, monospace',
    'Verdana, sans-serif',
    // Add more font families as needed
];

// Get the dropdown element
const dropdown = document.getElementById('fontFamilyDropdown');

// Populate the dropdown with font family options
fontFamilies.forEach(fontFamily => {
    const option = document.createElement('option');
    option.value = fontFamily;
    option.text = fontFamily.split(',')[0]; // Display only the first font in the list
    dropdown.add(option);
	
});
// Set a default font to be pre-selected (e.g., 'Arial, sans-serif')
const defaultFont = "<?php echo $lists['font_family']; ?>";
dropdown.value = defaultFont;

// Function to apply selected font family to a sample text
function applyFontFamily() {
    const selectedFont = dropdown.value;
    document.getElementById('previewFontFamily').style.fontFamily = selectedFont;
}

// Add an event listener to update the sample text when the selection changes
dropdown.addEventListener('change', applyFontFamily);
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
		
		 function allowNonNumericInput(event) {
            const inputChar = String.fromCharCode(event.keyCode);

            // Allow all characters except numeric values and some control keys
            if (!/^[^0-9]$/.test(inputChar) && ![8, 9, 13, 27, 37, 39].includes(event.keyCode)) {
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
    var mobileNumber = document.getElementById("phone").value;
    var regex = /^[0-9]{10}$/; // 

    if (regex.test(mobileNumber)) { 
		return true;// alert("Valid Mobile Number");
    } else {
        alert("Invalid Mobile Number");
		return false;
    }
}
</script>


<style>
.hideContent{
	display:none
}
</style>


<script>

function showHideLenderTypeOfPlatformFee(lenderPlatformFeeType) { // type_of_Lender_platform_fee
		   //  alert(lenderPlatformFeeType);
		if(lenderPlatformFeeType=="InRupee"){
        document.getElementById("type_of_Lender_platform_fee_div").innerHTML = '<label for="lender_platform_fee_rupee">Amount:</label><input type="number" name="lender_platform_fee_rupee"  value="<?php echo $lists['lender_platform_fee_rupee']; ?>" class="form-input">';
		}else if(lenderPlatformFeeType=="InPercentage"){
			 document.getElementById("type_of_Lender_platform_fee_div").innerHTML = '<label for="lender_platform_fee_percentage">Percentage:</label><input type="number" name="lender_platform_fee_percentage"  value="<?php echo $lists['lender_platform_fee_percentage']; ?>" class="form-input">';
		}else{
			 document.getElementById("type_of_Lender_platform_fee_div").innerHTML = '';
		}
    }

    function showHideLenderFeesAmount(value) {
		if(value>=1){
       // document.getElementById("lenderFees").innerHTML = '';
	   $("#lenderFees").show();
		}else{
			// document.getElementById("lenderFees").innerHTML = '';
			// $("#lender_partner_registration_fee").val("");
			  $("input[name='lender_partner_registration_fee']").val("");
			 $("#lenderFees").hide();
		}
    }

    function showHideBorrowerFeesAmount(value) {
		if(value>=1){
				$("#borrowerFees").show();
   //     document.getElementById("borrowerFees").innerHTML = '<label for="borrower_platform_registration_fee">Amount:</label><input type="number" name="borrower_platform_registration_fee" value="<?php echo $lists['borrower_platform_registration_fee']; ?>" class="form-input">';
		}else{	
				 $("input[name='borrower_platform_registration_fee']").val("");
				
				$("#borrowerFees").hide();
			// document.getElementById("borrowerFees").innerHTML = '';
		}
    }

   
</script>