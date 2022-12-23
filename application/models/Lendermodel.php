<?php
class Lendermodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_lender()
    {
       $lender_id = $this->create_lender_id();
       $lender_array = array(
           'lender_id'=>$lender_id,
           'name'=>$this->input->post('name'),
           'dob'=>$this->input->post('dob'),
           'gender'=>$this->input->post('gender'),
           'email'=>$this->input->post('email'),
           'mobile'=>$this->input->post('mobile'),
           'pan'=>$this->input->post('pan'),
           'qualification'=>$this->input->post('highest_qualification'),
           'occupation'=>$this->input->post('occupation'),
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
           $this->insert_lender_details($last_insert_lender_id);
           $this->insert_p2p_lender_address($last_insert_lender_id);
           if($this->input->post('occupation')==1)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['employed_company'] =  $this->input->post('employed_company1');
               $occuption['company_name'] =  $this->input->post('company_name1');
               $occuption['net_monthly_income'] = $this->input->post('net_monthly_income1');
               $occuption['current_emis'] =  $this->input->post('current_emis1')?$this->input->post('current_emis1'):'';
               $this->db->insert('p2p_lender_occ_salaried_details', $occuption);
           }
           if($this->input->post('occupation')==2)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['industry_type'] = $this->input->post('industry_type2');
               $occuption['total_experience'] = $this->input->post('total_experience2');
               $occuption['turnover_last_year'] = $this->input->post('turnover_last_year2');
               $occuption['turnover_last2_year'] = $this->input->post('turnover_last2_year2');
               $occuption['current_emis'] = $this->input->post('current_emis2')?$this->input->post('current_emis2'):'';
               $this->db->insert('p2p_lender_occ_self_business_details', $occuption);
           }
           if($this->input->post('occupation')==3)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['professional_type'] = $this->input->post('professional_type3');
               $occuption['total_experience'] = $this->input->post('total_experience3');
               $occuption['turnover_last_year'] = $this->input->post('turnover_last_year3');
               $occuption['turnover_last2_year'] = $this->input->post('turnover_last2_year3');
               $occuption['current_emis'] = $this->input->post('current_emis3')?$this->input->post('current_emis3'):'';
               $this->db-> insert('p2p_lender_occ_self_professional_details',$occuption);
           }
           if($this->input->post('occupation')==4)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['company_type'] = $this->input->post('company_type4');
               $occuption['company_name'] = $this->input->post('company_name4');
               $occuption['net_monthly_income'] = $this->input->post('net_monthly_income4');
               $occuption['current_emis'] = $this->input->post('current_emis4')?$this->input->post('current_emis4'):'';
               $this->db-> insert('p2p_lender_occ_retired_details',$occuption);
           }
           if($this->input->post('occupation')==5)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['pursuing'] = $this->input->post('pursuing5');
               $occuption['institute_name'] = $this->input->post('institute_name5');
               $occuption['net_monthly_income'] = $this->input->post('net_monthly_income5');
               $occuption['current_emis'] = $this->input->post('current_emis5')?$this->input->post('current_emis5'):'';
               $this->db-> insert('p2p_lender_occ_student_details',$occuption);
           }
           if($this->input->post('occupation')==6)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['net_monthly_income'] = $this->input->post('net_monthly_income6');
               $occuption['current_emis'] = $this->input->post('current_emis6')?$this->input->post('current_emis6'):'';
               $this->db-> insert('p2p_lender_occ_homemaker',$occuption);
           }
           if($this->input->post('occupation')==7)
           {
               $occuption['lender_id'] = $last_insert_lender_id;
               $occuption['net_monthly_income'] = $this->input->post('net_monthly_income7');
               $occuption['current_emis'] = $this->input->post('current_emis7')?$this->input->post('current_emis7'):'';
               $this->db-> insert('p2p_lender_occ_others',$occuption);
           }
           $this->Send_verification_email($last_insert_lender_id);

           return true;
       }
       else{
        return false;
       }
    }

    public function insert_lender_details($lender_id)
    {
        $loan_details = array(
            'lender_id'=>$lender_id,
            'max_loan_preference'=>$this->input->post('max_loan_preference'),
            'max_tenor'=>$this->input->post('max_tenor'),
            'max_interest_rate'=>$this->input->post('max_interest_rate'),
            'created_date'=>date("Y-m-d H:i:s"),
            'modified_date'=>date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_lender_details_table', $loan_details);
        if($this->db->affected_rows()>0)
        {
           return true;
        }
        else{
            return false;
        }
    }

    public function insert_p2p_lender_address($last_insert_lender_id)
    {
        $arr_lender_address = array(
            'lender_id'=>$last_insert_lender_id,
            'state'=>$this->input->post('state_code'),
            'city'=>$this->input->post('city'),
            'pincode'=>$this->input->post('pincode'),
            'address1'=>$this->input->post('address1'),
            'address2'=>$this->input->post('address2'),
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

    public function create_lender_id()
    {
        $this->db->select("lender_id");
        $this->db->from('p2p_lender_list');
        $this->db->order_by('lender_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $lid = $row['lender_id'];
            $lid++;
           return $lender_id = $lid;
        }
        else
        {
           return $lender_id = "LR10000001";
        }
    }

    public function Send_verification_email($lender_id)
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

    public function resendSend_verification_email($lender_id)
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
                    echo "send"; exit;
                }
                else
                {
                    echo "Not send"; exit;
                }
            }
            else{

            }
        }
        else{

        }


    }

    public function verify_lender($verify_code, $verify_hash, $hash)
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_list');
        $this->db->where('verify_code', $verify_code);
        $this->db->where('verify_hash', $verify_hash);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            if($result->status == 1)
            {
              return 2;
            }
            else{
                $hash_borrower_id = hash('SHA512', $result->lender_id);
                if($hash_borrower_id == $hash)
                {
                    $this->db->set('status', 1);
                    $this->db->where('user_id', $result->user_id);
                    $this->db->update('p2p_lender_list');
                    if($this->db->affected_rows()>0)
                    {
                        $lender_steps = array(
                            'lender_id'=>$result->user_id,
                            'step_1'=>1,
                        );
                        $this->db->insert('p2p_lender_steps',$lender_steps);
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
    }

}
?>