<?php

class Emailmodel extends CI_Model{

    public function __construct(){

	    $this->load->database();
		$this->load->library('email');
	}

	public function send_feedback_query() {

		//print_r($_POST);exit;
		if($_POST['page_val']=="p2p_home")
		{
			$sub = "Query from suggestion page";
		}

		$msg = 'Dear Sir/Madam/Customer,
		This is to inform you that, Someone express interest at this.
		Details are- 
		Fullname - '.$_POST['fname'].' '.$_POST['lname'].'
		Email - '.$_POST['email'].'
		State - '.$_POST['state'].'
		City - '.$_POST['city'].'
		Mobile - '.$_POST['mobile'].'
		Query - '.$_POST['query'].'
		';
		//echo $msg;exit;
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.falconide.com',
            'smtp_port' => 587,
            'smtp_user' => 'antworksmoney',
            'smtp_pass' => 'a91b34!81a582',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

		// Set to, from, message, etc.

		//send mail to lender
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
        $this->email->to('info@antworksmoney.com');
		//$this->email->to('deepak@lopamudracreative.com');
        $this->email->subject($sub);
        $this->email->message($msg);

		if($this->email->send())
		{
			return true;
		}
		else
		{
			return false;
			//echo $this->email->print_debugger();
		}
	}

	public function footer_exit_form() {

		//print_r($_POST);exit;

		$sub = "Query from Exit form";

		$msg = 'Dear Sir/Madam/Customer,
		This is to inform you that, Someone express interest at this.
		Details are- 
		Email - '.$_POST['email'].'
		Mobile - '.$_POST['mobile'].'
		';
		//echo $msg;exit;
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.falconide.com',
            'smtp_port' => 587,
            'smtp_user' => 'antworksmoney',
            'smtp_pass' => 'a91b34!81a582',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

		// Set to, from, message, etc.

		//send mail to lender
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
        $this->email->to('info@antworksmoney.com');
		//$this->email->to('deepak@lopamudracreative.com');
        $this->email->subject($sub);
        $this->email->message($msg);

		if($this->email->send())
		{
			return true;
		}
		else
		{
			return false;
			//echo $this->email->print_debugger();
		}
	}

	public function forgot_password() {

		//print_r($_POST);exit;

		$email = $_POST['email'];
		$hash = md5($email);

		$link = base_url()."home/reset_password?email=".$email."&hash=".$hash;

		$sub = "[Antworks P2P Financing] Password Reset";

		$msg = '<table border="0" cellpadding="10" width="600" >

				  <tr>
				   
					<tr>
					<td>Someone has requested a password reset for the following account: </td>
					</tr>
				   
					<tr>
					<td>If this was a mistake, just ignore this email and nothing will happen.</td>
					</tr>
					<tr>
					<td>To reset your password, visit the following address: </td>
					</tr>
					<tr>
					<br><br><a href="'.$link.'" >'.$link.'</a></tr>
				  </tr>
				</table>';
		//echo $msg;exit;
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.falconide.com',
            'smtp_port' => 587,
            'smtp_user' => 'antworksmoney',
            'smtp_pass' => 'a91b34!81a582',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

		// Set to, from, message, etc.

		//send mail to lender
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
        $this->email->to($email);
        $this->email->subject($sub);
        $this->email->message($msg);

		if($this->email->send())
		{
			return true;
		}
		else
		{
			return false;
			//echo $this->email->print_debugger();
		}
	}

	public function reset_password_mail($email,$msg,$subject) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.falconide.com',
            'smtp_port' => 587,
            'smtp_user' => 'antworksmoney',
            'smtp_pass' => 'a91b34!81a582',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

		// Set to, from, message, etc.
		$this->load->library('email', $config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('support@antworksmoney.com', 'Antworks Money');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($msg);
		if($this->email->send()){
		}
		else
		{
			//return false;
			echo $this->email->print_debugger();
		}
	}

	public function contact_us_mail() {
		$sub = "Query from Antworks P2P";
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
		$msg = 'Enquiry From Antworks P2P
		Name - '.$name.'
		Email - '.$email.'
		Mobile - '.$mobile.'
		Subject - '.$subject.'
		Message - '.$message.'
		';
		//echo $msg;exit;
        $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
        $this->db->from('p2p_admin_email_setting');
        $this->db->where('status', 1);
        $query= $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $email_config = (array)$query->row();
            $this->load->library('email', $email_config);
            $this->email->set_newline("\r\n");
            $this->email->from('grievance.p2p@antworksmoney.com', 'Antworks P2P');
            $this->email->to('grievance.p2p@antworksmoney.com');
            $this->email->cc('shantanu@antworksmoney.com');
            $this->email->subject($sub);
            $this->email->message($msg);
            if($this->email->send())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else{
            return false;
        }

		//send mail to lender

	}

	//New coading

    public function Send_email_change_password($email, $mobile, $name)
    {
        $this->db->select('CP.*');
        $this->db->from('p2p_change_password AS CP');
        $this->db->where('CP.email', $email);
        $this->db->order_by('CP.id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
            $this->load->library('email');
            $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
            $this->db->from('p2p_admin_email_setting');
            $this->db->where('status', 1);
            $query= $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $email_config = (array)$query->row();
                $verify_code = hash('SHA512', $email);
                $hash = $result['hash'];
                $token = $result['token'];
                $link = base_url()."user/change-password/?verify-hash=".$verify_code."&hash=".$hash."&token=".$token;

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
	<td align="center">Dear '.ucfirst($name).', </td>
</tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333333;">Please click to change your password</td>
  </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="40" height="40" /></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><a href="'.$link.'"><button>Change Your Password</button></a></td>
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
                $this->email->to($email);

                $this->email->subject('Welcome to Antworksp2p.com, Please change your password');
                $this->email->message($msg);
                if($this->email->send())
                {
                    return true;
                }
                else
                {
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
}