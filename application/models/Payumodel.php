<?php
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
class Payumodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Requestmodel');
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
					'loan_id' => $this->input->post('loan_id'),
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
    public function generateHash()
	{
		$key = PAYU_KEY;
		$req_arr = explode('|', $this->input->post('pipe_string_value'));
		$mid = $req_arr[0];
		$salt = $this->get_salt($mid);
		$pipe_string = $this->input->post('pipe_string_value') . $salt;
		$arr['status'] = "1";
		$arr['payment_hash'] = hash('SHA512', $pipe_string);

		return $arr;
	}
	public function checkNull($value)
	{
		if ($value == null) {
			return '';
		} else {
			return $value;
		}
	}

	public function payUresponse()
	{
		error_reporting(0);

		$reverseHash = $this->generateReverseHash();


		if ($_POST["hash"] == $reverseHash) {
			# transaction is successful
			# do the required javascript task
			if($_POST['status'] == 'success')
			{
				$this->db->where('transaction_no', $_POST["txnid"]);
				$this->db->set('status', 'success');
				$this->db->update('ant_app_order_list');
				$this->load_wallet();
			}

			$this->AndroidSuccess($_POST["amount"]);


		} else {
			# transaction is tempered
			# handle it as required
			echo("<br>");
			echo "\nInvalid transaction";
			exit;

		}

		//file_put_contents('payulog', json_encode($_POST));
		return true;
	}

	public function payUresponse_fail()
	{
		error_reporting(0);
		$this->db->where('transaction_no', $_POST["txnid"]);
		$this->db->set('status', 'failed');
		$this->db->update('ant_app_order_list');

		$reverseHash = $this->generateReverseHash();


		if ($_POST["hash"] == $reverseHash) {
			# transaction is successful
			# do the required javascript task
			$this->db->where('transaction_no', $_POST["txnid"]);
			$this->db->set('status', 'failed');
			$this->db->update('ant_app_order_list');

			$this->AndroidSuccess($_POST["amount"]);


		} else {
			# transaction is tempered
			# handle it as required
			echo("<br>");
			echo "\nInvalid transaction";
			exit;

		}

		//file_put_contents('payulog', json_encode($_POST));
		return true;
	}

	public function AndroidSuccess($input)
	{

		echo("Transaction Success & Verified");
		echo '<script type="text/javascript">';
		echo 'PayU.onSuccess("Amount =" +' . $_POST["amount"] . ')';
		echo "</script>";
		exit;
	}

	# Function to generate reverse hash
	public function generateReverseHash()
	{
		$salt = $this->get_salt($_POST["key"]);
		if ($_POST["additional_charges"] != null) {


			$reversehash_string = $_POST["additional_charges"] . "|" . $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" .
				$_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $_POST["amount"] . "|" . $_POST["txnid"] . "|" . $_POST["key"];


		} else {
			$reversehash_string = $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" .
				$_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $_POST["amount"] . "|" . $_POST["txnid"] . "|" . $_POST["key"];
		}
		//  echo($reversehash_string);
		$reverseHash = strtolower(hash("sha512", $reversehash_string));
		return $reverseHash;
	}

	public function get_salt($mid)
	{

		if ($mid == 'LMQfIC')
		{
           return PAYU_SALT;
		}
		if ($mid == 'b9IIab')
		{
			return PAYU_SALT_8485643;
		}
		if ($mid == 'PGb53w')
		{
			return PAYU_SALT_8485645;
		}
		if ($mid == 'uDBUjo')
		{
			return PAYU_SALT_8498966;
		}
		if ($mid == 'XwWFgY')
		{
			return PAYU_SALT_8498974;
		}

	}

	public function verify_payment_status($transaction_no)
	{
		$url = 'https://info.payu.in/merchant/postservice.php?form=2';
		$pipe = PAYU_KEY.'|' . 'verify_payment'.'|'.$transaction_no.'|'.PAYU_SALT ;
		$hash = hash('SHA512', $pipe);
        $data = "key=".PAYU_KEY."&command=verify_payment&var1=".$transaction_no."&hash=".$hash."";
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,

			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$response_array  = json_decode($response, true);
		if ($response_array['status'] == 1 && $response_array['transaction_details'][$transaction_no]['status'] == 'success'){
			$this->db->where('transaction_no', $transaction_no);
			$this->db->set('status', 'success');
			$this->db->update('ant_app_order_list');
			return true;
		}
		else{
			return false;
		}
	}


}
?>
