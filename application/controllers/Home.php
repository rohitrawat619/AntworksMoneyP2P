<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('Blogmodel');
    }

    public function index()
	{

		$data['list'] = $this->Blogmodel->get_blogs();
		//echo "<pre>";
		//print_r($data);exit;
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';

		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('peer2peer',$data);
		$this->load->view('templates/footer');
	}

	public function lender()
	{

		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('peer2peer-lender',$data);
		$this->load->view('templates/footer');
	}

	public function lender_lending_campaign()
	{
		$data['list'] = $this->Blogmodel->get_blogs();
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('frontend/lender/campaign-lender/peer2peer-lender-campaign',$data);
		$this->load->view('templates/footer');
	}

	public function lender_lending_campaign_inner()
	{
		$this->load->model('Requestmodel');
		$result = $this->Requestmodel->getRazorpayFundingkeys();
		$json_key = json_decode($result, true);
		if ($json_key['razorpay_Testkey']['status'] == 1) {
			//$data['razorpay_public_key'] = $json_key['razorpay_Testkey']['key'];
			$data['razorpay_public_key'] = $json_key['razorpay_razorpay_Livekey']['key'];
		} else {
			$data['razorpay_public_key'] = $json_key['razorpay_razorpay_Livekey']['key'];
		}
		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('frontend/lender/campaign-lender/peer2peer-lender-campaign-inner',$data);
		$this->load->view('templates/footer');
	}

	public function lender_lending_campaign_thank_you()
	{

		$data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
		$data['description']="Thanks";
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('frontend/lender/campaign-lender/thankyou',$data);
		$this->load->view('templates/footer');
	}


	
    
}
