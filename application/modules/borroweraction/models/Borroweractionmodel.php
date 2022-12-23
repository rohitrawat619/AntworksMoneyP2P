<?php
class Borroweractionmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function takeliveproposal()
    {
        $this->db->select('proposal_id');
        $this->db->from('p2p_proposal_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('proposal_id', $this->input->post('proposal_id'));
        $this->db->where('bidding_status', '0');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $this->db->set('bidding_status', 1);
            $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->where('proposal_id', $this->input->post('proposal_id'));
            $this->db->update('p2p_proposal_details');
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function accept_bid_borrower()
    {
        $this->db->select('id');
        $this->db->from('p2p_loan_aggrement_signature');
        $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $this->db->select('id');
            $this->db->from('p2p_loan_aggrement_signature');
            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
            $this->db->where('borrower_acceptance','0');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                if($this->input->post('aggree'))
                {
                    $arr = array(
                        'borrower_acceptance'=>1,
                    );
                    $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                    $this->db->update('p2p_loan_aggrement_signature', $arr);
                    if($this->db->affected_rows()>0)
                    {
                        return true;
                    }
                    else{
                        return false;
                    }
                }

                if($this->input->post('reject'))
                {
                    $arr = array(
                        'borrower_acceptance'=>2,
                    );
                    $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                    $this->db->update('p2p_loan_aggrement_signature', $arr);
                    if($this->db->affected_rows()>0)
                    {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }
        else{
            if($this->input->post('aggree'))
            {
                $arr = array(
                    'bid_registration_id'=>$this->input->post('bid_registration_id'),
                    'borrower_acceptance'=>1,
                );
                $this->db->insert('p2p_loan_aggrement_signature', $arr);
                if($this->db->affected_rows()>0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }

            if($this->input->post('reject'))
            {
                $arr = array(
                    'bid_registration_id'=>$this->input->post('bid_registration_id'),
                    'borrower_acceptance'=>2,
                );
                $this->db->insert('p2p_loan_aggrement_signature', $arr);
                if($this->db->affected_rows()>0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }
        }

    }

    public function accept_borrower_signature()
    {
            if($this->input->post('aggree'))
            {
                $this->db->select('*');
                $this->db->from('p2p_loan_aggrement_signature');
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->where('borrower_signature', '0');
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = $query->row();
                    $this->db->set('borrower_signature', 1);
                    $this->db->set('borrower_signature_date', date('Y-m-d H:i:s'));
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
                 $this->db->where('borrowers_id', $this->session->userdata('borrower_id'));
                 $this->db->where('borrower_acceptance', '0');
                 $query = $this->db->get();
                 if($this->db->affected_rows()>0)
                 {
                     $this->db->set('borrower_acceptance', 2); // rejected
                     $this->db->set('borrower_acceptance_date', date('Y-m-d H:i:s')); // rejected Datetime
                     $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                     $this->db->update('p2p_loan_aggrement_signature');
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
					BPD.bid_registration_id AS bid_registration_id
					FROM p2p_bidding_proposal_details BPD
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id					
					
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

    public function getPrevoiusresponseapi($api_name)
    {
        $this->db->select('*');
        $this->db->from('p2p_borrower_api_response');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('api_name', $api_name);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function insertRequest($insert_request)
    {
        $this->db->insert('p2p_borrower_requests', $insert_request);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function updateName()
    {

        $this->db->set('name', strtoupper(str_replace('  ', ' ', $this->input->post('name'))));
        $this->db->where('id', $this->session->userdata('borrower_id'));
        $this->db->update('p2p_borrowers_list');
        if($this->db->affected_rows()>0)
        {
            return true;
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

    public function subscribedEmail()
    {
        $this->db->select('*');
        $this->db->from('p2p_subscribed_emails');
        $this->db->where('email', $this->input->post('email'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            $this->db->set('email', $this->input->post('email'));
            $this->db->insert('p2p_subscribed_emails');
            return true;
        }
    }

    public function addNewproposal()
	{
	   $this->load->model('Borrowermodel');
	   $plrn = $this->Borrowermodel->create_plnr_no();
	   $proposal = array(
	   	'PLRN'=>$plrn,
	   	'borrower_id'=>$this->session->userdata('borrower_id'),
	   	'p2p_product_id'=>$this->input->post('p2p_product_id'),
	   	'loan_amount'=>$this->input->post('loan_amount_borrower'),
	   	'min_interest_rate'=>$this->input->post('borrower_interest_rate'),
	   	'tenor_months'=>$this->input->post('tenor_borrower'),
	   	'loan_description'=>$this->input->post('borrower_loan_desc'),
	   	'bidding_status'=>1,
	   	'date_added'=>date('Y-m-d H:i:s'),
	   );
       $this->db->insert('p2p_proposal_details', $proposal);
       if($this->db->affected_rows()>0)
	   {
         return true;
	   }
       else{
         return false;
	   }
	}

	public function createLoanledger($loan_disbursement_id)
	{
		error_reporting(E_ALL);
		$loanLedger = array();
		$balance = 0;
		$query = $this->db->select('dld.date_created, dld.id AS disburse_loan_id, bpd.loan_no, dld.bid_registration_id, dld.approved_loan_amount, dld.loan_processing_charges, dld.loan_tieup_fee, dld.disburse_amount, dld.reference')
			->join('p2p_bidding_proposal_details bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
			->get_where('p2p_disburse_loan_details AS dld', array('dld.id' => $loan_disbursement_id));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$loanLedger['loan_no'] = $result['loan_no'];
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "Loan Disbursement",
					'reference' => $result['reference'],
					'debit' => $result['approved_loan_amount'],
					'credit' => "",
					'balance' => $result['approved_loan_amount'],
					'narration' => "",
				);
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "being Antworks Processing fee charged",
					'reference' => $result['reference'],
					'debit' => $result['loan_processing_charges'],
					'credit' => "",
					'balance' => $result['approved_loan_amount'] + $result['loan_processing_charges'],
					'narration' => "",
				);
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "being Processing fee recovered",
					'reference' => $result['reference'],
					'debit' => "",
					'credit' => $result['loan_processing_charges'],
					'balance' => $result['approved_loan_amount'],
					'narration' => "",
				);
				$query = $this->db->select('bed.id AS emi_id, SUBDATE(bed.emi_date,1) AS due_date, bed.emi_date,  bed.emi_amount, bed.emi_interest, bed.emi_principal, bed.emi_balance, bed.status, 
				                            eps.emi_payment_date,
				                            eps.referece')
					->join('p2p_emi_payment_details eps', 'ON eps.emi_id = bed.id', 'left')
					->get_where('p2p_borrower_emi_details as bed',
						array('bed.disburse_loan_id' => $result['disburse_loan_id'], 'bed.emi_date <=' => date('Y-m-d'))
					);
				if ($this->db->affected_rows() > 0) {
					$emi_details = $query->result_array();
					$balance = $result['approved_loan_amount'];
					foreach ($emi_details AS $emi_detail) {
						if ($emi_detail['status'] == 1) {

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['due_date'])),
								'particular' => "being interest charged",
								'reference' => "",
								'debit' => $emi_detail['emi_interest'],
								'credit' => "",
								'balance' => $balance += $emi_detail['emi_interest'],
								'narration' => "",
							);
							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Interest paid",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_interest'],
								'balance' => $balance -= $emi_detail['emi_interest'],
								'narration' => "",
							);
							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Loan repayment",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_principal'],
								'balance' => $balance -= $emi_detail['emi_principal'],
								'narration' => "",
							);
						} else {

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['due_date'])),
								'particular' => "being interest charged",
								'reference' => "",
								'debit' => $emi_detail['emi_interest'],
								'credit' => "",
								'balance' => $balance += $emi_detail['emi_interest'],
								'narration' => "",
							);
						}


					}
				}
			}

			return $loanLedger;
		}
	}

}
?>
