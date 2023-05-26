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
 


			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					   <h3>Enter Vendor Details</h3>
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/vendor_regnow')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Company Name</label>
						    <input type="text" placeholder="Company Name" name="Company_Name" class="form-control" id="Company_Name" aria-describedby="Company_Name">
							<div style="color:red;">
							<?php echo form_error('Company_Name'); ?>
							</div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Address</label>
						    <input type="text"  placeholder="Address" name="Address" class="form-control" id="Address" aria-describedby="Address">
							<div style="color:red;">
							<?php echo form_error('Address'); ?>
							</div>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text"  placeholder="Company Phone Number" name="phone" class="form-control" id="phone" aria-describedby="phone">
							<div style="color:red;">
							<?php echo form_error('phone'); ?>
                          </div>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email</label>
						    <input type="text"  placeholder="Email" name="email" class="form-control" id="email" aria-describedby="email">
							<div style="color:red;">
							<?php echo form_error('email'); ?>
							</div>
						  </div><br>
						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Add Vendor</button>
						</div>
						<?php if($this->session->flashdata('success')): ?>
                       <p><?php echo $this->session->flashdata('success'); ?></p>
                               <?php endif; ?>

						</form>
						
					  </div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

