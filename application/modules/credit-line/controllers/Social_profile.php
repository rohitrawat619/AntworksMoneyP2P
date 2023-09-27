<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Social_profile extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
//$this->load->model('Borroweraddmodel','Invest_model');
        $this->load->model(array('Borrower_social_model'));
        $this->load->library('form_validation');
    }

    public function index()
	{
        $mobile = $this->input->get('id');
        
        if ($mobile != '') {
            $response=$this->get_borrower_details_social_profile();
        //$response = $this->Borrower_social_model->get_borrower_details_credit_line_social_profile($abc); 
        $data=array();
        $data['keywords']='';
        $data['title']='P2P Social Lending';
        $data['description'] = "This is the page description.";
        $data['new_p2p'] = "new_p2p";
        if($response['status']!=0){
        $data['borrower_id'] = $response['borrower_id'];
        $data['borrower_name'] = $response['borrower_name'];
        $data['mobile'] = $response['mobile'];
        $data['loan_amount'] = $response['loan_amount'];
        $data['loan_purpose'] = $response['loan_purpose'];
        $data['tenure'] = $response['tenure'];
        $data['roi'] = $response['roi'];
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav');
		$this->load->view('templates/collapse-nav');
		$this->load->view('borrowers_details');
		$this->load->view('templates/footer',$data);        
        }
        }
        else {
            // Handle case when decode_mobile is empty
        }
	}

    public function get_borrower_details_social_profile()
    {
	       $this->load->library('encrypt');
		   $decode_mobile = $this->input->get('id');
           $decode_mobile = $this->encrypt->decode($decode_mobile);
         //  var_dump($decode_mobile); exit;
            if ($decode_mobile !='') {
                $response = $this->Borrower_social_model->get_borrower_details_credit_line_social_profile($decode_mobile);
                return $response;
                
            } else {
                $response = array("error_msg" => 'Please enter valid Mobile No.');
                echo json_encode($response);
            }
    }

    public function insert_lender_data()
    { 
        $borrower_id = $this->input->post('borrower_id');
        $selected_amount = $this->input->post('selected_amount');
       //print_r($this->input->post());
        //die();
        $inserted = $this->Borrower_social_model->insert_lender_data($borrower_id, $selected_amount);
        echo json_encode($inserted);
        die();
    }
    
// Borrowers registration data KYC

    public function registration_borrower()
	{   //$data[] ="";
	    $data['keywords']='';
		$data['description'] = "";
        $data['title']='P2P Social Lending';
        $data['borrower_id'] = $_SESSION['borrower_id'];
        $this->load->view('templates/header',$data);
		$this->load->view('templates/nav');
		$this->load->view('templates/collapse-nav');
        $this->load->view('borrowers_registration');
		$this->load->view('templates/footer',$data);
	}

    public function borrower_payment()
    {   
	   $data['keywords']='';
	   $data['description'] = "";
	   $data['title']='P2P Social Lending';
        $data['borrower_details'] = $this->Borrower_social_model->getDetails($this->input->post('borrower_id'));
      // print_r($data['borrower_details']); exit;
        $this->load->model('Borrower_social_model');
        $borrower_id = $this->input->post('borrower_id');
        $name = $this->input->post('name');
        $dob = $this->input->post('dob');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $pan = $this->input->post('pan');
        $account = $this->input->post('account');
        $confirmaccount = $this->input->post('confirmaccount');
        $ifsc = $this->input->post('ifsc');
        
        $result = $this->Borrower_social_model->borrower_detail_update($borrower_id, $name, $dob, $email, $mobile, $pan, $account, $ifsc);
        
    // echo("Welcome India");
    // print_r($result); exit;
    
    if ($result['status'] == 1) {
    // PAN KYC Validation
        $pan_validation_details = array(
            'pan' => $pan,               
            'name' => $name,
            'mode' => 'exact',
            //'anchor'=> $anchor,
            'mobile'=> $mobile,
            'user_type' => 'lender',
            'user_id' => $borrower_id,
            'source' => 'social-lending',
        );
        $pan_kyc_response = $this->Borrower_social_model->basic_pan_kyc($pan_validation_details);
         
        $pan_kyc_details = json_decode($pan_kyc_response, true);

        // echo "<pre>";
        // print_r($pan_kyc_details['result']['status']);
        // print_r($pan_kyc_details); exit;

       // Account Validation
        $account_validation_details = array(
            'mobile' => $mobile,
            'name' => $name,
            'account_no' => $account,
            'caccount_no' => $confirmaccount,
            'ifsc_code' => $ifsc,
            //'anchor' => $anchor,
            'user_type' => 'lender',
            'user_id' => $borrower_id,
            'source' => 'social-lending',
        );

        $account_validation_response = $this->Borrower_social_model->account_validation($account_validation_details);
        $account_details = json_decode($account_validation_response, true);
        // echo "<pre>";
        // print_r($pan_kyc_details);
        // echo("<welcome>");
        // print_r($account_details);die();

       // echo $user_name = $account_details['fund_account']['details']['name'];
       // echo $registered_name = $account_details['results']['registered_name']; die;

        if (
            $pan_kyc_details['result']['name_match'] == 1 &&
            $pan_kyc_details['result']['status'] == 'Active' &&
           // $account_details['fund_account']['active'] == 1 &&
            $account_details['results']['account_status'] == 'active')
        {
            // Both PAN KYC and Account Validation successful
             // echo"<pre>"; print_r($data); die();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav', $data);
            $this->load->view('razorpay', $data);

        } else {
            // PAN or Account validation failed, redirect to registration_borrower
            $this->session->set_flashdata('error_message', 'Please enter a valid PAN and Account Number.');
            redirect('credit-line/social_profile/registration_borrower');
        }

    } else {

    }
} 

//payment process 
public function payment_process(){

}



   // Thanks Page Load After Payment
    public function thanks()
    {   
        $data = array();
		$data['keywords']='';
		$data['description'] = "";
        $data['title']='P2P Social Lending';
                $this->load->view('templates/header', $data);
                $this->load->view('templates/nav');
                $this->load->view('thanks', $data);
    }

}

?>