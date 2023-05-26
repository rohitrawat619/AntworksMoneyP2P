<?php
class Lenderaddmodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lendermodel');
    }

    public function add_lender()
    {
        $this->load->model('P2papi/Commonapimodel');
        $lender_id = $this->Lendermodel->create_lender_id();
        $lender_array = array(
            'lender_id'=>$lender_id,
            'name'=>$this->input->post('name'),
            'dob'=>$this->input->post('dob'),
            'gender'=>$this->input->post('gender'),
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('mobile'),
            'pan'=>$this->input->post('pan'),
            'qualification'=>$this->input->post('highest_qualification'),
            'password'=>$this->input->post('password'),
            'verify_code'=>hash('SHA512', $this->input->post('email')),
            'verify_hash'=>hash('SHA512', ($this->input->post('password').'_'.$this->input->post('email'))),
            'created_date'=>date("Y-m-d H:i:s"),
            'modified_date'=>date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_lender_list', $lender_array);
        if($this->db->affected_rows()>0)
        {
            $last_insert_lender_id = $this->db->insert_id();
            $this->Commonapimodel->Send_verification_email_code($last_insert_lender_id, $source = 'APP');
            if($this->input->post('andriod_app') == TRUE)
            {
                $this->updateLenderappdetails($last_insert_lender_id);
            }
            return true;
        }
        else{
            return false;
        }
    }

    public function updateLenderappdetails($lender_id)
    {
        $this->db->get_where('p2p_lender_address', array('lender_id' => $lender_id));
        if($this->db->affected_rows()>0)
        {
            $app_details = array(
                'imei_no'=>$this->input->post('imei_no'),
                'mobile_token'=>$this->input->post('mobile_token'),
                'latitude'=>$this->input->post('latitude'),
                'longitude'=>$this->input->post('longitude'),
                'created_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->where('lender_id', $lender_id);
            $this->db->update('p2p_app_lender_details', $app_details);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $app_details = array(
                'lender_id'=>$lender_id,
                'imei_no'=>$this->input->post('imei_no'),
                'mobile_token'=>$this->input->post('mobile_token'),
                'latitude'=>$this->input->post('latitude'),
                'longitude'=>$this->input->post('longitude'),
                'created_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_app_lender_details', $app_details);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }

    }

    public function Send_app_verification_email($lender_id)
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_list');
        $this->db->where('user_id', $lender_id);
        $query= $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $this->load->library('email');
            $lender_info = $query->row();
            $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
            $this->db->from('p2p_admin_email_setting');
            $this->db->where('status', 1);
            $query= $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $email_config = (array)$query->row();
                $verify_code = hash('SHA512', $lender_info->email);
                $verify_hash_create = $lender_info->password.'_'.$lender_info->email;
                $verify_hash = hash('SHA512', $verify_hash_create);
                $hash = hash('SHA512', ($lender_info->lender_id));
                $link = base_url()."lender-register/verify-email?verify_code=".$verify_code."&verify_hash=".$verify_hash."&hash=".$hash;

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
	<td align="center">Dear '.ucfirst($lender_info->name).', </td>
</tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333333;">Please click the activation link below to activate your profile<br />
          and help us serve you better.</td>
  </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="40" height="40" /></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><a href="'.$link.'"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/validate.png" width="251" height="50" border="0" /></a></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="30" height="30" /></td>
  </tr>
      <tr>
        <td align="center" bgcolor="#f7f7f7" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Having trouble clicking the button, simply copy paste below url in your browser:
 '.$link.' </td>
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
                $this->email->to($lender_info->email);

                $this->email->subject('Welcome to Antworksmoney.com, Please confirm your email id');
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

            }
        }
        else{

        }


    }

    public function udateAddress($lender_id)
    {
        $this->db->get_where('p2p_lender_address', array('lender_id' => $lender_id));
        if($this->db->affected_rows()>0)
        {
            $arr_lender_address = array(
                'lender_id'=>$lender_id,
                'state'=>$this->input->post('state_code'),
                'city'=>$this->input->post('city'),
                'pincode'=>$this->input->post('pincode'),
                'address1'=>$this->input->post('address1'),
                'address2'=>$this->input->post('address2')?$this->input->post('address2'):'',
                'modified_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->where('lender_id', $lender_id);
            $this->db->update('p2p_lender_address', $arr_lender_address);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $arr_lender_address = array(
                'lender_id'=>$lender_id,
                'state'=>$this->input->post('state_code'),
                'city'=>$this->input->post('city'),
                'pincode'=>$this->input->post('pincode'),
                'address1'=>$this->input->post('address1'),
                'address2'=>$this->input->post('address2')?$this->input->post('address2'):'',
                'created_date'=>date("Y-m-d H:i:s"),
                'modified_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_lender_address', $arr_lender_address);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }

    }

    public function updateOccupation($lender_id)
    {
        $this->db->get_where('p2p_lender_list', array('user_id' => $lender_id));
        if($this->db->affected_rows()>0)
        {
           $this->db->where('user_id', $lender_id);
           $this->db->set('occupation', $this->input->post('occupation'));
           $this->db->update('p2p_lender_list');
           $this->db->get_where('p2p_lender_details_table', array('lender_id' => $lender_id));
           if($this->db->affected_rows()>0)
           {
               $this->db->where('lender_id', $lender_id);
               $this->db->set('max_loan_preference', $this->input->post('income'));
               $this->db->set('investments', $this->input->post('willing_to_lend'));
               $this->db->update('p2p_lender_details_table');
           }
           else{
               $lender_details = array('lender_id'=>$lender_id, 'investments'=>$this->input->post('willing_to_lend'));
               $this->db->insert('p2p_lender_details_table', $lender_details);
           }
           return true;
        }
        else{
            return false;
        }
    }

    public function updateKyc($lender_id)
    {

    }

    public function addaccount($bankdetails)
    {
        $this->db->insert('p2p_lender_account_info', $bankdetails);
        if($this->db->affected_rows()>0)
        {
            $this->db->set('step_4', 1);
            $this->db->where('lender_id', $bankdetails['lender_id']);
            $this->db->update('p2p_lender_steps');

            return true;
        }
        else{
            return false;
        }
    }
}
?>