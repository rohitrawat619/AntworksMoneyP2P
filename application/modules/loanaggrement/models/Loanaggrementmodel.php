<?php
class Loanaggrementmodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function loanaGGrement()
    {
        $sql = "SELECT
					BL.borrower_id AS BORROWER_REGISTRATIONID,
					BL.name AS BORROWERNAME,
					BL.email AS BORROWEREMAIL,
					BL.mobile AS BORROWERMOBILE,
					BL.dob AS BORROWERDOB,
					BL.pan AS BORROWERR_pan,
					BAD.r_address AS BORROWERR_Address,
					BAD.r_address1 AS BORROWERR_Address1,
					BAD.r_city AS BORROWERR_City,
					SE.state AS BORROWERR_State,
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
					BPD.loan_no,					
					BPD.accepted_tenor AS TENORMONTHS,
					BPD.bid_loan_amount AS APPROVERD_LOAN_AMOUNT,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					LAS.borrower_signature,
					LAS.lender_signature,
					LAS.borrower_signature_date,
					LAS.lender_signature_date
					FROM p2p_bidding_proposal_details BPD
					
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_state_experien  AS SE
					ON SE.code = BAD.r_state
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id					
					
					LEFT JOIN p2p_lender_list AS LL
					ON LL.user_id = BPD.lenders_id
					
					LEFT JOIN p2p_lender_address AS LA
					ON LA.lender_id = BPD.lenders_id
					
					LEFT JOIN p2p_loan_aggrement_signature AS LAS
					ON LAS.bid_registration_id = BPD.bid_registration_id
					
					WHERE BPD.bid_registration_id=".$this->input->post('bid_registration_id')."
			";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
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

    public function checkRestructuring($bid_registration_id)
	{
		$query = $this->db->select('bed.emi_principal, bed.emi_interest, lr.extension_time, bpd.interest_rate')
				->join('p2p_disburse_loan_details dld', 'on dld.bid_registration_id = bpd.bid_registration_id', 'left')
				->join('p2p_loan_restructuring lr', 'on lr.loan_id = dld.id', 'left')
				->join('p2p_borrower_emi_details bed', 'on bed.loan_id = bpd.bid_registration_id', 'left')
				->get_where('p2p_bidding_proposal_details bpd', array('bpd.bid_registration_id' => $bid_registration_id, 'lr.status' => 1));
		if($this->db->affected_rows()>0)
		{
			$result = (array)$query->row();
			$amout = $result['emi_principal'] + $result['emi_interest'];

			$final_amount = ($amout*(1 + (($result['interest_rate']/100) / 12))) ** (12 * $result['extension_time']);

			return array(
				'principal_amount' => $amout,
				'emi_interest' => ($amout * $result['interest_rate']) / (12 * 100)*2,
				'emi_amount' => $amout + ($amout * $result['interest_rate']) / (12 * 100)*2,
				'extension_time' => $result['extension_time'],
			);

		}
		else{
           return false;
		}
	}
}
?>
