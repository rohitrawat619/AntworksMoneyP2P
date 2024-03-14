<?php
class Masterkycmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        $query = $this->db->get_where('master_kyc');
        if ($this->db->affected_rows() > 0)
        {
          $results = $query->result_array();
          foreach ($results as $result)
          {
              $query = $this->db->order_by('id', 'desc')->get_where('borrower_pan_api_details', array('mobile' => $result['mobile']));
              if ($this->db->affected_rows() > 0)
              {
                  $pan_details = $query->row_array();
              }
              $query = $this->db->order_by('id', 'desc')->get_where('p2p_borrower_bank_res', array('mobile' => $result['mobile']));
              if ($this->db->affected_rows() > 0)
              {
                  $bank = $query->row_array();
              }
              $query = $this->db->order_by('id', 'desc')->get_where('aadhar_api_response', array('mobile' => $result['mobile']));
              if ($this->db->affected_rows() > 0)
              {
                  $aadhar = $query->row_array();
              }
              $response[] = array(
                  'created_date' => $result['created_date'],
                  'registered_name' => $result['name'],
                  'pan' => $pan_details['pan'],
                  'aadhar' => $pan_details['aadhar'],
                  'account_no' => $bank['account_no'],
                  'pan_registered_name' => $pan_details['name'],
                  'aadhar_registered_name' => $aadhar['aadhar_response_name'],
                  'bank_registered_name' => $bank['bank_registered_name'],
                  'aadhar_dob' => $aadhar['dob'],
                  'kyc_step' => $result['kyc_step'],
              );
          }
          return $response;
        }
        else{
            return false;
        }
    }
}