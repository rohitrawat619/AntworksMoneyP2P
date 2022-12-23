<?php

class P2papplicationmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function count_active_application()
	{
		return $this->db->count_all('p2p_proposal_details');
	}

	public function get_count_partially_approve_application()
	{
		return $this->db->count_all('p2p_proposal_details');
	}

	public function get_active_application($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->where_in('bidding_status', array('1', '4'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$bids = array();
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();

					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}

			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function active_application_search()
	{
		$where = "";
		if ($this->input->post('start_date')) {
			$post_date = explode('+', $this->input->post('start_date'));
			$date = explode('-', $post_date[0]);
			$start_date = $date[0];
			$end_date = $date[1];
			// Date Format
			$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
			$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

			$where = "PD.created_date > '$start_date' AND PD.created_date < '$end_date'";
		}

		/*if($this->input->post('loan_id'))
		{
			$where .= "BPD.loan_no = '".$this->input->post('loan_id')."'";

		}*/
		if ($this->input->post('name')) {
			$where .= "BL.name = '" . $this->input->post('name') . "'";

		}
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->where_in('bidding_status', array('1', '4'));
		$this->db->where($where);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$bids = array();
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();

					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}

			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function get_application_details($plnr)
	{
		$this->db->select('PD.*, 
                           BL.name AS Borrowername, 
                           BL.mobile AS borrower_mobile,
                           BL.email AS borrower_email,
                           BL.dob AS dob,
                           BL.gender AS gender,
                           BL.marital_status AS marital_status,
                           BL.occuption_id,
                           PBA.r_address,
                           PBA.r_address1,
                           PBA.r_state,
                           PBA.r_city,
                           PBA.r_pincode,
                           PQ.qualification,
                           PO.name AS Occuption_name                           
                           ');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
		$this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
		$this->db->where('PLRN', $plnr);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			foreach ($active_applications as $active_application) {
				$bids = array();
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();

					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$occuption_detials = array();

				if ($active_application['occuption_id'] = 1) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_salaried_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 2) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_self_business_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 3) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_self_professional_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 4) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_retired_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 5) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_student_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 6) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_homemaker');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 7) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_others');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}

				$kyc_document = array();

				$this->db->select('*');
				$this->db->from('p2p_borrowers_docs_table');
				$this->db->where('borrower_id', $active_application['borrower_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$kyc_document = $query->result_array();
				}

				$active_all_applications = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_dob' => $active_application['dob'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_gender' => $active_application['gender'],
					'marital_status' => $active_application['marital_status'],
					'borrower_qualification' => $active_application['qualification'],
					'Occuption_name' => $active_application['Occuption_name'],
					'r_address' => $active_application['r_address'],
					'r_address1' => $active_application['r_address1'],
					'borrower_city' => $active_application['r_city'],
					'r_state' => $active_application['r_state'],
					'r_pincode' => $active_application['r_pincode'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
					'occuption_details' => $occuption_detials ? $occuption_detials : '',
					'borrower_kyc_document' => $kyc_document,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function approval_pending_application()
	{
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
		$this->db->where('PD.bidding_status', 1);
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();
					$bids = array();
					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function partially_approve_application($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
		$this->db->where('PD.bidding_status', 4);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();
					$bids = array();
					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function approved_application()
	{
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city,
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
                                LAS.lender_signature_date');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->join('p2p_bidding_proposal_details AS PBP', 'ON PBP.proposal_id = PD.proposal_id', 'left');
		$this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBP.bid_registration_id', 'left');
		$this->db->where('LAS.borrower_signature', 1);
		$this->db->where('LAS.lender_signature', 1);
		$this->db->where('LAS.credit_ops_signature', 1);
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername,
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
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PDP.bid_registration_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$this->db->where('LAS.borrower_signature', 1);
				$this->db->where('LAS.lender_signature', 1);
				$this->db->where('LAS.credit_ops_signature', 1);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();
					$bids = array();
					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function approved_application_details($plnr)
	{
		$this->db->select('PD.*, 
                           BL.name AS Borrowername, 
                           BL.mobile AS borrower_mobile,
                           BL.email AS borrower_email,
                           BL.dob AS dob,
                           BL.gender AS gender,
                           BL.marital_status AS marital_status,
                           BL.occuption_id,
                           PBA.r_address,
                           PBA.r_address1,
                           PBA.r_state,
                           PBA.r_city,
                           PBA.r_pincode,
                           PQ.qualification,
                           PO.name AS Occuption_name                           
                           ');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
		$this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
		$this->db->where('PLRN', $plnr);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			foreach ($active_applications as $active_application) {
				$bids = array();
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$this->db->where('PDP.borrower_signature', 1);
				$this->db->where('PDP.borrower_acceptance', 1);
				$this->db->where('PDP.admin_acceptance', 1);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();

					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$occuption_detials = array();

				if ($active_application['occuption_id'] = 1) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_salaried_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 2) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_self_business_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 3) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_self_professional_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 4) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_retired_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 5) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_student_details');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 6) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_homemaker');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}
				if ($active_application['occuption_id'] = 7) {
					$this->db->select('*');
					$this->db->from('p2p_borrower_others');
					$this->db->where('borrower_id', $active_application['borrower_id']);
					$query = $this->db->get();
					if ($this->db->affected_rows() > 0) {
						$occuption_detials = (array)$query->row();
					}
				}

				$kyc_document = array();

				$this->db->select('*');
				$this->db->from('p2p_borrowers_docs_table');
				$this->db->where('borrower_id', $active_application['borrower_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$kyc_document = $query->result_array();
				}

				$active_all_applications = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_dob' => $active_application['dob'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_gender' => $active_application['gender'],
					'marital_status' => $active_application['marital_status'],
					'borrower_qualification' => $active_application['qualification'],
					'Occuption_name' => $active_application['Occuption_name'],
					'r_address' => $active_application['r_address'],
					'r_address1' => $active_application['r_address1'],
					'borrower_city' => $active_application['r_city'],
					'r_state' => $active_application['r_state'],
					'r_pincode' => $active_application['r_pincode'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
					'occuption_details' => $occuption_detials ? $occuption_detials : '',
					'borrower_kyc_document' => $kyc_document,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function rejected_application()
	{
		$this->db->select('PD.*, BL.name AS Borrowername, BL.mobile AS borrower_mobile,BL.email AS borrower_email, PBA.r_city');
		$this->db->from('p2p_proposal_details AS PD');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = PD.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = PD.borrower_id', 'left');
		$this->db->where('PD.bidding_status', 3);
		$query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();

			foreach ($active_applications as $active_application) {
				$this->db->select('PDP.bid_registration_id, PDP.proposal_id, PDP.borrowers_id, PDP.lenders_id, PDP.bid_loan_amount, PDP.loan_amount, PDP.interest_rate,
                                 PL.name AS Lendername
                                ');
				$this->db->from('p2p_bidding_proposal_details AS PDP');
				$this->db->join('p2p_lender_list AS PL', 'ON PL.user_id = PDP.lenders_id', 'left');
				$this->db->where('PDP.proposal_id', $active_application['proposal_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$bid_info = $query->result_array();
					$bids = array();
					foreach ($bid_info as $bid) {
						$bids[$bid['bid_registration_id']] = array(
							'bid_registration_id' => $bid['bid_registration_id'],
							'proposal_id' => $bid['proposal_id'],
							'borrowers_id' => $bid['borrowers_id'],
							'lenders_id' => $bid['lenders_id'],
							'lender_name' => $bid['Lendername'],
							'bid_loan_amount' => $bid['bid_loan_amount'],
							'loan_amount' => $bid['loan_amount'],
						);
					}
				}

				$active_all_applications[] = array(
					'proposal_id' => $active_application['proposal_id'],
					'PLRN' => $active_application['PLRN'],
					'borrower_id' => $active_application['borrower_id'],
					'Borrowername' => $active_application['Borrowername'],
					'borrower_mobile' => $active_application['borrower_mobile'],
					'borrower_email' => $active_application['borrower_email'],
					'borrower_city' => $active_application['r_city'],
					'loan_amount' => $active_application['loan_amount'],
					'loan_purpose' => $active_application['loan_purpose'],
					'min_interest_rate' => $active_application['min_interest_rate'],
					'max_interest_rate' => $active_application['max_interest_rate'],
					'tenor_months' => $active_application['tenor_months'],
					'loan_description' => $active_application['loan_description'],
					'bidding_status' => $active_application['bidding_status'],
					'date_added' => $active_application['date_added'],
					'bids_by_lender' => $bids,
				);
			}


			return $active_all_applications;
		} else {
			return false;
		}
	}

	public function capproved_application($limit, $start)
	{
		//$proposal_days = $this->Requestmodel->proposal_days();
		$this->db->limit($limit, $start);
		$this->db->select('BPD.bid_registration_id,BPD.loan_no,LAS.borrower_signature,
            LAS.lender_signature,BL.borrower_id,BL.name AS borrowerName,LL.lender_id,LL.name AS lenderName,
            BPD.interest_rate AS accepted_interest_rate,PD.PLRN, PD.date_added,PD.loan_amount,BPD.accepted_tenor AS tenor_months');
		$this->db->from('p2p_bidding_proposal_details AS BPD');
		$this->db->JOIN('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = BPD.bid_registration_id', 'left');
		$this->db->JOIN('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
		$this->db->JOIN('p2p_lender_list AS LL', 'ON LL.user_id = BPD.lenders_id', 'left');
		$this->db->JOIN('p2p_proposal_details AS PD', 'ON PD.proposal_id = BPD.proposal_id', 'left');
		$this->db->where('LAS.borrower_acceptance', '1');
		$this->db->where('LAS.borrower_signature', '1');
		$this->db->where('LAS.lender_signature', '1');
		$this->db->where('LAS.credit_ops_signature', '1');
		$this->db->order_by('BL.id', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			return $active_applications;
		} else {
			return false;
		}

	}

	public function approved_search()
	{
		$where = "";
		if ($this->input->post('start_date')) {
			$post_date = explode('+', $this->input->post('start_date'));
			$date = explode('-', $post_date[0]);
			$start_date = $date[0];
			$end_date = $date[1];
			// Date Format
			$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
			$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

			$where = "PD.created_date > '$start_date' AND PD.created_date < '$end_date'";
		}

		if ($this->input->post('loan_id')) {
			$where .= "BPD.loan_no = '" . $this->input->post('loan_id') . "'";

		}
		if ($this->input->post('name')) {
			$where .= "BL.name = '" . $this->input->post('name') . "'";

		}
		$this->db->select('BPD.bid_registration_id,BPD.loan_no,LAS.borrower_signature,
            LAS.lender_signature,BL.borrower_id,BL.name AS borrowerName,LL.lender_id,LL.name AS lenderName,
            BPD.interest_rate AS accepted_interest_rate, PD.date_added,PD.loan_amount,PD.tenor_months');
		$this->db->from('p2p_bidding_proposal_details AS BPD');
		$this->db->JOIN('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = BPD.bid_registration_id', 'left');
		$this->db->JOIN('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
		$this->db->JOIN('p2p_lender_list AS LL', 'ON LL.user_id = BPD.lenders_id', 'left');
		$this->db->JOIN('p2p_proposal_details AS PD', 'ON PD.proposal_id = BPD.proposal_id', 'left');
		$this->db->where('LAS.borrower_acceptance', '1');
		$this->db->where('LAS.borrower_signature', '1');
		$this->db->where('LAS.lender_signature', '1');
		$this->db->where('LAS.credit_ops_signature', '1');
		$this->db->where($where);
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			return $active_applications;
		} else {
			return false;
		}

	}

	public function get_count_approval_pending()
	{
		return $this->db->count_all('p2p_proposal_details');
	}

	public function approval_pending($limit, $start)
	{

		$this->db->limit($limit, $start);
		$this->db->select('BPD.bid_registration_id,BPD.loan_no,LAS.borrower_signature,
            LAS.lender_signature,BL.borrower_id,BL.name AS borrowerName,LL.lender_id,LL.name AS lenderName,
            BPD.interest_rate AS accepted_interest_rate,BPD.bid_loan_amount,PD.PLRN, PD.date_added,PD.loan_amount,BPD.accepted_tenor AS tenor_months');
		$this->db->from('p2p_bidding_proposal_details AS BPD');
		$this->db->JOIN('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = BPD.bid_registration_id', 'left');
		$this->db->JOIN('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
		$this->db->JOIN('p2p_lender_list AS LL', 'ON LL.user_id = BPD.lenders_id', 'left');
		$this->db->JOIN('p2p_proposal_details AS PD', 'ON PD.proposal_id = BPD.proposal_id', 'left');
		$this->db->where('LAS.credit_ops_signature != 1');
		$this->db->order_by('BL.id', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			return $active_applications;
		} else {
			return false;
		}

	}

	public function pending_search()
	{
		$where = "";
		if ($this->input->post('start_date')) {
			$post_date = explode('+', $this->input->post('start_date'));
			$date = explode('-', $post_date[0]);
			$start_date = $date[0];
			$end_date = $date[1];
			// Date Format
			$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
			$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

			$where = "PD.created_date > '$start_date' AND PD.created_date < '$end_date'";
		}

		if ($this->input->post('loan_id')) {
			$where .= "BPD.loan_no = '" . $this->input->post('loan_id') . "'";

		}
		if ($this->input->post('name')) {
			$where .= "BL.name = '" . $this->input->post('name') . "'";

		}

		$this->db->select('BPD.bid_registration_id,BPD.loan_no,LAS.borrower_signature,
            LAS.lender_signature,BL.borrower_id,BL.name AS borrowerName,LL.lender_id,LL.name AS lenderName,
            BPD.interest_rate AS accepted_interest_rate,PD.date_added,PD.loan_amount,PD.tenor_months');
		$this->db->from('p2p_bidding_proposal_details AS BPD');
		$this->db->JOIN('p2p_loan_aggrement_signature AS LAS', 'ON LAS.bid_registration_id = BPD.bid_registration_id', 'left');
		$this->db->JOIN('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
		$this->db->JOIN('p2p_lender_list AS LL', 'ON LL.user_id = BPD.lenders_id', 'left');
		$this->db->JOIN('p2p_proposal_details AS PD', 'ON PD.proposal_id = BPD.proposal_id', 'left');
		$this->db->where('LAS.credit_ops_signature != 1');
		$this->db->where($where);
		$query = $this->db->get();
		// echo $this->db->last_query();die;
		if ($this->db->affected_rows() > 0) {
			$active_applications = $query->result_array();
			return $active_applications;
		} else {
			return false;
		}
	}


}

?>
