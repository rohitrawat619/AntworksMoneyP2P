
    <title>User Login & Registration</title>
  </head>
  <body>

		<div class="container">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<div class="card" style="margin-top: 30px">
					  <div class="card-header text-center">
					    Login Now
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/loginnow')?>">
					   <div class="mb-3">
						
						   <label><input type="radio" name="value" value="user"  class="btn btn-primary" onclick="updateLoginOption()"> <button type="button" name="loginOption" class="btn btn-danger">User</button></label>
                           <label><input type="radio" name="value" value="team"  class="btn btn-primary" onclick="updateLoginOption()"> <button type="button" name="loginOption" class="btn btn-danger">Team</button></label>
                           <label><input type="radio" name="value" value="partner"  class="btn btn-primary" onclick="updateLoginOption()"> <button type="button" name="loginOption" class="btn btn-danger">Partner</button></label>
   
						  </div
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email address</label>
						    <input type="email"  placeholder="Email Address" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputPassword1" class="form-label">Password</label>
						    <input type="password" name="password"  placeholder="User Password"  class="form-control" id="exampleInputPassword1">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputPassword1" class="form-label">OTP</label>
						    <input type="text" name="otp"  placeholder="Enter OTP"  class="form-control" id="exampleInputPassword1">
						  </div>

						 <div class="text-center">
						  <button type="submit" class="btn btn-primary">Login Now</button>
						</div>

					<?php
						if($this->session->flashdata('error')) {	?>
						 <p class="text-danger text-center" style="margin-top: 10px;"> <?=$this->session->flashdata('error')?></p>
						<?php } ?>
						
						</form>
					  </div>
					</div>
				</div>
				<div class="col-md-4"></div>
			</div>
		</div>
    
		<script>
    function updateLoginOption() {
      var loginOption = document.querySelector('input[name="value"]:checked').value;
      document.getElementById('loginOptionInput').value = value;
    }
  </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
