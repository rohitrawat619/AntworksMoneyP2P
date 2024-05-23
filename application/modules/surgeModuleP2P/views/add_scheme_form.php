
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
		//	echo "<pre>";
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
                        <input class="form-control" type="text" value="<?php echo $lists['Min_Inv_Amount']; ?>" id="Min_Inv_Amount" name="Min_Inv_Amount" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Max_Inv_Amount">
						Max_Inv_Amount:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Max_Inv_Amount']; ?>" id="Max_Inv_Amount" name="Max_Inv_Amount" required>
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
						Cooling_Period: (Months)</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Cooling_Period']; ?>" id="Cooling_Period" name="Cooling_Period" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Interest_Rate">
						Interest_Rate:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Interest_Rate']; ?>" id="Interest_Rate" 
						name="Interest_Rate" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="hike_rate">
						hike_rate:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['hike_rate']; ?>" id="hike_rate" name="hike_rate" required>
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
                        <label for="withrawl_anytime">
						Withrawl_Anytime:</label><br>
                        
						<input type="radio" name="Withrawl_Anytime" value="1" <?php echo ($lists['Withrawl_Anytime'] == 1) ? 'checked' : ''; ?>> Yes
						<input type="radio" name="Withrawl_Anytime" value="0" <?php echo ($lists['Withrawl_Anytime'] == 0) ? 'checked' : ''; ?>> No
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="pre_mat_rate">
						Pre_Mat_Rate:</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Pre_Mat_Rate']; ?>" id="Pre_Mat_Rate" name="Pre_Mat_Rate" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="lockin_period">
						Lockin_Period: (Months)</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Lockin_Period']; ?>" id="Lockin_Period" name="Lockin_Period" required>
                    </div>
                                    <div class="col-md-6 form-group">
                        <label for="Tenure">
						Tenure: (Months)</label><br>
                        <input class="form-control" type="text" value="<?php echo $lists['Tenure']; ?>" id="Tenure" name="Tenure" required>
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
                                    
							
        <div class="row">
            <div class="box-footer text-right">
                <input type="hidden" class="form-control csrf-security" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <?php if ($edit == true) : ?>
                    <input type="hidden" class="form-control" value="<?php echo $lists['id']; ?>" id="id" name="id">
                <?php endif; ?>
                <input type="submit" name="submit" value="<?php echo ($edit == true) ? 'Update Scheme' : 'Add Scheme'; ?>" class="btn btn-success"/>
            </div>
        </div>
    </div>
</form>

	</div>
</div>

	<div class="box-footer clearfix"></div>
	<div class="clearfix"></div>
	
</section>
