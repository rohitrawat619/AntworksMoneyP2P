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
					   Enter Scheme Details
					  </div>

					  <div class="card-body">
					   <form method="post" autocomplete="off" action="<?=base_url('welcome/editscheme2')?>">
					   	<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Scheme Name</label>
						    <input type="text" placeholder="Scheme_Name"  value="<?php echo $data['0']['Scheme_Name'];?>"  name="Scheme_Name" class="form-control" id="Scheme_Name" aria-describedby="Scheme_Name">
                            </div>
                           
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Minimum Invest Ammount</label>
						    <input type="text"  placeholder="Min_Inv_Amount" name="Min_Inv_Amount"  value="<?php echo $data['0']['Min_Inv_Amount'];?>"  class="form-control" id="Min_Inv_Amount" aria-describedby="Min_Inv_Amount">
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Maximum Invest Ammount</label>
						    <input type="text"  placeholder="Max_Inv_Amount" name="Max_Inv_Amount"  value="<?php echo $data['0']['Max_Inv_Amount'];?>" class="form-control" id="Max_Inv_Amount" aria-describedby="Max_Inv_Amount">
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Aggretate Invest Ammount</label>
						    <input type="text"  placeholder="Aggregate_Amount" name="Aggregate_Amount"  value="<?php echo $data['0']['Aggregate_Amount'];?>" class="form-control" id="Aggregate_Amount" aria-describedby="Aggregate_Amount">
						  </div>
                          <?php
						if($data['0']['Lockin'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin :</label>
                            </br> <input type="radio" name = "Lockin" id="Lockin" value="1" checked> Yes </br>
                            <input type="radio" name = "Lockin" id="Lockin" value="0" > No </br>
						  </div>
						<?php } ?>

                        <?php
						if($data['0']['Lockin'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin :</label>
                            </br> <input type="radio" name = "Lockin" id="Lockin" value="1" > Yes </br>
                            <input type="radio" name = "Lockin" id="Lockin" value="0" checked> No </br>
						  </div>
						<?php } ?>
                        
                        
                          
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Lockin Period</label>
						    <input type="text"  placeholder="Lockin_Period" name="Lockin_Period" value="<?php echo $data['0']['Lockin_Period'];?>"  class="form-control" id="Lockin_Period" aria-describedby="Lockin_Period">
						  </div>
                          <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Cooling Period</label>
						    <input type="text"  placeholder="Cooling_Period" name="Cooling_Period"  value="<?php echo $data['0']['Cooling_Period'];?>"  class="form-control" id="Cooling_Period" aria-describedby="Cooling_Period">
						  </div><div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Interest Rate</label>
						    <input type="text"  placeholder="Interest_Rate" name="Interest_Rate" value="<?php echo $data['0']['Interest_Rate'];?>"  class="form-control" id="Interest_Rate" aria-describedby="Interest_Rate">
                            </div>
                            <div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Pre-Mature Interest Rate</label>
						    <input type="text"  placeholder="Pre_Mat_Rate" name="Pre_Mat_Rate" value="<?php echo $data['0']['Pre_Mat_Rate'];?>"  class="form-control" id="Pre_Mat_Rate" aria-describedby="Pre_Mat_Rate">
						  </div>

                          <?php
						if($data['0']['Withrawl_Anytime'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="1" checked> Yes </br>
                            <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="0" > No </br>
						  </div>
						<?php } ?>

                        <?php
						if($data['0']['Withrawl_Anytime'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="1" > Yes </br>
                            <input type="radio" name = "Withrawl_Anytime" id="Withrawl_Anytime" value="0" checked> No </br>
						  </div>
						<?php } ?>

                        

                        <?php
						if($data['0']['Auto_Redeem'] ==1) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Auto Redeem :</label>
                            </br> <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="1" checked> Yes </br>
                            <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="0" > No </br>
						  </div>
						<?php } ?>

                        <?php
						if($data['0']['Auto_Redeem'] == 0) {	?>
						<div class="mb-3">
						    <label for="exampleInputEmail1" class="form-label">Withrawl Anytime :</label>
                            </br> <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="1" > Yes </br>
                            <input type="radio" name = "Auto_Redeem" id="Auto_Redeem" value="0" checked> No </br>
						  </div>
						<?php } ?>

                          <input type="hidden" id="Interest_Type" name="Interest_Type" value="Simple">
						 <div class="text-center">
						 <input type="hidden" id="SID" name="SID" value="<?php echo $data['0']['SID'];?>">
						  <button type="submit" class="btn btn-primary">Update Scheme</button>
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