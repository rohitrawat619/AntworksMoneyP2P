<?php

class Bank_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Borrowermodel', 'P2papi/Commonapimodel'));
		$this->money = $this->load->database('money', true);
    }
	public function replace_space($name){
		$string = str_replace(' ', '-', $name);
		$string = preg_replace('/[^A-Za-z0-9.\-]/', '', $string);
		$string = preg_replace('/-+/', ' ', $string);
		$string = preg_replace('/\s+/', ' ', $string); // This line replaces multiple spaces with a single space
		$string = strtoupper($string);
		return $string;
	}
   public function add_bank_detail_borrower_lender($postData)
    {
		$source = $this->input->post('source');
        //$query = $this->db->get_where('p2p_borrower_bank_res', array('mobile' => $this->input->post('mobile'), 'account_no' => $this->input->post('account_no'), 'ifsc_code' => $this->input->post('ifsc_code'), 'bank_registered_name is not null' => null));
		$this->db->where(array(
    'mobile' => $this->input->post('mobile'),
    'account_no' => $this->input->post('account_no'),
    'ifsc_code' => $this->input->post('ifsc_code'),
));
$this->db->where('bank_registered_name IS NOT NULL');
$this->db->order_by('id', 'DESC'); 
$query = $this->db->get('p2p_borrower_bank_res');

		//echo $this->db->last_query();exit;
		
        if ($this->db->affected_rows() > 0)
        {
            $bank_result = $query->row_array();
			
			file_put_contents('logs/bank/'.$source.'_DB'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$bank_result['razorpay_response_fav']."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
            $res_razorpay = json_decode($bank_result['razorpay_response_fav'], true);
			
            if ($postData['borrower_id'] || $postData['lender_id'] || $postData['user_type']) {
                 $bank_data = array(
                    'borrower_id' => $postData['borrower_id']? $postData['borrower_id']: $bank_result['borrower_id'],
                    'lender_id' => $postData['lender_id'] ? $postData['lender_id']:$bank_result['lender_id'],
                    'user_type' => $this->input->post('user_type'),
                    'source' => $this->input->post('source'),
                    'mobile' => $this->input->post('mobile'),
                    'account_number' => $this->input->post('account_no'),
                    'ifsc_code' => $this->input->post('ifsc_code'),
                    'is_verified' => 0,
                );
				
                $this->db->get_where('p2p_borrower_bank_details', array('mobile' => $this->input->post('mobile')));
				
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->update('p2p_borrower_bank_details', $bank_data);
                } else {
                    $this->db->insert('p2p_borrower_bank_details', $bank_data);
					
                }
               
                if ($res_razorpay['model']['isNameMatch'] == true) {
                    if($this->input->post('user_type') == 'borrower'){
						
						#Get borrower Details from antworks_p2pdevelopment Database
                       $user_details = $this->get_borrower_detail_p2p($postData['borrower_id']);
					   
					   #update Borrower Id if Already KYC Done as a borrower
						$this->db->where('mobile', $this->input->post('mobile'));
                        $this->db->set('borrower_id', $postData['borrower_id']);
                        $this->db->update('p2p_borrower_bank_res');
					}else{
						#Get lender Details from antworks_p2pdevelopment Database
					 $user_details = $this->get_lender_detail_p2p($postData['lender_id']);
					 
					    #update Lender Id if Already KYC Done as a borrower
						$this->db->where('mobile', $this->input->post('mobile'));
                        $this->db->set('lender_id', $postData['lender_id']);
                        $this->db->update('p2p_borrower_bank_res');
						
					}
					 
                    $name = $this->replace_space($this->input->post('fullname'));
					$razorpay_bankname = $this->replace_space($res_razorpay['model']['beneficiaryName']);
					
					if ($res_razorpay['model']['isNameMatch'] == true) {
                    //if ($name == $razorpay_bankname) {
                        $this->db->where('borrower_id', $postData['borrower_id']);
                        $this->db->set('bank_account_step', 1);
                        $this->db->update('p2p_borrower_steps_credit_line');
                        $bank_res_arr = array(
                            'bank_name' => 'NA',//$res_razorpay['fund_account']['bank_account']['bank_name'],
                            'bank_registered_name' => $razorpay_bankname,
                            'is_verified' => '1',
                        );
                        $this->db->where('borrower_id', $postData['borrower_id']);
                        $this->db->where('mobile', $postData['mobile']);
                        //$this->db->or_where('lender_id', $postData['lender_id']);
                        $this->db->update('p2p_borrower_bank_details', $bank_res_arr);
						//file_put_contents('logs/bank/'.$this->input->post('source').'update issue in bank Table'.date('Y-m-d').'.txt'.$this->db->last_query()."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
						return $responseData = array(
							'status' => 1,
							'msg' => "Bank verified successfully!",
							'name_match' => true,
							'bank_response' => json_decode($bank_result['razorpay_response_fav'], true),
							'request_type' => $this->input->post('user_type'),
							'dataType' => "DB1",
						);

                    } else {
                        $this->db->where('borrower_id', $postData['borrower_id']);
                        $this->db->set('bank_account_step', 0);
                        $this->db->update('p2p_borrower_steps_credit_line');
                        return $responseData = array(
                            'status' => 0,
                            'msg' => "Registered Name Not Matched!",
                            'name_match' => false,
							'request_type' => $this->input->post('user_type'),
                            'dataType' => "DB2",
                        );
                    }
                }
                

            }
            
        }

        
        $name = $this->input->post('fullname');
       
		$data = json_encode(array(
					"accNo" => $this->input->post('account_no'),
					"ifsc" => $this->input->post('ifsc_code'),
					"benificiaryName" => $name,
					"address" => "India",
					"paymentMode" => "IMPS"
					));	
		//pr($data);exit;
        
		              $curl = curl_init();
						curl_setopt_array($curl, array(
						CURLOPT_URL => 'https://api.digitap.ai/penny-drop/v2/check-valid', 
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS =>$data,
						CURLOPT_HTTPHEADER => array(
						'ent_authorization: Njc1MDg0MjE6S05wVXhsZUlONGRtNlpuRWN5QnZzSGpkZ29YWkVrSXg=', //Basic Base64 encoded value of ClientID:SecretKey',
						'Content-Type: application/json'
						),
						));
					
						$response = curl_exec($curl);
						$err = curl_error($curl);
						curl_close($curl);

			//echo $response;exit;			
        if ($err) {
            ///alert emil to admin
        } else {
			file_put_contents('logs/bank/'.$source.'_validations'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
            $res = json_decode($response, true);
			
			if(isset($res['message']) || $res['message']="" || isset($res['model']['desc']) && $res['model']['status']=="FAILED"){
					$msg = $res['message'];
					if(isset($res['model']['desc']) && $res['model']['status']=="FAILED"){
							$msg = $res['model']['desc']."\n\r Recommended Action:".$res['model']['recommendedAction'];
						}else{
					$msg = "Incorrect information, please check your details";
					}
				return $responseData = array(
									'status' => 0,
									'msg' => $msg,
									'name_match' => 0,
									'bank_response' => '',
									'request_type' => '',
									'dataType' => "Live",
								);	
			}
			//pr($res);exit;
			#insert Data in Bank Details table
            $bank_res = array(
                'borrower_id' => $postData['borrower_id'],
				'lender_id' => $postData['lender_id'],
				'user_type' => $this->input->post('user_type'),
				'source' => $this->input->post('source'),
				'mobile' => $this->input->post('mobile'),
                'account_no' => $this->input->post('account_no'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'fav_id' => isset($res['model']['transactionId']) ? $res['model']['transactionId'] : '',
                'razorpay_response_bank_ac' => $response,
            );
            $this->db->insert('p2p_borrower_bank_res', $bank_res);
			
			#insert Data in Bank Details table
			$bank_data = array(
                    'borrower_id' => $postData['borrower_id'],
                    'lender_id' => $postData['lender_id'],
                    'user_type' => $this->input->post('user_type'),
                    'source' => $this->input->post('source'),
                    'mobile' => $this->input->post('mobile'),
                    'account_number' => $this->input->post('account_no'),
                    'ifsc_code' => $this->input->post('ifsc_code'),
                    'is_verified' => 0,
                );
			$this->db->insert('p2p_borrower_bank_details', $bank_data);	
            if (isset($res['model']['status']) && $res['model']['status']=="SUCCESS") {
                
                $fav_id = $res['model']['transactionId'];
                if ($fav_id) {
					file_put_contents('logs/bank/'.$source.'_'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' fav_id = '.$fav_id.' - '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
                   
                        //pr($response); exit;
                        $res_razorpay = json_decode($response, true);
                        if ($postData['borrower_id']) {
                            $this->db->where('borrower_id', $postData['borrower_id']);
                            $this->db->where('fav_id', $fav_id);
                            $this->db->set('razorpay_response_fav', $response);
                            $this->db->update('p2p_borrower_bank_res');

                                $this->db->where('mobile', $this->input->post('mobile'));
                                $this->db->where('fav_id', $fav_id);
                                $this->db->set('bank_registered_name', $this->replace_space($res_razorpay['model']['beneficiaryName']));
                                $this->db->update('p2p_borrower_bank_res');
                                if ($res_razorpay['model']['isNameMatch']==true) {
									#update Borrore steps for credit-line
									
                                     $this->db->where('borrower_id', $postData['borrower_id']);
                                    $this->db->set('bank_account_step', 1);
                                    $this->db->update('p2p_borrower_steps_credit_line');
                                    $bank_res_arr = array(
                                        'bank_name' => 'NA',
                                        'bank_registered_name' => $res_razorpay['model']['beneficiaryName'],
                                        'is_verified' => '1',
                                    );
                                    $this->db->where('mobile', $this->input->post('mobile'));
                                    $this->db->update('p2p_borrower_bank_details', $bank_res_arr);
									return $responseData = array(
										'status' => 1,
										'msg' => "Bank verified successfully!!",
										'name_match' => 1,
										'bank_response' => $res_razorpay,
										'request_type' => $this->input->post('user_type'),
										'dataType' => "Live",
									);

                                } else {
									#update Borrore steps for credit-line
									
                                     $this->db->where('borrower_id', $this->input->post('borrower_id'));
                                    $this->db->set('bank_account_step', 0);
                                    $this->db->update('p2p_borrower_steps_credit_line'); 

                                    return $responseData = array(
                                        'status' => 0,
                                        'msg' => "Registered Name Not Matched!!",
										'name_match' => 0,
										'bank_response' => $res_razorpay,
										'request_type' => $this->input->post('user_type'),
										'dataType' => "Live",
                                    );
                                }
                            
                        }
                        else {
                            #For lender
                            $this->db->where('mobile', $this->input->post('mobile'));
                            $this->db->where('fav_id', $fav_id);
                            $this->db->set('razorpay_response_fav', $response);
                            $this->db->update('p2p_borrower_bank_res');

                            //if ($res_razorpay['results']['account_status'] == 'active') {
						     if ($res_razorpay['model']['isNameMatch']==true) {
                                $this->db->where('mobile', $this->input->post('mobile'));
                                $this->db->where('fav_id', $fav_id);
                                $this->db->set('bank_registered_name', $res_razorpay['model']['beneficiaryName']);
                                $this->db->update('p2p_borrower_bank_res');
								
                                if ($this->replace_space($name) == $this->replace_space($res_razorpay['results']['registered_name'])) {
									$bank_res_arr = array(
                                        'bank_name' => 'NA',
                                        'bank_registered_name' => $res_razorpay['model']['beneficiaryName'],
                                        'is_verified' => '1',
                                    );
                                    $this->db->where('mobile', $this->input->post('mobile'));
                                    $this->db->update('p2p_borrower_bank_details', $bank_res_arr);
									return $responseData = array(
										'status' => 1,
										'msg' => "Bank verified successfully!!!!",
										'name_match' => 1,
										'bank_response' => $res_razorpay,
										'request_type' => $this->input->post('user_type'),
										'dataType' => "Live",
									);
                                }else{
									 return $responseData = array(
                                        'status' => 0,
                                        'bank_response' => $res_razorpay,
                                        'msg' => "Registered Name Not Matched!!!",
										'name_match' => 0,
										'request_type' => $this->input->post('user_type'),
                                        'dataType' => "Live",
                                    );
								}
                            }else{
								
									return $responseData = array(
									'status' => 0,
									'msg' => "Bank Not verified!!",
									'name_match' => 0,
									'bank_response' => $res_razorpay,
									'request_type' => $this->input->post('user_type'),
									'dataType' => "Live",
								);
							}

                            
                        }
                } else {
                     $this->db->where('borrower_id', $postData['borrower_id']);
                    $this->db->set('bank_account_step', 2);
                    $this->db->update('p2p_borrower_steps_credit_line'); 

                    return $responseData = array(
                        'status' => 0,
                        'msg' => "Wrong Approach! Please try again or contact system administrator.",
                    );
                }
            }
        }
    }
	public function get_borrower_detail_p2p($borrower_id)
    {
        $this->db->select('*');
        $this->db->where('id', $borrower_id);
        $this->db->from('p2p_borrowers_list');
        $query = $this->db->get();
		
        if ($this->db->affected_rows() > 0) {
            return $result = (array)$query->row();
        } else {
            return false;
        }
    }
	public function get_lender_detail_p2p($lender_id)
    {
		//$this->db = $this->load->database('db_p2p', TRUE);
        $this->db->select('*');
        $this->db->where('user_id', $lender_id);
        $this->db->from('p2p_lender_list');
        $query = $this->db->get();
		
        if ($this->db->affected_rows() > 0) {
            return $result = (array)$query->row();
        } else {
            return false;
        }
    }
#Old functions use in credit-line Borrower model
    
}

?>
