<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Aadhaar extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
		$this->load->library('form_validation');
        $this->load->model('Aadhar_Model');
        $this->p2pdb = $this->load->database('default', true);
       
        // Enable error reporting
        error_reporting(E_ALL);
    }

public function aadhar_initiate_okyc_api_post()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
		$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
		$this->form_validation->set_rules('uid', 'Aadhar', 'trim|required|regex_match[/^[6-9]\d{11}$/]');
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
		$this->form_validation->set_rules('source', 'Source', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$query = $this->db->get_where('aadhar_api_response', array('mobile' => $this->input->post('mobile'), 'aadhar_no' => $this->input->post('uid')));
			if ($this->db->affected_rows() > 0) {
				$aadhar_response = $query->row_array();
				if ($aadhar_response['status_code'] == 200) {
					
					$data['status'] = 1;
					$data['msg'] = "Success";
					$data['data'] = json_decode($aadhar_response['aadhar_response'],true);
					$this->set_response($data, REST_Controller::HTTP_OK);
					return;
				}
				
			}
			$post_parameter = array(
				'uniqueId' => rand(),
				'uid' => $this->input->post('uid'),
			);
			//pr($post_parameter);exit;
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://svcdemo.digitap.work/ent/v3/kyc/intiate-kyc-auto',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($post_parameter),
				CURLOPT_HTTPHEADER => array(
					'authorization: MTExOTkzNDQ6akZqWEd4bGxITHpzMWpsUUljTTlsZUpaTDRSUkFoQ2s=',
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);
			
			file_put_contents('logs/API/'.'Addhar-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
			curl_close($curl);
				$err = "";
				if ($err) {
				   // echo "cURL Error #:" . $err;
					$data['status'] = 0;
				   $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
				   $data['data'] = array();
				}else{
					$arr_response = json_decode($response, true);
					$lender_id = "";
					$borrower_id = "";
					if($this->input->post('user_type')=="lender"){
							$lender_id = $this->input->post('user_id');
					}else if($this->input->post('user_type')=="borrower"){
							$borrower_id = $this->input->post('user_id');
					}
					$insert_arra = array(
					'mobile' => $this->input->post('mobile'),
					'user_type' => $this->input->post('user_type'),
					'source' => $this->input->post('source'),
					'borrower_id' => $borrower_id,
					'lender_id' => $lender_id,
					'aadhar_no' => $this->input->post('uid'),
					'aadhar_response' => $response,
					'status_code' => $arr_response['code'],
					'transactionId' => $arr_response['model']['transactionId'] ?? ''
					);
					$this->Aadhar_Model->saveResponse($insert_arra);
					//$this->db->insert('aadhar_api_response', $insert_arra);
					 
					$data['status'] = 1;
					$data['msg'] = "Success";
					$data['data'] = $arr_response;
					
				}
			$this->set_response($data, REST_Controller::HTTP_OK);
			return;
		} else {
			$errmsg = array("error_msg" => validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
	 
    }

    public function aadhar_validate_okyc_api_post()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
		$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
		$this->form_validation->set_rules('uid', 'Aadhar', 'trim|required|regex_match[/^[6-9]\d{11}$/]');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		$this->form_validation->set_rules('transactionId', 'Transaction Id', 'trim|required');
		$this->form_validation->set_rules('codeVerifier', 'Code Verifier', 'trim|required');
		$this->form_validation->set_rules('fwdp', 'FWDP', 'trim|required');
		$this->form_validation->set_rules('validateXml', 'Validate Xml', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
				$query = $this->db->order_by('id', 'desc')->get_where('aadhar_api_response',
					array(
						'mobile' => $this->input->post('mobile'),
						'aadhar_no' => $this->input->post('uid'),
						'aadhar_response_name !=' => '',
						'dob !=' => '',
						'status_code' => '200'
					)
				);
				//echo $this->db->last_query();exit;
				 if ($this->db->affected_rows() > 0) {
					$response = $query->row()->aadhar_response;
					$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
					return;
				} 
				$post_parameter = array(
					'shareCode' => '1234',
					'otp' => $this->input->post('otp'),
					'transactionId' => $this->input->post('transactionId'),
					'codeVerifier' => $this->input->post('codeVerifier'),
					'fwdp' => $this->input->post('fwdp'),
					'validateXml' => $this->input->post('validateXml'),
				);
			   //pr($post_parameter);exit;
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => 'https://svcdemo.digitap.work/ent/v3/kyc/submit-otp',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => json_encode($post_parameter),
					CURLOPT_HTTPHEADER => array(
						'authorization: MTExOTkzNDQ6akZqWEd4bGxITHpzMWpsUUljTTlsZUpaTDRSUkFoQ2s=',
						'Content-Type: application/json'
					),
				));

				$response = curl_exec($curl);
				curl_close($curl);
				file_put_contents('logs/API/'.'Addhar-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
				$arr_response = json_decode($response, true);
			//pr($arr_response);exit;
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
				$this->set_response($arr_response, REST_Controller::HTTP_OK);
				return;
		} else {
			$errmsg = array("error_msg" => validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
    }   

    public function advanced_validate_post(){
            
        $headers = $this->input->request_headers();
        if($headers['client_id']=="antworkCurlApi" && $headers['secret']=="testing@1234#"){
			$_POST = json_decode(file_get_contents('php://input'), true);
			
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
			$this->form_validation->set_rules('aadhaar', 'Aadhar', 'trim|required|regex_match[/^[6-9]\d{11}$/]');
		    $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
			$this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
			$this->form_validation->set_rules('source', 'Source', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
			  $api_response =  $this->aadharDetailsCurl($this->input->post('mobile'), $this->input->post('aadhaar'), $this->input->post('source'));
			  
			  $data = array(  
                'status'=>$api_response['status'],
                'msg' => $api_response['msg'],
                'data' => json_decode($api_response['data'],true),
            );
			//pr($data);exit;
			  $this->response($data, REST_Controller::HTTP_OK);
			}else{
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
     }else{
		 $data = array(  
                'status'=>0,
                 'msg' => "Unauthorised User",
            );
           $this->set_response($data, REST_Controller::HTTP_UNAUTHORIZED);
	 }  
	}



   public function aadharDetailsCurl($mobile,$aadhaar, $source){
      
        $err = "";
        $response = "";
        $query = $this->db->order_by('id', 'desc')->get_where('aadhar_validation_api_response',
					array(
						'mobile' => $mobile,
						'aadhar_no' => $aadhaar,
						'source' => $source
					)
				);
				//echo $this->db->last_query();exit;
				 if ($this->db->affected_rows() > 0) {
					$response = $query->row()->aadhar_response;
					    $data['status'] = 1;
                        $data['msg'] = "Success";
                        $data['data'] = $response;
					return $data;
				}
                $request = json_encode(array(
                        'client_ref_num' => uniqid(),
                        'aadhaar' => $aadhaar,
                    ));
	        	$request_header = array(
                       'authorization: ' .base64_encode('11199344:jFjXGxllHLzs1jlQIcM9leJZL4RRAhCk'), // UAT/DEMO
                        'Content-Type: application/json'
                    );			
                /********starting of curl function**********/
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  'https://svcdemo.digitap.work/validation/kyc/v1/aadhaar', // Aadhaar_API_URL,
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
					
					file_put_contents('logs/API/'.'Aadhar-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').'Request - '.$request.'Request Header client_id -'.json_encode($request_header).'Response -'.$response.PHP_EOL, FILE_APPEND); 
					
                    
                    if ($err) {
                       // echo "cURL Error #:" . $err;
                       $data['status'] = 0;
                       $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
                       $data['data'] = array();
                    }else{
						$arr_response = json_decode($response, true);
						//pr($arr_response);exit;
						$lender_id = "";
						$borrower_id = "";
						if($this->input->post('user_type')=="lender"){
								$lender_id = $this->input->post('user_id');
						}else if($this->input->post('user_type')=="borrower"){
								$borrower_id = $this->input->post('user_id');
						}
						$insert_arra = array(
									'mobile' => $this->input->post('mobile'),
									'user_type' => $this->input->post('user_type'),
									'source' => $this->input->post('source'),
									'borrower_id' => $borrower_id,
									'lender_id' => $lender_id,
									'aadhar_no' => $aadhaar,
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


	
}