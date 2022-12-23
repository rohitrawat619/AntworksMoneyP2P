<?php

class Bidding extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Biddingmodel', 'Smsmodule', 'Requestmodel'));
		$this->load->library('form_validation');
	}

	public function index()
	{
		echo "Not Access";
		exit;
	}

	public function live_bids()
	{
		if ($this->session->userdata('login_state') == TRUE) {
            $preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
            $data['auto_investment'] = $preferences['auto_investment'];
            $data['lender_preferences'] = json_decode($preferences['preferences'], true);
            $data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
            $data['lender_clubs'] = $this->Requestmodel->getLenderclub();

			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "bidding/live-bids";
			$where = "bidding_status = 1 OR bidding_status = 4";
			$config["total_rows"] = $this->Biddingmodel->get_count_proposal($where);
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['proposal_list'] = $this->Biddingmodel->proposal_list($config["per_page"], $page, $this->session->userdata('user_id'));
			$data['pageTitle'] = "Live Bids";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('proposal-list-live', $data);
			$this->load->view('templates-lender/footer');

		} else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function submitproposal()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$lender_preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
			if ($lender_preferences['auto_investment'] == 1) {
				$response = array('error' => 1, 'message' => "Sorry your auto investment mode is on");
				$this->session->set_flashdata('notification', $response);
				redirect(base_url() . 'bidding/live-bids/');
			}
			$this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required');
			$this->form_validation->set_rules('p2p_product_id', 'Product ID', 'trim|required');
			$this->form_validation->set_rules('loan_amount', 'Bid Loan Amount', 'trim|required|greater_than_equal_to[2500]|less_than_equal_to[50000]');
			if ($this->form_validation->run() == TRUE) {
				if ($this->input->post('p2p_product_id') == 2) {
					$this->form_validation->set_rules('loan_required', 'loan_required', 'required');
					$this->form_validation->set_rules('loan_amount', 'Bid Loan Amount', 'required|matches[loan_required]');
					if ($this->form_validation->run() == TRUE) {
						$response = $this->Biddingmodel->submit_proposal();
						$redirect_url = $response['redirect_url'];
						unset($response['redirect_url']);
						$this->session->set_flashdata('notification', $response);
						redirect($redirect_url);
					} else {
						$errmsg = validation_errors();
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
						redirect(base_url() . 'bidding/live-bids/');
					}
				} else {
					if ($this->input->post('loan_amount') >= 2500 && $this->input->post('loan_amount') <= 10000) {
						$response = $this->Biddingmodel->submit_proposal();
						$redirect_url = $response['redirect_url'];
						unset($response['redirect_url']);
						$this->session->set_flashdata('notification', $response);
						redirect($redirect_url);
					} else {
						$this->form_validation->set_rules('interest_rate', 'Interest Rate', 'trim|required');
						$this->form_validation->set_rules('accepted_tenor', 'Tenor', 'trim|required');
						if ($this->form_validation->run() == TRUE) {
							$response = $this->Biddingmodel->submit_proposal();
							$redirect_url = $response['redirect_url'];
							unset($response['redirect_url']);
							$this->session->set_flashdata('notification', $response);
							redirect($redirect_url);
						} else {
							$errmsg = validation_errors();
							$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
							redirect(base_url() . 'bidding/live-bids/');
						}

					}
				}
			} else {
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
				redirect(base_url() . 'bidding/live-bids/');
			}
		} else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}

	public function checkalreadyBid()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$result = $this->Biddingmodel->checkAlreadybid();
			if ($result === true) {
				// Bid Already done
				echo 1;
			} else {
				//Bid not done
				echo 2;
			}
			exit;
		}
		else{
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}

	}

	public function borrower_profile_details($borrower_id)
	{
		if ($this->session->userdata('login_state') == TRUE) {
			$data['borrower_info'] = $this->Biddingmodel->borrower_info_details($borrower_id);

			if ($data['borrower_info']) {

				$data['kycDoctype'] = $this->Biddingmodel->kycDoctype($data['borrower_info']['id']);


				$data['currentopen_proposal'] = $this->Biddingmodel->get_currentopen_proposal($data['borrower_info']['id']);
//                echo "<pre>";
//                print_r($data['currentopen_proposal']); exit;
				$this->load->model('P2PCreditenginemodel');
				$data['rating'] = $this->P2PCreditenginemodel->Engine($borrower_id);

				$data['pageTitle'] = "Borrower Profile Details";
				$this->load->view('templates-lender/header', $data);
				$this->load->view('templates-lender/nav', $data);
				$this->load->view('borrower-profile-details', $data);
				$this->load->view('templates-lender/footer');
			} else {
				redirect();
			}


		} else {
			redirect(base_url() . 'login/borrower');
		}

	}

	public function searchbyLender()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if (isset($_GET['name_borrower_id']) && !empty($_GET['name_borrower_id'])) {
				$where = "BL.name LIKE '%" . $this->input->get('name_borrower_id') . "%' OR BL.borrower_id = '" . $this->input->get('name_borrower_id') . "'";
			} else {
				$where = "1 != 1";
			}
            $preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
            $data['auto_investment'] = $preferences['auto_investment'];
            $data['lender_preferences'] = json_decode($preferences['preferences'], true);
            $data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
            $data['lender_clubs'] = $this->Requestmodel->getLenderclub();

			$data['proposal_list'] = $this->Biddingmodel->searchbyLender($where);
			$data['pageTitle'] = "Live Bids";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('proposal-list-live', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}

	}

	public function advancesearch()
	{

		if ($this->session->userdata('login_state') == TRUE) {
            $preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
            $data['auto_investment'] = $preferences['auto_investment'];
            $data['lender_preferences'] = json_decode($preferences['preferences'], true);
            $data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
            $data['lender_clubs'] = $this->Requestmodel->getLenderclub();

			$data['proposal_list'] = $this->Biddingmodel->searchbyLender();
			$data['pageTitle'] = "Live Bids";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('proposal-list-live', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}

	}

	public function proposalFavourite()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if ($this->input->post('proposalId')) {
				$response = array();
				$this->db->select('id')->get_where('p2p_proposal_shortlist_details', array('proposal_id' => $this->input->post('proposalId'), 'lender_id' => $this->session->userdata('user_id')));
				if ($this->db->affected_rows() > 0) {
					$response = array(
						'status' => 0,
						'msg' => 'Sorry! This proposal is already in your favorite',
					);
				} else {
					$this->db->set('lender_id', $this->session->userdata('user_id'));
					$this->db->set('proposal_id', $this->input->post('proposalId'));
					$this->db->insert('p2p_proposal_shortlist_details');
					if ($this->db->affected_rows() > 0) {
						$response = array(
							'status' => 1,
							'msg' => 'Proposal successfully added in favorite',
						);
					} else {
						$response = array(
							'status' => 0,
							'msg' => 'Something went wrong',
						);
					}
				}
				echo json_encode($response, true);
				exit;
			}
		}
		else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
		$this->load->database();

	}

	public function favouriteBids()
	{
		if ($this->session->userdata('login_state') == TRUE) {
            $preferences = $this->Biddingmodel->preferences($this->session->userdata('user_id'));
            $data['auto_investment'] = $preferences['auto_investment'];
            $data['lender_preferences'] = json_decode($preferences['preferences'], true);
            $data['p2p_loan_type'] = $this->Requestmodel->getLoantypeweb();
            $data['lender_clubs'] = $this->Requestmodel->getLenderclub();
			$data['proposal_list'] = $this->Biddingmodel->proposallistFavorite();
			$data['pageTitle'] = "Live Bids";
			$this->load->view('templates-lender/header', $data);
			$this->load->view('templates-lender/nav', $data);
			$this->load->view('proposal-list-live', $data);
			$this->load->view('templates-lender/footer');
		} else {
			$msg = "Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/lender');
		}
	}
}

?>
