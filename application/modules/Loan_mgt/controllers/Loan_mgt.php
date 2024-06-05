<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_mgt extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('loan_mgt_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('loan_mgt');
    }

    public function post() {
        
        $partner_id = 1;

        
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('interest', 'Interest', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tenor', 'Tenor', 'required|in_list[30,60,90]');

        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('loan_mgt');
        } else {
            
            $data = array(
                'partner_id' => $partner_id,
                'amount' => $this->input->post('amount', TRUE),
                'interest' => $this->input->post('interest', TRUE),
                'tenor' => $this->input->post('tenor', TRUE),
            );

            
            $check_data_exist = $this->loan_mgt_model->check_data_exist($partner_id);
            
            if ($check_data_exist) {
                updateLoanPlan($data);

            } else {
                addLoanPlan($data);
            }
            
            redirect('loan_mgt');
        }
    }

    public function updateLoanPlan(){
        $data['id'] = $check_data_exist['id'];
                if ($this->loan_mgt_model->update_loan_data($data)) {
                    $this->session->set_flashdata('success', 'Your Loan plan has been updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update loan plan. Please try again.');
                }
    }

    public function addLoanPlan(){
        if ($this->loan_mgt_model->insert_loan_data($data)) {
            $this->session->set_flashdata('success', 'Your Loan plan has been submitted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to submit loan plan. Please try again.');
        }
    }
}
?>
