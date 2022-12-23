<?php
class Borrowerresponsemodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

     public function insert_transaction_payment()
     {
         $transaction_array = array(
             'borrower_id'=>$this->session->userdata('borrower_id'),
             'razorpay_payment_id'=>$this->input->post('razorpay_payment_id'),
             'channel'=>'website',
         );
         $this->db->insert('p2p_borrower_registration_payment', $transaction_array);
         if($this->db->affected_rows()>0)
         {
             $this->db->set('step_2', 1);
             $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
             $this->db->update('p2p_borrower_steps');
             return true;
         }
         else{
             return false;
         }
     }

     public function updateEmiborrower()
	 {
         $this->load->model('Entryledger');
	 	 $emids = explode(',', $this->input->post('emi_ids'));

	 	 $emids_values = count($emids);
		 foreach ($emids AS $emid){
		 	$query = $this->db->get_where('p2p_borrower_emi_details', array('id' => $emid, 'disburse_loan_id' => $this->input->post('loan_id')));
		 	if( $this->db->affected_rows() > 0 ) {
				$emi_details = $query->row();
				$loan_info = $this->db->select('dld.id, dld.borrower_id, dld.lender_id, dld.approved_loan_amount, bpd.loan_no')->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id', 'left')->get_where('p2p_disburse_loan_details dld', array('dld.id' => $this->input->post('loan_id')))->row();
				if ($loan_info) {
					$this->db->where('borrower_id', $this->session->userdata('borrower_id'));
					$this->db->where('id', $emid);
					$this->db->set('status', 1);
					$this->db->update('p2p_borrower_emi_details');
					if ($this->db->affected_rows() > 0) {

						//Emi Payment Details
						$emi_payment_detail = array(
							'loan_id' => $this->input->post('loan_id'),
							'emi_id' => $emid,
							'referece' => $this->input->post('razorpay_payment_id'),
							'emi_payment_amount' => $emi_details->emi_amount,
							'emi_payment_date' => date('Y-m-d H:i:s'),
							'remarks' => 'Payment Done at, ' . date('Y-m-d H:i:s'),
							'is_verified' => 1,
						);
						$this->db->insert('p2p_emi_payment_details', $emi_payment_detail);

						$lender_account = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $emi_details->lender_id))->row();
						$balance = $lender_account->account_balance + $emi_details->emi_amount;
						$this->db->where('lender_id', $emi_details->lender_id);
						$this->db->set('account_balance', $balance);
						$this->db->update('p2p_lender_main_balance');
						//Entry Ledger of lender
						$ledger_array = array(
							'lender_id' => $emi_details->lender_id,
							'type' => 'repayment_received',
							'title' => 'Repayment Received',
							'reference_1' => $loan_info->loan_no,
							'credit' => $emi_details->emi_amount,
							'balance' => $balance,
						);
						$this->Entryledger->addlenderstatementEntry($ledger_array);
						//Check Loan for close
						$emi_principal = $this->db->select("SUM(emi_principal) as emi_principal")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $loan_info->id, 'status' => 1))->row()->emi_principal;
						if ($emi_principal == $loan_info->approved_loan_amount) {
							$this->db->where('id', $loan_info->id);
							$this->db->set('loan_status', 1);
							$this->db->update('p2p_disburse_loan_details');
						}

					}
				}


			}
		 }
		 return true;

	 }

	 public function updateForeclosureborrower()
	 {
		 $emids = explode(',', $this->input->post('emi_ids'));

		 $emids_values = count($emids);
		 foreach ($emids AS $emid){
			 $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
			 $this->db->where('id', $emid);
			 $this->db->set('status', 1);
			 $this->db->update('p2p_borrower_emi_details');

			 $this->db->set('loan_id', $this->input->post('loan_id'));
			 $this->db->set('emi_id', $emid);
			 $this->db->set('referece', $this->input->post('razorpay_payment_id'));
			 $this->db->insert('p2p_emi_payment_details');
			 //Update Loan Status
		 }
		 return true;
	 }
}
?>
