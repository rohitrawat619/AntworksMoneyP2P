<?php
class Masterkycmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function list($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->order_by('id', 'desc')->get_where('master_kyc');
        if ($this->db->affected_rows() > 0)
        {
          $results = $query->result_array();
          foreach ($results as $result)
          {     $mobile_no = $result['mobile'];
            $iidd = $result['id'];
              $query = $this->db->order_by('id', 'desc')->get_where('borrower_pan_api_details', array('mobile' => $mobile_no));
              if ($this->db->affected_rows() > 0)
              {
                  $pan_details = $query->row_array();
              }else{
                $pan_details = "";
              }
              $query = $this->db->order_by('id', 'desc')->get_where('p2p_borrower_bank_res', array('mobile' => $mobile_no));
              if ($this->db->affected_rows() > 0)
              {
                  $bank = $query->row_array();
              }else{
                $bank = "-";
              }
              $query = $this->db->order_by('id', 'desc')->get_where('aadhar_api_response', array('mobile' => $mobile_no));
              if ($this->db->affected_rows() > 0)
              {
                  $aadhar = $query->row_array();
              }else{
                $aadhar = "";
              }

              $query = $this->db->order_by('id', 'desc')->get_where('p2p_borrower_bank_details', array('borrower_id' => $bank['borrower_id']));
              if ($this->db->affected_rows() > 0)
              {
                  $borrower_bank_detail = $query->row_array();
              }else{
                $borrower_bank_detail = "-";
              }
              $panJsonResponse = json_decode($pan_details['response'],true);
              $panNameMatchedStatus = $panJsonResponse['result']['name_match'];
             
              $bankAccount =  json_decode($bank['razorpay_response_bank_ac'],true);
                            $bankAccountStatus = $bankAccount['results']['account_status'];
            
                        if($panNameMatchedStatus && $borrower_bank_detail['is_verified']){
                            $type_of_kyc = "Half Kyc";
                        }else{
                            $type_of_kyc = "NA";
                        }

                            $response[] = array(
                  'id' => $result['id'],
                  'borrower_id' => $bank['borrower_id'],
                  'created_date' => $result['created_date'],
                  'registered_name' => $result['name'],
                  'pan' => $pan_details['pan'],
                  'aadhar' => $aadhar['aadhar_no'],
                  'account_no' => $bank['account_no'],
                  'pan_registered_name' => $pan_details['name'],
                  'panNameMatchedStatus' => $panNameMatchedStatus,
                  'aadhar_registered_name' => $aadhar['aadhar_response_name'],
                  'bank_registered_name' => $bank['bank_registered_name'],
                  'bank_ifsc_code' => $bank['ifsc_code'],
                  'bank_name' => $borrower_bank_detail['bank_name'],
                  'bank_is_verified' => $borrower_bank_detail['is_verified'],
                  'aadhar_dob' => $aadhar['dob'],
                  'registered_mobile' => $mobile_no,
                  'kyc_step' => $result['kyc_step'],
                  'bankAccountStatus' => $bankAccountStatus,
                  'type_of_kyc' => $type_of_kyc,
              );
              $result = "";
          }
          return $response;
        }
        else{
            return false;
        }
    }


    function listCount(){
        return $this->db->count_all('master_kyc'); 
    
    }
}