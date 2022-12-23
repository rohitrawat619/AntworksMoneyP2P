<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
            <?=getNotificationHtml();?>
		</div>
	</div>


	<div class="white-box">
		<div class="col-md-8">
			<div class="payout-main m-t-40">
				<div class="payout-bx">
<!--                      <strong>Previous Request</strong>-->
<!--                    <ul>-->
<!--                        --><?php // if($previous_request){foreach($previous_request AS $request){?>
<!--                        <li>Request Date --><?//=$request['created_date']?><!--, --><?// if($request['accepted_or_not'] == 1){echo "Updated";}else{echo "Not Update";} ?><!--</li>-->
<!--                        --><?php //}}
//                        else{
//                            echo "<li>You don't have previous address change request</li>";
//                        }
//                        ?>
<!--                    </ul>-->
					  <div class="form-group">
						<label for="amount" class="col-sm-4 control-label">Current Address:</label>
						<div class="col-sm-8">
						  <p><?php echo $current_address['r_address'].', '.$current_address['r_address1']; ?><br><?php echo $current_address['r_city'] ?>, <?php echo $current_address['state']; ?>, <?php echo $current_address['r_pincode'] ?></p>
						</div>
					  </div>
				</div>
			</div>
		</div>
		<div class="col-md-8">


					<form method="post" action="<?php echo base_url(); ?>borroweraction/changeaddress">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address 1" name="address1" id="address1" rows="3" autocomplete="off">
                                <span class="validation error-validation" id="error_address1"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <input type="text" class="form-control" placeholder="Address 2" name="address2" id="address2" rows="3" autocomplete="off">
                                <span class="validation error-validation" id="error_address2"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <select class="form-control" name="state_code" id="state" onChange="get_city()" />
                                <option value="">Select State</option>
                                <?php if($states){foreach ($states AS $state){
                                    echo "<option value='".$state['code']."'>".$state['state']."</option>";
                                }} ?>
                                </select>
                                <span class="validation error-validation" id="error_state"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <select class="form-control" name="city" id="city" />

                                </select>
                                <span class="validation error-validation" id="error_city"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <input class="form-control" type="text" placeholder="Pincode" name="pincode" id="pincode" maxlength="6" onkeypress="return isNumberKey(event)" >
                                <span class="validation error-validation" id="error_pincode"></span>
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
