<?php
class Appdetails extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Appdetailsmodel'); exit;
	}

	public function index()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'mis') {
			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = base_url() . "p2padmin/appdetails";
			$config["total_rows"] = $this->Appdetailsmodel->countTotaluser();
			$config["per_page"] = 100;
			$config["uri_segment"] = 3;
			$config['num_links'] = 10;
			$config['full_tag_open'] = "<div class='new-pagination'>";
			$config['full_tag_close'] = "</div>";

			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$data["pagination"] = $this->pagination->create_links();
			$data['list'] = $this->Appdetailsmodel->getusers($config["per_page"], $page);
			$data['pageTitle'] = "User List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('templates-admin/header', $data);
			$this->load->view('templates-admin/mis-nav', $data);
			$this->load->view('user-ant/user-list', $data);
			$this->load->view('templates-admin/footer', $data);
		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function view($user_id)
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'mis') {
			$data['list'] = $this->Appdetailsmodel->getDetails($user_id);

			$data['pageTitle'] = "Admin Dashboard";
			$this->load->view('templates-admin/header', $data);
			$this->load->view('templates-admin/mis-nav', $data);
			$this->load->view('user-ant/user-details', $data);
			$this->load->view('templates-admin/footer', $data);
		}
		else{
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function downloadBorrowerclassification()
	{
		$this->db2 = $this->load->database('money', true);

		$this->db->select("bl.borrower_id, bl.name, bl.email, bl.mobile, bl.gender, bl.dob, bl.marital_status, bl.pan, date(bl.created_date) as borrowerCreationdate,
		                   odt.name as occupation, 
		                   q.qualification,
		                   bad.r_address as address1,
		                   bad.r_address1 as address2,
		                   bad.r_city as r_city,
		                   bad.r_state as r_state,
		                   bad.r_pincode as r_pincode,
		                   bank.bank_name,
		                   bank.account_number,
		                   bank.ifsc_code  
		                  ")
			->join('p2p_borrowers_list bl', 'bl.id = dld.borrower_id', 'left')
			->join('p2p_occupation_details_table odt', 'odt.id = bl.id', 'left')
			->join('p2p_qualification q', 'q.id = bl.id', 'left')
			->join('p2p_qualification q', 'q.id = bl.id', 'left')
			->join('p2p_borrower_address_details bad', 'bad.borrower_id = dld.borrower_id', 'left')
			->join('p2p_borrower_bank_details bank', 'bank.borrower_id = dld.borrower_id', 'left')
			->group_by('borrower_id')
			->get_where('p2p_disburse_loan_details');

	}

}
?>
