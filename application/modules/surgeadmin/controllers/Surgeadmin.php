<?php

class Surgeadmin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
		$this->load->model('Investmodel');
		$this->load->library('form_validation');
		$this->load->helper('custom');
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('login');
		$this->load->model('Investmodel'); 
	}

	function login()
	{
		$this->load->view('templates/header');
		$this->load->view('login');
	}

	function loginnow()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE) {
				$email = $this->input->post('email');
				$password = md5(($this->input->post('password')));


				$this->load->model('surge_model');
				$status = $this->surge_model->checkPassword($password, $email);
				if ($status) {
					$id = $status->id;
					$email = $status->email;
					$role = $status->role;


					$session_data = array(
						'id' => $id,
						'email' => $email
					);

					$this->session->set_userdata('session_data', $session_data);
					if ($role == 'admin') {
						redirect(base_url('Surgeadmin/teamdashboard'));
					} elseif ($role == 'partner') {
						redirect(base_url('Surgeadmin/partnerdashboard'));
					} else {
						redirect(base_url('Surgeadmin/userdashboard'));
					}
				} else {
					$this->session->set_flashdata('error', 'Email or Password is Wrong');
					redirect(base_url('Surgeadmin/login'));
				}
			} else {
				$this->session->set_flashdata('error', 'Fill all the required fields');
				redirect(base_url('Surgeadmin/login'));
			}
		}
	}

	function dashboard()
	{
		$this->load->view('templates/dbheader');
		$this->load->view('dashboard');
	}

	function register_partner()
	{

		$this->load->view('templates/teamheader');

		$this->load->view('partners/register_partner');

		$this->load->view('templates/footer');
		
		removeFlashData();
	}

	public function partner_reg()
	{
		$this->load->model('Investmodel');

		$this->form_validation->set_rules('Company_Name', 'company_Name', 'required|regex_match[/^([a-z ])+$/i]');
		$this->form_validation->set_rules('Address', 'address', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');


		if ($this->form_validation->run() == TRUE) {

			$data = $this->Investmodel->insert_partner();
			$this->session->set_flashdata('flashmsg', 'Partner registerd successfully </div>');

			redirect(base_url('Surgeadmin/allpartner'));
		} {
			$this->register_partner();
		}
	}

	
	

	
	public function vend_addscheme()
	{
		$this->load->model('Investmodel');

		$data['result'] = $this->Investmodel->vend_addcheme_get();


		$this->load->view('templates/teamheader');

		$this->load->view('partners/vend_addcheme', $data);

		$this->load->view('templates/footer');
		
		removeFlashData();
	}

	
	public function vend_addschemenow()
	{

		$this->form_validation->set_rules('Scheme_Name', 'scheme_Name', 'required');
		$this->form_validation->set_rules('vendor', 'Vendor', 'required');
		$this->form_validation->set_rules('Min_Inv_Amount', 'min_Inv_Amount', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('Max_Inv_Amount', 'max_Inv_Amount', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('Aggregate_Amount', 'Aggregate_Amount', 'required');
		$this->form_validation->set_rules('Lockin', 'lockin');
		$this->form_validation->set_rules('Lockin_Period', 'lockin_Period','required');
		$this->form_validation->set_rules('Cooling_Period', 'cooling_Period', 'required|integer');
		$this->form_validation->set_rules('Interest_Rate', 'interest_Rate');
		$this->form_validation->set_rules('Hike_Rate', 'hike_Rate');
		$this->form_validation->set_rules('Pre_Mat_Rate', 'Pre_Mat_Rate');
		$this->form_validation->set_rules('Withrawl_Anytime', 'withrawl_Anytime', 'required');
		$this->form_validation->set_rules('Auto_Redeem', 'auto_Redeem', 'required');
		$this->form_validation->set_rules('Interest_Type', 'interest_Type', 'required');

		if ($this->form_validation->run() == TRUE) {
			$schemeName = $this->input->post('Scheme_Name');
	
			if (!$this->Investmodel->isSchemeNameExists($schemeName)) {
				$data = $this->Investmodel->insert_scheme();
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Scheme registered successfully</div>');
				redirect(base_url('Surgeadmin/allschemes'));
				
			} else {
				
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger text-center">Scheme name already exists</div>');
				redirect(base_url('Surgeadmin/vend_addscheme'));
			}
		} else {
			$this->vend_addscheme();
		}
		
	 }

	function add_representative()
	{
		$this->load->model('Investmodel');
		$data['result'] = $this->Investmodel->scheme_vend_get();

		$this->load->view('templates/teamheader');

		$this->load->view('partners/add_representative', $data);

		$this->load->view('templates/footer');
		
		removeFlashData();
	}

	public function reg_representative()
	{
		$this->load->model('Investmodel');

		$this->form_validation->set_rules('RepName', 'repName', 'required|regex_match[/^([a-z ])+$/i]');
		$this->form_validation->set_rules('vender', 'Vender', 'required');
		$this->form_validation->set_rules('RepDesignation', 'repDesignation', 'required|regex_match[/^([a-z ])+$/i]');
		$this->form_validation->set_rules('Repphone', 'repphone', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('Repemail', 'repemail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password]');



		if ($this->form_validation->run() == TRUE) {

			$data = $this->Investmodel->insert_repersentive();
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Repersentive registerd successfully </div>');

			redirect(base_url('Surgeadmin/allrepersentative'));
		} {
			$this->add_representative();
		}
	}

	

	public	function teamdashboard()
	{

		$this->load->view('templates/teamheader');
		$this->load->view('buisnessteam/teamdashboard');
		$this->load->view('templates/footer');
	}

	public	function Partnerlogin()
	{
		$this->load->view('templates/header');

		$this->load->view('partners\vendor_login.php');
	}
	public	function Partnerloginnow()
	{
	

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE) {

				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$this->load->model('Investmodel');
				$status = $this->Investmodel->checkvenrep($password, $email);

				if ($status != false) {
					$username = $status->RepName;
					$email = $status->Repemail;
					$RID = $status->RID;
					$VID = $status->Vendor_ID;

					$session_data = array(
						'fullname' => $username,
						'email' => $email,
						'RID' => $RID,
						'VID' => $VID
					);

					$this->session->set_userdata('venloginsession', $session_data);

					redirect(base_url('Surgeadmin/vendordashboard'));
				} else {
					$this->session->set_flashdata('error', 'Email or Password is Wrong');
					redirect(base_url('Surgeadmin/vendor_login'));
				}
			} else {
				$this->session->set_flashdata('error', 'Fill all the required fields');
				redirect(base_url('Surgeadmin/vendor_login'));
			}
		}
	}

	public function vendordashboard()
	{

		$this->load->view('templates/venheader');
		$this->load->view('partners/vendordashboard');
	}

	public function allpartner()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->allpartners_get();
		$this->load->view('buisnessteam/allpartner', $data);
		$this->load->view('templates/footer');
	}


	public function allhikelogs()
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data['row'] = $this->Investmodel->allhikes_get();
		$this->load->view('buisnessteam/allhikelogs', $data);
		$this->load->view('templates/footer');
	}

	public function allrepersentative()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->allrepersent_gets();

		$this->load->view('buisnessteam/allrepersentative', $data);
		$this->load->view('templates/footer');
	}


	public function redemptionlist_request()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->redemption_gets();

		$this->load->view('buisnessteam/redemptionlist_request', $data);
		$this->load->view('templates/footer');
	}

public function redemption_process()
{

	$this->load->model('Investmodel');
	$this->load->view('templates/teamheader');
	$data['row'] = $this->Investmodel->disbursment_gets();
	$this->load->view('buisnessteam/redemption_process', $data);
	$this->load->view('templates/footer');
}

public function redeem()
{

	$this->load->model('Investmodel');
	$this->load->view('templates/teamheader');
	$data['row'] = $this->Investmodel->disburse_gets();
	$this->load->view('buisnessteam/redemption_redeem', $data);
	$this->load->view('templates/footer');
}

public function redemption_pending()
{

	$this->load->model('Investmodel');
	$this->load->view('templates/teamheader');
	$data['row'] = $this->Investmodel->dipending_gets();
	$this->load->view('buisnessteam/redemption_pending', $data);
	$this->load->view('templates/footer');
}

	public function declinelist()
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->decline_gets();
		$this->load->view('buisnessteam/redemptionlist', $data);
		$this->load->view('templates/footer');
	}

	public function Investmentlist()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->investment_gets();

		$this->load->view('buisnessteam/Investmentlist', $data);
		$this->load->view('templates/footer');
	}

	
	public function schemelogs($id)
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data['row'] = $this->Investmodel->schemelogs_get($id);

		$this->load->view('buisnessteam/schemelog', $data);
		$this->load->view('templates/footer');
	}


	public function allschemes()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data['row'] = $this->Investmodel->allschemes_get();

		$this->load->view('buisnessteam/allschemes', $data);
		$this->load->view('templates/footer');
	}

	public function editschemes($id)
	{

		$data['result'] = $this->Investmodel->vend_addcheme_get();
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');


		$data['schemelist'] = $this->Investmodel->updateschemes($id);


		$this->load->view('buisnessteam/editscheme', $data);
		$this->load->view('templates/footer');
		
		removeFlashData();
	}


	public function redemptionapproved($id, $st)
	{
	       
		$this->Investmodel->redemptionapproved($id, $st);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-warning text-center">Pending for redemption </div>');
		redirect(base_url() . 'Surgeadmin/redemption_pending/');
	}

	
	
	public function disburseapproved($id, $st)
	{
	       
		$this->Investmodel->disburseapproved($id, $st);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Disbursment Successfully  </div>');
		redirect(base_url() . 'Surgeadmin/redeem/');
	}

	/*public function pendingapproved($id, $st)
	{
	       
		$this->Investmodel->pendingapproved($id, $st);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger text-center">Disbursment Is In Pending  </div>');
		redirect(base_url() . 'Surgeadmin/dipending/');
	}*/


	public function update_redemption_status() {  
			
		$redemption_status = $this->input->post('redemption_status');
		$updatedRows = $this->Investmodel->updateRedemptionStatus($redemption_status);
	   echo json_encode($updatedRows);
	   }


	
	public function decline($id, $st)
	{
	       
		$this->Investmodel->decline($id, $st);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger text-center">Declined Successfylly </div>');
		redirect(base_url() . 'Surgeadmin/redemptionlist/');
	}

	public function statusupdate($id, $status)
	{

		$st = ($status == 0 ? 1 : 0);
		$this->Investmodel->statusupdate($id, $st);
		$this->session->set_flashdata('flashmsg', '<div class="alert alert-warning text-center">Status Updated Successfylly </div>');
		redirect(base_url() . 'Surgeadmin/allschemes/');
	}

	public function updatescheme()
	{
		$this->load->model('Investmodel');

		$this->load->view('templates/teamheader');

		$data = array(
			'Scheme_Name' => $this->input->post('Scheme_Name'),
			'Vendor_ID' => $this->input->post('vendor'),
			'Min_Inv_Amount' => $this->input->post('Min_Inv_Amount'),
			'Max_Inv_Amount' => $this->input->post('Max_Inv_Amount'),
			'Aggregate_Amount' => $this->input->post('Aggregate_Amount'),
			'Lockin' => $this->input->post('Lockin'),
			'Lockin_Period' => $this->input->post('Lockin_Period'),
			'Cooling_Period' => $this->input->post('Cooling_Period'),
			'Interest_Rate' => $this->input->post('Interest_Rate'),
			'hike_rate' => $this->input->post('hike_rate'),
			'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
			'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
			'Auto_Redeem' => $this->input->post('Auto_Redeem'),
			'Interest_Type' => $this->input->post('Interest_Type'),

		);
	
		$result = $this->Investmodel->update_scheme($data);

		$this->load->view('buisnessteam/allschemes', $data);
		$this->load->view('templates/footer');
		if ($result) {

			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Scheme Updated Successfully </div>');
			redirect(base_url() . 'Surgeadmin/allschemes/');
		} else {

			$this->session->set_flashdata('flashmsg', 'Scheme Not Updated Successfylly');
			redirect(base_url() . 'Surgeadmin/allschemes/');
		}
	}

	public function editvendor($VID)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');


		$data['adminlist'] = $this->Investmodel->edituser($VID);


		$this->load->view('buisnessteam/editvendor', $data);
		$this->load->view('templates/footer');

		removeFlashData();
	}
	public function editscheme($id)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['schemelist'] = $this->Investmodel->updateschemes($id);
		$this->load->view('buisnessteam/editscheme', $data);
		$this->load->view('templates/footer');
	}


	public function updatevendor()
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data = array(
			'Company_Name' => $this->input->post('Company_Name'),
			'Address' => $this->input->post('Address'),
			'Phone' => $this->input->post('Phone'),
			'Email' => $this->input->post('Email'),
		);
		$result = $this->Investmodel->update_user($data);

		$this->load->view('buisnessteam/allpartner', $data);
		$this->load->view('templates/footer');
		if ($result) {
			
			$this->session->set_flashdata('flashmsg', 'Partner updated successfully');
			redirect(base_url() . 'Surgeadmin/allpartner/');
		} else {
			
			$this->session->set_flashdata('flashmsg', 'Partner not updated successfully');
			redirect(base_url() . 'Surgeadmin/allpartner/');
		}
	}
	public	function logout()
	{
		session_destroy();
		redirect(base_url('Surgeadmin/login'));
	}

	public function deletevender($VID)
	{


		$this->cldb->where('VID', $VID);
		$row1 = $this->cldb->delete('invest_vendors');
		if ($row1 == true) {

			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Pender deleted successfully</div>');
		} else {

			$this->session->set_flashdata('error', 'Partner not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allpartner'));
	}

	public function deleterepersent($rid)
	{

		$this->cldb->where('rid', $rid);
		$row1 = $this->cldb->delete('invest_repessentative');
		if ($row1 == true) {
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger text-center">Repersentative deleted successfully </div>');
		} else {
			$this->session->set_flashdata('flashmsg', 'Repersantative not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allrepersentative'));
	}

	public function deletescheme($id)
	{


		$this->cldb->where('id', $id);
		$row1 = $this->cldb->delete('invest_scheme_details');
		if ($row1 == true) {
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger text-center">Scheme deleted successfully </div>');
		} else {
			$this->session->set_flashdata('flashmsg', 'Scheme not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allschemes'));
	}

	


	public function editrepersent($rid)
	{
		$this->load->model('Investmodel');
		$data['result'] = $this->Investmodel->scheme_vend_get();
		$this->load->view('templates/teamheader');


		$data['representlist'] = $this->Investmodel->editrepersents($rid);


		$this->load->view('buisnessteam/editreprsenative', $data);
		$this->load->view('templates/footer');

		removeFlashData();
	}


	public function updaterepersent()
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data = array(
			'RepName' => $this->input->post('RepName'),
			'vender' => $this->input->post('vender'),
			'RepDesignation' => $this->input->post('RepDesignation'),
			'Repphone' => $this->input->post('Repphone'),
			'Repemail' => $this->input->post('Repemail'),
			'password' => md5($this->input->post('password')),

		);
		$result = $this->Investmodel->update_repersent($data);

		$this->load->view('buisnessteam/allrepersentative', $data);
		$this->load->view('templates/footer');
		if ($result) {

			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Repersentive Updated Successfully </div>');
			redirect(base_url() . 'Surgeadmin/allrepersentative/');
		} else {

			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success text-center">Repersentive Updated Successfully </div>');
			redirect(base_url() . 'Surgeadmin/allrepersentative/');
		}
	}
}
