<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('login');
	}

	function try()
	{
	
		$this->load->view('test');
	}

	public function aphit($data)
	{
		$apiEndpoint = "https://www.antworksp2p.com/invest/index.php/invest/".$data['ap'];
		//$apiEndpoint = "http://localhost/invest/invest/".$data['ap'];
		unset($data['ap']);
		$jsonData = json_encode($data);
		// var_dump($data);
		// exit;

// Initialize a curl session
$curl = curl_init();

// Set the curl options
curl_setopt($curl, CURLOPT_URL, $apiEndpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/x-www-form-urlencoded', // Set the content type as per your API documentation
'Authorization: Basic ' . base64_encode('antApp_2021:Ant_Secure&@165'), // Replace 'username' and 'password' with your own Basic auth credentials
'X-API-KEY: startest' // Replace 'your_api_key' with your own API key
));

// Execute the curl session and get the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
$error = curl_error($curl);
echo "Curl error: $error";
}

// Close the curl session
curl_close($curl);
return $response;

	}

	function registerNow()
	{

		if($_SERVER['REQUEST_METHOD']=='POST')

		{
		
		//$this->input->post();
			// $this->form_validation->set_rules('fullname','User Name','required');
			// $this->form_validation->set_rules('email','Email','required');
			 $this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{
		// 		$try1 = $this->input->post();
		// var_dump($try1);
		// exit;

				$username = $this->input->post('fullname');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$Account_No = $this->input->post('Account_No');
				$DOB = $this->input->post('DOB');
				$PAN = $this->input->post('PAN');
				$phone = $this->input->post('phone');
				

				$data = array(
					'fullname'=>$username,
					'email'=>$email,
					'password'=>md5($password),
					'Account_No'=>($Account_No),
					'DOB'=>($DOB),
					'PAN'=>($PAN),
					'phone'=>($phone),
					'status'=>'1'
				);
			
				$jsonData = json_encode($data);

				$apiEndpoint = 'http://localhost/invest/invest/invest/user_reg';

// Initialize a curl session
$curl = curl_init();

// Set the curl options
curl_setopt($curl, CURLOPT_URL, $apiEndpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded', // Set the content type as per your API documentation
    'Authorization: Basic ' . base64_encode('starraxop:ykxgffrfi4rfboecobsey8u34r9i1guhudpgggxwbblzt0j8h97qk3vo'), // Replace 'username' and 'password' with your own Basic auth credentials
    'X-API-KEY: startest' // Replace 'your_api_key' with your own API key
));

// Execute the curl session and get the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    $error = curl_error($curl);
    echo "Curl error: $error";
}

// Close the curl session
curl_close($curl);

				// $this->load->model('user_model');
				// $this->user_model->insertuser($data);
				$this->session->set_flashdata('success','Congratulations Successfully Registered');
				redirect('welcome/index');
			}
		}
	}

	function login()
	{
		$this->load->view('templates/header');
		$this->load->view('login');
	}

	function loginnow()
	{
		// var_dump($this->input->post('value'));
		// exit;

		if(($this->input->post('value')== "team"))
		{
			if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
			
			
				// $this->load->model('user_model');
				// $status = $this->user_model->checkPassword($password,$email);
				if(($email== "star@test.com")&& ($password=="test"))
				{
					// $username = $status->fullname;
					// $email = $status->email; 
					// $UID = $status->UID;
					// $VID = $status->Vendor_ID;

					$session_data = array(
						'fullname'=> "testing",
						'email' => $email
					);

					$this->session->set_userdata('Teamloginsession',$session_data);

					redirect(base_url('welcome/teamdashboard'));
				}
				else
				{
					$this->session->set_flashdata('error','Email or Password is Wrong');
					redirect(base_url('welcome/login'));
				}

			}
			else
			{
				$this->session->set_flashdata('error','Fill all the required fields');
				redirect(base_url('welcome/businessTeamlogin'));
			}
		}

	
		}
	


		if(($this->input->post('value')== "partner"))
		{
			redirect(base_url('welcome/Partnerloginnow'));
		}

		else 
		{

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{
				$email = $this->input->post('email');
				$password = md5(md5($this->input->post('password')));
			
			
				$this->load->model('user_model');
				$status = $this->user_model->checkPassword($password,$email);
				if($status!=false)
				{
					$username = $status->fullname;
					$email = $status->email; 
					$UID = $status->UID;
					$VID = $status->Vendor_ID;

					$session_data = array(
						'fullname'=>$username,
						'email' => $email,
						'uid'=>$UID,
						'vid'=>$VID
					);

					$this->session->set_userdata('UserLoginSession',$session_data);

					redirect(base_url('welcome/dashboard'));
				}
				else
				{
					$this->session->set_flashdata('error','Email or Password is Wrong');
					redirect(base_url('welcome/login'));
				}

			}
			else
			{
				$this->session->set_flashdata('error','Fill all the required fields');
				redirect(base_url('welcome/login'));
			}
		}
	}
	}

	function dashboard()
	{
		$this->load->view('templates/dbheader');
		$this->load->view('dashboard');
	}
	function Invest_Schemes()
	{
		$res['Vendor_ID'] = $this->input->get('vid');
		$res += array('ap' => "all_schemes");
		$res1['data']=json_decode($this->aphit($res),TRUE);
		
		$this->load->view('templates/dbheader');
		$this->load->view('users/Invest_Schemes',$res1);
	}
	function Investments()
	{
		$this->load->view('templates/dbheader');
		$res['ap'] = "lender_detailshow";
		$res['Vendor_ID'] = $this->input->get('VID');
		$res['User_ID'] = $this->input->get('UID');
	
		$res1['data']=json_decode($this->aphit($res),TRUE);
		// var_dump($res1);
		
		$this->load->view('users/Investments',$res1);
	}
	function investinit1()
	{
		
		
        $SID = $_GET['SID'];
		$session_data = array(
			'SID'=>$SID);
		$this->session->set_userdata('scheme',$session_data);
		$this->load->view('templates/dbheader');
		$this->load->view('users/investinit1');
	}
	function investinit2()
	{
		// $res['Vendor_ID'] = $this->input->get('vid');
		// $res['ap'] = "";
		// $res1['data']=json_decode($this->aphit($res),TRUE);

			$this->load->view('templates/dbheader');
			$this->load->view('users/investinit2');

	
}
	
	function investinit3()
	{
		// $res['Investment_type'] = $this->input->post('Investment_type');
		// $res['Investment_Amt'] = $this->input->post('Investment_Amt');
		// $res['Investment_Amt'] = $this->input->post('Investment_Amt');
		// $this->form_validation->set_rules('Investment_Amt','required');
		// $this->form_validation->set_rules('termscon','required');

		// if($this->form_validation->run()==TRUE)
		// {
			$res =  $this->input->post();
			$res += array('status' => "1");
			$res+= array('ap' => "reguser_scheme");
			unset($res['termscon']);
			// var_dump($res);
			// exit;
			$res1['data']=json_decode($this->aphit($res),TRUE);
		$this->load->view('templates/dbheader');
		$this->load->view('users/investinit3');
		// }
		
	}

	
	function register_partner()
	{
		
		$this->load->view('templates/teamheader');
		
		$this->load->view('partners/register_partner');
		
		$this->load->view('templates/footer');
	
	}

	public function vendor_regnow()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('Company_Name','Company_Name','required');
    $this->form_validation->set_rules('Address','Address','required');
    $this->form_validation->set_rules('email','email','required'); 
	$this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
    // $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');

    if ($this->form_validation->run() == TRUE)
     {
       
		$res = $this->input->post();
		$res += array('ap' => "vend_reg");
		$res1['data']=json_decode($this->aphit($res),TRUE);
		$this->session->set_flashdata('success','Vendor Successfully Registered');
		redirect('welcome/register_partner');
      }
      else {
        $errmsg = array("error_msg" => validation_errors());
        $errmsg['status'] = 0;
        $this->set_response($errmsg, RestController::HTTP_OK);
        return;
              } 

	}

	public function vend_addscheme()
	{
		$res= array('ap' => "allvendors");
		
		$res1['data']=json_decode($this->aphit($res),TRUE);

		$this->load->view('templates/teamheader');
		
		$this->load->view('partners/vend_addcheme',$res1);
		
		$this->load->view('templates/footer');
	
	}

	public function vend_addschemenow()
	{
		$res = $this->input->post();
		$res += array('ap' => "Scheme_add");
	   $res1['data']=json_decode($this->aphit($res),TRUE);
	   $this->session->set_flashdata('success','Scheme Successfully Added');
	   redirect('welcome/vend_addscheme');

	// 	$_POST = json_decode(file_get_contents('php://input'), true);
    // $this->form_validation->set_rules('Scheme_Name','Scheme_Name','required');
    // // $this->form_validation->set_rules('Vendor_ID','Vendor_ID','required');
    // $this->form_validation->set_rules('Min_Inv_Amount','Min_Inv_Amount','required');
    // $this->form_validation->set_rules('Max_Inv_Amount','Max_Inv_Amount','required');
    // $this->form_validation->set_rules('Aggregate_Amount','Aggregate_Amount','required');
    // // $this->form_validation->set_rules('Lockin','Lockin','required');
    // // $this->form_validation->set_rules('Lockin_Period','Lockin_Period','required');
    // // $this->form_validation->set_rules('Cooling_Period','Cooling_Period','required');
    // $this->form_validation->set_rules('Interest_Rate','Interest_Rate','required');
    // $this->form_validation->set_rules('Pre_Mat_Rate','Pre_Mat_Rate','required');
	
    // if ($this->form_validation->run() == TRUE)
    //  {
      
    //   }
    //   else {
    //     $errmsg = array("error_msg" => validation_errors());
    //     $errmsg['status'] = 0;
	// 	$this->session->set_flashdata('error',"$errmsg");
	//    redirect('welcome/vend_addscheme');
    //           } 

	
	}

 public function add_representative()
	{
		$res= array('ap' => "allvendors");
		
		$res1['data']=json_decode($this->aphit($res),TRUE);
		
		$this->load->view('templates/teamheader');
		
		$this->load->view('partners/add_representative',$res1);
		
		$this->load->view('templates/footer');

	}

	public function add_representativenow()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('RepName','RepName','required');
    // $this->form_validation->set_rules('Vendor_ID','Vendor_ID','required');
    $this->form_validation->set_rules('RepDesignation','RepDesignation','required'); 
	$this->form_validation->set_rules('Repphone','Repphone','required|regex_match[/^[0-9]{10}$/]');
	$this->form_validation->set_rules('Repemail','Repemail','required');
    // $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
	
    if ($this->form_validation->run() == TRUE)
     {
       
		$res = $this->input->post();
		$res += array('ap' => "vend_reg");
	   $res1['data']=json_decode($this->aphit($res),TRUE);
	   $this->session->set_flashdata('success','Representatives Successfully Registered');
	   redirect('welcome/add_representative');

      }
      else {
        $errmsg = array("error_msg" => validation_errors());
        $errmsg['status'] = 0;
		$this->session->set_flashdata('success','Representatives Successfully Registered');
		redirect('welcome/add_representative');
        
              } 

	}
		

	public function redeem1()
	{
		$res = $this->input->get();
		$res += array('ap' => "update_valuestts");
		$res += array('updcd' => "1");
		$res1['data']=json_decode($this->aphit($res),TRUE);
		// var_dump($res);
		// exit;

		$this->load->view('templates/dbheader');
	    $message['Main']= "Redeemption Requested";
		$message['sub']= "Your Request sent to our Buisness Team. We will revert back once documentation completed";
		$this->load->view('users/redeemrqst',$message);

	}

public function businessTeamlogin ()
{
 
	$this->load->view('templates/header');
	$this->load->view('buisnessteam/businessTeamlogin');	

}

public function buisnesloginnow ()
{

	if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
			
			
				// $this->load->model('user_model');
				// $status = $this->user_model->checkPassword($password,$email);
				if(($email== "star@test.com")&& ($password=="test"))
				{
					// $username = $status->fullname;
					// $email = $status->email; 
					// $UID = $status->UID;
					// $VID = $status->Vendor_ID;

					$session_data = array(
						'fullname'=> "testing",
						'email' => $email
					);

					$this->session->set_userdata('Teamloginsession',$session_data);

					redirect(base_url('welcome/teamdashboard'));
				}
				else
				{
					$this->session->set_flashdata('error','Email or Password is Wrong');
					redirect(base_url('welcome/login'));
				}

			}
			else
			{
				$this->session->set_flashdata('error','Fill all the required fields');
				redirect(base_url('welcome/businessTeamlogin'));
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

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('email','Email','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()==TRUE)
			{

				$email = $this->input->post('email');
				$password = $this->input->post('password');
			
				 $this->load->model('user_model');
				 $status = $this->user_model->checkvenrep($password,$email);
                 
				 if($status!=false)
				{
					$username = $status->RepName;
					$email = $status->Repemail; 
					$RID = $status->RID;
					$VID = $status->Vendor_ID;

					$session_data = array(
						'fullname'=> $username,
						'email' => $email,
						'RID' => $RID,
						'VID' => $VID
					);

					$this->session->set_userdata('venloginsession',$session_data);

					redirect(base_url('welcome/vendordashboard'));
				}
				else
				{
					$this->session->set_flashdata('error','Email or Password is Wrong');
					redirect(base_url('welcome/vendor_login'));
				}

			}
			else
			{
				$this->session->set_flashdata('error','Fill all the required fields');
				redirect(base_url('welcome/vendor_login'));
			}
		}


		
	
	}

	public function vendordashboard()
	{

		$this->load->view('templates/venheader');
		$this->load->view('partners/vendordashboard');

	}

	public function Invest_Schemesven()
	{

		$this->load->view('templates/venheader');
		
		$res['Vendor_ID'] = $this->input->get('VID');
		$res += array('ap' => "all_schemes");
		// var_dump($res);
		// exit;
		$res1['data']=json_decode($this->aphit($res),TRUE);

		$this->load->view('partners/Invest_Schemes',$res1);
		// var_dump($res1);
		// exit;
	}


	function Investmentsven()
	{
		$this->load->view('templates/venheader');
		$res['ap'] = "vendor_detailshow";
		$res['Vendor_ID'] = $this->input->get('VID');
		
		// var_dump($res);
		// exit;
		
		$res1['data']=json_decode($this->aphit($res),TRUE);
		// var_dump($res1);
		// exit;
		$this->load->view('partners/allinvestments',$res1);
	}

	public function allvendors()
	{
		$this->load->view('templates/teamheader');
		$res['ap'] = "all_vendor";
		$res1['data']=json_decode($this->aphit($res),TRUE);
		$this->load->view('buisnessteam/allvendors',$res1);
		$this->load->view('templates/footer');
	}

	public function allschemes()
	{
      	$this->load->view('templates/teamheader');
	
			$res['ap'] = "all_scheme";
			$res1['data']=json_decode($this->aphit($res),TRUE);
			
			$this->load->view('buisnessteam/allschemes',$res1);
			$this->load->view('templates/footer');
	}


	public function editscheme1()
	{
		$this->load->view('templates/teamheader');
		if (!empty($this->input->get())) {
		$res = $this->input->get();}
		else 
		{
			$res = $this->session->userdata('SID');
			$this->session->unset_userdata('SID');
			$res = array ("SID"=> "$res");
		}

		$res +=array( 'ap'=> "all_scheme" );
		// var_dump($res);
		// exit;
	
			$res1['data']=json_decode($this->aphit($res),TRUE);
			$res1 += array('SID'=>$this->input->get());
			$this->load->view('buisnessteam/editscheme',$res1);
			$this->load->view('templates/footer');

	}

	public function editscheme2()
	{
		// var_dump($this->input->get());
		$res =$this->input->post();
		// exit;
		$this->load->view('templates/teamheader');
			$res +=array( 'ap'=> "update_values" );
		    $res +=array( 'updcode'=> "3" );
			$res1['data']=json_decode($this->aphit($res),TRUE);
			
			// echo "<pre>";
			// print_r($res1);
			// exit;
			if($res1['data']['SID'] > 0 )
			{
  
				$this->session->set_userdata($res1['data']);
				$this->load->view('buisnessteam/editvendor',$res1);
				$this->session->set_flashdata('success','Scheme Details are updated');
		     	redirect(base_url('welcome/editscheme1'));
			}
	}
	public function editvendor1()
	{

		$this->load->view('templates/teamheader');
		if (!empty($this->input->get())) {
		$res = $this->input->get();}
		else 
		{
			$res = $this->session->userdata('VID');
			$this->session->unset_userdata('VID');
			$res = array ("VID"=> "$res");
		}
		
			$res +=array( 'ap'=> "all_vendor" );
		
			$res1['data']=json_decode($this->aphit($res),TRUE);
			$res1 += array('VID'=>$this->input->get());
			$this->load->view('buisnessteam/editvendor',$res1);
			$this->load->view('templates/footer');
			
	
	}
	public function editvendor2()
	{	
		$res =$this->input->post();
		// exit;
		$this->load->view('templates/teamheader');
			$res +=array( 'ap'=> "update_values" );
		    $res +=array( 'updcode'=> "1" );
			// echo "<pre>";
			// print_r($res);
			// exit;
			$res1['data']=json_decode($this->aphit($res),TRUE);
			// echo "<pre>";
			// print_r($res1);
			// exit;
			if($res1['data'] > 0 )
			{  
				$this->session->set_userdata($res1['data']);
				//$all = $this->session->userdata('RID');
				// $this->load->view('buisnessteam/editvendor',$res1);
				$this->session->set_flashdata('success','Vendors Details are updated');
			redirect(base_url('welcome/editvendor1'));

	}
}

public function editvendor3()
{
	$this->load->view('templates/teamheader');
		  $res = $this->input->get();
		$res +=array( 'ap'=> "all_vendor" );
	
		$res1['data']=json_decode($this->aphit($res),TRUE);
		$res1 += array('VID'=>$this->input->get());
		echo "<pre>";
		print_r($res1);
		exit;
		$this->load->view('buisnessteam/editvendor',$res1);

}

public function editrep1()
{
			$this->load->view('templates/teamheader');
			
			$res = $this->input->get();
			$res +=array( 'ap'=> "all_rep" );
		
		
			$res1['data']=json_decode($this->aphit($res),TRUE);
			$res1 += array('RID'=>$this->input->get());

			$this->load->view('buisnessteam/allrepresentative',$res1);
			$this->load->view('templates/footer');

}

public function editrep2()
{

		$this->load->view('templates/teamheader');
		if (!empty($this->input->get())) {
		$res = $this->input->get();}
		else 
		{
			$res = $this->session->userdata('RID');
			$this->session->unset_userdata('RID');
			$res = array ("RID"=> "$res");
		}
		
		$res +=array( 'ap'=> "all_rep" );
		// 	var_dump($res);
		// exit;

		$res1['data']=json_decode($this->aphit($res),TRUE);

		// /$res1 += array($this->input->get()); 
		// var_dump($res1);
		// exit;
	   $this->load->view('buisnessteam/editreprsenative',$res1);


			// if (!empty($this->input->post())) {}

			}


public function editrep3()
	{	
		$res =$this->input->post();
				// exit;
				$this->load->view('templates/teamheader');
					$res +=array( 'ap'=> "update_values" );
					$res +=array( 'updcode'=> "2" );
					// echo "<pre>";
					// print_r($res);
					// exit;
					$res1['data']=json_decode($this->aphit($res),TRUE);
					// echo "<pre>";
					// print_r($res1);
					// exit;
			
					if($res1['data'] > 0 )
					{
						$this->session->set_userdata($res1['data']);
						//$all = $this->session->userdata('RID');
// var_dump($all);
// exit;
							// $this->load->view('buisnessteam/editreprsenative',$res1);
						$this->session->set_flashdata('success','Representative Details are updated');
					redirect(base_url('welcome/editrep2'));
		
}
	}

	public function editrep4()
{

			$this->load->view('templates/teamheader');
			if (!empty($this->input->get())) {
			$res = $this->input->get();}
			else 
			{
				$res = $this->session->userdata('RID');
				$this->session->unset_userdata('RID');
				$res = array ("RID"=> "$res");
			}
			
			$res +=array( 'ap'=> "all_rep" );
			// 	var_dump($res);
			// exit;

			$res1['data']=json_decode($this->aphit($res),TRUE);

			// /$res1 += array($this->input->get()); 
			// var_dump($res1);
			// exit;
		   $this->load->view('buisnessteam/editreprsenative',$res1);

			// if (!empty($this->input->post())) {}
			}
			public function testbase()
			{
				$this->load->view('templates/testingheader');
				$this->load->view('buisnessteam/testing');
			}
			public function payutest()
			{
				$this->load->view('buisnessteam/payutest');
			}


			public function sucess1()
			{
				echo "Success";
			}

			public function failure()
			{
                echo "Failed";
			}

			public function delete()
			{
				if (!empty($this->input->get())) {
				$res = $this->input->get();}
				else 
				{
					$res = $this->session->userdata('RID');
					$this->session->unset_userdata('RID');
					$res = array ("RID"=> "$res");
				}
				
				$res +=array( 'ap'=> "del_values" );
	
				$res1['data']=json_decode($this->aphit($res),TRUE);
			   $this->load->view('buisnessteam/editreprsenative',$res1);
			}

public function redemptionsrqsts()
{
	$res = array('ap' => "redemptions");
	$res1['data']=json_decode($this->aphit($res),TRUE);
	$this->load->view('templates/teamheader');
    $this->load->view('buisnessteam/redeemtions',$res1);
	$this->load->view('templates/footer');
}

public function redemptionsrqsts1()
{
	$res = $this->input->get();
	$res += array('ap' => "update_valuestts");
	$res += array('updcd' => "2");
	$res1['data']=json_decode($this->aphit($res),TRUE);
	$this->session->set_flashdata('redeemfinal','Redemption Request is finalised!');
	redirect(base_url('welcome/redemptionsrqsts'));
}
public	function logout()
	{
		session_destroy();
		redirect(base_url('welcome/login'));
	}


	public function validation_Teamplate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('Company_Name','Company_Name','required');
    $this->form_validation->set_rules('Address','Address','required');
    $this->form_validation->set_rules('email','email','required'); 
	$this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
    // $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');

    if ($this->form_validation->run() == TRUE)
     {
       
		//content
      }
      else {
        $errmsg = array("error_msg" => validation_errors());
        $errmsg['status'] = 0;
        $this->set_response($errmsg, RestController::HTTP_OK);
        return;
              } 

	}

}
