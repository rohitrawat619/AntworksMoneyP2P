<?php
class P2phistorymodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertHistory($data)
    {
        $this->db->insert('p2p_admin_history', $data);
        return true;
    }
}
?>