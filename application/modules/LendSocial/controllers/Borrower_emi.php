<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Borrower_emi extends CI_Controller{

    public function __construct()
    {
      
        parent::__construct();
        
       // $this->borrowerProductImagePath = "../../document/surge/img/borrower/buddy-credit-line.png";
        $this->imageBaseUrl = "../../document/surge/img/borrower"; 
		
		//$this->logo_path = "logo_path";
        $this->load->model('credit_line_model');
		$this->load->model('LendSocialmodel');
		//$this->mobile = 6395130787;
		
		$this->sessionVariableData = $this->session->userdata(); 
		$partnerInfo = $this->LendSocialmodel->getPartnersTheme($this->sessionVariableData['partner_id']);
		$this->sessionData = $this->LendSocialmodel->getUserDetail($this->sessionVariableData['mobile']);
		
		$this->mobile = $this->sessionData['mobile'];
		//$partnerInfo['logo_path'] =	str_replace('D:/public_html/antworksp2p.com','../..',$partnerInfo['logo_path'])."?q=".rand();
		$partnerInfo['logo_path'] =	"../..//document/surge/upload/vendor/1/lend-social-logo-300x77(1).png"."?q=".rand();
		$this->partnerInfo = $partnerInfo;
		
		$this->borrowerProductImagePath = str_replace('D:/public_html/antworksp2p.com','../../',$partnerInfo['borrower_logo_path'])."?q=".rand();	
			
		$this->borrowerProductName=$this->partnerInfo['borrower_product_name'];
	//	print_r($this->partnerInfo['borrower_product_name']);
		
		$this->checkSessionMobileNo();
        
    }

public function checkSessionMobileNo(){
						if($this->sessionData["mobile"]==""){
						 $this->session->set_flashdata('notification',array('error'=>0,'message'=>"Session Failed"));	
						 redirect(base_url('LendSocial/').'signIn');
								}
						}
    public function getBorrowerId(){
    		return $_SESSION['borrower_id'];
    }
    public function setBorrowerId($borrower_id){
    	$_SESSION['borrower_id'] = $borrower_id;
    }
	public function getPartnerId(){
    		return $_SESSION['partner_id'];
    }
    public function setPartnerId($partner_id){
    	$_SESSION['partner_id'] = $partner_id;
    }
    public function getLoanId(){
    		return $_SESSION['loan_id'];
    }
    public function setLoanId($loan_id){
    	$_SESSION['loan_id'] = $loan_id;
    }
	public function getLoanNo(){
    		return $_SESSION['loan_no'];
    }
    public function setLoanNo($loan_no){
    	$_SESSION['loan_no'] = $loan_no;
    }

public function info(){
    $data=array();
	//print_r($this->partnerInfo['partner_id']);
	//$this->setPartnerId($_SESSION['partnerInfo'][0]['VID']);
	$this->setPartnerId($this->partnerInfo['partner_id']);

    $get_user_details=$this->credit_line_model->get_borrower_details($this->mobile);
		//echo"<pre>";
		//print_r($_SESSION);die();
		//$dataVar = json_encode($get_user_details);
		// print_r(json_decode($dataVar,true));die();
		if($get_user_details['status']==0){
			 redirect(base_url('LendSocial/').'personalDetails');
		}
    $this->setBorrowerId($get_user_details['borrower_id']);
	$loan_details = $get_user_details['loan_details'];
	foreach($loan_details as $loan){
	$this->setLoanId($loan->id);
	$this->setLoanNo($loan->loan_no);
	}
	
    $get_video_kyc_status =$this->credit_line_model->get_video_kyc_status($this->getBorrowerId());
	
	if($get_video_kyc_status['step_8']!= 1){
		$skip_video_kyc_status = $this->credit_line_model->skip_video_kyc_status($this->getBorrowerId());
	}
    
    $data['borrowerProductInfo']['borrowerProductImagePath']=$this->borrowerProductImagePath ;
    $data['borrowerProductInfo']['borrowerProductName']=$this->borrowerProductName;
    $data['get_borrower_details']=$get_user_details;
	$data['logo_path'] = $this->partnerInfo['logo_path'];
	$data['imageBaseUrl'] = $this->imageBaseUrl;
    $this->load->view('template-LendSocial/header',$data);
//    $this->load->view('credit_line_templates/nav',$data);
    $this->load->view('credit_line/credit_line',$data);
    $this->load->view('template-LendSocial/footer',$data); 
    // die();


}



}

?>