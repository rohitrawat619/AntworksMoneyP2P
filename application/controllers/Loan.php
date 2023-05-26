<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
    }

    public function consumerLoan()
	{
		$this->load->model('Blogmodel');
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('loan/consumerloan',$data);
		$this->load->view('templates/footer');
	}

	public function personalLoan()
	{

		$this->load->model('Blogmodel');
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('loan/personalloan',$data);
		$this->load->view('templates/footer');
	}

	public function businessLoan()
	{
		$this->load->model('Blogmodel');
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('loan/business-loan',$data);
		$this->load->view('templates/footer');
	}

	public function lenderBusinessLoan()
	{
		$this->load->model('Blogmodel');
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('loan/lender/business-loan',$data);
		$this->load->view('templates/footer');
	}

	public function lenderConsumerLoan()
	{
		$this->load->model('Blogmodel');
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('loan/lender/consumer-loan',$data);
		$this->load->view('templates/footer');
	}


}
