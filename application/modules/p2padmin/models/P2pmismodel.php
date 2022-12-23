<?php

class P2pmismodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function referenceSystemstatement()
	{
		$reference_System_statement = array();
		$query = $this->db->select('ll.user_id, ll.lender_id, ll.name, lmb.account_balance as cash')
			->join('p2p_lender_list ll', 'll.user_id = lmb.lender_id', 'left')
			->get_where('p2p_lender_main_balance lmb');
		if ($this->db->affected_rows() > 0) {
			$results =  $query->result_array();
			foreach ($results AS $result){
				//get Total Principal Outstanding
				$outstanding_principal = 0;
				$query = $this->db->select("SUM(emi_principal) as loan")->having('loan IS NOT NULL')->get_where("p2p_borrower_emi_details", array('lender_id' => $result['user_id'], 'status' => 0, 'disburse_loan_id !=' => 0));
				if($this->db->affected_rows()>0)
				{
					$outstanding_principal = $query->row()->loan;
				}
				else{
					$outstanding_principal = 0;
				}
                //Net Amount Invested Total Aggregate Amount Invested
				$netInvest = 0;
				$query = $this->db->select("SUM(amount) as pay_in")->having('pay_in IS NOT NULL')->get_where("p2p_lender_pay_in", array('lender_id' => $result['user_id']));

				if($this->db->affected_rows()>0)
				{
					$pay_in = $query->row()->pay_in;
					$query = $this->db->select("SUM(amount) as pay_out")->having('pay_out IS NOT NULL')->get_where("p2p_lender_pay_out", array('lender_id' => $result['user_id']));
					if($this->db->affected_rows()>0)
					{
						$pay_out = $query->row()->pay_out;
						$netInvest = $pay_in - $pay_out;

					}
					else{
						$netInvest = $pay_in;
					}
				}
				else{
					$netInvest = 0;
				}
				//Earned EMI
				$emi_interest_total = 0;
				$query = $this->db->select("SUM(emi_interest) AS emi_interest_total")->having('emi_interest_total IS NOT NULL')->get_where('p2p_borrower_emi_details', array('lender_id' => $result['user_id'], 'status' => 1));
				if($this->db->affected_rows()>0)
				{
					$emi_interest_total = $query->row()->emi_interest_total;
				}
				else{
					$emi_interest_total = 0;
				}

				if(($result['cash'] + $outstanding_principal) == ($netInvest + $emi_interest_total))
				{
                    $is_match = "Y";
				}
				else{
					$is_match = "N";
				}

				$reference_System_statement[] = array(
					'user_id' => $result['user_id'],
					'lender_id' => $result['lender_id'],
					'name' => $result['name'],
					'cash' => $result['cash'],
					'loan' => $outstanding_principal,
					'total_cash_loan' => $result['cash'] + $outstanding_principal,
					'netInvest' => $netInvest,
					'interest_e' => $emi_interest_total,
					'total_netInvest_interest_e' => $netInvest + $emi_interest_total,
					'is_match' => $is_match,
					'difference' => ($result['cash'] + $outstanding_principal) - ($netInvest + $emi_interest_total),
				);


			}
			return $reference_System_statement;
		} else {
			return false;
		}
	}
	//total Disbursement of day in amount
	public function totalDisbursementofday()
	{
	  $previous_day = date('Y-m-d', strtotime(' -1 day ')). ' 19:00:00';
	  $current_day = date('Y-m-d'). ' 19:00:00';
      $query = $this->db->select('SUM(approved_loan_amount) as disburseamount')->having('disburseamount IS NOT NULL')->get_where('p2p_disburse_loan_details', array('date_created >= ' => $previous_day, 'date_created <= ' => $current_day));
      if($this->db->affected_rows()>0)
	  {
        return $query->row()->disburseamount;
	  }
      else{
        return 0;
	  }

	}

	public function totalCollectionofday()
	{
		$previous_day = date('Y-m-d', strtotime(' -1 day ')). ' 19:00:00';
		$current_day = date('Y-m-d'). ' 19:00:00';
		$query = $this->db->select('SUM(emi_payment_amount) as collection')->having('collection IS NOT NULL')->get_where('p2p_emi_payment_details', array('created_date >= ' => $previous_day, 'created_date <= ' => $current_day));
		if($this->db->affected_rows()>0)
		{
			return $query->row()->collection;
		}
		else{
			return 0;
		}

	}

	public function totallender()
	{
		$last24hours = date('Y-m-d H:i:s', strtotime(' -1 day '));
		$last7days = date('Y-m-d H:i:s', strtotime(' -7 day '));
		$last30days = date('Y-m-d H:i:s', strtotime(' -30 day '));

		$query = $this->db->select('COUNT(user_id) as last24hours')->get_where('p2p_lender_list', array('created_date >= ' => $last24hours));
		if($this->db->affected_rows()>0)
		{
			$last24hours = $query->row()->last24hours;
		}
		else{
			$last24hours = 0;
		}

		$query = $this->db->select('COUNT(user_id) as last7days')->get_where('p2p_lender_list', array('created_date >= ' => $last7days));
		if($this->db->affected_rows()>0)
		{
			$last7days = $query->row()->last7days;
		}
		else{
			$last7days = 0;
		}

		$query = $this->db->select('COUNT(user_id) as last30days')->get_where('p2p_lender_list', array('created_date >= ' => $last30days));
		if($this->db->affected_rows()>0)
		{
			$last30days = $query->row()->last30days;
		}
		else{
			$last30days = 0;
		}

		return $array = array(
			'last24hours' => $last24hours,
			'last7days' => $last7days,
			'last30days' => $last30days,
		);

	}

	public function totalborrower()
	{
		$last24hours = date('Y-m-d H:i:s', strtotime(' -1 day '));
		$last7days = date('Y-m-d H:i:s', strtotime(' -7 day '));
		$last30days = date('Y-m-d H:i:s', strtotime(' -30 day '));

		$query = $this->db->select('COUNT(id) as last24hours')->get_where('p2p_borrowers_list', array('created_date >= ' => $last24hours));
		if($this->db->affected_rows()>0)
		{
			$last24hours = $query->row()->last24hours;
		}
		else{
			$last24hours = 0;
		}

		$query = $this->db->select('COUNT(id) as last7days')->get_where('p2p_borrowers_list', array('created_date >= ' => $last7days));
		if($this->db->affected_rows()>0)
		{
			$last7days = $query->row()->last7days;
		}
		else{
			$last7days = 0;
		}

		$query = $this->db->select('COUNT(id) as last30days')->get_where('p2p_borrowers_list', array('created_date >= ' => $last30days));
		if($this->db->affected_rows()>0)
		{
			$last30days = $query->row()->last30days;
		}
		else{
			$last30days = 0;
		}

		return $array_ = array(
			'last24hours' => $last24hours,
			'last7days' => $last7days,
			'last30days' => $last30days,
		);

	}

	public function totalBids()
	{
		$last24hours = date('Y-m-d H:i:s', strtotime(' -1 day '));
		$last7days = date('Y-m-d H:i:s', strtotime(' -7 day '));
		$last30days = date('Y-m-d H:i:s', strtotime(' -30 day '));

		$query = $this->db->select('COUNT(bid_registration_id) as last24hours')->get_where('p2p_bidding_proposal_details', array('proposal_added_date >= ' => $last24hours));
		if($this->db->affected_rows()>0)
		{
			$last24hours = $query->row()->last24hours;
		}
		else{
			$last24hours = 0;
		}

		$query = $this->db->select('COUNT(bid_registration_id) as last7days')->get_where('p2p_bidding_proposal_details', array('proposal_added_date >= ' => $last7days));
		if($this->db->affected_rows()>0)
		{
			$last7days = $query->row()->last7days;
		}
		else{
			$last7days = 0;
		}

		$query = $this->db->select('COUNT(bid_registration_id) as last30days')->get_where('p2p_bidding_proposal_details', array('proposal_added_date >= ' => $last30days));
		if($this->db->affected_rows()>0)
		{
			$last30days = $query->row()->last30days;
		}
		else{
			$last30days = 0;
		}

		return $array_ = array(
			'last24hours' => $last24hours,
			'last7days' => $last7days,
			'last30days' => $last30days,
		);

	}

	public function activeLender()
	{
		$last24hours = date('Y-m-d H:i:s', strtotime(' -1 day '));
		$last7days = date('Y-m-d H:i:s', strtotime(' -7 day '));
		$last30days = date('Y-m-d H:i:s', strtotime(' -30 day '));

		$query = $this->db->select('COUNT(id) as last24hours')->get_where('p2p_login_activity', array('login_date >= ' => $last24hours, 'login_type' => 2));
		if($this->db->affected_rows()>0)
		{
			$last24hours = $query->row()->last24hours;
		}
		else{
			$last24hours = 0;
		}

		$query = $this->db->select('COUNT(id) as last7days')->get_where('p2p_login_activity', array('login_date >= ' => $last7days, 'login_type' => 2));
		if($this->db->affected_rows()>0)
		{
			$last7days = $query->row()->last7days;
		}
		else{
			$last7days = 0;
		}

		$query = $this->db->select('COUNT(id) as last30days')->get_where('p2p_login_activity', array('login_date >= ' => $last30days, 'login_type' => 2));
		if($this->db->affected_rows()>0)
		{
			$last30days = $query->row()->last30days;
		}
		else{
			$last30days = 0;
		}

		return $array_ = array(
			'last24hours' => $last24hours,
			'last7days' => $last7days,
			'last30days' => $last30days,
		);

	}

	public function activeBorrower()
	{
		$last24hours = date('Y-m-d H:i:s', strtotime(' -1 day '));
		$last7days = date('Y-m-d H:i:s', strtotime(' -7 day '));
		$last30days = date('Y-m-d H:i:s', strtotime(' -30 day '));

		$query = $this->db->select('COUNT(id) as last24hours')->get_where('p2p_login_activity', array('login_date >= ' => $last24hours, 'login_type' => 1));
		if($this->db->affected_rows()>0)
		{
			$last24hours = $query->row()->last24hours;
		}
		else{
			$last24hours = 0;
		}

		$query = $this->db->select('COUNT(id) as last7days')->get_where('p2p_login_activity', array('login_date >= ' => $last7days, 'login_type' => 1));
		if($this->db->affected_rows()>0)
		{
			$last7days = $query->row()->last7days;
		}
		else{
			$last7days = 0;
		}

		$query = $this->db->select('COUNT(id) as last30days')->get_where('p2p_login_activity', array('login_date >= ' => $last30days, 'login_type' => 1));
		if($this->db->affected_rows()>0)
		{
			$last30days = $query->row()->last30days;
		}
		else{
			$last30days = 0;
		}

		return $array_ = array(
			'last24hours' => $last24hours,
			'last7days' => $last7days,
			'last30days' => $last30days,
		);

	}

	public function totalLoanSummary()
	{
		return 0;
	}

	public function ageIng()
	{
		return 0;
	}

	public function notyetDue()
	{
		$where = "(emi_date >= CURDATE() - INTERVAL 30 DAY AND emi_date < CURDATE() - INTERVAL 0 DAY)";
		$this->db->select('count(id) AS not_yet_due');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('status', 0);
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return $past_due_0_30days = $query->row()->past_due_0_30days;

		}
		else{
			return false;
		}
	}

	public function past_due_0_30days()
	{
		$where = "(emi_date >= CURDATE() - INTERVAL 30 DAY AND emi_date < CURDATE() - INTERVAL 0 DAY)";
		$this->db->select('count(id) AS past_due_0_30days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('status', 0);
		$query = $this->db->get();

		if($this->db->affected_rows()>0)
		{
			return $past_due_0_30days = $query->row()->past_due_0_30days;

		}
		else{
			return false;
		}
	}

	public function past_due_30_60days()
	{
		$where = "(emi_date >= CURDATE() - INTERVAL 60 DAY AND emi_date < CURDATE() - INTERVAL 31 DAY)";
		$this->db->select('count(id) AS past_due_30_60days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('status', 0);
		$query = $this->db->get();

		if($this->db->affected_rows()>0)
		{
			return $past_due_30_60days = $query->row()->past_due_30_60days;

		}
		else{
			return false;
		}
	}

	public function past_due_60_90days()
	{
		$where = "(emi_date >= CURDATE() - INTERVAL 90 DAY AND emi_date < CURDATE() - INTERVAL 61 DAY)";
		$this->db->select('count(id) AS past_due_60_90days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('status', 0);
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return $past_due_60_90days = $query->row()->past_due_60_90days;

		}
		else{
			return false;
		}
	}
}

?>
