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
					    <h3>Enter Representative Details</h3>
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/reg_representative')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Name</label>
						    <input type="text" placeholder="Representative Name" name="RepName" class="form-control" id="RepName" aria-describedby="RepName" >
							<div style="color:red;">
							<?php echo form_error('RepName'); ?>
							</div>			    
						  </div><br>

					       <div class="mb-3">
						  <label for="exampleInputEmail1" name="vender" class="form-label">Select Vendor From list : </label>
						  <select name="vender" id="vender">
						  <option value="">Select Vendor from list</option>
						  <?php
						

                           foreach($result as $row1)
									{ ?><option value="<?php echo $row1['Company_Name']; ?>"><?php echo $row1['Company_Name']; ?></option>';
									<?php }
                                   ?>
                                </select>
						
								<div style="color:red;">
							<?php echo form_error('vender'); ?>
							</div>		
						  </div><br> 

						 <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Designation</label>
						    <input  type="text" placeholder="Designation" name="RepDesignation" class="form-control" id="RepDesignation" aria-describedby="RepDesignation">
							
							<div style="color:red;">
							<?php echo form_error('RepDesignation'); ?>
							</div>		
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text" placeholder="Phone Number" name="Repphone" class="form-control" id="Repphone" aria-describedby="Repphone">
							
							<div style="color:red;">
							<?php echo form_error('Repphone'); ?>
							</div>		
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email</label>
						    <input type="text"  placeholder="Email"  value="<?php echo set_value('Repemail'); ?>" name="Repemail" class="form-control" id="Repemail" aria-describedby="Repemail">
							
							<div style="color:red;">
							<?php echo form_error('Repemail'); ?>
							</div>		
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Password</label>
						    <input type="password"   value="<?php echo set_value('password'); ?>" placeholder="Password" name="password" class="form-control" id="Password" aria-describedby="Password">
							
							<div style="color:red;">
							<?php echo form_error('password'); ?>
							</div>		
						  </div><br>
						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Add Representative</button>
						</div>

						<?php
						if($this->session->flashdata('success')) {	?>
						 <p class="text-success text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('success')?></p>
						<?php } ?>
						
						</form>
					  </div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
    
     
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
	   
		</script>



 