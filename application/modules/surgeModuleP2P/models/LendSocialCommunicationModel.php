<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LendSocialCommunicationModel extends CI_Model{
	
				public function __construct(){

				parent::__construct();

				$this->antapp_db = $this->load->database('app', TRUE);

				$this->sessionData = $this->session->userdata();

				}
	
	
	
				/******************start of sendEmail function**********************/
				public function sendEmail($product_type_id, $instance_id,$input_data) 
				{	 
				 
			
				$mobileLender = $input_data['mobileLender'];
				$mobileBorrower = $input_data['mobileBorrower'];
				$partner_id = $input_data['partner_id'];
				
				$scheme_id = $input_data['scheme_id'];
				$user_id = $input_data['user_id'];

				$respData['mail_type']['product_type'] = $product_type_id;
				$respData['mail_type']['instance_name'] = $instance_id;
				$respData['user_data_byUserId'] = $this->getUserData($user_id); // table admin_user_list
				$respData['user_data_byUserId']['input_value'] = $user_id;
				$respData['lender_data_byLenderMobileNo'] = $this->getLenderDetails($mobileLender);
				$respData['lender_data_byLenderMobileNo']['input_value'] = $mobileLender;
				$respData['borrower_data_byBorrowerMobileNo'] = $this->getBorrowerDetails($mobileBorrower);
				$respData['borrower_data_byBorrowerMobileNo']['input_value'] = $mobileBorrower;
				$respData['partner_data_byParterId'] = $this->getPartnerDetails($partner_id);
				$respData['partner_data_byParterId']['input_value'] = $partner_id;
				$respData['scheme_data_bySchemeId'] = $this->getSchemeDetails($scheme_id);
				$respData['scheme_data_bySchemeId']['input_value'] = $scheme_id;
				
				// return $respData;
				
					// Assigning variables from $respData array without 'input_value'
					$user_data_byUserId = $respData['user_data_byUserId'];
					$lender_data_byLenderMobileNo = $respData['lender_data_byLenderMobileNo'];
					$borrower_data_byBorrowerMobileNo = $respData['borrower_data_byBorrowerMobileNo'];
					$partner_data_byParterId = $respData['partner_data_byParterId'];
					$scheme_data_bySchemeId = $respData['scheme_data_bySchemeId'];

				//replace template var with value
				$token = array(
				'PARTNER_NAME' => $partner_data_byParterId['Company_Name'],
				'PARTNER_CONTACT_NO' => $partner_data_byParterId['Phone'],

				'SITE_URL' => 'https://www.antworksp2p.com/',
				'SITE_NAME' => 'lend-social',
		
				'NAME' => $user_data_byUserId['fname']." ".$user_data_byUserId['lname'],
				'MOBILE' => $user_data_byUserId['mobile'],
				
				'SCHEMENAME' => $scheme_data_bySchemeId['Scheme_Name'],
				
				'LEND_SOCIAL_LOGIN_URL' => '<a href="https://www.antworksp2p.com/login/admin-login">https://www.antworksp2p.com/login/admin-login</a>',
				'USER_EMAIL' => $input_data['user_email'],
				'PASSWORD' => $input_data['password'],
				
				//'LOAN_APPLICATION_NO' => "202404311158",
				);
				$pattern = '[%s]';
				foreach ($token as $key => $val) {
				$varMap[sprintf($pattern, $key)] = $val;
				}
				
				$result = $this->get_notification($product_type_id, $instance_id);
				$msg = strtr($result->email_content, $varMap);
					
			//	return $msg;
				
				$email_config = $this->emilConfiguration();				
				$config = array(
				'protocol'  => $email_config['protocol'],  // 'smtp',
				'smtp_host' => $email_config['smtp_host'],  //'smtp.netcorecloud.net',
				'smtp_port' => $email_config['smtp_port'],  //587,
				'smtp_user' => $email_config['smtp_user'],  //'creditdoctoreapi',
				'smtp_pass' => $email_config['smtp_pass'],  //'ecef&8d05fd04',
				'mailtype'  => $email_config['mailtype'],  //'html',
				'charset'   => $email_config['charset'],  //'iso-8859-1'
				);
			
			
		
           // $this->email->attach($attched_file_invoice);
         
			//return $result;
			
				$this->load->library('email',$config);
				$this->email->initialize($config); // initialize with smtp configs
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
				//$this->email->from('support@antworksmoney.com', 'Antpay');
				$this->email->from('support@creditdoctor.in', 'lend-social');
				$this->email->to("dheeraj.antworks@gmail.com");// change it to yours
				$this->email->cc("dheeraj.antworks@gmail.com");// change it to yours
				$this->email->subject($result->instance);
				$this->email->message($msg);
				
				if ($this->email->send()) {
				//return "true";
				} else {
				return "false".$this->email->print_debugger();
				} 
						
				}
				/*****************end of sendEmail function****************/
	
	
				/********************start of notification function******************/
				public function get_notification($product_type_id, $instance_id)
				{
				$this->antapp_db->select('AC.*,ACI.instance_name');
				$this->antapp_db->from('antpay_communication AC');
				$this->antapp_db->join('antpay_communication_instance AS ACI', 'ON ACI.id = AC.instance', 'left');
				$this->antapp_db->where('AC.product_type', $product_type_id);
				$this->antapp_db->where('AC.instance', $instance_id);
				$query = $this->antapp_db->get();
			//	echo $this->antapp_db->last_query();
				if ($this->antapp_db->affected_rows() > 0) {
				return $query->row();
				} else {
				return false;
				}

				}  /************end of notification function**************/

				/*****************start*****************/
				public function emilConfiguration()
				{
				$this->load->library('email');
				$this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
				$this->db->from('p2p_admin_email_setting');
				$this->db->where('status', 1);
				$query= $this->db->get();
				return $email_config = (array)$query->row();
				}
				/*******************end********************/
	
	
				/***************start of get borrower detail********************/
				function getBorrowerDetails($mobile){
				$query = $this->db->get_where('p2p_borrowers_list', array('mobile' => $mobile));
				return $query->row_array(); // Return user details as an associative array
				}
				/**********************end of get borrower detail********************/
		
					/***************start of get lender detail********************/
					function getLenderDetails($mobile){
					$query = $this->db->get_where('p2p_lender_list', array('mobile' => $mobile));
					return $query->row_array(); // Return user details as an associative array
					}
					/**********************end of get lender detail********************/
				
			
				/***************start of get partner detail********************/
				function getPartnerDetails($partner_id){
				$query = $this->db->get_where('invest_vendors', array('VID' => $partner_id));
				return $query->row_array(); // Return user details as an associative array
				}
				/**********************end of get partner detail********************/

		
					public function getUserData($user_id){

					$this->db->select('p2p_admin_list.*, b.role_name, c.Company_Name as partner_name');
					$this->db->from('p2p_admin_list');
					$this->db->join('p2p_admin_role as b', 'p2p_admin_list.role_id=b.id', 'LEFT');
					$this->db->join('invest_vendors c', 'p2p_admin_list.partner_id=c.VID', 'LEFT');

					$this->db->where("p2p_admin_list.admin_id", $user_id);


					$this->db->limit(1);
					$res = $this->db->get();
					// echo $this->db->last_query(); die();
					return $result = $res->row_array();
					}
					
					
					/***************start of get scheme detail********************/
				function getSchemeDetails($scheme_id){
				$query = $this->db->get_where('invest_scheme_details', array('id' => $scheme_id));
				return $query->row_array(); // Return user details as an associative array
				}
				/**********************end of get scheme detail********************/
}


?>