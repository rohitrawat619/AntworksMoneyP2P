<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
</head>
<body>

<div style="text-align:center;">
<p>LAN: <?= $result['loan_no'] ?></p>
<p>Between</p>
<p><strong><?= $result['BORROWERNAME'] ?></strong></p>
<p>['The Borrower']</p>
<p>and</p>
<p><strong><?= $result['LENDER_fNAME'] ?></strong></p>
<p>['Lender']</p>
<p>and</p>
<p><strong>ANTWORKS FINANCIAL BUDDY TECHNOLOGIES PRIVATE LIMITED</strong></p>
<p>['Antworks']</p>
</div>
<div style="text-align:center;"><strong>LOAN AGREEMENT</strong></div>

<p style="text-align:center;"><strong>THIS AGREEMENT</strong> for Loan dated <?= $agreement_date ?>    BETWEEN</p>
<p><strong> <?= $result['BORROWERNAME'] ?> </strong> Residing at <?= $result['BORROWERR_Address'] ?> <?= $result['BORROWERR_Address1'] ?> <?= $result['BORROWERR_City'] ?> <?= $result['BORROWERR_State'] ?> <?= $result['BORROWERR_Pincode'] ?> having PAN <?= $result['BORROWERR_pan'] ?>, hereinafter referred to as 'the Borrower' and as more fully described in First Schedule here under (which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and heirs) of the FIRST PART;</p>

<p style="text-align:center;"><strong>AND</strong></p>

<p><strong>

<?= $result['LENDER_fNAME'] ?>, </strong> CIN U65999HR2017PTC071580, having its Registered Office at <?= $result['LENDER_address'] ?> <?= $result['LENDER_city'] ?> <?= $result['LENDER_state_code'] ?> <?= $result['LENDER_pincode'] ?> , having PAN <?= $result['LENDER_PAN'] ?>, a Reserve Bank of India registered P2P-NBFC bearing COR 14.03483, through its registered Lenders, hereinafter referred to as 'the Lender' and as more fully described in First Schedule hereunder (which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors, assigns and heirs) of the SECOND PART;</p>

<p style="text-align:center;"><strong>AND</strong></p>

<p><strong>ANTWORKS FINANCIAL BUDDY TECHNOLOGIES PRIVATE LIMITED,</strong> CIN U67100HR2020PTC084829 having its Registered Office at UL-03, Eros EF3 Mal, Sector-20 A, Mathura Road, Faridabad,121001, Haryana, having PAN AATCA1921C, hereinafter referred to as 'Antworks' (which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and assigns) of the <strong>THIRD PART</strong>;</p>

<p>WHEREAS Antworks runs a Mobile App, AntPay for providing Virtual Prepaid Cards, Mobile Wallet, Payments, Loans and Insurance services to its users and has entered into an agreement with <?= $result['LENDER_fNAME'] ?> through which it has been agreed that <?= $result['LENDER_fNAME'] ?> would consider providing loan facility to the borrowers who registered themselves at the portal of the Antworks, although the <?= $result['LENDER_fNAME'] ?> would have discretion on sanctioning of the loan

<p>AND WHEREAS the Borrower, being in need of money, have registered it on the AntPay App and had raised some request for a loan by filling up of necessary forms with the portal.</p>

<p>AND WHEREAS the Lender coming to know their mutual requirements conducted their respective diligence and finally decided to grant a loan amounting to Rs <?= $loan_amount ?>.</p>

<p>AND WHEREAS Antworks will act as a facilitator in the entire process of Loan starting from Credit Appraisal, disbursement and ending with the recovery of the Loan.</p>

<p>NOW THEREFORE, in consideration of the mutual covenants as set forth below, and based on the various representations and warranties of the Parties as herein made the Parties hereby agree to enter into the present Agreement on the terms and conditions as set out herein.</p>


<h3>1.	Definitions:</h3>
<ol>
<li><strong>Convenience Fee</strong> shall have the meaning as described in Clause 11 hereunder.</li>

<li><strong>Designated Loan Disbursement Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Lender would transfer the Principal Loan Amount for being disbursed to the Borrower at the instance of Antworks.</li>

<li><strong>Designated Loan Repayment Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Borrower shall deposit the amount for servicing / repayment of the Loan (i.e. principal and interest) as more fully described in Clause 10, hereunder.</li>

<li><strong>Escrow Bank</strong> shall be IDBI Bank account.</li>

<li><strong>Loan Disbursement Date</strong> for the purpose of this Agreement shall mean the date on which the Principal Loan amount, as reduced by the Borrower's Convenience Fee payable to Antworks, is credited to the Bank Account or Mobile Wallet of the Borrower opened with Antworks.</li>

<li><strong>Loan Transaction</strong> for the purpose of this Agreement shall mean the amount of Loan granted by the Lender to the Borrower.</li>

<li><strong>Penal Interest</strong> for the purpose of this Agreement shall mean the rate of interest per annum payable by the Borrower for any failure to pay any loan servicing amount on due date (i.e. designated date on which it is due for payment) in addition to the rate of interest of the loan for the period of delay till repayment of the entire overdue EMI amount.</li>

<li><strong>Principal Loan Amount / PLA</strong> for the purpose of this agreement shall mean the amount of the loans granted by the Lender to the Borrower.</li>

<li><strong>RBI Master Directions</strong>: For the purpose of this Agreement RBI Directions shall mean <strong>prevailing RBI Regulations applicable for NBFCs and Digital lending companies</strong> as amended from time to time.</li>
</ol>

<h3>2. Purpose of Agreement</h3>
<p>The purpose of this Agreement is to record in writing the terms and conditions of the Loan Transaction</p>

<h3>3. Loan Granted and Accepted</h3>
 <p>The Lender, upon getting himself satisfied about the creditworthiness of the Borrower and on the recommendation of the Antworks, hereby grants to the Borrower the Loan on the terms and conditions contained herein and the Borrower upon getting himself satisfied about the terms and conditions of loan through his own means hereby accepts the grant of Loan made by the Lender.</p>

 <h3>4. Principal Loan Amount,</h3>
 <p>The principal amount of Loan covered under this Agreement is Rs <?= $loan_amount ?></p>

<h3>5. Purpose of Loan</h3>
 <p>The Borrower has declared that he is taking the loan for '<?= $result['Loan_Description'] ?>'.</p>

<h3>6. Effective Date</h3>
 <p>This Loan Agreement shall be effective from the date of Signing of this Agreement.</p>

<h3>7. Tenure of the Loan</h3>
 <p>The tenure of the Loan shall be 1 months, which can be further extended upto 3 months on mutually agreeable terms and/or payment of Additional Convenience fee by Borrowers. Maximum Door to Door tenor of the loan shall not exceed <?= $result['TENORMONTHS'] ?> months for each drawdown.</p>

 <h3>8. Rate of Interest</h3>
 <p>The Loan shall be subject to an interest @<?= $result['LOAN_Interest_rate'] ?>% p.a</p>
<p>The effective interest rate may be higher due to convenience fee paid and penal charges, if paid by Borrowers.</p>

<h3>9. Availability Period</h3>
<p>Once sanctioned, the limit shall be available for drawdown within 12 months of sanction of limit. The limit may be withdrawn or cancelled by Lender at any point of time at its sole discretion.</p>

<h3>10. Loan Disbursement Mechanism</h3>
<ol>
<li>On request being made by the Borrower, Lender  shall deposit the loan amount to respective Bank Account or Antpay wallet of the user after deducting the Convenience fees of upto <?= $result['LOAN_Interest_rate'] ?>% p.a. charged on a Monthly basis. 
On timely repayment of the outstanding amount, request may be made to the App for subsequent disbursement, the Lender may charge a convenience fee upto <?= $result['LOAN_Interest_rate'] ?>% p.a. charged on a Monthly basis, which shall be deposited in the lender's account. </li>
</ol>

<h3>11. Convenience Fee</h3>
A. Borrower's Convenience Fee:
<ol>
<li>Lender  shall be entitled to a Convenience   Fees to be known as Borrower's Convenience Fees, at the rate as specified in the Mobile App payable by the Borrower before availing the services.</li>
<li>The Borrower's Convenience Fee (payable by the Borrower) can be recovered by Lender from the Principal Loan Amount during disbursement. The Borrower shall be liable to repay the Principal Loan Amount to the Lender and interest thereupon. The Borrower hereby conveys his unconditional consent in favor of Antpay  to deduct the Borrower's Convenience Fee from the Principal Loan Amount and undertakes not to contest or initiate any legal proceedings for such deduction, under any circumstances.</li>
</ol>

<h3>12.	Payment of Interest and Repayment of Principal Loan Amount by way of EMI</h3>
<ol>
<li> The Borrower shall pay the interest along with the principal by way of predetermined monthly installment (EMI) to the Lender as per an Amortization Schedule, to be shared separately with the Parties herein and shall form an integral part of this Agreement, in the format depicted in the Third Schedule hereunder.</li>
<li>In case the repayment schedule is not intimated separately by Antworks, the 1st EMI shall be paid by the Borrower to the Lender on the 15th day of the month immediately subsequent to the month in which the loan has been first disbursed by the Lender to the Borrower and thereafter 15th day of each subsequent month till full repayment of the loan amount along with interest and charges/ fees.</li>
<li>The Borrower shall pay the Applicable EMI by way of NACH/ eNACH or ECS/NetBanking/NEFT/ RTGS/IMPS/UPI or any other similar electronic funds transfer mechanism favoring the Designated Loan Repayment Escrow Account</li>
<li>Antworks would inform the Trustee to instruct the Escrow Bank for transfer of EMI amount deposited by the Borrower in Designated Loan Repayment Escrow Account to the Lender preferably by the immediately succeeding working day, after deducting therefrom the Lender' Convenience fee wherever applicable. The amount would be transferred to the Lender’s sub- account in Escrow and the Lender is entitled to withdraw the amount as and when desired.</li>
<li>The payment of EMI through NACH/ eNACH or ECS/NetBanking/NEFT/ RTGS/IMPS/UPI or any other similar electronic funds transfer mechanism shall be prefixed (as per an Amortization Schedule as intimated by Antworks.</li>
<li>Any amount paid by the Borrower in any account of the Lender other than the Designated Loan Repayment Escrow Account shall not be treated as an EMI for the purpose of this Agreement and such payment shall not be treated as a payment towards the Loan.</li>
</ol>

<h3>13.	Payment Assurance</h3>
<ol>
<li>In order to assure the repayment of the loan to the Lender, the Borrower shall have to furnish Cheques (PDC) as follows:</li>

  1. 1 PDC for the amount of Loan of the Lender</br>
  2. Depending on the transaction, Antworks may waive the requirement of PDC or may specify more number PDCs.
<li>In addition to above the Borrower shall also furnish Demand Promissory Note ('DPN') as set out in the Fourth Schedule hereunder.</li>
</ol>
<h3>14. Changes in Designated Loan Repayment Escrow Account</h3>
 <p>During the Tenure of the Agreement Antworks may change the Designated Loan Repayment Escrow Account after serving a written notice of 30 days to the Borrower and the Lender. Upon the expiry of the said period of 30 days the new account shall be treated as the Designated Loan Repayment Escrow Account for the purpose of this agreement and accordingly the Borrower shall make the EMI payment through NACH/ eNACH or ECS/Net Banking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism to such Designated Loan Repayment Escrow Account.</p>

 <h3>15. Delayed Payment of EMI and Penal Interest</h3>
 <ol>
<li>The Borrower shall not fail to pay his EMI in any month. However, in the event of unforeseen   circumstances, if the borrower fails to pay any EMI in a particular month on the due date (i.e. designated date on which it is due for payment) then it shall be treated as a non-payment of EMI (overdue EMI) and shall be subject to the Penal Interest. Notwithstanding the same, Antworks may allow a grace period not exceeding 7 days for payment of EMI. In addition to Penal Interest, any NACH/ eNACH/ ECS/ Cheque bouncing (dishonor) and/ or failure to pay EMI on due date or dishonor of payment mandate would attract penal charges/- and administrative fees payable to Antworks (in line with the rate and schedule provided in the Mobile App AntPay Mobile App).</li>

<li> Penal Interest referred to above shall be calculated <span style="color: red;">@36%</span> per annum (in addition to the rate of interest of the loan) for the period of delay till repayment of the entire overdue EMI amount. In case only the preceding EMI is overdue, the Penal Interest would be calculated on the overdue amount. In case more than one EMI is overdue, the Penal Interest would be calculated on the total outstanding loan amount.</li>

<li>The Borrower shall regularize the non-payment of any EMI by paying the overdue EMI amount along with the applicable Penal Interest and penal charges/ administrative fees at the earliest and on or before the immediately succeeding EMI date.</li>

<li>Payment of Penal Interest does not absolve the Borrower from consequences of default and remedies available to the Lender under this Loan Agreement.</li>

<li>Any payment made by the Borrower on a date immediately upon failure of the EMI payment   shall be, first adjusted against the Penal Interest, then by the EMI overdue and last by the current EMI.</li>
</ol>

<h3>16. Events of Default:</h3>
 <p>The following shall constitute Events of Default</p>

<h3>17. Curing of Default</h3>
<ol>
<li>The Borrower shall be allowed to cure, wherever practicable, a Default within 15 days of happening of the Event of Default.</li>
<li>The Borrower has procured a specific written waiver and/ or extended time to cure the Event of Default, communicated by the Lender in respect of any Event of Default.</li>
</ol>

<h3>18. Consequences of Default</h3>
 <p>If the Borrower fails to cure any Event of Default the Lender, in addition to the rights available under normal course of law:</p>
<ol>
 <li>may call upon the Borrower to pay immediately the entire outstanding Principal amount along with the unpaid Interest and Penal Interest (if any, accrued till the date of such payment) and fees/ charges.</li>
<li> may enforce the DPN and /or ask Antworks to lodge the PDC, at his discretion;</li>
<li> may initiate proceedings under Chapter III of the Insolvency and Bankruptcy Code, 2016 and / or such other remedy by virtue of any other security, statute or rule of law, as may be applicable.</li>
<li>Take such other steps to recover its due amount from the Borrower, as is available under the law, including legal proceedings under applicable laws.</li>
</ol>

<h3>19. Role of Antworks</h3>
 
<p>Antworks would perform the following roles against payment of fees for the respective services as disclosed in its Mobile App from time to time.</p>

<ol> 
<li>Co-ordination among the parties for sharing of information and communication, as set out in this agreement and as provided in the Mobile App of Antworks from time to time. Antworks may carry out changes to the loan policy from time to time as provided in its Mobile App AntPay Mobile App (including ‘How It Works’ section) after taking confirmation of the Lender and the same shall be applicable to both Borrower and Lender from the date of intimation of such change.</li>

<li> Antworks may at the request of the lender provide other services, as it may deem fit, for the purpose of grant of the loan by the Lender to the Borrower and repayment of the loan by the Borrower to the Lender. All the parties to the transaction provide their consent to Antworks to perform any such roles or to provide any such services as Antworks may be asked to perform by Lender.. Borrower  agree to pay fees to Antworks for the services (as availed by them) according to the rates as specified in the AntPay Mobile App. The Lender would be liable to pay fee as per the agreement entered into between the Lender and the Antwork.</li>

<li>The Antworks shall take all effective steps towards recovery of the debt from the borrower in case of default including coordinating and initiating legal proceedings against the borrowers and for which the Lender extends their consent. However, the cost of proceedings for recovery and other consequential proceedings shall be borne by the Antworks.</li>
</ol>

<h3>20. Borrower's Undertaking</h3>
 
<p>The Borrower hereby undertakes as follows:</p>
<ol>
<li>The personal data and all information furnished by him are true and correct at the time of submission.</li>

<li> Any change in his variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>

<li>The Borrower shall, on an annual basis, furnish/ updated information as submitted to the Antworks Mobile App (AntPay Mobile App), including Bank statements of all his Bank accounts, information on his income for the immediately preceding financial year, present monthly income, copy of latest Income Tax Return, other Borrowings and payment obligations etc.</li>

<li>The Borrower authorizes Antworks to carry out such Due Diligence on him as it may deem necessary including tracking his activities in any media/ forum or devise, accessing information about him as available with any information repository. Antworks is also authorized to engage any third party for the purpose of collecting/ collating and/ or verification of information on the Borrower.</li>

<li>The Borrower authorizes Antworks to access/ requisition/ download/ obtain from any or all Credit Information Bureaus his personal information/ credit report and score from time to time. Lender is also authorized to submit the relevant information on the present Loan (including repayment/ servicing track record) to the Credit Information Bureaus and also with any other relevant forum/ information bureau to notify the indebtedness of the Borrower.</li>

<li>The Borrower authorizes Antworks to share information about him with Lender and representatives/ consultants/ lawyers/ agents/ others engaged by Antworks for the purpose of the Loan. The Borrower authorizes Antworks to share updated information about him from time to time with the present Lender as also prospective Lender who expresses their intention to take over the loan from the present Lender through assignment (as described in Clause 27). The information shared with Lender/ prospective Lender may include information on the Borrower received/ obtained from third party sources whether or not verified by the Borrower</li>

<li>The Borrower shall not use the loan for any purpose other than the purpose mentioned in this agreement.</li>

<li>The Borrower shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>

<li>The Borrower shall not use the loan for speculative purpose or for the purpose of trading in the stock market.</li>

<li>The Borrower shall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>

<li>The Borrower undertakes to maintain sufficient balance in his/ her Bank account so that the PDCs as also the DPNs can be honored on presentation by the Lender/ Antworks.</li>

<li>The Borrower also undertakes to maintain adequate balance in his/her bank account to honour ECS/NACH commitments (and / or such other payment mandates)</li>

<li>The Borrower hereby authorizes Antworks to collect the fees and charges as chargeable for tying-up the loan and other services provided by Antworks according to the rate as specified in the Mobile App AntPay Mobile App from the Designated Escrow Account out of the disbursement amount. For all purposes of this Agreement the principal amount of the loan would be the gross amount including the fees and charges collected by Antworks in addition to the amount transferred to the Borrower from the Designated Escrow Account.</li>

<li>The Borrower hereby authorizes and provides its no objection to Antworks to render any service (including towards Loan Recovery), on its own or through its representatives/ consultant/ agents/ others, as it may desire towards the Loan to the Lender(including their successors/ assigns/ heirs).It is understood and agreed by the Borrower that steps as may be deemed necessary for Recovery of Loan can be taken by the Lender, Antworks, their agents/ consultants/ representatives and/ or any person acting through or under them.</li>

<li>The Borrower shall replace any or all the PDCs and DPNs as per the advice / requirement of Antworks.</li>

<li>The Borrower has perused and agrees to abide by the RBI Master Directions as may be applicable to him for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions. In addition to above the Borrower herein shall be bound to give an undertaking as given in the Fifth Schedule hereunder</li>

<li>The Borrower further undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>

<li>The Borrower agrees to give NACH/ eNACH/ ECS/ mandate or NetBanking/NEFT/RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism mandate to his Banker (where his income is credited) for periodical transfer of the EMI amount from his Bank account to the Designated Loan Repayment Escrow Account.</li>

<li>The Borrower undertakes that so long as one or more EMI is overdue (due and payable) to the Lender under this Agreement, the Borrower would first clear the dues under this Agreement from any amount (being his income or otherwise) received by the Borrower in any of his Bank account or in Cash (which would be deposited immediately in a Bank account) and transferred to the Loan Repayment Escrow Account.</li>

<li>The Borrower agrees to obtain insurance for covering the risks as may be informed by Antworks for the amount of the loan with the Lender as the loss payee and renew the same from time to time and keep it valid. Antworks is authorized to obtain such insurance on behalf of the Borrower and collect the premium from the Borrower.</li>

<li>Shall use the Designated Loan Repayment Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<h3>21. Lender's Undertaking</h3>

<p>The Lender hereby confirms and undertakes as follows:</p>
<ol>
<li> Any change in his variable personal data like communication address, shall be intimated to the Borrower and Antworks within 7 days from such change.</li>

<li>The Lender authorizes Antworks to share information about him with Borrowers registered in the portal of Antworks (AntPay Mobile App) and representatives/ consultants/ lawyers/ agents/ others engaged by Antworks for the purpose of the Loan.</li>

<li>He has granted the Loan from his own legally generated fund and has not used any fund which does not belong to him or by raising loan from some other person or entity.</li>

<li>His total exposure to all borrower across all Peer to Peer Lending Platform is not more than INR 10,00,000/-.</li>

<li>The total amount of Loan given by him to the Borrower in all Peer to Peer Lending Platform including this Agreement does not exceed INR 50,000/-.</li>

<li>He shall forthwith, within 7 days of receiving full repayment of the loan (either on receipt of all the payments in line with the repayment schedule or through Foreclosure/ Termination as provided in this agreement), issue No Dues Certificate to the Borrower and the PDCs and DPN would be returned to the Borrower.</li>

<li> He shall not hold Antworks, its associate organizations, its Board of Directors, its Directors, senior executives, representatives, consultants, legal and such other advisors responsible for any loss or damage that it might suffer for granting this Loan. He has been granted this Loan by entering into this Agreement at his   own will.</li>

<li>He shall not utilize the information received in the course of the transaction (including information on the Borrower) for any purpose other than this transaction and shall not share or disclose the information to anyone other than the parties to this transaction.</li>

<li>The Lender hereby authorizes Antworks to collect the fees and charges (Lender's Convenience Fees) from time to time, as due for the loan and other services provided by Antworks, according to the rate as specified in the Mobile App, AntPay Mobile App, from the Designated Loan Repayment Escrow Account or out of the EMI amount. For all purposes of this Agreement the amount of the loan repayment would be the gross amount including the fees and charges collected by Antworks in addition to the amount transferred to the Lender from the Designated Loan Repayment Escrow Account.</li>

<li>The Lender hereby authorizes and provides their no objection to Antworks to render any service, on its own or through its representatives/ consultants/ agents/ others, as it may desire towards the Loan to the Borrower or to other Lender including their successors/ assigns/ heirs.</li>

<li>The Lender has perused and agrees to abide by the RBI Master Directions as may be applicable to them for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions.</li>

<li>The Lender also undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>

<li>The Lender shall use the Designated Loan Disbursement Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<h3>22. Joint Covenant by the Lender and the Borrower</h3>
 
<p>The Lender and the Borrower covenants and warrant to each other that:</p>
<ol>
<li>He/she has read all the terms and conditions, privacy policy, fair practices code and other material available at AntPay Mobile App owned by Antworks herein.</li>

<li>They unconditionally agree to abide by the terms and conditions, privacy policy and other binding material contained on the AntPay Mobile App.</li>

<li>Antworks is in no manner responsible towards either loss of money or breach of privacy or leakage of any confidential information.</li>

<li>They have not provided any information which is incorrect or materially impairs the decision of Antworks to either register him / her or permits to lend him / her through the AntPay Mobile App.</li>

<li>They confirm that all types of communication between them (borrower and lender) will be/have been done online via an online platform provided by Antworks and all money transactions would be done through Bank accounts, the details of which is provided in this Agreement and as informed to and by Antworks.</li>

<li>Pay necessary fees and expenses as Antworks may decide to demand from time to time.</li>
</ol>

<h3>23. Paid Prepayment:</h3>
<ol> 

<li>The Borrower can any time after the expiry of 3 months from the date of payment of his 1st EMI, pre-pay and foreclose the Loan. Prepayment can happen only with prior approval of Antworks.</li>

<li>There will be no foreclosure penalty for such foreclosure. However, the Borrower shall be liable to pay remain bound to pay all interest dues till the date of prepayment and all charges due to Antworks, as the case maybe. Prepayment penalty for foreclosure before 3 months of the due date of 1st EMI would be 5% of the loan amount.</li>

<li>The Borrower shall pay a usage service charge of Rs. 500/- (or according to the updated rate as specified in the AntPay Mobile App as applicable at the time of such foreclosure) for foreclosure to Antworks.</li>

<li>No prepayment is allowed for loans with tenor of less than 6 months. The Borrower is required to pay the entire amount of the instalments (i.e. loan principal and full interest for the loan tenor), even if repaid early.</li>
</ol>

<h3>24. Termination</h3>
 
<p>This Agreement shall stand terminated in the event of -</p>

<ol>
 
<li> Complete repayment of Loan, along with interest (till the date of repayment) and other charges/ fees (as per the agreement) by the Borrower to the Lender and Antworks.</li>

<li>Foreclosure of Loan by the Borrower (on payment of entire due amount to the Lender and Antworks)</li>

<li>In case no amount under this Agreement for Loan is disbursed by the Lender within a period of 6 months from the date of this Agreement.</li>

<li>This Agreement becomes inoperative due to any provisions of the RBI Master Direction, subject to repayment of the loan amount along with interest and charges by the Borrower</li>
</ol>

<h3>25. Effect of Termination</h3>

<ol> 

<li>As and when the Borrower repays of the Loan to all the Lender in accordance with the provisions of this Agreement either full tenure payment or a prepayment by way of Foreclosure, the Lender shall give him No Dues Certificates in the format given in Sixth Schedule along with returning the DPN and all the PDCs held by them  hereunder  and Antworks shall give him a Clearance Certificate in the format given in Seventh Schedule. In case 'No Dues Certificate' is not received from Lender within 30 days of intimation without assigning any reason, in such case Antworks is hereby Authorized by the Lender to issue ‘No Dues Certificate’ to the Borrower as and when such request is made by the Borrower.</li>

<li>The relationship of the parties shall come to an end as and when such certificates are issued.</li>

<li>It is clearly understood by the parties that once the No Dues Certificate is issued by the Lender, the Borrower shall be absolved from all his duties and liabilities under this Agreement.</li>
</ol>

<h3>26. Assignment</h3>
 
<ol>
<li>The Borrower shall not assign or transfer any of its rights or obligations under this Agreement.</li>

<li>Subject to the applicable laws and the validity and enforceability of this Loan Agreement not being affected adversely in any manner, the Lender(including Assigned Lender) may at any time with prior consent of Antworks may transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons by executing a Deed of Assignment or any other valid documents for assignment inter se, without requiring any reference to the Borrower.  Any such Person(s) to which the Loan has been transferred / novated in accordance with this Section is referred to as the 'Assigned Lender(s)'.</li>

<li>The Borrower hereby gives his unconditional consent to any number of assignments as referred to above and accordingly all or any of the Lender may at any time transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons without requiring any reference to the Borrower.</li>

<li>The Assigned Lender shall, upon such assignment, as the case may be, acquire the same rights and assume the same obligations as regards the Borrower as it would have acquired and assumed had the Assigned Lender been an original party to this Agreement and shall abide by the terms, conditions and obligations of the Lender as stipulated in this Agreement.</li>

<li>The Assigned Lender would immediately intimate Antworks, Borrower and other Lender about the assignment. Upon such assignment, as the case may be, the Borrower would provide fresh PDC to the Assigned Lender and new DPN for the Loan in return of the previous PDC and DPN of the previous Lender assigning or novating or transferring his loan would be returned to the Borrower by him.</li>

<li>Notwithstanding anything contained herein, failure to replace the PDC and the DPN in the case of an assignment within 15 days from the date of receipt of intimation by the Borrower, the then outstanding loan amount shall become immediately payable in favour of the new Lender and the PDC and DPN provided already shall be valid for enforcement. However, the new Lender may at their sole discretion, agree to accept the PDCs and the DPN beyond the aforesaid 15 days and in which case the Loan Agreement shall continue without any further act or deed by any party.</li>

<li>Any assignment, shall not be construed as the creation of a new agreement with new obligations or rights, and the Borrower shall not be obliged to pay any person including the assigning or novating or transferring Lender and / or Assigned Lender any greater amount as a result of any such assignment or novation or transfer, as the case may be, than that which it would have been obliged to pay under this Agreement, if no such assignment or novation had taken place.</li>
</ol>

<h3>27. Supersedes</h3>
 
<p>This Agreement constitutes the entire agreement between the Parties and revokes and supersedes all previous discussions/correspondences and agreements between the Parties, oral or implied.</p>

<h3>28. Partial Validity</h3>
 
<p>If any provision of this Agreement or the application thereof to any circumstance shall be invalid, void or unenforceable to any extent, the remainder of this Agreement and the application of such provisions shall continue to be effective and each such provision of this Agreement shall be valid and enforceable to the fullest extent permitted by law. Notwithstanding anything contained hereinabove, if the Platform or services provided by Antworks becomes illegal due to any legal imposition or change in law, then in such a situation the Borrower shall be liable to refund the then outstanding amount to the Lender or may enter into a separate loan agreement with the Lender and in neither case Antworks shall be responsible / liable in any manner whatsoever.</p>


<h3>29. Alternative</h3>
 
<p>If any provision of this Agreement or the application thereof to any circumstance shall be invalid, void or unenforceable to any extent, the remainder of this Agreement and the application of such provisions shall continue to be effective and each such provision of this Agreement shall be valid and enforceable to the fullest extent permitted by law. Notwithstanding anything contained hereinabove, if the Platform or services provided by Antworks becomes illegal due to any legal imposition or change in law, then in such a situation the Borrower shall be liable to refund the then outstanding amount to the Lender or may enter into a separate loan agreement with the Lender and. In neither case Antworks shall be responsible / liable in any manner whatsoever.</p>

<h3>30. Interpretation</h3>
<ol> 
<li>In these presents, where the context so requires, the singular includes the plural and vice versa; and words importing any gender include any other gender.</li>

<li>Title and headings of sections of these presents are for convenience of reference only and shall not affect the construction of any provision herein;</li>

<li>All Schedules, annexure, plans, memorandum or any other document that is attached hereto and bears the signatures and/or seals of the both the Parties hereto shall be deemed to be part of these presents.</li>
</ol>

<h3>31. Waiver</h3>
 
<p>No failure or neglect of either party hereto in any instance to exercise any right, power or privilege hereunder or under law shall constitute a waiver of any other right, power or privilege or of the same right, power or privilege in any other instance. All waivers by either party hereto must be contained in a written instrument signed by the party to be charged or other person duly authorized by it.</p>

<h3>32. Amendment or Modification</h3>
 
<p>Save as otherwise provided elsewhere in this Agreement, no amendment or modification of this Agreement or any part hereof shall be valid and effective unless it is by an instrument in writing executed by the Parties or their authorized representative and expressly referring to this Agreement.</p>

<h3>33. Governance</h3>
 
<p>This Agreement shall be Governed by the Laws of India.</p>

<h3>34. Mode of Service</h3>
 
<p>Any notice or other communication required or permitted hereunder shall be in writing and shall be addressed and delivered to in the respective address of the Parties herein as mentioned in the nomenclature clause -</p>

<h3>35. Dispute Resolution</h3>
 
<p>Any dispute or claim arising from or in connection with this Agreement or breach, termination or invalidity thereof, shall be finally settled by arbitration in accordance with the Arbitration and Conciliation Act, 1996, as amended and/or enacted from time to time. The arbitration tribunal shall consist of one arbitrator, chosen by the parties in accordance with the said Act. The proceeding will be conducted in English and shall take place in Delhi. The award of the arbitrator shall be final and binding on all the Parties.</p>


<h3>IN WITNESS WHEREOF THE PARTIES HERETO HAVE EXECUTED THIS AGREEMENT FOR LOANON THE DAY MONTH AND YEAR FIRST ABOVE WRITTEN.</h3>

<table>
	<tr>
		<td>Borrower</td>
		<td>Lender</td>
	</tr>
	<tr>
		<td>E-sign- <?= $borrower_signature_date ?></td>
		<td><?= $agreement_date; ?></td>
	</tr>
	<tr>
		<td>(<?= $result['BORROWERNAME'] ?>)</td>
		<td>(<?= $result['LENDER_fNAME'] ?>)</td>
	</tr>
</table>
<p>FIRST SCHEDULE</p>
<p>[Details of the Borrower]</p>

<table>
	<tr>
		<th>SI</th>
		<th>Particulars</th>
		<th>Details</th>
	</tr>
	<tr>
		<td>1</td>
		<td>Name</td>
		<td><?= $result['BORROWERNAME'] ?></td>
	</tr>
	<tr>
		<td>3</td>
		<td>PAN</td>
		<td><?= $result['BORROWERR_pan'] ?></td>
	</tr>
	<tr>
		<td>5</td>
		<td>Address</td>
		<td><?= $result['BORROWERR_Address'] ?> <?= $result['BORROWERR_Address1'] ?> <?= $result['BORROWERR_City'] ?> <?= $result['BORROWERR_State'] ?> <?= $result['BORROWERR_Pincode'] ?></td>
	</tr>
	<tr>
		<td>6</td>
		<td>E-mail ID</td>
		<td><?= $result['BORROWEREMAIL'] ?></td>
	</tr>
	<tr>
		<td>7</td>
		<td>Mobile</td>
		<td><?= $result['BORROWERMOBILE'] ?></td>
	</tr>
	<tr>
		<td>8</td>
		<td>Borrower Registration Number</td>
		<td><?= $result['BORROWER_REGISTRATIONID'] ?></td>
	</tr>
</table>
<p>SECOND SCHEDULE</p>
<p>[Details of the Lender]</p>


<table>
	<tr>
		<th>SI</th>
		<th>Particulars</th>
		<th>Details</th>
	</tr>
	<tr>
		<td>1</td>
		<td>Name</td>
		<td><?= $result['LENDER_fNAME'] ?></td>
	</tr>
	<td>6</td>
		<td>E-mail ID</td>
		<td><?= $result['LENDER_email'] ?></td>
	</tr>
	
</table>

<p>THIRD SCHEDULE</p> 
<p>DEMAND PROMISSORY NOTE</p>


<p>On demand, I, <?= $result['BORROWERNAME'] ?> (Hereinafter the 'Borrower') hereby promise to pay to  <?= $result['LENDER_fNAME'] ?>, (referred to as the Lender in the Loan Agreement Dated <?= $borrower_signature_date; ?> inter-alia between me as Borrower and the Lender) the sum of Rs. <?= $loan_amount ?>(Rupees <?= $loan_amount_inword ?> only) in <?= $result['TENORMONTHS'] ?> monthly instalments, to be paid every month together with interest   at the rate of <?= $result['LOAN_Interest_rate'] ?>% per annum, from the date of these presents, payable in any part of India for value received.</p>

<p>In the event I default in making payment hereunder in any manner whatsoever, the entire balance then remaining outstanding shall immediately become due and payable.</p>

<p>Borrower Name & Signature</p>

<p>Dated: <?= $borrower_signature_date; ?></p>

<p>………………………………………………………</p>

<p>FOURTH SCHEDULE</p>

<h3>UNDERTAKING</h3>

<p>I, <?= $result['BORROWERNAME'] ?> (PAN: <?= $result['BORROWERR_pan'] ?>), residing at <?= $result['BORROWERR_Address1'] ?> <?= $result['BORROWERR_City'] ?> <?= $result['BORROWERR_State'] ?> <?= $result['BORROWERR_Pincode'] ?>  do hereby undertake as under: 

<ol> 

<li>THAT I have taken a Loan of an amount Rs. <?= $loan_amount ?>./- (Rupees <?= $loan_amount_inword ?>) for a tenure of <?= $result['TENORMONTHS'] ?> months from <?= $result['LENDER_fNAME'] ?> by virtue of Loan Agreement No. LAN <?= $result['loan_no'] ?> dated <?= $borrower_signature_date; ?> </li>

<li>THAT in the said Agreement <?= $result['LENDER_fNAME'] ?> has been identified as the Lender and myself as Borrower and AntPay Mobile App as Antworks</li>

<li>THAT the personal data furnished by me to AntPay Mobile App are true and correct at the time of submission</li>

<li>THAT any change in my variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>

<li>THAT I shall not use the loan for any purpose other than the purpose mentioned in this agreement</li>

<li>THAT I shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>

<li>THAT I shall not use the loan for investment purpose or for the purpose of trading in the stock market.</li>

<li>THAT I shall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>

<li>THAT I have read and understood all the terms and conditions of AntPay Mobile App.</li>

<li>THAT I shall have no objection if the Lender or Antworks takes any legal action against me including lodging of PDCs/DPN, in case I fail to repay the Loan as aforesaid</li>
</ol>
<p>Borrower Name & Signature</p>

<p>Dated: <?= $borrower_signature_date; ?></p>

<p>E-sign- <?= $borrower_signature_date ?></p>

<p><?= $result['BORROWERR_Address'] ?></p>

<p><?= $result['BORROWERR_City'] ?></p>
<p><?= $result['BORROWERR_State'] ?></p> 
<p><?= $result['BORROWERR_Pincode'] ?></p>

<p>Dear Sir,</p>

<p>NO DUES CERTIFICATE</p>

<p>This has reference to the Loan of Rs <?= $loan_amount ?>.for the tenure <?= $result['TENORMONTHS'] ?> at the rate of interest of <?= $result['LOAN_Interest_rate'] ?>% taken by you ('Borrower') from me ('Lender') by virtue of a Loan Agreement vide LAN <?= $result['loan_no'] ?> dated <?= $borrower_signature_date; ?> ('the Loan') through AntPay Mobile App.</p>

<p>I hereby confirm that I have received all sums payable by you to me in connection with the Loan and I have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>

<p>(………………………………………………………)</p>

<p>FIFTH SCHEDULE</p>
<p>[Format of Clearance Certificate]</p>

<p><?= $result['BORROWERNAME'] ?></p>

<p><?= $result['BORROWERR_Address'] ?></p>

<p><?= $result['BORROWERR_City'] ?> <?= $result['BORROWERR_Pincode'] ?></p>
<p><?= $result['BORROWERR_State'] ?></p>

<p>Dear Sir,<p>

<h4>Clearance Certificate</h4>

<p>This has reference to the Loan of Rs <?= $loan_amount ?>  for the tenure <?= $result['TENORMONTHS'] ?> at the rate of interest of <?= $result['LOAN_Interest_rate'] ?>% taken by you ('Borrower') from <?= $result['LENDER_fNAME'] ?>  ('Lender') by virtue of a Loan Agreement vide LAN <?= $result['loan_no'] ?> dated <?= $borrower_signature_date; ?> ('the Loan') through us AntPay Mobile App.</p>

<p>We hereby confirm that there stands no amount payable by to us by you and we have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>

<p>(………………………………………………………)</p>
 
</body>
</html>