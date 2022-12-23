<?php
class Documents extends CI_Model{

    public function __construct()
    {
        parent::__construct();

    }

//    public function get_borrower_id($borrower_id)
//    {
//        $this->db->select('id');
//        $this->db->from('p2p_borrowers_list');
//        $this->db->where('borrower_id', $borrower_id);
//        $query = $this->db->get();
//        if($this->db->affected_rows()>0)
//        {
//            return (array)$query->row();
//        }
//        else{
//            return false;
//        }
//
//    }
//
//    public function borrowerList() {
//        $sql = "SELECT * FROM p2p_borrowers_list ORDER BY id DESC";
//        $query = $this->db->query($sql);
//        if($this->db->affected_rows()>0)
//        {
//            return $query->result_array();
//        }
//        else
//        {
//            return false;
//        }
//    }
//
//    public function borrowerDoc($borrower_id)
//    {
//        $this->db->select('*');
//        $this->db->from('p2p_borrowers_docs_table');
//        $this->db->where('borrower_id', $borrower_id);
//        $query = $this->db->get();
//        if($this->db->affected_rows()>0)
//        {
//            return $query->result_array();
//        }
//        else{
//            return false;
//        }
//
//    }
//
//    public function borrower_details($borrower_id)
//    {
//        $this->db->select('BL.id,
//                           BL.borrower_id,
//                           BL.name AS Borrowername,
//                           BL.mobile AS borrower_mobile,
//                           BL.email AS borrower_email,
//                           BL.dob AS dob,
//                           BL.pan AS pan,
//                           BL.gender AS gender,
//                           BL.marital_status AS marital_status,
//                           BL.occuption_id,
//                           PBA.r_address,
//                           PBA.r_address1,
//                           PBA.r_state,
//                           PBA.r_city,
//                           PBA.r_pincode,
//                           PBD.father_name,
//                           PQ.qualification,
//                           PO.name AS Occuption_name,
//                           PBB.bank_name,
//                           PBB.branch_name,
//                           PBB.account_number,
//                           PBB.ifsc_code,
//                           PBB.account_type
//                           ');
//        $this->db->from('p2p_borrowers_list AS BL');
//        $this->db->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = BL.id', 'left');
//        $this->db->join('p2p_borrowers_details_table AS PBD', 'ON PBD.borrower_id = BL.id', 'left');
//        $this->db->join('p2p_borrower_bank_details AS PBB', 'ON PBB.borrower_id = BL.id', 'left');
//        $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
//        $this->db->join('p2p_occupation_details_table AS PO', 'ON PO.id = BL.occuption_id', 'left');
//        $this->db->where('BL.borrower_id', $borrower_id);
//        $query = $this->db->get();
//        if($this->db->affected_rows()>0)
//        {
//           return (array)$query->row();
//        }
//        else{
//            return false;
//        }
//    }
//
//    public function verifyimage($doc_id)
//    {
//        $sql = "UPDATE  p2p_borrowers_docs_table set verify='1'  where id = '".$doc_id."'";
//
//        $this->db->query($sql);
//        if($this->db->affected_rows()>0)
//
//        {
//
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//
//
//    }
//
//    public function submitcomment($doc_id,$comment,$email)
//    {
//        $sql = "UPDATE  p2p_borrowers_docs_table set comment='".$comment."'  where id = '".$doc_id."'";
//        $this->db->query($sql);
//        $this->load->library('email');
//        $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
//        $this->db->from('p2p_admin_email_setting');
//        $this->db->where('status', 1);
//        $query= $this->db->get();
//        if($this->db->affected_rows()>0)
//        {
//            $email_config = (array)$query->row();
//            $this->load->library('email', $email_config);
//            $this->email->set_mailtype("html");
//            $this->email->set_newline("\r\n");
//            $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
//            $this->email->to($email);
//
//
//            $msg = '<style type="text/css">
//body {
//	margin-left: 0px;
//	margin-top: 0px;
//	margin-right: 0px;
//	margin-bottom: 0px;
//}
//</style><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
//  <tr>
//    <td style="border:solid 1px #ccc;"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
//  <tr>
//    <td><a href="'.base_url().'"><img style="display:block" src="'.base_url().'assets/mailer/p2p-banner.png" width="600" height="290" border="0" /></a></td>
//  </tr>
//  <tr>
//    <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="40" height="40" /></td>
//  </tr>
//      <tr>
//        <td align="center" bgcolor="#f7f7f7" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333333;">'.$comment.'</td>
//  </tr>
//      <tr>
//        <td align="center" bgcolor="#f7f7f7"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="50" height="50" /></td>
//  </tr>
//      <tr>
//        <td align="center" bgcolor="#0d0d0d">&nbsp;</td>
//      </tr>
//      <tr>
//        <td align="center" bgcolor="#0d0d0d"><table border="0" cellspacing="0" cellpadding="0">
//          <tr>
//            <td><a href="https://twitter.com/AntworksMoney"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon1.png" width="27" height="27" border="0" /></a></td>
//            <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
//            <td><a href="https://www.facebook.com/Antworks-Money-178969025869296/?ref=aymt_homepage_panel"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon2.png" width="27" height="27" border="0" /></a></td>
//            <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
//            <td><a href="https://plus.google.com/112473637779323394734/"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon3.png" width="27" height="27" border="0" /></a></td>
//            <td><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
//            <td><a href="https://www.linkedin.com/company-beta/13288601/"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/social_icon5.png" width="27" height="27" border="0" /></a></td>
//          </tr>
//        </table></td>
//  </tr>
//      <tr>
//        <td align="center" bgcolor="#0d0d0d"><img style="display:block" src="https://www.antworksmoney.com/assets/mailer/trasactional-email/img/spacer.gif" width="10" height="10" /></td>
//      </tr>
//      <tr>
//        <td align="center" bgcolor="#0d0d0d" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff;"><em><a style="color:#fff;" href="https://www.antworksmoney.com/terms_and_condition">Terms & conditions</a>  |  Copyrights &copy; 2016 - 2017 All Rights Reserved.</em></td>
//  </tr>
//  <tr>
//    <td align="center" bgcolor="#0d0d0d">&nbsp;</td>
//  </tr>
//</table></td>
//  </tr>
//</table>';
//
//            $this->email->subject('Error in document verification');
//            $this->email->message($msg);
//            if($this->email->send())
//            {
//                return true;
//            }
//            else
//            {
//                return false;
//            }
//        }
//        else{
//
//        }
//
//    }
//
//    public function add_docs_borrower($uploads)
//    {
//
//            $this->db-> select('*');
//            $this->db-> from('p2p_borrowers_docs_table');
//            $this->db-> where('borrower_id', $uploads['borrower_id']);
//            $this->db-> where('docs_type', $uploads['docs_type']);
//            $query = $this->db->get();
//            if($this->db->affected_rows()>0)
//            {
//                $this->db->where('borrower_id',$uploads['borrower_id']);
//                $this->db-> where('docs_type', $uploads['docs_type']);
//                $this->db->update('borrowers_docs_table',$uploads);
//            }
//            else
//            {
//                $this->db->insert('p2p_borrowers_docs_table',$uploads);
//
//            }
//
//        return true;
//
//    }
//
//	public function add_Bulkdocs_borrower($uploads, $borrower_id)
//
//	{
//
//		$arr['borrower_id'] = $borrower_id;
//
//		foreach ($uploads as $key => $value) {
//
//			$arr['docs_type'] = $key;
//
//			$arr['docs_name'] = $value;
//
//			$arr['date_added'] = date('Y-m-d H:i:s');
//
//			$this->db->select('*');
//
//			$this->db->from('p2p_borrowers_docs_table');
//
//			$this->db->where('borrower_id', $arr['borrower_id']);
//
//			$this->db->where('docs_type', $key);
//
//			$query = $this->db->get();
//
//			if ($this->db->affected_rows() > 0) {
//
//				$this->db->where('borrower_id', $arr['borrower_id']);
//
//				$this->db->where('docs_type', $key);
//
//				$this->db->update('p2p_borrowers_docs_table', $arr);
//
//			} else {
//
//				$this->db->insert('p2p_borrowers_docs_table', $arr);
//			}
//
//		}
//
//		return true;
//
//	}

}?>
