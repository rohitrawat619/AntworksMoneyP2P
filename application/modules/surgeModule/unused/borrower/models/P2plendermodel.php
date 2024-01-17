<?php

class P2plendermodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_count_lenders()
	{
		return $this->db->count_all('p2p_lender_list');
	}

	public function getlenders($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this->db->order_by('user_id', 'desc');
		$query = $this->db->get('p2p_lender_list');
		return $query->result_array();
	}

	public function getlender($user_id)
	{
		$this->db->select('PLL.lender_id, PLL.lender_escrow_account_number, 
                           PLL.name, PLL.mobile, PLL.email, PLL.dob, PLL.pan, 
                           PLA.state, PLA.city, PLA.address1, PLA.address2,PLDT.father_name');
		$this->db->from('p2p_lender_list AS PLL');
		$this->db->join('p2p_lender_address AS PLA', 'PLL.user_id = PLA.lender_id', 'left');
		$this->db->join('p2p_lender_details_table AS PLDT', 'PLL.user_id = PLDT.lender_id', 'left');
		$this->db->where('PLL.user_id', $user_id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function getLenderofflinepayment($limit, $start)
	{
		$query = $this->db->select('ll.user_id, ll.lender_id, ll.name, ll.mobile, ll.email, opd.id as offline_id, opd.transactionId, opd.transaction_type, opd.amount, opd.approved_or_not, opd.created_date')
			->order_by('opd.id', 'desc')
			->join('p2p_lender_list as ll', 'on opd.lender_id = ll.user_id')
			->limit($limit, $start)
			->get_where('lender_offline_payment_details as opd');
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function count_offline_payment()
	{
		return $this->db->count_all('lender_offline_payment_details');
	}

	public function acceptOffline()
	{
		$query = $this->db->get_where('lender_offline_payment_details', array('approved_or_not' => '0', 'id' => $this->input->post('offline_id'), 'lender_id' => $this->input->post('user_id')));
		if ($this->db->affected_rows() > 0) {
			$offline_payment_details = $query->row();
			$this->db->where('id', $this->input->post('offline_id'));
			$this->db->where('lender_id', $this->input->post('user_id'));
			$this->db->set('approved_or_not', 1);
			$this->db->update('lender_offline_payment_details');
			if ($this->db->affected_rows() > 0) {
				$lender_balance = 0;
				$query = $this->db->get_where("p2p_lender_main_balance", array('lender_id' => $this->input->post('user_id')));
				if ($this->db->affected_rows() > 0) {
					$lender_account = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $this->input->post('user_id')))->row();
					$lender_balance = $lender_account->account_balance + $offline_payment_details->amount;
					$this->db->where('lender_id', $this->input->post('user_id'));
					$this->db->set('account_balance', $lender_balance);
					$this->db->update('p2p_lender_main_balance');
					if ($this->db->affected_rows() > 0) {
						$ledger_array = array(
							'lender_id' => $this->input->post('user_id'),
							'type' => 'pay_in',
							'title' => 'Money brought in (payin)',
							'reference_1' => $offline_payment_details->transactionId,
							'reference_2' => $offline_payment_details->id,
							'credit' => $offline_payment_details->amount,
							'balance' => $lender_balance,
						);
						$result = $this->Entryledger->addlenderstatementEntry($ledger_array);
						if ($result) {
							$pay_in = array(
								'lender_id' => $this->input->post('user_id'),
								'transaction_id' => $offline_payment_details->transactionId,
								'amount' => $offline_payment_details->amount,
								'reference' => 'pay_in',
							);
							$this->db->insert('p2p_lender_pay_in', $pay_in);
							return $msg = array('status' => 1, 'message' => "Approved successfully!!");
						} else {
							return $msg = array('status' => 0, 'message' => "Approved but not affected in ledger please contact to developer immediately");
						}

					} else {
						return $msg = array('status' => 0, 'message' => "Approved but not affected in balance please contact to developer immediately");
					}
				}
				else {
					$this->db->set("lender_id", $this->input->post('user_id'));
					$this->db->set("account_balance", $offline_payment_details->amount);
					$this->db->insert("p2p_lender_main_balance");
					if ($this->db->affected_rows() > 0) {
						$ledger_array = array(
							'lender_id' => $this->input->post('user_id'),
							'type' => 'pay_in',
							'title' => 'Money brought in (payin)',
							'reference_1' => $offline_payment_details->transactionId,
							'reference_2' => $offline_payment_details->id,
							'credit' => $offline_payment_details->amount,
							'balance' => $offline_payment_details->amount,
						);
						$result = $this->Entryledger->addlenderstatementEntry($ledger_array);
						if ($result) {
							$pay_in = array(
								'lender_id' => $this->input->post('user_id'),
								'transaction_id' => $offline_payment_details->transactionId,
								'amount' => $offline_payment_details->amount,
								'reference' => 'pay_in',
							);
							$this->db->insert('p2p_lender_pay_in', $pay_in);
							return $msg = array('status' => 1, 'message' => "Approved successfully!!");
						} else {
							return $msg = array('status' => 0, 'message' => "Approved but not affected in ledger please contact to developer immediately");
						}
					} else {
						return $msg = array('status' => 0, 'message' => "Approved but not affected in ledger please contact to developer immediately");
					}

				}
			} else {
				return $msg = array('status' => 0, 'message' => "Approved but not affected in balance please contact to developer immediately");
			}
		} else {
			return $msg = array('status' => 0, 'message' => "Already approved");
		}
	}

	public function getLenderinfo($lenderId)
	{
       $query = $this->db->select('ll.user_id, ll.lender_id, lmb.account_balance')
		   ->join('p2p_lender_main_balance lmb', 'ON lmb.lender_id = ll.user_id')->get_where('p2p_lender_list as ll', array('ll.lender_id' => $lenderId));
       if($this->db->affected_rows()>0)
	   {
          return (array)$query->row();
	   }
       else{
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
			$this->db->where('lenders_id', $this->input->post('lender_id'));
			$this->db->where('proposal_status', 1);
			$query = $this->db->get();
			if ($this->db->affected_rows() > 0) {
				return array('error' => 1, 'message' => "You already BID this proposal");
			} else {
				if ($this->input->post('loan_amount') > $proposal_info->loan_amount) // Condition to check Insert Bid
				{
					return array('error' => 1, 'message' => "Sorry check your bidding loan");
				}
				$total_bid_amount = $this->Biddingmodel->Total_bid_amount($this->input->post('proposal_id'));
				$remaining_amount = $proposal_info->loan_amount - $total_bid_amount['Totalbidamount'];
				if ($this->input->post('loan_amount') > $remaining_amount) // Condition to check Remaining Application Amount
				{
					return array('error' => 1, 'message' => "Bidding amount is greater then remaining amount");
				}
				$balance = $this->getaccountBalance($this->input->post('lender_id'));
				$allow_to_bid_amount = $balance['account_balance'] * $this->Biddingmodel->allow_to_bid_amount();
				if ($this->input->post('loan_amount') > $allow_to_bid_amount) {
					return array('error' => 1, 'message' => "You don't have sufficient balance for bid you account balance is " . $balance['account_balance'] . "", 'redirect_url' => base_url() . 'lender/pay-in');
				}
				$amountoffered = $this->input->post('loan_amount');
				$loan_amount_percentage = ($amountoffered / $proposal_info->loan_amount) * 100;
				if ($proposal_info->p2p_product_id == 2) {
					$subProductoptions = $this->Biddingmodel->getSubproductoptions($subProductid = 'CL1');
					$p2p_sub_product_id = 7;
					$proposal_submit_array = array(
						'proposal_id' => $this->input->post('proposal_id'),
						'p2p_sub_product_id' => $p2p_sub_product_id,
						'borrowers_id' => $proposal_info->borrower_id,
						'lenders_id' => $this->input->post('lender_id'),
						'bid_loan_amount' => $this->input->post('loan_amount'),
						'loan_amount' => $loan_amount_percentage,
						'interest_rate' => $subProductoptions['maximum_interest'],
						'accepted_tenor' => $subProductoptions['minimum_tenor'],
						'proposal_added_date' => date("Y-m-d H:i:s"),
					);
					$query = $this->db->insert('p2p_bidding_proposal_details', $proposal_submit_array);
				}
				else {
					if ($this->input->post('loan_amount') >= 1500 && $this->input->post('loan_amount') <= 10000) {
						if ($proposal_info->p2p_product_id == 1 || $proposal_info->p2p_product_id == 3) {
							$subProductoptions = $this->Biddingmodel->getSubproductoptions($subProductid = 'PL3');
							$p2p_sub_product_id = 3;
						}
						if ($proposal_info->p2p_product_id == 4) {
							$subProductoptions = $this->Biddingmodel->getSubproductoptions($subProductid = 'BL3');
							$p2p_sub_product_id = 6;
						}

						$proposal_submit_array = array(
							'proposal_id' => $this->input->post('proposal_id'),
							'p2p_sub_product_id' => $p2p_sub_product_id,
							'borrowers_id' => $proposal_info->borrower_id,
							'lenders_id' => $this->input->post('lender_id'),
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
							'lenders_id' => $this->input->post('lender_id'),
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
						'lender_id' => $this->input->post('lender_id'),
						'bid_registration_id' => $bid_registration_id,
						'lock_amount' => $this->input->post('loan_amount'),
					);
					$this->db->insert('p2p_lender_lock_amount', $lockedAMount);
					$total_bid_amount = $this->Biddingmodel->Total_bid_amount($this->input->post('proposal_id'));
					if ($total_bid_amount['Totalbidamount'] == $proposal_info->loan_amount) {
						$this->db->set('bidding_status', 2);
						$this->db->where('proposal_id', $this->input->post('proposal_id'));
						$this->db->update('p2p_proposal_details ');

					} else {
						$this->db->set('bidding_status', 4);
						$this->db->where('proposal_id', $this->input->post('proposal_id'));
						$this->db->update('p2p_proposal_details ');
					}
//					$borrower_info = $this->borrowers_info($proposal_info->borrower_id);
//					if ($borrower_info->gender == '1') {
//						$title = "Mr.";
//					} else {
//						$title = "Ms.";
//					}
//					$this->Smsmodule->Approved_Bid_borrower($title, $borrower_info->name, $amountoffered, $borrower_info->mobile);

					//Lender Notification
//					$lender_info = $this->profile();
//					if ($lender_info->gender == 1) {
//						$title = "Mr.";
//					} else {
//						$title = "Ms.";
//					}
//					$data['bid_list'] = $this->getTotalloanamountLenderinmarket();
//					$data['total_loan_amount_lender'] = array_sum(array_column($data['bid_list'], 'TOTALAMOUNT'));
//					$balance_amount = 1000000 - $data['total_loan_amount_lender'];
//					$this->Smsmodule->Lender_Approved_Bid($title, $lender_info->name, $amountoffered, $lender_info->mobile, $this->input->post('interest_rate'), $balance_amount);
					return array('error' => 0, 'message' => "Your bid was successfully, Thank you. Please keep bidding to more borrowers as we have got enough with similar profile");
				} else {
					return array('error' => 1, 'message' => "Something went wrong");
				}
			}
		} else {
			return array('error' => 1, 'message' => "This is not allowed here");
		}

	}

	public function getaccountBalance($lenderId)
	{
       $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $lenderId));
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function getautoinvestRequest()
	{
		$query = $this->db->select('lr.id as request_id, lr.status, lr.created_date, ll.user_id, ll.lender_id, ll.name, ll.mobile, ll.email')->join('p2p_lender_list ll', 'on ll.user_id = lr.lender_id', 'left')->order_by('lr.id', 'desc')->get_where('p2p_lender_requests lr', array('lr.type' => 'auto_investment'));
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
            return false;
		}
	}

	public function loanRestructuring()
	{
		$query = $this->db->select('dld.id as loan_id, bpd.loan_no, bl.name, ll.name as lender_name, dld.approved_loan_amount as loan_amount, bed.emi_date, plr.status, plr.extension_time')
			->join('p2p_loan_restructuring plr', 'on plr.loan_id = dld.id', 'right')
			->join('p2p_borrowers_list bl', 'on bl.id = dld.borrower_id', 'left')
			->join('p2p_lender_list ll', 'on ll.user_id = dld.lender_id', 'left')
			->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id', 'left')
			->join('p2p_borrower_emi_details bed', 'on bed.disburse_loan_id = dld.id', 'left')
			//->where_in('bpd.p2p_sub_product_id', array('3', '6'))
			//->where('bed.emi_date < CURDATE()')
			->get_where('p2p_disburse_loan_details dld', array(
				'dld.loan_status' => 0,
			));
		//echo "<pre>"; echo $this->db->last_query(); exit;
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function successfullbids($lenderId)
	{
		$this->db->select('PBPD.*, PD.PLRN, PBL.name AS borrower_name, ll.name as lender_name, 
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
		$this->db->from('p2p_bidding_proposal_details AS PBPD');
		$this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
		$this->db->join('p2p_borrowers_list AS PBL', 'PBL.id = PBPD.borrowers_id', 'left');
		$this->db->join('p2p_lender_list AS ll', 'll.user_id = PBPD.lenders_id', 'left');
		$this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
		$this->db->where('LAS.borrower_acceptance',1);
		$this->db->where('LAS.borrower_signature',1);
		$this->db->where('LAS.lender_signature','0');
		if($lenderId)
		{
			$this->db->where('ll.lender_id',$lenderId);
		}
		$this->db->order_by('PBPD.proposal_id','DESC');
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

	public function actionAcceptbid()
	{
		if($this->input->post('agree'))
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
				return array('error' => 0, 'message' => 'Bid Accepted successfully');
			}
			else{
				return array('error' => 1, 'message' => 'Bid Already Accepted');
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
				$this->db->update('p2p_loan_aggrement_signature');
				return array('error' => 1, 'message' => 'Bid Reject successfully');
			}
			else{
				return array('error' => 1, 'message' => 'Bid Already Rejected');
			}
		}


	}

	public function getLederbylender(){

	}

	public function getDebitCreditamount()
	{
		$query = $this->db->select('ll.user_id, ll.name as lender_name, ll.email, ll.mobile, lmb.account_balance')
				->join('p2p_lender_list ll', 'on ll.user_id = lmb.lender_id')
				->get_where('p2p_lender_main_balance lmb');
		if($this->db->affected_rows()>0)
		{
           $results = $query->result_array();
           foreach ($results as $result){
			   $query = $this->db->select("SUM(approved_loan_amount) as total_debit, lender_id")->where('approved_loan_amount is not NULL', NULL, true)->get_where('p2p_disburse_loan_details', array('lender_id' => $result['user_id'], 'DATE(date_created)' => date('Y-m-d')));
			   if($this->db->affected_rows()>0)
			   {
                 $debit = $query->row()->total_debit;
                 if($debit == NULL)
				 {
				 	$debit = 0;
				 }

			   }
			   else{
				   $debit = 0;
			   }
			   $query = $this->db->select("SUM(epd.emi_payment_amount) as total_credit, bed.lender_id")->join('p2p_borrower_emi_details bed', 'on bed.id = epd.emi_id')->where('epd.emi_payment_amount is not NULL')->get_where('p2p_emi_payment_details epd', array('bed.lender_id' => $result['user_id'], 'DATE(epd.created_date)' => date('Y-m-d')));
			   if($this->db->affected_rows()>0)
			   {
				   $credit = $query->row()->total_credit;
				   if($credit == NULL)
				   {
					   $credit = 0;
				   }
			   }
			   else{
				   $credit = 0;
			   }

			   $lenderdetaisl[] = array(
			   	'user_id' => $result['user_id'],
			   	'lender_name' => $result['lender_name'],
			   	'mobile' => $result['mobile'],
			   	'email' => $result['email'],
			   	'account_balance' => $result['account_balance'],
			   	'debit' => $debit,
			   	'credit' => $credit,
			   );

		   }
           return $lenderdetaisl;
		}
		else{
           return false;
		}
	}
}

?>
