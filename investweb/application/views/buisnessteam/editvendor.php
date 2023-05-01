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

<?php
    //   echo "<pre>";
    //    print_r($data);
    //    exit;
?>
<?php echo validation_errors(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					    Edit Vendor Details
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('welcome/editvendor2')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Company Name</label>
						    <input type="text" placeholder="Company Name" value="<?php echo $data['0']['Company_Name'];?>" name="Company_Name" class="form-control" id="Company_Name" aria-describedby="Company_Name">
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Address</label>
						    <input type="text"  placeholder="Address" value="<?php echo $data['0']['Address'];?>" name="Address" class="form-control" id="Address" aria-describedby="Address">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text"  placeholder="Company Phone Number" value="<?php echo $data['0']['Phone'];?>" name="Phone" class="form-control" id="Phone" aria-describedby="Phone">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email</label>
						    <input type="email"  placeholder="Email" value="<?php echo $data['0']['Email'];?>" name="Email" class="form-control" id="Email" aria-describedby="Email">
						  </div>
						  <br>
						 <div class="text-center">
						 <input type="hidden" id="VID" name="VID" value="<?php echo $data['0']['VID'];?>">
						  <button type="submit" class="btn btn-primary">Update Vendor Details</button>
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
					
