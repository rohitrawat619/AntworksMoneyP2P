<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Kycapi extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
		$this->load->model('kyc_engine_model');
		$this->load->library('middleware');
        //$this->cldb = $this->load->database('credit-line', TRUE);
        // Enable error reporting
        error_reporting(E_ALL);
    }
	
	public function all_in_one_kyc_post(){
		$_POST = json_decode(file_get_contents('php://input'),true);
		 $auth = $this->middleware->client_auth();
        if ($auth) { 
			$postData = $this->input->post();
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('fullname','fullname','trim|required');
			#validation for PAN
			$this->form_validation->set_rules('pan','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
			#validation for Aadhar		
			$this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|required|numeric|exact_length[12]');
			#validation for Account
			$this->form_validation->set_rules('account_no','account_no','required');
			$this->form_validation->set_rules('caccount_no','caccount_no','required|matches[account_no]'); 
			$this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
			
			$this->form_validation->set_rules('dob','DOB','required');
			$this->form_validation->set_rules('gender','Gender','required');
			$this->form_validation->set_rules('occuption_id','Occuption','required');
			$this->form_validation->set_rules('company_type','Company Type','required');
			$this->form_validation->set_rules('company_name','Company Name','required');
			$this->form_validation->set_rules('company_code','Company Code','required');
			$this->form_validation->set_rules('highest_qualification','Qualification','required');
			$this->form_validation->set_rules('r_pincode','Pincode','required');
			$this->form_validation->set_rules('r_city','City','required');
			$this->form_validation->set_rules('r_state','State','required');
			$this->form_validation->set_rules('r_state','State','required');
			$this->form_validation->set_rules('net_monthly_income','Net Monthly Income','required');
			$this->form_validation->set_rules('user_type','User Type','required');
			$this->form_validation->set_rules('source','Source','required');
			
			if ($this->form_validation->run() == TRUE) {
				$response = $this->kyc_engine_model->kyc_send_aadhar_otp_engine();
				
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		 }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); 
	}
	public function all_in_one_kyc_submit_otp_post(){
		$_POST = json_decode(file_get_contents('php://input'),true);
		 $auth = $this->middleware->client_auth();
        if ($auth) { 
			$postData = $this->input->post();
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
			/* $this->form_validation->set_rules('fullname','fullname','required');
			#validation for PAN
			$this->form_validation->set_rules('pan','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
			#validation for Account
			$this->form_validation->set_rules('account_no','account_no','required');
			$this->form_validation->set_rules('caccount_no','caccount_no','required|matches[account_no]'); 
			$this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
			#validation for Aadhar		
			$this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|required|numeric|exact_length[12]'); */
			$this->form_validation->set_rules('user_type','User Type','required');
			$this->form_validation->set_rules('source','Source','required');
			$this->form_validation->set_rules('kyc_unique_id','kyc_unique_id','required');
			
			//$this->form_validation->set_rules('otp','Otp','required');
			//$this->form_validation->set_rules('transactionId','Transaction Id','required');
			//$this->form_validation->set_rules('codeVerifier','codeVerifier','required');
			//$this->form_validation->set_rules('fwdp','fwdp','required');
			
			
			if ($this->form_validation->run() == TRUE) {
				
				$this->db->get_where('all_kyc_api_log', array('mobile' => $this->input->post('mobile'),'kyc_api_status'=>1));
				//echo $this->db->last_query();exit;
				if ($this->db->affected_rows() > 0) {
						$response['status'] = 0;
						$response['msg'] = "Full KYC Done";
					
				}else{
				   $response = $this->kyc_engine_model->kyc_submit_otp_engine();
				}
				
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		}
     $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);	
		
	}
	public function all_in_one_kyc_status_post(){
		$_POST = json_decode(file_get_contents('php://input'),true);
		 $auth = $this->middleware->client_auth();
        if ($auth) { 
			$postData = $this->input->post();
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('pan','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('user_type','User Type','required');
			if ($this->form_validation->run() == TRUE) {
				
				 $response = $this->kyc_engine_model->kyc_status();
				
				
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		}
     $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);	
		
	}
#Client API Example -Ektara	
  public function pan_validate_post(){
	  $_POST = json_decode(file_get_contents('php://input'),true);
	  $auth = $this->middleware->client_auth();
        if ($auth) {
				$postData = $this->input->post();
				
				$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
				$this->form_validation->set_rules('fullname','fullname','required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				#validation for PAN
				$this->form_validation->set_rules('pan','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
				$this->form_validation->set_rules('user_type','User Type','required');
				$this->form_validation->set_rules('source','Source','required');
				if ($this->form_validation->run() == TRUE) {
					  $response = $this->kyc_engine_model->basic_pan_kyc();
					
					$this->set_response($response, REST_Controller::HTTP_OK);
					return;
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
				}
		}
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}
	public function bank_validate_post(){
		$_POST = json_decode(file_get_contents('php://input'),true);
	   $auth = $this->middleware->client_auth();
        if ($auth) {
				$postData = $this->input->post();
				//pr($postData);exit;
				$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
				$this->form_validation->set_rules('fullname','fullname','required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				#validation for Account
				$this->form_validation->set_rules('account_no','account_no','required');
				$this->form_validation->set_rules('caccount_no','caccount_no','required|matches[account_no]'); 
				$this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
				$this->form_validation->set_rules('user_type','User Type','required');
				$this->form_validation->set_rules('source','Source','required');
				if ($this->form_validation->run() == TRUE) {
					  
					 $response = $this->kyc_engine_model->bank_kyc();
					$this->set_response($response, REST_Controller::HTTP_OK);
					return;
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
				}
		}
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}
   public function aadhar_send_otp_post(){
	   $_POST = json_decode(file_get_contents('php://input'),true);
	   $auth = $this->middleware->client_auth();
        if ($auth) {
			$postData = $this->input->post();
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('fullname','fullname','required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|required|numeric|exact_length[12]');
			$this->form_validation->set_rules('user_type','User Type','required');
			$this->form_validation->set_rules('source','Source','required');
			if ($this->form_validation->run() == TRUE) {
				$response = $this->kyc_engine_model->aadhar_initiate_okyc_send_otp_api();
				
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		}
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}
    public function aadhar_submit_otp_post(){
		$_POST = json_decode(file_get_contents('php://input'),true);
		$auth = $this->middleware->client_auth();
        if ($auth) {
			$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			
			$this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|required|numeric|exact_length[12]');
			$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
			$this->form_validation->set_rules('transactionId', 'Transaction Id', 'trim|required');
			$this->form_validation->set_rules('codeVerifier', 'Code Verifier', 'trim|required');
			$this->form_validation->set_rules('fwdp', 'FWDP', 'trim|required');
			$this->form_validation->set_rules('validateXml', 'Validate Xml', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$response = $this->kyc_engine_model->aadhar_validate_okyc_submit_otp();
				
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		}
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}
	public function aadhar_validate_without_otp_post(){
			$_POST = json_decode(file_get_contents('php://input'),true);
			$postData = $this->input->post();
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('fullname','fullname','required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|required|numeric|exact_length[12]');
			$this->form_validation->set_rules('user_type','User Type','required');
			$this->form_validation->set_rules('source','Source','required');
			if ($this->form_validation->run() == TRUE) {
				$response = $this->kyc_engine_model->aadhar_validate_without_otp();
				$this->set_response($response, REST_Controller::HTTP_OK);
				return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		
	}
}