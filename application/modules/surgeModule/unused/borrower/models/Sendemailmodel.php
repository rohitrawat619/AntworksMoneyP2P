<?php

use Mpdf\Mpdf;

class Sendemailmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Smssetting');
	}

	public function sendEmail($lenderId, $to, $subject, $msg)
	{
		$email_config = $this->Smssetting->emilConfigration();
		$this->load->library('email', $email_config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('support@antworksp2p.com', 'Antworks P2P Financing PVT. LTD.');
		$this->email->to('dinesh.knmiet@gmail.com');
		$this->email->subject($subject);
		$this->email->message($msg);
		if ($this->email->send()) {
			$arr = array(
				'lender_id' => $lenderId,
				'notification_type' => 'email',
				'instance' => $subject,
				'content' => $msg,
			);
			$this->db->insert('p2p_lender_notification', $arr);
		}
	}

	public function sendSms($lenderID, $mobile, $msg, $instance)
	{
		$setting = $this->Smssetting->smssetting();
		$data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $mobile, "sender" => $setting['sender'], "message" => rawurlencode($msg));

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		echo $response;
		curl_close($ch);
		$res = json_decode($response, true);
		if ($res['status'] == 'success') {
			$arr = array(
				'lender_id' => $lenderID,
				'notification_type' => 'sms',
				'instance' => $instance,
				'content' => $msg,
			);
			$this->db->insert('p2p_lender_notification', $arr);
		}
	}

	public function sendNotification($lenderId, $token, $title, $body, $click_action)
	{
		define('API_ACCESS_KEY_GOOGLE', 'AAAAa2uizTg:APA91bH4ZKQLsl5H-jyiyAjQRN0fjm2nNABHORy-87TcrXIatBjiV9wMtJV1gKmaVKU3tf58OfM3_VcY8qII6RDAu9JIccQALL3aukYxi4B_4u8a5baC5F5zEfpWHiwyYuUJUZnvhinH');
		$msg = array(
			'title' => $title,
			'body' => $body,
			'vibrate' => 1,
			'sound' => 1,
			'click_action' => $click_action,
		);
		$fields = array
		(
			'to' => $token,
			'data' => $msg
		);

		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY_GOOGLE,
			'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// print_r($fields);exit;
		$result = curl_exec($ch);

		curl_close($ch);
		$arr = array(
			'lender_id' => $lenderId,
			'notification_type' => 'notification',
			'instance' => $title,
			'content' => $body,
		);
		$this->db->insert('p2p_lender_notification', $arr);

	}

	# incomplete registration Lender
	public function incompleteRegistration()
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 1))->row();
		$email_contents = explode('__', $notification['email_content']);
		$where = "DATE(created_date) =  CURDATE() OR DATE(created_date) = CURDATE() - INTERVAL 1 DAY OR DATE(created_date) = CURDATE() - INTERVAL 7 DAY OR DATE(created_date) = CURDATE() - INTERVAL 29 DAY";
		$this->db->select('user_id, name as lender_name, mobile as lender_mobile, email');
		$this->db->where($where);
		$query = $this->db->get('p2p_lender_list');
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$final_email_content = "";
				$final_email_content .= $email_contents[0];
				$final_email_content .= strtoupper($result[$email_contents[1]]);
				$final_email_content .= $email_contents[2];
				$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
				///Send Mail
				$this->sendSms($result['user_id'], $result['lender_mobile'], $notification['sms_content'], $notification['instance']);

				$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $result['user_id']));
				if ($this->db->affected_rows() > 0) {
					$token = $query->row()->mobile_token;
					$this->sendNotification($result['user_id'], $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

				}

			}
		}
		//


	}

    # Registration Confirmation Link for Verification

	public function registrationVerificationlink($lenderId, $mobile)
	{
		#emils send allready here sending email and notification
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 3))->row();
		if ($this->db->affected_rows() > 0) {

			$this->sendSms($lenderId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}


	}

    #Registration Payment Confirmation(Decline/Processed) if processed Invoice

	public function sendPaymentConfirmation($lenderId, $lender_name, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 4))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $lender_name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= 590;
			$final_email_content .= $email_contents[4];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($lenderId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

    # Funding (PayIn) Confirmation (Failure/Processed)

	public function sendPayinConfirmation($lenderId, $lender_name, $payInamount, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 5))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $lender_name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= $payInamount;
			$final_email_content .= $email_contents[4];

			//Sms content
			$final_sms_content = "";
			$sms_content = explode('__', $notification['sms_content']);
			$final_sms_content .= $sms_content[0];
			$final_sms_content .= $payInamount;
			$final_sms_content .= $sms_content[2];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($lenderId, $mobile, $final_sms_content, $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $final_sms_content, $click_url = base_url());

			}
		}
	}

	#Funding (PauOut) Confirmation (Failure/Processed)

	public function sendPayOutConfirmation($lenderId, $lender_name, $payOutamount, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 6))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $lender_name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= $payOutamount;
			$final_email_content .= $email_contents[4];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			//Sms content
			$final_sms_content = "";
			$sms_content = explode('__', $notification['sms_content']);
			$final_sms_content .= $sms_content[0];
			$final_sms_content .= $payOutamount;
			$final_sms_content .= $sms_content[2];
			$this->sendSms($lenderId, $mobile, $final_sms_content, $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $final_sms_content, $click_url = base_url());

			}
		}
	}

    #Fund Statement

	public function sendFundStatement()
	{
		$current_month = date('Y-m-01');
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 7))->row();
		$email_contents = explode('__', $notification['email_content']);
		$query = $this->db->select('ll.user_id, ll.name as lender_name, ll.pan, email, lmb.account_balance')
			->join('p2p_lender_list ll', 'on ll.user_id = lmb.lender_id')
			->get_where('p2p_lender_main_balance lmb', array('ll.user_id' => 107));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$query = $this->db->get_where('p2p_lender_statement_entry', array('lender_id' => $result['user_id'], 'DATE(created_date) >' => $current_month));

				if ($this->db->affected_rows() > 0) {
					$statements = $query->result_array();
					$statement_details[] = array(
						'lenderId' => $result['user_id'],
						'lender_name' => $result['lender_name'],
						'pan' => strtoupper($result['pan']),
						'email' => $result['email'],
						'account_balance' => $result['account_balance'],
						'statement' => $statements,
					);
				}
			}
			if (@$statement_details) {
				require_once APPPATH . "/third_party/mpdf/vendor/autoload.php";
				$mpdf = new Mpdf();
				$pdf_content = "";
				foreach ($statement_details as $statement_detail) {
					$pdf_content .= "<table class='table m-t-30 table-bordered p2ploans marz-t-30' data-page-size='100'>
									<tr>
										<th class='p2ploans-hd' colspan='7' style='background: #01548f; color: #fff'>Lender's Ledger</th>
									</tr>
									<tr>
										<th class='col-md-2'>SN</th>
										<th class='col-md-2'></th>
										<th class='col-md-2'>Reference</th>
										<th class='col-md-2'>Date</th>
										<th class='col-md-2'>Debit</th>
										<th class='col-md-2'>Credit</th>
										<th class='col-md-2'>Balance</th>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								";
					$pdf_content_inner = "";
					$i = 1;
					foreach ($statement_detail['statement'] as $entry) {
						$pdf_content_inner .= "<tr>
                                              <td>$i</td>
                                              <td>" . $entry['title'] . "</td>
                                              <td>" . $entry['reference_1'] . "</td>
                                              <td>" . $entry['created_date'] . "</td>
                                              <td>" . $entry['debit'] ? $entry['debit'] : '' . "</td>
                                              <td>" . $entry['credit'] ? $entry['credit'] : '' . "</td>
                                              <td>" . $entry['balance'] . "</td>
										  </tr>";
						$i++;
					}
					$pdf_content .= $pdf_content_inner;
					$pdf_content .= "<tr>
								<td colspan='5'>Current Balance</td>
								<td>" . $statement_detail['account_balance'] ? $statement_detail['account_balance'] : '' . "</td>
								</tr>
							</table>
						  ";
				}

				echo $pdf_content;
				exit;

			}

			echo "<pre>";
			print_r($statement_details);
			exit;


//			foreach ($results as $result) {
//				$final_email_content = "";
//				$final_email_content .= $email_contents[0];
//				$final_email_content .= strtoupper($result[$email_contents[1]]);
//				$final_email_content .= $email_contents[2];
//				$this->sendEmail($result['user_id'], 'dinesh.knmiet@gmail.com', $notification['instance'], $final_email_content);
//			}
		}
	}

	#Low Balance in Funding Account

	public function sendLowbalancefundingac()
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 28))->row();
		$email_contents = explode('__', $notification['email_content']);
		$query = $this->db->select('ll.user_id, ll.name as lender_name,ll.mobile, ll.pan, ll.email, lmb.account_balance')
			->join('p2p_lender_list ll', 'on ll.user_id = lmb.lender_id')
			->get_where('p2p_lender_main_balance lmb', array('lmb.account_balance <' => 100000));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$final_email_content = "";
				$final_email_content .= $email_contents[0];
				$final_email_content .= $result['lender_name'];
				$final_email_content .= $email_contents[2];
				$final_email_content .= $result['account_balance'];
				$final_email_content .= $email_contents[4];
				$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
				$this->sendSms($result['user_id'], $result['mobile'], $notification['sms_content'], $notification['instance']);
			}
		}
	}

	#Auto Invest On/Off Confirmation

	public function sendautoInvestmentoff($lenderId, $lender_name, $email, $mobile, $confirmation = 'Y')
	{
		$this->load->model('Requestmodel');
		$preferences = $this->Requestmodel->preferences($lenderId);
		$lenderPreferences = json_decode($preferences['preferences'], true);
//		echo "<pre>";
//		print_r($lenderPreferences); exit;
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 29))->row();
		if ($this->db->affected_rows() > 0) {
			$sms_content = explode('__', $notification['sms_content']);
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $lender_name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= $lenderPreferences['loan_amount_minimum'];
			$final_email_content .= $email_contents[4];
			$final_email_content .= $lenderPreferences['loan_amount_maximum'];
			$final_email_content .= $email_contents[6];
			$final_sms_content = "";
			$final_sms_content .= $sms_content[0];
			$final_sms_content .= $confirmation ? 'ON' : 'OFF';
			$final_sms_content .= $sms_content[2];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($lenderId, $mobile, $final_sms_content, $notification['instance']);
		}
	}

	#Consolidated Bid Status (Accepted / Rejected)

	public function sendBidStatus()
	{

		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getBidsfordisbursement();
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 8))->row();
		$sms_content = explode('__', $notification['sms_content']);
		$email_contents = explode('__', $notification['email_content']);
		foreach ($results as $result) {
			$final_email_content = "";
			$final_sms_content = "";
			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $email_contents[0];
			$final_email_content .= $result[$email_contents[1]];
			$final_email_content .= $email_contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $email_contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
			$final_sms_content .= count($loan_detail);
			$final_sms_content .= $sms_content[1];
			$this->sendSms($result['user_id'], $result['mobile'], $final_sms_content, $notification['instance']);
		}
		return true;
	}

	#Profile Suggestions for Investing

	public function sendProfileSuggestions()
	{

		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getProfileforsuggestion();
		$notification = $this->db->get_where('p2p_email_notification', array('id' => 14))->row()->email_content;
		$contents = explode('__', $notification);

		foreach ($results as $result) {
			$final_email_content = "";
			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $contents[0];
			$final_email_content .= $result[$contents[1]];
			$final_email_content .= $contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
		}
		return true;
	}

	#Loan Agreement Signing Notification

	public function sendAggrementSigningNotification()
	{

		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getBidsfordisbursement();
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 10))->row();

		$email_contents = explode('__', $notification['email_content']);
		foreach ($results as $result) {
			$final_email_content = "";

			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $email_contents[0];
			$final_email_content .= $result[$email_contents[1]];
			$final_email_content .= $email_contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $email_contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
			$this->sendSms($result['user_id'], $result['mobile'], $notification['sms_content'], $notification['instance']);
		}
		return true;
	}

	#Consolidated Debit/Credit Intimation, with balance (Account Update)

	public function sendConsolidatedDebitCredit()
	{
		$this->load->model('p2padmin/P2plendermodel');
		$results = $this->P2plendermodel->getDebitCreditamount();
		if ($results) {
			$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 30))->row();
			if ($this->db->affected_rows() > 0) {
				foreach ($results as $result) {

					$email_contents = explode('__', $notification['email_content']);
					$final_email_content = "";
					$final_email_content .= $email_contents[0];
					$final_email_content .= $result['lender_name'];
					$final_email_content .= $email_contents[2];
					$final_email_content .= $result['account_balance'];
					$final_email_content .= $email_contents[4];
					$final_email_content .= date('Y-m-d');
					$final_email_content .= $email_contents[6];
					$final_email_content .= $result['debit'];
					$final_email_content .= $email_contents[8];
					$final_email_content .= $result['credit'];
					$final_email_content .= $email_contents[10];

					$this->sendEmail($result['user_id'], 'shantanu@antworksmoney.com', $notification['instance'], $final_email_content);
					$this->sendSms($result['user_id'], '9910719994', $notification['sms_content'], $notification['instance']);

				}
			}
		}

	}

	#Address/Mobile Change Confirmation

	public function sendAddressMobilechange($lenderId, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 3))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($lenderId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

	#Nominee Add

	public function sendNomineeAdd($lenderId, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 3))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$this->sendEmail($lenderId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($lenderId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $lenderId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($lenderId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

	#Inactive Profile

	public function sendInactiveprofile()
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 1))->row();
		$email_contents = explode('__', $notification['email_content']);
		$where = "DATE(created_date) =  CURDATE() OR DATE(created_date) = CURDATE() - INTERVAL 1 DAY OR DATE(created_date) = CURDATE() - INTERVAL 7 DAY OR DATE(created_date) = CURDATE() - INTERVAL 29 DAY";
		$this->db->select('user_id, name as lender_name, mobile as lender_mobile, email');
		$this->db->where($where);
		$query = $this->db->get('p2p_lender_list');
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$final_email_content = "";
				$final_email_content .= $email_contents[0];
				$final_email_content .= strtoupper($result[$email_contents[1]]);
				$final_email_content .= $email_contents[2];
				$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
				///Send Mail
				$this->sendSms($result['user_id'], $result['lender_mobile'], $notification['sms_content']);


				$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $result['user_id']));
				if ($this->db->affected_rows() > 0) {
					$token = $query->row()->mobile_token;
					$this->sendNotification($result['user_id'], $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

				}

			}
		}
		//


	}

	#Auto invest

	public function sendAutoInvestment()
	{
		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getAggrementSigning();
		$notification = $this->db->get_where('p2p_email_notification', array('id' => 14))->row()->email_content;
		$contents = explode('__', $notification);

		foreach ($results as $result) {
			$final_email_content = "";
			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $contents[0];
			$final_email_content .= $result[$contents[1]];
			$final_email_content .= $contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
			$this->sendSms($result['user_id'], $result['mobile'], $notification['sms_content']);
		}
		return true;
	}

	#Last Login

	public function sendLastLogin()
	{
		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getAggrementSigning();
		$notification = $this->db->get_where('p2p_email_notification', array('id' => 14))->row()->email_content;
		$contents = explode('__', $notification);

		foreach ($results as $result) {
			$final_email_content = "";
			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $contents[0];
			$final_email_content .= $result[$contents[1]];
			$final_email_content .= $contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
			$this->sendSms($result['user_id'], $result['mobile'], $notification['sms_content']);
		}
		return true;
	}

	#Investor Meets Information

	public function sendInvestorMeetsInformation()
	{
		$this->load->model('p2padmin/Loanmanagementmodel');

		$results = $this->Loanmanagementmodel->getAggrementSigning();
		$notification = $this->db->get_where('p2p_email_notification', array('id' => 14))->row()->email_content;
		$contents = explode('__', $notification);

		foreach ($results as $result) {
			$final_email_content = "";
			$dynamic_part = "";
			$i = 1;
			foreach ($result['loan_details'] as $loan_detail) {
				$dynamic_part .= "<tr>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>$i</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['borrower_id'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['loan_no'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['bid_loan_amount'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['accepted_tenor'] . "</td>
								<td style='text-align:left; border:solid 1px #eee; padding:5px;'>" . $loan_detail['interest_rate'] . "</td>
							</tr>";
				$i++;
			}
			$final_email_content .= $contents[0];
			$final_email_content .= $result[$contents[1]];
			$final_email_content .= $contents[2];
			$final_email_content .= $dynamic_part;
			$final_email_content .= $contents[4];
			$this->sendEmail($result['user_id'], $result['email'], $notification['instance'], $final_email_content);
			$this->sendSms($result['user_id'], $result['mobile'], $notification['sms_content']);
		}
		return true;
	}

}

?>
