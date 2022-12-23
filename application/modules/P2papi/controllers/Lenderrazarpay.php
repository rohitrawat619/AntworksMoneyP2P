<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
 class Lenderrazarpay extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);
         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model('Lenderactivitymodel');
         $this->load->model('Requestmodel');
     }

     public function createFundingpaymentorder_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId)
                 {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('amount', 'Amount', 'required');
                     if ($this->form_validation->run() == TRUE)
                     {
						 $result_keys = $this->Requestmodel->getRazorpayFundingkeys();
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
                                 'amount' => $this->input->post('amount')*100,
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

	 public function responseFundingpaymentResponse_post()
	 {

		 $headers = $this->input->request_headers();
		 if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			 $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			 if ($decodedToken != false) {
				 $lenderId = $decodedToken->lender_id;
				 if ($lenderId) {
					 $_POST = json_decode(file_get_contents("php://input"), true);
					 $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
					 $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
					 $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
					 if ($this->form_validation->run() == TRUE) {
						 $result_keys = $this->Requestmodel->getRazorpayFundingkeys();
						 $keys = (json_decode($result_keys, true));
						 if ($keys['razorpay_Testkey']['status'] == 1) {
							 $api_key = $keys['razorpay_Testkey']['key'];
							 $api_secret = $keys['razorpay_Testkey']['secret_key'];

						 }
						 if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

							 $api_key = $keys['razorpay_razorpay_Livekey']['key'];
							 $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

						 }
						 $hasing_value = $this->input->post('razorpay_order_id') . "|" . $this->input->post('razorpay_payment_id');
						 $generated_signature = hash_hmac('SHA256', $hasing_value, $api_secret);
						 if ($generated_signature == $this->input->post('razorpay_signature')) {
							 $res = array(
								 'status' => 1,
								 'msg' => 'Your finding account successfully added',
							 );
							 $this->set_response($res, REST_Controller::HTTP_OK);
							 return;
						 } else {
							 $res = array(
								 'status' => 0,
								 'msg' => 'Invalid payment request',
							 );
							 $this->set_response($res, REST_Controller::HTTP_OK);
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

     //Create Order for lender registration
     public function createOrderlenderres_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId)
                 {
                     $lenderenrollmentFee = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'lender_enrollment'))->row();
					 $result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
					 $keys = (json_decode($result_keys, true));
					 if($keys['razorpay_Testkey']['status'] == 1)
					 {
						 $api_key = $keys['razorpay_Testkey']['key'];
						 $api_secret = $keys['razorpay_Testkey']['secret_key'];

					 }
					 if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

						 $api_key = $keys['razorpay_razorpay_Livekey']['key'];
						 $api_secret = $keys['razorpay_razorpay_Livekey']['key'];

					 }
					 $api = new Api($api_key, $api_secret);
                     $order = $api->order->create(array(
                             'amount' => $lenderenrollmentFee->option_value*100,
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

     //Payment Response of Lender Registration
     public function responseLenderres_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId)
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
							 $api_secret = $keys['razorpay_razorpay_Livekey']['key'];

						 }
                     	$hasing_value = $this->input->post('razorpay_order_id') . "|" . $this->input->post('razorpay_payment_id');
                        $generated_signature = hash_hmac('SHA256', $hasing_value, $api_secret);
                        if ($generated_signature == $this->input->post('razorpay_signature')) {
							$res = array(
								'status'=>1,
								'msg'=>'Your finding account successfully added',
							);
							$this->set_response($res, REST_Controller::HTTP_OK);
							return;
						}
                        else{
							$res = array(
								'status'=>0,
								'msg'=>'Sorry Invalid payment',
							);
							$this->set_response($res, REST_Controller::HTTP_OK);
							return;
						}

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

	 //Create Order for lender Processing FEE
	 public function createOrderlenderprocessingfee_post()
	 {
		 $headers = $this->input->request_headers();
		 if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			 $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			 if ($decodedToken != false) {
				 $lenderId = $decodedToken->lender_id;
				 if($lenderId)
				 {
				 	$_POST = json_decode(file_get_contents('php://input'), true);
                     $this->form_validation->set_rules('amount', 'Amount', 'required');
                     $this->form_validation->set_rules('is_total', 'Is total amount', 'required');
                     if($this->input->post('is_total') == 'N')
					 {
						 $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
					 }
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
						 $api = new Api($api_key, $api_secret);
						 $order = $api->order->create(array(
								 'amount' => $this->input->post('amount')*100,
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

	 //Response Lender Processing fee
	 public function responseLenderProcessingfee_post()
	 {
		 $headers = $this->input->request_headers();
		 if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			 $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			 if ($decodedToken != false) {
				 $lenderId = $decodedToken->lender_id;
				 if($lenderId)
				 {
					 $_POST = json_decode(file_get_contents("php://input"), true);
					 $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
					 $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
					 $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
					 $this->form_validation->set_rules('is_total', 'Is total processing fee', 'required');
					 if($this->input->post('is_total') == 'N')
					 {
						 $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
					 }
					 if ($this->form_validation->run() == TRUE)
					 {
						 $res = array(
							 'status'=>1,
							 'msg'=>'Your Processing fee paid successfully',
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
