<?php
class Micro extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['pageTitle'] = "Antworks P2P Microfinance Pool 1";
		$this->load->view('micro', $data);

	}

	public function process(){
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
		$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
		$this->form_validation->set_rules('investment_amount', 'Investment Amount', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
         $data = array(
         			'full_name' => $this->input->post('full_name'),
         			'email' => $this->input->post('email'),
         			'mobile' => $this->input->post('mobile'),
         			'occupation' => $this->input->post('occupation'),
         			'investment_amount' => $this->input->post('investment_amount'),
			 		'status' => 1,
			 		'created_date' => date("Y-m-d H:i:s")
         			);
         $this->db->insert('fund_offers',$data);
         if ($this->db->affected_rows() > 0) {
			 redirect(base_url() . 'micro/thankyou');
		 } else{
			 $errmsg = "Something went wrong";
			 $this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
			 redirect(base_url() . 'fundofferglimpse');
		 }
		} else{
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
			redirect(base_url() . 'fundofferglimpse');

		}
	}

	public function thankyou(){
		$data['p2p'] = "P2P";
		$data['title'] = 'Leading Peer to Peer Loan and Money Management Company India';
		$data['description'] = 'Peer to peer loan (home loan, car loan, business loan, personal loan) and investment management platform. Borrowers and lenders in a single platform to meet the needs. Register now.';
		$data['keywords'] = 'peer to peer loan, community loan, home loan, free credit score, community lending';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('thankyou',$data);
		$this->load->view('templates/footer',$data);
	}

}

?>
