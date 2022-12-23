<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

class Repaymentwebhook extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Requestmodel');
		$this->load->model('Entryledger');
	}

	public function index()
	{
		$json = file_get_contents("php://input");
		$json_response = json_decode($json, true);
		if ($json_response['event'] == 'order.paid') {
			$order_id = $json_response['payload']['order']['entity']['id'];
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if ($keys['razorpay_Testkey']['status'] == 1) {
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];

			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}

			$api = new Api($api_key, $api_secret);
			$order = $api->order->fetch($order_id);
			$amount = $order->amount / 100;
			if ($order->status == 'paid') {
				$query = $this->db->select('bid_registration_id')->get_where('p2p_bidding_proposal_details', array('loan_no' => $order->receipt));
				if ($this->db->affected_rows() > 0) {
					$bid_registration_id = $query->row()->bid_registration_id;
					$loan_info = $this->db->select('id, borrower_id, lender_id, approved_loan_amount')->get_where('p2p_disburse_loan_details', array('bid_registration_id' => $bid_registration_id))->row();
					if ($loan_info) {
						$query = $this->db->select('id, lender_id, emi_amount, emi_interest')->order_by('id', 'asc')->limit(1)->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $loan_info->id, 'status !=' => 1));
						if ($this->db->affected_rows() > 0) {
							$emi_details = $query->row();
							$emi_id = $emi_details->id;
							$emi_amount = $emi_details->emi_amount;
							if ($amount == $emi_amount) {
								$this->db->where('id', $emi_id);
								$this->db->set('status', 1);
								$this->db->update('p2p_borrower_emi_details');
								if ($this->db->affected_rows() > 0) {
									// EMi payment Details
									$arr_emi_details = array(
										'loan_id' => $loan_info->id,
										'emi_id' => $emi_id,
										'referece' => $order_id,
										'emi_payment_amount' => $amount,
										'emi_payment_date' => date('Y-m-d H:i:s'),
										'emi_payment_mode' => "Razorpay Webhook",
										'remarks' => "Payment Done at, " . date('Y-m-d H:i:s'),
										'is_verified' => 1,
										'created_date' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('p2p_emi_payment_details', $arr_emi_details);

									$lender_account = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $emi_details->lender_id))->row();

									$this->db->where('lender_id', $emi_details->lender_id);
									$this->db->set('account_balance', $lender_account->account_balance + $amount);
									$this->db->update('p2p_lender_main_balance');
									//Entry Ledger of lender
									$ledger_array = array(
										'lender_id' => $emi_details->lender_id,
										'type' => 'repayment_received',
										'title' => 'Repayment Received',
										'reference_1' => $order->receipt,
										'credit' => $amount,
										'balance' => $lender_account->account_balance + $amount,
									);
									$this->Entryledger->addlenderstatementEntry($ledger_array);
									//end
									// Now this is Inactive //Enter lender Pay IN if lender chose auto investment option right now auto investment is default ON
//							 $pay_in = array(
//							 	'lender_id'=>$emi_details->lender_id,
//							 	'transaction_id'=>$order->receipt,
//							 	'amount'=>$emi_details->emi_interest,
//								'reference'=>$order_id
//							 );
//							 $this->db->insert('p2p_lender_pay_in', $pay_in);

									//Check Loan for close
									$emi_principal = $this->db->select("SUM(emi_principal) as emi_principal")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $loan_info->id, 'status' => 1))->row()->emi_principal;
									if ($emi_principal == $loan_info->approved_loan_amount) {
										$this->db->where('id', $loan_info->id);
										$this->db->set('loan_status', 1);
										$this->db->update('p2p_disburse_loan_details');
									}
								}


							}
						} else {

						}
					} else {

					}
				}
			}
			$arr = array(
				'response' => $json ? $json : '',
			);
			$this->db->insert('webhook_repayment', $arr);
		}


	}

	public function repayemi()
	{
		if ($this->input->get('razorpay_payment_id') &&
			$this->input->get('razorpay_invoice_id') &&
			$this->input->get('razorpay_invoice_status') &&
			$this->input->get('razorpay_invoice_receipt') &&
			$this->input->get('razorpay_signature')) {
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if ($keys['razorpay_Testkey']['status'] == 1) {
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];
			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}
			$signature_payload = $this->input->get('razorpay_invoice_id') . '|' . $this->input->get('razorpay_invoice_receipt') . '|' .
				$this->input->get('razorpay_invoice_status') . '|' . $this->input->get('razorpay_payment_id');
			$expected_signature = hash_hmac('SHA256', $signature_payload, $api_secret);
			if ($this->input->get('razorpay_signature') == $expected_signature) {
				$query = $this->db->get_where('p2p_razorpay_emi_order_details', array('invoice_id' => $this->input->get('razorpay_invoice_id'), 'status' => 0));
				if ($this->db->affected_rows() > 0) {
					$result = (array)$query->row();
					if ($result['purpose'] == 'emi_payment') {
						$query = $this->db->get_where('p2p_borrower_emi_details', array('id' => $result['emi_id'], 'status' => 0));
						if ($this->db->affected_rows() > 0) {
							$emi_details = $query->row();
							$loan_info = $this->db->select('dld.id, dld.borrower_id, dld.lender_id, dld.approved_loan_amount, bpd.loan_no')
								->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id', 'left')
								->get_where('p2p_disburse_loan_details dld', array('dld.id' => $result['loan_id']))->row();
							if ($this->db->affected_rows() > 0) {
								$this->db->where('id', $result['emi_id']);
								$this->db->set('status', 1);
								$this->db->update('p2p_borrower_emi_details');
								if ($this->db->affected_rows() > 0) {
									$arr_emi_details = array(
										'loan_id' => $result['loan_id'],
										'emi_id' => $result['emi_id'],
										'referece' => $this->input->get('razorpay_payment_id'),
										'emi_payment_amount' => $result['amount'],
										'emi_payment_date' => date('Y-m-d H:i:s'),
										'emi_payment_mode' => "Razorpay Link P2P_recovery",
										'remarks' => "Payment Done at, " . date('Y-m-d H:i:s'),
										'is_verified' => 1,
										'created_date' => date('Y-m-d H:i:s'),
									);
									$this->db->insert('p2p_emi_payment_details', $arr_emi_details);

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
									$emi_principal = $this->db->select("SUM(emi_principal) as emi_principal")->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $result['loan_id'], 'status' => 1))->row()->emi_principal;
									if ($emi_principal == $loan_info->approved_loan_amount) {
										$this->db->where('id', $loan_info->id);
										$this->db->set('loan_status', 1);
										$this->db->update('p2p_disburse_loan_details');
									}
									//Update Razorpay order
									$this->db->where('id', $result['id']);
									$this->db->set('status', 1);
									$this->db->set('p2p_razorpay_emi_order_details');


									$this->load->view('frontend/borrower/thankyou-emi-payment');
								}
							}

						}

					}
				}

			} else {

			}

		} else {

		}

	}
}
?>
