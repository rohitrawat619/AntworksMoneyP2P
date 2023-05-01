<?php 
if($this->session->userdata('Teamloginsession'))
{
    $udata = $this->session->userdata('Teamloginsession');
   // echo 'Welcome'.' '.$udata['fullname'];
}
else
{
    redirect(base_url('welcome/businessTeamlogin'));
}
 ?>


<?php echo validation_errors(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					    <h3>Enter Representative Details</h3>
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('welcome/add_representativenow')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Name</label>
						    <input type="text" required placeholder="Representative Name" name="RepName" class="form-control" id="RepName" aria-describedby="RepName" required>			    
						  </div><br>
                          <div class="mb-3">
						  <label for="exampleInputEmail1" class="form-label">Select Vendor From list : </label>
                          <select name="Vendor_ID" required>
                                                    <?php
                                                            foreach ($data as $option) {
                                                                         echo '<option value="'.$option['VID'].'">'.$option['Company_Name'].'</option>';
                                                                                                }
                                                                                                                    ?></select>
						  </div><br>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Designation</label>
						    <input required type="text"  placeholder="Designation" name="RepDesignation" class="form-control" id="RepDesignation" aria-describedby="RepDesignation" required>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text" required placeholder="Phone Number" name="Repphone" class="form-control" id="Repphone" aria-describedby="Repphone" required>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email</label>
						    <input type="email" required placeholder="Email" name="Repemail" class="form-control" id="Repemail" aria-describedby="Repemail" required>
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Password</label>
						    <input type="password" required  placeholder="Password" name="Password" class="form-control" id="Password" aria-describedby="Password">
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

 