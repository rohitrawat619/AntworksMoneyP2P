<?php
require APPPATH. '/third_party/crypt/vendor/autoload.php';
use phpseclib\Crypt;
class Enc extends CI_Controller {

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
		print_r($array); exit;

	}

	function encryptValue($inputVal,$secureKey)
	{


		$key='';
		for ($i=0; $i < strlen($secureKey)-1; $i+=2)
		{
			$key .= chr(hexdec($secureKey[$i].$secureKey[$i+1]));
		}



		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$pad = $block - (strlen($inputVal) % $block);
		$inputVal .= str_repeat(chr($pad), $pad);

		$encrypted_text = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $inputVal, MCRYPT_MODE_ECB));


		return $encrypted_text;
	}

	function decryptValue($inputVal, $secureKey)
	{

		$key='';
		for ($i=0; $i < strlen($secureKey)-1; $i+=2)
		{
			$key .= chr(hexdec($secureKey[$i].$secureKey[$i+1]));
		}

		$encblock='';
		for ($i=0; $i < strlen($inputVal)-1; $i+=2)
		{
			$encblock .= chr(hexdec($inputVal[$i].$inputVal[$i+1]));
		}

		$decrypted_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encblock, MCRYPT_MODE_ECB);

		return $decrypted_text;

	}

	function upiSend()
	{
          $data = "YES0000000050953|ANT80008988|9029225287@yesb|11|test|EXPAFTER|30|1520||||||||||||||||||||NA|NA";
		  $secureKey = "e77fcc649d9a7aea8603b9cda427060d";

		  echo $enc_data = $this->encryptValue($data, $secureKey); exit;

//		  echo "<br>";
//		  echo $data;
//		  echo "<br>";
//
		  $enc_res = "4CDBA503B706CBF421617FB76FBFF39EB30CB7124DD3E9B5E5F8E83A2CF5ED9518576CDDB8478857BE002ED35D5C740ED65343A9867501449F57836A3735032629DACDD3F41F473B319A872D3E782A6442DD24AFF691E6F11D18DDF38785615C502DD22B6779AD681D59F51D9D7974ACE75D36AC846A972650972DE71BFDF5EA5AA7CC10616D9F2D31AA44996B8F94B7E883111883F6EC836CF39F739C98A37D8040453D1E874105044655F0CFBB793A220255CA076B1F033D3A257D1E7E20E9";
		  echo $this->decryptValue($enc_res, $secureKey);
          exit;
          //echo $enc_data; exit;
          $request = array(
          	'requestMsg' => $enc_data,
          	'pgMerchantId' => "YES0000000050953",
		  );
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_CAINFO => getcwd() . 'E:/Yes/selfsigned.crt',
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/meTransCollectSvc",
			CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_0,
			CURLOPT_SSH_PRIVATE_KEYFILE => getcwd() . 'E:/Yes/selfsigned.p12',
			CURLOPT_SSLCERT => getcwd(). 'E:/Yes/selfsigned.crt',
			CURLOPT_SSLCERTPASSWD => "Antworks@165",
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
		echo $decr_data; exit;
	}

	public function transactionStatus(){

		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
		$enc_data = $this->encryptValue('YES0000000050953|ANT80008988||||||||||||NA|NA', $secureKey);
		$request = json_encode(array('requestMsg' => $enc_data, 'pgMerchantId' => 'YES0000000050953'));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "444",
			CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/meTransStatusQuery",
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
			echo $response;
		}
         exit;

		//'2058624|ANT23098|11.0|2020:10:31 11:11:53|FAILED|Transaction fail|IR|NA|kb12@yesb|YESBB2A2D9CCE2481648E05400144FFAD5A|NA|030511506826|NA|NA|NA|antwork@yesb|YESB0000003|XXXXXX2857|NA|Antworks|NA|U30|test|NA|NA|NA|NA|NA|NA|NA';

//        echo $this->encryptValue('YES0000000050953|ANT80008988||||||||||||NA|NA', $secureKey); exit;
        echo $this->decryptValue('D1C9E02153B220FCB25FCBB494F24AAB278F2CE64DE78C5AA4CF00F4393E402DC0AB37CEE7CC915A5CA829AD74058499F6A80370018803556084279B244EA06B513B52A4A2A7B510E0ACDD4F3C1E1439A9E793DF40DCD102F044C3E2920F31DE01A8DCB3023604187CA9160CCFD0C5E5B6A552A14832A36409E5726AF5E6EEAFDBD27A7A01809D02DDDDD898C8812981E14E1939AAC8ABDDF4FF460F6192B877741BA4716BE6903FB46AB1AFDF4B7634E7EBEB8E4DE8E683AF88E5F4F6646DDA3D921AE0963ECF4FDF9239D8BC0CFB37927FF02B4228177365F78469791E54B5B1B46C346EDFD49012385F1A1894C350BC93BDF37C8784E24B59A42F830DDC689A1B19E7D0A96A3F40A644D53F9BA21B', $secureKey); exit;
	}

	public function validateVPA()
	{
		$data = 'YES0000000050953|ANT89865|kb12@yesb|T|com.msg.app|0.0 ,0.0 |Mumbai|172.16.50.65|MOB|5200000200010004000639292929292|Android7.0|351898082074677|89914902900059967808|4e9389eadeea5b7c|02:00:00:00:00:00|02:00:00:00:00:00|||||||||NA|NA';
		$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
//		echo $this->encryptValue($data, $secureKey); exit;
		echo $this->decryptValue('09C408C9F95F909C4698FC3789434F754413FB3D7F0A5BECED20A5F8DE286B3E18049A443B36EA129125E93BDAD9465BBAB95D181711CC051B195CEF66AAC5167F4E62D68DFD7DE57324EE7AC56E2D138F707CDFC26412FC612911F70F3A62819A1B19E7D0A96A3F40A644D53F9BA21B', $secureKey); exit;

	}
}
?>
