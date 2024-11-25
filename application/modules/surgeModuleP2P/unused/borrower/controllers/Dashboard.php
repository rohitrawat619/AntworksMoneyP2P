<?php
class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
		
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){
			$data['pageTitle'] = "Borrower List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('templates-admin/header',$data);
			$this->load->view('templates-admin/nav',$data);
			$this->load->view('dashboard',$data);
			$this->load->view('templates-admin/footer',$data);
		}
		else{
			$msg="Please Login First";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}

    }
}
?>
