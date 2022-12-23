<div class="mytitle row">
		<div class="left col-md-6">
			<h1><?=$pageTitle;?></h1>
			<!--p>Please check below to your profile information.</p-->
		</div>
		<div class="col-md-6 text-right"><a href="http://192.168.1.19/p2pdevelopment/bidding/live-bids" class="btn btn-primary hidden" ><i class="fa fa-undo"></i> Back</a></div>
	</div>
	
	<div class="white-box prsnl-dtls">
     <h3 class="borrower-prof-hd"><i class="ti-user"></i> Profile Summary</h3>
		<div class="row">
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table bdr-rite">
							<tbody>
              <tr>
								<td>Borrower Name</td>
								<td><?php $fname = explode(' ',$borrower_info['Borrower_name']); echo ucfirst(strtolower($fname[0]))?></td>
							</tr>
                            <tr>
								<td>Employment</td>
								<td><?php echo $borrower_info['occuption_name']; ?></td>
							</tr>
							<tr>
								<td>Age</td>
								<td><?php echo $borrower_info['age']; ?> years</td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php if($borrower_info['gender'] == 1){echo "Male";}else if($borrower_info['gender'] == 2){echo "Female";} else{echo "Others";} ?></td>
							</tr>
							<tr>
								<td>Residence Type</td>
                                <td><?php echo $borrower_info['residence_name'] ?></td>
							</tr>
							<tr>
								<td>Marital Status</td>
								<td><?php if($borrower_info['gender'] == 1){echo "Married";}else{echo "Unmarried";} ?></td>
							</tr>
                    <tr>
                        <td>Education</td>
                        <td><?php echo $borrower_info['qualification']; ?></td>
                    </tr>
						</tbody>
           </table>
					</div>
				</div>
			</div>
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table">
							<tbody>
							<tr>
								<td>City</td>
								<td><?php echo $borrower_info['r_city']; ?></td>
							</tr>
							<tr>
								<td>State</td>
								<td><?php echo $borrower_info['state']; ?></td>
							</tr>
							<tr>
								<td>Salary</td>
								<td><?php echo $borrower_info['net_monthly_income']; ?></td>
							</tr>
                      <tr>
                         <td>Current EMI's</td>
                         <td><?php echo $borrower_info['current_emis']; ?></td>
                      </tr>
							<tr>
								<td>Purpose of Loan</td>
								<td>
									
										<?php echo $currentopen_proposal['loan_description']; ?>
									
								</td>
							</tr>
						</tbody>
           </table>
				   </div>
				</div>
			</div>
			<div class="col-md-3 hidden">
				<div class="strength-risk">
					<div class="strenght-area">
						<h3 class="title">
							Strengths <i class="fa fa-plus" aria-hidden="true"></i>
						</h3>
						<ul>
							<li>Parental House</li>
							<li>Business is registered</li>
							<li>Less number of enquiries</li>
							<li>Good average monthly balance</li>
						</ul>
					</div>
					<div class="strenght-area risk">
						<h3 class="title">
							Risk <i class="fa fa-minus" aria-hidden="true"></i>
						</h3>
						<ul>
							<li>High expenditure to income ratio</li>
							<li>Business premises is rented</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>


<?php if($rating){ ?>

<div class="white-box prsnl-dtls">
<h3 class="borrower-prof-hd"><i class="ti-user"></i> Credit Score Analysis</h3>
    <div class="row">
        <!--active loan-->
        <div class="col-md-6" style="padding-right: 0;">
		<div class="table-responsive">
            <table class="table credit-score-main tm15 table-bordered">
                <tr>
                    <th colspan="4" style="text-align: center !important;">Ongoing Loan</th>

                </tr>
                <tr>
                    <td></td>
                    <td>Bank Name</td>
                    <td>Type of loan</td>
                    <td>Outstanding</td>
                </tr>
                <?php $i = 1;
                foreach ($rating['ongoing_loan_list'] AS $ongoing_loan)
                   {?>
                    <tr>
                        <td>ACC<?= $i; ?></td>
                        <td><?= $ongoing_loan['bank_name'] ?></td>
                        <td><?= $ongoing_loan['loan_type'] ?></td>
                        <td style="text-align:center;"><?= $ongoing_loan['outstanding_balance'] ?></td>
                    </tr>
                    <?php $i++; } ?>
            </table>
        </div>
        </div>
        <!--close loan-->
        <div class="col-md-6" style="padding-left: 0;">
		<div class="table-responsive">
            <table class="table credit-score-main tm15 table-bordered">
                <tr>
                   <th colspan="4" style="text-align: center !important;">
                      Closed Loan
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td>Bank Name</td>
                    <td>Type of loan</td>
                    <td>Outstanding</td>
                </tr>
                <?php $i = 1;
                foreach ($rating['close_loan_list'] AS $close_loan)
                  {?>
                    <tr>
                        <td>ACC<?= $i; ?></td>
                        <td><?= $close_loan['bank_name'] ?></td>
                        <td><?= $close_loan['loan_type'] ?></td>
                        <td style="text-align:center;"><?= $close_loan['outstanding_balance'] ?></td>
                    </tr>
                    <?php $i++;}
                  ?>
            </table>
        </div>
        </div>
    </div>
	<div class="table-responsive">
<table class="table credit-score-main tm15 table-bordered" style="text-align: left !important;">
<tr>
  <th class="" style="text-align:center; min-width: 50px;">S No.</th>
  <th class="col-md-5" style="text-align:center;">PARTICULARS</th>
  <th class="col-md-1" style="text-align:center;">SCORE</th>
  <th class="col-md-6" style="text-align:center;">RATIO</th>
</tr>
<tr>
<td style="text-align: center;"></td>
<td></td>
<td></td>
<td>
<ul class="alertratio">
<li>Weak</li>
<li>Strong</li>
</ul>
</td>
</tr>
        <!--Leveraging Ratio-->
<tr>
    <td style="text-align: center;">1</td>
    <td>Leveraging Ratio**</td>
    <?php
      $overall_leveraging_ratio = $rating['overall_leveraging_ratio'];

      if($overall_leveraging_ratio < 3)
        {
         echo "<td><center>".$overall_leveraging_ratio."</center></td>";
        }
      else if($overall_leveraging_ratio == 3 )
        {
         echo "<td><center>".$overall_leveraging_ratio."</center></td>";
        }
      else if($overall_leveraging_ratio > 3)
        {
         echo "<td><center>".$overall_leveraging_ratio."</center></td>";
        }
     ?>
       
            <td>
                <div style="width:100%; float:right !important;">
                    <?php

                    if($overall_leveraging_ratio >= 0 && $overall_leveraging_ratio <= 1) 
                          {
                            echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                          }
                    else if($overall_leveraging_ratio > 1 && $overall_leveraging_ratio <= 2) 
                          {
                            echo '<div style="font-size:15px;text-align:right; width:77%;" aria-hidden="true">&#9660;</div>';
                          }
                    else if($overall_leveraging_ratio > 2 && $overall_leveraging_ratio <= 3) 
                          {
                            echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                          }
                    else if($overall_leveraging_ratio >  3 && $overall_leveraging_ratio <= 4) 
                         {
                            echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                          }
                  
                    else if($overall_leveraging_ratio > 4 )
                         {
                            echo '<div style="font-size:15px;text-align:right; width:12%;" aria-hidden="true">&#9660;</div>';
                         }
                    ?>
                    <div class="red" style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div class="green" style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>
                </div>
            </td>
        </tr>
      

        <tr>
            <td style="text-align: center;">2</td>
            <td>Outstanding to Limit</td>
            <?php

            $outstanding_to_limit_term_credit = $rating['outstanding_to_limit_term_credit'];

            echo "<td><center>" . $outstanding_to_limit_term_credit . "</center></td>";
            ?>

            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($outstanding_to_limit_term_credit == 0) 
                         {
                          echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                         }
                    if ($outstanding_to_limit_term_credit > 0 && $outstanding_to_limit_term_credit < 41) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                         }
                    if ($outstanding_to_limit_term_credit > 40 && $outstanding_to_limit_term_credit < 81) 
                         {
                          echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                         }
                    if ($outstanding_to_limit_term_credit > 80 && $outstanding_to_limit_term_credit < 91) 
                         {
                          echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                         }

                    if ($outstanding_to_limit_term_credit > 90)
                         {
                          echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                         }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: center;">3</td>
            <td>Fixed Obligation to Income</td>
            <?php
            $fixed_obligation_to_income = $rating['fixed_obligation_to_income'];

            echo "<td><center>" . $fixed_obligation_to_income . "</center></td>";

            ?>
        <td style="text-align: -webkit-auto;">
        <div style="width:100%; float:right !important;">
            <?php
                
                if ($fixed_obligation_to_income >= 0 && $fixed_obligation_to_income <= 25)
                        {
                         echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                        }

                else if ($fixed_obligation_to_income > 25 && $fixed_obligation_to_income <= 40) 
                        {
                            echo '<div style="font-size:15px;text-align:right; width:67%;" aria-hidden="true">&#9660;</div>';
                        }
                else if ($fixed_obligation_to_income > 40 && $fixed_obligation_to_income <= 60) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:45%;" aria-hidden="true">&#9660;</div>';
                        }
                else if ($fixed_obligation_to_income > 60 && $fixed_obligation_to_income <= 75) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:33%;" aria-hidden="true">&#9660;</div>';
                        }
                else if ($fixed_obligation_to_income > 75 && $fixed_obligation_to_income <= 90) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                        }
                else if ($fixed_obligation_to_income > 90) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:8%;" aria-hidden="true">&#9660;</div>';
                         }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>
        <!--no of active account-->
        <tr>
            <td style="text-align: center;">4</td>
            <td>No of Active Account</td>
            <td><center><?php $no_of_active_accounts =  $rating['no_of_active_accounts']; echo $no_of_active_accounts; ?></center></td>
            <td style="text-align: -webkit-auto;">
                <div class="scale-main">
            <?php
               if ($no_of_active_accounts >= 0 && $no_of_active_accounts <= 2) 
                       {
                            echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                       }
               else if ($no_of_active_accounts > 2 && 
                        $no_of_active_accounts <= 4) 
                        {
                            echo '<div style="font-size:15px;text-align:right; width:78%;" aria-hidden="true">&#9660;</div>';
                         }
               else if ($no_of_active_accounts > 4 && 
                        $no_of_active_accounts <= 6) 
                         {
                            echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                          }
               else if ($no_of_active_accounts > 6 && 
                       $no_of_active_accounts <= 10) 
                        {
                            echo '<div style="font-size:15px;text-align:right; width:36%;" aria-hidden="true">&#9660;</div>';
                        }
               else if ($no_of_active_accounts > 10 )
                        {
                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                        }

                  ?>
                                            
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>
        <!--Variety of Loans-->
        <tr>
            <td style="text-align: center;">5</td>
            <td colspan="3">Variety of Loans</td>
        </tr>
        <tr>
            <td style="text-align: center;">a.</td>
            <td>Variety of Loans (Active)</td>
            <?php
            $variety_of_loans_active = $rating['variety_of_loans_active'];

            echo "<td><center>" . $variety_of_loans_active . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                <?php
                if ($variety_of_loans_active >= 0 && $variety_of_loans_active <= 2)
                      {
                        echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                      }
                
                else if ($variety_of_loans_active > 2 && $variety_of_loans_active <= 5) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:65%;" aria-hidden="true">&#9660;</div>';
                      }
                else if ($variety_of_loans_active > 5 && $variety_of_loans_active <= 8) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                      }

                else if($variety_of_loans_active > 8) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                      }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

            <?php
            ?>
        </tr>
        <tr>
            <td style="text-align: center;">b.</td>
            <td>Variety of Loans (including Closed)</td>
            <?php
                $variety_of_loans_including_closed = $rating['variety_of_loans_including_closed'];
                echo "<td><center>" . $variety_of_loans_including_closed . "</center></td>";
            ?>

            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($variety_of_loans_including_closed == 0) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                        }
                    if ($variety_of_loans_including_closed > 0 && $variety_of_loans_including_closed <= 2) 
                         {
                          echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                         }
                    if ($variety_of_loans_including_closed > 2 && $variety_of_loans_including_closed <= 5) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                        }
                    if ($variety_of_loans_including_closed > 5 && $variety_of_loans_including_closed <= 8) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                        }
 
                    if ($variety_of_loans_including_closed > 8) 
                        {
                           echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                        }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                        
                    </div>

                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>

        <!--noof enquiry-->
        <tr>
            <td style="text-align: center;">6</td>
            <td>No of Credit Enquiry In last 3 Months</td>
            <?php $no_of_credit_enquiry_in_last_3_months = $rating['no_of_credit_enquiry_in_last_3_months']; ?>
            <td><center><?= $no_of_credit_enquiry_in_last_3_months ?></center></td>
            <td style="text-align: -webkit-auto;">
            <div style="width:100%; float:right !important;">
            <?php
            if ($no_of_credit_enquiry_in_last_3_months >= 0 && $no_of_credit_enquiry_in_last_3_months <= 1) 
                   {
                     echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                   }
           else if ($no_of_credit_enquiry_in_last_3_months > 1 && $no_of_credit_enquiry_in_last_3_months <= 2) 
                    {
                     echo '<div style="font-size:15px;text-align:right; width:78%;" aria-hidden="true">&#9660;</div>';
                    }
           else if ($no_of_credit_enquiry_in_last_3_months > 2 && $no_of_credit_enquiry_in_last_3_months <= 3) 
                     {
                        echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                     }

           else if ($no_of_credit_enquiry_in_last_3_months > 3 && $no_of_credit_enquiry_in_last_3_months <= 6) 
                    {
                        echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                    }

            else if ($no_of_credit_enquiry_in_last_3_months > 6 ) 
                      {
                         echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                    }

                    ?>
                 <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                 </div>
                 <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>
                </div>
            </td>

        </tr>

        <!--No. of Loans Availed to Credit Enquiry in last 12 months-->
        <tr>
            <td style="text-align: center;">7</td>
            <td>No. of Loans Availed to Credit Enquiry in last 12 months</td>
            <?php
            $no_of_loans_availed_to_credit_enquiry_in_last_12_months = $rating['no_of_loans_availed_to_credit_enquiry_in_last_12_months'];

            echo "<td><center>" . $no_of_loans_availed_to_credit_enquiry_in_last_12_months . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
            <div style="width:100%; float:right !important;">
            <?php
             
            if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months >= 0 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months <= 1) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                      }
            else if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months < 1.5) 
                       {
                         echo '<div style="font-size:15px;text-align:right; width:65%;" aria-hidden="true">&#9660;</div>';
                       }

        else if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1.5) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                      }

                    ?>
                <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                </div>
                <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                </div>

                </div>
            </td>

        </tr>

        <!-- History of credit (oldest credit account)-->
        <tr>
            <td style="text-align: center;">8</td>
            <td> History of credit (oldest credit account)</td>
            <?php
            $history_of_credit_oldest_credit_account = $rating['history_of_credit_oldest_credit_account'];


            echo "<td><center>" . $history_of_credit_oldest_credit_account . "
            </center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
              <div style="width:100%; float:right !important;">
                 <?php
                      
                if ($history_of_credit_oldest_credit_account >= 0 && $history_of_credit_oldest_credit_account <= 1) 
                       {
                            echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                       }
                else if ($history_of_credit_oldest_credit_account > 1 && $history_of_credit_oldest_credit_account <= 3) 
                         {
                            echo '<div style="font-size:15px;text-align:right; width:65%;" aria-hidden="true">&#9660;</div>';
                         }


                else if ($history_of_credit_oldest_credit_account > 3)
                        {
                           echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                        }

                   ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>

        <!-- Limit Breach-->
        <tr>
            <td style="text-align: center;">9</td>
            <td> Limit Breach</td>
            <?php
            $limit_breachach = $rating['limit_breach'];
            echo "<td><center>" . $limit_breachach . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                 <?php
                if ($limit_breach == 0) 
                        {

                            echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                        }

                else if ($limit_breach > 0 && $limit_breach <= 2) 
                       {
                            echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                        }


               else if ($limit_breach > 2 )
                     {

                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                     }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>
        <!-- Present Delay in Servicing-->
        <tr>
            <td style="text-align: center;">10</td>
            <td colspan="5">Present Delay in Servicing</td>
        </tr>
        <tr>
            <td style="text-align: center;">a.</td>
            <td> Overdue to Obligation</td>
            <?php
            $overdue_to_obligation = $rating['overdue_to_obligation'];

            echo "<td><center>" . $overdue_to_obligation . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($overdue_to_obligation == 0) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                       }

                    if ($overdue_to_obligation > 0 && $overdue_to_obligation <= 25) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                        }
                    if ($overdue_to_obligation > 25 && $overdue_to_obligation <= 50) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                       }
                    if ($overdue_to_obligation > 50 && $overdue_to_obligation <= 75) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                       }
                    if ($overdue_to_obligation > 75 && $overdue_to_obligation <= 100) 
                        {
                        echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                         }
                    if ($overdue_to_obligation > 100) 
                        {

                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                        }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>
        <tr>
            <td style="text-align: center;">b.</td>
            <td>Overdue to Monthly Income</td>
            <?php
            $overdue_to_monthly_income = $rating['overdue_to_monthly_income'];

            echo "<td><center>" . $overdue_to_monthly_income . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($overdue_to_monthly_income == 0)
                       {
                        echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                       }

                    if ($overdue_to_monthly_income > 0 && $overdue_to_monthly_income <= 25) 
                        {
                          echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                        }

                    if ($overdue_to_monthly_income > 25 && $overdue_to_monthly_income <= 50) 
                       {
                         echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                       }
                    if ($overdue_to_monthly_income > 50) 
                       {

                        echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                       }

                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>

        <!-- Past Delay in Servicing-->
        <tr>
            <td style="text-align: center;">11</td>
            <td colspan="3">Past Delay in Servicing</td>
        </tr>
        <tr>
            <td style="text-align: center;">a.</td>
            <td> Number of instances of delay in past 6 months</td>
            <?php
            $number_of_instances_of_delay_in_past_6_months = $rating['number_of_instances_of_delay_in_past_6_months'];
            echo "<td><center>" . $number_of_instances_of_delay_in_past_6_months . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($number_of_instances_of_delay_in_past_6_months == 0) 
                       {

                        echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                       }

                    if ($number_of_instances_of_delay_in_past_6_months > 0) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                       }
                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>
      
        <tr>
            <td style="text-align: center;">c.</td>
            <td> Number of instances of delay in past 36 months</td>
            <?php
            $number_of_instances_of_delay_in_past_36_months = $rating['number_of_instances_of_delay_in_past_36_months'];
            echo "<td><center>" . $number_of_instances_of_delay_in_past_36_months . "</center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($number_of_instances_of_delay_in_past_12_months == 0) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:85%;" aria-hidden="true">&#9660;</div>';
                      }

                    if ($number_of_instances_of_delay_in_past_12_months > 0) 
                      {
                        echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                      }
                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>


        <tr>
            <td style="text-align: center;">12</td>
            <td> Past instances of settlement/ write-off</td>
            <?php
            $past_instances_of_settlement_write_off = $rating['past_instances_of_settlement_write_off'];
            echo "<td><center>" . $past_instances_of_settlement_write_off . "
            </center></td>";

            ?>
            <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                    <?php
                    if ($past_instances_of_settlement_write_off == 0) 
                       {

                        echo '<div style="font-size:15px;text-align:right; width:85%;" aria-hidden="true">&#9660;</div>';
                       }

                    if ($past_instances_of_settlement_write_off > 0) 
                       {
                        echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                       }
                    ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;">
                    </div>

                </div>
            </td>

        </tr>

        <!--overdue date-->
        <tr>
            <td style="text-align: center;">13</td>
            <td colspan="3">Over Due Date's</td>
        </tr>

        <?php

        if($rating['over_due_dates']) foreach ($rating['over_due_dates'] AS $over_due_dates)
        {
            for($i = 0; $i<count($over_due_dates); $i++)
            {
                ?>
                <?php
                if($over_due_dates[$i]['Days_Past_Due'] == 0)
                   { 

                   }
                 else { ?>
                <tr>
                    <td></td>
                    <td> <?= $over_due_dates[$i]['bank_name']; ?>
                        (<?= $over_due_dates[$i]['Account_Number']; ?>
                        )
                    </td>
                    <td><center><?php if($over_due_dates[$i]['Days_Past_Due']){
                            echo $over_due_dates[$i]['Days_Past_Due'].' Days';
                        } else{
                            echo '0 Days';
                        } ?>
                    </center></td>

                <td style="text-align: -webkit-auto;">
                <div style="width:100%; float:right !important;">
                <?php
                if($over_due_dates[$i]['Days_Past_Due'] == 0) 
                        {
                            echo '<div style="font-size:15px;text-align:right; width:92%;" aria-hidden="true">&#9660;</div>';
                        }
                if($over_due_dates[$i]['Days_Past_Due'] > 0 && $over_due_dates[$i]['Days_Past_Due'] <= 30) 
                        {
                             echo '<div style="font-size:15px;text-align:right; width:45%;" aria-hidden="true">&#9660;</div>';
                        }
                 if($over_due_dates[$i]['Days_Past_Due'] > 30 && $over_due_dates[$i]['Days_Past_Due'] <= 60) 
                        {
                             echo '<div style="font-size:15px;text-align:right; width:32%;" aria-hidden="true">&#9660;</div>';
                        }
     
                 if($over_due_dates[$i]['Days_Past_Due'] > 60 && $over_due_dates[$i]['Days_Past_Due'] <= 90)  
                        {
                            echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                        }
                                                 
                if($over_due_dates[$i]['Days_Past_Due'] > 90) 
                        {
                            echo '<div style="font-size:15px;text-align:right; width:8%;" aria-hidden="true">&#9660;</div>';
                        }
                             
                     ?>
                    <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;">
                    </div>
                    <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                    </div>
                    </td>

                </tr>
            <?php } }
                  }
               ?>
    </table>
</div>
</div>
<?php }?>

<div class="white-box prsnl-dtls">

<h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>
    <div class="row">
        <ul class="documnt-verify">
            <?php foreach($kycDoctype AS $doctype){?>

                <li><i class="fa fa-check-square-o" aria-hidden="true"></i><?php echo str_replace('_', ' ', $doctype['docs_type']) ?></li>
            <?php } ?>
        </ul>
    </div>
    <?php
    error_reporting(0);
    ?>
</div>
	
	
	