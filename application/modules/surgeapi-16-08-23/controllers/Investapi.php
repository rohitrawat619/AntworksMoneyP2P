<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Investapi extends REST_Controller{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
		//$this->investDB = $this->load->database('invest', TRUE);
		$this->cldb = $this->load->database('credit-line', TRUE);
        $this->load->library('form_validation');
        $this->load->library('middleware');
        $this->load->helper('form');
        $this->load->model(array('Requestmodel', 'Smssetting', 'Commonapimodel','Invest_model'));
    }
	
	public function all_schemes_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) { */
                $_POST = json_decode(file_get_contents('php://input'),true);
				$this->form_validation->set_rules('phone', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
				if ($this->form_validation->run() == TRUE) {
					$all_scheme = $this->Invest_model->get_all_scheme();
					
					if($all_scheme)
					{
						$response = array(
							'status'=>1,
							'schemes'=>$all_scheme,
							'kyc_status'=>$this->Invest_model->get_kyc_status($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}
					else{
						$response = array(
							'status'=>0,
							'schemes'=>'Not found',
							'kyc_status'=>$this->Invest_model->get_kyc_status($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function user_personal_detail_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) { */
                $_POST = json_decode(file_get_contents('php://input'),true);
				$postData = $this->input->post();
				$this->form_validation->set_rules('vendor_id','Vendor ID','required|trim');
				$this->form_validation->set_rules('fullname','fullname','required');
				$this->form_validation->set_rules('phone','phone','required|trim|required|regex_match[/^[0-9]{10}$/]');
                $this->form_validation->set_rules('gender','gender','required');
                $this->form_validation->set_rules('DOB','DOB','required');
				$this->form_validation->set_rules('PAN','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
				if ($this->form_validation->run() == TRUE) {
					$pan_response = $this->Invest_model->basic_pan_kyc();
					$arr_response = json_decode($pan_response, true);
					
					if ($arr_response['result']['name_match'] == true) {
						#check User exist in main P2P  Database Table-p2p_lender_list
						$user_exist_in_p2p = $this->Invest_model->check_user_exist_in_p2p();
						//pr($user_exist_in_p2p);exit;
						if($user_exist_in_p2p['status'] == 1 && $user_exist_in_p2p['msg'] == 'PAN Mismatch'){
							//echo $user_exist_in_p2p['msg'];exit;
							/* $this->cldb->insert('p2p_lender_list', array(
										'lender_id' => $user_exist_in_p2p['lender_id'],
										'vendor_id' => 3,
										'name' => $postData['fullname'],
										'gender' => $postData['gender'],
										'email' => $postData['email'],
										'mobile' => $postData['phone'],
										'dob' => date('Y-m-d', strtotime(str_replace('/', '-', $postData['DOB']))),
										'pan' => $postData['PAN']
									)); */
							$response = array(
									'status'=>2,
									'lender_id'=>$user_exist_in_p2p['lender_id'],
									'msg'=>$user_exist_in_p2p['msg']
									
								);
								$this->set_response($response, REST_Controller::HTTP_OK);
								return;
							
						}
						if($user_exist_in_p2p['status'] == 1 && $user_exist_in_p2p['msg'] == 'Already Exist'){
							
							//$query = $this->cldb->get_where('p2p_lender_list', array('pan' => $postData['PAN'], 'mobile' => $postData['phone']));
							$query = $this ->cldb
									   -> select('*')
									   -> where('mobile', $this->input->post('phone'))
									   -> or_where('pan', $this->input->post('PAN'))
									   -> or_where('email', $this->input->post('email'))
									   -> get('p2p_lender_list');
								if ($this->cldb->affected_rows() > 0)
								{
									//echo 'exist in new p2p';exit;
									$lender_details = $query->row();
									$lender_id = $lender_details->lender_id;
								}else{
									//echo 'Not exist in new p2p';exit;
									$lender_id = $this->create_lender_id();
									# Create Leander in Credit Line P2P 			
								$this->cldb->insert('p2p_lender_list', array(
										'lender_id' => $user_exist_in_p2p['lender_id'],
										'vendor_id' => $this->input->post('vendor_id'),
										'name' => $postData['fullname'],
										'gender' => $postData['gender'],
										'email' => $postData['email'],
										'mobile' => $postData['phone'],
										'dob' => date('Y-m-d', strtotime(str_replace('/', '-', $postData['DOB']))),
										'pan' => $postData['PAN']
									));
								}
							
							
						}else{
								//echo 'New User';exit;
							$lender_id = $this->create_lender_id();
							# Create Leander in antworksP2P 
							  $this->db->insert('p2p_lender_list', array(
										'lender_id' => $lender_id,
										'name' => $postData['fullname'],
										'gender' => $postData['gender'],
										'email' => $postData['email'],
										'mobile' => $postData['phone'],
										'dob' => date('Y-m-d', strtotime(str_replace('/', '-', $postData['DOB']))),
										'pan' => $postData['PAN'],
										'source_of_lead' => 'Surge',
										'created_date'=>date("Y-m-d H:i:s"),
                                        'modified_date'=>date("Y-m-d H:i:s"),
									));
						     # Create Leander in Credit Line P2P 			
								$this->cldb->insert('p2p_lender_list', array(
										'lender_id' => $lender_id,
										'vendor_id' => $this->input->post('vendor_id'),
										'name' => $postData['fullname'],
										'gender' => $postData['gender'],
										'email' => $postData['email'],
										'mobile' => $postData['phone'],
										'dob' => date('Y-m-d', strtotime(str_replace('/', '-', $postData['DOB']))),
										'pan' => $postData['PAN']
									));
						}
                        #Genrate Token  Start
						$tokenData['user_id'] = $lender_id;
						$token_data['fullname'] = $postData['fullname']; 
						$tokenData['email'] = $postData['email'];
						//pr($tokenData);exit;
						//$tokenData['generated_timestamp'] = date('Y-m-d H:i:s');
						$oath_token = AUTHORIZATION::generateToken($tokenData);
						#Genrate Token End
						
                        $this->cldb->where('mobile', $postData['phone']);
                        $this->cldb->update('p2p_lender_list', array('pan_kyc' => 1,'oath_token' => $oath_token));
						
						
						$response = array(
							'status'=>1,
							'lender_id'=>$lender_id,
							'Authorization' => $oath_token,
							'msg'=>"User Basic KYC Done!!"
							);
						
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
                    } else {
                        if ($arr_response['result']['status'] == 'Invalid') {
                            $this->cldb->where('phone', $postData['phone']);
                            $this->cldb->update('p2p_lender_list', array('pan_kyc' => 0));
                        } 
						$response = array(
							'status'=>0,
							'lender_id'=>'',
							'msg'=>"Please Check the Pan No, or name on PAN card!"
							
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
                    }
				
					
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function user_bank_detail_post()
    {
        $auth = $this->middleware->auth();
        if ($auth) {
                $_POST = json_decode(file_get_contents('php://input'),true);
				$postData = $this->input->post();
				//pr($postData);exit;
				
				$this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
				$this->form_validation->set_rules('fullname','Full Name','required|trim');
				$this->form_validation->set_rules('account_no','account_no','required');
				$this->form_validation->set_rules('caccount_no','caccount_no','required|matches[account_no]'); 
				$this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
				if ($this->form_validation->run() == TRUE) {
					 $query = $this->cldb->get_where('p2p_lender_list', array('mobile' => $postData['phone']));
                    if ($this->cldb->affected_rows() > 0) {
						$lender_details = $query->row();
						$bank_kyc_response = $this->Invest_model->basic_bank_kyc($postData);
					   $arr_response = json_decode($bank_kyc_response, true);
					   if ($arr_response['results']['account_status'] == 'active') {
						   $name = strtoupper($lender_details->name);
					       $razorpay_bankname = strtoupper($arr_response['results']['registered_name']);
						   
						   if (str_replace(' ', '', $name) == str_replace(' ', '', $razorpay_bankname)) {
							$this->cldb->where('mobile', $this->input->post('phone'));
							$this->cldb->set('account_kyc', 1);
							$this->cldb->update('p2p_lender_list');
							$response = array(
								'status' => 1,
								'lender_id'=>$lender_details->lender_id,
								'msg' => "Bank verified successfully!",
							);
							
							$this->set_response($response, REST_Controller::HTTP_OK);
						return;
							/* $bank_res_arr = array(
								'bank_name' => $res_razorpay['fund_account']['bank_account']['bank_name'],
								'bank_registered_name' => str_replace(' ', '', $razorpay_bankname),
								'is_verified' => '1',
							);
							$this->db->where('borrower_id', $this->input->post('borrower_id'));
							$this->db->update('p2p_borrower_bank_details', $bank_res_arr); */

						} else {
							/* $this->db->where('borrower_id', $this->input->post('borrower_id'));
							$this->db->set('bank_account_step', 2);
							$this->db->update('p2p_borrower_steps'); */
							$response = array(
								'status' => 0,
								'msg' => "Bank not verified successfully!",
							);
							
							$this->set_response($response, REST_Controller::HTTP_OK);
						return;
						}
					}
				}
					
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }
	public function kyc_status_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) {  */
                $_POST = json_decode(file_get_contents('php://input'),true);
				$this->form_validation->set_rules('phone', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
				//$this->form_validation->set_rules('vendor_id', 'Vendor ID', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					
						$response = array(
							'status'=>1,
							'kyc_status'=>$this->Invest_model->get_kyc_status($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					
					
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
        //}
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); 
    }
	public function lender_investment_post(){
		$auth = $this->middleware->auth();
        if ($auth) {
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 $this->form_validation->set_rules('lender_id','Lender ID','required');
			$this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('scheme_id','Scheme ID','required');
			 $this->form_validation->set_rules('amount','Amount','required');
			 $this->form_validation->set_rules('ant_txn_id','Transaction Id','required');
			  if ($this->form_validation->run() == TRUE) {
				  $query = $this->cldb->select('Interest_Rate,hike_rate,Pre_Mat_Rate')->get_where('invest_scheme_details',array('id'=>$this->input->post('scheme_id')));
				   if($this->cldb->affected_rows()>0){
					   $investment_no = $this->create_investment_no();
						   $result = (array)$query->row();
						   //pr($result);exit;
						   
							$this->cldb->insert('p2p_lender_reinvestment', array(
									'investment_No' => $investment_no,
									'lender_id' => $this->input->post('lender_id'),
									'mobile' => $this->input->post('phone'),
									'scheme_id' => $this->input->post('scheme_id'),
									'amount' => $this->input->post('amount'),
									'basic_rate' => $result['Interest_Rate'],
									'hike_rate' => $result['hike_rate'],
									'pre_mat_rate' => $result['Pre_Mat_Rate'],
									'ant_txn_id' => $this->input->post('ant_txn_id'),
									'source' => 'surge',
								));
					   $response = array(
								'status' => 1,
								'investment_no' => $investment_no,
								'msg' => "Investment add successfully!",
							);
				   }else{
					   $response = array(
								'status' => 0,
								'investment_no' => '',
								'msg' => "Investment Not Add successfully!",
							);
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
	public function create_lender_id()
    {
        $this->db->select("lender_id");
        $this->db->from('p2p_lender_list');
        $this->db->order_by('lender_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $lid = $row['lender_id'];
            $lid++;
           return $lender_id = $lid;
        }
        else
        {
           return $lender_id = "LR10000001";
        }
    }
	public function create_investment_no()
    {
        $this->cldb->select("investment_No");
        $this->cldb->from('p2p_lender_reinvestment');
        $this->cldb->order_by('investment_No', 'DESC');
        $this->cldb->where('source', 'surge');
        $this->cldb->limit(1);
        $query = $this->cldb->get();
        $row = (array)$query->row();
        if($this->cldb->affected_rows()>0)
        {
            $lid = $row['investment_No'];
            $lid++;
           return $investment_No = $lid;
        }
        else
        {
           return $investment_No = "INV10000001";
        }
    }
	public function lender_investment_details_post(){
		$auth = $this->middleware->auth();
        if ($auth) {
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 //$this->form_validation->set_rules('lender_id','Lender ID','required');
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			  if ($this->form_validation->run() == TRUE) {
				  $investment_details = $this->Invest_model->investment_details();
				  
                   $response = array(
							'status' => 1,
							'investment_details' => $investment_details,
						);
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
	public function redemption_request_post(){
		$auth = $this->middleware->auth();
        if ($auth) {
			 $_POST = json_decode(file_get_contents('php://input'), true);
			
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('investment_no','Investment No.','required');
			  if ($this->form_validation->run() == TRUE) {
				  $redemption_request = $this->Invest_model->redemption_request();
				  
                   $response = array(
							'status' => 1,
							'redemption_request' => $redemption_request,
						);
					
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
	public function redemption_status_post(){
		$auth = $this->middleware->auth();
        if ($auth) {
			$_POST = json_decode(file_get_contents('php://input'), true);
			
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('investment_no','Investment No.','required');
			  if ($this->form_validation->run() == TRUE) {
				  
				  $this->cldb->where('investment_No', $this->input->post('investment_no'));
				  $this->cldb->where('mobile', $this->input->post('phone'));
				  $this->cldb->where('redemption_status', 0);
                  $this->cldb->set('redemption_status', 1);
                  $this->cldb->set('redemption_date', date('Y-m-d h:i:sa'));
                  $this->cldb->update('p2p_lender_reinvestment');
				   $response = array(
							'status' => 1,
							'mes' => 'Redemption in Process',
						);
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
	public function lender_mismatch_post(){
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 
			 $this->form_validation->set_rules('lender_id','Lender ID','required');
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			  if ($this->form_validation->run() == TRUE) {
				  $this->cldb->insert('p2p_mismatch_users', array(
								'lender_id' => $this->input->post('lender_id'),
								'mobile' => $this->input->post('phone'),
								'source' => 'surge',
							));
				  
                   $response = array(
							'status' => 1,
							'msg' => 'User Add successfully',
						);
					$this->set_response($response, REST_Controller::HTTP_OK);
					return;
			}else {
				$errmsg = array("error_msg" => validation_errors());
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			}
		 
	}
    public function authdb($str, $field)
    {
		$db2 = $this->load->database('invest', TRUE);
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($db2)
            ? ($db2->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
            : FALSE;
    }
}

?>
