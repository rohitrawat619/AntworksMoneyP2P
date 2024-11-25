<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LendSocialmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	//	$this->db_money_money = $this->load->database('db_money', true);
	//  $this->cldb = $this->load->database('credit-line', TRUE);
	$this->cldb = $this->load->database('', TRUE);
	//$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
	//	$this->load->model('Common_model');
			// Get the database name
		//	$this->apiBaseUrlLender = "https://www.antworksp2p.com/surgeapi/investapi/"; dated: 2024-feb-19
			$this->apiBaseUrlLender = "https://www.antworksp2p.com/surgeapi/Investapip2p/"; // dated: 2024-feb-19
			$this->apiBaseUrlKycApi = "https://antworksp2p.com/kycapi/";
			
			
			$this->authorization = 'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==';
			$this->oath_token = "oath_token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjAyMDU1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiOTIxMzg1NTcwMyIsImRldmljZV9pZCI6IiIsImFwcF92ZXJzaW9uIjpudWxsLCJnZW5lcmF0ZWRfdGltZXN0YW1wIjoiMjAyNC0wMi0yMCAxNjowODozNSIsImlwX2FkZHJlc3MiOiI1NC44Ni41MC4xMzkifQ.6o3tDNV52ntG-C26VXjsnCnVk24F9rslkoIRz7cDwiM";
			$this->sessionData = $this->session->userdata();
		
	}
	
	public function investmentRequestListProcessing($requestPayload){
		
					$this->db->set('request_status', 'rejected');		
					$this->db->set('processing_status', '1');
					$this->db->set('rejected_by','lender');
					$this->db->set('request_update_date', date("Y-m-d H:i:s"));	
					$this->db->set('requestor_id', $this->session->userdata('user_id'));	
					$this->db->where('lender_id', $requestPayload['lender_id']);
					$this->db->where('batch_id', $requestPayload['batch_id']);
					$this->db->where('investment_no', $requestPayload['investment_no']);
					$this->db->where('processing_status',0);
					
					$this->db->update('borrower_proposed_list'); 
				
			    if ($this->db->affected_rows() > 0)
					{
						
						$this->db->set('request_status', 'approved');	
						$this->db->where('lender_id', $requestPayload['lender_id']);
						$this->db->where_in('id', explode(',',$requestPayload['borrower_proposed_list_ids']));
						$this->db->where('batch_id', $requestPayload['batch_id']);
						$this->db->where('investment_no', $requestPayload['investment_no']);
						$this->db->update('borrower_proposed_list');  
							$resp['status'] = 1;
							$resp['msg'] = "Updated Successful";
					
				   } else { 
							http_response_code(405);
							$resp['status'] = 0;
							$resp['msg'] = "Updation Failed";
				        }
				
				 return json_encode($resp);
				
				}
	
	public function get_borrower_proposed_list($lender_id, $investment_no)
{
    $this->db->select('a.*, a.id AS borrower_proposed_list_id, b.name AS borrower_name,
                       (SELECT SUM(amount) FROM borrower_proposed_list 
                        WHERE investment_no = ' . $this->db->escape($investment_no) . ' 
                          AND lender_id = ' . $this->db->escape($lender_id) . ' 
                          AND processing_status = 0) AS total_amount', false);
    $this->db->from('borrower_proposed_list a');
    $this->db->join('p2p_borrowers_list b', 'a.borrower_id = b.borrower_id', 'LEFT');
    $this->db->where('a.investment_no', $investment_no);
    $this->db->where('a.lender_id', $lender_id);
    $this->db->where('a.processing_status', 0);
    //$this->db->limit(40);	
    
    $query = $this->db->get();

    return $query->result();  
}

	
	public function e_sign_lender_agreement_send_otp($lenderInfo)
    {
           
            if ($lenderInfo!="") {
               
                $otp = rand(100000, 999999);
                $this->load->model('Smssetting');
                $setting = $this->Smssetting->smssetting();
                
				
                $this->db->select('*');
                $this->db->from('p2p_lender_otp_signature');
                $this->db->where('mobile', $lenderInfo['mobile']);
                $this->db->where('lender_id', $lenderInfo['lender_id']);
                $this->db->where('date_added >= now() - INTERVAL 1 DAY');
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
                    $result = count($query->result_array());
                    if ($result > 1000) {
                        $errmsg = array("error_msg" => "Your tried multiple times please try again");
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    } else {
                        $arr["mobile"] = $lenderInfo['mobile'];
                    $arr["lender_id"] = $lenderInfo['lender_id'];
                        $arr["otp"] = $otp;
						$arr['source'] = 'LSLA';
                        $query = $this->db->insert('p2p_lender_otp_signature', $arr);
                    }
                } else {
						$arr["mobile"] = $lenderInfo['mobile'];
						$arr["lender_id"] = $lenderInfo['lender_id'];
						$arr["otp"] = $otp;
						$arr['source'] = 'LSLA';
						$query = $this->db->insert('p2p_lender_otp_signature', $arr);
                }

             
			 
				$msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
				$msg = "$otp is your Antworks Account verification code - ANTWORKS";
				//            $msg = "Hi (Test Name lenght 10) Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
				$message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => SMS_GATEWAY_USERNAME, 'hash' => SMS_GATEWAY_HASH_API, 'numbers' =>  $lenderInfo['mobile'], "sender" => SMS_GATEWAY_SENDER, "message" => $message);
			
			 $ch = curl_init('https://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseCurl = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($responseCurl, true);
                if ($res['status'] == 'success') {
                    $response = array(
                        'status' => 1,
                        'msg' => 'OTP sent successfully'
                    );
					
                    return json_encode($response);
                } else {
                    $response = array(
                        'status' => 0,
                        'msg' => 'Something went wrong!!'.$responseCurl
                    );
						return json_encode($response);
                }

            } else {
                $errmsg = array("error_msg" => validation_errors());
                return json_encode($errmsg);
            }
       /*  }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     */
	 }
	 
	 
	 	public function e_sign_borrower_proposed_list_send_otp($lenderInfo)
		{
           
            if ($lenderInfo!="") {
               
                $otp = rand(100000, 999999);
                $this->load->model('Smssetting');
                $setting = $this->Smssetting->smssetting();
                
				
                $this->db->select('*');
                $this->db->from('p2p_lender_otp_signature');
                $this->db->where('mobile', $lenderInfo['mobile']);
                $this->db->where('lender_id', $lenderInfo['lender_id']);
                $this->db->where('date_added >= now() - INTERVAL 1 DAY');
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
                    $result = count($query->result_array());
                    if ($result > 1000) {
                        $errmsg = array("error_msg" => "Your tried multiple times please try again");
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    } else {
                        $arr["mobile"] = $lenderInfo['mobile'];
                    $arr["lender_id"] = $lenderInfo['lender_id'];
					 $arr["batch_id"] = $lenderInfo['batch_id'];
                        $arr["otp"] = $otp;
                        $query = $this->db->insert('p2p_lender_otp_signature', $arr);
                    }
                } else {
                    $arr["mobile"] = $lenderInfo['mobile'];
                    $arr["lender_id"] = $lenderInfo['lender_id'];
					 $arr["batch_id"] = $lenderInfo['batch_id'];
                    $arr["otp"] = $otp;
                    $arr["source"] = $otp;
                    $query = $this->db->insert('p2p_lender_otp_signature', $arr);
                }

             
			 
				$msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
				$msg = "$otp is your Antworks Account verification code - ANTWORKS";
				//            $msg = "Hi (Test Name lenght 10) Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
				$message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => SMS_GATEWAY_USERNAME, 'hash' => SMS_GATEWAY_HASH_API, 'numbers' =>  $lenderInfo['mobile'], "sender" => SMS_GATEWAY_SENDER, "message" => $message);
			
			 $ch = curl_init('https://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseCurl = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($responseCurl, true);
                if ($res['status'] == 'success') {
                    $response = array(
                        'status' => 1,
                        'msg' => 'OTP sent successfully',
					    'requestPayloadParm' => $lenderInfo['requestPayloadParm']
                    );
					
                    return json_encode($response);
                } else {
                    $response = array(
                        'status' => 0,
                        'msg' => 'Something went wrong!!'.$responseCurl,
						'requestPayloadParm' => $lenderInfo['requestPayloadParm']
						
                    );
						return json_encode($response);
                }

            } else {
                $errmsg = array("error_msg" => validation_errors());
                return json_encode($errmsg);
            }
       /*  }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     */
	 }
	 	 public function e_sign_verify_lender_agreement_otp($lenderInfo,$otp)
    {

		
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_lender_otp_signature');
        $this->db->where('lender_id', $lenderInfo['lender_id']);
        $this->db->where('mobile', $lenderInfo['mobile']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
		//  return $this->db->last_query();
        if ($this->db->affected_rows() > 0) {
            $result = $query->row();
            if ($otp == $result->otp) {
                if ($result->MINUTE <= 10) {
					
				
				$this->db->set('is_verified', '1');		
				$this->db->where('otp', $otp);
				$this->db->where('lender_id', $lenderInfo['lender_id']);
				$this->db->where('mobile', $lenderInfo['mobile']);
				$this->db->update('p2p_lender_otp_signature', $data);
		
                    return json_encode(array(
                        'status' => '1',
                        'msg' => 'Otp verified'
                    ));
                } else {
                    return json_encode(array(
                        'status' => '0',
                        'msg' => 'Sorry Your OTP is expired please try again'
                    ));
                }
            } else {
                return json_encode(array(
                    'status' => '0',
                    'msg' => 'your OTP is not verified please enter correct OTP'
                ));
            }
        } else {
            return false;
        }
    
    }
	
	
	
		 	 public function e_sign_verify_borrower_proposed_list_otp($lenderInfo,$otp)
    {

		
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_lender_otp_signature');
        $this->db->where('lender_id', $lenderInfo['lender_id']);
        $this->db->where('mobile', $lenderInfo['mobile']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
		//  return $this->db->last_query();
        if ($this->db->affected_rows() > 0) {
            $result = $query->row();
            if ($otp == $result->otp) {
                if ($result->MINUTE <= 10) {
					
				
				$this->db->set('is_verified', '1');	
				$this->db->where('otp', $otp);
				$this->db->where('lender_id', $lenderInfo['lender_id']);
				$this->db->where('mobile', $lenderInfo['mobile']);
				$this->db->update('p2p_lender_otp_signature', $data);
		
                    return json_encode(array(
                        'status' => '1',
                        'msg' => 'Otp verified',
						'requestPayloadParm' => $lenderInfo['requestPayloadParm']
                    ));
                } else {
                    return json_encode(array(
                        'status' => '0',
                        'msg' => 'Sorry Your OTP is expired please try again',
						'requestPayloadParm' => $lenderInfo['requestPayloadParm']
                    ));
                }
            } else {
                return json_encode(array(
                    'status' => '0',
                    'msg' => 'your OTP is not verified please enter correct OTP',
						'requestPayloadParm' => $lenderInfo['requestPayloadParm']
                ));
            }
        } else {
            return false;
        }
    
    }
	
					public function get_master_fee_structure_by_partnerId($partner_id,$userType) //'borrowerRegistrationFee','lenderRegistrationFee'
	{		
		if($userType=="borrowerBullet"){
			$this->cldb->select('a.borrower_partner_registration_fee as partner_registration_fee_charges, a.*');
		}else if($userType=="lender"){
			$this->cldb->select('a.type_of_Lender_platform_fee, a.lender_platform_fee_rupee, a.lender_platform_fee_percentage, a.lender_partner_registration_fee as partner_registration_fee_charges, a.lender_processing_fee_rupee, a.lender_processing_fee_percent, a.lender_pg_charges_bearer');
		}
		
		$this->cldb->from('master_fee_structure a');
		$this->cldb->where(array("a.status"=>1)); // 1:visible; 0:hide  
		$this->cldb->where(array("a.partner_id"=>$partner_id)); // 1:visible; 0:hide  
		$res = $this->cldb->get();

		 $result = $res->result_array();
		// return $this->cldb->last_query();
			return $result;
	}
	
	
	public function array_key_uppercase($array){
				//$upperCaseKeysArray = array_combine(array_map('strtoupper', array_keys($array)),array_values($array));
				$upperCaseKeysArray = array_combine(array_map(function($key) {return strtoupper($key) . '_SESSN';}, array_keys($array)),array_values($array));
				return $upperCaseKeysArray;
				}
				
				
	public function saveRegistrationFee(){
		
				$arr["transactionType"] = $this->input->post('transactionType');
				$arr["user_type"] = $this->input->post('user_type');
				$arr["user_id"] = $this->input->post('user_id');
				$arr["mobile"] = $this->input->post('mobile');
				$arr["amount"] = $this->input->post('amount');
				$arr["razorpay_order_id"] = $this->input->post('razorpay_order_id');
				$arr["razorpay_payment_id"] = $this->input->post('razorpay_payment_id');
				$arr["razorpay_signature"] = $this->input->post('razorpay_signature');
				$arr["ant_txn_id"] = $this->input->post('ant_txn_id');
				$arr["partner_id"] = $this->input->post('partner_id');

				$arr["data_entry_id"] = $this->session->userdata('user_id');
				$arr["data_entry_time"] = date("Y-m-d H:i:s");
				$arr["status"] = 1;
					
                    $query = $this->db->insert('trans_fee_structure', $arr);
						//return $arr;
	
						if ($query) {
							
												/***********start of mail send 2024-Aug-26 Not Yet Commit*************/
					$this->load->model('surgeModuleP2P/LendSocialCommunicationModel');
					$product_type_id = "LendSocialDashboard"; $instance_id = "Registration Payment Confirmation"; //abcd
					$input_data['module_name'] = "OneTimeRegistrationPaymentConfirmation";
					$input_data['partner_id'] = $this->sessionData['partners_id'];
					$input_data['investor_name'] = $this->sessionData['name'];
					$input_data['investor_email'] = $this->sessionData['email_id'];
					$input_data['USER_DATA'] = $this->array_key_uppercase($this->sessionData);
					$input_data['USER_DATA']['INVOICE_AMOUNT'] = $this->input->post('amount');// 749;
					$input_data['USER_DATA']['INVOICE_DATE'] = date("Y-m-d");
					$input_data['USER_DATA']['INVOICE_NO'] = time();
					$respa = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
				//	print_r($respa);
					/****************end of mail send*******************/

							
							return "Insertion successful.";
						} else {
							return "Insertion failed.";
						}
	}
	
	public function saveInvestmentOtherFee($investment_no){ // 2024-june-06 will call this function everytime lender invest the payment
		
				$arr["transactionType"] = "lenderCharges";
				$arr["user_type"] = "lender";
				$arr["user_id"] = $this->input->post('lender_id');
				$arr["mobile"] = $this->input->post('mobile');
				$arr["amount"] = $this->input->post('total_amount'); // total amount paid by payment gateway inclusive of all charges
				$arr["razorpay_order_id"] = $this->input->post('razorpay_order_id');
				$arr["razorpay_payment_id"] = $this->input->post('razorpay_payment_id');
				$arr["razorpay_signature"] = $this->input->post('razorpay_signature');
				$arr["ant_txn_id"] = $this->input->post('ant_txn_id');
				$arr["partner_id"] = $this->input->post('partner_id');
				$arr["lender_processing_fee"] = $this->input->post('lender_processing_fee');
				$arr["lender_platform_fee"] = $this->input->post('lender_platform_fee');
				$arr["master_fee_structure_json"] = $this->input->post('master_fee_structure_json');
				$arr["investment_amount"] = $this->input->post('investment_amount'); 

				$arr["data_entry_id"] = $this->session->userdata('user_id');
				$arr["data_entry_time"] = date("Y-m-d H:i:s");
				$arr["status"] = 1;
				$arr["investment_no"] = $investment_no;
					
                    $query = $this->db->insert('trans_fee_structure', $arr);
						//return $arr;
	
						if ($query) {
							return "Insertion successful.";
						} else {
							return "Insertion failed.";
						}
	}
	
				public function get_registration_fee_status($userType,$userId,$transactionType) //'borrowerRegistrationFee','lenderRegistrationFee'
	{
		$this->cldb->select('trans_fee_structure.*');
		$this->cldb->from('trans_fee_structure'); 
		
		$this->cldb->where(array("trans_fee_structure.transactionType"=>$transactionType));
		$this->cldb->where(array("trans_fee_structure.user_type"=>$userType));
		 $this->cldb->where(array("trans_fee_structure.status"=>1));
				$this->cldb->where(array("trans_fee_structure.user_id"=>$userId));
				$this->cldb->where(array("trans_fee_structure.razorpay_payment_id!="=>""));

		  
		$res = $this->cldb->get();

		 $result = $res->result_array();
		// return $this->cldb->last_query();
			return $result;
	}
		
					public function updateUserLenderId($id,$mobile,$lender_id,$partners_id,$oldNew){

					$arr_user_detail = array(
					'status'=> 1,
					'id' => $id,
					'mobile' => $mobile,

					'userType' => $oldNew
					);	



						foreach ($arr_user_detail as $key => $value) {
						if (empty($value)) {
						$resp['status'] = 2;
						$resp['msg'] = "Field '$key' is empty";
						$resp['mobile'] = "";
						return $resp;
						}
						}								if($lender_id!=""){
					$arr_user_detail['lender_id'] = $lender_id;
					}

					if($partners_id!=""){
					$arr_user_detail['partners_id'] = $partners_id;
					}


					$this->cldb->where('id',$arr_user_detail['id']);	
					$this->cldb->where('mobile',$arr_user_detail['mobile']);
					$this->cldb->where('lender_id',""); //one
					$insertResult = $this->cldb->update('master_user', $arr_user_detail);

					if($insertResult){

					$resp['status'] = 1;
					$resp['msg'] = "Lender ID Updated Successful".$this->cldb->last_query();
					$resp['mobile'] = $arr_user_detail['mobile'];
					return $resp;
					}else{
					$resp['status'] = 0;
					$resp['msg'] = "Lender ID  Updation Failed".$this->cldb->last_query();
					$resp['mobile'] =  $arr_user_detail['mobile'];
					return $resp;
					}
					}
	
	
						/*******************starting of borrower ID update**************/
						public function updateUserBorrowerId($id,$mobile,$borrower_id,$partners_id,$oldNew,$get_user_details){
						$get_user_details = json_encode($get_user_details);
						$borrowerDetails = json_decode($get_user_details,true);
						$arr_user_detail = array(
						'status'=> 1,
						'id' => $id,
						'mobile' => $mobile,

						'userType' => $oldNew
						);	



						foreach ($arr_user_detail as $key => $value) {
						if (empty($value)) {
						$resp['status'] = 2;
						$resp['msg'] = "Field '$key' is empty";
						$resp['mobile'] = "";
						return $resp;
						}
						}								if($borrower_id!=""){
						$arr_user_detail['borrower_id'] = $borrower_id;
						}

						if($partners_id!=""){
						$arr_user_detail['partners_id'] = $partners_id;
						}

						$arr_user_detail['name'] =	$borrowerDetails['name'];
						$arr_user_detail['email_id'] =	$borrowerDetails['email_id'];
						$arr_user_detail['highest_qualification'] =	$borrowerDetails['highest_qualification'];
						$arr_user_detail['pan_card'] =	$borrowerDetails['pan_card'];

						$arr_user_detail['aadhaar_status'] =	$borrowerDetails['aadhaar_status'];
						$arr_user_detail['pan_status'] =	$borrowerDetails['pan_status'];
						$arr_user_detail['account_status'] =	$borrowerDetails['account_status'];

						$this->cldb->where('id',$arr_user_detail['id']);	
						$this->cldb->where('mobile',$arr_user_detail['mobile']);
						//$this->cldb->where('borrower_id',"");
						$insertResult = $this->cldb->update('master_user', $arr_user_detail);

						if($insertResult){

						$resp['status'] = 1;
						$resp['msg'] = "Borrower ID Updated Successful".$this->cldb->last_query();
						$resp['mobile'] = $arr_user_detail['mobile'];
						return $resp;
						}else{
						$resp['status'] = 0;
						$resp['msg'] = "Borrower ID  Updation Failed".$this->cldb->last_query();
						$resp['mobile'] =  $arr_user_detail['mobile'];
						return $resp;
						}
						}
						/******************ending of borrower ID update*********************/
		
		
							/***********************************************/
							public function updateUserDetail(){
							//	echo"<pre>";	print_r($this->input->post()); die();
							$formName = $this->input->post('form');
							$arr_user_detail = "";
							if($formName=="personalDetail"){
							$arr_user_detail = array(
							'status' => 1,
							'id' => $this->input->post('id'),
							'mobile' => $this->input->post('mobile'),
							'name' => $this->input->post('name'),
							'date_of_birth' => $this->input->post('date_of_birth'),
							'gender' => $this->input->post(gender),
							'email_id' => $this->input->post('email_id'),
							'pan_card' => $this->input->post('pan_card'),
							'aadhaar' => $this->input->post('aadhaar'),

							);	

							$loan_purpose = $this->input->post('loan_purpose');
							$loan_amount = $this->input->post('loanAmount');
							$loan_tenure = $this->input->post('loan_tenure');

							if (!empty($loan_purpose) && !empty($loan_amount) && !empty($loan_tenure)) {
								$arr_user_detail['loan_purpose'] = $loan_purpose;
								$arr_user_detail['loan_amount'] = $loan_amount;
								$arr_user_detail['loan_tenure'] = $loan_tenure;
							}

							$arr_user_detail['r_address'] = $this->input->post('r_address');
							$stateData = explode(",",$this->input->post('r_state'));
							$arr_user_detail['r_state'] = $stateData[0]; //$this->input->post('r_state');
							$arr_user_detail['r_city'] = $this->input->post('r_city');
							$arr_user_detail['r_pincode'] = $this->input->post('r_pincode');

							$arr_user_detail['r_state_code'] = $stateData[1]; //$this->input->post('r_state_code');


							$arr_user_detail['highest_qualification'] = $this->input->post('highest_qualification');


							$arr_user_detail['occuption_id'] = 1; // static occupation id will be one because 2024-feb-13 $this->input->post('occuption_id');
							$arr_user_detail['company_type'] = $this->input->post('company_type');


							$arr_user_detail['company_name'] = $this->input->post('company_name');
							// $arr_user_detail['company_code'] = $this->input->post('company_code');
							
								$company_code = $this->input->post('company_code');

								// Assign to arr_user_detail with proper handling for empty values
								$arr_user_detail['company_code'] = ($company_code !== "" ? $company_code : 0);
								
							//  $arr_user_detail['company_code'] = ($this->input->post('company_code')==""? 0: $this->input->post('company_code'));
							
							$arr_user_detail['salary_process'] = $this->input->post('salary_process');
							$arr_user_detail['net_monthly_income'] = $this->input->post('net_monthly_income');

								
							}else if($formName=="accountDetail"){
							$arr_user_detail = array(
							'id' => $this->input->post('id'),
							'mobile' => $this->input->post('mobile'),
							'account_number' => $this->input->post('account_number'),
							'ifsc_code' => $this->input->post('ifsc_code'),
							//'bank_name' => $this->input->post('bank_name'),
							);	
							}


									foreach ($arr_user_detail as $key => $value) {
									//if (empty($value)) {
										if ($value === null || $value === "") {
									$resp['status'] = 2;
									$resp['msg'] = "Field '$key' is empty";
									$resp['mobile'] = "";
									return $resp;
									}
									}

							$this->cldb->where('id',$arr_user_detail['id']);	
							$this->cldb->where('mobile',$arr_user_detail['mobile']);	
							$insertResult = $this->cldb->update('master_user', $arr_user_detail);
							//	echo $this->cldb->last_query(); die();
							if($insertResult){

							$resp['status'] = 1;
							$resp['msg'] = "User Updated Successful In".$formName;
							$resp['mobile'] = $this->input->post('mobile');
							return $resp;
							}else{
							$resp['status'] = 0;
							$resp['msg'] = "User  Updation Failed";
							$resp['mobile'] =  $this->input->post('mobile');
							return $resp;
							}
							}

							public function getLoantypeweb()
							{
								return $loan_types = $this->db->order_by('p2p_product_id,loan_name', 'desc')->get_where('p2p_loan_type', array('status' => 1, 'p2p_product_id !='=>1))->result_array();
							}

	

		public function getUserDetail($mobile)
	{
		$this->cldb->select('master_user.*, a.Company_Name as partner_name');
		$this->cldb->from('master_user');
		$this->cldb->join('invest_vendors a',"master_user.partners_id = a.VID", "LEFT");
		$this->cldb->where(array("master_user.mobile"=>$mobile));
		$res = $this->cldb->get();

		 $result = $res->result_array();
			return $result[0];
	}
	
		public function get_company_list($searchTerm)
	{
		$this->db->select('id,company_name');
		$this->db->from('p2p_list_company');
		$this->db->like('company_name', $searchTerm); 
		$this->db->limit(40);	
		$query = $this->db->get();

		return $query->result();  
	}


	
	
	public function get_state()
    {
        $this->db->select('state, code');
        $this->db->from('p2p_state_experien');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	
	public function highest_qualification()
    {
        $this->db->select('*');
        $this->db->from('p2p_qualification');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	
			public function getPartnersTheme($partner_id)
				{
		
		
		$this->cldb->select('partners_theme.*');
		$this->cldb->from('partners_theme');
		//$this->cldb->join('invest_vendorssss1 a',"master_user.partners_id = a.VID", "LEFT");
		
			$this->cldb->where(array("partners_theme.partner_id"=>$partner_id));
		$res = $this->cldb->get();

		 $result = $res->result_array();

			return $result[0];
			}



/******************starting of allInOneKycSubmitOtp here*************/
		public function allInOneKycSubmitOtp($mobile,$fullname,$email,$pan,$aadhar,$account_no,$bank_name,$ifsc_code,$otp,$transactionId,$codeVerifier,$fwdp,$kyc_unique_id){  
							
		
$curl = curl_init();


$postData = json_encode(array(
    'kyc_unique_id' => $kyc_unique_id,
	'mobile' => $mobile,
	'fullname' => $fullname,
    'user_type' => 'lender',
    'source' => 'Surge',
	 "product"=> "Lend Social",
    'otp' => $otp,
    'transactionId' => $transactionId,
    'codeVerifier' => $codeVerifier,
    'fwdp' => $fwdp,
    'validateXml' => true
				));


curl_setopt_array($curl, array(
  CURLOPT_URL => $this->apiBaseUrlKycApi.'all_in_one_kyc_submit_otp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,


		CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=e8duebnem634m2db5fj7vfh3ul0kqlbr',
	'Authorization:NTk0MDcxOmJhMjUzZTM4ZmM0NDBkMjQ4Yjk1NWRmOGYzMzZmNzRl'
  ),
			));

			$response = curl_exec($curl);

			
			$response = curl_exec($curl);

			if ($response === false) {
				echo 'Curl error: ' . curl_error($curl);
				echo 'Curl error number: ' . curl_errno($curl);
			}

			curl_close($curl);

			return $response;

				}
	/**************ending of allInOneKycSubmitOtp here**************/



/******************starting of allInOneKyc here*************/
		public function allInOneKyc($mobile,$fullname,$email,$pan,$aadhar,$account_no,$bank_name,$ifsc_code,$company_type,$company_name,$company_code,$user_type,$dob,$gender,$highest_qualification,$r_pincode,$net_monthly_income,$r_city,$r_state,$vendor_id,$loan_purpose,$loan_amount,$loan_tenure){  
						
		
			$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $this->apiBaseUrlKycApi.'all_in_one_kyc',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
					"mobile": "'.$mobile.'",
					"fullname": "'.$fullname.'",
					"email": "'.$email.'",
					"pan": "'.$pan.'", 
					"aadhar":"'.$aadhar.'",
					"account_no": "'.$account_no.'",
					"caccount_no": "'.$account_no.'",
					"bank_name": "'.$bank_name.'",
					"ifsc_code": "'.$ifsc_code.'",
					"dob": "'.$dob.'",
					 "gender":  "'.$gender.'",
					  "occuption_id": "1",
					  "company_type": "'.$company_type.'",
					"company_name": "'.$company_name.'",
					"company_code": "'.$company_code.'",
					 "highest_qualification":  "'.$highest_qualification.'",
					"r_pincode": "'.$r_pincode.'",
					"net_monthly_income": "'.$net_monthly_income.'",
					"r_city": "'.$r_city.'",
					"r_state": "'.$r_state.'",
					"user_type": "'.$user_type.'",
					"vendor_id": "'.$vendor_id.'",
					"source": "LendSocialWebApp",
					"product": "Lend Social",
					"loan_purpose": "'.$loan_purpose.'",
					"loan_amount": "'.$loan_amount.'",
					"loan_tenure": "'.$loan_tenure.'",
					}',


			  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=e8duebnem634m2db5fj7vfh3ul0kqlbr',
	'Authorization:NTk0MDcxOmJhMjUzZTM4ZmM0NDBkMjQ4Yjk1NWRmOGYzMzZmNzRl'
  ),
			));

			$response = curl_exec($curl);
			
			curl_close($curl);
			return $response;

				}
				
				
				
				
	/**************ending of allInOneKyc here**************/


/************************starting of allInOneKycStatus**************************/
public function getAllInOneKycStatus($mobile,$user_type){ // Dated: 2024-oct-01

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://antworksp2p.com/kycapi/all_in_one_kyc_status',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "mobile": "'.$mobile.'",
    "user_type": "'.$user_type.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: NTk0MDcxOmJhMjUzZTM4ZmM0NDBkMjQ4Yjk1NWRmOGYzMzZmNzRl',
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=uf8t4ss1brv4373s0btvp503vcdchnnh; PHPSESSID=j359ho9ekg8r2gcf1o7ru37dej; p2p_2018_2019_session=mm1i0dcgl6qc5242edja01tojrqqtj52'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;

}
/****************end of allInOneKycStatus*******************************/

/******************starting of Bank KYC here*************/
		public function userBankKYC($account_no,$caccount_no,$fullname,$ifsc_code,$lender_id,$phone){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
		//2023-dec-20	  CURLOPT_URL =>  'https://webhook.site/b0d5ff61-d3a7-40a6-bee0-4ffdcc7e1412/surgeapi/investapi/user_bank_detail',
			  CURLOPT_URL => $this->apiBaseUrlLender.'user_bank_detail',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				     "account_no": "'.$account_no.'",
					"caccount_no": "'.$caccount_no.'",
					"fullname": "'.$fullname.'",
					"ifsc_code": "'.$ifsc_code.'",
					"lender_id": "'.$lender_id.'",
					"phone": "'.$phone.'",	
				   "source":"surge"
						} ',



			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of Bank KYC here**************/


/******************starting of PAN KYC / User Personal Detail here*************/
		public function saveUserPersonalDetailApi($DOB,$email,$fullname,$gender,$PAN,$phone,$vendor_id){   // vender_id =partner_id
					$postData = '{
				     "device_id":"SurgeWebAppID",
						"app_version":"2",
						"DOB": "'.$DOB.'", 
						"email": "'.$email.'",
						"fullname": "'.$fullname.'",
						"gender": "'.$gender.'",
						"PAN": "'.$PAN.'",
						"phone": "'.$phone.'",
						"vendor_id": "'.$vendor_id.'",
				 "source":"LendSocialWebApp"
						}';				
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'user_personal_detail',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,

						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));
				
			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of generateOrder here**************/


/******************starting of generateOrder here*************/
		public function generateOrder($amount,$mobile,$service){  
							/*
							INSERT INTO `activate_pg_by_services` (`id`, `channel`, `service_name`, `pg_name`, `fee_rate`, `payu_merchant_id`, `payu_merchant_salt`, `razorpay_key`, `short_text`, `long_text`) VALUES (NULL, 'PG', 'antworks-p2p', 'Razorpay', '0', '', '', 'rzp_live_rkIuQRMRkiHJzM', '2.15% extra convenience fee', '2.15% extra convenience fee');

							*/
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://antworksmoney.com/apiserver/antapp/generateOrder',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			  "amount":"'.$amount.'",
			  "channel":"PG",
              "mobile":"'.$mobile.'", 
              "service":"'.$service.'",
				 "source":"surge"
						} ',
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of generateOrder here**************/
	


/******************starting of socialAfterPayment here*************/
		public function socialAfterPayment($ant_txn_id,$mobile,$amount,$razorpay_order_id,$razorpay_payment_id,$razorpay_signature){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://antworksmoney.com/apiserver/social/social_after_payment',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "ant_txn_id": "'.$ant_txn_id.'",
				"mobile": "'.$mobile.'",
				"amount":"'.$amount.'",
				"payment_method": "PG",
				"service":"social-lending",
				"razorpay_order_id": "'.$razorpay_order_id.'",
				"razorpay_payment_id": "'.$razorpay_payment_id.'",
				"razorpay_signature": "'.$razorpay_signature.'",
				"source":"surge"
				}',
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);
		  // Check for cURL errors
    if ($response === false) {
        $error_message = curl_error($curl);
        $error_code = curl_errno($curl);

        // Handle the error as needed
        return "cURL Error $error_code: $error_message";
    }
			curl_close($curl);
			return $response;

				}
	/**************ending of socialAfterPayment here**************/


				/*********************starting of getSchemeDataById here****************/
						public function getSchemeDataById($scheme_id){

						$this->db->select('*');
						$this->db->from('invest_scheme_details');
						$this->db->where('id', $scheme_id);
						
						$query = $this->db->get();
						if ($this->db->affected_rows() > 0) {
						return $result = $query->row_array();
						} else {
						return false;
						}
						}
				/***********************ending of getSchemeDataById here****************/

/******************starting of lenderInvestment here*************/
		public function lenderInvestment($mobile,$lender_id,$amount,$scheme_id,$ant_txn_id){  
						
			$postData =  json_encode(array(
				 "phone"=>$mobile,
				 "lender_id"=>$lender_id,
				 "amount"=>$amount,
				 "scheme_id"=>$scheme_id,
                 "ant_txn_id"=>$ant_txn_id,
				 "source" => "Surge",
				 "product"=> "Lend Social",
			));							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'lender_investment',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of lenderInvestment here**************/


				/****************starting of add_lender_payout_schedule************************/
				public function add_lender_payout_schedule_model($data){ // Dated: 2024-july-25

				$this->db->insert('lendsocial_lender_payout_schedule',$data);
				if($this->db->affected_rows()>0){
						return true;
				}else{
					return false;
				}
				}
				/****************ending of add_lender_payout_schedule***********************/			


/******************starting of sendRedemptionRequest here************Done*/
		public function sendRedemptionRequest($mobile,$investment_no){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'redemption_status',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "investment_no":"'.$investment_no.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl); /*
				$response = '{
    "status": 0,
    "mes": "Redemption in Process"
}';  */
			return $response;

				}
	/**************ending of sendRedemptionRequest here**************/


/******************starting of getRedeemRequestPreview here************Done*/
		public function getRedeemRequestPreview($mobile,$investment_no){  
							

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'redemption_request',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "investment_no":"'.$investment_no.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/***************************/

		public function getAllSchemes($mobile,$partner_id){  
							

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'all_schemes',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "vendor_id":"'.$partner_id.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}


		public function getInvestmentList($mobile,$lender_id){
						
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'lender_investment_details',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "lender_id":"'.$lender_id.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
		
		public function getKycStatus($mobile,$vendor_id){
					$postData =  json_encode(array("phone"=>$mobile, "vendor_id"=>$vendor_id));		
						
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'kyc_status',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
							}
