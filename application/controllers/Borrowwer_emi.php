<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowwer_emi extends CI_Controller {
	private $perPage = 20;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('credit_line_emi_model');
	}

	public function getBorrowerId(){
		return $_SESSION['borrower_id'];
	}
	public function setBorrowerId($borrower_id){
		$_SESSION['borrower_id'] = $borrower_id;
	}
	public function getLoanId(){
		return $_SESSION['loan_id'];
	}
	public function setLoanId($loan_id){
		$_SESSION['loan_id'] = $loan_id;
	}


	public function index()
	{
		$borrower_id=14;
		$_SESSION['borrower_id']=$borrower_id;
		    // $data['proposal_list'] = $this->Biddingmodel->proposal_list($limit = 50, $start = 0, $lender_id = 41);
			$data['title'] = "Borrower List";
			$data['description'] = "Borrower List";
			$data['keywords'] = "Borrower List";

			$this->load->view('credit_line_templates/header',$data);
			$this->load->view('credit_line_templates/nav');
			$this->load->view('loan_proposal',$data);
			$this->load->view('credit_line_templates/footer',$data);
			// $this->load->view('loan_proposal', $data);
            // $this->load->view('templates/footer');

	}

    public function proposal_submit(){
		$requestData = $this->input->post();
        $response=$this->credit_line_emi_model->add_loan_proposal($requestData);
  		echo json_encode($response); die();
    }



	public function loan_agreement(){
		$this->setBorrowerId(3103);
		$this->setLoanId(196);
		
		$response=$this->credit_line_emi_model->view_loan_agreement();
		$data['loan_agreement']=$response['msg'];


		$this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('emi_product/emi_sign',$data);
  $this->load->view('credit_line_templates/footer',$data);
		// echo "<pre>";print_r($response);die();
		// $this->load->view('templates/header',$data);
		// 	$this->load->view('templates/nav');
		// 	$this->load->view('templates/collapse-nav');
			// $this->load->view('loan_agreement', $data);
            // $this->load->view('templates/footer');

	}

	public function e_sign_send_otp_ajax(){

		$response=$this->credit_line_emi_model->credit_line_sendOtpsignature($this->getBorrowerId(),$this->getLoanId());
	  
		echo json_encode($response);die();
	  }
	  
	  
	  public function e_sign_verify_otp_ajax(){
	  
		$otp=$this->input->post('otp');
		$response=$this->credit_line_emi_model->credit_line_verifyOtpsignature($this->getBorrowerId(),$this->getLoanId(),$otp);
	  
		echo json_encode($response);die();
	  }


	  public function otp(){

		$data=array();
		$this->load->view('credit_line_templates/header',$data);
		$this->load->view('credit_line_templates/nav');
		$this->load->view('credit_line/otp',$data);
		$this->load->view('credit_line_templates/footer',$data);
	  
	  }
	  
	  public function e_sign_success(){
		
		$data=array();
		$this->load->view('credit_line_templates/header',$data);
		$this->load->view('credit_line_templates/nav');
		$this->load->view('credit_line/e_sign_success');
		$this->load->view('credit_line_templates/footer',$data);
	  }
	  
	  public function dashboard(){
	  
		$data=array();
		
		$loan_details=$this->credit_line_emi_model->loan_details($_SESSION['borrower_id']);
		// echo "<pre>";print_r($loan_details);die();
	  
		
		$data['loan_details']=$loan_details;
		$this->load->view('credit_line_templates/header',$data);
		$this->load->view('credit_line_templates/nav');
		$this->load->view('credit_line/dashboard',$data);
		$this->load->view('credit_line_templates/footer',$data);
	  }
	  
	  public function disburse(){
		// $_SESSION['borrower_id'];
		// $_SESSION['loan_id']=192;
	  
		$disburse=$this->credit_line_emi_model->disbursement_request($_SESSION['borrower_id'],$_SESSION['loan_id']);
		// $response=array('borrower_id'=>$_SESSION['borrower_id'],'loan_id'=>$_SESSION['loan_id']);
		echo json_encode($disburse);die();
	  
	  
		
	  }
	  

	

	
}
