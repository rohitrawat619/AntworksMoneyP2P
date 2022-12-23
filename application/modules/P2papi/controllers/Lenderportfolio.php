<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
 class Lenderportfolio extends REST_Controller{

     public function __construct($config = 'rest')
     {
         parent::__construct($config);

         $this->load->library('form_validation');
         $this->load->helper(array('form', 'url'));
         $this->load->model(array('Lenderactivitymodel', 'Lenderportfoliomodel'));
     }

     public function loanBook_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $data['total_amount_invested'] = $this->Lenderportfoliomodel->total_amount_invested($lenderId);
                     $data['total_principal_outstanding'] = $this->Lenderportfoliomodel->total_principal_outstanding($lenderId);
                     $data['total_principal_recieved'] = $this->Lenderportfoliomodel->total_principal_recieved($lenderId);
                     $data['total_principal_delayed'] = $this->Lenderportfoliomodel->total_principal_delayed($lenderId);
                     $data['total_interest_recieved'] = $this->Lenderportfoliomodel->total_interest_recieved($lenderId);
                     //$data['total_other_payment_recieved'] = $this->Lenderportfolio->total_other_payment_recieved();
                     $data['total_no_of_loans'] = $this->Lenderportfoliomodel->total_no_of_loans($lenderId);
                     $data['total_no_of_closed_loans'] = $this->Lenderportfoliomodel->total_no_of_closed_loans($lenderId);
                     $this->set_response($data, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function composition_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $data['termResult'] = $this->Lenderportfoliomodel->termResult($lenderId);
                     $this->set_response($data, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function details_get()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $data['past_due_30_89days'] = $this->Lenderportfoliomodel->past_due_30_89days($lenderId);
                     $data['past_due_90_180days'] = $this->Lenderportfoliomodel->past_due_90_180days($lenderId);
                     $data['past_due_plus_180days'] = $this->Lenderportfoliomodel->past_due_plus_180days($lenderId);
                     $this->set_response($data, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }

     public function loanSummary_post()
     {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $_POST = json_decode(file_get_contents('php://input'), true);
                     if(isset($_POST['limit']) && isset($_POST['start'])) {
                         $data['loan_summary'] = $this->Lenderportfoliomodel->loan_summary($lenderId, $_POST['limit'], $_POST['start']);
                         $this->set_response($data, REST_Controller::HTTP_OK);
                         return;
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
         return;
     }

     public function accountSummary_get()
     {
         error_reporting(0);
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) {
                 //
                 $lenderId = $decodedToken->lender_id;
                 if($lenderId) {
                     $data['loan_summary'] = $this->Lenderportfoliomodel->accountSummary($lenderId);
                     $this->set_response($data, REST_Controller::HTTP_OK);
                     return;
                 }
             }
         }
         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
         return;
     }
 }
?>