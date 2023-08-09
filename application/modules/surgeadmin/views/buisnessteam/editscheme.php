<?php 
if($this->session->userdata('session_data'))
{
    $udata = $this->session->userdata('session_data');

}
else
{
    redirect(base_url('Surgeadmin/businessTeamlogin'));
}
 ?>

<?php echo validation_errors(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					  <h3> Edit Scheme Details</h3>
					  </div>

					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/updatescheme')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Scheme Name</label>
						    <input type="text" placeholder="Scheme_Name"  value="<?php echo $schemelist['Scheme_Name'];?>"  name="Scheme_Name" class="form-control" id="Scheme_Name" aria-describedby="Scheme_Name" required>
                            </div>
							<div class="mb-3">
                            
						
							<label for="exampleInputEmail1" class="form-label">Select Partner from list</label>
							
							<select name="vendor" class="form-control" id="vendor">
                                  
									
                                    <?php
									
									foreach($result as $row1)
                           
									{
										if($row1['VID'] == $schemelist['Vendor_ID']){
											$selected = 'selected';
										}else{
											$selected = '';
										}
										?><option <?php echo $selected;?> value="<?php echo $row1['VID']; ?>"><?php echo $row1['Company_Name']; ?></option>';
									<?php }
                                 
                                 ?>
                                </select>
								<div style="color:red;">
							<?php echo form_error('vendor'); ?>
								</div>
                            </div>
                           
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Minimum Invest Ammount</label>
						    <input type="text"  placeholder="Min_Inv_Amount" name="Min_Inv_Amount"  value="<?php echo $schemelist['Min_Inv_Amount'];?>"  class="form-control" id="Min_Inv_Amount" aria-describedby="Min_Inv_Amount" required>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Maximum Invest Ammount</label>
						    <input type="text"  placeholder="Max_Inv_Amount" name="Max_Inv_Amount"  value="<?php echo $schemelist['Max_Inv_Amount'];?>" class="form-control" id="Max_Inv_Amount" aria-describedby="Max_Inv_Amount" required>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Aggretate Invest Ammount</label>
						    <input type="text"  placeholder="Aggregate_Amount" name="Aggregate_Amount"  value="<?php echo $schemelist['Aggregate_Amount'];?>" class="form-control" id="Aggregate_Amount" aria-describedby="Aggregate_Amount" required>
						  </div>
                          <?php
						if($schemelist['Lockin'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin :</label>
                            </br> <input type="radio" name = "Lockin" id="Lockin" value="1" checked> Yes </br>
                            <input type="radio" name = "Lockin" id="Lockin" value="0" > No </br>
						  </div>
						<?php } ?>

                        <?php
						if($schemelist['Lockin'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin :</label>
                            </br> <input type="radio" name = "Lockin" id="Lockin" value="1"> Yes </br>
                            <input type="radio" name = "Lockin" id="Lockin" value="0" checked> No </br>
						  </div>
						<?php } ?>
                        
                        
                          
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin Period</label>
						    <input type="text"  placeholder="Lockin_Period" name="Lockin_Period" value="<?php echo $schemelist['Lockin_Period'];?>"  class="form-control" id="Lockin_Period" aria-describedby="Lockin_Period" required>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Cooling Period</label>
						    <input type="text"  placeholder="Cooling_Period" name="Cooling_Period"  value="<?php echo $schemelist['Cooling_Period'];?>"  class="form-control" id="Cooling_Period" aria-describedby="Cooling_Period" required>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Interest Rate</label>
						    <input type="text"  placeholder="Interest_Rate" name="Interest_Rate" value="<?php echo $schemelist['Interest_Rate'];?>"  class="form-control" id="Interest_Rate" aria-describedby="Interest_Rate" required>
                            </div>
							<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Hike Rate</label>
						    <input type="text"  placeholder="Hike_Rate" name="hike_rate" value="<?php echo $schemelist['hike_rate'];?>"  class="form-control" id="hike_rate" aria-describedby="rike_rate" required>
                            </div>
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Pre-Mature Interest Rate</label>
						    <input type="text"  placeholder="Pre_Mat_Rate" name="Pre_Mat_Rate" value="<?php echo $schemelist['Pre_Mat_Rate'];?>"  class="form-control" id="Pre_Mat_Rate" aria-describedby="Pre_Mat_Rate" required>
						  </div>

                          <?php
						if($schemelist['Withrawl_Anytime'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="1" checked> Yes </br>
                            <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="0"> No </br>
						  </div>
						<?php } ?>

                        <?php
						if($schemelist['Withrawl_Anytime'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="1" > Yes </br>
                            <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="0" checked> No </br>
						  </div>
						<?php } ?>

                        

                        <?php
						if($schemelist['Auto_Redeem'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Auto Redeem :</label>
                            </br> <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="1" checked > Yes </br>
                            <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="0" > No </br>
						  </div>
						<?php } ?>

                        <?php
						if($schemelist['Auto_Redeem'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="1"> Yes </br>
                            <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="0"> No </br>
						  </div>
						<?php } ?>

                          <input type="hidden" id="Interest_Type" name="Interest_Type" value="Simple">
						  <br>
						 <div class="text-center">
						 <input type="hidden" id="id" name="id" value="<?php echo $schemelist['id'];?>">
						  <button type="submit" class="btn btn-primary">Update Scheme</button>
						</div>
						
						
						</form>
					  </div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  </body>
</html>