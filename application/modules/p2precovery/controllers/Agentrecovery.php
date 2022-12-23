<?php
class Agentrecovery extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2precoverymodel');
		$this->load->model('p2padmin/Loanmanagementmodel');
	}

	public function dashboard()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "agentrecovery") {
			$data['week'] = $this->P2precoverymodel->getLast_week();
			$data['twoweek'] = $this->P2precoverymodel->getLast_Twoweek();
			$data['list'] = $this->P2precoverymodel->getEmilist_due();
			$data['bounced'] = $this->P2precoverymodel->getEmi_bounced();
			//echo "<pre>";
			//print_r($data);exit;
			$data['pageTitle'] = "Dashboard";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/dashboard', $data);
			$this->load->view('p2precovery/footer', $data);
		}
		else{
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function search()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'agentrecovery') {
			$data["pagination"] = "";
			$data['loan_list'] = $this->Loanmanagementmodel->searchbyLoan($this->input->post('loan_no'));
			$data['pageTitle'] = "Emi List";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function index()
	{
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "agentrecovery") {
			$data['loan_list'] = '';
			$data['pageTitle'] = "Search Loan";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/loan-list', $data);
			$this->load->view('p2precovery/footer', $data);
		}
		else{
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function loandetails($loanno)
	{
		error_reporting(0);
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "agentrecovery") {
			$data['loan'] = $this->Loanmanagementmodel->currentLoandetails($loanno);
			$data['loanno'] = $loanno;
			$data['pageTitle'] = "Loan Details- " . $loanno;
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/loan-details', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function tvsrecovery()
	{
		error_reporting(0);
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "agentrecovery") {
			$data['lists'] = $this->db->select('id, SL_NO, CUSTOMER_NAME, Product, Product_Group, Mobile_No, Alternate_nos, Vehicle_Model, Reg_No, DATE_OF_CALLING')->get_where('tvs_user_records')->result_array();
//			echo "<pre>";
//			foreach ($data['lists'] AS $key => $list) {
//            print_r($list);
//			} exit;
			$data['pageTitle'] = "Tvs Data";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/tvs/tvs-list', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function tvsrecovery_loandetails($sl_NO)
	{
		error_reporting(0);
		if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == "agentrecovery") {
			$data['loan'] = $this->db->get_where('tvs_user_records', array('SL_NO' => $sl_NO))->row_array();
			$data['loan_details']= $this->db->get_where('tvs_user_calling_data', array('tvs_id' => $data['loan']['id']))->row_array();
			$data['comments']= $this->db->get_where('tvs_comment_record', array('tvs_id' => $data['loan']['id']))->result_array();
//			foreach ($data['loan'] AS $key => $list) {
//            print_r($key);
//			} exit;
			$data['pageTitle'] = "Tvs Data";
			$data['title'] = "Admin Dashboard";
			$this->load->view('p2precovery/header', $data);
			$this->load->view('p2precovery/header-below', $data);
			$this->load->view('agent/nav', $data);
			$this->load->view('agent/tvs/tvs-loan-details', $data);
			$this->load->view('p2precovery/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}

	}

	public function saveTvsdata()
	{
		$arr_tvs = array(
			'tvs_id' => $this->input->post('tvs_id'),
			'Disposition_Code' => $this->input->post('Disposition_Code'),
			'PTP_Dt' => $this->input->post('PTP_Dt'),
			'PTP_AMOUNT' => $this->input->post('PTP_AMOUNT'),
			'PTP_MODE' => $this->input->post('PTP_MODE'),
			'Next_action' => $this->input->post('Next_action'),
			'Payment_Mode' => $this->input->post('Payment_Mode'),
			'Paid_Amount' => $this->input->post('Paid_Amount'),
			'Paid_Dt' => $this->input->post('Paid_Dt'),
			'modified_date' => date('Y-m-d H:i:s'),
		);
		$this->db->get_where('tvs_user_calling_data', array('tvs_id' => $this->input->post('tvs_id')));
		if($this->db->affected_rows() > 0)
		{
           $this->db->where('tvs_id', $this->input->post('tvs_id'));
           $this->db->update('tvs_user_calling_data', $arr_tvs);
		}
		else{
           $this->db->insert("tvs_user_calling_data", $arr_tvs);
		}

		// Comment Records
		$comment_records = array(
			'tvs_id' => $this->input->post('tvs_id'),
			'comment_data' => $this->input->post('remarks'),
		);
		$this->db->insert('tvs_comment_record', $comment_records);

		echo json_encode(array(
			'status' => 1,
			'msg' => 'Record update successfully',
		));
		exit;
	}


}
?>
