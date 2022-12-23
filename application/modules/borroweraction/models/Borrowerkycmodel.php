<?php
class Borrowerkycmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function borrower_name()
    {
       $this->db->select('name');
       $this->db->from('p2p_borrowers_list');
       $this->db->where('id', $this->session->userdata('borrower_id'));
       $query = $this->db->get();
       if($this->db->affected_rows()>0)
       {
         return $query->row();

       }
       else{
            return false;
       }
    }

    public function check_pan_kyc()
    {
        $this->db->select('id, docs_type, docs_name');
        $this->db->from('p2p_borrowers_docs_table');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('docs_type', 'pan');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row();

        }
        else{
            return false;
        }
    }

    public function update_pan_kyc($borrower_file_info)
    {
        $this->db->where('borrower_id',$this->session->userdata('borrower_id'));
        $this->db->where('docs_type','pan');
        $this->db->update('p2p_borrowers_docs_table',$borrower_file_info);
        if($this->db->affected_rows()>0)
        {
            return true;

        }
        else{
            return false;
        }
    }

    public function insert_kyc_pan($borrower_file_info)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file_info);
        if($this->db->affected_rows()>0)
        {
            return true;

        }
        else{
            return false;
        }
    }

    public function verify_borrower_kyc()
    {
        $this->db->select('*');
        $this->db->from('p2p_borrowers_docs_table');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function updateKycPanresponse($data)
    {
        $this->db->set('whatsloan_response', $data['whatsloan_response']);
        $this->db->where('id', $data['doc_id']);
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->update('p2p_borrowers_docs_table');

        $data_arr_res = json_decode($data['whatsloan_response']);
        if($data_arr_res->result){
            foreach ($data_arr_res->result AS $res)
            {
               $res->details->father;
            }
            $this->db->get_where('p2p_borrowers_details_table', array('borrower_id' => $this->session->userdata('borrower_id')));
            if($this->db->affected_rows()>0)
            {
                $this->db->set('father_name', $res->details->father);
                $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
                $this->db->update('p2p_borrowers_details_table');
            }
            else{
                $insert_arr = array(
                    'borrower_id' => $this->session->userdata('borrower_id'),
                    'father_name'=>$res->details->father,
                );
                $this->db->insert('p2p_borrowers_details_table', $insert_arr);
            }

        }

        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function updateKycresponse($data)
    {
        $this->db->set('whatsloan_response', $data['whatsloan_response']);
        $this->db->where('id', $data['doc_id']);
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->update('p2p_borrowers_docs_table');
        if($this->db->affected_rows()>0)
        {
          return true;
        }
        else{
          return false;
        }
    }

    public function updateprocess()
    {
        $this->db->set('step_3', 1);
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->update('p2p_borrower_steps');

        return true;
    }
}
?>