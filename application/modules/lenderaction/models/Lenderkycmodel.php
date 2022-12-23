<?php
class Lenderkycmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function lender_name()
    {
       $this->db->select('name');
       $this->db->from('p2p_lender_list');
       $this->db->where('user_id', $this->session->userdata('user_id'));
       $query = $this->db->get();
       if($this->db->affected_rows()>0)
       {
         return $query->row();

       }
       else{
            return false;
       }
    }

    public function updateLender()
    {
        $this->db->set('pan', $this->input->post('pan'));
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_list');
        $this->db->set('step_3', 1);
        $this->db->where('lender_id', $this->session->userdata('lender_id'));
        $this->db->update('p2p_lender_steps');

        return true;

    }

    public function insert_kyc_pan($file_info)
    {
        if($file_info['docs_type'] == 'selfiImage'){
            $query = $this->db->select('id, docs_name')->get_where('p2p_lender_docs_table', array('lender_id'=>$file_info['lender_id'], 'docs_type'=>'selfiImage'));
            if($this->db->affected_rows()>0)
            {

              $selfiImage = $query->row();
              @unlink(FCPATH.'/assets/lender-documents/'.$selfiImage->docs_name);
              $this->db->set('docs_name', $file_info['docs_name']);
              $this->db->where('id', $selfiImage->id);
              $this->db->update('p2p_lender_docs_table');
              if($this->db->affected_rows()>0)
              {
                return true;
              }
              else{
                  return false;
              }
            }
            else{
                $this->db->insert('p2p_lender_docs_table', $file_info);
                if($this->db->affected_rows()>0)
                {
                    return true;

                }
                else{
                    return false;
                }
            }
        }
        else{
            $this->db->insert('p2p_lender_docs_table', $file_info);
            if($this->db->affected_rows()>0)
            {
                return true;

            }
            else{
                return false;
            }
        }


    }

    public function updateprocess()
    {
        $this->db->set('step_3', 1);
        $this->db->where('lender_id', $this->session->userdata('lender_id'));
        $this->db->update('p2p_lender_steps');

        return true;
    }
}
?>