<?php
class Loanmanagement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Loanmanagementmodel');
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function loanlist()
    {
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url() . "p2padmin/loanmanagement/loanlist";
		$config["total_rows"] = $this->Loanmanagementmodel->get_count_loan();
		$config["per_page"] = 50;
		$config["uri_segment"] = 3;
		$config['num_links'] = 10;
		$config['full_tag_open'] = "<div class='new-pagination'>";
		$config['full_tag_close'] = "</div>";

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
        $data['loan_list'] = $this->Loanmanagementmodel->getOngoingloan($config["per_page"], $page);
        $data['pageTitle'] = "Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('loan-management/loan-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

	public function createLoanledger($loan_disbursement_id)
	{

			$data['lenderLedger'] = $this->Loanmanagementmodel->createLoanledger($loan_disbursement_id);
			$ledger = $this->load->view('loan-management/loan_ledger', $data, true);
			echo $ledger;
			exit;
	}

	public function trialBalance()
	{
		$data['trial_balance'] = $this->Loanmanagementmodel->getTrailbalance($start_date = 0, $end_date = 0);
		$data['pageTitle'] = "Trail Balance";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('loan-management/trail-balance',$data);
		$this->load->view('templates-admin/footer',$data);
	}

	public function searchtrailBalance()
	{
//		echo "<pre>";
//		print_r($_POST);
		$dates = explode('-', $this->input->post('start_date'));
		$start_date = date('Y-m-d H:i:s', strtotime($dates[0]));
		$last_date  = date('Y-m-d', strtotime($dates[1]));
		$end_date =  $last_date.' 23:59:59';
		$data['trial_balance'] = $this->Loanmanagementmodel->getTrailbalance($start_date, $end_date);
		$data['pageTitle'] = "Trail Balance";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('loan-management/trail-balance',$data);
		$this->load->view('templates-admin/footer',$data);
	}

}
?>
