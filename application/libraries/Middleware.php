<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware
{

	public function __construct()
	{
		$this->_CI = &get_instance();
        error_reporting(0);
	}

	public function auth()
	{
		$headers = $this->_CI->input->request_headers();
		
		//$headers['auth-token'] = $headers['auth_token'] ? $headers['auth_token'] : $headers['Auth-Token'];
		
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
			 /* if ($this->_CI->input->server('PHP_AUTH_USER') === 'antApp_2021' && $this->_CI->input->server('PHP_AUTH_PW') === 'Ant_Secure&@165') {  */
				
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				//pr($decodedToken);exit;
				if ($decodedToken != false) {
					return true;
				}else{
					return false;
				}
			//}
		}
		return false;

	}

	public function auth__()
	{
		$headers = $this->_CI->input->request_headers();
		$headers['auth-token'] = $headers['auth-token'] ? $headers['auth-token'] : $headers['Auth-Token'];
		if (array_key_exists('auth-token', $headers) && !empty($headers['Authorization']) && !empty($headers['auth-token'])) {
			if ($this->_CI->input->server('PHP_AUTH_USER') === 'BAA_2022' && $this->_CI->input->server('PHP_AUTH_PW') === 'BAA@2022))Dev') {
				$decodedToken = AUTHORIZATION::validateToken($headers['auth-token']);
				if ($decodedToken != false) {
					return true;
				}
			}
		}
		else{
			if (!array_key_exists('auth-token', $headers)){
				return 'sorry key not exist';
			}
			if (!empty($headers['auth-token'])){
				return 'sorry value not exist';
			}

		}
		return "Error In header";

	}

}
