
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); ?>
	<div class="box">
				<div class="row">
	     	<div class="col-md-12">
		<?php // echo"<pre>"; print_r($lists); echo"</pre>"; 
			if($lists['admin_id']!=""){
					$edit= true;
					$path= "update_user";
			}else{
				$edit=false;
					$path= "add_user";
			}
		//	echo "<pre>";
		 //	print_r($lists['partnersData'][0]['Company_Name']);
		?>
		
		<form class="form form-material" 
			  action="../surge/<?php echo $path; ?>/" onsubmit="return validateMobileNumber() && validateEmail()" method="POST"  > 
			<div class="col-md-12" >
			<h2><?php echo ($edit == true) ? 'Update User' : 'Add User'; ?></h2>

				
			
				<div class="box-body">
					<div class="row">

					
					  

    <div class="col-md-6 form-group">
        <label for="fname">First Name:</label><br>
        <input  class="form-control" class="form-control"type="text" onkeypress="allowAlphabeticInput(event);" required value="<?php echo $lists['fname']; ?>"  id="fname" name="fname" placeholder="Enter First Name">
		
    </div>

    
    <div class="col-md-6 form-group">
        <label for="lname">Last Name:</label><br>
        <input  class="form-control"type="text" id="lname" onkeypress="allowAlphabeticInput(event);" required value="<?php echo $lists['lname']; ?>" name="lname" placeholder="Enter Last Name">
    </div>

    <div class="col-md-6 form-group">
        <label for="email">Email:</label><br>
        <input  class="form-control"type="text" id="email" required value="<?php echo $lists['email']; ?>" name="email" placeholder="Enter Email">
    </div>

 <div class="col-md-6 form-group">
        <label for="mobile">Mobile:</label><br>
        <input  class="form-control"type="text" id="mobile" onkeypress="allowNumericInput(event);"  required value="<?php echo $lists['mobile']; ?>" name="mobile" placeholder="Enter Mobile">
    </div>
	
	<div class="col-md-6 form-group">
        <label for="password">Password:</label><br>
        <input  class="form-control"type="text" id="password"  name="password" placeholder="Enter Password">
    </div>
	
	<div class="col-md-6 form-group">
        <label for="password">Partner:</label><br>
        <select  class="form-control" name="partner_id" id="partner_id" >
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
	
	<div class="col-md-6 form-group">
        <label for="password">Role:</label><br>
        <select  class="form-control" name="role_id" id="role_id" >
		<option value="">Select Role</option>
			<?php for($i=0; $i<count($lists['AdminRoleData']); $i++){
			if($lists['role_id']==$lists['AdminRoleData'][$i]['id']){
					$selected = "selected";
				}else{
					$selected = "";
					}	
			
			echo '<option '.$selected.' value="'.$lists['AdminRoleData'][$i]['id'].'">'.$lists['AdminRoleData'][$i]['role_name'].'</option>';
		}
			?>
		</select>
    </div>
	
	  
	  <div class="col-md-6 form-group">
                        <label for="status">
						User Status:</label> <br>

						<input class="form-input" type="radio" name="status" value="1" required <?php echo ($lists['status'] == 1) ? 'checked' : ''; ?>> Active    
						<input  class="form-input" type="radio" name="status" value="0" required <?php echo ($lists['status'] == 0) ? 'checked' : ''; ?>> InActive
                    </div>

	
	
		



					</div>
				</div>
				<div class="row">
					<div class="box-footer text-right">
						<input  class="form-control"type="hidden" class="csrf-security"
							   name="<?php echo $this->security->get_csrf_token_name(); ?>"
							   value="<?php echo $this->security->get_csrf_hash(); ?>">
						
					
					
								<?php if($edit==true){ ?>
								<input class="form-control" class="form-control" type="hidden" value="<?php echo $lists['admin_id']; ?>" id="admin_id" name="admin_id">
						<input   type="submit" name="submit" id="" value="Update User" class="btn btn-success"/>
								<?php }else{?>
						<input   type="submit" name="submit" id="" value="Add User" class="btn btn-success"/>
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

