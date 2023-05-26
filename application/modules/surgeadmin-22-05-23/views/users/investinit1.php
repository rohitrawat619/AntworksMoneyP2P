<?php 
if($this->session->userdata('UserLoginSession'))
{
    $udata = $this->session->userdata('UserLoginSession');
    $sdata = $this->session->userdata('scheme');
    var_dump($sdata);
}
else
{
    redirect(base_url('welcome/login'));
}
 ?>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card" style="margin-top: 30px">
              <div class="card-header text-center">
                Please Verify Account Number and Pan Card Details
              </div>
              <div class="card-body">
               <form method="post" autocomplete="off" action="<?=base_url('welcome/investinit2?SID='.$sdata['SID'].'&UID='.$udata['uid'].'&VID='.$udata['vid'])?>">
             
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name on PAN Card</label>
                    <input type="text"  placeholder="Full Name on PAN" name="fullname" class="form-control" id="fullname" aria-describedby="emailHelp" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPan1" class="form-label">PAN No.</label>
                    <input type="text" name="pan"  placeholder="PAN Card No."  class="form-control" id="pan" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Account No.</label>
                    <input type="text" name="Account_No"  placeholder="Account Number"  class="form-control" id="Account_No" required>
                  </div>
                 <div class="text-center">
                  <button type="submit" class="btn btn-primary">Conitinue</button>
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


