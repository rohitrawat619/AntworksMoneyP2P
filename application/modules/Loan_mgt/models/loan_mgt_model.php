<?php
class Loan_mgt_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function check_data_exist($partner_id) {
        $where_condition = array(
            'partner_id' => $partner_id,
            'tenor' => $this->input->post('tenor', TRUE),
            'status'=>1
        );
        $query = $this->db->get_where('partner_loan_plan', $where_condition);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function insert_loan_data($data) {
        if ($this->db->insert('partner_loan_plan', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_loan_data($data) {
        $this->db->where('id', $data['id']);
        if ($this->db->update('partner_loan_plan', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
