<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Borrowerloan extends REST_Controller
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Borrowermodel', 'Borroweractivitymodel', 'bidding/Biddingmodel'));
		$this->load->database();
	}

	public function softApprovelloan_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                      $approve_amount = array(
                          'status'=>1,
                          'approve_loan_amount'=>10000
                      );
                        $this->set_response($approve_amount, REST_Controller::HTTP_OK);
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

    public function softApprovelloanaccept_post(){
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'trim|required|is_unique[p2p_loan_soft_approvel_amount.proposal_id]');
                    $this->form_validation->set_rules('approve_loan_amount', 'Amount', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $this->db->where('proposal_id', $this->input->post('proposal_id'));
                        $this->db->set('bidding_status', 1);
                        $this->db->set('date_added', date('Y-m-d H:i:s'));
                        $this->db->update('p2p_proposal_details');
                        if($this->db->affected_rows()>0)
                        {
                            $approve_amount = array(
                                'msg'=>'Thanks for accepting loan!',
                                'status'=>1,
                            );
                            $this->set_response($approve_amount, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $approve_amount = array(
                                'msg'=>'You have already accepted this loan!',
                                'status'=>1,
                            );
                            $this->set_response($approve_amount, REST_Controller::HTTP_OK);
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

    public function myLoanlist_get()
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
                    $response = $this->Borroweractivitymodel->get_myloan($borrowerId);
                    if($response)
                    {
                        $msg = array(
                            'status'=>1,
                            'myloan'=>$response
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            'status'=>0,
                            'myloan'=>'Not found'
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function myLoanDetails_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweractivitymodel->get_myloanDetails($borrowerId);
                        if($response)
                        {
                            $msg = array(
                                'status'=>1,
                                'myloanDetails'=>$response
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array(
                                'status'=>0,
                                'myloanDetails'=>'Not found'
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
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

    public function loanagreementPdf_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweractivitymodel->get_loanagreementPdf($borrowerId);
                        if($response)
                        {
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $this->set_response($response, REST_Controller::HTTP_OK);
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

    public function downloadNoc_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweractivitymodel->get_loanagreementPdf($borrowerId);
                        if($response)
                        {
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $this->set_response($response, REST_Controller::HTTP_OK);
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

    public function myloanStatement_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('loan_no', 'Loan NO', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweractivitymodel->get_loanStatement($borrowerId);

                        if($response)
                        {
                            $this->set_response($response, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array(
                                'status'=>0,
                                'MyloanStatement'=>'Not found'
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
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

    public function sendOtpsignature_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $this->load->model('Borrowerinfomodel');
                        $otp = rand(100000,999999);
                        $this->load->model('Smssetting');
                        $setting = $this->Smssetting->smssetting();
                        $borrowerInfo = $this->Borrowerinfomodel->get_personalDetails($borrowerId);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_otp_signature');
                        $this->db->where('mobile', $borrowerInfo['mobile']);
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
                                $arr["mobile"]=$borrowerInfo['mobile'];
                                $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                                $arr["otp"]=$otp;
                                $query = $this->db-> insert('p2p_borrower_otp_signature',$arr);
                            }
                        }
                        else{
                            $arr["mobile"]=$borrowerInfo['mobile'];
                            $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                            $arr["otp"]=$otp;
                            $query = $this->db-> insert('p2p_borrower_otp_signature',$arr);
                        }

                        $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
                        $message = rawurlencode($msg);
                        $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $borrowerInfo['mobile'], "sender" => $setting['sender'], "message" => $message);
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
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'required');
                    $this->form_validation->set_rules('otp', 'OTP', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $bid_registration_id = $this->input->post('bid_registration_id');
                        $otp = $this->input->post('otp');
                        $res = $this->Borroweractivitymodel->verify_signature($borrowerId, $bid_registration_id, $otp);
                        if($res)
                        {

                            $this->set_response($res, REST_Controller::HTTP_OK);
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

    public function getcurrentLoan_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $proposalInfo = $this->Biddingmodel->proposalInfoapi();
                        if($proposalInfo)
                        {
                            $this->set_response($proposalInfo, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"Something went wrong");
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

    public function loanConfirmation_post()
    {

        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {

                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('proposal_id', 'Proposal ID', 'required');
                    if ($this->form_validation->run() == TRUE){
                        $confirmation = "Loan Confirmed successfully";
                        if($confirmation)
                        {
                            $msg = array("msg"=>$confirmation);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg"=>"Something went wrong");
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

    public function viewLoanaggrement_post()
    {
        error_reporting(0);
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $this->load->model('loanaggrement/Loanaggrementmodel');
                        $result = $this->Loanaggrementmodel->loanaggrement();
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
                        $errmsg = array("error_msg" => validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function emiPayment_post()
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
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('emi_id', 'EMI ID', 'trim|required');
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration ID', 'trim|required');
                    if ($this->form_validation->run() == TRUE)
                    {
                        $response = $this->Borroweractivitymodel->getEmidetailstopay($borrowerId);
                        if($response)
                        {
                            $msg = array(
                                'status'=>1,
                                'myloanDetails'=>$response
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $msg = array(
                                'status'=>0,
                                'myloanDetails'=>'Not found'
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
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

    public function estimatedTime_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('bid_registration_id', 'Bid Registration Id', 'required');
                    if ($this->form_validation->run() == TRUE){

                        $estimate_time = array(
                            'status'=>1,
                            "estimated_time"=>'01:00',
                            'is_disburse'=>1,
                        );
                        $this->set_response($estimate_time, REST_Controller::HTTP_OK);
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

    public function checkBorrowerCurrentproposal_get()
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
                    $response = $this->Borroweractivitymodel->checkCurrentproposal($borrowerId);

                       $this->set_response($response, REST_Controller::HTTP_OK);
                       return;


                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function uploadInvoice_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $borrowerId = $decodedToken->borrower_id;
                if ($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('date_of_invoice', 'Date of Invoice', 'required');
                    $this->form_validation->set_rules('invoice_no', 'invoice_no', 'required');
                    $this->form_validation->set_rules('amount', 'Amount', 'required');
                    if ($this->form_validation->run() == TRUE){

                        $invoice_data = array(
                            "borrower_id"=>$borrowerId,
                            'date_of_invoice'=>$this->input->post('date_of_invoice'),
                            "invoice_no"=>$this->input->post('invoice_no'),
                            'amount'=>$this->input->post('amount'),
                        );
                        $this->db->insert('p2p_borrower_invoice', $invoice_data);
                        if($this->db->affected_rows()>0)
                        {
                          $res = array(
                              'status'=>1,
                              'msg'=>'Invoice Added Successfully'
                          );
                        }
                        else{
                            $res = array(
                                'status'=>0,
                                'msg'=>'Invoice not add'
                            );
                        }
                        $this->set_response($res, REST_Controller::HTTP_OK);
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

}

?>
