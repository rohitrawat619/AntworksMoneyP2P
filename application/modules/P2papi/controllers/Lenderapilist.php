<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 class Lenderapilist extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model('Lenderactivitymodel');
     }

     public function lenderScreenlist_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                   $result = $this->Lenderactivitymodel->lenderScreenlist();
                     if($result)
                     {
                         $response = array(
                             'msg'=>"found",
                             'loan_type'=>$result
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
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function loanDetail_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'required');
                     $loan_details = $this->Lenderactivitymodel->currentLoandetails($lenderId);
                     if($loan_details)
                     {
                            $response = array(
                                'msg'=>"Found",
                                'loan_detail'=>$loan_details,
                            );
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                     }
                     else{
                         $response = array(
                             'err_msg'=>"Not Found",
                         );
                         $this->set_response($response, REST_Controller::HTTP_OK);
                         return;
                     }

                 }

             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function viewLoanaggrement_post()
     {
         error_reporting(0);
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
                     if ($this->form_validation->run() == TRUE) {
                         $this->load->model('loanaggrement/Loanaggrementmodel');

                         $result = $this->Loanaggrementmodel->loanaggrement();
                         if ($result) {
                                 $loan_amount = $result['APPROVERD_LOAN_AMOUNT'];
                                 $loan_amount_inword = $this->Loanaggrementmodel->convert_number_to_words($loan_amount);
                                 $loan_interest_rate = $result['LOAN_Interest_rate'];
                                 $loan_tenor = $result['TENORMONTHS'];
                                 $loan_time = $loan_tenor / 12;
                                 $loan_ir = $loan_interest_rate;

                                 $numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
                                 $denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
                                 $emi = ($numerator / $denominator);
                                 $table = "";
                                 $emi_balance = 0;
                                 for ($i = 1; $i <= $loan_tenor; $i++) {

                                     if ($i == 1) {
                                         $emi_sn[$i] = "Month " . $i;
                                         $emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
                                         $emi_principal[$i] = $emi - $emi_interest[$i];
                                         $emi_balance[$i] = $loan_amount - $emi_principal[$i];
                                     } else if ($i < 37) {
                                         $emi_sn[$i] = "Month " . $i;
                                         $emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
                                         $emi_principal[$i] = $emi - $emi_interest[$i];
                                         $emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
                                     } else if ($i >= 37) {
                                         break;
                                     }
                                     $day = date('j');
                                     if ($day >= 8) {

                                         $date = date('07/F/Y', strtotime('+' . $i . ' month'));
                                         //echo "<br>";
                                     } else {
                                         if ($i == 1) {
                                             $date = date('07/F/Y');
                                             //echo "<br>";
                                         } else {

                                             $date = date('07/F/Y', strtotime('+' . $i - 1 . ' month'));
                                             //echo "<br>";
                                         }

                                     }
                                     $table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>" . $date . "</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";

                                 }

                                 $data['result'] = $result;
                                 $data['table'] = $table;
                                 $data['loan_amount'] = $loan_amount;
                                 $data['loan_amount_inword'] = $loan_amount_inword;
                                 $data['html'] = "";
                                 $data['portal_name'] = 'www.antworksp2p.com';
                                 $data['today'] = date("d-m-Y");
                                 /////
                                 $data['agreement_date_time_stamp'] = $date = date('d/m/Y H:i:s', time());
                                 //d-m-Y format
                                 $data['agreement_date'] = date("d-m-Y");
                                 //


                                 $aggrement_result = $this->load->view('loan-aggrement-borrower', $data, true);
                                 $msg = array('status' => 1,
                                              'agreement' => $aggrement_result,
                                     );
                                 $msg = array("msg"=>$msg);
                                 $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         }
                         else{
                             $errmsg = array(
                                 'status'=>2,
                                 'err_msg'=>'Not Found',
                             );
                             $errmsg = array("error_msg"=>$errmsg);
                             $this->set_response($errmsg, REST_Controller::HTTP_OK);
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

     public function viewLoanaggrementcopy_post()
     {
         error_reporting(0);
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
                     if ($this->form_validation->run() == TRUE){
                         $this->load->model('loanaggrement/Loanaggrementmodel');

                         $result = $this->Loanaggrementmodel->loanaggrement();
                         if ($result) {
                             $loan_amount = $result['APPROVERD_LOAN_AMOUNT'];
                             $loan_amount_inword = $this->Loanaggrementmodel->convert_number_to_words($loan_amount);
                             $loan_interest_rate = $result['LOAN_Interest_rate'];
                             $loan_tenor = $result['TENORMONTHS'];
                             $loan_time = $loan_tenor / 12;
                             $loan_ir = $loan_interest_rate;

                             $numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
                             $denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
                             $emi = ($numerator / $denominator);
                             $table = "";
                             $emi_balance = 0;
                             for ($i = 1; $i <= $loan_tenor; $i++) {

                                 if ($i == 1) {
                                     $emi_sn[$i] = "Month " . $i;
                                     $emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
                                     $emi_principal[$i] = $emi - $emi_interest[$i];
                                     $emi_balance[$i] = $loan_amount - $emi_principal[$i];
                                 } else if ($i < 37) {
                                     $emi_sn[$i] = "Month " . $i;
                                     $emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
                                     $emi_principal[$i] = $emi - $emi_interest[$i];
                                     $emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
                                 } else if ($i >= 37) {
                                     break;
                                 }
                                 $day = date('j');
                                 if ($day >= 8) {

                                     $date = date('07/F/Y', strtotime('+' . $i . ' month'));
                                     //echo "<br>";
                                 } else {
                                     if ($i == 1) {
                                         $date = date('07/F/Y');
                                         //echo "<br>";
                                     } else {

                                         $date = date('07/F/Y', strtotime('+' . $i - 1 . ' month'));
                                         //echo "<br>";
                                     }

                                 }
                                 $table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>" . $date . "</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";

                             }

                             $data['result'] = $result;
                             $data['table'] = $table;
                             $data['loan_amount'] = $loan_amount;
                             $data['loan_amount_inword'] = $loan_amount_inword;
                             $data['html'] = "";
                             $data['portal_name'] = 'www.antworksp2p.com';
                             $data['today'] = date("d-m-Y");
                             /////
                             $data['agreement_date_time_stamp'] = $date = date('d/m/Y H:i:s', time());
                             //d-m-Y format
                             $data['agreement_date'] = date("d-m-Y");
                             //


                             $aggrement_result = $this->load->view('loan-aggrement-borrower', $data, true);
                             $msg = array('status' => 1,
                                 'agreement' => $aggrement_result,
                             );
                             $msg = array("msg"=>$msg);
                             $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         }
                         else{
                             $errmsg = array(
                                 'status'=>2,
                                 'err_msg'=>'Not Found',
                             );
                             $errmsg = array("error_msg"=>$errmsg);
                             $this->set_response($errmsg, REST_Controller::HTTP_OK);
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

     public function sendOtpsignature_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
                     if ($this->form_validation->run() == TRUE){
                         $otp = rand(100000,999999);
                         $this->load->model('Smssetting');
                         $setting = $this->Smssetting->smssetting();
                         $lenderInfo = $this->Lenderactivitymodel->lenderInfo($lenderId);
                         $this->db->select('*');
                         $this->db->from('p2p_lender_otp_signature');
                         $this->db->where('mobile', $lenderInfo['mobile']);
                         $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                         $this->db->where('date_added >= now() - INTERVAL 1 DAY');
                         $query = $this->db->get();
                         if($this->db->affected_rows()>0)
                         {
                             $result = count($query->result_array());
                             if($result>3)
                             {
                                 $errmsg = array("error_msg"=>"Your tried multiple times please try again");
                                 $this->set_response($errmsg, REST_Controller::HTTP_OK);
                                 return;
                             }
                             else{
                                 $arr["mobile"]=$lenderInfo['mobile'];
                                 $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                                 $arr["otp"]=$otp;
                                 $query = $this->db-> insert('p2p_lender_otp_signature',$arr);
                             }
                         }
                         else{
                             $arr["mobile"]=$lenderInfo['mobile'];
                             $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                             $arr["otp"]=$otp;
                             $query = $this->db-> insert('p2p_lender_otp_signature',$arr);
                         }

                         $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
                         $message = rawurlencode($msg);
                         $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $lenderInfo['mobile'], "sender" => $setting['sender'], "message" => $message);
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
                         $errmsg = array("error_msg"=>validation_errors());
                         $this->set_response($errmsg, REST_Controller::HTTP_OK);
                         return;
                     }

                 }

             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function verifyOtpsignature_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                     $this->form_validation->set_rules('otp', 'OTP', 'required');
                     if ($this->form_validation->run() == TRUE){
                       $bid_registration_id = $this->input->post('bid_registration_id');
                       $otp = $this->input->post('otp');
                       $res = $this->Lenderactivitymodel->verify_signature($lenderId, $bid_registration_id, $otp);
                       if($res)
                       {
                           $msg = array("msg"=>$res);
                           $this->set_response($msg, REST_Controller::HTTP_OK);
                           return;
                       }
                       else{
                           $errmsg = array("error_msg"=>"Please send otp first");
                           $this->set_response($errmsg, REST_Controller::HTTP_OK);
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

     public function uploadEsign_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('', '', 'required');
                     if ($this->form_validation->run() == TRUE){

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

     public function downloadNachform_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('', '', 'required');
                     if ($this->form_validation->run() == TRUE){

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

     public function uploadSignednachform_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('', '', 'required');
                     if ($this->form_validation->run() == TRUE){

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

     public function downloadSamplenachform_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('', '', 'required');
                     if ($this->form_validation->run() == TRUE){

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

     public function downloadNachaftersigned_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('', '', 'required');
                     if ($this->form_validation->run() == TRUE){

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

     public function lenderLedger_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
				   $_POST = json_decode(file_get_contents('php://input'), true);
				   if(!empty($_POST['start_date']) && !empty($_POST['end_date']))
				   {
					   $res = $this->Lenderactivitymodel->lender_ledgerinfo($lenderId);
					   if($res)
					   {
						   $msg = array("msg"=>$res);
						   $this->set_response($msg, REST_Controller::HTTP_OK);
						   return;
					   }
					   else{
						   $errmsg = array("error_msg"=>"No record found");
						   $this->set_response($errmsg, REST_Controller::HTTP_OK);
						   return;
					   }
				   }
				   else{
					   $res = $this->Lenderactivitymodel->lender_ledgerinfo($lenderId);
					   if($res)
					   {
						   $msg = array("msg"=>$res);
						   $this->set_response($msg, REST_Controller::HTTP_OK);
						   return;
					   }
					   else{
						   $errmsg = array("error_msg"=>"No record found");
						   $this->set_response($errmsg, REST_Controller::HTTP_OK);
						   return;
					   }
				   }

                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function bankDetails_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $res = $this->Lenderactivitymodel->lenderBankdetails($lenderId);
                     if($res)
                     {
                         $msg = array("msg"=>$res);
                         $this->set_response($msg, REST_Controller::HTTP_OK);
                         return;
                     }
                     else{
                         $errmsg = array("error_msg"=>"No record found");
                         $this->set_response($errmsg, REST_Controller::HTTP_OK);
                         return;
                     }

                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function addmoneytoEscrowoffline_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('transactionId', 'Transaction ID', 'required');
                     $this->form_validation->set_rules('transaction_type', 'Transaction Type', 'required');
                     $this->form_validation->set_rules('amount', 'Amount', 'required');
                     if ($this->form_validation->run() == TRUE){
                       $res = $this->Lenderactivitymodel->addmoneytoEscrowoffline($lenderId);
                       if($res)
                       {
                           $msg = array("msg"=>$res);
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

     public function createOrder_post()
     {
         //error_reporting(E_ALL);
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if ($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('amount', 'Amount', 'required');
                     if ($this->form_validation->run() == TRUE) {
                         require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
                         $api = new Api($api_key = 'rzp_live_Enngj7JFsebBze', $api_secret = 'RTrz2qr6HXtv2yBHGafPNYkw');
                         var_dump($api); exit;
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
 }
?>
