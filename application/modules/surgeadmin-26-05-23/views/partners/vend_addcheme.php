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




		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					  <h3> Enter Scheme Details</h3>
					  </div>

					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/vend_addschemenow')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Scheme Name</label>
						    <input type="text" placeholder="Scheme_Name" name="Scheme_Name" class="form-control" id="Scheme_Name" aria-describedby="Scheme_Name">
							<div style="color:red;">
							<?php echo form_error('Scheme_Name'); ?>
							</div>
                            </div>
                            <br>
                            <div class="mb-3">
                            
						
							<label for="exampleInputEmail1" class="form-label">Select Vendor from list</label>
							
							<select name="vendor_ID" id="vendor_ID">
                                    <option value="">Select Vendor from list</option>
                                    <?php
									


									foreach($result as $row1)
									{ ?><option value="<?php echo $row1['Company_Name']; ?>"><?php echo $row1['Company_Name']; ?></option>';
									<?php }
                                 
                                 ?>
                                </select>
								<div style="color:red;">
							<?php echo form_error('vendor_ID'); ?>
								</div>
                            </div>
						  </div> <br>
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Minimum Invest Ammount</label>
						    <input type="text"  placeholder="Min_Inv_Amount" name="" class="form-control" id="Min_Inv_Amount" aria-describedby="Min_Inv_Amount">
							<div style="color:red;">
							<?php echo form_error('Min_Inv_Amount'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Maximum Invest Ammount</label>
						    <input type="text"  placeholder="Max_Inv_Amount" name="Max_Inv_Amount" class="form-control" id="Max_Inv_Amount" aria-describedby="Max_Inv_Amount">
							<div style="color:red;">
							<?php echo form_error('Max_Inv_Amount'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Aggretate Invest Ammount</label>
						    <input type="text"  placeholder="Aggregate_Amount" name="Aggregate_Amount" class="form-control" id="Aggregate_Amount" aria-describedby="Aggregate_Amount">
							<div style="color:red;">
							<?php echo form_error('Aggregate_Amount'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin :</label>
                            </br> <input type="radio" name ="Lockin" id="Lockin" value="1"> Yes 
                            <input type="radio" name = "Lockin" id="Lockin" value="0" checked> No </br>
							<div style="color:red;">
							<?php echo form_error('Lockin'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin Period</label>
						    <input type="text"  placeholder="Lockin_Period" name="Lockin_Period" class="form-control" id="Lockin_Period" aria-describedby="Lockin_Period" >
							<div style="color:red;">
							<?php echo form_error('Lockin_Period'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Cooling Period</label>
						    <input type="text"  placeholder="Cooling_Period" name="Cooling_Period" class="form-control" id="Cooling_Period" aria-describedby="Cooling_Period" >
							<div style="color:red;">
							<?php echo form_error('Cooling_Period'); ?>
							</div>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Interest Rate</label>
						    <input type="text"  placeholder="Interest_Rate" name="Interest_Rate" class="form-control" id="Interest_Rate" aria-describedby="Interest_Rate">
							<div style="color:red;">
							<?php echo form_error('Interest_Rate'); ?>
							</div>
                            </div>
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Pre-Mature Interest Rate</label>
						    <input type="text"  placeholder="Pre_Mat_Rate" name="Pre_Mat_Rate" class="form-control" id="Pre_Mat_Rate" aria-describedby="Pre_Mat_Rate">
							<div style="color:red;">
							<?php echo form_error('Pre_Mat_Rate'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime</label>
                            </br> <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="1"> Yes 
                            <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="0" checked> No </br>
							<div style="color:red;">
							<?php echo form_error('Withrawl_Anytime'); ?>
							</div>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Auto Redeem</label>
                            </br> <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="1"> Yes 
                            <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="0" checked> No </br>
							<div style="color:red;">
							<?php echo form_error('Auto_Redeem'); ?>
							</div>
						  </div>
                          <input type="hidden" id="Interest_Type" name="Interest_Type" value="Simple">
                          <br>
						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Add Scheme</button>
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

