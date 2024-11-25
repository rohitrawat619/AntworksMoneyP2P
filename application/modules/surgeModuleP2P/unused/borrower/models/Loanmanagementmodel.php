<?php

class Loanmanagementmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/////
	public function get_count_loan()
	{
		return $this->db->count_all_results('p2p_disburse_loan_details');
	}

	public function getOngoingloan($limit, $start)
	{
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name,
                           LL.name AS lender_name,
                           DLD.date_created AS disbursement_date,
                           DLD.id AS loan_disbursement_id
                          ');
		$this->db->from('p2p_disburse_loan_details AS DLD');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON DLD.bid_registration_id = BPD.bid_registration_id');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = DLD.borrower_id');
		$this->db->join('p2p_lender_list AS LL', 'ON LL.user_id = DLD.lender_id');
		$this->db->order_by('DLD.date_created', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}
				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$next_repay = $this->Next_Repay($result['loan_disbursement_id']);

				$loan_summary[] = array(
					'loan_disbursement_id' => $result['loan_disbursement_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_name' => $result['name'],
					'lender_name' => $result['lender_name'],
					'loan_no' => $result['loan_no'],
					'tenor_months' => $result['accepted_tenor'],
					'principal_outstanding' => $principalamount,
					'number_of_emi_serviced' => $number_of_emi_serviced,
					'emi_amount' => $emi_amount,
					'next_repay' => $next_repay,
					'disbursement_date' => date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		} else {
			return false;
		}
	}

	public function get_count_loan_due($where)
	{
		$query = $this->db->select("count(DISTINCT dld.id) as num_rows")
			->where('dld.loan_status', 0)
			->where('emi.status', 0)
			->where($where)
			->join('p2p_borrower_emi_details emi', 'on emi.disburse_loan_id = dld.id')
			->get_where('p2p_disburse_loan_details dld');
		$result = $query->row_array();
		return $result['num_rows'];

	}

	public function getOngoingloan_due($limit, $start, $where)
	{
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name,
                           LL.name AS lender_name,
                           dld.date_created AS disbursement_date,
                           dld.id AS loan_disbursement_id
                          ');
		$this->db->where('dld.loan_status', 0);
		$this->db->where('emi.status', 0);
		$this->db->where($where);
		$this->db->from('p2p_disburse_loan_details AS dld');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON dld.bid_registration_id = BPD.bid_registration_id', 'left');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = dld.borrower_id', 'left');
		$this->db->join('p2p_lender_list AS LL', 'ON LL.user_id = dld.lender_id', 'left');
		$this->db->join('p2p_borrower_emi_details AS emi', 'ON emi.id = dld.id', 'left');
		$this->db->group_by('dld.id');
		$this->db->order_by('DLD.date_created', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}
				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$next_repay = $this->Next_Repay($result['loan_disbursement_id']);

				$loan_summary[] = array(
					'loan_disbursement_id' => $result['loan_disbursement_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_name' => $result['name'],
					'lender_name' => $result['lender_name'],
					'loan_no' => $result['loan_no'],
					'tenor_months' => $result['accepted_tenor'],
					'principal_outstanding' => $principalamount,
					'number_of_emi_serviced' => $number_of_emi_serviced,
					'emi_amount' => $emi_amount,
					'next_repay' => $next_repay,
					'disbursement_date' => date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		} else {
			return false;
		}
	}

	public function number_of_emi_serviced($loan_disbursement_id)
	{
		$this->db->select('COUNT(id) AS number_of_emi_serviced');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('disburse_loan_id', $loan_disbursement_id);
		$this->db->where('status', '1');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result['number_of_emi_serviced'];
		} else {
			return false;
		}
	}

	public function Each_EMI_Amount($loan_disbursement_id)
	{
		$this->db->select('emi_amount');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('disburse_loan_id', $loan_disbursement_id);
		$this->db->limit('1');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result['emi_amount'];
		} else {
			return false;
		}
	}

	public function Next_Repay($loan_disbursement_id)
	{
		$this->db->select('emi_date');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('disburse_loan_id', $loan_disbursement_id);
		$this->db->where('status', '0');
		$this->db->order_by('id', 'asc');
		$this->db->limit('1');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return date('d-M-Y', strtotime($result['emi_date']));
		} else {
			return false;
		}
	}

	public function searchbyLoan($loanNo)
	{
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name,
                           LL.name AS lender_name,
                           DLD.date_created AS disbursement_date,
                           DLD.id AS loan_disbursement_id
                          ');
		$this->db->from('p2p_disburse_loan_details AS DLD');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON DLD.bid_registration_id = BPD.bid_registration_id');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = DLD.borrower_id');
		$this->db->join('p2p_lender_list AS LL', 'ON LL.user_id = DLD.lender_id');
		$this->db->order_by('DLD.date_created', 'desc');
		$this->db->where('BPD.loan_no', $loanNo);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}
				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$next_repay = $this->Next_Repay($result['loan_disbursement_id']);

				$loan_summary[] = array(
					'loan_disbursement_id' => $result['loan_disbursement_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_name' => $result['name'],
					'lender_name' => $result['lender_name'],
					'loan_no' => $result['loan_no'],
					'tenor_months' => $result['accepted_tenor'],
					'principal_outstanding' => $principalamount,
					'number_of_emi_serviced' => $number_of_emi_serviced,
					'emi_amount' => $emi_amount,
					'next_repay' => $next_repay,
					'disbursement_date' => date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		} else {
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
			foreach ($results as $result) {
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
					foreach ($emi_details as $emi_detail) {
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

	public function getTrailbalance($start_date, $end_date)
	{
		//OutStandingloans Trail Balance
		if (empty($start_date) && empty($end_date)) {
			$query = $this->db->select('SUM(loan_processing_charges) AS platform_fees')
				->get_where('p2p_disburse_loan_details');
			$result = (array)$query->row();

			$sum_outstanding_loans = $this->db->select('SUM(emi_principal) AS sum_outstanding_loans')->get_where('p2p_borrower_emi_details', array('status' => '0'))->row()->sum_outstanding_loans;
			$sum_outstanding_loans_interest = $this->db->select('SUM(emi_interest) AS sum_outstanding_loans_interest')->get_where('p2p_borrower_emi_details', array('emi_date <=' => date('Y-m-d'), 'status' => '0'))->row()->sum_outstanding_loans_interest;
			$sum_of_outstanding = $sum_outstanding_loans + $sum_outstanding_loans_interest;

			$trailbalance[] = array(
				'particular' => "Outstanding loans",
				'debit' => $sum_of_outstanding,
				'credit' => "",
			);

			$trailbalance[] = array(
				'particular' => "Lenders Dues",
				'debit' => "",
				'credit' => $sum_of_outstanding,
			);

			$trailbalance[] = array(
				'particular' => "Platform fees",
				'debit' => "",
				'credit' => $result['platform_fees'],
			);

			$trailbalance[] = array(
				'particular' => "platform_cash_balance",
				'debit' => $result['platform_fees'],
				'credit' => "",
			);
			return $trailbalance;

		} else {


			$query = $this->db->select('SUM(loan_processing_charges) AS platform_fees')
				->get_where('p2p_disburse_loan_details', array('date_created >= ' => $start_date, 'date_created <= ' => $end_date));
			$result = (array)$query->row();

			$sum_outstanding_loans = $this->db->select('SUM(emi_principal) AS sum_outstanding_loans')->get_where('p2p_borrower_emi_details', array('status' => '0', 'created_date >= ' => $start_date, 'created_date <= ' => $end_date))->row()->sum_outstanding_loans;
			$sum_outstanding_loans_interest = $this->db->select('SUM(emi_interest) AS sum_outstanding_loans_interest')->get_where('p2p_borrower_emi_details', array('emi_date <=' => date('Y-m-d'), 'status' => '0', 'created_date >= ' => $start_date, 'created_date <= ' => $end_date))->row()->sum_outstanding_loans_interest;
			$sum_of_outstanding = $sum_outstanding_loans + $sum_outstanding_loans_interest;

			$trailbalance[] = array(
				'particular' => "Outstanding loans",
				'debit' => $sum_of_outstanding,
				'credit' => "",
			);

			$trailbalance[] = array(
				'particular' => "Lenders Dues",
				'debit' => "",
				'credit' => $sum_of_outstanding,
			);

			$trailbalance[] = array(
				'particular' => "Platform fees",
				'debit' => "",
				'credit' => $result['platform_fees'],
			);

			$trailbalance[] = array(
				'particular' => "platform_cash_balance",
				'debit' => $result['platform_fees'],
				'credit' => "",
			);
			return $trailbalance;
		}

	}

	public function currentLoandetails($loanno)
	{
		$sql = "SELECT
					dld.id as disburse_loan_id,
					BL.borrower_id AS b_borrower_id,
					BL.name AS b_name,
					BL.email AS b_email,
					BL.mobile AS b_mobile,
					BL.pan AS b_pan,
					BAD.r_address AS b_address,
					BAD.r_address1 AS b_address1,
					BAD.r_city AS b_city,
					SE.state AS b_state,
					BAD.r_pincode AS b_pincode,
					LL.user_id AS lender_id,                    
					LL.lender_id AS l_lender_id,                    
					LL.name AS l_name,
					LL.pan AS l_pan,					
					LL.email AS l_email,
					LL.mobile AS l_mobile,
					BPD.bid_registration_id AS bid_registration_id,
					BPD.bid_loan_amount AS loan_amount,
					BPD.interest_rate,
					BPD.accepted_tenor
							
					FROM p2p_disburse_loan_details dld					
					LEFT JOIN p2p_bidding_proposal_details BPD
					ON BPD.bid_registration_id = dld.bid_registration_id					
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
					
					WHERE BPD.loan_no = '" . $loanno . "'
			";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			$loan = (array)$query->row();
			$emi_details = $this->db->order_by('id', 'asc')->get_where('p2p_borrower_emi_details', array('loan_id' => $loan['bid_registration_id']))->result_array();
			$loan_details = array(
				'disburse_loan_id' => $loan['disburse_loan_id'],
				'b_borrower_id' => $loan['b_borrower_id'],
				'b_name' => $loan['b_name'],
				'b_email' => $loan['b_email'],
				'b_mobile' => $loan['b_mobile'],
				'b_pan' => $loan['b_pan'],
				'b_address' => $loan['b_address'],
				'b_address1' => $loan['b_address1'],
				'b_city' => $loan['b_city'],
				'b_state' => $loan['b_state'],
				'b_pincode' => $loan['b_pincode'],
				'lender_id' => $loan['lender_id'],
				'l_lender_id' => $loan['l_lender_id'],
				'l_name' => $loan['l_name'],
				'l_pan' => $loan['l_pan'],
				'l_email' => $loan['l_email'],
				'l_mobile' => $loan['l_mobile'],
				'bid_registration_id' => $loan['bid_registration_id'],
				'loan_amount' => $loan['loan_amount'],
				'interest_rate' => $loan['interest_rate'],
				'accepted_tenor' => $loan['accepted_tenor'],
				'emi_details' => $emi_details,
			);
			return $loan_details;
		} else {
			return false;
		}
	}

	public function emiDetail($emi_id)
	{
		$query = $this->db->select("bed.*, epd.referece, epd.emi_payment_amount, epd.emi_payment_date, epd.emi_payment_mode, epd.remarks, epd.is_verified,
						   bpd.loan_no, bpd.p2p_sub_product_id, plr.status as loan_retraction_status, plr.extension_time")
			->join('p2p_emi_payment_details as epd', 'ON epd.emi_id = bed.id', 'left')
			->join('p2p_bidding_proposal_details as bpd', 'ON bpd.bid_registration_id = bed.loan_id', 'left')
			->join('p2p_loan_restructuring plr', 'on plr.loan_id = bed.disburse_loan_id', 'left')
			->get_where('p2p_borrower_emi_details as bed', array('bed.id' => $emi_id));
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function getForeclosurepayment($loanno)
	{
		$query = $this->db->select('bid_registration_id')
			->get_where('p2p_bidding_proposal_details', array('loan_no' => $this->input->post('loan_no')));
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$query = $this->db->select("SUM(emi_amount) as total_emi_amount")->having('total_emi_amount IS NOT NULL')->get_where('p2p_borrower_emi_details', array('loan_id' => $result->bid_registration_id, 'status' => 0));
			if ($this->db->affected_rows() > 0) {
				return $query->row()->total_emi_amount;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function generateloanaGGrement()
	{
		$sql = "SELECT
					BL.id AS borrower_id,
					BL.borrower_id AS b_borrower_id,
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
					
					WHERE BPD.loan_no='" . $this->input->post('loan_no') . "'
			";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function convert_number_to_words($number)
	{
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
			'18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
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
		$dd = "";
		if ($points) {
			$dd = $points . " Paise";
		}
		return $result . " " . $dd;
	}

	public function getDisbursementcase($datetime)
	{
		$query = $this->db->select('ll.user_id, ll.name as lender_name,  ll.email as lender_email')
			->join('p2p_lender_list ll', 'on ll.user_id = dld.lender_id')
			->join('lender_loan_preferences lp', 'on lp.lender_id = dld.lender_id')
			->group_by('dld.lender_id')
			->get_where('p2p_disburse_loan_details dld', array('dld.date_created >' => $datetime, 'lp.auto_investment' => 1));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$query = $this->db->select('bl.borrower_id, bpd.loan_no, bpd.interest_rate, bpd.accepted_tenor, dld.approved_loan_amount')
					->join('p2p_borrowers_list bl', 'on bl.id = dld.borrower_id')
					->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id')
					->get_where('p2p_disburse_loan_details dld', array('dld.date_created >' => $datetime, 'dld.lender_id' => $result['user_id']));
				if ($this->db->affected_rows() > 0) {
					{
						$loan_details = $query->result_array();
					}
				}
				$disburse_loan_details[] = array(
					'lender_id' => $result['user_id'],
					'lender_name' => $result['lender_name'],
					'lender_email' => $result['lender_email'],
					'loan_details' => $loan_details
				);
			}
			return $disburse_loan_details;
		}
	}

	public function getBidsfordisbursement()
	{
		$query = $this->db->select("ll.user_id, ll.name as lender_name, ll.mobile, ll.email")
							->join('p2p_bidding_proposal_details bpd', 'on las.bid_registration_id = bpd.bid_registration_id')
							->join('p2p_lender_list ll', 'on ll.user_id = bpd.lenders_id')
			                ->group_by('ll.user_id')
							->get_where('p2p_loan_aggrement_signature las', array('las.borrower_signature' =>1 , 'las.lender_signature' => 0, 'DATE(las.created_date)' => date('Y-m-d')));

		if ($this->db->affected_rows() > 0){
			$results =  $query->result_array();
			foreach ($results as $result){
				$query = $this->db->select("bl.borrower_id, bpd.loan_no, bpd.interest_rate, bpd.accepted_tenor, bpd.bid_loan_amount")
					->join('p2p_borrowers_list bl', 'on bl.id = bpd.borrowers_id')
					->join('p2p_loan_aggrement_signature las', 'on las.bid_registration_id = bpd.bid_registration_id')
					->get_where('p2p_bidding_proposal_details bpd', array('lenders_id' =>  $result['user_id'], 'las.borrower_signature' =>1 , 'las.lender_signature' => 0, 'DATE(las.created_date)' => date('Y-m-d')));
				if ($this->db->affected_rows() > 0) {
						$bid_details = $query->result_array();
				}
				$bidding_details[] = array(
					'user_id' => $result['user_id'],
					'lender_name' => $result['lender_name'],
					'email' => $result['email'],
					'mobile' => $result['mobile'],
					'loan_details' => $bid_details
				);
			}
			return $bidding_details;
		}
		else{
			return false;
		}
	}

	#good borrower bad borrower

	public function getGoodBadborrower()
	{
		 $this->db->select("BL.borrower_id AS B_Borrower_ID,
                            BL.name AS BorrowerName,
                            BL.email AS EMAIL,
                            BL.pan,
                            
                            IF(epd.id IS NULL, 'ND1', 'ND2') AS Borrower,
                            CASE
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=7)  THEN 'G1'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >7 AND DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <= 15) then 'G2'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >15 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=21) then 'G3'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >21 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=30) then 'G4'                              
                              END AS GoodBorrower,
                            CASE
                              WHEN (DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >30 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=60) then 'B1'
                              WHEN (DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >60 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=90) then 'B2'
                              WHEN DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >90 then 'B3'
                              
                              END AS BadBorrower, 
                            BL.created_date AS borrower_created_date                        
                          ");
		$this->db->from('p2p_borrower_emi_details AS bed');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = bed.borrower_id', 'left');
		//$this->db->join('p2p_borrower_emi_details AS bed', 'ON bed.borrower_id = BL.id', 'left');
		$this->db->join('p2p_emi_payment_details AS epd', 'ON epd.emi_id = bed.id', 'left');

		//$this->db->where('bed.emi_date <', date('Y-m-d'));
//		$this->db->where('BL.borrower_id', 'BR10004172');
		//$this->db->group_by('BL.id');
		$this->db->order_by('BL.id');
		return $query = $this->db->get();
	}


	/////
	public function sendRepaymentresponse()
	{
		$this->db->select('*');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('emi_sql_date<', date('Y-m-d'));

		$this->db->where_in('status', array('0', '2', '3'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function checkExist($emi_id, $charges_type)
	{
		$this->db->select('id');
		$this->db->from('p2p_borrower_bounce_details');
		$this->db->where('emi_id', $emi_id);
		$this->db->where('chrages_type', $charges_type);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateEmibounce($id, $emi_bounce_arr)
	{
		$this->db->where('id', $id);
		$this->db->update('p2p_borrower_bounce_details', $emi_bounce_arr);
		return true;
	}

	public function recordEmibounce($emi_bounce_arr)
	{
		foreach ($emi_bounce_arr as $emi_bounce) {
			$this->db->insert('p2p_borrower_bounce_details', $emi_bounce);
		}
		return true;
	}

	public function sendRepayment($filename)
	{

		$attched_file = FCPATH . "document/repayment/" . $filename;
		$this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
		$this->db->from('p2p_admin_email_setting');
		$this->db->where('status', 1);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$msg = "File For Repayment";
			$email_config = (array)$query->row();
			$this->load->library('email', $email_config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			$this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
			$this->email->to('dinesh.knmiet@gmail.com');
			$this->email->attach($attched_file);
			$this->email->subject('Repayment Files');
			$this->email->message($msg);
			if ($this->email->send()) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function lender_info($lender_id)
	{
		$this->db->select('*');
		$this->db->from('p2p_lender_list');
		$this->db->where('user_id', $lender_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function updateEmiresponse($data)
	{
		$this->db->set('status', 2);
		$this->db->where('id', $data['emi_no']);
		$this->db->update('p2p_borrower_emi_details');

		$this->db->select('*');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('id', $data['emi_no']);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$record = (array)$query->row();
			$current_BALANCE = $this->lender_ac_info($record['lender_id']);
			$total_amount = $current_BALANCE['account_balance'] + $data['amount'];
			$ledger_array = array(
				'lender_id' => $record['lender_id'],
				'type' => 'repayment',
				'loan_no' => $data['laon_no'],
				'emi_id' => $data['emi_no'],
				'title' => 'Loan Repayment',
				'reference_1' => $data['reference_1'],
				'credit' => $data['amount'],
				'amount' => $data['amount'],
				'balance' => $total_amount,
			);

			$this->db->insert('p2p_lender_statement_entry', $ledger_array);

			$this->db->set('account_balance', $total_amount);
			$this->db->where('lender_id', $record['lender_id']);
			$this->db->update('p2p_lender_main_balance');
			$ledger_array_borrower = array(
				'borrower_id' => $record['borrower_id'],
				'type' => 'repayment',
				'loan_no' => $data['laon_no'],
				'title' => 'Loan Repayment',
				'reference_1' => $data['reference_1'],
				'credit' => $data['amount'],
				'amount' => $data['amount'],
				'balance' => '',
			);

			$this->db->insert('p2p_borrower_statement_entry', $ledger_array_borrower);
		} else {
			return false;
		}


	}

	public function lender_ac_info($lender_id)
	{
		$this->db->select('account_balance');
		$this->db->from('p2p_lender_main_balance');
		$this->db->where('lender_id', $lender_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function loanstatement($loan_id)
	{
		$this->db->select('*');
		$this->db->from('p2p_lender_statement_entry');
		$this->db->where('loan_no', $loan_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {

				$this->db->select('*');
				$this->db->from('p2p_borrower_bounce_details');
				$this->db->where('emi_id', $result['emi_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$emi_result = $query->result_array();
				}
				$emi_details[] = array(
					'lender_id' => $result['lender_id'],
					'type' => $result['type'],
					'loan_no' => $result['loan_no'],
					'emi_id' => $result['emi_id'],
					'title' => $result['title'],
					'reference_1' => $result['reference_1'],
					'reference_2' => $result['reference_2'],
					'debit' => $result['debit'],
					'credit' => $result['credit'],
					'amount' => $result['amount'],
					'balance' => $result['balance'],
					'created_date' => $result['created_date'],
					'emi_bounce_details' => $emi_result ? $emi_result : '',
				);

			}
			return $emi_details;
		} else {
			return false;
		}
	}
}

?>
