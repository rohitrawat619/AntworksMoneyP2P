<?php
defined('BASEPATH') or exit('No direct script access allowed');

class check_model extends CI_Model
{

    public function __construct()  // dated 11-Sep-2024
    {
        parent::__construct();
        $this->db = $this->load->database('', TRUE);
    }

    public function getNoOfLendersAvailInScheme($scheme_id) {
        $this->db->select('COUNT(*) as num_lenders');
        $this->db->from('p2p_lender_priority_queue');

        // add the conditions 
        $this->db->where('scheme_id', $scheme_id);
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->row()->num_lenders;
    }

    public function getLendersAvailInScheme($scheme_id){
        $this->db->select('*');
        $this->db->from('p2p_lender_priority_queue');

        // add the conditions 
        $this->db->where('scheme_id', $scheme_id); 
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getNoOfBorrowersAvailInScheme($scheme_id) {
        $this->db->select('COUNT(*) as num_borrowers');
        $this->db->from('p2p_borrower_priority_queue');

        // add the conditions 
        // $this->db->where('scheme_id', $scheme_id);
        $this->db->where('status', 1);
        $this->db->where('remaining_amount_needed > 0');

        $query = $this->db->get();
        return $query->row()->num_borrowers;
    }

    public function getborrowersAvailInScheme($scheme_id){
        $this->db->select('*');
        $this->db->from('p2p_borrower_priority_queue');

        // add the conditions 
        $this->db->where('status', 1);
        $this->db->where('remaining_amount_needed > 0');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateLenderAmount($lender_id, $new_rem_amount)
    {
        $data = array(
            'rem_amount' => $new_rem_amount,
        );
        $this->db->where('id', $lender_id);
        $this->db->update('p2p_lender_priority_queue', $data);
    }

    public function updateBorrowerAmount($borrower_id, $new_remaining_amount_needed, $borrowing_amount)
    {
        $data = array(
            'remaining_amount_needed' => $new_remaining_amount_needed,
            'borrowing_amount' => $borrowing_amount,
        );
        $this->db->where('id', $borrower_id);
        $this->db->update('p2p_borrower_priority_queue', $data);
    }
}
