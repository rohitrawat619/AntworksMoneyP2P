<?php echo validation_errors(); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					    Register Now
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('welcome/registerNow')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Full Name on PAN Card</label>
						    <input type="text" placeholder="User Name" name="fullname" class="form-control" id="fullname" aria-describedby="name">			    
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email address</label>
						    <input type="email"  placeholder="Email Address" name="email" class="form-control" id="email" aria-describedby="emailHelp">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text"  placeholder="Phone Number" name="phone" class="form-control" id="phone" aria-describedby="phone">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">PAN</label>
						    <input type="text"  placeholder="PAN No." name="PAN" class="form-control" id="PAN" aria-describedby="PAN">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">DOB</label>
						    <input type="date"  placeholder="Date of Birth" name="DOB" class="form-control" id="DOB" aria-describedby="DOB">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Account No.</label>
						    <input type="text"  placeholder="Bank Acc No." name="Account_No" class="form-control" id="Account_No" aria-describedby="Account_No">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputPassword1" class="form-label">Password</label>
						    <input type="password" name="password"  placeholder="Enter your Password"  class="form-control" id="password">
						  </div>

						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Register Now</button>
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
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
