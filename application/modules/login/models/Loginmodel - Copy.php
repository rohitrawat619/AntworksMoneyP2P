<?php
class Loginmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
        $this->db-> select('P.admin_id, P.email, P.fname, P.mobile, P.password, P.role_id, P.status, R.role_name');
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
