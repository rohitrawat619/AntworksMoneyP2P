<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
class P2precoveryrazorpay extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2precoverymodel');
		$this->load->model('p2padmin/Loanmanagementmodel');
		$this->load->model('Entryledger');
		$this->load->model('Requestmodel');
		$this->load->library('form_validation');
	}

	public function sendPaymentlink()
	{
		$this->form_validation->set_rules('purpose', 'Link Purpose', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->input->post('purpose') == 'partially_payment')
		{
			$this->form_validation->set_rules('partially_amount', 'Partially Amount', 'trim|required');
		}
		if ($this->form_validation->run() == TRUE)
		{
			$loan_details = $this->Loanmanagementmodel->currentLoandetails($this->input->post('loan_no'));
			if($this->input->post('purpose') == 'extend_loan')
			{
				$amount = 1000;
			}
			if($this->input->post('purpose') == 'partially_payment')
			{
				$amount = $this->input->post('partially_amount');
			}
			if($this->input->post('purpose') == 'emi_payment')
			{
				$emi_details = $this->Loanmanagementmodel->emiDetail($this->input->post('emi_id'));
				$amount = $emi_details['emi_amount'];
			}
			if($this->input->post('purpose') == 'foreclosure')
			{
				$amount = $this->Loanmanagementmodel->getForeclosurepayment($this->input->post('loan_no'));
			}
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 0)
			{
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];

			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 0){

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}
			$arr_invoice = array("customer" => array("name" => $loan_details['b_name'], "contact" => $loan_details['b_mobile'], "email" => $loan_details['b_email']),
				"type" => "link",
				"amount" => $amount*100,
				"currency" => "INR",
				'description' => $this->input->post('description') ? $this->input->post('description') : '',
				'receipt' => $this->input->post('loan_no'). '_' .strtotime(date('Y-m-d H:i:s')),
				"expire_by" => $this->input->post('') ? strtotime($this->input->post('')) : '',
				"reminder_enable" => false,
				"sms_notify" => 1,
				"email_notify" => 1,
				"callback_url" => base_url()."repaymentwebhook/repayemi",
				"callback_method" => "get"
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.razorpay.com/v1/invoices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_USERPWD => $api_key.':'.$api_secret,
				CURLOPT_POSTFIELDS => json_encode($arr_invoice),
				CURLOPT_HTTPHEADER => array(
					"content-type: application/json",
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			}
			$arr_response = (json_decode($response, true));
			if(@$arr_response['error'])
			{
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $arr_response['error']['description']));
				redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
			}
			else{
				$records = array(
					'purpose' => $this->input->post('purpose'),
					'loan_id' => $loan_details['disburse_loan_id'],
					'emi_id' => $this->input->post('emi_id'),
					'amount' => $amount,
					'invoice_id' => $arr_response['id'],
					'order_id' => $arr_response['order_id'],
					'razorpay_response' =>$response
				);
				$this->db->insert('p2p_razorpay_emi_order_details', $records);
				if($this->db->affected_rows()>0)
				{
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => 'Link send successfully'));
					redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
				}
				else{
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => 'Something went wrong'));
					redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
				}
			}
		}
		else{
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification',array('validation_errors'=>1,'message'=>$errmsg));
			redirect(base_url().'p2precovery/loandetails/'.$this->input->post('loan_no'));
		}
	}
}

?>
