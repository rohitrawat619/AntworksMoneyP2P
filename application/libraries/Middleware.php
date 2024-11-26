<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware
{

	public function __construct()
	{
		$this->_CI = &get_instance();
		$CI =   &get_instance();
		$this->app = $this->_CI->load->database('app', TRUE);
        error_reporting(0);
	}
    public function auth()
	{
		
		$headers = $this->_CI->input->request_headers();
		
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']) && !empty($headers['oath_token']))
        {
			
			 if ($this->_CI->input->server('PHP_AUTH_USER') === 'antApp_2023' && $this->_CI->input->server('PHP_AUTH_PW') === 'Ant_Secure&@1!65') {
				$decodedToken = AUTHORIZATION::validateToken($headers['oath_token']);
				//pr($decodedToken);exit;
				if ($decodedToken != false) {
					$query = $this->app->get_where('ant_trans_login_records', array('jwt_token' => $headers['oath_token'],'status' => 1));
					//echo $this->app->last_query();exit;
					if ($this->app->affected_rows() > 0) {
						$user = $query->row_array();
						//echo $headers['oath_token'].'~'.$user['oath_token'];exit;
						if($decodedToken->device_id == $user['device_id'] && $headers['oath_token'] == $user['jwt_token']){
						   return true;
						}
					}
					return false;
				}
				return false;
			 }
			 return false;
		}
		return false;

	}
	public function client_auth()
	{
		$this->p2p = $this->_CI->load->database('default', TRUE);
		
		$headers = $this->_CI->input->request_headers();
		
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
			//pr($this->_CI->input->post());exit;
				$decodedToken = base64_decode($headers['Authorization']);
				
				if ($decodedToken != false) {
					$token_arr = explode (":", $decodedToken); 
					//pr($token_arr);exit;
					if(isset($token_arr[0]) && isset($token_arr[1]) && $token_arr[0]!='' && $token_arr[1]!=''){
						$api_key = $token_arr[0];
						$api_secret = $token_arr[1];
					}else{
						return false;
					}
					$query = $this->p2p->get_where('kyc_api_client_secret', array('api_key' => $api_key,'api_secret'=>$api_secret,'status' => 1));
					//echo $this->p2p->last_query();exit;
					if ($this->p2p->affected_rows() > 0) {
						$dbData = $query->row_array();
						if($api_key == $dbData['api_key'] && $api_secret == $dbData['api_secret']){
							#Update client And Secret
							//$this->p2p->where('mobile', $this->_CI->input->post('mobile'));	   
							$this->p2p->where('mobile', $this->_CI->input->post('mobile'));	   
					        $this->p2p->update('all_kyc_api_log',array('client_api_key'=>$dbData['api_key']));
							file_put_contents('logs/'.'auth-'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.$this->p2p->last_query()."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
						   return true;
						}
					}
					return false;
				}
				return false;
		}
		return false;

	}

}
