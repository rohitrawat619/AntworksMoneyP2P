<?php

class Changepassword extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $data['pageTitle'] = "Change Password";
            $data['title'] = "Change Password";
            $this->load->view('templates-admin/header', $data);
            //$this->load->view('templates-admin/nav', $data);
            $this->load->view('change-password', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function action_change_password()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $this->form_validation->set_rules('old_password', 'old password', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('P2padminmodel');
                $response = $this->P2padminmodel->change_password();
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $response['msg']));
                redirect(base_url() . 'p2padmin/changepassword');
            } else {
                $errmsg = validation_errors();
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
                redirect(base_url() . 'p2padmin/changepassword');
            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }
}