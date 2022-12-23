<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Biddingapi extends REST_Controller{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model(array('bidding/Biddingmodel', 'Lenderactivitymodel'));
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function livebids_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //

                $lenderId = $decodedToken->lender_id;
                if ($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    if(isset($_POST['limit']) && isset($_POST['start']))
                    {
                        $bidlist = $this->Biddingmodel->proposal_list_app($_POST['p2p_product_id'], $_POST['limit'], $_POST['start']);
                        if($bidlist)
                        {
                            $this->set_response($bidlist, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array("status" => 0, "msg" => "No record found");
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                    }
                    else{
                        $msg = array("status" => 0, "msg" => "Please Set Pagination");
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

                }

            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function searchBid_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if ($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('b_borrower_id', 'Borrower ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $bidlist = $this->Biddingmodel->search_proposal_list();
                        if($bidlist)
                        {
                            //$msg = array("status" => 0, "msg" => "Please select file to upload");
                            $this->set_response($bidlist, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array("status" => 0, "msg" => "No records found");
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

    public function proposalInfo_post()
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
                    if ($this->form_validation->run() == TRUE){
                        $proposal_info = $this->Biddingmodel->proposalInfo();
                        if($proposal_info)
                        {
                            $this->set_response($proposal_info, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array("status" => 0, "msg" => "Please enter Borrower ID");
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

    public function acceptBid_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                //echo $lenderId; exit;
                if ($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('borrower_id', 'Borrower ID', 'required');
                    $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'required');
                    $this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
                    $this->form_validation->set_rules('interest_rate', 'Interest Rate', 'required');
                    $this->form_validation->set_rules('tenor', 'Tenor', 'required');
                    if ($this->form_validation->run() == TRUE){
                      $max_amount = $this->Biddingmodel->maximumBidamount();
                      if($this->input->post('loan_amount') <= $max_amount['option_value'])
                      {
                          $balance = $this->Lenderactivitymodel->getaccountBalance($lenderId);
                          $allow_to_bid_amount = $balance['account_balance']*$this->Biddingmodel->allow_to_bid_amount();
                          $lock = $this->Lenderactivitymodel->getLockamount($lenderId);
                          $allow_to_bid_amount_lock_amount = $allow_to_bid_amount - $lock['lock_amount'];
                          if($allow_to_bid_amount_lock_amount)
                          {
                              $response = $this->Lenderactivitymodel->accept_bid($lenderId);
                              $this->set_response($response, REST_Controller::HTTP_OK);
                              return;
                          }
                          else{
                              $errmsg = array("error_msg"=>"Sorry you do not have sufficient balance left to accept this bid. Please Top-up your Investment Account");
                              $this->set_response($errmsg, REST_Controller::HTTP_OK);
                              return;
                          }
                      }
                      else{
                          $errmsg = array("error_msg"=>"Loan Amount cannot be greater than ".$max_amount['option_value']."");
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

    public function addInvoice_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
//                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required|is_unique[p2p_lender_consumer_product_details.bid_registration_id]');
                    $this->form_validation->set_rules('invoice_no', 'Invoice No', 'required|is_unique[p2p_lender_consumer_product_details.invoice_no]');
                    $this->form_validation->set_rules('date_of_invoice', 'Date of Invoice', 'required');
                    $this->form_validation->set_rules('amount', 'Amount', 'required');
                    if ($this->form_validation->run() == TRUE){
                        if (isset($_FILES['invoice_image'])){
                            $config['upload_path'] = "./consumer-loan-doc";
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                            $config['encrypt_name'] = TRUE;
                            $config['max_width'] = '0';
                            $config['max_height'] = '0';
                            $config['overwrite'] = TRUE;
                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload("invoice_image")) {
                                $data = $this->upload->data();
                                $_POST['invoice_image'] = $data['file_name'];
                                $result = $this->Biddingmodel->addInvoice();
                                if($result)
                                {
                                    $response = array(
                                        'msg'=>"Invoice added successfully",
                                    );
                                    $this->set_response($response, REST_Controller::HTTP_OK);
                                    return;
                                }
                                else{
                                    $response = array(
                                        'err_msg'=>"OOPS! Something went wrong please check you credential and try again",
                                    );
                                    $this->set_response($response, REST_Controller::HTTP_OK);
                                    return;
                                }
                            } else {
                                $msg = array("status" => 0,
                                    "msg" => $this->upload->display_errors()
                                );
                                $this->set_response($msg, REST_Controller::HTTP_OK);
                                return;
                            }
                        }
                        else{
                            $result = $this->Biddingmodel->addInvoice();
                            if($result)
                            {
                                $response = array(
                                    'msg'=>"Invoice added successfully",
                                );
                                $this->set_response($response, REST_Controller::HTTP_OK);
                                return;
                            }
                            else{
                                $response = array(
                                    'err_msg'=>"OOPS! Something went wrong please check you credential and try again",
                                );
                                $this->set_response($response, REST_Controller::HTTP_OK);
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

    public function bidInformation_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $bid_info = $this->Biddingmodel->biddingInfo($lenderId);
                        if($bid_info)
                        {
                            $msg = array("msg"=>$bid_info);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"No record found!!");
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
        return;
    }

    public function getaccountBalance_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                        $this->load->model('Lenderactivitymodel');
                        $accountBalance = $this->Lenderactivitymodel->getaccountBalance($lenderId);
                        if($accountBalance)
                        {
                            $msg = array("msg"=>$accountBalance);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"No record found!!");
                            $this->set_response($errmsg, REST_Controller::HTTP_OK);
                            return;
                        }
                    }
                }
            }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
        return;
        }

    public function loanConfirmation_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        //$confirmation = $this->Lenderactivitymodel->loanConformation($lenderId);
                        $confirmation = "Loan Confirmed successfully";
                        if($confirmation)
                        {
                            $msg = array("msg"=>$confirmation);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
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
        return;
    }

    public function processingFee_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $processingFee = $this->Lenderactivitymodel->getpeocessingFee($lenderId);
                        if($processingFee)
                        {
                            $msg = array("processing_fee"=>$processingFee);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
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
        return;
    }

    public function processingFeepayLater_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $payLetter = array('status'=>'1', 'msg'=>'you can pay later');
                        if($payLetter)
                        {
                            $this->set_response($payLetter, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
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
        return;
    }

    public function processingFeeall_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $lenderId = $decodedToken->lender_id;
                if($lenderId) {
                    $processingFeeall = $this->Lenderactivitymodel->getpeocessingFeeall($lenderId);
                    if($processingFeeall)
                    {
                        $process_fee = array(
                            "processing_fee_all"=>$processingFeeall,
                            "unpaid_total_processing_fee"=>$this->Lenderactivitymodel->unpaidProcessingfee($lenderId),
                            "current_processing_fee"=>$this->Lenderactivitymodel->unpaidProcessingfee($lenderId),
                            "is_pay_later"=>1,
                        );
                        $this->set_response($process_fee, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $errmsg = array("error_msg"=>"OOPS! Something went wrong please check you credential and try again");
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
