<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nach_controller extends CI_Controller{

    public function __construct()
    {
      
        parent::__construct();
        $this->load->model('nach_model');
  
    }

    public function create_customer() {
     
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get the raw POST data
            $encoded_post_data = file_get_contents('php://input');
    
            // Decrypt the POST data
            $decoded_post_data = decrypt_string($encoded_post_data);
    
            // Parse the decoded string into an array
            parse_str($decoded_post_data, $post_fields);

            // pr($encoded_post_data);
            $error = "Bad Request.";
            if(!isset($post_fields['name'])){
                http_response_code(400);
                echo json_encode(['status' => 0, 'messages' => $error]);
                exit;
            }
            $name = filter_var($post_fields['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($post_fields['email'], FILTER_SANITIZE_EMAIL);
            $contact = filter_var($post_fields['contact'], FILTER_SANITIZE_STRING);
            $notes_key_1 = filter_var($post_fields['notes_key_1'], FILTER_SANITIZE_STRING);
            $notes_key_2 = filter_var($post_fields['notes_key_2'], FILTER_SANITIZE_STRING);
            $borrower_id = filter_var($post_fields['borrower_id'], FILTER_SANITIZE_STRING);
            $expire_time = filter_var($post_fields['expire_time'], FILTER_SANITIZE_NUMBER_INT); // Corrected 
            $current_time = time();
    
            // Initialize validation errors array
            $errors = [];
            // echo $current_time;
            
            // Check if the request has expired
            if ($expire_time < $current_time) {
                $errors[] = "The request has expired.";
            }
    
            // Validate name
            if (empty($name) || strlen($name) > 255) {
                $errors[] = "Name is required and must not exceed 255 characters.";
            }
    
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
    
            // Validate contact
            if (strlen($contact) > 10) {
                $errors[] = "Contact must be a valid phone number.";
            }
    
            // Validate borrower_id
            if (empty($borrower_id)) {
                $errors[] = "Must enter borrower ID.";
            }
    
            // Check if there are any validation errors
            if (!empty($errors)) {
                echo json_encode(['status' => 0, 'messages' => $error]);
                exit;
            }
    
            // Prepare sanitized data for further processing
            $data = [
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'notes_key_1' => $notes_key_1,
                'notes_key_2' => $notes_key_2,
                'borrower_id' => $borrower_id
            ];
    
            // Call model function to create customer
            $customer_details = $this->nach_model->create_customer($data);
            $customer_details = json_encode($customer_details, true);
    
            // Output customer details
            // return $customer_details;
            print_r($customer_details);die();
            
        } else {
            echo "No data received";
        }
    }
    
    

    public function create_order() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            // Get the raw POST data
            $encoded_post_data = file_get_contents('php://input');
    
            // Decrypt the POST data
            $decoded_post_data = decrypt_string($encoded_post_data);
    
            // Parse the decoded string into an array
            parse_str($decoded_post_data, $post_fields);
            // pr($post_fields); die();
    
            // Define constants for validation
            $VALID_AUTH_TYPES = ['netbanking', 'debitcard', 'aadhaar'];
            $VALID_ACCOUNT_TYPES = ['savings', 'current'];
            $MAX_BENEFICIARY_NAME_LENGTH = 255;
            $MAX_ACCOUNT_NUMBER_LENGTH = 20;
            $MAX_IFSC_CODE_LENGTH = 11;
    
            // Sanitize input
            $borrower_id = filter_var($post_fields['borrower_id'], FILTER_SANITIZE_STRING);
            $notes_key_1 = filter_var($post_fields['notes_key_1'], FILTER_SANITIZE_STRING);
            $notes_key_2 = filter_var($post_fields['notes_key_2'], FILTER_SANITIZE_STRING);
            $auth_type = filter_var($post_fields['auth_type'], FILTER_SANITIZE_STRING);
            $token_notes_key_1 = filter_var($post_fields['token_notes_key_1'], FILTER_SANITIZE_STRING);
            $token_notes_key_2 = filter_var($post_fields['token_notes_key_2'], FILTER_SANITIZE_STRING);
            $beneficiary_name = filter_var($post_fields['beneficiary_name'], FILTER_SANITIZE_STRING);
            $account_number = filter_var($post_fields['account_number'], FILTER_SANITIZE_STRING);
            $ifsc_code = filter_var($post_fields['ifsc_code'], FILTER_SANITIZE_STRING);
            $account_type = filter_var($post_fields['account_type'], FILTER_SANITIZE_STRING);
    
            // Initialize validation errors array
            $errors = [];
    
            // Validate borrower_id
            if (empty($borrower_id)) {
                $errors[] = "Must enter borrower ID.";
            }
    
            // Validate auth_type
            if (!in_array($auth_type, $VALID_AUTH_TYPES)) {
                $errors[] = "Invalid authorization type.";
            }
    
            // Validate account_type
            if (!in_array($account_type, $VALID_ACCOUNT_TYPES)) {
                $errors[] = "Invalid account type.";
            }
    
            // Validate beneficiary_name
            if (empty($beneficiary_name) || strlen($beneficiary_name) > $MAX_BENEFICIARY_NAME_LENGTH) {
                $errors[] = "Beneficiary name is required and must not exceed $MAX_BENEFICIARY_NAME_LENGTH characters.";
            }
    
            // Validate account_number
            if (empty($account_number) || strlen($account_number) > $MAX_ACCOUNT_NUMBER_LENGTH) {
                $errors[] = "Account number is required and must not exceed $MAX_ACCOUNT_NUMBER_LENGTH characters.";
            }
    
            // Validate ifsc_code
            if (empty($ifsc_code) || strlen($ifsc_code) > $MAX_IFSC_CODE_LENGTH) {
                $errors[] = "IFSC code is required and must not exceed $MAX_IFSC_CODE_LENGTH characters.";
            }
    
            // Check if there are any validation errors
            if (!empty($errors)) {
                echo json_encode(['status' => 0, 'messages' => $errors]);
                exit;
            }
    
            // Call model function to get customer id
            $customerId = $this->nach_model->getCustomerId($borrower_id);
    
            $receipt_no = $this->nach_model->getReceiptNo('master_nach_customer_order');
    
            // Prepare sanitized data for further processing
            $data = [
                'customer_id' => $customerId,
                'receipt_no' => $receipt_no,
                'borrower_id' => $borrower_id,
                'notes_key_1' => $notes_key_1,
                'notes_key_2' => $notes_key_2,
                'auth_type' => $auth_type,
                'token_notes_key_1' => $token_notes_key_1,
                'token_notes_key_2' => $token_notes_key_2,
                'max_amount' => NACH_AMOUNT, 
                'expire_at' => NACH_EXPIRE_AT, 
                'beneficiary_name' => $beneficiary_name,
                'account_number' => $account_number,
                'ifsc_code' => $ifsc_code,
                'account_type' => $account_type
            ];
            // pr($data);die();
            // Create order
            $order_details = $this->nach_model->create_order($data);
            $order_details['customer_id'] = $customerId;
            $order_details = json_encode($order_details, true);
    
            // Output order details
            print_r($order_details);
            die();
            // return $order_details;
        } else {
            echo "No data received";
        }
    }
    
// public function payment_page(){
//   $borrower_id = 1;
//   $data['payment_details'] = $this->nach_model->payment_details_via_borrower_id($borrower_id);

//   $this->load->view('index',$data);

// }

public function paymentIdCallback(){

  $data = file_get_contents('php://input');
  parse_str($data, $parsedData);
  // echo "<pre>";print_r($parsedData);die();
  $response = $this->nach_model->fetch_token_by_payment_id($parsedData);
  $response = json_encode($response,true);
  
  return $response;

}


public function fetch_token_by_payment_id() {

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $encoded_post_data = file_get_contents('php://input');
      $decoded_post_data = decrypt_string($encoded_post_data);
      parse_str($decoded_post_data, $post_fields);


      // Sanitize and validate input
      $payment_id = filter_input($post_fields['razorpay_payment_id'], FILTER_SANITIZE_STRING);
      // echo $payment_id; die();
      // Basic validation to ensure payment_id is not empty
      if (empty($payment_id)) {
          echo "Invalid payment ID";
          exit;
      }

      // Prepare sanitized data
      $data = [
          'razorpay_payment_id' => $payment_id
      ];
      
      $token_details = $this->nach_model->fetch_token_by_payment_id($data);
      
      if($token_details['status'] == 1){
      window.link ('http://localhost/check');
    }else{
    //   return $token_details;
    print_r($token_details);die();
    }
  } else {
      echo "No data received";
  }
  
}



public function create_order_to_charge_customer() {

    $encoded_post_data = file_get_contents('php://input');
            $decoded_post_data = decrypt_string($encoded_post_data);
            parse_str($decoded_post_data, $post_fields);


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sanitize and validate input
      $amount = filter_input($post_fields['amount'], FILTER_SANITIZE_STRING);
      $receipt = filter_input($post_fields['receipt'], FILTER_SANITIZE_STRING);
      $notes_key_1 = filter_input($post_fields['notes_key_1'], FILTER_SANITIZE_STRING);
      $notes_key_2 = filter_input($post_fields['notes_key_2'], FILTER_SANITIZE_STRING);

      // Validate amount to ensure it is a valid positive number
      if (!is_numeric($amount) || empty($receipt) || empty($notes_key_1) || empty($notes_key_2)) {
          echo "Invalid input data";
          exit;
      }

      // Prepare sanitized data
      $data = [
          'amount' => $amount,
          'receipt' => $receipt,
          'notes_key_1' => $notes_key_1,
          'notes_key_2' => $notes_key_2
      ];

      $order_details = $this->nach_model->create_order_to_charge_customer($data);
    //   return $order_details;
    print_r($order_details);die();
  } else {
      echo "No data received";
  }
}


public function create_recurring_payment() {

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $encoded_post_data = file_get_contents('php://input');
    $decoded_post_data = decrypt_string($encoded_post_data);
    parse_str($decoded_post_data, $post_fields);

      // Sanitize and validate input 
      $email = filter_input($post_fields['email'], FILTER_SANITIZE_EMAIL);
      $contact = filter_input($post_fields['contact'], FILTER_SANITIZE_STRING);
      $amount = filter_input($post_fields['amount'], FILTER_SANITIZE_STRING);
      $order_id = filter_input($post_fields['order_id'], FILTER_SANITIZE_STRING);
      $customer_id = filter_input($post_fields['customer_id'], FILTER_SANITIZE_STRING);
      $token = filter_input($post_fields['token'], FILTER_SANITIZE_STRING);
      $description = filter_input($post_fields['description'], FILTER_SANITIZE_STRING);
      $notes_key_1 = filter_input($post_fields['notes_key_1'], FILTER_SANITIZE_STRING);
      $notes_key_2 = filter_input($post_fields['notes_key_2'], FILTER_SANITIZE_STRING);

      // Validate and ensure all required fields are provided
      if (!filter_var($email, FILTER_VALIDATE_EMAIL) || 
          !is_numeric($amount) || 
          empty($contact) || 
          empty($order_id) || 
          empty($customer_id) || 
          empty($token) || 
          empty($description)) { 
          echo "Invalid input data";
          exit;
      }

      // Prepare sanitized and validated data
      $data = [
          'email' => $email,
          'contact' => $contact,
          'amount' => $amount,
          'order_id' => $order_id,
          'customer_id' => $customer_id,
          'token' => $token,
          'description' => $description,
          'notes_key_1' => $notes_key_1,
          'notes_key_2' => $notes_key_2
      ];

      $order_details = $this->nach_model->create_recurring_payment($data);
    //   return $order_details;
    print_r($order_details);die();
  } else {
      echo "No data received";
  } 
}


}

?>