<?php
require APPPATH . 'third_party/razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

class Ordermodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Requestmodel', 'Payumodel'));
	}

	protected $interest = 0;

	public function generateOrder()
	{
     
		$query = $this->db->get_where('p2p_loan_list', array('borrower_id' => $this->input->post('borrower_id'), 'id' => $this->input->post('loan_id')));
		if ($this->db->affected_rows() > 0)
		{
			$loan_details = $query->row_array();
		}
		$percentage = .0215;
		//$this->interest = $info['fee_rate'] / 100;
		$this->interest = 0;
		$amount = $loan_details['approved_loan_amount'] + ($loan_details['approved_loan_amount'] * $loan_details['approved_interest'])/100;
		$order = array(
			'borrower_id' => $this->input->post('borrower_id') ? $this->input->post('borrower_id') : '',
			'loan_id' => $this->input->post('loan_id') ? $this->input->post('loan_id') : '',
			'amount' => $amount,
			'fee_rate' => $this->interest,
			'service' => 'Repayment',
			'channel' => 'PG - PAYU',
			'pg_type' => 'payu'
		);
		if ($this->input->post('service') == 'Repayment') {
			
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];

			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}
			
			#Amount in Paise
            $api = new Api($api_key, $api_secret);
			$order = $api->order->create(array(
					'amount' => $this->input->post('amount')*100,
					'currency' => 'INR'
				)
			);
			
			$order_id = $order->id;
			if ($order_id) {
				#genetare order
				$order = array(
					'mobile' => $this->input->post('mobile'),
					'amount' => $this->input->post('amount'),
					'fee_rate' => $this->input->post('amount') * $this->interest,
					'order_id' => $order_id,
					'borrower_id' => $loan_details['borrower_id'],
					'loan_id' => $loan_details['id'],
					'service' => $this->input->post('service'),
					'channel' => 'PG',
				);
				$txnid = generateAnt_Order($order);
				#end

				return array(
					'status' => '1',
					'txnid' => $txnid,
					'fee' => 0,
					'amount' => $this->input->post('amount'),
					'final_amount' => $this->input->post('amount'),
					'order_id' => $order_id,
					'loan_id' => $loan_details['id'],
					'api_key' => $api_key,
					'pg_type' => 'Razorpay',
					'channel' => 'PG',
					'msg' => 'Order generate successfully',
				);
			} else {
				return array(
					'status' => '0',
					'txnid' => '',
					'fee' => round($this->input->post('amount') * $this->interest, 2),
					'amount' => $this->input->post('amount'),
					'final_amount' => round($this->input->post('amount') + ($this->input->post('amount') * $this->interest), 2),
					'order_id' => '',
					'loan_id' => $this->input->post('loan_id'),
					'api_key' => '',
					'pg_type' => 'Razorpay',
					'channel' => 'PG',
					'msg' => 'Sorry Something went wrong please try again',
				);
			}
		}
		

		/* $key = PAYU_KEY;
		$salt = PAYU_SALT;
		//$arr = $order;
		$arr['txnid'] = $txnid;
		$arr['fee'] = 0;
		$arr['amount'] = $amount;
		$arr['final_amount'] = $amount;
		$arr['key'] = $key;
		return $arr; */
	}

	public function fee_rate()
	{
		$query = $this->db->get_where('activate_pg_by_services', array('service_name' => $this->input->post('service')));
		if ($this->db->affected_rows() > 0) {
			$info = $query->result_array();
			return array(
				'status' => '1',
				'PG' => $info[0]['fee_rate'],
				'pg_short_text' => $info[0]['fee_rate'] . '% convenience fee extra',
				'pg_long_text' => $info[0]['fee_rate'] . '% convenience fee extra',
				'UPI' => number_format(($info[1]['fee_rate']), 2, '.', ''),
				'upi_short_text' => number_format(($info[1]['fee_rate']), 2, '.', '') . '% convenience fee extra',
				'upi_long_text' => number_format(($info[1]['fee_rate']), 2, '.', '') . '% convenience fee extra',
				'activate_pg' => $info[0]['pg_name'],
				'msg' => 'Details found',
			);
		} else {
			return array(
				'status' => '0',
				'msg' => 'sorry not found',
			);
		}
	}

	public function verify_order()
	{

	}
}
