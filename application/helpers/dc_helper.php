<?
defined('BASEPATH') or exit('No direct script access allowed');

// ------------------------------------------------------------------------

if (!function_exists('valid_email')) {
	/**
	 * Validate email address
	 *
	 * @deprecated    3.0.0    Use PHP's filter_var() instead
	 * @param string $email
	 * @return    bool
	 */
	function valid_email($email)
	{
		return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
	}
}

// ------------------------------------------------------------------------
if (!function_exists('unique_email')) {
	/**
	 * Validate email address
	 *
	 * @deprecated    3.0.0    Use PHP's filter_var() instead
	 * @param string $email
	 * @return    bool
	 */
	function unique_email($str, $email)
	{
		$arr = explode(".", $str);
		$table = $arr[0];
		$field = $arr[1];
		$ci = &get_instance();
		$ci->load->database();
		$query = $ci->db->query("select " . $field . " from " . $table . " where " . $field . "='$email'");
		$res = $query->result();
		if ($res) {
			return false;
		} else {
			return true;
		}
	}
}

if (!function_exists('getNotificationHtml')) {
	function getNotificationHtml()
	{
		$ci = &get_instance();
		if ($ci->session->flashdata('notification')) {
			$notificationData = $ci->session->flashdata('notification');
			if ($notificationData['error'] == 0) {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $notificationData['message'] . '</div>';
			} elseif ($notificationData['error'] == 1) {
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $notificationData['message'] . '</div>';
			}
		}
		if ($ci->session->flashdata('validation_errors')) {
			$errorData = $ci->session->flashdata('validation_errors');
			if ($errorData['error'] == 1) {
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
				foreach ($errorData['message'] as $key => $value) {
					echo $value . "<br>";
				}
				echo '</div>';
			}
		}
	}
}
if (!function_exists('generate_hr_referal_code')) {
	function generate_hr_referal_code($corporate_hr_id)
	{
		$four_digit_referal_code = '';
		if ($corporate_hr_id <= 9) {
			$four_digit_referal_code = '000' . $corporate_hr_id;
		} else if ($corporate_hr_id > 9 && $corporate_hr_id <= 99) {
			$four_digit_referal_code = '00' . $corporate_hr_id;
		} else if ($corporate_hr_id > 99 && $corporate_hr_id <= 999) {
			$four_digit_referal_code = '0' . $corporate_hr_id;
		} else if ($corporate_hr_id > 999 && $corporate_hr_id <= 9999) {
			$four_digit_referal_code = $corporate_hr_id;
		} else {
			$four_digit_referal_code = $corporate_hr_id;
		}
		return $four_digit_referal_code;

	}
}
if (!function_exists('generate_hr_virtual_account_no')) {
	function generate_hr_virtual_account_no($corporate_hr_id)
	{
		$four_digit_code = '';
		if ($corporate_hr_id <= 9) {
			$four_digit_code = '000' . $corporate_hr_id;
		} else if ($corporate_hr_id > 9 && $corporate_hr_id <= 99) {
			$four_digit_code = '00' . $corporate_hr_id;
		} else if ($corporate_hr_id > 99 && $corporate_hr_id <= 999) {
			$four_digit_code = '0' . $corporate_hr_id;
		} else if ($corporate_hr_id > 999 && $corporate_hr_id <= 9999) {
			$four_digit_code = $corporate_hr_id;
		} else {
			$four_digit_code = $corporate_hr_id;
		}
		return $four_digit_code;

	}
}
if (!function_exists('generate_corporate_hr_users_virtual_account_no')) {
	function generate_corporate_hr_users_virtual_account_no($user_id)
	{
		$six_digit_code = '';

		if ($user_id <= 9) {
			$six_digit_code = '00000' . $user_id;
		} else if ($user_id > 9 && $user_id <= 99) {
			$six_digit_code = '0000' . $user_id;
		} else if ($user_id > 99 && $user_id <= 999) {
			$six_digit_code = '000' . $user_id;
		} else if ($user_id > 999 && $user_id <= 9999) {
			$six_digit_code = '00' . $user_id;
		} else if ($user_id > 9999 && $user_id <= 99999) {
			$six_digit_code = '0' . $user_id;
		} else if ($user_id > 99999 && $user_id <= 999999) {
			$six_digit_code = $user_id;
		} else {
			$six_digit_code = $user_id;
		}
		return $six_digit_code;
	}
}
if (!function_exists('corporate_hr_balance')) {
	function corporate_hr_balance()
	{
		$ci = &get_instance();
		$query = $ci->db->select('balance')->get_where('corporate_hr_balance', array('corporate_hr_id' => $ci->session->userdata('corporate_hr_id'),'agent_id' => $ci->session->userdata('agent_id')));
		$res = $query->row();
		if ($res) {
			return $res->balance;
		} else {
			return false;
		}
	}
}
if (!function_exists('random_strings')) {
	function random_strings($length_of_string)
	{
	  
		// String of all alphanumeric character
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	  
		// Shuffle the $str_result and returns substring
		// of specified length
		return substr(str_shuffle($str_result),0, $length_of_string);
	}
}
if(!function_exists('generateAnt_Order')){
	function generateAnt_Order($order){
		$ci = & get_instance();
		$last_transactionNo = $ci->db->select('transaction_no')->order_by('id', 'desc')->limit(1)->get_where('ant_app_order_list')->row()->transaction_no;
		$last_6_digit = substr($last_transactionNo, -6);
		$last_6_digit = str_pad($last_6_digit + 1, 6, 0, STR_PAD_LEFT);
		$txn = 'ANT'. date('ymd'). $last_6_digit;
		$data['mobile'] = $order['mobile'];
		$data['transaction_no'] = $txn;
		$data['amount'] = $order['amount'];
		$data['service'] = $order['service'];
		$data['channel'] = $order['channel'];
		$data['payment_id'] = $order['payment_id'];
		$data['status'] = $order['status'];
		$data['ip_address'] = $ci->input->ip_address();
		$ci->db->insert('ant_app_order_list', $data);
		return $txn;
	}
}
function pr($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
	if(!function_exists('encrypt_string')){
		function encrypt_string($string){
			
			// Store a string into the variable which
			// need to be Encrypted
			
			  
			// Display the original string
			//echo "Original String: " . $string;
			  
			// Store the cipher method
			$ciphering = "AES-128-CTR";
			  
			// Use OpenSSl Encryption method
			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;
			  
			// Non-NULL Initialization Vector for encryption
			$encryption_iv = '1234567891011121';
			  
			// Store the encryption key
			$encryption_key = "antworksSme";
			  
			// Use openssl_encrypt() function to encrypt the data
		return $encryption = openssl_encrypt($string, $ciphering,
					$encryption_key, $options, $encryption_iv);
		 
		}
	}
	if(!function_exists('decrypt_string')){
		function decrypt_string($encryption){
			 //Store the cipher method
			$ciphering = "AES-128-CTR";
			// Use OpenSSl Encryption method
			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;
			
			// Non-NULL Initialization Vector for decryption
			$decryption_iv = '1234567891011121';
			  
			// Store the decryption key
			$decryption_key = "antworksSme";
			  
			// Use openssl_decrypt() function to decrypt the data
			return $decryption=openssl_decrypt ($encryption, $ciphering, 
					$decryption_key, $options, $decryption_iv);
		 
		}
	}