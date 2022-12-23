<?php
class Adminborrowermodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_borrower_details($borrower_id)
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
        $this->db->from('p2p_borrowers_list AS BL');
        $this->db->join('p2p_proposal_details AS PD', 'ON PD.borrower_id = BL.id', 'left');
        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
        $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
        $this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
        $this->db->where('BL.borrower_id', $borrower_id);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $borrower_details= $query->result_array();
            foreach($borrower_details AS $active_application)
            {
                $bids = array();
                $this->db->select('PDP.bid_registration_id,PDP.loan_no, PDP.proposal_id, BS.bid_status_name, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
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
                $this->db->join('p2p_bid_status AS BS', 'ON BS.bid_id = PDP.proposal_status', 'left');
                $this->db->join('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = PDP.bid_registration_id', 'left');
                $this->db->where('PDP.proposal_id', $active_application['proposal_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0) {
                    $bid_info = $query->result_array();

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
                            'bid_status_name'=>$bid['bid_status_name'],
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

                $borrower_all_info = array(
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


            return $borrower_all_info;
        }
        else{
            return false;
        }
    }

    public function get_count_borrowers()
    {
        return $this->db->count_all('p2p_borrowers_list');
    }

    public function getborrowers($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get('p2p_borrowers_list');
        return $query->result_array();
    }

}
?>