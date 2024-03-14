<?php

class Aadhar_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->p2pdb = $this->load->database('default', true);
	}

	 public function aadhar_initiate_okyc_api()
    {
		
			/* $query = $this->db->get_where('aadhar_api_response', array('mobile' => $this->input->post('mobile'), 'aadhar_no' => $this->input->post('aadhar'))); */
			
			$query = $this->db->order_by('id', 'desc')->get_where('aadhar_api_response',
				array(
					'mobile' => $this->input->post('mobile'),
					'aadhar_no' => $this->input->post('aadhar'),
					'aadhar_response_name !=' => '',
					'dob !=' => '',
					'status_code' => '200'
				)
			);
			if ($this->db->affected_rows() > 0) {
				$aadhar_response = $query->row_array();
				if ($aadhar_response['status_code'] == 200) {
					$data['status'] = 1;
					$data['msg'] = "Success";
					$data['aadhar_response'] = json_decode($aadhar_response['aadhar_response'],true);
					$data['request_type'] = $this->input->post('user_type');
					$data['dataType'] = "DB";
					return $data;
				}
				
			}
			$post_parameter = array(
				'uniqueId' => rand(),
				'uid' => $this->input->post('aadhar'),
			);
			//pr($post_parameter);exit;
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://svc.digitap.ai/ent/v3/kyc/intiate-kyc-auto',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($post_parameter),
				CURLOPT_HTTPHEADER => array(
					'authorization: ' .base64_encode('67508421:KNpUxleIN4dm6ZnEcyBvsHjdgoXZEkIx'), 
                    'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
				if ($err) {
				   // echo "cURL Error #:" . $err;
					$data['status'] = 0;
				   $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
				   $data['data'] = array();
				}else{
					$arr_response = json_decode($response, true);
					/* $lender_id = "";
					$borrower_id = "";
					if($this->input->post('user_type')=="lender"){
							$lender_id = $this->input->post('user_id');
					}else if($this->input->post('user_type')=="borrower"){
							$borrower_id = $this->input->post('user_id');
					} */
					$insert_arra = array(
					'mobile' => $this->input->post('mobile'),
					'user_type' => $this->input->post('user_type'),
					'source' => $this->input->post('source'),
					'aadhar_no' => $this->input->post('aadhar'),
					'name' => $this->input->post('fullname'),
					'aadhar_response' => $response,
					'status_code' => $arr_response['code'],
					'transactionId' => $arr_response['model']['transactionId'] ?? ''
					);
					//$this->saveResponse($insert_arra);
					$this->db->insert('aadhar_api_response', $insert_arra);
					 
					$data['status'] = 1;
					$data['msg'] = "Success";
					$data['aadhar_response'] = json_decode($response,true);
					$data['request_type'] = $this->input->post('user_type');
					$data['dataType'] = "Live";
				}
			  return $data;
    }

    public function aadhar_validate_okyc_api()
    {
        
			$query = $this->db->order_by('id', 'desc')->get_where('aadhar_api_response',
				array(
					'mobile' => $this->input->post('mobile'),
					'aadhar_response_name !=' => '',
					'dob !=' => '',
					'status_code' => '200'
				)
			);
			
				//echo $this->db->last_query();exit;
				 if ($this->db->affected_rows() > 0) {
					$response = $query->row()->aadhar_response;
					$arr_response = json_decode($response,true);
					
					$post_name = $this->replace_space($this->input->post('fullname'));
					$aadhar_name = $this->replace_space($arr_response['model']['name']);
					$final = "{".$post_name."}{".$aadhar_name."}";
					
					
					if($post_name == $aadhar_name){
						#Update Aadhar Step
						$this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->set('aadhar_step', 1);
                        $this->db->update('p2p_borrower_steps_credit_line');
						
						$arr_response['name_match'] = true;
						$arr_response['status'] = 1;
					}else{
						#Update Aadhar Step
						$this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->set('aadhar_step', 0);
                        $this->db->update('p2p_borrower_steps_credit_line');
						
						$arr_response['name_match'] = false;
						$arr_response['status'] = 0;
					}
					
					$arr_response['dataType'] = 'DB';
					return $arr_response;
					
				} 
				
				$post_parameter = array(
					'shareCode' => '1234',
					'otp' => $this->input->post('otp'),
					'transactionId' => $this->input->post('transactionId'),
					'codeVerifier' => $this->input->post('codeVerifier'),
					'fwdp' => $this->input->post('fwdp'),
					'validateXml' => $this->input->post('validateXml'),
				);
				
			   
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => 'https://svc.digitap.ai/ent/v3/kyc/submit-otp',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => json_encode($post_parameter),
					CURLOPT_HTTPHEADER => array(
					'authorization: ' .base64_encode('67508421:KNpUxleIN4dm6ZnEcyBvsHjdgoXZEkIx'), 
                    'Content-Type: application/json'
				    ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				if ($err) {
				   // echo "cURL Error #:" . $err;
					$data['status'] = 0;
				   $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
				   $data['data'] = array();
				}else{
				$arr_response = json_decode($response, true);
				
					if($arr_response['code'] == 400 || $arr_response['code'] == 500 || $arr_response['code'] == 403){
						$arr_response['status'] = 0;
					    $arr_response['dataType'] = 'Live!';
						$arr_response['name_match'] = false;
						return $arr_response;
					}
			
			
					$post_name = $this->replace_space($this->input->post('fullname'));
					$aadhar_name = $this->replace_space($arr_response['model']['name']);
					$final = "{".$post_name."}{".$aadhar_name."}";
					
					
					if($post_name == $aadhar_name){
						#Update Aadhar Step
						$this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->set('aadhar_step', 1);
                        $this->db->update('p2p_borrower_steps_credit_line');
						
						$arr_response['name_match'] = true;
						$arr_response['status'] = 1;
					}else{
						#Update Aadhar Step
						$this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->set('aadhar_step', 0);
                        $this->db->update('p2p_borrower_steps_credit_line');
						$arr_response['name_match'] = false;
						$arr_response['status'] = 0;
					}
					
					$arr_response['dataType'] = 'Live';
					
						$array_update = array(
						'aadhar_response_name' => $arr_response['model']['name']  ?? '',
						'dob' => date('Y-m-d', strtotime($arr_response['model']['dob'])),
						'address' => json_encode($arr_response['model']['address']),
						'status_code' => $arr_response['code'],
						'aadhar_response' => $response
					);
					//pr($array_update);exit;
					$this->db->where('mobile', $this->input->post('mobile'));
					$this->db->update('aadhar_api_response', $array_update);
					return $arr_response;
				}	
				
		
    }   
#Aadhar Validation Without OTP

    public function advanced_validate_post($postData){
		 //pr($postData);exit;
			  //$api_response =  $this->aadharDetailsCurl($this->input->post());
			  $query = $this->db->order_by('id', 'desc')->get_where('aadhar_validation_api_response',
					array(
						'mobile' => $postData['mobile'],
						'aadhar_no' => $postData['aadhar'],
						'source' => $postData['source']
					)
				);
				//echo $this->db->last_query();exit;
				
				 if ($this->db->affected_rows() > 0) {
					$response = $query->row()->aadhar_response;
					    $data['status'] = 1;
                        $data['msg'] = "Success";
						$data['dataType'] = 'DB';
                        $data['data'] = json_decode($response,true);
						
					return $data;
				}
                $request = json_encode(array(
                        'client_ref_num' => uniqid(),
                        'aadhaar' => $postData['aadhar'],
                    ));
					
	        	$request_header = array(
                       'authorization: ' .base64_encode('67508421:KNpUxleIN4dm6ZnEcyBvsHjdgoXZEkIx'), // UAT/DEMO
                        'Content-Type: application/json'
                    );			
                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  'https://svc.digitap.ai/validation/kyc/v1/aadhaar', // Aadhaar_API_URL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $request,
                    CURLOPT_HTTPHEADER => $request_header,
                ));
    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                       // echo "cURL Error #:" . $err;
                       $data['status'] = 0;
                       $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
                       $data['data'] = array();
                       
                    }else{
						$arr_response = json_decode($response, true);
						
						$insert_arra = array(
									'mobile' => $postData['mobile'],
									'user_type' => $postData['user_type'],
									'source' => $postData['source'],
									'borrower_id' => $postData['borrower_id'] ?? '',
									'lender_id' => $postData['lender_id'] ?? '',
									'aadhar_no' => $postData['aadhar'],
									'aadhaar_age_band' => $arr_response['result']['aadhaar_age_band'] ?? '',
									'aadhaar_gender' => $arr_response['result']['aadhaar_gender'] ?? '',
									'aadhaar_state' => $arr_response['result']['aadhaar_state'] ?? '',
									'aadhar_request' => json_encode($postData),
									'aadhar_response' => $response,
									'client_ref_num' => $arr_response['client_ref_num']
									);
						//pr($insert_arra);	exit;		
					   $this->db->insert('aadhar_validation_api_response', $insert_arra);
						  $data = array(  
							'status'=>1,
							'msg' => 'Success',
							'dataType' => 'live',
							'data' => $arr_response,
							
						);
					}
			return $data;
			
      
	}



   public function aadharDetailsCurl($post){
      
        $err = "";
        $response = "";
		
        $query = $this->db->order_by('id', 'desc')->get_where('aadhar_validation_api_response',
					array(
						'mobile' => $post['mobile'],
						'aadhar_no' => $post['aadhar_no'],
						'source' => $post['source']
					)
				);
				//echo $this->db->last_query();exit;
				//file_put_contents('logs/API/'.'Addhar-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$this->db->last_query()."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
				 if ($this->db->affected_rows() > 0) {
					$response = $query->row()->aadhar_response;
					    $data['status'] = 1;
                        $data['msg'] = "Success";
                        $data['data'] = $response;
					return $data;
				}
                $request = json_encode(array(
                        'client_ref_num' => uniqid(),
                        'aadhaar' => $post['aadhar_no'],
                    ));
					
	        	$request_header = array(
                       'authorization: ' .base64_encode('67508421:KNpUxleIN4dm6ZnEcyBvsHjdgoXZEkIx'), // UAT/DEMO
                        'Content-Type: application/json'
                    );			
                /********starting of curl function**********/
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  'https://svc.digitap.ai/validation/kyc/v1/aadhaar', // Aadhaar_API_URL,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $request,
                    CURLOPT_HTTPHEADER => $request_header,
                ));
    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
					
					//file_put_contents('logs/API/'.'Aadhar-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').'Request - '.$request.'Request Header client_id -'.json_encode($request_header).'Response -'.$response.PHP_EOL, FILE_APPEND); 
					
                    
                    if ($err) {
                       // echo "cURL Error #:" . $err;
                       $data['status'] = 0;
                       $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
                       $data['data'] = array();
                    }else{
						$arr_response = json_decode($response, true);
						$insert_arra = array(
									'mobile' => $this->input->post('mobile'),
									'user_type' => $this->input->post('user_type'),
									'source' => $this->input->post('source'),
									'borrower_id' => $post['borrower_id'],
									'lender_id' => $post['lender_id'],
									'aadhar_no' => $post['aadhaar'],
									'aadhaar_age_band' => $arr_response['result']['aadhaar_age_band'] ?? '',
									'aadhaar_gender' => $arr_response['result']['aadhaar_gender'] ?? '',
									'aadhaar_state' => $arr_response['result']['aadhaar_state'] ?? '',
									'aadhar_response' => $response,
									'client_ref_num' => $arr_response['client_ref_num']
									);
						//pr($insert_arra);			
					$this->db->insert('aadhar_validation_api_response', $insert_arra);
                        $data['status'] = 1;
                        $data['msg'] = "Success";
                        $data['data'] = $response;
                    } 
            return $data;

   }

  public function replace_space($name){
		$string = str_replace(' ', '-', $name);
		$string = preg_replace('/[^A-Za-z0-9.\-]/', '', $string);
		$string = preg_replace('/-+/', ' ', $string);
		$string = strtoupper($string);
		return $string;
	}
	/* public function saveResponse($response){
		$this->db->insert('aadhar_api_response', $response);
	} */
 	
  
}
