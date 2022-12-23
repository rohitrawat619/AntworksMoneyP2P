<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Ecollect extends REST_Controller
{

	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
	}

	public function validate_post()
	{
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			if ($this->input->server('PHP_AUTH_USER') === 'ANT_)2@20(' && $this->input->server('PHP_AUTH_PW') === 'ANT_(2@19)_)2@2@(') {
				$validate = json_decode(file_get_contents('php://input'), true);
				// Save all request from yes bank
				$this->db->insert('p2p_yes_validation_request', array(
					'request' => json_encode($validate)
				));
				if(empty($validate['validate']))
				{
					$response = array(
						'validateResponse' => array('decision' => 'Bad Request'),
					);
					$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
				$_POST = $validate['validate'];
				$payment_validate = array();
				$this->form_validation->set_rules('customer_code', 'customer_code', 'trim|required');
				$this->form_validation->set_rules('bene_account_no', 'bene_account_no', 'trim|required');
				$this->form_validation->set_rules('bene_account_ifsc', 'bene_account_ifsc', 'trim|required');
				$this->form_validation->set_rules('transfer_type', 'transfer_type', 'trim|required');
				$this->form_validation->set_rules('transfer_unique_no', 'transfer_unique_no', 'trim|required');
				$this->form_validation->set_rules('transfer_timestamp', 'transfer_timestamp', 'trim|required');
				$this->form_validation->set_rules('transfer_amt', 'transfer_amt', 'trim|required');
				$this->form_validation->set_rules('rmtr_account_no', 'rmtr_account_no', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$bene_account_no_customer_code = substr($this->input->post('bene_account_no'), 0, 6);
					if($this->customer_code == $this->input->post('customer_code') && $this->customer_code == $bene_account_no_customer_code)
					{
						$bene_account_key_array = array('A', 'B', 'C');
						$bene_account_key = substr($this->input->post('bene_account_no'), 6,1);
						if(!in_array($bene_account_key, $bene_account_key_array)){
							$response = array(
								'validateResponse' => array('decision' => 'reject', 'reject_reason' => 'invalid request'),
							);
							$this->set_response($response, REST_Controller::HTTP_OK);
							return;
						}
						if(strlen($this->input->post('bene_account_no')) != 18)
						{
							$response = array(
								'validateResponse' => array('decision' => 'reject', 'reject_reason' => 'invalid request'),
							);
							$this->set_response($response, REST_Controller::HTTP_OK);
							return;
						}

						//Payment Array
						$payment_validate = array(
							'customer_code' => $this->input->post('customer_code'),
							'bene_account_no' => $this->input->post('bene_account_no'),
							'bene_account_ifsc' => $this->input->post('bene_account_ifsc'),
							'bene_full_name' => $this->input->post('bene_full_name') ? $this->input->post('bene_full_name') : '',
							'transfer_type' => $this->input->post('transfer_type'),
							'transfer_unique_no' => $this->input->post('transfer_unique_no'),
							'transfer_timestamp' => $this->input->post('transfer_timestamp'),
							'transfer_ccy' => $this->input->post('transfer_ccy') ? $this->input->post('transfer_ccy') : '',
							'transfer_amt' => $this->input->post('transfer_amt'),
							'rmtr_account_no' => $this->input->post('rmtr_account_no'),
							'rmtr_account_ifsc' => $this->input->post('rmtr_account_ifsc') ? $this->input->post('rmtr_account_ifsc') : '',
							'rmtr_account_type' => $this->input->post('rmtr_account_type') ? $this->input->post('rmtr_account_type') : '',
							'rmtr_full_name' => $this->input->post('rmtr_full_name') ? $this->input->post('rmtr_full_name') : '',
							'rmtr_address' => $this->input->post('rmtr_address') ? $this->input->post('rmtr_address') : '',
							'rmtr_to_bene_note' => $this->input->post('rmtr_to_bene_note') ? $this->input->post('rmtr_to_bene_note') : '',
							'attempt_no' => $this->input->post('attempt_no') ? $this->input->post('attempt_no') : '',
							'Status' => $this->input->post('Status') ? $this->input->post('Status') : '',
							'credit_acct_no' => $this->input->post('credit_acct_no') ? $this->input->post('credit_acct_no') : '',
							'credited_at' => $this->input->post('credited_at') ? $this->input->post('credited_at') : '',
							'returned_at' => $this->input->post('returned_at') ? $this->input->post('returned_at') : '',
						);
						if($this->input->post('transfer_type') == 'NEFT')
						{
							$this->db->get_where('p2p_yes_transactions', array('transfer_type' => 'NEFT', 'transfer_unique_no' => $this->input->post('transfer_unique_no'), 'bene_account_ifsc' => $this->input->post('bene_account_ifsc')));

							if($this->db->affected_rows() > 0)
							{
								$response = array(
									'validateResponse' => array('decision' => 'reject', 'reject_reason' => 'already exist.'),
								);
								$this->set_response($response, REST_Controller::HTTP_OK);
								return;
							}
							else{
								$this->db->insert('p2p_yes_transactions', $payment_validate);
								if($this->db->affected_rows()>0)
								{
									$response = array(
										'validateResponse' => array('decision' => 'pass'),
									);
									$this->set_response($response, REST_Controller::HTTP_OK);
									return;
								}
								else{
									$response = array(
										'validateResponse' => array('decision' => 'Internal Server Error'),
									);
									$this->set_response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
									return;
								}
							}
						}
						else{
							$this->db->get_where('p2p_yes_transactions', array('transfer_unique_no' => $this->input->post('transfer_unique_no')));
							if($this->db->affected_rows() > 0)
							{
								$response = array(
									'validateResponse' => array('decision' => 'reject', 'reject_reason' => 'Already exist'),
								);
								$this->set_response($response, REST_Controller::HTTP_OK);
								return;
							}
							else{
								$this->db->insert('p2p_yes_transactions', $payment_validate);
								if($this->db->affected_rows()>0)
								{
									$response = array(
										'validateResponse' => array('decision' => 'pass'),
									);
									$this->set_response($response, REST_Controller::HTTP_OK);
									return;
								}
								else{
									$response = array(
										'validateResponse' => array('decision' => 'Internal Server Error'),
									);
									$this->set_response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
									return;
								}
							}
						}
					}
					else{
						$response = array(
							'validateResponse' => array('decision' => 'reject', 'reject_reason' => 'invalid request'),
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}

				}
				else{
					$response = array(
						'validateResponse' => array('decision' => 'Bad Request'),
					);
					$this->set_response("Bad Request", REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
			}
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;

	}

	public function notify_post()
	{
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			if ($this->input->server('PHP_AUTH_USER') === 'ANT_)2@20(' && $this->input->server('PHP_AUTH_PW') === 'ANT_(2@19)_)2@2@(') {
				$notify = json_decode(file_get_contents('php://input'), true);
				//Save All Notify Request
				$this->db->insert('p2p_yes_notify_request', array(
					'request' => json_encode($notify)
				));
				if(empty($notify['notify']))
				{
					$response = array(
						'notifyResult' => array('result' => 'Bad Request', 'reject_reason' => 'invalid request'),
					);
					$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
				$_POST = $notify['notify'];
				$this->form_validation->set_rules('customer_code', 'customer_code', 'trim|required');
				$this->form_validation->set_rules('bene_account_no', 'bene_account_no', 'trim|required');
				$this->form_validation->set_rules('bene_account_ifsc', 'bene_account_ifsc', 'trim|required');
				$this->form_validation->set_rules('transfer_type', 'transfer_type', 'trim|required');
				$this->form_validation->set_rules('transfer_unique_no', 'transfer_unique_no', 'trim|required');
				$this->form_validation->set_rules('transfer_timestamp', 'transfer_timestamp', 'trim|required');
				$this->form_validation->set_rules('transfer_amt', 'transfer_amt', 'trim|required');
				$this->form_validation->set_rules('rmtr_account_no', 'rmtr_account_no', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$bene_account_no_customer_code = substr($this->input->post('bene_account_no'), 0, 6);
					if($this->customer_code == $this->input->post('customer_code') && $this->customer_code == $bene_account_no_customer_code)
					{
						$bene_account_key_array = array('A', 'B', 'C');
						$bene_account_key = substr($this->input->post('bene_account_no'), 6,1);
						if(!in_array($bene_account_key, $bene_account_key_array)){
							$response = array(
								'notifyResult' => array('result' => 'Bad Request', 'reject_reason' => 'invalid request'),
							);
							$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
							return;
						}
						if(strlen($this->input->post('bene_account_no')) != 18)
						{
							$response = array(
								'notifyResult' => array('result' => 'Bad Request', 'reject_reason' => 'invalid request'),
							);
							$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
							return;
						}
						$response = array(
							'notifyResult' => array('result' => 'ok'),
						);
						$this->set_response($response, REST_Controller::HTTP_OK);
						return;
					}
					else{

						$response = array(
							'notifyResult' => array('result' => 'Bad Request', 'reject_reason' => 'invalid request'),
						);
						$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
						return;
					}

				}
				else{
					$response = array(
						'notifyResult' => array('result' => 'Bad Request', 'reject_reason' => 'invalid request'),
					);
					$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
			}
		}

		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}
}

?>
