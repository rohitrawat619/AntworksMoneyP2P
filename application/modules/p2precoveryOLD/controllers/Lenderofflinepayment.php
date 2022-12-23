<?php

class Lenderofflinepayment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('p2padmin/P2plendermodel');

		$this->load->model('Entryledger');
	}

	public function index()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$this->load->model('P2precoverymodel');
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "lenderofflinepayment";
			$config["total_rows"] = $this->P2plendermodel->count_offline_payment();
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["pagination"] = $this->pagination->create_links();
			$data['offline_list'] = $this->P2plendermodel->getLenderofflinepayment($config["per_page"], $page);

			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('p2precovery/nav', $data);
			$this->load->view('lender/lender-offline-payment', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function acceptoffline()
	{
		$this->load->library('form_validation');
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$this->form_validation->set_rules('user_id', 'lender ID', 'trim|required');
			$this->form_validation->set_rules('offline_id', 'Offline Id', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				if ($this->input->post('user_id') && $this->input->post('offline_id')) {
					$msg = $this->P2plendermodel->acceptOffline();
				} else {
					$msg = array('status' => 0, 'message' => "Need all valid input parameters");
				}
			} else {
				$errmsg = validation_errors();
				$msg = array('status' => 0, 'message' => $errmsg);
			}

		}
		else {
			$msg = array('status' => 0, 'message' => "Please Login first you are logged out");
		}
		echo json_encode($msg);
		exit;
	}

	public function declineoffline()
	{
		$this->load->library('form_validation');
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role_id') == 3) {
			$this->form_validation->set_rules('offline_id', 'Offline Id', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				if ($this->input->post('offline_id')) {
                        $this->db->where('id', $this->input->post('offline_id'));
						$this->db->set('approved_or_not', 2);
						$this->db->update('lender_offline_payment_details');
						if ($this->db->affected_rows() > 0) {
							$msg = array('status' => 1, 'message' => "Disapproved successfully!!");
						}
						else{
							$msg = array('status' => 0, 'message' => "Something went wrong");
						}
				} else {
					$msg = array('status' => 0, 'message' => "Need all valid input parameters");
				}
			} else {
				$errmsg = validation_errors();
				$msg = array('status' => 0, 'message' => $errmsg);
			}
		} else {
			$msg = array('status' => 0, 'message' => "Please Login first you are logged out");
		}
		echo json_encode($msg);
		exit;
	}
	/////


}

?>
