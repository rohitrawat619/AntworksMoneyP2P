<?php

class LendSocial extends CI_Controller
{			private $vendor_id;
	public function __construct()
	{
		parent::__construct();
	//	$this->surgeInvestmentDynamiCss();
		$this->load->model('LendSocialmodel');
		$this->load->model('login/Loginmodel');
		$this->load->helper('url');
		$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
		//$this->load->library('form_validation');
		$this->load->helper('custom');
		$this->load->helper('cookie');
		//$this->load->library('pagination');
		$this->vendor_id = 1;
		error_reporting(0);
					$database_name = $this->cldb->database;
			//	echo "Database Name: ".$database_name;
		//	$this->check_role();
		 if($this->input->get('q')!=""){
					$this->setCookieData($this->input->get('q'),"firstBlock");
					 }
		$this->sessionMobileData = $this->session->userdata();
				if($this->sessionMobileData['partner_id']==""){
					$userCookieValue = $this->input->cookie('partner_id');
					
					$this->setCookieData($userCookieValue,"secondBlockCookieSet");
				}
				$this->sessionMobileData = $this->session->userdata();
				
		print_r($sessionMobileData);
	//	 $this->session->sess_destroy();
				$this->sessionData = $this->LendSocialmodel->getUserDetail($this->sessionMobileData['mobile']);
			
				
				if($this->sessionData['partners_id']==""){
				$partnerInfo = $this->LendSocialmodel->getPartnersTheme($this->sessionMobileData['partner_id']);
				}else{
					$partnerInfo = $this->LendSocialmodel->getPartnersTheme($this->sessionData['partners_id']);
				}
			////	print_r($partnerInfo['partner_id']);
					$partnerInfo['logo_path'] =	str_replace('D:/public_html/antworksp2p.com','..',$partnerInfo['logo_path'])."?q=".rand();
						$this->partnerInfo = $partnerInfo;
					
	}

		
	

	public function dashboard(){
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
			$this->load->view('dashboard',$data);
		}
		
			public function signIn(){
					// $this->session->sess_destroy();
					
				 if($this->partnerInfo['partner_id']==""){ echo"<h2>Invalid Url</h2>"; exit();	 }
				 
			
			
			$data['logo_path'] = $this->partnerInfo['logo_path']; //".a./document/surge/img/surge-logo.png";
			$this->load->view('template-LendSocial/header',$data);
			$this->load->view('signIn',$data);
			$this->load->view('template-LendSocial/footer',$data);
			
		}
					public function sendLendSocialOtp(){
						return $this->Loginmodel->sendLendSocialOtp();
								}

					public function otp(){
				
			
			$data['logo_path'] = $this->partnerInfo['logo_path'];
			$this->load->view('template-LendSocial/header',$data);
			$data['mobile'] = $this->input->post('mobile');
				$mobile = substr($this->input->post('mobile'),0,10);
				if($mobile!=""){
				$this->session->set_userdata(array("mobile"=>$mobile));
				$this->sendLendSocialOtp();
				
				}
					$data['lists']['otpMsg'] = 	"An otp has been sent to ******".substr(($mobile!=''?$mobile:$this->sessionData["mobile"]),6).".";
					$this->load->view('otp',$data);
				
			$this->load->view('template-LendSocial/footer',$data);
		}

			public function verifyOtp(){
				
					if($this->input->post('otp')!=""){
			$respData = $this->Loginmodel->verify_mobile_LendSocial($this->sessionData["mobile"],$this->input->post('otp'));
						}
			
			
				$this->session->set_userdata(array("otpStatus"=>$respData['status']));
			if($respData['status']==1){ // verified
							
				$kycStatus =  json_decode($this->LendSocialmodel->getKycStatus($this->sessionData["mobile"]),true);
							$updateUserLenderIdStatus = $this->LendSocialmodel->updateUserLenderId($this->sessionData["id"],$this->sessionData["mobile"],$kycStatus['kyc_status']['lender_id'],$kycStatus['kyc_status']['vendor_id'],"-");
							
						if($kycStatus=="Unauthorised" && $kycStatus['status']!=1){
							$error = 1;
							$msg = "Token Authorization Failed.";
					$this->session->set_flashdata('notification',array('error'=>$error,'message'=>$msg));
			 redirect(base_url('LendSocial/').'signIn');
								}
						$error = 0;
						$msg = $respData['response'];	
					if($kycStatus['kyc_status']['step']==0){ // new user
						
						$sessionTemp = $this->session->userdata();
						print_r($this->LendSocialmodel->updateUserLenderId($this->sessionData["id"],$this->sessionData["mobile"],"",$sessionTemp['partner_id'],"NewUser")); 
							
						redirect(base_url('LendSocial/').'personalDetails');
						}else if($kycStatus['kyc_status']['step']==1){ // half kyc done
								redirect(base_url('LendSocial/').'accountDetails');	
							}else if($kycStatus['kyc_status']['step']==2){ // penny drop done
							redirect(base_url('LendSocial/').'surgeInvestmentPlans');
							
								}else if($kycStatus['kyc_status']['step']==3){ // atleast one payment done
										redirect(base_url('LendSocial/').'lenderDashboard');
									}

						}else{	// not verified
							$error = 1;
							$msg = $respData['response'];
					$this->session->set_flashdata('notification',array('error'=>$error,'message'=>$msg));
			 redirect(base_url('LendSocial/').'otp');
							}
			
			
						}	
		
		public function investmentAmount(){
			$scheme_id = $this->input->post('scheme_id');
			

				
		//$this->load->view('template-LendSocial/nav');
		$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
		$data['lists']['scheme_id'] = $scheme_id;
		$this->load->view('investmentAmount',$data);
			$this->load->view('template-LendSocial/footer',$data);
		}
		public function hello(){
			
			print_r($this->input->post());
		}
		
		public function processingInvestmentPayment(){
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
			$this->checkSessionMobileNo();
			$scheme_id = $this->input->post('scheme_id');
			$amount = $this->input->post('amount');
			$mobile = $this->sessionData["mobile"];
			$generateOrderResp = json_decode($this->LendSocialmodel->generateOrder($amount,$mobile),true);
			$data['lists']['generateOrderResp'] = $generateOrderResp;
			$data['lists']['sessionData'] = $this->sessionData;
			$data['lists']['scheme_id'] = $scheme_id;
			$this->load->view('processingInvestmentPayment',$data);
			$this->load->view('template-LendSocial/footer',$data);
		}
		
				public function redeemRequestPreview(){
						$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
		$data['lists']['redeemRequestPreviewData'] = json_decode($this->LendSocialmodel->getRedeemRequestPreview($this->sessionData["mobile"],
		$this->input->post('investment_no')),true); 
			$data['lists']['sessionData'] = $this->sessionData;
		$this->load->view('redeemRequestPreview',$data);
		$this->load->view('template-LendSocial/footer',$data);
			
		}
				public function sendRedemptionReqest(){
					$this->checkSessionMobileNo();
				}
				
			public function lenderDashboard(){
				$this->checkSessionMobileNo();
			
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
			$data['lists']['investmentList'] = json_decode($this->LendSocialmodel->getInvestmentList($this->sessionData["mobile"],$this->sessionData["lender_id"]),true); // getInvestmentList($mobile,$lender_id)
			$data['lists']['sessionData'] = $this->sessionData;
			$this->load->view('lenderDashboard',$data);
			$this->load->view('template-LendSocial/footer',$data);
			
			
		}
		
		public function personalDetails(){
				
							$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
				$data['lists']['sessionData'] = $this->sessionData;
				
		$this->load->view('personalDetails',$data);
		$this->load->view('template-LendSocial/footer',$data);
		//$this->load->view('template-LendSocial/footer');
				}

			public function accountDetails(){
					$this->checkSessionMobileNo();
				if($this->sessionData["mobile"]){
			$this->session->set_userdata($this->input->post()); 
			}				
						$updateUserDetailStatus = $this->LendSocialmodel->updateUserDetail();
				//print_r($updateUserDetailStatus);
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
		$data['lists']['sessionData'] = $this->sessionData;
		$this->load->view('accountDetails',$data);
		//$this->load->view('template-LendSocial/footer');
		$this->load->view('template-LendSocial/footer',$data);
				}
				
						public function otpAadhaar(){
						$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
			$data['lists']['msg']  = ($this->input->get('msg'));
			$data['lists']['otpPageMsg'] = "";
		$this->load->view('template-LendSocial/header',$data);
			
				
					$this->load->view('otpAadhaar',$data);
				$this->load->view('template-LendSocial/footer',$data);
			
		}
		
		public function otpAadhaarProcessing(){
			echo"<pre>";
			//print_r($this->input->post('adhaarOtp'));
			//print_r($this->sessionData);
			
			$mobile = $this->sessionData['mobile'];
			$fullname = $this->sessionData['name'];
			$email = $this->sessionData['email_id'];
			$pan = $this->sessionData['pan_card'];
			$aadhaar = $this->sessionData['aadhaar'];
			$account_no = $this->sessionData['account_number'];
			$bank_name = $this->sessionData['bank_name'];
			$ifsc_code = $this->sessionData['ifsc_code'];
			
			$otp = $this->input->post('adhaarOtp');
			$transactionId = $this->input->post('transactionId');
					$fwdp = $this->input->post('fwdp');
					$codeVerifier = $this->input->post('codeVerifier');
					$kyc_unique_id = $this->input->post('kyc_unique_id');			
			$allInOneKycSubmitOtpStatus = json_decode($this->LendSocialmodel->allInOneKycSubmitOtp($mobile,$fullname,$email,$pan,$aadhaar,$account_no,$bank_name,$ifsc_code,$otp,$transactionId,$codeVerifier,$fwdp,$kyc_unique_id),true);   // vender_id =partner_id
						$allInOneKycSubmitOtpStatus = $allInOneKycSubmitOtpStatus['response'];
			//	echo"<pre>------------------"; print_r($allInOneKycSubmitOtpStatus); die();
		if($allInOneKycSubmitOtpStatus['aadhar_kyc']['status']==1){
				$kycStatus['status'] = 1;
				$kycStatus['msg']  = $allInOneKycSubmitOtpStatus['aadhar_kyc']['msg'];
			}else{
				$kycStatus['status'] =0;
				$kycStatus['msg'] = $allInOneKycSubmitOtpStatus['aadhar_kyc']['msg'].$allInOneKycSubmitOtpStatus['error_msg']; // "Aadhaar OTP verification failed, Please try again."
			}
			
			
			if($kycStatus['status']==1){ 
					$msg = urlencode(base64_encode($kycStatus['msg']));
					redirect(base_url('LendSocial/') . 'kycSuccessful?msg='.$msg);
				}else{
					
					$msg = $kycStatus['msg'];
				$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
				redirect(base_url('LendSocial/') . 'otpAadhaar?msg='.base64_encode($msg).'&transactionId='.$transactionId.'&fwdp='.$fwdp.'&codeVerifier='.$codeVerifier.'&kyc_unique_id='.$kyc_unique_id);
			}
		}
				
			public function verifyKYC(){
				$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
				$this->load->view('verifyKYC',$data);
				$this->load->view('template-LendSocial/footer',$data);
					$updateUserDetailStatus = $this->LendSocialmodel->updateUserDetail();
					
					
					$getUserDetailResp = $this->LendSocialmodel->getUserDetail($this->sessionMobileData['mobile']);
					$dob = $this->formatted_dob($getUserDetailResp['date_of_birth']); 
					$email = $getUserDetailResp['email_id'];
					$fullname = $getUserDetailResp['name'];
					$gender = $getUserDetailResp['gender'];
					$phone = $getUserDetailResp['mobile'];
					$vendor_id = $getUserDetailResp['partners_id'];
					$pan = $getUserDetailResp['pan_card'];
					$account_no = $getUserDetailResp['account_number'];
					$caccount_no =  $getUserDetailResp['account_number'];
					$ifsc_code = $getUserDetailResp['ifsc_code'];
					$aadhaar = $getUserDetailResp['aadhaar'];
					$bank_name = $getUserDetailResp['bank_name'];
					
					$saveUserPersonalDetailStatus = json_decode($this->LendSocialmodel->saveUserPersonalDetail($dob,$email,$fullname,$gender,$pan,$phone,$vendor_id),true);   // vender_id =partner_id
						
					if($saveUserPersonalDetailStatus['status']==1){ // saveUserPersonalDetailStatus
						$lender_id = $saveUserPersonalDetailStatus['lender_id'];
						
						$this->LendSocialmodel->updateUserLenderId($this->sessionData["id"],$this->sessionData["mobile"],$lender_id,"","NewUser"); // updated  lender's Id.
						
						$userBankKYCStatus = json_decode($this->LendSocialmodel->userBankKYC($account_no,$caccount_no,$fullname,$ifsc_code,$lender_id,$phone),true);
						
						/*if($userBankKYCStatus['status']!=1){  //userBankKYCStatus 1:done; 0:failed
								$kycStatus['status'] = $userBankKYCStatus['status'];
								$kycStatus['msg'] = $userBankKYCStatus['msg'];
							*/	
							$allInOneKycStatus =	json_decode($this->LendSocialmodel->allInOneKyc($phone,$fullname,$email,$pan,$aadhaar,$account_no,$bank_name,$ifsc_code),true); //dated:2023-dec-21
									
							if($allInOneKycStatus['aadhar_response']['code']==200){
								$kycStatus['status'] = "1";
								$kycStatus['msg'] = $allInOneKycStatus['aadhar_response']['msg'].$allInOneKycStatus['error_msg'];
								if($allInOneKycStatus['aadhar_response']['model']['adharNumber']!=""){
									$kycStatus['status'] = 2;  // aadhaar is already verified (that means kyc done sucessfull)
								$kycStatus['msg'] = "Aadhaar Verification Already Done.";
								}else{
									$kycStatus['status'] = 1;
									$kycStatus['data']['kyc_unique_id'] = $allInOneKycStatus['kyc_unique_id'];
									$kycStatus['data']['transactionId'] = $allInOneKycStatus['aadhar_response']['model']['transactionId'];
									$kycStatus['data']['fwdp'] = $allInOneKycStatus['aadhar_response']['model']['fwdp'];
									$kycStatus['data']['codeVerifier'] = $allInOneKycStatus['aadhar_response']['model']['codeVerifier'];
								$kycStatus['msg'] = $allInOneKycStatus['aadhar_response']['model']['uidaiResponse']['message'].$allInOneKycStatus['error_msg'];
								}
								
							}else{
								$kycStatus['status'] = 0;
								$kycStatus['msg'] = json_encode($allInOneKycStatus); //$allInOneKycStatus['aadhar_kyc']['msg'].$allInOneKycStatus['error_msg'];
							}
								
							/*}else{
								$kycStatus['status']= $userBankKYCStatus['status'];
								$kycStatus['msg'] = $userBankKYCStatus['msg'].$userBankKYCStatus['error_msg'];
								$kycStatus['resp'] = json_encode($userBankKYCStatus);
							} */
					}else{
						$kycStatus['status'] = 0;
						$kycStatus['msg'] = $saveUserPersonalDetailStatus['msg'].$saveUserPersonalDetailStatus['error_msg'];
						$kycStatus['resp'] = json_encode($saveUserPersonalDetailStatus);
					}
						//	echo"<pre>";
			//	print_r($kycStatus); die();
				
				
				$data['lists']['sessionData'] = $this->sessionData;
				
					
				if($kycStatus['status']==1){
					$msg = urlencode(base64_encode($kycStatus['msg']));
					$transactionId = urlencode($kycStatus['data']['transactionId']);
					$fwdp = urlencode($kycStatus['data']['fwdp']);
					$codeVerifier = urlencode($kycStatus['data']['codeVerifier']);
					$kyc_unique_id = urlencode($kycStatus['data']['kyc_unique_id']);
					redirect(base_url('LendSocial/') . 'otpAadhaar?msg='.$msg.'&transactionId='.$transactionId.'&fwdp='.$fwdp.'&codeVerifier='.$codeVerifier."&kyc_unique_id=".$kyc_unique_id);
				}else if($kycStatus['status']==2){ // aadhaar is already verified (that means kyc done sucessful)
					$msg = urlencode(base64_encode($kycStatus['msg']));
					redirect(base_url('LendSocial/') . 'kycSuccessful?msg='.$msg);
				}else{
					$msg = urlencode(base64_encode($kycStatus['msg'])); //"Failed due to wrong pan card");
					redirect(base_url('LendSocial/') . 'kycFailed?msg='.$msg);
				}
				
						}

				public function kycSuccessful(){
						$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
			$data['lists']['msg']  = ($this->input->get('msg'));
		$this->load->view('template-LendSocial/header',$data);
			$this->load->view('kycSuccessful',$data);
			$this->load->view('template-LendSocial/footer',$data);
		}		
							
			public function kycFailed(){
				$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
			$data['logo_path'] = $this->partnerInfo['logo_path'];
			$data['lists']['msg']  = ($this->input->get('msg'));
			$this->load->view('kycFailed',$data);
			$this->load->view('template-LendSocial/footer',$data);
		}
			
			public function redeemRequestProcessing(){
				$this->checkSessionMobileNo();
				$reponseRedeemptionRequest = json_decode($this->LendSocialmodel->sendRedemptionRequest($this->sessionData["mobile"],$this->input->post('investment_no')),true);
				// print_r($this->input->post());
				// print_r($reponseRedeemptionRequest);
				$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
				if($reponseRedeemptionRequest['status']==1){
					
					$data['lists']['title'] = "Redeemption Request Successfully";
					$data['lists']['text'] = "click on below link for home page";
					$data['lists']['link'] = "lenderDashboard";
					$this->load->view('success',$data);
				}else{
					
					$data['lists']['title'] = "Redeemption Request Failed";
					$data['lists']['text'] = "click on below link for home page";
					$data['lists']['link'] = "lenderDashboard";
					$this->load->view('failed',$data);
				}
				$this->load->view('template-LendSocial/footer',$data);
			//	print_r($reponseRedeemptionRequest);
				
			//	redirect(base_url() . 'loginLogoutadmin');
			}

			public function lenderInvestmentProcessing(){ 
							$this->checkSessionMobileNo();
							
							$ant_txn_id = $this->input->post('ant_txn_id');
							$mobile = $this->input->post('mobile');
							$amount = $this->input->post('amount');
							$razorpay_order_id = $this->input->post('razorpay_order_id');
							$razorpay_payment_id = $this->input->post('razorpay_payment_id');
							$razorpay_signature = $this->input->post('razorpay_signature');
							$lender_id = $this->input->post('lender_id');
							$amount = $this->input->post('amount');
							$scheme_id = $this->input->post('scheme_id');
				//	echo"<pre>";
			$socialAfterPaymentRequest = json_decode($this->LendSocialmodel->socialAfterPayment($ant_txn_id,$mobile,$amount,$razorpay_order_id,$razorpay_payment_id,$razorpay_signature),true);
		//	print_r($socialAfterPaymentRequest);
			$lenderInvestmentRequest = json_decode($this->LendSocialmodel->lenderInvestment($mobile,$lender_id,$amount,$scheme_id,$ant_txn_id),true);
			//	print_r($lenderInvestmentRequest);
				// print_r($this->input->post());
			//	 print_r($reponseRedeemptionRequest);
$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
				if($lenderInvestmentRequest['status']==1){
					
					$data['lists']['title'] = "Investment Successfully";
					$data['lists']['text'] = "click on below link for home page";
					$data['lists']['link'] = "lenderDashboard";
					$this->load->view('success',$data);
				}else{
					
					$data['lists']['title'] = "Investment Request Failed";
					$data['lists']['text'] = "click on below link for home page";
					$data['lists']['link'] = "lenderDashboard";
					$this->load->view('failed',$data);
				}
				$this->load->view('template-LendSocial/footer',$data);
					}
		

			public function surgeInvestmentPlans(){
						$this->checkSessionMobileNo();
			$data['logo_path'] = $this->partnerInfo['logo_path'];
		$this->load->view('template-LendSocial/header',$data);
				$data['lists']['allSchemeList'] = json_decode($this->LendSocialmodel->getAllSchemes($this->sessionData["mobile"],1),true); // getAllSchemes($mobile,$partner_id)
		$this->load->view('surgeInvestmentPlans',$data);
		$this->load->view('template-LendSocial/footer',$data);
		//print_r($data);
				}
		
		public function sign_out(){
						$this->session->sess_destroy();
				redirect(base_url('LendSocial/') . 'signIn?q='.base64_encode(base64_encode($this->sessionData['partners_id'])));
		}
		
		public function checkSessionMobileNo(){
						if($this->sessionData["mobile"]==""){
						 $this->session->set_flashdata('notification',array('error'=>0,'message'=>"Session Failed"));	
						 redirect(base_url('LendSocial/').'signIn');
								}
						}
						
			
		
					public function setCookieData($q,$block){
						
				//	echo "{".$block."---}";
						 $this->session->set_userdata(array("partner_id"=>base64_decode(base64_decode($q))));
				    // Set a cookie expires in 1 hour (3600 seconds)
					$cookie = array('name'=>'partner_id','value'=>"",'expire'=> time() - 3600,'path'   => '/',);
					$this->input->set_cookie($cookie);
					$cookie = array('name'=>'partner_id','value'=>$q,'expire'=> time() + 3600,'path'   => '/',);
					$this->input->set_cookie($cookie);
					}
					public function formatted_dob($dob){
						return date("d/m/Y",strtotime($dob));
					}
		
		public function surgeInvestmentDynamiCss() {
			
        // You can generate dynamic CSS content here
        // For example, change background color dynamically
        $backgroundColor = "#c5e6eb";
		$buttonBackgroundColor = $this->partnerInfo['background_color']; //"#b61e37";
		$headerColor = $this->partnerInfo['color']; 
		$redeembtncolor = "#3a9cd9";
		$font_family = $this->partnerInfo['font_family'];

        // Your dynamic CSS rules
        $css = "body{font-family:'$font_family'}
		.surge-redeem-btn-color{background-color:$redeembtncolor; padding:15px 60px; margin-top:15px; color:#fff; display: inline-block; border-radius: 30px !important;
  border: none;}
		.surgebg {background:$backgroundColor; padding:80px 30px;}
.surgelogo {max-width:220px; margin-bottom:50px;}
.main-headr {font-size: 30px; font-weight:600; margin-bottom:0;}
.main-subheadr {font-size: 18px; font-weight:400;}
.sub-subheadr {font-size: 18px; font-weight:400;}
.mainsurge-plans {padding:60px 0;}
.surge-plans {width:100%; float:left; min-height: 345px; position:relative; padding:30px; margin-bottom:30px; border-radius:8px; border:1px solid #e1e1e1; box-shadow:1px 1px 10px 5px #e8e8e8;}
.surge-badge {position:absolute; right:15px; top:15px;}
.surge-badge img {max-width:100%;}
.surge-plans ul {padding:0 0 0 15px; min-height: 145px;}
.surge-plans h2 {font-size:24px; font-weight:bold; margin:0 0 10px 0;}
.surge-plans li {font-size:14px; font-weight:400; margin:0 0 10px 0; display:block;}
.surge-plans-btn {background:$buttonBackgroundColor; padding:15px 60px; margin-top:5px; color:#fff; display: inline-block; border-radius: 30px !important;
  border: none;}
.surge-plans-btn:hover {background:#7eb3bb; color:#fff;}
.remarks-txt {font-size:11px; margin-top:10px; display: inline-block;}
.surge-plans .f1 fieldset {margin-top:15px;}
.surgeant-icon {max-width:150px; margin-bottom:15px;}
.success-txt {font-size: 18px; color:#0d8c03; font-weight:600;}
.fail-txt {font-size: 18px; color:red; font-weight:600;}
.surge-success {border: 1px solid #e1e1e1; border-radius:10px; box-shadow: 1px 1px 10px 5px #e8e8e8; padding:50px 30px; margin:50px 0;}
.investment-box {padding:0; margin:30px 0 0 0;}
.investment-box li {display:inline-block; padding:15px 30px; border-radius:10px; font-size:16px; color:#fff; font-weight:600; margin:5px; width:25%;}
.investment-box li span {display:block;}
.investment-box li:nth-child(1){background:#3a9cd9;}
.investment-box li:nth-child(2){background:#c8062b;}
.investment-box li:nth-child(3){background:#9e39b7;}
.surge-list {width:100%; float:left; border: 1px solid #e1e1e1; border-radius:10px; box-shadow: 1px 1px 10px 5px #e8e8e8; padding:30px; margin:0 0 30px 0;}
.surge-list p {margin:0;}
.moreinvest {font-size:16px;}
.dash-hd {font-size:24px; font-weight:bold;}
.investmentno {font-size:18px; font-weight:bold;}
.investmentname {font-size:18px; font-weight:bold;}
.invest-details {margin:0; padding:0;}
.invest-details li {width:50%; float:left; list-style:none; font-size:16px; padding:5px 15px 5px 0;}
.invest-details li span {display:block;}

@media(max-width:767px){
.surgelogo {max-width:220px; margin-bottom:30px;}
.surgebg {padding:40px 20px;}
.surge-badge img {max-width:130px;}
.topfeature {max-width:60px; margin-top:10px;}
.surgebg .sub-subheadr {font-size:14px;}
.main-headr {font-size: 24px;}
.mainsurge-plans {margin:15px;}
.surge-plans {padding: 15px; min-height:auto;}
.surge-plans ul {min-height: auto;}
.mainsurge-plans {padding: 20px 0;}
.investment-box {margin-top:10px;}
.investment-box li {width:100%;}
} 
.borrower-hd {font-size:30px; text-align:center; margin-bottom:30px;} 
.borrower-hd span {font-weight:600;} 
.borrower-profile {margin:0 auto; padding:50px; text-align:center; width:100%; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #cecaca; border-radius:60px; margin-top:160px;}
.borrowerpic img {width:150px; height:150px; border-radius:150px; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #d4d4d4; margin-top:-120px;}
.borrower-criteria {margin:0 0 30px 0; padding:0;}
.borrower-criteria li{display:inline-block; padding-right:20px; color:#7e7e7e; font-size:14px; font-weight:600;}
.borrower-criteria li span {color:#000; font-size:18px; display:block;}
.borrower-criteria li:last-child{padding-right:0;}
.lending-box {margin:50px 0;}
.borrower-btn {text-align:center;}
.borrower-btn button {border-radius: 30px !important; border: none; padding:10px 50px;}
.other-amount {margin-top:30px; font-size:18px;}
.amount-entr {width:60%; display:inline-block; text-align:center; padding:25px 10px; border-radius:50px!important;}
.btn-submit-amount {margin-top:15px;}

.register-hd {font-size:28px; font-weight:600; color:#000;}

.f1 {padding: 25px; background: #fff; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;}
.f1 h3 { margin-top: 0; margin-bottom: 5px; text-transform: uppercase;}
.f1 .form-group {margin-bottom: 5px;}
.f1-steps { overflow: hidden; position: relative; margin: 20px 30px 0 30px; }
.f1-progress { position: absolute; top: 24px; left: 21%; width: 56%; height: 4px; background: #ddd;}
.f1-progress-line { position: absolute; top: 0; left: 0; height: 4px; background: #004566;}
.f1-step { position: relative; float: left; width: 50%; padding: 0; text-align: center;}
.f1-step-icon {display: inline-block;  text-align:center; width: 40px; height: 40px; margin-top: 4px; background: #ddd; font-size: 16px; color: #fff; line-height: 40px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;}
.f1-step.activated .f1-step-icon {background: #fff; border: 1px solid #004566; color: #fff; line-height: 48px; width: 48px; height: 48px; margin-top: 0; background: #004566;}
.f1-step.active .f1-step-icon {width: 48px; height: 48px; margin-top: 0; background: #004566; font-size: 22px; line-height: 48px;}
.f1-step p {color: #ccc;}
.f1-step.activated p {color:#004566;}
.f1-step.active p {color:#004566;}
.f1 fieldset {display: none; text-align:left;}
.f1-buttons {text-align: right;}
.f1 .input-error { border-color: red !important;}
.f1 fieldset [class^='col-'] {padding:0 5px;}
.f1 label {font-size:14px; color:#595959; font-weight:400;}
.f1 label span {color:#fe0000; font-size:15px;}
.pas-tips {font-size:11px; color: #222; line-height:12px; display: inline-block; margin-top:5px;}
#send_otp button {float:right; border: none; background: #014667; color:#fff; margin-top:-10px; border-radius:3px; font-size:11px; padding:5px 10px;}
.f1-buttons button {background:$buttonBackgroundColor; width:96px; color:#fff; border-radius:20px;}
.f1-buttons {width:100%; float:left; padding:10px 0;}
.f1-buttons button:hover {color:#fff;}
.f1-buttons .btn-previous {float:left;}
.f1-step .f1-progress-line {display:none;}



.borrower-hd {font-size:30px; text-align:center; margin-bottom:30px;} 
.borrower-hd span {font-weight:600;} 
.borrower-profile {margin:0 auto; padding:50px; text-align:center; width:100%; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #cecaca; border-radius:60px; margin-top:160px;}
.borrowerpic img {width:150px; height:150px; border-radius:150px; border:1px solid #d4d4d4; box-shadow:0px 2px 4px 1px #d4d4d4; margin-top:-120px;}
.borrower-criteria {margin:0 0 30px 0; padding:0;}
.borrower-criteria li{display:inline-block; padding-right:20px; color:#7e7e7e; font-size:14px; font-weight:600;}
.borrower-criteria li span {color:#000; font-size:18px; display:block;}
.borrower-criteria li:last-child{padding-right:0;}
.lending-box {margin:50px 0;}
.borrower-btn {text-align:center;}
.borrower-btn button {border-radius: 30px !important; border: none; padding:10px 50px;}
.other-amount {margin-top:30px; font-size:18px;}
.amount-entr {width:60%; display:inline-block; text-align:center; padding:25px 10px; border-radius:50px!important;}
.btn-submit-amount {margin-top:15px;}

.register-hd {font-size:28px; font-weight:600; color:#000;}

.f1 {padding: 25px; background: #fff; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;}
.f1 h3 { margin-top: 0; margin-bottom: 5px; text-transform: uppercase;}
.f1 .form-group {margin-bottom: 5px;}
.f1-steps { overflow: hidden; position: relative; margin: 20px 30px 0 30px; }
.f1-progress { position: absolute; top: 24px; left: 21%; width: 56%; height: 4px; background: #ddd;}
.f1-progress-line { position: absolute; top: 0; left: 0; height: 4px; background: #004566;}
.f1-step { position: relative; float: left; width: 50%; padding: 0; text-align: center;}
.f1-step-icon {display: inline-block;  text-align:center; width: 40px; height: 40px; margin-top: 4px; background: #ddd; font-size: 16px; color: #fff; line-height: 40px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;}
.f1-step.activated .f1-step-icon {background: #fff; border: 1px solid #004566; color: #fff; line-height: 48px; width: 48px; height: 48px; margin-top: 0; background: #004566;}
.f1-step.active .f1-step-icon {width: 48px; height: 48px; margin-top: 0; background: #004566; font-size: 22px; line-height: 48px;}
.f1-step p {color: #ccc;}
.f1-step.activated p {color:#004566;}
.f1-step.active p {color:#004566;}
.f1 fieldset {display: none; text-align:left;}
.f1-buttons {text-align: right;}
.f1 .input-error { border-color: red !important;}
.f1 fieldset [class^='col-'] {padding:0 5px;}
.f1 label {font-size:14px; color:#595959; font-weight:400;}
.f1 label span {color:#fe0000; font-size:15px;}
.pas-tips {font-size:11px; color: #222; line-height:12px; display: inline-block; margin-top:5px;}
#send_otp button {float:right; border: none; background: #014667; color:#fff; margin-top:-10px; border-radius:3px; font-size:11px; padding:5px 10px;}
.f1-buttons button {background:$buttonBackgroundColor; width:96px; color:#fff; border-radius:20px;}
.f1-buttons {width:100%; float:left; padding:10px 0;}
.f1-buttons button:hover {color:#fff;}
.f1-buttons .btn-previous {float:left;}
.f1-step .f1-progress-line {display:none;}

/*OTP Screen*/

.otpverify {font-size:24px; color:#000; font-weight:bold; text-transform:auto;}

.otpinfo {font-size:18px; color:#118a44; font-weight:bold; text-transform:auto;}

.otpmsg {font-size:18px; color:#000; font-weight:bold; text-transform:auto;}

.otp-input-fields {margin: auto; width: auto; display: flex; justify-content: center; gap: 10px; padding: 40px;}

.otp-input-fields>input {height: 42px; width: 42px; background-color: transparent; border: 1px solid #000; border-radius:4px!important; text-align: center; outline: none; font-size: 16px;}

.otp-input-fields>input::-webkit-outer-spin-button, .otp-input-fields input::-webkit-inner-spin-button {

-webkit-appearance: none; margin: 0;}

.otp-input-fields input[type=number] {-moz-appearance: textfield;}

/*OTP Screen*/


.header .header-navigation.navbar {background: $headerColor !important; margin-bottom:50px; border-bottom:1px solid #f2f2f2; box-shadow: 0px 2px 10px rgba(0,0,0,0.10),0px 0px 2px rgba(0,0,0,0.10);}

.footer-bottom {background: #0D0D0D; padding: 17.5px 0;}

.footer-bottom p {margin: 0; font-size:14px; color: #999; line-height: 35px;}
";


        // Set the appropriate content type
        $this->output->set_content_type('text/css');

        // Output the dynamic CSS content
        $this->output->set_output($css);

    }
		
		
		
		
	


}
