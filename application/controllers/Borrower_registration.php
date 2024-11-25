<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Borrower_registration extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Requestmodel','Borrowermodel'));
        $this->load->library('form_validation');

    }

    public $username 	= 'shantanu@antworksmoney.com';
    public $hash_api 	= 'b3a4f30ed009f72aa58fcad1e58ddd49b8b7fd44f5a82bc2b93da9325174d68f';//'323c07417bfd9b57c114e379217072abe4c2c0c0753cc28d151cac689d956581';  //'2f6f843823f6b9f5352bb47355e264fd20369975';
    public $sender 		= 'ANTFIN';

    public function index()
    {
        //$this->Borrowermodel->create_borrower_id();
        $data['loan_types'] = $this->Requestmodel->getLoantypeweb();
        $data['states'] = $this->Requestmodel->get_state();
        $data['qualification'] = $this->Requestmodel->highest_qualification();
        $data['occuptions'] = $this->Requestmodel->get_occuption();
        $data['present_residence_type'] = $this->Requestmodel->get_present_residence_type();
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/borrower/borrower-register',$data);
        $this->load->view('templates/footer',$data);
    }

    public function borrower_register()
    {
//echo "hi";exit;
        $this->form_validation->set_rules('name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('highest_qualification', 'trim|Qualification', 'required');
        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
        $this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
        $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('address1', 'address1', 'required');
        $this->form_validation->set_rules('state_code', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|regex_match[/^[1-9][0-9]{5}$/]');
        $this->form_validation->set_rules('present_residence', 'Present Residence', 'required');
        $this->form_validation->set_rules('occupation', 'occupation', 'required');
        if($this->input->post('occupation') == 1)
        {
            $this->form_validation->set_rules('company_type', 'Company type', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('total_experience', 'Total Experience', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 2)
        {
            $this->form_validation->set_rules('company_type', 'Industry type', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('total_experience', 'Total experience', 'trim|required');
            $this->form_validation->set_rules('turnover_last_year', 'Turnover last year', 'trim|required');
            $this->form_validation->set_rules('turnover_last2_year', 'Turnover last 2 year', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Net Monthly Income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 3)
        {
            $this->form_validation->set_rules('company_type', 'Professional type', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('total_experience', 'Total experiance', 'trim|required');
            $this->form_validation->set_rules('turnover_last_year', 'Last year turnover', 'trim|required');
            $this->form_validation->set_rules('turnover_last2_year', 'Last 2 year turnover', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Net Monthly Income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 4)
        {
            $this->form_validation->set_rules('company_type', 'Company type', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 5)
        {
            $this->form_validation->set_rules('company_type', 'Pursuing course', 'trim|required');
            $this->form_validation->set_rules('company_name', 'institute_name5', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 6)
        {
            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        if($this->input->post('occupation') == 7)
        {
            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
        }
        $this->form_validation->set_rules('loan_amount_borrower', 'Loan amount', 'required');
        $this->form_validation->set_rules('tenor_borrower', 'Tenor', 'required');
        $this->form_validation->set_rules('borrower_interest_rate', 'Interest rate', 'required');
        $this->form_validation->set_rules('p2p_product_id', 'Loan purpose', 'required');
        $this->form_validation->set_rules('borrower_loan_desc', 'Loan description', 'required');
        $this->form_validation->set_rules('term_and_condition', 'Term and condition', 'required');

        if ($this->form_validation->run() == TRUE)
		{

            $result = $this->Borrowermodel->add_borrower();
            if($result){
                $msg="Thank you for registering with Antworks P2P. We have sent you an activation link on your email id, Please follow the link to verify your email.";
                $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
                redirect(base_url().'borrower-register/thank-you');
            }
            else{
                $errmsg = "OOPS! Something went wrong please check you credential and try again.";
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
                redirect(base_url().'borrower-registration');
            }
        }
        else{
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
            redirect(base_url().'borrower-registration');
        }
    }

    public function verify_email()
    {
      $verify_code =$this->input->get('verify_code');
      $verify_hash = $this->input->get('verify_hash');
      $hash = $this->input->get('hash');
      if($verify_code && $verify_hash && $hash)
      {
             $data['result'] = $this->Borrowermodel->verify_borrower($verify_code, $verify_hash, $hash);
             if($this->input->get('source') == 'APP')
             {
//                if($data['result'] === true)
//                {
//                  $response = array('status'=>1, 'email_verified_or_not'=>1, 'msg'=>'Borrower');
//                }
//                else if($data['result'] == 2){
//                    $response = array('status'=>0, 'email_verified_or_not'=>1);
//                }
//                else{
//                    $response = array('status'=>0, 'email_verified_or_not'=>0);
//                }
//                var_dump($data['result']); exit;
             }
              $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
              $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
              $data['keywords']='';
              $this->load->view('templates/header',$data);
              $this->load->view('templates/nav',$data);
              $this->load->view('templates/collapse-nav',$data);
              $this->load->view('frontend/borrower/verify-email',$data);
              $this->load->view('templates/footer');

      }
      else{
         echo "OOPS! You do not have Direct Access. Please Login"; exit;
      }

    }

    public function thankyou()
    {
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/borrower/thankyou',$data);
        $this->load->view('templates/footer',$data);
    }

    public function company_list_search()
    {
        $q=$_POST["q"];
        $hint="";

        $this->db->select('*');
        $this->db->from('p2p_list_company');
        $this->db->like('company_name',$q, 'after');
        $this->db->limit(4);
        $query = $this->db->get();
        if($this->db->affected_rows()>0) {
            $res = $query->result_array();
            $hint = "<ul>";
            $i = 1;
            if ($res) {
                foreach ($res as $row) {
                    $hint .= '<li id="ls1' . $i . '" onClick="livesearchbox1(' . $i . ')">' . $row['company_name'] . '</li>';
                    $i++;
                }
                $hint .= "</ul>";
                $response = $hint;
            } else {
                $response = '<li id="ls11" onClick="livesearchbox1(1)">' . $this->input->post('q') . '</li>';
            }
        }
		else {
            $response = '<ul><li id="ls11" onClick="livesearchbox1(1)">' . $this->input->post('q') . '</li></ul>';
        }

        //output the response
        echo $response;
    }

    public function sendOTP()
    {		
	
        $this->load->database();
		 $mobile = sanitize_input_data($_POST['mobile']);
		// echo $mobile;
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$sourceOfSms =  $_POST['source']; 
		if($sourceOfSms==""){
			http_response_code(500);
			return false;
		}
        if(!empty($_POST['mobile'])){

            $sql = "SELECT mobile FROM p2p_lender_list WHERE mobile = ".$mobile."
                    UNION
                    SELECT mobile FROM p2p_borrowers_list WHERE mobile = ".$mobile."";
            $this->db->query($sql);
			//echo $this->db->last_query();
            if($this->db->affected_rows()>0)
            {
                echo 3; exit; //Already re
            }
            else{



            $arr=array();
            $number = str_replace("'","",sanitize_input_data($_POST['mobile']));
			//echo $number."--";
            $otp = rand(100000,999999);
			$otp = '876420';
            $this->db->select('*');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->where('date_added >= now() - INTERVAL 10 MINUTE');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = count($query->result_array());
                if($result>10)
                {
                    echo 2; exit;
                }
                else{
                    $arr["mobile"]=$number;
                    $arr["otp"]=$otp;
					$arr["source"]= $sourceOfSms.'sendOTP';
					$arr["ip_address"]= $ip_address;
                    $query = $this->db-> insert('p2p_otp_details_table',$arr);
                }

            }
            else{
                $arr["mobile"]=$number;
                $arr["otp"]=$otp;
				$arr["source"]= $sourceOfSms.'sendOTP2';
				$arr["ip_address"]= $ip_address;
                $query = $this->db-> insert('p2p_otp_details_table',$arr);
            }

				//echo $this->db->last_query(); die();

            //$msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
            $msg = "$otp is your Antworks Account verification code - ANTWORKS";
//            $msg = "Hi (Test Name lenght 10) Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
            $message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

            // Send the POST request with cURL
         /*  comment on 2024-march-03 dheeraj dutta */
		 $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch); 
            // Create session for verifying number

            echo 1; exit;
            }
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }

    public function verify_mobile()
    {			 http_response_code(401);
        if (!empty($_POST['mobile']) && !empty($_POST['otp'])) {
            $number = $_POST['mobile'];
            $otp = $_POST['otp'];
            $data = array(
                'csrf_token' => $this->security->get_csrf_hash(),
            );
            $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->where('status', '0');
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                $result = $query->row();
                if($otp == $result->otp)
                {
                    if ($result->MINUTE <= 10) {
						 http_response_code(200);
                        $data['response'] = "verify";
                        $this->db->where('otp', $this->input->post('otp'));
                        $this->db->where('mobile', $this->input->post('mobile'));
                        $this->db->set('status', '1');
                        $this->db->update('p2p_otp_details_table');
                    } else {
                        $data['response'] = "OTP Expired, Please Resend and try again";
                    }
                }
                else{
                    $data['response'] = "OTP Not Verified";
                }

            } else {
                $data['response'] = "OTP Not Verified";
            }
            echo json_encode($data);
            exit;

        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }

    public function check_email_availability()
    {
        if(!empty($_POST['email'])){
            $this->db->select('email');
            $this->db->from('p2p_borrowers_list');
            $this->db->where('email',$_POST['email']);
            $this->db->get();
            if($this->db->affected_rows()>0)
            {
                echo "No";
            }
            else
            {
                $this->db->select('email');
                $this->db->from('p2p_lender_list');
                $this->db->where('email',$_POST['email']);
                $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    echo "No";
                }
                else{
                    echo "Yes";
                }

            }
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
        }
    }

    public function check_pan_availability()
    {
        if(!empty($_POST['pan'])){
            $this->db->select('pan');
            $this->db->from('p2p_borrowers_list');
            $this->db->where('pan',$_POST['pan']);
            $this->db->get();
            if($this->db->affected_rows()>0)
            {
                echo "No";
            }
            else
            {
                $this->db->select('pan');
                $this->db->from('p2p_lender_list');
                $this->db->where('pan',$_POST['pan']);
                $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    echo "No";
                }
                else{
                    echo "Yes";
                }

            }
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
        }
    }

    public function getOccuptionfields()
    {
        if(isset($_POST))
        {
            $occuption_fields = '';
            if($this->input->post('occuaption') == 1){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <select class="form-control" name="company_type" id="company_type" >
                                        <option value="">Select Employment</option>
                                        <option value="Government">Government</option>
                                        <option value="PSUs">PSUs</option>
                                        <option value="MNC">MNC</option>
                                        <option value="Public Limited Company">Public Limited Company</option>
                                        <option value="Private Limited Company">Private Limited Company</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Proprietorship">Proprietorship</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <span class="validation error-validation" id="error_company_type"></span>
                                </div>
                            </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Company Name" name="company_name" id="company_name" onkeyup="showResult1(this.value)" >
                                            <span class="validation error-validation" id="error_company_name"></span>
                                        </div>
                                        <div id="livesearch1" class="col-md-12" style="display:none"></div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <select class="form-control" name="total_experience" id="total_experience">
                                                <option value="">--Total Experience--</option>
                                                <option value="">Less then 1 year</option>
                                                <option value="1">1 year</option>
                                                <option value="2">2 years</option>
                                                <option value="3">3 years</option>
                                                <option value="4">4 years</option>
                                                <option value="5">5 years</option>
                                                <option value="6">6 years</option>
                                                <option value="7">7 years</option>
                                                <option value="8">8 years</option>
                                                <option value="9">9 years</option>
                                                <option value="10">(>)10 years</option>
                                            </select>
                                            <span class="validation error-validation" id="error_total_experience"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
        
                                            <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                            <span class="validation error-validation" id="error_net_monthly_income"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 2){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <select class="form-control" name="company_type" id="company_type" >
                                        <option value="">Select Industry</option>
                                        <option value="Manufacturing">Manufacturing</option>
                                        <option value="Trading">Trading</option>
                                        <option value="Service">Service</option>
                                        <option value="MNC">MNC</option>
                                        <option value="KPO">KPO</option>
                                        <option value="BPO">BPO</option>
                                        <option value="Software">Software</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <span class="validation error-validation" id="error_company_type"></span>
                                </div>
                            </div>
                                        <div class="col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Company Name" name="company_name" id="company_name" onkeyup="showResult1(this.value)" >
                                                <span class="validation error-validation" id="error_company_name"></span>
                                            </div>
                                            <div id="livesearch1" class="col-md-12" style="display:none"></div>
                                        </div>            
                                        <div class="col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <select class="form-control" name="total_experience" id="total_experience">
                                                    <option value="">--Total Experience--</option>
                                                    <option value="">Less then 1 year</option>
                                                    <option value="1">1 year</option>
                                                    <option value="2">2 years</option>
                                                    <option value="3">3 years</option>
                                                    <option value="4">4 years</option>
                                                    <option value="5">5 years</option>
                                                    <option value="6">6 years</option>
                                                    <option value="7">7 years</option>
                                                    <option value="8">8 years</option>
                                                    <option value="9">9 years</option>
                                                    <option value="10">(>)10 years</option>
                                                </select>
                                                <span class="validation error-validation" id="error_total_experience"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Turnover Last Year" type="text" name="turnover_last_year" id="turnover_last_year" >
                                                <span class="validation error-validation" id="error_turnover_last_year"></span>
                                            </div>
                                        </div>            
                                        <div class="col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Turnover Last 2 Year" name="turnover_last2_year" id="turnover_last2_year" >
                                                <span class="validation error-validation" id="error_turnover_last2_year"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <div class="form-group">
            
                                                <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                                <span class="validation error-validation" id="error_net_monthly_income"></span>
                                            </div>
                                        </div>            
                                        <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 3){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <select class="form-control" name="company_type" id="company_type" >
                                        <option value="">Select Professional</option>
                                        <option value="Doctor">Doctor</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="CA">CA</option>
                                        <option value="CS">CS</option>
                                        <option value="Architect">Architect</option>
                                        <option value="Lawyer">Lawyer</option>
                                        <option value="Other Consultant">Other Consultant</option>
                                    </select>
                                    <span class="validation error-validation" id="error_company_type"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Company Name" name="company_name" id="company_name" onkeyup="showResult1(this.value)" >
                                    <span class="validation error-validation" id="error_company_name"></span>
                                </div>
                                <div id="livesearch1" class="col-md-12" style="display:none"></div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <select class="form-control" name="total_experience" id="total_experience">
                                        <option value="">--Total Experience--</option>
                                        <option value="">Less then 1 year</option>
                                        <option value="1">1 year</option>
                                        <option value="2">2 years</option>
                                        <option value="3">3 years</option>
                                        <option value="4">4 years</option>
                                        <option value="5">5 years</option>
                                        <option value="6">6 years</option>
                                        <option value="7">7 years</option>
                                        <option value="8">8 years</option>
                                        <option value="9">9 years</option>
                                        <option value="10">(>)10 years</option>
                                    </select>
                                    <span class="validation error-validation" id="error_total_experience"></span>
                                </div>
                            </div>
							<div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Turnover Last Year" type="text" name="turnover_last_year" id="turnover_last_year" >
                                    <span class="validation error-validation" id="error_turnover_last_year"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Turnover Last 2 Year" name="turnover_last2_year" id="turnover_last2_year" >
                                    <span class="validation error-validation" id="error_turnover_last2_year"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_net_monthly_income"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 4){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <select class="form-control" name="company_type" id="company_type" >
                                        <option value="">Select Employment</option>
                                        <option value="Government">Government</option>
                                        <option value="PSUs">PSUs</option>
                                        <option value="MNC">MNC</option>
                                        <option value="Public Limited Company">Public Limited Company</option>
                                        <option value="Private Limited Company">Private Limited Company</option>
                                        <option value="Partnership">Partnership</option>
                                        <option value="Proprietorship">Proprietorship</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <span class="validation error-validation" id="error_company_type"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Company Name" name="company_name" id="company_name" onkeyup="showResult1(this.value)" >
                                    <span class="validation error-validation" id="error_company_name"></span>
                                </div>
                                <div id="livesearch1" class="col-md-12" style="display:none"></div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <select class="form-control" name="total_experience" id="total_experience">
                                        <option value="">--Total Experience--</option>
                                        <option value="">Less then 1 year</option>
                                        <option value="1">1 year</option>
                                        <option value="2">2 years</option>
                                        <option value="3">3 years</option>
                                        <option value="4">4 years</option>
                                        <option value="5">5 years</option>
                                        <option value="6">6 years</option>
                                        <option value="7">7 years</option>
                                        <option value="8">8 years</option>
                                        <option value="9">9 years</option>
                                        <option value="10">(>)10 years</option>
                                    </select>
                                    <span class="validation error-validation" id="error_total_experience"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_net_monthly_income"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 5){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <select class="form-control" name="company_type" id="company_type" >
                                        <option value="">Select </option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Postgraduation">Postgraduation</option>
                                        <option value="Doctoral">Doctoral</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Diploma">Diploma</option>
                                    </select>
                                    <span class="validation error-validation" id="error_company_type"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Institute Name" name="company_name" id="company_name">
                                    <span class="validation error-validation" id="error_company_name"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_net_monthly_income"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 6){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_net_monthly_income"></span>
                                </div>
                            </div><div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }
            if($this->input->post('occuaption') == 7){
                $occuption_fields = '<div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Monthly Income" name="net_monthly_income" id="net_monthly_income" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_net_monthly_income"></span>
                                </div>
                            </div><div class="col-md-6 col-xs-6">
                                <div class="form-group">

                                    <input class="form-control" type="text" placeholder="Current EMIS" name="current_emis" id="current_emis" maxlength="10" onkeypress="return isNumberKey(event)" >
                                    <span class="validation error-validation" id="error_current_emis"></span>
                                </div>
                            </div>';
            }

            echo $occuption_fields; exit;
        }
        else{

        }
    }


}

?>
