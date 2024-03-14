<?php
class Loginmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		//$this->cldb = $this->load->database('credit-line', TRUE);
    }

    public function validity_ip_base_login_failed()
    {
        $ip = $this->input->ip_address();

        $date = date('y-m-d').' 00:00:00';
        $sql = "SELECT COUNT(id) AS TOTAL FROM p2p_failed_logins WHERE login_attempt_ip = '$ip' AND failed_login_date>'$date'";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            if($result->TOTAL > 2)
            {
                $this->db->select('ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(failed_login_date)) / 60) AS MINUTE');
                $this->db->from('p2p_failed_logins');
                $this->db->where('login_attempt_ip', $ip);
                $this->db->order_by('id', 'desc');
                $this->db->limit(1);
                $query = $this->db->get();
//                echo $this->db->last_query(); exit;
                if ($this->db->affected_rows() > 0) {
                    $result = $query->row();
                    if ($result->MINUTE <= 9.9434349) {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }

    public function updateSession_ip($email)
    {
        $date = date('y-m-d H:i:s');
        $date_arr = array(
            'email'=>$email,
            'created_date'=>$date,
            'session_token'=>md5(rand('1000000', '99999999'))
        );
        $this->db->where('id', session_id());
        $this->db->update('p2p_ci_sessions', $date_arr);
        if($this->db->affected_rows()>0)
        {
            $this->db->where('created_date < ', $date);
            $this->db->where('ip_address', $this->input->ip_address());
            $this->db->where('email', $email);
            $this->db->delete('p2p_ci_sessions');
            return true;

        }
        else{
            return false;
        }
    }

    public function activity_login_log($activity_log)
    {
        $this->db->insert('p2p_login_activity', $activity_log);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function failed_activity_login_log($activity_log)
    {
        $this->db->insert('p2p_failed_logins', $activity_log);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function update_activity_login_log()
    {
        $activity_log = array(
            'logout_date' =>date('y-m-d H:i:s'),
        );
        $this->db->select('id');
        $this->db->from('p2p_login_activity');
        $this->db->where('user_login', $this->session->userdata('email'));
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            $this->db->where('id', $result->id);
            $this->db->update('p2p_login_activity', $activity_log);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }

    public function validateAdmin($username, $password, $hash) {
        $this->db-> select('P.admin_id, P.email, P.fname, P.mobile, P.password, P.role_id, P.status, R.role_name, R.admin_access, P.partner_id');
        $this->db-> from('p2p_admin_list AS P');
        $this->db->join('p2p_admin_role AS R', 'R.id = P.role_id', 'left');
        $this->db->where('email', $username);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            $current_password_with_key = $result->password.$hash;
            $generate_password = hash('SHA512',$current_password_with_key);
            if($generate_password == $password)
            {
                return $query->row();
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
	
		/***********starting of send SurgeApp OTP**************/
    public function sendLendSocialOtp() // dated: 2023-oct-23
    {
        $this->load->database();
		 $mobile = sanitize_input_data($_POST['mobile']);
		// echo $mobile;
        if(!empty($_POST['mobile'])){



            $arr=array();
            $number = str_replace("'","",sanitize_input_data($_POST['mobile']));
			//echo $number."--";
            $otp = rand(100000,999999);
			//$otp = '876420';
            $this->db->select('*');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->where('date_added >= now() - INTERVAL 10 MINUTE');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = count($query->result_array());
                if($result>10)
                {
                    return "Exceeded Max OTP Send Limit"; 
                }
                else{
                    $arr["mobile"]=$number;
                    $arr["otp"]=$otp;
                    $arr["source"]='sendLendSocialOtp';
					
                    $query = $this->db-> insert('p2p_otp_details_table',$arr);
                }

            }
            else{
                $arr["mobile"]=$number;
                $arr["otp"]=$otp;
				$arr["source"]='sendLendSocialOtp2';
                $query = $this->db-> insert('p2p_otp_details_table',$arr);
            }


			/****************/
			$mobileToInsert = $_POST['mobile'];
			$this->db->where('mobile', $mobileToInsert);
			$query = $this->db->get('master_user');

			if ($query->num_rows() == 0) {
				// Mobile number doesn't exist, proceed with the insert
				$this->db->insert('master_user', array("mobile" => $mobileToInsert));
				
			}
				/******************/
			

            $msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
            $msg = "$otp is your Antworks Account verification code - ANTWORKS";
//            $msg = "Hi (Test Name lenght 10) Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
            $message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => SMS_GATEWAY_USERNAME, 'hash' => SMS_GATEWAY_HASH_API, 'numbers' => $number, "sender" => SMS_GATEWAY_SENDER, "message" => $message);

            /* dated: 2023-dec-12 / Send the POST request with cURL */
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // Create session for verifying number		*/

            return 1;
            }
        }
        
				/***********ending of send SurgeApp OTP***********/	

						/**************verify SurgeApp OTP starting here***************/
	 public function verify_mobile_LendSocial($mobile,$otp)
    {			// http_response_code(401);
        if (!empty($mobile) && !empty($otp)) {
            $number = $mobile;
            $otp = $otp;
            $data = array(
                'csrf_token' => $this->security->get_csrf_hash(),
            );
            $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $mobile);
            $this->db->where('status', '0');
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                $result = $query->row();
                if($otp == $result->otp)
                {
                    if ($result->MINUTE <= 600) {
						
						 $data['status'] = 1;
                        $data['response'] = "verify";
                        $this->db->where('otp', $otp);
                        $this->db->where('mobile', $mobile);
                        $this->db->set('status', '1');
                        $this->db->update('p2p_otp_details_table');
                    } else {
						$data['status'] = 0;
                        $data['response'] = "OTP Expired, Please Resend and try again";
                    }
                }
                else{
					$data['status'] = 2;
                    $data['response'] = "OTP Not Verified ";
                }

            } else {
				$data['status'] = 3;
                $data['response'] = "OTP Not Verified ";
            }
            return $data;
           

        }
        
    }  /**************verify SurgeApp OTP ending here**************/

	public function validateSurgeAdmin($username, $password, $hash) { // Dated: 2023-Nov-29
        $this->db-> select('P.admin_id, P.email, P.fname, P.mobile, P.password, P.role_id, P.status, R.role_name, R.admin_access, P.partner_id');
        $this->db-> from('p2p_admin_list AS P');
        $this->db->join('p2p_admin_role AS R', 'R.id = P.role_id', 'left');
        $this->db->where('email', $username);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            $current_password_with_key = $result->password.$hash;
            $generate_password = hash('SHA512',$current_password_with_key);
            if($generate_password == $password)
            {
                return $query->row();
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function requestnewpassword()
    {
        $this->db->select('name, email, mobile');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('email', $this->input->post('user'));
        $this->db->where('status', 1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $res = (array)$query->row();
            $response = $this->generateToken($res['email'], $res['mobile'], $res['name']);
            if($response)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $this->db->select('name, email, mobile');
            $this->db->from('p2p_lender_list');
            $this->db->where('email', $this->input->post('user'));
            $this->db->where('status', 1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $res = (array)$query->row();
                $response = $this->generateToken($res['email'], $res['mobile'], $res['name']);
                if($response)
                {
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }

    public function validate($username, $password, $hash)
    {
        $this->db-> select('id, borrower_id, borrower_escrow_account, name, password, email, mobile, gender, dob, highest_qualification, occuption_id, marital_status, pan, status, created_date');
        $this->db-> from('p2p_borrowers_list');
        $this->db-> where('email', $username);
        $this->db-> limit(1);
        $query = $this->db->get();
        $this->db->last_query();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            $current_password_with_key = $result->password.$hash;
            $generate_password = hash('SHA512',$current_password_with_key);

            if($generate_password === $password)
            {
                $result = $query->row();
                return $user_info = array(
                    'borrower_id'  => $result->id,
                    'borrower_generated_id'  => $result->borrower_id,
                    'email'  => $result->email,
                    'name'  => $result->name,
                    'mobile'  => $result->mobile,
                    'status'  => $result->status,
                    'login_type'=>'borrower',
                    'borrower_state' => TRUE
                );
            }
            else{
                return false;
            }
        }
        else{
            $this->db-> select('*');
            $this->db-> from('p2p_lender_list');
            $this->db->where('email', $username);
            $this->db-> limit(1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = $query->row();
                $current_password_with_key = $result->password.$hash;
                $generate_password = hash('SHA512',$current_password_with_key);
                if($generate_password == $password)
                {
                    $result = $query->row();

                    return $user_info = array(
                        'user_id' 	=> $result->user_id,
                        'email' 	=> $result->email,
                        'name'  => $result->name,
                        'mobile'  => $result->mobile,
                        'status'  => $result->status,
                        'login_type'=>'lender',
                        'login_state'=> TRUE

                    );
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

    }


public function validate_by_mobile($mobile, $otp, $hash)
    {
        $this->db-> select('id, borrower_id, borrower_escrow_account, name, password, email, mobile, gender, dob, highest_qualification, occuption_id, marital_status, pan, status, created_date');
        $this->db-> from('p2p_borrowers_list');
        $this->db-> where('mobile', $mobile);
        $this->db-> limit(1);
        $query = $this->db->get();
        $this->db->last_query();
		
		//$verify_mobile_resp = $this->verify_mobile($mobile,$otp);
		//print_r($verify_mobile_resp); die();
				/**start block**/
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
           // $current_password_with_key = $result->password.$hash;
           // $generate_password = hash('SHA512',$current_password_with_key);
				//print_r($result);
				//return "testing".$verify_mobile_resp; exit;
				$verify_mobile_resp = $this->verify_mobile($mobile,$otp);
            if($verify_mobile_resp['status'] === 1)
            {
                $result = $query->row();
                return $user_info = array(
				'verify_mobile_resp' => $verify_mobile_resp,
                    'borrower_id'  => $result->id,
                    'borrower_generated_id'  => $result->borrower_id,
                    'email'  => $result->email,
                    'name'  => $result->name,
                    'mobile'  => $result->mobile,
                    'status'  => $result->status,
                    'login_type'=>'borrower',
                    'borrower_state' => TRUE
                );
            }
            else{
				
                return $verify_mobile_resp;
            }
        }
        else{
            $this->db-> select('*');
            $this->db-> from('p2p_lender_list');
            $this->db->where('mobile', $mobile);
            $this->db-> limit(1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = $query->row();
                //$current_password_with_key = $result->password.$hash;
               // $generate_password = hash('SHA512',$current_password_with_key);
			   $verify_mobile_resp = $this->verify_mobile($mobile,$otp);
                if($verify_mobile_resp == 1)
                {
                    $result = $query->row();

                    return $user_info = array(
                        'user_id' 	=> $result->user_id,
                        'email' 	=> $result->email,
                        'name'  => $result->name,
                        'mobile'  => $result->mobile,
                        'status'  => $result->status,
                        'login_type'=>'lender',
                        'login_state'=> TRUE

                    );
                }
                else{
                    return $verify_mobile_resp;
                }
            }
            else{
				$resp['status'] = 0;
				$resp['response'] = "User Not Found";
                return $resp;
            }
        }
		
					} /*end block* /

    }


		/**************verify mobile starting here***************/
	 public function verify_mobile($mobile,$otp)
    {			// http_response_code(401);
        if (!empty($mobile) && !empty($otp)) {
            $number = $mobile;
            $otp = $otp;
            $data = array(
                'csrf_token' => $this->security->get_csrf_hash(),
            );
            $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $mobile);
            $this->db->where('status', '0');
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                $result = $query->row();
                if($otp == $result->otp)
                {
                    if ($result->MINUTE <= 600) {
						
						 $data['status'] = 1;
                        $data['response'] = "verify";
                        $this->db->where('otp', $otp);
                        $this->db->where('mobile', $mobile);
                        $this->db->set('status', '1');
                        $this->db->update('p2p_otp_details_table');
                    } else {
						$data['status'] = 0;
                        $data['response'] = "OTP Expired, Please Resend and try again";
                    }
                }
                else{
					$data['status'] = 2;
                    $data['response'] = "OTP Not Verified qq";
                }

            } else {
				$data['status'] = 3;
                $data['response'] = "OTP Not Verified dd";
            }
            return $data;
           

        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }  /**************verify mobile ending here**************/
	
    public function generateToken($email, $mobile, $name)
    {
        $this->load->model('Emailmodel');
        $ip = $this->input->ip_address();
        $current_date = date('Y:m:d H:i:s');
        $hash_string = $current_date.$this->generateSalt();
        $hash = hash('sha512', $hash_string);
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $changepass = array(
            'email'=>$email,
            'hash'=>$hash,
            'ip_address'=>$ip,
            'token'=>$token,
        );
        $this->db->insert('p2p_change_password', $changepass);
        $response = $this->Emailmodel->Send_email_change_password($email, $mobile, $name);
        if($response)
        {
            return true;

        }
        else{
            return false;
        }

    }

    public function generateSalt($max = 16) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }

    public function verify_token_change_password($verify_hash, $hash, $token)
    {
        $this->db->select('*');
        $this->db->from('p2p_change_password');
        $this->db->where('hash', $hash);
        $this->db->where('token', $token);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
           $result = $query->row();

           $email_hash = hash('sha512', $result->email);

           if($email_hash == $verify_hash)
           {
             return $result->email;
           }
           else{
               return false;
           }

        }
        else{
            return false;
        }
    }

    public function change_user_password($verify_hash, $hash, $token){

        $result_email = $this->verify_token_change_password($verify_hash, $hash, $token);
        if($result_email)
        {
            $this->db->select('email');
            $this->db->from('p2p_borrowers_list');
            $this->db->where('email', $result_email);
            $this->db->where('status', 1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $this->db->set('password', $this->input->post('pwd'));
                $this->db->where('email', $result_email);
                $this->db->update('p2p_borrowers_list');
                if($this->db->affected_rows()>0)
                {
                   return true;
                }
                else{
                    return false;
                }
            }

            else{
                $this->db->select('email');
                $this->db->from('p2p_lender_list');
                $this->db->where('email', $result_email);
                $this->db->where('status', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $this->db->set('password', $this->input->post('pwd'));
                    $this->db->where('email', $result_email);
                    $this->db->update('p2p_lender_list');
                    if($this->db->affected_rows()>0)
                    {
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
        }
        else{
            return false;
        }

    }

}
?>
