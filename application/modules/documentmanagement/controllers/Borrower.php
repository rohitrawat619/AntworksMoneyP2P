<?php

class Borrower extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2padmin/P2pborrowermodel');
		$this->load->model('P2padmin/Documents');

		if ($this->session->userdata('admin_state') == TRUE) {

		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
		error_reporting(0);
	}

	public function index()
	{
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url() . "documentmanagement/borrower";
		$config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
		$config["per_page"] = 50;
		$config["uri_segment"] = 3;
		$config['num_links'] = 10;
		$config['full_tag_open'] = "<div class='new-pagination'>";
		$config['full_tag_close'] = "</div>";

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data["pagination"] = $this->pagination->create_links();
		$data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
		$data['pageTitle'] = "Borrower List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('document-management/header', $data);
		$this->load->view('document-management/nav', $data);
		$this->load->view('borrower/borrower-list', $data);
		$this->load->view('templates-admin/js/borrowerJS', $data);
		$this->load->view('document-management/footer', $data);
	}

	public function viewborrower($borrower_id)
	{
		$data['b_borrower_id'] = $borrower_id;
		$data['list'] = $this->P2pborrowermodel->get_borrower_details($borrower_id);
		$data['current_step'] = $this->P2pborrowermodel->getBorrowersteps($data['list']['borrower_id']);
		$data['experian_details'] = $this->P2pborrowermodel->getExperian_details($data['list']['borrower_id']);
		$data['panresponse'] = $this->P2pborrowermodel->getPanresponse($data['list']['borrower_id']);
		$data['bankaccountresponse'] = $this->P2pborrowermodel->bankaccountresponse($data['list']['borrower_id']);
		$data['pageTitle'] = "Borrower Details";

//        echo "<pre>";
//        print_r($data); exit;
		$data['title'] = "Admin Dashboard";
		$this->load->view('document-management/header', $data);
		$this->load->view('document-management/nav', $data);
		$this->load->view('borrower/borrower-details', $data);
		$this->load->view('document-management/footer', $data);
	}

	public function add_docs_borrower()
	{
		$this->load->library('upload');
		$borrower_id = $_POST['borrower_id'];

		if ($_FILES) {
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['file']['name']);
			for ($i = 0; $i < $cpt; $i++) {
				$_FILES['file']['name'] = $files['file']['name'][$i];
				$_FILES['file']['type'] = $files['file']['type'][$i];
				$_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
				$_FILES['file']['error'] = $files['file']['error'][$i];
				$_FILES['file']['size'] = $files['file']['size'][$i];

				$this->upload->initialize($this->set_upload_options());
				if ($this->upload->do_upload("file")) {
					$data = $this->upload->data();
					$borrower_file_info = array(
						'borrower_id' => $_POST['borrower_id'],
						'docs_name' => $data['file_name'],
						'docs_type' => $_POST['docs_type'][$i],
					);
					$this->db->insert('p2p_borrowers_docs_table', $borrower_file_info);
				} else {
					$this->session->set_flashdata('notification', array('error' => 1, 'message' => $this->upload->display_errors()));
					redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));

				}
			}
			$msg = "Your documents are uploaded successfully.";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));
		} else {

			$msg = "Please Select a File! We accept .doc, .dox, .jpg, .png, .pdf file formats only";

			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));

			redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));

		}

	}

	private function set_upload_options()
	{
		//upload an image options
		$config = array();
		$config['upload_path'] = './assets/borrower-documents/';
		$config['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
		$config['max_size'] = '0';
		$config['encrypt_name'] = TRUE;
		$config['overwrite'] = FALSE;

		return $config;
	}
	//*******************************************************************
    public function generateLoanaggrement()
	{
		$this->load->model('p2padmin/Loanmanagementmodel');

		error_reporting(0);
		//$_POST['bid_registration_id'] = 6;
		if(!empty($_POST['loan_no'])){
			require_once APPPATH . "/third_party/mpdf/vendor/autoload.php";

			$result = $this->Loanmanagementmodel->generateloanaGGrement();
//			echo "<pre>";
//			print_r($result); exit;
			$loan_amount = $result['APPROVERD_LOAN_AMOUNT'];
			$loan_amount_inword = $this->Loanmanagementmodel->convert_number_to_words($loan_amount);
			$loan_interest_rate = $result['LOAN_Interest_rate'];
			$loan_tenor = $result['TENORMONTHS'];
			$loan_time = $loan_tenor / 12;
			$loan_ir = $loan_interest_rate;

			$numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
			$denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
			$emi = ($numerator / $denominator);
			$table = "";
			$emi_balance = 0;
			$emi_interest = array();
			$emi_principal = array();
			$emi_balance = array();
			if($result['borrower_signature'] == 1)
			{
				$data['borrower_signature_date'] = $result['borrower_signature_date'];
				$data['agreement_date'] = date('d-m-Y',strtotime($result['borrower_signature_date']));
			}
			else{
				$data['borrower_signature_date'] = date('d/m/Y H:i:s', time());
				$data['agreement_date'] = date("d-m-Y");
			}
			if($result['lender_signature'] == 1)
			{
				$data['lender_signature_date'] = $result['lender_signature_date'];
			}
			else{
				$data['lender_signature_date'] = "";
			}
			for ($i = 1; $i <= $loan_tenor; $i++) {

				if ($i == 1) {
					$emi_sn[$i] = "Month " . $i;
					$emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
					$emi_principal[$i] = $emi - $emi_interest[$i];
					$emi_balance[$i] = $loan_amount - $emi_principal[$i];
				} else if ($i < 37) {
					$emi_sn[$i] = "Month " . $i;
					$emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
					$emi_principal[$i] = $emi - $emi_interest[$i];
					$emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
				} else if ($i >= 37) {
					break;
				}
				$emi_date = date('d/F/Y', strtotime($data['agreement_date']. '+'. $i. " months"));
				$table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>" . $emi_date . "</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";

			}

			$data['result'] = $result;
			$data['table'] = $table;
			$data['loan_amount'] = $loan_amount;
			$data['loan_amount_inword'] = $loan_amount_inword;
			$data['emi'] = $emi;
			$data['html'] = "";
			$data['portal_name'] = 'www.antworksp2p.com';
			$data['today'] = date("d-m-Y");
			/////
			$data['agreement_date_time_stamp'] = $date = date('d/m/Y H:i:s', time());
			//
			if($data['result'])
			{
				$file_name = $this->input->post('loan_no') . '.pdf';
				$aggrement_result = $this->load->view('borrower/loan-aggrement-borrower', $data, true);
				$mpdf = new \Mpdf\Mpdf();
				$stylesheet = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/assets/css/loan-aggrement.css'); // external css
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($aggrement_result,2);
				$mpdf->Output('./borrower-loan-aggrement/' . $file_name, 'F');
				$arr = array(
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_id' => $result['borrower_id'],
					'lender_id' => $result['user_id_lender'],
					'loan_no' => $this->input->post('loan_no'),
					'doc_name' => $file_name,
					'accept_or_not' => 1,
				);
				$this->db->insert('p2p_loan_aggrement', $arr);
				if($this->db->affected_rows()>0)
				{
					$msg = "Your Loan Agreement created successfully download it";
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
					redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));
				}
				else{
					$msg = "Something went wrong";
					$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
					redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));
				}
			}
			else{
				$msg = "Disburse Loan Not Found";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));
			}
		}
		else{
			$msg = "Wrong approch";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'documentmanagement/borrower/viewborrower/' . $this->input->post('b_borrower_id'));
		}
	}

}

?>
