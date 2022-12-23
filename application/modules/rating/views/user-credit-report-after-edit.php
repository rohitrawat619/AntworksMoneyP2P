<?php
//echo "<pre>";
//print_r($civil_report); exit;
?>
<div class="mytitle row">
		<div class="left col-md-4">
           Experian Score- <?=$saved_record['experian_score']; ?> <?=getNotificationHtml();?>
		</div>
	</div>

    <form action="<?php echo base_url(); ?>rating/ratingmanager/save_records" method="post">
	<div class="white-box">
		<div class="col-md-12">
			<div class="table-responsive kyc-main">
				<table class="table table-bordered kyc-main">
					<tr>
						<th>Particular</th>
<!--						<th>Preferred</th>-->
                        <th>Maximum Weightage</th>
<!--						<th>Score</th>-->
						<th>System Score</th>
						<th>Credit Opt. Score</th>
					</tr>
                    <?php if($civil_report){ foreach ($civil_report AS $report_key => $report_value) {?>

					<tr>

						<td><?=$report_key?></td>
<!--						<td>--><?php //echo $report_value['preferred_value']?><!--</td>-->
                        <td><?php echo $report_value['maximum_weightage']?></td>
<!--						<td>--><?php //echo $report_value['user_result']; ?><!--</td>-->
						<td><?php echo $report_value['system_score']; ?></td>
						<td><input class="form-control class-for-change" name="<?php echo $report_key;  ?>" type="text" value="<?php echo $saved_record[$report_key]; ?>" placeholder="Credit Opt. Score" min="0" max="5"></td>
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
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>> >5</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>5</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>4</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>3</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>2</option>
                                <option value="5" <?php if($saved_record['cheque_bouncing'] == 5)echo "selected";?>>1</option>
                                <option value="10" <?php if($saved_record['cheque_bouncing'] == 10)echo "selected";?>>0</option>
                            </select>
                            <?php }  else{?>
                            <select name="cheque_bouncing" class="form-control onchangeclass" id="cheque_bouncing">
                                <option value="">--Select Business/ Profession--</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>> >6</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>6</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>5</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>4</option>
                                <option value="0" <?php if($saved_record['cheque_bouncing'] == 0)echo "selected";?>>3</option>
                                <option value="1" <?php if($saved_record['cheque_bouncing'] == 1)echo "selected";?>>2</option>
                                <option value="5" <?php if($saved_record['cheque_bouncing'] == 5)echo "selected";?>>1</option>
                                <option value="10" <?php if($saved_record['cheque_bouncing'] == 10)echo "selected";?>>0</option>
                            </select>
                            <? } ?>
                        </td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" value="<?php echo $saved_record['cheque_bouncing'] ?>" name="cheque_bouncing_value" id="cheque_bouncing_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Credit Summation to Annual Income (all Bank accounts)</td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="credit_summation" class="form-control onchangeclass" id="credit_summation">
                                <option value="">--Select Service --</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?>><10%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?>>10-30%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?>>30-50%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?>>50-60%</option>
                                <option value="1" <?php if($saved_record['credit_summation_to_annual_income'] == 1)echo "selected";?>>60-70%</option>
                                <option value="2" <?php if($saved_record['credit_summation_to_annual_income'] == 2)echo "selected";?>>70-80%</option>
                                <option value="3" <?php if($saved_record['credit_summation_to_annual_income'] == 3)echo "selected";?>>80-90%</option>
                                <option value="4" <?php if($saved_record['credit_summation_to_annual_income'] == 4)echo "selected";?>>90-100%</option>
                                <option value="4" <?php if($saved_record['credit_summation_to_annual_income'] == 4)echo "selected";?>> >1 (incl. cash)</option>
                                <option value="5" <?php if($saved_record['credit_summation_to_annual_income'] == 5)echo "selected";?>> >1 (non cash)</option>
                            </select>
                            <?php }  else{?>
                            <select name="credit_summation" class="form-control onchangeclass" id="credit_summation">
                                <option value="">--Select Business/ Profession --</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?> ><20%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?> >20-40%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?> >40-60%</option>
                                <option value="0" <?php if($saved_record['credit_summation_to_annual_income'] == 0)echo "selected";?> >60-80%</option>
                                <option value="1" <?php if($saved_record['credit_summation_to_annual_income'] == 1)echo "selected";?> >80-100%</option>
                                <option value="2" <?php if($saved_record['credit_summation_to_annual_income'] == 2)echo "selected";?> >1-1.5</option>
                                <option value="3" <?php if($saved_record['credit_summation_to_annual_income'] == 3)echo "selected";?> >1.5-2</option>
                                <option value="4" <?php if($saved_record['credit_summation_to_annual_income'] == 4)echo "selected";?> >2-3</option>
                                <option value="4" <?php if($saved_record['credit_summation_to_annual_income'] == 4)echo "selected";?>> >3 (incl. cash)</option>
                                <option value="5" <?php if($saved_record['credit_summation_to_annual_income'] == 5)echo "selected";?>> >3 (non cash)</option>

                            </select>
                            <? } ?>
                        </td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="credit_summation_value" value="<?php echo $saved_record['credit_summation_to_annual_income'] ?>" id="credit_summation_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Digital Banking (cash withdrawal to total withdrawal)</td>
                        <td><select name="digital_banking" class="form-control onchangeclass" id="digital_banking">
                                <option value="">--Select--</option>
                                <option value="0" <?php if($saved_record['digital_banking'] == 0)echo "selected";?>>90-95%</option>
                                <option value="0" <?php if($saved_record['digital_banking'] == 0)echo "selected";?>>80-90%</option>
                                <option value="0" <?php if($saved_record['digital_banking'] == 0)echo "selected";?>>70-80%</option>
                                <option value="0" <?php if($saved_record['digital_banking'] == 0)echo "selected";?>>60-70%</option>
                                <option value="1" <?php if($saved_record['digital_banking'] == 1)echo "selected";?>>50-60%</option>
                                <option value="2" <?php if($saved_record['digital_banking'] == 2)echo "selected";?>>40-50%</option>
                                <option value="3" <?php if($saved_record['digital_banking'] == 3)echo "selected";?>>30-40%</option>
                                <option value="4" <?php if($saved_record['digital_banking'] == 4)echo "selected";?>>20-30%</option>
                                <option value="4" <?php if($saved_record['digital_banking'] == 4)echo "selected";?>>10-20%</option>
                                <option value="5" <?php if($saved_record['digital_banking'] == 5)echo "selected";?>>>10%</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="digital_banking_value" value="<?php echo $saved_record['digital_banking'] ?>" id="digital_banking_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                    </tr>
                    <tr>
                        <td>Savings as percentage of Annual Income (Bank statement)</td>
                        <td><select name="savings_as_percentage" class="form-control onchangeclass" id="savings_as_percentage">
                                <option value="">--Select--</option>
                                <option value="0" <?php if($saved_record['savings_as_percentage'] == 0)echo "selected";?>>10-15%</option>
                                <option value="1" <?php if($saved_record['savings_as_percentage'] == 1)echo "selected";?>>15-20%</option>
                                <option value="2" <?php if($saved_record['savings_as_percentage'] == 2)echo "selected";?>>20-25%</option>
                                <option value="3" <?php if($saved_record['savings_as_percentage'] == 3)echo "selected";?>>25-30%</option>
                                <option value="4" <?php if($saved_record['savings_as_percentage'] == 4)echo "selected";?>>30-40%</option>
                                <option value="4" <?php if($saved_record['savings_as_percentage'] == 4)echo "selected";?>>40-50%</option>
                                <option value="5" <?php if($saved_record['savings_as_percentage'] == 5)echo "selected";?>>>50%</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control" name="savings_as_percentage_value" value="<?php echo $saved_record['savings_as_percentage'] ?>" id="savings_as_percentage_value" type="text" placeholder="Credit Opt. Score" readonly></td>
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
                                    <option value="0" <?php if($saved_record['present_residence'] == 0)echo "selected";?>>Rented (Frequent change)</option>
                                    <option value="0" <?php if($saved_record['present_residence'] == 0)echo "selected";?>>Rented (<1 years)</option>
                                    <option value="0" <?php if($saved_record['present_residence'] == 0)echo "selected";?>>Rented (1-3 years)</option>
                                    <option value="1" <?php if($saved_record['present_residence'] == 1)echo "selected";?>>Rented (3-5 years)</option>
                                    <option value="2" <?php if($saved_record['present_residence'] == 2)echo "selected";?>>Rented (>5 years)</option>
                                    <option value="2" <?php if($saved_record['present_residence'] == 2)echo "selected";?>>Ancestral (other than Parent)</option>
                                    <option value="2" <?php if($saved_record['present_residence'] == 2)echo "selected";?>>Ancestral (Parent)</option>
                                    <option value="3" <?php if($saved_record['present_residence'] == 3)echo "selected";?>>Permanent address is owned by self/ jointly but residing in rented apartment</option>
                                    <option value="4" <?php if($saved_record['present_residence'] == 4)echo "selected";?>>Owned by Spouse</option>
                                    <option value="5" <?php if($saved_record['present_residence'] == 5)echo "selected";?>>Owned by self/ jointly</option>
                                </select></td>
                            <td>10</td>
                            <td></td>
                            <td></td>
                            <td><input class="form-control class-for-change" value="<?php echo $saved_record['present_residence']; ?>" name="present_residence_value" id="present_residence_value" type="text" placeholder="Credit Opt. Score" readonly></td>
                        </tr>
                    <tr>
                        <td>City of residence

                        </td>
                        <td><select name="city_of_residence" class="form-control onchangeclass" id="city_of_residence">
                                <option value="">--Select--</option>
                                <option value="1" <?php if($saved_record['city_of_residence'] == 1)echo "selected";?>>Rural/ village</option>
                                <option value="1" <?php if($saved_record['city_of_residence'] == 1)echo "selected";?>>Semi-rural</option>
                                <option value="2" <?php if($saved_record['city_of_residence'] == 2)echo "selected";?>>Towns</option>
                                <option value="3" <?php if($saved_record['city_of_residence'] == 3)echo "selected";?>>Class C Cities</option>
                                <option value="4" <?php if($saved_record['city_of_residence'] == 4)echo "selected";?>>Class B cities/ State capitals/ Metro Suburbs</option>
                                <option value="5" <?php if($saved_record['city_of_residence'] == 5)echo "selected";?>>Top cities/ Class A cities</option>
                                <option value="5" <?php if($saved_record['city_of_residence'] == 5)echo "selected";?>>Metro</option>
                            </select></td>
                        <td>5</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['city_of_residence']; ?>" readonly name="city_of_residence_value" id="city_of_residence_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Education

                        </td>
                        <td>
                            <select name="education" class="form-control onchangeclass" id="education">
                                <option value="">--Select--</option>
                                <option value="0" <?php if($borrower_info['highest_qualification'] == 1)echo "selected";?>>Undergraduate</option>
                                <option value="1" <?php if($borrower_info['highest_qualification'] == 2)echo "selected";?>>Graduate</option>
                                <option value="2" <?php if($borrower_info['highest_qualification'] == 3)echo "selected";?>>Post Graduate</option>
                                <option value="4" <?php if($borrower_info['highest_qualification'] == 4)echo "selected";?>>Professional</option>
                                <option value="5" <?php if($borrower_info['highest_qualification'] == 5)echo "selected";?>>Other</option>
                            </select>
                        </td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['education']; ?>" readonly type="text" name="education_value" id="education_value" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Institute of Study (highest degree)</td>
                        <td><select name="institute_of_study" class="form-control onchangeclass" id="institute_of_study">
                                <option value="">--Select--</option>
                                <option value="1" <?php if($saved_record['institute_of_study'] == 1)echo "selected";?>>Unrecognized Institute</option>
                                <option value="2" <?php if($saved_record['institute_of_study'] == 2)echo "selected";?>>Recognized Institute</option>
                                <option value="3" <?php if($saved_record['institute_of_study'] == 3)echo "selected";?>>Top 100</option>
                                <option value="3" <?php if($saved_record['institute_of_study'] == 3)echo "selected";?>>Top 50</option>
                                <option value="4" <?php if($saved_record['institute_of_study'] == 4)echo "selected";?>>Top 25</option>
                                <option value="5" <?php if($saved_record['institute_of_study'] == 5)echo "selected";?>>Top 10</option>
                            </select></td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['institute_of_study']; ?>" readonly name="institute_of_study_value" id="institute_of_study_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td><?php $from = new DateTime($borrower_info['dob']);
                            $to   = new DateTime('today');
                            echo "Age- ". $from->diff($to)->y;
                          ?>, <?php echo "DOB- ". $borrower_info['dob'] ?></td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['age']; ?>" readonly name="age" id="age" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Occupation</td>
                        <td>

                            <select name="occupation" class="form-control onchangeclass" id="occupation">

                                <option value="">--Select--</option>
                                <option value="15" <?php if($borrower_info['occuption_id'] == 1)echo "selected";?>>Salaried</option>
                                <option value="18" <?php if($borrower_info['occuption_id'] == 2)echo "selected";?>>Self employed Business</option>
                                <option value="20" <?php if($borrower_info['occuption_id'] == 3)echo "selected";?>>Self Employed Professional</option>
                                <option value="8" <?php if($borrower_info['occuption_id'] == 4)echo "selected";?>>Retired</option>
                                <option value="0" <?php if($borrower_info['occuption_id'] == 5)echo "selected";?>>Student</option>
                                <option value="0" <?php if($borrower_info['occuption_id'] == 6)echo "selected";?>>Home Maker</option>
                                <option value="0" <?php if($borrower_info['occuption_id'] == 7)echo "selected";?>>Others</option>
                            </select>

                        </td>
                        <td>20</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['occupation']; ?>" readonly type="text" name="occupation_value" id="occupation_value" placeholder="Credit Opt. Score"></td>
                    </tr>
                    <tr>
                        <td>Experience

                        </td>
                        <td>
                            <?php if($borrower_info['occuption_id'] == 1 || $borrower_info['occuption_id'] == 4 ){  ?>
                            <select name="experience" class="form-control onchangeclass" id="experience">
                                <option value="">--Select--</option>
                                <option value="0" <?php if($saved_record['experience'] == 0)echo "selected";?>><1/<2</option>
                                <option value="1" <?php if($saved_record['experience'] == 1)echo "selected";?>>1-2/2-3</option>
                                <option value="2" <?php if($saved_record['experience'] == 2)echo "selected";?>>2-4/3-5</option>
                                <option value="3" <?php if($saved_record['experience'] == 3)echo "selected";?>>4-6/5-8</option>
                                <option value="4" <?php if($saved_record['experience'] == 4)echo "selected";?>>6-8/8-10</option>
                                <option value="4" <?php if($saved_record['experience'] == 4)echo "selected";?>>8-10/10-15</option>
                                <option value="5" <?php if($saved_record['experience'] == 5)echo "selected";?>>>10/>15</option>
                            </select>
                            <?php } else{?>
                            <select name="experience" class="form-control onchangeclass" id="experience">
                                <option value="">--Select--</option>
                                <option value="0" <?php if($saved_record['experience'] == 0)echo "selected";?>><1</option>
                                <option value="1" <?php if($saved_record['experience'] == 1)echo "selected";?>>1-2</option>
                                <option value="2" <?php if($saved_record['experience'] == 2)echo "selected";?>>2-4</option>
                                <option value="3" <?php if($saved_record['experience'] == 3)echo "selected";?>>4-6</option>
                                <option value="4" <?php if($saved_record['experience'] == 4)echo "selected";?>>6-8</option>
                                <option value="4" <?php if($saved_record['experience'] == 4)echo "selected";?>>8-10</option>
                                <option value="5" <?php if($saved_record['experience'] == 5)echo "selected";?>>>10</option>
                            </select>
                        <?php } ?>
                        </td>
                        <td>10</td>
                        <td></td>
                        <td></td>
                        <td><input class="form-control class-for-change" value="<?php echo $saved_record['experience']; ?>" readonly name="experience_value" id="experience_value" type="text" placeholder="Credit Opt. Score"></td>
                    </tr>
                </table>
                <table class="table table-bordered kyc-total">
                    <tr>
                        <td>Total Rating</td>
                        <td><input class="form-control" name="total_rating_value" id="total_rating_value" type="text" value="<?php unset($saved_record['id']);
                            unset($saved_record['borrower_id']);
                            unset($saved_record['experian_score']);
                            unset($saved_record['modified_date']);
                            unset($saved_record['created_date']); echo array_sum($saved_record)/26; ?>" readonly placeholder="Total Rating"></td>
                    </tr>
                </table>
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <input type="hidden" name="borrower_id" id="borrower_id" value="<?php echo $borrower_info['id']; ?>">
                <input type="submit" class="form-control" name="submit" id="submit" value="Update">
                </div>
			</div>
		</div>


	</div>
    </form>
