<?php

class Kyc_engine_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->p2pdb = $this->load->database('default', true);
		$this->load->model(array('Pan_Model','Bank_Model','Aadhar_Model'));
	}
	public function kyc_send_aadhar_otp_engine(){
		$kyc_rule = $this->get_product_kyc_rule();
		//pr($kyc_rule);exit;
		  # For full KYC
			if($kyc_rule['pan_kyc'] == 'ok' && $kyc_rule['aadhar_OKYC']  == 'ok' && $kyc_rule['bank_account_kyc'] == 'ok'){
				#Aadhar OKYC Start
			     $aadhar_okyc_response = $this->aadhar_initiate_okyc_send_otp_api();
				 
				 $user_details = array('user_type'=>$this->input->post('user_type'),'user_id'=>$aadhar_okyc_response['user_id'],'lender_id'=>$aadhar_okyc_response['lender_id']);
				 
				 $aadhar_response = array(
				 'kyc_unique_id' => $aadhar_okyc_response['kyc_unique_id'],
				 'aadhar_response' => $aadhar_okyc_response['aadhar_response'],
				 );
				 
				#PAN KYC Start
				$pan_kyc_result = $this->basic_pan_kyc();
				
				if(!empty($pan_kyc_result)){
				  $pan_response = array(
				  'status'=>$pan_kyc_result['response']['result']['status'],
				  'name_match'=>$pan_kyc_result['response']['result']['name_match'],
				  'msg'=>$pan_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType']
				  );
				}
				
				#BANK KYC Start
				
			    $bank_kyc_result = $this->bank_kyc();
				if(!empty($bank_kyc_result)){
				  $bank_response = array('status'=>$bank_kyc_result['status'],
				  'msg'=>$bank_kyc_result['msg'],
				  'dataType'=>$bank_kyc_result['dataType'],
				  'name_match'=>$bank_kyc_result['name_match']
				  );
				}
				
				$response = array('user_details' => $user_details,'aadhar_kyc' => $aadhar_response,'pan_kyc' => $pan_response, 'bank_kyc' => $bank_response);
			}
			# For Half KYC
			else if($kyc_rule['pan_kyc'] == 'ok' && $kyc_rule['aadhar_KYC']  == 'ok' && $kyc_rule['bank_account_kyc'] == 'ok'){
				//echo 'Half KYC';exit;
				
				
				#PAN KYC Start
				$pan_kyc_result = $this->basic_pan_kyc();
				
				if(!empty($pan_kyc_result)){
				  $pan_response = array(
				  'status'=>$pan_kyc_result['response']['result']['status'],
				  'name_match'=>$pan_kyc_result['response']['result']['name_match'],
				  'msg'=>$pan_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType']
				  );
				}
				#BANK KYC Start
			    $bank_kyc_result = $this->bank_kyc();
				//pr($bank_kyc_result);exit;
				if(!empty($bank_kyc_result)){
				  $bank_response = array('status'=>$bank_kyc_result['status'],
				  'msg'=>$bank_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType'],
				  'name_match'=>$bank_kyc_result['name_match']
				  );
				};
				#Aadhar KYC Start Basic Without OTP
			     $aadhar_kyc_response = $this->aadhar_validate_without_otp();
				 $response = array('pan_kyc' => $pan_response, 'bank_kyc' => $bank_response, 'aadhar_kyc' => $aadhar_kyc_response);
				 
			}
			 
			
			return $response;
	}
	public function kyc_submit_otp_engine(){
		$kyc_rule = $this->get_product_kyc_rule();
		$postData = $this->input->post();
		$response_arr = array();
		//pr($kyc_rule);exit;
		
		  # For full KYC
			if($kyc_rule['pan_kyc'] == 'ok' && $kyc_rule['aadhar_OKYC']  == 'ok' && $kyc_rule['bank_account_kyc'] == 'ok'){
			#Aadhar KYC Start
				
			     $aadhar_okyc_response = $this->aadhar_validate_okyc_submit_otp();
					if(!empty($aadhar_okyc_response)){
					 $aadhar_response = array(
					 'status' => $aadhar_okyc_response['status'],
					 'msg' => $aadhar_okyc_response['msg'],
					 'name_match'=>$aadhar_okyc_response['name_match'],
					 'dataType'=>$aadhar_okyc_response['dataType'],
					 );
					}
				
				/* #PAN KYC Start
				$pan_kyc_result = $this->basic_pan_kyc();
				
				if(!empty($pan_kyc_result)){
				  $pan_response = array(
				  'status'=>$pan_kyc_result['response']['result']['status'],
				  'name_match'=>$pan_kyc_result['response']['result']['name_match'],
				  'msg'=>$pan_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType']
				  );
				}
				
				#BANK KYC Start
				
			    $bank_kyc_result = $this->bank_kyc();
				//pr($bank_kyc_result);exit;
				if(!empty($bank_kyc_result)){
				  $bank_response = array('status'=>$bank_kyc_result['status'],
				  'msg'=>$bank_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType'],
				  'name_match'=>$bank_kyc_result['name_match']
				  );
				}
				
				$response = array('aadhar_kyc' => $aadhar_response,'pan_kyc' => $pan_response, 'bank_kyc' => $bank_response); */
				
				#Update All Kyc Status Done
				
				/* if($response['aadhar_kyc']['name_match'] == true && $response['pan_kyc']['name_match'] == true && $response['bank_kyc']['name_match'] == true){
				  $this->db->where('mobile', $this->input->post('mobile'));
				   $this->db->update('all_kyc_api_log', array('kyc_api_status'=>1));
				} */
				//pr($response);exit;
				$response = array('aadhar_kyc' => $aadhar_response);
			}
			# For Half KYC
			else if($kyc_rule['pan_kyc'] == 'ok' && $kyc_rule['aadhar_KYC']  == 'ok' && $kyc_rule['bank_account_kyc'] == 'ok'){
				#Aadhar KYC Start Basic Without OTP
			     $aadhar_kyc_response = $this->aadhar_validate_without_otp();
				 
				#PAN KYC Start
				$pan_kyc_result = $this->basic_pan_kyc();
				
				if(!empty($pan_kyc_result)){
				  $pan_response = array(
				  'status'=>$pan_kyc_result['response']['result']['status'],
				  'name_match'=>$pan_kyc_result['response']['result']['name_match'],
				  'msg'=>$pan_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType']
				  );
				}
				#BANK KYC Start
			    $bank_kyc_result = $this->bank_kyc();
				//pr($bank_kyc_result);exit;
				if(!empty($bank_kyc_result)){
				  $bank_response = array('status'=>$bank_kyc_result['status'],
				  'msg'=>$bank_kyc_result['msg'],
				  'dataType'=>$pan_kyc_result['dataType'],
				  'name_match'=>$bank_kyc_result['name_match']
				  );
				}
				
				 $response = array('aadhar_kyc' => $aadhar_kyc_response,'pan_kyc' => $pan_response, 'bank_kyc' => $bank_response, );
				 
			}
			$response_arr = array('status'=>1,'response'=>$response);
			return $response_arr;
	}
	public function get_product_kyc_rule(){
		$query = $this->db->select('kr.*,kp.product_name')->join('kyc_products kp', 'kp.id = kr.product_id')->get_where('product_kyc_rule kr', array('kp.product_name' => $this->input->post('product')));
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result;
		}else{
			return array();
		} 
	}
	
	public function get_user_details($postData){
		//pr($postData);exit;
		if($postData['user_type'] == 'lender'){
			$query = $this ->db
				   -> select('*')
				   -> where('mobile', $postData['mobile'])
				   -> or_where('pan', $postData['pan'])
				   -> or_where('email', $postData['email'])
				   -> get('p2p_lender_list');
			if ($this->db->affected_rows() > 0)
			{
					$lender_details = $query->row();
					$user_id = $lender_details->user_id;
					$lender_id = $lender_details->lender_id;
					return $result = array('user_id'=>$user_id,'user_type'=>'lender','datatype'=>'already','lender_id'=>$lender_id);
			}else{
				# 'Not exist in p2p Database';
					$lender_id = create_lender_id();
				# Create Leander in P2P Database 			
				$this->db->insert('p2p_lender_list', array(
						'lender_id' => $lender_id,
						'name' => $postData['fullname'],
						'email' => $postData['email'],
						'mobile' => $postData['mobile'],
						'dob' => date("Y-m-d",strtotime($postData['dob'])),
						'gender' => $postData['gender'],
						'occupation' => $postData['occuption_id'],
						'qualification' => $postData['highest_qualification'],
						'pan' => $postData['pan'],
						'source_of_lead' => $postData['source'],
						'created_date'=>date("Y-m-d H:i:s"),
                        'modified_date'=>date("Y-m-d H:i:s"),
						'vendor_id' => $postData['vendor_id'],
					));
					
					$lenderID = $this->db->insert_id();
					return $result = array('user_id'=>$lenderID,'user_type'=>'lender','datatype'=>'new','lender_id'=>$lender_id);
			}
		}else{
			$query = $this ->db
				   -> select('*')
				   -> where('mobile', $postData['mobile'])
				   -> or_where('pan', $postData['pan'])
				   -> or_where('email', $postData['email'])
				   -> get('p2p_borrowers_list');
			if ($this->db->affected_rows() > 0)
			{
				$borrowers_details = $query->row();
				
				$id = $borrowers_details->id;
				
				#Update Borrower Details
				$this->db->where('id', $id);
				$this->db->update('p2p_borrowers_list', array(
						'dob' => date("Y-m-d",strtotime($postData['dob'])),
						'gender' => $postData['gender'],
						'occuption_id' => $postData['occuption_id'],
						'highest_qualification' => $postData['highest_qualification']
					));
				
				
				#Add/Update Borrower Address Details
				$this->borrower_address_details($id);
				#Add/Update Borrower Occuption Details
				$this->borrower_occuption_details($id);
				return $result = array('user_id'=>$id,'user_type'=>'borrower','datatype'=>'already','lender_id'=>'');
			}else{
				# 'Not exist in p2p Database';
					$borrower_id = create_borrower_id();
				# Create borrower in P2P 			
				$this->db->insert('p2p_borrowers_list', array(
						'borrower_id' => $borrower_id,
						'name' => $postData['fullname'],
						'email' => $postData['email'],
						'mobile' => $postData['mobile'],
						'dob' => date("Y-m-d",strtotime($postData['dob'])),
						'gender' => $postData['gender'],
						'occuption_id' => $postData['occuption_id'],
						'highest_qualification' => $postData['highest_qualification'],
						'pan' => $postData['pan'],
						'source' => $postData['source'],
						'created_date'=>date("Y-m-d H:i:s"),
                        'modified_date'=>date("Y-m-d H:i:s"),
						'vendor_id' => $postData['vendor_id'],
					));
					
					$borrower_id = $this->db->insert_id();
					#Add/Update Borrower Address Details
					$this->borrower_address_details($borrower_id);
					#Add/Update Borrower Occuption Details
					$this->borrower_occuption_details($borrower_id);
					return $result = array('user_id'=>$borrower_id,'user_type'=>'borrower','datatype'=>'new','lender_id'=>'');
			}
		}
	}
	public function borrower_address_details($borrowerId)
    {
		$this->db->select('borrower_id')->get_where('p2p_borrower_address_details', array('borrower_id' => $borrowerId));
		//echo $this->db->last_query();exit;
        if ($this->db->affected_rows() > 0) {
            $address_details = array(
                'borrower_id' => $borrowerId,
                'r_state' => $this->input->post('r_state_code'),
                'r_state_name' => $this->input->post('r_state'),
                'r_city' => $this->input->post('r_city'),
                'r_address' => $this->input->post('r_address'),
                'r_pincode' => $this->input->post('r_pincode'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'date_added' => date("Y-m-d H:i:s"),
            );
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_address_details', $address_details);
			//echo $this->db->last_query();exit;
        } else {
            $address_details = array(
			    'borrower_id' => $borrowerId,
                'r_state' => $this->input->post('r_state_code'),
                'r_state_name' => $this->input->post('r_state'),
                'r_city' => $this->input->post('r_city'),
                'r_address' => $this->input->post('r_address'),
                'r_pincode' => $this->input->post('r_pincode'),
				'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'date_added' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_borrower_address_details', $address_details);
			//echo $this->db->last_query();exit;
        }
        return array('borrower_id' => $borrowerId);

    }
	public function borrower_occuption_details($borrowerId)
    {
        $data = array(
            'occuption_id' => $this->input->post('occuption_id'),
            'modified_date' => date("Y-m-d H:i:s"),
        );
        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);
        $borrower_array = array(
            'borrower_id' => $borrowerId,
            'occuption_type' => $this->input->post('occuption_id'),
            'company_type' => $this->input->post('company_type'),
            'company_name' => $this->input->post('company_name'),
			'net_monthly_income' => $this->input->post('net_monthly_income'),
            'salary_process' => $this->input->post('salary_process'),
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_occuption_details', $borrower_array);
        } else {
            $this->db->insert('p2p_borrower_occuption_details', $borrower_array);
        }
        return array('borrower_id' => $borrowerId);

    }
/***************** PAN KYC *******************/
	public function basic_pan_kyc() {
         $postData = $this->input->post();
		 $userData = $this->get_user_details($postData);
		 
		$request = array(
				'pan' => $postData['pan'],
				'name' => $postData['fullname'],
				'mobile'=> $postData['mobile'],
				'name_match_method' => 'exact',
				'user_type' => $postData['user_type'],
				'user_id' => isset($userData['user_id']) ? $userData['user_id'] : 0,
				'source' => $postData['source'],
				
			);	
			   $response_arr = $this->Pan_Model->pankyc($request);
		  
				
				$response['status'] = $response_arr['status'];
				$response['msg'] = $response_arr['msg'];
				$response['request_type'] = 'pan_api';
				$response['dataType'] = $response_arr['dataType'];
				$response['response'] = $response_arr['response'];
				
				$lender_id = "";
				$borrower_id = "";
				if($postData['user_type']=="lender"){
						$lender_id = $userData['user_id'];
				}else {
						$borrower_id = $userData['user_id'];
				}
				
				$query = $this->db->get_where('all_kyc_api_log', array('mobile' => $postData['mobile']));
				    if ($this->db->affected_rows() > 0) {
					  $log_array = array(
							   'pan_api_request'=>json_encode($request),
							   'pan_api_response'=>json_encode($response_arr),
							   'pan_api_status'=>$response_arr['response']['result']['status'] ?? '',
							   'pan_display_name'=>$response_arr['response']['result']['name'] ?? '',
							   'pan_name_match'=>$response_arr['response']['result']['name_match'] ?? ''
							   );
						   
					 //$this->db->insert('all_kyc_api_log',$log_array);
					 $this->db->where('mobile', $postData['mobile']);	   
					 $this->db->update('all_kyc_api_log',$log_array);
				    } 
			
		return $response;
		     
}
/***************** Bank KYC ***********************************/
public function bank_kyc() {
     //$headers = $this->input->request_headers();
	 $postData = $this->input->post();
	 $userData = $this->get_user_details($postData);
	 
	 $lender_id = "";
	 $borrower_id = "";
		 if($postData['user_type']=="lender"){
				$lender_id = isset($userData['user_id']) ? $userData['user_id'] : 0;
			}else if($postData['user_type']=="borrower"){
				$borrower_id = isset($userData['user_id']) ? $userData['user_id'] : 0;
			}
		$postData['borrower_id']= 	$borrower_id;
		$postData['lender_id']= 	$lender_id;
		
	 $request = json_encode(array(
            'mobile' => $postData['mobile'],
            'name' => $postData['fullname'],
            'account_no' => $postData['account_no'],
            'caccount_no' => $postData['caccount_no'],
            'ifsc_code' => $postData['ifsc_code'],
            'user_type' => $postData['user_type'],
            'borrower_id' => $postData['borrower_id'],
            'lender_id' => $postData['lender_id'],
            'source' => $postData['source']
        )); 
	  
				$response = $this->Bank_Model->add_bank_detail_borrower_lender($postData);
				
				//$response_arr = json_decode($response, true);
				$response_arr['status'] = $response['status'];
				$response_arr['msg'] = $response['msg'];
				$response_arr['request_type'] = $response['request_type'];
				$response_arr['dataType'] = $response['dataType'];
				$response_arr['name_match'] = $response['name_match'];
				
				
				$query = $this->db->get_where('all_kyc_api_log', array('mobile' => $postData['mobile']));
				    if ($this->db->affected_rows() > 0) {
					  $log_array = array(
							   'bank_kyc_request'=>$request,
							   'bank_kyc_response'=>json_encode($response),
							   'bank_kyc_status'=>$response['msg'] ?? '',
							   );
							   
						$this->db->where('mobile', $postData['mobile']);	   
					    $this->db->update('all_kyc_api_log',$log_array);
				    } 
			
			
			
			return $response;
     }
/*****************Aadhar KYC With Send OTP **************************************/
	public function aadhar_initiate_okyc_send_otp_api() {
		      $postData = $this->input->post();
			  $userData = $this->get_user_details($postData);
			  
			    $lender_id = "";
				$borrower_id = "";
				$response['lender_id'] = "";
				if($postData['user_type']=="lender"){
						$lender_id = $userData['user_id'];
						$response['user_id'] = $lender_id;
						$response['lender_id'] = $userData['lender_id'];
				}else {
						$borrower_id = $userData['user_id'];
						$response['user_id'] = $borrower_id;
				}
				$request = array(
					'mobile' => $postData['mobile'],
					'fullname' => $postData['fullname'],
					'aadhar' => $postData['aadhar'],
					'user_type' => $postData['user_type'],
					'source' => $postData['source']
				);
				$response_arr = $this->Aadhar_Model->aadhar_initiate_okyc_api();
				$kyc_unique_id = date("Ymdhis");
				$response['status'] = $response_arr['status'];
				$response['msg'] = $response_arr['msg'];
				$response['request_type'] = $response_arr['request_type'];
				$response['dataType'] = $response_arr['dataType'];
				$response['kyc_unique_id'] = $kyc_unique_id;
				$response['aadhar_response'] = $response_arr['aadhar_response'];
				
				$query = $this->db->get_where('all_kyc_api_log', array('mobile' => $postData['mobile']));
				    if ($this->db->affected_rows() == 0) {
                        $log_array = array('mobile'=>$postData['mobile'],
							   'source'=>$postData['source'],
							   'user_type'=>$postData['user_type'],
							   'borrower_id'=>$borrower_id,
							   'lender_id'=>$lender_id,
							   'aadhar_api_request'=>json_encode($request),
							   'aadhar_api_response'=>json_encode($response_arr),
							   'aadhar_api_status'=>$response_arr['msg'] ?? '',
							   'kyc_unique_id'=>$kyc_unique_id,
							   );							   
                    	$this->db->insert('all_kyc_api_log',$log_array);						   
						//$this->db->where('mobile', $postData['mobile']);	   
					    //$this->db->update('all_kyc_api_log',$log_array);
				    }
			
			return $response;
     }
	 /***************** Submit OTP API **********************/
	public function aadhar_validate_okyc_submit_otp(){
		    $postData = $this->input->post();
			//$userData = $this->get_user_details($postData);
			
			$response = $this->Aadhar_Model->aadhar_validate_okyc_api();
			$query = $this->db->get_where('all_kyc_api_log', array('mobile' => $postData['mobile']));
				    if ($this->db->affected_rows() > 0) {
					  $log_array = array(
							   'aadhar_api_response'=>json_encode($response),
							   'aadhar_api_status'=>$response['msg'] ?? '',
							   );	
                    						   
						$this->db->where('mobile', $postData['mobile']);	   
					    $this->db->update('all_kyc_api_log',$log_array);
				    }
				
			
			return $response;
		
     } 
	 /*****************Aadhar KYC Without OTP********************************/
	 public function aadhar_validate_without_otp(){
		 $postData = $this->input->post();
		 $userData = $this->get_user_details($postData);
		 
		 $lender_id = "";
		 $borrower_id = "";
		 if($postData['user_type']=="lender"){
				$postData['lender_id'] = $userData['user_id'];
			}else if($postData['user_type']=="borrower"){
				$postData['borrower_id'] = $userData['user_id'];
			}
			
			$request = array(
						'mobile' => $postData['mobile'],
						'aadhar_no' => $postData['aadhar'],
						'borrower_id' => $postData['borrower_id'] ?? '',
						'lender_id' => $postData['lender_id'] ?? '',
						'user_type' => $postData['user_type'],
						'source' => $postData['source']
					);
			
			$response = $this->Aadhar_Model->advanced_validate_post($postData);
			return $response;
		
     }
	public function kyc_status(){
		$postData = $this->input->post();
		$response = array();
			$query = $this->db->get_where('all_kyc_api_log', array('mobile' => $this->input->post('mobile')));
			if ($this->db->affected_rows() > 0) {
				$kycData = (array)$query->row();
				
				//pr($lender_borrower_details);exit;
				
					$pan_response = array('status'=>0,'msg' => '','name_match'=>0);
					$aadhar_response = array('status'=>0,'msg' => '','name_match'=>0);
					$bank_response = array('status'=>0,'msg' => '','name_match'=>0);
					if($kycData['pan_api_response']){
						$pan_api_response = json_decode($kycData['pan_api_response'],true);
						
						if($pan_api_response['response']['result']['status'] == 'Invalid'){
							$status = 0;
						}else{
							$status = 1;
						}
						$pan_response = array(
						  'status'=>$status,
						  'msg' => $pan_api_response['msg'],
						  'name_match'=>$pan_api_response['name_match'],
						  );
					}
					
					if($kycData['aadhar_api_response']){
						$aadhar_api_response = json_decode($kycData['aadhar_api_response'],true);
						//pr($aadhar_api_response);exit;
						if(isset($aadhar_api_response['name_match']) && $aadhar_api_response['name_match'] ==1){
							$status = 1;
						}else{
							$status = 0;
						}
						$aadhar_response = array(
						 'status' => $status,
						 'msg' => isset($aadhar_api_response['aadhar_response']['msg'])?$aadhar_api_response['aadhar_response']['msg']:$aadhar_api_response['msg'],
						 'name_match'=>$aadhar_api_response['name_match'] ?? '',
						 );
					}
					
					if($kycData['bank_kyc_response']){
						$bank_kyc_response = json_decode($kycData['bank_kyc_response'],true);
						$bank_response = array(
						  'status'=>$bank_kyc_response['status'],
						  'msg' => $bank_kyc_response['msg'],
						  'name_match'=>$bank_kyc_response['name_match'],
						  );
					}
					
					if($aadhar_response['name_match'] == true && $pan_response['name_match'] == true &&  $bank_response['name_match'] == true){
				     $this->db->where('mobile', $this->input->post('mobile'));
				     $this->db->update('all_kyc_api_log', array('kyc_api_status'=>1));
				      }else{
						  $this->db->where('mobile', $this->input->post('mobile'));
				          $this->db->update('all_kyc_api_log', array('kyc_api_status'=>0));
					  } 
					$lender_borrower_details = $this->get_lender_borrower_details($postData);
					
                    $user_details = array('user_type'=>$lender_borrower_details['user_type'],'user_id'=>$lender_borrower_details['user_id']);
//pr($user_details);exit();					
				  $response = array('aadhar_kyc' => $aadhar_response,'pan_kyc' => $pan_response, 'bank_kyc' => $bank_response,'kyc_user_details' => $user_details);
				
			}else{
				$response = array('status'=>0,'msg'=>'User Not found');
			}
			
			$response_arr = array('status'=>1,'response'=>$response);
			return $response_arr;
	} 
	public function get_lender_borrower_details($postData){
		//pr($postData);exit;
		
			$query = $this ->db
				   -> select('mobile,source,user_type,borrower_id,lender_id')
				   -> where('mobile', $postData['mobile'])
				   -> get('all_kyc_api_log');
			if ($this->db->affected_rows() > 0)
			{
				$kyc_details = $query->row();
				//pr($kyc_details);exit;
				$user_type = $kyc_details->user_type;
				if($postData['user_type'] == 'lender'){
				  $user_id = $kyc_details->lender_id;
				  $userData = $this->getUserData($postData,'p2p_lender_list');
				  
				}else if($postData['user_type'] == 'borrower'){
					$user_id = $kyc_details->borrower_id;
					$userData = $this->getUserData($postData,'p2p_borrowers_list');
				}
				
				return $result = array('user_id'=>$userData['user_id'],'user_type'=>$postData['user_type']);
			}else{
				return $result = array('user_id'=>'','msg'=>'KYC Not Found');
			}
		
	}
    public function getUserData($postData,$table){
		   
		         $query = $this ->db
					   -> select('*')
					   -> where('mobile', $postData['mobile'])
					   -> or_where('pan', $postData['pan'])
					   -> or_where('email', $postData['email'])
					   -> get($table);
					   //echo $this->db->last_query();exit;
					   //echo $this->db->affected_rows();exit;
				if ($this->db->affected_rows() > 0)
				{
					$user_data = $query->row();
					
					if($postData['user_type'] == 'borrower'){
						$user_id = $user_data->id;
						//echo $user_id.'if';exit;
					}else{
						$user_id = $user_data->user_id;
						//echo $user_id.'else';exit;
					}
					
					return $result = array('user_id'=>$user_id,'user_type'=>$postData['user_type']);
				}else{
					if($postData['user_type'] == 'borrower'){
				       $tbl = 'p2p_lender_list';
					   $tblInsert = 'p2p_borrowers_list';
					   $borrower_id = create_borrower_id();
					   $insertData['borrower_id'] = $borrower_id;
					}else{
						$tbl = 'p2p_borrowers_list';
						$tblInsert = 'p2p_lender_list';
						$lender_id = create_lender_id();
					    $insertData['lender_id'] = $lender_id;
					}
					
                         $query = $this ->db
					   -> select('*')
					   -> where('mobile', $postData['mobile'])
					   -> or_where('pan', $postData['pan'])
					   -> or_where('email', $postData['email'])
					   -> get($tbl);
					   //echo $tblInsert;exit;
//echo $this->db->last_query();exit;					   
                  if ($this->db->affected_rows() > 0)
					{
						$userData = (array)$query->row();
						
						$insertionData = array(
						'name' => $userData['name'],
						'email' => $userData['email'],
						'mobile' => $userData['mobile'],
						'dob' => date("Y-m-d",strtotime($userData['dob'])),
						'gender' => $userData['gender'],
						'occuption_id' => isset($userData['occuption_id'])?$userData['occuption_id']:$userData['occupation'],
						'highest_qualification' => isset($userData['highest_qualification'])?$userData['highest_qualification']:$userData['qualification'],
						'pan' => $userData['pan'],
						'source' => $userData['source'],
						'created_date'=>date("Y-m-d H:i:s"),
                        'modified_date'=>date("Y-m-d H:i:s"),
					);
					
					/* echo $tblInsert;
					pr($insertionData);exit;  */
					
					if($tblInsert == 'p2p_lender_list'){
						$insertionData['occupation'] = $insertionData['occuption_id'];
						$insertionData['qualification'] = $insertionData['highest_qualification'];
                        unset($insertionData['occuption_id']);
                        unset($insertionData['highest_qualification']);
					}
					
					
					$insertionData = array_merge($insertData,$insertionData);
					//pr($insertionData);exit;
						$this->db->insert($tblInsert, $insertionData);
						$user_id = $this->db->insert_id();
					return $result = array('user_id'=>$user_id,'user_type'=>$postData['user_type']);	
					}					   
				}
	}
}
