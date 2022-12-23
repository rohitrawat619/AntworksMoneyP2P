<?php
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

class Lenderaction extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lenderactionmodel');
		$this->load->library('form_validation');
	}

	public function create_escrow()
	{

		$this->Lenderactionmodel->updatelenderescrow();
	}

	public function addaccountdetails()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->form_validation->set_rules('account_no', 'account no', 'trim|required');
			$this->form_validation->set_rules('caccount_no', 'confirm account no', 'trim|required');
			$this->form_validation->set_rules('ifsc_code', 'Ifsc code', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$data = json_encode(
					array(
						"fund_account" => array(
							"account_type" => 'bank_account',
							"bank_account" => array(
								"name" => $this->session->userdata('name'),
								"ifsc" => $this->input->post('ifsc_code'),
								"account_number" => $this->input->post('account_no'),
							),
						),
						"amount" => "100",
						"currency" => "INR",
						"notes" => array(
							"random_key_1" => "",
							"random_key_2" => "",
						),
					)
				);

				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/json",
						"authorization: Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v",
					),
				));
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				if ($err) {
					///alert emil to admin
				} else {

					$res = json_decode($response, true);
					$bank_res = array(
						'lender_id' => $this->session->userdata('user_id'),
						'fav_id' => $res['id'] ? $res['id'] : '',
						'razorpay_response_bank_ac' => $response,
					);
					$this->db->insert('p2p_lender_bank_res', $bank_res);
					$bank_data = array(
						'lender_id' => $this->session->userdata('user_id'),
						'bank_name' => $res['fund_account']['bank_account']['bank_name'] ? $res['fund_account']['bank_account']['bank_name'] : '',
						'account_number' => $this->input->post('account_no'),
						'ifsc_code' => $this->input->post('ifsc_code'),
						'is_verified' => 0,
					);
					$result = $this->Lenderactionmodel->addaccount($bank_data);
					if ($result) {
						$msg = "Bank Account added successfully";
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
						redirect(base_url() . 'lenderprocess/lender-preferences');
					} else {
						$msg = "Incorrect information, please check your details";
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
						redirect(base_url() . 'lenderprocess/bank-account-details');
					}
				}
			} else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/request/add-nominee');
			}

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function acceptance_lender()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$result = $this->Lenderactionmodel->accept_bids();
			if ($result) {
				$msg = "You have successfully accepted the Bid";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url() . 'lender/successfullbids');
			} else {
				$msg = "You have already accepted the Bid";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'lender/successfullbids');
			}
		} else {
			redirect(base_url() . 'login/lender');
		}

	}

	public function getLoanaggrement()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['results'] = $this->Lenderactionmodel->loanaggrement();
			$data['table'] = "";
			$data['html'] = "";
			$data['portal_name'] = 'www.antworksp2p.com';
			$data['today'] = date("d-m-Y");
			$data['current_time_stamp'] = $date = date('d/m/Y H:i:s', time());
			if ($data['results']['0']['lender_signature'] == 1) {
				echo $this->load->view('loan-aggrement-copy', $data, true);
			} else if ($data['results']['0']['lender_signature'] == 0) {
				echo $this->load->view('loan-aggrement', $data, true);

			}
		} else {
			redirect(base_url() . 'login/lender');
		}

	}

	public function sendotpSignatuereaccept()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->database();
			if (!empty($_POST['bid_registration_id'])) {
				$this->load->model('smssetting');
				$setting = $this->smssetting->smssetting();
				$arr = array();
				$number = $this->session->userdata('mobile');
				$otp = rand(100000, 999999);

				$this->db->select('*');
				$this->db->from('p2p_lender_otp_signature');
				$this->db->where('mobile', $number);
				$this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
				$this->db->where('date_added >= now() - INTERVAL 1 DAY');
				$query = $this->db->get();
				//echo $this->db->last_query(); exit;
				if ($this->db->affected_rows() > 0) {
					$result = count($query->result_array());
					if ($result > 3) {
						echo 2;
						exit;
					} else {
						$arr["mobile"] = $number;
						$arr["bid_registration_id"] = $this->input->post('bid_registration_id');
						$arr["otp"] = $otp;
						$query = $this->db->insert('p2p_lender_otp_signature', $arr);
					}

				} else {
					$arr["mobile"] = $number;
					$arr["bid_registration_id"] = $this->input->post('bid_registration_id');
					$arr["otp"] = $otp;
					$query = $this->db->insert('p2p_lender_otp_signature', $arr);
				}


				$msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
				$message = rawurlencode($msg);

				// Prepare data for POST request
				$data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $number, "sender" => $setting['sender'], "message" => $message);

				// Send the POST request with cURL
				$ch = curl_init('https://api.textlocal.in/send/');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				// Create session for verifying number


				echo 1;
				exit;

			} else {
				echo "OOPS! You do not have Direct Access. Please Login";
				exit;
			}
		}
	}

	public function verify_signature()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if (!empty($_POST['bid_registration_id']) && !empty($_POST['otp'])) {
				$this->load->database();
				$number = $this->session->userdata('mobile');
				$otp = $_POST['otp'];
				$this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
				$this->db->from('p2p_lender_otp_signature');
				$this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
				$this->db->where('mobile', $number);
				$this->db->order_by('id', 'desc');
				$this->db->limit(1);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$result = $query->row();
					if ($otp == $result->otp) {
						if ($result->MINUTE <= 10) {
							$result = $this->Lenderactionmodel->accept_lender_signature();
							if ($result) {
								$msg = "You have successfully signed";
								$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
							} else {
								$msg = "You have already accepted this Bid";
								$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
							}
							$data['response'] = "verify";
							$this->db->where('otp', $otp);
							$this->db->where('mobile', $number);
							$this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
							$this->db->delete('p2p_lender_otp_signature');
						} else {
							$data['response'] = "Expired";
						}
					} else {
						$data['response'] = "Not";
					}

				} else {
					$data['response'] = "Not";
				}
				echo json_encode($data);
				exit;

			} else {
				echo "OOPS! You do not have Direct Access. Please Login";
				exit;
			}
		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function requestnamechange()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->model('lenderprocess/Lenderprocessmodel');
			$api_record = $this->Lenderprocessmodel->getpanApiresponse($api_name = 'pan');
			$record = json_decode($api_record['response'], true);
			$name = str_replace('  ', ' ', $record['result']['name']);
			if ($name == strtoupper(str_replace('  ', ' ', $this->input->post('name')))) {

				$dataSteps = array(
					'step_3' => 1,
					'modified_date' => date('Y-m-d H:i:s'),
				);
				$this->Lenderprocessmodel->updateSteps($dataSteps);

				$insert_request = array(
					'lender_id' => $this->session->userdata('user_id'),
					'type' => 'name',
					'request_data' => $this->input->post('name'),
					'status' => 1,
				);

				$this->Lenderprocessmodel->updateName();

				$this->Lenderprocessmodel->insertRequest($insert_request);

				redirect(base_url() . 'lenderprocess/kyc-updation');
			} else {

				$dataSteps = array(
					'step_3' => 3,
					'modified_date' => date('Y-m-d H:i:s'),
				);
				$this->Lenderprocessmodel->updateSteps($dataSteps);
				redirect(base_url() . 'lenderprocess/kyc-updation');

			}

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function updateProfilePic()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if (isset($_FILES['selfiImage'])) {

				$this->load->model('lenderaction/Lenderkycmodel');
				$config['upload_path'] = "./assets/lender-documents";
				$config['allowed_types'] = 'jpg|png|jpeg|pdf';
				$config['encrypt_name'] = TRUE;
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if (isset($_FILES['selfiImage'])) {
					if ($this->upload->do_upload("selfiImage")) {
						$data = $this->upload->data();
						$file_info = array(
							'lender_id' => $this->session->userdata('user_id'),
							'docs_type' => 'selfiImage',
							'docs_name' => $data['file_name'],
						);
						$this->Lenderkycmodel->insert_kyc_pan($file_info);
						$msg = 'Profile picture updated successfully.';
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
						redirect(base_url() . 'lender/profile');
					} else {
						$msg = $this->upload->display_errors();
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
						redirect(base_url() . 'lender/profile');

					}
				} else {
					$msg = "Please select a file to upload";
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
					redirect(base_url() . 'lender/profile');
				}

			} else {
				$msg = "Please select a file to upload";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'lender/profile');
			}
		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function changePassword()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if ($this->security->xss_clean($this->input->post('pwd'), TRUE) === FALSE) {
				redirect(base_url() . 'login');
			}
			if ($this->security->xss_clean($this->input->post('cpwd'), TRUE) === FALSE) {
				redirect(base_url() . 'login');
			}
			$this->form_validation->set_rules('old_pwd', 'Password', 'required');
			$this->form_validation->set_rules('pwd', 'Password', 'required');
			$this->form_validation->set_rules('cpwd', 'Confirm Password', 'required|matches[pwd]');
			if ($this->form_validation->run() == TRUE) {
				$result = $this->Lenderactionmodel->changePassword();
				if ($result === false) {
					redirect(base_url() . 'login/logout/');
				}
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $result));
				redirect(base_url() . 'lender/profile');
			} else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/profile');
			}
		} else {
			redirect(base_url() . 'login/lender');
		}

	}

	public function offlinePayment()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->form_validation->set_rules('transactionId', 'Transaction ID', 'required|is_unique[lender_offline_payment_details.transactionId]');
			$this->form_validation->set_rules('transaction_type', 'Transaction Type', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
			if ($this->form_validation->run() == TRUE) {
				$result = $this->Lenderactionmodel->offlinePayment();
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $result));
				redirect(base_url() . 'lender/pay-in');
			} else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/pay-in');
			}

		} else {
			redirect(base_url() . 'login/lender');
		}

	}

	public function requestchangeAddress()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->form_validation->set_rules('address1', 'Address', 'required');
			$this->form_validation->set_rules('state_code', 'state', 'required');
			$this->form_validation->set_rules('city', 'city', 'required');
			$this->form_validation->set_rules('pincode', 'pincode', 'required');
			if ($this->form_validation->run() == TRUE) {
				$this->db->select('id')->get_where('p2p_lender_requests', array('type' => 'address', 'status' => '0', 'lender_id' => $this->session->userdata('user_id')));
				if ($this->db->affected_rows() > 0) {
					$msg = "Your request is pending";
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
					redirect(base_url() . 'lender/change-address');
				} else {
					$address_request = array(
						'address1' => $this->input->post('address1'),
						'state_code' => $this->input->post('state_code'),
						'city' => $this->input->post('city'),
						'pincode' => $this->input->post('pincode'),
					);
					$save_arr = array(
						'lender_id' => $this->session->userdata('user_id'),
						'type' => 'address',
						'request_data' => json_encode($address_request),
					);
					$this->db->insert('p2p_lender_requests', $save_arr);

					$msg = 'Your request accepted';
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
					redirect(base_url() . 'lender/change-address');
				}

			} else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/change-address');
			}

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function addNominee()
	{
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('pan', 'PAN', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
		$this->form_validation->set_rules('address', 'address', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$nominee_details = array(
				'lender_id' => $this->session->userdata('user_id'),
				'full_name' => $this->input->post('full_name'),
				'dob' => $this->input->post('dob'),
				'mobile' => $this->input->post('mobile'),
				'pan' => $this->input->post('pan'),
				'address' => $this->input->post('address'),
			);
			$this->db->insert('p2p_lender_nominee', $nominee_details);
			if ($this->db->affected_rows() > 0) {
				$msg = "Nominee details added successfully";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url() . 'lender/request/add-nominee');
			} else {
				$msg = "OOPS! Something went wrong please check you credential and try again";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url() . 'lender/request/add-nominee');
			}
		} else {
			$errmsg = $this->form_validation->error_array();
			$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
			redirect(base_url() . 'lender/request/add-nominee');
		}
	}

	public function payout_lender()
	{
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$this->db->get_where('p2p_lender_requests', array('lender_id' => $this->session->userdata('user_id'), 'type' => 'pay_out', 'status' => 0));
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => 'Your request is pending'));
				redirect(base_url() . 'lender/pay-out');
			} else {
				$arr_pay_out = array(
					'lender_id' => $this->session->userdata('user_id'),
					'type' => 'pay_out',
					'request_data' => json_encode(array("amount" => $this->input->post('amount'), "payment_remarks" => $this->input->post('payment_remarks') ? $this->input->post('payment_remarks') : "")),
				);
				$this->db->insert('p2p_lender_requests', $arr_pay_out);
				if ($this->db->affected_rows() > 0) {
					//Lender Lock Amount
					$arr_lock_amount = array('lender_id' => $this->session->userdata('user_id'), 'request_id' => $this->db->insert_id(), 'lock_amount' => $this->input->post('amount'));
					$this->db->insert('p2p_lender_lock_amount', $arr_lock_amount);
					if ($this->db->affected_rows() > 0) {
						$msg = "We have initiated the transfer instruction. It generally takes about two banking days to get cleared/reflected in your bank account";
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
						redirect(base_url() . 'lender/pay-out');
					}
					else{
						$msg = "OOPS! Something went wrong please check you credential and try again";
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
						redirect(base_url() . 'lender/pay-out');
					}

				} else {

					$this->session->set_flashdata('notification', array('error' => 0, 'message' => "OOPS! Something went wrong please check you credential and try again"));
					redirect(base_url() . 'lender/request/tds-statement');
				}
			}
		} else {
			$errmsg = $this->form_validation->error_array();
			$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
			redirect(base_url() . 'lender/pay-out');
		}
	}

	public function savelenderPreference()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$pre_data = array(
				'product_preference' => implode(',', $this->input->post('product_preference')),
				'loan_amount_minimum' => $this->input->post('loan_amount_minimum') ? $this->input->post('loan_amount_minimum') : '',
				'loan_amount_maximum' => $this->input->post('loan_amount_maximum') ? $this->input->post('loan_amount_maximum') : '',
				'min_antworks_rating' => $this->input->post('min_antworks_rating') ? $this->input->post('min_antworks_rating') : '',
				'landing_club' => $this->input->post('landing_club') ? $this->input->post('landing_club') : '',
				'reinvest' => $this->input->post('reinvest') ? $this->input->post('reinvest') : '',
				'mobile_retailer' => $this->input->post('mobile_retailer') ? $this->input->post('mobile_retailer') : '',
				'selffinance' => $this->input->post('selffinance') ? $this->input->post('selffinance') : '',
				'annual_turnover' => $this->input->post('annual_turnover') ? $this->input->post('annual_turnover') : '',
				'year_in' => $this->input->post('year_in') ? $this->input->post('year_in') : '',
				'place_to' => $this->input->post('place_to') ? $this->input->post('place_to') : '',

			);
			$data = array(
				'lender_id' => $this->session->userdata('user_id'),
				'auto_investment ' => $this->input->post('auto_investment') ? $this->input->post('auto_investment') : '',
				'preferences' => json_encode($pre_data),
			);
			$this->db->insert('lender_loan_preferences', $data);
			if ($this->db->affected_rows() > 0) {
				$this->db->where('lender_id', $this->session->userdata('user_id'));
				$this->db->set('step_5', 1);
				$this->db->update('p2p_lender_steps');
				if ($this->db->affected_rows() > 0) {
					redirect(base_url() . 'lender/dashboard');
				} else {
					$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => "OOPS! Something went wrong please check you credential and try again"));
					redirect(base_url() . 'lenderprocess/lender-preferences');
				}
			} else {
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => "OOPS! Something went wrong please check you credential and try again"));
				redirect(base_url() . 'lenderprocess/lender-preferences');
			}
		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function updateLenderpreference()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$pre_data = array(
				'product_preference' => implode(',', $this->input->post('product_preference')),
				'loan_amount_minimum' => $this->input->post('loan_amount_minimum') ? $this->input->post('loan_amount_minimum') : '',
				'loan_amount_maximum' => $this->input->post('loan_amount_maximum') ? $this->input->post('loan_amount_maximum') : '',
				'min_antworks_rating' => $this->input->post('min_antworks_rating') ? $this->input->post('min_antworks_rating') : '',
				'landing_club' => $this->input->post('landing_club') ? $this->input->post('landing_club') : '',
				'reinvest' => $this->input->post('reinvest') ? $this->input->post('reinvest') : '',
				'mobile_retailer' => $this->input->post('mobile_retailer') ? $this->input->post('mobile_retailer') : '',
				'selffinance' => $this->input->post('selffinance') ? $this->input->post('selffinance') : '',
				'annual_turnover' => $this->input->post('annual_turnover') ? $this->input->post('annual_turnover') : '',
				'year_in' => $this->input->post('year_in') ? $this->input->post('year_in') : '',
				'place_to' => $this->input->post('place_to') ? $this->input->post('place_to') : '',

			);
			$data = array(
				'lender_id' => $this->session->userdata('user_id'),
//				'auto_investment ' => $this->input->post('auto_investment') ? $this->input->post('auto_investment') : '',
				'preferences' => json_encode($pre_data),
			);
			$this->db->get_where('lender_loan_preferences', array('lender_id' => $this->session->userdata('user_id')));
			if ($this->db->affected_rows() > 0) {
				$this->db->insert('lender_loan_preferences', $data);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('validation_errors', array('error' => 0, 'message' => "Your investment criteria is added successfully"));
					redirect(base_url() . 'lender/request/preferences');
				} else {
					$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => "OOPS! Something went wrong please check you credential and try again"));
					redirect(base_url() . 'lender/request/preferences');
				}
			} else {
				$this->db->where('lender_id', $this->session->userdata('user_id'));
				$this->db->update('lender_loan_preferences', $data);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('validation_errors', array('error' => 0, 'message' => "Your investment criteria is added successfully"));
					redirect(base_url() . 'lender/request/preferences');
				} else {
					$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => "OOPS! Something went wrong please check you credential and try again"));
					redirect(base_url() . 'lender/request/preferences');
				}
			}

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function loanRestructuring()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if (!empty($_POST['loan_id']) && !empty($_POST['action'])) {

				if ($this->input->post('action') === 'Approve') {
					$this->db->where('loan_id', $this->input->post('loan_id'));
					$this->db->set('status', 1);
					$this->db->update('p2p_loan_restructuring');
					if ($this->db->affected_rows() > 0) {
						$extension_time = $this->db->select('extension_time')->get_where('p2p_loan_restructuring', array('loan_id' => $this->input->post('loan_id')))->row()->extension_time;
						$emi_detail = $this->db->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $this->input->post('loan_id')))->row();
						$this->db->where('id', $emi_detail->id);
						$this->db->set('emi_date', date('Y-m-d', strtotime($emi_detail->emi_date . "+$extension_time months")));
						$this->db->update('p2p_borrower_emi_details');
						if ($this->db->affected_rows() > 0) {
							$response = array(
								'status' => 1,
								'message' => "Your request for Loan Restructuring is approved successfully",
							);
						} else {
							$response = array(
								'status' => 1,
								'message' => "Request of loan restructuring Approve successfully but emi date not update please drop a mail to Antworks P2P",
							);
						}

					} else {
						$response = array(
							'status' => 0,
							'message' => "Request for Loan Restructuring not Approved by Lender",
						);
					}
				}
				if ($this->input->post('action') === 'Reject') {
					$this->db->where('loan_id', $this->input->post('loan_id'));
					$this->db->set('status', 1);
					$this->db->update('p2p_loan_restructuring');
					if ($this->db->affected_rows() > 0) {
						$response = array(
							'status' => 1,
							'message' => "Your request for Loan Restructuring is rejected. Please follow the standard repayment policy",
						);
					} else {
						$response = array(
							'status' => 0,
							'message' => "Request of loan restructuring not Reject",
						);
					}
				}
			} else {
				$response = array(
					'status' => 0,
					'message' => "Your request for Loan Restructuring is not accepted by lender",
				);
			}
		} else {
			$response = array(
				'status' => 0,
				'message' => "Your session had expired. Please Re-Login",
			);
		}
		echo json_encode($response);
		exit;
	}

	public function requestautoinvest()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if ($this->input->post('auto_invest_val') == 0 || $this->input->post('auto_invest_val') == 1) {
				if ($this->input->post('auto_invest_val') == 1) {
					$this->db->get_where('lender_loan_preferences', array('lender_id' => $this->session->userdata('user_id')));
					if ($this->db->affected_rows() > 0) {
						$this->db->where('lender_id', $this->session->userdata('user_id'));
						$this->db->set('auto_investment', 1);
						$this->db->update('lender_loan_preferences');
						if ($this->db->affected_rows() > 0) {
							$response = array('status' => 1, "message" => "Thanks for choosing Auto Investment Option");
						} else {
							$response = array('status' => 1, "message" => "Thanks for choosing Auto Investment Option");
						}

					} else {
						$this->db->set('lender_id', $this->session->userdata('user_id'));
						$this->db->set('auto_investment', 1);
						$this->db->insert('lender_loan_preferences');
						if ($this->db->affected_rows() > 0) {
							$response = array('status' => 1, "message" => "Thanks for choosing Auto Investment Option");
						} else {
							$response = array('status' => 0, "message" => "Something went wrong");
						}
					}


				}
				if ($this->input->post('auto_invest_val') == 0) {
					$this->db->get_where('p2p_lender_requests', array('lender_id' => $this->session->userdata('user_id'), 'type' => 'auto_investment', 'status' => '0'));
					if ($this->db->affected_rows() > 0) {
						$response = array('status' => 0, "message" => "Your request is pending");
					} else {
						$this->db->insert('p2p_lender_requests', array('lender_id' => $this->session->userdata('user_id'), 'type' => 'auto_investment', 'request_data' => 'off',));
						if ($this->db->affected_rows() > 0) {
							$response = array('status' => 1, "message" => "Your request is accepted and pending for approval");
						} else {
							$response = array('status' => 0, "message" => "Something went wrong");
						}

					}
				}
			} else {
				$response = array('status' => 0, "message" => "Invalid Approach, Please check back");
			}
		} else {
			$response = array('status' => 0, "message" => "Your session had expired. Please Re-Login");
		}
		echo json_encode($response);
		exit;
	}

	public function saveLending()
	{
		$this->ant = $this->load->database('money', true);
		$campaign_record = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'mobile' => $this->input->post('mobile'),
			'address' => $this->input->post('address') ? $this->input->post('address') : '',
			'amount' => $this->input->post('amount') ? $this->input->post('amount') / 100 : '',
			'ip_address' => $this->input->ip_address(),
		);
		$this->db->insert("p2p_lending_campaign_record", $campaign_record);
		$this->ant->insert('p2p_lender_list', $campaign_record);
		$response = array(
			'status' => 1,
			'last_insert_id' => $this->db->insert_id(),
			'message' => "Added Successfully"
		);
		echo json_encode($response);
		exit;
	}

	//update after Payment lender campaign
	public function updateafterPayment()
	{
		header('Access-Control-Allow-Origin: *');

		header('Access-Control-Allow-Methods: GET, POST');

		header("Access-Control-Allow-Headers: X-Requested-With");
		$this->db->where('id', $this->input->post('last_insert_id'));
		$this->db->set('transaction_id', $this->input->post('razorpay_payment_id'));
		$this->db->update('p2p_lending_campaign_record');
		if ($this->db->affected_rows() > 0) {
			$response = array(
				'status' => 1,
				'message' => "Added Successfully",
			);
		} else {
			$response = array(
				'status' => 0,
				'message' => "something went wrong"
			);
		}
		echo json_encode($response);
		exit;
	}

	public function saveRequesttdsstatement()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->form_validation->set_rules('tds_statement_date', 'Date Range', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$this->db->get_where('p2p_lender_requests', array('lender_id' => $this->session->userdata('user_id'), 'type' => 'tds_statement', 'status' => 0));
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => 'Your request is pending'));
					redirect(base_url() . 'lender/request/tds-statement');
				} else {
					$arr_tds = array(
						'lender_id' => $this->session->userdata('user_id'),
						'type' => 'tds_statement',
						'request_data' => json_encode(array('tds_statement_date' => $this->input->post('tds_statement_date'))),
					);
					$this->db->insert('p2p_lender_requests', $arr_tds);
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => "Your TDS statement request is accepted successfully and shall be sent to your registered email within 2 working days."));
						redirect(base_url() . 'lender/request/tds-statement');
					} else {

						$this->session->set_flashdata('notification', array('error' => 0, 'message' => "OOPS! Something went wrong please check you credential and try again"));
						redirect(base_url() . 'lender/request/tds-statement');
					}
				}

			} else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/request/tds-statement');
			}

		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function createRazorpayfundingorder(){
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->model('Requestmodel');
			$result_keys = $this->Requestmodel->getRazorpayFundingkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];
			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){
				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
			}
			$api = new Api($api_key, $api_secret);
			$order = $api->order->create(array(
					'amount' => $this->input->post('amount'),
					'currency' => 'INR'
				)
			);
			if($order->id)
			{
              $order = json_encode(array('status' => 1, 'order_id' => $order->id));
			}
			else{
			  $order = json_encode(array('status' => 0, 'order_id' => ''));
			}
			echo $order; exit;
		}
	}
}

?>
