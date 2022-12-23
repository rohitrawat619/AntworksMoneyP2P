<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
            <?=getNotificationHtml();?>
		</div>
	</div>


	<div class="white-box">
	
		<div class="col-md-8">


					<form method="post" action="<?php echo base_url(); ?>borroweraction/actionEkyc">
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="text" class="form-control" placeholder="Aadhhar no." name="aadhaar_number" id="aadhaar_number">
                                <span class="validation error-validation" id="error_address1"></span>
                            </div>
                        </div>
                     
             
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						  <button type="submit" class="btn btn-primary pull-right">Submit</button>
						</div>
					  </div>
					</form>

		</div>
	</div>
