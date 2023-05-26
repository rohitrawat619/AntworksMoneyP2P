<?php

class P2precovery extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2precoverymodel');
		$this->load->model('p2padmin/Loanmanagementmodel');
		$this->load->model('Requestmodel');
		$this->load->model('Entryledger');
	}

	public function dashboard()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$data['week'] = $this->P2precoverymodel->getLast_week();
			$data['twoweek'] = $this->P2precoverymodel->getLast_Twoweek();
			$data['list'] = $this->P2precoverymodel->getEmilist_due();
			$data['bounced'] = $this->P2precoverymodel->getEmi_bounced();
			//echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Dashboard";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('dashboard', $data);
			$this->load->view('p2precovery/footer', $data);
		}
		else{
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function loanlist()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
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
			$this->load->view('loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function loanlist_due_30()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$where = "(emi.emi_date >= CURDATE() - INTERVAL 30 DAY AND emi.emi_date < CURDATE() - INTERVAL 0 DAY)";
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/loanlist_due_30";
			$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan_due($where);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan_due($config["per_page"], $page, $where);
			// echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function loanlist_due_30_60()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$where = "(emi.emi_date >= CURDATE() - INTERVAL 60 DAY AND emi.emi_date < CURDATE() - INTERVAL 31 DAY)";
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/loanlist_due_30_60";
			$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan_due($where);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan_due($config["per_page"], $page, $where);
			// echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function loanlist_due_60_90()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$where = "(emi.emi_date >= CURDATE() - INTERVAL 90 DAY AND emi.emi_date < CURDATE() - INTERVAL 61 DAY)";
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/loanlist_due_60_90";
			$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan_due($where);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan_due($config["per_page"], $page, $where);
			// echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function loanlist_due_90()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$where = "emi.emi_date < CURDATE() - INTERVAL 91 DAY";
			$config = array();
			$config["base_url"] = base_url() . "p2precovery/loanlist_due_90";
			$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan_due($where);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan_due($config["per_page"], $page, $where);
			// echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-list', $data);
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
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$data['loan'] = $this->Loanmanagementmodel->currentLoandetails($loanno);
			$data['loanno'] = $loanno;
			$data['pageTitle'] = "Loan Details- " . $loanno;
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
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$data['emi'] = $this->Loanmanagementmodel->emiDetail($emi_id);
//		echo "<pre>";
//		print_r($data); exit;
			$emidetail = $this->load->view('emi-detail', $data, true);
			echo $emidetail;
			exit;
		}
	}

	public function updateEmi()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('transaction_id', 'Transaction ID / Reference', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('mode', 'Payment Mode', 'trim|required');
			$this->form_validation->set_rules('date', 'date', 'trim|required');
			$this->form_validation->set_rules('remarks', 'remarks', 'trim|required');
			$this->form_validation->set_rules('emi_id', 'EMI ID', 'trim|required|is_unique[p2p_emi_payment_details.emi_id]');
			$this->form_validation->set_rules('loan_no', 'Loan No', 'trim|required');
			if ($this->form_validation->run() == TRUE) {

				$result = $this->P2precoverymodel->addEmipaymentdeatils();
				if ($result) {
					$msg = "EMI payment added successfully please wait for approvement";
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
					redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
				} else {
					$errmsg = "Something went wrong please try again";
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
					redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
				}
			} else {
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function pendigApproval()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			error_reporting(0);
			$data['pending_approval'] = $this->P2precoverymodel->getpendingApproval();
			$data['pageTitle'] = "Pending list for approval";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('pending-list-approval', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function acceptpendingApprovel()
	{

		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			if ($this->input->post('emi_payment_due_id') && $this->input->post('emi_id')) {
				$this->db->get_where('p2p_borrower_emi_details', array('id' => $this->input->post('emi_id'), 'status' => 1));
				if ($this->db->affected_rows() > 0) {
					echo json_encode(array("status" => 2, "msg" => "Already approved kindly crosscheck"));
				} else {
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
				}
			} else {
				echo json_encode(array("status" => 2, "msg" => "Kindly cross check"));
			}
		} else {
			echo json_encode(array("status" => 2, "msg" => "Please Login First"));
		}

		exit;
	}

	public function rejectpendingApprovel()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
			if ($this->input->post('emi_payment_due_id')) {
				$this->db->get_where('p2p_emi_payment_details', array('id' => $this->input->post('emi_payment_due_id'), 'is_verified' => 0));
				if ($this->db->affected_rows() > 0) {
					$this->db->where('id', $this->input->post('emi_payment_due_id'));
					$this->db->set('is_verified', 2);
					$this->db->update('p2p_emi_payment_details');
					if ($this->db->affected_rows() > 0) {
						$json = json_encode(array("status" => 1, "msg" => "Disapprove successfully"));
					} else {
						$json = json_encode(array("status" => 2, "msg" => "Something went wrong please try again"));
					}
				} else {
					$json = json_encode(array("status" => 2, "msg" => "Kindly cross check"));
				}
			} else {
				$json = json_encode(array("status" => 2, "msg" => "Kindly cross check"));
			}
		} else {
			$json = json_encode(array("status" => 2, "msg" => "Please Login First"));
		}
		echo $json;
		exit;
	}

	public function search()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {
			$data["pagination"] = "";
			$data['loan_list'] = $this->Loanmanagementmodel->searchbyLoan($this->input->post('loan_no'));
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function requestLoanrestructuring()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {

			if (!empty($_POST['loan_id']) && !empty($_POST['extension_time'])) {

				$loan_restructuring = array('loan_id' => $this->input->post('loan_id'), 'extension_time' => $this->input->post('extension_time'));
				$this->db->insert('p2p_loan_restructuring', $loan_restructuring);
				if ($this->db->affected_rows() > 0) {
					$response = array(
						'status' => 1,
						'message' => "Your request of loan restructuring added successfully",
					);
				} else {
					$response = array(
						'status' => 0,
						'message' => "Your request of loan restructuring not added",
					);
				}
			} else {
				$response = array(
					'status' => 0,
					'message' => "Your request of loan restructuring not added",
				);
			}
		} else {
			$response = array(
				'status' => 0,
				'message' => "Please login first",
			);
		}
		echo json_encode($response);
		exit;
	}

	public function sendPaymentlink()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('purpose', 'Link Purpose', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			if ($this->input->post('purpose') == 'partially_payment') {
				$this->form_validation->set_rules('partially_amount', 'Partially Amount', 'trim|required');
			}
			if ($this->form_validation->run() == TRUE) {
				$loan_details = $this->Loanmanagementmodel->currentLoandetails($this->input->post('loan_no'));
				if ($this->input->post('purpose') == 'extend_loan') {
					$amount = 1000;
				}
				if ($this->input->post('purpose') == 'partially_payment') {
					$amount = $this->input->post('partially_amount');
				}
				if ($this->input->post('purpose') == 'emi_payment') {
					$emi_details = $this->Loanmanagementmodel->emiDetail($this->input->post('emi_id'));
					$amount = $emi_details['emi_amount'];
				}
				if ($this->input->post('purpose') == 'foreclosure') {
					$amount = $this->Loanmanagementmodel->getForeclosurepayment($this->input->post('loan_no'));
				}
				$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
				$keys = (json_decode($result_keys, true));
				if ($keys['razorpay_Testkey']['status'] == 1) {
					$api_key = $keys['razorpay_Testkey']['key'];
					$api_secret = $keys['razorpay_Testkey']['secret_key'];

				}
				if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

				}
				$arr_invoice = array("customer" => array("name" => $loan_details['b_name'], "contact" => $loan_details['b_mobile'], "email" => $loan_details['b_email']),
					"type" => "link",
					"amount" => $amount * 100,
					"currency" => "INR",
					'description' => $this->input->post('description') ? $this->input->post('description') : '',
					'receipt' => $this->input->post('loan_no') . '_' . strtotime(date('Y-m-d H:i:s')),
					"expire_by" => $this->input->post('') ? strtotime($this->input->post('')) : '',
					"reminder_enable" => false,
					"sms_notify" => 1,
					"email_notify" => 1,
					"callback_url" => base_url() . "repaymentwebhook/repayemi",
					"callback_method" => "get"
				);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://api.razorpay.com/v1/invoices",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_USERPWD => $api_key . ':' . $api_secret,
					CURLOPT_POSTFIELDS => json_encode($arr_invoice),
					CURLOPT_HTTPHEADER => array(
						"content-type: application/json",
					),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					echo "cURL Error #:" . $err;
				}
				$arr_response = (json_decode($response, true));
				if (@$arr_response['error']) {
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $arr_response['error']['description']));
					redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
				} else {
					$records = array(
						'purpose' => $this->input->post('purpose'),
						'loan_id' => $loan_details['disburse_loan_id'],
						'emi_id' => $this->input->post('emi_id'),
						'amount' => $amount,
						'invoice_id' => $arr_response['id'],
						'order_id' => $arr_response['order_id'],
						'razorpay_response' => $response
					);
					$this->db->insert('p2p_razorpay_emi_order_details', $records);
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => 'Link send successfully'));
						redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
					} else {
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => 'Something went wrong'));
						redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
					}
				}
			} else {
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification', array('validation_errors' => 1, 'message' => $errmsg));
				redirect(base_url() . 'p2precovery/loandetails/' . $this->input->post('loan_no'));
			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function downloadLoans()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {
			$query = $this->db->select('dld.id, bl.borrower_id, bl.pan, ad.r_pincode, bl.name, ll.name as lender_name, bpd.loan_no, dld.approved_loan_amount, bpd.interest_rate, bpd.accepted_tenor,bl.gender,bl.occuption_id,bl.marital_status,ad.r_state,ad.present_residence,bl.highest_qualification')
				->join('p2p_borrowers_list bl', 'ON bl.id = dld.borrower_id', 'left')
				->join('p2p_borrower_address_details ad', 'ON ad.borrower_id = dld.borrower_id', 'left')
				->join('p2p_lender_list ll', 'ON ll.user_id = dld.lender_id', 'left')
				->join('p2p_bidding_proposal_details bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
				->get_where('p2p_disburse_loan_details as dld', array('dld.id !=' => NULL));
			if ($this->db->affected_rows() > 0) {
				$results = $query->result_array();
				foreach ($results as $result) {
					$query = $this->db->select("COUNT(id) as total_emi_paid")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $result['id'], 'status' => 1));
					if ($this->db->affected_rows() > 0) {
						$total_emi_paid = $query->row()->total_emi_paid;
					} else {
						$total_emi_paid = 0;
					}
					$query = $this->db->select("COUNT(id) as total_emi_unpaid")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $result['id'], 'status' => 0));
					if ($this->db->affected_rows() > 0) {
						$total_emi_unpaid = $query->row()->total_emi_unpaid;
					} else {
						$total_emi_unpaid = 0;
					}
					$loan_details[] = array(
						'loan_no' => $result['loan_no'],
						'borrower_id' => $result['borrower_id'],
						'borrower_name' => $result['name'],
						'pan' => $result['pan'],
						'lender_name' => $result['lender_name'],
						'loan_amount' => $result['approved_loan_amount'],
						'interest_rate' => $result['interest_rate'],
						'tenor' => $result['accepted_tenor'],
						'total_emi_paid' => $total_emi_paid,
						'total_emi_unpaid' => $total_emi_unpaid,
						'gender' => $result['gender'],
						'r_pincode' => $result['r_pincode'],
						'r_state' => $result['r_state'],
						'occuption_id' => $result['occuption_id'],
						'marital_status' => $result['marital_status'],
						'present_residence' => $result['present_residence'],
						'highest_qualification' => $result['highest_qualification'],
					);


				}
				header("Content-type: application/csv");
				header("Content-Disposition: attachment; filename=Loan-file.csv");
				$fp = fopen('php://output', 'w');
				$i = 1;
				$head = array('loan_no',
					'borrower_id',
					'borrower_name',
					'pan',
					'lender_name',
					'loan_amount',
					'interest_rate',
					'tenor',
					'total_emi_paid',
					'total_emi_unpaid',
					'gender',
					'r_pincode',
					'r_state',
					'occuption_id',
					'marital_status',
					'present_residence',
					'highest_qualification',);
				foreach ($loan_details as $key => $loan) {
					if ($i == 1) {
						fputcsv($fp, $head);
					}
					fputcsv($fp, $loan);
					$i++;
				}
				fclose($fp);
				exit;
			} else {
				return false;
			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}
	/////
//	public function deleteLoan()
//	{
//		echo "This is in maintenance !!"; exit;
//		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "recovery") {
//			if($this->input->post('loanNumber') && $this->input->post('loanId')){
//				$flag = false;
//				$this->db->where('loan_no', $this->input->post('loanNumber'));
//				$this->db->delete('p2p_bidding_proposal_details');
//				if ($this->db->affected_rows() > 0) {
//					$flag = true;
//					$this->db->where('id', $this->input->post('loanId'));
//					$this->db->delete('p2p_disburse_loan_details');
//					if ($this->db->affected_rows() > 0) {
//						$flag = true;
//					} else {
//						$flag = false;
//					}
//					$this->db->where('disburse_loan_id', $this->input->post('loanId'));
//					$this->db->delete('p2p_borrower_emi_details');
//					if ($this->db->affected_rows() > 0) {
//						$flag = true;
//					} else {
//						$flag = false;
//					}
//
//					$this->db->where('loan_id', $this->input->post('loanId'));
//					$this->db->delete('p2p_emi_payment_details');
//					//
//
//					$query = $this->db->get_where('p2p_lender_statement_entry', array('reference_1' => $this->input->post('loanNumber')));
//					if ($this->db->affected_rows() > 0) {
//						$result = $query->row_array();
//
//						$this->db->where('lender_id', $result['lender_id']);
//						$this->db->where('reference_1', $this->input->post('loanNumber'));
//						$this->db->delete('p2p_lender_statement_entry');
//						if ($this->db->affected_rows() > 0) {
//							$flag = true;
//						} else {
//							$flag = false;
//						}
//						$this->db->where('id > ', $result['id']);
//						$this->db->where('lender_id', $result['lender_id']);
//						$this->db->set("balance", "balance + " . $result['debit'], false);
//						$this->db->update('p2p_lender_statement_entry');
//						if ($this->db->affected_rows() > 0) {
//							$flag = true;
//
//						} else {
//							$flag = false;
//						}
//					}
//
//
//				}
//				if ($flag == true) {
//					$this->db->where('lender_id', $result['lender_id']);
//					$this->db->set("account_balance", "account_balance + " . $result['debit'], false);
//					$this->db->update('p2p_lender_main_balance');
//				}
//				$response = array('msg' => "Deleted Successfully", 'status' => 1);
//			}
//			else{
//				$response = array('msg' => "Sorry wrong approch", 'status' => 0);
//			}
//
//
//
//		}
//		else {
//			$response = array('msg' => "Please login first", 'status' => 0);
//		}
//		echo json_encode($response); exit;
//	}
// Download borrower and lender
	/*public function downloadBorrower(){
		$data['pageTitle'] = "Borrower List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('p2precovery/header', $data);
		$this->load->view('p2precovery/header-below', $data);
		$this->load->view('p2precovery/nav', $data);
		$this->load->view('borrowerlist-download', $data);
		$this->load->view('p2precovery/footer', $data);
	}

	public function borrowerSearch(){
		exit;
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {
			$where = "";
			if ($this->input->post('start_date')) {
				$post_date = explode('+', $this->input->post('start_date'));
				$date = explode('-', $post_date[0]);
				$start_date = $date[0];
				$end_date = $date[1];
				// Date Format
				$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
				$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

				$where = "PBRP.created_date > '$start_date' AND PBRP.created_date < '$end_date'";
			}
			$this->db->select("
							PBRP.created_date AS borrower_payment_created_date,
							PBRP.razorpay_payment_id AS razorpay_payment_id,
						    BL.borrower_id AS B_Borrower_ID,
                           BL.name AS BorrowerName,
                           BL.email AS EMAIL,
                           BL.mobile AS MOBILE,
                           BL.gender AS GENDER,
                           BL.dob AS DATEOFBIRTH,
                           BL.marital_status,
                           BL.pan,
                           PQ.qualification AS QUALIFICATION_NAME,
                           ODT.name AS OccuptionName,
                           BR.experian_score AS EXPERIANSCORE,
                           BR.antworksp2p_rating AS Antworksp2pRating,
                           BANK.bank_name,                       
                           BANK.account_number,                       
                           BANK.ifsc_code,
                            addr.r_address AS address1,
                            addr.r_address1 AS address2,
                            addr.r_city AS city,
                            addr.r_pincode AS r_pincode,
                            SE.state AS state
                            ");

			$this->db->from('p2p_borrower_registration_payment AS PBRP');
			$this->db->join('p2p_borrowers_list AS BL', 'BL.id = PBRP.borrower_id', 'left');
			$this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
			$this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = BL.occuption_id', 'left');
			$this->db->join('ant_borrower_rating AS BR', 'ON BR.borrower_id = BL.id', 'left');
			$this->db->join('p2p_borrower_address_details addr', 'addr.borrower_id=BL.id', 'left');
			$this->db->join('p2p_state_experien SE', 'SE.code=addr.r_state', 'left');
			$this->db->join('p2p_borrower_bank_details AS BANK', 'ON BANK.borrower_id = BL.id', 'left');
			$this->db->where($where);
			// $this->db->where('DATE(BL.created_date) > ', date('Y-m-d', strtotime('- 1 month')));
			$this->db->order_by('PBRP.id', 'desc');
			$query = $this->db->get();
           // echo $this->db->last_query();exit;
			if ($this->db->affected_rows() > 0) {
				$this->load->dbutil();
				$this->load->helper('file');
				$this->load->helper('download');
				$delimiter = ",";
				$newline = "\r\n";
				$filename = "Borrowerpayment_details.csv";
				$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				//echo "No record found"; exit;
			}
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function downloadLender(){
		$data['pageTitle'] = "Lender List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('p2precovery/header', $data);
		$this->load->view('p2precovery/header-below', $data);
		$this->load->view('p2precovery/nav', $data);
		$this->load->view('lenderlist-download', $data);
		$this->load->view('p2precovery/footer', $data);
	}

	public function lenderSearch(){
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery') {
		$where = "";
		if ($this->input->post('start_date')) {
			$post_date = explode('+', $this->input->post('start_date'));
			$date = explode('-', $post_date[0]);
			$start_date = $date[0];
			$end_date = $date[1];
			// Date Format
			$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
			$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

			$where = "PLRP.created_date > '$start_date' AND PLRP.created_date < '$end_date'";
		}
		$this->db->select("
							PLRP.created_date AS lender_payment_created_date,
							PLRP.razorpay_payment_id AS razorpay_payment_id,
						    PL.lender_id AS L_Lender_ID,
                           PL.name AS LenderName,
                           PL.email AS EMAIL,
                           PL.mobile AS MOBILE,
                           PL.gender AS GENDER,
                           PL.dob AS DATEOFBIRTH,
                           PL.pan,
                           PQ.qualification AS QUALIFICATION_NAME,
                           ODT.name AS OccuptionName,
                           PLAI.bank_name,                       
                           PLAI.account_number,                       
                           PLAI.ifsc_code,
                            PLA.address1 AS address1,
                            PLA.address2 AS address2,
                            PLA.city AS city,
                            PLA.pincode AS pincode,
                            SE.state AS state
                           ");
		$this->db->from('p2p_lender_registration_payment AS PLRP');
		$this->db->join('p2p_lender_list AS PL','PL.user_id  = PLRP.lender_id','left');
		$this->db->join('p2p_qualification AS PQ', 'ON PQ.id = PL.qualification', 'left');
		$this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = PL.occupation', 'left');
		$this->db->join('p2p_lender_address AS PLA', 'ON PLA.lender_id = PL.user_id', 'left');
		$this->db->join('p2p_state_experien SE', 'SE.code=PLA.state', 'left');
		$this->db->join('p2p_lender_account_info PLAI', 'PLAI.lender_id=PL.user_id', 'left');
		$this->db->where($where);
		$this->db->order_by('PLRP.id', 'desc');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if ($this->db->affected_rows() > 0) {
			$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$delimiter = ",";
			$newline = "\r\n";
			$filename = "Lenderpayment_details.csv";
			$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
			force_download($filename, $data);
		} else {
			//echo "No record found"; exit;
		}
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}*/
	
	
	public function downloadLoansAll()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'recovery')
		 {
			$query = $this->db->select('dld.id, bl.borrower_id, bl.pan, bl.name,bl.email,bl.mobile,bl.dob,bpd.loan_no, dld.date_created AS disbursement_date, dld.approved_loan_amount,bl.gender,ad.r_state,ad.residence_type ,ad.r_pincode,ad.r_address,emi.created_date as close_date,emi.emi_balance')
				->join('p2p_borrowers_list bl', 'ON bl.id = dld.borrower_id', 'left')
				->join('p2p_borrower_address_details ad', 'ON ad.borrower_id = dld.borrower_id', 'left')
				->join('p2p_bidding_proposal_details bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
				->join('p2p_borrower_emi_details emi', 'ON emi.disburse_loan_id = dld.id', 'left')
				->group_by('dld.id')
				->get_where('p2p_disburse_loan_details as dld', array('dld.id !=' => NULL));
				
			if ($this->db->affected_rows() > 0) {
				$results = $query->result_array();
				foreach ($results as $result) {
				     $date=date_create($result['dob']);
                     $dob= "'".date_format($date,"dmY");
				     $date1=date_create($result['disbursement_date']);
                     $disbursement_date= "'".date_format($date1,"dmY");
					 $date2=date_create($result['close_date']);
                     $close_date= "'".date_format($date2,"dmY");
					$loan_details[] = array(
						'Consumer Name' => $result['name'],
						'Date of Birth' =>$dob,
						'Gender' => $result['gender'],
						'Income Tax ID Number' => $result['pan'],
						'Passport Number' => '',
						'Passport Issue Date' => '',
						'Passport Expiry Date' => '',
						'Voter ID Number' => '',
						'Driving License Number' => '',
						'Driving License Issue Date' => '',
						'Driving License Expiry Date' => '',
						'Ration Card Number' => '',
						'Universal ID Number' => '',
						'Additional ID #1' => '',
						'Additional ID #2' => '',
						'mobile' => $result['mobile'],
						'Telephone No.Residence' => '',
					    'Telephone No.Office' => '',
					    'Extension Office' => '',
				        'Telephone No.Other' => '',
				        'Extension Other' => '',
				        'Email ID 1' => $result['email'],
				        'Email ID 2' => '',
				        'Address 1' => $result['r_address'],
				        'State Code 1' => $result['r_state'],
				        'PIN Code 1' => $result['r_pincode'],
				        'Address Category 1' => $result['residence_type'],
				        'Residence Code 1' => '',
				        'Address 2' => '',
				        'State Code 2' => '',
				        'PIN Code 2' => '', 
				        'Address Category 2' => '',
				        'Residence Code 2' => '',
				        'Current/New Member Code' => '',
				        'Current/New Member Short Name' => '',
				        'Curr/New Account No' => $result['loan_no'],
				        'Account Type' => '',
				        'Ownership Indicator' => '',
				        'Date Opened/Disbursed' => $disbursement_date, 
						'Date of Last Payment' => $close_date, 
						'Date Closed' => $close_date,
						'Date Reported' => '',
						'High Credit/Sanctioned Amt' => $result['approved_loan_amount'],
						'Current Balance' => $result['emi_balance'],
						'Amt Overdue' => $result['emi_balance'],
						'No of Days Past Due' => '',
						'Old Mbr Code' => '',
						'Old Mbr Short Name' => '',
					    'Old Acc No' => '',
				        'Old Acc Type' => '',
				        'Old Ownership Indicator' => '',
				        'Suit Filed / Wilful Default' => '',
				        'Credit Facility Status' => '',
				        'Asset Classification' => '', 
						'Value of Collateral' => '',
						'Type of Collateral' => '',
						'Credit Limit' => '',
						'Cash Limit'=> '',
						'Rate of Interest' => '',
						'RepaymentTenure' => '',
						'EMI Amount' => '',
						'Written- off Amount (Total)' => '',
						'Written- off Principal Amount' => '',
						'Settlement Amt' => '',
						'Payment Frequency' => '',
						'Actual Payment Amt' => '',
						'Occupation Code' => '',
						'Income' => '',
						'Net/Gross Income Indicator' => '',
						'Monthly/Annual Income Indicator' => '',);

				}
				header("Content-type: application/csv");
				header("Content-Disposition: attachment; filename=Loan-file.csv");
				$fp = fopen('php://output', 'w');
				
				$i = 1;
				$head = array('Consumer Name',
					'Date of Birth',
					'Gender',
					'Income Tax ID Number',
					'Passport Number',
					'Passport Issue Date',
					'Passport Expiry Date',
					'Voter ID Number',
					'Driving License Number',
					'Driving License Issue Date',
					'Driving License Expiry Date',
					'Ration Card Number',
					'Universal ID Number',
					'Additional ID #1',
					'Additional ID #2',
					'Telephone No.Mobile',
					'Telephone No.Residence',
				    'Telephone No.Office',
				    'Extension Office',
			        'Telephone No.Other ',
			        'Extension Other',
			        'Email ID 1',
			        'Email ID 2',
			        'Address 1',
			        'State Code 1',
			        'PIN Code 1',
			        'Address Category 1',
			        'Residence Code 1',
			        'Address 2',
			        'State Code 2',
			        'PIN Code 2',
			        'Address Category 2',
			        'Residence Code 2',
			        'Current/New Member Code',
			        'Current/New Member Short Name',
			        'Curr/New Account No',
			        'Account Type',
			        'Ownership Indicator',
			        'Date Opened/Disbursed', 
					'Date of Last Payment',
					'Date Closed',
					'Date Reported',
					'High Credit/Sanctioned Amt',
					'Current  Balance',
					'Amt Overdue',
					'No of Days Past Due',
					'Old Mbr Code',
					'Old Mbr Short Name',
				    'Old Acc No',
			        'Old Acc Type',
			        'Old Ownership Indicator',
			        'Suit Filed / Wilful Default',
			        'Credit Facility Status',
			        'Asset Classification', 
					'Value of Collateral',
					'Type of Collateral',
					'Credit Limit',
					'Cash Limit',
					'Rate of Interest',
					'RepaymentTenure',
					'EMI Amount',
					'Written- off Amount (Total) ',
					'Written- off Principal Amount',
					'Settlement Amt',
					'Payment Frequency',
					'Actual Payment Amt',
					'Occupation Code',
					'Income',
					'Net/Gross Income Indicator',
					'Monthly/Annual Income Indicator',);


				foreach ($loan_details as $key => $loan) {
					if ($i == 1) {
						fputcsv($fp, $head);
					}
					fputcsv($fp, $loan);
					$i++;
				}
				fclose($fp);
				exit;
			} else {
				return false;
			}
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}


}


