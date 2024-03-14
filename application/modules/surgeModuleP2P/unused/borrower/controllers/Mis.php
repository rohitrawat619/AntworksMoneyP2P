<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mis extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db2 = $this->load->database('money', true);
		$this->load->helper('path');
		$this->load->library('form_validation');
		if ($this->session->userdata('admin_state') == TRUE && ($this->session->userdata('role') == 'mis' || $this->session->userdata('role') == 'admin')) {

		} else {
			$msg = "Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function index()
	{

		$data['pageTitle'] = "MIS List";

		$data['title'] = "MIS List";
		$this->load->view('templates-admin/header', $data);
		$this->load->view('templates-admin/mis-nav', $data);
		$this->load->view('mis1', $data);
		$this->load->view('templates-admin/footer', $data);
	}


	public function doenloadMisp2pgivenapp()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}
			if ($key == 'loan' && !empty($_POST['loan'])) {
				if (!empty($str)) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}
			if ($key == 'rating' && !empty($_POST['rating'])) {
				if(!empty($str))
				{
					$str .= ' ,' . implode(',', $value);
				}
				else{
					$str .= implode(',', $value);
				}
			}


			if ($key == 'recovery' && !empty($_POST['recovery'])) {
				if(!empty($str))
				{
					$str .= ' ,' . implode(',', $value);
				}
				else{
					$str .= implode(',', $value);
				}
			}
		}
		if (!empty($_POST)) {
			$this->db->select("$str");
			$this->db->from('p2p_borrower_emi_details AS bed');
			$this->db->join('p2p_emi_payment_details AS epd', 'ON epd.emi_id = bed.id', 'left');
			$this->db->join('p2p_borrowers_list AS BS', 'on BS.id = bed.borrower_id', 'left');
			$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BN.bid_registration_id = bed.loan_id', 'left');
			$this->db->join('p2p_disburse_loan_details AS DLD', 'ON DLD.id = bed.disburse_loan_id', 'left');
			$this->db->join('p2p_borrower_bank_details AS BNK', 'ON BNK.borrower_id = bed.borrower_id', 'left');
			$this->db->join('p2p_borrower_address_details AS ADR', 'ON ADR.borrower_id = bed.borrower_id', 'left');
			$this->db->join('ant_borrower_rating AS RATI', 'ON RATI.borrower_id = bed.borrower_id', 'left');
			$this->db->join('p2p_occupation_details_table AS OCU', 'ON  OCU.id = BS.occuption_id', 'left');
			$this->db->join('p2p_qualification AS QUL', 'ON QUL.id = BS.highest_qualification', 'left');
			$this->db->join('p2p_app_borrower_details AS APP', 'ON APP.borrower_id = bed.borrower_id', 'left');
			$this->db->where('APP.borrower_id IS NOT NULL', null, false);
			$result = $this->db->get();
			//echo "<pre>"; echo $this->db->last_query(); exit;
			if ($this->db->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadMisp2pnotgivenapp()
	{


		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'rating' && !empty($_POST['rating'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db->select("$str");
			$this->db->from('p2p_borrowers_list AS BS');
			$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
			$this->db->join('p2p_disburse_loan_details AS DLD', 'ON BN.bid_registration_id = DLD.bid_registration_id', 'left');
			$this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');
			$this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left');
			$this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left');
			$this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left');
			$this->db->join('p2p_app_borrower_details AS APP', 'ON BS.id = APP.borrower_id', 'left');
			$this->db->where('BS.id AND APP.borrower_id');
			$this->db->where_not_in('DLD.bid_registration_id AND BS.id');
			$result = $this->db->get();

			if ($this->db->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadMisp2pgivenweb()
	{

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}
			if ($key == 'loan' && !empty($_POST['loan'])) {
				if (!empty($str)) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}
			if ($key == 'rating' && !empty($_POST['rating'])) {
				if(!empty($str))
				{
					$str .= ' ,' . implode(',', $value);
				}
				else{
					$str .= implode(',', $value);
				}
			}


			if ($key == 'recovery' && !empty($_POST['recovery'])) {
				if(!empty($str))
				{
					$str .= ' ,' . implode(',', $value);
				}
				else{
					$str .= implode(',', $value);
				}
			}
		}
//		echo "<pre>";
//		print_r($_POST);
//		echo $str; exit;
		if (!empty($_POST)) { echo "<pre>";
			$this->db->select("$str");
			$this->db->from('p2p_borrower_emi_details AS bed');
			$this->db->join('p2p_emi_payment_details AS epd', 'ON epd.emi_id = bed.id', 'left');
			$this->db->join('p2p_borrowers_list AS BS', 'on BS.id = bed.borrower_id', 'left');
			$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BN.bid_registration_id = bed.loan_id', 'left');
			$this->db->join('p2p_disburse_loan_details AS DLD', 'ON DLD.id = bed.disburse_loan_id', 'left');
			$this->db->join('p2p_borrower_bank_details AS BNK', 'ON BNK.borrower_id = bed.borrower_id', 'left');
			$this->db->join('p2p_borrower_address_details AS ADR', 'ON ADR.borrower_id = bed.borrower_id', 'left');
			$this->db->join('ant_borrower_rating AS RATI', 'ON RATI.borrower_id = bed.borrower_id', 'left');
			$this->db->join('p2p_occupation_details_table AS OCU', 'ON  OCU.id = BS.occuption_id', 'left');
			$this->db->join('p2p_qualification AS QUL', 'ON QUL.id = BS.highest_qualification', 'left');
			$this->db->join('p2p_app_borrower_details AS APP', 'ON APP.borrower_id = bed.borrower_id', 'left');
			$this->db->where('APP.borrower_id IS NULL', null, false);
//			$this->db->where('BN.loan_no', 'LN10000000004');
			$result = $this->db->get();
//			echo "<pre>"; echo $this->db->last_query(); exit;
			if ($this->db->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadMisp2pnotgivenweb()
	{


		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'rating' && !empty($_POST['rating'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}


		}


		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db->select("$str");
			$this->db->from('p2p_borrowers_list AS BS');
			$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
			$this->db->join('p2p_disburse_loan_details AS DLD', 'ON BN.bid_registration_id = DLD.bid_registration_id', 'left');
			$this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');
			$this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left');
			$this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left');
			$this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left');
			$this->db->join('p2p_app_borrower_details AS APP', 'ON BS.id = APP.borrower_id', 'left');
			$this->db->where_not_in('DLD.bid_registration_id AND BS.id');
			$this->db->where_not_in('BS.id AND APP.borrower_id');
			$result = $this->db->get();

			if ($this->db->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadMisp2pall()
	{


		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'loan' && !empty($_POST['loan'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'rating' && !empty($_POST['rating'])) {
				if (!empty($_POST['personal']) && empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan'])) {
					$str .= implode(',', $value);
				}
			}


			if ($key == 'recovery' && !empty($_POST['recovery'])) {
				if (!empty($_POST['personal']) && empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		// exit;

		if (!empty($_POST)) {
			$this->db->select("$str");
			$this->db->from('p2p_borrowers_list AS BS');
			$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
			$this->db->join('p2p_disburse_loan_details AS DLD', 'ON BN.bid_registration_id = DLD.bid_registration_id', 'left');
			$this->db->join('p2p_borrower_emi_details AS EMI', 'ON BS.id = EMI.borrower_id', 'left');
			$this->db->join('p2p_borrower_bank_details AS BNK', 'ON BS.id = BNK.borrower_id', 'left');
			$this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');
			$this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left');
			$this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left');
			$this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left');
			$this->db->join('p2p_app_borrower_details AS APP', 'ON BS.id = APP.borrower_id', 'left');

			$result = $this->db->get();

			if ($this->db->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadGoogleallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '1');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

	public function doenloadFacebookallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '2');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadWebsiteallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '3');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadCreatedallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '4');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadClassifiedallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '5');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

	public function doenloadEmailerallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '6');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadFinBuddyallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '7');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadSoftCallallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '8');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadTransferFallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '9');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadScrubDataallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '10');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadLandingAdallCon()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '11');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadGoogleall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '1');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadFacebookall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '2');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadWebsiteall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '3');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

	public function doenloadCreatedall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '4');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadClassifiedall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '5');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadEmailerall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '6');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

	public function doenloadFinBuddyall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '7');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadSoftCallall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '8');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadTransferFall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '9');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadScrubDataall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}

		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '10');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}


	public function doenloadLandingAdall()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');
			$this->db2->where_not_in('ALL.status', '15');
			$this->db2->where('ALL.source_of_lead', '11');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************


	public function doenloadGooglelead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '1');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadFacebooklead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '2');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "We could not found any Data.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadWebsitelead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '3');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadCreatedlead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '4');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadClassifiedlead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '5');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************


	public function doenloadEmailerlead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '6');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadFinBuddylead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '7');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadSoftCalllead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '8');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadTransferFlead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '9');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadScrubDatalead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '10');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}

//************************************************************************************************************

	public function doenloadLandingAdlead()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = "";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'address' && !empty($_POST['address'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'workinfo' && !empty($_POST['workinfo'])) {
				if (!empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}


				if (!empty($_POST['personal']) && !empty($_POST['address'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address'])) {
					$str .= implode(',', $value);
				}

			}


			if ($key == 'other' && !empty($_POST['other'])) {


				if (!empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['address']) && !empty($_POST['workinfo'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['address']) && empty($_POST['workinfo'])) {
					$str .= implode(',', $value);
				}


			}


		}
		// echo $str;
		//exit;

		if (!empty($_POST)) {
			$this->db2->select("$str");
			$this->db2->from('ant_all_leads AS ALL');
			$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
			$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
			$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
			$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
			$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

			$this->db2->where('ALL.source_of_lead', '11');
			$result = $this->db2->get();
			if ($this->db2->affected_rows() > 0) {
				$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
				force_download($filename, $data);
			} else {
				$msg = "Data not found.";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'p2padmin/mis/');
			}
		}
	}
//************************************************************************************************************

    // Download Borrower Status
    public function downloadBorrowerstatus()
	{
//		echo "<pre>";
//		print_r($_POST); exit;
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Mis.csv";
		unset($_POST['submit']);
		$str = " ";
		foreach ($_POST as $key => $value) {
			if ($key == 'personal' && !empty($_POST['personal'])) {
				$str .= implode(',', $value);
			}


			if ($key == 'loan' && !empty($_POST['loan'])) {
				if (!empty($_POST['personal'])) {
					$str .= ' ,' . implode(',', $value);
				} else {
					$str .= implode(',', $value);
				}

			}

			if ($key == 'rating' && !empty($_POST['rating'])) {
				if (!empty($_POST['personal']) && empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['loan'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan'])) {
					$str .= implode(',', $value);
				}
			}


			if ($key == 'recovery' && !empty($_POST['recovery'])) {
				if (!empty($_POST['personal']) && empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && !empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && !empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (!empty($_POST['personal']) && empty($_POST['loan']) && !empty($_POST['rating'])) {
					$str .= ' ,' . implode(',', $value);
				}

				if (empty($_POST['personal']) && empty($_POST['loan']) && empty($_POST['rating'])) {
					$str .= implode(',', $value);
				}


			}


		}
		$this->db->select("IF(epd.id IS NULL, 'ND1', 'ND2') AS Borrower,
                            CASE
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=7)  THEN 'G1'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >7 AND DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <= 15) then 'G2'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >15 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=21) then 'G3'
                              WHEN (bed.status = 1 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >21 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=30) then 'G4'                              
                              END AS GoodBorrower,
                            CASE
                              WHEN (DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >30 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=60) then 'B1'
                              WHEN (DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >60 and DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) <=90) then 'B2'
                              WHEN DATEDIFF(bed.emi_date, DATE(epd.emi_payment_date)) >90 then 'B3'
                              
                              END AS BadBorrower                      
                          ".' ,'.$str);
		$this->db->from('p2p_borrower_emi_details AS bed');
		$this->db->join('p2p_borrowers_list AS BL', 'ON BL.id = bed.borrower_id', 'left');
		$this->db->join('p2p_emi_payment_details AS epd', 'ON epd.emi_id = bed.id', 'left');
		//
		$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BN.borrowers_id = bed.borrower_id', 'left');
		$this->db->join('p2p_borrower_address_details AS ADR', 'ON ADR.borrower_id = bed.borrower_id', 'left');
		$this->db->join('p2p_borrower_bank_details AS BNK', 'ON BNK.borrower_id = bed.borrower_id', 'left');
		$this->db->join('p2p_disburse_loan_details AS DLD', 'ON DLD.id = bed.disburse_loan_id', 'left');
		$this->db->join('p2p_occupation_details_table AS OCU', 'ON BL.occuption_id = OCU.id', 'left');
		$this->db->join('p2p_qualification AS QUL', 'ON BL.highest_qualification = QUL.id', 'left');
		$this->db->join('ant_borrower_rating AS RATI', 'ON RATI.borrower_id = bed.borrower_id', 'left');


		$this->db->order_by('bed.borrower_id');
		$query = $this->db->get();
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		force_download($filename, $data);
	}

	//P2P update payments

	public function updaterazorpaypayments()
	{
		$data['pageTitle'] = "MIS List";

		$data['title'] = "MIS List";
		$this->load->view('templates-admin/header', $data);
		$this->load->view('templates-admin/mis-nav', $data);
		$this->load->view('mis/razorpay', $data);
		$this->load->view('templates-admin/footer', $data);
	}

	public function uploadRazorpaypayments()
	{
		if (isset($_POST["submitpnbfile"])) {
			$this->money = $this->load->database('money', true);
			$filename = $_FILES["pnbResponsefile"]["tmp_name"];
			if ($_FILES["pnbResponsefile"]["size"] > 0) {

				$file = fopen($filename, "r");
				$firstRow = true;
				$i = 1;
				echo "<pre>";

				while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
					if ($firstRow) {
						$firstRow = false;
					} else {
						if($importdata[3] == 'captured')
						{
							//print_r($importdata);
							$time_arr = explode(' ', $importdata[25]);
							$date_arr = explode('/', $time_arr[0]);
							$date = strtotime($date_arr[2].'-'.$date_arr[1].'-'.$date_arr[0].' '.$time_arr[1]);
							$mobile  = substr($importdata[19], -10, '10');
							$query = $this->money->select('id')->get_where('ant_all_leads', array('mobile' => $mobile));
							if($this->money->affected_rows()>0)
							{
								$lead_id = $query->row()->id;
							}
							else{
								$lead_id = '';
							}
							$this->money->get_where('p2p_res_borrower_payment', array('payment_id' => $importdata[0]));
							if($this->money->affected_rows() == 0)
							{
//                                echo $date;
								$para = array(
									'lead_id' => $lead_id,
									'payment_id' => $importdata[0],
									'mobile' => $mobile,
									'email' => $importdata[18],
									'amount' => $importdata[1],
									'created_date' => date('Y-m-d H:i:s', $date),
								);
								$this->money->insert('p2p_res_borrower_payment', $para);
							}

						}

					}
				}

				fclose($file);
				$msg = "File upload successfully";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url().'p2padmin/mis/updaterazorpaypayments');
			}
			else{
				$msg = "Please Check File";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url().'p2padmin/mis/updaterazorpaypayments');
			}
		}
		else{
			$msg = "Please Select File";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url().'p2padmin/mis/updaterazorpaypayments');
		}
	}
	
	//Borrower Classification

	public function downloadBorrowerclassification()
	{
		echo "<pre>";
		$this->db2 = $this->load->database('money', true);

		$query = $this->db->select("bl.id as borrower_id, bl.borrower_id as b_borrower_id, bl.name, bl.email, bl.mobile, 
		                   bl.gender, bl.dob, bl.marital_status, bl.pan, date(bl.created_date) as borrowerCreationdate,
		                   odt.name as occupation, 
		                   q.qualification,
		                   bad.r_address as address1,
		                   bad.r_address1 as address2,
		                   bad.r_city as city,
		                   bad.r_state as state,
		                   bad.r_pincode as pincode,
		                   bank.bank_name,
		                   bank.account_number,
		                   bank.ifsc_code,
		                   dld.loan_status as loan_status  
		                  ")
			->join('p2p_borrowers_list bl', 'bl.id = dld.borrower_id', 'left')
			->join('p2p_occupation_details_table odt', 'odt.id = bl.id', 'left')
			->join('p2p_qualification q', 'q.id = bl.id', 'left')
			->join('p2p_borrower_address_details bad', 'bad.borrower_id = dld.borrower_id', 'left')
			->join('p2p_borrower_bank_details bank', 'bank.borrower_id = dld.borrower_id', 'left')
			->group_by('dld.borrower_id')
			->order_by('dld.date_created', 'desc')
			->get_where('p2p_disburse_loan_details as dld');
		if($this->db->affected_rows()>0)
		{
			$results = $query->result_array();
			foreach ($results as $result) {
				$query = $this->db->order_by('id', 'desc')->limit(1)->get_where('ant_borrower_rating', array('borrower_id' => $result['borrower_id']));
				if($this->db->affected_rows()>0)
				{
					$experian = (array)$query->row();
					unset($experian['id']);
					unset($experian['borrower_id']);
					unset($experian['created_date']);
					unset($experian['modified_date']);

					$arr = array_merge($result, $experian);
				}
				if($result['loan_status'] == 1)
				{
					$borrower_classification['classification'] = 'PR1C';
				}
				else{
					$this->db->where('bed.emi_date <', 'CURDATE()', false)->where("DATEDIFF(CURDATE(), bed.emi_date) > ", 90)->get_where('p2p_borrower_emi_details as bed', array('bed.borrower_id' => $result['borrower_id'], 'bed.status' => 0));
					if($this->db->affected_rows()>0)
					{
						$borrower_classification['classification'] = 'PR2';
					}
					else{
						$this->db->where('bed.emi_date <', 'CURDATE()', false)->where("DATEDIFF(DATE(epd.emi_payment_date), bed.emi_date) >", 90)
							->join('p2p_emi_payment_details AS epd', 'ON epd.emi_id = bed.id', 'left')
							->get_where('p2p_borrower_emi_details as bed', array('bed.borrower_id' => $result['borrower_id'], 'bed.status' => 1));
						if($this->db->affected_rows()>0)
						{
							$borrower_classification['classification'] = 'PR2';
						}
						else{
							$borrower_classification['classification'] = 'PR1';
						}

					}

				}



				$contact['total_contact'] = @$this->db2->select("count_no")
					->get_where('fc_contact_count', array('mobile' => $result['mobile']))->row()->count_no;
				$data[] = array_merge($arr, $contact,  $borrower_classification);

//					array(
//						"borrower_id" => $result['borrower_id'],
//						"b_borrower_id" => $result['b_borrower_id'],
//						"name" => $result['name'],
//						"email" => $result['email'],
//						"mobile" => $result['mobile'],
//						"gender" => $result['gender'],
//						"dob" => $result['dob'],
//						"marital_status" => $result['marital_status'],
//						"pan" => $result['pan'],
//						"borrowerCreationdate" => $result['borrowerCreationdate'],
//						"occupation" => $result['occupation'],
//						"qualification" => $result['qualification'],
//						"address1" => $result['address1'],
//						"address2" => $result['address2'],
//						"city" => $result['city'],
//						"state" => $result['state'],
//						"pincode" => $result['pincode'],
//						"bank_name" => $result['bank_name'],
//						"account_number" => $result['account_number'],
//						"ifsc_code" => $result['ifsc_code'],
//						"experian_score" => $experian['experian_score'],
//						"antworksp2p_rating" => $experian['antworksp2p_rating'],
//						"experian_response" => $experian['experian_response'],
//						"overall_leveraging_ratio" => $experian['overall_leveraging_ratio'],
//						"leverage_ratio_maximum_available_credit" => $experian['leverage_ratio_maximum_available_credit'],
//						"limit_utilization_revolving_credit" => $experian['limit_utilization_revolving_credit'],
//						"outstanding_to_limit_term_credit" => $experian['outstanding_to_limit_term_credit'],
//						"outstanding_to_limit_term_credit_including_past_facilities" => $experian['outstanding_to_limit_term_credit_including_past_facilities'],
//						"short_term_leveraging" => $experian['short_term_leveraging'],
//						"revolving_credit_line_to_total_credit" => $experian['revolving_credit_line_to_total_credit'],
//						"short_term_credit_to_total_credit" => $experian['short_term_credit_to_total_credit'],
//						"secured_facilities_to_total_credit" => $experian['secured_facilities_to_total_credit'],
//						"fixed_obligation_to_income" => $experian['fixed_obligation_to_income'],
//						"no_of_active_accounts" => $experian['no_of_active_accounts'],
//						"variety_of_loans_active" => $experian['variety_of_loans_active'],
//						"no_of_credit_enquiry_in_last_3_months" => $experian['no_of_credit_enquiry_in_last_3_months'],
//						"no_of_loans_availed_to_credit_enquiry_in_last_12_months" => $experian['no_of_loans_availed_to_credit_enquiry_in_last_12_months'],
//						"history_of_credit_oldest_credit_account" => $experian['history_of_credit_oldest_credit_account'],
//						"limit_breach" => $experian['limit_breach'],
//						"overdue_to_obligation" => $experian['overdue_to_obligation'],
//						"overdue_to_monthly_income" => $experian['overdue_to_monthly_income'],
//						"number_of_instances_of_delay_in_past_6_months" => $experian['number_of_instances_of_delay_in_past_6_months'],
//						"number_of_instances_of_delay_in_past_12_months" => $experian['number_of_instances_of_delay_in_past_12_months'],
//						"number_of_instances_of_delay_in_past_36_months" => $experian['number_of_instances_of_delay_in_past_36_months'],
//						"cheque_bouncing" => $experian['cheque_bouncing'],
//					);

			}

			foreach ($data[0] as $k => $v)
			{

				$head[] = $k;
			}

			header("Content-type: application/csv");
			header("Content-Disposition: attachment; filename=Loan-file.csv");
			$fp = fopen('php://output', 'w');
			$i = 1;

			foreach ($data as $key => $loan) {
				if ($i == 1) {
					fputcsv($fp, $head);
				}
				fputcsv($fp, $loan);
				$i++;
			}
			fclose($fp);
			exit;
		}
		else{

		}

	}

}

?>
