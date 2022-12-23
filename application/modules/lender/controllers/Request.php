<?php

class Request extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Lendermodelbackend', 'Requestmodel'));
	}

	public function escrow_account_statement()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->model('Lenderaccountmodel');
			$data['pageTitle'] = "Investment Account Statement";
			$data['ledger_balance'] = $this->Lenderaccountmodel->lenderInvestment();
			$data['remainningAmount'] = $this->Lenderaccountmodel->remainningAmount();
			// echo "<pre>";
			// print_r($data['ledger_balance']);exit;
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('ledger', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function search_Accountstatement()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('filter_by_date', 'Date Range', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$this->load->model('Lenderaccountmodel');
				$data['pageTitle'] = "Investment Account Statement";
				$data['ledger_balance'] = $this->Lenderaccountmodel->searchlenderInvestment();
				$data['remainningAmount'] = $this->Lenderaccountmodel->remainningAmount();
				// echo "<pre>";
				// print_r($data['ledger_balance']);exit;
				$this->load->view('templates-lender/header', $data);
				$this->load->view('templates-lender/nav', $data);
				$this->load->view('ledger', $data);
				$this->load->view('templates-lender/footer');
			}
			else {
				$errmsg = $this->form_validation->error_array();
				$this->session->set_flashdata('validation_errors', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'lender/request/escrow-account-statement');
			}

		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function change_address()
	{
		if ($this->session->userdata('login_state') == TRUE) {

			$data['states'] = $this->Requestmodel->get_state();
			$data['pageTitle'] = "Request Change Address";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/change_address', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function change_mobile_no()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['pageTitle'] = "Request Change Mobile No";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/change_mobile', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function tds_statement()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['pageTitle'] = "TDS Statement";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/tds_statement', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function add_nominee()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['pageTitle'] = "ADD Nominee";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/add_nominee', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function kyc_updation()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['pageTitle'] = "KYC Updation";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/kyc_updation', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function loanrestructuring()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['loan_list'] = $this->Lendermodelbackend->loanRestructuring();
			$data['pageTitle'] = "Loan Restructuring";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/loan-restructuring', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function preferences()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$this->load->model('bidding/Biddingmodel');
			$preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
			$data['auto_investment'] = $preferences['auto_investment'];
			$data['lender_preferences'] = json_decode($preferences['preferences'], true);
			$data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
			$data['lender_clubs'] = $this->Requestmodel->getLenderclub();
			$data['pageTitle'] = "Loan Preferences";
//			echo "<pre>";
//			print_r($data); exit;
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('request/Lender_preferences', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}

	}


}

?>
