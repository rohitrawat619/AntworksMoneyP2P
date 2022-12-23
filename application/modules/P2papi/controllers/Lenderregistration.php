<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 class Lenderregistration extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model('Lenderaddmodel');
     }

     public function lenderAdd_post()
     {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $_POST = json_decode(file_get_contents('php://input'),true);
                 $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                 $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
                 $this->form_validation->set_rules('highest_qualification', 'Qualification', 'trim|required');
                 $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
                 $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                 $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
                 $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
                 $this->form_validation->set_rules('imei_no', 'IMEI No', 'required');
                 $this->form_validation->set_rules('mobile_token', 'Mobile Token', 'required');
                 $this->form_validation->set_rules('latitude', 'Latitude', 'required');
                 $this->form_validation->set_rules('longitude', 'Longitude', 'required');
                 $this->form_validation->set_rules('term_and_condition', 'Term and condition', 'required');
                 if ($this->form_validation->run() == TRUE)
                 {
                    $this->load->model('Lendermodel');
                    $_POST['andriod_app'] = TRUE;
                    $lender_response = $this->Lenderaddmodel->add_lender();
                    if($lender_response)
                    {
                        $msg = array(
                            "status"=>1,
                            "msg"=>"Lender Register Successfully",
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            "status"=>1,
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
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function updateAddress_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId)
                 {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('address1', 'address1', 'trim|required');
                     $this->form_validation->set_rules('state_code', 'State', 'trim|required');
                     $this->form_validation->set_rules('city', 'City', 'trim|required');
                     $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
                     if ($this->form_validation->run() == TRUE) {
                         $result = $this->Lenderaddmodel->udateAddress($lenderId);
                         if($result)
                         {
                             $msg = array(
                                 "status"=>1,
                                 "msg"=>"Address update successfully",
                             );
                             $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         }
                         else{
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

     public function updateOccupation_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId)
                 {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('occupation', 'occupation', 'trim|required');
                     $this->form_validation->set_rules('willing_to_lend', 'Willing to LEND', 'trim|required');
                     if ($this->form_validation->run() == TRUE) {
                         $result = $this->Lenderaddmodel->updateOccupation($lenderId);
                         if($result)
                         {
                             $msg = array(
                                 "status"=>1,
                                 "msg"=>"Occuption update successfully",
                             );
                             $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         }
                         else{
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

     public function updateKyc_post()
     {
         
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     if (isset($_FILES['pan_file']) || isset($_FILES['kyc_file']) || isset($_FILES['selfiImage']))
                     {
                         $this->load->model('lenderaction/Lenderkycmodel');
                         $config['upload_path'] = "./assets/lender-documents";
                         $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                         $config['encrypt_name'] = TRUE;
                         $config['max_width'] = '0';
                         $config['max_height'] = '0';
                         $config['overwrite'] = TRUE;
                         $this->load->library('upload', $config);
                         if (isset($_FILES['pan_file'])) {
                             if ($this->upload->do_upload("pan_file")) {
                                 $data = $this->upload->data();
                                 $file_info = array(
                                     'lender_id' => $lenderId,
                                     'docs_type' => 'pan',
                                     'docs_name' => $data['file_name'],
                                 );
                                 $this->Lenderkycmodel->insert_kyc_pan($file_info);
                             } else {
                                 $msg = array("status" => 0,
                                     "document_type" => "PAN",
                                     "msg" => $this->upload->display_errors()
                                 );
                                 $this->set_response($msg, REST_Controller::HTTP_OK);
                                 return;
                             }
                         }
                         if (isset($_FILES['kyc_file'])) {
//                             $this->form_validation->set_rules('doc_no', 'Document No', 'trim|required');
//                             $this->form_validation->set_rules('document_type', 'Document Type', 'trim|required');
                             if ($this->form_validation->run() == TRUE) {
                                 if ($this->upload->do_upload("kyc_file")) {
                                     $data = $this->upload->data();
                                     $file_info = array(
                                         'lender_id' =>$lenderId,
                                         'docs_type' => 'address_proof',
//                                         'docs_no' => $this->input->post('doc_no'),
                                         'docs_name' => $data['file_name'],

                                     );
                                     $this->Lenderkycmodel->insert_kyc_pan($file_info);
                                 } else {
                                     $msg = array("status" => 0,
                                         "document_type" => "KYC",
                                         "msg" => $this->upload->display_errors()
                                     );
                                     $this->set_response($msg, REST_Controller::HTTP_OK);
                                     return;
                                 }
                             }
                         }
                         if (isset($_FILES['selfiImage'])) {
                             if ($this->upload->do_upload("selfiImage")) {
                                 $data = $this->upload->data();
                                 $file_info = array(
                                     'lender_id' => $lenderId,
                                     'docs_type' => 'selfiImage',
//                                     'docs_no' => $this->input->post('doc_no'),
                                     'docs_name' => $data['file_name'],
                                 );
                                 $this->Lenderkycmodel->insert_kyc_pan($file_info);
                             } else {
                                 $msg = array("status" => 0,
                                     "document_type" => "Selfi",
                                     "msg" => $this->upload->display_errors()
                                 );
                                 $this->set_response($msg, REST_Controller::HTTP_OK);
                                 return;
                             }
                         }

                         $msg = array("status" => 1, "msg" => "File Upload successfully");
                         $this->set_response($msg, REST_Controller::HTTP_OK);
                         return;
                    }
                    else{
                        $msg = array("status" => 0, "msg" => "Please select a file to upload");
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function updateBank_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                 	$this->db->get_where('p2p_lender_steps', array('lender_id' => $lenderId, 'step_4' => 1));
                     if($this->db->affected_rows()>0)
					 {
						 $msg = array(
							 "status" => 1,
							 "msg" => "Bank account Already Updated"
						 );
						 $this->set_response($msg, REST_Controller::HTTP_OK);
						 return;
					 }

                     $this->load->model(array('lenderprocess/Lenderprocessmodel'));
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
                     $this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
                     $this->form_validation->set_rules('caccount_no', 'Conform account no', 'trim|required|matches[account_no]');
                     $this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'trim|required');
                     if ($this->form_validation->run() == TRUE) {
						 $lender_name = $this->db->select('name')->get_where('p2p_lender_list', array('user_id' => $lenderId))->row()->name;
						 $data = json_encode(
							 array(
								 "fund_account" => array(
									 "account_type" => 'bank_account',
									 "bank_account" => array(
										 "name" => $lender_name,
										 "ifsc" => $this->input->post('ifsc_code'),
										 "account_number" => $this->input->post('account_no'),
									 ),
								 ),
								 "amount" => "100",
								 "currency" => "INR",
								 "notes" => array(
									 "random_key_1" => "",
									 "random_key_2" => "",
								 ),
							 )
						 );
						 $curl = curl_init();
						 curl_setopt_array($curl, array(
							 CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations",
							 CURLOPT_RETURNTRANSFER => true,
							 CURLOPT_ENCODING => "",
							 CURLOPT_MAXREDIRS => 10,
							 CURLOPT_TIMEOUT => 30,
							 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							 CURLOPT_CUSTOMREQUEST => "POST",
							 CURLOPT_POSTFIELDS => $data,
							 CURLOPT_HTTPHEADER => array(
								 "cache-control: no-cache",
								 "content-type: application/json",
								 "authorization: Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v",
							 ),
						 ));
						 $response = curl_exec($curl);
						 $err = curl_error($curl);
						 curl_close($curl);
                         if ($err) {
                             $msg = array(
                                 "status" => 0,
                                 "msg" => "Somethign went wrong please try again"
                             );
                             $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         } else {
							 $res = json_decode($response, true);
							 $bank_res = array(
								 'lender_id' => $this->session->userdata('user_id'),
								 'fav_id' => $res['id'] ? $res['id'] : '',
								 'razorpay_response_bank_ac' => $response,
							 );
							 $this->db->insert('p2p_lender_bank_res', $bank_res);
                             if($res['id'])
							 {
								 $bank_data = array(
									 'lender_id'=>$lenderId,
									 'bank_name'=>$this->input->post('bank_name'),
									 'account_number'=>$this->input->post('account_no'),
									 'ifsc_code'=>$this->input->post('ifsc_code'),
									 'is_verified'=>0,
								 );
								 $this->Lenderaddmodel->addaccount($bank_data);
								 //Update Lender step
								 $this->db->where('lender_id', $lenderId);
								 $this->db->set('step_4', 1);
								 $this->db->update('p2p_lender_steps');
								 $msg = array(
									 "status" => 1,
									 "msg" => "Bank Account added successfully"
								 );
								 $this->set_response($msg, REST_Controller::HTTP_OK);
								 return;
							 }
                             else{
                                 $msg = array(
                                     "status" => 0,
                                     "msg" => "Incorrect information, please check your details"
                                 );
                                 $this->set_response($msg, REST_Controller::HTTP_OK);
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
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     public function getOccuptionfields_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('occupation', 'Occuption ID', 'required');
                     if ($this->form_validation->run() == TRUE) {
                         $this->load->model('Commonapimodel');
                         $result = $this->Commonapimodel->getOccuptionfields();
                         if($result){
                             $msg = array("msg" =>"found", "occupation_field_list"=>$result);
                             $this->set_response($msg, REST_Controller::HTTP_OK);
                             return;
                         }
                         else{
                             $errmsg = array("error_msg" => "Not Found");
                             $this->set_response($errmsg, REST_Controller::HTTP_OK);
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

 }
?>
