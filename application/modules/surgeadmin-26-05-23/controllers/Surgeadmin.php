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
					$password = $this->input->post('password');


					$this->load->model('surge_model');
					$status = $this->surge_model->checkPassword($password,$email);
					if ($status) {
						$id = $status->id;
						$email = $status->email; 
						$role = $status->role; 
						

						$session_data = array(
							'id' => $id,
							'email' => $email
						);

						$this->session->set_userdata('session_data', $session_data);
                    if($role == 'admin'){
	                 redirect(base_url('Surgeadmin/teamdashboard'));
                   } elseif($role == 'partner'){
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

	public function vendor_regnow()
	{
		$this->load->model('Investmodel');
		
		$this->form_validation->set_rules('Company_Name', 'company_Name', 'required|alpha|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('Address', 'address', 'required|alpha|min_length[10]|max_length[50]');
		$this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');


		if ($this->form_validation->run() == TRUE) {

			$data = $this->Investmodel->insert_vendor();
            $this->session->set_flashdata('flashmsg', 'vender registerd successfully');

			redirect(base_url('Surgeadmin/allvendors'));
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
	}

	public function vend_addschemenow()
	{
	$this->form_validation->set_rules('Scheme_Name', 'scheme_Name', 'required|alpha|min_length[3]|max_length[25]');
	$this->form_validation->set_rules('vendor_ID', 'vendor_ID', 'numeric|xss_clrean|is_unique|xss_clean');
	$this->form_validation->set_rules('Min_Inv_Amount', 'min_Inv_Amount', 'required|numeric|xss_clean');
	$this->form_validation->set_rules('Max_Inv_Amount', 'max_Inv_Amount', 'required|mumeric|xss_clean');
	$this->form_validation->set_rules('Lockin', 'lockin', 'required');
	$this->form_validation->set_rules('Lockin_Period', 'lockin_Period', 'required|numeric|xss_clean');
	$this->form_validation->set_rules('Cooling_Period', 'cooling_Period', 'required|numeric|xss_clean');
	$this->form_validation->set_rules('Interest_Rate', 'interest_Rate', 'required|numeric|xss_clean');
	$this->form_validation->set_rules('Pre_Mat_Rate', 'Pre_Mat_Rate', 'required|numeric|xss_clean');
	$this->form_validation->set_rules('Withrawl_Anytime', 'withrawl_Anytime', 'required');
	$this->form_validation->set_rules('Auto_Redeem', 'auto_Redeem', 'required');
	$this->form_validation->set_rules('Interest_Type', 'interest_Type', 'required');
		
		if($this->form_validation->run() == TRUE) {
			$data = $this->Investmodel->insert_scheme();
			redirect(base_url('Surgeadmin/allschemes'));
		} {
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
	}
	public function reg_representative()
	{
		$this->load->model('Investmodel');
		
		$this->form_validation->set_rules('RepName', 'repName', 'required|alpha|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('vender', 'Vender', 'required|alpha|min_length[3]|max_length[25]');
		$this->form_validation->set_rules('RepDesignation', 'repDesignation', 'required');
		$this->form_validation->set_rules('Repphone', 'repphone', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('Repemail', 'repemail', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[password');
	


		if ($this->form_validation->run() == TRUE) {

			$data = $this->Investmodel->insert_repersentive();
            $this->session->set_flashdata('flashmsg', 'Repersentive registerd successfully');

			redirect(base_url('Surgeadmin/allrepersentative'));
		} {
			$this->add_representative();
		}
	}


	public function businessTeamlogin()
	{

		$this->load->view('templates/header');
		$this->load->view('buisnessteam/businessTeamlogin');
	}
	public function buisnesloginnow()
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');


				// $this->load->model('Investmodel');
				// $status = $this->Investmodel->checkPassword($password,$email);
				if (($email == "star@test.com") && ($password == "test")) {
					// $username = $status->fullname;
					// $email = $status->email; 
					// $UID = $status->UID;
					// $VID = $status->Vendor_ID;

					$session_data = array(
						'fullname' => "testing",
						'email' => $email
					);

					$this->session->set_userdata('Teamloginsession', $session_data);

					redirect(base_url('Surgeadmin/teamdashboard'));
				} else {
					$this->session->set_flashdata('error', 'Email or Password is Wrong');
					redirect(base_url('Surgeadmin/login'));
				}
			} else {
				$this->session->set_flashdata('error', 'Fill all the required fields');
				redirect(base_url('Surgeadmin/businessTeamlogin'));
			}
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
		// var_dump($this->input->post());
		// exit;

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

	public function allvendors()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->allvendors_get();
		$this->load->view('buisnessteam/allvendors', $data);
		$this->load->view('templates/footer');
	}

	public function allrepersentative()
	{

		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['row'] = $this->Investmodel->allrepersent_get();
		$this->load->view('buisnessteam/redeemtions', $data);
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

	public function editscheme2($id)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');


		$data['schemelist'] = $this->Investmodel->updatescheme2($id);


		$this->load->view('buisnessteam/editscheme', $data);
		$this->load->view('templates/footer');
	}
	public function updatescheme()
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');
		$data = array(
			'Scheme_Name' => $this->input->post('Scheme_Name'),
			'Min_Inv_Amount' => $this->input->post('Min_Inv_Amount'),
			'Max_Inv_Amount' => $this->input->post('Max_Inv_Amount'),
			'Aggregate_Amount' => $this->input->post('Aggregate_Amount'),
			'Lockin' => $this->input->post('Lockin'),
			'Lockin_Period' => $this->input->post('Lockin_Period'),
			'Cooling_Period' => $this->input->post('Cooling_Period'),
			'Interest_Rate' => $this->input->post('Interest_Rate'),
			'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
			'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
			'Auto_Redeem' => $this->input->post('Auto_Redeem'),
			'Interest_Type' => $this->input->post('Interest_Type'),

		);
		$result = $this->Investmodel->update_scheme($data);

		$this->load->view('buisnessteam/allschemes', $data);
		$this->load->view('templates/footer');
		if ($result) {
			$msg = "Update successfully";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allschemes/');
		} else {
			$msg = "Nothing to update";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allschemes/');
		}
	}

	public function editvendor1($VID)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');


		$data['adminlist'] = $this->Investmodel->edituser($VID);


		$this->load->view('buisnessteam/editvendor', $data);
		$this->load->view('templates/footer');
	}
	public function editscheme($id)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

		$data['schemelist'] = $this->Investmodel->updatescheme2($id);
		$this->load->view('buisnessteam/editscheme', $data);
		$this->load->view('templates/footer');
	}


	public function updatevendor1()
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

		$this->load->view('buisnessteam/allvendors', $data);
		$this->load->view('templates/footer');
		if ($result) {
			$msg = "Update successfully";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allvendors/');
		} else {
			$msg = "Nothing to update";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allvendors/' . $this->input->post('admin_id'));
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
			echo "deleted successfully";
			//$this->session->set_flashdata('success', 'Vender deleted successfully');
		} else {
			echo "something goes wrong";
			//$this->session->set_flashdata('error', 'Vender not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allvendors'));
	}

	public function deleterepersent($rid)
	{

		$this->cldb->where('rid', $rid);
		$row1 = $this->cldb->delete('invest_repessentative');
		if ($row1 == true) {
			$this->session->set_flashdata('success', 'Repersentative deleted successfully');
		} else {
			$this->session->set_flashdata('error', 'Repersantative not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allrepersentative'));
	}

	public function deletescheme($id)
	{


		$this->cldb->where('id', $id);
		$row1 = $this->cldb->delete('invest_scheme_details');
		if ($row1 == true) {
			$this->session->set_flashdata('success', 'Vender deleted successfully');
		} else {
			$this->session->set_flashdata('error', 'Vender not deleted successfully');
		}

		redirect(base_url('Surgeadmin/allschemes'));
	}


	public function editrepersent($rid)
	{
		$this->load->model('Investmodel');
		$this->load->view('templates/teamheader');

	//echo $rid; exit;
		$data['representlist'] = $this->Investmodel->editrepersents($rid);


		$this->load->view('buisnessteam/editreprsenative', $data);
		$this->load->view('templates/footer');
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
			'password' => $this->input->post('password'),

		);
		$result = $this->Investmodel->update_repersent($data);

		$this->load->view('buisnessteam/allrepersentative', $data);
		$this->load->view('templates/footer');
		if ($result) {
			$msg = "Update successfully";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allrepersentative/');
		} else {
			$msg = "Nothing to update";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'Surgeadmin/allrepersentative/');
		}
	}
}
