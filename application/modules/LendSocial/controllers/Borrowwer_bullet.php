<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowwer_bullet extends CI_Controller{

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


public function waiting(){
  
  $data=array();
	$data['logo_path'] = $this->partnerInfo['logo_path'];
	$data['imageBaseUrl'] = $this->imageBaseUrl;
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/waiting');
  $this->load->view('template-LendSocial/footer',$data); 
}

public function waiting_ajax(){

  $loan_eligiblity_status=$this->credit_line_model->loan_eligiblity_status($this->getBorrowerId(),$this->getPartnerId());
  //$this->setLoanId($loan_eligiblity_status['loan_id']);
  echo json_encode($loan_eligiblity_status); die();

  
}
public function success(){

  $data=array();
	$data['logo_path'] = $this->partnerInfo['logo_path'];
	$data['imageBaseUrl'] = $this->imageBaseUrl;
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/success');
  $this->load->view('template-LendSocial/footer',$data);
}

public function e_sign(){
  

  $data=array();
  
 // $credit_line_sanction_details=$this->credit_line_model->credit_line_saction_details($this->getBorrowerId(),$this->getLoanId());

  $view_loan_agreement=$this->credit_line_model->viewLoanaggrement($this->getBorrowerId());
	//echo "<pre>";print_r($view_loan_agreement);die();
	
	$data['partner_loan_plans']=$this->credit_line_model->get_loan_plans(array('partner_id'=>$this->getPartnerId(),'status'=>1)); // dated: 2024-june-06
	
  $data['view_loan_agreement']=$view_loan_agreement;
 // $data['credit_line_sanction_details']=$credit_line_sanction_details;
  $data['imageBaseUrl'] = $this->imageBaseUrl;
	$data['logo_path'] = $this->partnerInfo['logo_path'];
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/e_sign',$data);
  $this->load->view('template-LendSocial/footer',$data);
}
public function e_sign_send_otp_ajax(){

  $partner_loan_plan = $this->credit_line_model->get_loan_plans(array('id'=>$this->input->post('selectedId'),'status'=>1));
  $partner_loan_plan['loan_no'] = $this->getLoanNo();
  $partner_loan_plan['borrower_id'] = $this->getBorrowerId();
  $data=$this->credit_line_model->updateLoanDetails($partner_loan_plan);
  if($data==1){
   $response=$this->credit_line_model->credit_line_sendOtpsignature($this->getBorrowerId(),$this->getLoanId());
}else{
  $response['msg']='data not updated';
}
  echo json_encode($response);die();
}


public function e_sign_verify_otp_ajax(){

  $otp=$this->input->post('otp');
  $response=$this->credit_line_model->credit_line_verifyOtpsignature($this->getBorrowerId(),$this->getLoanId(),$otp);

  echo json_encode($response);die();
}


public function otp(){

  $data=array();
  $data['logo_path'] = $this->partnerInfo['logo_path'];
  $data['imageBaseUrl'] = $this->imageBaseUrl;
  $data['mobile'] = $this->mobile;
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/otp',$data);
  $this->load->view('template-LendSocial/footer',$data);

}

public function e_sign_success(){
  
  $data=array();
  $data['imageBaseUrl'] = $this->imageBaseUrl;
  $data['logo_path'] = $this->partnerInfo['logo_path'];
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/e_sign_success');
  $this->load->view('template-LendSocial/footer',$data);
}

public function dashboard(){

  $data=array();
  //echo "<pre>";print_r($_SESSION);die();
  $loan_details=$this->credit_line_model->loan_details($this->getBorrowerId());
    $data['partner_loan_plans']=$this->credit_line_model->get_loan_plans(array('partner_id'=>$this->getPartnerId(),'status'=>1));//get_loan_plans();
  $data['loan_details']=$loan_details;
  $data['imageBaseUrl'] = $this->imageBaseUrl;
  $data['logo_path'] = $this->partnerInfo['logo_path'];
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/dashboard',$data);
  $this->load->view('template-LendSocial/footer',$data);
}

/*
public function disburse(){

  $disburse=$this->credit_line_model->disbursement_request($this->getBorrowerId(),$this->getLoanId(),$this->getPartnerId());
  // $response=array('borrower_id'=>$_SESSION['borrower_id'],'loan_id'=>$_SESSION['loan_id']);
  echo json_encode($disburse);die();

  
} */


public function disburse(){
	$selectedId = $this->input->post('selectedId');
	if($selectedId!=""){
		
    $partner_loan_plan = $this->credit_line_model->get_loan_plans(array('partner_id'=>$this->getPartnerId(),'status'=>1,'id'=>$selectedId));//get_loan_plans();
  $partner_loan_plan['id'] = $this->getLoanId();
   $partner_loan_plan['loan_no'] = $this->getLoanNo();
  $partner_loan_plan['borrower_id'] = $this->getBorrowerId();
  $data=$this->credit_line_model->updateLoanDetails($partner_loan_plan);

    if($data==1){
      $response=$this->credit_line_model->disbursement_request($this->getBorrowerId(),$this->getLoanId(),$this->getPartnerId());
      $response['msg']='data updated';
}else{
  $response['msg']='data not updated';
}
	}else{
$response['msg']='Loan Plan ID Required';
	}
  echo json_encode($response);die();


  
}

}

?>