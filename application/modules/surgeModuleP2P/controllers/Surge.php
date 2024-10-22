<?php

class Surge extends CI_Controller
{			
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Surgemodel');
		$this->load->model('LendSocialCommunicationModel');
		$this->load->helper('url');
		//$this->cldb = $this->load->database('new_p2p//_sandbox', TRUE);
		//$this->load->model('Common_model');
		$this->load->library('form_validation');
		$this->load->helper('custom');
		$this->load->library('pagination');
		
		error_reporting(0);
				//	$database_name = $this->cldb->database;
			//	echo "Database Name: ".$database_name;
			$this->check_role();
		$this->partner_id = $this->session->userdata('partner_id');
		//	print_r($this->session->userdata());
		$this->session->set_userdata(array("partnerInfo"=>$this->Surgemodel->getPartnersList(1, 0,"")));
	}


		public function findValuesViaInvestmentFunction(){
		//$_POST['minInvestment'] = $this->input->get('q'); //"20000";
		//print_r($_POST['minInvestment']); die();
  if(isset($_POST['minInvestment'])){
  $minInvestment = (int)$_POST['minInvestment'];

  // Check if the minimum investment is less than 12,500
  if ($minInvestment > 0 && $minInvestment < 12500) {
      // Apply rules if the minimum investment is less than 12,500
      $lenderDiversificationInitial = 4;
      $lenderDiversificationStepUp = 2;
  } else {
      // rules when the minimum investment is 12,500 or more
      $lenderDiversificationInitial = 10;
      $lenderDiversificationStepUp = 5;
  }

  $results = [];

  // Initialize variables to hold the last successful values
  $lastSuccessfulStepUp = 0;
  $lastSuccessfulLenderDiversificationFactor = 0;

  // Define the range for the loan amount
  $minLoanAmount = 5000;
  $maxLoanAmount = 20000;

  for ($lenderDiversificationFactor = $lenderDiversificationInitial; $lenderDiversificationFactor <= 100; $lenderDiversificationFactor += $lenderDiversificationStepUp) {

      $stepUp = $minInvestment / $lenderDiversificationFactor;

      if (intval($stepUp) == $stepUp) {

          $loanAmount = 4 * $stepUp;

          // Check if stepUp falls within the loan amount range
          if ($loanAmount >= $minLoanAmount && $loanAmount <= $maxLoanAmount) {
              
			$results[] = [
				'step_up_value' => $stepUp,
				'diversification_factor_value' => $lenderDiversificationFactor,
				'minimum_loan_amount' => $loanAmount
			];

          }
      }
  }


  // Return the result as JSON
  echo json_encode($results);
  die();
}
}
	
	public function dashboardBorrower(){
		$partner_id=$this->partner_id;
		
		$data['noOfBorrower']=$this->Surgemodel->getNoOfBorrower($partner_id);
		$data['borrowerAmount']=$this->Surgemodel->getBorrowerAmount($partner_id);
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$this->load->view('dashboardBorrower',$data);
		$this->load->view('template-surgeModuleP2P/footer');
	}
	
	public function email(){
		
		$product_type_id = "LendSocialDashboard"; $instance_id = "Scheme Edit"; //"Welcome Mail";
		$resp = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id);
		echo"<pre>"; print_r($resp);
	}
	
	public function dashboard(){	
	
			// print_r($this->input->post());
		//	echo "Partner: ".$this->partner_id;
		//  print_r($this->session->userdata('role'));
			$data['lists']['partnersData'] = $this->Surgemodel->getPartnersList(100,0,"");
			$data['lists']['schemeList'] = $this->Surgemodel->getSchemeList(100, 0,"");
			$data['lists']['dashboardData']['TodayInvestment'] =  $this->Surgemodel->getInvestmentAmount('today');
			
			$data['lists']['dashboardData']['TodayInvestmentNoOfInvestor'] = $this->Surgemodel->getInvestmentNoOfInvestor('today');
			
			$data['lists']['dashboardData']['TodayRedemption'] = $this->Surgemodel->getRedemptionAmount('today');
			
			$data['lists']['dashboardData']['TodayRedemptionNoOfInvestor'] = $this->Surgemodel->getRedeemedInNoOfInvestor('today');

			$data['lists']['dashboardData']['TotalInvestment'] = '&#x20B9;'.(str_replace('&#x20B9;','',$this->Surgemodel->getInvestmentAmount('')));
			
			$data['lists']['dashboardData']['TotalInvestmentOutstanding'] = $this->Surgemodel->getlInvestmentOutstandingAmount('');
			
			$data['lists']['dashboardData']['TotalInvestmentRedeemed'] = $this->Surgemodel->getRedemptionAmount('');
			
			$data['lists']['dashboardData']['TotalInvestmentInvestor'] = $this->Surgemodel->getInvestmentNoOfInvestor('');
			
			$data['lists']['dashboardData']['AverageROI'] = $this->Surgemodel->getlAverageROI('');
			
			$data['lists']['dashboardData']['InterestOutstanding'] = $this->Surgemodel->getInterestOutstanding('');
			
			$data['lists']['dashboardData']['TotalInterestPaidOnRedeemedInvestment'] = $this->Surgemodel->getInterestPaidOnRedeemedInvestment('');
			
			$data['lists']['dashboardData']['AverageInvestment'] = '&#x20B9;'.str_replace('nan','0',number_format(str_replace('&#x20B9;','',$this->Surgemodel->getInvestmentAmount(''))/($this->Surgemodel->getInvestmentNoOfInvestor('')),2));
			
			$data['lists']['dashboardData']['OutstandingInvestmentNoInvestor'] = $this->Surgemodel->getOutstandingInvestmentNoInvestor('');
			
			$data['lists']['dashboardData']['RedeemedInvestmentNoInvestor'] = $this->Surgemodel->getRedeemedInNoOfInvestor('');
				
			$this->load->view('template-surgeModuleP2P/header');

				
		$this->load->view('template-surgeModuleP2P/nav');
		$this->load->view('dashboard',$data);
			$this->load->view('template-surgeModuleP2P/footer');
		}


	public function getProfessionList(){
		$resp = 	$this->Surgemodel->getProfessionList();
			//  echo json_encode($resp);
			echo "<pre>"; echo var_dump($resp); 
	}
	
	
	
	public function partners_list(){
		
			$where = ""; 
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/partners_list";
		$config["total_rows"] = $this->Surgemodel->getCountPartnersList($where);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	//	echo $page;
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getPartnersList($config["per_page"], $page,$where);
		$data['page'] = $page;
		$this->load->view('partners_list',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function add_partners_form(){
			$where['VID'] = $this->input->get('id');
			$partnersData = $data['lists'] = $this->Surgemodel->getPartnersList(1,0,$where);
			$data['lists'] = $partnersData['0'];
			
			$data['role'] = $this->session->userdata('role_id'); // 11 partner admin; 12:user; 10:super admin	
			
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			$this->load->view('template-surgeModuleP2P/nav');
		
			$this->load->view('add_partners_form',$data);
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function add_partner(){
			 unset($_POST['lender_partner_registration_feeCheckbox']);
			unset($_POST['borrower_platform_registration_feeCheckbox']);
			$addPartnerResp = $this->Surgemodel->add_partner();

			
			if($addPartnerResp['status']==1){
			$partners_id = $addPartnerResp['insert_id'];
			
			if($partners_id!=""){
							$addMasterFeeStructureResp = $this->Surgemodel->add_master_fee_structure($partners_id); 
			$uploadImageResp = $this->upload_image($partners_id,'mainLogo','partner_logo_file');
			$uploadBorrowerImageResp = $this->upload_image($partners_id,'borrowerBulletProduct','partner_borrower_product_logo_file');
			$uploadLenderImageResp = $this->upload_image($partners_id,'lenderProduct','partner_lender_product_logo_file');
			$addThemeResp = $this->Surgemodel->add_theme($partners_id,$uploadImageResp['full_path'],$uploadLenderImageResp['full_path'],$uploadBorrowerImageResp['full_path']);
					}
					$addPartnerResp['uploadImageResp'] = $uploadImageResp;
					$addPartnerResp['addThemeResp'] = $addThemeResp;
					
					if($addThemeResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $addThemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_partners_form');
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $addThemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_partners_form');
					}
			}else{
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $addPartnerResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_partners_form');
			}
			echo json_encode($addPartnerResp);
		}
		
		public function update_partner(){
			//unset($this->input->post('lender_partner_registration_feeCheckbox'));
			unset($_POST['lender_partner_registration_feeCheckbox']);
			unset($_POST['borrower_platform_registration_feeCheckbox']);

				// echo"<pre>";	print_r($this->input->post()); // die();echo"<pre>";
			//	print_r($updatePartnerResp); 
				//		print_r($this->input->post()); die();
			$updatePartnerResp = $this->Surgemodel->update_partner();
			
			$updateMasterFeeStructureResp = $this->Surgemodel->update_master_fee_structure();
			$partners_id = $updatePartnerResp['partner_id'];
			if($partners_id!=""){
		//	$uploadImageResp = $this->upload_image($partners_id);
		 //	$updateThemeResp = $this->Surgemodel->update_theme($partners_id,$uploadImageResp['full_path']);
		 
		 $uploadImageResp = $this->upload_image($partners_id,'mainLogo','partner_logo_file');
			$uploadBorrowerImageResp = $this->upload_image($partners_id,'borrowerBulletProduct','partner_borrower_product_logo_file');
			$uploadLenderImageResp = $this->upload_image($partners_id,'lenderProduct','partner_lender_product_logo_file');
			$updateThemeResp = $this->Surgemodel->update_theme($partners_id,$uploadImageResp['full_path'],$uploadLenderImageResp['full_path'],$uploadBorrowerImageResp['full_path']);
					} 
					$updatePartnerResp['uploadImageResp'] = $uploadImageResp;
					$updatePartnerResp['updateThemeResp'] = $updateThemeResp;
						
					if($updateThemeResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $updateThemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_partners_form?id='.$partners_id);
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $updateThemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_partners_form?id='.$partners_id);
					}  
					//echo"<pre>";
				//	print_r($uploadImageResp['full_path']);
			//echo json_encode($updatePartnerResp);
		}
		
		public function upload_image($vendor_id,$moduleType,$partner_logo_file_field_name){
		
		$directoryPath  = './document\surge\upload/vendor/'.$moduleType."/".$vendor_id;
    
	if (!is_dir($directoryPath)) {          if (!mkdir($directoryPath, 0777, true)) {      die('Failed to create directory');     }    } 
	$config['upload_path'] =  $directoryPath;
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = 8048; // 2MB
	/*
   $config['max_width'] = 1024;
    $config['max_height'] = 768;
			*/
	$this->load->library('upload', $config);

    if ($this->upload->do_upload($partner_logo_file_field_name)){
        // Image uploaded successfully
        $data = $this->upload->data();
		//  print_r($data);
		$data['custom_msg'] = 'Image uploaded: ' . $data['file_name'];
        return $data;
    } else {
        // Image upload failed, show error messages
        return $this->upload->display_errors();
			}
			}
			
		public function lender_list(){
					$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/lender_list";
		$config["total_rows"] = $this->Surgemodel->getCountLenderList();
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getLenderList($config["per_page"], $page);
		$data['page'] = $page;
		$this->load->view('lender_list',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function add_lender(){
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			
			//  echo "add_lender";
		$this->load->view('template-surgeModuleP2P/nav');
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function scheme_list(){
						$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/scheme_list";
		$config["total_rows"] = $this->Surgemodel->getCountSchemeList();
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getSchemeList($config["per_page"], $page,"");
		$data['page'] = $page;
		$this->load->view('scheme_list',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function add_scheme_form(){
			
			$where = "";
			
			$schemeData = $this->Surgemodel->getSchemeList(1, 0,array('id'=>$this->input->get('id')));
			$data['lists'] = $schemeData[0];
			$data['borrower_classifier'] = 	$this->Surgemodel->getProfessionList();
			$data['occupation_list'] = 	$this->Surgemodel->getOccupationList();
			$data['lists']['partnersData'] = $this->Surgemodel->getPartnersList(100,0,$where);
			
			
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			$this->load->view('template-surgeModuleP2P/nav');
			//  echo "add_scheme";
			$this->load->view('add_scheme_form',$data);
		
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function update_scheme(){
			 
			$updateSchemeResp = $this->Surgemodel->update_scheme();
				
			$scheme_id = $updateSchemeResp['scheme_id'];
		
					if($updateSchemeResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $updateSchemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_scheme_form?id='.$scheme_id);
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $updateSchemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_scheme_form?id='.$scheme_id);
					}  
		}
		
			public function add_scheme(){
					
			$updateSchemeResp = $this->Surgemodel->add_scheme();
			$scheme_id = $updateSchemeResp['scheme_id'];
		
					if($updateSchemeResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $updateSchemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_scheme_form?id='.$scheme_id);
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $updateSchemeResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_scheme_form?id='.$scheme_id);
					}  
		}
		
		public function user_list(){
			$where = "";
			$whereIn = array('role_id'=>array(10,11,12));
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/user_list";
		$config["total_rows"] = $this->Surgemodel->getCountUserList($where, $whereIn);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
		$data['lists'] = $this->Surgemodel->getUserList($config["per_page"], $page,$where,$whereIn);
		
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$this->load->view('user_list',$data);
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function add_user_form(){
			$whereIn = ""; //array('id'=>array(10,11,12));
			
			$userData = $this->Surgemodel->getUserList(1, 0,array('admin_id'=>$this->input->get('id')),$whereIn);
			$data['lists'] = $userData['0'];
			$data['lists']['partnersData'] = $this->Surgemodel->getPartnersList(100,0,$where);
			$data['lists']['AdminRoleData'] = $this->Surgemodel->getAdminRoleList($where,$whereIn);
			
			
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			$this->load->view('template-surgeModuleP2P/nav');
			$this->load->view('add_user_form',$data);
		
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function update_user(){
			 
			$updateUserResp = $this->Surgemodel->update_user();
			$user_id = $updateUserResp['user_id'];
		
					if($updateUserResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $updateUserResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_user_form?id='.$user_id);
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $updateUserResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_user_form?id='.$user_id);
					}  
		}
		
			public function add_user(){
					
			$updateUserResp = $this->Surgemodel->add_user();
			
			$user_id = $updateUserResp['user_id'];
		
					if($updateUserResp['status']==1){
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $updateUserResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/user_list?id='.$user_id);
					}else{
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $updateUserResp['msg']));
							redirect(base_url() . 'surgeModuleP2P/surge/add_user_form?id='.$user_id);
					}  
		}
		
		public function redemption_list_pending(){
			$status = array(1); // approval pending
							$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_pending";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatus($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionList($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('redemption_list_pending',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
				public function redemption_list_pending_v2(){
			$status = array(0); // approval pending 
			//$encrypted_data = encrypt_string("Dheeraj");
		//	echo $encrypted_data;
			
		//	echo "Decrypted Data:".decrypt_string($encrypted_data);
							$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_pending_v2";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatusV2($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionListV2($config["per_page"], $page,$status,$this->vendor_id);
			$data['request_id'] = $this->generate_reqquest_id();
		$data['page'] = $page;
		//  echo "<pre>"; print_r($data['lists']);
		$this->load->view('V2/redemption_list_pending',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function generate_reqquest_id(){
				$requestId = uniqid("req_batch_",true);
				$requestIdEncoded =  base64_encode(base64_encode($requestId));
				$this->session->set_userdata('request_id', $requestId);
				return $requestIdEncoded;
		}
		
		public function validating_request_id($userRequestId){ // The function will validate only once, and then it will be removed from the session.
			$userRequestIdDecoded  = base64_decode(base64_decode($userRequestId));
				$sessionRequestId = $this->session->userdata('request_id');
				
				$this->session->unset_userdata('request_id');
				if ($userRequestIdDecoded !== $sessionRequestId) {
					$this->output->set_status_header(400)->set_output('Unauthorized access. Please log in.'); exit();
						return false;
				}else{
					return true;
				}
		}
		
		public function redemption_list_generate_bank_file_v2(){
			
			$status = array(5);// pending for genertion of redemption file
							$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_generate_bank_file_v2";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatusV2($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionListV2($config["per_page"], $page,$status,$this->vendor_id);
		$data['request_id'] = $this->generate_reqquest_id();
		$data['page'] = $page;
		$this->load->view('V2/redemption_list_generate_bank_file',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		} 
		
			public function redemption_list_under_process_v2(){
			$status = array(2); // under process
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_under_process_v2";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatusV2($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionListV2($config["per_page"], $page,$status,$this->vendor_id);
		$data['request_id'] = $this->generate_reqquest_id();
		$data['page'] = $page;
		$this->load->view('V2/redemption_list_under_process',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		
		public function redemption_list_redeemed_v2(){
			$status = array(4);
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_redeemed_v2";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatusV2($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionListV2($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('V2/redemption_list_redeemed',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function redemption_list_generate_bank_file(){
			
			$status = array(5);// pending for genertion of redemption file
							$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_generate_bank_file";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatus($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionList($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('redemption_list_generate_bank_file',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		
		
		
		public function redemption_list_under_process(){
			$status = array(2); // under process
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_under_process";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatus($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionList($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('redemption_list_under_process',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function redemption_list_redeemed(){
			$status = array(4);
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/redemption_list_redeemed";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatus($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionList($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('redemption_list_redeemed',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function redemption_list_all(){
		
		}
		
			public function update_investment_status(){
				$ids = $this->input->post('ids');
				$investmentStatus = $this->input->post('status');
				$remarks = $this->input->post('remarks');

						/************starting of generate bank file function use*****************/
				if($investmentStatus==2){ // generate_bank_file 
				$csv_data = $this->generate_bank_file_excel($ids);
			$update_investment_status =	$this->Surgemodel->update_investment_status($investmentStatus, $ids,$remarks);
			$update_investment_status = (array)json_decode($update_investment_status,true);
			$update_investment_status['csv_data'] = $csv_data;
			echo json_encode($update_investment_status);
					/******ending of generate bank file function use**********/
			}else{
			echo	$update_investment_status =	$this->Surgemodel->update_investment_status($investmentStatus, $ids,$remarks);
			}
				
		}
		
		public function update_investment_status_v2(){
			
			  $req_batch_id = $this->input->post('request_id');
			  
					if(!$this->validating_request_id($req_batch_id)){ return; } // validating request_id
			  
				$ids = $this->input->post('ids');
				$investmentStatus = $this->input->post('status');
				$payment_type = $this->input->post('payment_type');
				$remarks = $this->input->post('remarks');
				$investment_no = $this->input->post('investment_no'); 

						/************starting of generate bank file function use*****************/
				if($investmentStatus==2){ // under process; this is a next step after Bank file is generated
				
				$razorPayxResp = "NA";
				
				    $exploded_ids = explode(",",$ids);
				
				   $idsArray = "";
						for($i=0; $i<count($exploded_ids); $i++){
							$explodeRequest = explode("||",base64_decode($exploded_ids[$i])); // base64_encode($unique_id."||".$list['investment_No']."||".$list['payout_type'])
							$ids           = $explodeRequest[0];
							$investment_no = $explodeRequest[1];
							$payment_type  = $explodeRequest[2]; 
							$lender_id  =    $explodeRequest[3]; 
							$payout_amount = $explodeRequest[4]; 
							$idsArray.= $ids.",";
							
							if($lender_id==""){ return "Invalid Lender ID.";}
							
							$razorpayx_create_contact_data = $this->Surgemodel->getMasterRazorpayPayoutContactByLenderId($lender_id);

							if($razorpayx_create_contact_data==""){
							$razorPayxResp = $this->razorpayx_create_contact($lender_id,$req_batch_id);
							}
							$razorpayx_create_contact_data = $this->Surgemodel->getMasterRazorpayPayoutContactByLenderId($lender_id);
							
							$fund_account_id = $razorpayx_create_contact_data['resp_fund_account_id'];
							
							if($fund_account_id!=""){
								
								$perform_razorpay_payout_resp = json_decode($this->razorPayxPerform_razorpay_payout($razorpayx_create_contact_data,$payout_amount,$investment_no),true);
								
								if($perform_razorpay_payout_resp['id']!=""){ $investmentStatus = 4; /* redeem*/  }
							}
							
							
							
							 
						//	echo "Investment Status".$investmentStatus."\n\n\r";//.($perform_razorpay_payout_resp['error']['description']);
							$update_investment_status_v2 =	$this->Surgemodel->update_investment_status_v2($investmentStatus, $ids,$remarks,$payment_type,$investment_no,json_encode($perform_razorpay_payout_resp),$req_batch_id);
							$update_investment_status_v2 = (array)json_decode($update_investment_status_v2,true);
						}


		         	$csv_data = $this->generate_bank_file_excel_v2($idsArray);
			
					
						$update_investment_status_v2['csv_data'] = $csv_data;
					echo json_encode($update_investment_status_v2);
					/******ending of generate bank file function use**********/
					}else{
			echo	$update_investment_status_v2 =	$this->Surgemodel->update_investment_status_v2($investmentStatus, $ids,$remarks,$payment_type,$investment_no,$razorPayxResp,$req_batch_id);
			 }
				
		}
		
		public function investment_list(){
		
			$status = array(4,2,5,1,0);
			
		$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/investment_list";
		$config["total_rows"] = $this->Surgemodel->getCountRedemptionListStatus($status,$this->vendor_id);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getRedemptionList($config["per_page"], $page,$status,$this->vendor_id);
		$data['page'] = $page;
		$this->load->view('investment_list',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		
		
		}
		
		
		public function ticket_list(){
				$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/ticket_list";
		$config["total_rows"] = $this->Surgemodel->getCountTicketList();
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	//	echo $page;
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$data['lists'] = $this->Surgemodel->getTicketList($config["per_page"], $page);
		
		$data['page'] = $page;
		$this->load->view('ticket_list',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
			public function ticket_detail_form(){
				$config = array();
		$config["base_url"] = base_url() . "surgeModuleP2P/surge/ticket_detail_form";
		$ticket_id = base64_decode($this->input->get('id'));
		$this->load->view('template-surgeModuleP2P/header');
		$this->load->view('template-surgeModuleP2P/nav');
		$single_ticket_data = $this->Surgemodel->getSingleTicket($ticket_id);
		
		$data['lists'] = $single_ticket_data[0];
		$data['lists']['comments_list'] = $this->Surgemodel->getTicketCommentList($ticket_id);
	//	print_r($data['lists']);
		$data['page'] = $page;
		$this->load->view('ticket_detail_form',$data);
		
		$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function raise_ticket(){
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			
			//  echo "raise_ticket";
		$this->load->view('template-surgeModuleP2P/nav');
		$this->load->view('raise_ticket_form');
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function insert_raise_ticket(){
			

			$dataResp = $this->Surgemodel->insert_raise_ticket();
			$msg = $dataResp['msg'];
			if($dataResp['status']==1){
			
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'surgeModuleP2P/surge/raise_ticket');
			
			}else if($dataResp['status']==2){
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
							redirect(base_url() . 'surgeModuleP2P/surge/raise_ticket');
						}else{
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'surgeModuleP2P/surge/raise_ticket');
			
						}
		}
		
		
		public function comment_ticket(){
			

			$dataResp = $this->Surgemodel->comment_ticket();
			$msg = $dataResp['msg'];
			$ticket_id = base64_encode($dataResp['ticket_id']);
			if($dataResp['status']==1){
			
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'surgeModuleP2P/surge/ticket_detail_form?id='.$ticket_id);
			
			}else if($dataResp['status']==2){
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
							redirect(base_url() . 'surgeModuleP2P/surge/ticket_detail_form?id='.$ticket_id);
						}else{
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'surgeModuleP2P/surge/ticket_detail_form?id='.$ticket_id);
			
						}
		}
		
		public function generate_bank_file_excel_v2($ids){
	
	     	$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$delimiter = ",";
			$newline = "\r\n";
			$respResultSet = $this->Surgemodel->generate_bank_file_excel_v2($ids);
			$projectName = "Bank_file_V2_";
			//print_r($respResultSet);
			if($respResultSet){
					$filename = $projectName."__product_from-".$start_date." To-".$end_date.".csv";
				   //	echo $respResultSet;
				$data = $this->dbutil->csv_from_result($respResultSet, $delimiter, $newline);
			//	force_download($filename, $data);
					return $data;
				}else{
					return "hello data";
				}
		}
		
		public function generate_bank_file_excel($reinvestment_id){
	
	     	$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$delimiter = ",";
			$newline = "\r\n";
			$respResultSet = $this->Surgemodel->generate_bank_file_excel($reinvestment_id);
			$projectName = "Bank_file";
			//print_r($respResultSet);
			if($respResultSet){
					$filename = $projectName."__product_from-".$start_date." To-".$end_date.".csv";
				   //	echo $respResultSet;
				$data = $this->dbutil->csv_from_result($respResultSet, $delimiter, $newline);
			//	force_download($filename, $data);
					return $data;
				}else{
					return "hello data";
				}
		}
		
		
		function check_role(){
						/*
					$controller_name = $this->uri->segment(3);
					$user_permissions = explode(',',str_replace(["\n", "\r"],'',$this->session->userdata('admin_access')));
					$havePermission = TRUE;
					$msg = "Please Login First";
					if(in_array($controller_name, $user_permissions)){
						$havePermission = TRUE;
						$msg = "You have permission";
					//	echo "You have permission: ".$controller_name;
					}else{
						$havePermission = FALSE;
						$msg = "You don't have permission of this page ";
					//	echo "You don't have permission of this page ".$controller_name;
					}			*/
			
				if ($this->session->userdata('admin_state') === TRUE ) { // && $havePermission === TRUE
		
			}else {
			
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
					redirect(base_url() . 'login/Logoutadmin');
				   }
		}
		
		public function change_password(){
			//$this->load->view('templates/teamheader');
			$this->load->view('template-surgeModuleP2P/header');
			
			//  echo "change_password";
		$this->load->view('template-surgeModuleP2P/nav');
			$this->load->view('template-surgeModuleP2P/footer');
		}
		
		public function sign_out(){
				redirect(base_url() . 'login/Logoutadmin');
		}
		
		
		public function razorPayxPerform_razorpay_payout($razorpayx_create_contact_data,$payout_amount,$investment_no){
						 $this->load->helper('razorpay');
						$array = [
						"account_number" => $razorpayx_create_contact_data['bnk_account_number'], //"002066200000196",
						"fund_account_id" => $razorpayx_create_contact_data['resp_fund_account_id'],//"fa_OhVNCX62rcrDF8",
						"amount" => $payout_amount,
						"currency" => "INR",
						"mode" => "IMPS",
						"purpose" => "payout",
						"queue_if_low_balance" => false,
						"reference_id" => $investment_no,
						"narration" => "Antworks Fund Transfer",
						"notes" => [
						"notes_key_1" => "Lender ID:".$razorpayx_create_contact_data['lender_id'],
						"notes_key_2" => "Investment No:".$investment_no,
						]
						];

						$payoutApiResp =  perform_razorpay_payout($array,$investment_no); // helper function
						
						/***req_***/
						$array['notes_key_1'] = ($array['notes']['notes_key_1']);
						$array['notes_key_2'] = ($array['notes']['notes_key_2']);
						unset($array['notes']);
						$arrayForInsertion1 = $this->prependKeyPrefix($array, "req_");
							/****req_****/
	

												/***res_***/
						$payoutApiRespArray = json_decode($payoutApiResp,true);
						
						$payoutApiRespArray['notes_key_1'] = ($payoutApiRespArray['notes']['notes_key_1']);
						$payoutApiRespArray['notes_key_2'] = ($payoutApiRespArray['notes']['notes_key_2']);
						unset($payoutApiRespArray['notes']);
						
						
						$payoutApiRespArray['status_details_description'] = ($payoutApiRespArray['status_details']['description']);
						$payoutApiRespArray['status_details_source'] = ($payoutApiRespArray['status_details']['source']);
						$payoutApiRespArray['status_details_reason'] = ($payoutApiRespArray['status_details']['reason']);
						$payoutApiRespArray['message'] = json_encode($payoutApiRespArray['error']);
						unset($payoutApiRespArray['status_details']);
						unset($payoutApiRespArray['error']);
						//echo"<pre>"; print_r(json_encode($payoutApiRespArray['error'])); die();
						$arrayForInsertion2 = $this->prependKeyPrefix($payoutApiRespArray, "res_");
							/****res_****/
						$combinedArray = array_merge($arrayForInsertion1,$arrayForInsertion2);
					//	echo"<pre>"; print_r($combinedArray); die();
							
					//	die();
						
						$payoutDataBaseInsertResp = $this->Surgemodel->add_razorPayxPerform_razorpay_payout($combinedArray);
						
						return $payoutApiResp;
		}
		
		
		function prependKeyPrefix($array, $prefix) {
    $prefixedArray = [];
    foreach ($array as $key => $value) {
        // If the value is an array, apply prefix recursively
       
        $prefixedArray[$prefix . $key] = $value;
    }
    return $prefixedArray;
}
		
		public function razorpayx_create_contact($lender_id,$batch_id){ // 2024-august-05 Dheeraj Dutta
                          $this->load->helper('razorpay');
					//	$lender_id = 'LR10002410';
						$lenderDetails = $this->Surgemodel->getLenderDetailsByLenderId($lender_id);
						
					if($lenderDetails!=""){
						
						$customer_name = $lenderDetails['name']; "Dheeraj Dutta";
						$email = $lenderDetails['email']; //"dheeraj.dutta2002@gmail.com";
						$contact = $lenderDetails['contact']; //"9213855703";
						$type = $lenderDetails['type'];//"customer";
						$reference_id = $lender_id;
						
						$notes_input = "LendSocial Lender Payout User Creation";
						
						$account_type = $lenderDetails['account_type']; 
						$ifsc = $lenderDetails['ifsc'];
						$account_number = $lenderDetails['account_number']; 
						

								$resp_contact =	create_razorpay_contact($customer_name, $email, $contact, $type, $reference_id, $batch_id, $notes_input);
								
								
								$respArray_contact = json_decode($resp_contact,true);
								
								if(isset($respArray_contact['error'])){
									
									$error = $respArray_contact['error'];
									$request_data['status'] = 0;
									$request_data['msg'] = $error ;
										
								}else{
									$request_data['status'] = 1;
									$contact_id = $respArray_contact['id'];
								$resp_fund_account = create_razorpay_fund_account($contact_id, $account_type,$customer_name,$ifsc,$account_number);
								$respArray_fund_account = json_decode($resp_fund_account,true);
								}
								
								$request_data['msg'] = "success";
								$request_data['lender_id'] = $lender_id;
								$request_data['name'] = $customer_name;
								$request_data['email'] = $email;
								$request_data['contact'] = $contact;
								$request_data['type'] = $type;
								$request_data['reference_id'] = $reference_id;
								$request_data['batch_id'] = $batch_id;
								$request_data['notes'] = $notes_input;
								$request_data['response_json'] = json_encode($respArray_contact);
								$request_data['resp_contact_id'] = $contact_id;
								$request_data['resp_created_at'] = $respArray_contact['created_at'];
								$request_data['notes'] = json_encode($request_data['notes']);
								
								
								
								
								
								$request_data['bnk_response_json'] = json_encode($respArray_fund_account);
		                        $request_data['resp_fund_account_id'] = $respArray_fund_account['id'];
		                        $request_data['bnk_active'] = (boolean)$respArray_fund_account['active'];
								
								$request_data['bnk_account_type'] = $account_type;
								$request_data['bnk_ifsc'] = $ifsc;
								$request_data['bnk_account_number'] = $account_number;
								
								$this->Surgemodel->add_razorpayx_create_contact($request_data);
		}else{
			$request_data['status'] = 0;
			$request_data['msg'] = "Data Not Found.";
			
		}
						//	echo json_encode($request_data);
							return json_encode($request_data);

		}	

		
	


}
