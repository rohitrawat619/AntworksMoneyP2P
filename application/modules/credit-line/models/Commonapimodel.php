<?php
class Commonapimodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOccuptionfields()
    {
      $query = $this->db->from('p2p_occuption_inputparams')->where(array('occuption_id'=>$this->input->post('occupation')))->order_by('id', 'ASC')->get();
      if($this->db->affected_rows()>0)
      {
         $results =  $query->result_array();
         foreach ($results AS $result){
             $occupation_details[] = array(
                 'occuption_id'=>$result['occuption_id'],
                 'paramName'=>$result['paramName'],
                 'paramType'=>$result['paramType'],
                 'dataType'=>$result['dataType'],
                 'optional_value'=>array(json_decode($result['optional_value'], true)),
                 'place_holder_name'=>$result['place_holder_name'],
                 'isOptional'=>$result['isOptional'],
                 'minLength'=>$result['minLength'],
                 'maxLength'=>$result['maxLength'],
             );
         }
         return $occupation_details;


      }
      else{
        return false;
      }

    }

    public function Send_verification_email_code($source)
    {
        $this->db-> select('id, name, email');
        $this->db-> from('p2p_borrowers_list');
        $this->db-> where('email', $this->input->post('email'));
        $this->db-> limit(1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
           $result = $query->row();
           $id = $result->id;
        }
        else{
            $this->db-> select('user_id, name, email');
            $this->db-> from('p2p_lender_list');
            $this->db->where('email', $this->input->post('email'));
            $this->db-> limit(1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = $query->row();
                $id = $result->user_id;
            }
            else{
                return false;
            }
        }
        if($result){
            $this->load->library('email');
            $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
            $this->db->from('p2p_admin_email_setting');
            $this->db->where('status', 1);
            $query= $this->db->get();
            if($this->db->affected_rows()>0)
                {
                    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                    $key = substr(str_shuffle($str_result),
                        0, 6);
                    $key_array = array('email'=>$this->input->post('email'), 'email_verify_key'=>$key);
                    $this->db->insert('p2p_email_verify_keys' ,$key_array);
                    $email_config = (array)$query->row();

                    $link = $key;

                    $msg = '<style type="text/css">
    body {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    </style><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border:solid 1px #ccc;"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="'.base_url().'"><img style="display:block" src="'.base_url().'assets/mailer/p2p-banner.png" width="600" height="290" border="0" /></a></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="40" height="40" /></td>
      </tr>
    <tr>
        <td align="center">Dear '.ucfirst($result->name).', </td>
    </tr>
          <tr>
            <td align="center" bgcolor="#f7f7f7" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333333;"><b>This is your mail verification code</b></td>
      </tr>
          <tr>
            <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="40" height="40" /></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f7f7f7"><b>'.$link.'</b></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="50" height="50" /></td>
      </tr>
          <tr>
            <td align="center" bgcolor="#0d0d0d">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#0d0d0d"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><a href="https://twitter.com/AntworksMoney"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon1.png" width="27" height="27" border="0" /></a></td>
                <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
                <td><a href="https://www.facebook.com/Antworks-Money-178969025869296/?ref=aymt_homepage_panel"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon2.png" width="27" height="27" border="0" /></a></td>
                <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
                <td><a href="https://plus.google.com/112473637779323394734/"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon3.png" width="27" height="27" border="0" /></a></td>
                <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
                <td><a href="https://www.linkedin.com/company-beta/13288601/"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon5.png" width="27" height="27" border="0" /></a></td>
              </tr>
            </table></td>
      </tr>
          <tr>
            <td align="center" bgcolor="#0d0d0d"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#0d0d0d" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff;"><em><a style="color:#fff;" href="https://www.antworksmoney.com/terms_and_condition">Terms & conditions</a>  |  Copyrights &copy; 2016 - 2017 All Rights Reserved.</em></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#0d0d0d">&nbsp;</td>
      </tr>
    </table></td>
      </tr>
    </table>';

                    $this->load->library('email', $email_config);
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
                    $this->email->to($this->input->post('email'));

                    $this->email->subject('Welcome to Antworksmoney.com, Please confirm your email id');
                    $this->email->message($msg);
                    if($this->email->send())
                    {
                        return true;
                    }
                    else
                    {
                        $result_error = $this->email->print_debugger();
                        $arr = array(
                            'borrower_id'=>$id,
                            'error_response'=>$result_error,
                        );
                        $this->db->insert('borrower_error_mail_report', $arr);
                        return false;
                    }
                }
            }

    }

    public function verifyEmailcode($source)
    {
        $this->db-> select('id, name, email');
        $this->db-> from('p2p_borrowers_list');
        $this->db-> where('email', $this->input->post('email'));
        $this->db-> limit(1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
           $info = $query->row();
               $this->db->select('email_verify_key, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
               $this->db->from('p2p_email_verify_keys');
               $this->db->where('email', $this->input->post('email'));
               $this->db->where('status', '0');
               $this->db->order_by('id', 'desc');
               $this->db->limit(1);
               $query = $this->db->get();
               if ($this->db->affected_rows() > 0) {
                   $result = $query->row();
                   if($this->input->post('email_verification_code') == $result->email_verify_key)
                   {
                       if ($result->MINUTE <= 10) {
                           $this->db->where('email_verify_key', $this->input->post('email_verification_code'));
                           $this->db->where('email', $this->input->post('email'));
                           $this->db->set('status', '1');
                           $this->db->update('p2p_email_verify_keys');
                           $this->db->select('id')->get_where('p2p_borrower_steps_credit_line', array('borrower_id'=>$info->id));
                           if($this->db->affected_rows()>0)
                           {
                               $this->db->where('borrower_id', $info->id);
                               $this->db->set('step_1', 1);
                               $this->db->update('p2p_borrower_steps_credit_line');
                           }
                           else{
                               $arr_inset_step = array(
                                   'borrower_id'=>$info->id,
                                   'step_1'=>1,
                               );
                               $this->db->insert('p2p_borrower_steps_credit_line', $arr_inset_step);
                           }
                           //Status Update
                           $this->db->where('id', $info->id);
                           $this->db->set('status', 1);
                           $this->db->update('p2p_borrowers_list');
                           return array(
                               'status'=>1,
                               'msg'=> 'Thanks for confirm your E-mail',
                           );
                       }
                       else {
                           //OTP expired
                           return array(
                               'status'=>0,
                               'msg'=> 'Your code is expired please try again',
                           );

                       }
                   }
                   else{
                       return array(
                           'status'=>0,
                           'msg'=> 'Invalid Code',
                       );
                   }
               }
        }
        else{
            $this->db-> select('user_id, name, email');
            $this->db-> from('p2p_lender_list');
            $this->db->where('email', $this->input->post('email'));
            $this->db-> limit(1);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $info = $query->row();
                    $this->db->select('email_verify_key, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
                    $this->db->from('p2p_email_verify_keys');
                    $this->db->where('email', $this->input->post('email'));
                    $this->db->where('status', '0');
                    $this->db->order_by('id', 'desc');
                    $this->db->limit(1);
                    $query = $this->db->get();
                    if ($this->db->affected_rows() > 0) {
                        $result = $query->row();
                        if($this->input->post('email_verification_code') == $result->email_verify_key)
                        {
                            if ($result->MINUTE <= 10) {
                                $this->db->where('email_verify_key', $this->input->post('email_verification_code'));
                                $this->db->where('email', $this->input->post('email'));
                                $this->db->set('status', '1');
                                $this->db->update('p2p_email_verify_keys');
								//Status Update
								$this->db->where('user_id', $info->user_id);
								$this->db->set('status', 1);
								$this->db->update('p2p_lender_list');

                                $this->db->select('id')->get_where('p2p_lender_steps', array('lender_id'=>$info->user_id));
                                if($this->db->affected_rows()>0)
                                {
								   $this->db->where('lender_id', $info->user_id);
                                   $this->db->set('step_1', 1);
                                   $this->db->update('p2p_lender_steps');

                                }
                                else{
                                   $arr_inset_step = array(
                                       'lender_id'=>$info->user_id,
                                       'step_1'=>1,
                                   );
                                   $this->db->insert('p2p_lender_steps', $arr_inset_step);
                                }

                                return array(
                                    'status'=>1,
                                    'msg'=> 'Thanks for confirm your E-mail',
                                );
                            }
                            else {
                                //OTP expired
                                return array(
                                    'status'=>0,
                                    'msg'=> 'Your code is expired please try again',
                                );

                            }
                        }
                        else{
                            return array(
                                'status'=>0,
                                'msg'=> 'Invalid Code',
                            );
                        }
                    }

            }
            else{
                return array(
                    'status'=>0,
                    'msg'=> 'Invalid Approch',
                );
            }
        }

    }

    //Forgot Password
    public function sentotpForgotpassword()
    {
        $this->db->select('*');
        $this->db->from('p2p_otp_forgot_password_table');
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

    public function verifyOtpForgotpassword()
    {
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_forgot_password_table');
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
                    $this->db->update('p2p_otp_forgot_password_table');
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

    public function changePasswordborrower()
    {
        $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_forgot_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '1');
        $this->db->where('is_password_update', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
//        echo "<pre>"; echo $this->db->last_query(); exit;
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
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->update('p2p_borrowers_list', $data);

                    if($this->db->affected_rows()>0)
                    {
                        $this->db->where('id', $result->id);
                        $this->db->set('is_password_update', '1');
                        $this->db->update('p2p_otp_forgot_password_table');
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

    public function changePasswordlender()
    {
        $this->db->select('id, otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_forgot_password_table');
        $this->db->where('mobile', $this->input->post('mobile'));
        $this->db->where('status', '1');
        $this->db->where('is_password_update', '0');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
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
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->update('p2p_lender_list', $data);

                    if($this->db->affected_rows()>0)
                    {
                        $this->db->where('id', $result->id);
                        $this->db->set('is_password_update', '1');
                        $this->db->update('p2p_otp_forgot_password_table');
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

    //END

}
?>
