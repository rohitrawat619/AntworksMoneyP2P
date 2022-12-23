<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 class Lenderprofile extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model('Lenderactivitymodel');
     }

     public function personalInfo_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $this->db->select('PLL.lender_id, PLL.lender_escrow_account_number, 
                           PLL.name, PLL.mobile, PLL.email, PLL.dob, PLL.pan,                           
                           PLDT.father_name, PLDT.max_loan_preference, PLDT.max_interest_rate, PLDT.max_tenor, PLDT.investments                         
                           ');
                     $this->db->from('p2p_lender_list AS PLL');
                     $this->db->join('p2p_lender_details_table AS PLDT', 'PLL.user_id = PLDT.lender_id', 'left');
                     $this->db->where('PLL.user_id', $lenderId);
                     $query = $this->db->get();

                     if($this->db->affected_rows()>0)
                     {
                         $result =  (array)$query->row();
                         $this->set_response($result, REST_Controller::HTTP_OK);
                         return;

                     }
                     else
                     {
                         $errmsg = array("error_msg"=>"No Record Found");
                         $this->set_response($errmsg, REST_Controller::HTTP_OK);
                         return;
                     }
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function residentialInfo_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                   $query = $this->db->select('SE.state, PLA.city, PLA.address1, PLA.address2, PLA.pincode')
					        ->join('p2p_state_experien AS SE', 'ON SE.code = PLA.state', 'left')
                            ->get_where('p2p_lender_address AS PLA', array('lender_id'=>$lenderId));
                     if($this->db->affected_rows()>0)
                     {
                         $result =  (array)$query->row();
                         $this->set_response($result, REST_Controller::HTTP_OK);
                         return;

                     }
                     else
                     {
                         $errmsg = array("error_msg"=>"No Record Found");
                         $this->set_response($errmsg, REST_Controller::HTTP_OK);
                         return;
                     }
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function occupationalInfo_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                    $this->db->select('ODT.name AS occupation_name');
                    $this->db->from('p2p_lender_list AS LL');
                    $this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = LL.occupation');
                    $this->db->where('user_id', $lenderId);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $result =  (array)$query->row();
                        $res = array(
                            'occupation_name'=>$result['occupation_name'],
                            'willing_to_lend'=>1000000,
                            'income'=>50000,
                        );
                        $this->set_response($res, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $errmsg = array("error_msg"=>"No Record Found");
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }

                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function bankaccountInfo_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                    $query = $this->db->select('PLAI.bank_name,PLAI.branch_name,PLAI.account_number,PLAI.ifsc_code,PLAI.account_type')
                             ->get_where('p2p_lender_account_info AS PLAI', array('PLAI.lender_id'=>$lenderId))
                    ;
                 }
                 if($this->db->affected_rows()>0)
                 {
                     $result = (array)$query->row();
                     $this->set_response($result, REST_Controller::HTTP_OK);
                     return;
                 }
                 else{
                     $errmsg = array("error_msg"=>"No Record Found");
                     $this->set_response($errmsg, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function updateLenderprofile_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     if (isset($_FILES['selfiImage']))
                     {
                         $this->load->model('lenderaction/Lenderkycmodel');
                         $config['upload_path'] = "./assets/lender-documents";
                         $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                         $config['encrypt_name'] = TRUE;
                         $config['max_width'] = '0';
                         $config['max_height'] = '0';
                         $config['overwrite'] = TRUE;
                         $this->load->library('upload', $config);
                         if (isset($_FILES['selfiImage'])) {
                             if ($this->upload->do_upload("selfiImage")) {
                                 $data = $this->upload->data();
                                 $file_info = array(
                                     'lender_id' => $lenderId,
                                     'docs_type' => 'selfiImage',
//                                     'docs_no' => $this->input->post('doc_no'),
                                     'docs_name' => $data['file_name'],
                                     'date_added' => date('Y-m-d H:i:s'),
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

     public function updateBankaccount_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $this->load->model(array('lenderprocess/Lenderprocessmodel'));
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
                     $this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
                     $this->form_validation->set_rules('caccount_no', 'Conform account no', 'trim|required|matches[account_no]');
                     $this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'trim|required');
                     if ($this->form_validation->run() == TRUE) {

                         $msg = array(
                             "status" => 0,
                             "msg" => "You can't update verified account no"
                         );
                         $this->set_response($msg, REST_Controller::HTTP_OK);
                         return;

                         $data = json_encode(array(
                             "bank_acc_no"=>$this->input->post('account_no'),
                             "ifsc_code"=>$this->input->post('ifsc_code'),
                         ));

                         $curl = curl_init();

                         curl_setopt_array($curl, array(
                             CURLOPT_URL => "https://api.whatsloan.com/v1/ekyc/bankaccAuth",
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
                                 "token: ".WHATAPP_TOKEN.""
                             ),
                         ));

                         $response = curl_exec($curl);
                         $err = curl_error($curl);
//                         echo $response; exit;
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
                             if($res['status-code'] == 101){
                                 if($res['result']['bankTxnStatus'] == 1){
                                     $bank_data = array(
                                         'lender_id'=>$lenderId,
                                         'bank_name'=>$this->input->post('bank_name'),
                                         'account_number'=>$this->input->post('account_no'),
                                         'ifsc_code'=>$this->input->post('ifsc_code'),
                                         'is_verified'=>1,
                                     );
                                     $this->Lenderaddmodel->addaccount($bank_data);
                                     $api_response = array(
                                         'lender_id'=>$lenderId,
                                         'api_name'=>'bank',
                                         'response'=>$response,
                                     );
                                     $this->Lenderprocessmodel->saveApiResponse($api_response);
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
 }
?>
