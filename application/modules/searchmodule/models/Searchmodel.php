<?php
class Searchmodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function search()
    {
        $where = "";
        if($this->input->post('start_date'))
         {
           $post_date = explode('+', $this->input->post('start_date'));
           $date = explode('-', $post_date[0]);
           $start_date = $date[0];
           $end_date = $date[1];
           // Date Format
           $start_date = (date("Y-m-d", strtotime($start_date))).' 00:00:00';
           $end_date = (date("Y-m-d", strtotime($end_date))).' 23:59:59';

           $where = "BL.created_date > '$start_date' AND BL.created_date < '$end_date'";


        }
        if($this->input->post('name'))
        {
            $where .= "BL.name LIKE '%".$this->input->post('name')."%'";
        }
        if($this->input->post('pan'))
        {
            $where .= "BL.pan = '".$this->input->post('pan')."'";
        }
        if($this->input->post('email'))
        {
            $where .= "BL.email = '".$this->input->post('email')."'";
        }
        if($this->input->post('mobile'))
        {
            $where .= "BL.mobile = '".$this->input->post('mobile')."'";
        }

        $this->db->select("BL.borrower_id, BL.name, BL.email, BL.mobile, BL.created_date,
                           IF(BS.step_2 = 1, 'Payment Done', 'Payment Not Done') AS step_2,
                         ");
        $this->db->from('p2p_borrowers_list AS BL');
        $this->db->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->db->where($where);
        $this->db->order_by('BL.id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }
}
?>