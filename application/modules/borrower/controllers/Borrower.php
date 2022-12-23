<?php
class Borrower extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrowermodelbackend');
        if($this->session->userdata('all_steps_complete') != 1)
        {
            redirect(base_url().'borrowerprocess/checking-steps/');
        }

    }

    public function index()
    {
        redirect(base_url().'borrower/dashboard');
    }

    public function dashboard()
    {
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['liveproposal'] = $this->Borrowermodelbackend->liveProposal();
            $data['livelender'] = $this->Borrowermodelbackend->liveLender();
            $data['totalbidrecieved'] = $this->Borrowermodelbackend->totalBidrecieved();
            $data['totalAvgintrestrate'] = $this->Borrowermodelbackend->totalAvgintrestrate();

            $data['pageTitle'] = "Dashboard";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('dashboard',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function list_my_proposal()
    {

        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['proposal'] = $this->Borrowermodelbackend->get_currentopen_proposal();
            if(empty($data['proposal']))
            {
                redirect(base_url().'borrower/live-listing');
            }
            $data['pageTitle'] = "List My Proposal";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('list-my-proposal',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function payment()
    {

        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['pageTitle'] = "Payment";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/process',$data);
            $this->load->view('payment',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function live_listing()
    {

        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['liveproposal'] = $this->Borrowermodelbackend->liveProposal();
            $data['livelender'] = $this->Borrowermodelbackend->liveLender();
            $data['totalbidrecieved'] = $this->Borrowermodelbackend->totalBidrecieved();
            $data['totalAvgintrestrate'] = $this->Borrowermodelbackend->totalAvgintrestrate();
            $data['currentproposelBids'] = $this->Borrowermodelbackend->currentproposelBids();
            $data['avrageInterstrate'] = $this->Borrowermodelbackend->avrageInterstrate();
            $data['proposal_info'] = $this->Borrowermodelbackend->get_currentactivate_proposal();
            $data['bidding_info'] = $this->Borrowermodelbackend->borrower_bidding_info();
			$data['total_likes'] = $this->Borrowermodelbackend->totalProposallikes($data['proposal_info']['proposal_id']);
			$data['total_views'] = $this->Borrowermodelbackend->totalProposalviews($data['proposal_info']['proposal_id']);
//            echo "<pre>";
//            print_r($data['proposal_info']); exit;
            $data['pageTitle'] = "Live Listing";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('live-listing',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function proposal_history()
    {

        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['all_proposal_info'] = $this->Borrowermodelbackend->get_all_proposal();

            $data['open_proposal_info'] = $this->Borrowermodelbackend->open_proposal_info();
            $data['closed_proposal_info'] = $this->Borrowermodelbackend->closed_proposal_info();
            $data['successfull_proposal_info'] = $this->Borrowermodelbackend->successfull_proposal_info();
            $data['partially_proposal_info'] = $this->Borrowermodelbackend->partially_proposal_info();
            $data['pageTitle'] = "Proposal History";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('proposal-history',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function loan_agreement_copies()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['aggrements'] = $this->Borrowermodelbackend->loan_agreement_copies();

            $data['pageTitle'] = "Loan Agreement Copies";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('loan-agreement-copies',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function pending_signature()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['approved_info'] = $this->Borrowermodelbackend->borrower_pendingsignature_loan();

            $data['pageTitle'] = "Pending Signature";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('pending-signature',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function kyc()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['kycDoctype'] = $this->Borrowermodelbackend->kycDoctype();
            $data['pageTitle'] = "KYC";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('kyc',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function ongoing_loan()
    {
        error_reporting(0);
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
			$data['loan_list'] = $this->Borrowermodelbackend->getOngoingloan();

            $data['pageTitle'] = "Ongoing Loan";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('loan/loan-list',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function closed_loan()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
			$data['loan_list'] = $this->Borrowermodelbackend->closedBorrowerloan();
            $data['pageTitle'] = "Closed Loan";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('loan/closed-loan',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function change_address()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {

            $this->load->model('Requestmodel');
            $data['current_address'] = $this->Borrowermodelbackend->getAdddress();
            $data['previous_request'] = $this->Borrowermodelbackend->previousRequestChengeaddress();
            $data['states'] = $this->Requestmodel->get_state();
            $data['pageTitle'] = "Address Change";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('change-address',$data);
            $this->load->view('template-borrower/footer',$data);
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function changeaddress()
    {
        if ( $this->session->userdata('borrower_state') == TRUE )
        {

           $result = $this->Borrowermodelbackend->updateAddress();
           if($result)
           {
               $msg="Your Address Change Request is submitted successfully. We shall update you shortly";
               $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
               redirect(base_url().'borrower/change-address');
           }
           else{
               $msg="OOPS! Something went wrong please check you credential and try again";
               $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
               redirect(base_url().'borrower/change-address');
           }
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function kyc_updation()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['doc'] = $this->Borrowermodelbackend->borrowerDoc();
            $data['pageTitle'] = "Kyc Updation";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('kyc-updation',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function make_payment()
    {

        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Make Payment";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('make-payment',$data);
            $this->load->view('template-borrower/footer',$data);

        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function closer_request()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Closer Request";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('closer-request',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function e_nach()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "E Nach";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('e-nach',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function payment_unsuccessful()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['title'] = 'payment Successful';
            $this->load->view('template-borrower/header',$data);
            //$this->load->view('template-borrower/nav',$data);
            
            $this->load->view('payment-unsuccessful',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function payment_successful()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['title'] = 'payment Successful';
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/process',$data);
            
            $this->load->view('payment-successful',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function escrow_account()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['title'] = 'payment Successful';
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('escrow-account',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function escrow_account_successful()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['title'] = 'payment Successful';
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/process',$data);
            $this->load->view('escrow-account-successful',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function escrow_account_unsuccessful()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['title'] = 'payment Successful';
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('escrow-account-unsuccessful',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function profile_pic()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Profile Picture Upload";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('photo-upload',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function profile_complete_thankyou()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Profile Picture Upload";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('profile-complete-thankyou',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function profile_details()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Profile Details";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('profile-details',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function banking_check()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Account Verification";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('banking-check',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function search_bank()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "Search Bank";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('search-bank',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function icici_bank()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "ICICI Bank";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('icici-bank',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function itr_details()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "ITR Details";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('itr-details',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function itr_details2()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "ITR Details";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('itr-details2',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function check_borrower_registration_payment()
    {
        $result = $this->Borrowermodelbackend->check_borrower_payment_registration();
        if($result)
        {
            return true;
        }
        else{
              redirect(base_url().'borrowerprocess/payment');
        }
    }

    public function checkborrowerSteps()
    {
        if ( $this->session->userdata('borrower_state') == TRUE ) {
            $result = $this->Borrowermodelbackend->check_p2p_process();
            if (in_array('0', $result)) {
                redirect(base_url() . 'borrowerprocess/checking-steps');
            } else {
                $data = array(
                    'all_steps_complete'=>1,
                );
                $this->session->set_userdata($data);

            }
        }
    }
}
?>
