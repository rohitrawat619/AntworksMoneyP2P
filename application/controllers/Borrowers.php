<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowers extends CI_Controller {
	private $perPage = 20;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('bidding/Biddingmodel');
	}

	public function index()
	{
            $data['proposal_list'] = $this->Biddingmodel->proposal_list($limit = 50, $start = 0, $lender_id = 41);
			$data['title'] = "Borrower List";
			$data['description'] = "Borrower List";
			$data['keywords'] = "Borrower List";

            $this->load->view('templates/header',$data);
			$this->load->view('templates/nav');
			$this->load->view('templates/collapse-nav');
			$this->load->view('frontend/borrower/borrower-list', $data);
            $this->load->view('templates/footer');

	}
}
