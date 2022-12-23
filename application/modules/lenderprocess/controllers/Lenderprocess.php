<?php
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

class Lenderprocess extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lenderprocessmodel');
		$this->load->model('Requestmodel');

	}

	public function index()
	{
		echo "OOPS! You do not have Direct Access. Please Login";
		exit;
	}

	////
	public function payment()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$current_step = $this->Lenderprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
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
					'amount' => 590*100,
					'currency' => 'INR'
				)
			);
			$data['current_step'] = $current_step;
			$data['order_id'] = $order->id;
			$data['api_key'] = $api_key;
			$data['steps'] = $this->Lenderprocessmodel->getLendersteps();
			$data['pageTitle'] = "Payment";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/process', $data);
			$this->load->view('payment', $data);
			$this->load->view('templates-lender/footer', $data);

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function uriSegmant()
	{
		return $this->uri->segment(1) . '/' . $this->uri->segment(2);
	}

	public function payment_unsuccessful()
	{

		if ($this->session->userdata('login_state') == TRUE) {
			$current_step = $this->Lenderprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Lenderprocessmodel->getLendersteps();
			$data['title'] = 'payment Successful';
			$this->load->view('templates-lender/header', $data);
			//$this->load->view('templates-borrower/nav',$data);

			$this->load->view('payment-unsuccessful', $data);
			$this->load->view('templates-lender/footer', $data);

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	//

	public function payment_successful()
	{

		if ($this->session->userdata('login_state') == TRUE) {
			$current_step = $this->Lenderprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Lenderprocessmodel->getLendersteps();
			$data['title'] = 'payment Successful';
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/process', $data);
			$this->load->view('payment-successful', $data);
			$this->load->view('templates-lender/footer', $data);

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	//

	public function kyc_updation()
	{

		if ($this->session->userdata('login_state') == TRUE) {

			$current_step = $this->Lenderprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Lenderprocessmodel->getLendersteps();
			$data['info'] = $this->Lenderprocessmodel->lender_info();

			$dataSteps = array(
				'step_3' => 1,
				'modified_date' => date('Y-m-d H:i:s'),
			);
			$this->Lenderprocessmodel->updateSteps($dataSteps);

			$data['pageTitle'] = "Kyc Updation";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/process', $data);

			$this->load->view('kyc-updation', $data);

			$this->load->view('templates-lender/footer', $data);

		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function bank_account_details()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$current_step = $this->Lenderprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}

			$data['steps'] = $this->Lenderprocessmodel->getLendersteps();

			$data['verified'] = $this->Lenderprocessmodel->getBankdetails();

			$data['title'] = 'payment Successful';
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/process', $data);
			$this->load->view('bank-account-details', $data);
			$this->load->view('templates-lender/footer', $data);


		} else {
			redirect(base_url() . 'login/lender');
		}
	}

	public function lender_preferences()
	{
		$current_step = $this->Lenderprocessmodel->steps();
		if ($current_step != $this->uriSegmant()) {
			redirect(base_url() . $current_step);
		}
		$data['steps'] = $this->Lenderprocessmodel->getLendersteps();
		$data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
		$data['lender_clubs'] = $this->Requestmodel->getLenderclub();
		$data['title'] = 'payment Successful';
		$this->load->view('templates-lender/header', $data);
		$this->load->view('templates-lender/process', $data);
		$this->load->view('preference_criteria', $data);
		$this->load->view('templates-lender/footer', $data);
	}

	public function checking_steps()
	{
		$current_step = $this->Lenderprocessmodel->steps();
		if ($this->session->userdata('all_steps_complete') == 1) {
			redirect(base_url() . 'lender/dashboard');
		}
		if ($current_step != $this->uriSegmant()) {
			redirect(base_url() . $current_step);
		}
	}
}

?>
