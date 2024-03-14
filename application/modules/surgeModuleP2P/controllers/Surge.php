<?php

class Surge extends CI_Controller
{			
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Surgemodel');
		$this->load->helper('url');
		$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
		//$this->load->model('Common_model');
		$this->load->library('form_validation');
		$this->load->helper('custom');
		$this->load->library('pagination');
		
		error_reporting(0);
					$database_name = $this->cldb->database;
			//	echo "Database Name: ".$database_name;
			$this->check_role();
		$this->partner_id = $this->session->userdata('partner_id');
		//	print_r($this->session->userdata());
		$this->session->set_userdata(array("partnerInfo"=>$this->Surgemodel->getPartnersList(1, 0,"")));
	}

		
	
	
	public function dashboard(){	
		//	echo "Partner: ".$this->partner_id;
		//  print_r($this->session->userdata('role'));
			$data['lists']['partnersData'] = $this->Surgemodel->getPartnersList(100,0,"");
			$data['lists']['schemeList'] = $this->Surgemodel->getSchemeList(100, 0,"");
			$data['lists']['dashboardData']['TodayInvestment'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TodayInvestmentNoOfInvestor'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TodayRedemption'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TodayRedemptionNoOfInvestor'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");

			$data['lists']['dashboardData']['TotalInvestment'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0),"");
			$data['lists']['dashboardData']['TotalInvestmentOutstanding'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TotalInvestmentRedeemed'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TotalInvestmentInvestor'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['AverageROI'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['InterestOutstanding'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['TotalInterestPaidOnRedeemedInvestment'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['AverageInvestment'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['OutstandingInvestmentNoInvestor'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");
			$data['lists']['dashboardData']['RedeemedInvestmentNoInvestor'] = $this->Surgemodel->getDashboardDataCount("p2p_lender_investment",array("redemption_status"=>0, 'Date(created_date)'=>date("Y-m-d")),"");	
			//$this->load->view('templates/teamheader');
				
			$this->load->view('template-surgeModuleP2P/header');

				
		$this->load->view('template-surgeModuleP2P/nav');
		$this->load->view('dashboard',$data);
			$this->load->view('template-surgeModuleP2P/footer');
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
			 
			$addPartnerResp = $this->Surgemodel->add_partner();
			
			if($addPartnerResp['status']==1){
			$partners_id = $addPartnerResp['insert_id'];
			
			if($partners_id!=""){
			$uploadImageResp = $this->upload_image($partners_id);
			$addThemeResp = $this->Surgemodel->add_theme($partners_id,$uploadImageResp['full_path']);
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
				//	print_r($this->input->post()); die();echo"<pre>";
			//	print_r($updatePartnerResp); 
				//		print_r($this->input->post()); die();
			$updatePartnerResp = $this->Surgemodel->update_partner();
			$partners_id = $updatePartnerResp['partner_id'];
			if($partners_id!=""){
			$uploadImageResp = $this->upload_image($partners_id);
			$updateThemeResp = $this->Surgemodel->update_theme($partners_id,$uploadImageResp['full_path']);
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
		
		public function upload_image($vendor_id){
		
		$directoryPath  = './document\surge\upload/vendor/'.$vendor_id;
    
	if (!is_dir($directoryPath)) {          if (!mkdir($directoryPath, 0777, true)) {      die('Failed to create directory');     }    } 
	$config['upload_path'] =  $directoryPath;
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = 8048; // 2MB
	/*
   $config['max_width'] = 1024;
    $config['max_height'] = 768;
			*/
	$this->load->library('upload', $config);

    if ($this->upload->do_upload('partner_logo_file')){
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
		
		
		
	


}
