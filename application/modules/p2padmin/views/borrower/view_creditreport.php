<?php
error_reporting(0);
 ?>
<style>

    .btn-credit{
        margin-bottom: 15px;
    }
    /* CIBIL Meter */
    /*Credit Scale */
    .scale-main, .arrow {width:100%; float:right !important;}
    .bad {background:#fe0000; border-radius: 4px 0px 0px 4px;}
    .average {background:#ffa101;}
    .good {background:#68bc0e;}
    .excellent {background:#008d53;}
    .bad, .average, .good, .excellent {width:25%; float:left; padding:2px 1px; color:#fff; font-size:11px; text-align:center;}
    .arrow i {font-size:24px;}
    .arrow-position {text-align:right; width:10%;}
    /*EndCredit Scale */
    .persnl-hd {
        width: 100%;
        float: left;
        /*background: linear-gradient( #f9f9f9 50%, #ededed 50%);*/
        background: linear-gradient( #00518c 50%, #034879 50%);
        padding: 7px 10px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
    }
    .persnl-main {
        border: 1px solid #ccc;
        margin-bottom: 15px;
        clear:both;
    }
    .tm15 {
        margin-top: 15px;
    }
    .credit-score-main>tbody>tr>th {
        background: linear-gradient( #f9f9f9 50%, #ededed 50%)!important;
        /*color: #fff !important;*/
    }
    .credit-score-main>tbody>tr>td {
        font-weight: 400;
    }
    .scor-hd {
        /*background: #00518c;*/
    }
    .scor-hd img {
        max-width: 200px;
        margin-top: 7px;
    }
    .scor-bdy {
        border: 1px solid #f2f2f2;
        padding-top: 15px;
    }
    .scor-top-hd h2 {
        color: #00518c;
        font-weight: 400;
        margin: 20px 0 0 0;
        font-size: 30px;
    }
    .scor-top-hd h2 span {
        color: #000;
        font-size: 16px;
        display: block;
        padding-bottom:10px;
    }
    .termss li {
        display:block;
        padding: 5px 0;
    }
    .termss li i {
        font-size: 12px;
        padding-right: 5px;
    }
    .report-dtls {
        text-align: right;
        color: #000;
    }
    .report-dtls p {
        margin-bottom: 0;
    }
    .report-dtls p:first-child {
        margin-top: 20px;
    }
    .credit-data-nm {
        display: block;
        margin: 7px 0;
        font-weight: bold;
        color: #797979;
    }
    .credit-data-nm span {
        display: inline-block;
        font-weight: 300;

    }
    .credit-data-rite {
        text-align: right;
    }
    .credit-data>tbody>tr>td {
        text-align: left;
    }
    .credit-data>tbody>tr>td:nth-child(2n+1) {
        color: #0070c0;
        font-weight: bold;
        width: 230px;
    }
    .credit-info li {
        display: inline-block;
        font-size: 14px;
        color: #000;
        padding: 0 10px;
        position: relative;
    }
    .credit-info li:before {
        position: absolute;
        background: #000;
        width: 2px;
        content: "";
        height: 10px;
        right: -3px;
        top: 5px;
    }
    .credit-info li:last-child:before {
        background: transparent;
    }
    .strip-good {
        border-left: 4px solid #008000;
        padding: 10px;
        background: #f9f9f9;
        font-size: 12px;
        color: #333;
    }
    .strip-bad {
        border-left: 4px solid #ff2200;
        padding: 10px;
        background: #f9f9f9;
        font-size: 12px;
        color: #333;
    }

</style>
<style>


</style>
<?=getNotificationHtml();
?>
<div class="row"><br>

 <div class="col-md-12">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 ">
                            </div>
                            <div class="col-md-6 ">
                                <h2 class="points"><?= $rating['experian_score']; ?></h2>
                                <div class="chart-gauge" id="for_image"></div>
                            </div>

                        </div>
                        <div class="col-md-12 scor-hd">
                            <div class="row scor-top-hd text-center">
                                <h2>
                                    Borrower Name- <?= $rating['experian_user_first_name']. ' '. $rating['experian_user_last_name'] ; ?>
                                    <!--span>Your Records Are:</span></h2-->
                                </h2>
                                <ul class="credit-info">
                                    <li>Created Date: <?= $rating['created_date']; ?> </li>
                                    <li>Unique Transaction ID: <?= $rating['order_id']; ?> </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12 scor-bdy">




                            <div class="col-md-12 credit-data" style="text-align: left !important;">
                                <!--personal detail-->
                                <div class="row persnl-main">
                                    <div class="col-md-12 persnl-hd">
                                        Personal Details
                                    </div>



                                        <div class="col-md-6">
                                            <div class="credit-data-nm">Age
                                                : <span><?php
                                                    echo $rating['age'] . ' years'; ?></span></div>
                                        </div>


                                    <div class="col-md-6 credit-data-rite">
                                        <div class="credit-data-nm">Monthly Income :
                                            <span>INR. <?= $rating['monthly_income']; ?></span></div>
                                        <div class="credit-data-nm"> Leveraging Ratio :
                                            <?php
                                            $overall_leveraging_ratio = $rating['overall_leveraging_ratio'];
                                            if ($overall_leveraging_ratio < 10) {
                                                echo "<td><span style='color:#008000;'>" . $overall_leveraging_ratio . "</span></td>";
                                            } else if ($overall_leveraging_ratio == 10) {
                                                echo "<td><span style='color:#ffbf00;'>" . $overall_leveraging_ratio . "</span></td>";
                                            } else if ($overall_leveraging_ratio > 10) {
                                                echo "<td><span style='color:#FF0000;'>" . $overall_leveraging_ratio . "</span></td>";
                                            }
                                            ?>
                                        </div>

                                        <div class="credit-data-nm">No. of Active Loan Account :
                                            <span><?= $rating['no_of_active_accounts']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--loan Details for Verification Purpose-->
                            <div class="col-md-12 persnl-main">
                                <div class="row">
                                    <div class="persnl-hd">
                                        Loan Details for Verification Purpose*
                                    </div>
                                </div>
                                <div class="row">
                                    <!--active loan-->
                                    <div class="col-md-6" style="padding-right: 0;">
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
                                                 <td><?= $ongoing_loan['outstanding_balance'] ?></td>
                                             </tr>
                                            <?php $i++;}
                                            ?>
                                        </table>
                                    </div>
                                    <!--close loan-->
                                    <div class="col-md-6" style="padding-left: 0;">
                                        <table class="table credit-score-main tm15 table-bordered">
                                            <tr>

                                                <th colspan="4" style="text-align: center !important;">Closed Loan</th>
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
                                                    <td><?= $close_loan['outstanding_balance'] ?></td>
                                                </tr>
                                                <?php $i++;}
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Borrower Applications Address Details -->
                            <div class="col-md-12 persnl-main">
                                <div class="row">
                                    <div class="persnl-hd">
                                        Loan Details for Verification Purpose*
                                    </div>
                                </div>
                                <div class="row">
                                    <!--active loan-->
                                    <div class="col-md-6" style="padding-right: 0;">
                                        <table class="table credit-score-main tm15 table-bordered">
                                            <tr>
                                                <th colspan="4" style="text-align: center !important;">List Of Address</th>

                                            </tr>
                                            <tr>
                                                <td></td>

                                                <td>Address</td>
                                            </tr>
                                            <?php $i = 1;
                                            foreach ($rating['applications_address_list'] AS $applications_address_list)
                                            {?>
                                                <tr>
                                                    <td>ACC<?= $i; ?></td>
                                                    <td><?= $applications_address_list; ?></td>
                                                </tr>
                                                <?php $i++;}
                                            ?>
                                        </table>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0;">
                                        <table class="table credit-score-main tm15 table-bordered">
                                            <tr>
                                                <th colspan="4" style="text-align: center !important;">List Of Mobile No</th>

                                            </tr>
                                            <tr>
                                                <td></td>

                                                <td>Mobile</td>
                                            </tr>
                                            <?php $i = 1;
                                            foreach ($rating['phone_list'] AS $phone_list)
                                            {?>
                                                <tr>
                                                    <td>ACC<?= $i; ?></td>
                                                    <td><?= $phone_list; ?></td>
                                                </tr>
                                                <?php $i++;}
                                            ?>
                                        </table>
                                    </div>
                                    <!--close loan-->
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row text-right">
                                                <button class="btn btn-danger btn-credit" type="button"
                                                        data-toggle="collapse" data-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                    Click Here If You Noticed an Error
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="collapse" id="collapseExample">
                                                    <div class="well">
                                                        <h3>Here's How To Fix An Error In Your Report</h3>

                                                        <p>If you have questions regarding your Credit Report, please
                                                            direct your concerns and queries to Experian Credit
                                                            Information Company of India Private Limited (Experian)
                                                            within 15 days of receiving your report.</p>
                                                        <h4>Contact Details</h4>

                                                        <p><strong>Email:</strong> consumer.support@in.experian.com</p>

                                                        <p><strong>Phone:</strong> 022 6641 9000</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Borrower Applications Address Details -->

                            <!--Credit Score Analysis-->
                            <div class="col-md-12 persnl-main">
                                <div class="row">
                                    <div class="persnl-hd">
                                        Credit Score Analysis
                                    </div>
                                </div>
                                <table class="table credit-score-main tm15 table-bordered"
                                       style="text-align: left !important;">
                                    <tr>
                                        <th class="col-md-2" style="text-align:center;">S No.</th>
                                        <th class="col-md-2" style="text-align:center;">PARTICULARS</th>
                                        <th class="col-md-2" style="text-align:center;">SCORE</th>
                                        <th class="col-md-3" style="text-align: center;">SUGGESTED RANGE</th>
                                        <th class="col-md-4" style="text-align: center;">SUGGESTION</th>
                                    </tr>
                                    <!--value of L15-->


                                    <!--Leveraging Ratio-->
                                    <tr>
                                        <td style="text-align: center;">1</td>
                                        <td colspan="4">Leveraging Ratio**</td>
                                    </tr>
                                    <tr><td style="text-align: center;">a.</td><td>Overall Leveraging Ratio</td>
                                        <?php
                                        $overall_leveraging_ratio = $rating['overall_leveraging_ratio'];

                                        if($overall_leveraging_ratio < 3)
                                        {
                                            echo "<td><span style='color:#008000;'>".$overall_leveraging_ratio."</span></td>";
                                        }
                                        else if($overall_leveraging_ratio == 3 )
                                        {
                                            echo "<td><span style='color:#ffbf00;'>".$overall_leveraging_ratio."</span></td>";
                                        }
                                        else if($overall_leveraging_ratio > 3)
                                        {
                                            echo "<td><span style='color:#FF0000;'>".$overall_leveraging_ratio."</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php

                                                if($overall_leveraging_ratio == 0 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio > 0 && $overall_leveraging_ratio <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:90%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio > 1 && $overall_leveraging_ratio <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio > 2 && $overall_leveraging_ratio <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio >  3 && $overall_leveraging_ratio <= 4) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio > 4 && $overall_leveraging_ratio <= 5) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($overall_leveraging_ratio > 5 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                                            </div>
                                        </td>
                                        <td style='border:none !important;'></td>

                                    </tr>
                                    <tr><td style="text-align: center;">b.</td><td>Leverage Ratio (maximum available credit)</td>
                                        <?php
                                        $leverage_ratio_maximum_available_credit = $rating['leverage_ratio_maximum_available_credit'];

                                        if($leverage_ratio_maximum_available_credit < 3)
                                        {
                                            echo "<td><span style='color:#008000;'>".round($leverage_ratio_maximum_available_credit,2)."</span></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit == 3 )
                                        {
                                            echo "<td><span style='color:#ffbf00;'>".round($leverage_ratio_maximum_available_credit,2)."</span></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit > 3)
                                        {
                                            echo "<td><span style='color:#FF0000;'>".round($leverage_ratio_maximum_available_credit,2)."</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php

                                                if($leverage_ratio_maximum_available_credit == 0 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit > 0 && $leverage_ratio_maximum_available_credit <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:90%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit > 1 && $leverage_ratio_maximum_available_credit <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit > 2 && $leverage_ratio_maximum_available_credit <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit >  3 && $leverage_ratio_maximum_available_credit <= 4) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit > 4 && $leverage_ratio_maximum_available_credit <= 5) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if($leverage_ratio_maximum_available_credit > 5 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                                            </div>
                                        </td>
                                        <?php
                                        if($leverage_ratio_maximum_available_credit >= 0 &&  $leverage_ratio_maximum_available_credit <= 1)
                                        {
                                            echo "<td style='border:none ;'><p class='strip-good'style='margin-top:-50px;'>Excellent. Your credit availment is low.</p></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit > 1  && $leverage_ratio_maximum_available_credit <= 2)
                                        {
                                            echo "<td style='border:none;'><p class='strip-good'style='margin-top:-50px;'>Great. Your Credit availment is within reasonable limits. Keep your credit mix prudent.</p></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit > 2  && $leverage_ratio_maximum_available_credit <= 3)
                                        {
                                            echo "<td style='border:none !important;'><p class='strip-good' style='margin-top:-50px;'>Good. Your overall credit limit is still within limit. Keep a check on further borrowings (borrow only if necessary). Keep your credit mix prudent with more long term facilities.</p></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit > 3  && $leverage_ratio_maximum_available_credit <= 4)
                                        {
                                            echo "<td style='border:none;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have exceeded the prudent leveraging limit. It is advised not to avail further credit and borrow only if extremely essential. Try to remain on time with repayment obligations and over time the ratio would improve to prudent level.</p></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit > 4)
                                        {
                                            echo "<td style='border:none; '><p class='strip-bad'style='margin-top:-50px;'>Caution. You have exceeded the prudent leveraging limit. Borrow only if extremely essential. Reduce discretionary spending to bring down utilization of revolving credit lines and prepay short term loans to bring down indebtedness. Try to remain on time with repayment obligations and over time </p></td>";
                                        }
                                        else if($leverage_ratio_maximum_available_credit < 3 && $leverage_ratio_maximum_available_credit > 3)
                                        {
                                            echo "<td style='border:none;'><p class='strip-bad'style='margin-top:-50px;'>You have additional revolving credit line available. Restrained utilization of the same is advised in order to remain within prudent leverage ratio.</p></td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--Limit Utilization-->
                                    <tr>
                                        <td style="text-align: center;">2.</td>
                                        <td>Limit Utilization</td>
                                        <?php
                                        $limit_utilization_revolving_credit = $rating['limit_utilization_revolving_credit'];

                                        echo "<td>" . $limit_utilization_revolving_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($limit_utilization_revolving_credit == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 0 && $limit_utilization_revolving_credit < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 10 && $limit_utilization_revolving_credit < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 25 && $limit_utilization_revolving_credit < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 50 && $limit_utilization_revolving_credit < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 75 && $limit_utilization_revolving_credit < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($limit_utilization_revolving_credit > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($limit_utilization_revolving_credit >= 0 && $limit_utilization_revolving_credit < 11) {
                                            echo "<td><p class='strip-good'>you are advised to avail revolving credit line like credit card and make prompt payment for further improvement of score</p></td>";
                                        } else if ($limit_utilization_revolving_credit > 10 && $limit_utilization_revolving_credit < 26) {
                                            echo "<td><p class='strip-good'>Excellent. You have optimum revolving limit available and most prudent limit utilization.</p></td>";
                                        } else if ($limit_utilization_revolving_credit > 25 && $limit_utilization_revolving_credit < 51) {
                                            echo "<td><p class='strip-good'>Good. You have adequate revolving limit available.</p></td>";
                                        } else if ($limit_utilization_revolving_credit > 50 && $limit_utilization_revolving_credit < 76) {
                                            echo "<td><p class='strip-bad'>Alert. You have utilized a substantial part of your revolving credit line.  You may accept limit enhancement in revolving credit facilities like credit card or overdraft (as and when available).</p></td>";
                                        } else if ($limit_utilization_revolving_credit > 75 && $limit_utilization_revolving_credit < 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. It is advised to reduce utilization ratio for better credit profile. You may also avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
                                        } else if ($limit_utilization_revolving_credit > 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. You have very little credit line available for contingency. It is recommended that you avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility). It is advised to apply restraint on discretionary spending. and reduce credit utilization ratio for better credit. </p></td>";
                                        }
                                        ?>
                                    </tr>

                                    <tr>
                                        <td style="text-align: center;">3</td>
                                        <td colspan="4">Outstanding to Limit</td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: center;">a.</td>
                                        <td>Outstanding to Limit(Term Credit)</td>
                                        <?php

                                        $outstanding_to_limit_term_credit = $rating['outstanding_to_limit_term_credit'];

                                        echo "<td>" . $outstanding_to_limit_term_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($outstanding_to_limit_term_credit == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit > 0 && $outstanding_to_limit_term_credit < 41) {

                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit > 40 && $outstanding_to_limit_term_credit < 81) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit > 80 && $outstanding_to_limit_term_credit < 91) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($outstanding_to_limit_term_credit > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Outstanding to Limit(Term Credit including past facilities)</td>
                                        <?php

                                        $outstanding_to_limit_term_credit_including_past_facilities = $rating['outstanding_to_limit_term_credit_including_past_facilities'];


                                        echo "<td>" . $outstanding_to_limit_term_credit_including_past_facilities . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($outstanding_to_limit_term_credit_including_past_facilities == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 0 && $outstanding_to_limit_term_credit_including_past_facilities < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 10 && $outstanding_to_limit_term_credit_including_past_facilities < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 25 && $outstanding_to_limit_term_credit_including_past_facilities < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 50 && $outstanding_to_limit_term_credit_including_past_facilities < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 75 && $outstanding_to_limit_term_credit_including_past_facilities < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($outstanding_to_limit_term_credit_including_past_facilities > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($outstanding_to_limit_term_credit >= 0 && $outstanding_to_limit_term_credit < 41) {
                                            $comment1 = 'Excellent. You have repaid substantial part of your term obligations. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile..';
                                            $full = $comment1.$comment2;
                                            $outstanding_to_limit_term_credit_including_past_facilities < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";

                                        } else if ($outstanding_to_limit_term_credit > 40 && $outstanding_to_limit_term_credit < 81) {
                                            $comment1 = 'Good. You have repaid a part of your term obligations. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile..';
                                            $full = $comment1.$comment2;
                                            $outstanding_to_limit_term_credit_including_past_facilities < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        } else if ($outstanding_to_limit_term_credit > 80 && $outstanding_to_limit_term_credit < 91) {
                                            $comment1 = 'Your present term debt obligations are relatively new. Maintain regular servicing for improved credit profile';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile.';
                                            $full = $comment1.$comment2;
                                            $outstanding_to_limit_term_credit_including_past_facilities < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        } else if ($outstanding_to_limit_term_credit > 90) {
                                            $comment1 = 'Your present term debt obligations are relatively new. There is minimal reduction in loan principal outstanding till this point. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile.';
                                            $full = $comment1.$comment2;
                                            $outstanding_to_limit_term_credit_including_past_facilities < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        }

                                        ?>
                                    </tr>
                                    <!--Short term Leveraging-->
                                    <tr>
                                        <td style="text-align: center;">4.</td>
                                        <td>Short term Leveraging***</td>
                                        <?php
                                        $short_term_leveraging = $rating['short_term_leveraging'];
                                        if ($short_term_leveraging < 1) {
                                            echo "<td><span style='color:#008000;'>" . $short_term_leveraging . "</span></td>";
                                        } else if ($short_term_leveraging == 1) {
                                            echo "<td><span style='color:#ffbf00;'>" . $short_term_leveraging . "</span></td>";
                                        } else if ($short_term_leveraging > 1) {
                                            echo "<td><span style='color:#FF0000;'>" . $short_term_leveraging . "</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                switch ($short_term_leveraging) {
                                                    case "0":
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';

                                                        break;
                                                    case "1":
                                                        echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "2":
                                                        echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "3":
                                                        echo '<div style="font-size:15px;text-align:right; width:49%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "4":
                                                        echo '<div style="font-size:15px;text-align:right; width:48%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "5":
                                                        echo '<div style="font-size:15px;text-align:right; width:46%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "06":
                                                        echo '<div style="font-size:15px;text-align:right; width:44%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "07":
                                                        echo '<div style="font-size:15px;text-align:right; width:42%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "08":
                                                        echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "09":
                                                        echo '<div style="font-size:15px;text-align:right; width:28%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "10":
                                                        echo '<div style="font-size:15px;text-align:right; width:26%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "11":
                                                        echo '<div style="font-size:15px;text-align:right; width:24%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "12":
                                                        echo '<div style="font-size:15px;text-align:right; width:22%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "13":
                                                        echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "14":
                                                        echo '<div style="font-size:15px;text-align:right; width:18%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "15":
                                                        echo '<div style="font-size:15px;text-align:right; width:16%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "16":
                                                        echo '<div style="font-size:15px;text-align:right; width:14%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "17":
                                                        echo '<div style="font-size:15px;text-align:right; width:12%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "18":
                                                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "19":
                                                        echo '<div style="font-size:15px;text-align:right; width:6%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "20":
                                                        echo '<div style="font-size:15px;text-align:right; width:0%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    default:
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($short_term_leveraging < 1) {
                                            echo "<td><p class='strip-good'>Great! You are within the suggested range please do not cross the max limit. We advise you to stay within the suggest range to maintain a healthy credit score.</p></td>";
                                        } else if ($short_term_leveraging == 1) {
                                            echo "<td><p class='strip-bad'>Alert! You have reached the maximum limit of suggested range. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        } else if ($short_term_leveraging > 1) {
                                            echo "<td><p class='strip-bad'>Alert! You have crossed the maximum limit of suggested range which is affecting your credit score. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--Credit Mix 1-->
                                    <tr>
                                        <td style="text-align: center;">5</td>
                                        <td colspan="4">Credit Mix 1</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td>Revolving Credit line to Total Credit</td>
                                        <?php
                                        $revolving_credit_line_to_total_credit = $rating['revolving_credit_line_to_total_credit'];


                                        echo "<td>" . $revolving_credit_line_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;">

                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Term Credit to Total Credit</td>
                                        <?php
                                        $term_credit_to_total_credit = $rating['term_credit_to_total_credit'];
                                        echo "<td>" . $term_credit_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;border-top: none;">

                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td>Available Revolving line to Total Credit</td>
                                        <?php
                                        $available_revolving_line_to_total_credit = $rating['available_revolving_line_to_total_credit'];
                                        echo "<td>" . $available_revolving_line_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top:none ;"><div style='margin-top:-80px;'>
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                
                                                if ($revolving_credit_line_to_total_credit == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 0 && $revolving_credit_line_to_total_credit < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 10 && $revolving_credit_line_to_total_credit < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 25 && $revolving_credit_line_to_total_credit < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 50 && $revolving_credit_line_to_total_credit < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 75 && $revolving_credit_line_to_total_credit < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($revolving_credit_line_to_total_credit > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                            </div>
                                            </td>
                                        <?php


                                        if ($revolving_credit_line_to_total_credit >= 0 && $revolving_credit_line_to_total_credit < 11 ) {
                                            $comment1 = 'Alert. You have very low proportion of revolving credit line. You may obtain enhancement in credit limits of credit card or overdraft or explore new revolving facility limit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";

                                        }
                                        else if ($revolving_credit_line_to_total_credit > 10 && $revolving_credit_line_to_total_credit < 26) {
                                            $comment1 = 'You have low proportion of revolving credit line. You may accept enhancement in credit limits of credit card or overdraft (as and when available).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if ($revolving_credit_line_to_total_credit > 25 && $revolving_credit_line_to_total_credit < 51) {
                                            $comment1 = 'Great. You have appropriate mix of revolving line and term credit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if ($revolving_credit_line_to_total_credit > 50 && $revolving_credit_line_to_total_credit < 76) {
                                            $comment1 = 'Good. You have reasonable mix of revolving line and term credit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if ($revolving_credit_line_to_total_credit > 75 && $revolving_credit_line_to_total_credit <= 100) {
                                            $comment1 = 'Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if ($revolving_credit_line_to_total_credit > 100) {

                                            $comment1 = 'Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            $available_revolving_line_to_total_credit <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>".$comment."</p></td>";
                                        }
                                        if ($available_revolving_line_to_total_credit <= 5) {
                                            //echo "<td>You have low unexhausted revolving credit limit left for contingencies.</td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--Credit Mix 2-->
                                    <tr>
                                        <td style="text-align: center;">6</td>
                                        <td colspan="4">Credit Mix 2</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td>Short Term Credit to Total Credit</td>
                                        <?php
                                        $short_term_credit_to_total_credit = $rating['short_term_credit_to_total_credit'];

                                        echo "<td>" . $short_term_credit_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;">

                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Medium Term Credit to Total Credit</td>
                                        <?php
                                        $medium_term_credit_to_total_credit = $rating['medium_term_credit_to_total_credit'];
                                        echo "<td>" . $medium_term_credit_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;border-top:none ;">

                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td>Long Term Credit to Total Credit</td>
                                        <?php

                                        $long_term_credit_to_total_credit = $rating['long_term_credit_to_total_credit'];

                                        echo "<td>" . $long_term_credit_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top:none;">
                                           <div style='margin-top:-80px;'>
                                                <div style="width:100%; float:right !important;">
                                                    <?php
                                                    if ($short_term_credit_to_total_credit == 0) {

                                                        echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                    }
                                                    if ($short_term_credit_to_total_credit > 0 && $short_term_credit_to_total_credit <= 25) {

                                                        echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                    }
                                                    if ($short_term_credit_to_total_credit > 25 && $short_term_credit_to_total_credit <= 50) {
                                                        echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                    }
                                                    if ($short_term_credit_to_total_credit > 50 && $short_term_credit_to_total_credit < 75) {
                                                        echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                    }
                                                    if ($short_term_credit_to_total_credit > 75 && $short_term_credit_to_total_credit <= 100) {
                                                        echo '<div style="font-size:15px;text-align:right; width:45%;" aria-hidden="true">&#9660;</div>';
                                                    }
                                                    ?>
                                                    <div
                                                        style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                    <div
                                                        style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                                    </div>
                                            </div>
                                        </td>
                                        <?php

                                       if ($short_term_credit_to_total_credit >= 0 && $short_term_credit_to_total_credit <= 25) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>You have low proportion of short/ medium term credit line.</p></td>";
                                        } else if ($short_term_credit_to_total_credit > 25 && $short_term_credit_to_total_credit <= 50) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Great. You have appropriate mix of short/ medium term and long term credit.</p></td>";
                                        } else if ($short_term_credit_to_total_credit > 50 && $short_term_credit_to_total_credit <= 75) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Good. You have reasonable mix of revolving line and term credit.</p></td>";
                                        } else if ($short_term_credit_to_total_credit > 75 && $short_term_credit_to_total_credit <= 100) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Alert. You have high proportion of short/ medium term credit. It is advised that future credit lines (whenever availed) should ideally have longer tenors.</p></td>";
                                        }


                                        ?>

                                    </tr>
                                    <!--Credit Mix 3-->
                                    <tr>
                                        <td style="text-align: center;">7</td>
                                        <td colspan="4">Credit Mix 3</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td>Secured Facilities to Total Credit</td>
                                        <?php
                                        $secured_facilities_to_total_credit = $rating['secured_facilities_to_total_credit'];

                                        echo "<td>" . $secured_facilities_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom: none; ">

                                        </td>
                                        <td style="border:none;"></td>

                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Unsecured Facilities to Total Credit</td>
                                        <?php

                                        $unsecured_facilities_to_total_credit = $rating['unsecured_facilities_to_total_credit'];

                                        echo "<td>" . $unsecured_facilities_to_total_credit . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top: none;"><div style='margin-top:-50px;'>
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($secured_facilities_to_total_credit == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($secured_facilities_to_total_credit > 0 && $secured_facilities_to_total_credit <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($secured_facilities_to_total_credit > 25 && $secured_facilities_to_total_credit <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($secured_facilities_to_total_credit > 50 && $secured_facilities_to_total_credit < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($secured_facilities_to_total_credit > 75 && $secured_facilities_to_total_credit < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($secured_facilities_to_total_credit > 100) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                       </div> </td>
                                        <?php

                                        if ($secured_facilities_to_total_credit >= 0 && $secured_facilities_to_total_credit <= 25) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have low proportion of secured credit line.</p></td>";
                                        } else if ($secured_facilities_to_total_credit > 25 && $secured_facilities_to_total_credit <= 50) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have reasonable mix of secured and unsecured credit.</p></td>";
                                        } else if ($secured_facilities_to_total_credit > 50 && $secured_facilities_to_total_credit <= 75) {
                                            echo "<td style='border:none ;'><p class='strip-good'style='margin-top:-50px;'>Great. You have appropriate mix of secured and unsecured credit.</p></td>";
                                        } else if ($secured_facilities_to_total_credit > 75 && $secured_facilities_to_total_credit < 100) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have low proportion of unsecured credit line.</p></td>";
                                        }


                                        ?>
                                    </tr>
                                    <!--Fixed Obligation to Income-->

                                    <tr>
                                        <td style="text-align: center;">8</td>
                                        <td>Fixed Obligation to Income</td>
                                        <?php
                                       $fixed_obligation_to_income = $rating['fixed_obligation_to_income'];

                                        echo "<td>" . $fixed_obligation_to_income . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($fixed_obligation_to_income == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 0 && $fixed_obligation_to_income <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 25 && $fixed_obligation_to_income <= 40) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 40 && $fixed_obligation_to_income <= 60) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 60 && $fixed_obligation_to_income <= 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 75 && $fixed_obligation_to_income <= 90) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($fixed_obligation_to_income > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($fixed_obligation_to_income > 0 && $fixed_obligation_to_income <= 25) {
                                            echo "<td><p class='strip-good'>Excellent. You have very prudent debt servicing capability.</p></td>";
                                        } else if ($fixed_obligation_to_income > 25 && $fixed_obligation_to_income <= 40) {
                                            echo "<td><p class='strip-good'>Great. You reasonable metrics debt servicing capability.</p></td>";
                                        } else if ($fixed_obligation_to_income > 40 && $fixed_obligation_to_income <= 60) {
                                            echo "<td><p class='strip-bad'>Alert. You are reaching the outer limits of prudent debt servicing capability.</p></td>";
                                        } else if ($fixed_obligation_to_income > 60 && $fixed_obligation_to_income <= 75) {
                                            echo "<td><p class='strip-bad'>Alert. You have high debt servicing obligations. Abstain from new term credit if not necessary.</p></td>";
                                        } else if ($fixed_obligation_to_income > 75 && $fixed_obligation_to_income <= 90) {
                                            echo "<td><p class='strip-bad'>Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
                                        } else if ($fixed_obligation_to_income > 100) {
                                            echo "<td><p class='strip-bad'>Alert. You have very high debt servicing obligations. Abstain from new term credit if not absolutely necessary. Reduce discretionary spending in order to retire.</p> </td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--no of active account-->
                                    <tr>
                                        <td style="text-align: center;">9</td>
                                        <td>No of Active Account</td>
                                        <td><?php $no_of_active_accounts =  $rating['no_of_active_accounts']; echo $no_of_active_accounts; ?></td>
                                        <td style="text-align: -webkit-auto;">
                                            <div class="scale-main">
                                                <?php
                                                switch ($no_of_active_accounts) {
                                                    case "0":
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';

                                                        break;
                                                    case "1":
                                                        echo '<div style="font-size:15px;text-align:right; width:95%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "2":
                                                        echo '<div style="font-size:15px;text-align:right; width:85%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "3":
                                                        echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "4":
                                                        echo '<div style="font-size:15px;text-align:right; width:65%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "5":
                                                        echo '<div style="font-size:15px;text-align:right; width:55%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "06":
                                                        echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "07":
                                                        echo '<div style="font-size:15px;text-align:right; width:45%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "08":
                                                        echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "09":
                                                        echo '<div style="font-size:15px;text-align:right; width:28%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "10":
                                                        echo '<div style="font-size:15px;text-align:right; width:26%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "11":
                                                        echo '<div style="font-size:15px;text-align:right; width:24%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "12":
                                                        echo '<div style="font-size:15px;text-align:right; width:22%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "13":
                                                        echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "14":
                                                        echo '<div style="font-size:15px;text-align:right; width:18%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "15":
                                                        echo '<div style="font-size:15px;text-align:right; width:16%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "16":
                                                        echo '<div style="font-size:15px;text-align:right; width:14%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "17":
                                                        echo '<div style="font-size:15px;text-align:right; width:12%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "18":
                                                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "19":
                                                        echo '<div style="font-size:15px;text-align:right; width:6%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "20":
                                                        echo '<div style="font-size:15px;text-align:right; width:0%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    default:
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>

                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        $activeac = $result_array['CAIS_Account']['CAIS_Summary']['Credit_Account']['CreditAccountActive'];
                                        if ($no_of_active_accounts < 6) {
                                            echo "<td><p class='strip-good'>Great! You are within the suggested range please do not cross the max limit. We advise you to stay within the suggest range to maintain a healthy credit score.</p></td>";
                                        } else if ($no_of_active_accounts == 6) {
                                            echo "<td><p class='strip-bad'>Alert! You have reached the maximum limit of suggested range. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        } else if ($no_of_active_accounts > 6) {
                                            echo "<td><p class='strip-bad'>Alert! You have crossed the maximum limit of suggested range which is affecting your credit score. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--Variety of Loans-->
                                    <tr>
                                        <td style="text-align: center;">10</td>
                                        <td colspan="4">Variety of Loans</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td>Variety of Loans (Active)</td>
                                        <?php
                                        $variety_of_loans_active = $rating['variety_of_loans_active'];

                                        echo "<td>" . $variety_of_loans_active . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($variety_of_loans_active == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_active > 0 && $variety_of_loans_active <= 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_active > 2 && $variety_of_loans_active <= 5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_active > 5 && $variety_of_loans_active <= 8) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($variety_of_loans_active > 8) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                  <td style="border:none;"></td>
                                        <?php
                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Variety of Loans (including Closed)</td>
                                        <?php
                                        $variety_of_loans_including_closed = $rating['variety_of_loans_including_closed'];

                                        echo "<td>" . $variety_of_loans_including_closed . "</td>";


                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($variety_of_loans_including_closed == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_including_closed > 0 && $variety_of_loans_including_closed <= 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_including_closed > 2 && $variety_of_loans_including_closed <= 5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($variety_of_loans_including_closed > 5 && $variety_of_loans_including_closed <= 8) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($variety_of_loans_including_closed > 8) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php

                                        if ($variety_of_loans_active >= 0 && $variety_of_loans_active <= 2) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Great. You are within limit. However, you have availed fewer types of credit and thus credit concentration is not diversified. You may avail different types of credit (according to your requirement) in order to improve your credit profile further.</p></td>";
                                        } else if ($variety_of_loans_active > 2 && $variety_of_loans_active <= 5) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Excellent. Your credit portfolio is aptly diversified with different types of credit.</p></td>";
                                        } else if ($variety_of_loans_active > 5 && $variety_of_loans_active <= 8) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have availed different types of credit exceeding the prudent practice.</p></td>";
                                        } else if ($variety_of_loans_active > 8) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have availed too many types of loans which signifies eagerness to credit. It is advised to reduce the credit products within prudent range.</p></td>";
                                        }

                                        ?>
                                    </tr>

                                    <!--noof enquiry-->
                                    <tr>
                                        <td style="text-align: center;">11</td>
                                        <td>No of Credit Enquiry In last 3 Months</td>
                                        <?php $no_of_credit_enquiry_in_last_3_months = $rating['no_of_credit_enquiry_in_last_3_months']; ?>
                                        <td><?= $no_of_credit_enquiry_in_last_3_months ?></td>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                switch ($no_of_credit_enquiry_in_last_3_months) {
                                                    case "0":
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';

                                                        break;
                                                    case "1":
                                                        echo '<div style="font-size:15px;text-align:right; width:85%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "2":
                                                        echo '<div style="font-size:15px;text-align:right; width:70%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "3":
                                                        echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "4":
                                                        echo '<div style="font-size:15px;text-align:right; width:48%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "5":
                                                        echo '<div style="font-size:15px;text-align:right; width:46%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "06":
                                                        echo '<div style="font-size:15px;text-align:right; width:44%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "07":
                                                        echo '<div style="font-size:15px;text-align:right; width:42%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "08":
                                                        echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "09":
                                                        echo '<div style="font-size:15px;text-align:right; width:28%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "10":
                                                        echo '<div style="font-size:15px;text-align:right; width:26%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "11":
                                                        echo '<div style="font-size:15px;text-align:right; width:24%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "12":
                                                        echo '<div style="font-size:15px;text-align:right; width:22%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "13":
                                                        echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "14":
                                                        echo '<div style="font-size:15px;text-align:right; width:18%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "15":
                                                        echo '<div style="font-size:15px;text-align:right; width:16%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "16":
                                                        echo '<div style="font-size:15px;text-align:right; width:14%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "17":
                                                        echo '<div style="font-size:15px;text-align:right; width:12%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "18":
                                                        echo '<div style="font-size:15px;text-align:right; width:10%;" aria-hidden="true">&#9660;</div>';
                                                        break;
                                                    case "19":
                                                        echo '<div style="font-size:15px;text-align:right; width:6%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    case "20":
                                                        echo '<div style="font-size:15px;text-align:right; width:0%;" aria-hidden="true">&#9660;</div>';
                                                        break;

                                                    default:
                                                        echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                                            </div>
                                        </td>
                                        <?php
                                        if ($no_of_credit_enquiry_in_last_3_months >= '0' && $no_of_credit_enquiry_in_last_3_months <= '1') {
                                            ?>
                                            <td><p class='strip-good'>Excellent. Minimal credit enquiry in the immediate past.
                                            </p></td>
                                            <?php
                                        } else if ($no_of_credit_enquiry_in_last_3_months > '1' && $no_of_credit_enquiry_in_last_3_months <= '2') {
                                            ?>
                                            <td><p class='strip-good'>Great. Within Limit.</p></td>
                                            <?php
                                        } else if ($no_of_credit_enquiry_in_last_3_months > '2' && $no_of_credit_enquiry_in_last_3_months <= '3') {
                                            ?>
                                            <td><p class='strip-good'>Good. Within reasonable limit.</p></td>
                                            <?php
                                        }else if ($no_of_credit_enquiry_in_last_3_months > '3' && $no_of_credit_enquiry_in_last_3_months <= '6') {
                                            ?>
                                            <td><p class='strip-good'>Alert. You have exceeded prudent limit for credit enquiry. Don't apply for too many loans or with too many lenders for the same loan.</p></td>
                                            <?php
                                        }else if ($no_of_credit_enquiry_in_last_3_months > '6') {
                                            ?>
                                            <td><p class='strip-good'>Caution. You have exceeded prudent limit for credit enquiry. This indicates you have very high credit requirement or not receiving credit approval for applied facility. You are advised not to apply for too many loans or with too many lenders for the same loan.</p></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>

                                    <!--No. of Loans Availed to Credit Enquiry in last 12 months-->
                                    <tr>
                                        <td style="text-align: center;">12</td>
                                        <td>No. of Loans Availed to Credit Enquiry in last 12 months</td>
                                        <?php
                                        $no_of_loans_availed_to_credit_enquiry_in_last_12_months = $rating['no_of_loans_availed_to_credit_enquiry_in_last_12_months'];

                                        echo "<td>" . $no_of_loans_availed_to_credit_enquiry_in_last_12_months . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 0 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months < 1.5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1.5) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months >= 0 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months <= 1) {
                                            echo "<td><p class='strip-good'>Great. Within Limit.</p></td>";
                                        } else if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1 && $no_of_loans_availed_to_credit_enquiry_in_last_12_months < 1.5) {
                                            echo "<td>Excellent. Satisfactory success rate for loans applied.</td>";
                                        } else if ($no_of_loans_availed_to_credit_enquiry_in_last_12_months > 1.5) {
                                            echo "<td>Alert. Don't apply with many lenders for the same loan. Know your eligibility before applying.</td>";
                                        }
                                        ?>
                                    </tr>

                                    <!-- History of credit (oldest credit account)-->
                                    <tr>
                                        <td style="text-align: center;">13</td>
                                        <td> History of credit (oldest credit account)</td>
                                        <?php
                                        $history_of_credit_oldest_credit_account = $rating['history_of_credit_oldest_credit_account'];


                                        echo "<td>" . $history_of_credit_oldest_credit_account . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($history_of_credit_oldest_credit_account == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($history_of_credit_oldest_credit_account > 0 && $history_of_credit_oldest_credit_account < 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($history_of_credit_oldest_credit_account > 1 && $history_of_credit_oldest_credit_account <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if ($history_of_credit_oldest_credit_account > 3) {

                                                    echo '<div style="font-size:15px;text-align:right; width:95%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($history_of_credit_oldest_credit_account >= 0 && $history_of_credit_oldest_credit_account < 2) {
                                            echo "<td><p class='strip-bad'>Recently started availing credit. Keep debt servicing track record intact for gradual improvement in credit profile over time.</p></td>";
                                        } else if ($history_of_credit_oldest_credit_account > 1 && $history_of_credit_oldest_credit_account <= 3) {
                                            echo "<td><p class='strip-good'>Reasonable history of credit. The credit profile would gradually improve over time on timely servicing of loans.</p></td>";
                                        } else if ($history_of_credit_oldest_credit_account > 3) {
                                            echo "<td><p class='strip-good'>Great. You have fairly long history of availing credit.</p></td>";
                                        }
                                        ?>
                                    </tr>

                                    <!-- Limit Breach-->
                                    <tr>
                                        <td style="text-align: center;">14</td>
                                        <td> Limit Breach</td>
                                        <?php
                                        $limit_breachach = $rating['limit_breach'];


                                        echo "<td>" . $limit_breachach . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($limit_breach == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($limit_breach > 0 && $limit_breach <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if ($limit_breach >= 3) {

                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($limit_breach == 0) {
                                            echo "<td><p class='strip-good'>Excellent. You have remained within limit of each facility.</p></td>";
                                        } else if ($limit_breach > 0 && $limit_breach <= 2) {
                                            echo "<td><p class='strip-bad'>Alert. You have breached credit limits of certain facilities.</p></td>";
                                        } else if ($limit_breach > 2) {
                                            echo "<td><p class='strip-bad'>Alert. You have breached credit limits of some facilities. You are advised to bring down the outstanding within limit.</p></td>";
                                        }
                                        ?>
                                    </tr>
                                    <!-- Present Delay in Servicing-->
                                    <tr>
                                        <td style="text-align: center;">15</td>
                                        <td colspan="5">Present Delay in Servicing</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td> Overdue to Obligation</td>
                                        <?php
                                        $overdue_to_obligation = $rating['overdue_to_obligation'];

                                        echo "<td>" . $overdue_to_obligation . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($overdue_to_obligation == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($overdue_to_obligation > 0 && $overdue_to_obligation <= 25) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obligation > 25 && $overdue_to_obligation <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obligation > 50 && $overdue_to_obligation <= 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obligation > 75 && $overdue_to_obligation <= 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obligation > 100) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <td style="border:none;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Overdue to Monthly Income</td>
                                        <?php
                                        $overdue_to_monthly_income = $rating['overdue_to_monthly_income'];

                                        echo "<td>" . $overdue_to_monthly_income . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($overdue_to_monthly_income == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($overdue_to_monthly_income > 0 && $overdue_to_monthly_income <= 25) {
                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($overdue_to_monthly_income > 25 && $overdue_to_monthly_income <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_monthly_income > 50) {

                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($overdue_to_obligation == 0) {

                                            $comment1 = 'Excellent. No overdues.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                           if($overdue_to_monthly_income > 50 && $condition > 100)
                                           {
                                               echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                           }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obligation > 0 && $limit_breach <= 25) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                            if($overdue_to_monthly_income > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obligation > 25 && $overdue_to_obligation <= 50) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                            if($overdue_to_monthly_income > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obligation > 50 && $overdue_to_obligation <= 75) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Reduce discretionary spending. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                            if($overdue_to_monthly_income > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }
                                        } else if ($overdue_to_obligation > 75 && $overdue_to_obligation <= 100) {

                                            $comment1 = 'Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                            if($overdue_to_monthly_income > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }
                                        } else if ($overdue_to_obligation > 100) {

                                            $comment1 = 'Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = ($overdue_to_monthly_income+$fixed_obligation_to_income);
                                            if($overdue_to_monthly_income > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }
                                        }

                                        ?>
                                    </tr>

                                    <!-- Past Delay in Servicing-->
                                    <tr>
                                        <td style="text-align: center;">16</td>
                                        <td colspan="4">Past Delay in Servicing</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">a.</td>
                                        <td> Number of instances of delay in past 6 months</td>
                                        <?php
                                        $number_of_instances_of_delay_in_past_6_months = $rating['number_of_instances_of_delay_in_past_6_months'];
                                        echo "<td>" . $number_of_instances_of_delay_in_past_6_months . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($number_of_instances_of_delay_in_past_6_months == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($number_of_instances_of_delay_in_past_6_months > 0) {
                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <td style="border:none;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td> Number of instances of delay in past 12 months</td>
                                        <?php
                                        $number_of_instances_of_delay_in_past_12_months = $rating['number_of_instances_of_delay_in_past_12_months'];

                                        echo "<td>" . $number_of_instances_of_delay_in_past_12_months . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($number_of_instances_of_delay_in_past_12_months == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($number_of_instances_of_delay_in_past_12_months > 0) {
                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <td style="border:none;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td> Number of instances of delay in past 36 months</td>
                                        <?php
                                        $number_of_instances_of_delay_in_past_36_months = $rating['number_of_instances_of_delay_in_past_36_months'];
                                        echo "<td>" . $number_of_instances_of_delay_in_past_36_months . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($number_of_instances_of_delay_in_past_12_months == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($number_of_instances_of_delay_in_past_12_months > 0) {
                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($number_of_instances_of_delay_in_past_6_months == 0) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>Excellent. Your past debt servicing track record is impeccable.</p></td>";
                                        } else if ($number_of_instances_of_delay_in_past_6_months > 0) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>Alert. You have delayed servicing of debt in the past (22 instances in last 6 months and 29 instances in past 12 months). in future, always make debt payment within due date, in order to improve credit profile.</p></td>";
                                        }


                                        ?>
                                    </tr>


                                    <tr>
                                        <td style="text-align: center;">17</td>
                                        <td> Past instances of settlement/ write-off</td>
                                        <?php
                                        $past_instances_of_settlement_write_off = $rating['past_instances_of_settlement_write_off'];
                                        echo "<td>" . $past_instances_of_settlement_write_off . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($past_instances_of_settlement_write_off == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($past_instances_of_settlement_write_off > 0) {
                                                    echo '<div style="font-size:15px;text-align:right; width:25%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        if ($past_instances_of_settlement_write_off == 0) {
                                            echo "<td><p class='strip-good'>Excellent. You do not have any record of compromise/ settlement or write-offs by lenders.</p></td>";
                                        } else if ($past_instances_of_settlement_write_off > 0) {
                                            echo "<td><p class='strip-bad'>Alert. You have past instances of settlement or write-off. This may impact your credit profile. In future, try to avoid any dispute with lenders for unblemished credit profile.</p></td>";
                                        }


                                        ?>
                                    </tr>

                                    <!--overdue date-->
                                    <tr>
                                        <td style="text-align: center;">18</td>
                                        <td colspan="4">Over Due Date's</td>
                                    </tr>
                                    <?php

                                      if($rating['over_due_dates']) foreach ($rating['over_due_dates'] AS $over_due_dates)
                                       {
                                           for($i = 0; $i<count($over_due_dates); $i++)
                                           {
                                           ?>
                                        <tr>
                                               <td></td>
                                               <td> <?= $over_due_dates[$i]['bank_name']; ?>
                                                   (<?= $over_due_dates[$i]['Account_Number']; ?>
                                                   )
                                               </td>
                                               <td><?php if($over_due_dates[$i]['Days_Past_Due']){
                                                   echo $over_due_dates[$i]['Days_Past_Due'].' Days';
                                                   } else{
                                                   echo '0 Days';
                                                   } ?>
                                               </td>

                                                   <td style="text-align: -webkit-auto;">
                                                       <div style="width:100%; float:right !important;">
                                                           <?php
                                                           if($over_due_dates[$i]['Days_Past_Due']){
                                                               echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                                                           } else{
                                                               echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                           }
                                                           ?>
                                                           <div
                                                                   style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                           <div
                                                                   style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                                                       </div>
                                                   </td>

                                                   <?php
                                                   if ($over_due_dates[$i]['Days_Past_Due']) {
                                                       ?>
                                                       <td style='border:none ;'>
                                                           <p class='strip-bad'style=''>Alert! You
                                                               have
                                                               crossed the maximum limit of suggested range which is
                                                               affecting
                                                               your credit score. We advise you to stay within the
                                                               suggested
                                                               range to maintain a healthy credit score.</p>
                                                       </td>

                                                       <?php
                                                   } else {
                                                       ?>
                                                       <td style='font-weight: 400;border: 1px solid #ddd;'>Great! You
                                                           are
                                                           within the suggested range please do not cross the max
                                                           limit. We
                                                           advise you to stay within the suggest range to maintain a
                                                           healthy credit score.
                                                       </td>

                                                       <?php
                                                   }

                                                   ?>
                                        </tr>
                                       <?php }
                                       }
                                    ?>


                                </table>
                            </div>
                            <!--description-->
                            <div class="col-md-12">
                                <ul class="termss">
                                    <li><i class="fa fa-asterisk"></i>The purpose of verification is to identity cases
                                        of misuse of identity of individual by fraud use to avail Loan
                                    </li>
                                    <li><i class="fa fa-asterisk"></i><i class="fa fa-asterisk"></i> Leveraging Ratio is
                                        defined as your total loan divided by your annual income. High the ratio might
                                        the chances of default.
                                    </li>
                                    <li><i class="fa fa-asterisk"></i><i class="fa fa-asterisk"></i><i
                                            class="fa fa-asterisk"></i> Short Term leveraging is credit card due divided
                                        by monthly income
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.container -->

                </div>
            </div>

        </div>
    </div>