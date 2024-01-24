<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowwer extends CI_Controller {
	private $perPage = 20;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('');
	}

	public function index()
	{
		$borrower_id=14;
		$_SESSION['borrower_id']=$borrower_id;
		    // $data['proposal_list'] = $this->Biddingmodel->proposal_list($limit = 50, $start = 0, $lender_id = 41);
			$data['title'] = "Borrower List";
			$data['description'] = "Borrower List";
			$data['keywords'] = "Borrower List";

            $this->load->view('templates/header',$data);
			$this->load->view('templates/nav');
			$this->load->view('templates/collapse-nav');
			$this->load->view('loan_proposal', $data);
            $this->load->view('templates/footer');

	}

    public function proposal_submit(){
		$requestData = $this->input->post();
        $response=$this->add_loan_proposal($requestData);
  		echo json_encode($response); die();
    }


	public function add_loan_proposal($data){
	// return $data['borrower_id'];	

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/addLoanProposal',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		"borrower_id":"'.$data['borrower_id'].'",
		"p2p_product_id":"4",
		"loan_amount":"'.$data['loan_amount'].'",
		"tenor_months":"'.$data['loan_tenor'].'",
		"loan_description":"'.$data['loan_description'].'"
	
	}',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	// echo $response;
	$response=(array)json_decode($response);
return $response;

	}

	public function loan_agreement(){
		// echo "hdu";die();
		$response=$this->view_loan_agreement();
		$data['loan_agreement']=$response['msg'];
		// echo "<pre>";print_r($response);die();
		// $this->load->view('templates/header',$data);
		// 	$this->load->view('templates/nav');
		// 	$this->load->view('templates/collapse-nav');
			$this->load->view('loan_agreement', $data);
            // $this->load->view('templates/footer');

	}

	public function view_loan_agreement(){
		
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/viewLoanAgreement',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "bid_registration_id":"3"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=vseplhib3viuphvnqe1lkhcdbq885cut'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

$response=(array)json_decode($response);
return $response;

	}

	public function my_loan_statement(){
		
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/myloanStatement',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "loan_no": "LN10000000003"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

	}


	public function emi_payment(){
		
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/emiPayment',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
"emi_id": "231",
"bid_registration_id": "3"
   
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=7525va6694fhut3t0old51s165ehptnj'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

	}
}
