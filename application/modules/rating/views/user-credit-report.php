<div class="mytitle row">
		<div class="left col-md-4">
            <?=getNotificationHtml();?>
		</div>
	</div>
   <?php if($civil_report) {?>


    <form action="<?php echo base_url(); ?>rating/ratingmanager/save_records" method="post">
	<div class="white-box">
		<div class="col-md-12">
			<div class="table-responsive kyc-main">
				<table class="table table-bordered kyc-main">
					<tr>
						<th>Par</th>
						<th>Particular</th>
						<th>Preferred</th>
                        <th>Weightage</th>
                        <th>User Score</th>
						<th>System Score</th>
						<th>Credit Opt. Score</th>
					</tr>
                    <?php if($civil_report){ foreach ($civil_report AS $report_key => $report_value) {?>

					<tr>

						<td><?php echo $report_key; ?></td>
						<td><?php echo $report_value['rating_name']; ?></td>
						<td><?php echo $report_value['preferred_value']?></td>

                        <td><?php echo $report_value['maximum_weightage']?></td>
                        <td><?php echo $report_value['user_result']; ?></td>
						<td><?php echo $report_value['system_score']; ?></td>
						<td><input class="form-control class-for-change" name="<?php echo $report_key;  ?>" type="text" value="<?php echo $report_value['system_score']; ?>" placeholder="Credit Opt. Score" min="0" max="5"></td>
					</tr>
                    <?php }}?>
				</table>
                <table class="table table-bordered kyc-main">
                    <tr>
                        <th>Particular</th>
                        <th>Preferred</th>
                        <th>Maximum Weightage</th>
                        <th>Score</th>
                        <th>System Score</th>
                        <th>Credit Opt. Score</th>
                    </tr>
                    <tr>
                        <td>Cheque Bouncing (all Bank accounts)


                        </td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="cheque_bouncing" class="form-control onchangeclass" id="cheque_bouncing">
                                <option value="">--Select Service--</option>
                                <option value="0"> >5</option>
                                <option value="0">5</option>
                                <option value="0">4</option>
                                <option value="0">3</option>
                                <option value="0">2</option>
                                <option value="1">1</option>
                                <option value="5">0</option>
                            </select>
                            <?php }  else{?>
                            <select name="cheque_bouncing" class="form-control onchangeclass" id="cheque_bouncing">
                                <option value="">--Select Business/ Profession--</option>
                                <option value="0"> >6</option>
                                <option value="0">6</option>
                                <option value="0">5</option>
                                <option value="0">4</option>
                                <option value="0">3</option>
                                <option value="1">2</option>
                                <option value="2">1</option>
                                <option value="5">0</option>
                            </select>
                            <? } ?>
                        </td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="cheque_bouncing_value" id="cheque_bouncing_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Credit Summation to Annual Income (all Bank accounts)</td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="credit_summation" class="form-control onchangeclass" id="credit_summation">
                                <option value="">--Select Service --</option>
                                <option value="0"><10%</option>
                                <option value="0">10-30%</option>
                                <option value="0">30-50%</option>
                                <option value="0">50-60%</option>
                                <option value="1">60-70%</option>
                                <option value="2">70-80%</option>
                                <option value="3">80-90%</option>
                                <option value="4">90-100%</option>
                                <option value="4">>1 (incl. cash)</option>
                                <option value="5">>1 (non cash)</option>
                            </select>
                            <?php }  else{?>
                            <select name="credit_summation" class="form-control onchangeclass" id="credit_summation">
                                <option value="">--Select Business/ Profession --</option>
                                <option value="0"><20%</option>
                                <option value="0">20-40%</option>
                                <option value="0">40-60%</option>
                                <option value="0">60-80%</option>
                                <option value="1">80-100%</option>
                                <option value="2">1-1.5</option>
                                <option value="3">1.5-2</option>
                                <option value="4">2-3</option>
                                <option value="4">>3 (incl. cash)</option>
                                <option value="5">>3 (non cash)</option>

                            </select>
                            <? } ?>
                        </td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="credit_summation_value" id="credit_summation_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Digital Banking (cash withdrawal to total withdrawal)</td>
                        <td><select name="digital_banking" class="form-control onchangeclass" id="digital_banking">
                                <option value="">--Select--</option>
                                <option value="0">90-95%</option>
                                <option value="0">80-90%</option>
                                <option value="0">70-80%</option>
                                <option value="0">60-70%</option>
                                <option value="1">50-60%</option>
                                <option value="2">40-50%</option>
                                <option value="3">30-40%</option>
                                <option value="4">20-30%</option>
                                <option value="4">10-20%</option>
                                <option value="5">>10%</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="digital_banking_value" id="digital_banking_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Savings as percentage of Annual Income (Bank statement)</td>
                        <td><select name="savings_as_percentage" class="form-control onchangeclass" id="savings_as_percentage">
                                <option value="">--Select--</option>
                                <option value="0">10-15%</option>
                                <option value="1">15-20%</option>
                                <option value="2">20-25%</option>
                                <option value="3">25-30%</option>
                                <option value="4">30-40%</option>
                                <option value="4">40-50%</option>
                                <option value="5">>50%</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="savings_as_percentage_value" id="savings_as_percentage_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                </table>
                <table class="table table-bordered kyc-main">
                    <tr>
                        <th>Particular</th>
                        <th>Preferred</th>
                        <th>Maximum Weightage</th>
                        <th>Score</th>
                        <th>System Score</th>
                        <th>Credit Opt. Score</th>
                    </tr>
                    <tr>
                            <td>
                                <level>Present Residence</level>

                            </td>
                            <td><select name="present_residence" class="form-control onchangeclass" id="present_residence">
                                    <option value="">--Select--</option>
                                    <option value="0">Rented (Frequent change)</option>
                                    <option value="0">Rented (<1 years)</option>
                                    <option value="0">Rented (1-3 years)</option>
                                    <option value="1">Rented (3-5 years)</option>
                                    <option value="2">Rented (>5 years)</option>
                                    <option value="2">Ancestral (other than Parent)</option>
                                    <option value="2">Ancestral (Parent)</option>
                                    <option value="3">Permanent address is owned by self/ jointly but residing in rented apartment</option>
                                    <option value="4">Owned by Spouse</option>
                                    <option value="5">Owned by self/ jointly</option>
                                </select></td>
                            <td>10</td>
                            <td></td>
                            <td></td>
                            <td><input class="form-control class-for-change" name="present_residence_value" id="present_residence_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                        </tr>
<!--                    <tr>-->
<!--                        <td>Vehicle Owned-->
<!---->
<!--                        </td>-->
<!--                        <td><select name="vehicle_owned" class="form-control onchangeclass" id="vehicle_owned">-->
<!--                                <option value="">--Select--</option>-->
<!--                                <option value="0">No vehicle owned</option>-->
<!--                                <option value="2">Two wheeler</option>-->
<!--                                <option value="4">Four wheeler hatchback</option>-->
<!--                                <option value="5">Four wheeler sedan</option>-->
<!--                            </select></td>-->
<!--                        <td>5</td>-->
<!--                        <td></td>-->
<!--                        <td></td>-->
<!--                        <td><input class="form-control class-for-change" readonly type="text" name="vehicle_owned_value" id="vehicle_owned_value" placeholder="Credit Opt. Score"></td>-->
<!--                    </tr>-->
                    <tr>
                        <td>City of residence

                        </td>
                        <td><select name="city_of_residence" class="form-control onchangeclass" id="city_of_residence">
                                <option value="">--Select--</option>
                                <option value="1">Rural/ village</option>
                                <option value="1">Semi-rural</option>
                                <option value="2">Towns</option>
                                <option value="3">Class C Cities</option>
                                <option value="4">Class B cities/ State capitals/ Metro Suburbs</option>
                                <option value="5">Top cities/ Class A cities</option>
                                <option value="5">Metro</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly name="city_of_residence_value" id="city_of_residence_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Education

                        </td>
                        <td><select name="education" class="form-control onchangeclass" id="education">
                                <option value="">--Select--</option>
                                <option value="0">10th pass</option>
                                <option value="1">12th pass</option>
                                <option value="2">Vocational Qualification</option>
                                <option value="4">Graduate</option>
                                <option value="5">Post Graduate</option>
                                <option value="5">Professional Qualification</option>
                            </select></td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly type="text" name="education_value" id="education_value" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Institute of Study (highest degree)</td>
                        <td><select name="institute_of_study" class="form-control onchangeclass" id="institute_of_study">
                                <option value="">--Select--</option>
                                <option value="1">Unrecognized Institute</option>
                                <option value="2">Recognized Institute</option>
                                <option value="3">Top 100</option>
                                <option value="3">Top 50</option>
                                <option value="4">Top 25</option>
                                <option value="5">Top 10</option>
                            </select></td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly name="institute_of_study_value" id="institute_of_study_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td><select name="age" class="form-control onchangeclass" id="age">
                                <option value="">--Select--</option>
                                <option value="0">65-70</option>
                                <option value="2">62-65</option>
                            </select></td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly name="age_value" id="age_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Occupation</td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="occupation" class="form-control onchangeclass" id="occupation">
                                <option value="">--Select--</option>
                                <option value="0">No Job for last <12 months</option>
                                <option value="0">No Job for last <6 months</option>
                                <option value="0">No Job for last <3 months</option>
                                <option value="2">Private non-Corporate (without PF/ ESI)</option>
                                <option value="3">Private non-Corporate (with PF/ ESI)</option>
                                <option value="3">Private Corporate (Others)</option>
                                <option value="4">Private Corporate (Rank 2)</option>
                                <option value="5">Private Corporate (Rank 1)/ Non-strategic continuous loss-making PSU</option>
                                <option value="5">Government Sector/ PSU (Strategic or profit-making)</option>
                            </select>
                            <?php } else{?>
                            <select name="occupation" class="form-control onchangeclass" id="occupation">
                                <option value="">--Select--</option>
                                <option value="0">No occupation for last <12 months</option>
                                <option value="0">No occupation for last <6 months</option>
                                <option value="1">Consultancy or Intermediation Services (other than qualified professional) less than 5 years old/ No Job occupation last <3 months</option>
                                <option value="1">Trading Business or Service Establishment less than 5 years old</option>
                                <option value="1">Vocational Service (Plumber/ Carpenter/ Electrician/ Tailor/ Barber/ Beautician/ Other skilled services)</option>
                                <option value="2">Trading Business or Service Establishment more than 5 years old/ Consultancy or Intermediation Services (other than qualified professional) more than 5 years old</option>
                                <option value="3">Manufacturing</option>
                                <option value="4">Lawyer/ CS/ Valuer/ Architect/ CWA</option>
                                <option value="5">Doctor/ CA</option>
                            </select>
                            <?php } ?>
                        </td>
                        <td>20</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly type="text" name="occupation_value" id="occupation_value" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Experience

                        </td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="experience" class="form-control onchangeclass" id="experience">
                                <option value="">--Select--</option>
                                <option value="0"><1/<2</option>
                                <option value="1">1-2/2-3</option>
                                <option value="2">2-4/3-5</option>
                                <option value="3">4-6/5-8</option>
                                <option value="4">6-8/8-10</option>
                                <option value="4">8-10/10-15</option>
                                <option value="5">>10/>15</option>
                            </select>
                            <?php } else{?>
                            <select name="experience" class="form-control onchangeclass" id="experience">
                                <option value="">--Select--</option>
                                <option value="0"><1</option>
                                <option value="1">1-2</option>
                                <option value="2">2-4</option>
                                <option value="3">4-6</option>
                                <option value="4">6-8</option>
                                <option value="4">8-10</option>
                                <option value="5">>10</option>
                            </select>
                        <?php } ?>
                        </td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" readonly name="experience_value" id="experience_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>

                    <!--<tr>
                        <td>Health Insurance Cover (to Annual Income)
                            </td>
                        <td><select name="health_insurance_cover" class="form-control onchangeclass" id="health_insurance_cover">
                                <option value="">--Select--</option>
                                <option value="0">Nil</option>
                                <option value="1"><5% or < Rs. 0.5 L</option>
                                <option value="1">5-10% or >Rs. 0.5 L</option>
                                <option value="3">10-25% or >Rs. 1 L</option>
                                <option value="3">25-50% or >Rs. 1.5 L</option>
                                <option value="4">50-75% or >Rs. 2 L</option>
                                <option value="4">75-100% or >Rs. 3 L</option>
                                <option value="5">>100% or >Rs. 5 L</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" id="health_insurance_cover_value" name="health_insurance_cover_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Pending Litigation
                            </td>
                        <td><select name="pending_litigation" class="form-control onchangeclass" id="pending_litigation">
                                <option value="">--Select--</option>
                                <option value="0">Value>5 times Annual Income/ Charge sheet max Punishment>1 year</option>
                                <option value="0">Value 2-5 times Annual Income/ Charge sheet max Punishment<1 years</option>
                                <option value="0">Value 1-2 times Annual Income/ No charge sheet</option>
                                <option value="0">Value 0.5-1 times Annual Income</option>
                                <option value="0">Value<0.5 times Annual Income</option>
                                <option value="2">No pending litigation</option>
                                <option value="5">No litigation ever</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="pending_litigation_value" id="pending_litigation_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Contingent Liability
                            </td>
                        <td><select name="contingent_litigation" class="form-control onchangeclass" id="pending_litigation">
                                <option value="">--Select--</option>
                                <option value="0">Value>10 times Annual Income</option>
                                <option value="0">Value 5-10 times Annual Income</option>
                                <option value="0">Value 2-5 times Annual Income</option>
                                <option value="0">Value 1-2 times Annual Income</option>
                                <option value="0">Value<0.5 times Annual Income</option>
                                <option value="0">Value 0.5-1 times Annual Income</option>
                                <option value="5">No Contingent Liability</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" id="contingent_litigation_value" name="contingent_litigation_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr> -->
                </table>
                <table class="table table-bordered kyc-total">
                    <tr>
                        <td>Total Rating</td>
                        <?php $report_sum = 0; foreach ($civil_report AS $report) {
                            $report_sum += $report['system_score'];
                        } ?>
                        <td><input class="form-control" name="total_rating_value" id="total_rating_value" type="text" value="<?php echo $report_sum; ?>" readonly placeholder="Total Rating"></td>
                    </tr>
                </table>
                <div class="col-md-10"></div>
                <div class="col-md-2">
                <input type="submit" class="form-control" name="submit" id="submit" value="Update">
                </div>
			</div>
		</div>


	</div>
    </form>
<script>
    $(".onchangeclass").change(function () {
        var value = $("#"+this.id).val();
        var current_input_value = $("#"+this.id+"_value").val();
        if(current_input_value == '')
        {
            var current_value = $("#total_rating_value").val();
            var plus_value = parseFloat(current_value)+parseFloat(value);
            $("#total_rating_value").val(plus_value);
        }
        else{
            var current_value = $("#total_rating_value").val();
            var previous_value = parseFloat(current_value)-parseFloat(current_input_value);
            var plus_value = parseFloat(previous_value)+parseFloat(value);
            $("#total_rating_value").val(plus_value);
        }


        $("#"+this.id+"_value").val(value);
    })

   $(".class-for-change").change(function () {

       if (this.value > 5) {
           this.value = 5;
       }
       var change_value = this.defaultValue < this.value;
       this.defaultValue = this.value;
       if (change_value)
       {
          var current_value = $("#total_rating_value").val();
          var plus_value = parseFloat(current_value)+parseFloat(this.value);
           $("#total_rating_value").val(plus_value);

       }
       else
       {
           var current_value = $("#total_rating_value").val();
           var plus_value = parseFloat(current_value)-parseFloat(this.value);
           $("#total_rating_value").val(plus_value);
       }
   })

</script>
<?} else {
       echo "Experian Report Not Found";
   }?>