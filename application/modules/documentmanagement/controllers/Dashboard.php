<?php
class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
         {
    
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('document-management/header',$data);
            $this->load->view('document-management/nav',$data);
            $this->load->view('dashboard',$data);
            $this->load->view('document-management/footer',$data);
       
       }
}
?>