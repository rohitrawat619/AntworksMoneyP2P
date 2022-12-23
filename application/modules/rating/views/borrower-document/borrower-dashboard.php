<?php $borrower_id =  $_SESSION['borrower_id'];  ?>
<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>

<!-- for Edge/FF/Chrome/Opera/etc. getUserMedia support -->
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdn.webrtc-experiment.com/DetectRTC.js"> </script>

<!-- video element -->
<link href="https://cdn.webrtc-experiment.com/getHTMLMediaElement.css" rel="stylesheet">
<script src="https://cdn.webrtc-experiment.com/getHTMLMediaElement.js"></script>
<style>
  .recordrtc li {
    border-bottom: 1px solid rgb(189, 189, 189);
    border-left: 1px solid rgb(189, 189, 189);
    padding: .5em;
  }
 .recordrtc label {
    display: inline-block;
    width: 8em;
  }

  .recordrtc h1 span {
    background: yellow;
    border: 2px solid #8e1515;
    padding: 2px 8px;
    margin: 2px 5px;
    border-radius: 7px;
    color: #8e1515;
    display: inline-block;
  }

  .recordrtc button {
    font-size: inherit;
  }

  .recordrtc button, .recordrtc select {
    vertical-align: middle;
    line-height: 1;
    padding: 2px 5px;
    height: auto;
    font-size: inherit;
    margin: 0;
  }

  .recordrtc, .recordrtc .header {
    display: block;
    text-align: center;
    padding-top: 0;
  }

  .recordrtc video, .recordrtc img {
    max-width: 100%!important;
    vertical-align: top;
  }

  .recordrtc audio {
    vertical-align: bottom;
  }

  .recordrtc option[disabled] {
    display: none;
  }

  .recordrtc select {
    font-size: 17px;
  }
  .media-box h2{
    display: none;
  }
</style>
<?php
$track_info = $this->session->userdata('track_info');
$this->session->unset_userdata('track_info');
?>
<style>
.affix {
	top: 192px;
	width: 100%;
	margin-top:0px !important;
}
.sec-navbar {
	background: #01518c;
	z-index: 1;
	margin-top:22px;
}
.header .header-navigation.navbar {
	margin-bottom: -22px !important;
}

@media (max-width: 1024px){
.affix {top:126px;}
}
</style>
<div class="sec-navbar" data-spy="affix" data-offset-top="100">
  <div class="container">
    <div class="col-md-8">
      <button class="btn toggle-tab" data-toggle="collapse" data-target="#nav-tabs-menu"><span class="fa fa-bars"><span/></button>
      <ul class="sec-nav-side nav nav-tabs collapse navbar-collapse" id="nav-tabs-menu">
        <li class="active"><a data-toggle="tab" href="#profiletab1">My Profile</a></li>
        <li><a data-toggle="tab" href="#profiletab2">Proposal Status</a></li>
        <li><a data-toggle="tab" href="#profiletab3">Bidding Status</a></li>
        <li id="track-class"><a data-toggle="tab" href="#profiletab4">Track Application Status</a></li>
        <li id="track-class"><a data-toggle="tab" href="#profiletab6">Record Your Video</a></li>
      </ul>
    </div>
    <div class="col-md-4 text-right" style="padding-right:0px;">
      <? 	if($userdetails['profilepic'])
				{
					$user_image = "uploads/users/".$userdetails['profilepic'];
				}
				else
				{
					$user_image = "assets/img/team/team-8.png";
				}
			?>
      <div class="btn-group bnotification"> <a data-toggle="tab" href="#profiletab5"><i class="fa fa-bell"></i><? if($latest_count>0){?><span class="count"><?=$latest_count?></span><? }?></a> </div>
      <div class="btn-group user-account"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="<?=base_url().$user_image;?>">
        <p><? if($this->session->userdata('login_type')==1){ echo $userdetails['first_name']; }if($this->session->userdata('login_type')==2){ echo $userdetails['company_name'];}?></p>
        </a>
        <ul class="dropdown-menu dropdown-menu-right user-drop-box">
          <!--
				<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>-->
          <li><a href="<?=base_url();?>Home/Logout/"><i class="fa fa-power-off"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="sec-pad-30 shadow-top" style="background: #f0f0f0;">
  <div class="container">
    <?=getNotificationHtml();?>
    <!--
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      Your Profile is 55% completed. Click on Edit Profile to complete your profile. </div>
  </div>
  -->
  <div class="container panel-white">
    <div class="tab-content">
      <div id="profiletab1" class="tab-pane fade in active">
        <div class="page-aside">
          <div class="left-aside">
            <ul class="left-nav">
              <li class="active"><a data-toggle="tab" href="#proedittab1">My Profile</a></li>
              <li><a data-toggle="tab" href="#proedittab2">Edit Profile</a></li>
              <? 	$b_status = 0;
						foreach($borrower_info as $row){
							if($row['bidding_status']==0 || $row['bidding_status']==1){
								$b_status = 1;
							}
						}
						if($b_status==0){
					?>
              <li><a data-toggle="tab" href="#proedittab6">Add Proposal</a></li>
              <? }?>
              <li><a data-toggle="tab" href="#proedittab3">Verify and Rate My Profile</a></li>
              <li><a data-toggle="tab" href="#proedittab4">Upload Documents</a></li>
              <? 	$b1_status = 0;
					foreach($borrower_info as $row){
						if($row['bidding_status']==2){
							$b1_status = 1;
						}
					}
					if($b1_status==1){
				?>
              <li><a data-toggle="tab" href="#proedittab5">Loan Documents</a></li>
              <? }?>
            </ul>
          </div>
          <div class="right-aside form-horizontal">
            <div class="tab-content">

              <!-- Subtab-1 -->
              <? if($this->session->userdata('login_type')==1){?>
              <div id="proedittab1" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Full Name</p>
                      <h4>&nbsp;
                        <? 	$fullname = $userdetails['first_name'];
							if($userdetails['middle_name']){
								$fullname .= " ".$userdetails['middle_name'];
							}if($userdetails['last_name']){
								$fullname .= " ".$userdetails['last_name'];
							}
							echo $fullname;?>
                      </h4>
                      <hr>
                      <p>Email ID</p>
                      <h4>&nbsp;
                        <?=$userdetails['email'];?>
                      </h4>
                      <hr>
                      <p>Mobile</p>
                      <h4>&nbsp;
                        <?=$userdetails['mobile'];?>
                      </h4>
                      <hr>
                      <p>Gender</p>
                      <h4>&nbsp;
                        <?=$userdetails['gender'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">

                      <p>Father Name</p>
                      <h4>&nbsp;
                        <?=$userdetails['father_name'];?>
                      </h4>
                      <hr>
                      <p>DOB</p>
                      <h4>&nbsp;
                        <?=$userdetails['dob'];?>
                      </h4>
                      <hr>
                      <p>Highest Qualification</p>
                      <h4>&nbsp;
                        <?=$userdetails['highest_qualification'];?>
                      </h4>
                      <hr>
                      <p>Marital Status</p>
                      <h4>&nbsp;
                        <?=$userdetails['marital_status'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Religion</p>
                      <h4>&nbsp;
                        <?=$userdetails['religion'];?>
                      </h4>
                      <hr>
                      <p>Residential Address</p>
                      <h4>&nbsp;
                        <?=$userdetails['r_address'];?>
                      </h4>
                      <hr>
                      <p>City</p>
                      <h4>&nbsp;
                        <?=$userdetails['r_city'];?>
                      </h4>
                      <hr>
                      <p>State</p>
                      <h4>&nbsp;
                        <?=$userdetails['r_state'];?>
                      </h4>
                      <hr>
                      <p>Pin Code</p>
                      <h4>&nbsp;
                        <?=$userdetails['r_pincode'];?>
                      </h4>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">

                      <p>Nationality</p>
                      <h4>&nbsp;
                        <?=$userdetails['nationality'];?>
                      </h4>
                      <hr>
                      <p>Residence Type</p>
                      <h4>&nbsp;
                        <?=$userdetails['residence_type'];?>
                      </h4>
                      <hr>
                      <p>Years in current residence</p>
                      <h4>&nbsp;
                        <?=$userdetails['living_yrs_current_residence'];?>
                      </h4>
                      <hr>
                      <p>Is it your  permanent Residence</p>
                      <h4>&nbsp;
                        <?=$userdetails['permanent_residence_flag'];?>
                      </h4>
                      <hr>
                      <p>Residential Tel No.</p>
                      <h4>&nbsp;
                        <?=$userdetails['r_tel_no'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <br>
                <br>
                <div class="row" style="background-color:#f7fafc; padding:30px 15px;">
                  <h3>Office Details</h3>&nbsp;
                  <?=$userdetails['o_address'];?>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-6 col-sm-4">
                      <div class="prodetils-box">
                        <p>City</p>
                        <h4>&nbsp;
                          <?=$userdetails['o_city'];?>
                        </h4>
                        <hr>
                        <p>State</p>
                        <h4>&nbsp;
                          <?=$userdetails['o_state'];?>
                        </h4>
                        <hr>
                        <p>Pin Code</p>
                        <h4>&nbsp;
                          <?=$userdetails['o_pincode'];?>
                        </h4>
                        <hr>
                        <p>Office Tel No.</p>
                        <h4>&nbsp;
                          <?=$userdetails['o_tel_no'];?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4">
                      <div class="prodetils-box">
                        <p>Whether Applying with a  Co Applicant</p>
                        <h4>&nbsp;
                          <?=$userdetails['co_applicant_flag'];?>
                        </h4>
                        <hr>
                        <p>Aadhhar card</p>
                        <h4>&nbsp;
                          <?=$userdetails['aadhaar'];?>
                        </h4>
                        <hr>
                        <p>Passport No</p>
                        <h4>&nbsp;
                          <?=$userdetails['passport'];?>
                        </h4>
                        <hr>
                        <p>Pan Card No</p>
                        <h4>&nbsp;
                          <?=$userdetails['pan'];?>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>

                <? if($userdetails['occupation']!=0)
				{?>
                <br>
                <br>
                <h3>Occupation and Financial Information</h3>
                <br>
                <br>
                <div class="row">
                  <div class="col-md-12 mb32">
                    <div class="prodetils-box">
                      <p style="float:left;">Occupation: &nbsp;&nbsp;&nbsp;</p>
                      <h4>&nbsp;
                        <?=$this->Requestmodel->get_occupation_name($userdetails['occupation']);?>
                      </h4>
                    </div>
                  </div>
                </div>
                <?=$occup_details = $this->Requestmodel->get_occupational_details($userdetails['occupation'],$userdetails['borrower_id']);
							if($userdetails['occupation']==1){?>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Type of company employed with</p>
                      <h4>&nbsp;
                        <?=$occup_details['employed_company'];?>
                      </h4>
                      <hr>
                      <p>Name of company</p>
                      <h4>&nbsp;
                        <?=$occup_details['company_name'];?>
                      </h4>
                      <hr>
                      <p>No of years at current employment</p>
                      <h4>&nbsp;
                        <?=$occup_details['years_count'];?>
                      </h4>
                      <hr>
                      <p>Designation</p>
                      <h4>&nbsp;
                        <?=$occup_details['designation'];?>
                      </h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Department</p>
                      <h4>&nbsp;
                        <?=$occup_details['department'];?>
                      </h4>
                      <hr>
                      <p>Total years in employment</p>
                      <h4>&nbsp;
                        <?=$occup_details['total_yrs_emp'];?>
                      </h4>
                      <hr>
                      <p>Net Monthly Income in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['net_monthly_income'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan or credit card</p>
                      <h4>&nbsp;
                        <?=$occup_details['defaulted'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <? }?>
                <? if($userdetails['occupation']==2){?>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Industry Type</p>
                      <h4>&nbsp;
                        <?=$occup_details['industry_type'];?>
                      </h4>
                      <hr>
                      <p>Total Experience</p>
                      <h4>&nbsp;
                        <?=$occup_details['total_experience'];?>
                      </h4>
                      <hr>
                      <p>Net Worth</p>
                      <h4>&nbsp;
                        <?=$occup_details['net_worth'];?>
                      </h4>
                      <hr>
                      <p>Gross Turnover Last Year</p>
                      <h4>&nbsp;
                        <?=$occup_details['turnover_last_year'];?>
                      </h4>
                      <hr>
                      <p>Gross Turnver Year 2</p>
                      <h4>&nbsp;
                        <?=$occup_details['turnover_last2_year'];?>
                      </h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Audit done for financials?</p>
                      <h4>&nbsp;
                        <?=$occup_details['audit_status'];?>
                      </h4>
                      <hr>
                      <p>Office phone no.</p>
                      <h4>&nbsp;
                        <?=$occup_details['office_phone_no'];?>
                      </h4>
                      <hr>
                      <p>Office ownership</p>
                      <h4>&nbsp;
                        <?=$occup_details['office_ownership'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan or credit card</p>
                      <h4>&nbsp;
                        <?=$occup_details['defaulted'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <? }?>
                <? if($userdetails['occupation']==3){?>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Profession type</p>
                      <h4>&nbsp;
                        <?=$occup_details['professional_type'];?>
                      </h4>
                      <hr>
                      <p>Total experience</p>
                      <h4>&nbsp;
                        <?=$occup_details['total_experience'];?>
                      </h4>
                      <hr>
                      <p>Net worth</p>
                      <h4>&nbsp;
                        <?=$occup_details['net_worth'];?>
                      </h4>
                      <hr>
                      <p>Gross turnover last year</p>
                      <h4>&nbsp;
                        <?=$occup_details['turnover_last_year'];?>
                      </h4>
                      <hr>
                      <p>Gross turnver year 2</p>
                      <h4>&nbsp;
                        <?=$occup_details['turnover_last2_year'];?>
                      </h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>audit done for financials?</p>
                      <h4>&nbsp;
                        <?=$occup_details['audit_status'];?>
                      </h4>
                      <hr>
                      <p>office phone no.</p>
                      <h4>&nbsp;
                        <?=$occup_details['office_phone_no'];?>
                      </h4>
                      <hr>
                      <p>Office ownership</p>
                      <h4>&nbsp;
                        <?=$occup_details['office_ownership'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan or credit card</p>
                      <h4>&nbsp;
                        <?=$occup_details['defaulted'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <? }?>
                <? if($userdetails['occupation']==4){?>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Type of company employed with</p>
                      <h4>&nbsp;
                        <?=$occup_details['company_type'];?>
                      </h4>
                      <hr>
                      <p>Name of company</p>
                      <h4>&nbsp;
                        <?=$occup_details['company_name'];?>
                      </h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Net Monthly Income in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['net_monthly_income'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan or credit card</p>
                      <h4>&nbsp;
                        <?=$occup_details['defaulted'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <? }?>
                <? if($userdetails['occupation']==5){?>
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>I am pursuing</p>
                      <h4>&nbsp;
                        <?=$occup_details['pursuing'];?>
                      </h4>
                      <hr>
                      <p>Name of Educational Institution</p>
                      <h4>&nbsp;
                        <?=$occup_details['institute_name'];?>
                      </h4>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Net Monthly Income in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['net_monthly_income'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$occup_details['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan or credit card</p>
                      <h4>&nbsp;
                        <?=$occup_details['defaulted'];?>
                      </h4>
                    </div>
                  </div>
                </div>
                <? }}?>
                <div class="row" style="background-color:#f7fafc; padding:30px 15px;">
                  <h3>Bank Details</h3>&nbsp;
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-6 col-sm-4">
                      <div class="prodetils-box">
                        <p>Bank Name</p>
                        <h4>&nbsp;
                          <?=$userdetails['bank_name'];?>
                        </h4>
                        <hr>
                        <p>Branch Name</p>
                        <h4>&nbsp;
                          <?=$userdetails['branch_name'];?>
                        </h4>
                        <hr>
                        <p>Account Number</p>
                        <h4>&nbsp;
                          <?=$userdetails['account_number'];?>
                        </h4>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-4">
                      <div class="prodetils-box">
                        <p>IFSC Code</p>
                        <h4>&nbsp;
                          <?=$userdetails['ifsc_code'];?>
                        </h4>
                        <hr>
                        <p>Account Type</p>
                        <h4>&nbsp;
                          <?=$userdetails['account_type'];?>
                        </h4>

                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <? }if($this->session->userdata('login_type')==2){?>
              <div id="proedittab1" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Company Name</p>
                      <h4>&nbsp;
                        <?=$userdetails['company_name'];?>
                      </h4>
                      <hr>
                      <p>Email ID</p>
                      <h4>&nbsp;
                        <?=$userdetails['email'];?>
                      </h4>
                      <hr>
                      <p>Mobile</p>
                      <h4>&nbsp;
                        <?=$userdetails['mobile'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">

                      <p>Person Name</p>
                      <h4>&nbsp;
                        <?=$userdetails['person_name'];?>
                      </h4>
                      <hr>
                      <p>Username</p>
                      <h4>&nbsp;
                        <?=$userdetails['username'];?>
                      </h4>
                      <hr>
                      <p>Year of Incorporation</p>
                      <h4>&nbsp;
                        <?=$userdetails['yr_incorp'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>CIN</p>
                      <h4>&nbsp;
                        <?=$userdetails['cin'];?>
                      </h4>
                      <hr>
                      <p>Net worth</p>
                      <h4>&nbsp;
                        <?=$userdetails['net_worth'];?>
                      </h4>
                      <hr>
                      <p>Gross turnover year 2</p>
                      <h4>&nbsp;
                        <?=$userdetails['turnover_year2'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">

                      <p>Company Industry</p>
                      <h4>&nbsp;
                        <?=$userdetails['company_industry'];?>
                      </h4>
                      <hr>
                      <p>Gross turnover last year</p>
                      <h4>&nbsp;
                        <?=$userdetails['turnover_last_year'];?>
                      </h4>
                      <hr>
                      <p>Gross turnover year 3</p>
                      <h4>&nbsp;
                        <?=$userdetails['turnover_year3'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">
                      <p>Net Profit last year</p>
                      <h4>&nbsp;
                        <?=$userdetails['profit_last_year'];?>
                      </h4>
                      <hr>
                      <p>Net profit year 3</p>
                      <h4>&nbsp;
                        <?=$userdetails['profit_year3'];?>
                      </h4>
                      <hr>
                      <p>Current EMIs in INR</p>
                      <h4>&nbsp;
                        <?=$userdetails['current_emis'];?>
                      </h4>
                      <hr>
                      <p>Any cheque bounce case in last 6 months</p>
                      <h4>&nbsp;
                        <?=$userdetails['cheque_bounce_flag'];?>
                      </h4>
                      <hr>
                      <p>Antworks Rating</p>
                      <h4>&nbsp;
                        <?=$userdetails['antworks_rating'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-4">
                    <div class="prodetils-box">

                      <p>Net profit year 2</p>
                      <h4>&nbsp;
                        <?=$userdetails['profit_year2'];?>
                      </h4>
                      <hr>
                      <p>Total loans on book</p>
                      <h4>&nbsp;
                        <?=$userdetails['total_loans_on_book'];?>
                      </h4>
                      <hr>
                      <p>Ever defaulted on any loan</p>
                      <h4>&nbsp;
                        <?=$userdetails['defaulted'];?>
                      </h4>
                      <hr>
                      <p>Whether company is rated by Rating Agency</p>
                      <h4>&nbsp;
                        <?=$userdetails['latest_rating'];?>
                      </h4>
                      <hr>
                    </div>
                  </div>

                </div>

              </div>
              <? }?>

              <!-- Subtab-2 -->
              <? if($this->session->userdata('login_type')==1){?>
              <div id="proedittab2" class="tab-pane fade in">
                <div class="edit-profile-tabs">
                  <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=base_url();?>home/edit_borrower_details/<?=$userdetails['id'];?>/" onsubmit="return edit_borrower_details()">
                    <div class="section row" style="padding-top: 0px;">
                      <div class="panel-group accordion" id="accordion-one" role="tablist">
                        <div class="panel panel-default"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-one" href="#accordion-one-collapse-one">Personal Details</a>
                          <div id="accordion-one-collapse-one" class="panel-collapse collapse" role="tabpanel">
                            <div class="inner-box">
                              <div class="card" id="form1">
                                <div class="card-content">
                                  <div class="section edit-profile row">
                                    <div class="">
                                      <div class="">
                                        <input type="hidden" name="borrower_id" value="<?=$userdetails['borrower_id'];?>" readonly >
                                        <div class="row">
                                          <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                              <label for="id_partner_name">First Name* </label>
                                              <input type="text" class="form-control" name="" value="<?=$userdetails['first_name'];?>" readonly >
                                            </div>
                                          </div>
                                          <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                              <label for="id_partner_name">Middle Name </label>
                                              <input type="text" class="form-control" name="" value="<?=$userdetails['middle_name'];?>" >
                                            </div>
                                          </div>
                                          <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                              <label for="id_partner_name">Last Name* </label>
                                              <input type="text" class="form-control" name="" value="<?=$userdetails['last_name'];?>" readonly >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_email">Father's Name</label>
                                              <input type="text" class="form-control" name="father_name" value="<?=$userdetails['father_name'];?>" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_email">Email*</label>
                                              <input type="text" class="form-control" name="" value="<?=$userdetails['email'];?>" readonly>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_partner_name">Username* </label>
                                              <input type="text" class="form-control" name="" value="<?=$userdetails['username'];?>" readonly>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_email">Mobile*</label>
                                              <input type="text" class="form-control" name="mobile" id="mobile" value="<?=$userdetails['mobile'];?>" maxlength="10" onkeypress="return isNumberKey(event)" readonly >
                                              <input type="text" class="form-control" name="newmobile" id="newmobile" value="" maxlength="10" onkeypress="return isNumberKey(event)" style="display:none" >
                                              <input type="text" class="form-control" name="otpnewmobile" id="otpnewmobile" value="" placeholder="Enter OTP Sent to your Number" maxlength="10" style="display:none" >
                                              <span id="mobileotpverifybutton" style="display:none" ><button>Verify OTP</button></span>
                                              <span id="mobileotpsendbutton" style="display:none" ><button>Send OTP</button></span>
                                            <span id="mobilechange" >Change Number</span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_date_of_birth">Date of birth*</label>
                                              <input type="text" class="form-control" value="<?=$userdetails['dob'];?>" id="datepicker1" name="dob">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="">Gender* </label>
                                              <select class="form-control" name="gender" id="gender" >
                                                <? 	$m=$f=$o="";
														if($userdetails['gender']=="Male"){
												  			$m = " selected";
														}
														else if($userdetails['gender']=="Female"){
															$f = " selected";
														}else if($userdetails['gender']=="Other"){
															$o = " selected";
														}

													?>
                                                <option value="Male" <?=$m;?>>Male</option>
                                                <option value="Female" <?=$f;?>>Female</option>
                                                <option value="Other" <?=$o;?>>Other</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_nationality">Highest Qualification* </label>
                                              <select class="form-control" name="highest_qualification" id="highest_qualification" >
                                                <? 	$u=$p=$pg=$o=$g="";
														if($userdetails['highest_qualification']=="Undergraduate"){
												  			$u = " selected";
														}
														else if($userdetails['highest_qualification']=="Graduate"){
															$g = " selected";
														}else if($userdetails['highest_qualification']=="Post Graduate"){
															$pg = " selected";
														}
														else if($userdetails['highest_qualification']=="Professional"){
															$p = " selected";
														}else if($userdetails['highest_qualification']=="Other"){
															$o = " selected";
														}

													?>
                                                <option value="Undergraduate" <?=$u;?>>Undergraduate</option>
                                                <option value="Graduate" <?=$g;?>>Graduate</option>
                                                <option value="Post Graduate" <?=$pg;?>>Post Graduate </option>
                                                <option value="Professional" <?=$p;?>>Professional</option>
                                                <option value="Other" <?=$o;?>>Other</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="Marital Status">Marital Status</label>
                                              <select class="form-control" id="" name="marital_status">
                                                <? 	$s=$m=$d=$w="";
													if($userdetails['marital_status']=="Single"){
														$s = " selected";
													}
													else if($userdetails['marital_status']=="Married"){
														$m = " selected";
													}else if($userdetails['marital_status']=="Divorced"){
														$d = " selected";
													}
													else if($userdetails['marital_status']=="Separated"){
														$w = " selected";
													}

												?>
                                                <option value="Single" <?=$s;?>>Single</option>
                                                <option value="Married" <?=$m;?>>Married</option>
                                                <option value="Divorced" <?=$d;?>>Divorced</option>
                                                <option value="Separated" <?=$w;?>>Separated</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_nationality">Nationality</label>
                                              <select class="form-control" id="" name="nationality">
                                                <? 	$i=$n=$o="";
													if($userdetails['nationality']=="Indian"){
														$i = " selected";
													}
													else if($userdetails['nationality']=="NRI"){
														$n = " selected";
													}else if($userdetails['nationality']=="Other"){
														$o = " selected";
													}

												?>
                                                <option value="Indian" <?=$i;?>>Indian</option>
                                                <option value="NRI" <?=$n;?>>NRI</option>
                                                <option value="Other" <?=$o;?>>Other</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4 col-sm-6">
                                            <div class="form-group">
                                              <label for="Religion">Religion</label>
                                              <select class="form-control" id="" name="religion">
                                                <? 	$h=$m=$s=$c=$j=$o="";
													if($userdetails['religion']=="Hindu"){
														$h = " selected";
													}
													else if($userdetails['religion']=="Muslim"){
														$m = " selected";
													}else if($userdetails['religion']=="Sikh"){
														$s = " selected";
													}
													else if($userdetails['religion']=="Christian"){
														$c = " selected";
													}
													else if($userdetails['religion']=="Jain"){
														$j = " selected";
													}
													else if($userdetails['religion']=="Other"){
														$o = " selected";
													}

												?>
                                                <option value="Hindu" <?=$h;?>>Hindu</option>
                                                <option value="Muslim" <?=$m;?>>Muslim</option>
                                                <option value="Sikh" <?=$s;?>>Sikh</option>
                                                <option value="Christian" <?=$c;?>>Christian</option>
                                                <option value="Jain" <?=$j;?>>Jain</option>
                                                <option value="Other" <?=$o;?>>Other</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="section"> <br>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <h5 class="mb16">Residential address</h5>
                                            <hr class="sm">
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-6 col-sm-4">
                                                <div class="form-group" id="id_office_container">
                                                  <label for="">Address Line1*</label>
                                                  <input class="form-control" type="text" name="r_address" id="r_address" rows="2" value="<?=$userdetails['r_address'];?>" >
                                                </div>
                                              </div>

                                              <div class="col-md-6 col-sm-4">
                                                <div class="form-group" id="id_office_container">
                                                  <label for="">Address Line2</label>
                                                  <input class="form-control" type="text" name="r_address1" id="r_address1" rows="2" value="<?=$userdetails['r_address1'];?>" >
                                                </div>
                                              </div>

                                            </div>
                                            <div class="row">
                                              <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                  <label for="">State*</label>
                                                  <select class="form-control" name="r_state" id="r_state" onchange="get_city()" />

                                                  <option value="">Select State</option>
                                                  <? $statelist = $this->Requestmodel->state_list();
                                                        foreach($statelist as $row)
                                                        {
															$s="";
															if($row['state_code']==$userdetails['r_state']){$s = " selected";}
                                                            echo '<option value="'.$row['state_code'].'" '.$s.'>'.$row['state_name'].'</option>';
                                                        }
                                                        ?>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                  <label for="">City*</label>
                                                  <select class="form-control" name="r_city" id="r_city" />

                                                  <option value="<?=$userdetails['r_city'];?>">
                                                  <?=$userdetails['r_city'];?>
                                                  </option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                  <label for="id_pin_code">Pin code*</label>
                                                  <input class="form-control" type="text" name="r_pincode" id="r_pincode" value="<?=$userdetails['r_pincode'];?>" maxlength="6" onkeypress="return isNumberKey(event)" >
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="section row">
                                        <div class="col-md-6 col-sm-4 col-sm-6">
                                          <div class="form-group">
                                            <label for="" >Residence type</label>
                                            <select class="form-control" id="" name="residence_type">
                                              <? 	$s=$r=$c=$os=$op="";
													if($userdetails['residence_type']=="Self Owned"){
														$s = " selected";
													}
													else if($userdetails['residence_type']=="Rented"){
														$r = " selected";
													}else if($userdetails['residence_type']=="Company provided"){
														$c = " selected";
													}
													else if($userdetails['residence_type']=="Owned by Spouse"){
														$os = " selected";
													}
													else if($userdetails['residence_type']=="Owned by Parents"){
														$op = " selected";
													}

												?>
                                              <option value="Self Owned" <?=$s;?>>Self Owned</option>
                                              <option value="Rented" <?=$r;?>>Rented</option>
                                              <option value="Company provided" <?=$c;?>>Company provided</option>
                                              <option value="Owned by Spouse" <?=$os;?>>Owned by Spouse</option>
                                              <option value="Owned by Parents" <?=$op;?>>Owned by Parents</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Years in current Residence</label>
                                            <input class="form-control" id="" name="living_yrs_current_residence" type="text" value="<?=$userdetails['living_yrs_current_residence'];?>" maxlength="2" onkeypress="return isNumberKey(event)">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="layout-row row">
                                        <div class="col-md-6 col-sm-4 col-sm-6">
                                          <div class="form-group">
                                            <label for="" >Is it your  permanent Residence</label>
                                            <select class="form-control" id="" name="permanent_residence_flag">
                                              <? 	$y=$n="";
													if($userdetails['permanent_residence_flag']=="Yes"){
														$y = " selected";
													}
													else if($userdetails['permanent_residence_flag']=="No"){
														$n = " selected";
													}
												?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Residential Tel No</label>
                                            <input class="form-control" id="" name="r_tel_no" type="text" value="<?=$userdetails['r_tel_no'];?>" maxlength="10" onkeypress="return isNumberKey(event)">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="section"> <br>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <h5 class="mb16">Office Address</h5>
                                            <hr class="sm">
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Office Address</label>
                                              <input class="form-control" id="" name="o_address" type="text" value="<?=$userdetails['o_address'];?>">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4">
                                            <div class="row">
                                              <div class="col-md-6 col-sm-4">
                                                <div class="form-group">
                                                  <label for="">State</label>
                                                  <select class="form-control" name="o_state" id="o_state" onChange="get_office_city()" />

                                                  <option value="">Select State</option>
                                                  <? $statelist = $this->Requestmodel->state_list();
																	foreach($statelist as $row)
																	{
																		$s="";
																		if($row['state_code']==$userdetails['o_state']){$s = " selected";}
																		echo '<option value="'.$row['state_code'].'" '.$s.'>'.$row['state_name'].'</option>';
																	}
																	?>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-6 col-sm-4">
                                                <div class="form-group">
                                                  <label for="">City</label>
                                                  <select class="form-control" name="o_city" id="o_city" />

                                                  <option value="<?=$userdetails['o_city'];?>">
                                                  <?=$userdetails['o_city'];?>
                                                  </option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="id_pin_code">Pin code</label>
                                              <input class="form-control" type="text" name="o_pincode" id="o_pincode" value="<?=$userdetails['o_pincode'];?>" maxlength="6" onkeypress="return isNumberKey(event)" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Office Tel No</label>
                                              <input class="form-control" id="o_tel_no" name="o_tel_no" type="text" value="<?=$userdetails['o_tel_no'];?>" maxlength="10" onkeypress="return isNumberKey(event)">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="" >Whether Applying with a  Co Applicant </label>
                                              <select class="form-control" id="" name="co_applicant_flag">
                                                <? 	$y=$n="";
														if($userdetails['co_applicant_flag']=="Yes"){
															$y = " selected";
														}
														else if($userdetails['co_applicant_flag']=="No"){
															$n = " selected";
														}
													?>
                                                <option value="Yes" <?=$y;?>>Yes</option>
                                                <option value="No" <?=$n;?>>No</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Aadhhar card</label>
                                              <input class="form-control" id="aadhaar" name="aadhaar" type="text" value="<?=$userdetails['aadhaar'];?>" maxlength="12" maxlength="12" onkeypress="return isNumberKey(event)">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Passport No.</label>
                                              <input class="form-control" id="passport" name="passport" type="text" value="<?=$userdetails['passport'];?>" maxlength="10" style="text-transform:uppercase">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Pan Card No.</label>
                                              <input class="form-control" id="pan" name="pan" type="text" value="<?=$userdetails['pan'];?>" maxlength="10" style="text-transform:uppercase">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group">
                                              <label for="">Personal Description</label>
                                              <textarea  class="form-control" id="description" name="description" rows="4"><?=$userdetails['description'];?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default"><a role="button" data-toggle="collapse" data-parent="#accordion-one" href="#accordion-one-collapse-two" class="collapsed">Occupation and Financial Information</a>
                          <div id="accordion-one-collapse-two" class="panel-collapse collapse" role="tabpanel">
                            <div class="inner-box">
                              <div class="card-content">
                                <div class="section edit-profile row">
                                  <div class="col-md-12">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="id_nationality" >Occupation*</label>
                                          <select class="form-control" name="occupation" id="occupation" onchange="occupation_value();" >
                                            <? $occupation_details = $this->Requestmodel->get_occupation_details();
													foreach($occupation_details as $row){
														$s="";
														if($row['id']==$userdetails['occupation']){$s = " selected";}
														echo '<option value="'.$row['id'].'" '.$s.'>'.$row['name'].'</option>';
													}
												?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <? 	if($userdetails['occupation']){$occup_details = $this->Requestmodel->get_occupational_details($userdetails['occupation'],$userdetails['borrower_id']);}
								  		if($userdetails['occupation']==1)
										{
											$occup_details1 = $occup_details;
										}
										else if($userdetails['occupation']==2)
										{
											$occup_details2 = $occup_details;
										}
										else if($userdetails['occupation']==3)
										{
											$occup_details3 = $occup_details;
										}
										else if($userdetails['occupation']==4)
										{
											$occup_details4 = $occup_details;
										}
										else if($userdetails['occupation']==5)
										{
											$occup_details5 = $occup_details;
										}
										?>
                                    <div class="layout-row occup_form" id="oocup1">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Type of company employed with* </label>
                                            <select class="form-control" name="employed_company1" id="employed_company1" >
                                              <? 	$g=$p=$m=$pl=$pr=$ps=$o="";
													if($occup_details1['employed_company']=="Government"){
														$g = " selected";
													}
													else if($occup_details1['employed_company']=="PSUs"){
														$p = " selected";
													}
													else if($occup_details1['employed_company']=="MNC"){
														$m = " selected";
													}
													else if($occup_details1['employed_company']=="Public Limited Company"){
														$pl = " selected";
													}
													else if($occup_details1['employed_company']=="Partnership"){
														$pr = " selected";
													}
													else if($occup_details1['employed_company']=="Proprietorship"){
														$ps = " selected";
													}
													else if($occup_details1['employed_company']=="Others"){
														$o = " selected";
													}

											  ?>
                                              <option value="Government" <?=$g;?>>Government</option>
                                              <option value="PSUs" <?=$p;?>>PSUs</option>
                                              <option value="MNC" <?=$m;?>>MNC</option>
                                              <option value="Public Limited Company" <?=$pl;?>>Public Limited Company</option>
                                              <option value="Partnership" <?=$pr;?>>Partnership</option>
                                              <option value="Proprietorship" <?=$ps;?>>Proprietorship</option>
                                              <option value="Others" <?=$o;?>>Others</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="form-group">
                                            <label for="">Name of company*</label>
                                            <input class="form-control" type="text" name="company_name1" id="company_name1" value="<?=$occup_details1['company_name'];?>" onkeyup="showResult1(this.value)" >
                                          </div>
                                      <div id="livesearch1" class="col-md-12" style="display:none"></div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">No of years at current employment</label>
                                            <input class="form-control" type="text" name="years_count1" id="years_count1" value="<?=$occup_details1['years_count'];?>" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Designation</label>
                                            <input class="form-control" type="text" name="designation" id="designation" value="<?=$occup_details1['designation'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Department</label>
                                            <input class="form-control" type="text" name="department" id="department" value="<?=$occup_details1['department'];?>" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Total years in employment</label>
                                            <input class="form-control" type="text" name="total_yrs_emp1" id="total_yrs_emp1" value="<?=$occup_details1['total_yrs_emp'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Net Monthly Income in INR*</label>
                                            <input class="form-control" type="text" name="net_monthly_income1" id="net_monthly_income1" value="<?=$occup_details1['net_monthly_income'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Current EMIs in INR*</label>
                                            <input class="form-control" type="text" name="current_emis1" id="current_emis1" maxlength="10" value="<?=$occup_details1['current_emis'];?>" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Ever defaulted on any loan or credit card*</label>
                                            <select class="form-control" name="defaulted1" id="defaulted1" >
                                              <? 	$y=$n="";
													if($occup_details1['defaulted']=="Yes"){
														$y = " selected";
													}
													else if($occup_details1['defaulted']=="No"){
														$n = " selected";
													}
												?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="layout-row occup_form" id="oocup2">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Industry Type* </label>
                                            <select class="form-control" name="industry_type2" id="industry_type2" >
                                              <? 	$m=$t=$s=$mn=$k=$b=$so=$o="";
														if($occup_details2['employed_company']=="Manufacturing"){
															$m = " selected";
														}
														else if($occup_details2['employed_company']=="Trading"){
															$t = " selected";
														}else if($occup_details2['employed_company']=="Service"){
															$s = " selected";
														}
														else if($occup_details2['employed_company']=="MNC"){
															$mn = " selected";
														}
														else if($occup_details2['employed_company']=="KPO"){
															$k = " selected";
														}
														else if($occup_details2['employed_company']=="BPO"){
															$b = " selected";
														}
														else if($occup_details2['employed_company']=="Software"){
															$so = " selected";
														}
														else if($occup_details2['employed_company']=="Others"){
															$o = " selected";
														}

												  ?>
                                              <option value="Manufacturing" <?=$m;?>>Manufacturing</option>
                                              <option value="Trading" <?=$t;?>>Trading</option>
                                              <option value="Service" <?=$s;?>>Service</option>
                                              <option value="MNC" <?=$mn;?>>MNC</option>
                                              <option value="KPO" <?=$k;?>>KPO</option>
                                              <option value="BPO" <?=$b;?>>BPO</option>
                                              <option value="Software" <?=$so;?>>Software</option>
                                              <option value="Others" <?=$o;?>>Others</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Total Experience*</label>
                                            <input class="form-control" type="text" name="total_experience2" id="total_experience2" value="<?=$occup_details2['total_experience'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Net worth</label>
                                            <input class="form-control" id="" name="net_worth2" type="text" value="<?=$occup_details2['net_worth'];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Gross Turnover Last Year*</label>
                                            <input class="form-control" type="text" name="turnover_last_year2" id="turnover_last_year2" value="<?=$occup_details2['turnover_last_year'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Gross Turnover Year 2*</label>
                                            <input class="form-control" type="text" name="turnover_last2_year2" id="turnover_last2_year2" value="<?=$occup_details2['turnover_last2_year'];?>" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">audit done for financials?</label>
                                            <input class="form-control" id="" name="audit_status2" type="text" value="<?=$occup_details2['audit_status'];?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">office phone no.</label>
                                            <input class="form-control" id="" name="office_phone_no2" type="text" value="<?=$occup_details2['office_phone_no'];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Office ownership</label>
                                            <select class="form-control" name="office_ownership2" >
                                              <? 	$o=$r=$rc="";
													if($occup_details2['office_ownership']=="Owned"){
														$o = " selected";
													}
													else if($occup_details2['office_ownership']=="Rented"){
														$r = " selected";
													}
													else if($occup_details2['office_ownership']=="Resi cum office"){
														$rc = " selected";
													}
												?>
                                              <option value="Owned" <?=$o;?>>Owned</option>
                                              <option value="Rented" <?=$r;?>>Rented</option>
                                              <option value="Resi cum office" <?=$rc;?>>Resi cum office</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Current EMIs in INR*</label>
                                            <input class="form-control" type="text" name="current_emis2" id="current_emis2" value="<?=$occup_details2['current_emis'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Ever defaulted on any loan or credit card*</label>
                                            <select class="form-control" name="defaulted2" id="defaulted2" >
                                              <? 	$y=$n="";
														if($occup_details2['defaulted']=="Yes"){
															$y = " selected";
														}
														else if($occup_details2['defaulted']=="No"){
															$n = " selected";
														}
													?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="layout-row occup_form" id="oocup3">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Profession Type*</label>
                                            <select class="form-control" name="professional_type3" id="professional_type3" >
                                              <? 	$d=$t=$ca=$cs=$a=$l=$o="";
														if($occup_details3['professional_type']=="Doctor"){
															$d = " selected";
														}
														else if($occup_details3['professional_type']=="Teacher"){
															$t = " selected";
														}
														else if($occup_details3['professional_type']=="CA"){
															$ca = " selected";
														}
														else if($occup_details3['professional_type']=="CS"){
															$cs = " selected";
														}
														else if($occup_details3['professional_type']=="Architect"){
															$a = " selected";
														}
														else if($occup_details3['professional_type']=="Lawyer"){
															$l = " selected";
														}
														else if($occup_details3['professional_type']=="Others Consultant"){
															$o = " selected";
														}

												  ?>
                                              <option value="Doctor" <?=$d;?>>Doctor</option>
                                              <option value="Teacher" <?=$t;?>>Teacher</option>
                                              <option value="CA" <?=$ca;?>>CA</option>
                                              <option value="CS" <?=$cs;?>>CS</option>
                                              <option value="Architect" <?=$a;?>>Architect</option>
                                              <option value="Lawyer" <?=$l;?>>Lawyer</option>
                                              <option value="Other Consultant" <?=$o;?>>Other Consultant</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Total Experience*</label>
                                            <input class="form-control" type="text" name="total_experience3" id="total_experience3" value="<?=$occup_details3['total_experience'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Net worth</label>
                                            <input class="form-control" id="" name="net_worth3" type="text" value="<?=$occup_details2['net_worth'];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Gross Turnover Last Year*</label>
                                            <input class="form-control" type="text" name="turnover_last_year3" id="turnover_last_year3" value="<?=$occup_details3['turnover_last_year'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Gross Turnover Year 2*</label>
                                            <input class="form-control" type="text" name="turnover_last2_year3" id="turnover_last2_year3" value="<?=$occup_details3['turnover_last2_year'];?>" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="input-field col s12 required" id="">
                                            <label for="">audit done for financials?</label>
                                            <input class="form-control" id="" name="audit_status3" type="text" value="<?=$occup_details3['audit_status'];?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">office phone no.</label>
                                            <input class="form-control" id="" name="office_phone_no3" type="text" value="<?=$occup_details3['office_phone_no'];?>">
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Office ownership</label>
                                            <select class="form-control" name="office_ownership3" >
                                              <? 	$o=$r=$rc="";
													if($occup_details3['office_ownership']=="Owned"){
														$o = " selected";
													}
													else if($occup_details3['office_ownership']=="Rented"){
														$r = " selected";
													}
													else if($occup_details3['office_ownership']=="Resi cum office"){
														$rc = " selected";
													}
												?>
                                              <option value="Owned" <?=$o;?>>Owned</option>
                                              <option value="Rented" <?=$r;?>>Rented</option>
                                              <option value="Resi cum office" <?=$rc;?>>Resi cum office</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Current EMIs in INR*</label>
                                            <input class="form-control" type="text" name="current_emis3" id="current_emis3" value="<?=$occup_details3['current_emis'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Ever defaulted on any loan or credit card*</label>
                                            <select class="form-control" name="defaulted3" id="defaulted3" >
                                              <? 	$y=$n="";
														if($occup_details3['defaulted']=="Yes"){
															$y = " selected";
														}
														else if($occup_details3['defaulted']=="No"){
															$n = " selected";
														}
													?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="layout-row occup_form" id="oocup4">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Type of company employed with </label>
                                            <select class="form-control" name="company_type4" id="company_type4" >
                                              <? 	$g=$p=$m=$pl=$pr=$ps=$o="";
														if($occup_details4['company_type']=="Government"){
															$g = " selected";
														}
														else if($occup_details4['company_type']=="PSUs"){
															$p = " selected";
														}else if($occup_details4['company_type']=="MNC"){
															$m = " selected";
														}
														else if($occup_details4['company_type']=="Public Limited Company"){
															$pl = " selected";
														}
														else if($occup_details4['company_type']=="Partnership"){
															$pr = " selected";
														}
														else if($occup_details4['company_type']=="Proprietorship"){
															$ps = " selected";
														}
														else if($occup_details4['company_type']=="Others"){
															$o = " selected";
														}

												  ?>
                                              <option value="Government" <?=$g;?>>Government</option>
                                              <option value="PSUs" <?=$p;?>>PSUs</option>
                                              <option value="MNC" <?=$m;?>>MNC</option>
                                              <option value="Public Limited Company" <?=$pl;?>>Public Limited Company</option>
                                              <option value="Partnership" <?=$pr;?>>Partnership</option>
                                              <option value="Proprietorship" <?=$ps;?>>Proprietorship</option>
                                              <option value="Others" <?=$o;?>>Others</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="form-group">
                                            <label for="">Name of company*</label>
                                            <input class="form-control" type="text" name="company_name4" id="company_name4" value="<?=$occup_details4['company_name'];?>" onkeyup="showResult4(this.value)" >
                                          </div>
                                      <div id="livesearch4" class="col-md-12" style="display:none"></div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Net Monthly Income in INR*</label>
                                            <input class="form-control" type="text" name="net_monthly_income4" id="net_monthly_income4" value="<?=$occup_details4['net_monthly_income'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Current EMIs in INR*</label>
                                            <input class="form-control" type="text" name="current_emis4" id="current_emis4" value="<?=$occup_details4['current_emis'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">

                                            <label for="">Ever defaulted on any loan or credit card*</label>
                                            <select class="form-control" name="defaulted4" id="defaulted4" >
                                              <? 	$y=$n="";
														if($occup_details4['defaulted']=="Yes"){
															$y = " selected";
														}
														else if($occup_details4['defaulted']=="No"){
															$n = " selected";
														}
													?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="layout-row occup_form" id="oocup5">
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">I am pursuing* </label>
                                            <select class="form-control" name="pursuing5" id="pursuing5" >
                                              <? 	$g=$p=$d=$pl=$di="";
														if($occup_details5['pursuing']=="Graduation"){
															$g = " selected";
														}
														else if($occup_details5['pursuing']=="Postgraduation"){
															$p = " selected";
														}
														else if($occup_details5['pursuing']=="Doctoral"){
															$d = " selected";
														}
														else if($occup_details5['pursuing']=="Professional"){
															$pl = " selected";
														}
														else if($occup_details5['pursuing']=="Diploma"){
															$di = " selected";
														}

												  ?>
                                              <option value="Graduation" <?=$g;?>>Graduation</option>
                                              <option value="Postgraduation" <?=$p;?>>Postgraduation</option>
                                              <option value="Doctoral" <?=$d;?>>Doctoral</option>
                                              <option value="Professional" <?=$pl;?>>Professional</option>
                                              <option value="Diploma" <?=$d;?>>Diploma</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Name of Educational Institution*</label>
                                            <input class="form-control" type="text" name="institute_name5" id="institute_name5" value="<?=$occup_details5['institute_name'];?>" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Net Monthly Income in INR*</label>
                                            <input class="form-control" type="text" name="net_monthly_income5" id="net_monthly_income5" value="<?=$occup_details5['net_monthly_income'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Current EMIs in INR</label>
                                            <input class="form-control" type="text" name="current_emis5" id="current_emis5" value="<?=$occup_details5['current_emis'];?>" maxlength="10" onkeypress="return isNumberKey(event)" >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                          <div class="form-group">
                                            <label for="">Ever defaulted on any loan or credit card*</label>
                                            <select class="form-control" name="defaulted5" id="defaulted5" >
                                              <? 	$y=$n="";
														if($occup_details5['defaulted']=="Yes"){
															$y = " selected";
														}
														else if($occup_details5['defaulted']=="No"){
															$n = " selected";
														}
													?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default"><a role="button" data-toggle="collapse" data-parent="#accordion-one" href="#accordion-one-collapse-three">Bank Details</a>
                          <div id="accordion-one-collapse-three" class="panel-collapse collapse" role="tabpanel">
                            <div class="inner-box">
                              <div class="card" id="form1">
                                <div class="card-content">
                                  <div class="section edit-profile row">
                                    <div class="">
                                      <div class="">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_partner_name">Bank Name </label>
                                              <input type="text" class="form-control" name="bank_name" value="<?=$userdetails['bank_name'];?>" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_partner_name">Branch Name </label>
                                              <input type="text" class="form-control" name="branch_name" value="<?=$userdetails['branch_name'];?>" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_email">Account Number</label>
                                              <input type="text" class="form-control" name="account_no" id="account_no" value="<?=$userdetails['account_number'];?>" maxlength="16" onkeypress="return isNumberKey(event)" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                              <label for="id_date_of_birth">IFSC Code</label>
                                              <input type="text" class="form-control" value="<?=$userdetails['ifsc_code'];?>" id="ifsc_code" name="ifsc_code">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-4">
                                            <div class="form-group" id="id_office_container">
                                              <label for="">Account Type</label>
                                              <input class="form-control" type="text" name="account_type" value="<?=$userdetails['account_type'];?>" >
                                            </div>
                                          </div>
                                       </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="card-action">
                      <div class="right-align">
                        <button class="btn btn-primary" type="sumbit">Save</button>
                      </div>
                    </div>
                    <br>
                    <br>
                  </form>
                </div>
                <!-- End Edit Profile -->
              </div>
              <? }if($this->session->userdata('login_type')==2){?>

              <div id="proedittab2" class="tab-pane fade in">
                <div class="edit-profile-tabs">
                  <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=base_url();?>home/edit_borrower_corporate/" onsubmit="return edit_borrower_corporate()">
                    <div class="section row" style="padding-top: 0px;">

                        <div class="inner-box">
                          <div class="card" id="form1">
                            <div class="card-content">
                              <div class="section edit-profile row">
                                <div class="col-md-12">
                                  <div class="">
                                    <input type="hidden" name="borrower_id" value="<?=$userdetails['borrower_id'];?>" readonly >
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Name of company* </label>
                                          <input type="text" class="form-control" name="" value="<?=$userdetails['company_name'];?>" readonly >
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="">Name of Authorized person* </label>
                                          <input type="text" class="form-control" value="<?=$userdetails['person_name'];?>" id="person_name" name="person_name">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Email Id*</label>
                                          <input type="text" class="form-control" name="" value="<?=$userdetails['email'];?>" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Username* </label>
                                          <input type="text" class="form-control" name="" value="<?=$userdetails['username'];?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Mobile*</label>
                                          <input type="text" class="form-control" name="mobile" id="mobile" value="<?=$userdetails['mobile'];?>" maxlength="10" onkeypress="return isNumberKey(event)">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">Year of Incorporation*</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['yr_incorp'];?>" id="yr_incorp" name="yr_incorp" maxlength="4" onkeypress="return isNumberKey(event)">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">CIN*</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['cin'];?>" id="cin" name="cin">
											<a href="http://www.mca.gov.in/mcafoportal/findCIN.do" target="_blank">Ministry Of Corporate Affairs - MCA Services</a>
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Company Industry</label>
                                          <select class="form-control" name="company_industry" id="company_industry" >
                                          	<option value="<?=$userdetails['company_industry'];?>" ><?=$userdetails['company_industry'];?></option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Trading">Trading</option>
                                            <option value="Service">Service</option>
                                            <option value="Transporter">Transporter</option>
                                            <option value="Infrastructure">Infrastructure</option>
                                            <option value="Other">Other</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">Net Worth</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['net_worth'];?>" id="net_worth" name="net_worth" maxlength="10" onkeypress="return isNumberKey(event)">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Gross turnover last year </label>
                                          <input type="text" class="form-control" name="turnover_last_year" value="<?=$userdetails['turnover_last_year'];?>" >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="">Gross turnver year 2 </label>
                                          <input type="text" class="form-control" value="<?=$userdetails['turnover_year2'];?>" id="" name="turnover_year2">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Gross turnver year 3</label>
                                          <input type="text" class="form-control" name="turnover_year3" value="<?=$userdetails['turnover_year3'];?>">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Net Profit last year </label>
                                          <input type="text" class="form-control" name="profit_last_year" value="<?=$userdetails['profit_last_year'];?>">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Net profit year 2</label>
                                          <input type="text" class="form-control" name="profit_year2" id="" value="<?=$userdetails['profit_year2'];?>" >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">Net profit year 3</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['profit_year3'];?>" id="" name="profit_year3">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Total loans on book</label>
                                          <input type="text" class="form-control" name="total_loans_on_book" value="<?=$userdetails['total_loans_on_book'];?>" >
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="">Current EMIs in INR</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['current_emis'];?>" id="" name="current_emis">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Ever defaulted on any loan</label>
                                           <select class="form-control" name="defaulted" id="defaulted" >
                                              <? 	$y=$n="";
													if($userdetails['defaulted']=="Yes"){
														$y = " selected";
													}
													else if($userdetails['defaulted']=="No"){
														$n = " selected";
													}
												?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_partner_name">Any cheque bounce case in last 6 months</label>
                                          <select class="form-control" name="cheque_bounce_flag" id="" >
                                              <? 	$y=$n="";
													if($userdetails['cheque_bounce_flag']=="Yes"){
														$y = " selected";
													}
													else if($userdetails['cheque_bounce_flag']=="No"){
														$n = " selected";
													}
												?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_email">Whether company is rated by Rating Agency</label>
                                          <select class="form-control" name="rating_agency_flag" id="rating_agency_flag" >
                                              <? 	$y=$n="";
													if($userdetails['rating_agency_flag']=="Yes"){
														$y = " selected";
													}
													else if($userdetails['rating_agency_flag']=="No"){
														$n = " selected";
													}
												?>
                                              <option value="Yes" <?=$y;?>>Yes</option>
                                              <option value="No" <?=$n;?>>No</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">Latest Rating</label>
                                          <input type="text" class="form-control" value="<?=$userdetails['latest_rating'];?>" id="" name="latest_rating">
                                        </div>
                                      </div>
                                      <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                          <label for="id_date_of_birth">Description*</label>
                                          <textarea type="text" class="form-control" id="" name="description"><?=$userdetails['description'];?></textarea>
                                        </div>
                                      </div>
                                    </div>


                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="card-action">
                      <div class="right-align">
                        <button class="btn btn-primary pull-right" type="sumbit">Save</button>
                      </div>
                    </div>
                    <br>
                    <br>
                  </form>
                </div>
                <!-- End Edit Profile -->
              </div>
              <? }?>
              <!-- Subtab-3 -->

              <div id="proedittab3" class="tab-pane fade in">
                <div class="row">
                  <div class="col-md-12">
                    <h4>ANTWORKS MONEY VERIFICATION AND RATING SERVICES</h4>
                        <h5><b style="text-decoration: underline;">VERIFICATION</b></h5>

                        <p>We verify Borrower’s Personal and Occupational Information like:<p>
                        <ul>
              						<li>Aadhaar Number (online)</li>
              						<li>PAN Card (online)</li>
              						<li>Defaulter List Check (online)</li>
              						<li>Income figures with Income Tax and TDS returns (offline)</li>
              						<li>Address Verification (offline) </li>
              						<li>Employment Status (offline)</li>
              					</ul>
              					<h5><b style="text-decoration: underline;">RATING</b></h5>
              					<p>We provide a Rating of 1-10 to Individual Borrowers only, wherein 1 indicates lowest level of Risk and 10 means highest level of Risk. The Rating is awarded basis evaluation of creditworthiness of Borrower on more than 20 different parameters.</p>
                        <p>The Rating can be initiated at the request of Borrower and Lender and it takes 24-48 hours to complete the rating process.</p>
                        <p>Please note that Personal and Occupational Information is also verified in the process of Rating a loan proposal and therefore a rated profile provides dual comfort to prospective lender viz.</p>
                        <ul>
                          <li>Comfort of user profile meeting our Verification </li>
                          <li>Rating of profile on our proprietary rating model.</li>
                        </ul>
                        <p>Borrower can choose to get these services as it will increase the chances of getting the interest from lenders.</p>
                        <p>We charge INR 2500 for verifying the user profile and it takes 24-48 hours to complete the verification process. The process of verification is done by our approved service providers and we ensure that these service providers are having a credible background.</p>
                        <p>Please <a href="<?=base_url();?>payment/loan_rating_services/">click here</a> to pay for Loan Rating and Verification Services and start the verification process</p>
                  </div>
                </div>
              </div>

              <!-- Subtab-4 -->
              <div id="proedittab4" class="tab-pane fade in">
                <div class="row">
<!--                  <div class="col-md-12 mb16">-->
<!--                    <h3>Documents Details</h3>-->
<!--                  </div>-->
                </div>
                <div class="row mb32">
                  <? $docs_info = $this->P2pmodel->get_borrower_docs($userdetails['borrower_id']);
						foreach($docs_info as $row){?>
                  <div class="col-md-3">
                    <div class="document-block"> <a href="<?=base_url()."uploads/docs/".$row['docs_name'];?>" target="_blank">
                      <h1>
                        <?=ucfirst($row['docs_type']);?>
                      </h1>
                      <p>View File</p>
                      </a> </div>
                  </div>
                  <? }?>
                </div>
                <form action="<?=base_url();?>Home/add_docs_borrower/" method="post" onsubmit="validate check_borrower_docs()" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12 mb16">
                      <h3>Upload Documents</h3>
                    </div>
                  </div>
                  <div class="row">
                    <input type="hidden" name="bid" value="<?=$userdetails['borrower_id'];?>">
                    <div class="col-md-6 col-sm-4">
                      <div class="form-group">
                        <label class="col-md-12">Aadhaar Card</label>
                        <div class="col-md-12">
                          <input class="form-control" type="file" name="aadhaar"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4">
                      <div class="form-group">
                        <label class="col-md-12">PAN Card</label>
                        <div class="col-md-12">
                          <input class="form-control" type="file" name="pancard"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4">
                      <div class="form-group">
                        <label class="col-md-12">Voter ID</label>
                        <div class="col-md-12">
                          <input class="form-control" type="file" name="voter"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4">
                      <div class="form-group">
                        <label class="col-md-12">Financial Documents</label>
                        <div class="col-md-12">
                          <input class="form-control" type="file" name="financial"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-4 upload-mfile">
                      <div class="form-group">
                        <label class="col-md-12">&nbsp;</label>
                        <div class="col-md-12"><a href="javascript:" class="upload-mfile-btn"><i class="fa fa-plus"></i> Upload more files</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="card-action">
                      <div class="col-md-12 right-align">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Subtab-5 -->
              <div id="proedittab5" class="tab-pane fade in">
                <div class="row">
                  <div class="col-md-12 mb16">
                    <h3>Loan Documents</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">

                    <? if($borrower_info){
						$i=1;
						foreach($borrower_info as $row33){
							if($row33['bidding_status']==2){
								echo '<p><a href="'.base_url().'pdfedit?proposal_id='.$row33['proposal_id'].'" target="_blank">View/ Download Loan Document for PLRN - '.$row33['PLRN'].'</a></p>';
							}
						}
					}
					?>
                  </div>
                </div>
              </div>

              <!-- Subtab-6 -->
              <div id="proedittab6" class="tab-pane fade in">
                <div class="edit-profile">
                  <div class="row">
                    <h3 class="mb16">New Proposal</h3>
                  </div>
                  <form action="<?=base_url();?>Home/add_loan_proposal/" method="post" onsubmit="return add_loan_proposal()">
                    <div class="row">
                      <div class="col-md-6 col-sm-4">
                        <div class="form-group">
                          <label for="">I am* </label>
                          <select class="form-control" name="" id="">
                            <option value="<?=$userdetails['loan_type'];?>">
                            <?=$this->Requestmodel->loan_type_name($userdetails['loan_type']);?>
                            </option>
                            <input class="form-control" type="hidden" name="borrower_id" value="<?=$userdetails['borrower_id'];?>"/>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-4">
                        <div class="form-group">
                          <label for="">Looking for*</label>
                          <select class="form-control" name="loan_purpose" id="loan_purpose" >
                            <option value="">Select Loan Type</option>
                            <? $loan_info = $this->Requestmodel->loan_info_byid($userdetails['loan_type']);
										foreach($loan_info as $row){?>
                            <option value="<?=$row['id'];?>">
                            <?=$row['name'];?>
                            </option>
                            <? }?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-4">
                        <div class="form-group">
                          <h5 class="mb16">Loan Amount</h5>
                          <div id="slider" class="mb16"></div>
                          <input class="form-control" type="text" id="loan" name="loan_amount" value="100000" maxlength="8" onkeypress="return isNumberKey(event)" />
                        </div>
                        <div class="form-group">
                          <h5 class="mb16">Interest Range</h5>
                          <div class="col-md-6 col-sm-4">
                            <div class="form-group">
                              <label>Min</label>
                              <div id="min" class="mb16"></div>
                              <input class="form-control" type="text" id="min-range" name="min_interest_rate" value="12" maxlength="2" onkeypress="return isNumberKey(event)" />
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-4">
                            <div class="form-group">
                              <label>Max</label>
                              <div id="max" class="mb16"></div>
                              <input class="form-control" type="text" id="max-range" name="max_interest_rate" value="24" maxlength="2" onkeypress="return isNumberKey(event)" />
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <h5 class="mb16">Tenor in months</h5>
                          <div class="col-md-12">
                            <div class="form-group">
                              <div id="tenor" class="mb16"></div>
                              <input class="form-control" type="text" class="col-md-6" id="tenor-range" name="tenor_months" value="12" maxlength="3" onkeypress="return isNumberKey(event)" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-4"> <br>
                        <br>
                        <div class="form-group">
                          <label for="">Whether any collateral is offered*</label>
                          <select class="form-control" name="collateral_flag" id="collateral_flag" onchange="get_collateral_details()" >
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                          </select>
                        </div>
                        <div id="collateral_details_div">
                          <div class="form-group">
                            <label for="">Collateral Details in max 50 words</label>
                            <textarea class="form-control" name="collateral_details" id="collateral_details" cols="5" style="height:100%" maxlength="100"></textarea>
                          </div>
                        </div>
                        <div>
                          <div class="form-group">
                            <label for="">Loan pitch by Borrower in max 100 words</label>
                            <textarea class="form-control" name="loan_description" id="loan_description" cols="5" style="height:100%" maxlength="100"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-action">
                      <div class="">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                    </div>
                    <br>
                    <br>
                  </form>
                </div>
              </div>
            </div>
            <!-- End tab-content -->

          </div>
        </div>
      </div>
      <div id="profiletab2" class="tab-pane fade">
        <div class="page-full">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table default-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Loan Name</th>
                      <th>Peer Loan Request Number(PLRN)</th>
                      <th>Amount(in INR)</th>
                      <th>Interest Rate Range(%)</th>
                      <th>Tenor(in months)</th>
                      <th>DateTime of Proposal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <? if($borrower_info){
								$i=1;
								foreach($borrower_info as $row){?>
                    <tr>
                      <td><?=$i;?></td>
                      <td><?=$this->Requestmodel->get_loan_name($row['loan_purpose']);?></td>
                      <td><?=$row['PLRN'];?></td>
                      <td><?=$row['loan_amount'];?></td>
                      <td><?=$row['min_interest_rate']."-".$row['max_interest_rate'];?></td>
                      <td><?=$row['tenor_months'];?></td>
                      <td><?=$row['date_added'];?></td>
                      <? 	if($row['bidding_status']==0)
							{
								$bid_s = "Proposal Listed";
							}
							else if($row['bidding_status']==1)
							{
								$bid_s = "Bidding Open";
							}
							else if($row['bidding_status']==2)
							{
								$bid_s = "Loan Approved";
							}
							else if($row['bidding_status']==3)
							{
								$bid_s = "Application Closed";
							}
							if($row['bidding_status']!=0){
							?>
                      <td><span class="label label-danger">
                        <?=$bid_s;?>
                        </span></td>
                      <? }else{?>
                      <td><a href="<?=base_url();?>Home/initiate_bidding/<?=$row['proposal_id'];?>" onclick="return confirm_status_change()">
                        <button type="button" class="btn pull-right btn-primary" >Initiate Bidding</button>
                        </a></td>
                      <? }?>
                    </tr>
                    <? $i++;}}
							 else {?>
                    <tr>
                      <td colspan="7">
                            <p>Please Initiate Bidding to enable lender see your profile and start bidding.</p>
                            <p>Increase the chance of gaining their interest with <a href="#">Loan Rating Services</a></p>
                      </td>
                    </tr>
                    <? }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="profiletab3" class="tab-pane fade">
        <ul class="bidding-status-ul">
          <? if($borrower_info){
			$i=1;
			foreach($borrower_info as $row11){
				if($row11['bidding_status']!=0)
				{
					//print_r($borrower_info);exit;
					if($row11['bidding_status']==2)
					{
						$proposal_info=$this->P2pmodel->get_approved_bid($row11['proposal_id']);
					}
					else
					{
						$proposal_info=$this->P2pmodel->borrower_bidding_proposal_orderby_interestrate($row11['proposal_id']);
					}
				//print_r($proposal_info);exit;
		?>
          <li>
            <div class="sec-title">
              <h3>Loan for
                <?=$this->Requestmodel->get_loan_name($row11['loan_purpose']);?>
                | PLRN -
                <?=$row11['PLRN'];?>
              </h3>
            </div>
            <p class="info"> <strong>Loan Amt</strong> <a>
              <?=$row11['loan_amount'];?>
              </a>&nbsp;&nbsp;|&nbsp;&nbsp; <strong>Interest Rate</strong> <a>
              <?=$row11['min_interest_rate']."-".$row11['max_interest_rate'];?>
              (%)</a>&nbsp;&nbsp;|&nbsp;&nbsp; <strong>Tenor</strong> <a>
              <?=$row11['tenor_months'];?>
              months</a> </p>
            <? 	if($row11['bidding_status']==0)
				{
					$bidding_status = "Proposal Listed";
				}
				else if($row11['bidding_status']==1)
				{
					$bidding_status = "Bidding Open";
				}
				else if($row11['bidding_status']==2)
				{
					$bidding_status = "Loan Approved";
				}
				else if($row11['bidding_status']==3)
				{
					$bidding_status = "Application Closed";
				}
			?>
            <a>Proposal Status -</a> <span class="label label-danger">
            <?=ucwords($bidding_status);?>
            </span>
            <hr>
            <? if($row11['bidding_status']==2)
		{?>
            <h5>Successful Bids</h5>
            <div class="table-responsive">
              <table class="table default-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Lender Name</th>
                    <th>Amount %</th>
                    <th>Interest Rate(%)</th>
                    <th>DateTime of Bid</th>
                  </tr>
                </thead>
                <tbody>
                  <?
				if($proposal_info){
					foreach($proposal_info as $row){
				?>
                  <tr>
                    <td><?=$i;?></td>
                    <td><?=$this->Requestmodel->get_user_name($row['lenders_id']);?></td>
                    <td><?=$row['approved_loan_amount'];?></td>
                    <td><?=$row['interest_rate'];?></td>
                    <td><?=$row['proposal_added_date'];?></td>
                  </tr>
                  <? $i++;}}

				 else {?>
                  <tr>
                    <td colspan="6">Please Initiate Bidding to enable lender see your profile and start bidding.<br>Increase the chance of gaining their interest with <a href="#">Loan Rating Services</a></td>
                  </tr>
                  <? }?>
                </tbody>
              </table>
            </div>
            <? if($row11['bidding_status']==2)
			{?>
            <div class="col-md-3 pull-left"> <a href="<?=base_url();?>home/borrower_dashboard/">
              <button class="btn btn-primary " type="submit"><i class="fa fa-plus"> </i> &nbsp; &nbsp;Initiate Document </button>
              </a> </div>
              <? }?>
            <div class="col-md-3 pull-right"> <a href="<?=base_url();?>home/bidding_status_details/<?=$row11['proposal_id']?>/">
              <button class="btn btn-primary " type="submit"><i class="fa fa-plus"> </i> &nbsp; &nbsp;View Bids Received </button>
              </a> </div>
            <? }else
			{ ?>
            <h5>Requested Bids</h5>
            <div class="table-responsive">
              <table class="table default-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Lender Name</th>
                    <th>Amount %</th>
                    <th>Interest Rate(%)</th>
                    <th>DateTime of Bid</th>
                  </tr>
                </thead>
                <tbody>
                  <?
                    if($proposal_info){//print_r($proposal_info);
                        $i=1;
                        foreach($proposal_info as $row){?>
                  <tr>
                    <td><?=$i;?></td>
                    <td><?=$this->Requestmodel->get_user_name($row['lenders_id']);?></td>
                    <td><?=$row['loan_amount'];?></td>
                    <td><?=$row['interest_rate'];?></td>
                    <td><?=$row['proposal_added_date'];?></td>
                  </tr>
                  <? $i++;}}

                     else {?>
                  <tr>
                    <td colspan="6">Please Initiate Bidding to enable lender see your profile and start bidding.<br>
                      Increase the chance of gaining their interest with <a href="javascript:void(0);" onclick="gotoprofile();">Loan Rating Services</a></td>
                  </tr>
                  <? }?>
                </tbody>
              </table>
            </div>
            <?
		}?>
            <br>
            <br>
          </li>
          <? }
		  else {?>
            <li>
            <div class="sec-title">
              Please Initiate Bidding to enable lender see your profile and start bidding.<br>
              Increase the chance of gaining their interest with <a href="javascript:void(0);" onclick="gotoprofile();">Loan Rating Services </a>
            </div>
           <? }}}?>
        </ul>
      </div>
      <div id="profiletab4" class="tab-pane fade">
        <div class="page-full">
          <div class="row">
            <div class="col-md-12">
              <form action="<?=base_url();?>home/track_request/" method="post">
                <div class="track-filter-box"> <i class="fa fa-search"></i>
                  <input class="form-control" type="text" name="plrn" placeholder="Search" maxlength="10">
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <? if($track_info){?>
              <div class="content"> <br>
                <br>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <h3>Request Tracking:
                      <?=$this->session->userdata('plrn');;?>
                    </h3>
                  </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="content3 col-md-10 col-md-offset-1 single-service-tabs">
                  <div class="shipment">
                    <div class="confirm" id="proposal-listed">
                      <div class="imgcircle"> <img src="<?=base_url();?>assets/img/process.png" alt="process order"> </div>
                      <span class="line"></span>
                      <p>Proposal Listed</p>
                    </div>

                    <div class="process" id="bid-open">
                      <div class="imgcircle"> <img src="<?=base_url();?>assets/img/quality.png" alt="quality check"> </div>
                      <span class="line"></span>
                      <p>Bidding Open</p>
                    </div>

                    <div class="process" id="loan-approved">
                      <div class="imgcircle"> <img src="<?=base_url();?>assets/img/dispatch.png" alt="dispatch product"> </div>
                      <span class="line"></span>
                      <p>Loan Approved</p>
                    </div>

                    <div class="delivery" id="loan-given">
                      <div class="imgcircle"> <img src="<?=base_url();?>assets/img/delivery.png" alt="delivery"> </div>
                      <p>Application Closed</p>
                    </div>
                    <div class="clear"></div>
                  </div>
                </div>
              </div>
              <? }?>
            </div>
          </div>
        </div>
      </div>
      <div id="profiletab5" class="tab-pane fade">
        <div class="page-full">
         <style>
		 	.alert {overflow:auto;}
			.alert div.img {display:inline-block; float:left;}
			.alert div.desc {margin-left: 70px;}
			.alert div.desc .date {font-weight:bold; font-size:12px; margin-bottom:5px; margin-top:5px;}
			.alert div.img img {width:60px;}
		 </style>
          <div class="notification">
            <div class="row tutorial_list"><br />
            	<div class="sec-title text-left">
                    <h4>Borrowers Notification</h4>
                 </div >
            <? 	foreach($borrower_notification as $roww){
				$lender_profile = $this->P2pmodel->get_profilepic_lender($roww['user_id']);
				if($lender_profile)
				{
					$user_image = base_url()."uploads/users/".$lender_profile;
				}
				else
				{
					$user_image = base_url()."assets/img/team/team-8.png";
				}
			?>
              <div class="alert alert-info">
              	<div class="img"><a href="<?=base_url();?>home/lenders_details/<?=$roww['user_id'];?>"><img src="<?=$user_image;?>"></a></div>
              	<div class="desc">
                <div class="date"><?=$roww['datecreated'];?></div>
                <strong><?=$roww['activity'];?>!</strong> <?=$roww['description'];?>
                </div>
              </div>
            <? }?>
            </div>
            <div class="row">
            <? if($latest_count > $limit){ ?>
             <div class="show_more_main" id="show_more_main<?php echo $tutorial_id; ?>">
                <span id="<?php echo $tutorial_id; ?>" class="show_more" title="Load more posts">Show more</span>
                <span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span>
            </div>
             <? }?>
            </div>
          </div>
        </div>
      </div>
      <div id="profiletab6" class="tab-pane fade">
        <div class="page-full">
         <style>
		 	.alert {overflow:auto;}
			.alert div.img {display:inline-block; float:left;}
			.alert div.desc {margin-left: 70px;}
			.alert div.desc .date {font-weight:bold; font-size:12px; margin-bottom:5px; margin-top:5px;}
			.alert div.img img {width:60px;}
		 </style>
          <div class="notification">
            <div class="row tutorial_list"><br />
            	<div class="sec-title text-left">

                   <?php if($borrower_video_info){?><h4>Your Video</h4> <?php
                     foreach($borrower_video_info AS $borrower_video){
                     ?>
                     <video width="400" controls>
                       <source src="<?php echo base_url();?>uploads/borrowervideo/<?php echo $borrower_video['file_name'] ?>" type="video/mp4">
                     </video>
                     <?php
                     }} else{ ?>
                    <h4>Record Your Video</h4>
                  <section class="experiment recordrtc">
                    <div style="margin-top: 10px;" id="recording-player"></div>
                    <span id="question1"></span>
                    <input type="button" id="next_button" class="btn btn-primary" value="Next" style="display: none">
                    <div class="header" style="margin: 0; background: #fff;">
                      <select class="recording-media" style="display: none;">
                        <option value="record-audio-plus-video" selected>Microphone+Camera</option>
                        <option value="record-audio">Microphone</option>
                        <option value="record-screen">Full Screen</option>
                        <option value="record-audio-plus-screen">Microphone+Screen</option>
                      </select>



                      <select class="media-container-format" style="display: none">
                        <option>default</option>
                        <option>vp8</option>
                        <option>vp9</option>
                        <option>h264</option>
                        <option>mkv</option>
                        <option>opus</option>
                        <option>ogg</option>
                        <option>pcm</option>
                        <option>gif</option>
                        <option>whammy</option>
                      </select>



                      <button id="btn-start-recording" class="btn btn-primary">Start Recording</button>
                      <button id="btn-pause-recording" class="btn btn-primary" style="display: none; font-size: 15px;">Pause</button>

                      <hr style="border-top: 0;border-bottom: 1px solid rgb(189, 189, 189);margin: 4px -12px;margin-top: 8px;">
                      <select class="media-resolutions" style="display: none;">
                        <option value="default">Default resolutions</option>
                        <option value="1920x1080">1080p</option>
                        <option value="1280x720">720p</option>
                        <option value="640x480">480p</option>
                        <option value="3840x2160">4K Ultra HD (3840x2160)</option>
                      </select>

                      <select class="media-framerates" style="display: none">
                        <option value="default">Default framerates</option>
                        <option value="5">5 fps</option>
                        <option value="15">15 fps</option>
                        <option value="24">24 fps</option>
                        <option value="30">30 fps</option>
                        <option value="60">60 fps</option>
                      </select>

                      <select class="media-bitrates" style="display: none">
                        <option value="default">Default bitrates</option>
                        <option value="8000000000">1 GB bps</option>
                        <option value="800000000">100 MB bps</option>
                        <option value="8000000">1 MB bps</option>
                        <option value="800000">100 KB bps</option>
                        <option value="8000">1 KB bps</option>
                        <option value="800">100 Bytes bps</option>
                      </select>
                    </div>

                    <div style="text-align: center; display: none;">
                      <button id="save-to-disk" style="display: none;">Save To Disk</button>
                      <button id="upload-to-php">Upload</button>
                      <button id="open-new-tab" style="display: none">Open New Tab</button>

                      <!-- <div style="margin-top: 10px;">
                               <span id="signinButton" class="pre-sign-in">
                                 <span
                                         class="g-signin"
                                         data-callback="signinCallback"
                                         data-clientid="41556190767-115ifahd55lk4ln5pop4jus55cr4l7oh.apps.googleusercontent.com"
                                         data-cookiepolicy="single_host_origin"
                                         data-scope="https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube">
                                 </span>
                               </span>

                           <button id="upload-to-youtube" style="vertical-align:top;">Upload to YouTube</button>
                       </div> -->
                    </div>


                  </section>

                  <script>
                    (function() {
                      var params = {},
                          r = /([^&=]+)=?([^&]*)/g;

                      function d(s) {
                        return decodeURIComponent(s.replace(/\+/g, ' '));
                      }

                      var match, search = window.location.search;
                      while (match = r.exec(search.substring(1))) {
                        params[d(match[1])] = d(match[2]);

                        if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                          params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                        }
                      }

                      window.params = params;
                    })();

                    function addStreamStopListener(stream, callback) {
                      var streamEndedEvent = 'ended';

                      if ('oninactive' in stream) {
                        streamEndedEvent = 'inactive';
                      }

                      stream.addEventListener(streamEndedEvent, function() {
                        callback();
                        callback = function() {};
                      }, false);

                      stream.getAudioTracks().forEach(function(track) {
                        track.addEventListener(streamEndedEvent, function() {
                          callback();
                          callback = function() {};
                        }, false);
                      });

                      stream.getVideoTracks().forEach(function(track) {
                        track.addEventListener(streamEndedEvent, function() {
                          callback();
                          callback = function() {};
                        }, false);
                      });
                    }
                  </script>

                  <script>
                    var video = document.createElement('video');
                    video.controls = false;
                    var mediaElement = getHTMLMediaElement(video, {
                      title: 'Recording status: inactive',
                      buttons: ['full-screen'/*, 'take-snapshot'*/],
                      showOnMouseEnter: false,
                      width: 360,
                      onTakeSnapshot: function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = mediaElement.clientWidth;
                        canvas.height = mediaElement.clientHeight;

                        var context = canvas.getContext('2d');
                        context.drawImage(recordingPlayer, 0, 0, canvas.width, canvas.height);

                        window.open(canvas.toDataURL('image/png'));
                      }
                    });
                    document.getElementById('recording-player').appendChild(mediaElement);

                    var div = document.createElement('section');
                    mediaElement.media.parentNode.appendChild(div);
                    div.appendChild(mediaElement.media);

                    var recordingPlayer = mediaElement.media;
                    var recordingMedia = document.querySelector('.recording-media');
                    var mediaContainerFormat = document.querySelector('.media-container-format');
                    var mimeType = 'video/webm';
                    var fileExtension = 'webm';
                    var type = 'video';
                    var recorderType;
                    var defaultWidth;
                    var defaultHeight;

                    var btnStartRecording = document.querySelector('#btn-start-recording');

                    window.onbeforeunload = function() {
                      btnStartRecording.disabled = false;
                      recordingMedia.disabled = false;
                      mediaContainerFormat.disabled = false;
                    };

                    btnStartRecording.onclick = function(event) {
                      var button = btnStartRecording;

                      if(button.innerHTML === 'Stop Recording') {
                        btnPauseRecording.style.display = 'none';
                        button.disabled = true;
                        button.disableStateWaiting = true;
                        setTimeout(function() {
                          button.disabled = false;
                          button.disableStateWaiting = false;
                        }, 2000);

                        button.innerHTML = 'Start Recording';

                        function stopStream() {
                          if(button.stream && button.stream.stop) {
                            button.stream.stop();
                            button.stream = null;
                          }

                          if(button.stream instanceof Array) {
                            button.stream.forEach(function(stream) {
                              stream.stop();
                            });
                            button.stream = null;
                          }

                          videoBitsPerSecond = null;
                          var html = 'Recording status: stopped';
                          html += '<br>Size: ' + bytesToSize(button.recordRTC.getBlob().size);
                          recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = html;
                        }

                        if(button.recordRTC) {
                          if(button.recordRTC.length) {
                            button.recordRTC[0].stopRecording(function(url) {
                              if(!button.recordRTC[1]) {
                                button.recordingEndedCallback(url);
                                stopStream();

                                saveToDiskOrOpenNewTab(button.recordRTC[0]);
                                return;
                              }

                              button.recordRTC[1].stopRecording(function(url) {
                                button.recordingEndedCallback(url);
                                stopStream();
                              });
                            });
                          }
                          else {
                            button.recordRTC.stopRecording(function(url) {
                              if(button.blobs && button.blobs.length) {
                                var blob = new File(button.blobs, getFileName(fileExtension), {
                                  type: mimeType
                                });

                                button.recordRTC.getBlob = function() {
                                  return blob;
                                };

                                url = URL.createObjectURL(blob);
                              }

                              button.recordingEndedCallback(url);
                              saveToDiskOrOpenNewTab(button.recordRTC);
                              stopStream();
                            });
                          }
                        }

                        return;
                      }

                      if(!event) return;

                      button.disabled = true;

                      var commonConfig = {
                        onMediaCaptured: function(stream) {
                          button.stream = stream;
                          if(button.mediaCapturedCallback) {
                            button.mediaCapturedCallback();
                          }

                          button.innerHTML = 'Stop Recording';
                          button.disabled = false;
                        },
                        onMediaStopped: function() {
                          button.innerHTML = 'Start Recording';

                          if(!button.disableStateWaiting) {
                            button.disabled = false;
                          }
                        },
                        onMediaCapturingFailed: function(error) {
                          console.error('onMediaCapturingFailed:', error);

                          if(error.toString().indexOf('no audio or video tracks available') !== -1) {
                            alert('RecordRTC failed to start because there are no audio or video tracks available.');
                          }

                          if(DetectRTC.browser.name === 'Safari') return;

                          if(error.name === 'PermissionDeniedError' && DetectRTC.browser.name === 'Firefox') {
                            alert('Firefox requires version >= 52. Firefox also requires HTTPs.');
                          }

                          commonConfig.onMediaStopped();
                        }
                      };

                      if(mediaContainerFormat.value === 'h264') {
                        mimeType = 'video/webm\;codecs=h264';
                        fileExtension = 'mp4';

                        // video/mp4;codecs=avc1
                        if(isMimeTypeSupported('video/mpeg')) {
                          mimeType = 'video/mpeg';
                        }
                      }

                      if(mediaContainerFormat.value === 'mkv' && isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
                        mimeType = 'video/x-matroska;codecs=avc1';
                        fileExtension = 'mkv';
                      }

                      if(mediaContainerFormat.value === 'vp8' && isMimeTypeSupported('video/webm\;codecs=vp8')) {
                        mimeType = 'video/webm\;codecs=vp8';
                        fileExtension = 'webm';
                        recorderType = null;
                        type = 'video';
                      }

                      if(mediaContainerFormat.value === 'vp9' && isMimeTypeSupported('video/webm\;codecs=vp9')) {
                        mimeType = 'video/webm\;codecs=vp9';
                        fileExtension = 'webm';
                        recorderType = null;
                        type = 'video';
                      }

                      if(mediaContainerFormat.value === 'pcm') {
                        mimeType = 'audio/wav';
                        fileExtension = 'wav';
                        recorderType = StereoAudioRecorder;
                        type = 'audio';
                      }

                      if(mediaContainerFormat.value === 'opus' || mediaContainerFormat.value === 'ogg') {
                        if(isMimeTypeSupported('audio/webm')) {
                          mimeType = 'audio/webm';
                          fileExtension = 'webm'; // webm
                        }

                        if(isMimeTypeSupported('audio/ogg')) {
                          mimeType = 'audio/ogg; codecs=opus';
                          fileExtension = 'ogg'; // ogg
                        }

                        recorderType = null;
                        type = 'audio';
                      }

                      if(mediaContainerFormat.value === 'whammy') {
                        mimeType = 'video/webm';
                        fileExtension = 'webm';
                        recorderType = WhammyRecorder;
                        type = 'video';
                      }

                      if(mediaContainerFormat.value === 'gif') {
                        mimeType = 'image/gif';
                        fileExtension = 'gif';
                        recorderType = GifRecorder;
                        type = 'gif';
                      }

                      if(mediaContainerFormat.value === 'default') {
                        mimeType = 'video/webm';
                        fileExtension = 'webm';
                        recorderType = null;
                        type = 'video';
                      }

                      if(recordingMedia.value === 'record-audio') {
                        captureAudio(commonConfig);

                        button.mediaCapturedCallback = function() {
                          var options = {
                            type: type,
                            mimeType: mimeType,
                            leftChannel: params.leftChannel || false,
                            disableLogs: params.disableLogs || false
                          };

                          if(params.sampleRate) {
                            options.sampleRate = parseInt(params.sampleRate);
                          }

                          if(params.bufferSize) {
                            options.bufferSize = parseInt(params.bufferSize);
                          }

                          if(recorderType) {
                            options.recorderType = recorderType;
                          }

                          if(videoBitsPerSecond) {
                            options.videoBitsPerSecond = videoBitsPerSecond;
                          }

                          if(DetectRTC.browser.name === 'Edge') {
                            options.numberOfAudioChannels = 1;
                          }

                          options.ignoreMutedMedia = false;
                          button.recordRTC = RecordRTC(button.stream, options);

                          button.recordingEndedCallback = function(url) {
                            setVideoURL(url);
                          };

                          button.recordRTC.startRecording();
                          btnPauseRecording.style.display = '';
                        };
                      }

                      if(recordingMedia.value === 'record-audio-plus-video') {
                        captureAudioPlusVideo(commonConfig);

                        button.mediaCapturedCallback = function() {
                          if(typeof MediaRecorder === 'undefined') { // opera or chrome etc.
                            button.recordRTC = [];

                            if(!params.bufferSize) {
                              // it fixes audio issues whilst recording 720p
                              params.bufferSize = 16384;
                            }

                            var options = {
                              type: 'audio', // hard-code to set "audio"
                              leftChannel: params.leftChannel || false,
                              disableLogs: params.disableLogs || false,
                              video: recordingPlayer
                            };

                            if(params.sampleRate) {
                              options.sampleRate = parseInt(params.sampleRate);
                            }

                            if(params.bufferSize) {
                              options.bufferSize = parseInt(params.bufferSize);
                            }

                            if(params.frameInterval) {
                              options.frameInterval = parseInt(params.frameInterval);
                            }

                            if(recorderType) {
                              options.recorderType = recorderType;
                            }

                            if(videoBitsPerSecond) {
                              options.videoBitsPerSecond = videoBitsPerSecond;
                            }

                            options.ignoreMutedMedia = false;
                            var audioRecorder = RecordRTC(button.stream, options);

                            options.type = type;
                            var videoRecorder = RecordRTC(button.stream, options);

                            // to sync audio/video playbacks in browser!
                            videoRecorder.initRecorder(function() {
                              audioRecorder.initRecorder(function() {
                                audioRecorder.startRecording();
                                videoRecorder.startRecording();
                                btnPauseRecording.style.display = '';
                              });
                            });

                            button.recordRTC.push(audioRecorder, videoRecorder);

                            button.recordingEndedCallback = function() {
                              var audio = new Audio();
                              audio.src = audioRecorder.toURL();
                              audio.controls = true;
                              audio.autoplay = true;

                              recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                              recordingPlayer.parentNode.appendChild(audio);

                              if(audio.paused) audio.play();
                            };
                            return;
                          }

                          var options = {
                            type: type,
                            mimeType: mimeType,
                            disableLogs: params.disableLogs || false,
                            getNativeBlob: false, // enable it for longer recordings
                            video: recordingPlayer
                          };

                          if(recorderType) {
                            options.recorderType = recorderType;

                            if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                              options.canvas = options.video = {
                                width: defaultWidth || 320,
                                height: defaultHeight || 240
                              };
                            }
                          }

                          if(videoBitsPerSecond) {
                            options.videoBitsPerSecond = videoBitsPerSecond;
                          }

                          if(timeSlice && typeof MediaRecorder !== 'undefined') {
                            options.timeSlice = timeSlice;
                            button.blobs = [];
                            options.ondataavailable = function(blob) {
                              button.blobs.push(blob);
                            };
                          }

                          options.ignoreMutedMedia = false;
                          button.recordRTC = RecordRTC(button.stream, options);

                          button.recordingEndedCallback = function(url) {
                            setVideoURL(url);
                          };

                          button.recordRTC.startRecording();
                          btnPauseRecording.style.display = '';
                          recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = '<img src="https://cdn.webrtc-experiment.com/images/progress.gif">';
                        };
                      }

                      if(recordingMedia.value === 'record-screen') {
                        captureScreen(commonConfig);

                        button.mediaCapturedCallback = function() {
                          var options = {
                            type: type,
                            mimeType: mimeType,
                            disableLogs: params.disableLogs || false,
                            getNativeBlob: false, // enable it for longer recordings
                            video: recordingPlayer
                          };

                          if(recorderType) {
                            options.recorderType = recorderType;

                            if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                              options.canvas = options.video = {
                                width: defaultWidth || 320,
                                height: defaultHeight || 240
                              };
                            }
                          }

                          if(videoBitsPerSecond) {
                            options.videoBitsPerSecond = videoBitsPerSecond;
                          }

                          options.ignoreMutedMedia = false;
                          button.recordRTC = RecordRTC(button.stream, options);

                          button.recordingEndedCallback = function(url) {
                            setVideoURL(url);
                          };

                          button.recordRTC.startRecording();
                          btnPauseRecording.style.display = '';
                        };
                      }

                      // note: audio+tab is supported in Chrome 50+
                      // todo: add audio+tab recording
                      if(recordingMedia.value === 'record-audio-plus-screen') {
                        captureAudioPlusScreen(commonConfig);

                        button.mediaCapturedCallback = function() {
                          var options = {
                            type: type,
                            mimeType: mimeType,
                            disableLogs: params.disableLogs || false,
                            getNativeBlob: false, // enable it for longer recordings
                            video: recordingPlayer
                          };

                          if(recorderType) {
                            options.recorderType = recorderType;

                            if(recorderType == WhammyRecorder || recorderType == GifRecorder) {
                              options.canvas = options.video = {
                                width: defaultWidth || 320,
                                height: defaultHeight || 240
                              };
                            }
                          }

                          if(videoBitsPerSecond) {
                            options.videoBitsPerSecond = videoBitsPerSecond;
                          }

                          options.ignoreMutedMedia = false;
                          button.recordRTC = RecordRTC(button.stream, options);

                          button.recordingEndedCallback = function(url) {
                            setVideoURL(url);
                          };

                          button.recordRTC.startRecording();
                          btnPauseRecording.style.display = '';
                        };
                      }
                    };

                    function captureVideo(config) {
                      captureUserMedia({video: true}, function(videoStream) {
                        config.onMediaCaptured(videoStream);

                        addStreamStopListener(videoStream, function() {
                          config.onMediaStopped();
                        });
                      }, function(error) {
                        config.onMediaCapturingFailed(error);
                      });
                    }

                    function captureAudio(config) {
                      captureUserMedia({audio: true}, function(audioStream) {
                        config.onMediaCaptured(audioStream);

                        addStreamStopListener(audioStream, function() {
                          config.onMediaStopped();
                        });
                      }, function(error) {
                        config.onMediaCapturingFailed(error);
                      });
                    }

                    function captureAudioPlusVideo(config) {
                      captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
                        config.onMediaCaptured(audioVideoStream);

                        if(audioVideoStream instanceof Array) {
                          audioVideoStream.forEach(function(stream) {
                            addStreamStopListener(stream, function() {
                              config.onMediaStopped();
                            });
                          });
                          return;
                        }

                        addStreamStopListener(audioVideoStream, function() {
                          config.onMediaStopped();
                        });
                      }, function(error) {
                        config.onMediaCapturingFailed(error);
                      });
                    }

                    var MY_DOMAIN = 'webrtc-experiment.com';

                    function isMyOwnDomain() {
                      // replace "webrtc-experiment.com" with your own domain name
                      return document.domain.indexOf(MY_DOMAIN) !== -1;
                    }

                    function isLocalHost() {
                      // "chrome.exe" --enable-usermedia-screen-capturing
                      // or firefox => about:config => "media.getusermedia.screensharing.allowed_domains" => add "localhost"
                      return document.domain === 'localhost' || document.domain === '127.0.0.1';
                    }

                    function captureScreen(config) {
                      // Firefox screen capturing addon is open-sourced here: https://github.com/muaz-khan/Firefox-Extensions
                      // Google Chrome screen capturing extension is open-sourced here: https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture

                      window.getScreenId = function(chromeMediaSource, chromeMediaSourceId) {
                        var screenConstraints = {
                          audio: false,
                          video: {
                            mandatory: {
                              chromeMediaSourceId: chromeMediaSourceId,
                              chromeMediaSource: isLocalHost() ? 'screen' : chromeMediaSource
                            }
                          }
                        };

                        if(DetectRTC.browser.name === 'Firefox') {
                          screenConstraints = {
                            video: {
                              mediaSource: 'window'
                            }
                          }
                        }

                        captureUserMedia(screenConstraints, function(screenStream) {
                          config.onMediaCaptured(screenStream);

                          addStreamStopListener(screenStream, function() {
                            // config.onMediaStopped();

                            btnStartRecording.onclick();
                          });
                        }, function(error) {
                          config.onMediaCapturingFailed(error);

                          if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Chrome') {
                            // otherwise deploy chrome extension yourselves
                            // https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture
                            alert('Please enable this command line flag: "--enable-usermedia-screen-capturing"');
                          }

                          if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Firefox') {
                            // otherwise deploy firefox addon yourself
                            // https://github.com/muaz-khan/Firefox-Extensions
                            alert('Please enable screen capturing for your domain. Open "about:config" and search for "media.getusermedia.screensharing.allowed_domains"');
                          }
                        });
                      };

                      if(DetectRTC.browser.name === 'Firefox' || isLocalHost()) {
                        window.getScreenId();
                      }

                      window.postMessage('get-sourceId', '*');
                    }

                    function captureAudioPlusScreen(config) {
                      // Firefox screen capturing addon is open-sourced here: https://github.com/muaz-khan/Firefox-Extensions
                      // Google Chrome screen capturing extension is open-sourced here: https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture

                      window.getScreenId = function(chromeMediaSource, chromeMediaSourceId) {
                        var screenConstraints = {
                          audio: false,
                          video: {
                            mandatory: {
                              chromeMediaSourceId: chromeMediaSourceId,
                              chromeMediaSource: isLocalHost() ? 'screen' : chromeMediaSource
                            }
                          }
                        };

                        if(DetectRTC.browser.name === 'Firefox') {
                          screenConstraints = {
                            video: {
                              mediaSource: 'window'
                            },
                            audio: false
                          }
                        }

                        captureUserMedia(screenConstraints, function(screenStream) {
                          captureUserMedia({audio: true}, function(audioStream) {
                            var newStream = new MediaStream();

                            // merge audio and video tracks in a single stream
                            audioStream.getAudioTracks().forEach(function(track) {
                              newStream.addTrack(track);
                            });

                            screenStream.getVideoTracks().forEach(function(track) {
                              newStream.addTrack(track);
                            });

                            config.onMediaCaptured(newStream);

                            addStreamStopListener(newStream, function() {
                              config.onMediaStopped();
                            });
                          }, function(error) {
                            config.onMediaCapturingFailed(error);
                          });
                        }, function(error) {
                          config.onMediaCapturingFailed(error);

                          if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Chrome') {
                            // otherwise deploy chrome extension yourselves
                            // https://github.com/muaz-khan/Chrome-Extensions/tree/master/desktopCapture
                            alert('Please enable this command line flag: "--enable-usermedia-screen-capturing"');
                          }

                          if(isMyOwnDomain() === false && DetectRTC.browser.name === 'Firefox') {
                            // otherwise deploy firefox addon yourself
                            // https://github.com/muaz-khan/Firefox-Extensions
                            alert('Please enable screen capturing for your domain. Open "about:config" and search for "media.getusermedia.screensharing.allowed_domains"');
                          }
                        });
                      };

                      if(DetectRTC.browser.name === 'Firefox' || isLocalHost()) {
                        window.getScreenId();
                      }

                      window.postMessage('get-sourceId', '*');
                    }

                    var videoBitsPerSecond;

                    function setVideoBitrates() {
                      var select = document.querySelector('.media-bitrates');
                      var value = select.value;

                      if(value == 'default') {
                        videoBitsPerSecond = null;
                        return;
                      }

                      videoBitsPerSecond = parseInt(value);
                    }

                    function getFrameRates(mediaConstraints) {
                      if(!mediaConstraints.video) {
                        return mediaConstraints;
                      }

                      var select = document.querySelector('.media-framerates');
                      var value = select.value;

                      if(value == 'default') {
                        return mediaConstraints;
                      }

                      value = parseInt(value);

                      if(DetectRTC.browser.name === 'Firefox') {
                        mediaConstraints.video.frameRate = value;
                        return mediaConstraints;
                      }

                      if(!mediaConstraints.video.mandatory) {
                        mediaConstraints.video.mandatory = {};
                        mediaConstraints.video.optional = [];
                      }

                      var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;
                      if(isScreen) {
                        mediaConstraints.video.mandatory.maxFrameRate = value;
                      }
                      else {
                        mediaConstraints.video.mandatory.minFrameRate = value;
                      }

                      return mediaConstraints;
                    }

                    function setGetFromLocalStorage(selectors) {
                      selectors.forEach(function(selector) {
                        var storageItem = selector.replace(/\.|#/g, '');
                        if(localStorage.getItem(storageItem)) {
                          document.querySelector(selector).value = localStorage.getItem(storageItem);
                        }

                        addEventListenerToUploadLocalStorageItem(selector, ['change', 'blur'], function() {
                          localStorage.setItem(storageItem, document.querySelector(selector).value);
                        });
                      });
                    }

                    function addEventListenerToUploadLocalStorageItem(selector, arr, callback) {
                      arr.forEach(function(event) {
                        document.querySelector(selector).addEventListener(event, callback, false);
                      });
                    }

                    setGetFromLocalStorage(['.media-resolutions', '.media-framerates', '.media-bitrates', '.recording-media', '.media-container-format']);

                    function getVideoResolutions(mediaConstraints) {
                      if(!mediaConstraints.video) {
                        return mediaConstraints;
                      }

                      var select = document.querySelector('.media-resolutions');
                      var value = select.value;

                      if(value == 'default') {
                        return mediaConstraints;
                      }

                      value = value.split('x');

                      if(value.length != 2) {
                        return mediaConstraints;
                      }

                      defaultWidth = parseInt(value[0]);
                      defaultHeight = parseInt(value[1]);

                      if(DetectRTC.browser.name === 'Firefox') {
                        mediaConstraints.video.width = defaultWidth;
                        mediaConstraints.video.height = defaultHeight;
                        return mediaConstraints;
                      }

                      if(!mediaConstraints.video.mandatory) {
                        mediaConstraints.video.mandatory = {};
                        mediaConstraints.video.optional = [];
                      }

                      var isScreen = recordingMedia.value.toString().toLowerCase().indexOf('screen') != -1;

                      if(isScreen) {
                        mediaConstraints.video.mandatory.maxWidth = defaultWidth;
                        mediaConstraints.video.mandatory.maxHeight = defaultHeight;
                      }
                      else {
                        mediaConstraints.video.mandatory.minWidth = defaultWidth;
                        mediaConstraints.video.mandatory.minHeight = defaultHeight;
                      }

                      return mediaConstraints;
                    }

                    function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                      if(mediaConstraints.video == true) {
                        mediaConstraints.video = {};
                      }

                      setVideoBitrates();

                      mediaConstraints = getVideoResolutions(mediaConstraints);
                      mediaConstraints = getFrameRates(mediaConstraints);

                      var isBlackBerry = !!(/BB10|BlackBerry/i.test(navigator.userAgent || ''));
                      if(isBlackBerry && !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia)) {
                        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                        navigator.getUserMedia(mediaConstraints, successCallback, errorCallback);
                        return;
                      }

                      navigator.mediaDevices.getUserMedia(mediaConstraints).then(function(stream) {
                        successCallback(stream);

                        setVideoURL(stream, true);
                      }).catch(function(error) {
                        if(error && error.name === 'ConstraintNotSatisfiedError') {
                          alert('Your camera or browser does NOT supports selected resolutions or frame-rates. \n\nPlease select "default" resolutions.');
                        }

                        errorCallback(error);
                      });
                    }

                    function setMediaContainerFormat(arrayOfOptionsSupported) {
                      var options = Array.prototype.slice.call(
                          mediaContainerFormat.querySelectorAll('option')
                      );

                      var localStorageItem;
                      if(localStorage.getItem('media-container-format')) {
                        localStorageItem = localStorage.getItem('media-container-format');
                      }

                      var selectedItem;
                      options.forEach(function(option) {
                        option.disabled = true;

                        if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                          option.disabled = false;

                          if(localStorageItem && arrayOfOptionsSupported.indexOf(localStorageItem) != -1) {
                            if(option.value != localStorageItem) return;
                            option.selected = true;
                            selectedItem = option;
                            return;
                          }

                          if(!selectedItem) {
                            option.selected = true;
                            selectedItem = option;
                          }
                        }
                      });
                    }

                    function isMimeTypeSupported(mimeType) {
                      if(DetectRTC.browser.name === 'Edge' || DetectRTC.browser.name === 'Safari' || typeof MediaRecorder === 'undefined') {
                        return false;
                      }

                      if(typeof MediaRecorder.isTypeSupported !== 'function') {
                        return true;
                      }

                      return MediaRecorder.isTypeSupported(mimeType);
                    }

                    recordingMedia.onchange = function() {
                      if(recordingMedia.value === 'record-audio') {
                        var recordingOptions = [];

                        if(isMimeTypeSupported('audio/webm')) {
                          recordingOptions.push('opus');
                        }

                        if(isMimeTypeSupported('audio/ogg')) {
                          recordingOptions.push('ogg');
                        }

                        recordingOptions.push('pcm');

                        setMediaContainerFormat(recordingOptions);
                        return;
                      }

                      var isChrome = !!window.chrome && !(!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0);

                      var recordingOptions = ['vp8']; // MediaStreamRecorder with vp8

                      if(isMimeTypeSupported('video/webm\;codecs=vp9')) {
                        recordingOptions.push('vp9'); // MediaStreamRecorder with vp9
                      }

                      if(isMimeTypeSupported('video/webm\;codecs=h264')) {
                        recordingOptions.push('h264'); // MediaStreamRecorder with h264
                      }

                      if(isMimeTypeSupported('video/x-matroska;codecs=avc1')) {
                        recordingOptions.push('mkv'); // MediaStreamRecorder with mkv/matroska
                      }

                      recordingOptions.push('gif'); // GifRecorder

                      if(isChrome) {
                        recordingOptions.push('whammy'); // WhammyRecorder
                      }

                      recordingOptions.push('default'); // Default mimeType for MediaStreamRecorder

                      setMediaContainerFormat(recordingOptions);
                    };
                    recordingMedia.onchange();

                    if(DetectRTC.browser.name === 'Edge' || DetectRTC.browser.name === 'Safari') {
                      // webp isn't supported in Microsoft Edge
                      // neither MediaRecorder API
                      // so lets disable both video/screen recording options

                      console.warn('Neither MediaRecorder API nor webp is supported in ' + DetectRTC.browser.name + '. You cam merely record audio.');

                      recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
                      setMediaContainerFormat(['pcm']);
                    }

                    function stringify(obj) {
                      var result = '';
                      Object.keys(obj).forEach(function(key) {
                        if(typeof obj[key] === 'function') {
                          return;
                        }

                        if(result.length) {
                          result += ',';
                        }

                        result += key + ': ' + obj[key];
                      });

                      return result;
                    }

                    function mediaRecorderToStringify(mediaRecorder) {
                      var result = '';
                      result += 'mimeType: ' + mediaRecorder.mimeType;
                      result += ', state: ' + mediaRecorder.state;
                      result += ', audioBitsPerSecond: ' + mediaRecorder.audioBitsPerSecond;
                      result += ', videoBitsPerSecond: ' + mediaRecorder.videoBitsPerSecond;
                      if(mediaRecorder.stream) {
                        result += ', streamid: ' + mediaRecorder.stream.id;
                        result += ', stream-active: ' + mediaRecorder.stream.active;
                      }
                      return result;
                    }

                    function getFailureReport() {
                      var info = 'RecordRTC seems failed. \n\n' + stringify(DetectRTC.browser) + '\n\n' + DetectRTC.osName + ' ' + DetectRTC.osVersion + '\n';

                      if (typeof recorderType !== 'undefined' && recorderType) {
                        info += '\nrecorderType: ' + recorderType.name;
                      }

                      if (typeof mimeType !== 'undefined') {
                        info += '\nmimeType: ' + mimeType;
                      }

                      Array.prototype.slice.call(document.querySelectorAll('select')).forEach(function(select) {
                        info += '\n' + (select.id || select.className) + ': ' + select.value;
                      });

                      if (btnStartRecording.recordRTC) {
                        info += '\n\ninternal-recorder: ' + btnStartRecording.recordRTC.getInternalRecorder().name;

                        if(btnStartRecording.recordRTC.getInternalRecorder().getAllStates) {
                          info += '\n\nrecorder-states: ' + btnStartRecording.recordRTC.getInternalRecorder().getAllStates();
                        }
                      }

                      if(btnStartRecording.stream) {
                        info += '\n\naudio-tracks: ' + btnStartRecording.stream.getAudioTracks().length;
                        info += '\nvideo-tracks: ' + btnStartRecording.stream.getVideoTracks().length;
                        info += '\nstream-active? ' + !!btnStartRecording.stream.active;

                        btnStartRecording.stream.getAudioTracks().concat(btnStartRecording.stream.getVideoTracks()).forEach(function(track) {
                          info += '\n' + track.kind + '-track-' + (track.label || track.id) + ': (enabled: ' + !!track.enabled + ', readyState: ' + track.readyState + ', muted: ' + !!track.muted + ')';

                          if(track.getConstraints && Object.keys(track.getConstraints()).length) {
                            info += '\n' + track.kind + '-track-getConstraints: ' + stringify(track.getConstraints());
                          }

                          if(track.getSettings && Object.keys(track.getSettings()).length) {
                            info += '\n' + track.kind + '-track-getSettings: ' + stringify(track.getSettings());
                          }
                        });
                      }

                      if(timeSlice && btnStartRecording.recordRTC) {
                        info += '\ntimeSlice: ' + timeSlice;

                        if(btnStartRecording.recordRTC.getInternalRecorder().getArrayOfBlobs) {
                          var blobSizes = [];
                          btnStartRecording.recordRTC.getInternalRecorder().getArrayOfBlobs().forEach(function(blob) {
                            blobSizes.push(blob.size);
                          });
                          info += '\nblobSizes: ' + blobSizes;
                        }
                      }

                      else if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getBlob()) {
                        info += '\n\nblobSize: ' + bytesToSize(btnStartRecording.recordRTC.getBlob().size);
                      }

                      if(btnStartRecording.recordRTC && btnStartRecording.recordRTC.getInternalRecorder() && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder && btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder()) {
                        info += '\n\ngetInternalRecorder: ' + mediaRecorderToStringify(btnStartRecording.recordRTC.getInternalRecorder().getInternalRecorder());
                      }

                      return info;
                    }

                    function saveToDiskOrOpenNewTab(recordRTC) {
                      if(!recordRTC.getBlob().size) {
                        var info = getFailureReport();
                        console.log('blob', recordRTC.getBlob());
                        console.log('recordrtc instance', recordRTC);
                        console.log('report', info);

                        if(mediaContainerFormat.value !== 'default') {
                          alert('RecordRTC seems failed recording using ' + mediaContainerFormat.value + '. Please choose "default" option from the drop down and record again.');
                        }
                        else {
                          alert('RecordRTC seems failed. Unexpected issue. You can read the email in your console log. \n\nPlease report using disqus chat below.');
                        }

                        if(mediaContainerFormat.value !== 'vp9' && DetectRTC.browser.name === 'Chrome') {
                          alert('Please record using VP9 encoder. (select from the dropdown)');
                        }
                      }

                      var fileName = getFileName(fileExtension);

                      document.querySelector('#save-to-disk').parentNode.style.display = 'block';
                      document.querySelector('#save-to-disk').onclick = function() {
                        if(!recordRTC) return alert('No recording found.');

                        var file = new File([recordRTC.getBlob()], fileName, {
                          type: mimeType
                        });

                        invokeSaveAsDialog(file, file.name);
                      };

                      document.querySelector('#open-new-tab').onclick = function() {
                        if(!recordRTC) return alert('No recording found.');

                        var file = new File([recordRTC.getBlob()], fileName, {
                          type: mimeType
                        });

                        window.open(URL.createObjectURL(file));
                      };

                      // upload to PHP server
                      document.querySelector('#upload-to-php').disabled = false;
                      document.querySelector('#upload-to-php').onclick = function() {
                        if(!recordRTC) return alert('No recording found.');
                        this.disabled = true;

                        var button = this;
                        uploadToPHPServer(fileName, recordRTC, function(progress, fileURL) {
                          if(progress === 'ended') {
                            button.disabled = false;
                            button.innerHTML = '';
                            button.onclick = function() {
                              SaveFileURLToDisk(fileURL, fileName);
                            };

                            setVideoURL(fileURL);

                            var html = '';
                            html += '<a href="'+fileURL+'" download="'+fileName+'" style="display:none; color: yellow; display: block; margin-top: 15px;">'+fileName+'</a>';
                            recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = html;
                            return;
                          }
                          button.innerHTML = progress;
                          recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = progress;
                        });
                      };

                      // upload to YouTube!
                      document.querySelector('#upload-to-youtube').disabled = false;
                      document.querySelector('#upload-to-youtube').onclick = function() {
                        if(!recordRTC) return alert('No recording found.');
                        this.disabled = true;

                        if(isLocalHost()) {
                          alert('This feature is NOT available on localhost.');
                          return;
                        }

                        if(isMyOwnDomain() === false) {
                          var url = 'https://github.com/muaz-khan/RecordRTC/wiki/Upload-to-YouTube';
                          alert('YouTube API key is configured to work only on webrtc-experiment.com. Please create your own YouTube key + oAuth client-id and use it instead.\n\nWiki page: ' + url);

                          // check instructions on the wiki page
                          location.href = url;
                          return;
                        }

                        var button = this;
                        uploadToYouTube(fileName, recordRTC, function(percentageComplete, fileURL) {
                          if(percentageComplete == 'uploaded') {
                            button.disabled = false;
                            button.innerHTML = 'Uploaded. However YouTube is still processing.';
                            button.onclick = function() {
                              window.open(fileURL);
                            };
                            return;
                          }
                          if(percentageComplete == 'processed') {
                            button.disabled = false;
                            button.innerHTML = 'Uploaded & Processed. Click to open YouTube video.';
                            button.onclick = function() {
                              window.open(fileURL);
                            };

                            document.querySelector('h1').innerHTML = 'Your video has been uploaded. Default privacy type is <span>private</span>. Please visit <a href="https://www.youtube.com/my_videos?o=U" target="_blank">youtube.com/my_videos</a> to change privacy to <span>public</span>.';
                            window.scrollTo(0, 0);

                            alert('Your video has been uploaded. Default privacy type is "private". Please visit "youtube.com/my_videos" to change privacy to "public".');
                            return;
                          }
                          if(percentageComplete == 'failed') {
                            button.disabled = false;
                            button.innerHTML = 'YouTube failed transcoding the video.';
                            button.onclick = function() {
                              window.open(fileURL);
                            };
                            return;
                          }
                          button.innerHTML = percentageComplete + '% uploaded to YouTube.';
                        });
                      };
                    }

                    function uploadToPHPServer(fileName, recordRTC, callback) {
                      var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.getBlob();

                      blob = new File([blob], getFileName(fileExtension), {
                        type: mimeType
                      });

                      // create FormData
                      var formData = new FormData();
                      formData.append('video-filename', fileName);
                      formData.append('video-blob', blob);

                      callback('Uploading recorded-file to server.');

                      makeXMLHttpRequest('<?php echo base_url(); ?>userrecording', formData, function(progress) {
                        if (progress !== 'upload-ended') {
                          callback(progress);
                          return;
                        }

                        var initialURL = '<?php echo base_url(); ?>uploads/borrowervideo/';

                        callback('ended', initialURL + fileName);
                      });
                    }

                    function makeXMLHttpRequest(url, data, callback) {
                      var request = new XMLHttpRequest();
                      request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                          if(request.responseText === 'success') {
                            callback('upload-ended');
                            return;
                          }

                          document.querySelector('.header').parentNode.style = 'text-align: left; color: red; padding: 5px 10px;';
                          document.querySelector('.header').parentNode.innerHTML = request.responseText;
                        }
                      };

                      request.upload.onloadstart = function() {
                        callback('Upload started...');
                      };

                      request.upload.onprogress = function(event) {
                        callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
                      };

                      request.upload.onload = function() {
                        callback('progress-about-to-end');
                      };

                      request.upload.onload = function() {
                        callback('Getting File URL..');
                      };

                      request.upload.onerror = function(error) {
                        callback('Failed to upload to server');
                      };

                      request.upload.onabort = function(error) {
                        callback('Upload aborted.');
                      };

                      request.open('POST', url);
                      request.send(data);
                    }

                    function getRandomString() {
                      if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
                        var a = window.crypto.getRandomValues(new Uint32Array(3)),
                            token = '';
                        for (var i = 0, l = a.length; i < l; i++) {
                          token += a[i].toString(36);
                        }
                        return token;
                      } else {
                        return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
                      }
                    }

                    function getFileName(fileExtension) {
                      var d = new Date();
                      var year = d.getUTCFullYear();
                      var month = d.getUTCMonth();
                      var date = d.getUTCDate();
                      return '<?php echo $borrower_id; ?>' + '-' + getRandomString() + '.' + fileExtension;
                    }

                    function SaveFileURLToDisk(fileUrl, fileName) {
                      var hyperlink = document.createElement('a');
                      hyperlink.href = fileUrl;
                      hyperlink.target = '_blank';
                      hyperlink.download = fileName || fileUrl;

                      (document.body || document.documentElement).appendChild(hyperlink);
                      hyperlink.onclick = function() {
                        (document.body || document.documentElement).removeChild(hyperlink);

                        // required for Firefox
                        window.URL.revokeObjectURL(hyperlink.href);
                      };

                      var mouseEvent = new MouseEvent('click', {
                        view: window,
                        bubbles: true,
                        cancelable: true
                      });

                      hyperlink.dispatchEvent(mouseEvent);
                    }

                    function getURL(arg) {
                      var url = arg;

                      if(arg instanceof Blob || arg instanceof File) {
                        url = URL.createObjectURL(arg);
                      }

                      if(arg instanceof RecordRTC || arg.getBlob) {
                        url = URL.createObjectURL(arg.getBlob());
                      }

                      if(arg instanceof MediaStream || arg.getTracks || arg.getVideoTracks || arg.getAudioTracks) {
                        // url = URL.createObjectURL(arg);
                      }

                      return url;
                    }

                    function setVideoURL(arg, forceNonImage) {
                      var url = getURL(arg);

                      var parentNode = recordingPlayer.parentNode;
                      parentNode.removeChild(recordingPlayer);
                      parentNode.innerHTML = '';

                      var elem = 'video';
                      if(type == 'gif' && !forceNonImage) {
                        elem = 'img';
                      }
                      if(type == 'audio') {
                        elem = 'audio';
                      }

                      recordingPlayer = document.createElement(elem);

                      if(arg instanceof MediaStream) {
                        recordingPlayer.muted = true;
                      }

                      recordingPlayer.addEventListener('loadedmetadata', function() {
                        if(navigator.userAgent.toLowerCase().indexOf('android') == -1) return;

                        // android
                        setTimeout(function() {
                          if(typeof recordingPlayer.play === 'function') {
                            recordingPlayer.play();
                          }
                        }, 2000);
                      }, false);

                      recordingPlayer.poster = '';

                      if(arg instanceof MediaStream) {
                        recordingPlayer.srcObject = arg;
                      }
                      else {
                        recordingPlayer.src = url;
                      }

                      if(typeof recordingPlayer.play === 'function') {
                        recordingPlayer.play();
                      }

                      recordingPlayer.addEventListener('ended', function() {
                        url = getURL(arg);

                        if(arg instanceof MediaStream) {
                          recordingPlayer.srcObject = arg;
                        }
                        else {
                          recordingPlayer.src = url;
                        }
                      });

                      parentNode.appendChild(recordingPlayer);
                    }
                  </script>

                  <script>
                    /* upload_youtube_video.js Copyright 2017 Google Inc. All Rights Reserved. */

                    function uploadToYouTube(fileName, recordRTC, callback) {
                      var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.getBlob();

                      blob = new File([blob], getFileName(fileExtension), {
                        type: mimeType
                      });

                      if(!uploadVideo) {
                        alert('YouTube API are not available.');
                        return;
                      }

                      uploadVideo.callback = callback;
                      uploadVideo.uploadFile(fileName, blob);
                    }

                    var uploadVideo;

                    var signinCallback = function (result){
                      if(result.access_token) {
                        uploadVideo = new UploadVideo();
                        uploadVideo.ready(result.access_token);

                        document.querySelector('#signinButton').style.display = 'none';
                      }
                      else {
                        // console.error('YouTube error', result);
                        // document.querySelector('#upload-to-youtube').style.display = 'none';
                      }
                    };

                    var STATUS_POLLING_INTERVAL_MILLIS = 60 * 1000; // One minute.

                    var UploadVideo = function() {
                      this.tags = ['recordrtc'];
                      this.categoryId = 28; // via: http://stackoverflow.com/a/35877512/552182
                      this.videoId = '';
                      this.uploadStartTime = 0;
                    };


                    UploadVideo.prototype.ready = function(accessToken) {
                      this.accessToken = accessToken;
                      this.gapi = gapi;
                      this.authenticated = true;
                      false && this.gapi.client.request({
                        path: '/youtube/v3/channels',
                        params: {
                          part: 'snippet',
                          mine: true
                        },
                        callback: function(response) {
                          if (!response.error) {
                            // response.items[0].snippet.title -- channel title
                            // response.items[0].snippet.thumbnails.default.url -- channel thumbnail
                          }
                        }.bind(this)
                      });
                    };

                    UploadVideo.prototype.uploadFile = function(fileName, file) {
                      var metadata = {
                        snippet: {
                          title: fileName,
                          description: fileName,
                          tags: this.tags,
                          categoryId: this.categoryId
                        },
                        status: {
                          privacyStatus: 'private'
                        }
                      };
                      var uploader = new MediaUploader({
                        baseUrl: 'https://www.googleapis.com/upload/youtube/v3/videos',
                        file: file,
                        token: this.accessToken,
                        metadata: metadata,
                        params: {
                          part: Object.keys(metadata).join(',')
                        },
                        onError: function(data) {
                          var message = data;
                          try {
                            var errorResponse = JSON.parse(data);
                            message = errorResponse.error.message;
                          } finally {
                            alert(message);
                          }
                        }.bind(this),
                        onProgress: function(data) {
                          var bytesUploaded = data.loaded;
                          var totalBytes = parseInt(data.total);
                          var percentageComplete = parseInt((bytesUploaded * 100) / totalBytes);

                          uploadVideo.callback(percentageComplete);
                        }.bind(this),
                        onComplete: function(data) {
                          var uploadResponse = JSON.parse(data);
                          this.videoId = uploadResponse.id;
                          this.videoURL = 'https://www.youtube.com/watch?v=' + this.videoId;
                          uploadVideo.callback('uploaded', this.videoURL);

                          setTimeout(this.pollForVideoStatus, 2000);
                        }.bind(this)
                      });
                      this.uploadStartTime = Date.now();
                      uploader.upload();
                    };

                    UploadVideo.prototype.pollForVideoStatus = function() {
                      this.gapi.client.request({
                        path: '/youtube/v3/videos',
                        params: {
                          part: 'status,player',
                          id: this.videoId
                        },
                        callback: function(response) {
                          if (response.error) {
                            uploadVideo.pollForVideoStatus();
                          } else {
                            var uploadStatus = response.items[0].status.uploadStatus;
                            switch (uploadStatus) {
                              case 'uploaded':
                                uploadVideo.callback('uploaded', uploadVideo.videoURL);
                                uploadVideo.pollForVideoStatus();
                                break;
                              case 'processed':
                                uploadVideo.callback('processed', uploadVideo.videoURL);
                                break;
                              default:
                                uploadVideo.callback('failed', uploadVideo.videoURL);
                                break;
                            }
                          }
                        }.bind(this)
                      });
                    };

                  </script>

                  <script>
                    /* cors_upload.js Copyright 2015 Google Inc. All Rights Reserved. */

                    var DRIVE_UPLOAD_URL = 'https://www.googleapis.com/upload/drive/v2/files/';

                    var RetryHandler = function() {
                      this.interval = 1000; // Start at one second
                      this.maxInterval = 60 * 1000; // Don't wait longer than a minute
                    };

                    RetryHandler.prototype.retry = function(fn) {
                      setTimeout(fn, this.interval);
                      this.interval = this.nextInterval_();
                    };

                    RetryHandler.prototype.reset = function() {
                      this.interval = 1000;
                    };

                    RetryHandler.prototype.nextInterval_ = function() {
                      var interval = this.interval * 2 + this.getRandomInt_(0, 1000);
                      return Math.min(interval, this.maxInterval);
                    };

                    RetryHandler.prototype.getRandomInt_ = function(min, max) {
                      return Math.floor(Math.random() * (max - min + 1) + min);
                    };

                    var MediaUploader = function(options) {
                      var noop = function() {};
                      this.file = options.file;
                      this.contentType = options.contentType || this.file.type || 'application/octet-stream';
                      this.metadata = options.metadata || {
                            'title': this.file.name,
                            'mimeType': this.contentType
                          };
                      this.token = options.token;
                      this.onComplete = options.onComplete || noop;
                      this.onProgress = options.onProgress || noop;
                      this.onError = options.onError || noop;
                      this.offset = options.offset || 0;
                      this.chunkSize = options.chunkSize || 0;
                      this.retryHandler = new RetryHandler();

                      this.url = options.url;
                      if (!this.url) {
                        var params = options.params || {};
                        params.uploadType = 'resumable';
                        this.url = this.buildUrl_(options.fileId, params, options.baseUrl);
                      }
                      this.httpMethod = options.fileId ? 'PUT' : 'POST';
                    };

                    MediaUploader.prototype.upload = function() {
                      var self = this;
                      var xhr = new XMLHttpRequest();

                      xhr.open(this.httpMethod, this.url, true);
                      xhr.setRequestHeader('Authorization', 'Bearer ' + this.token);
                      xhr.setRequestHeader('Content-Type', 'application/json');
                      xhr.setRequestHeader('X-Upload-Content-Length', this.file.size);
                      xhr.setRequestHeader('X-Upload-Content-Type', this.contentType);

                      xhr.onload = function(e) {
                        if (e.target.status < 400) {
                          var location = e.target.getResponseHeader('Location');
                          this.url = location;
                          this.sendFile_();
                        } else {
                          this.onUploadError_(e);
                        }
                      }.bind(this);
                      xhr.onerror = this.onUploadError_.bind(this);
                      xhr.send(JSON.stringify(this.metadata));
                    };

                    MediaUploader.prototype.sendFile_ = function() {
                      var content = this.file;
                      var end = this.file.size;

                      if (this.offset || this.chunkSize) {
                        // Only bother to slice the file if we're either resuming or uploading in chunks
                        if (this.chunkSize) {
                          end = Math.min(this.offset + this.chunkSize, this.file.size);
                        }
                        content = content.slice(this.offset, end);
                      }

                      var xhr = new XMLHttpRequest();
                      xhr.open('PUT', this.url, true);
                      xhr.setRequestHeader('Content-Type', this.contentType);
                      xhr.setRequestHeader('Content-Range', 'bytes ' + this.offset + '-' + (end - 1) + '/' + this.file.size);
                      xhr.setRequestHeader('X-Upload-Content-Type', this.file.type);
                      if (xhr.upload) {
                        xhr.upload.addEventListener('progress', this.onProgress);
                      }
                      xhr.onload = this.onContentUploadSuccess_.bind(this);
                      xhr.onerror = this.onContentUploadError_.bind(this);
                      xhr.send(content);
                    };

                    MediaUploader.prototype.resume_ = function() {
                      var xhr = new XMLHttpRequest();
                      xhr.open('PUT', this.url, true);
                      xhr.setRequestHeader('Content-Range', 'bytes */' + this.file.size);
                      xhr.setRequestHeader('X-Upload-Content-Type', this.file.type);
                      if (xhr.upload) {
                        xhr.upload.addEventListener('progress', this.onProgress);
                      }
                      xhr.onload = this.onContentUploadSuccess_.bind(this);
                      xhr.onerror = this.onContentUploadError_.bind(this);
                      xhr.send();
                    };

                    MediaUploader.prototype.extractRange_ = function(xhr) {
                      var range = xhr.getResponseHeader('Range');
                      if (range) {
                        this.offset = parseInt(range.match(/\d+/g).pop(), 10) + 1;
                      }
                    };

                    MediaUploader.prototype.onContentUploadSuccess_ = function(e) {
                      if (e.target.status == 200 || e.target.status == 201) {
                        this.onComplete(e.target.response);
                      } else if (e.target.status == 308) {
                        this.extractRange_(e.target);
                        this.retryHandler.reset();
                        this.sendFile_();
                      }
                    };

                    MediaUploader.prototype.onContentUploadError_ = function(e) {
                      if (e.target.status && e.target.status < 500) {
                        this.onError(e.target.response);
                      } else {
                        this.retryHandler.retry(this.resume_.bind(this));
                      }
                    };

                    MediaUploader.prototype.onUploadError_ = function(e) {
                      this.onError(e.target.response); // TODO - Retries for initial upload
                    };

                    MediaUploader.prototype.buildQuery_ = function(params) {
                      params = params || {};
                      return Object.keys(params).map(function(key) {
                        return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
                      }).join('&');
                    };

                    MediaUploader.prototype.buildUrl_ = function(id, params, baseUrl) {
                      var url = baseUrl || DRIVE_UPLOAD_URL;
                      if (id) {
                        url += id;
                      }
                      var query = this.buildQuery_(params);
                      if (query) {
                        url += '?' + query;
                      }
                      return url;
                    };
                  </script>

                  <script>
                    var chkTimeSlice = document.querySelector('#chk-timeSlice');
                    var timeSlice = false;

                    if(typeof MediaRecorder === 'undefined') {
                      chkTimeSlice.disabled = true;
                    }

                    chkTimeSlice.addEventListener('change', function() {
                      if(chkTimeSlice.checked === true) {
                        var _timeSlice = prompt('Please enter timeSlice in milliseconds e.g. 1000 or 2000 or 3000.', 1000);
                        _timeSlice = parseInt(_timeSlice);
                        if(!_timeSlice || _timeSlice == NaN || typeof _timeSlice === 'undefined') {
                          timeSlice = false;
                          return;
                        }

                        timeSlice = _timeSlice;
                      }
                      else {
                        timeSlice = false;
                      }
                    }, false);
                  </script>

                  <script>
                    var btnPauseRecording = document.querySelector('#btn-pause-recording');
                    btnPauseRecording.onclick = function() {
                      if(!btnStartRecording.recordRTC) {
                        btnPauseRecording.style.display = 'none';
                        return;
                      }

                      btnPauseRecording.disabled = true;
                      if(btnPauseRecording.innerHTML === 'Pause') {
                        btnStartRecording.disabled = true;
                        btnStartRecording.style.fontSize = '15px';
                        btnStartRecording.recordRTC.pauseRecording();
                        recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = 'Recording status: paused';
                        recordingPlayer.pause();

                        btnPauseRecording.style.fontSize = 'inherit';
                        setTimeout(function() {
                          btnPauseRecording.innerHTML = 'Resume Recording';
                          btnPauseRecording.disabled = false;
                        }, 2000);
                      }

                      if(btnPauseRecording.innerHTML === 'Resume Recording') {
                        btnStartRecording.disabled = false;
                        btnStartRecording.style.fontSize = 'inherit';
                        btnStartRecording.recordRTC.resumeRecording();
                        recordingPlayer.parentNode.parentNode.querySelector('h2').innerHTML = '<img src="https://cdn.webrtc-experiment.com/images/progress.gif">';
                        recordingPlayer.play();

                        btnPauseRecording.style.fontSize = '15px';
                        btnPauseRecording.innerHTML = 'Pause';
                        setTimeout(function() {
                          btnPauseRecording.disabled = false;
                        }, 2000);
                      }
                    };
                  </script>
                  <?php } ?>
                 </div >

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.tab-content-box -->

</div>
<div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
</div>


<script>
    function gotoprofile(){
        //$.when( $('.sec-navbar #nav-tabs-menu a[href="#profiletab1"]').trigger('click') ).done( function(x){
        //    $('#profiletab1 ul.left-nav a[href="#proedittab3"]').trigger('click');
        //});
        $('.sec-navbar #nav-tabs-menu a[href="#profiletab1"]').trigger('click')
        $('#profiletab1 ul.left-nav a[href="#proedittab3"]').trigger('click');
    }
$(document).ready(function() {
       var i=0;
    $(".upload-mfile-btn").click(function() {
		i=i+1;
        var domElement = $('<div class="col-md-6 col-sm-4"><div class="form-group"><input class="form-control" type="text" name="doc_name[]" placeholder="Enter Document Name"/><input class="form-control" type="file" name="doc_file[]"/></div></div></div>');
        $('.upload-mfile').before(domElement);
    });



});

$(document).ready(function(){
    $(document).on('click','.show_more',function(){
        var ID = $(this).attr('id');
        $('.show_more').hide();
        $('.loding').show();
        $.ajax({
            type:'POST',
            url:'<?=base_url();?>home/notification_more/',
            data:'id='+ID,
            success:function(html){
                $('#show_more_main'+ID).remove();
                $('.tutorial_list').append(html);
            }
        });
    });




});
</script>
<? if($track_info){?>
<script>
    $('#profiletab1').removeClass('in active');
    $('#profiletab4').addClass('in active');

	 $('.nav-tabs li').removeClass('active');
    $('#track-class').addClass('active');
    </script>
<? 	if($track_info=="0")
    {?>
<script>
		$('#skills').removeClass('activetrack');
		$('#proposal-listed').addClass('activetrack');
        </script>
<? }	if($track_info==1)
    {?>
<script>
		$('#proposal-listed').addClass('activetrack');
		$('#bid-open').addClass('activetrack');
        </script>
<? }
	if($track_info==3)
    {?>
<script>
		$('#proposal-listed').addClass('activetrack');
		$('#bid-open').addClass('activetrack');
        $('#loan-approved').addClass('activetrack');
        </script>
<? }
}?>
<script>
$("#r_state").change(function()
{
   // console.log("getting city");
	var $selectDropdown =
      $("#r_city")
        .empty()
        .html(' ');
	$selectDropdown.append(
	  $("<option></option>")
		.attr("value","")
		.text("Select City")
	);
	var slc=$('#r_state').val();
	if(slc)
	{
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>home/city_list_statewise/",
			dataType: "html",
			data: "state="+slc,
			async: false,
			success: function (data) {
				window.value=data;
			}
		});

		var dd = (window.value).split(",");

		for (i = 0; i < dd.length; i++) {
			$selectDropdown.append(
			  $("<option></option>")
				.attr("value",dd[i])
				.text(dd[i])
			);
		}
	}
   	 	$selectDropdown.trigger('contentChanged');
});

function get_office_city()
{
	var $selectDropdown =
      $("#o_city")
        .empty()
        .html(' ');
	$selectDropdown.append(
	  $("<option></option>")
		.attr("value","")
		.text("Select City")
	);
	var slc=$('#o_state').val();
	if(slc)
	{
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>home/city_list_statewise/",
			dataType: "html",
			data: "state="+slc,
			async: false,
			success: function (data) {
				window.value=data;
			}
		});

		var dd = (window.value).split(",");

		for (i = 0; i < dd.length; i++) {
			$selectDropdown.append(
			  $("<option></option>")
				.attr("value",dd[i])
				.text(dd[i])
			);
		}
	}
   	 	$selectDropdown.trigger('contentChanged');
}


	<? if($userdetails['occupation']==0)
	{?>
		$("#oocup1,#oocup2,#oocup3,#oocup4,#oocup5").hide();
	<? }
	else if($userdetails['occupation']==1)
	{?>
		$("#oocup1").show();
		$("#oocup2,#oocup3,#oocup4,#oocup5").hide();
	<? }
	else if($userdetails['occupation'] == 2)
	{?>
		$("#oocup2").show();
		$("#oocup1,#oocup3,#oocup4,#oocup5").hide();
	<? }
	else if($userdetails['occupation'] == 3)
	{?>
		$("#oocup3").show();
		$("#oocup2,#oocup1,#oocup4,#oocup5").hide();
	<? }
	else if($userdetails['occupation'] == 4)
	{?>
		$("#oocup4").show();
		$("#oocup2,#oocup3,#oocup1,#oocup5").hide();
	<? }
	else if($userdetails['occupation'] == 5)
	{?>
		$("#oocup5").show();
		$("#oocup2,#oocup3,#oocup4,#oocup1").hide();
	<? }
	else if($userdetails['occupation'] == 6)
	{?>
		$("#oocup1,#oocup2,#oocup3,#oocup4,#oocup5").hide();
	<? }?>
function occupation_value()
{
	var occupation = $("#occupation").val();
	if(occupation == 1)
	{
		$("#oocup1").show();
		$("#oocup2").hide();
		$("#oocup3").hide();
		$("#oocup4").hide();
		$("#oocup5").hide();
	}
	else if(occupation == 2)
	{
		$("#oocup1").hide();
		$("#oocup2").show();
		$("#oocup3").hide();
		$("#oocup4").hide();
		$("#oocup5").hide();
	}
	else if(occupation == 3)
	{
		$("#oocup1").hide();
		$("#oocup2").hide();
		$("#oocup3").show();
		$("#oocup4").hide();
		$("#oocup5").hide();
	}
	else if(occupation == 4)
	{
		$("#oocup1").hide();
		$("#oocup2").hide();
		$("#oocup3").hide();
		$("#oocup4").show();
		$("#oocup5").hide();
	}
	else if(occupation == 5)
	{
		$("#oocup1").hide();
		$("#oocup2").hide();
		$("#oocup3").hide();
		$("#oocup4").hide();
		$("#oocup5").show();
	}
	else if(occupation == 6)
	{
		$("#oocup1").hide();
		$("#oocup2").hide();
		$("#oocup3").hide();
		$("#oocup4").hide();
		$("#oocup5").hide();
	}
	else
	{
		$("#oocup1").hide();
		$("#oocup2").hide();
		$("#oocup3").hide();
		$("#oocup4").hide();
		$("#oocup5").hide();
	}
}
function get_collateral_details()
{
	if(($("#collateral_flag").val())=="Yes")
	{
		$("#collateral_details_div").show();
	}
	else if(($("#collateral_flag").val())=="No")
	{
		$("#collateral_details_div").hide();
	}
}


function showResult1(str) {

	if (str.length==0) {
		$("#livesearch1").hide();
		return;
	}

	$.ajax({
		type: "POST",
		url: "<?=base_url();?>home/livesearch1/",
		dataType: "html",
		data: "q="+str,
		async: false,
		success: function (data) {
			$("#livesearch1").html(data);
			$("#livesearch1").show();
		}
	});
}

function livesearchbox1(str)
{
	$("#company_name1").val($('#ls1'+str).html());
	$("#livesearch1").hide();
	//showResult($('#ls'+str).html());
}

function showResult4(str) {

	if (str.length==0) {
		$("#livesearch4").hide();
		return;
	}

	$.ajax({
		type: "POST",
		url: "<?=base_url();?>home/livesearch4/",
		dataType: "html",
		data: "q="+str,
		async: false,
		success: function (data) {
			$("#livesearch4").html(data);
			$("#livesearch4").show();
		}
	});
}

function livesearchbox4(str)
{
	$("#company_name4").val($('#ls4'+str).html());
	$("#livesearch4").hide();
	//showResult($('#ls'+str).html());
}

</script>

<style>
#livesearch, #livesearch1, #livesearch4 {
margin: -20px 0 auto;
}
#livesearch ul, #livesearch1 ul, #livesearch4 ul {
padding: 0 5px;
margin: 0;
border: 1px solid rgb(165, 172, 178);
}
#livesearch ul li, #livesearch1 ul li, #livesearch4 ul li {
padding: 0;
list-style: none;
margin: 0;
}
#livesearch ul li:hover, #livesearch1 ul li:hover, #livesearch4 ul li:hover
{
background: #e9bebe;
}

#ui-datepicker-div{ background-color:#fff !important}



</style>




<script>
$(document).ready(
  function () {
    $( "#datepicker1" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      dateFormat: 'yy-mm-dd',
      yearRange: '1970:<?=(date('Y')-17);?>',
      onSelect: function(dateText) {
    //display("Selected date: " + dateText + "; input's current value: " + this.value);
    nextentry('birthday'); // lanuch next event by autusubmit
  }

    });
  }
);


// Auto Slide after date of Birth

// Change Mbile number with OTP
$('#mobilechange').click(function(){
    //alert("Are you sure ?");
    $("#mobile").hide();
    $("#newmobile").show();
    $("#mobileotpsendbutton").show();
    $("#mobilechange").hide();
});


// Send OTP Button
$("#mobileotpsendbutton").click(function(){
    alert("Are you sure to send OTP?")
  var mobile = $("#newmobile").val();
	if(mobile=="")
	{
		alert("Please fill mobile.");
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/sendOTP/",
			data: "mobile="+mobile,
			success: function (data) {
				$("#mobileotpsendbutton").hide();
                $("#newmobile").hide();
                $("#mobileotpverifybutton").show();
                $("#otpnewmobile").show();
                console.log(data);
			}
		});
	}
 return false;
});
// End SEND OTP button

//verify otp
$("#mobileotpverifybutton").click(function(){


    var mobile = $("#newmobile").val();
	var otp = $("#otpnewmobile").val();
	if(mobile=="")
	{
		alert("Please fill mobile.");
		$("#newmobile").focus();
	}
	else if(otp=="")
	{
		alert("Please fill otp.");
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/verify_mobile/",
			data: "mobile="+mobile+"&otp="+otp,
			success: function (data) {
				if(data=="verify"){
				    $("#mobile").val(mobile);
					 $("#newmobile").remove();
                    $("#mobileotpsendbutton").remove();
                    $("#mobilechange").remove();
                    $("#mobileotpverifybutton").remove();
                    $("#otpnewmobile").remove();
                    $("#mobile").show();
                    alert("Your mobile numer verified successfully");
				}
				else
				{
					alert("OTP was not correct please try again");

				}
			}
		});
	}

    return false;
});
// end verify otp
// End Changing Mobile number with OTP

</script>

  <script>
    var chromeMediaSource = 'screen';
    window.addEventListener('message', function(message) {
      if(message.origin.toString().indexOf(MY_DOMAIN) === -1) return;
      chromeMediaSource = 'desktop';
      if(typeof getScreenId == 'function' && !!message.data.sourceId) {
        getScreenId(chromeMediaSource, message.data.sourceId);
      }
    });
  </script>
  <script>
    var count = 1;
    var rcount = 0;
    $('#btn-start-recording').click(function(){
      rcount += 1;

      if(rcount == 1)
      {
        $('#btn-start-recording').hide();
        $('#next_button').show();
        $('#question1').html('Tell me about yourself Education/Family');
      }
      else if(rcount == 2)
      {
        $('#question1').hide();
        $('#btn-start-recording').hide();
      }

    })
    $('#next_button').click(function(){
      count += 1;
      if(count == 2)
      {
        $('#question1').html('Please tell me about Working/Employment/Business');
      }
      else if(count == 3)
      {
        $('#question1').html('Please tell me about your Income/Experience');
      }
      else if(count == 4)
      {
        $('#question1').html('Please tell me about your Back Loan');
      }
      else if(count == 5)
      {
        $('#question1').html('Please tell me about your Loan Required and end use and how to Repay');
      }
      else if(count == 6)
      {
        $('#next_button').hide();
        $('#question1').hide();
        $('#btn-start-recording').show();


      }




    })


  </script>