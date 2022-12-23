<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 class Lenderrequest extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model('Lenderactivitymodel');
         $this->load->model('P2psmsmodel');
         $this->load->model('Smssetting');
     }

     public function requestChangeaddress_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('address1', 'Address', 'required');
                     $this->form_validation->set_rules('city', 'city', 'required');
                     $this->form_validation->set_rules('state_code', 'State Code', 'required');
                     $this->form_validation->set_rules('pincode', 'pincode', 'required');
                     if ($this->form_validation->run() == TRUE){
                        $this->db->select('id')->get_where('p2p_lender_requests', array('lender_id'=>$lenderId, 'status'=>'0'));
                        if($this->db->affected_rows()>0)
                        {
                            $errmsg = array("error_msg"=>"Change Request Already pending");
                            $this->set_response($errmsg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $address_array = array(
                                'lender_id'=>$lenderId,
                                'type'=>'address',
                                'request_data'=>file_get_contents('php://input'),
                            );
                            $this->db->insert('p2p_lender_requests', $address_array);
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

     public function requestChangemobile_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'),true);
                     $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                     if ($this->form_validation->run() == TRUE){
                         $this->load->model('P2psmsmodel');
                         $this->load->model('Smssetting');
                         $result = $this->P2psmsmodel->changemobilesendOtp($lenderId);
                         if($result === true)
                         {
                             $setting = $this->Smssetting->smssetting();
                             $otp = rand(100000,999999);
                             $arr["lender_id"]=$lenderId;
                             $arr["type"]='mobile';
                             $arr['request_data'] = json_encode(array(
                                 'mobile'=>$this->input->post('mobile'),
                                 'otp'=>$otp,
                             ));
                             $query = $this->db->insert('p2p_lender_requests',$arr);
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
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $this->load->model('P2psmsmodel');
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                     $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                     if ($this->form_validation->run() == TRUE){
                         $result = $this->P2psmsmodel->verifyChangemobile($lenderId);
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

     public function orderRequest_get()
     {
         echo "He"; exit;
         $this->load->library('Razorpay');
         $response = $this->Razorpay->create(array(
             'receipt'         => 'order_rcptid_11',
             'amount'          => 50000,
             'currency'        => 'INR',
             'payment_capture' =>  '0'
         ));
        echo "<pre>";
        print_r($response); exit;
     }

     //Change Password
     public function sendOtpPassword_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                     if ($this->form_validation->run() == TRUE) {
                         $query = $this->db->select('mobile')->get_where('p2p_lender_list', array('user_id' => $lenderId));
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
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
                     $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                     if ($this->form_validation->run() == TRUE) {
                         $result = $this->P2psmsmodel->verifyOtpPassword();

                         if ($result === true) {
                             $response = array(
                                 'status' => 1,
                                 'msg' => 'OTP verified successfully'
                             );
                             $this->set_response($response, REST_Controller::HTTP_OK);
                             return;
                         }
                         if ($result == 2) {
                             $response = array(
                                 'status' => 0,
                                 'msg' => 'OTP Expired, Please Resend and try again'
                             );
                             $this->set_response($response, REST_Controller::HTTP_OK);
                             return;
                         }
                         if ($result == 3) {
                             $response = array(
                                 'status' => 0,
                                 'msg' => 'Your OTP is not verified please enter valid OTP'
                             );
                             $this->set_response($response, REST_Controller::HTTP_OK);
                             return;
                         }
                         if ($result === false) {
                             $response = array(
                                 'status' => 0,
                                 'msg' => 'Invalid Approch'
                             );
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
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function changepasswordLender_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
         {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false)
             {
                $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'),true);
                     $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
                     $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
                     $this->form_validation->set_rules('old_password', 'OLD Password', 'trim|required');
                     $this->form_validation->set_rules('password', 'Password', 'trim|required');
                     $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
                     if ($this->form_validation->run() == TRUE)
                     {
                         $query = $this->db->select('password')->get_where('p2p_lender_list', array('user_id'=>$lenderId));
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
                                 $response = $this->P2psmsmodel->changePasswordlender($lenderId);
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
 }
?>