<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
class Razorpayorder extends CI_Controller {
   public function __construct($api_key = 'rzp_test_HJfN2VNqrxSCTj', $api_secret = 'uYcilUOzg3tGviFzUWapubzO')
   {
       parent::__construct($api_key, $api_secret);

       $this->load->library('form_validation');
       $this->load->helper('form');
       $this->load->helper('AUTHORIZATION');
       return true;
   }


    public function index()
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
                        $api = new Api($api_key = 'rzp_test_HJfN2VNqrxSCTj', $api_secret = 'uYcilUOzg3tGviFzUWapubzO');
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
                        echo json_encode($msg); exit;
                    }
                    else{
                        $errmsg = array("error_msg"=>validation_errors());
                        echo json_encode($errmsg); exit;
                    }
                }
            }
        }


    }

    //Payment Response of funding payment
    public function paymentResponse()
    {

        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $lenderId = $decodedToken->lender_id;
                if($lenderId)
                {
                    $_POST = json_decode(file_get_contents("php://input"));
                    $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                    $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                    $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
                    if ($this->form_validation->run() == TRUE)
                    {

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
    public function createOrderidemiPayment()
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
                    $this->form_validation->set_rules('is_foreclosure', 'Amount', 'required');
                    if($this->input->post('is_foreclosure') == 'Y')
                    {
                        $this->form_validation->set_rules('foreclosure_amount', 'Foreclosure Amount', 'required');
                        $amount = $this->input->post('foreclosure_amount');
                        $is_foreclosure = 'Y';
                    }
                    else{
                        $this->form_validation->set_rules('emi_amount_to_pay', 'Emi Amount', 'required');
                        $amount = $this->input->post('emi_amount_to_pay');
                        $is_foreclosure = 'N';
                    }

                    if ($this->form_validation->run() == TRUE)
                    {

                        $api = new Api($api_key = 'rzp_test_pizKcSWowSM8zq', $api_secret = 'e7cUk7xrJhB5po3aqz5mFtSu');
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
                        echo json_encode($msg); exit;
                    }
                    else{
                        $errmsg = array("error_msg"=>validation_errors());
                        echo json_encode($errmsg); exit;
                    }
                }
            }
        }
    }

    //Payment response of EMI Payment
    public function paymentResponseEmi()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $_POST = json_decode(file_get_contents("php://input"));
                    $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                    $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                    $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
                    if ($this->form_validation->run() == TRUE)
                    {

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

    //Create Order for lender registration
    public function createOrderlenderRes()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $lenderId = $decodedToken->lender_id;
                if($lenderId)
                {
                    $lenderenrollmentFee = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'lender_enrollment'))->row();
                    $razorpay_keys = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_registration_api_keys'))->row();
                    $keys_array = json_decode($razorpay_keys->option_value, true);
                    if($keys_array['razorpay_Testkey']['status'] == 1)
                    {
                       $key_public = $keys_array['razorpay_Testkey']['key'];
                    }
                    else{
                        $key_public = $keys_array['razorpay_razorpay_Livekey']['key'];
                    }
                    $key_public = $keys_array['razorpay_Testkey']['key'];
                    $api = new Api($key_public, $api_secret = 'uYcilUOzg3tGviFzUWapubzO');
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
                    echo json_encode($msg); exit;

                }
            }
        }
    }

    //Payment Response of Lender Registration
    public function responseLenderres()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $lenderId = $decodedToken->lender_id;
                if($lenderId)
                {
                    $_POST = json_decode(file_get_contents("php://input"));
                    $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                    $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                    $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
                    if ($this->form_validation->run() == TRUE)
                    {

                    }
                    else{
                        $errmsg = array("error_msg" => validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }
        }

    }

    //Create Order for Borrower registration
    public function createOrderborrowerRes()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $borrowerenrollmentFee = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'borrower_registration_fee'))->row();
                    $razorpay_keys = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_registration_api_keys'))->row();
                    $keys_array = json_decode($razorpay_keys->option_value, true);
                    if($keys_array['razorpay_Testkey']['status'] == 1)
                    {
                        $key_public = $keys_array['razorpay_Testkey']['key'];
                    }
                    else{
                        $key_public = $keys_array['razorpay_razorpay_Livekey']['key'];
                    }
                    $key_public = $keys_array['razorpay_Testkey']['key'];
                    $api = new Api($key_public, $api_secret = 'uYcilUOzg3tGviFzUWapubzO');
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
                    echo json_encode($msg); exit;

                }
            }
        }
    }

    //Payment Response of Borrower registration
    public function responseBorrowerres()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $_POST = json_decode(file_get_contents("php://input"));
                    $this->form_validation->set_rules('razorpay_signature', 'Razorpay Signature', 'trim|required');
                    $this->form_validation->set_rules('razorpay_payment_id', 'Razorpay Payment ID', 'required');
                    $this->form_validation->set_rules('razorpay_order_id', 'Razorpay Order ID', 'required');
                    if ($this->form_validation->run() == TRUE)
                    {
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

}
?>
