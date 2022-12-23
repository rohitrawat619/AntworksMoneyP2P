<head>
    <style type="text/css">
        .row{

    margin-right: -15px;
    margin-left: -8px;
        }
        .multiselect-wrapper, .multiselect-wrapper .multiselect-input {width: 100%;}
        .box-body .radio {display: inline-block; margin-right: 20px;}
        select option{text-transform: uppercase;}
 .box-body {

    padding: 45px;
}
    </style>




</head>

<div class="row">
<section class="content-header">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mis List</li>
    </ol>
</section>

<section class="content" style="min-height: 50px; max-height: 65px;">
  
  <div class="box">

        <div class="box-header with-border"><?=getNotificationHtml();?></div>        
              
           
      <div class="box-body">

              <div class="right-page-header text-right">
                <form action="<?php echo base_url(); ?>p2padmin/missearch/" method="post" enctype="multipart/form-data">
                            <div class="col-md-12" style="margin-bottom: -50px;">
                            <div class="col-md-5"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                       <select class="form-control" name="selectedData" required>
                                           <option value="P2PLoanGiven">Borrowers  Loan Given</option>
                                           <option value="P2PLoanNotGiven">Borrowers  Loan Not Given</option>
                                           <option value="P2PConverted">Borrowers Converted</option>
                                           <option value="CCConverted">CC Converted</option>
                                           <option value="CCNotConverted">CC Not Converted</option>
                                           <option value="ALLConverted">ALL Converted</option>
                                           <option value="ALLNotConverted">ALL Not Converted</option>
                                       </select>
                                    </div>
                                </div>
                          
                                <div class="col-md-3">
                                    <div class="form-group">
                                  <input type="text" readonly name="start_date" id="daterange-btn" placeholder="Filter by date" class="form-control filter-by-date" required>
                                    </div>
                                </div>
                          
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input type="submit" id="submit" value="download" name="submit" class="btn btn-primary">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
             </div></div>
          </br></br>
          <div class="box">
          <div class="box-body">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#p2p" aria-controls="p2p" role="tab" data-toggle="tab">Borrowers</a></li>
            <li role="presentation"><a href="#cc" aria-controls="cc" role="tab" data-toggle="tab">CC</a></li>
            <li role="presentation"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">ALL</a></li>
          </ul>

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="p2p">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#p2papp" aria-controls="p2papp" role="tab" data-toggle="tab">Borrowers App</a></li>
                <li role="presentation"><a href="#p2pweb" aria-controls="p2pweb" role="tab" data-toggle="tab">Borrowers Web</a></li>
                <li role="presentation"><a href="#p2pall" aria-controls="p2pall" role="tab" data-toggle="tab">Borrowers All</a></li>
                <li role="presentation"><a href="<?php echo base_url()?>p2padmin/mis/downloadBorrowerclassification">Borrower Classification</a></li>
              </ul>


        <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="p2papp">
                       
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation"><a href="#Loangiven" aria-controls="Loangiven" role="tab" data-toggle="tab">Loan Given</a></li>
                        <li role="presentation"><a href="#Loannotgiven" aria-controls="Loannotgiven" role="tab" data-toggle="tab">Loan Not Given</a>
                        </li>
                    </ul>



            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="Loangiven">
                <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pgivenapp" method="post" enctype="multipart/form-data">
                      <div class="col-md-4">
                         <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='DLD.date_created' selected>DATE</option>  
                                <option value='BS.borrower_id'>BORROWER ID</option>
                                <option value='BS.name'>CLIENT NAME</option>
                                <option value='BS.mobile'>PHONE NO.</option>
                                <option value='BS.email'>Email</option>
                                <option value='QUL.qualification'>Qualification</option>
                                <option value='OCU.name AS occupation'>Occupation</option>
                                <option value='BS.gender'>Gender</option>
                                <option value='BS.dob'>DOB</option>
                                <option value='ADR.r_city'>CITY</option>
                            </select>
                        </div>
                    </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loan Details</label>
                                    <select  name="loan[]" multiple class="form-control">
                                        <option value='BNK.account_number'>BENIFICIARY A/C NO</option>
                                        <option value='BNK.ifsc_code'>IFSC CODE</option>
                                        <option value='BNK.bank_name'>BANK NAME</option>
                                        <option value='DLD.approved_loan_amount'>LOAN AMOUNT</option>
                                        <option value='DLD.loan_processing_charges'>PROCESSING FEES</option>
                                        <option value='bed.emi_interest'>ROI</option>
                                        <option value='BN.accepted_tenor'>TENURE/MONTH</option>
                                        <option value='bed.emi_amount'>EMI AMOUNT</option>
                                        <option value='bed.emi_date'>REPAYMENT DATE</option>
                                        <option value='BN.loan_no'>LOAN NO</option>
                                    </select>
                                 </div>
                             </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Rating</label>
              <select  name="rating[]" multiple class="form-control">
                <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                <option value='RATI.short_term_leveraging'>short term leveraging</option>
                <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                <option value='RATI.limit_breach'>limit breach</option>
                <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                <option value='RATI.digital_banking'>digital banking</option>
                <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                <option value='RATI.present_residence'>present residence</option>
                <option value='RATI.city_of_residence'>city of residence</option>
                <option value='RATI.highest_qualification'>rating highest qualification</option>
                <option value='RATI.age'>rating age</option>
                <option value='RATI.occupation'>rating occupation</option>
                <option value='RATI.experience'>rating experience</option>
            </select>
         </div>
     </div>
                  <div class="col-md-4">
                    <div class="form-group">
                     <label>Recovery</label>
                        <select  name="recovery[]" multiple class="form-control">
                            <option value='BS.id AS borrower_id'>BORROWER ID</option>
                           <!-- <option value='BN.bid_registration_id'>Bid Registration Id</option>-->
                            <option value='BS.name'>First Name</option> 
                            <option value='BS.email'>Email</option>                      
                            <option value='BS.mobile'>Mobile</option>
                            <option value='BN.loan_no'>Loan No</option>
                            <option value='BN.bid_loan_amount'>Loan Amount</option>
                            <option value='ADR.r_city'>City</option>
                            <option value='BNK.account_number'>Account Number</option>
                            <option value='bed.emi_date'>Emi Date</option>
                            <option value='bed.emi_amount'>Emi Amount</option>
							<option value="CASE
                              WHEN DATE(bed.emi_date) > CURDATE()  THEN 'Payment Not Due'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=7)  THEN 'G1'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >7 AND DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <= 15) then 'G2'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >15 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=21) then 'G3'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >21 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=30) then 'G4'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >30 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=60) then 'B1'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >60 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=90) then 'B2'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >90) then 'B3'

                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) <=7)  THEN 'G1'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >7 AND DATEDIFF(CURDATE(), bed.emi_date) <= 15) then 'G2'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >15 and DATEDIFF(CURDATE(), bed.emi_date) <=21) then 'G3'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >21 and DATEDIFF(CURDATE(), bed.emi_date) <=30) then 'G4'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >30 and DATEDIFF(CURDATE(), bed.emi_date) <=60) then 'B1'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >60 and DATEDIFF(CURDATE(), bed.emi_date) <=90) then 'B2'
                              WHEN  bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >90 then 'B3'

                              END AS Borrowerstatus">Status</option>
                        </select>
                        </div>
                    </div>

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
     </div>
                        

            <div role="tabpanel" class="tab-pane" id="Loannotgiven">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pnotgivenapp" method="post" enctype="multipart/form-data">
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='BS.created_date' selected>DATE</option>  
                            <option value='BS.borrower_id'>BORROWER ID</option>
                            <option value='BS.name'>CLIENT NAME</option>
                            <option value='BS.mobile'>PHONE NO.</option>
                            <option value='BS.email'>Email</option>
                            <option value='QUL.qualification'>Qualification</option>
                            <option value='OCU.name AS occupation'>Occupation</option>
                            <option value='BS.gender'>Gender</option>
                            <option value='BS.dob'>DOB</option>
                            <option value='ADR.r_city'>CITY</option>
                        </select>
                    </div>
                </div>


        <div class="col-md-4">
          <div class="form-group">
            <label>Rating</label>
              <select  name="rating[]" multiple class="form-control">
                <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                <option value='RATI.short_term_leveraging'>short term leveraging</option>
                <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                <option value='RATI.limit_breach'>limit breach</option>
                <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                <option value='RATI.digital_banking'>digital banking</option>
                <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                <option value='RATI.present_residence'>present residence</option>
                <option value='RATI.city_of_residence'>city of residence</option>
                <option value='RATI.highest_qualification'>rating highest qualification</option>
                <option value='RATI.age'>rating age</option>
                <option value='RATI.occupation'>rating occupation</option>
                <option value='RATI.experience'>rating experience</option>
            </select>
         </div>
     </div>
                 

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
    </div>
    </div>
    </div>

         <div role="tabpanel" class="tab-pane" id="p2pweb">
                <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#Loangivenweb" aria-controls="Loangivenweb" role="tab" data-toggle="tab">Loan Given</a></li>
                <li role="presentation"><a href="#Loannotgivenweb" aria-controls="Loannotgivenweb" role="tab" data-toggle="tab">Loan Not Given</a></li>
            </ul>

   <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="Loangivenweb">
     <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pgivenweb" method="post" enctype="multipart/form-data">
                      <div class="col-md-4">
                         <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='DLD.date_created' selected>DATE</option>  
                                <option value='BS.borrower_id'>BORROWER ID</option>
                                <option value='BS.name'>CLIENT NAME</option>
                                <option value='BS.mobile'>PHONE NO.</option>
                                <option value='BS.email'>Email</option>
                                <option value='QUL.qualification'>Qualification</option>
                                <option value='OCU.name AS occupation'>Occupation</option>
                                <option value='BS.gender'>Gender</option>
                                <option value='BS.dob'>DOB</option>
                                <option value='ADR.r_city'>CITY</option>
                            </select>
                         </div>
                      </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loan Details</label>
                                    <select  name="loan[]" multiple class="form-control">
                                        <option value='BNK.account_number'>BENIFICIARY A/C NO</option>
                                        <option value='BNK.ifsc_code'>IFSC CODE</option>
                                        <option value='BNK.bank_name'>BANK NAME</option>
                                        <option value='DLD.approved_loan_amount'>LOAN AMOUNT</option>
                                        <option value='DLD.loan_processing_charges'>PROCESSING FEES</option>
                                        <option value='bed.emi_interest'>ROI</option>
                                        <option value='BN.accepted_tenor'>TENURE/MONTH</option>
                                        <option value='bed.emi_amount'>EMI AMOUNT</option>
                                        <option value='bed.emi_date'>REPAYMENT DATE</option>
                                        <option value='BN.loan_no'>LOAN NO</option>
                                    </select>
                                 </div>
                             </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Rating</label>
              <select  name="rating[]" multiple class="form-control">
                <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                <option value='RATI.short_term_leveraging'>short term leveraging</option>
                <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                <option value='RATI.limit_breach'>limit breach</option>
                <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                <option value='RATI.digital_banking'>digital banking</option>
                <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                <option value='RATI.present_residence'>present residence</option>
                <option value='RATI.city_of_residence'>city of residence</option>
                <option value='RATI.highest_qualification'>rating highest qualification</option>
                <option value='RATI.age'>rating age</option>
                <option value='RATI.occupation'>rating occupation</option>
                <option value='RATI.experience'>rating experience</option>
            </select>
         </div>
     </div>
                  <div class="col-md-4">
                    <div class="form-group">
                     <label>Recovery</label>
                        <select  name="recovery[]" multiple class="form-control">
                            <option value='BS.id AS borrower_id'>BORROWER ID</option>
                           <!-- <option value='BN.bid_registration_id'>Bid Registration Id</option>-->
                            <option value='BS.name'>First Name</option> 
                            <option value='BS.email'>Email</option>                      
                            <option value='BS.mobile'>Mobile</option>
                            <option value='BN.loan_no'>Loan No</option>
                            <option value='BN.bid_loan_amount'>Loan Amount</option>
                            <option value='ADR.r_city'>City</option>
                            <option value='BNK.account_number'>Account Number</option>
                            <option value='bed.emi_date'>Emi Date</option>
                            <option value='bed.emi_amount'>Emi Amount</option>
							<option value="CASE
                              WHEN DATE(bed.emi_date) > CURDATE()  THEN 'Payment Not Due'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=7)  THEN 'G1'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >7 AND DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <= 15) then 'G2'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >15 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=21) then 'G3'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >21 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=30) then 'G4'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >30 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=60) then 'B1'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >60 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) <=90) then 'B2'
                              WHEN (bed.status = 1 and DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >90) then 'B3'

                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) <=7)  THEN 'G1'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >7 AND DATEDIFF(CURDATE(), bed.emi_date) <= 15) then 'G2'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >15 and DATEDIFF(CURDATE(), bed.emi_date) <=21) then 'G3'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >21 and DATEDIFF(CURDATE(), bed.emi_date) <=30) then 'G4'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >30 and DATEDIFF(CURDATE(), bed.emi_date) <=60) then 'B1'
                              WHEN (bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >60 and DATEDIFF(CURDATE(), bed.emi_date) <=90) then 'B2'
                              WHEN  bed.status = 0 and DATEDIFF(CURDATE(), bed.emi_date) >90 then 'B3'

                              END AS Borrowerstatus">Status</option>
                        </select>
                        </div>
                    </div>

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
   </div>
            

            <div role="tabpanel" class="tab-pane" id="Loannotgivenweb">
             <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pnotgivenweb" method="post" enctype="multipart/form-data">
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='BS.created_date' selected>DATE</option>  
                            <option value='BS.borrower_id'>BORROWER ID</option>
                            <option value='BS.name'>CLIENT NAME</option>
                            <option value='BS.mobile'>PHONE NO.</option>
                            <option value='BS.email'>Email</option>
                            <option value='QUL.qualification'>Qualification</option>
                            <option value='OCU.name AS occupation'>Occupation</option>
                            <option value='BS.gender'>Gender</option>
                            <option value='BS.dob'>DOB</option>
                            <option value='ADR.r_city'>CITY</option>
                        </select>
                    </div>
                </div>

                       

        <div class="col-md-4">
          <div class="form-group">
            <label>Rating</label>
              <select  name="rating[]" multiple class="form-control">
                <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                <option value='RATI.short_term_leveraging'>short term leveraging</option>
                <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                <option value='RATI.limit_breach'>limit breach</option>
                <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                <option value='RATI.digital_banking'>digital banking</option>
                <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                <option value='RATI.present_residence'>present residence</option>
                <option value='RATI.city_of_residence'>city of residence</option>
                <option value='RATI.highest_qualification'>rating highest qualification</option>
                <option value='RATI.age'>rating age</option>
                <option value='RATI.occupation'>rating occupation</option>
                <option value='RATI.experience'>rating experience</option>
            </select>
         </div>
     </div>
               

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
        </div>
    </div>
    </div>


         
        <div role="tabpanel" class="tab-pane" id="p2pall">
             <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pall" method="post" enctype="multipart/form-data">
                      <div class="col-md-4">
                         <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='DLD.date_created' selected>DATE</option>  
                                <option value='BS.borrower_id'>BORROWER ID</option>
                                <option value='BS.name'>CLIENT NAME</option>
                                <option value='BS.mobile'>PHONE NO.</option>
                                <option value='BS.email'>Email</option>
                                <option value='QUL.qualification'>Qualification</option>
                                <option value='OCU.name AS occupation'>Occupation</option>
                                <option value='BS.gender'>Gender</option>
                                <option value='BS.dob'>DOB</option>
                                <option value='ADR.r_city'>CITY</option>
                            </select>
                        </div>
                    </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Loan Details</label>
                            <select  name="loan[]" multiple class="form-control">
                                <option value='BNK.account_number'>BENIFICIARY A/C NO</option>
                                <option value='BNK.ifsc_code'>IFSC CODE</option>
                                <option value='BNK.bank_name'>BANK NAME</option>
                                <option value='DLD.approved_loan_amount'>LOAN AMOUNT</option>
                                <option value='DLD.loan_processing_charges'>PROCESSING FEES</option>
                                <option value='EMI.emi_interest'>ROI</option>
                                <option value='BN.accepted_tenor'>TENURE/MONTH</option>
                                <option value='EMI.emi_amount'>EMI AMOUNT</option>
                                <option value='EMI.emi_date'>REPAYMENT DATE</option>
                                <option value='BN.loan_no'>LOAN NO</option>
                            </select>
                         </div>
                     </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Rating</label>
                      <select  name="rating[]" multiple class="form-control">
                        <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                        <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                        <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                        <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                        <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                        <option value='RATI.short_term_leveraging'>short term leveraging</option>
                        <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                        <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                        <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                        <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                        <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                        <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                        <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                        <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                        <option value='RATI.limit_breach'>limit breach</option>
                        <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                        <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                        <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                        <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                        <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                        <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                        <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                        <option value='RATI.digital_banking'>digital banking</option>
                        <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                        <option value='RATI.present_residence'>present residence</option>
                        <option value='RATI.city_of_residence'>city of residence</option>
                        <option value='RATI.highest_qualification'>rating highest qualification</option>
                        <option value='RATI.age'>rating age</option>
                        <option value='RATI.occupation'>rating occupation</option>
                        <option value='RATI.experience'>rating experience</option>
                    </select>
                 </div>
             </div>
                <div class="col-md-4">
                    <div class="form-group">
                     <label>Recovery</label>
                        <select  name="recovery[]" multiple class="form-control">
                            <option value='BS.id AS borrower_id'>BORROWER ID</option>
                           <!-- <option value='BN.bid_registration_id'>Bid Registration Id</option>-->
                            <option value='BS.name'>First Name</option> 
                            <option value='BS.email'>Email</option>                      
                            <option value='BS.mobile'>Mobile</option>
                            <option value='BN.loan_no'>Loan No</option>
                            <option value='BN.bid_loan_amount'>Loan Amount</option>
                            <option value='ADR.r_city'>City</option>
                            <option value='BNK.account_number'>Account Number</option>
                            <option value='EMI.emi_date'>Emi Date</option>
                            <option value='EMI.emi_amount'>Emi Amount</option>
                            <option value='EMI.status'>Status</option>
                        </select>
                        </div>
                    </div>

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
     </div>

			<div role="tabpanel" class="tab-pane" id="p2pborrowerstatus">
				<form action="<?php echo base_url(); ?>p2padmin/mis/downloadBorrowerstatus" method="post" enctype="multipart/form-data">
					<div class="col-md-4">
						<div class="form-group">
							<label>Personal Details</label>
							<select  name="personal[]" multiple class="form-control">
								<option value='DLD.date_created' selected>DATE</option>
								<option value='BL.borrower_id'>BORROWER ID</option>
								<option value='BL.name'>CLIENT NAME</option>
								<option value='BL.mobile'>PHONE NO.</option>
								<option value='BL.email'>Email</option>
								<option value='QUL.qualification'>Qualification</option>
								<option value='OCU.name AS occupation'>Occupation</option>
								<option value='BL.gender'>Gender</option>
								<option value='BL.dob'>DOB</option>
								<option value='ADR.r_city'>CITY</option>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Loan Details</label>
							<select  name="loan[]" multiple class="form-control">
								<option value='BNK.account_number'>BENIFICIARY A/C NO</option>
								<option value='BNK.ifsc_code'>IFSC CODE</option>
								<option value='BNK.bank_name'>BANK NAME</option>
								<option value='DLD.approved_loan_amount'>LOAN AMOUNT</option>
								<option value='DLD.loan_processing_charges'>PROCESSING FEES</option>
								<option value='bed.emi_interest'>ROI</option>
								<option value='BN.accepted_tenor'>TENURE/MONTH</option>
								<option value='bed.emi_amount'>EMI AMOUNT</option>
								<option value='bed.emi_date'>REPAYMENT DATE</option>
								<option value='BN.loan_no'>LOAN NO</option>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Rating</label>
							<select  name="rating[]" multiple class="form-control">
								<option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
								<option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
								<option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
								<option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
								<option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
								<option value='RATI.short_term_leveraging'>short term leveraging</option>
								<option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
								<option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
								<option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
								<option value='RATI.no_of_active_accounts'>no of active accounts</option>
								<option value='RATI.variety_of_loans_active'>variety of loans active</option>
								<option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
								<option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
								<option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
								<option value='RATI.limit_breach'>limit breach</option>
								<option value='RATI.overdue_to_obligation'>overdue to obligation</option>
								<option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
								<option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
								<option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
								<option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
								<option value='RATI.cheque_bouncing'>cheque bouncing</option>
								<option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
								<option value='RATI.digital_banking'>digital banking</option>
								<option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
								<option value='RATI.present_residence'>present residence</option>
								<option value='RATI.city_of_residence'>city of residence</option>
								<option value='RATI.highest_qualification'>rating highest qualification</option>
								<option value='RATI.age'>rating age</option>
								<option value='RATI.occupation'>rating occupation</option>
								<option value='RATI.experience'>rating experience</option>
							</select>
						</div>
					</div>

					<div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
				</form>
			</div>
                        

        <div role="tabpanel" class="tab-pane" id="Loannotgiven">
             <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadMisp2pnotgivenapp" method="post" enctype="multipart/form-data">
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='BS.created_date' selected>DATE</option>  
                            <option value='BS.borrower_id'>BORROWER ID</option>
                            <option value='BS.name'>CLIENT NAME</option>
                            <option value='BS.mobile'>PHONE NO.</option>
                            <option value='BS.email'>Email</option>
                            <option value='QUL.qualification'>Qualification</option>
                            <option value='OCU.name AS occupation'>Occupation</option>
                            <option value='BS.gender'>Gender</option>
                            <option value='BS.dob'>DOB</option>
                            <option value='ADR.r_city'>CITY</option>
                        </select>
                    </div>
                </div>


        <div class="col-md-4">
          <div class="form-group">
            <label>Rating</label>
              <select  name="rating[]" multiple class="form-control">
                <option value='RATI.overall_leveraging_ratio'>overall leveraging ratio</option>
                <option value='RATI.leverage_ratio_maximum_available_credit'>leverage ratio maximum available credit</option>
                <option value='RATI.limit_utilization_revolving_credit'>limit utilization revolving credit</option>
                <option value='RATI.outstanding_to_limit_term_credit'>outstanding to limit term credit</option>
                <option value='RATI.outstanding_to_limit_term_credit_including_past_facilities'>outstanding to limit term credit including past facilities</option>
                <option value='RATI.short_term_leveraging'>short term leveraging</option>
                <option value='RATI.short_term_credit_to_total_credit'>short term credit to total credit</option>
                <option value='RATI.secured_facilities_to_total_credit'>secured facilities to total credit</option>
                <option value='RATI.fixed_obligation_to_income'>fixed obligation to income</option>
                <option value='RATI.no_of_active_accounts'>no of active accounts</option>
                <option value='RATI.variety_of_loans_active'>variety of loans active</option>
                <option value='RATI.no_of_credit_enquiry_in_last_3_months'>no of credit enquiry in last 3 months</option>
                <option value='RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months'>no of loans availed to credit enquiry in last 12 months</option>
                <option value='RATI.history_of_credit_oldest_credit_account'>history of credit oldest credit account</option>
                <option value='RATI.limit_breach'>limit breach</option>
                <option value='RATI.overdue_to_obligation'>overdue to obligation</option>
                <option value='RATI.overdue_to_monthly_income'>overdue to monthly income</option>
                <option value='RATI.number_of_instances_of_delay_in_past_6_months'>number of instances of delay in past 6 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_12_months'>number of instances of delay in past 12 months</option>
                <option value='RATI.number_of_instances_of_delay_in_past_36_months'>number of instances of delay in past 36 months</option>
                <option value='RATI.cheque_bouncing'>cheque bouncing</option>
                <option value='RATI.credit_summation_to_annual_income'>credit summation to annual income</option>
                <option value='RATI.digital_banking'>digital banking</option>
                <option value='RATI.savings_as_percentage_of_annual_income'>savings as percentage of annual income</option>
                <option value='RATI.present_residence'>present residence</option>
                <option value='RATI.city_of_residence'>city of residence</option>
                <option value='RATI.highest_qualification'>rating highest qualification</option>
                <option value='RATI.age'>rating age</option>
                <option value='RATI.occupation'>rating occupation</option>
                <option value='RATI.experience'>rating experience</option>
            </select>
         </div>
     </div>
                 

        <div class="col-md-12 text-right"><button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
      </form>
    </div>    
 </div>
</div>

    

   <div role="tabpanel" class="tab-pane" id="cc">
        <ul class="nav nav-tabs" role="tablist">
   
        <li role="presentation"><a href="#ccweb" aria-controls="ccweb" role="tab" data-toggle="tab">CC Web</a></li>
        <li role="presentation"><a href="#ccall" aria-controls="ccall" role="tab" data-toggle="tab">CC all</a></li>
      </ul>
         <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="ccweb">
               
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#Ccconverted" aria-controls="Ccconverted" role="tab" data-toggle="tab">CC converted</a></li>
                <li role="presentation"><a href="#Ccnonconverted" aria-controls="Ccnonconverted" role="tab" data-toggle="tab">CC non converted</a></li>
            </ul>



                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="Ccconverted">
                             <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="#Ccconverted1" aria-controls="Ccconverted1" role="tab" data-toggle="tab">Google</a></li>
                                <li role="presentation"><a href="#Ccconverted2" aria-controls="Ccconverted2" role="tab" data-toggle="tab">Online</a></li>
                                <li role="presentation"><a href="#Ccconverted3" aria-controls="Ccconverted3" role="tab" data-toggle="tab">Free Credit Score</a></li>
                                <li role="presentation"><a href="#Ccconverted4" aria-controls="Ccconverted4" role="tab" data-toggle="tab">Transfer From U</a></li>
                                <li role="presentation"><a href="#Ccconverted5" aria-controls="Ccconverted5" role="tab" data-toggle="tab">Transfer From M</a></li>
                                <li role="presentation"><a href="#Ccconverted6" aria-controls="Ccconverted6" role="tab" data-toggle="tab">Facebook</a></li>
                                <li role="presentation"><a href="#Ccconverted7" aria-controls="Ccconverted7" role="tab" data-toggle="tab">Scrub Data</a></li>
                                <li role="presentation"><a href="#Ccconverted8" aria-controls="Ccconverted8" role="tab" data-toggle="tab">Financial Buddy</a></li>
                                <li role="presentation"><a href="#Ccconverted9" aria-controls="Ccconverted9" role="tab" data-toggle="tab">Blog Website</a></li>
                                <li role="presentation"><a href="#Ccconverted10" aria-controls="Ccconverted10" role="tab" data-toggle="tab">Transfer From P2P</a></li>
                                <li role="presentation"><a href="#Ccconverted11" aria-controls="Ccconverted11" role="tab" data-toggle="tab">Transfer From CRM</a></li>
                                <li role="presentation"><a href="#Ccconverted12" aria-controls="Ccconverted12" role="tab" data-toggle="tab">Landing Adda</a></li>
                             </ul>
                 <div class="tab-content">
                 <div role="tabpanel" class="tab-pane" id="Ccconverted1">   
                 <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadGoogleccCon" method="post" enctype="multipart/form-data">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Personal Details</label>
                                            <select  name="cccon[]" multiple class="form-control">
                                                <option value='created_date' >Date</option>    
                                                <option value='id' selected>LEAD ID</option>  
                                                <option value='firstName'>FIRST NAME</option>
                                                <option value='surName'>LAST NAME</option>
                                                <option value='dateOfBirth'>DOB</option>
                                                <option value='gender'>GENDER</option>
                                                <option value='email'>EMAIL</option>
                                                <option value='flatno'>FLOT NO.</option>
                                                <option value='city'>CITY</option>
                                                <option value='pincode'>PINCODE</option>
                                                <option value='pan'>PAN</option>
                                                <option value='mobileNo'>PHONE NO.</option>
                                                <option value='monthly_income'>INCOME</option>
                                                <option value='experian_rating '>EXPERIAN RATING</option>
                                                <option value='gst'>GST</option>
                                                <option value='package'>PACKAGE</option>
                                            </select>
                                        </div>
                                    </div>             

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                        </div>
                      </form>
                  </div>



                <div role="tabpanel" class="tab-pane" id="Ccconverted2">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadOnlineccCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                            <option value='gst'>GST</option>
                                            <option value='package'>PACKAGE</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>
                           

        <div role="tabpanel" class="tab-pane" id="Ccconverted3">
        <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFreeCraditScoreccCon" method="post" enctype="multipart/form-data">
                                         <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Personal Details</label>
                                                <select  name="cccon[]" multiple class="form-control">   
                                                    <option value='created_date' >Date</option> 
                                                    <option value='id' selected>LEAD ID</option>  
                                                    <option value='firstName'>FIRST NAME</option>
                                                    <option value='surName'>LAST NAME</option>
                                                    <option value='dateOfBirth'>DOB</option>
                                                    <option value='gender'>GENDER</option>
                                                    <option value='email'>EMAIL</option>
                                                    <option value='flatno'>FLOT NO.</option>
                                                    <option value='city'>CITY</option>
                                                    <option value='pincode'>PINCODE</option>
                                                    <option value='pan'>PAN</option>
                                                    <option value='mobileNo'>PHONE NO.</option>
                                                    <option value='monthly_income'>INCOME</option>
                                                    <option value='experian_rating'>EXPERIAN RATING</option>
                                                    <option value='gst'>GST</option>
                                                <option value='package'>PACKAGE</option>
                                                </select>
                                            </div>
                                        </div>             

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                          </form>
                        </div>


            <div role="tabpanel" class="tab-pane" id="Ccconverted4">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromUccCon" method="post" enctype="multipart/form-data">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Personal Details</label>
                                            <select  name="cccon[]" multiple class="form-control">  
                                                <option value='created_date' >Date</option>  
                                                <option value='id' selected>LEAD ID</option>  
                                                <option value='firstName'>FIRST NAME</option>
                                                <option value='surName'>LAST NAME</option>
                                                <option value='dateOfBirth'>DOB</option>
                                                <option value='gender'>GENDER</option>
                                                <option value='email'>EMAIL</option>
                                                <option value='flatno'>FLOT NO.</option>
                                                <option value='city'>CITY</option>
                                                <option value='pincode'>PINCODE</option>
                                                <option value='pan'>PAN</option>
                                                <option value='mobileNo'>PHONE NO.</option>
                                                <option value='monthly_income'>INCOME</option>
                                                <option value='experian_rating'>EXPERIAN RATING</option>
                                                <option value='gst'>GST</option>
                                                <option value='package'>PACKAGE</option>
                                            </select>
                                        </div>
                                    </div>             

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                      </form>
                  </div>

                <div role="tabpanel" class="tab-pane" id="Ccconverted5">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromMccCon" method="post" enctype="multipart/form-data">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Personal Details</label>
                                            <select  name="cccon[]" multiple class="form-control">  
                                                <option value='created_date' >Date</option>  
                                                <option value='id' selected>LEAD ID</option>  
                                                <option value='firstName'>FIRST NAME</option>
                                                <option value='surName'>LAST NAME</option>
                                                <option value='dateOfBirth'>DOB</option>
                                                <option value='gender'>GENDER</option>
                                                <option value='email'>EMAIL</option>
                                                <option value='flatno'>FLOT NO.</option>
                                                <option value='city'>CITY</option>
                                                <option value='pincode'>PINCODE</option>
                                                <option value='pan'>PAN</option>
                                                <option value='mobileNo'>PHONE NO.</option>
                                                <option value='monthly_income'>INCOME</option>
                                                <option value='experian_rating'>EXPERIAN RATING</option>
                                                <option value='gst'>GST</option>
                                                <option value='package'>PACKAGE</option>
                                            </select>
                                        </div>
                                    </div>             

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                      </form>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="Ccconverted6">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFacebookccCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control"> 
                                            <option value='created_date' >Date</option>   
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                            <option value='gst'>GST</option>
                                            <option value='package'>PACKAGE</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>


              <div role="tabpanel" class="tab-pane" id="Ccconverted7">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadScrubDataccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">  
                                        <option value='created_date' >Date</option>  
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted8">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFinancialBuddyccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">   
                                        <option value='created_date' >Date</option> 
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
              </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted9">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadBlogWebsiteccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                        <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

        <div role="tabpanel" class="tab-pane" id="Ccconverted10">  
        
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferfromPTPccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">  
                                        <option value='created_date' >Date</option>  
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted11">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromCRMccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                        <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted12">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadLandingAddaccCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">  
                                        <option value='created_date' >Date</option>  
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                        <option value='gst'>GST</option>
                                        <option value='package'>PACKAGE</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>
         </div>

        </div>


          <div role="tabpanel" class="tab-pane" id="Ccnonconverted">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#Ccconverted13" aria-controls="Ccconverted13" role="tab" data-toggle="tab">Google</a></li>
                <li role="presentation"><a href="#Ccconverted14" aria-controls="Ccconverted14" role="tab" data-toggle="tab">Online</a></li>
                <li role="presentation"><a href="#Ccconverted15" aria-controls="Ccconverted15" role="tab" data-toggle="tab">Free Credit Score</a></li>
                <li role="presentation"><a href="#Ccconverted16" aria-controls="Ccconverted16" role="tab" data-toggle="tab">Transfer From U</a></li>
                <li role="presentation"><a href="#Ccconverted17" aria-controls="Ccconverted17" role="tab" data-toggle="tab">Transfer From M</a></li>
                <li role="presentation"><a href="#Ccconverted18" aria-controls="Ccconverted18" role="tab" data-toggle="tab">Facebook</a></li>
                <li role="presentation"><a href="#Ccconverted19" aria-controls="Ccconverted19" role="tab" data-toggle="tab">Scrub Data</a></li>
                <li role="presentation"><a href="#Ccconverted20" aria-controls="Ccconverted20" role="tab" data-toggle="tab">Financial Buddy</a></li>
                <li role="presentation"><a href="#Ccconverted21" aria-controls="Ccconverted21" role="tab" data-toggle="tab">Blog Website</a></li>
                <li role="presentation"><a href="#Ccconverted22" aria-controls="Ccconverted22" role="tab" data-toggle="tab">Transfer From P2P</a></li>
                <li role="presentation"><a href="#Ccconverted23" aria-controls="Ccconverted23" role="tab" data-toggle="tab">Transfer From CRM</a></li>
                <li role="presentation"><a href="#Ccconverted24" aria-controls="Ccconverted24" role="tab" data-toggle="tab">Landing Adda</a></li>
             </ul>

             <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="Ccconverted13">   
                 <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadGoogleccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control"> 
                                            <option value='created_date' >Date</option>   
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                  </form>
              </div>


             <div role="tabpanel" class="tab-pane" id="Ccconverted14">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadOnlineccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">  
                                            <option value='created_date' >Date</option>  
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>


                <div role="tabpanel" class="tab-pane" id="Ccconverted15">
                   <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFreeCraditScoreccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control"> 
                                            <option value='created_date' >Date</option>   
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
                </div>

                 <div role="tabpanel" class="tab-pane" id="Ccconverted16">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromUccNonCon" method="post" enctype="multipart/form-data">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Personal Details</label>
                                            <select  name="cccon[]" multiple class="form-control">  
                                                <option value='created_date' >Date</option>  
                                                <option value='id' selected>LEAD ID</option>  
                                                <option value='firstName'>FIRST NAME</option>
                                                <option value='surName'>LAST NAME</option>
                                                <option value='dateOfBirth'>DOB</option>
                                                <option value='gender'>GENDER</option>
                                                <option value='email'>EMAIL</option>
                                                <option value='flatno'>FLOT NO.</option>
                                                <option value='city'>CITY</option>
                                                <option value='pincode'>PINCODE</option>
                                                <option value='pan'>PAN</option>
                                                <option value='mobileNo'>PHONE NO.</option>
                                                <option value='monthly_income'>INCOME</option>
                                                <option value='experian_rating'>EXPERIAN RATING</option>
                                            </select>
                                        </div>
                                    </div>             

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                      </form>
                  </div>

                <div role="tabpanel" class="tab-pane" id="Ccconverted17">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromMccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted18">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFacebookccNonCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">   
                                        <option value='created_date' >Date</option> 
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>


              <div role="tabpanel" class="tab-pane" id="Ccconverted19">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadScrubDataccNonCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">   
                                        <option value='created_date' >Date</option> 
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted20">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFinancialBuddyccNonCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                        <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

                <div role="tabpanel" class="tab-pane" id="Ccconverted21">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadBlogWebsitecNoncCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

                  <div role="tabpanel" class="tab-pane" id="Ccconverted22">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromP2PccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

            <div role="tabpanel" class="tab-pane" id="Ccconverted23">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromCRMccNonCon" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">   
                                        <option value='created_date' >Date</option> 
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

            <div role="tabpanel" class="tab-pane" id="Ccconverted24">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadLandingAddaccNonCon" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">  
                                            <option value='created_date' >Date</option>  
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>
             </div>

            </div>


        </div>

     </div>


 <div role="tabpanel" class="tab-pane" id="ccall">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="#Ccconverted25" aria-controls="Ccconverted25" role="tab" data-toggle="tab">Google</a></li>
                <li role="presentation"><a href="#Ccconverted26" aria-controls="Ccconverted26" role="tab" data-toggle="tab">Online</a></li>
                <li role="presentation"><a href="#Ccconverted27" aria-controls="Ccconverted27" role="tab" data-toggle="tab">Free Cradit Score</a></li>
                <li role="presentation"><a href="#Ccconverted28" aria-controls="Ccconverted28" role="tab" data-toggle="tab">Transfer From U</a></li>
                <li role="presentation"><a href="#Ccconverted29" aria-controls="Ccconverted29" role="tab" data-toggle="tab">Transfer From M</a></li>
                <li role="presentation"><a href="#Ccconverted30" aria-controls="Ccconverted30" role="tab" data-toggle="tab">Facebook</a></li>
                <li role="presentation"><a href="#Ccconverted31" aria-controls="Ccconverted31" role="tab" data-toggle="tab">Scrub Data</a></li>
                <li role="presentation"><a href="#Ccconverted32" aria-controls="Ccconverted32" role="tab" data-toggle="tab">Financial Buddy</a></li>
                <li role="presentation"><a href="#Ccconverted33" aria-controls="Ccconverted33" role="tab" data-toggle="tab">Blog Website</a></li>
                <li role="presentation"><a href="#Ccconverted34" aria-controls="Ccconverted34" role="tab" data-toggle="tab">Transfer From P2P</a></li>
                <li role="presentation"><a href="#Ccconverted35" aria-controls="Ccconverted35" role="tab" data-toggle="tab">Transfer From CRM</a></li>
                <li role="presentation"><a href="#Ccconverted36" aria-controls="Ccconverted36" role="tab" data-toggle="tab">Landing Adda</a></li>
             </ul>

             <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="Ccconverted25">   
                 <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadGoogleccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control"> 
                                            <option value='created_date' >Date</option>   
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                  </form>
              </div>


             <div role="tabpanel" class="tab-pane" id="Ccconverted26">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadOnlineccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>


                <div role="tabpanel" class="tab-pane" id="Ccconverted27">
                   <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFreeCraditScoreccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
                </div>

                 <div role="tabpanel" class="tab-pane" id="Ccconverted28">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromUccall" method="post" enctype="multipart/form-data">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Personal Details</label>
                                            <select  name="cccon[]" multiple class="form-control">  
                                            <option value='created_date' >Date</option>  
                                                <option value='id' selected>LEAD ID</option>  
                                                <option value='firstName'>FIRST NAME</option>
                                                <option value='surName'>LAST NAME</option>
                                                <option value='dateOfBirth'>DOB</option>
                                                <option value='gender'>GENDER</option>
                                                <option value='email'>EMAIL</option>
                                                <option value='flatno'>FLOT NO.</option>
                                                <option value='city'>CITY</option>
                                                <option value='pincode'>PINCODE</option>
                                                <option value='pan'>PAN</option>
                                                <option value='mobileNo'>PHONE NO.</option>
                                                <option value='monthly_income'>INCOME</option>
                                                <option value='experian_rating'>EXPERIAN RATING</option>
                                            </select>
                                        </div>
                                    </div>             

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                      </form>
                  </div>

                <div role="tabpanel" class="tab-pane" id="Ccconverted29">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromMccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted30">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFacebookccall" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                    <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>


              <div role="tabpanel" class="tab-pane" id="Ccconverted31">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadScrubDataccall" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                    <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

              <div role="tabpanel" class="tab-pane" id="Ccconverted32">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadFinancialBuddyccall" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control"> 
                                    <option value='created_date' >Date</option>   
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

                <div role="tabpanel" class="tab-pane" id="Ccconverted33">  
                <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadBlogWebsiteccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

                  <div role="tabpanel" class="tab-pane" id="Ccconverted34">  
                    <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromP2Pccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control">   
                                            <option value='created_date' >Date</option> 
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>

            <div role="tabpanel" class="tab-pane" id="Ccconverted35">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadTransferFromCRMccall" method="post" enctype="multipart/form-data">
                             <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="cccon[]" multiple class="form-control">   
                                        <option value='created_date' >Date</option> 
                                        <option value='id' selected>LEAD ID</option>  
                                        <option value='firstName'>FIRST NAME</option>
                                        <option value='surName'>LAST NAME</option>
                                        <option value='dateOfBirth'>DOB</option>
                                        <option value='gender'>GENDER</option>
                                        <option value='email'>EMAIL</option>
                                        <option value='flatno'>FLOT NO.</option>
                                        <option value='city'>CITY</option>
                                        <option value='pincode'>PINCODE</option>
                                        <option value='pan'>PAN</option>
                                        <option value='mobileNo'>PHONE NO.</option>
                                        <option value='monthly_income'>INCOME</option>
                                        <option value='experian_rating'>EXPERIAN RATING</option>
                                    </select>
                                </div>
                            </div>             

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
              </form>
          </div>

            <div role="tabpanel" class="tab-pane" id="Ccconverted36">  
            <form action="<?php echo base_url(); ?>p2padmin/misconverted/doenloadLandingAddaccall" method="post" enctype="multipart/form-data">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Personal Details</label>
                                        <select  name="cccon[]" multiple class="form-control"> 
                                        <option value='created_date' >Date</option>   
                                            <option value='id' selected>LEAD ID</option>  
                                            <option value='firstName'>FIRST NAME</option>
                                            <option value='surName'>LAST NAME</option>
                                            <option value='dateOfBirth'>DOB</option>
                                            <option value='gender'>GENDER</option>
                                            <option value='email'>EMAIL</option>
                                            <option value='flatno'>FLOT NO.</option>
                                            <option value='city'>CITY</option>
                                            <option value='pincode'>PINCODE</option>
                                            <option value='pan'>PAN</option>
                                            <option value='mobileNo'>PHONE NO.</option>
                                            <option value='monthly_income'>INCOME</option>
                                            <option value='experian_rating'>EXPERIAN RATING</option>
                                        </select>
                                    </div>
                                </div>             

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button></div>
                  </form>
              </div>
             </div>

            </div>
    </div>

</div>



    <div role="tabpanel" class="tab-pane" id="all">
        <ul class="nav nav-tabs" role="tablist">
   
        <li role="presentation"><a href="#allcon" aria-controls="allcon" role="tab" data-toggle="tab">ALL converted</a></li>
        <li role="presentation"><a href="#allnoncon" aria-controls="allnoncon" role="tab" data-toggle="tab">ALL non converted</a></li>
        <li role="presentation"><a href="#alllead" aria-controls="alllead" role="tab" data-toggle="tab">ALL</a></li>
      </ul>
                  
<div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="allcon">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#all1" aria-controls="all1" role="tab" data-toggle="tab">Google</a></li>
        <li role="presentation"><a href="#all2" aria-controls="all2" role="tab" data-toggle="tab">Facebook</a></li>
        <li role="presentation"><a href="#all3" aria-controls="all3" role="tab" data-toggle="tab">Website</a></li>
        <li role="presentation"><a href="#all4" aria-controls="all4" role="tab" data-toggle="tab">Created</a></li>
        <li role="presentation"><a href="#all5" aria-controls="all5" role="tab" data-toggle="tab">Classified</a></li>
        <li role="presentation"><a href="#all6" aria-controls="all6" role="tab" data-toggle="tab">Emailer</a></li>
        <li role="presentation"><a href="#all7" aria-controls="all7" role="tab" data-toggle="tab">Fin Buddy</a></li>
        <li role="presentation"><a href="#all8" aria-controls="all8" role="tab" data-toggle="tab">Soft Call </a></li>
        <li role="presentation"><a href="#all9" aria-controls="all9" role="tab" data-toggle="tab">Transfer F</a></li>
        <li role="presentation"><a href="#all10" aria-controls="all10" role="tab" data-toggle="tab">Scrub Data</a></li>
        <li role="presentation"><a href="#all11" aria-controls="all11" role="tab" data-toggle="tab">Landing Ad</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="all1">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadGoogleallCon" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
            </form>
            </div>

           <div role="tabpanel" class="tab-pane" id="all2">
                <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFacebookallCon" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
          </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all3">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadWebsiteallCon" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

       <div role="tabpanel" class="tab-pane" id="all4">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadCreatedallCon" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='ALL.created_date'>DATE</option>  
                            <option value='ALL.id' selected>LEAD ID</option>
                            <option value='ALL.fname'>FIRST NAME</option>
                            <option value='ALL.lname'>LAST NAME</option>
                            <option value='ALL.email'>Email</option>
                            <option value='ALL.mobile'>MOBILE</option>
                            <option value='ALL.pan'>PAN</option>
                            <option value='ALL.gender'>GENDER</option>
                            <option value='ALL.marital_status'>MARITAL STATUS</option>
                            <option value='ALL.cibil_score'>CIBIL SCORE</option>
                        </select>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all5">
             <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadClassifiedallCon" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

        <div role="tabpanel" class="tab-pane" id="all6">
           <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadEmailerallCon" method="post" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>Personal Details</label>
                                <select  name="personal[]" multiple class="form-control">   
                                    <option value='ALL.created_date'>DATE</option>  
                                    <option value='ALL.id' selected>LEAD ID</option>
                                    <option value='ALL.fname'>FIRST NAME</option>
                                    <option value='ALL.lname'>LAST NAME</option>
                                    <option value='ALL.email'>Email</option>
                                    <option value='ALL.mobile'>MOBILE</option>
                                    <option value='ALL.pan'>PAN</option>
                                    <option value='ALL.gender'>GENDER</option>
                                    <option value='ALL.marital_status'>MARITAL STATUS</option>
                                    <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                </select>
                            </div>
                        </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

        <div role="tabpanel" class="tab-pane" id="all7">
         <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFinBuddyallCon" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>

            <div role="tabpanel" class="tab-pane" id="all8">
             <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadSoftCallallCon" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
            </div>


            <div role="tabpanel" class="tab-pane" id="all9">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadTransferFallCon" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
            <div role="tabpanel" class="tab-pane" id="all10">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadScrubDataallCon" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>

            <div role="tabpanel" class="tab-pane" id="all11">
            <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadLandingAdallCon" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
            </form>
          </div>

            </div>
            </div>

        <div role="tabpanel" class="tab-pane" id="allnoncon">
                 <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#all21" aria-controls="all21" role="tab" data-toggle="tab">Google</a></li>
                    <li role="presentation"><a href="#all22" aria-controls="all22" role="tab" data-toggle="tab">Facebook</a></li>
                    <li role="presentation"><a href="#all23" aria-controls="all23" role="tab" data-toggle="tab">Website</a></li>
                    <li role="presentation"><a href="#all24" aria-controls="all24" role="tab" data-toggle="tab">Created</a></li>
                    <li role="presentation"><a href="#all25" aria-controls="all25" role="tab" data-toggle="tab">Classified</a></li>
                    <li role="presentation"><a href="#all26" aria-controls="all26" role="tab" data-toggle="tab">Emailer</a></li>
                    <li role="presentation"><a href="#all27" aria-controls="all27" role="tab" data-toggle="tab">Fin Buddy</a></li>
                    <li role="presentation"><a href="#all28" aria-controls="all28" role="tab" data-toggle="tab">Soft Call </a></li>
                    <li role="presentation"><a href="#all29" aria-controls="all29" role="tab" data-toggle="tab">Transfer F</a></li>
                    <li role="presentation"><a href="#all30" aria-controls="all30" role="tab" data-toggle="tab">Scrub Data</a></li>
                    <li role="presentation"><a href="#all31" aria-controls="all31" role="tab" data-toggle="tab">Landing Ad</a></li>
                </ul>
         <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="all21">
              <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadGoogleall" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
                </form>
            </div>

            <div role="tabpanel" class="tab-pane" id="all22">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFacebookall" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
          </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all23">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadWebsiteall" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

       <div role="tabpanel" class="tab-pane" id="all24">
              <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadCreatedall" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='ALL.created_date'>DATE</option>  
                            <option value='ALL.id' selected>LEAD ID</option>
                            <option value='ALL.fname'>FIRST NAME</option>
                            <option value='ALL.lname'>LAST NAME</option>
                            <option value='ALL.email'>Email</option>
                            <option value='ALL.mobile'>MOBILE</option>
                            <option value='ALL.pan'>PAN</option>
                            <option value='ALL.gender'>GENDER</option>
                            <option value='ALL.marital_status'>MARITAL STATUS</option>
                            <option value='ALL.cibil_score'>CIBIL SCORE</option>
                        </select>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all25">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadClassifiedall" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

              <div role="tabpanel" class="tab-pane" id="all26">
                    <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadEmailerall" method="post" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>Personal Details</label>
                                <select  name="personal[]" multiple class="form-control">   
                                    <option value='ALL.created_date'>DATE</option>  
                                    <option value='ALL.id' selected>LEAD ID</option>
                                    <option value='ALL.fname'>FIRST NAME</option>
                                    <option value='ALL.lname'>LAST NAME</option>
                                    <option value='ALL.email'>Email</option>
                                    <option value='ALL.mobile'>MOBILE</option>
                                    <option value='ALL.pan'>PAN</option>
                                    <option value='ALL.gender'>GENDER</option>
                                    <option value='ALL.marital_status'>MARITAL STATUS</option>
                                    <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                </select>
                            </div>
                        </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

           <div role="tabpanel" class="tab-pane" id="all27">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFinBuddyall" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                <div role="tabpanel" class="tab-pane" id="all28">
                          <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadSoftCallall" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                <div role="tabpanel" class="tab-pane" id="all29">
                          <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadTransferFall" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                 <div role="tabpanel" class="tab-pane" id="all30">
                          <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadScrubDataall" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                 <div role="tabpanel" class="tab-pane" id="all31">
                          <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadLandingAdall" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
            </form>
          </div>

        </div>

  </div>


     <div role="tabpanel" class="tab-pane" id="alllead">
                 <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#all32" aria-controls="all32" role="tab" data-toggle="tab">Google</a></li>
                    <li role="presentation"><a href="#all33" aria-controls="all33" role="tab" data-toggle="tab">Facebook</a></li>
                    <li role="presentation"><a href="#all34" aria-controls="all34" role="tab" data-toggle="tab">Website</a></li>
                    <li role="presentation"><a href="#all35" aria-controls="all35" role="tab" data-toggle="tab">Created</a></li>
                    <li role="presentation"><a href="#all36" aria-controls="all36" role="tab" data-toggle="tab">Classified</a></li>
                    <li role="presentation"><a href="#all37" aria-controls="all37" role="tab" data-toggle="tab">Emailer</a></li>
                    <li role="presentation"><a href="#all38" aria-controls="all38" role="tab" data-toggle="tab">Fin Buddy</a></li>
                    <li role="presentation"><a href="#all39" aria-controls="all39" role="tab" data-toggle="tab">Soft Call </a></li>
                    <li role="presentation"><a href="#all40" aria-controls="all40" role="tab" data-toggle="tab">Transfer F</a></li>
                    <li role="presentation"><a href="#all41" aria-controls="all41" role="tab" data-toggle="tab">Scrub Data</a></li>
                    <li role="presentation"><a href="#all42" aria-controls="all42" role="tab" data-toggle="tab">Landing Ad</a></li>
                </ul>
         <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="all32">
              <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadGooglelead" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
                </form>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="all33">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFacebooklead" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
          </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all34">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadWebsitelead" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>

                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

       <div role="tabpanel" class="tab-pane" id="all35">
              <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadCreatedlead" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                    <div class="form-group">
                      <label>Personal Details</label>
                        <select  name="personal[]" multiple class="form-control">   
                            <option value='ALL.created_date'>DATE</option>  
                            <option value='ALL.id' selected>LEAD ID</option>
                            <option value='ALL.fname'>FIRST NAME</option>
                            <option value='ALL.lname'>LAST NAME</option>
                            <option value='ALL.email'>Email</option>
                            <option value='ALL.mobile'>MOBILE</option>
                            <option value='ALL.pan'>PAN</option>
                            <option value='ALL.gender'>GENDER</option>
                            <option value='ALL.marital_status'>MARITAL STATUS</option>
                            <option value='ALL.cibil_score'>CIBIL SCORE</option>
                        </select>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>
                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

         <div role="tabpanel" class="tab-pane" id="all36">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadClassifiedlead" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address Details</label>
                          <select  name="address[]" multiple class="form-control">
                                <option value='ALL.state'>STATE</option>
                                <option value='ALL.city'>CITY</option>
                                <option value='ALL.address1'>ADDRESS</option>
                                <option value='ALL.pin'>PIN CODE</option>
                                <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                <option value='ALL.builder_name'>BUILDER NAME</option>
                                <option value='ALL.property_value'>PROPERTY VALUE</option>
                                <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                       </select>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>WORK INFO</label>
                       <select  name="workinfo[]" multiple class="form-control">
                            <option value='ALL.occupation'>OCCUPATION</option>
                            <option value='ALL.company_type'>COMPANY TYPE</option>
                            <option value='ALL.company_name'>COMPANY NAME</option>
                            <option value='ALL.profession_type'>PROFESSION TYPE</option>
                            <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                            <option value='ALL.working_since'>WORKING SINCE</option>
                            <option value='ALL.experiance'>EXPERIANCE</option>
                            <option value='ALL.turnover1'>TURNOVER</option>
                            <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                            <option value='ALL.designation'>DESIGNATION</option>
                            <option value='ALL.department'>DEPARTMENT</option>
                            <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                            <option value='ALL.income'>INCOME</option>
                            <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                            <option value='ALL.qualification'>QUALIFICATION</option>
                            <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                  
                   </select>
                </div>
            </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

              <div role="tabpanel" class="tab-pane" id="all37">
                <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadEmailerlead" method="post" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label>Personal Details</label>
                                <select  name="personal[]" multiple class="form-control">   
                                    <option value='ALL.created_date'>DATE</option>  
                                    <option value='ALL.id' selected>LEAD ID</option>
                                    <option value='ALL.fname'>FIRST NAME</option>
                                    <option value='ALL.lname'>LAST NAME</option>
                                    <option value='ALL.email'>Email</option>
                                    <option value='ALL.mobile'>MOBILE</option>
                                    <option value='ALL.pan'>PAN</option>
                                    <option value='ALL.gender'>GENDER</option>
                                    <option value='ALL.marital_status'>MARITAL STATUS</option>
                                    <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                </select>
                            </div>
                        </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Address Details</label>
                      <select  name="address[]" multiple class="form-control">
                            <option value='ALL.state'>STATE</option>
                            <option value='ALL.city'>CITY</option>
                            <option value='ALL.address1'>ADDRESS</option>
                            <option value='ALL.pin'>PIN CODE</option>
                            <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                            <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                            <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                            <option value='ALL.property_details'>PROPERTY DETAILS</option>
                            <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                            <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                            <option value='ALL.builder_name'>BUILDER NAME</option>
                            <option value='ALL.property_value'>PROPERTY VALUE</option>
                            <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                   </select>
                </div>
            </div>
                    <div class="col-md-4">
                      <div class="form-group">
                       <label>WORK INFO</label>
                           <select  name="workinfo[]" multiple class="form-control">
                                <option value='ALL.occupation'>OCCUPATION</option>
                                <option value='ALL.company_type'>COMPANY TYPE</option>
                                <option value='ALL.company_name'>COMPANY NAME</option>
                                <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                <option value='ALL.working_since'>WORKING SINCE</option>
                                <option value='ALL.experiance'>EXPERIANCE</option>
                                <option value='ALL.turnover1'>TURNOVER</option>
                                <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                <option value='ALL.designation'>DESIGNATION</option>
                                <option value='ALL.department'>DEPARTMENT</option>
                                <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                <option value='ALL.income'>INCOME</option>
                                <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                <option value='ALL.qualification'>QUALIFICATION</option>
                                <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                      
                       </select>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                      <label>OTHER</label>
                        <select  name="other[]" multiple class="form-control">
                            <option value='ALL.loan_amount'>LOAN AMONUT</option>
                            <option value='LT.loan_type'>PRODUCT TYPE</option>
                            <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                            <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                            <option value='ALL.loan_bank'>LOAN BANK</option>
                            <option value='ALL.send_to_bank'>SEND TO BANK</option>
                            <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                            <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                            <option value='ALL.payout_id'>PAYOUT ID</option>
                            <option value='USR.username'>CALLER NAME</option>
                            <option value='ALL.status'>STATUS</option>
                        </select>
                      </div>
                    </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
            </div>
        </form>
         </div>

           <div role="tabpanel" class="tab-pane" id="all38">
                  <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadFinBuddylead" method="post" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Personal Details</label>
                            <select  name="personal[]" multiple class="form-control">   
                                <option value='ALL.created_date'>DATE</option>  
                                <option value='ALL.id' selected>LEAD ID</option>
                                <option value='ALL.fname'>FIRST NAME</option>
                                <option value='ALL.lname'>LAST NAME</option>
                                <option value='ALL.email'>Email</option>
                                <option value='ALL.mobile'>MOBILE</option>
                                <option value='ALL.pan'>PAN</option>
                                <option value='ALL.gender'>GENDER</option>
                                <option value='ALL.marital_status'>MARITAL STATUS</option>
                                <option value='ALL.cibil_score'>CIBIL SCORE</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                <div role="tabpanel" class="tab-pane" id="all39">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadSoftCalllead" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                <div role="tabpanel" class="tab-pane" id="all40">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadTransferFlead" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>
                 <div role="tabpanel" class="tab-pane" id="all41">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadScrubDatalead" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                    </div>
                </form>
                 </div>

              <div role="tabpanel" class="tab-pane" id="all42">
                 <form action="<?php echo base_url(); ?>p2padmin/mis/doenloadLandingAdlead" method="post" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>Personal Details</label>
                                    <select  name="personal[]" multiple class="form-control">   
                                        <option value='ALL.created_date'>DATE</option>  
                                        <option value='ALL.id' selected>LEAD ID</option>
                                        <option value='ALL.fname'>FIRST NAME</option>
                                        <option value='ALL.lname'>LAST NAME</option>
                                        <option value='ALL.email'>Email</option>
                                        <option value='ALL.mobile'>MOBILE</option>
                                        <option value='ALL.pan'>PAN</option>
                                        <option value='ALL.gender'>GENDER</option>
                                        <option value='ALL.marital_status'>MARITAL STATUS</option>
                                        <option value='ALL.cibil_score'>CIBIL SCORE</option>
                                    </select>
                                </div>
                            </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address Details</label>
                              <select  name="address[]" multiple class="form-control">
                                    <option value='ALL.state'>STATE</option>
                                    <option value='ALL.city'>CITY</option>
                                    <option value='ALL.address1'>ADDRESS</option>
                                    <option value='ALL.pin'>PIN CODE</option>
                                    <option value='RES.name AS residence_type'>RESIDENCE TYPE</option>
                                    <option value='ALL.year_in_curr_residence'>YEAR IN CURR RESIDENCE</option>
                                    <option value='ALL.is_parmanent_address'>IS PARMANENT ADDRESS</option>
                                    <option value='ALL.property_details'>PROPERTY DETAILS</option>
                                    <option value='ALL.property_details_second'>PROPERTY DETAILS SECOND</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.location_of_property'>LOCTION OF PROPERTY</option>
                                    <option value='ALL.location_of_property_pincode'>LOCTION OF PROPERTY PINCODE</option>
                                    <option value='ALL.builder_name'>BUILDER NAME</option>
                                    <option value='ALL.property_value'>PROPERTY VALUE</option>
                                    <option value='ALL.industry_type'>INDUSTRY TYPE</option>
                           </select>
                        </div>
                    </div>
                            <div class="col-md-4">
                              <div class="form-group">
                               <label>WORK INFO</label>
                                   <select  name="workinfo[]" multiple class="form-control">
                                        <option value='ALL.occupation'>OCCUPATION</option>
                                        <option value='ALL.company_type'>COMPANY TYPE</option>
                                        <option value='ALL.company_name'>COMPANY NAME</option>
                                        <option value='ALL.profession_type'>PROFESSION TYPE</option>
                                        <option value='ALL.officeaddress'>OFFICE ADDRESS</option>
                                        <option value='ALL.working_since'>WORKING SINCE</option>
                                        <option value='ALL.experiance'>EXPERIANCE</option>
                                        <option value='ALL.turnover1'>TURNOVER</option>
                                        <option value='ALL.office_ownership'>OFFICE OWNERSHIP</option>
                                        <option value='ALL.designation'>DESIGNATION</option>
                                        <option value='ALL.department'>DEPARTMENT</option>
                                        <option value='ALL.salary_account'>SALARY ACCOUNT</option>
                                        <option value='ALL.income'>INCOME</option>
                                        <option value='ALL.mode_of_salary'>MODE OF SALARY</option>
                                        <option value='ALL.qualification'>QUALIFICATION</option>
                                        <option value='ALL.educational_institute_name'>EDUCATIONAL INSTITUTW NAME</option>
                              
                               </select>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label>OTHER</label>
                                <select  name="other[]" multiple class="form-control">
                                    <option value='ALL.loan_amount'>LOAN AMONUT</option>
                                    <option value='LT.loan_type'>PRODUCT TYPE</option>
                                    <option value='ALL.outstanding_loan_details'>OUTSTANDING LOAN DETAILS</option> 
                                    <option value='ALL.brief_outstanding_loan_details'>BRIEF OUTSTANDING LOAN DETAILS</option>
                                    <option value='ALL.loan_bank'>LOAN BANK</option>
                                    <option value='ALL.send_to_bank'>SEND TO BANK</option>
                                    <option value='SOU.name AS source_of_lead'>SOURCE OF LEAD</option>
                                    <option value='CAMP.campaign_name'>CAMPAIGN ID</option>
                                    <option value='ALL.payout_id'>PAYOUT ID</option>
                                    <option value='USR.username'>CALLER NAME</option>
                                    <option value='ALL.status'>STATUS</option>
                                </select>
                              </div>
                            </div>

                    <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-info" name="submit">Export Excel</button>
                </div>
            </form>
          </div>

        </div>

  </div>
  </div>

</div>
   </div>
</section>

</div>


