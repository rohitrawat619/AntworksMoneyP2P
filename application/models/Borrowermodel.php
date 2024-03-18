<?php
class Borrowermodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_borrower()
    {

       $borrower_id = $this->create_borrower_id();
        $borrower_escrow_account = $this->createEscrowaccount();
       $borrower_array = array(
           'borrower_id'=>$borrower_id,
//           'borrower_escrow_account'=>$borrower_escrow_account,
           'name'=>strtoupper($this->input->post('name')),
           'dob'=>$this->input->post('dob'),
           'gender'=>$this->input->post('gender'),
           'email'=>$this->input->post('email'),
           'mobile'=>$this->input->post('mobile'),
           'pan'=>strtoupper($this->input->post('pan')),
           'password'=>$this->input->post('password'),
           'verify_code'=>hash('SHA512', $this->input->post('email')),
           'verify_hash'=>hash('SHA512', ($this->input->post('password').'_'.$this->input->post('email'))),
           'highest_qualification'=>$this->input->post('highest_qualification'),
           'occuption_id'=>$this->input->post('occupation'),
           'created_date'=>date("Y-m-d H:i:s"),
       );
       $this->db->insert('p2p_borrowers_list', $borrower_array);
       if($this->db->affected_rows()>0)
       {

           $last_insert_borrower_id = $this->db->insert_id();
           $this->insert_loan_details($last_insert_borrower_id);
           $this->insert_address($last_insert_borrower_id);
           $occuption_details = array(
               'borrower_id'=>$last_insert_borrower_id,
               'company_type'=>$this->input->post('company_type')?$this->input->post('company_type'):'',
               'company_name'=>$this->input->post('company_name')?$this->input->post('company_name'):'',
               'total_experience'=>$this->input->post('total_experience')?$this->input->post('total_experience'):'',
               'turnover_last_year'=>$this->input->post('turnover_last_year')?$this->input->post('turnover_last_year'):'',
               'turnover_last2_year'=>$this->input->post('turnover_last2_year')?$this->input->post('turnover_last2_year'):'',
               'net_monthly_income'=>$this->input->post('net_monthly_income')?$this->input->post('net_monthly_income'):'',
               'current_emis'=>$this->input->post('current_emis')?$this->input->post('current_emis'):'',
           );
           $this->db->insert('p2p_borrower_occuption_details', $occuption_details);
           $this->Send_verification_email($last_insert_borrower_id, $source = 'web');
           return true;
       }
       else{
        return false;
       }
    }

    public function insert_loan_details($borrower_id)
    {
        $plnr = $this->create_plnr_no();
        $tenor = '';
        if($this->input->post('loan_amount_borrower') > 10000)
        {
            $tenor = $this->input->post('tenor_borrower');
        }
        else{
            $tenor = 1;
        }
        $loan_details = array(
            'borrower_id'=>$borrower_id,
            'p2p_product_id'=>"3", #$this->input->post('p2p_product_id'),
            'loan_amount'=>$this->input->post('loan_amount_borrower'),
            'tenor_months'=>$tenor,
            'min_interest_rate'=>$this->input->post('borrower_interest_rate'),
            'PLRN'=>$plnr,
            'loan_description'=>$this->input->post('borrower_loan_desc'),
            'created_date'=>date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_proposal_details', $loan_details);
        if($this->db->affected_rows()>0)
        {
           return true;
        }
        else{
            return false;
        }
    }

    public function insert_address($borrower_id)
    {
       $borrower_residential_address = array(
           'borrower_id'=> $borrower_id,
           'r_address'=> $this->input->post('address1'),
           'r_address1'=> $this->input->post('address2'),
           'r_city'=>$this->input->post('city'),
           'r_state'=>$this->input->post('state_code'),
           'r_pincode'=>$this->input->post('pincode'),
           'present_residence'=>$this->input->post('present_residence'),
       );
       $this->db->insert('p2p_borrower_address_details', $borrower_residential_address);
    }

    public function create_borrower_id()
    {
        $this->db->select("id");
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_borrowers_list');
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $borrwer_last_register_id = $row['id'];
            $bid = 10000000 + $borrwer_last_register_id + 1;
            return $borrower_id  = "BR".$bid;

        }
        else
        {
            return $borrower_id = "BR10000001";
        }
    }

    public function createEscrowaccount()
    {
        $this->db->select("borrower_escrow_account");
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_borrowers_list');
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $bea = $row['borrower_escrow_account'];
            $bea++;
            return $borrower_escrow_account = $bea;
        }
        else
        {
            return $borrower_escrow_account = "VANTB00000000001";
        }
    }

    public function create_plnr_no()
    {
        $this->db->select("proposal_id");
        $this->db->order_by('proposal_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_proposal_details');
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $plrn_initial_value = 10000000;
            $plrn_next_velue = $plrn_initial_value + $row['proposal_id']+1;
            return $plrn = "PL".$plrn_next_velue;

        }
        else
        {
            return $PLRN = "PL10000001";
        }
    }

    public function Send_verification_email($borrower_id, $source)
    {
        $this->db->select('*');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('id', $borrower_id);
        $query= $this->db->get();
        if($this->db->affected_rows()>0)
        {
                $this->load->library('email');
                $borrower_info = $query->row();
                $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
                $this->db->from('p2p_admin_email_setting');
                $this->db->where('status', 1);
                $query= $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $email_config = (array)$query->row();
						$this->email->initialize($email_config); // initialize with smtp configs
                    $verify_code = hash('SHA512', $borrower_info->email);
                    $verify_hash_create = $borrower_info->password.'_'.$borrower_info->email;
                    $verify_hash = hash('SHA512', $verify_hash_create);
                    $hash = hash('SHA512', ($borrower_info->borrower_id));
                    $link = base_url()."borrower-register/verify-email?verify_code=".$verify_code."&verify_hash=".$verify_hash."&hash=".$hash."&source=".$source;

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
	<td align="center">Dear '.ucfirst($borrower_info->name).', </td>
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
						$this->email->initialize($email_config); // initialize with smtp configs
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
                    $this->email->to($borrower_info->email);

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
                                   'borrower_id'=>$borrower_id,
                                   'error_response'=>$result_error,
                                   );
                        $this->db->insert('borrower_error_mail_report', $arr);
                        return false;
                    }
                }
                else{

                }
        }
        else{

        }


    }

    public function verify_borrower($verify_code, $verify_hash, $hash)
    {
        $this->db->select('*');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('verify_code', $verify_code);
        $this->db->where('verify_hash', $verify_hash);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = $query->row();
            if($result->status == 1)
            {
              return 2;
            }
            else{
                $hash_borrower_id = hash('SHA512', $result->borrower_id);
                if($hash_borrower_id == $hash)
                {
                    $this->db->set('status', 1);
                    $this->db->where('id', $result->id);
                    $this->db->update('p2p_borrowers_list');
                    if($this->db->affected_rows()>0)
                    {
                        $this->db->select('id')->get_where('p2p_borrower_steps', array('borrower_id'=>$result->id));
                        if($this->db->affected_rows()>0)
                        {
                            $borrower_steps = array(
                                'borrower_id'=>$result->id,
                                'step_1'=>1,
                            );
                            $this->db->where('borrower_id',$result->id);
                            $this->db->set('step_1',1);
                            $this->db->update('p2p_borrower_steps');
                            return true;
                        }
                        else{
                            $borrower_steps = array(
                                'borrower_id'=>$result->id,
                                'step_1'=>1,
                            );
                            $this->db->insert('p2p_borrower_steps',$borrower_steps);
                            return true;
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
    }

    public function resendVerificationmail()
    {
        $this->load->model('historymodule/P2phistorymodel');
        $this->db->select('id, borrower_id, name, email, status, verify_code, verify_hash');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('id', $this->input->post('borrowerId'));
        $this->db->where('status', '0');
        $query= $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $borrower_info = $query->row();

            $this->load->library('email');
            $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
            $this->db->from('p2p_admin_email_setting');
            $this->db->where('status', 1);
            $query= $this->db->get();
            $email_config = (array)$query->row();
				$this->email->initialize($email_config); // initialize with smtp configs
            $verify_code = hash('SHA512', $borrower_info->email);
            $verify_hash_create = $borrower_info->password.'_'.$borrower_info->email;
            $verify_hash = hash('SHA512', $verify_hash_create);
            $hash = hash('SHA512', ($borrower_info->borrower_id));
            $link = base_url()."borrower-register/verify-email?verify_code=".$borrower_info->verify_code."&verify_hash=".$borrower_info->verify_hash."&hash=".$hash;

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
	<td align="center">Dear '.ucfirst($borrower_info->name).', </td>
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
        <td align="center" bgcolor="#0d0d0d" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff;"><em><a style="color:#fff;" href="https://www.antworksp2p.com/term-and-conditions">Terms & conditions</a>  |  Copyrights &copy; 2016 - 2017 All Rights Reserved.</em></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#0d0d0d">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>';
            $this->load->library('email', $email_config);
				$this->email->initialize($email_config); // initialize with smtp configs
            if($borrower_info->email == $this->input->post('email'))
            {
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
                $this->email->to($borrower_info->email);

                $this->email->subject('Welcome to Antworksmoney.com, Please confirm your email id');
                $this->email->message($msg);
                if($this->email->send())
                {
                    $history_data = array(
                                    'adminId'=>$this->session->userdata('user_id'),
                                    'history_data'=>serialize($_POST),
                                    );
                    $this->P2phistorymodel->insertHistory($history_data);
                    return array(
                        'status'=>1,
                        'msg'=>'Email send successfully',
                    );
                }
                else
                {
                    $result_error = $this->email->print_debugger();
                    $arr = array(
                        'borrower_id'=>$this->input->post('borrowerId'),
                        'error_response'=>$result_error,
                    );
                    $this->db->insert('borrower_error_mail_report', $arr);
                    return array(
                        'status'=>0,
                        'msg'=>'Something went wrong contact to developer',
                    );
                }
            }
            else{
                $this->db->select('id, borrower_id, name, email, status');
                $this->db->from('p2p_borrowers_list');
                $this->db->where('email', $this->input->post('email'));
                $query= $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return array(
                        'status'=>0,
                        'msg'=>'Borrower already exist',
                    );
                }
                else{
                    $this->db->where('id', $this->input->post('borrowerId'));
                    $this->db->set('email', $this->input->post('email'));
                    $this->db->set('status', 0);
                    $this->db->update('p2p_borrowers_list');
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
                    $this->email->to($this->input->post('email'));
                    $this->email->subject('Welcome to Antworksmoney.com, Please confirm your email id');
                    $this->email->message($msg);
                    if($this->email->send())
                    {
                        $history_data = array(
                            'adminId'=>$this->session->userdata('user_id'),
                            'history_data'=>serialize($_POST),
                        );
                        $this->P2phistorymodel->insertHistory($history_data);
                        return array(
                            'status'=>1,
                            'msg'=>'Email send successfully',
                        );
                    }
                    else
                    {
                        $result_error = $this->email->print_debugger();
                        $arr = array(
                            'borrower_id'=>$this->input->post('borrowerId'),
                            'error_response'=>$result_error,
                        );
                        $this->db->insert('borrower_error_mail_report', $arr);
                        return array(
                            'status'=>0,
                            'msg'=>'Something went wrong contact to developer',
                        );
                    }
                }
            }

        }
        else{
            return array(
                'status'=>0,
                'msg'=>'Borrower already verified',
            );
        }


    }

}
?>
