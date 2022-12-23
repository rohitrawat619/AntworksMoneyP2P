<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
 class Borrowerrazarpay extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
		 $this->load->model('Requestmodel');
     }

     //Create Order for Borrower registration
     public function createOrderborrowerRes_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $borrowerId = $decodedToken->borrower_id;
                 if($borrowerId)
                 {
                     $borrowerenrollmentFee = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'borrower_registration_fee'))->row();
					 $result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
					 $keys = (json_decode($result_keys, true));
					 if($keys['razorpay_Testkey']['status'] == 1)
					 {
						 $api_key = $keys['razorpay_Testkey']['key'];
						 $api_secret = $keys['razorpay_Testkey']['secret_key'];

					 }
					 if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

						 $api_key = $keys['razorpay_razorpay_Livekey']['key'];
						 $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

					 }
					 $api = new Api($api_key, $api_secret);
                     $order = $api->order->create(array(
                             'amount' => $borrowerenrollmentFee->option_value*100,
                             'currency' => 'INR'
                         )
                     );
                     if($order->id)
                     {
                         $msg = array(
                             'msg'=>'found',
                             'order_id'=>$order->id,
                         );
                     }
                     else{
                         $msg = array(
                             'msg'=>'not found',
                             'order_id'=>'',
                         );
                     }
                     $this->set_response($msg, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     //Payment Response of Borrower registration
     public function responseBorrowerres_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $borrowerId = $decodedToken->borrower_id;
                 if($borrowerId)
                 {
                     $_POST = json_decode(file_get_contents("php://input"), true);
                     $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                     $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                     $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
                     if ($this->form_validation->run() == TRUE)
                     {
						 $result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
						 $keys = (json_decode($result_keys, true));
						 if($keys['razorpay_Testkey']['status'] == 1)
						 {
							 $api_key = $keys['razorpay_Testkey']['key'];
							 $api_secret = $keys['razorpay_Testkey']['secret_key'];

						 }
						 if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

							 $api_key = $keys['razorpay_razorpay_Livekey']['key'];
							 $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

						 }
                         $hasing_value = $this->input->post('razorpay_order_id')."|".$this->input->post('razorpay_payment_id');
                         $generated_signature = hash_hmac('SHA256',$hasing_value, $api_secret);
                         if ($generated_signature == $this->input->post('razorpay_signature')) {
                            $this->db->select('id')->get_where('p2p_borrower_steps', array('borrower_id'=>$borrowerId));
							if($this->db->affected_rows()>0)
							{
								$this->db->where('borrower_id', $borrowerId);
								$this->db->set('step_2', 1);
								$this->db->update('p2p_borrower_steps');
							}
							else{
								$this->db->set('borrower_id', $borrowerId);
								$this->db->set('step_2', 1);
								$this->db->insert('p2p_borrower_steps');
							}

							 $res = array(
								 'status'=>1,
								 'msg'=>'Your fee successfully added',
							 );
							 $this->set_response($res, REST_Controller::HTTP_OK);
							 return;
                         }
                         else{
							 $res = array(
								 'status'=>0,
								 'msg'=>'Oops! Payment for P2P Registration was unsuccessful. Please try again',
							 );
							 $this->set_response($res, REST_Controller::HTTP_OK);
							 return;
						 }
//                         echo $generated_signature; echo "\n";
//                         echo $this->input->post('razorpay_signature'); exit;

                         $attrbutes = array();
                         $api = new Api("rzp_test_HJfN2VNqrxSCTj", "uYcilUOzg3tGviFzUWapubzO");
                         $payment_response = array(
                             'razorpay_signature'  => $this->input->post('razorpay_signature'),
                             'razorpay_payment_id'  => $this->input->post('razorpay_payment_id') ,
                             'razorpay_order_id' => $this->input->post('razorpay_order_id')
                         );
                         echo "<pre>";
                         print_r($payment_response); exit;
                         $payment_result  = $api->utility->verifyPaymentSignature($payment_response);
                         echo "<pre>";
                         var_dump($payment_result);
                         exit;
                     }
                     else{
                         $errmsg = array("error_msg" => validation_errors());
                         $this->set_response($errmsg, REST_Controller::HTTP_OK);
                         return;
                     }
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

     //Create Order for EMI payment
     public function createOrderidemiPayment_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $borrowerId = $decodedToken->borrower_id;
                 if($borrowerId)
                 {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('emi_id', 'Emi ID', 'required');
                     $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                     $this->form_validation->set_rules('is_foreclosure', 'Should be Y N', 'required');
                     if($this->input->post('is_foreclosure') == 'Y')
                     {
                         $this->form_validation->set_rules('foreclusore_amount', 'Foreclosure Amount', 'required');
                         $amount = $this->input->post('foreclusore_amount');
                         $is_foreclosure = 'Y';
                     }
                     else{
                         $this->form_validation->set_rules('emi_amount_to_pay', 'Emi Amount', 'required');
                         $amount = $this->input->post('emi_amount_to_pay');
                         $is_foreclosure = 'N';
                     }

                     if ($this->form_validation->run() == TRUE)
                     {

						 $result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
						 $keys = (json_decode($result_keys, true));
						 if($keys['razorpay_Testkey']['status'] == 1)
						 {
							 $api_key = $keys['razorpay_Testkey']['key'];
							 $api_secret = $keys['razorpay_Testkey']['secret_key'];

						 }
						 if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

							 $api_key = $keys['razorpay_razorpay_Livekey']['key'];
							 $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

						 }
						 $api = new Api($api_key, $api_secret);
                         $order = $api->order->create(array(
                                 'amount'   => $amount*100,
                                 'currency' => 'INR',
                                 'receipt'  => ''.$this->input->post('emi_id').'|'.$this->input->post('bid_registration_id').'|'.$is_foreclosure,
                             )
                         );
                         if($order->id)
                         {
                             $msg = array(
                                 'msg'=>'found',
                                 'order_id'=>$order->id,
                             );
                         }
                         else{
                             $msg = array(
                                 'msg'=>'not found',
                                 'order_id'=>'',
                             );
                         }
                         $this->set_response($msg, REST_Controller::HTTP_OK);
                         return;
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

     //Payment response of EMI Payment
     public function paymentResponseEmi_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $borrowerId = $decodedToken->borrower_id;
                 if($borrowerId)
                 {
                     $_POST = json_decode(file_get_contents("php://input"), true);

                     $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                     $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                     $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');

					 $this->form_validation->set_rules('emiData[emi_id]', 'Emi ID', 'required');
					 $this->form_validation->set_rules('emiData[bid_registration_id]', 'Bid Registration ID', 'required');
					 $this->form_validation->set_rules('emiData[is_foreclosure]', 'Should be Y N', 'required');
					 if($_POST['emiData']['is_foreclosure'] == 'Y')
					 {
						 $this->form_validation->set_rules('emiData[foreclusore_amount]', 'Foreclosure Amount', 'required');
						 $amount = $_POST['emiData']['foreclusore_amount'];
						 $is_foreclosure = 'Y';
					 }
					 else{
						 $this->form_validation->set_rules('emiData[emi_amount_to_pay]', 'Emi Amount', 'required');
						 $amount = $_POST['emiData']['emi_amount_to_pay'];
						 $is_foreclosure = 'N';
					 }

                     if ($this->form_validation->run() == TRUE)
                     {
                         $res = array(
                             'status'=>1,
                             'msg'=>'Your EMI detail successfully added',
                         );
                         $this->set_response($res, REST_Controller::HTTP_OK);
                         return;
                     }
                     else{
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
