<?php
class P2psmsmodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendOtp()
    {
        $this->db->select('*');
        $this->db->from('p2p_otp_details_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('date_added >= now() - INTERVAL 1 DAY');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result = count($query->result_array());
            if($result>3)
            {
               return "Dear user you tried multiple times please try after 24 hour's";
            }
            else{
                return true;

            }
        }
        else{
            return true;
        }
    }

    public function verifyOtp()
    {
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_details_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            if($this->input->post('otp') == $result->otp)
            {
                if ($result->MINUTE <= 10) {
                    $data['response'] = "verify";
                    $this->db->where('otp', $this->input->post('otp'));
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->set('status', '1');
                    $this->db->update('p2p_otp_details_table');
                    return true;
                } else {
                    //OTP expired
                    return 2;

                }
            }
            else{
                //OTP NOT Verified
                return 3;
            }
        }
        else{
            return false;
        }
    }

    public function changemobilesendOtp($lenderId)
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_requests');
        $this->db->where('lender_id', $lenderId);
        $this->db->where('type', 'mobile');
        $this->db->where('created_date >= now() - INTERVAL 1 DAY');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result = count($query->result_array());
            if($result>3)
            {
                return true;
                return "Dear user you tried multiple times please try after 24 hour's";
            }
            else{
                return true;

            }
        }
        else{
            return true;
        }
    }

    public function verifyChangemobile($lenderId)
    {
        $this->db->select('*,ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_date)) / 60) AS MINUTE');
        $this->db->from('p2p_lender_requests');
        $this->db->where('lender_id', $lenderId);
        $this->db->where('type', 'mobile');
        $this->db->where('status', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            $request = json_decode($result->request_data, true);

            $recieved_otp = $request['otp'];
            $recieved_mobile = $request['mobile'];
            if($this->input->post('otp') == $recieved_otp && $this->input->post('mobile') == $recieved_mobile)
            {
                if ($result->MINUTE <= 10) {
                    $data['response'] = "verify";
                    $this->db->where('id', $result->id);
                    $this->db->set('status', '1');
                    $this->db->update('p2p_lender_requests');
                    return true;
                } else {
                    //OTP expired
                    return 2;

                }
            }
            else{
                //OTP NOT Verified
                return 3;
            }
        }
        else{
            return false;
        }
    }

    ///change Password
    public function sentOtppassword()
    {
        $this->db->select('*');
        $this->db->from('p2p_otp_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('date_added >= now() - INTERVAL 1 DAY');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = count($query->result_array());
            if($result>3)
            {
                return "Dear user you tried multiple times please try after 24 hour's";
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }

    public function verifyOtpPassword()
    {
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            if($this->input->post('otp') == $result->otp)
            {
                if ($result->MINUTE <= 10)
                {
                    $data['response'] = "verify";
                    $this->db->where('otp', $this->input->post('otp'));
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->set('status', 1);
                    $this->db->update('p2p_otp_password_table');
                    return true;
                }
                else {
                    return 2;
                }
            }
            else {
                return 3;
            }
        }
        else {
            return false;
        }
    }
    //Chenge Password for borrower
    public function changePassword($borrowerId)
    {
        $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '1');
        $this->db->where('is_password_update', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

//        echo $this->db->last_query(); exit;
        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            if($this->input->post('otp') == $result->otp)
            {
                if ($result->MINUTE <= 15)
                {
                    $data = array(
                        'password'=>$this->input->post('password'),
                        'modified_date'=>date("Y-m-d H:i:s"),
                    );
                    $this->db->where('id', $borrowerId);
                    $this->db->update('p2p_borrowers_list', $data);

                    if($this->db->affected_rows()>0)
                    {
                        $this->db->where('id', $result->id);
                        $this->db->set('is_password_update', '1');
                        $this->db->update('p2p_otp_password_table');
                        return 'Your password update successfully';
                    }
                    else
                    {
                        return 'something went wrong please try again';
                    }
                }
                else{
                    return 'Request Time Out Please try again';
                }

            }

        }

    }

    public function changePasswordlender($lenderId)
    {
        $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '1');
        $this->db->where('is_password_update', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

//        echo $this->db->last_query(); exit;
        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            if($this->input->post('otp') == $result->otp)
            {
                if ($result->MINUTE <= 15)
                {
                    $data = array(
                        'password'=>$this->input->post('password'),
                        'modified_date'=>date("Y-m-d H:i:s"),
                    );
                    $this->db->where('user_id', $lenderId);
                    $this->db->update('p2p_lender_list', $data);

                    if($this->db->affected_rows()>0)
                    {
                        $this->db->where('id', $result->id);
                        $this->db->set('is_password_update', '1');
                        $this->db->update('p2p_otp_password_table');
                        return 'Your password update successfully';
                    }
                    else
                    {
                        return 'something went wrong please try again';
                    }
                }
                else{
                    return 'Request Time Out Please try again';
                }

            }

        }

    }

    ///END
    /// Change Mobile request Borrower

    public function requestmobileChangeborrowerOtp($borrowerId)
    {
        $this->db->select('*');
        $this->db->from('p2p_borrower_requests');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->where('type', 'mobile');
        $this->db->where('created_date >= now() - INTERVAL 1 DAY');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result = count($query->result_array());
            if($result>3)
            {
                return "Dear user you tried multiple times please try after 24 hour's";
            }
            else{
                return true;

            }
        }
        else{
            return true;
        }
    }

    public function verifyChangemobileborrower($borrowerId)
    {
        $this->db->select('*,ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_date)) / 60) AS MINUTE');
        $this->db->from('p2p_borrower_requests');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->where('type', 'mobile');
        $this->db->where('status', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            $request = json_decode($result->request_data, true);

            $recieved_otp = $request['otp'];
            $recieved_mobile = $request['mobile'];
            if($this->input->post('otp') == $recieved_otp && $this->input->post('mobile') == $recieved_mobile)
            {
                if ($result->MINUTE <= 10) {
                    $data['response'] = "verify";
                    $this->db->where('id', $result->id);
                    $this->db->set('status', '1');
                    $this->db->update('p2p_borrower_requests');
                    return true;
                } else {
                    //OTP expired
                    return 2;

                }
            }
            else{
                //OTP NOT Verified
                return 3;
            }
        }
        else{
            return false;
        }
    }

    //

}
?>