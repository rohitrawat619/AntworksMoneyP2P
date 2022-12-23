<?=getNotificationHtml();?>
<section class="sec-pad sec-pad-30">
    <div class="mytitle row">
        <div class="left col-md-12">
            <h1 id="pagetitle"><?=$pageTitle;?></h1>
        </div>
    </div>
		<div class="white-box">
		<div class="col-md-8">
			<div class="payout-main">
				<div class="payout-bx">
					<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>lenderaction/requestchangeAddress">
					  
					  <div class="row">
						  <div class="form-group">
							<label for="amount" class="col-sm-4 control-label">Enter Your Address:</label>
							<div class="col-sm-8">
								<input type="text" name="address1" class="form-control" style="height:80px;">
							</div>
						  </div>
					  </div>
					  <div class="row">
						  <div class="form-group">
							<label for="amount" class="col-sm-4 control-label">Enter Your Address 2:</label>
							<div class="col-sm-8">
								<input type="text" name="address2" class="form-control" style="height:80px;">
							</div>
						  </div>
					  </div>
					  <div class="row">
						  <div class="form-group">
							<label for="pincode" class="col-sm-4 control-label">State:</label>
							<div class="col-sm-8">
								<select class="form-control" name="state_code" id="state" onchange="return get_city()">
                                    <option value="">Select State</option>
                                    <?php if($states){foreach ($states AS $state){
                                        echo "<option value='".$state['code']."'>".$state['state']."</option>";
                                    }} ?>
                                </select>
							</div>
						  </div>
					  </div>
					  <div class="row">
						  <div class="form-group">
							<label for="pincode" class="col-sm-4 control-label">City:</label>
							<div class="col-sm-8">
								<select class="form-control" name="city" id="city">
								</select>
							</div>
						  </div>
					  </div>
					  <div class="row">
						  <div class="form-group">
							<label for="pincode" class="col-sm-4 control-label">Pin Code:</label>
							<div class="col-sm-8">
								<input type="text" id="pincode" name="pincode" class="form-control">
							</div>
						  </div>
					  </div>
					  
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						  <button type="submit" class="btn btn-primary">Submit</button>
						</div>
					  </div>
					</form>
				</div>
			</div>
		</div>
		</div>
	
</section>
<script>
    function get_city()
    {
        var state_code = $("#state").val();
        if(state_code){
            $.ajax({
                async: true,
                type:"POST",
                url: baseURL+"frontendresponse/city_list/",
                data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',"state":state_code},
                success: function(result){
                    $("#city").html(result);
                }});
        }

    }
</script>