<?php
class P2papplication extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2papplicationmodel');
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}
        error_reporting(0);
    }

    public function activeapplication()
    {
        $data['list'] = $this->P2papplicationmodel->get_active_application();

        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/loan-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function approval_pending_application()
    {
        $data['list'] = $this->P2papplicationmodel->approval_pending_application();
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/loan-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function partially_approve_application()
    {
        $data['list'] = $this->P2papplicationmodel->partially_approve_application();

        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/loan-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function approved_application()
    {
        $data['list'] = $this->P2papplicationmodel->approved_application();
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/approved_application',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function rejected_application()
    {
        $data['list'] = $this->P2papplicationmodel->rejected_application();
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/loan-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function viewapplication($loan_no)
    {

        $data['list'] = $this->P2papplicationmodel->get_application_details($loan_no);
        $data['pageTitle'] = "Application Details";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('application-listing/application-detail-to-escrow',$data);
        $this->load->view('templates-admin/footer',$data);
    }

}
?>
