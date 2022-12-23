<?php
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

class Lenderresponse extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lenderresponsemodel');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
	}

	public function payment_response()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if ($this->input->post('razorpay_payment_id') && $this->input->post('razorpay_order_id') && $this->input->post('razorpay_signature')) {
				$this->load->model('Requestmodel');
				$result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
				$keys = (json_decode($result_keys, true));
				if ($keys['razorpay_Testkey']['status'] == 1) {
					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
				}
				if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {
					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
				}
				$hasing_value = $this->input->post('razorpay_order_id') . "|" . $this->input->post('razorpay_payment_id');
				$generated_signature = hash_hmac('SHA256', $hasing_value, $api_secret);
				if ($generated_signature == $this->input->post('razorpay_signature')) {
					$result = $this->Lenderresponsemodel->insert_transaction_payment();
					if ($result) {
						echo 1;
					} else {
						echo 2;
					}
				} else {
					echo 3;
				}
			} else {
				echo 3;
			}
		}
		else{
			echo 4;
		}
		exit;
	}

	public function add_amount_in_escrow()
	{
		if ($this->session->userdata('login_state') == TRUE) {

			if ($this->input->post('razorpay_payment_id') && $this->input->post('razorpay_order_id') && $this->input->post('razorpay_signature')) {
				$this->load->model('Requestmodel');
				$result_keys = $this->Requestmodel->getRazorpayFundingkeys();
				$keys = (json_decode($result_keys, true));
				if ($keys['razorpay_Testkey']['status'] == 1) {
					$api_key = $keys['razorpay_Testkey']['key'];
					$api_secret = $keys['razorpay_Testkey']['secret_key'];
				}
				if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {
					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
				}
				$hasing_value = $this->input->post('razorpay_order_id') . "|" . $this->input->post('razorpay_payment_id');
				$generated_signature = hash_hmac('SHA256', $hasing_value, $api_secret);
				if ($generated_signature == $this->input->post('razorpay_signature')) {
					$api = new Api($api_key, $api_secret);
					$order = $api->order->fetch($this->input->post('razorpay_order_id'));
					$amount = $order->amount_paid / 100;
					$result = $this->Lenderresponsemodel->add_amount_in_escrow($amount);
					if ($result) {
						echo 1;
					} else {
						echo 2;
					}
				} else {
					echo 3;
				}

			} else {
				echo 3;
			}
		} else {
			echo 4;
		}
		exit;
	}

	public function requestChangemobile()
	{
		//
		if ($this->session->userdata('login_state') == TRUE) {
			$lenderId = $this->session->userdata('user_id');
			if ($lenderId) {
				$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('P2papi/P2psmsmodel');
					$this->load->model('Smssetting');
					$result = $this->P2psmsmodel->changemobilesendOtp($lenderId);
					if ($result === true) {
						$setting = $this->Smssetting->smssetting();
						$otp = rand(100000, 999999);
						$arr["lender_id"] = $lenderId;
						$arr["type"] = 'mobile';
						$arr['request_data'] = json_encode(array(
							'mobile' => $this->input->post('mobile'),
							'otp' => $otp,
						));
						$query = $this->db->insert('p2p_lender_requests', $arr);
						$msg = "Your One Time Password (OTP) for Antworks P2P Mobile Number Verification is $otp. DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
						$message = rawurlencode($msg);

						// Prepare data for POST request
						$data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $this->input->post('mobile'), "sender" => $setting['sender'], "message" => $message);
						$ch = curl_init('https://api.textlocal.in/send/');
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($ch);
						curl_close($ch);
						$res = json_decode($response, true);
						if ($res['status'] == 'success') {
							$response = array(
								'status' => 1,
								'msg' => 'OTP sent successfully'
							);
						} else {
							$response = array(
								'status' => 0,
								'msg' => 'Something went wrong!!'
							);

						}
					} else {
						$response = array(
							'status' => 0,
							'msg' => $result
						);
					}
				} else {
					$response = array(
						"status" => 0,
						"msg" => validation_errors(),
					);
				}
			}
			echo json_encode($response);
			exit;
		}
	}

	public function verifyChangemobile()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$lenderId = $this->session->userdata('user_id');
			if ($lenderId) {
				$this->load->model('P2papi/P2psmsmodel');
				$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
				$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$result = $this->P2psmsmodel->verifyChangemobile($lenderId);
					if ($result === true) {
						$response = array(
							'status' => 1,
							'msg' => 'Credit team is reviewing your profile'
						);
						echo json_encode($response);
						exit;
					}
					if ($result === 2) {
						$response = array(
							'status' => 0,
							'msg' => 'OTP Expired, Please Resend and try again'
						);
						echo json_encode($response);
						exit;
					}
					if ($result === 3) {
						$response = array(
							'status' => 0,
							'msg' => 'OTP Not Verified'
						);
						echo json_encode($response);
						exit;
					}
					if ($result === false) {
						$response = array(
							'status' => 0,
							'msg' => 'Invalid Approch'
						);
						echo json_encode($response);
						exit;
					}
				} else {
					$response = array(
						'status' => 0,
						'msg' => validation_errors(),
					);
				}
			}
			echo json_encode($response);
			exit;
		}
	}
}

?>
