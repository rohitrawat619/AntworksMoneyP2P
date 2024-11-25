<?php

class Borrowerinfomodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function calculateRepaymentAmountInDays($principal, $annualInterestRate, $timeInDays) {
    
		$timeInYears = $timeInDays / 365;
	
		$interest = ($principal * $annualInterestRate * $timeInYears) / 100;
		$repaymentAmount= $principal + $interest;
		return round($repaymentAmount);
		
	}

	public function loan_details()
	{
		$query = $this->db->order_by('id', 'desc')->get_where('p2p_loan_list', array('borrower_id' => $this->input->post('borrower_id')));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			
			foreach ($results as $result) {
				
				
			if($result['disbursed_flag']==1){
				$available_limit = '0';
				$use_limit = '2550';
			}else{
				$available_limit = '2500';
				$use_limit = '0';
			}
				$query2 = $this->db->select('status as payment_status')->order_by('id', 'desc')->get_where('p2p_order_list', array('loan_id' => $result['id'],'borrower_id' => $result['borrower_id']));
				
				if ($this->db->affected_rows() > 0) {
					$payment_status = (array)$query2->row();
				}else{
					$payment_status['payment_status'] = ""; // 2024-april-22
				}
				
				$due_status = '';
				if($result['disbursement_date'] && date('d-m-Y') < date('d-m-Y', strtotime($result['disbursement_date']. ' + 1 months'))){
				 $due_status = 'Not Due';	
				}if($result['disbursement_date'] && date('d-m-Y') > date('d-m-Y', strtotime($result['disbursement_date']. ' + 1 months'))){
				 $due_status = 'Over due';	
				}
				if($result['approved_tenor_days']=="" || $result['approved_tenor_days']=="0"){
					$tenureType = "Month";
					$tenure = $result['approved_tenor'];
					$repaymentAmount = $result['approved_loan_amount'] + ($result['approved_loan_amount'] * $result['approved_interest'])/100;
				}
				else{
					$tenureType = "Days ";
					$tenure = $result['approved_tenor_days'];
					$repaymentAmount = $this->calculateRepaymentAmountInDays($result['approved_loan_amount'],$result['approved_interest'],$result['approved_tenor_days']);
				}
				
				$loan[] = array(
					'id' => $result['id'],
					'loan_no' => $result['loan_no'],
					'borrower_disbursement_request' => $result['disbursement_request'],
					'disburse_amount' => $result['approved_loan_amount'],
					'approved_interest' => $result['approved_interest'] . '%',
					'approved_tenor' => $tenure . $tenureType,//' Month',
					'disbursement_date' => $result['disbursement_date'] ?date("Y-m-d",strtotime($result['disbursement_date'])):null,
					'repayment_amount' => $repaymentAmount,
					'repayment_date' => $result['disbursement_date'] ? date('d-m-Y', strtotime($result['disbursement_date']. ' + 1 months')) : $result['disbursement_date'],
					'disbursed_flag' => $result['disbursed_flag'],
					'loan_status' => $result['loan_status']?$result['loan_status']:null,
					'due_status' => $due_status,
					'payment_status' => $payment_status['payment_status'],
					'lender_name' => 'Antworks P2P',
				);
			}
			
			return array(
				'status' => 1,
                'available_limit' => $available_limit,
                'use_limit' => $use_limit,
				'loan_list' => $loan,
				'msg' => 'Loan list found'
			);
		} else {
			return array(
				'status' => 0,
				'loan_list' => array(),
				'msg' => 'Sory Loan list not found'
			);
		}
	}
	public function borrower_details($borrowerId)
	{
		$query = $this->db
			->select("
              bl.id,
              bl.borrower_id,
              bl.name,
              bl.email,
              bl.mobile,
              bl.gender,
              bl.dob,
              bl.highest_qualification,
              bl.marital_status,
              bl.pan,
              o.occuption_type,
              o.company_type,
              o.company_name,
              o.net_monthly_income,
              o.salary_process,
              address.r_address,
              address.r_address1,
              address.r_city,
              address.r_state,
              address.r_pincode
            ")
			->join('p2p_borrower_address_details as address', 'address.borrower_id = bl.id', '')
			->join('p2p_borrower_occuption_details as o', 'o.borrower_id = bl.id', 'left')
			->get_where('p2p_borrowers_list as bl', array('bl.id' => $borrowerId));
		if ($this->db->affected_rows() > 0) {
			$result = $query->row_array();
			return $response = array(
				'status' => 1,
				'borrower_details' => $result,
				'msg' => 'found',
			);
		} else {
			return false;
		}
	}
	public function get_personalDetails($borrowerId)
	{

		$this->db->select('BL.name ,BL.email ,BL.mobile, BL.gender,BL.dob, BS.step_1 AS email_verified_or_not');
		$this->db->join('p2p_borrower_steps_credit_line AS BS', 'ON BS.borrower_id = BL.id', 'left');
		$this->db->where('BL.id', $borrowerId);
		$this->db->from('p2p_borrowers_list AS BL');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}
#Old Function
	

	public function get_residentalDetails($borrowerId)
	{

		$sql = "SELECT  UI.r_address, UI.r_address1,UI.r_city,UI.r_pincode,UI.present_residence , UR.state AS r_state 
              FROM p2p_borrower_address_details AS UI
              LEFT JOIN p2p_state_experien UR 
               ON  UR.id= UI.r_state WHERE UI.borrower_id = $borrowerId";

		$query = $this->db->query($sql);

		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function get_OccupationDetails($borrowerId)
	{

		$sql = "SELECT  UR.name AS occuption_type ,UI.company_type, UI.company_name,UI.total_experience,
                          UI.current_emis,UI.salary_process ,UI.net_monthly_income ,UI.turnover_last_year  

               FROM p2p_borrower_occuption_details AS UI
               LEFT JOIN p2p_occupation_details_table UR 
               ON  UR.id= UI.occuption_type WHERE UI.borrower_id = $borrowerId";

		$query = $this->db->query($sql);

		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	public function get_accountDetails($borrowerId)
	{

		$this->db->select('bank_name ,account_number, ifsc_code, account_type');
		$this->db->where('borrower_id', $borrowerId);
		$this->db->from('p2p_borrower_bank_details');
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}

	
}

?>
