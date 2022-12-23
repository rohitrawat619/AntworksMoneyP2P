<?php

class Biddingmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function proposal_list($limit, $start, $lender_id)
	{

		$proposal_days = $this->proposal_days();
		$preferencesCondition = $this->lenderPreferences($lender_id);

		$this->db->select('ppd.proposal_id, 
                            ppd.p2p_product_id,
                            LT.loan_name,     
                            LT.loan_purpose,     
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.date_added,
                            ppd.date_modified,
                            status.proposal_status_name AS bidding_status,     
                            ' . $proposal_days . '-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            pbl.name, pbl.id AS borrower_id, TIMESTAMPDIFF(YEAR, pbl.dob, CURDATE()) AS age, pbl.gender, 
                            pbl.borrower_id AS b_borrower_id, address.r_city, pq.qualification, pbl.occuption_id, pbl.marital_status,
                            rating.experian_score, 
                            rating.antworksp2p_rating
                            ');
		$this->db->from('p2p_proposal_details ppd');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details address', 'address.borrower_id=ppd.borrower_id', 'left');
		$this->db->join('p2p_qualification pq', 'pbl.highest_qualification=pq.id', 'left');
		$this->db->join('p2p_proposal_status_name status', 'status.proposal_status_id = ppd.bidding_status', 'left');
		$this->db->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'inner');
		$this->db->join('p2p_loan_type LT', 'LT.p2p_product_id = ppd.p2p_product_id', 'left');
		$this->db->where_in('ppd.bidding_status', array('1', '4'));
		if($preferencesCondition)
		{
			$this->db->where($preferencesCondition);
		}
		$this->db->group_by('ppd.borrower_id');
		$this->db->order_by('ppd.date_added', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['borrower_id']));
				$occ_income_details = (array)$query->row();
				$this->db->select('SUM(bid_loan_amount) AS total_bid_amount');
				$this->db->from('p2p_bidding_proposal_details');
				$this->db->where('proposal_id', $result['proposal_id']);
				$this->db->where('proposal_status !=', 3);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_details = (array)$query->row();
				}

				$bids_info[] = array(
					'proposal_id' => $result['proposal_id'],
					'p2p_product_id' => $result['p2p_product_id'],
					'loan_name' => $result['loan_name'],
					'loan_purpose' => $result['loan_purpose'],
					'PLRN' => $result['PLRN'],
					'borrower_id' => $result['borrower_id'],
					'b_borrower_id' => $result['b_borrower_id'],
					'loan_amount' => $result['loan_amount'],
					'loan_purpose' => $result['loan_purpose'],
					'min_interest_rate' => $result['min_interest_rate'],
					'max_interest_rate' => $result['max_interest_rate'],
					'prefered_interest_min' => $result['prefered_interest_min'],
					'prefered_interest_max' => $result['prefered_interest_max'],
					'tenor_months' => $result['tenor_months'],
					'loan_description' => $result['loan_description'],
					'bidding_status' => $result['bidding_status'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'time_left' => $result['time_left'],
					'name' => $result['name'],
					'age' => $result['age'],
					'gender' => $result['gender'],
					'r_city' => $result['r_city'],
					'qualification' => $result['qualification'],
					'marital_status' => $result['marital_status'],
					'experian_score' => $result['experian_score'],
					'antworksp2p_rating' => $result['antworksp2p_rating'],
					'total_bid_amount' => $bid_details['total_bid_amount'] ? $bid_details['total_bid_amount'] : 0,
					'occuption_details' => $occ_income_details ? $occ_income_details : '',
				);

			}
			return $bids_info;
		}

	}

	public function proposallistFavorite()
	{
		$proposal_days = $this->proposal_days();
		$this->db->select('ppd.proposal_id, 
                            ppd.p2p_product_id,
                            LT.loan_name,     
                            LT.loan_purpose,     
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.date_added,
                            ppd.date_modified,
                            status.proposal_status_name AS bidding_status,     
                            ' . $proposal_days . '-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            pbl.name, pbl.id AS borrower_id, TIMESTAMPDIFF(YEAR, pbl.dob, CURDATE()) AS age, pbl.gender, 
                            pbl.borrower_id AS b_borrower_id, address.r_city, pq.qualification, pbl.occuption_id, pbl.marital_status,
                            rating.experian_score, 
                            rating.antworksp2p_rating
                            ');
		$this->db->from('p2p_proposal_shortlist_details ppdd');
		$this->db->join('p2p_proposal_details ppd', 'ppd.proposal_id=ppdd.proposal_id', 'left');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details address', 'address.borrower_id=ppd.borrower_id', 'left');
		$this->db->join('p2p_qualification pq', 'pbl.highest_qualification=pq.id', 'left');
		$this->db->join('p2p_proposal_status_name status', 'status.proposal_status_id = ppd.bidding_status', 'left');
		$this->db->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'left');
		$this->db->join('p2p_loan_type LT', 'LT.p2p_product_id = ppd.p2p_product_id', 'left');
		$this->db->where('ppdd.lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('ppd.bidding_status', array(1, 4));
		$this->db->order_by('ppd.date_added', 'DESC');
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['borrower_id']));
				$occ_income_details = (array)$query->row();
				$this->db->select('SUM(bid_loan_amount) AS total_bid_amount');
				$this->db->from('p2p_bidding_proposal_details');
				$this->db->where('proposal_id', $result['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_details = (array)$query->row();
				}

				$bids_info[] = array(
					'proposal_id' => $result['proposal_id'],
					'p2p_product_id' => $result['p2p_product_id'],
					'loan_name' => $result['loan_name'],
					'loan_purpose' => $result['loan_purpose'],
					'PLRN' => $result['PLRN'],
					'borrower_id' => $result['borrower_id'],
					'b_borrower_id' => $result['b_borrower_id'],
					'loan_amount' => $result['loan_amount'],
					'loan_purpose' => $result['loan_purpose'],
					'min_interest_rate' => $result['min_interest_rate'],
					'max_interest_rate' => $result['max_interest_rate'],
					'prefered_interest_min' => $result['prefered_interest_min'],
					'prefered_interest_max' => $result['prefered_interest_max'],
					'tenor_months' => $result['tenor_months'],
					'loan_description' => $result['loan_description'],
					'bidding_status' => $result['bidding_status'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'time_left' => $result['time_left'],
					'name' => $result['name'],
					'age' => $result['age'],
					'gender' => $result['gender'],
					'r_city' => $result['r_city'],
					'qualification' => $result['qualification'],
					'marital_status' => $result['marital_status'],
					'experian_score' => $result['experian_score'],
					'antworksp2p_rating' => $result['antworksp2p_rating'],
					'total_bid_amount' => $bid_details['total_bid_amount'] ? $bid_details['total_bid_amount'] : 0,
					'occuption_details' => $occ_income_details ? $occ_income_details : '',
				);

			}
			return $bids_info;
		}

	}

	public function proposal_list_app($product_id, $limit, $start)
	{

		$this->db->select('ppd.proposal_id, 
                            ppd.p2p_product_id,
                            LT.loan_name,     
                            LT.loan_purpose,     
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.date_added,
                            ppd.date_modified,
                            status.proposal_status_name AS bidding_status,     
                            31-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            pbl.name, pbl.id AS borrower_id, TIMESTAMPDIFF(YEAR, pbl.dob, CURDATE()) AS age, pbl.gender, 
                            pbl.borrower_id AS b_borrower_id, address.r_city, pq.qualification, pbl.occuption_id, pbl.marital_status,
                            rating.experian_score, 
                            rating.antworksp2p_rating
                            ');
		$this->db->from('p2p_proposal_details ppd');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details address', 'address.borrower_id=ppd.borrower_id', 'left');
		$this->db->join('p2p_qualification pq', 'pbl.highest_qualification=pq.id', 'left');
		$this->db->join('p2p_proposal_status_name status', 'status.proposal_status_id = ppd.bidding_status', 'left');
		$this->db->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'left');
		$this->db->join('p2p_loan_type LT', 'LT.p2p_product_id = ppd.p2p_product_id', 'left');
		$this->db->where('ppd.p2p_product_id', $product_id);
		$this->db->where_in('ppd.bidding_status', array(1, 2, 4));
		$this->db->group_by('ppd.borrower_id');
		$this->db->order_by('ppd.date_added', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['borrower_id']));
				$occ_income_details = (array)$query->row();
				$this->db->select('SUM(bid_loan_amount) AS total_bid_amount');
				$this->db->from('p2p_bidding_proposal_details');
				$this->db->where('proposal_id', $result['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_details = (array)$query->row();
				}

				$bids_info[] = array(
					'proposal_id' => $result['proposal_id'],
					'p2p_product_id' => $result['p2p_product_id'],
					'loan_name' => $result['loan_name'],
					'loan_purpose' => $result['loan_purpose'],
					'PLRN' => $result['PLRN'],
					'borrower_id' => $result['borrower_id'],
					'b_borrower_id' => $result['b_borrower_id'],
					'loan_amount' => $result['loan_amount'],
					'loan_purpose' => $result['loan_purpose'],
					'min_interest_rate' => $result['min_interest_rate'],
					'max_interest_rate' => $result['max_interest_rate'],
					'prefered_interest_min' => $result['prefered_interest_min'],
					'prefered_interest_max' => $result['prefered_interest_max'],
					'tenor_months' => $result['tenor_months'],
					'loan_description' => $result['loan_description'],
					'bidding_status' => $result['bidding_status'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'time_left' => $result['time_left'],
					'name' => $result['name'],
					'age' => $result['age'],
					'gender' => $result['gender'],
					'r_city' => $result['r_city'],
					'qualification' => $result['qualification'],
					'marital_status' => $result['marital_status'],
					'experian_score' => $result['experian_score'],
					'antworksp2p_rating' => $result['antworksp2p_rating'],
					'total_bid_amount' => $bid_details['total_bid_amount'] ? $bid_details['total_bid_amount'] : 0,
					'occuption_details' => $occ_income_details ? $occ_income_details : '',
				);

			}
			return $bids_info;
		}

	}

	public function get_count_proposal($where)
	{
		return $this->db->from('p2p_proposal_details')->where($where)->count_all_results();
		echo $this->db->last_query();
		exit;
	}

	public function get_count_proposal_preferences($lenderId)
	{
		$preferencesCondition = $this->lenderPreferences($lenderId);
		return $this->db->from('p2p_proposal_details as ppd')
			->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'left')
			->where($preferencesCondition)->count_all_results();
		echo $this->db->last_query();
		exit;
	}

	public function state_list()
	{

		$this->db->select('*');
		$this->db->from('p2p_state_experien');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_occupation_details()
	{

		$this->db->select('*');
		$this->db->from('p2p_occupation_details_table');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function submit_proposal()
	{
		$this->db->select('*');
		$this->db->from('p2p_proposal_details');
		$this->db->where('proposal_id', $this->input->post('proposal_id'));
		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			$proposal_info = $query->row();

			$this->db->select('bid_registration_id');
			$this->db->from('p2p_bidding_proposal_details');
			$this->db->where('proposal_id', $this->input->post('proposal_id'));
			$this->db->where('lenders_id', $this->session->userdata('user_id'));
			$query = $this->db->get();
			if ($this->db->affected_rows() > 0) {
				return array('error' => 1, 'message' => "You already BID this proposal", 'redirect_url' => base_url() . 'bidding/live-bids/');
			} else {
				if ($this->input->post('loan_amount') > $proposal_info->loan_amount) // Condition to check Insert Bid
				{
					return array('error' => 1, 'message' => "Sorry check your bidding loan", 'redirect_url' => base_url() . 'bidding/live-bids/');
				}
				$total_bid_amount = $this->Total_bid_amount($this->input->post('proposal_id'));
				$remaining_amount = $proposal_info->loan_amount - $total_bid_amount['Totalbidamount'];
				if ($this->input->post('loan_amount') > $remaining_amount) // Condition to check Remaining Application Amount
				{
					return array('error' => 1, 'message' => "Bidding amount is greater then remaining amount", 'redirect_url' => base_url() . 'bidding/live-bids/');
				}
				$balance = $this->getaccountBalance();
				$allow_to_bid_amount = $balance['account_balance'] * $this->allow_to_bid_amount();
				if ($this->input->post('loan_amount') > $allow_to_bid_amount) {
					return array('error' => 1, 'message' => "You don't have sufficient balance for bid you account balance is " . $balance['account_balance'] . "", 'redirect_url' => base_url() . 'lender/pay-in');
				}
				$amountoffered = $this->input->post('loan_amount');
				$loan_amount_percentage = ($amountoffered / $proposal_info->loan_amount) * 100;
				if ($proposal_info->p2p_product_id == 2) {
					$subProductoptions = $this->getSubproductoptions($subProductid = 'CL1');
					$p2p_sub_product_id = 7;
					$proposal_submit_array = array(
						'proposal_id' => $this->input->post('proposal_id'),
						'p2p_sub_product_id' => $p2p_sub_product_id,
						'borrowers_id' => $proposal_info->borrower_id,
						'lenders_id' => $this->session->userdata('user_id'),
						'bid_loan_amount' => $this->input->post('loan_amount'),
						'loan_amount' => $loan_amount_percentage,
						'interest_rate' => $subProductoptions['maximum_interest'],
						'accepted_tenor' => $subProductoptions['minimum_tenor'],
						'proposal_added_date' => date("Y-m-d H:i:s"),
					);
					$query = $this->db->insert('p2p_bidding_proposal_details', $proposal_submit_array);
				} else {
					if ($this->input->post('loan_amount') >= 2500 && $this->input->post('loan_amount') <= 10000) {
						if ($proposal_info->p2p_product_id == 1 || $proposal_info->p2p_product_id == 3) {
							$subProductoptions = $this->getSubproductoptions($subProductid = 'PL3');
							$p2p_sub_product_id = 3;
						}
						if ($proposal_info->p2p_product_id == 4) {
							$subProductoptions = $this->getSubproductoptions($subProductid = 'BL3');
							$p2p_sub_product_id = 6;
						}

						$proposal_submit_array = array(
							'proposal_id' => $this->input->post('proposal_id'),
							'p2p_sub_product_id' => $p2p_sub_product_id,
							'borrowers_id' => $proposal_info->borrower_id,
							'lenders_id' => $this->session->userdata('user_id'),
							'bid_loan_amount' => $this->input->post('loan_amount'),
							'loan_amount' => $loan_amount_percentage,
							'interest_rate' => $subProductoptions['maximum_interest'],
							'accepted_tenor' => $subProductoptions['minimum_tenor'],
							'proposal_added_date' => date("Y-m-d H:i:s"),
						);
						$query = $this->db->insert('p2p_bidding_proposal_details', $proposal_submit_array);
					} else {
						$proposal_submit_array = array(
							'proposal_id' => $this->input->post('proposal_id'),
							'borrowers_id' => $proposal_info->borrower_id,
							'lenders_id' => $this->session->userdata('user_id'),
							'bid_loan_amount' => $this->input->post('loan_amount'),
							'loan_amount' => $loan_amount_percentage,
							'interest_rate' => $this->input->post('interest_rate'),
							'accepted_tenor' => $this->input->post('accepted_tenor'),
							'proposal_added_date' => date("Y-m-d H:i:s"),
						);
						$query = $this->db->insert('p2p_bidding_proposal_details', $proposal_submit_array);
					}
				}
				if ($this->db->affected_rows() > 0) {
					$bid_registration_id = $this->db->insert_id();
					//Create/Update Loan NO
					$loan_no_plus = 10000000000 + $bid_registration_id;
					$loan_no = "LN".$loan_no_plus;
					$this->db->where('bid_registration_id', $bid_registration_id);
					$this->db->set('loan_no', $loan_no);
					$this->db->update('p2p_bidding_proposal_details');

					$lockedAMount = array(
						'lender_id' => $this->session->userdata('user_id'),
						'bid_registration_id' => $bid_registration_id,
						'lock_amount' => $this->input->post('loan_amount'),
					);
					$this->db->insert('p2p_lender_lock_amount', $lockedAMount);
					$total_bid_amount = $this->Total_bid_amount($this->input->post('proposal_id'));
					if ($total_bid_amount['Totalbidamount'] == $proposal_info->loan_amount) {
						$this->db->set('bidding_status', 2);
						$this->db->where('proposal_id', $this->input->post('proposal_id'));
						$this->db->update('p2p_proposal_details ');

					} else {
						$this->db->set('bidding_status', 4);
						$this->db->where('proposal_id', $this->input->post('proposal_id'));
						$this->db->update('p2p_proposal_details ');
					}
					$borrower_info = $this->borrowers_info($proposal_info->borrower_id);
					if ($borrower_info->gender == '1') {
						$title = "Mr.";
					} else {
						$title = "Ms.";
					}
					$this->Smsmodule->Approved_Bid_borrower($title, $borrower_info->name, $amountoffered, $borrower_info->mobile);

					//Lender Notification
					$lender_info = $this->profile();
					if ($lender_info->gender == 1) {
						$title = "Mr.";
					} else {
						$title = "Ms.";
					}
					$data['bid_list'] = $this->getTotalloanamountLenderinmarket();
					$data['total_loan_amount_lender'] = array_sum(array_column($data['bid_list'], 'TOTALAMOUNT'));
					$balance_amount = 1000000 - $data['total_loan_amount_lender'];
					$this->Smsmodule->Lender_Approved_Bid($title, $lender_info->name, $amountoffered, $lender_info->mobile, $this->input->post('interest_rate'), $balance_amount);
					return array('error' => 1, 'message' => "Your bid has been successfully submitted", 'redirect_url' => base_url() . 'bidding/live-bids/');
				} else {
					return array('error' => 1, 'message' => "Something went wrong", 'redirect_url' => base_url() . 'bidding/live-bids/');
				}
			}
		} else {
			return array('error' => 1, 'message' => "This is not allowed here", 'redirect_url' => base_url() . 'bidding/live-bids/');
		}

	}

	public function create_loan_no()
	{
		$this->db->select("loan_no");
		$this->db->order_by('loan_no', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('p2p_bidding_proposal_details');
		$row = (array)$query->row();
		if ($this->db->affected_rows() > 0) {
			$loan_no = $row['loan_no'];
			$loan_no++;
			return $loan_no = $loan_no;
		} else {
			return $loan_no = "LN10000000001";
		}
	}

	public function borrowers_info($borrower_id)
	{
		$this->db->select('*');
		$this->db->from('p2p_borrowers_list');
		$this->db->where('id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function profile()
	{
		$this->db->select('*');
		$this->db->from('p2p_lender_list');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function getTotalloanamountLenderinmarket()
	{
		$lid = $this->session->userdata('user_id');
		$sql = "SELECT
				PD.loan_amount AS LOANAMOUNT,
				BPD.loan_amount AS LOANAMOUNTPERCENT,
				((PD.loan_amount * BPD.loan_amount)/100) AS TOTALAMOUNT

		        FROM p2p_proposal_details AS PD
		        LEFT JOIN p2p_bidding_proposal_details AS BPD
		        ON PD.proposal_id  = BPD.proposal_id
		        WHERE BPD.lenders_id = '$lid'
		       ";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getaccountBalance()
	{
		$this->db->select('*');
		$this->db->from('p2p_lender_main_balance');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function proposal_detail()
	{
		$this->db->select('*');
		$this->db->from('p2p_proposal_details');
		$this->db->where('proposal_id', $this->input->post('proposal_id'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function Total_bid_amount($porposal_id)
	{
		$this->db->select('SUM(bid_loan_amount) AS Totalbidamount');
		$this->db->from('p2p_bidding_proposal_details');
		$this->db->where('proposal_id', $porposal_id);
		$this->db->where('proposal_status !=', 3);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function borrower_info_details($borrower_id)
	{
		$this->db->select("Bl.id, BL.name AS Borrower_name,
                         TIMESTAMPDIFF(YEAR, BL.dob, CURDATE()) AS age,                         
                         BL.gender,                        
                         BL.marital_status,
                         BAD.r_city,
                         SM.state,
                         ODT.name AS occuption_name,
                         PQ.qualification,
                         BOD.company_type,                         
                         BOD.company_name,                         
                         BOD.current_emis,                         
                         BOD.net_monthly_income,
                         PRT.residence_name                       
                         ");
		$this->db->from('p2p_borrowers_list AS BL');
		$this->db->join('p2p_borrower_address_details AS BAD', 'ON BAD.borrower_id = BL.id', 'left');
		$this->db->join('p2p_state_experien AS SM', 'ON SM.code = BAD.r_state', 'left');
		$this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = BL.occuption_id', 'left');
		$this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
		$this->db->join('p2p_borrower_occuption_details BOD', 'ON BOD.borrower_id = BL.id', 'left');
		$this->db->join('p2p_present_residence_type PRT', 'ON PRT.id = BAD.present_residence', 'left');
		$this->db->where('BL.borrower_id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function occuptionDetails($table, $borrower_id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('borrower_id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function kycDoctype($borrower_id)
	{
		$this->db->select('docs_type');
		$this->db->from('p2p_borrowers_docs_table');
		$this->db->where('borrower_id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_currentopen_proposal($borrower_id)
	{
		$this->db->select('*, date(date_added) AS date_of_added');
		$this->db->from('p2p_proposal_details');
		$this->db->where('borrower_id', $borrower_id);
		$this->db->where('bidding_status', '1');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function get_id_borrower($borrower_id)
	{
		$this->db->select('id');
		$this->db->from('p2p_borrowers_list');
		$this->db->where('borrower_id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result['id'];
		} else {
			return false;
		}
	}

	public function getExperainscoere($borrower_id)
	{
		$this->db->select('experian_score');
		$this->db->from('ant_borrower_rating');
		$this->db->where('borrower_id', $borrower_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function getUserrating($borrower_id)
	{
		$this->db->select('antworksp2p_rating');
		$this->db->from('ant_borrower_rating');
		$this->db->where('borrower_id', $borrower_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function search_proposal_list()
	{
		$this->db->select('ppd.proposal_id,      
                            ppd.p2p_product_id,      
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.loan_purpose,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.date_added,
                            ppd.date_modified,
                            status.proposal_status_name AS bidding_status,     
                            31-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            pbl.name, pbl.id AS borrower_id, TIMESTAMPDIFF(YEAR, pbl.dob, CURDATE()) AS age, pbl.gender, 
                            pbl.borrower_id AS b_borrower_id, address.r_city, pq.qualification, pbl.occuption_id, pbl.marital_status,
                            rating.experian_score, 
                            rating.antworksp2p_rating
                            ');
		$this->db->from('p2p_proposal_details ppd');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details address', 'address.borrower_id=ppd.borrower_id', 'left');
		$this->db->join('p2p_qualification pq', 'pbl.highest_qualification=pq.id', 'left');
		$this->db->join('p2p_proposal_status_name status', 'status.proposal_status_id = ppd.bidding_status', 'left');
		$this->db->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'left');
		$this->db->where("(pbl.borrower_id = '" . $this->input->post('b_borrower_id') . "' OR pbl.name LIKE '%" . $this->input->post('b_borrower_id') . "%')");
		$this->db->where('ppd.p2p_product_id', $this->input->post('p2p_product_id'));
		$this->db->order_by('ppd.date_added', 'DESC');
		//$this->db->limit('1');
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {

				$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['borrower_id']));
				$occ_income_details = (array)$query->row();
				$this->db->select('SUM(bid_loan_amount) AS total_bid_amount');
				$this->db->from('p2p_bidding_proposal_details');
				$this->db->where('proposal_id', $result['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_details = (array)$query->row();
				}

				$bids_info[] = array(
					'proposal_id' => $result['proposal_id'],
					'p2p_product_id' => $result['p2p_product_id'],
					'PLRN' => $result['PLRN'],
					'borrower_id' => $result['borrower_id'],
					'b_borrower_id' => $result['b_borrower_id'],
					'loan_amount' => $result['loan_amount'],
					'loan_purpose' => $result['loan_purpose'],
					'min_interest_rate' => $result['min_interest_rate'],
					'max_interest_rate' => $result['max_interest_rate'],
					'prefered_interest_min' => $result['prefered_interest_min'],
					'prefered_interest_max' => $result['prefered_interest_max'],
					'tenor_months' => $result['tenor_months'],
					'loan_description' => $result['loan_description'],
					'bidding_status' => $result['bidding_status'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'time_left' => $result['time_left'],
					'name' => $result['name'],
					'age' => $result['age'],
					'gender' => $result['gender'],
					'r_city' => $result['r_city'],
					'qualification' => $result['qualification'],
					'marital_status' => $result['marital_status'],
					'experian_score' => $result['experian_score'],
					'antworksp2p_rating' => $result['antworksp2p_rating'],
					'total_bid_amount' => $bid_details['total_bid_amount'] ? $bid_details['total_bid_amount'] : 0,
					'occuption_details' => $occ_income_details ? $occ_income_details : '',
				);

			}
			return $bids_info;
		}
	}

	public function proposalInfo()
	{
		$this->db->select('ppd.proposal_id,      
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.loan_purpose,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.date_added,   
                            31-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left,
                            pbl.name, pbl.id AS main_borrower_id,
                            pbl.borrower_id AS created_borrower_id
                            ');
		$this->db->from('p2p_proposal_details ppd');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->where('ppd.proposal_id', $this->input->post('proposal_id'));
		$this->db->order_by('ppd.date_added', 'DESC');
		//$this->db->limit('1');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		}
	}

	public function maximumBidamount()
	{
		return $query = (array)$this->db->select('option_value')->get_where('p2p_admin_options', array('option_name' => 'maximum_bid_amount'))->row();
	}

	public function addInvoice()
	{
		$arr = array(
			'bid_registration_id' => $this->input->post('bid_registration_id'),
			'invoice_no' => $this->input->post('invoice_no'),
			'amount' => $this->input->post('amount'),
			'date_of_invoice' => $this->input->post('date_of_invoice'),
			'invoice_image' => $this->input->post('invoice_image') ? $this->input->post('invoice_image') : '',
		);
		$this->db->insert('p2p_lender_consumer_product_details', $arr);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function biddingInfo($lenderId)
	{
		$query = $this->db->get_where('p2p_bidding_proposal_details', array('bid_registration_id' => $this->input->post('bid_registration_id')));
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();

			$emi = 0;

			// one month interest
			$r = $result['interest_rate'] / (12 * 100);

			// one month period
			$t = $result['accepted_tenor'];

			$emi = ($result['bid_loan_amount'] * $r * pow(1 + $r, $t)) /
				(pow(1 + $r, $t) - 1);
			$total_repayment_amount = $emi * $result['accepted_tenor'];
			$emi_date = date('Y-m-d', strtotime('+1 month'));
			return array(
				'loan_amount' => $result['bid_loan_amount'],
				'tenor' => $result['accepted_tenor'],
				'interest_rate' => $result['interest_rate'],
				'emi' => round($emi, 2),
				'emi_date' => $emi_date,
				'total_repayment_amount' => round($total_repayment_amount, 2),
				'processing_fee' => 1500,
				'loan_status' => 'Approved'
			);
		} else {
			return false;
		}

	}

	public function allow_to_bid_amount()
	{
		$query = $this->db->get_where('p2p_admin_options', array('option_name' => 'allow_to_bid_amount'));
		if ($this->db->affected_rows() > 0) {
			return $query->row()->option_value;
		} else {
			return false;
		}
	}

	public function searchbyLender()
	{
		$proposal_days = $this->proposal_days();
		$where = '';
		if (!empty($_GET['name_borrower_id'])) {
			$where = "BL.name LIKE '%" . $this->input->get('name_borrower_id') . "%' OR BL.borrower_id = '" . $this->input->get('name_borrower_id') . "'";
		}

		if (!empty($_GET['min_loan'])) {
			$where = "ppd.loan_amount >= '" . $this->input->get('min_loan') . "'";
		}

		if (!empty($_GET['max_loan'])) {
			if (!empty($_GET['min_loan'])) {
				$where = $where . " AND ppd.loan_amount <= '" . $this->input->get('max_loan') . "'";
			} else {
				$where = "ppd.loan_amount <= '" . $this->input->get('max_loan') . "'";
			}
		}
		if (!empty($_GET['min_interest_rate'])) {

			if (!empty($_GET['min_loan']) || !empty($_GET['max_loan'])) {
				$where = $where . " AND ppd.prefered_interest_max >= '" . $this->input->get('min_interest_rate') . "'";
			} else if (empty($_GET['min_loan']) && empty($_GET['max_loan'])) {
				$where = "ppd.prefered_interest_max >= '" . $this->input->get('min_interest_rate') . "'";
			}


		}
		if (!empty($_GET['max_interest_rate'])) {
			if (!empty($_GET['min_loan']) || !empty($_GET['max_loan']) || !empty($_GET['min_interest_rate'])) {
				$where = $where . " AND ppd.prefered_interest_max <= '" . $this->input->get('max_interest_rate') . "'";
			} else {
				$where = "ppd.prefered_interest_max <= '" . $this->input->get('max_interest_rate') . "'";
			}
		}

		if (!empty($_GET['product_type'])) {
			if (!empty($_GET['min_loan']) || !empty($_GET['max_loan']) || !empty($_GET['min_interest_rate']) || !empty($_GET['max_interest_rate'])) {
				if ($this->input->get('product_type') == 1) {
					$where = $where . " AND ppd.p2p_product_id = '" . $this->input->get('product_type') . "' AND ppd.loan_amount <= 10000";
				} else {
					$where = $where . " AND ppd.p2p_product_id = '" . $this->input->get('product_type') . "'";
				}

			} else {
				if ($this->input->get('product_type') == 1) {
					$where = "ppd.p2p_product_id = '" . $this->input->get('product_type') . "' AND ppd.loan_amount <= 10000";
				} else {
					$where = "ppd.p2p_product_id = '" . $this->input->get('product_type') . "'";
				}

			}
		}

		if (!empty($_GET['antworks_rating'])) {
			if (!empty($_GET['min_loan']) || !empty($_GET['max_loan']) || !empty($_GET['min_interest_rate']) || !empty($_GET['max_interest_rate']) || !empty($_GET['product_type'])) {
				$where = $where . " AND rating.antworksp2p_rating >='" . $this->input->get('antworks_rating') . "'";
			} else {
				if($_GET['antworks_rating'] == 'All'){
					$where = "rating.antworksp2p_rating >='0'";
				}
				else{
					$where = "rating.antworksp2p_rating >='" . $this->input->get('antworks_rating') . "'";
				}

			}
		}
		if ($where) {
			$search_query = "ppd.bidding_status NOT IN(0, 3) AND (" . $where .")";
			$this->db->select('ppd.proposal_id,  
            				ppd.p2p_product_id,     
            				LT.loan_name,     
                            LT.loan_purpose,    
                            ppd.PLRN,      
                            ppd.loan_amount,     
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.bidding_status,
                            ppd.date_added,
                            ppd.date_modified,
                            status.proposal_status_name AS bidding_status_name,     
                            ' . $proposal_days . '-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            BL.name, BL.id AS borrower_id, TIMESTAMPDIFF(YEAR, BL.dob, CURDATE()) AS age, BL.gender, 
                            BL.borrower_id AS b_borrower_id, address.r_city, pq.qualification, BL.occuption_id, BL.marital_status,
                            rating.experian_score, 
                            rating.antworksp2p_rating
                            ');
			$this->db->from('p2p_proposal_details ppd');
			$this->db->join('p2p_borrowers_list BL', 'BL.id=ppd.borrower_id', 'left');
			$this->db->join('p2p_borrower_address_details address', 'address.borrower_id=ppd.borrower_id', 'left');
			$this->db->join('p2p_qualification pq', 'BL.highest_qualification=pq.id', 'left');
			$this->db->join('p2p_proposal_status_name status', 'status.proposal_status_id = ppd.bidding_status', 'left');
			$this->db->join('ant_borrower_rating rating', 'rating.borrower_id = ppd.borrower_id', 'left');
			$this->db->join('p2p_loan_type LT', 'LT.p2p_product_id = ppd.p2p_product_id', 'left');
			$this->db->where($search_query);
			$this->db->group_by('ppd.borrower_id');
			$this->db->order_by('ppd.date_added', 'DESC');
			$this->db->limit('100');
			$query = $this->db->get();

			if ($this->db->affected_rows() > 0) {
				$results = $query->result_array();
				foreach ($results AS $result) {

					$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['borrower_id']));
					$occ_income_details = (array)$query->row();
					$this->db->select('SUM(bid_loan_amount) AS total_bid_amount');
					$this->db->from('p2p_bidding_proposal_details');
					$this->db->where('proposal_id', $result['proposal_id']);
					$this->db->where('proposal_status != ', 3);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$bid_details = (array)$query->row();
					}

					$bids_info[] = array(
						'proposal_id' => $result['proposal_id'],
						'p2p_product_id' => $result['p2p_product_id'],
						'PLRN' => $result['PLRN'],
						'borrower_id' => $result['borrower_id'],
						'b_borrower_id' => $result['b_borrower_id'],
						'loan_amount' => $result['loan_amount'],
						'loan_name' => $result['loan_name'],
						'loan_purpose' => $result['loan_purpose'],
						'min_interest_rate' => $result['min_interest_rate'],
						'max_interest_rate' => $result['max_interest_rate'],
						'prefered_interest_min' => $result['prefered_interest_min'],
						'prefered_interest_max' => $result['prefered_interest_max'],
						'tenor_months' => $result['tenor_months'],
						'loan_description' => $result['loan_description'],
						'bidding_status' => $result['bidding_status'],
						'bidding_status_name' => $result['bidding_status_name'],
						'date_added' => $result['date_added'],
						'date_modified' => $result['date_modified'],
						'time_left' => $result['time_left'],
						'name' => $result['name'],
						'age' => $result['age'],
						'gender' => $result['gender'],
						'r_city' => $result['r_city'],
						'qualification' => $result['qualification'],
						'marital_status' => $result['marital_status'],
						'experian_score' => $result['experian_score'],
						'antworksp2p_rating' => $result['antworksp2p_rating'],
						'total_bid_amount' => $bid_details['total_bid_amount'] ? $bid_details['total_bid_amount'] : 0,
						'occuption_details' => $occ_income_details ? $occ_income_details : '',
					);

				}
				return $bids_info;
			}
		} else {
			return false;
		}

	}

	public function checkAlreadybid()
	{
		$this->db->select('bid_registration_id');
		$this->db->from('p2p_bidding_proposal_details');
		$this->db->where('proposal_id', $this->input->post('proposal_id'));
		$this->db->where('lenders_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	//API Borrower
	public function proposalInfoapi()
	{
		error_reporting(0);
		$this->db->select('ppd.proposal_id,      
                            ppd.PLRN,      
                            ppd.loan_amount,      
                            ppd.loan_purpose,      
                            ppd.min_interest_rate,      
                            ppd.max_interest_rate,      
                            ppd.prefered_interest_min,      
                            ppd.prefered_interest_max,      
                            ppd.tenor_months,      
                            ppd.loan_description,
                            ppd.bidding_status,
                            ppd.date_added,   
                            14-TIMESTAMPDIFF(DAY, DATE(ppd.date_added), CURDATE()) AS time_left, 
                            pbl.name, pbl.id AS borrower_id,
                            pbl.borrower_id AS b_borrower_id,
                            BPD.bid_registration_id,
                            BPD.bid_loan_amount,
                            BPD.interest_rate AS accepted_interest_rate,
                            BPD.accepted_tenor
                            ');
		$this->db->from('p2p_proposal_details ppd');
		$this->db->join('p2p_bidding_proposal_details BPD', 'BPD.proposal_id=ppd.proposal_id', 'left');
		$this->db->join('p2p_borrowers_list pbl', 'pbl.id=ppd.borrower_id', 'left');
		$this->db->where('ppd.proposal_id', $this->input->post('proposal_id'));
		$this->db->order_by('ppd.date_added', 'DESC');
		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			if ($result['bidding_status'] == 2 || $result['bidding_status'] == 4) {
				$emi = 0;

				// one month interest
				$r = $result['accepted_interest_rate'] / (12 * 100);

				// one month period
				$t = $result['accepted_tenor'];

				$emi = ($result['bid_loan_amount'] * $r * pow(1 + $r, $t)) /
					(pow(1 + $r, $t) - 1);
				$total_repayment_amount = $emi * $result['accepted_tenor'];
				$emi_date = date('Y-m-d', strtotime('+1 month'));
				return array(
					'bid_registration_id' => $result['bid_registration_id'],
					'loan_amount' => $result['bid_loan_amount'],
					'tenor' => $result['accepted_tenor'],
					'interest_rate' => $result['accepted_interest_rate'],
					'emi' => round($emi, 2),
					'emi_date' => $emi_date,
					'total_repayment_amount' => round($total_repayment_amount, 2),
					'processing_fee' => 1500,
					'loan_status' => 'Approved'
				);
			} else {
				return array(
					'bid_registration_id' => '',
					'loan_amount' => $result['loan_amount'],
					'tenor' => $result['tenor_months'],
					'interest_rate' => $result['prefered_interest_max'],
					'emi' => '',
					'emi_date' => '',
					'total_repayment_amount' => '',
					'processing_fee' => '',
					'loan_status' => 'Not Approved'
				);
			}

		}
	}

	public function proposal_days()
	{
		return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name' => 'open_proposal_days'))->row()->option_value;
	}

	public function getSubproductoptions($subProduct)
	{
		$res = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name' => $subProduct))->row()->option_value;
		return json_decode($res, true);
	}

	public function getAutoinvestlender()
	{
       $query = $this->db->select('ll.user_id, ll.lender_id, ll.name')
		   ->join('p2p_lender_list as ll', 'on ll.user_id = llp.lender_id', 'left')
		   ->order_by('llp.id', 'desc')
		   ->get_where('lender_loan_preferences as llp', array('llp.auto_investment' => 1));
       if($this->db->affected_rows()>0)
	   {
          return $res = $query->result_array();
	   }
       else{
         return false;
	   }
	}

	public function lenderPreferences($lender_id)
	{
       $query = $this->db->order_by('id', 'desc')->get_where('lender_loan_preferences', array('lender_id' => $lender_id));
       if($this->db->affected_rows()>0)
	   {
          $res = $query->row();
          $response = json_decode($res->preferences, true);
		  $where = "";
          if($response['product_preference'])
		  {
			  $where .= "ppd.p2p_product_id IN(".$response['product_preference'].")";
		  }
          if($response['min_antworks_rating'])
		  {
		  	if($response['product_preference']){
				$where .= " AND rating.antworksp2p_rating >= '".$response['min_antworks_rating']."'";
			}
		  	else{
				$where .= "rating.antworksp2p_rating >= '".$response['min_antworks_rating']."'";
			}

		  }
          if($where)
		  {
		  	return $where;
		  }
          else{
			return false;
		  }
	   }
       else{
         return false;
	   }
	}

	public function preferences($lender_id)
	{
		$query = $this->db->order_by('id', 'desc')->get_where('lender_loan_preferences', array('lender_id' => $lender_id));
		if($this->db->affected_rows()>0)
		{
			return $res = (array)$query->row();
		}
		else{
			return false;
		}
	}


}

?>
