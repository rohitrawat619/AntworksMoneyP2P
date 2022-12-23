
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
	
	<div class="container">
	<div class="white-box m-t-40">
		<!-- CREDIT CARD FORM STARTS HERE -->
				<ul class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active"><a href="#iprofile" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="true"><span><i class="fa fa-credit-card"></i></span> Dabit Card</a></li>
			  <li role="presentation" class=""><a href="#ihome" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false"><span><i class="fa fa-cc-paypal text-info"></i></span> Paypal</a></li>
			</ul>
						<div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="ihome">
                                You can pay your money through paypal, for more info <a href="">click here</a><br><br>
                                <button class="btn btn-info"><i class="fa fa-cc-paypal"></i> Pay with Paypal</button>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="iprofile">
                            <div class="col-md-7 col-sm-5">
                                  <form>
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">CARD NUMBER</label>
                                        <div class="input-group">
                                          <div class="input-group-addon"><i class="fa fa-credit-card"></i></div>
                                          <input type="text" class="form-control" id="exampleInputuname" placeholder="Card Number">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-xs-7 col-md-7">
                                            <div class="form-group">
                                                <label>EXPIRATION DATE</label>
                                                <input type="text" class="form-control" name="Expiry" placeholder="MM / YY" required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-5 col-md-5 pull-right">
                                            <div class="form-group">
                                                <label>CV CODE</label>
                                                <input type="text" class="form-control" name="CVC" placeholder="CVC" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>NAME OF CARD</label>
                                                <input type="text" class="form-control" name="nameCard" placeholder="NAME AND SURNAME">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-success">Make Payment</button>
                                  </form>
                              </div>

                              <div class="col-md-4 col-sm-5 pull-right">
                                  <h3 class="box-title m-t-10">General Info</h3>
                                  <h2><i class="fa fa-cc-visa text-info"></i> <i class="fa fa-cc-mastercard text-danger"></i> <i class="fa fa-cc-discover text-success"></i> <i class="fa fa-cc-amex text-warning"></i></h2>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p> 
                              </div>

                              
                              <div class="clearfix"></div>
                            </div>
                            
                        </div>
		<!-- CREDIT CARD FORM ENDS HERE -->
	</div>
	
	</div>
	
	