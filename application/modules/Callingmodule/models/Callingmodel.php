<?php

class Callingmodel extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}
	public $campaign = 'crmobcall';
	public $url = 'http://122.176.53.192:81/';

	public function call($phone, $tvs_sl_NO)
	{
			$url = $this->url . 'services/easyobcall.php?empid=ANT0091&phone=' .$phone . '&campaign=' . $this->campaign . '&leadid=' . $tvs_sl_NO . '';
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"postman-token: 09a0d239-504c-8135-de4d-f15e1d183c78"
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
	}

}

?>
