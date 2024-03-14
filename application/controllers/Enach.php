<?php
class Enach extends CI_Controller{
    public function index()
    {
        $request_info = base64_decode($_GET['request_info']);
        $request_info_with_hash = base64_decode($_GET['request_info_with_hash']);
        $data['request_info'] = json_decode($request_info, true);
        $data['request_info_with_hash'] = json_decode($request_info_with_hash, true);
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header', $data);
        $this->load->view('enachnew');
        $this->load->view('templates-admin/footer', $data);

    }

    public function success()
    {
       file_put_contents('enachlog', date('Y-m-d H:i:s').' - '.json_encode($_POST), FILE_APPEND);
       $query = $this->db->get_where('p2p_borrowers_list', array('mobile' => $this->input->post('phone')));
       if ($this->db->affected_rows() > 0)
       {
           $borrowerId = $query->row()->id;
           $this->db->where('borrower_id', $borrowerId);
           $this->db->set('step_3', 1);
           $this->db->update('p2p_borrower_steps_credit_line');
       }

    }

    public function failure()
    {
        $query = $this->db->get_where('p2p_borrowers_list', array('mobile' => $this->input->post('phone')));
        if ($this->db->affected_rows() > 0)
        {
            $borrowerId = $query->row()->id;
            $this->db->where('borrower_id', $borrowerId);
            $this->db->set('step_3', 2);
            $this->db->update('p2p_borrower_steps_credit_line');
        }
    }
}