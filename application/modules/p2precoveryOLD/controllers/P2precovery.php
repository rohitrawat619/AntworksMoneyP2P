<?php

class P2precovery extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2precoverymodel');
		$this->load->model('p2padmin/Loanmanagementmodel');

		$this->load->model('Entryledger');
	}

	public function loanlist()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/loanlist";
			$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan();
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan($config["per_page"], $page);
			// echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('emi/loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function loandetails($loanno)
	{
		error_reporting(0);
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$data['loan'] = $this->Loanmanagementmodel->currentLoandetails($loanno);
			$data['loanno'] = $loanno;
			$data['pageTitle'] = "Loan Details- ".$loanno;
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-details', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function emidetail($emi_id)
	{
		$data['emi'] = $this->Loanmanagementmodel->emiDetail($emi_id);
		$emidetail = $this->load->view('emi-detail', $data, true);
		echo $emidetail;
		exit;
	}

	public function updateEmi()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('transaction_id', 'Transaction ID / Reference', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		$this->form_validation->set_rules('mode', 'Payment Mode', 'trim|required');
		$this->form_validation->set_rules('date', 'date', 'trim|required');
		$this->form_validation->set_rules('remarks', 'remarks', 'trim|required');
		$this->form_validation->set_rules('emi_id', 'EMI ID', 'trim|required');
		$this->form_validation->set_rules('loan_no', 'Loan No', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{

			$result = $this->P2precoverymodel->addEmipaymentdeatils();
			if($result){
				$msg="EMI payment added successfully please wait for approvement";
				$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
				redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
			}
			else{
				$errmsg = "Something went wrong please try again";
				$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
				redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
			}
		}
		else{
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
			redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
		}
	}

	public function pendigApproval()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			error_reporting(0);
			$data['pending_approval'] = $this->P2precoverymodel->getpendingApproval();
			$data['pageTitle'] = "Pending list for approval";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('emi/pending-list-approval', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function acceptpendingApprovel()
	{

		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			if ($this->input->post('emi_payment_due_id') && $this->input->post('emi_id')) {

				$loan_no = $this->db->select('bpd.loan_no')->join('p2p_bidding_proposal_details as bpd', 'ON bpd.bid_registration_id = bed.loan_id')->get_where('p2p_borrower_emi_details as bed', array('bed.id' => $this->input->post('emi_id')))->row()->loan_no;
				$emi_payment_details = $this->db->get_where('p2p_emi_payment_details', array('id' => $this->input->post('emi_payment_due_id')))->row();
				$emi_details = $this->db->select('bed.emi_amount, bed.lender_id, bed.disburse_loan_id')
					->get_where('p2p_borrower_emi_details as bed', array('id' => $this->input->post('emi_id')))->row();
				if ($emi_payment_details->emi_payment_amount == $emi_details->emi_amount) {
					//Update Emi Payment
					$this->db->where('id', $this->input->post('emi_payment_due_id'));
					$this->db->set('is_verified', 1);
					$this->db->update('p2p_emi_payment_details');

					$this->db->where('id', $this->input->post('emi_id'));
					$this->db->set('status', 1);
					$this->db->update('p2p_borrower_emi_details');

					$lender_account = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $emi_details->lender_id))->row();

					$this->db->where('lender_id', $emi_details->lender_id);
					$this->db->set('account_balance', $lender_account->account_balance + $emi_payment_details->emi_payment_amount);
					$this->db->update('p2p_lender_main_balance');
					//Entry Ledger of lender
					$ledger_array = array(
						'lender_id' => $emi_details->lender_id,
						'type' => 'repayment_received',
						'title' => 'Repayment Received',
						'reference_1' => $loan_no,
						'credit' => $emi_payment_details->emi_payment_amount,
						'balance' => $lender_account->account_balance + $emi_payment_details->emi_payment_amount,
					);
					$this->Entryledger->addlenderstatementEntry($ledger_array);
					//end

					$total_emi_principal_recieved = $this->db->select("SUM(emi_principal) AS emi_principal")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $emi_details->disburse_loan_id, 'status' => 1))->row()->emi_principal;
					$approved_loan_amount = $this->db->select("SUM(approved_loan_amount) AS approved_loan_amount")->get_where('p2p_disburse_loan_details', array('id' => $emi_details->disburse_loan_id))->row()->approved_loan_amount;
					if ($total_emi_principal_recieved == $approved_loan_amount) {
						$this->db->where('id', $emi_details->disburse_loan_id);
						$this->db->set('loan_status', 1);
						$this->db->update('p2p_disburse_loan_details');
					}
					echo json_encode(array("status" => 1, "msg" => "Update successfully"));
				} else {
					echo json_encode(array("status" => 2, "msg" => "Kindly cross check"));
				}
			} else {
				echo json_encode(array("status" => 2, "msg" => "Kindly cross check"));
			}
		} else {
			echo json_encode(array("status" => 2, "msg" => "Please Login First"));
		}

		exit;
	}

	public function search()
	{
		$data["pagination"] = "";
		$data['loan_list'] = $this->Loanmanagementmodel->searchbyLoan($this->input->post('loan_no'));
		$data['pageTitle'] = "Emi List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('p2precovery/header', $data);
		$this->load->view('p2precovery/header-below', $data);
		$this->load->view('p2precovery/nav', $data);
		$this->load->view('emi/loan-list', $data);
		$this->load->view('p2precovery/footer', $data);
	}

	//////

	public function emiduelist()
	{ exit;
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/emiduelist";
			$config["total_rows"] = $this->P2precoverymodel->get_count_emi();
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['week'] = $this->P2precoverymodel->getEmi_due($config["per_page"], $page);
			/// echo "<pre>";
			// print_r($data);exit;
			$data['pageTitle'] = "Emi Due List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('emi/emidue-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function sendsms()
	{ exit;
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$number = $_POST['mobile'];
			$loan_no = $_POST['loan_no'];
			$emi_date = $_POST['emi_date'];
			$emi_amount = $_POST['emi_amount'];
			$account_number = $_POST['account_number'];
			$ac = substr($account_number, -4);

			//$arr=array();
			$username = 'shantanu@antworksmoney.com';
			$hash_api = 'b3a4f30ed009f72aa58fcad1e58ddd49b8b7fd44f5a82bc2b93da9325174d68f';

			$sender = 'SECURE';

			$msg = "Hi! EMI Rs. " . $emi_amount . " for Loan No. " . $loan_no . " is due on " . $emi_date . " Keep A/c. XX " . $ac . " funded to avoid Charges. 
Thanks 
Antworks P2P";

			$message = rawurlencode($msg);

			$data = array('username' => $username, 'hash' => $hash_api, 'numbers' => $number, "sender" => $sender, "message" => $message);

			//print_r($data);exit;
			$ch = curl_init('https://api.textlocal.in/send/');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			// echo $response;exit;


			$result = json_decode($response, TRUE);

			// print_r($result);exit;
			if ($result['status'] == 'success') {
				$msg = "Sms send successfully.";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url() . 'p2precovery/emiduelist/');
			} else {

				$msg = "Something Wrong!";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'recovery/emiduelist/');
			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function sendemi($bid_registration_id)
	{ exit;
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$data['emi'] = $this->P2precoverymodel->get_due($bid_registration_id);
			// echo "<pre>";
			//  print_r($data);exit;
			$data['pageTitle'] = "Pay Emi";
			$data['title'] = "Pay Emi";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('emi/emi-send', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function insertEmi()
	{ exit;
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$emi_id = $_POST['emi_id'];
			$loan_id = $_POST['loan_id'];
			// print_r($_POST);exit;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('referece', 'Referece NO', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('bank', 'Bank', 'trim|required');
			$this->form_validation->set_rules('emi_date', 'Emi date', 'trim|required');
			$this->form_validation->set_rules('mode', 'Mode', 'trim|required');
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');


			if ($this->form_validation->run() == TRUE) {

				$kk = $this->P2precoverymodel->add_emi($emi_id, $loan_id);

				if ($kk) {
					$msg = "Emi Update successfully.";
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
					redirect(base_url() . 'p2precovery/sendemi/' . $this->input->post('loan_id'));
				} else {
					$msg = "Something Wrong!";
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
					redirect(base_url() . 'p2precovery/sendemi/' . $this->input->post('loan_id'));
				}
			} else {
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'p2precovery/sendemi/' . $this->input->post('loan_id'));

			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}


}

?>
