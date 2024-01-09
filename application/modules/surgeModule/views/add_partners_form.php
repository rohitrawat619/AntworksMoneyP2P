
<!-- Main content -->
<section class="content" >
	<?= getNotificationHtml(); ?>
	<div class="box">

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
			  action="<?php echo base_url(); ?>surgeModule/surge/<?php echo $path; ?>/" method="POST"  enctype="multipart/form-data" > 
			<div class="col-md-12" >
				<h2>Add Partners</h2>
			
				<div class="box-body">
					<div class="row">

					
					  

    <div class="col-md-6 form-group">
        <label for="Company_Name">Company Name:</label><br>
        <input  class="form-control" class="form-control"type="text" required value="<?php echo $lists['Company_Name']; ?>"  id="Company_Name" name="Company_Name" placeholder="Enter Company Name">
		<br><br>
    </div>

    <div class="col-md-6 form-group">
        <label for="Address">Address:</label><br>
        <textarea  class="form-control" class="form-control"type="text" id="Address" name="Address" placeholder="Enter Address"><?php echo $lists['Address']; ?></textarea><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="Phone">Phone:</label><br>
        <input  class="form-control"type="text" id="Phone" required value="<?php echo $lists['Phone']; ?>" name="Phone" placeholder="Enter Phone"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="Email">Email:</label><br>
        <input  class="form-control"type="text" id="Email" required value="<?php echo $lists['Email']; ?>" name="Email" placeholder="Enter Email"><br><br>
    </div>

    <div class="col-md-6 form-group">
        <label for="key">Key:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['key']; ?>" id="key" name="key" placeholder="Enter Key"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="level">Level:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['level']; ?>" id="level" name="level" placeholder="Enter Level"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="ignore_limits">Ignore Limits:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['ignore_limits']; ?>" id="ignore_limits" name="ignore_limits" placeholder="Enter Ignore Limits"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="is_private_key">Is Private Key:</label><br>
        <input  class="form-control"type="text" value="<?php echo $lists['is_private_key']; ?>" id="is_private_key" name="is_private_key" placeholder="Enter Private Key"><br><br>
    </div>

    <div class="col-md-3 form-group">
        <label for="ip_addresses">IP Addresses:</label><br>
        <input  class="form-control"type="text" id="ip_addresses" value="<?php echo $lists['ip_addresses']; ?>" name="ip_addresses" placeholder="Enter IP Addresses"><br><br>
    </div>
			
			<hr>
  
	<div class="col-md-3 form-group">
	 <label for="partner_logo">Logo:</label><br>
	<input type="file" accept=".png,.jpg,.jpeg,.bmp" name="partner_logo_file" id="partner_logo_file" onchange="previewImage()" />
    <img src="<?php echo str_replace("D:/public_html/antworksp2p.com","",$lists['logo_path']); ?>" alt="Preview" id="partner_logo_imagePreview" style=" max-width: 200px; max-height: 200px;" />
		</div>
		
		<div class="col-md-3 form-group">
        <label for="color">Header Color: </label><br>
        <input  class="form-control"type="text" required id="color" style="background-color:<?php echo $lists['color']; ?>;" value="<?php echo $lists['color']; ?>" name="color" placeholder="Color"><br><br>
    </div>
	
	<div class="col-md-3 form-group">
        <label for="background_color">Button Color:</label><br>
        <input  class="form-control"type="text" required id="background_color" style="background-color:<?php echo $lists['background_color']; ?>;" value="<?php echo $lists['background_color']; ?>" name="background_color" placeholder="Background Color"><br><br>
    </div>
	
	<div class="col-md-3 form-group">
        <label for="font_family">Font Family:</label><br>
        <input  class="form-control"type="text" required id="font_family" 
				style="font-family:<?php echo $lists['font_family']; ?>;"
		value="<?php echo $lists['font_family']; ?>" name="font_family" placeholder="Font Family"><br><br>
    </div>
	
			<div class="col-md-3 form-group">
        <label for="lender_product_name">Lender Product Name:</label><br>
        <input  class="form-control"type="text" required id="lender_product_name" value="<?php echo $lists['lender_product_name']; ?>" name="lender_product_name" placeholder="Lender Product Name"><br><br>
    </div>

		<div class="col-md-3 form-group">
        <label for="borrower_product_name">Borrower Product Name:</label><br>
        <input  class="form-control"type="text" required id="borrower_product_name" value="<?php echo $lists['borrower_product_name']; ?>" name="borrower_product_name" placeholder="Borrower Product Name"><br><br>
    </div>

			<div class="col-md-6 form-group"><b>Lender Link:</b>
		<a target="_blank" href="https://www.antworksp2p.com/SurgeApp/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>" >
		<input type="text" class="form-control"  id="lenderLinkInput" value="https://www.antworksp2p.com/SurgeApp/signIn?q=<?php echo base64_encode(base64_encode($lists['VID']));?>" readonly> </a>
					
					
					</div>
					<div class="col-md-6 form-group"> <b><br></b>
					
					<button class="btn btn-outline-secondary" type="button" onclick="copyLink()">Copy</button>
					<small id="copyMessage" class="form-text text-muted"></small>
					</div>
					</div>
					
				</div>
				<div class="row">
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

			</div>
		</form>
	</div>

<script>
    function copyLink() {
        /* Get the text field */
        var lenderLinkInput = document.getElementById("lenderLinkInput");

        /* Select the text field */
        lenderLinkInput.select();
        lenderLinkInput.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Display the copy message */
        var copyMessage = document.getElementById("copyMessage");
        copyMessage.innerHTML = "Link copied!";
        
        /* Clear the message after a short delay */
        setTimeout(function() {
            copyMessage.innerHTML = "";
        }, 2000);
    }
</script>

	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	
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


