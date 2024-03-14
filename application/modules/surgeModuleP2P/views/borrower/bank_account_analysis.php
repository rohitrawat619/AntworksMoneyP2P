<style>
.lender-dtls {width:100%; float:left; margin-top:15px; padding:0;}
.lender-dtls li {width:35%; float:left; font-size:14px; padding:5px; list-style:none;}
.lender-dtls li:nth-child(odd) {width:65%; font-weight:bold;}

</style>
<div class="mytitle row">
    <div class="left col-md-4">
        <h1><?=$pageTitle;?></h1>
        <?=getNotificationHtml();?>
    </div>
</div>
<?php if($result){?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box p-0">
                <!-- .left-right-aside-column-->
                <div class="page-aside">
                    <!-- .left-aside-column-->
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <ul class="lender-dtls">
                                <li>Bank Name:</li>
                                <li>-- --</li>
                                <li>Statement Period</li>
                                <li><?php echo $result['metaData']['duration']['fromDate']; ?> to <?php echo $result['metaData']['duration']['toDate']; ?></li>
                                <li>Account Number</li>
                                <li><?php echo $result['metaData']['accountNumber']; ?></li>
                                <li>Current Balance</li>
                                <li><?php echo $result['metaData']['currentBalance']; ?></li>
                                <li>Last Transaction Date</li>
                                <li><?php echo $result['metaData']['lastTransactionSeen']; ?></li>
                                <li>Average Daily Balance</li>
                                <li>5000</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="lender-dtls">
                                <li>Avg Daily Balance</li>
                                <li><?php echo $result['adbDetails']['avgDailyBalance']; ?></li>
                                <li>Average Expenses</li>
                                <li><?php echo $result['categoryDetails']['expense']['avgExpense']; ?></li>
                                <li>Total Credit</li>
                                <li><?php echo $result['categoryDetails']['transfer']['totalCredit']; ?></li>
                                <li>Total Debit</li>
                                <li><?php echo $result['categoryDetails']['transfer']['totalDebit']; ?></li>
                                <li>Expense Income Ratio</li>
                                <li><?php echo $result['categoryDetails']['expenseIncomeRatio']['expenseToIncomeRatio']; ?></li>
                                <li>Total Salary</li>
                                <li><?php echo $result['categoryDetails']['salary']['totalSalary']; ?></li>
                                <li>Average Salary</li>
                                <li><?php echo $result['categoryDetails']['salary']['avgSalary']; ?></li>
                            </ul>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h4>Average Monthly Balance</h4>
                                <table class="table table-bordered p2ploans" data-page-size="100">
                                    <tr>
                                        <th>Month</th>
                                        <th>Average Amount</th>
                                        <th>Minimum Balance</th>
                                        <th>Maximum Balance</th>
                                        <th>End of Month Balance</th>
                                        <th>Total Credits</th>
                                        <th>Total Debits</th>
                                    </tr>
                                    <?php if($result['ambDetails']){ $i = 0; foreach($result['ambDetails'] AS $monthly_details) {?>
                                        <tr>
                                            <td><?=$monthly_details['monthName']?> - <?=$monthly_details['year']?></td>
                                            <td><?=$monthly_details['avgAmount']?></td>
                                            <td><?=$monthly_details['minBalance']?></td>
                                            <td><?=$monthly_details['maxBalance']?></td>
                                            <td><?=$monthly_details['eomBalance']?></td>
                                            <td><?php echo  @$result['monthlyTotal']['creditTotalList'][$i]['total']?$result['monthlyTotal']['creditTotalList'][$i]['total']:'N/A'; ?></td>
                                            <td><?php echo @$result['monthlyTotal']['creditTotalList'][$i]['total']?$result['monthlyTotal']['debitTotalList'][$i]['total']:'N/A'; ?></td>
                                        </tr>
                                        <? $i++; }} ?>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h4>Transaction Details</h4>
                                <table class="table table-bordered p2ploans" data-page-size="100">
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Counts</th>
                                        <th>Amount</th>
                                    </tr>
                                    <?php foreach ($result['transactionDataObjects'] AS $item){?>
                                        <tr>
                                            <td><?php echo $item['txnListType'] ?></td>
                                            <td><?php echo $item['count'] ?></td>
                                            <td><?php echo $item['totalAmt'] ?></td>
                                        </tr>
                                    <? } ?>


                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <div class="table-responsive">
                                <table class="table table-bordered p2ploans" data-page-size="100">
                                    <tr>
                                        <th>Top 5 Debits</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    <?php if($result['transactionDataObjects']){foreach($result['transactionDataObjects'] AS $transaction_details) {
                                        if($transaction_details['txnListType'] == 'Top 5 Debits'){
                                            $count = $transaction_details['count'];
                                            for ($i = 0; $i<$count; $i++)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['dateToString'] ?></td>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['originalDescription'] ?></td>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['amount'] ?></td>
                                                </tr>
                                            <?php }}
                                    }} ?>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <div class="table-responsive">
                                <table class="table table-bordered p2ploans" data-page-size="100">
                                    <tr>
                                        <th>Top 5 Credits</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    <?php if($result['transactionDataObjects']){foreach($result['transactionDataObjects'] AS $transaction_details) {
                                        if($transaction_details['txnListType'] == 'Top 5 Credits'){
                                            $count = $transaction_details['count'];
                                            for ($i = 0; $i<$count; $i++)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['dateToString'] ?></td>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['originalDescription'] ?></td>
                                                    <td><?php echo $transaction_details['transactionDataObjects'][$i]['amount'] ?></td>
                                                </tr>
                                            <?php }}
                                    }} ?>
                                </table>
                            </div>
                        </div>

                    </div>



                    <!-- /.left-aside-column-->
                    <div class="col-md-12 hidden">
                        <div class="right-page-header">

                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="col-md-12">
                                <div class="col-md-12">



                                    <div class="form-bg">
                                        <div class="table-responsive">
                                            <table class="table m-t-30 table-bordered p2ploans" data-page-size="100">
                                                <tr class="hidden">
                                                    <th class="col-md-2">Lender Name</th>
                                                    <th class="col-md-2">Amount in Escrow</th>
                                                    <th class="col-md-2">Amount of Loan Approved but not Disbursed</th>
                                                    <th class="col-md-2">Balance</th>
                                                    <th class="col-md-2" colspan="2">Transfer to Own Bank Account</th>
                                                </tr>
                                                <tr class="hidden">
                                                    <td><?php echo $lender_info->LENDERNAME; ?></td>
                                                    <td><?php echo $lender_info->escrow_amount; ?></td>
                                                    <td><?php echo $not_disburse_amount->TOTAL_AMOUNT_NOT_DISBURSE; ?></td>
                                                    <td><?php echo $lender_info->balance_amount; ?></td>

                                                    <td colspan="2">
                                                        <input type="text" class="form-control" id="Amount" placeholder="Enter Amount">
                                                        <div class="text-center"><button type="submit" class="btn btn-primary btnp2p">Submit</button></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="p2ploans-hd" colspan="12">Loan Extended</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">Total Principal Outstanding</th>
                                                    <th colspan="6">Out of Aggregate Loan Disbursed</th>

                                                </tr>
                                                <tr class="text-center">
                                                    <td colspan="3">Rs. 50,000/-</td>
                                                    <td colspan="3">Rs. 40,000/-</td>
                                                </tr>
                                                <tr>
                                                    <th class="p2ploans-hd" colspan="14">Loan Book</th>
                                                </tr>
                                                <?php if($loan_list) { foreach($loan_list AS $loan) {?>
                                                    <tr>
                                                        <th>Loan Number</th>
                                                        <th>Date of Agreement</th>
                                                        <th>Loan Principal Amount</th>
                                                        <th>Rate of Interest</th>
                                                        <th>Total Number of EMI</th>
                                                        <th>Overdue EMI</th>
                                                        <th>Borrower Name</th>
                                                        <th>Date of Disbursement</th>
                                                        <th>Principal Outstanding</th>
                                                        <th>Each EMI Amount</th>
                                                        <th>Number of EMI Serviced</th>
                                                        <th>Penal Interest</th>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $loan->loan_account_number; ?></td>
                                                        <td><?php echo $loan->date_of_agreement; ?></td>
                                                        <td><?php echo (($loan->LOANAMOUNT*$loan->APPROVERD_LOAN_AMOUNT)/100); ?></td>
                                                        <td><?php echo $loan->LOAN_Interest_rate; ?>%</td>
                                                        <?php $emai_total = $this->Lendermodel->total_no_of_emai($loan->bid_registration_id) ?>
                                                        <td><?php echo $emai_total->TOTAL_EMI; ?></td>
                                                        <?php $emai_overdue_total = $this->Lendermodel->total_no_of_overdue_emai($loan->bid_registration_id) ?>
                                                        <td><?php echo $emai_overdue_total->TOTAL_EMI_OVERDUE; ?></td>
                                                        <td><?php echo $loan->BORROWERNAME; ?></td>
                                                        <td><?php echo $loan->Date_of_Disbursement; ?></td>
                                                        <?php //Principal Outstanding ?>
                                                        <td></td>
                                                        <?php /*Each EMI AMOUNT*/ $emi_amount = $this->Lendermodel->each_EMI_amount($loan->bid_registration_id) ?>
                                                        <td><?php echo $emi_amount->emi_amount; ?></td>
                                                        <?php /*Each EMI AMOUNT*/ $no_EMI_Serviced = $this->Lendermodel->No_EMI_Serviced($loan->bid_registration_id) ?>
                                                        <td><?php echo $no_EMI_Serviced->No_EMI_Serviced; ?></td>
                                                        <td></td>
                                                    </tr>
                                                <?php } } ?>
                                                <tr>
                                                    <th class="p2ploans-hd" colspan="6">Total</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-center">60,0000</td>
                                                </tr>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .left-aside-column-->

                </div>
                <!-- /.left-right-aside-column-->
            </div>
        </div>
    </div>
<?} else{
    echo "No record found";
} ?>
