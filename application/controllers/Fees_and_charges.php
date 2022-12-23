<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fees_and_charges extends CI_Controller{

    public function index()
    {
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/common-pages/pricing',$data);
        $this->load->view('templates/footer');
    }
}

?>