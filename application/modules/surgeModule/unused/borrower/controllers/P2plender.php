<?php
class P2plender extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2plendermodel');
        $this->load->model('P2padminmodel');
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}
        error_reporting(0);
    }

    public function lenders()
    {
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = base_url() . "p2padmin/lenders";
        $config["total_rows"] = $this->P2plendermodel->get_count_lenders();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["pagination"] = $this->pagination->create_links();
        $data['list'] = $this->P2plendermodel->getlenders($config["per_page"], $page);
        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('lender/lender-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function viewlender($user_id)
    {
        error_reporting(0);
        $data['lender'] = $this->P2plendermodel->getlender($user_id);

        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('lender/edit-lender',$data);
        $this->load->view('templates-admin/footer',$data);
    }

	public function downloadLoans()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Loan.csv";
		$result = $this->db->select('dld.id, bl.borrower_id, bl.name, ll.name as lender_name, bpd.loan_no, dld.approved_loan_amount, bpd.interest_rate, bpd.accepted_tenor')
			->join('p2p_borrowers_list bl', 'ON bl.id = dld.borrower_id', 'left')
			->join('p2p_lender_list ll', 'ON ll.user_id = dld.lender_id', 'left')
			->join('p2p_bidding_proposal_details bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
			->get_where('p2p_disburse_loan_details as dld', array('dld.id !=' => NULL));
		if ($this->db->affected_rows() > 0) {
			$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
			force_download($filename, $data);
		} else {
			return false;
		}
	}

	public function downloadLener()
	{
		$result = $this->db->get_where('p2p_lender_list');

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Lender.csv";
		if ($this->db->affected_rows() > 0) {
			$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
			force_download($filename, $data);
		} else {
			return false;
		}

	}

}
?>
