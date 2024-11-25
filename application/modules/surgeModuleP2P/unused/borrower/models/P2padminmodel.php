<?php

class P2padminmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_borrower_rating()
    {
        $this->db->select("*");
        $this->db->from('p2p_borrower_rating_parameter');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_tegs_value($parameter_id)
    {
        $this->db->select('*');
        $this->db->from('p2p_borrower_rating_tags');
        $this->db->where('parameter_id', $parameter_id);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function create_loan_no()
    {
        $this->db->select("loan_no");
        $this->db->order_by('loan_no', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_disburse_loan_details');
        $row = (array)$query->row();
        if ($this->db->affected_rows() > 0) {
            $loan_no = $row['loan_no'];
            $loan_no++;
            return $loan_no = $loan_no;
        } else {
            return $loan_no = "LN10000000001";
        }
    }

    public function send_toescrow_infromation()
    {
        $this->db->select('BPD.*,PLL.lender_escrow_account_number, BBD.ifsc_code,
         BBD.account_number, BL.name AS borrower_name, ADD.r_city, PLL.name AS sender_name, PLL.mobile AS sender_reciever_info');
        $this->db->from('p2p_bidding_proposal_details AS BPD');
        $this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left');
        $this->db->join('p2p_borrower_bank_details AS BBD', 'ON BBD.borrower_id = BPD.borrowers_id', 'left');
        $this->db->join('p2p_lender_list AS PLL', 'ON PLL.user_id = BPD.lenders_id', 'left');
        $this->db->join('p2p_borrower_address_details AS ADD', 'ON ADD.borrower_id = BPD.borrowers_id', 'left');
        $this->db->where('BPD.proposal_status', 2);
        $this->db->where('BPD.send_to_escrow', 0);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function svaeFileDetailsescrow($filename)
    {

        $arr = array(
            'name' => $filename
        );
        $this->db->insert('p2p_escrow_file_name', $arr);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sendDisbursementfiles($filename)
    {
        $attched_file = FCPATH . "document/escrow/" . $filename;
        $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
        $this->db->from('p2p_admin_email_setting');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            $msg = "Credit Line File For Loan Disbursement";
            $email_config = (array)$query->row();
            $this->load->library('email', $email_config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
            $this->email->to('shantanu@antworksmoney.com, dinesh.knmiet@gmail.com, shantanu.tewary@gmail.com, asheesh.yadav568@gmail.com');
            $this->email->attach($attched_file);
            $this->email->subject('Credit Line File For Loan Disbursement');
            $this->email->message($msg);
            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkresponseLoanEmi_exist($loan_number, $emi_no, $date_added_escrow)
    {
        $this->db->select('id');
        $this->db->from('p2p_reypayment_escrow_response');
        $this->db->where('loan_number', $loan_number);
        $this->db->where('emi_no', $emi_no);
        $this->db->where('date_added_escrow', $date_added_escrow);
        $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getAccount_sendername()
    {
        $where = "option_name IN('antworks_idbi_account_no','sender_name_to_disburse_file') AND status = 1";
        $query = $this->db->select('option_value')->from('p2p_admin_options')->where($where)->get();
        if ($this->db->affected_rows() > 0) {
            $results = $query->result_array();
//           echo "<pre>";
//           print_r($results); exit;
            $options = array(
                'antworks_idbi_account_no' => $results[0]['option_value'],
                'sender_name_to_disburse_file' => $results[1]['option_value'],
            );
            return $options;
        } else {
            return false;
        }
    }

    public function getChargesmicro()
    {
        $where = "option_name IN('loan_processing_fee_micro_5000','loan_tieup_fee_micro_5000') AND status = 1";
        $query = $this->db->select('option_value')->from('p2p_admin_options')->where($where)->get();
        if ($this->db->affected_rows() > 0) {
            $results = $query->result_array();
//           echo "<pre>";
//           print_r($results); exit;
            $options = array(
                'loan_processing_fee_micro_5000' => $results[0]['option_value'],
                'loan_tieup_fee_micro_5000' => $results[1]['option_value'],
            );
            return $options;
        } else {
            return false;
        }
    }

    public function getChargesmicro_ten()
    {
        $where = "option_name IN('loan_processing_fee_micro_10000','loan_tieup_fee_micro_10000') AND status = 1";
        $query = $this->db->select('option_value')->from('p2p_admin_options')->where($where)->get();
        if ($this->db->affected_rows() > 0) {
            $results = $query->result_array();
            $options = array(
                'loan_processing_fee_micro_10000' => $results[0]['option_value'],
                'loan_tieup_fee_micro_10000' => $results[1]['option_value'],
            );
            return $options;
        } else {
            return false;
        }
    }

    public function saveApproveloan_data($approve_laon_data)
    {
        $this->db->select('id')->get_where('p2p_disburse_loan_details', array('bid_registration_id' => $approve_laon_data['bid_registration_id']));
        if ($this->db->affected_rows() > 0) {
            return false;
        } else {
            $this->db->insert('p2p_disburse_loan_details', $approve_laon_data);
            if ($this->db->affected_rows() > 0) {
                $this->db->where('loan_id', $approve_laon_data['bid_registration_id']);
                $this->db->set('disburse_loan_id', $this->db->insert_id());
                $this->db->update('p2p_borrower_emi_details');

                $this->db->where('bid_registration_id', $approve_laon_data['bid_registration_id']);
                $this->db->set('send_to_escrow', 1);
                $this->db->update('p2p_bidding_proposal_details');

                return true;
            } else {
                return false;
            }
        }
    }

    public function change_password()
    {
        $query = $this->db->get_where('p2p_admin_list', array('admin_id' => $this->session->userdata('user_id')));
        if ($this->db->affected_rows() > 0) {
            $result = $query->row_array();
            if ($result['password'] == hash('SHA512', $this->input->post('old_password')))
            {
                $this->db->where('admin_id', $this->session->userdata('user_id'));
                $this->db->set('password', hash('SHA512', $this->input->post('password')));
                $this->db->update('p2p_admin_list');
                if ($this->db->affected_rows() > 0) {
                    return array(
                        'status' => "1",
                        'msg' => 'Password Change Successfully'
                    );
                }
                else{
                    return array(
                        'status' => "0",
                        'msg' => 'Sorry Old password not match please try again!!'
                    );
                }
            }
            else{
                return array(
                    'status' => "0",
                    'msg' => 'Sorry Old password not match please try again!!'
                );
            }

        }
        else{
            return array(
                'status' => "0",
                'msg' => 'Sorry Old password not match please try again!!'
            );
        }
    }
} ?>
