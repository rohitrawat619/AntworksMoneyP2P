<?php

class Frontresponsemodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function city_list_statcode($scode) {

        $this->db->select('*');
        $this->db->from('p2p_city_master');
        $this->db->where('state_code',$scode);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function company_list_search()
    {

    }

}