<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Commonapi extends REST_Controller{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model(array('Requestmodel', 'Smssetting', 'Commonapimodel'));
    }

    public function sendOtp_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $_POST = json_decode(file_get_contents('php://input'),true);
                $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                if ($this->form_validation->run() == TRUE)
                {
                    $this->load->model('P2psmsmodel');
                    $this->load->model('Smssetting');
                    $result = $this->P2psmsmodel->sendOtp();
                    if($result === true)
                    {
                        $setting = $this->Smssetting->smssetting();
                        $otp = 898767;//rand(100000,999999);
                        $arr["mobile"]=$this->input->post('mobile');
                        $arr["otp"]=$otp;
						$arr["source"]="commonApi";
                        $query = $this->db->insert('p2p_otp_details_table',$arr);
                        $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
                        $message = rawurlencode($msg);

                        // Prepare data for POST request
                        $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $this->input->post('mobile'), "sender" => $setting['sender'], "message" => $message);
                        $ch = curl_init('https://api.textlocal.in/send/');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $res = json_decode($response, true);
                        if($res['status'] == 'success')
                        {
                            $response = array(
                                'status'=>1,
                                'msg'=>'OTP sent successfully'
                            );
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $response = array(
                                'status'=>0,
                                'msg'=>'Something went wrong!!'
                            );
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                        }
                    }
                    else{
                        $response = array(
                            'status'=>0,
                            'msg'=>$result
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                }
                else{
                    $errmsg = array("error_msg"=>validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }

            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function verifyOTP_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false) {
                $this->load->model('P2psmsmodel');
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $result = $this->P2psmsmodel->verifyOtp();
                    if($result === true)
                    {
                        $response = array(
                            'status'=>1,
                            'msg'=>'OTP verified successfully'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result == 2)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'OTP Expired, Please Resend and try again'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result == 3)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'Your OTP is not verified please enter valid OTP'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result === false)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'Invalid Approch'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                }
                else{
                    $errmsg = array("error_msg"=>validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getState_get()
    {
        $headers = $this->input->request_headers();
		 
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
          
            if ($decodedToken != false){
                $state_list = $this->Requestmodel->get_state();
                if($state_list)
                {
                    $response = array(
                        'status'=>1,
                        'state_list'=>$state_list
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'state_list'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function cityList_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('state_code', 'State Code', 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $city_list = $this->Requestmodel->city_list_statcode();
                    if($city_list)
                    {
                        $response = array(
                            'status'=>1,
                            'city_list'=>$city_list
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $response = array(
                            'status'=>0,
                            'city_list'=>'Not found'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                }
                else{
                    $errmsg = array("error_msg"=>validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }

            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getOccuption_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false){
                $occupation_list = $this->Requestmodel->get_occuption();
                if($occupation_list)
                {
                    $response = array(
                        'status'=>1,
                        'occupation_list'=>$occupation_list
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'occupation_list'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getQualification_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false){
               $qualification_list = $this->Requestmodel->highest_qualification();
                if($qualification_list)
                {
                    $response = array(
                        'status'=>1,
                        'qualification_list'=>$qualification_list
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'qualification_list'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }
    
    public function getPresentresidence_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false){
                $present_residence_list = $this->Requestmodel->get_present_residence_type();
                if($present_residence_list)
                {
                    $response = array(
                        'status'=>1,
                        'present_residence_list'=>$present_residence_list
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'present_residence_list'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getBanklist_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $bank_list = $this->Requestmodel->get_Banklist();
                if($bank_list)
                {
                    $response = array(
                        'status'=>1,
                        'bank_list'=>$bank_list
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'bank_list'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getLoantype_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $loan_type = $this->Requestmodel->getLoantype();
                if($loan_type)
                {
                    $response = array(
                        'msg'=>"found",
                        'loan_type'=>$loan_type
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'err_msg'=>"Not Found",
                        'loan_type'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getRazorpaykey_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $result = $this->Requestmodel->getRazorpayRegistrationkeys();
                if($result)
                {
                   $keys = json_decode($result, true);
                    if($keys['razorpay_Testkey']['status'] == 0)
                    {
                        $key['key'] = $keys['razorpay_Testkey']['key'];
                    }
                    if ($keys['razorpay_razorpay_Livekey']['status'] == 0){

                        $key['key'] = $keys['razorpay_razorpay_Livekey']['key'];

                    }
                   $this->set_response($key, REST_Controller::HTTP_OK);
                   return;
                }
                else{
                    $response = array(
                        'msg'=>"Sorry not found",
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }


            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getRazorpaykeyfunding_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $result = $this->Requestmodel->getRazorpayFundingkeys();
                if($result)
                {
                    $keys = json_decode($result, true);
                    if($keys['razorpay_Testkey']['status'] == 0)
                    {
                        $key['key'] = $keys['razorpay_Testkey']['key'];

                    }
                    if ($keys['razorpay_razorpay_Livekey']['status'] == 0){

                        $key['key'] = $keys['razorpay_razorpay_Livekey']['key'];

                    }

                    $this->set_response($key, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'msg'=>"Sorry not found",
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }


            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getRazorpaykeyrepayment_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $result = $this->Requestmodel->getRazorpayRepaymentkeys();
                if($result)
                {

                    $keys = json_decode($result, true);
					//pr($keys);exit;
                    if($keys['razorpay_Testkey']['status'] == 0)
                    {
                       $key['key'] = $keys['razorpay_Testkey']['key'];

                    }
                    if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

                        $key['key'] = $keys['razorpay_razorpay_Livekey']['key'];

                    }
                    $razorpay_key['razorpay_key'] = $key;
                    $this->set_response($key, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'msg'=>"Sorry not found",
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }


            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function resendEmailverification_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                if ($this->form_validation->run() == TRUE) {

                    $response = $this->Commonapimodel->Send_verification_email_code($source = 'APP');

                    if ($response) {
                        $msg = array(
                            "status" => 1,
                            "msg" => "E-mail varification code send",
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    } else {
                        $msg = array(
                            "status" => 0,
                            "msg" => "Something went wrong",
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
                else
                {
                    $errmsg = array("error_msg" => validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }
            }

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function verifyEmailcode_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('email_verification_code', 'Email Verification Code', 'trim|required');
                if ($this->form_validation->run() == TRUE) {
                    $response = $this->Commonapimodel->verifyEmailcode($source = 'APP');
                    if ($response) {
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                } else {
                    $errmsg = array("error_msg" => validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getborrowerRegistrationfee_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $response = array(
                    'status'=>1,
                    'lender_registration_fee'=>500,
                );
                if($response)
                {
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'borrower_registration_fee'=>0,
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getlenderRegistrationfee_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false){
                $response = array(
                    'status'=>1,
                    'lender_registration_fee'=>500,
                );
                if($response)
                {
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'borrower_registration_fee'=>0,
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function sendotpForgotpassword_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                    $this->load->database();
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                    if ($this->form_validation->run() == TRUE) {
                        $query = $this->db->select('mobile')->get_where('p2p_borrowers_list', array('mobile' => $this->input->post('mobile')));
                        if($this->db->affected_rows()>0)
                        {
                            $result = (array)$query->row();
                            $result = $this->Commonapimodel->sentotpForgotpassword();
                            if ($result === true) {
                                $setting = $this->Smssetting->smssetting();
                                $otp = rand(100000, 999999);
                                $arr["mobile"] = $this->input->post('mobile');
                                $arr["date_added"] = date("Y-m-d H:i:s");
                                $arr["otp"] = $otp;
                                $query = $this->db->insert('p2p_otp_forgot_password_table', $arr);
                                $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
                                $message = rawurlencode($msg);

                                // Prepare data for POST request
                                $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $this->input->post('mobile'), "sender" => $setting['sender'], "message" => $message);
                                $ch = curl_init('https://api.textlocal.in/send/');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $response = curl_exec($ch);
                                curl_close($ch);
                                $res = json_decode($response, true);
                                if ($res['status'] == 'success') {
                                    $response = array(
                                        'status' => 1,
                                        'msg' => 'OTP sent successfully'
                                    );
                                    $this->set_response($response, REST_Controller::HTTP_OK);
                                    return;
                                } else {
                                    $response = array(
                                        'status' => 0,
                                        'msg' => 'Something went wrong!!'
                                    );
                                    $this->set_response($response, REST_Controller::HTTP_OK);
                                    return;
                                }
                            } else {
                                $response = array(
                                    'status' => 0,
                                    'msg' => $result
                                );
                                $this->set_response($response, REST_Controller::HTTP_OK);
                                return;
                            }

                        }
                        else{
                            $query = $this->db->select('mobile')->get_where('p2p_lender_list', array('mobile' => $this->input->post('mobile')));
                            if($this->db->affected_rows()>0)
                            {
                                $result = (array)$query->row();
                                $result = $this->Commonapimodel->sentotpForgotpassword();
                                if ($result === true) {
                                    $setting = $this->Smssetting->smssetting();
                                    $otp = rand(100000, 999999);
                                    $arr["mobile"] = $this->input->post('mobile');
                                    $arr["date_added"] = date("Y-m-d H:i:s");
                                    $arr["otp"] = $otp;
                                    $query = $this->db->insert('p2p_otp_forgot_password_table', $arr);
                                    $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
                                    $message = rawurlencode($msg);

                                    // Prepare data for POST request
                                    $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $this->input->post('mobile'), "sender" => $setting['sender'], "message" => $message);
                                    $ch = curl_init('https://api.textlocal.in/send/');
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    $res = json_decode($response, true);
                                    if ($res['status'] == 'success') {
                                        $response = array(
                                            'status' => 1,
                                            'msg' => 'OTP sent successfully'
                                        );
                                        $this->set_response($response, REST_Controller::HTTP_OK);
                                        return;
                                    } else {
                                        $response = array(
                                            'status' => 0,
                                            'msg' => 'Something went wrong!!'
                                        );
                                        $this->set_response($response, REST_Controller::HTTP_OK);
                                        return;
                                    }
                                } else {
                                    $response = array(
                                        'status' => 0,
                                        'msg' => $result
                                    );
                                    $this->set_response($response, REST_Controller::HTTP_OK);
                                    return;
                                }
                            }
                            else{
                                $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
                                return;
                            }

                        }

                    } else {
                        $errmsg = array("error_msg" => validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }

            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    public function forgotPasswordOTPverify_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $result = $this->Commonapimodel->verifyOtpForgotpassword();

                    if($result === true)
                    {
                        $response = array(
                            'status'=>1,
                            'msg'=>'OTP verified successfully'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result == 2)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'OTP Expired, Please Resend and try again'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result == 3)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'Your OTP is not verified please enter valid OTP'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                    if($result === false)
                    {
                        $response = array(
                            'status'=>0,
                            'msg'=>'Invalid Approch'
                        );
                        $this->set_response($response, REST_Controller::HTTP_OK);
                        return;
                    }
                }
                else{
                    $errmsg = array("error_msg"=>validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function changePasswordforgot_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $this->load->database();
                $_POST = json_decode(file_get_contents('php://input'),true);
                $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
                $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
                if ($this->form_validation->run() == TRUE)
                {
                    $query = $this->db->select('mobile, password')->get_where('p2p_borrowers_list', array('mobile' => $this->input->post('mobile')));
                    if($this->db->affected_rows()>0)
                    {

                        $result = (array)$query->row();
                        if($result['password'] == $this->input->post('password'))
                        {
                            $msg = array(
                                "status"=>0,
                                "msg"=>"Your old password should not be current password",
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                                $response = $this->Commonapimodel->changePasswordborrower();
                                if($response)
                                {
                                    $msg = array(
                                        "status"=>1,
                                        "msg"=>$response,
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
                            }

                    }
                    else{
                        $query = $this->db->select('mobile, password')->get_where('p2p_lender_list', array('mobile' => $this->input->post('mobile')));
                        if($this->db->affected_rows()>0)
                        {
                            $result = (array)$query->row();
                            if($result['password'] == $this->input->post('password'))
                            {
                                $msg = array(
                                    "status"=>0,
                                    "msg"=>"Your old password should not be current password",
                                );
                                $this->set_response($msg, REST_Controller::HTTP_OK);
                                return;
                            }
                            else{
                                $response = $this->Commonapimodel->changePasswordlender();
                                if($response)
                                {
                                    $msg = array(
                                        "status"=>1,
                                        "msg"=>$response,
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
                            }

                        }
                        else{
                            $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
                            return;
                        }
                    }
                }
                else{
                        $errmsg = array("error_msg"=>validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }

            }

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;

    }

    public function bankaccountDetailsfunding_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false){
                $bankaccountDetailsfunding = $this->Requestmodel->bankaccountDetailsfunding();
                if($bankaccountDetailsfunding)
                {
                    $this->set_response($bankaccountDetailsfunding, REST_Controller::HTTP_OK);
                    return;
                }
                else{
                    $response = array(
                        'status'=>0,
                        'bank-account-details-funding'=>'Not found'
                    );
                    $this->set_response($response, REST_Controller::HTTP_OK);
                    return;
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }
}

?>
