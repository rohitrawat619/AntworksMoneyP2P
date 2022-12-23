<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Borrowerrequest extends REST_Controller
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Smssetting', 'Borrowermodel', 'Borroweraddmodel', 'P2papi/P2psmsmodel'));
		$this->load->database();
	}

    public function changemobile_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {

                $borrowerId = $decodedToken->borrower_id;

                if($borrowerId)
                {
                    $this->load->model('P2psmsmodel');
                    $_POST = json_decode(file_get_contents('php://input'),true);
                    $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
                    $this->form_validation->set_rules('dob', 'dob', 'trim|required');

                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweraddmodel->changeMobile($borrowerId);

                        if($response)
                        {
                            $msg = array(
                                "status"=>1,
                                "msg"=>"Your Mobile number changed successfully",
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }

                        else
                        {
                            $msg = array(
                                "status"=>0,
                                "msg"=>"Something went wrong",
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
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

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

    }

    public function sendOtpMobile_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $_POST = json_decode(file_get_contents('php://input'),true);
                $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                if ($this->form_validation->run() == TRUE)
                {
                    $this->load->model('P2psmsmodel');
                    
                    $result = $this->P2psmsmodel->sentOtppassword();
                    if($result === true)
                    {
                        $setting = $this->Smssetting->smssetting();
                        $otp = rand(100000,999999);
                        $arr["mobile"]=$this->input->post('mobile');
                        $arr["date_added"]=date("Y-m-d H:i:s");
                        $arr["otp"]=$otp;
                        $query = $this->db-> insert('p2p_otp_password_table',$arr);
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

    public function mobileOTPverify_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false) {
                $this->load->model('P2psmsmodel');
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->form_validation->set_rules('mobile', 'mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');

                $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                if ($this->form_validation->run() == TRUE)
                {
                    $result = $this->Borroweraddmodel->verifyOtpMoblie();

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

    //Change Password
    public function sendOtpPassword_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId){
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                    if ($this->form_validation->run() == TRUE) {
                        $query = $this->db->select('mobile')->get_where('p2p_borrowers_list', array('id' => $borrowerId));
                        if($this->db->affected_rows()>0)
                        {
                           $result = (array)$query->row();
                           if($result['mobile'] == $this->input->post('mobile'))
                           {
                               
                               
                               $result = $this->P2psmsmodel->sentOtppassword();
                               if ($result === true) {
                                   $setting = $this->Smssetting->smssetting();
                                   $otp = rand(100000, 999999);
                                   $arr["mobile"] = $this->input->post('mobile');
                                   $arr["date_added"] = date("Y-m-d H:i:s");
                                   $arr["otp"] = $otp;
                                   $query = $this->db->insert('p2p_otp_password_table', $arr);
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
                               $response = array(
                                   'status' => 0,
                                   'msg' => 'Please check your mobile that you shared'
                               );
                               $this->set_response($response, REST_Controller::HTTP_OK);
                               return;
                           }
                        }
                        else{
                            $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
                            return;
                        }

                    } else {
                    $errmsg = array("error_msg" => validation_errors());
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    public function passwordOTPverify_post()
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
                    $result = $this->P2psmsmodel->verifyOtpPassword();

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

    public function changepassword_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {

                $borrowerId = $decodedToken->borrower_id;

                if($borrowerId)
                {
                    
                    $_POST = json_decode(file_get_contents('php://input'),true);
                    $this->form_validation->set_rules('password', 'Password', 'trim|required');
                    $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');


                    if ($this->form_validation->run() == TRUE)
                    {
                        $query = $this->db->select('password')->get_where('p2p_borrowers_list', array('id'=>$borrowerId));
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
                                $response = $this->P2psmsmodel->changePassword($borrowerId);
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

                    else{
                        $errmsg = array("error_msg"=>validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;

    }
    //End

    //change mobile request

    public function requestChangemobile_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'),true);
                    $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                    if ($this->form_validation->run() == TRUE){
                        
                        $result = $this->P2psmsmodel->requestmobileChangeborrowerOtp($borrowerId);
                        if($result === true)
                        {
                            $setting = $this->Smssetting->smssetting();
                            $otp = rand(100000,999999);
                            $arr["borrower_id"]=$borrowerId;
                            $arr["type"]='mobile';
                            $arr['request_data'] = json_encode(array(
                                'mobile'=>$this->input->post('mobile'),
                                'otp'=>$otp,
                            ));
                            $query = $this->db->insert('p2p_borrower_requests',$arr);
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
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    public function verifyChangemobile_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $this->load->model('P2psmsmodel');
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                    $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                    if ($this->form_validation->run() == TRUE){
                        $result = $this->P2psmsmodel->verifyChangemobileborrower($borrowerId);
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
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    //END
    public function requestChangeaddress_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('address1', 'Address', 'required');
                    $this->form_validation->set_rules('city', 'city', 'required');
                    $this->form_validation->set_rules('state_code', 'State Code', 'required');
                    $this->form_validation->set_rules('pincode', 'pincode', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $this->db->select('id')->get_where('p2p_borrower_requests', array('borrower_id'=>$borrowerId, 'status'=>'0'));
                        if($this->db->affected_rows()>0)
                        {
                            $errmsg = array("error_msg"=>"Change Request Already pending");
                            $this->set_response($errmsg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $address_array = array(
                                'borrower_id'=>$borrowerId,
                                'type'=>'address',
                                'request_data'=>file_get_contents('php://input'),
                            );
                            $this->db->insert('p2p_borrower_requests', $address_array);
                            if($this->db->affected_rows()>0)
                            {
                                $msg = array("msg"=>"Change Request added successfully");
                                $this->set_response($msg, REST_Controller::HTTP_OK);
                                return;
                            }
                            else{
                                $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
                                $this->set_response($errmsg, REST_Controller::HTTP_OK);
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
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    public function saveborrowerStep_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('current_step', 'Current Step', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $this->db->select('id')->get_where('p2p_borrower_current_step_app', array('borrower_id'=>$borrowerId));
                        if($this->db->affected_rows()>0)
                        {
                            $this->db->where('borrower_id', $borrowerId);
                            $this->db->set('current_step', $this->input->post('current_step'));
                            $this->db->where('p2p_borrower_current_step_app');
                            $msg = array("status"=>"1", "msg"=>"update successfully");
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $step_array = array(
                                'borrower_id'=>$borrowerId,
                                'current_step'=>$this->input->post('current_step'),
                            );
                            $this->db->insert('p2p_borrower_current_step_app', $step_array);
                            if($this->db->affected_rows()>0)
                            {
                                $msg = array("status"=>"1", "msg"=>"update successfully");
                                $this->set_response($msg, REST_Controller::HTTP_OK);
                                return;
                            }
                            else{
                                $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
                                $this->set_response($errmsg, REST_Controller::HTTP_OK);
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
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }

    public function getborrowerStep_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $query = $this->db->select('current_step')->get_where('p2p_borrower_current_step_app', array('borrower_id'=>$borrowerId));
                    if($this->db->affected_rows()>0)
                    {
                        $result = $query->row();

                        $msg = array("status"=>"1", "current_step"=>$result->current_step);
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $errmsg = array("status"=>0, "msg"=>"Not found");
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                        }


                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
    }
}

?>
