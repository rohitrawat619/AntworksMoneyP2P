<?php

class Superlender extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('bidding/Biddingmodel', 'p2padmin/P2plendermodel', 'Smsmodule', 'Requestmodel'));
		$this->load->library('form_validation');
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'superlender') {

		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function dashboard()
	{
		$data['lender_list'] = $this->Biddingmodel->getAutoinvestlender();
		$data['pageTitle'] = "Super Lender";
		$this->load->view('templates-superlender/header', $data);
		$this->load->view('templates-superlender/nav', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('templates-superlender/footer');
	}

	public function selectLender()
	{
		$data['lender_list'] = $this->Biddingmodel->getAutoinvestlender();
		$data['pageTitle'] = "Super Lender";
		$this->load->view('templates-superlender/header', $data);
		$this->load->view('templates-superlender/nav', $data);
		$this->load->view('bidding/select-lender', $data);
		$this->load->view('templates-superlender/footer');
	}

	public function lender()
	{
		$lenderId = $this->uri->segment(3) ? $this->uri->segment(3) : '';
		$lender_details = $this->P2plendermodel->getLenderinfo($lenderId);
		if ($lender_details) {
			$lender_preferences = $this->Biddingmodel->preferences($lender_details['user_id']);
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "superlender/lender/$lenderId";
			$config["total_rows"] = $this->Biddingmodel->get_count_proposal_preferences($lender_details['user_id']);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 50;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['proposal_list'] = $this->Biddingmodel->proposal_list($config["per_page"], $page, $lender_details['user_id']);
			$data['lender_details'] = $lender_details;
			$data['lender_preferences'] = json_decode($lender_preferences['preferences'], true);
			$data['lender_list'] = $this->Biddingmodel->getAutoinvestlender();
			$data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
			$data['pageTitle'] = "Lender Bid LIST";
			$this->load->view('templates-superlender/header', $data);
			$this->load->view('templates-superlender/nav', $data);
			$this->load->view('bidding/proposal-list-live', $data);
			$this->load->view('bidding/bid-list-js', $data);
			$this->load->view('templates-superlender/footer');
		} else {
			echo "OOPS! You do not have Direct Access. Please Login";
		}
	}

	public function submitproposal()
	{

		$this->form_validation->set_rules('lender_id', 'Lender ID', 'trim|required');
		$this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required');
		$this->form_validation->set_rules('p2p_product_id', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('loan_amount', 'Bid Loan Amount', 'trim|required|greater_than_equal_to[1500]|less_than_equal_to[50000]');
		if ($this->form_validation->run() == TRUE) {
			if ($this->input->post('p2p_product_id') == 2) {
				$this->form_validation->set_rules('loan_required', 'loan_required', 'required');
				$this->form_validation->set_rules('loan_amount', 'Bid Loan Amount', 'required|matches[loan_required]');
				if ($this->form_validation->run() == TRUE) {
					$response = $this->P2plendermodel->submit_proposal();
				} else {
					$response = array('error' => 1, 'message' => validation_errors());
				}
			} else {
				if ($this->input->post('loan_amount') >= 1500 && $this->input->post('loan_amount') <= 10000) {
					$response = $this->P2plendermodel->submit_proposal();
				} else {
					$this->form_validation->set_rules('interest_rate', 'Interest Rate', 'trim|required');
					$this->form_validation->set_rules('accepted_tenor', 'Tenor', 'trim|required');
					if ($this->form_validation->run() == TRUE) {
						$response = $this->P2plendermodel->submit_proposal();
					} else {
						$response = array('error' => 1, 'message' => validation_errors());
					}

				}
			}
		} else {
			$response = array('error' => 1, 'message' => validation_errors());
		}
		echo json_encode($response);
		exit;
	}

	public function offautoinvest()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'superlender') {
			$data['list'] = $this->P2plendermodel->getautoinvestRequest();
			$data['pageTitle'] = "Request for off auto investment";
			$this->load->view('templates-superlender/header', $data);
			$this->load->view('templates-superlender/nav', $data);
			$this->load->view('request/request-off-auto-investment', $data);
			$this->load->view('templates-superlender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function actionRequestautoinvest()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'superlender') {
			if ($this->input->post('request_id') && $this->input->post('lender_id') && $this->input->post('action')) {
				$this->db->get_where('p2p_lender_requests', array('id' => $this->input->post('request_id'), 'status' => 0));
				if($this->db->affected_rows()>0)
				{
					if ($this->input->post('action') == 'Accept') {
						$this->db->where('id', $this->input->post('request_id'));
						$this->db->set('status', 1);
						$this->db->update('p2p_lender_requests');
						if ($this->db->affected_rows() > 0) {
							$this->db->where('lender_id', $this->input->post('lender_id'));
							$this->db->set('auto_investment', 0);
							$this->db->update('lender_loan_preferences');
							if ($this->db->affected_rows() > 0) {
								$response = array('status' => 1, 'message' => 'Request approved successfully');
							} else {
								$response = array('status' => 0, 'message' => 'Something went wrong');
							}
						} else {
							$response = array('status' => 0, 'message' => 'Something went wrong');
						}
					}
					if ($this->input->post('action') == 'Reject') {
						$this->db->where('id', $this->input->post('request_id'));
						$this->db->set('status', 2);
						$this->db->update('p2p_lender_requests');
						if ($this->db->affected_rows() > 0) {
							$response = array('status' => 1, 'message' => 'Request reject successfully');
						} else {
							$response = array('status' => 0, 'message' => 'Something went wrong');
						}
					}
				}
				else{
					$response = array('status' => 0, 'message' => 'Invalid Approach, Please check back');
				}

			} else {
				$response = array('status' => 0, 'message' => 'Invalid Approach, Please check back');
			}
		} else {
			$response = array('status' => 0, 'message' => 'Invalid Approach, Please check back');
		}
		echo json_encode($response); exit;
	}

	public function loanrestructuring()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'superlender') {
			$data['loan_list'] = $this->P2plendermodel->loanRestructuring();
			$data['pageTitle'] = "Request for off loan restructuring";
			$this->load->view('templates-superlender/header', $data);
			$this->load->view('templates-superlender/nav', $data);
			$this->load->view('request/request-loan-restructuring', $data);
			$this->load->view('templates-superlender/footer');
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function actionLoanrestructuring()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'superlender') {
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
					$this->db->set('status', 2);
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
		echo json_encode($response); exit;
	}

	public function searchBysuperlender()
	{
		$lenderId = $this->uri->segment(3) ? $this->uri->segment(3) : '';
		$lender_details = $this->P2plendermodel->getLenderinfo($lenderId);
		if ($lender_details) {
			$lender_preferences = $this->Biddingmodel->preferences($lender_details['user_id']);
			$data['proposal_list'] = $this->Biddingmodel->searchbyLender();
			$data['lender_details'] = $lender_details;
			$data['lender_preferences'] = json_decode($lender_preferences['preferences'], true);
			$data['lender_list'] = $this->Biddingmodel->getAutoinvestlender();
			$data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
			$data['pagination'] = "";
			$data['pageTitle'] = "Lender Bid LIST";
			$this->load->view('templates-superlender/header', $data);
			$this->load->view('templates-superlender/nav', $data);
			$this->load->view('bidding/proposal-list-live', $data);
			$this->load->view('bidding/bid-list-js', $data);
			$this->load->view('templates-superlender/footer');
		} else {
			echo "OOPS! You do not have Direct Access. Please Login";
		}
	}

	public function acceptBids()
	{
		$lenderId = $this->uri->segment(3) ? $this->uri->segment(3) : '';
		$data['lender_list'] = $this->Biddingmodel->getAutoinvestlender();
		$data['successfullbids'] = $this->P2plendermodel->successfullbids($lenderId?$lenderId:null);
		$data['lenderId'] = $lenderId;
		$data['pageTitle'] = "Request for accept pending Bids";
		$this->load->view('templates-superlender/header', $data);
		$this->load->view('templates-superlender/nav', $data);
		$this->load->view('bidding/bid-list-for-accept', $data);
		$this->load->view('bidding/bid-list-js', $data);
		$this->load->view('templates-superlender/footer');

	}

	public function actionAcceptbid()
	{
		$msg = $this->P2plendermodel->actionAcceptbid();
		$this->session->set_flashdata('notification', $msg);
		redirect(base_url() . 'superlender/acceptBids');

	}
}

?>
