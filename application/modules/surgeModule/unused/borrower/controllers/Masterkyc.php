<?php
class Masterkyc extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterkycmodel');
    }

    public function index()
    {
       
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = base_url() . "p2padmin/masterkyc/index";
        //$where = "";
        $config["total_rows"] = $this->Masterkycmodel->listCount();
        $config["per_page"] = 100;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;
        $config['full_tag_open'] = "<div class='new-pagination'>";
        $config['full_tag_close'] = "</div>";
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["pagination"] = $this->pagination->create_links();
       echo $page."---".$config["total_rows"];

        //if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $data['lists'] = $this->Masterkycmodel->list($config["per_page"], $page);

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