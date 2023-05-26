Enter The Investment Ammount
<?php 
if($this->session->userdata('UserLoginSession'))
{
    $udata = $this->session->userdata('UserLoginSession');
    echo 'Welcome'.' '.$udata['fullname'];
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
                Enter Investment Amount!
              </div>
              <div class="card-body">
               <form method="post" autocomplete="off" action="<?=base_url('welcome/investinit3')?>">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Amount in INR</label>
                    <input type="text"  placeholder="Enter Investment Amount" name="Investment_Amt" class="form-control" id="Investment_Amt" aria-describedby="emailHelp" required>
                  </div>
                  <div class="mb-3">
                  <label for="pet-select">Investment Method:</label>
                        <select name="Investment_type" id="Investment_type">
                        <option value="Auto" selected>Auto</option>
                            <option value="self">Self</option>
                        </select>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Check it if want reinvestment</label>
                    <input type="checkbox" id="reinvestment" name="reinvestment" value="1">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Accept Term and Conditions</label>
                    <input type="checkbox" id="termscon" name="termscon" value="1" required>
                  </div>
                  <input type="hidden" name="User_ID" id="User_ID" value="<?php echo $udata['uid']; ?>"/>
                  <input type="hidden" name="Scheme_ID" id="Scheme_ID" value="<?php echo $sdata['SID']; ?>"/>
                  <input type="hidden" name="Vendor_ID" id="Vendor_ID" value="<?php echo $udata['vid']; ?>"/>
                  <div class="text-center">
                  <button type="submit" class="btn btn-primary">Request Investment</button>
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

