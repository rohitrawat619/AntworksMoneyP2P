<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Social_profile extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Borrower_social_model'));
        $this->load->library('form_validation');
    }

    public function index()
	{  
        $_SESSION['mobile'] = $this->input->get('id');
        $mobile= $_SESSION['mobile'];
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
        $_SESSION['borrower_name'] = $data['borrower_name'];
        $data['mobile'] = $response['mobile'];
        $data['loan_amount'] = $response['loan_amount'];
        $data['loan_purpose'] = $response['loan_purpose'];
        $data['tenure'] = $response['tenure'];
        $data['roi'] = $response['roi'];
        $data['profile_pic'] = $response['profile_pic'];
        $data['credit_score'] = $response['credit_score'];
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
          //var_dump($decode_mobile); exit;
            if ($decode_mobile !='') {
                $response = $this->Borrower_social_model->get_borrower_details_credit_line_social_profile($decode_mobile);
				//print_r($response);exit;
                $get_score = $this->Borrower_social_model->get_score($decode_mobile);
                $response ['credit_score']=$get_score['score'];
                $image = $this->Borrower_social_model->getProfilepicture($decode_mobile);
                $response ['profile_pic']=$image['pic'];
                return $response;
                
            } else {
                $response = array("error_msg" => 'Please enter valid Mobile No.');
                echo json_encode($response);
            }
    }

    public function insert_lender_data()
    {   
        $this->form_validation->set_rules('selected_amount', 'Selected Amount', 'required');
        
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
	{   if($_POST){
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
        $this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
        $this->form_validation->set_rules('pan', 'Pancard No', 'required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
        $this->form_validation->set_rules('account', 'Account', 'required');
        $this->form_validation->set_rules('confirmaccount', 'Confirm Account', 'required|matches[account]');
        

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
        
    // echo("Welcome India");
    // print_r($result); exit;
    
    //if ($result['status'] == 1) {
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
            $result = $this->Borrower_social_model->borrower_detail_update($borrower_id, $name, $dob, $email, $mobile, $pan, $account, $ifsc);
            $result_keys = $this->Borrower_social_model->getRazorpayRegistrationkeys();
            $keys = (json_decode($result_keys, true));
            if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}
            $data['api_key'] = $api_key;
            // echo "<pre>";print_r($api_key);die();
      
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
    }
    else{
        $data[] ="";
        $data['borrower_name'] = $_SESSION['borrower_name'];
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
}


//payment process 
    public function payment_process(){
        
        $payment_array = array(
            'lender_id' => $this->input->post('lender_id'),
            'razorpay_payment_id' => $this->input->post('razorpay_payment_id'),
            'created_date' => date('Y-m-d h:i:s')
        );
        $this->db->insert('p2p_lender_registration_payment', $payment_array);
        echo 1;
        exit;
    }


    //Get profile Picture
    public function get_profile_pic_post()
	{
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$response = $this->Borrower_social_model->getProfilepicture();
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		} else {
			$errmsg = array("error_msg" => validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
	}


 // Thanks Page Load After Payment
    public function thanks()
    {   $data = array();
        $data['borrower_name'] = $_SESSION['borrower_name'];
        $data['keywords']='';
        $data['description'] = "";
        $data['title']='P2P Social Lending';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('thanks', $data);
    }

}

?>