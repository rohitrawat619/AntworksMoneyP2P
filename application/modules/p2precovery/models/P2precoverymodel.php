<?php

class P2precoverymodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

////////////////////////////////////////



	public function getEmilist_due()
	{
		$this->db->where('emi_sql_date <', date('Y-m-d'));
		$result = $this->db->count_all_results('p2p_borrower_emi_details');

		if ($this->db->affected_rows() > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function getLast_week()
	{
		error_reporting(0);
		// $today = date("d/F/Y");
		//echo $today;exit;
		$this->db->where('emi_sql_date >', date('Y-m-d', strtotime('-7 days')));
		$this->db->where('emi_sql_date <', date('Y-m-d'));
		$result = $this->db->count_all_results('p2p_borrower_emi_details');


		if ($this->db->affected_rows() > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function getLast_Twoweek()
	{
		error_reporting(0);
		//$today = date("d/F/Y");
		//echo $today;exit;
		$this->db->where('emi_sql_date >', date('Y-m-d', strtotime('-15 days')));
		$this->db->where('emi_sql_date <', date('Y-m-d'));
		$result = $this->db->count_all_results('p2p_borrower_emi_details');


		if ($this->db->affected_rows() > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function getEmi_bounced()
	{
		error_reporting(0);

		$this->db->where('status ', 3);
		$result = $this->db->count_all_results('p2p_borrower_emi_details');


		if ($this->db->affected_rows() > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function get_due($bid_registration_id)
	{
		$this->db->select('BS.id AS borrower_id,
                           BS.borrower_id AS b_borrower_id,
                           BS.name,
                           BS.email,
                           BS.mobile,
                           BN.bid_registration_id,
                           BN.bid_loan_amount,
                           BN.loan_no, 
                           BA.r_city,
                           AC.account_number');
		$this->db->from('p2p_disburse_loan_details AS DLT');
		$this->db->join('p2p_bidding_proposal_details AS BN', 'ON DLT.bid_registration_id = BN.bid_registration_id', 'left');
		$this->db->join('p2p_borrowers_list AS BS', 'ON BN.borrowers_id = BS.id', 'left');
		$this->db->join('p2p_borrower_address_details AS BA', 'ON BA.borrower_id = BN.borrowers_id', 'left');
		$this->db->join('p2p_borrower_bank_details AS AC', 'ON AC.borrower_id = BN.borrowers_id', 'left');
		$this->db->join('p2p_borrower_emi_details AS EMI', 'ON EMI.loan_id = BN.bid_registration_id', 'left');

		$this->db->where('BN.bid_registration_id', $bid_registration_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$emi_detil = array();
			$results = $query->result_array();
			foreach ($results as $result) {

				$emi_detils = $this->db->select('id,emi_date, emi_amount,status')->order_by('id', 'asc')->limit(1)->get_where('p2p_borrower_emi_details', array('loan_id' => $bid_registration_id, 'status' => "0"))->row();
				if ($this->db->affected_rows() > 0) {
					$emi_detil = $emi_detils;
				} else {
					$emi_detil = array();
				}
				$loan_details[] = array(
					'borrower_id' => $result['borrower_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'b_borrower_id' => $result['b_borrower_id'],
					'name' => $result['name'],
					'email' => $result['email'],
					'mobile' => $result['mobile'],
					'loan_no' => $result['loan_no'],
					'bid_loan_amount' => $result['bid_loan_amount'],
					'r_city' => $result['r_city'],
					'account_number' => $result['account_number'],
					'emi_detil' => $emi_detil,
				);
			}


			return $loan_details;
		} else {
			return false;
		}
	}

	public function addEmipaymentdeatils()
	{
		$query = $this->db->get_where('p2p_borrower_emi_details', array('id' => $this->input->post('emi_id'), 'status' => '0'));
		if($this->db->affected_rows()>0)
		{
			$emi = $query->row();
			$arr = array(
				'loan_id'=>$emi->disburse_loan_id,
				'emi_id'=>$this->input->post('emi_id'),
				'referece'=>$this->input->post('transaction_id'),
				'emi_payment_amount'=>$this->input->post('amount'),
				'emi_payment_date'=>$this->input->post('date'),
				'emi_payment_mode'=>$this->input->post('mode'),
				'remarks'=>$this->input->post('remarks'),
			);
			$this->db->insert('p2p_emi_payment_details', $arr);
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		else{
			return false;
		}

	}

	public function getpendingApproval()
	{
		$query = $this->db->select('epd.id as emi_payment_due_id,
									epd.referece, 
		                            epd.emi_payment_amount,
		                            epd.is_verified,
		                            epd.remarks, 
		                            bed.id AS emi_id,
		                            bed.loan_id AS bid_registration_id,
		                            bed.disburse_loan_id,		                            
		                            bl.id AS borrower_id, 
		                            bl.borrower_id AS b_borrower_id,  
		                            bpd.loan_no, 
		                            bl.name AS borrower_name, 
		                            bl.email, 
		                            bl.mobile, 
		                            bad.r_city, 
		                            dld.approved_loan_amount, 
		                            bed.emi_amount')
			->join('p2p_borrower_emi_details AS bed', 'ON bed.id = epd.emi_id')
			->join('p2p_borrowers_list AS bl', 'ON bl.id = bed.borrower_id', 'left')
			->join('p2p_bidding_proposal_details AS bpd', 'ON bpd.bid_registration_id = bed.loan_id', 'left')
			->join('p2p_disburse_loan_details AS dld', 'ON dld.id = bed.disburse_loan_id', 'left')
			->join('p2p_borrower_address_details AS bad', 'ON bad.borrower_id = bed.borrower_id', 'left')
			->get_where('p2p_emi_payment_details AS epd', array('is_verified' => '0'));
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {

		}
	}
}
?>
