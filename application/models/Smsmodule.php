<?php 

class Smsmodule extends CI_Model{
	
    public function __construct(){
		
	    $this->load->database();
		$this->load->library('email');
	}

	public $username 	= 'shantanu@antworksmoney.com';
	public $hash_api 	= 'b3a4f30ed009f72aa58fcad1e58ddd49b8b7fd44f5a82bc2b93da9325174d68f';//'323c07417bfd9b57c114e379217072abe4c2c0c0753cc28d151cac689d956581';  //'2f6f843823f6b9f5352bb47355e264fd20369975';
	public $sender 		= 'ANTFIN';

	public function Approved_Bid_borrower($title, $name, $amount, $number)
	{
		$msg = "Hello ".$title." ".$name." Congrats! One of our Investor has funded you with Rs. ".$amount.". Please check back Antworks P2P dashboard and accept the Bid.%nANTWORKS P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Borrower_Details_Incompleteness($title,$name,$profile,$number)
	{
		$msg = "Hello ".$title." ".$name."%nYour profile is ".$profile." complete please make it 100%, few of our Investors are in search of profile like yours.%nANTWORKS P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Borrower_Details_completeness()
	{
		$title = "Mr.";
		$name = "Dinesh";
		$profile = "99";
		$number = "9910719994";
		$msg = "Hello ".$title." ".$name."%nCongrats! Your Profile is 100% complete now and would be visible to the Investors.%nANTWORKS P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Borrower_Sanctioned($title, $name, $loan_amount, $number)
	{
		$msg = "Hello ".$title.". ".$name."%nYour Loan of Rs. ".$loan_amount." is sanctioned, and is ready for disbursement, just a step of accept the Loan Agreement.%nANTWORKS P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Lender_Notification($title, $name, $number)
	{
		$msg = "Hello ".$title.". ".$name."%nVerified and good rated Borrowers are waiting for you to review their profile.%nANTWORKS P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Lender_Approved_Bid($title, $name, $loan_amount, $number, $interest_rate, $balance_amount)
	{
		$msg = "Hello ".$title.". ".$name."%nYou have successfully submitted your bid for an Amount of Rs. ".$loan_amount." at and yearly Interest Rate of ".$interest_rate.". %nYour balance capacity Rs. ".$balance_amount."";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Borrower_EMI_Detection()
	{
		$title = "Mr.";
		$name = "Dinesh";
		$loan_amount = "99";
		$number = "9910719994";
		$account_no = "7385";
		$month_of_date = "JAN-18";
		$msg = "Hello ".$title.". ".$name."%nThe Amount of Rs. ".$loan_amount.", is debited towards Repayment of your Loan Account Number ending with ".$account_no." for the Month of ".$month_of_date.".%nAntworks P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function EMI_Information_to_Borrower()
	{
		$title = "Mr.";
		$name = "Dinesh";
		$number = "9910719994";
		$due_date = "23-06-18";
		$emi_amount = "8000";
		$loan_account = "4543";
		$msg = "Hello ".$title.". ".$name."%nYour EMI will be due on ".$due_date.", with Amount Rs. ".$emi_amount." against Loan A/c Number ending with ".$loan_account.". Please maintain funds in your Account.";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Borrower_Disbursed_Confirmation()
	{
		$title = "Mr.";
		$name = "Dinesh";
		$account_no = "99";
		$number = "9910719994";
		$amount = "8000";
		$msg = "Hello ".$title.". ".$name."%nThe Loan Account Number ending with ".$account_no." of Rs. ".$amount." is been processed to your Bank A/c.%nFor query please write to info@antworksmoney.com";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function Lender_Escrow_AC_Confirmation($title, $name, $number)
	{

		$msg = "Hello ".$title.". ".$name."%nYour Escrow Account is created and Details had been emailed to your registered email id. %nPlease be aware of fishing emails.%nAntworks P2P";
		$message = rawurlencode($msg);

		// Prepare data for POST request
		$data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}


}