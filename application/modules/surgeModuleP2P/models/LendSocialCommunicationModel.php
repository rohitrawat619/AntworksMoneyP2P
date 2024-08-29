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
				$attachment_instance_id = "";
				$token['SITE_URL'] = 'https://www.antworksp2p.com/';
				$token['SITE_NAME'] = 'lend-social';
				$ccMailList = "";
				if($input_data['module_name'] == 'user_creation'){
					$userData = $this->getUserData($input_data['user_id']); // table admin_user_list "admin_id"
					 $partnerData = $this->getPartnerDetails($userData['partner_id']);
					$token['NAME'] = $userData['fname']." ".$userData['lname'];
					$token['LEND_SOCIAL_LOGIN_URL'] = '<a href="https://www.antworksp2p.com/login/admin-login">https://www.antworksp2p.com/login/admin-login</a>';
					$token['USER_EMAIL'] = $input_data['user_email'];
					$token['PASSWORD'] = $input_data['password'];
					$toMailList = $userData['email'];
					$ccMailList = $partnerData['Email'];
					
				}else if($input_data['module_name']=="scheme"){
					$userData = $this->getUserData($input_data['user_id']); // table admin_user_list "admin_id"
					$token['NAME'] = $userData['fname']." ".$userData['lname'];		
					$schemeData = $this->getSchemeDetails($input_data['scheme_id']);
					$token['SCHEMENAME'] = $schemeData['Scheme_Name'];
					$toMailList = $userData['email'];

				}else if($input_data['module_name']=="InvestmentConfirmation"){
					
					$token['NAME'] = $input_data['investor_name'];
					$token['INVESTMENT_AMOUNT'] = $input_data['investment_amount'];
					$schemeData = $this->getSchemeDetails($input_data['scheme_id']);
					$token['SCHEMENAME'] = $schemeData['Scheme_Name'];
					
					$partnerData = $this->getPartnerDetails($schemeData['Vendor_ID']); // partner ID
					$token['COMPANY_NAME'] = $partnerData['Company_Name'];
					$token['COMPANY_CONTACT'] = $partnerData['Phone']; 
					$token['INVESTMENT_NUMBER'] = $input_data['investment_no'];
					$toMailList = $input_data['investor_email'];
					//print_r($token); die();
				}else if($input_data['module_name']=="OneTimeRegistrationPaymentConfirmation"){
					$token['NAME'] = $input_data['investor_name'];
					$partnerData = $this->getPartnerDetails($input_data['partner_id']); // partner ID
					$token['COMPANY_NAME'] = $partnerData['Company_Name'];
					$token['COMPANY_CONTACT'] = $partnerData['Phone']; 
					$toMailList = $input_data['investor_email'];
					$attachment_instance_id = "Registration Payment Confirmation PDF Attachment";
					
					//$token['INVOICE_AMOUNT'] = $input_data["invoice_amount"];
					//$token['INVOICE_DATE']  = $input_data["invoice_date"];
					//$token1 = array_combine($token,$input_data['USER_DATA']);
				     // echo"<pre>";	print_r($token); die();
				}else{
				/*
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
				$token['PARTNER_NAME'] = $partner_data_byParterId['Company_Name'];
				$token['PARTNER_CONTACT_NO'] = $partner_data_byParterId['Phone'];

				
		
				$token['NAME'] = $user_data_byUserId['fname']." ".$user_data_byUserId['lname'];
				$token['MOBILE'] = $user_data_byUserId['mobile'];
				
				$token['SCHEMENAME'] = $scheme_data_bySchemeId['Scheme_Name'];
				
				$token['LEND_SOCIAL_LOGIN_URL'] = '<a href="https://www.antworksp2p.com/login/admin-login">https://www.antworksp2p.com/login/admin-login</a>';
				$token['USER_EMAIL'] = $input_data['user_email'];
				$token['PASSWORD'] = $input_data['password']; */
				  }
				//'LOAN_APPLICATION_NO' => "202404311158",
				
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
				$this->email->to($toMailList);// 
				if($ccMailList!=""){
									$this->email->cc($ccMailList);// 
				}
				
				if($attachment_instance_id!=""){
					$pattern = '[%s]';
				//	echo"<pre>"; print_r($input_data['USER_DATA']); die();
				foreach ($input_data['USER_DATA'] as $key => $val) {
				$varMapMail[sprintf($pattern, $key)] = $val;
				}
					$htmlTemplateContent = $this->get_notification($product_type_id, $attachment_instance_id);
					//return $htmlTemplateContent; 
					$htmlTemplateContentArray = strtr($htmlTemplateContent->email_content, $varMapMail);
					
					$pdf_file_path = $this->generatePdfFromHTML("",$htmlTemplateContentArray);
					//return $pdf_file_path;
					$this->email->attach($pdf_file_path);
				}
				
				$this->email->bcc("dheeraj.antworks@gmail.com");// change it to yours
				$this->email->subject($result->instance);
				$this->email->message($msg);
				
				if ($this->email->send()) {
				return "true";
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
				
				
						 function generatePdfFromHTML($mobile,$report_view){
							// echo $report_view; die();
							
		require_once APPPATH . "/third_party/mpdf/vendor/autoload.php";
					$file_name = "";
					$document_storage_path = './document/Lendsocial/Invoice/';
					$file_name = $mobile . 'Registration Payment-' . date('Ymdhis') . '.pdf';
					$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'pagenumPrefix' => 'Page | ']);

					//$report_view =  "<h2>Dheeraj Dutta</h2>";
					$mpdf->setFooter('{PAGENO}');
					$mpdf->WriteHTML($report_view, 2);
					if (!is_dir($document_storage_path)) {
					mkdir($document_storage_path, 0777, true); // Creates the directory with permissions
					}
					$mpdf->Output($document_storage_path . $file_name, 'F');
					$attched_file_invoice = FCPATH . str_replace('./','',$document_storage_path). $file_name;
					return $attched_file_invoice;
		}
}


?>