<?php
require APPPATH . '/third_party/crypt/vendor/autoload.php';

use phpseclib\Crypt;

class Enccurl extends CI_Controller
{

	public $secureKey = '';


	function index()
	{


		$array = array('B', 'Q', '8', '5', '1', '7', '6', '9', '10', '3');

		echo "Unsorted array is: ";
		echo "<br />";
		print_r($array);


		for ($j = 0; $j < count($array); $j++) {
			for ($i = 0; $i < count($array) - 1; $i++) {

				if ($array[$i] > $array[$i + 1]) {
					$temp = $array[$i + 1];
					$array[$i + 1] = $array[$i];
					$array[$i] = $temp;
				}
			}
		}

		echo "Sorted Array is: ";
		echo "<br />";
		print_r($array);
		exit;

	}

	function pay()
	{
		$pay_id = "ANTFIN".rand(100000,999999);
		$data = "YES0000000050953|".$pay_id."|test|100|INR|P2P|Pay|7399||||||9029225287@yesb|||||UPI|Sagar||||||VPA|||||||||NA|NA";
		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
		$enc_data = $this->encryptValue($data, $secureKey);
		$request = array(
			'requestMsg' => $enc_data,
			'pgMerchantId' => "YES0000000050953",
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/mePayServerReqImps",
			CURLOPT_SSH_PRIVATE_KEYFILE => 'E:/Yes/selfsigned.jks',
			CURLOPT_SSLCERT => 'E:/Yes/selfsigned.pem',
			CURLOPT_SSLCERTPASSWD => 'Antworks@165',
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => TRUE,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($request),
			CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"x-ibm-client-id: 4d12d9ac-7a38-4c35-a73f-1d5d27815106",
				"x-ibm-client-secret: N3jH8xH5iQ0oV5hN2hL4oL1bK2bH8cG8uI0pX6yV8tF0wG6wI3"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$response;
		}

		$decr_data = $this->decryptValue($response, $secureKey);
		echo $decr_data;
		exit;
	}

	function upiSend()
	{
		$pay_id = "ANTFIN".rand(100000,999999);
		echo $data = "YES0000000050953|".$pay_id."|9029225287@yesb|11|test|EXPAFTER|30|1520||||||||||||||||||||NA|NA";
         echo "<br>";
		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
		$enc_data = $this->encryptValue($data, $secureKey);
		$request = array(
			'requestMsg' => $enc_data,
			'pgMerchantId' => "YES0000000050953",
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/meTransCollectSvc",
			CURLOPT_SSH_PRIVATE_KEYFILE => 'E:/Yes/selfsigned.jks',
			CURLOPT_SSLCERT => 'E:/Yes/selfsigned.pem',
			CURLOPT_SSLCERTPASSWD => 'Antworks@165',
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => TRUE,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($request),
			CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"x-ibm-client-id: 4d12d9ac-7a38-4c35-a73f-1d5d27815106",
				"x-ibm-client-secret: N3jH8xH5iQ0oV5hN2hL4oL1bK2bH8cG8uI0pX6yV8tF0wG6wI3"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$response;
		}

		$decr_data = $this->decryptValue($response, $secureKey);
		echo $decr_data;
		exit;
	}

	function decryptValue($inputVal, $secureKey)
	{

		$key = '';
		for ($i = 0; $i < strlen($secureKey) - 1; $i += 2) {
			$key .= chr(hexdec($secureKey[$i] . $secureKey[$i + 1]));
		}

		$encblock = '';
		for ($i = 0; $i < strlen($inputVal) - 1; $i += 2) {
			$encblock .= chr(hexdec($inputVal[$i] . $inputVal[$i + 1]));
		}

		$decrypted_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encblock, MCRYPT_MODE_ECB);

		return $decrypted_text;

	}

	public function transactionStatus()
	{

		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
		$enc_data = $this->encryptValue('YES0000000050953|ANTFIN405787||||||||||||NA|NA', $secureKey);
		$request = json_encode(array('requestMsg' => $enc_data, 'pgMerchantId' => 'YES0000000050953'));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/meTransStatusQuery",
			CURLOPT_SSH_PRIVATE_KEYFILE => 'E:/Yes/selfsigned.jks',
			CURLOPT_SSLCERT => 'E:/Yes/selfsigned.pem',
			CURLOPT_SSLCERTPASSWD => 'Antworks@165',
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => TRUE,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $request,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"x-ibm-client-id: 4d12d9ac-7a38-4c35-a73f-1d5d27815106",
				"x-ibm-client-secret: N3jH8xH5iQ0oV5hN2hL4oL1bK2bH8cG8uI0pX6yV8tF0wG6wI3"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {

		}

		echo $this->decryptValue($response, $secureKey);
		exit;
	}

	function encryptValue($inputVal, $secureKey)
	{


		$key = '';
		for ($i = 0; $i < strlen($secureKey) - 1; $i += 2) {
			$key .= chr(hexdec($secureKey[$i] . $secureKey[$i + 1]));
		}


		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$pad = $block - (strlen($inputVal) % $block);
		$inputVal .= str_repeat(chr($pad), $pad);

		$encrypted_text = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $inputVal, MCRYPT_MODE_ECB));


		return $encrypted_text;
	}

	public function validateVPA()
	{
		$data = 'YES0000000050953|ANT89865|9029225287@yesb|T|com.msg.app|0.0 ,0.0 |Mumbai|172.16.50.65|MOB|5200000200010004000639292929292|Android7.0|351898082074677|89914902900059967808|4e9389eadeea5b7c|02:00:00:00:00:00|02:00:00:00:00:00|||||||||NA|NA';
		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
		$enc_data = $this->encryptValue($data, $secureKey);

		$request = array(
			'requestMsg' => $enc_data,
			'pgMerchantId' => "YES0000000050953",
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/CheckVirtualAddress",
			CURLOPT_SSH_PRIVATE_KEYFILE => 'E:/Yes/selfsigned.jks',
			CURLOPT_SSLCERT => 'E:/Yes/selfsigned.pem',
			CURLOPT_SSLCERTPASSWD => 'Antworks@165',
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => TRUE,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($request),
			CURLOPT_HTTPHEADER => array(
				"content-type: application/json",
				"x-ibm-client-id: 4d12d9ac-7a38-4c35-a73f-1d5d27815106",
				"x-ibm-client-secret: N3jH8xH5iQ0oV5hN2hL4oL1bK2bH8cG8uI0pX6yV8tF0wG6wI3"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$response;
		}

		$decr_data = $this->decryptValue($response, $secureKey);
		echo $decr_data;
		exit;

	}
}
?>
