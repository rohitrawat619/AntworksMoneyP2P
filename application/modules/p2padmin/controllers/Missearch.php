<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Missearch extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db2 = $this->load->database('money', true);
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
		$this->load->library('form_validation');
		$this->form_validation->set_rules('selectedData', 'Product', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Date', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if (!empty($_POST)) {
				if ($this->input->post('selectedData') == 'P2PLoanGiven') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];
						// Date Format
						$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
						$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

						$where = "DLD.date_created > '$start_date' AND DLD.date_created < '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";
					// unset($_POST['submit']);

					$this->db->select("DLD.date_created,
                                                               BS.borrower_id,
                                                               BS.name,
                                                               BS.mobile,
                                                               BS.email,
                                                               QUL.qualification,
                                                               OCU.name AS occupation,
                                                               BS.gender,
                                                               BS.dob,
                                                               ADR.r_city,
                                                               BNK.account_number,
                                                               BNK.ifsc_code,
                                                               BNK.bank_name,
                                                               DLD.approved_loan_amount,
                                                               DLD.loan_processing_charges,
                                                               EMI.emi_interest,
                                                               BN.accepted_tenor,
                                                               EMI.emi_amount,
                                                               EMI.emi_date,
                                                               BN.loan_no,
                                                               RATI.overall_leveraging_ratio,
                                                               RATI.leverage_ratio_maximum_available_credit,
                                                               RATI.limit_utilization_revolving_credit,
                                                               RATI.outstanding_to_limit_term_credit,
                                                               RATI.outstanding_to_limit_term_credit_including_past_facilities,
                                                               RATI.short_term_leveraging,
                                                               RATI.short_term_credit_to_total_credit,
                                                               RATI.secured_facilities_to_total_credit,
                                                               RATI.no_of_active_accounts,
                                                               RATI.variety_of_loans_active,
                                                               RATI.no_of_credit_enquiry_in_last_3_months,
                                                               RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months,
                                                               RATI.history_of_credit_oldest_credit_account,
                                                               RATI.limit_breach,
                                                               RATI.overdue_to_obligation,
                                                               RATI.overdue_to_monthly_income,
                                                               RATI.number_of_instances_of_delay_in_past_6_months,
                                                               RATI.number_of_instances_of_delay_in_past_12_months,
                                                               RATI.number_of_instances_of_delay_in_past_36_months,
                                                               RATI.cheque_bouncing,
                                                               RATI.credit_summation_to_annual_income,
                                                               RATI.digital_banking,
                                                               RATI.savings_as_percentage_of_annual_income,
                                                               RATI.present_residence,
                                                               RATI.city_of_residence,
                                                               RATI.highest_qualification,
                                                               RATI.age,
                                                               RATI.occupation,
                                                               RATI.experience,
                                                               BS.name,
                                                               BS.email,
                                                               BS.mobile,
                                                               BN.loan_no,
                                                               BN.bid_loan_amount,
                                                               ADR.r_city,
                                                               BNK.account_number,
                                                               EMI.emi_date,
                                                               EMI.emi_amount,
                                                               EMI.status,");


					$this->db->from('p2p_borrowers_list AS BS');
					$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
					$this->db->join('p2p_disburse_loan_details AS DLD', 'ON BS.id= DLD.bid_registration_id', 'left');
					$this->db->join('p2p_borrower_emi_details AS EMI', 'ON BS.id = EMI.borrower_id', 'left');
					$this->db->join('p2p_borrower_bank_details AS BNK', 'ON BS.id = BNK.borrower_id', 'left');
					$this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');
					$this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left');
					$this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left');
					$this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left');
					$this->db->join('p2p_app_borrower_details AS APP', 'ON BS.id = APP.borrower_id', 'left');
					$this->db->where('DLD.bid_registration_id AND BS.id');
					$this->db->where($where);
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
				else if ($this->input->post('selectedData') == 'P2PConverted') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];
						// Date Format
						$start_date = (date("Y-m-d", strtotime($start_date)));
						$end_date = (date("Y-m-d", strtotime($end_date)));

						$where = "DATE(bp.created_date) >= '$start_date' AND DATE(bp.created_date) <= '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";
					// unset($_POST['submit']);

					$result = $this->db2->select('aal.id as lead_id, 
					                 bp.mobile as razorpay_mobile,
					                 bp.email as razorpay_email,
					                 aal.fname,
									 aal.lname,
									 aal.email,
									 aal.state,
									 aal.city,
									 aal.address1,
									 aal.pin,
									 aal.pan,
									 aal.loan_amount,
									 aal.cibil_score,
									 aal.qualification,
									 aal.gender,
									 aal.dob,
									 aal.income,
									 aal.source_of_lead,
									 aal.campaign_id,
									 so.name as source,
									 sc.campaign_name,
									 aal.created_date
									 ')
								  ->join('ant_all_leads as aal', 'on aal.id = bp.lead_id',  'left')
								  ->join('ant_source as so', 'on so.id = aal.source_of_lead', 'left')
								  ->join('ant_source_campaign as sc', 'on sc.id = aal.campaign_id', 'left')

						          ->where($where)
								  ->get_where('p2p_res_borrower_payment as bp');
					if ($this->db2->affected_rows() > 0) {
						$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
						force_download($filename, $data);
					} else {
						$msg = "We could not found any Data.";
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
						redirect(base_url() . 'p2padmin/mis/');
					}

				}
				else if ($this->input->post('selectedData') == 'P2PLoanNotGiven') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];
						// Date Format
						$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
						$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

						$where = "BS.created_date > '$start_date' AND BS.created_date < '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";
					// unset($_POST['submit']);

					$this->db->select("BS.created_date,
                                                               BS.borrower_id,
                                                               BS.name,
                                                               BS.mobile,
                                                               BS.email,
                                                               QUL.qualification,
                                                               OCU.name AS occupation,
                                                               BS.gender,
                                                               BS.dob,
                                                               ADR.r_city,
                                                               RATI.overall_leveraging_ratio,
                                                               RATI.leverage_ratio_maximum_available_credit,
                                                               RATI.limit_utilization_revolving_credit,
                                                               RATI.outstanding_to_limit_term_credit,
                                                               RATI.outstanding_to_limit_term_credit_including_past_facilities,
                                                               RATI.short_term_leveraging,
                                                               RATI.short_term_credit_to_total_credit,
                                                               RATI.secured_facilities_to_total_credit,
                                                               RATI.no_of_active_accounts,
                                                               RATI.variety_of_loans_active,
                                                               RATI.no_of_credit_enquiry_in_last_3_months,
                                                               RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months,
                                                               RATI.history_of_credit_oldest_credit_account,
                                                               RATI.limit_breach,
                                                               RATI.overdue_to_obligation,
                                                               RATI.overdue_to_monthly_income,
                                                               RATI.number_of_instances_of_delay_in_past_6_months,
                                                               RATI.number_of_instances_of_delay_in_past_12_months,
                                                               RATI.number_of_instances_of_delay_in_past_36_months,
                                                               RATI.cheque_bouncing,
                                                               RATI.credit_summation_to_annual_income,
                                                               RATI.digital_banking,
                                                               RATI.savings_as_percentage_of_annual_income,
                                                               RATI.present_residence,
                                                               RATI.city_of_residence,
                                                               RATI.highest_qualification,
                                                               RATI.age,
                                                               RATI.occupation,
                                                               RATI.experience,");


					$this->db->from('p2p_borrowers_list AS BS');
					$this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
					$this->db->join('p2p_disburse_loan_details AS DLD', 'ON BS.id= DLD.bid_registration_id', 'left');
					$this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left');
					$this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');
					$this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left');
					$this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left');
					$this->db->where_not_in('DLD.bid_registration_id AND BS.id');
					$this->db->where($where);

					$result = $this->db->get();
					/*     $str = $this->db->last_query();

						 echo "<pre>";
						 print_r($str);
						 exit; */

					if ($this->db->affected_rows() > 0) {
						$data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
						force_download($filename, $data);
					} else {
						$msg = "We could not found any Data.";
						$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
						redirect(base_url() . 'p2padmin/mis/');
					}


				}
				else if ($this->input->post('selectedData') == 'CCConverted') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];

						$start_date = (date("Y-m-d", strtotime($start_date)));
						$end_date = (date("Y-m-d", strtotime($end_date)));

						$where = "DATE(pd.created_date) >= '$start_date' AND DATE(pd.created_date) <= '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";

					$this->db2->select("
					                     pd.payment_id,
					                     pd.payment_gateway,
					                     pd.channel,
					                     pd.amount,
										 CC.id AS LeadID,
										 CC.firstName,
										 CC.surName,
										 CC.dateOfBirth,
										 CC.gender,
										 CC.email,
										 CC.flatno,
										 CC.city,
										 CC.pincode,
										 CC.pan,
										 CC.mobileNo,
										 CC.monthly_income,
										 CC.experian_rating,
										 CC.gst,
										 CC.package,
										 CC.source_of_lead,
										 CC.source_of_lead_campaign,
										 ccs.name as source,
										 csc.name as campaign
										 ");
					$this->db2->from('cc_payment_details AS pd');
					$this->db2->join('credit_score_query AS CC', 'on cc.id = pd.cc_id', 'left');
					$this->db2->join('credit_counselling_source AS ccs', 'on ccs.id = CC.source_of_lead', 'left');
					$this->db2->join('credit_counselling_source_campaign AS csc', 'on csc.id = CC.source_of_lead_campaign', 'left');
					//$this->db2->join('cc_payment_invoice_details AS invo', 'on invo.cc_id = CC.id', 'left');
					$this->db2->where($where);
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
				else if ($this->input->post('selectedData') == 'CCNotConverted') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];

						$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
						$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

						$where = "CC.created_date > '$start_date' AND CC.created_date < '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";

					$this->db2->select("CC.id AS LeadID,
                                                            CC.firstName,
                                                            CC.surName,
                                                            CC.dateOfBirth,
                                                            CC.gender,
                                                            CC.email,
                                                            CC.flatno,
                                                            CC.city,
                                                            CC.pincode,
                                                            CC.pan,
                                                            CC.mobileNo,
                                                            CC.monthly_income,
                                                            CC.experian_rating,
                                                            CC.created_date,");
					$this->db2->from('credit_score_query AS CC');
					$this->db2->join('credit_counselling_payment_razorpay AS CR', 'ON CC.id = CR.credit_counselling_id', 'left');
					$this->db2->where_not_in('CR.credit_counselling_id AND CC.id');
					$this->db2->where_not_in('CC.status', '11');
					$this->db2->where($where);

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
				else if ($this->input->post('selectedData') == 'ALLConverted') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];
						// Date Format
						$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
						$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

						$where = "ALL.created_date > '$start_date' AND ALL.created_date < '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";
					// unset($_POST['submit']);

					$this->db->select("ALL.created_date,ALL.id,
                                                               ALL.fname,
                                                               ALL.lname,
                                                               ALL.email,
                                                               ALL.mobile,
                                                               ALL.pan,
                                                               ALL.gender,
                                                               ALL.marital_status,
                                                               ALL.cibil_score,
                                                               ALL.state,
                                                               ALL.city,
                                                               ALL.address1,
                                                               ALL.pin,
                                                               RES.name AS residence_type,
                                                               ALL.year_in_curr_residence,
                                                               ALL.is_parmanent_address,
                                                               ALL.property_details,
                                                               ALL.property_details_second,
                                                               ALL.property_value,
                                                               ALL.location_of_property,
                                                               ALL.location_of_property_pincode,
                                                               ALL.builder_name,
                                                               ALL.property_value,
                                                               ALL.industry_type,
                                                               ALL.occupation,
                                                               ALL.company_type,
                                                               ALL.company_name,
                                                               ALL.profession_type,
                                                               ALL.officeaddress,
                                                               ALL.working_since,
                                                               ALL.experiance,
                                                               ALL.turnover1,
                                                               ALL.office_ownership,
                                                               ALL.designation,
                                                               ALL.department,
                                                               ALL.salary_account,
                                                               ALL.income,
                                                               ALL.mode_of_salary,
                                                               ALL.qualification,
                                                               ALL.educational_institute_name,
                                                               ALL.loan_amount,
                                                               LT.loan_type,
                                                               ALL.outstanding_loan_details,
                                                               ALL.brief_outstanding_loan_details,
                                                               ALL.loan_bank,
                                                               ALL.send_to_bank,
                                                               SOU.name AS source_of_lead,
                                                               CAMP.campaign_name,
                                                               ALL.payout_id,
                                                               USR.username AS caller name,
                                                               ALL.status,");


				$this->db2->from('ant_all_leads AS ALL');
				$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
				$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
				$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
				$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
				$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');
				$this->db2->where('ALL.status', '15');
				$this->db2->where($where);

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
				else if ($this->input->post('selectedData') == 'ALLNotConverted') {

					$where = "";
					if ($this->input->post('start_date')) {
						$post_date = explode('+', $this->input->post('start_date'));
						$date = explode('-', $post_date[0]);
						$start_date = $date[0];
						$end_date = $date[1];
						// Date Format
						$start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
						$end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

						$where = "ALL.created_date > '$start_date' AND ALL.created_date < '$end_date'";
					}


					$this->load->dbutil();
					$this->load->helper('file');
					$this->load->helper('download');
					$delimiter = ",";
					$newline = "\r\n";
					$filename = "Mis.csv";
					// unset($_POST['submit']);

					$this->db->select("ALL.created_date,
                                                               ALL.id,
                                                               ALL.fname,
                                                               ALL.lname,
                                                               ALL.email,
                                                               ALL.mobile,
                                                               ALL.pan,
                                                               ALL.gender,
                                                               ALL.marital_status,
                                                               ALL.cibil_score,
                                                               ALL.state,
                                                               ALL.city,
                                                               ALL.address1,
                                                               ALL.pin,
                                                               RES.name AS residence_type,
                                                               ALL.year_in_curr_residence,
                                                               ALL.is_parmanent_address,
                                                               ALL.property_details,
                                                               ALL.property_details_second,
                                                               ALL.property_value,
                                                               ALL.location_of_property,
                                                               ALL.location_of_property_pincode,
                                                               ALL.builder_name,
                                                               ALL.property_value,
                                                               ALL.industry_type,
                                                               ALL.occupation,
                                                               ALL.company_type,
                                                               ALL.company_name,
                                                               ALL.profession_type,
                                                               ALL.officeaddress,
                                                               ALL.working_since,
                                                               ALL.experiance,
                                                               ALL.turnover1,
                                                               ALL.office_ownership,
                                                               ALL.designation,
                                                               ALL.department,
                                                               ALL.salary_account,
                                                               ALL.income,
                                                               ALL.mode_of_salary,
                                                               ALL.qualification,
                                                               ALL.educational_institute_name,
                                                               ALL.loan_amount,
                                                               LT.loan_type,
                                                               ALL.outstanding_loan_details,
                                                               ALL.brief_outstanding_loan_details,
                                                               ALL.loan_bank,
                                                               ALL.send_to_bank,
                                                               SOU.name AS source_of_lead,
                                                               CAMP.campaign_name,
                                                               ALL.payout_id,
                                                               USR.username AS caller name,
                                                               ALL.status,");


					$this->db2->from('ant_all_leads AS ALL');
					$this->db2->join('user_info AS USR', 'ON ALL.assigned_to = USR.user_id', 'left');
					$this->db2->join('ant_source AS SOU', 'ON ALL.source_of_lead = SOU.id', 'left');
					$this->db2->join('ant_source_campaign AS CAMP', 'ON ALL.source_of_lead = CAMP.id', 'left');
					$this->db2->join('bank_loan_type AS LT', 'ON ALL.product_type = LT.id', 'left');
					$this->db2->join('residence_type AS RES', 'ON ALL.residence_type = RES.id', 'left');

					$this->db2->where_not_in('ALL.status', '15');
					$this->db2->where($where);

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

		} else {
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
			redirect(base_url() . 'p2padmin/mis/');

		}


	}

}

?>
