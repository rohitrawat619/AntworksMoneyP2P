<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowwer_bullet extends CI_Controller{

    public function __construct()
    {
      
        parent::__construct();
        
        $this->borrowerProductImagePath = "../../document/surge/img/borrower/buddy-credit-line.png";
        $this->imageBaseUrl = "../../document/surge/img/borrower"; 
		
		//$this->logo_path = "logo_path";
        $this->load->model('credit_line_model');
		$this->load->model('LendSocialmodel');
		//$this->mobile = 6395130787;
		
		$this->sessionVariableData = $this->session->userdata(); 
		$partnerInfo = $this->LendSocialmodel->getPartnersTheme($this->sessionVariableData['partner_id']);
		$this->sessionData = $this->LendSocialmodel->getUserDetail($this->sessionVariableData['mobile']);
		
		$this->mobile = $this->sessionData['mobile'];
		$partnerInfo['logo_path'] =	str_replace('D:/public_html/antworksp2p.com','../..',$partnerInfo['logo_path'])."?q=".rand();
		$this->partnerInfo = $partnerInfo;
						
		$this->borrowerProductName=$this->partnerInfo['borrower_product_name'];
	//	print_r($this->partnerInfo['borrower_product_name']);
		
		
        
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

public function info(){
    $data=array();
 
   

    
    $get_user_details=$this->credit_line_model->get_borrower_details($this->mobile);
		// echo"<pre>";
		//$dataVar = json_encode($get_user_details);
		//  print_r(json_decode($dataVar,true));
		if($get_user_details['status']==0){
			 redirect(base_url('LendSocial/').'personalDetails');
		}
    $this->setBorrowerId($get_user_details['borrower_id']);
    
    
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

  $loan_eligiblity_status=$this->credit_line_model->loan_eligiblity_status($this->getBorrowerId());
  $this->setLoanId($loan_eligiblity_status['loan_id']);
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
  
  $credit_line_sanction_details=$this->credit_line_model->credit_line_saction_details($this->getBorrowerId(),$this->getLoanId());

  $view_loan_agreement=$this->credit_line_model->viewLoanaggrement($this->getBorrowerId());

  $data['view_loan_agreement']=$view_loan_agreement;
  $data['credit_line_sanction_details']=$credit_line_sanction_details;
  $data['imageBaseUrl'] = $this->imageBaseUrl;
	$data['logo_path'] = $this->partnerInfo['logo_path'];
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/e_sign',$data);
  $this->load->view('template-LendSocial/footer',$data);
}
public function e_sign_send_otp_ajax(){

  $response=$this->credit_line_model->credit_line_sendOtpsignature($this->getBorrowerId(),$this->getLoanId());

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
  
  $loan_details=$this->credit_line_model->loan_details($this->getBorrowerId());
  // echo "<pre>";print_r($loan_details);die();

  
  $data['loan_details']=$loan_details;
  $data['imageBaseUrl'] = $this->imageBaseUrl;
  $data['logo_path'] = $this->partnerInfo['logo_path'];
   $this->load->view('template-LendSocial/header',$data);
 // $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/dashboard',$data);
  $this->load->view('template-LendSocial/footer',$data);
}

public function disburse(){
  // $_SESSION['borrower_id'];
  // $_SESSION['loan_id']=192;

  $disburse=$this->credit_line_model->disbursement_request($this->getBorrowerId(),$this->getLoanId());
  // $response=array('borrower_id'=>$_SESSION['borrower_id'],'loan_id'=>$_SESSION['loan_id']);
  echo json_encode($disburse);die();


  
}


}

?>