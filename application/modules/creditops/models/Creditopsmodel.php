<?php
class Creditopsmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
    }

    public function get_application_details($plnr)
    {
        $this->db->select('PD.*, 
                           BL.name AS Borrowername, 
                           BL.borrower_id AS borrower_info_id,
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
                           PO.name AS Occuption_name,
                           PBP.loan_no,                           
                           PBP.proposal_status                  
                           ');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
        $this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->where('PLRN', $plnr);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();
            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id,PDP.loan_no, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PDP.proposal_status, PL.name AS Lendername
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
                            'loan_no'=>$bid['loan_no'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                            'bid_proposal_status'=>$bid['proposal_status'],
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
                    'loan_no'=>$active_application['loan_no'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'borrower_info_id'=>$active_application['borrower_info_id'],
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
                    'bid_proposal_status'=>$bid['proposal_status'],
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

    public function approval_pending_application()
    {
        $this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,PBP.loan_no,BL.email AS borrower_email, PBA.r_city,
        PBP.interest_rate AS accepted_interest_rate
        ');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = PBP.bid_registration_id', 'left');
        $this->db->where('(PD.bidding_status = 2 OR PD.bidding_status = 4)');
        $this->db->where('LAS.credit_ops_signature != 1');
		$this->db->order_by('PBP.bid_registration_id', 'desc');
        //$this->db->or_where('PD.bidding_status', 4);
        //$this->db->or_where('LAS.admin_acceptance', '0');
        $query = $this->db->get();

        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();
            foreach($active_applications AS $active_application)
            {
              $this->db->select('PDP.bid_registration_id, PDP.loan_no, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
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
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();
                    $bids = array();
                    foreach ($bid_info AS $bid)
                    {
                        $bids[$bid['bid_registration_id']] = array(
                            'bid_registration_id'=>$bid['bid_registration_id'],
                            'loan_no'=>$bid['loan_no'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                            'borrower_acceptance'=>$bid['borrower_acceptance'],
                            'borrower_signature'=>$bid['borrower_signature'],
                            'lender_signature'=>$bid['lender_signature'],
                            'credit_ops_signature'=>$bid['credit_ops_signature'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'loan_no'=>$active_application['loan_no'],
                    'accepted_interest_rate'=>$active_application['accepted_interest_rate'],
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
        $this->db->select('PD.*, BL.name AS Borrowername,PBP.interest_rate AS accepted_interest_rate, PBP.loan_no,PBP.proposal_status, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = PBP.bid_registration_id', 'left');
        $this->db->where('LAS.borrower_acceptance', '1');
        $this->db->where('LAS.borrower_signature', '1');
        $this->db->where('LAS.lender_signature', '1');
        $this->db->where('LAS.credit_ops_signature', '1');
        $this->db->order_by('PBP.bid_registration_id', 'desc');

        $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $active_applications = $query->result_array();

            foreach($active_applications AS $active_application)
            {
                $this->db->select('PDP.bid_registration_id,PDP.loan_no,PDP.proposal_status, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
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
                            'loan_no'=>$bid['loan_no'],
                            'proposal_id'=>$bid['proposal_id'],
                            'borrowers_id'=>$bid['borrowers_id'],
                            'lenders_id'=>$bid['lenders_id'],
                            'lender_name'=>$bid['Lendername'],
                            'bid_loan_amount'=>$bid['bid_loan_amount'],
                            'loan_amount'=>$bid['loan_amount'],
                            'bid_proposal_status'=>$bid['proposal_status'],
                        );
                    }
                }

                $active_all_applications[] = array(
                    'proposal_id'=>$active_application['proposal_id'],
                    'PLRN'=>$active_application['PLRN'],
                    'loan_no'=>$active_application['loan_no'],
                    'borrower_id'=>$active_application['borrower_id'],
                    'Borrowername'=>$active_application['Borrowername'],
                    'borrower_mobile'=>$active_application['borrower_mobile'],
                    'borrower_email'=>$active_application['borrower_email'],
                    'borrower_city'=>$active_application['r_city'],
                    'loan_amount'=>$active_application['loan_amount'],
                    'loan_purpose'=>$active_application['loan_purpose'],
                    'min_interest_rate'=>$active_application['min_interest_rate'],
                    'max_interest_rate'=>$active_application['max_interest_rate'],
                    'accepted_interest_rate'=>$active_application['accepted_interest_rate'],
                    'tenor_months'=>$active_application['tenor_months'],
                    'loan_description'=>$active_application['loan_description'],
                    'bidding_status'=>$active_application['bidding_status'],
                    'date_added'=>$active_application['date_added'],
                    'bid_proposal_status'=>$active_application['proposal_status'],
                    'bids_by_lender'=>  $bids,
                );
            }


            return $active_all_applications;
        }
        else{
            return false;
        }
    }

    public function accept_bid()
    {
        $this->db->select('BPD.*,LAS.borrower_acceptance,
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
        $this->db->from('p2p_bidding_proposal_details AS BPD');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = BPD.bid_registration_id', 'left');
        $this->db->where('BPD.bid_registration_id', $this->input->post('bid_registration_id'));
        $this->db->where('LAS.credit_ops_signature', '0');
        $this->db->where('LAS.borrower_acceptance', '1');
        $this->db->where('LAS.borrower_signature', '1');
        $this->db->where('LAS.lender_signature', '1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_status_array = array(
                'proposal_status'=>2,
				'processing_fee' => $this->input->post('processing_fee'),
            );
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->update('p2p_bidding_proposal_details', $bid_status_array);

            $acceptance_array = array(
                'credit_ops_signature'=>1,
                'credit_ops_signature_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->update('p2p_loan_aggrement_signature', $acceptance_array);

            if($this->db->affected_rows()>0)
            {
                return true;
            }
        }
        else{
            return false;
        }
    }

    public function loanaggrement()
    {
        $sql = "SELECT
					BL.name AS BORROWERNAME,
					BL.email AS BORROWEREMAIL,
					BL.mobile AS BORROWERMOBILE,
					BL.dob AS BORROWERDOB,
					BL.pan AS BORROWERR_pan,
					BAD.r_address AS BORROWERR_Address,
					BAD.r_address1 AS BORROWERR_Address1,
					BAD.r_city AS BORROWERR_City,
					PSE.state AS BORROWERR_State,
					BAD.r_pincode AS BORROWERR_Pincode,										
					BDT.aadhaar AS BORROWERR_aadhaar,
                    BDT.father_name AS BORROWERFATHERNAME,
                    
					LL.user_id AS user_id_lender,
					LL.name AS LENDER_fNAME,
					LL.dob AS LENDER_dob,
					LL.pan AS LENDER_PAN,
					LL.lender_id AS LENDER_ID,
					LL.email AS LENDER_email,
					LL.mobile AS LENDER_mobile,
					
					LA.state AS LENDER_state_code,
					LA.city AS LENDER_city,
					LA.address1 AS LENDER_address,
					LA.address2 AS LENDER_address1,					

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,					
					
					BPD.bid_loan_amount AS APPROVERD_LOAN_AMOUNT,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					BPD.accepted_tenor AS TENORMONTHS
					
					FROM p2p_bidding_proposal_details BPD
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id					
					
					LEFT JOIN p2p_state_experien AS PSE
					ON PSE.code = BAD.r_state
					
					LEFT JOIN p2p_lender_list AS LL
					ON LL.user_id = BPD.lenders_id
					LEFT JOIN p2p_lender_address AS LA
					ON LA.lender_id = BPD.lenders_id
					WHERE BPD.bid_registration_id=".$this->input->post('bid_registration_id')."
			";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function loanaggrementOLD()
    {
        $sql = "SELECT
					BL.name AS BORROWERNAME,
					BL.email AS BORROWEREMAIL,
					BL.mobile AS BORROWERMOBILE,
					BL.dob AS BORROWERDOB,
					BL.pan AS BORROWERR_pan,
					BAD.r_address AS BORROWERR_Address,
					BAD.r_address1 AS BORROWERR_Address1,
					BAD.r_city AS BORROWERR_City,
					BAD.r_state AS BORROWERR_State,
					BAD.r_pincode AS BORROWERR_Pincode,										
					BDT.aadhaar AS BORROWERR_aadhaar,
                    BDT.father_name AS BORROWERFATHERNAME,
                    BDT.accepted_tenor AS TENORMONTHS,
                    
					LL.user_id AS user_id_lender,
					LL.name AS LENDER_fNAME,
					LL.dob AS LENDER_dob,
					LL.pan AS LENDER_PAN,
					LL.lender_id AS LENDER_ID,
					LL.email AS LENDER_email,
					LL.mobile AS LENDER_mobile,
					
					LA.state AS LENDER_state_code,
					LA.city AS LENDER_city,
					LA.address1 AS LENDER_address,
					LA.address2 AS LENDER_address1,					

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,					
					
					BPD.bid_loan_amount AS APPROVERD_LOAN_AMOUNT,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
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
					FROM p2p_bidding_proposal_details BPD
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_loan_aggrement_signature AS LAS
					ON LAS.bid_registration_id = BPD.bid_registration_id					
					
					LEFT JOIN p2p_lender_list AS LL
					ON LL.user_id = BPD.lenders_id
					LEFT JOIN p2p_lender_address AS LA
					ON LA.lender_id = BPD.lenders_id
					WHERE BPD.bid_registration_id=".$this->input->post('bid_registration_id')."
			";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function experianCreditreport()
    {
        $this->db->select('*');
        $this->db->from('credit_score_query');
        $this->db->where('1 = 1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function getBankresponse()
    {
        $this->db->select('*');
        $this->db->from('p2p_borrowers_docs_table');
        $this->db->where('borrower_id', 1);
        $this->db->where('docs_type', 'bank_statement');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

}?>
