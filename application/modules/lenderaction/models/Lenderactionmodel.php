<?php
class Lenderactionmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function updatelenderescrow()
    {
        $lender_escrow_account = rand('ABCDEFGHIJKLMNOP');
        $this->db->set('lender_escrow_account_number', $lender_escrow_account);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_list');
        $this->db->set('step_3', 1);
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_steps');
        return true;
    }

    public function addaccount($bankdetails)
    {
        $this->db->insert('p2p_lender_account_info', $bankdetails);
        if($this->db->affected_rows()>0)
        {
            $this->db->set('step_4', 1);
            $this->db->where('lender_id', $this->session->userdata('user_id'));
            $this->db->update('p2p_lender_steps');

           return true;
        }
        else{
           return false;
        }
    }

    public function accept_bids()
    {
        if($this->input->post('aggree'))
        {
            $this->db->select('*');
            $this->db->from('p2p_bidding_proposal_details');
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->where('lenders_id', $this->session->userdata('user_id'));
            $this->db->where('lender_acceptance', '0');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = $query->row();
                $this->db->set('lender_acceptance', 1);
                $this->db->set('lender_acceptance_date', date('Y-m-d H:i:s'));
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->where('lenders_id', $this->session->userdata('user_id'));
                $this->db->update('p2p_bidding_proposal_details');
                return true;
            }
            else{
                return false;
            }
        }
    }

    public function accept_lender_signature()
    {
        if($this->input->post('aggree'))
        {
            $this->db->select('*');
            $this->db->from('p2p_loan_aggrement_signature');
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->where('lender_signature', '0');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = $query->row();
                $this->db->set('lender_signature', 1);
                $this->db->set('lender_signature_date', date('Y-m-d H:i:s'));
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->update('p2p_loan_aggrement_signature');
                return true;
            }
            else{
                return false;
            }
        }

        if($this->input->post('reject'))
        {
            $this->db->select('*');
            $this->db->from('p2p_loan_aggrement_signature');
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->where('lender_signature', '0');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $this->db->set('lender_signature', 2); // rejected
                $this->db->set('lender_signature_date', date('Y-m-d H:i:s')); // rejected Datetime
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->update('p2p_bidding_proposal_details');
                return true;
            }
            else{
                return false;
            }
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
					BAD.r_state AS BORROWERR_State,
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
					PD.tenor_months AS TENORMONTHS,
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

    public function convert_number_to_words($number) {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            "." . $words[$point / 10] . " " .
            $words[$point = $point % 10] : '';
        $dd="";
        if($points)
        {
            $dd = $points . " Paise";
        }
        return $result . " " . $dd;
    }

    public function changePassword()
    {
      $query = $this->db->select('user_id, password')->get_where('p2p_lender_list', array('user_id'=>$this->session->userdata('user_id')));
      if($this->db->affected_rows()>0)
      {
          $result = $query->row();
          if($result->password == $this->input->post('old_pwd'))
          {
              if($result->password == $this->input->post('pwd'))
              {
                  return 'Password should not be current password';
              }
              else{
                  $this->db->set('password', $this->input->post('pwd'));
                  $this->db->where('user_id', $this->session->userdata('user_id'));
                  $this->db->update('p2p_lender_list');
                  if($this->db->affected_rows()>0)
                  {
                      return 'Your password updated successfully';
                  }
                  else{
                      return 'OOPS! Something went wrong please check you credential and try again';
                  }
              }
          }
          else{
              return 'Old password not match||';
          }
      }
      else{
         return false;
      }
    }

    public function offlinePayment()
    {
        $offline_payment = array(
            "lender_id"=>$this->session->userdata('user_id'),
            "transactionId"=>$this->input->post('transactionId'),
            "transaction_type"=>$this->input->post('transaction_type'),
            "amount"=>$this->input->post('amount'),
            );
            $this->db->insert('lender_offline_payment_details', $offline_payment);
            if($this->db->affected_rows()>0)
            {
              return "Your payment added successfully please wait for admin approve";
            }
            else{
                return "OOPS! Something went wrong please check you credential and try again";
            }
    }
}
?>
