<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Investapip2p extends REST_Controller{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
		$this->app = $this->load->database('app', TRUE);
		
        
        $this->load->library('middleware');
        
        $this->load->model(array('Requestmodel', 'Smssetting', 'Commonapimodel','Invest_model_p2p','Communication_model'));
    }
	
	public function all_schemes_post()
    {
         
                $_POST = json_decode(file_get_contents('php://input'),true);
				$this->form_validation->set_rules('phone', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
				if ($this->form_validation->run() == TRUE) {
					$all_scheme = $this->Invest_model_p2p->get_all_scheme();
					#Send Mail KYC Pending
							/* $product_type = 'AntpaySurge';
							$instance = 'KYC Pending';
							echo $this->Communication_model->sendEmail($this->input->post('phone'),$product_type, $instance, $amount = '');exit; */
					    #end
					if($all_scheme)
					{
						$response = array(
							'status'=>1,
							'schemes'=>$all_scheme,
							'kyc_status'=>$this->Invest_model_p2p->getKycStatus($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}
					else{
						$response = array(
							'status'=>1,
							'schemes'=>'Not found',
							'kyc_status'=>$this->Invest_model_p2p->getKycStatus($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
           
    }
	public function user_personal_detail_post()
    {
         
                $_POST = json_decode(file_get_contents('php://input'),true);
				$postData = $this->input->post();
				
				$this->form_validation->set_rules('vendor_id','Vendor ID','required|trim');
				$this->form_validation->set_rules('fullname','fullname','required');
				$this->form_validation->set_rules('phone','phone','required|trim|required|regex_match[/^[0-9]{10}$/]');
                $this->form_validation->set_rules('gender','gender','required');
                $this->form_validation->set_rules('DOB','DOB','required');
				$this->form_validation->set_rules('PAN','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
				if ($this->form_validation->run() == TRUE) {
					
						#check User exist in main P2P  Database Table-p2p_lender_list
						$response = $this->Invest_model_p2p->check_user_exist_in_p2p();
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
          
    }
	public function kyc_status_post()
    {
         
                $_POST = json_decode(file_get_contents('php://input'),true);
				$this->form_validation->set_rules('phone', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
				$this->form_validation->set_rules('vendor_id', 'Vendor ID', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					
						$response = array(
							'status'=>1,
							'kyc_status'=>$this->Invest_model_p2p->getKycStatus($this->input->post('phone'))
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					
					
				}else {
					$errmsg = array("error_msg" => validation_errors());
					$this->set_response($errmsg, REST_Controller::HTTP_OK);
					return;
                }
        
    }
	public function lender_investment_post(){
		 
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 $this->form_validation->set_rules('lender_id','Lender ID','required');
			$this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('scheme_id','Scheme ID','required');
			 $this->form_validation->set_rules('amount','Amount','required');
			 $this->form_validation->set_rules('ant_txn_id','Transaction Id','required');
			 $this->form_validation->set_rules('source','Source','required');
			 $this->form_validation->set_rules('product','Product','required');
			  if ($this->form_validation->run() == TRUE) {
				  $query = $this->db->select('Interest_Rate,hike_rate,Pre_Mat_Rate,Tenure,lockin_Period')->get_where('invest_scheme_details',array('id'=>$this->input->post('scheme_id')));
				  //echo $this->db->last_query();exit;
				   if($this->db->affected_rows()>0){
					   $investment_no = $this->Invest_model_p2p->create_investment_no();
						   $result = (array)$query->row();
						   $investData = array(
									'investment_No' => $investment_no,
									'lender_id' => $this->input->post('lender_id'),
									'mobile' => $this->input->post('phone'),
									'scheme_id' => $this->input->post('scheme_id'),
									'amount' => $this->input->post('amount'),
									'basic_rate' => $result['Interest_Rate'],
									'hike_rate' => $result['hike_rate'],
									'pre_mat_rate' => $result['Pre_Mat_Rate'],
									'ant_txn_id' => $this->input->post('ant_txn_id'),
									'source' => $this->input->post('source'),
									'product' => $this->input->post('product'),
									'tenure' => $result['Tenure'], // added new field 2024-june-19
									'lockin_period' => $result['tenure'], // added new field 2024-june-19
								);
								
							
							$this->db->insert('p2p_lender_investment', $investData);
							
							/*************starting of lender statement generation**********/
							 $partner_id = $this->Invest_model_p2p->getPartnerIdBySchemeID($this->input->post('scheme_id'));
							 $lenderBalance = $this->Invest_model_p2p->getLastLenderStatementbalance($investData['lender_id'], $partner_id);
							 $title = $investData['amount']." Invested By Lender";
							$lenderStatementData['lender_id'] = $investData['lender_id'];
							$lenderStatementData['refrence'] = $investData['investment_No'];
							$lenderStatementData['reference_type'] = "investment_no";
							$lenderStatementData['transaction_type'] = "investment";
							
							$lenderStatementData['amount'] = $investData['amount']; // actual amount
							$lenderStatementData['credit'] = $investData['amount'];  // credited amount
							$lenderStatementData['source'] = $investData['source'];  // credited amount
							$lenderStatementData['partner_id'] = $partner_id;
							$lenderStatementData['balance'] = ($lenderBalance+$investData['amount']);
							$lenderStatementData['title'] = $title;
							$lenderStatementData['created_date'] = date("Y-m-d H:i:s");
							
							$this->db->insert('lendsocial_lender_statement', $lenderStatementData);
							
							$lenderStatementQueData['lender_id'] = $investData['lender_id'];
							$lenderStatementQueData['invest_id'] = $investData['investment_No'];
							$lenderStatementQueData['amount'] = $investData['amount'];
							$lenderStatementQueData['remaining_amount'] = $investData['amount'];
							$lenderStatementQueData['status'] = 1; //0:inactive; 1:active
							$lenderStatementQueData['source'] = $investData['source'];
							$lenderStatementQueData['partner_id'] = $partner_id;
							
							$lenderStatementQueData['created_date'] = date("Y-m-d H:i:s");
							
							$this->db->insert('lendsocial_lender_loan_priority_allocation_queue', $lenderStatementQueData);
							
							/*************ending of lender statement generation************/
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
	public function lender_investment_details_post(){
		/*  $auth = $this->middleware->auth();
        if ($auth) { */ 
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 //$this->form_validation->set_rules('lender_id','Lender ID','required');
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			  if ($this->form_validation->run() == TRUE) {
				  $investment_details = $this->Invest_model_p2p->investment_details();
				  
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
		 /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
	}
	
	public function lender_mismatch_post(){
		
			 $_POST = json_decode(file_get_contents('php://input'), true);
			 
			 $this->form_validation->set_rules('lender_id','Lender ID','required');
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			  if ($this->form_validation->run() == TRUE) {
				  $this->db->insert('p2p_mismatch_users', array(
								'lender_id' => $this->input->post('lender_id'),
								'mobile' => $this->input->post('phone'),
								'source' => $this->input->post('source'),
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
	public function redemption_request_post(){
		
			 $_POST = json_decode(file_get_contents('php://input'), true);
			
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('investment_no','Investment No.','required');
			  if ($this->form_validation->run() == TRUE) {
				  $redemption_request = $this->Invest_model_p2p->redemption_request();
				  
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
	public function redemption_status_post(){
		  
			$_POST = json_decode(file_get_contents('php://input'), true);
			
			 $this->form_validation->set_rules('phone','phone','required|trim|regex_match[/^[0-9]{10}$/]');
			 $this->form_validation->set_rules('investment_no','Investment No.','required');
			  if ($this->form_validation->run() == TRUE) {
				  
				  $this->db->where('investment_No', $this->input->post('investment_no'));
				  $this->db->where('mobile', $this->input->post('phone'));
				  $this->db->where('redemption_status', 0);
                  $this->db->set('redemption_status', 1);
                  $this->db->set('redemption_date', date('Y-m-d h:i:sa'));
                  $this->db->update('p2p_lender_investment');
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
