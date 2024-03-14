<?php
class Masterkyc extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterkycmodel');
    }

    public function index()
    {
        //if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $data['lists'] = $this->Masterkycmodel->list();

            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('master-kyc/kyc-list', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
//        } else {
//            $msg = "Your session had expired. Please Re-Login";
//            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
//            redirect(base_url() . 'login/admin-login');
//        }
    }
}