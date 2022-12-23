<?php

class Lenderresponsemodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Entryledger');
	}

	public function insert_transaction_payment()
	{
		$transaction_array = array(
			'lender_id' => $this->session->userdata('user_id'),
			'razorpay_payment_id' => $this->input->post('razorpay_payment_id'),
		);
		$this->db->insert('p2p_lender_registration_payment', $transaction_array);
		if ($this->db->affected_rows() > 0) {
			$this->db->set('step_2', 1);
			$this->db->where('lender_id', $this->session->userdata('user_id'));
			$this->db->update('p2p_lender_steps');
			return true;
		} else {
			return false;
		}
	}

	public function add_amount_in_escrow($amount)
	{
		$ledger_array = array();
		$this->db->select('*');
		$this->db->from('p2p_lender_main_balance');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();

			$final_amount = $result['account_balance'] + $amount;
			$this->db->set('account_balance', $final_amount);
			$this->db->where('lender_id', $this->session->userdata('user_id'));
			$this->db->update('p2p_lender_main_balance');
			$ledger_array = array(
				'lender_id' => $this->session->userdata('user_id'),
				'type' => 'pay_in',
				'title' => 'Money brought in (payin)',
				'reference_1' => $this->input->post('razorpay_payment_id'),
				'credit' => $amount,
				'balance' => $final_amount,
			);
		} else {
			$main_balance = array(
				'lender_id' => $this->session->userdata('user_id'),
				'account_balance' => $amount,
			);
			$this->db->insert('p2p_lender_main_balance', $main_balance);
			$ledger_array = array(
				'lender_id' => $this->session->userdata('user_id'),
				'type' => 'pay_in',
				'title' => 'Money brought in (payin)',
				'reference_1' => $this->input->post('razorpay_payment_id'),
				'credit' => $amount,
				'balance' => $amount,
			);
		}

		$this->Entryledger->addlenderstatementEntry($ledger_array);
		//Entry In PAY IN

		$pay_in = array(
			'lender_id' => $this->session->userdata('user_id'),
			'transaction_id' => $this->input->post('razorpay_payment_id'),
			'amount' => $amount,
			'reference' => 'pay_in',
			);
		$this->db->insert('p2p_lender_pay_in', $pay_in);
		return true;
	}

}

?>
