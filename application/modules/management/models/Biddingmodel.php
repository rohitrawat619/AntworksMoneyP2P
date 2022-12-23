<?php 

class Biddingmodel extends CI_Model{
	
    private $u_primary_key='u_id';

	public function __construct(){
		
	    $this->load->database();
	}
	
	public function profile() {

		$rid = $this->session->userdata('user_id');
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('user_id',$rid);
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function approved()
	{
		$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL
			";
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function approved_bidding_view($proposal_id)
	{
		$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE BPD.proposal_id='$proposal_id' AND ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL
			";
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

}