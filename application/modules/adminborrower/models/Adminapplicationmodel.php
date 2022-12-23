<?php
class Adminapplicationmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_active_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->where_in('bidding_status', array('1', '4'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $bids = array();
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();

                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                );
            }

            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function get_application_details($plnr)
    {
        $this->db->select('PD.*, 
                           BL.name AS Borrowername, 
                           BL.mobile AS borrower_mobile,
                           BL.email AS borrower_email,
                           BL.dob AS dob,
                           BL.gender AS gender,
                           BL.marital_status AS marital_status,
                           BL.occuption_id,
                           PBA.r_address,
                           PBA.r_address1,
                           PBA.r_state,
                           PBA.r_city,
                           PBA.r_pincode,
                           PQ.qualification,
                           PO.name AS Occuption_name                           
                           ');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
        $this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
        $this->db->where('PLRN', $plnr);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();
            foreach($active_applications AS $active_application)
            {
                $bids = array();
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();

                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $occuption_detials = array();

                if($active_application['occuption_id'] = 1)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_salaried_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 2)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_self_business_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 3)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_self_professional_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 4)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_retired_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 5)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_student_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 6)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_homemaker');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 7)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_others');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }

                $kyc_document = array();

                $this->db->select('*');
                $this->db->from('p2p_borrowers_docs_table');
                $this->db->where('borrower_id', $active_application['borrower_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $kyc_document = $query->result_array();
                }

                $active_all_applications = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_dob'=>$active_application['dob'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_gender'=>$active_application['gender'],
                    'marital_status'=>$active_application['marital_status'],
                    'borrower_qualification'=>$active_application['qualification'],
                    'Occuption_name'=>$active_application['Occuption_name'],
                    'r_address'=>$active_application['r_address'],
                    'r_address1'=>$active_application['r_address1'],
                    'borrower_city'=>$active_application['r_city'],
                    'r_state'=>$active_application['r_state'],
                    'r_pincode'=>$active_application['r_pincode'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                    'occuption_details'=>  $occuption_detials?$occuption_detials:'',
                    'borrower_kyc_document'=>  $kyc_document,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function getBankresponse($borrower_id)
    {
        $sql = "SELECT * FROM p2p_borrowers_docs_table WHERE borrower_id = ".$borrower_id." AND (docs_type = 'bank_statement' OR docs_type = 'Online_bank_statement') ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function approval_pending_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->where('PD.bidding_status', 1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id, 
                                   PDP.proposal_id, 
                                   PDP.borrowers_id, 
                                   PDP.lenders_id, 
                                   PDP.bid_loan_amount, 
                                   PDP.loan_amount, 
                                   PDP.interest_rate,
                                   PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();
                    $bids = array();
                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function partially_approve_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->where('PD.bidding_status', 4);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();
                    $bids = array();
                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function approved_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city,
                                LAS.borrower_acceptance,
                                LAS.admin_signature,					
                                LAS.admin_signature_date,
                                LAS.borrower_signature,
                                LAS.borrower_signature_date,
                                LAS.credit_ops_manager_signature,
                                LAS.credit_ops_manager_signature_date,
                                LAS.credit_ops_signature,
                                LAS.credit_ops_signature_date,
                                LAS.lender_signature,
                                LAS.lender_signature_date');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBP.bid_registration_id', 'left');
        $this->db->where('LAS.borrower_signature', 1);
        $this->db->where('LAS.lender_signature', 1);
        $this->db->where('LAS.credit_ops_signature', 1);
        $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername,
                                 LAS.borrower_acceptance,
                                LAS.admin_signature,					
                                LAS.admin_signature_date,
                                LAS.borrower_signature,
                                LAS.borrower_signature_date,
                                LAS.credit_ops_manager_signature,
                                LAS.credit_ops_manager_signature_date,
                                LAS.credit_ops_signature,
                                LAS.credit_ops_signature_date,
                                LAS.lender_signature,
                                LAS.lender_signature_date
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PDP.bid_registration_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $this->db->where('LAS.borrower_signature', 1);
                $this->db->where('LAS.lender_signature', 1);
                $this->db->where('LAS.credit_ops_signature', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();
                    $bids = array();
                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function approved_application_details($plnr)
    {
        $this->db->select('PD.*, 
                           BL.name AS Borrowername, 
                           BL.mobile AS borrower_mobile,
                           BL.email AS borrower_email,
                           BL.dob AS dob,
                           BL.gender AS gender,
                           BL.marital_status AS marital_status,
                           BL.occuption_id,
                           PBA.r_address,
                           PBA.r_address1,
                           PBA.r_state,
                           PBA.r_city,
                           PBA.r_pincode,
                           PQ.qualification,
                           PO.name AS Occuption_name                           
                           ');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
        $this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
        $this->db->where('PLRN', $plnr);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();
            foreach($active_applications AS $active_application)
            {
                $bids = array();
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $this->db->where('PDP.borrower_signature', 1);
                $this->db->where('PDP.borrower_acceptance', 1);
                $this->db->where('PDP.admin_acceptance', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();

                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $occuption_detials = array();

                if($active_application['occuption_id'] = 1)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_salaried_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 2)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_self_business_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 3)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_self_professional_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 4)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_retired_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 5)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_student_details');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 6)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_homemaker');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }
                if($active_application['occuption_id'] = 7)
                {
                    $this->db->select('*');
                    $this->db->from('p2p_borrower_others');
                    $this->db->where('borrower_id', $active_application['borrower_id']);
                    $query = $this->db->get();
                    if($this->db->affected_rows()>0)
                    {
                        $occuption_detials = (array)$query->row();
                    }
                }

                $kyc_document = array();

                $this->db->select('*');
                $this->db->from('p2p_borrowers_docs_table');
                $this->db->where('borrower_id', $active_application['borrower_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $kyc_document = $query->result_array();
                }

                $active_all_applications = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_dob'=>$active_application['dob'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_gender'=>$active_application['gender'],
                    'marital_status'=>$active_application['marital_status'],
                    'borrower_qualification'=>$active_application['qualification'],
                    'Occuption_name'=>$active_application['Occuption_name'],
                    'r_address'=>$active_application['r_address'],
                    'r_address1'=>$active_application['r_address1'],
                    'borrower_city'=>$active_application['r_city'],
                    'r_state'=>$active_application['r_state'],
                    'r_pincode'=>$active_application['r_pincode'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                    'occuption_details'=>  $occuption_detials?$occuption_detials:'',
                    'borrower_kyc_document'=>  $kyc_document,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function rejected_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->where('PD.bidding_status', 3);
        $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
                $this->db->from('p2p_bidding_proposal_details AS PDP');
                $this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();
                    $bids = array();
                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bids_by_lender'=>  $bids,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function send_toescrow_infromation()
    {
        $this->db->select('BPD.*,PLL.lender_escrow_account_number, BBD.ifsc_code,
         BBD.account_number, BL.name AS borrower_name, ADD.r_city, PLL.name AS sender_name, PLL.mobile AS sender_reciever_info');
        $this->db->from('p2p_bidding_proposal_details AS BPD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
        $this->db->join('p2p_borrower_bank_details AS BBD', 'ON BBD.borrower_id = BPD.borrowers_id', 'left');
        $this->db->join('p2p_lender_list AS PLL', 'ON PLL.user_id = BPD.lenders_id', 'left');
        $this->db->join('p2p_borrower_address_details AS ADD', 'ON ADD.borrower_id = BPD.borrowers_id', 'left');
        $this->db->where('proposal_status', 2);
        $this->db->where('send_to_escrow', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }
	public test(){
		echo 'test';
	}
}
?>