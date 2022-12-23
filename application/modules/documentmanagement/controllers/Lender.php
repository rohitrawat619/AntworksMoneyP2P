<?php
class Lender extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2plendermodel');
        $this->load->model('P2padminmodel');
        if( $this->session->userdata('admin_state') == TRUE ){

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
        $config["base_url"] = base_url() . "documentmanagement/p2plender//lenders";
        $config["total_rows"] = $this->P2plendermodel->get_count_lenders();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["pagination"] = $this->pagination->create_links();
        $data['list'] = $this->P2plendermodel->getlenders($config["per_page"], $page);
        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('document-management/header',$data);
        $this->load->view('document-management/nav',$data);
        $this->load->view('lender/lender-list',$data);
        $this->load->view('document-management/footer',$data);
    }

    public function viewlender($user_id)
    {
        error_reporting(0);
        $data['lender'] = $this->P2plendermodel->getlender($user_id);

        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('document-management/header',$data);
        $this->load->view('document-management/nav',$data);
        $this->load->view('lender/edit-lender',$data);
        $this->load->view('document-management/footer',$data);
    }

}
?>
