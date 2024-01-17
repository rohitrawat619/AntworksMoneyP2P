<?php

class Sendemailborrowermodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Smssetting');
	}

	# Invalid Pan
	public function invalidPan()
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 31))->row();
		$email_contents = explode('__', $notification['email_content']);

		$query = $this->db->select('bl.id, bl.name as borrower_name, bl.mobile, email')
			->join('p2p_borrowers_list bl', 'on bl.id = bs.borrower_id', 'left')
			->group_by('bl.id')
			->order_by('bl.id', 'desc')
			->get_where('p2p_borrower_steps bs', array('bs.step_3' => 3));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$final_email_content = "";
				$final_email_content .= $email_contents[0];
				$final_email_content .= strtoupper($result[$email_contents[1]]);
				$final_email_content .= $email_contents[2];
				$this->sendEmail($result['id'], $result['email'], $notification['instance'], $final_email_content);
				///Send Mail
				//$this->sendSms($result['id'], $result['mobile'], $notification['sms_content'], $notification['instance']);

//				$query = $this->db->select('mobile_token')->get_where('p2p_app_lender_details', array('lender_id' => $result['user_id']));
//				if ($this->db->affected_rows() > 0) {
//					$token = $query->row()->mobile_token;
//					$this->sendNotification($result['user_id'], $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());
//
//				}

			}
		}



	}

	public function sendEmail($borrowerId, $to, $subject, $msg)
	{
		$email_config = $this->Smssetting->emilConfigration();
		$this->load->library('email', $email_config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('p2psupport@antworksmoney.com', 'Antworks P2P Financing PVT. LTD.');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($msg);
		if ($this->email->send()) {
			$arr = array(
				'borrower_id' => $borrowerId,
				'notification_type' => 'email',
				'instance' => $subject,
				'content' => $msg,
			);
			$this->db->insert('p2p_borrower_notification', $arr);
		}
	}


	public function sendSms($borrowerId, $mobile, $msg, $instance)
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
				'lender_id' => $borrowerId,
				'notification_type' => 'sms',
				'instance' => $instance,
				'content' => $msg,
			);
			$this->db->insert('p2p_lender_notification', $arr);
		}
	}


	public function sendNotification($borrowerId, $token, $title, $body, $click_action)
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
			'lender_id' => $borrowerId,
			'notification_type' => 'notification',
			'instance' => $title,
			'content' => $body,
		);
		$this->db->insert('p2p_lender_notification', $arr);

	}

	//Repayment Confirmation
	public function repaymentold_confirmaition($borrowerId, $name, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 25))->row();
		$email_contents = explode('__', $notification['email_content']);
		$where = "DATE(created_date) =  CURDATE() OR DATE(created_date) = CURDATE() - INTERVAL 1 DAY OR DATE(created_date) = CURDATE() - INTERVAL 7 DAY OR DATE(created_date) = CURDATE() - INTERVAL 29 DAY";
		$this->db->select('id, name as borrower_name, mobile as borrower_mobile, email');
		$this->db->where($where);
		$query = $this->db->get('p2p_borrowers_list');
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results as $result) {
				$final_email_content = "";
				$final_email_content .= $email_contents[0];
				$final_email_content .= strtoupper($result[$email_contents[1]]);
				$final_email_content .= $email_contents[2];
				//$this->sendEmail($result['id'], $result['email'], $notification['instance'], $final_email_content);
				///Send Mail
				$this->sendSms($result['id'], $result['borrower_mobile'], $notification['sms_content'], $notification['instance']);

				$query = $this->db->select('mobile_token')->get_where('p2p_app_borrower_details', array('borrower_id' => $result['id']));
				if ($this->db->affected_rows() > 0) {
					$token = $query->row()->mobile_token;
					$this->sendNotification($result['id'], $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

				}

			}
		}
		//


	}


	# Worked

	//Information on Activating NACH (With Link to follow)
	public function information_activating_nach($borrowerId,$name,$email,$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 23))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
		}
	}

	//Information on Bidding & Loan Agreement Signing
	public function informationbinddingloan_agreementemail($borrowerId, $name, $email, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 24))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
		}
	}

	// Re-payment Information

	public function repayment_information($borrowerId, $name, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 25))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= 590;
			$final_email_content .= $email_contents[4];
		//	$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($borrowerId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($borrowerId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

	//Noc Email
	public function nocEmail($borrowerId,$name,$email,$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 27))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
		}
	}

	//Loan ClosureConfirmation
	public function loanClosureConfirmation($borrowerId,$name,$email,$mobile,$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 26))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($borrowerId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($borrowerId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

	//Inviting user for checkback for updates on the Live Listing Scheduler pending
	public function invitLiveList($borrowerId='2328',$name='sneha',$email='singhprincysnehu21@gmail.com',$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 22))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
		}
	}

	//KYC / Other Document Competion Information and upload of pending document via link
	public function kycDocumentCompInfo($borrowerId,$name,$email,$mobile,$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 21))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($borrowerId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($borrowerId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}

	//Registration Payment Invoice action pending
	public function registrationpaymentinvoice($borrowerId, $name, $email,$confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 20))->row();

		if ($this->db->affected_rows() > 0) {

			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];

			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
		}
	}

	//Registration Payment Confirmation(Decline/Processed)

	public function registrationPaymentConfirmation($borrowerId, $name, $email, $mobile, $confirmation = 'Y')
	{
		$notification = (array)$this->db->get_where('p2p_email_notification', array('id' => 19))->row();
		if ($this->db->affected_rows() > 0) {
			$email_contents = explode('__', $notification['email_content']);
			$final_email_content = "";
			$final_email_content .= $email_contents[0];
			$final_email_content .= $name;
			$final_email_content .= $email_contents[2];
			$final_email_content .= 590;
			$final_email_content .= $email_contents[4];
			$this->sendEmail($borrowerId, $email, $notification['instance'], $final_email_content);
			$this->sendSms($borrowerId, $mobile, $notification['sms_content'], $notification['instance']);
			$query = $this->db->select('mobile_token')->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
			if ($this->db->affected_rows() > 0) {
				$token = $query->row()->mobile_token;
				$this->sendNotification($borrowerId, $token, $notification['instance'], $notification['notification_content'], $click_url = base_url());

			}
		}
	}



}

?>
