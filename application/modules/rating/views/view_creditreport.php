<?php error_reporting(0); //echo "<pre>"; print_r($list); die; ?>
<style>

    .points {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
        text-align: right;
        padding-right: 100px;
    }
    .chart-gauge {
        width: 220px;
        margin: 0 auto;
        height: 100px;
        position: relative;
        float: right;
    }
    .chart-color1 {
        fill: #e92213;
        position: relative;
    }
    .chart-gauge:before {
        position: absolute;
        content: "300";
        left: -5px;
        bottom: 15px;
        color: #000;
        font-weight: 600;
        transform: rotate(-90deg);
    }
    .chart-gauge:after {
        position: absolute;
        content: "900";
        right: 15px;
        bottom: 15px;
        color: #000;
        font-weight: 600;
        transform: rotate(90deg);
    }

    .chart-color2 {
        fill: #E9621A;
    }

    .chart-color3 {
        fill: #fcdd19;
    }
    .chart-color4 {
        fill: #8ac23f;
    }
    .chart-color5 {
        fill: #079f4c;
    }

    .needle,
    .needle-center {
        fill: #464A4F;
    }
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

<div class="row"><br>



    <div class="col-md-12">
        <?php
        if($result_array == '')
        {
            echo 'Error-'.$values->errorString.'<br>';
            echo 'stageOneId_ '.$values->stageOneId_.'<br>';
            echo 'stageTwoId_ '.$values->stageTwoId_;
        }
        else {
            ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 ">
                                <img src="<?=base_url();?>assets/img/logo2.png" alt="Antworks Money Logo" height="71"/>
                            </div>
                            <div class="col-md-6 ">
                                <h2 class="points"><?= $result_array['SCORE']['BureauScore']; ?></h2>
                                <div class="chart-gauge" id="for_image"></div>
                            </div>

                        </div>
                        <div class="col-md-12 scor-hd">
                            <div class="row scor-top-hd text-center">
                                <h2>
                                    Hello <?=  $result_array['Current_Application']['Current_Application_Details']['Current_Applicant_Details']['First_Name']; ?>
                                    <!--span>Your Records Are:</span></h2-->
                                </h2>
                                <ul class="credit-info">
                                    <li>Created Date: <?= $values->created_date; ?> </li>
                                    <li>Unique Transaction ID: <?= $values->order_id; ?> </li>
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

                                        <div class="credit-data-nm">Name :
                                            <span><?= $result_array['Current_Application']['Current_Application_Details']['Current_Applicant_Details']['First_Name']; ?> <?= $result_array['Current_Application']['Current_Application_Details']['Current_Applicant_Details']['Last_Name']; ?></span>
                                        </div>
                                        <div class="credit-data-nm">Age
                                            : <span><?php $dob = $result_array['Current_Application']['Current_Application_Details']['Current_Applicant_Details']['Date_Of_Birth_Applicant'];

                                                $from = new DateTime($dob);
                                                $to = new DateTime('today');
                                                echo $from->diff($to)->y . 'years'; ?></span></div>
                                        <div class="credit-data-nm">Gender : <span><?php

                                                $gender = $result_array['Current_Application']['Current_Application_Details']['Current_Applicant_Details']['Gender_Code'];
                                                if ($gender == '1') {
                                                    echo "Male";
                                                } else if ($gender == '2') {
                                                    echo "Female";
                                                }
                                                ?></span></div>

                                    </div>
                                    <?php
                                    $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                    $loan = $count - 1;
                                    for ($i = 0; $i <= $loan; $i++) {
                                        $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                        if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                            $loanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                        }
                                    }
                                    ?>
                                    <div class="col-md-6 credit-data-rite">
                                        <div class="credit-data-nm">Monthly Income :
                                            <span>INR. <?= $values['monthly_income']; ?></span></div>
                                        <div class="credit-data-nm"> Leveraging Ratio :
                                            <?php
                                            $income = $values['monthly_income'];

                                            $anual = ($income * 12);

                                            $expanse = ($loanamount / $anual);
                                            if (round($expanse, 0) < 10) {
                                                echo "<td><span style='color:#008000;'>" . round($expanse, 2) . "</span></td>";
                                            } else if (round($expanse, 0) == 10) {
                                                echo "<td><span style='color:#ffbf00;'>" . round($expanse, 2) . "</span></td>";
                                            } else if (round($expanse, 0) > 10) {
                                                echo "<td><span style='color:#FF0000;'>" . round($expanse, 2) . "</span></td>";
                                            }
                                            ?>
                                        </div>

                                        <div class="credit-data-nm">No. of Active Loan Account :
                                            <span><?= $result_array['CAIS_Account']['CAIS_Summary']['Credit_Account']['CreditAccountActive']; ?></span>
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
                                            <?php
                                            $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                            $loan = $count - 1;
                                            $j = 1;
                                            for ($i = 0; $i <= $loan; $i++) {

                                                ?>
                                                <tr>
                                                    <?php
                                                    $status_loan  = '00, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 79, 81, 85, 86, 87, 88, 90, 91, 93, 97';
                                                    $status_loan = explode(',', $status_loan);
                                                    $active_loan  = '11, 21, 22, 23, 24, 25, 71, 78, 80, 82, 83, 84';
                                                    $active_loan = explode(',', $active_loan);
                                                    $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                                    if (in_array($loanstatus,$active_loan)) {
                                                        $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name'];
                                                        $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                        ?>
                                                        <td>Acct <?= $j++; ?></td>
                                                        <td> <?php echo $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name']; ?></td>

                                                        <?php
                                                        $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                        switch ($loantype) {
                                                            case "0":
                                                                echo "<td>OTHERS</td>";
                                                                break;
                                                            case "1":
                                                                echo "<td>AUTO LOAN</td>";
                                                                break;
                                                            case "2":
                                                                echo "<td>HOUSING LOAN</td>";
                                                                break;
                                                            case "3":
                                                                echo "<td>PROPERTY LOAN</td>";
                                                                break;
                                                            case "4":
                                                                echo "<td>LOAN AGAINST SHARES/SECURITIES</td>";
                                                                break;
                                                            case "5":
                                                                echo "<td>PERSONAL LOAN </td>";
                                                                break;
                                                            case "06":
                                                                echo "<td>CONSUMER LOAN</td>";
                                                                break;
                                                            case "07":
                                                                echo "<td>GOLD LOAN</td>";
                                                                break;
                                                            case "08":
                                                                echo "<td>EDUCATIONAL LOAN </td>";
                                                                break;
                                                            case "09":
                                                                echo "<td>LOAN TO PROFESSIONAL</td>";
                                                                break;

                                                            case "10":
                                                                echo "<td>CREDIT CARD</td>";
                                                                break;
                                                            case "11":
                                                                echo "<td>LEASING</td>";
                                                                break;
                                                            case "12":
                                                                echo "<td>OVERDRAFT</td>";
                                                                break;
                                                            case "13":
                                                                echo "<td>TWO-WHEELER LOAN</td>";
                                                                break;
                                                            case "14":
                                                                echo "<td>NON-FUNDED CREDIT FACILITY </td>";
                                                                break;
                                                            case "15":
                                                                echo "<td>LOAN AGAINST BANK DEPOSITS </td>";
                                                                break;
                                                            case "16":
                                                                echo "<td>FLEET CARD</td>";
                                                                break;
                                                            case "17":
                                                                echo "<td>Commercial Vehicle Loan </td>";
                                                                break;
                                                            case "18":
                                                                echo "<td>Telco Wireless</td>";
                                                                break;
                                                            case "19":
                                                                echo "<td>Telco Broadband</td>";
                                                                break;
                                                            case "20":
                                                                echo "<td>Telco Landline</td>";
                                                                break;
                                                            case "31":
                                                                echo "<td>Secured Credit Card</td>";
                                                                break;
                                                            case "32":
                                                                echo "<td>Used Car Loan</td>";
                                                                break;

                                                            case "33":
                                                                echo "<td>Construction Equipment Loan</td>";
                                                                break;
                                                            case "34":
                                                                echo "<td>Tractor Loan</td>";
                                                                break;
                                                            case "35":
                                                                echo "<td>CORPORATE CREDIT CARD</td>";
                                                                break;
                                                            case "43":
                                                                echo "<td>Microfinance Others </td>";
                                                                break;
                                                            case "43":
                                                                echo "<td>Microfinance Others </td>";
                                                                break;
                                                            case "51":
                                                                echo "<td>BUSINESS LOAN GENERAL</td>";
                                                                break;
                                                            case "52":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR SMALL BUSINESS </td>";
                                                                break;
                                                            case "53":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR AGRICULTURE </td>";
                                                                break;
                                                            case "54":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR OTHERS  </td>";
                                                                break;
                                                            case "55":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY GENERAL  </td>";
                                                                break;
                                                            case "56":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR SMALL BUSINESS   </td>";
                                                                break;
                                                            case "57":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR AGRICULTURE   </td>";
                                                                break;
                                                            case "58":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR OTHERS   </td>";
                                                                break;
                                                            case "59":
                                                                echo "<td>BUSINESS LOANS AGAINST BANK DEPOSITS    </td>";
                                                                break;
                                                            case "60":
                                                                echo "<td>Staff Loan</td>";
                                                                break;
                                                            case "36":
                                                                echo "<td>Kisan Credit Card</td>";
                                                                break;
                                                            case "37":
                                                                echo "<td>Loan on Credit Card</td>";
                                                                break;
                                                            case "38":
                                                                echo "<td>Prime Minister Jaan Dhan Yojana - Overdraft</td>";
                                                                break;
                                                            case "39":
                                                                echo "<td>Mudra Loans Shishu / Kishor / Tarun</td>";
                                                                break;
                                                            case "61":
                                                                echo "<td>BUSINESS LOANUnsecured</td>";
                                                                break;
                                                            default:
                                                                echo "<td>-</td>";
                                                        }

                                                        ?>
                                                        <td>
                                                            INR.<?= $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance']; ?></td>
                                                        <?php
                                                    }


                                                    ?>
                                                </tr>
                                                <?php
                                            }
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
                                            <?php
                                            $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                            $loan = $count - 1;
                                            $j = 1;
                                            for ($i = 0; $i <= $loan; $i++) {

                                                ?>
                                                <tr>
                                                    <?php
                                                    $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];

                                                    if ($loanstatus == '12' || $loanstatus == '13' || $loanstatus == '14' || $loanstatus == '15' || $loanstatus == '17') {
                                                        ?>
                                                        <td>Acct <?=$j++;?></td>
                                                        <td> <?php echo $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name'] ?></td>
                                                        <?php
                                                        $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

                                                        switch ($loantype) {
                                                            case "0":
                                                                echo "<td>OTHERS</td>";
                                                                break;
                                                            case "1":
                                                                echo "<td>AUTO LOAN</td>";
                                                                break;
                                                            case "2":
                                                                echo "<td>HOUSING LOAN</td>";
                                                                break;
                                                            case "3":
                                                                echo "<td>PROPERTY LOAN</td>";
                                                                break;
                                                            case "4":
                                                                echo "<td>LOAN AGAINST SHARES/SECURITIES</td>";
                                                                break;
                                                            case "5":
                                                                echo "<td>PERSONAL LOAN </td>";
                                                                break;
                                                            case "06":
                                                                echo "<td>CONSUMER LOAN</td>";
                                                                break;
                                                            case "07":
                                                                echo "<td>GOLD LOAN</td>";
                                                                break;
                                                            case "08":
                                                                echo "<td>EDUCATIONAL LOAN </td>";
                                                                break;
                                                            case "09":
                                                                echo "<td>LOAN TO PROFESSIONAL</td>";
                                                                break;

                                                            case "10":
                                                                echo "<td>CREDIT CARD</td>";
                                                                break;
                                                            case "11":
                                                                echo "<td>LEASING</td>";
                                                                break;
                                                            case "12":
                                                                echo "<td>OVERDRAFT</td>";
                                                                break;
                                                            case "13":
                                                                echo "<td>TWO-WHEELER LOAN</td>";
                                                                break;
                                                            case "14":
                                                                echo "<td>NON-FUNDED CREDIT FACILITY </td>";
                                                                break;
                                                            case "15":
                                                                echo "<td>LOAN AGAINST BANK DEPOSITS </td>";
                                                                break;
                                                            case "16":
                                                                echo "<td>FLEET CARD</td>";
                                                                break;
                                                            case "17":
                                                                echo "<td>Commercial Vehicle Loan </td>";
                                                                break;
                                                            case "18":
                                                                echo "<td>Telco Wireless</td>";
                                                                break;
                                                            case "19":
                                                                echo "<td>Telco Broadband</td>";
                                                                break;
                                                            case "20":
                                                                echo "<td>Telco Landline</td>";
                                                                break;
                                                            case "31":
                                                                echo "<td>Secured Credit Card</td>";
                                                                break;
                                                            case "32":
                                                                echo "<td>Used Car Loan</td>";
                                                                break;

                                                            case "33":
                                                                echo "<td>Construction Equipment Loan</td>";
                                                                break;
                                                            case "34":
                                                                echo "<td>Tractor Loan</td>";
                                                                break;
                                                            case "35":
                                                                echo "<td>CORPORATE CREDIT CARD</td>";
                                                                break;
                                                            case "43":
                                                                echo "<td>Microfinance Others </td>";
                                                                break;
                                                            case "43":
                                                                echo "<td>Microfinance Others </td>";
                                                                break;
                                                            case "51":
                                                                echo "<td>BUSINESS LOAN GENERAL</td>";
                                                                break;
                                                            case "52":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR SMALL BUSINESS </td>";
                                                                break;
                                                            case "53":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR AGRICULTURE </td>";
                                                                break;
                                                            case "54":
                                                                echo "<td>BUSINESS LOANPRIORITY SECTOR OTHERS  </td>";
                                                                break;
                                                            case "55":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY GENERAL  </td>";
                                                                break;
                                                            case "56":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR SMALL BUSINESS   </td>";
                                                                break;
                                                            case "57":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR AGRICULTURE   </td>";
                                                                break;
                                                            case "58":
                                                                echo "<td>BUSINESS NON-FUNDED CREDIT FACILITY PRIORITY SECTOR OTHERS   </td>";
                                                                break;
                                                            case "59":
                                                                echo "<td>BUSINESS LOANS AGAINST BANK DEPOSITS    </td>";
                                                                break;
                                                            case "60":
                                                                echo "<td>Staff Loan</td>";
                                                                break;
                                                            case "36":
                                                                echo "<td>Kisan Credit Card</td>";
                                                                break;
                                                            case "37":
                                                                echo "<td>Loan on Credit Card</td>";
                                                                break;
                                                            case "38":
                                                                echo "<td>Prime Minister Jaan Dhan Yojana - Overdraft</td>";
                                                                break;
                                                            case "39":
                                                                echo "<td>Mudra Loans Shishu / Kishor / Tarun</td>";
                                                                break;
                                                            case "61":
                                                                echo "<td>BUSINESS LOANUnsecured</td>";
                                                                break;
                                                            default:
                                                                echo "<td>-</td>";
                                                        }
                                                        ?>
                                                        <td>
                                                            INR.<?= $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance']; ?></td>
                                                        <?php
                                                    }

                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
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
                                    <?php
                                    $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                    $loan = $count - 1;
                                    for ($i = 0; $i <= $loan; $i++) {
                                        $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                        if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype !== '10') {
                                                $all_credit_amountsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            } else {


                                                $credit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                if ($credit_limit) {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                } else {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                                $credit_limit_amount > $credit_amount ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount;
                                                $revolving_amountsumall += $revolving_amount;


                                            }
                                        }

                                    }
                                    //value of L15
                                    $adjusted_balance = ($all_credit_amountsum + $revolving_amountsumall);
                                    ?>

                                    <!--Leveraging Ratio-->
                                    <tr>
                                        <td style="text-align: center;">1</td>
                                        <td colspan="4">Leveraging Ratio**</td>
                                    </tr>
                                    <tr><td style="text-align: center;">a.</td><td>Overall Leveraging Ratio</td>
                                        <?php
                                        $income = $values['monthly_income'];
                                        $loanamount;
                                        $anual = ($income*12);
                                        $expanse = ($loanamount/$anual);
                                        if(round($expanse,0) < 3)
                                        {
                                            echo "<td><span style='color:#008000;'>".round($expanse,2)."</span></td>";
                                        }
                                        else if(round($expanse,0) == 3 )
                                        {
                                            echo "<td><span style='color:#ffbf00;'>".round($expanse,2)."</span></td>";
                                        }
                                        else if(round($expanse,0) > 3)
                                        {
                                            echo "<td><span style='color:#FF0000;'>".round($expanse,2)."</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php

                                                if(round($expanse,0) == 0 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) > 0 && round($expanse,0) <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:90%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) > 1 && round($expanse,0) <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) > 2 && round($expanse,0) <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) >  3 && round($expanse,0) <= 4) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) > 4 && round($expanse,0) <= 5) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse,0) > 5 ) {

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
                                        $income = $values['monthly_income'];
                                        $loanamount;
                                        $anual = ($income*12);
                                        $expanse2 = ($adjusted_balance/$anual);
                                        if(round($expanse2,0) < 3)
                                        {
                                            echo "<td><span style='color:#008000;'>".round($expanse2,2)."</span></td>";
                                        }
                                        else if(round($expanse2,0) == 3 )
                                        {
                                            echo "<td><span style='color:#ffbf00;'>".round($expanse2,2)."</span></td>";
                                        }
                                        else if(round($expanse2,0) > 3)
                                        {
                                            echo "<td><span style='color:#FF0000;'>".round($expanse2,2)."</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php

                                                if(round($expanse2,0) == 0 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) > 0 && round($expanse2,0) <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:90%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) > 1 && round($expanse2,0) <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) > 2 && round($expanse2,0) <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) >  3 && round($expanse2,0) <= 4) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) > 4 && round($expanse2,0) <= 5) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if(round($expanse2,0) > 5 ) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>
                                            </div>
                                        </td>
                                        <?php
                                        if(round($expanse,0) >= 0 &&  round($expanse,0) <= 1)
                                        {
                                            echo "<td style='border:none ;'><p class='strip-good'style='margin-top:-50px;'>Excellent. Your credit availment is low.</p></td>";
                                        }
                                        else if(round($expanse,0) > 1  && round($expanse,0) <= 2)
                                        {
                                            echo "<td style='border:none;'><p class='strip-good'style='margin-top:-50px;'>Great. Your Credit availment is within reasonable limits. Keep your credit mix prudent.</p></td>";
                                        }
                                        else if(round($expanse,0) > 2  && round($expanse,0) <= 3)
                                        {
                                            echo "<td style='border:none !important;'><p class='strip-good' style='margin-top:-50px;'>Good. Your overall credit limit is still within limit. Keep a check on further borrowings (borrow only if necessary). Keep your credit mix prudent with more long term facilities.</p></td>";
                                        }
                                        else if(round($expanse,0) > 3  && round($expanse,0) <= 4)
                                        {
                                            echo "<td style='border:none;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have exceeded the prudent leveraging limit. It is advised not to avail further credit and borrow only if extremely essential. Try to remain on time with repayment obligations and over time the ratio would improve to prudent level.</p></td>";
                                        }
                                        else if(round($expanse,0) > 4)
                                        {
                                            echo "<td style='border:none; '><p class='strip-bad'style='margin-top:-50px;'>Caution. You have exceeded the prudent leveraging limit. Borrow only if extremely essential. Reduce discretionary spending to bring down utilization of revolving credit lines and prepay short term loans to bring down indebtedness. Try to remain on time with repayment obligations and over time </p></td>";
                                        }
                                        else if(round($expanse,0) < 3 && round($expanse2,0) > 3)
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype == '10') {
                                                    $creditamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }


                                                    $creditloanamount += $credit_limit_amount;
                                                }

                                            }
                                        }


                                        $revolving = (($creditamount / $creditloanamount) * 100);


                                        echo "<td>" . round($revolving, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($revolving, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 0 && round($revolving, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 10 && round($revolving, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 25 && round($revolving, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 50 && round($revolving, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 75 && round($revolving, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($revolving, 0) > 90) {

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
                                        if (round($revolving, 0) >= 0 && round($revolving, 0) < 11) {
                                            echo "<td><p class='strip-good'>Great. You have maximum revolving limit unutilized. However, be selective in availing new limits which may not be required in future.</p></td>";
                                        } else if (round($revolving, 0) > 10 && round($revolving, 0) < 26) {
                                            echo "<td><p class='strip-good'>Excellent. You have optimum revolving limit available and most prudent limit utilization.</p></td>";
                                        } else if (round($revolving, 0) > 25 && round($revolving, 0) < 51) {
                                            echo "<td><p class='strip-good'>Good. You have adequate revolving limit available.</p></td>";
                                        } else if (round($revolving, 0) > 50 && round($revolving, 0) < 76) {
                                            echo "<td><p class='strip-bad'>Alert. You have utilized a substantial part of your revolving credit line.  You may accept limit enhancement in revolving credit facilities like credit card or overdraft (as and when available).</p></td>";
                                        } else if (round($revolving, 0) > 75 && round($revolving, 0) < 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. It is advised to reduce utilization ratio for better credit profile. You may also avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
                                        } else if (round($revolving, 0) > 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. You have very little credit line available for contingency. It is recommended that you avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility). It is advised to apply restraint on discretionary spending. and reduce credit utilization ratio for better credit. </p></td>";
                                        }
                                        ?>
                                    </tr>
                                    <!--Outstanding to Limit-->
                                    <tr>
                                        <td style="text-align: center;">3</td>
                                        <td colspan="4">Outstanding to Limit</td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: center;">a.</td>
                                        <td>Outstanding to Limit(Term Credit)</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {

                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype !== '10') {
                                                    $termamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    $termloanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                            }
                                        }

                                        $outstanding = (($termamount / $termloanamount) * 100);


                                        echo "<td>" . round($outstanding, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($outstanding, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstanding, 0) > 0 && round($outstanding, 0) < 41) {

                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstanding, 0) > 40 && round($outstanding, 0) < 81) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstanding, 0) > 80 && round($outstanding, 0) < 91) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($outstanding, 0) > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                        </td>
                                        <?php
                                        /*if (round($outstanding, 0) >= 0 && round($outstanding, 0) < 41) {
                                            echo "<td><p class='strip-good'>Excellent. You have repaid substantial part of your term obligations. Maintain regular servicing for improved credit profile.</p></td>";
                                        } else if (round($outstanding, 0) > 40 && round($outstanding, 0) < 81) {
                                            echo "<td><p class='strip-good'>Good. You have repaid a part of your term obligations. Maintain regular servicing for improved credit profile.</p></td>";
                                        } else if (round($outstanding, 0) > 80 && round($outstanding, 0) < 91) {
                                            echo "<td><p class='strip-bad'>Your present term debt obligations are relatively new. Maintain regular servicing for improved credit profile.</p></td>";
                                        } else if (round($outstanding, 0) > 90) {
                                            echo "<td><p class='strip-bad'>Your present term debt obligations are relatively new. There is minimal reduction in loan principal outstanding till this point. Maintain regular servicing for improved credit profile.</p></td>";
                                        }*/

                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Outstanding to Limit(Term Credit including past facilities)</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype !== '10') {
                                                $termamountall += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];

                                                $alltermloanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                            }

                                        }

                                        $outstandingall = (($termamountall / $alltermloanamount) * 100);


                                        echo "<td>" . round($outstandingall, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($outstandingall, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 0 && round($outstandingall, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 10 && round($outstandingall, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 25 && round($outstandingall, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 50 && round($outstandingall, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 75 && round($outstandingall, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($outstandingall, 0) > 90) {

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
                                        /*if (round($outstandingall, 0) >= 0 && round($outstandingall, 0) < 11) {
                                            echo "<td><p class='strip-good'>Great. You have maximum revolving limit unutilized. However, be selective in availing new limits which may not be required in future.</p></td>";
                                        } else if (round($outstandingall, 0) > 10 && round($outstandingall, 0) < 26) {
                                            echo "<td><p class='strip-good'>Excellent. You have optimum revolving limit available and most prudent limit utilization.</p></td>";
                                        } else if (round($outstandingall, 0) > 25 && round($outstandingall, 0) < 51) {
                                            echo "<td><p class='strip-good'>Good. You have adequate revolving limit available.</p></td>";
                                        } else if (round($outstandingall, 0) > 50 && round($outstandingall, 0) < 76) {
                                            echo "<td><p class='strip-bad'>Alert. You have utilized a substantial part of your revolving credit line.  You may accept limit enhancement in revolving credit facilities like credit card or overdraft (as and when available).</p></td>";
                                        } else if (round($outstandingall, 0) > 75 && round($outstandingall, 0) < 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. It is advised to reduce utilization ratio for better credit profile. You may also avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
                                        } else if (round($outstandingall, 0) > 90) {
                                            echo "<td><p class='strip-bad'>Alert. You are close to the limit of your revolving credit line. You have very little credit line available for contingency. It is recommended that you avail term credit to pay off revolving line (credit card/ overdraft etc.) or convert part of the outstanding into term facility (ie. EMI facility). It is advised to apply restraint on discretionary spending. and reduce credit utilization ratio for better credit.</p></td>";
                                        }*/
                                        if (round($outstanding, 0) >= 0 && round($outstanding, 0) < 41) {
                                            $comment1 = 'Excellent. You have repaid substantial part of your term obligations. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile..';
                                            $full = $comment1.$comment2;
                                            round($outstandingall, 0) < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";

                                        } else if (round($outstanding, 0) > 40 && round($outstanding, 0) < 81) {
                                            $comment1 = 'Good. You have repaid a part of your term obligations. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile..';
                                            $full = $comment1.$comment2;
                                            round($outstandingall, 0) < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        } else if (round($outstanding, 0) > 80 && round($outstanding, 0) < 91) {
                                            $comment1 = 'Your present term debt obligations are relatively new. Maintain regular servicing for improved credit profile';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile.';
                                            $full = $comment1.$comment2;
                                            round($outstandingall, 0) < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        } else if (round($outstanding, 0) > 90) {
                                            $comment1 = 'Your present term debt obligations are relatively new. There is minimal reduction in loan principal outstanding till this point. Maintain regular servicing for improved credit profile.';
                                            $comment2 = '<br/>You have past track record (9 term credit accounts) of repayment. This is positive for credit profile.';
                                            $full = $comment1.$comment2;
                                            round($outstandingall, 0) < 50 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-70px;'>".$comment."</p></td>";
                                        }

                                        ?>
                                    </tr>
                                    <!--Short term Leveraging-->
                                    <tr>
                                        <td style="text-align: center;">4.</td>
                                        <td>Short term Leveraging***</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype == '10') {
                                                $loanamount2 += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            }

                                        }

                                        $income = $values['monthly_income'];
                                        $expanse = ($loanamount2 / $income);
                                        if (round($expanse, 0) < 1) {
                                            echo "<td><span style='color:#008000;'>" . round($expanse, 2) . "</span></td>";
                                        } else if (round($expanse, 0) == 1) {
                                            echo "<td><span style='color:#ffbf00;'>" . round($expanse, 2) . "</span></td>";
                                        } else if (round($expanse, 0) > 1) {
                                            echo "<td><span style='color:#FF0000;'>" . round($expanse, 2) . "</span></td>";
                                        }
                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php

                                                switch (round($expanse, 0)) {
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
                                        if (round($expanse, 0) < 1) {
                                            echo "<td><p class='strip-good'>Great! You are within the suggested range please do not cross the max limit. We advise you to stay within the suggest range to maintain a healthy credit score.</p></td>";
                                        } else if (round($expanse, 0) == 1) {
                                            echo "<td><p class='strip-bad'>Alert! You have reached the maximum limit of suggested range. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        } else if (round($expanse, 0) > 1) {
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype !== '10') {
                                                $termamountallsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            } else {

                                                $credit_amountsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                if ($credit_limit) {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                } else {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                                $credit_limit_amount > $credit_amount ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount;
                                                $revolving_amountsum += $revolving_amount;


                                            }

                                        }

                                        $termcredit = $termamountallsum + $credit_amountsum;
                                        $creditmix = (($revolving_amountsum / $termcredit) * 100);


                                        echo "<td>" . round($creditmix, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;">
                                            <!--<div style="width:100%; float:right !important;">
                                                <?php
                                               /* if (round($creditmix, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 0 && round($creditmix, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 10 && round($creditmix, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 25 && round($creditmix, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 50 && round($creditmix, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 75 && round($creditmix, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }*/

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>-->
                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Term Credit to Total Credit</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype !== '10') {
                                                $termamountasum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            } else {

                                                $credit_amountsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                if ($credit_limit) {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                } else {
                                                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                                $credit_limit_amount > $credit_amount ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount;
                                                $revolving_amountsumcredit += $revolving_amount;


                                            }

                                        }

                                        $termcreditto = $termamountasum + $revolving_amountsumcredit;

                                        $creditmixcredit = (($termamountasum / $termcreditto) * 100);


                                        echo "<td>" . round($creditmixcredit, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;border-top: none;">
                                           <!-- <div style="width:100%; float:right !important;">
                                                <?php
                                               /* if (round($creditmixcredit, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 0 && round($creditmixcredit, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 10 && round($creditmixcredit, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 25 && round($creditmixcredit, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 50 && round($creditmixcredit, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 75 && round($creditmixcredit, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit, 0) > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }*/

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>-->
                                        </td>
                                        <td style='border:none ;'></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td>Available Revolving line to Total Credit</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            if ($loantype !== '10') {
                                                $termamountasum_available += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            } else {

                                                $credit_amountsum_available += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_amount_available = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit_available = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                if ($credit_limit_available) {
                                                    $credit_limit_amount_available = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                } else {
                                                    $credit_limit_amount_available = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                                $revolving_amountsumcredit_available += $credit_limit_amount_available;


                                            }

                                        }

                                        $termcreditto_available = $termamountasum_available + $revolving_amountsumcredit_available;

                                        $creditmixcredit_available = ((($revolving_amountsumcredit_available - $credit_amountsum_available) / $termcreditto) * 100);


                                        echo "<td>" . round($creditmixcredit_available, 1) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top:none ;"><div style='margin-top:-80px;'>
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                /*if (round($creditmixcredit_available, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 0 && round($creditmixcredit_available, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 10 && round($creditmixcredit_available, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 25 && round($creditmixcredit_available, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 50 && round($creditmixcredit_available, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 75 && round($creditmixcredit_available, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmixcredit_available, 0) > 90) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }*/
                                                if (round($creditmix, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 0 && round($creditmix, 0) < 11) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 10 && round($creditmix, 0) < 26) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 25 && round($creditmix, 0) < 51) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 50 && round($creditmix, 0) < 76) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 75 && round($creditmix, 0) < 91) {


                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($creditmix, 0) > 90) {

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


                                        if (round($creditmix, 0) >= 0 && round($creditmix, 0) < 11 ) {
                                            $comment1 = 'Alert. You have very low proportion of revolving credit line. You may obtain enhancement in credit limits of credit card or overdraft or explore new revolving facility limit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";

                                        }
                                        else if (round($creditmix, 0) > 10 && round($creditmix, 0) < 26) {
                                            $comment1 = 'You have low proportion of revolving credit line. You may accept enhancement in credit limits of credit card or overdraft (as and when available).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if (round($creditmix, 0) > 25 && round($creditmix, 0) < 51) {
                                            $comment1 = 'Great. You have appropriate mix of revolving line and term credit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if (round($creditmix, 0) > 50 && round($creditmix, 0) < 76) {
                                            $comment1 = 'Good. You have reasonable mix of revolving line and term credit.';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-good' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if (round($creditmix, 0) > 75 && round($creditmix, 0) < 100) {
                                            $comment1 = 'Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad' style='margin-top:-120px;'>".$comment."</p></td>";
                                        } else if (round($creditmix, 0) > 100) {

                                            $comment1 = 'Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).';
                                            $comment2 = '<br/>You have low unexhausted revolving credit limit left for contingencies.';
                                            $full = $comment1.$comment2;
                                            round($creditmixcredit_available, 0) <= 5 ?  $comment=$full  :  $comment=$comment1;
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>".$comment."</p></td>";
                                        }
                                        if (round($creditmixcredit_available, 0) <= 5) {
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {

                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype !== '10') {

                                                    $termamountallsum_tenor += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                }
                                                $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                if ($repayment_tenor != 0 && !is_array($repayment_tenor)) {
                                                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                } else {
                                                    $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                    switch ($loantype) {
                                                        case "0":
                                                            $repayment_tenor = '0';
                                                            break;
                                                        case "1":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "2":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "3":
                                                            $repayment_tenor = '180';
                                                            break;
                                                        case "4":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "5":
                                                            $repayment_tenor = '48';
                                                            break;
                                                        case "06":
                                                            $repayment_tenor = '24';
                                                            break;
                                                        case "07":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "08":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "09":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "10":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "11":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "12":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "13":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "14":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "15":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "16":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "17":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "18":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "19":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "20":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "31":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "32":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "33":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "34":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "35":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "43":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "51":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "52":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "53":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "54":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "55":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "56":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "57":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "58":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "59":
                                                            $repayment_tenor = '3';
                                                            break;
                                                        case "60":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "36":
                                                            $repayment_tenor = '6';
                                                            break;
                                                        case "37":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "38":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "39":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "61":
                                                            $repayment_tenor = '36';
                                                            break;

                                                    }
                                                }
                                                if ($repayment_tenor <= 24) {

                                                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                    if ($loantype == '10') {
                                                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                                                    } else {
                                                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    }

                                                    $revolving_amountsum_tenor += $revolving_amount;

                                                }

                                            }
                                        }

                                        //echo "<br>";

                                        $shortterm_credit = $termamountallsum_tenor + $revolving_amountsum_tenor;
                                        $shortcreditmix2 = (($revolving_amountsum_tenor / $shortterm_credit) * 100);


                                        echo "<td>" . round($shortcreditmix2, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;">
                                         <!-- <div style="width:100%; float:right !important;">
                                                <?php
                                               /*if (round($shortcreditmix2, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 0 && round($shortcreditmix2, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 25 && round($shortcreditmix2, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 50 && round($shortcreditmix2, 0) < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 75 && round($shortcreditmix2, 0) < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }*/

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>-->
                                        </td>
                                        <td style='border:none ;'></td>
                                        <?php
                                        /*
                                        if (round($shortcreditmix2, 0) >= 0 && round($shortcreditmix2, 0) <= 25) {
                                            echo "<td>You have low proportion of short/ medium term credit line.</td>";
                                        } else if (round($shortcreditmix2, 0) > 25 && round($shortcreditmix2, 0) <= 50) {
                                            echo "<td>Great. You have appropriate mix of short/ medium term and long term credit.</td>";
                                        } else if (round($shortcreditmix2, 0) > 50 && round($shortcreditmix2, 0) <= 75) {
                                            echo "<td>Good. You have reasonable mix of revolving line and term credit.</td>";
                                        } else if (round($shortcreditmix2, 0) > 75 && round($shortcreditmix2, 0) < 100) {
                                            echo "<td>Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).</td>";
                                        }*/


                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Medium Term Credit to Total Credit</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype !== '10') {

                                                    $termamountallsum_tenor_medium += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                } else {

                                                    $credit_amount_for_all = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }

                                                    $credit_limit_amount > $credit_amount_for_all ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_for_all;
                                                    $revolving_amountsum_for_all += $revolving_amount;
                                                }
                                                $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                if ($repayment_tenor != 0 && !is_array($repayment_tenor)) {
                                                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                } else {
                                                    $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                    switch ($loantype) {
                                                        case "0":
                                                            $repayment_tenor = '0';
                                                            break;
                                                        case "1":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "2":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "3":
                                                            $repayment_tenor = '180';
                                                            break;
                                                        case "4":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "5":
                                                            $repayment_tenor = '48';
                                                            break;
                                                        case "06":
                                                            $repayment_tenor = '24';
                                                            break;
                                                        case "07":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "08":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "09":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "10":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "11":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "12":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "13":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "14":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "15":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "16":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "17":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "18":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "19":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "20":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "31":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "32":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "33":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "34":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "35":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "43":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "51":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "52":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "53":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "54":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "55":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "56":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "57":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "58":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "59":
                                                            $repayment_tenor = '3';
                                                            break;
                                                        case "60":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "36":
                                                            $repayment_tenor = '6';
                                                            break;
                                                        case "37":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "38":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "39":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "61":
                                                            $repayment_tenor = '36';
                                                            break;

                                                    }
                                                }

                                                if ($repayment_tenor > 24 && $repayment_tenor < 60) {

                                                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                    if ($loantype == '10') {
                                                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                                                    } else {
                                                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    }

                                                    $revolving_amountsum_tenor_medium += $revolving_amount;

                                                }

                                            }
                                        }

                                        $mediumtermcredit = $termamountallsum_tenor_medium + $revolving_amountsum_for_all;
                                        $mediumcreditmix = (($revolving_amountsum_tenor_medium / $mediumtermcredit) * 100);


                                        echo "<td>" . round($mediumcreditmix, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom:none ;border-top:none ;">
                                            <!--<div style="width:100%; float:right !important;">
                                                <?php
                                                /*if (round($mediumcreditmix, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($mediumcreditmix, 0) > 0 && round($mediumcreditmix, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($mediumcreditmix, 0) > 25 && round($mediumcreditmix, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($mediumcreditmix, 0) > 50 && round($mediumcreditmix, 0) < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($mediumcreditmix, 0) > 75 && round($mediumcreditmix, 0) < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }*/

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>-->
                                        </td>
                                        <td style='border:none ;'></td>
                                        <?php
                                        /*
                                        if (round($mediumcreditmix, 0) >= 0 && round($mediumcreditmix, 0) <= 25) {
                                            echo "<td>You have low proportion of short/ medium term credit line.</td>";
                                        } else if (round($mediumcreditmix, 0) > 25 && round($mediumcreditmix, 0) <= 50) {
                                            echo "<td>Great. You have appropriate mix of short/ medium term and long term credit.</td>";
                                        } else if (round($mediumcreditmix, 0) > 50 && round($mediumcreditmix, 0) <= 75) {
                                            echo "<td>Good. You have reasonable mix of revolving line and term credit.</td>";
                                        } else if (round($mediumcreditmix, 0) > 75 && round($mediumcreditmix, 0) < 100) {
                                            echo "<td>Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).</td>";
                                        }
                                               */

                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td>Long Term Credit to Total Credit</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype !== '10') {

                                                    $termamountallsum_tenor_long += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                } else {

                                                    $credit_amount_for_all = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }

                                                    $credit_limit_amount > $credit_amount_for_all ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_for_all;
                                                    $revolving_amountsum_for_long += $revolving_amount;
                                                }
                                                $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                if ($repayment_tenor != 0 && !is_array($repayment_tenor)) {
                                                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                } else {
                                                    $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                    switch ($loantype) {
                                                        case "0":
                                                            $repayment_tenor = '0';
                                                            break;
                                                        case "1":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "2":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "3":
                                                            $repayment_tenor = '180';
                                                            break;
                                                        case "4":
                                                            $repayment_tenor = '240';
                                                            break;
                                                        case "5":
                                                            $repayment_tenor = '48';
                                                            break;
                                                        case "06":
                                                            $repayment_tenor = '24';
                                                            break;
                                                        case "07":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "08":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "09":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "10":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "11":
                                                            $repayment_tenor = '84';
                                                            break;
                                                        case "12":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "13":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "14":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "15":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "16":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "17":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "18":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "19":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "20":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "31":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "32":
                                                            $repayment_tenor = '60';
                                                            break;

                                                        case "33":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "34":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "35":
                                                            $repayment_tenor = '1';
                                                            break;
                                                        case "43":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "51":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "52":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "53":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "54":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "55":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "56":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "57":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "58":
                                                            $repayment_tenor = '36';
                                                            break;
                                                        case "59":
                                                            $repayment_tenor = '3';
                                                            break;
                                                        case "60":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "36":
                                                            $repayment_tenor = '6';
                                                            break;
                                                        case "37":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "38":
                                                            $repayment_tenor = '12';
                                                            break;
                                                        case "39":
                                                            $repayment_tenor = '60';
                                                            break;
                                                        case "61":
                                                            $repayment_tenor = '36';
                                                            break;

                                                    }
                                                }

                                                if ($repayment_tenor >= 60) {

                                                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                    if ($loantype == '10') {
                                                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                                                    } else {
                                                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    }

                                                    $revolving_amountsum_tenor_long += $revolving_amount;

                                                }

                                            }
                                        }


                                        $longtermcredit = $termamountallsum_tenor_long + $revolving_amountsum_for_long;
                                        $longcreditmix = (($revolving_amountsum_tenor_long / $longtermcredit) * 100);


                                        echo "<td>" . round($longcreditmix, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top:none;"><div style='margin-top:-80px;'>
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($shortcreditmix2, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 0 && round($shortcreditmix2, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 25 && round($shortcreditmix2, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 50 && round($shortcreditmix2, 0) < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($shortcreditmix2, 0) > 75 && round($shortcreditmix2, 0) < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:45%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>
                                       </div> </td>
                                        <?php

                                       if (round($shortcreditmix2, 0) >= 0 && round($shortcreditmix2, 0) <= 25) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>You have low proportion of short/ medium term credit line.</p></td>";
                                        } else if (round($shortcreditmix2, 0) > 25 && round($shortcreditmix2, 0) <= 50) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Great. You have appropriate mix of short/ medium term and long term credit.</p></td>";
                                        } else if (round($shortcreditmix2, 0) > 50 && round($shortcreditmix2, 0) <= 75) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Good. You have reasonable mix of revolving line and term credit.</p></td>";
                                        } else if (round($shortcreditmix2, 0) > 75 && round($shortcreditmix2, 0) < 100) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-90px;'>Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {

                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                switch ($loantype) {
                                                    case "0":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "1":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "2":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "3":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "4":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "5":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "06":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "07":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "08":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "09":
                                                        $accounttype = 'unsecured';
                                                        break;

                                                    case "10":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "11":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "12":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "13":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "14":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "15":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "16":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "17":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "18":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "19":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "20":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "31":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "32":
                                                        $accounttype = 'secured';
                                                        break;

                                                    case "33":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "34":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "35":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "43":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "51":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "52":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "53":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "54":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "55":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "56":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "57":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "58":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "59":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "60":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "36":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "37":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "38":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "39":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "61":
                                                        $accounttype = 'unsecured';
                                                        break;


                                                }


                                                if ($accounttype == 'secured') {

                                                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                    if ($loantype == '10') {
                                                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                                                    } else {
                                                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    }

                                                    $revolvingsecure += $revolving_amount;

                                                }

                                            }
                                        }

                                        $secure_credit = (($revolvingsecure / $adjusted_balance) * 100);


                                        echo "<td>" . round($secure_credit, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-bottom: none; ">
                                            <!--<div style="width:100%; float:right !important;">
                                                <?php
                                                /*if (round($secure_credit, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 0 && round($secure_credit, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 25 && round($secure_credit, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 50 && round($secure_credit, 0) < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 75 && round($secure_credit, 0) < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($secure_credit, 0) > 100) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }*/

                                                ?>
                                                <div
                                                    style="background:#fe0000; border-radius: 4px 0px 0px 4px;width:49%; float:left; padding:2px 1px; color:#fff;text-align:center;height: 10px;"></div>
                                                <div
                                                    style="background:#68bc0e;width:49%; float:left; padding:2px 1px; color:#fff; text-align:center;height: 10px;border-radius: 0px 4px 4px 0px;"></div>

                                            </div>-->
                                        </td>
                                        <td style="border:none;"></td>
                                        <?php
                                        /*
                                        if (round($creditmix, 0) >= 0 && round($creditmix, 0) <= 25) {
                                            echo "<td>You have low proportion of short/ medium term credit line.</td>";
                                        } else if (round($creditmix, 0) > 25 && round($creditmix, 0) <= 50) {
                                            echo "<td>Great. You have appropriate mix of short/ medium term and long term credit.</td>";
                                        } else if (round($creditmix, 0) > 50 && round($creditmix, 0) <= 75) {
                                            echo "<td>You have moderately high proportion of short/ medium term credit.</td>";
                                        } else if (round($creditmix, 0) > 75 && round($creditmix, 0) < 100) {
                                            echo "<td>You have low proportion of unsecured credit line.</td>";
                                        }
                                     */
                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Unsecured Facilities to Total Credit</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];


                                                switch ($loantype) {
                                                    case "0":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "1":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "2":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "3":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "4":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "5":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "06":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "07":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "08":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "09":
                                                        $accounttype = 'unsecured';
                                                        break;

                                                    case "10":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "11":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "12":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "13":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "14":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "15":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "16":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "17":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "18":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "19":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "20":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "31":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "32":
                                                        $accounttype = 'secured';
                                                        break;

                                                    case "33":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "34":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "35":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "43":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "51":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "52":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "53":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "54":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "55":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "56":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "57":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "58":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "59":
                                                        $accounttype = 'secured';
                                                        break;
                                                    case "60":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "36":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "37":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "38":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "39":
                                                        $accounttype = 'unsecured';
                                                        break;
                                                    case "61":
                                                        $accounttype = 'unsecured';
                                                        break;


                                                }


                                                if ($accounttype == 'unsecured') {

                                                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                                                    $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit) {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                    if ($loantype == '10') {
                                                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                                                    } else {
                                                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                    }

                                                    $revolvingunsecure += $revolving_amount;

                                                }

                                            }

                                        }

                                        $unsecure_credit = (($revolvingunsecure / $adjusted_balance) * 100);


                                        echo "<td>" . round($unsecure_credit, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;border-top: none;"><div style='margin-top:-50px;'>
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                /*if (round($unsecure_credit, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($unsecure_credit, 0) > 0 && round($unsecure_credit, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($unsecure_credit, 0) > 25 && round($unsecure_credit, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($unsecure_credit, 0) > 50 && round($unsecure_credit, 0) <= 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($unsecure_credit, 0) > 75 && round($unsecure_credit, 0) <= 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($unsecure_credit, 0) > 100) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }*/
                                                if (round($secure_credit, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 0 && round($secure_credit, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 25 && round($secure_credit, 0) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 50 && round($secure_credit, 0) < 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($secure_credit, 0) > 75 && round($secure_credit, 0) < 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($secure_credit, 0) > 100) {

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
                                        /*
                                        if (round($unsecure_credit, 0) >= 0 && round($unsecure_credit, 0) <= 25) {
                                            echo "<td>You have low proportion of short/ medium term credit line.</td>";
                                        } else if (round($unsecure_credit, 0) > 25 && round($unsecure_credit, 0) <= 50) {
                                            echo "<td>Great. You have appropriate mix of short/ medium term and long term credit.</td>";
                                        } else if (round($unsecure_credit, 0) > 50 && round($unsecure_credit, 0) <= 75) {
                                            echo "<td>You have moderately high proportion of short/ medium term credit.</td>";
                                        } else if (round($unsecure_credit, 0) > 75 && round($unsecure_credit, 0) <= 100) {
                                            echo "<td>You have low proportion of unsecured credit line.</td>";
                                        }*/

                                        if (round($secure_credit, 2) >= 0 && round($secure_credit, 2) <= 25) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have low proportion of secured credit line.</p></td>";
                                        } else if (round($secure_credit, 2) > 25 && round($secure_credit, 2) <= 50) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have reasonable mix of secured and unsecured credit.</p></td>";
                                        } else if (round($secure_credit, 2) > 50 && round($secure_credit, 2) <= 75) {
                                            echo "<td style='border:none ;'><p class='strip-good'style='margin-top:-50px;'>Great. You have appropriate mix of secured and unsecured credit.</p></td>";
                                        } else if (round($secure_credit, 2) > 75 && round($secure_credit, 2) < 100) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>You have low proportion of unsecured credit line.</p></td>";
                                        }


                                        ?>
                                    </tr>
                                    <!--Fixed Obligation to Income-->

                                    <tr>
                                        <td style="text-align: center;">8</td>
                                        <td>Fixed Obligation to Income</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                        $loan = $count - 1;
                                        $score = $result_array['SCORE']['BureauScore'];
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            $repayment_tenor_data = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                                                $repayment_tenor_data = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($repayment_tenor_data != 0 && !is_array($repayment_tenor_data)) {
                                                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                    switch ($loantype) {
                                                        case "1":

                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "2":

                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            break;
                                                        case "3":

                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            break;
                                                        case "4":

                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            break;
                                                        case "5":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;
                                                        case "06":

                                                            if ($score <= 500) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "07":

                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '13.50';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;
                                                        case "08":

                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "09":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;

                                                        case "10":

                                                            $interest = '10';

                                                        case "11":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }

                                                            break;
                                                        case "12":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "13":

                                                            if ($score <= 500) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            break;
                                                        case "14":

                                                            if ($score <= 500) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            break;
                                                        case "15":


                                                            $interest = '10';

                                                            break;
                                                        case "16":

                                                            $interest = '18';
                                                            break;
                                                        case "17":

                                                            if ($score <= 500) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "18":

                                                            $interest = '36';
                                                            break;
                                                        case "19":

                                                            $interest = '36';
                                                            break;
                                                        case "20":

                                                            $interest = '36';
                                                            break;
                                                        case "31":

                                                            $interest = '1';
                                                            break;
                                                        case "32":

                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;

                                                        case "33":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "34":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "35":

                                                            $interest = '18';
                                                            break;
                                                        case "43":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "51":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "52":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "53":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "54":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "55":

                                                            $interest = '1';
                                                            break;
                                                        case "56":

                                                            $interest = '0.75';
                                                            break;
                                                        case "57":

                                                            $interest = '0.50';
                                                            break;
                                                        case "58":

                                                            $interest = '0.75';
                                                            break;
                                                        case "59":

                                                            $interest = '10';
                                                            break;
                                                        case "60":

                                                            $interest = '10';
                                                            break;
                                                        case "36":

                                                            $interest = '12';
                                                            break;
                                                        case "37":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "38":

                                                            $interest = '11';
                                                            break;
                                                        case "39":

                                                            $interest = '11';
                                                            break;
                                                        case "61":

                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;

                                                    }
                                                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                                                } else {

                                                    switch ($loantype) {
                                                        case "0":
                                                            $repayment_tenor = '0';
                                                            break;
                                                        case "1":
                                                            $repayment_tenor = '84';
                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "2":
                                                            $repayment_tenor = '240';
                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            break;
                                                        case "3":
                                                            $repayment_tenor = '180';
                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            break;
                                                        case "4":
                                                            $repayment_tenor = '240';
                                                            if ($score <= 500) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '9';
                                                                break;
                                                            }
                                                            break;
                                                        case "5":
                                                            $repayment_tenor = '48';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;
                                                        case "06":
                                                            $repayment_tenor = '24';
                                                            if ($score <= 500) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "07":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '13.50';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;
                                                        case "08":
                                                            $repayment_tenor = '84';
                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "09":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;

                                                        case "10":
                                                            $repayment_tenor = '1';
                                                            $interest = '10';

                                                        case "11":
                                                            $repayment_tenor = '84';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }

                                                            break;
                                                        case "12":
                                                            $repayment_tenor = '12';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "13":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            break;
                                                        case "14":
                                                            $repayment_tenor = '12';
                                                            if ($score <= 500) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '2';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '1';
                                                                break;
                                                            }
                                                            break;
                                                        case "15":
                                                            $repayment_tenor = '36';

                                                            $interest = '10';

                                                            break;
                                                        case "16":
                                                            $repayment_tenor = '1';
                                                            $interest = '18';
                                                            break;
                                                        case "17":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '11';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '10';
                                                                break;
                                                            }
                                                            break;
                                                        case "18":
                                                            $repayment_tenor = '1';
                                                            $interest = '36';
                                                            break;
                                                        case "19":
                                                            $repayment_tenor = '1';
                                                            $interest = '36';
                                                            break;
                                                        case "20":
                                                            $repayment_tenor = '1';
                                                            $interest = '36';
                                                            break;
                                                        case "31":
                                                            $repayment_tenor = '1';
                                                            $interest = '1';
                                                            break;
                                                        case "32":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '12';
                                                                break;
                                                            }
                                                            break;

                                                        case "33":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "34":
                                                            $repayment_tenor = '60';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "35":
                                                            $repayment_tenor = '1';
                                                            $interest = '18';
                                                            break;
                                                        case "43":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "51":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "52":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "53":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "54":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "55":
                                                            $repayment_tenor = '36';
                                                            $interest = '1';
                                                            break;
                                                        case "56":
                                                            $repayment_tenor = '36';
                                                            $interest = '0.75';
                                                            break;
                                                        case "57":
                                                            $repayment_tenor = '36';
                                                            $interest = '0.50';
                                                            break;
                                                        case "58":
                                                            $repayment_tenor = '36';
                                                            $interest = '0.75';
                                                            break;
                                                        case "59":
                                                            $repayment_tenor = '3';
                                                            $interest = '10';
                                                            break;
                                                        case "60":
                                                            $repayment_tenor = '60';
                                                            $interest = '10';
                                                            break;
                                                        case "36":
                                                            $repayment_tenor = '6';
                                                            $interest = '12';
                                                            break;
                                                        case "37":
                                                            $repayment_tenor = '12';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;
                                                        case "38":
                                                            $repayment_tenor = '12';
                                                            $interest = '11';
                                                            break;
                                                        case "39":
                                                            $repayment_tenor = '60';
                                                            $interest = '11';
                                                            break;
                                                        case "61":
                                                            $repayment_tenor = '36';
                                                            if ($score <= 500) {
                                                                $interest = '20';
                                                                break;
                                                            }
                                                            if ($score > 500 && $score <= 600) {
                                                                $interest = '19';
                                                                break;
                                                            }
                                                            if ($score > 600 && $score <= 650) {
                                                                $interest = '18';
                                                                break;
                                                            }
                                                            if ($score > 650 && $score <= 700) {
                                                                $interest = '17';
                                                                break;
                                                            }
                                                            if ($score > 700 && $score <= 750) {
                                                                $interest = '16';
                                                                break;
                                                            }
                                                            if ($score > 750 && $score <= 800) {
                                                                $interest = '15';
                                                                break;
                                                            }
                                                            if ($score > 800 && $score <= 850) {
                                                                $interest = '14';
                                                                break;
                                                            }
                                                            if ($score > 850) {
                                                                $interest = '13';
                                                                break;
                                                            }
                                                            break;

                                                    }
                                                }
                                                if ($loantype != '10') {
                                                    $loanamount_highcredit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];

                                                    $t1 = (($loanamount_highcredit * ($interest / (1200))) * (pow((1 + ($interest / (1200))), $repayment_tenor)));
                                                    $t2 = ((pow((1 + ($interest / (12 * 100))), ($repayment_tenor))) - 1);


                                                    $shadow_emi = round(($t1 / $t2), 0);

                                                    $sum_emi_all += $shadow_emi;
                                                }


                                            }
                                        }
                                        $anual = ($income * 12);


                                        $fix_ob = (($sum_emi_all / $income) * 100);

                                        echo "<td>" . round($fix_ob, 0) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($fix_ob, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 0 && round($fix_ob, 0) <= 25) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 25 && round($fix_ob, 0) <= 40) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 40 && round($fix_ob, 0) <= 60) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 60 && round($fix_ob, 0) <= 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:40%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 75 && round($fix_ob, 0) <= 90) {


                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($fix_ob, 0) > 90) {

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
                                        if (round($fix_ob, 0) > 0 && round($fix_ob, 0) <= 25) {
                                            echo "<td><p class='strip-good'>Excellent. You have very prudent debt servicing capability.</p></td>";
                                        } else if (round($fix_ob, 0) > 25 && round($fix_ob, 0) <= 40) {
                                            echo "<td><p class='strip-good'>Great. You reasonable metrics debt servicing capability.</p></td>";
                                        } else if (round($fix_ob, 0) > 40 && round($fix_ob, 0) <= 60) {
                                            echo "<td><p class='strip-bad'>Alert. You are reaching the outer limits of prudent debt servicing capability.</p></td>";
                                        } else if (round($fix_ob, 0) > 60 && round($fix_ob, 0) <= 75) {
                                            echo "<td><p class='strip-bad'>Alert. You have high debt servicing obligations. Abstain from new term credit if not necessary.</p></td>";
                                        } else if (round($fix_ob, 0) > 75 && round($fix_ob, 0) <= 90) {
                                            echo "<td><p class='strip-bad'>Alert. You have high proportion of revolving credit line and low term credit. If you are rolling over credit card dues, you may instead avail term credit or convert part of the outstanding into term facility (ie. EMI facility).</p></td>";
                                        } else if (round($fix_ob, 0) > 100) {
                                            echo "<td><p class='strip-bad'>Alert. You have very high debt servicing obligations. Abstain from new term credit if not absolutely necessary. Reduce discretionary spending in order to retire.</p> </td>";
                                        }
                                        ?>
                                    </tr>


                                    <!--<tr><td>No of Credit Enquiry In 6 Months:</td>
                       <td><?= $result_array['CAPS']['CAPS_Summary']['CAPSLast180Days']; ?></td>
                   <td></td>
                   <td></td>
                   </tr>-->
                                    <!--no of active account-->
                                    <tr>
                                        <td style="text-align: center;">9</td>
                                        <td>No of Active Account</td>
                                        <td><?= $result_array['CAIS_Account']['CAIS_Summary']['Credit_Account']['CreditAccountActive']; ?></td>
                                        <td style="text-align: -webkit-auto;">
                                            <div class="scale-main">
                                                <?php
                                                $activeac = $result_array['CAIS_Account']['CAIS_Summary']['Credit_Account']['CreditAccountActive'];
                                                switch ($activeac) {
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
                                        if ($activeac < 6) {
                                            echo "<td><p class='strip-good'>Great! You are within the suggested range please do not cross the max limit. We advise you to stay within the suggest range to maintain a healthy credit score.</p></td>";
                                        } else if ($activeac == 6) {
                                            echo "<td><p class='strip-bad'>Alert! You have reached the maximum limit of suggested range. We advise you to stay within the suggested range to maintain a healthy credit score.</p></td>";
                                        } else if ($activeac > 6) {
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;

                                        $all_ali = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                                                $all_ali[$i] = $loantype;


                                            }
                                        }

                                        $all_count = count(array_unique($all_ali));

                                        echo "<td>" . $all_count . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($all_count == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count > 0 && $all_count <= 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count > 2 && $all_count <= 5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count > 5 && $all_count <= 8) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($all_count > 8) {

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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;

                                        $all_ali2 = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

                                            $all_ali2[$i] = $loantype;
                                        }

                                        $all_count2 = count(array_unique($all_ali2));

                                        echo "<td>" . $all_count2 . "</td>";


                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($all_count2 == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count2 > 0 && $all_count2 <= 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count2 > 2 && $all_count2 <= 5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($all_count2 > 5 && $all_count2 <= 8) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($all_count2 > 8) {

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
                                        /*if ($all_count >= 0 && $all_count <= 2) {
                                            echo "<td>Great. You are within limit. However, you have availed fewer types of credit and thus credit concentration is not diversified. You may avail different types of credit (according to your requirement) in order to improve your credit profile further.</td>";
                                        } else if ($all_count > 2 && $all_count <= 5) {
                                            echo "<td>Excellent. Your credit portfolio is aptly diversified with different types of credit.</td>";
                                        } else if ($all_count > 5 && $all_count <= 8) {
                                            echo "<td>Alert. You have availed different types of credit exceeding the prudent practice.</td>";
                                        } else if ($all_count > 8) {
                                            echo "<td>Alert. You have availed too many types of loans which signifies eagerness to credit. It is advised to reduce the credit products within prudent range.</td>";
                                        }*/
                                        if ($all_count >= 0 && $all_count <= 2) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Great. You are within limit. However, you have availed fewer types of credit and thus credit concentration is not diversified. You may avail different types of credit (according to your requirement) in order to improve your credit profile further.</p></td>";
                                        } else if ($all_count > 2 && $all_count <= 5) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Excellent. Your credit portfolio is aptly diversified with different types of credit.</p></td>";
                                        } else if ($all_count > 5 && $all_count <= 8) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have availed different types of credit exceeding the prudent practice.</p></td>";
                                        } else if ($all_count > 8) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>Alert. You have availed too many types of loans which signifies eagerness to credit. It is advised to reduce the credit products within prudent range.</p></td>";
                                        }

                                        ?>
                                    </tr>

                                    <!--noof enquiry-->
                                    <tr>
                                        <td style="text-align: center;">11</td>
                                        <td>No of Credit Enquiry In last 3 Months</td>
                                        <?php $enquiry3 = $result_array['CAPS']['CAPS_Summary']['CAPSLast90Days']; ?>
                                        <td><?= $result_array['CAPS']['CAPS_Summary']['CAPSLast90Days']; ?></td>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                switch ($enquiry3) {
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
                                        if ($enquiry3 >= '0' && $enquiry3 <= '1') {
                                            ?>
                                            <td><p class='strip-good'>Excellent. Minimal credit enquiry in the immediate past.
                                            </p></td>
                                            <?php
                                        } else if ($enquiry3 > '1' && $enquiry3 <= '2') {
                                            ?>
                                            <td><p class='strip-good'>Great. Within Limit.</p></td>
                                            <?php
                                        } else if ($enquiry3 > '2' && $enquiry3 <= '3') {
                                            ?>
                                            <td><p class='strip-good'>Good. Within reasonable limit.</p></td>
                                            <?php
                                        }else if ($enquiry3 > '3' && $enquiry3 <= '6') {
                                            ?>
                                            <td><p class='strip-good'>Alert. You have exceeded prudent limit for credit enquiry. Don�t apply for too many loans or with too many lenders for the same loan.</p></td>
                                            <?php
                                        }else if ($enquiry3 > '6') {
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
                                        $countcredit = count($result_array['CAPS']['CAPS_Application_Details']);


                                        for ($i = 0; $i <= $countcredit; $i++) {

                                            $loandate = $result_array['CAPS']['CAPS_Application_Details'][$i]['Date_of_Request'];
                                            $ex = date('Y-m-d', strtotime($loandate));


                                            $statrt = date('Y-m-d');

                                            $end = date('Y-m-d', strtotime('-1 years'));

                                            if ($ex < $statrt && $ex > $end) {

                                                $enquiry_credit += 1;
                                            }
                                        }

                                        $avail_loan = ($enquiry_credit / 4);

                                        echo "<td>" . $avail_loan . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($avail_loan == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($avail_loan > 0 && $avail_loan <= 1) {

                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($avail_loan > 1 && $avail_loan < 1.5) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if ($avail_loan > 1.5) {

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
                                        if ($avail_loan >= 0 && $avail_loan <= 1) {
                                            echo "<td><p class='strip-good'>Great. Within Limit.</p></td>";
                                        } else if ($avail_loan > 1 && $avail_loan < 1.5) {
                                            echo "<td>Excellent. Satisfactory success rate for loans applied.</td>";
                                        } else if ($avail_loan > 1.5) {
                                            echo "<td>Alert. Don�t apply with many lenders for the same loan. Know your eligibility before applying.</td>";
                                        }
                                        ?>
                                    </tr>

                                    <!-- History of credit (oldest credit account)-->
                                    <tr>
                                        <td style="text-align: center;">13</td>
                                        <td> History of credit (oldest credit account)</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                            $open_date = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Open_Date'];
                                            $ex = date('Y-m-d', strtotime($open_date));
                                            $opendate[$i] = $ex;
                                        }

                                        usort($opendate, function ($a, $b) {
                                            $dateTimestamp1 = strtotime($a);
                                            $dateTimestamp2 = strtotime($b);

                                            return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
                                        });
                                        $givendate = strtotime("2018-06-30");
                                        $mindate = strtotime($opendate[0]);
                                        $datediff = ($givendate - $mindate);
                                        $finaldate = round($datediff / (60 * 60 * 24));
                                        $history = ($finaldate / 365);


                                        echo "<td>" . round($history, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($history, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:20%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($history, 0) > 0 && round($history, 0) < 2) {

                                                    echo '<div style="font-size:15px;text-align:right; width:30%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($history, 0) > 1 && round($history, 0) <= 3) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if (round($history, 0) > 3) {

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
                                        if (round($history, 0) >= 0 && round($history, 0) < 2) {
                                            echo "<td><p class='strip-bad'>Recently started availing credit. Keep debt servicing track record intact for gradual improvement in credit profile over time.</p></td>";
                                        } else if (round($history, 0) > 1 && round($history, 0) <= 3) {
                                            echo "<td><p class='strip-good'>Reasonable history of credit. The credit profile would gradually improve over time on timely servicing of loans.</p></td>";
                                        } else if (round($history, 0) > 3) {
                                            echo "<td><p class='strip-good'>Great. You have fairly long history of availing credit.</p></td>";
                                        }
                                        ?>
                                    </tr>

                                    <!-- Limit Breach-->
                                    <tr>
                                        <td style="text-align: center;">14</td>
                                        <td> Limit Breach</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                                                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                                                if ($loantype == '10') {
                                                    $current_balance = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];

                                                    $credit_limit_amount1 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                    if ($credit_limit_amount1) {
                                                        $hcredit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                    } else {
                                                        $hcredit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }


                                                    if ($current_balance > $hcredit_limit_amount) {

                                                        $limit_bre += 1;
                                                    }

                                                }
                                            }

                                        }


                                        echo "<td>" . $limit_bre . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($limit_bre == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($limit_bre > 0 && $limit_bre <= 2) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }


                                                if ($limit_bre >= 3) {

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
                                        if ($limit_bre == 0) {
                                            echo "<td><p class='strip-good'>Excellent. You have remained within limit of each facility.</p></td>";
                                        } else if ($limit_bre > 0 && $limit_bre <= 2) {
                                            echo "<td><p class='strip-bad'>Alert. You have breached credit limits of certain facilities.</p></td>";
                                        } else if ($limit_bre > 2) {
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

                                            $current_balance += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            $overdue = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

                                            if ($overdue) {

                                                $overdueall += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];
                                            }
                                            if ($loantype == '10') {

                                                $credit_amount_credit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                                $credit_limit2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                                                if ($credit_limit2) {
                                                    $credit_limit_amount2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                                                } else {
                                                    $credit_limit_amount2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                                                }

                                                $credit_limit_amount2 > $credit_amount_credit ? $revolving_amount2 = $credit_limit_amount2 : $revolving_amount2 = $credit_amount_credit;
                                                $revolving_amountsum2 += $revolving_amount2;
                                                $overdue2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

                                                if ($overdue2 == 0 || is_array($overdue2)) {

                                                    $credit_limit_amount2 > $credit_amount_credit ? $revolving_amount2 = $credit_limit_amount2 : $revolving_amount2 = $credit_amount_credit;
                                                    $revolvingall += $revolving_amount2;
                                                }

                                            }


                                        }

                                        //echo $overdueall ;
                                        // echo "<br>";
                                        // echo $revolving_amountsum2;
                                        // echo "<br>";
                                        $obligation = ($revolving_amountsum2 - $revolvingall);
                                        $p16 = ($obligation * (5 / 100));
                                        $xy = (($overdueall / ($p16 + $sum_emi_all)) * 100);
                                        $overdue_to_obl = round($xy, 0);

                                        echo "<td>" . $overdue_to_obl . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($overdue_to_obl == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($overdue_to_obl > 0 && $overdue_to_obl <= 25) {
                                                    echo '<div style="font-size:15px;text-align:right; width:80%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obl > 25 && $overdue_to_obl <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:60%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obl > 50 && $overdue_to_obl <= 75) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obl > 75 && $overdue_to_obl <= 100) {
                                                    echo '<div style="font-size:15px;text-align:right; width:35%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if ($overdue_to_obl > 100) {

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
                                        /*
                                        if ($overdue_to_obl == 0) {
                                            echo "<td>Excellent. No overdues.</td>";
                                        } else if ($overdue_to_obl > 0 && $limit_bre <= 25) {
                                            echo "<td>Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.</td>";
                                        } else if ($overdue_to_obl > 25 && $overdue_to_obl <= 50) {
                                            echo "<td>Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.</td>";
                                        } else if ($overdue_to_obl > 50 && $overdue_to_obl <= 75) {
                                            echo "<td>Alert. Overdues impact the credit profile severely. Reduce discretionary spending. Clear the overdues at the earliest.</td>";
                                        } else if ($overdue_to_obl > 75 && $overdue_to_obl <= 100) {
                                            echo "<td>Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.</td>";
                                        } else if ($overdue_to_obl > 100) {
                                            echo "<td>Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.</td>";
                                        }*/
                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td>Overdue to Monthly Income</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

                                            $current_balance += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                                            $overdue = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

                                            if ($overdue) {

                                                $overdueall2 += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];
                                            }


                                        }

                                        //echo $overdueall ;
                                        // echo "<br>";
                                        // echo $revolving_amountsum2;
                                        // echo "<br>";
                                        $monthly_income_overdue = (($overdueall2 / $income) * 100);


                                        echo "<td>" . round($monthly_income_overdue, 2) . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if (round($monthly_income_overdue, 0) == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($monthly_income_overdue, 0) > 0 && round($monthly_income_overdue, 2) <= 25) {
                                                    echo '<div style="font-size:15px;text-align:right; width:75%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if (round($monthly_income_overdue, 0) > 25 && round($monthly_income_overdue, 2) <= 50) {
                                                    echo '<div style="font-size:15px;text-align:right; width:50%;" aria-hidden="true">&#9660;</div>';
                                                }
                                                if (round($monthly_income_overdue, 0) > 50) {

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
                                       /* if (round($monthly_income_overdue, 0) == 0) {
                                            echo "<td>Excellent. No overdues.</td>";
                                        } else if (round($monthly_income_overdue, 0) > 0 && round($monthly_income_overdue, 2) <= 25) {
                                            echo "<td>Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.</td>";
                                        } else if (round($monthly_income_overdue, 0) > 25 && round($monthly_income_overdue, 2) <= 50) {
                                            echo "<td>Alert. Overdues impact the credit profile severely. Reduce discretionary spending. Clear the overdues at the earliest.</td>";
                                        } else if (round($monthly_income_overdue, 0) > 50) {
                                            echo "<td>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.</td>";
                                        }*/

                                        if ($overdue_to_obl == 0) {

                                            $comment1 = 'Excellent. No overdues.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                           if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
                                           {
                                               echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                           }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obl > 0 && $limit_bre <= 25) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                            if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obl > 25 && $overdue_to_obl <= 50) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                            if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }

                                        }
                                        else if ($overdue_to_obl > 50 && $overdue_to_obl <= 75) {

                                            $comment1 = 'Alert. Overdues impact the credit profile severely. Reduce discretionary spending. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                            if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }
                                        } else if ($overdue_to_obl > 75 && $overdue_to_obl <= 100) {

                                            $comment1 = 'Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                            if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
                                            {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$full."</p></td>";
                                            }
                                            else {
                                                echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-50px;'>".$comment1."</p></td>";

                                            }
                                        } else if ($overdue_to_obl > 100) {

                                            $comment1 = 'Caution. You have very high overdue position. Overdues impact the credit profile severely. Reduce discretionary spending. Liquidate surplus assets. Clear the overdues at the earliest.';
                                            $comment2 = '<br/>Your overdue position is substantially high. You need to take drastic steps to bring back financial discipline. Eliminate discretionary spending and liquidate surplus/ unutilized assets in order to maintain solvency.';
                                            $full = $comment1.$comment2;
                                            $condition = (round($monthly_income_overdue, 0)+round($fix_ob, 0));
                                            if(round($monthly_income_overdue, 0) > 50 && $condition > 100)
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
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

                                            for ($j = 0; $j <= $acount_history; $j++) {
                                                $current_year = date("Y");
                                                $previous_year = date("Y", strtotime("-1 year"));


                                                $overdue_year = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                                                $overdue_month = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                                                if ($overdue_year == $current_year && $overdue_month <= '06') {
                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                                                    if ($overduedates != '0' && !is_array($overduedates)) {
                                                        $alloverdue += 1;
                                                    }
                                                }
                                                if ($overdue_year == $previous_year && $overdue_month == '12') {
                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                                                    if ($overduedates != '0' && !is_array($overduedates)) {
                                                        $alloverdue2 += 1;
                                                    }
                                                }
                                            }
                                        }

                                        $delay6 = ($alloverdue + $alloverdue2);
                                        // echo "<br>";
                                        // echo $revolving_amountsum2;
                                        // echo "<br>";


                                        echo "<td>" . $delay6 . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($delay6 == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($delay6 > 0) {
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
                                        <?php
                                         /*if ($delay6 == 0) {
                                            echo "<td>Excellent. Your past debt servicing track record is impeccable.</td>";
                                        } else if ($delay6 > 0) {
                                            echo "<td>Alert. You have delayed servicing of debt in the past (22 instances in last 6 months and 29 instances in past 12 months). in future, always make debt payment within due date, in order to improve credit profile.</td>";
                                        }*/


                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">b.</td>
                                        <td> Number of instances of delay in past 12 months</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

                                            for ($j = 0; $j <= $acount_history; $j++) {
                                                $current_year = date("Y");
                                                $previous_year = date("Y", strtotime("-1 year"));


                                                $overdue_year = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                                                $overdue_month = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                                                if ($overdue_year == $current_year && $overdue_month <= '06') {
                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                                                    if ($overduedates != '0' && !is_array($overduedates)) {

                                                        $alloverdue11 += 1;
                                                    }
                                                }
                                                if ($overdue_year == $previous_year && $overdue_month >= '06') {

                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                                                    if ($overduedates != '0' && !is_array($overduedates)) {


                                                        $alloverdue12 += 1;
                                                    }
                                                }

                                            }


                                        }

                                        $delay12 = ($alloverdue11 + $alloverdue12);

                                        echo "<td>" . $delay12 . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($delay12 == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($delay12 > 0) {
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
                                        <?php
                                        /*if ($delay12 == 0) {
                                            echo "<td>Excellent. Your past debt servicing track record is impeccable.</td>";
                                        } else if ($delay12 > 0) {
                                            echo "<td>Alert. You have delayed servicing of debt in the past (22 instances in last 6 months and 29 instances in past 12 months). in future, always make debt payment within due date, in order to improve credit profile.</td>";
                                        }*/


                                        ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">c.</td>
                                        <td> Number of instances of delay in past 36 months</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;
                                        $opendate = array();
                                        for ($i = 0; $i <= $loan; $i++) {
                                            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

                                            for ($j = 0; $j <= $acount_history; $j++) {
                                                $current_year = date("Y");
                                                $previous_year = date("Y", strtotime("-1 year"));


                                                $overdue_year = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                                                $overdue_month = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                                                if ($overdue_year == $current_year && $overdue_month <= '06') {
                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                                                    if ($overduedates != '0' && !is_array($overduedates)) {

                                                        //echo $overduedates;
                                                        // echo "<br>";
                                                        $alloverdue13 += 1;
                                                    }
                                                }
                                                if ($overdue_year == $previous_year && $overdue_month >= '01') {

                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                                                    if ($overduedates != '0' && !is_array($overduedates)) {


                                                        $alloverdue23 += 1;
                                                    }
                                                }
                                                $pre_previous = date("Y", strtotime("-2 year"));
                                                if ($overdue_year == $pre_previous && $overdue_month >= '06') {

                                                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                                                    if ($overduedates != '0' && !is_array($overduedates)) {


                                                        $alloverdue33 += 1;
                                                    }
                                                }

                                            }


                                        }

                                        $delay13 = ($alloverdue13 + $alloverdue23 + $alloverdue33);
                                        // echo "<br>";
                                        // echo $revolving_amountsum2;
                                        // echo "<br>";


                                        echo "<td>" . $delay13 . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($delay12 == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($delay12 > 0) {
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
                                        /*if ($delay12 == 0) {
                                            echo "<td>Excellent. Your past debt servicing track record is impeccable.</td>";
                                        } else if ($delay12 > 0) {
                                            echo "<td>Alert. You have delayed servicing of debt in the past (22 instances in last 6 months and 29 instances in past 12 months). in future, always make debt payment within due date, in order to improve credit profile.</td>";
                                        }*/
                                        if ($delay6 == 0) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>Excellent. Your past debt servicing track record is impeccable.</p></td>";
                                        } else if ($delay6 > 0) {
                                            echo "<td style='border:none ;'><p class='strip-bad'style='margin-top:-120px;'>Alert. You have delayed servicing of debt in the past (22 instances in last 6 months and 29 instances in past 12 months). in future, always make debt payment within due date, in order to improve credit profile.</p></td>";
                                        }


                                        ?>
                                    </tr>
                                    <!-- Past instances of settlement/ write-off-->

                                    <tr>
                                        <td style="text-align: center;">17</td>
                                        <td> Past instances of settlement/ write-off</td>
                                        <?php
                                        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);

                                        $loan = $count - 1;

                                        for ($i = 0; $i <= $loan; $i++) {
                                            $status_loan  = '00, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 79, 81, 85, 86, 87, 88, 90, 91, 93, 97';
                                            $status_loan = explode(',', $status_loan);
                                            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                            if (in_array($loanstatus,$status_loan))
                                            {
                                                $settlement += 1;
                                            }
                                            else{
                                                $settlement = 0;
                                            }
                                        }

                                        echo "<td>" . $settlement . "</td>";

                                        ?>
                                        <td style="text-align: -webkit-auto;">
                                            <div style="width:100%; float:right !important;">
                                                <?php
                                                if ($settlement == 0) {

                                                    echo '<div style="font-size:15px;text-align:right; width:100%;" aria-hidden="true">&#9660;</div>';
                                                }

                                                if ($settlement > 0) {
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
                                        if ($settlement == 0) {
                                            echo "<td><p class='strip-good'>Excellent. You do not have any record of compromise/ settlement or write-offs by lenders.</p></td>";
                                        } else if ($settlement > 0) {
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
                                    $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
                                    $loan = $count - 1;
                                    $bad_message = "<p class='strip-bad'style=''>Alert! You
                                                            have
                                                            crossed the maximum limit of suggested range which is
                                                            affecting
                                                            your credit score. We advise you to stay within the
                                                            suggested
                                                            range to maintain a healthy credit score.</p>";
                                    for ($i = 0; $i <= $loan; $i++) {
                                        $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
                                        if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {


                                            ?>
                                            <!--Over Due Date-->
                                            <?php
                                            $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];
                                            if ($days) {
                                                ?>

                                                <tr>
                                                    <td></td>
                                                    <td> <?= $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name']; ?>
                                                        (<?= $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Number']; ?>
                                                        )
                                                    </td>

                                                    <td>

                                                        <?php
                                                        $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];
                                                        if (is_array($days)) {
                                                            echo '0';
                                                        } else {
                                                            echo $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];

                                                        }

                                                        ?>
                                                        Days
                                                    </td>


                                                    <td style="text-align: -webkit-auto;">
                                                        <div style="width:100%; float:right !important;">
                                                            <?php
                                                            if (is_array($days)) {
                                                                $days = '0';
                                                            } else {
                                                                $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];
                                                            }
                                                            if ($days > 0) {
                                                                echo '<div style="font-size:15px;text-align:right; width:15%;" aria-hidden="true">&#9660;</div>';
                                                            } elseif ($days == '0' || $days == '') {
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
                                                    if ($days == 0) {
                                                        ?>
                                                        <td style='font-weight: 400;border: 1px solid #ddd;'>Great! You
                                                            are
                                                            within the suggested range please do not cross the max
                                                            limit. We
                                                            advise you to stay within the suggest range to maintain a
                                                            healthy credit score.
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>

                                                        <td style='border:none ;'>
                                                            <?php echo $bad_message; unset($bad_message); ?>
                                                        </td>
                                                        <?php
                                                    }

                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }

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
            <?php
        }
        ?>
        </div>
    </div>
        <script src="<?=base_url();?>assets/js/d3.min.js"></script>
        <script src="<?=base_url();?>assets/js/d4.js"></script>
        <script>
            (function() {
                var Needle, arc, arcEndRad, arcStartRad, barWidth, chart, chartInset, degToRad, el, endPadRad, height, i, margin, needle, numSections, padRad, percToDeg, percToRad, percent, radius, ref, sectionIndx, sectionPerc, startPadRad, svg, totalPercent, width;


                percent = <?php echo ((($result_array['SCORE']['BureauScore']-300)/600));?>;

                barWidth = 40;


                numSections = 5;


                // / 2 for HALF circle
                sectionPerc = 1 / numSections / 2;


                padRad = 0.05;

                chartInset = 10;
                // start at 270deg
                totalPercent = .75;


                el = d3.select('.chart-gauge');


                margin = {
                    top: 0,
                    right: 20,
                    bottom: 10,
                    left: 20
                };


                width = el[0][0].offsetWidth - margin.left - margin.right;


                height = width;


                radius = Math.min(width, height) / 2;


                percToDeg = function(perc) {
                    return perc * 360;
                };


                percToRad = function(perc) {
                    return degToRad(percToDeg(perc));
                };


                degToRad = function(deg) {
                    return deg * Math.PI / 180;
                };


                svg = el.append('svg').attr('width', width + margin.left + margin.right).attr('height', height + margin.top + margin.bottom);


                chart = svg.append('g').attr('transform', `translate(${(width + margin.left) / 2}, ${(height + margin.top) / 2})`);


                // build gauge bg
                for (sectionIndx = i = 1, ref = numSections; (1 <= ref ? i <= ref : i >= ref); sectionIndx = 1 <= ref ? ++i : --i) {if (window.CP.shouldStopExecution(1)){break;}
                    arcStartRad = percToRad(totalPercent);
                    arcEndRad = arcStartRad + percToRad(sectionPerc);
                    totalPercent += sectionPerc;
                    startPadRad = sectionIndx === 0 ? 0 : padRad / 2;
                    endPadRad = sectionIndx === numSections ? 0 : padRad / 2;
                    arc = d3.svg.arc().outerRadius(radius - chartInset).innerRadius(radius - chartInset - barWidth).startAngle(arcStartRad + startPadRad).endAngle(arcEndRad - endPadRad);
                    chart.append('path').attr('class', `arc chart-color${sectionIndx}`).attr('d', arc);
                }
                window.CP.exitedLoop(1);




                Needle = class Needle {
                    constructor(len, radius1) {
                        this.len = len;
                        this.radius = radius1;
                    }


                    drawOn(el, perc) {
                        el.append('circle').attr('class', 'needle-center').attr('cx', 0).attr('cy', 0).attr('r', this.radius);
                        return el.append('path').attr('class', 'needle').attr('d', this.mkCmd(perc));
                    }


                    animateOn(el, perc) {
                        var self;
                        self = this;
                        return el.transition().delay(500).ease('elastic').duration(3000).selectAll('.needle').tween('progress', function() {
                            return function(percentOfPercent) {
                                var progress;
                                progress = percentOfPercent * perc;
                                return d3.select(this).attr('d', self.mkCmd(progress));
                            };
                        });
                    }


                    mkCmd(perc) {
                        var centerX, centerY, leftX, leftY, rightX, rightY, thetaRad, topX, topY;
                        thetaRad = percToRad(perc / 2); // half circle
                        centerX = 0;
                        centerY = 0;
                        topX = centerX - this.len * Math.cos(thetaRad);
                        topY = centerY - this.len * Math.sin(thetaRad);
                        leftX = centerX - this.radius * Math.cos(thetaRad - Math.PI / 2);
                        leftY = centerY - this.radius * Math.sin(thetaRad - Math.PI / 2);
                        rightX = centerX - this.radius * Math.cos(thetaRad + Math.PI / 2);
                        rightY = centerY - this.radius * Math.sin(thetaRad + Math.PI / 2);
                        return `M ${leftX} ${leftY} L ${topX} ${topY} L ${rightX} ${rightY}`;
                    }


                };


                needle = new Needle(60, 15);


                needle.drawOn(chart, 0);


                needle.animateOn(chart, percent);


            }).call(this);
        </script>