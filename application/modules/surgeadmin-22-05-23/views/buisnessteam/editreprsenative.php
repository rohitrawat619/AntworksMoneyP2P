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
					    Enter Representative Details
					  </div>
					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('Surgeadmin/updaterepersent')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Name</label>
						    <input type="text" placeholder="Representative Name"  value="<?php echo $representlist['RepName'];?>" name="RepName" class="form-control" id="RepName" aria-describedby="RepName" required>			    
						  </div>

						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Vender</label>
						    <input type="text"  value="<?php echo $representlist['vender'];?>" name="vender" class="form-control" id="vender" aria-describedby="vender" required>			    
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Designation</label>
						    <input type="text"  placeholder="Designation" value="<?php echo  $representlist['RepDesignation'];?>"  name="RepDesignation" class="form-control" id="RepDesignation" aria-describedby="RepDesignation" required>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Phone</label>
						    <input type="text"  placeholder="Phone Number" value="<?php echo  $representlist['Repphone'];?>"  name="Repphone" class="form-control" id="Repphone" aria-describedby="Repphone" required>
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Email</label>
						    <input type="email"  placeholder="Email" value="<?php echo  $representlist['Repemail'];?>" name="Repemail" class="form-control" id="Repemail" aria-describedby="Repemail" required>
							<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Password</label>
						    <input type="password"   value="<?php echo  $representlist['password']; ?>" placeholder="Password" name="password" class="form-control" id="Password" aria-describedby="Password">
						  </div><br>
							
						</div>
						<br>
						 <div class="text-center">
						 <input type="hidden" id="rid" name="rid" value="<?php echo $representlist['rid'];?>">
						  <button type="submit" class="btn btn-primary">Update Representative Details</button>
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
    
<!-- <script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script> -->
  </body>
</html>
