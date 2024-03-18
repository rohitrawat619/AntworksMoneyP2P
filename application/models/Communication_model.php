<?php
class Communication_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
		
        $this->load->model('Smssetting');
    }
	public function get_user_detail($mobile)
	{
		$this->cldb->select("PLL.name, PLL.email, PLL.mobile, PLL.pan");
		$this->cldb->from('p2p_lender_list PLL');
		$this->cldb->where('PLL.mobile', $mobile);
		$query = $this->cldb->get();
		if ($this->cldb->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}

	}
    public function get_notification($product_type_id,$instance_id){
		#load AntApp Database
		$this->appdb = $this->load->database('app', TRUE);
		
    	       $this->appdb->select('AC.*,ACI.instance_name');
                $this->appdb->from('antpay_communication AC');
                $this->appdb->join('antpay_communication_instance AS ACI', 'ON ACI.id = AC.instance', 'left');
                $this->appdb->where('AC.product_type',$product_type_id);
                $this->appdb->where('AC.instance',$instance_id);
                $query = $this->appdb->get();
                if($this->appdb->affected_rows()>0)
					 {
			           return $query->row();
					 }
			         else{
			           return false;
				    }
                
    }
    public function send_otp($mobile,$product_type,$instance,$amount)
	{
		$sms_content = $this->get_notification($product_type,$instance);
		$setting = $this->Smssetting->smssetting();
		$otp = rand(100000, 999999);
		$token = array(
				'SITE_URL'  => 'https://www.antworksmoney.com/',
				'SITE_NAME' => 'Antworksmoney.com',
				'OTP' => $otp,
				'AMOUNT' => $amount,
				'MOBILE' => $mobile,
			);
		   $pattern = '[%s]';
			foreach($token as $key=>$val){
				$varMap[sprintf($pattern,$key)] = $val;
			}
			$message = strtr($sms_content->sms_content,$varMap);
		    $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $mobile, "sender" => $setting['sender'], "message" => $message);
				$ch = curl_init('https://api.textlocal.in/send/');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				$res = json_decode($response, true);
				if ($res['status'] == 'success') {
					$this->db->insert('corporate_otp_details', array('mobile'=>$mobile,'otp'=>$otp));
					return $return_response = array(
						'csrfName' => $this->security->get_csrf_token_name(),
						'token' => $this->security->get_csrf_hash(),
						'status' => 1,
						'msg' => "Otp sent successfully",
					);
				}else{
				return $return_response = array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'token' => $this->security->get_csrf_hash(),
					'status' => 0,
					'msg' => "Something went wrong please try again !!",
				);
			  }

	}
	
    //notification
	public function send_notification($message)
	{
		
		$msg_arr = array(
			'title' => $message['title'], 
			'message' => $message['body'],
			'image-url' => $message['img_url'],
			'page-url' => $message['page_url'],
			'page-name' => $message['page_name'],
		);
		
		$SERVER_API_KEY = 'AAAA8vpzem4:APA91bHM3ZzwywrrTUnWdkhKnL9VQVjyeUe5xiUv26L8KFOn6ldJSbOCv-kbna6dtXrsdD8QN91mpkIZZkeCiXqKVCEiIwoqdRgAs3AQciAmQLmLGJBk6izqKTV-XgGllpysh3M28RRF';
		// payload data, it will vary according to requirement
		$data = [
			"to" => $message['mobile_token'], // for single device id
			"priority" => 'high',
			"data" => $msg_arr
		];
		//pr($data);exit;
		$dataString = json_encode($data);
		
		$headers = [
			'Authorization: key=' . $SERVER_API_KEY,
			'Content-Type: application/json',
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

		//$response = curl_exec($ch);
		// curl_close($ch);
		$result = curl_exec($ch);
		if ($result === FALSE) {
			return false;
		}
		curl_close($ch);
		return true;
	}
	
	// Mail For  
    public function sendEmail($mobile,$product_type_id,$instance_id,$amount='') {
		$user_data = $this->get_user_detail($mobile);
        $result = $this->get_notification($product_type_id,$instance_id);
		
		if($result->email_content!=''){
		   //replace template var with value
			$token = array(
				'SITE_URL'  => 'https://www.antworksmoney.com/',
				'SITE_NAME' => 'Antworksmoney.com',
				'USER_NAME' => $user_data->name,
				'AMOUNT' => $amount,
			);
			$pattern = '[%s]';
			foreach($token as $key=>$val){
				$varMap[sprintf($pattern,$key)] = $val;
			}
			$msg = strtr($result->email_content,$varMap);
			  $this->load->library('email');
			  $this->email->set_mailtype("html");
			  $this->email->set_newline("\r\n");
			  $this->email->from('creditcounselling@antworksmoney.com', 'Antworks Financial Buddy Technology Pvt. Ltd.');
			  $this->email->to($user_data->email);// change it to yours
			  $this->email->subject($result->instance);
			  $this->email->message($msg);
			if($this->email->send()){
				return 'Mail sent';
			} 
			else
			{
				//return false;
				return  $this->email->print_debugger();
			}
	  }else{
		  return false;
	  }
	}
	public function send_sms($mobile,$sms_content,$amount)
	{
		$token = array(
				'SITE_URL'  => 'https://www.antworksmoney.com/',
				'SITE_NAME' => 'Antworksmoney.com',
				'AMOUNT' => $amount,
				'MOBILE' => $mobile,
			);
		   $pattern = '[%s]';
			foreach($token as $key=>$val){
				$varMap[sprintf($pattern,$key)] = $val;
			}
			$msg = strtr($sms_content,$varMap);
		$setting = $this->db->limit(1)->get_where('app_admin_sms_setting')->row_array();
		$data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $mobile, "sender" => $setting['sender'], "message" => rawurlencode($msg));
		$ch = curl_init('http://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$res = json_decode($response, true);
		if ($res['status'] == 'success') {
			//$this->db->insert('corporate_otp_details', array('mobile' => $this->input->post('mobile'), 'otp' => $otp,));
			return $return_response = 'SMS sent successfully';
		}else{
			return $return_response = 'Something went wrong please try again !!';
		}
	}
	public function send_sms_email_notification($mobile,$product_type_id,$instance_id,$page_name='',$amount='')
	{
        $user_result = $this->get_user_detail($mobile);

        if(!empty($user_result)){ 
	        $device_token = $user_result->mobile_token;
	        $email_sms_notification = $this->get_notification($product_type_id,$instance_id);
			//pr($email_sms_notification);die;
	        if(!empty($email_sms_notification)){
					if($email_sms_notification->email_content!=''){
						// Send Email Code...
						$this->sendEmail($mobile,$product_type_id,$instance_id,$amount);
					}if ($email_sms_notification->sms_content!='') {
						// SMS Code...
						$this->send_sms($mobile,$email_sms_notification->sms_content,$amount);
					}if($email_sms_notification->notification_content!=''){
						// SMS notification
						$token = array(
							'SITE_URL'  => 'https://www.antworksmoney.com/',
							'SITE_NAME' => 'Antworksmoney.com',
							'AMOUNT' => $amount,
							'MOBILE' => $mobile,
						);
					   $pattern = '[%s]';
						foreach($token as $key=>$val){
							$varMap[sprintf($pattern,$key)] = $val;
						}
						$notification_title = strtr($email_sms_notification->notification_title,$varMap);
						$notification_content = strtr($email_sms_notification->notification_content,$varMap);
					$notification_array = array(
									"mobile_token" => $user_result->mobile_token,
									"title" => $notification_title,
									"body" => $notification_content,
									"icon" => $email_sms_notification->notification_img,
								);
								
					
					/*****Insert notification history****/
							$notification_history = array(
										'mobile' => $user_result->mobile,
										'page_name' => $page_name,
										'title' => $email_sms_notification->notification_title,
										'message' => $email_sms_notification->notification_content,
									);
					 //pr($notification_array);die;							
					$notif_respons = $this->send_notification($notification_array);
					if($notif_respons['success']== true){
							
							$this->notification_history($notification_history);
						}
					 //pr($notif_respons);die;   
				   }
            }else{
			  return false;
			}				   
		}else{
		  return false;
		}    
		
	}
	
}
?>
