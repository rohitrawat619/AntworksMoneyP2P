	<div class="white-box prsnl-dtls">
		<h3 class="borrower-prof-hd"><i class="ti-user"></i> Account Summary</h3>
		<div class="row">
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table bdr-rite">
							<tbody><tr>
								<td>Bank Name</td>
								<td><strong><?php  ?></strong></td>
							</tr>
							<tr>
								<td>Statement Period</td>
								<td><strong><?php echo $bank_analysis['metaData']['duration']['fromDate']; ?> - <?php echo $bank_analysis['metaData']['duration']['toDate']; ?></strong></td>
							</tr>
							<tr>
								<td>Account Number</td>
								<td><strong><?php echo $bank_analysis['metaData']['accountNumber']; ?></strong></td>
							</tr>
							<tr>
								<td>Current Account Balance</td>
								<td><strong><?php echo $bank_analysis['metaData']['currentBalance']; ?></strong></td>
							</tr>
							<tr>
								<td>Last Transaction Date</td>
								<td><strong><?php echo $bank_analysis['metaData']['lastTransactionSeen']; ?></strong></td>
							</tr>
							<tr>
								<td>Average Daily Balance</td>
								<td><strong><?php echo $bank_analysis['adbDetails']['avgDailyBalance']; ?></strong></td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
			<div class="col-md-6 profile-devider">
				<div class="borrower-record">
					<div class="table-responsive">
						<table class="table">
							<tbody><tr>
								<td>Income</td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['income']['avgIncome']; ?></strong></td>
							</tr>
							<tr>
								<td>Expenses</td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['expense']['avgExpense']; ?></strong></td>
							</tr>
							<tr>
								<td>Total Credit</td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['transfer']['totalCredit']; ?></strong></td>
							</tr>
							<tr>
								<td>Total Debit
                                </td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['transfer']['totalDebit']; ?></strong></td>
							</tr>
                            <tr>
								<td>Total Salary
                                </td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['salary']['totalSalary']; ?></strong></td>
							</tr>
                            <tr>
								<td>Average Salary
                                </td>
								<td><strong><?php echo $bank_analysis['categoryDetails']['salary']['avgSalary']; ?></strong></td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
		</div>
		</div>
		
		<div class="white-box prsnl-dtls">
			<h3 class="borrower-prof-hd"><i class="ti-user"></i> Documents Submitted</h3>
			<div class="row">
                <ul class="documnt-verify">
                    <?php foreach($kycDoctype AS $doctype){?>

                        <li><i class="fa fa-check-square-o" aria-hidden="true"></i><?php echo str_replace('_', ' ', $doctype['docs_type']) ?></li>
                    <?php } ?>


                </ul>
			</div>
		</div>
        <div class="white-box prsnl-dtls">
            <table class="table table-bordered responsive-table">
            <tbody>
            <tr>
                <td colspan="17" class="text-center">Average Monthly Balance</td>
            </tr>
            <tr>
                <?php foreach($bank_analysis['ambDetails'] AS $ambDetails){?>

                    <td>Month</td>
                    <td><?php echo $ambDetails['monthName']; ?>-<?php echo $ambDetails['year']; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td>Average Amount</td>
                <td></td>
                <td>&nbsp;</td>
                <td>Average Amount</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Average Amount</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Average Amount</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Average Amount</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Average Amount</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Minimum Balance</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Maximum Balance</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>End of Month Balance</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Total Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Credits</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Total Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Total Debits</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="white-box prsnl-dtls">
            <table class="table table-bordered responsive-table">
            <tbody>
            <tr>
                <td colspan="4"  class="text-center">Transaction Details</td>
            </tr>
            <tr>
                <td>Particulars</td>
                <td>Counts</td>
                <td>&nbsp;</td>
                <td>Amount</td>
            </tr>
            <tr>
                <td>Credits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Debits</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Credit Card Payments</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cheque Inwards</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cheque Outwards</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cheque Bounces</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>ATM Withdrawls</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Service Charges Fees</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>EMI</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>POS</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Reversal</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Credit Transfers</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Debit Transfers</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cash Withdrawls at Bank</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Cash Deposits at Bank</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Interest Amount</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Debits excluding cheque Inwards</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Payments made from same account</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Payments recieved to same account</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="white-box prsnl-dtls">
            <table class="table table-bordered responsive-table">
            <tbody>
            <tr>
                <td>Top 5 Credits</td>
                <td>Description</td>
                <td>&nbsp;</td>
                <td>Amount</td>
            </tr>
            <tr>
                <td>22/04/2019</td>
                <td>BY CASH-GURGAON-UNIVERSALTRADE TOWER</td>
                <td>&nbsp;</td>
                <td>50000</td>
            </tr>
            <tr>
                <td>22/04/2020</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2021</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2022</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2023</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="white-box prsnl-dtls">
            <table class="table table-bordered responsive-table">
            <tbody>
            <tr>
                <td>Top 5 Debits</td>
                <td>Description</td>
                <td>&nbsp;</td>
                <td>Amount</td>
            </tr>
            <tr>
                <td>22/04/2019</td>
                <td width="116">MMT/IMPS/xxxxxxxx9760/KP</td>
                <td>&nbsp;</td>
                <td>50005</td>
            </tr>
            <tr>
                <td>22/04/2020</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2021</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2022</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>22/04/2023</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
		</div>
	
	
	
	
	