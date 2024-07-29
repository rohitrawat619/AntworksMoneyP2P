<?php 
class nach_model extends CI_Model{

public function __construct(){
    $this->apiBaseUrl= "https://antworksp2p.com/credit-line/"; //"https://antworksmoney.com/credit-line/p2papiborrower/";
    $this->content_type="application/json";
    $this->authorization="Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v";
    $this->load->database();
}

public function create_customer($data) {

  // Sanitize input data
  $sanitized_data = [
      'name' => htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'),
      'email' => htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8'),
      'contact' => htmlspecialchars($data['contact'], ENT_QUOTES, 'UTF-8'),
      'notes_key_1' => htmlspecialchars($data['notes_key_1'], ENT_QUOTES, 'UTF-8'),
      'notes_key_2' => htmlspecialchars($data['notes_key_2'], ENT_QUOTES, 'UTF-8'),
      'borrower_id' => htmlspecialchars($data['borrower_id'], ENT_QUOTES, 'UTF-8')
  ];

  // Check if a customer with the same email already exists
  $this->db->where('email', $sanitized_data['email']);
  $query = $this->db->get('master_nach_customer');

  if ($query->num_rows() > 0) {
      // Customer with this email already exists
      $existing_customer = $query->row_array();  // Get the existing customer's details
      $response = [
          'status' => 1,
          'type' => 'db',
          'borrower_id' => $sanitized_data['borrower_id'],
          'cust_id' => $existing_customer['cust_id'],
          'msg' => 'Customer with this email already exists'
      ];
  } else {
      // Check if a customer with the same contact already exists
      $this->db->where('contact', $sanitized_data['contact']);
      $query = $this->db->get('master_nach_customer');

      if ($query->num_rows() > 0) {
          // Customer with this contact already exists
          $existing_customer = $query->row_array();  // Get the existing customer's details
          $response = [
              'status' => 1,
              'type' => 'db',
              'borrower_id' => $sanitized_data['borrower_id'],
              'cust_id' => $existing_customer['cust_id'],
              'msg' => 'Customer with this contact number already exists'
          ];
      } else {
          // Insert customer data into the database
          $this->db->insert('master_nach_customer', $sanitized_data);
          $insert_id = $this->db->insert_id();

          // Call the API to create the customer and get the response
          $api_response = $this->create_customer_api($sanitized_data);

          // Check if the API response contains an ID
          if (isset($api_response['id'])) {
              // Update the database with the customer ID returned by the API
              $this->db->where('id', $insert_id);
              $this->db->update('master_nach_customer', ['cust_id' => $api_response['id']]);

              // Check if the database update was successful
              if ($this->db->affected_rows() > 0) {
                  $response = [
                      'status' => 1,
                      'type' => 'live',
                      'borrower_id' => $sanitized_data['borrower_id'],
                      'cust_id' => $api_response['id'],
                      'msg' => 'Data inserted and customer ID updated'
                  ];
              } else {
                  $response = [
                      'status' => 0,
                      'borrower_id' => $sanitized_data['borrower_id'],
                      'msg' => 'Data inserted but failed to update customer ID'
                  ];
              }
          } else {
              $response = [
                  'status' => 0,
                  'borrower_id' => $sanitized_data['borrower_id'],
                  'msg' => 'Data inserted but API call failed'
              ];
          }
      }
  }

  return $response;
}



public function create_customer_api($data) {
  $curl = curl_init();

  $postFields = json_encode([
      "name" => $data['name'],
      "email" => $data['email'],
      "contact" => $data['contact'],
      "fail_existing" => "0", // 0: Retrieve details of the existing customer. 1 (default): Throws an exception error.
      "notes" => [
          "note_key_1" => $data['notes_key_1'],
          "note_key_2" => $data['notes_key_2']
      ]
  ]);

  curl_setopt_array($curl, [
      CURLOPT_URL => 'https://api.razorpay.com/v1/customers',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postFields,
      CURLOPT_HTTPHEADER => [
          'Content-Type: application/json',
          'Authorization: ' . $this->authorization
      ],
  ]);

  $response = curl_exec($curl);

  if (curl_errno($curl)) {
      // Handle curl error
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['error' => $error_msg];
  }

  curl_close($curl);

  $responseArray = json_decode($response, true);

  // Return the decoded response
  return $responseArray;
}


public function getCustomerId($borrower_id) {
  // Sanitize input data
  $sanitized_data = ['borrower_id' => htmlspecialchars($borrower_id, ENT_QUOTES, 'UTF-8')];
  // $customer_id = htmlspecialchars($data['customer_id'], ENT_QUOTES, 'UTF-8');

  // Query the database
  $this->db->where('borrower_id', $sanitized_data['borrower_id']);
  $query = $this->db->get('master_nach_customer');

  // Check if the query returned any results
  if ($query->num_rows() > 0) {
      // Fetch the result as an associative array
      $result = $query->row_array();

      // Return the result
      return $result['cust_id'];
  } else {
      // Handle case where no customer is found
      return ['status' => 0, 'msg' => 'No customer found with the given ID'];
  }
}


public function getReceiptNo($table_name) {


  $this->db->select('receipt_no');
  $this->db->order_by('receipt_no', 'DESC');
  $query = $this->db->get($table_name);

   // Check if there are any results
   if ($query->num_rows() > 0) {
    $result = $query->row();
    $receiptNo = $result->receipt_no;

    $newReceiptNo = sprintf('RECP%08d', intval(substr($receiptNo, 4)) + 1);
    return $newReceiptNo;
} else {
      $receipt_no = 'RECP00000001';
      return $receipt_no;
  }
}




public function create_order($data) {

  // Sanitize input data
  $sanitized_data = [
      'customer_id' => htmlspecialchars($data['customer_id'], ENT_QUOTES, 'UTF-8'),
      'receipt_no' => htmlspecialchars($data['receipt_no'], ENT_QUOTES, 'UTF-8'),
      'notes_key_1' => htmlspecialchars($data['notes_key_1'], ENT_QUOTES, 'UTF-8'),
      'notes_key_2' => htmlspecialchars($data['notes_key_2'], ENT_QUOTES, 'UTF-8'),
      'auth_type' => htmlspecialchars($data['auth_type'], ENT_QUOTES, 'UTF-8'),
      'max_amount' => htmlspecialchars($data['max_amount'], ENT_QUOTES, 'UTF-8'), 
      'expire_at' => htmlspecialchars($data['expire_at'], ENT_QUOTES, 'UTF-8'), 
      'token_notes_key_1' => htmlspecialchars($data['token_notes_key_1'], ENT_QUOTES, 'UTF-8'),
      'token_notes_key_2' => htmlspecialchars($data['token_notes_key_2'], ENT_QUOTES, 'UTF-8'), 
      'beneficiary_name' => htmlspecialchars($data['beneficiary_name'], ENT_QUOTES, 'UTF-8'),
      'account_number' => htmlspecialchars($data['account_number'], ENT_QUOTES, 'UTF-8'),
      'account_type' => htmlspecialchars($data['account_type'], ENT_QUOTES, 'UTF-8'),
      'ifsc_code' => htmlspecialchars($data['ifsc_code'], ENT_QUOTES, 'UTF-8')
  ];

  // Insert order data into the database
  $this->db->insert('master_nach_customer_order', $sanitized_data);
  $insert_id = $this->db->insert_id();

  // Call the API to create the order and get the response
  $response_api = $this->create_order_api($sanitized_data);

  // Check if the response contains an ID
  if (isset($response_api['id'])) {
      // Update the database with the order ID returned by the API
      $this->db->where('id', $insert_id);
      $query = $this->db->update('master_nach_customer_order', ['order_id' => $response_api['id']]);

      // Check if the database update was successful
      if ($this->db->affected_rows() > 0) {

          $response['status'] = 1;
          $response['order_id'] =  $response_api['id'];
          $response['msg'] = "Data inserted and order ID updated";
      } else {
          $response['status'] = 0;
          $response['msg'] = "Data inserted but failed to update order ID";
      }
  } else {
      $response['status'] = 0;
      $response['msg'] = "Data inserted but API call failed";
  }

  return $response;

}


public function create_order_api($data) {
  $maxAmount = $data['max_amount'] * 100; // Convert amount to paisa

  $curl = curl_init();

  $postFields = json_encode([
      "amount" => 0, // the amount should be 0.
      "currency" => "INR", // The 3-letter ISO currency code for the payment.
      "payment_capture" => true, // true: Payments are captured automatically.
      "method" => "emandate", // The authorization method.
      "customer_id" => $data['customer_id'],
      "receipt" => $data['receipt_no'],
      "notes" => [
          "notes_key_1" => $data['notes_key_1'],
          "notes_key_2" => $data['notes_key_2']
      ],
      "token" => [
          "auth_type" => $data['auth_type'],
          "max_amount" => $maxAmount,
          "expire_at" => $data['expire_at'],
          "notes" => [
              "notes_key_1" => $data['token_notes_key_1'],
              "notes_key_2" => $data['token_notes_key_2']
          ],
          "bank_account" => [
              "beneficiary_name" => $data['beneficiary_name'],
              "account_number" => $data['account_number'],
              "account_type" => $data['account_type'], // Account type
              "ifsc_code" => $data['ifsc_code']
          ]
      ]
  ]);


  curl_setopt_array($curl, [
      CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postFields,
      CURLOPT_HTTPHEADER => [
          'Content-Type: application/json',
          'Authorization: ' . $this->authorization
      ],
  ]);

  $response = curl_exec($curl);

  if (curl_errno($curl)) {
      // Handle curl error
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['error' => $error_msg];
  }

  curl_close($curl);

  $responseArray = json_decode($response, true);
  return $responseArray;
}


public function fetch_token_by_payment_id($data) {
  // Sanitize input data
  $payment_id = htmlspecialchars($data['payment_id'], ENT_QUOTES, 'UTF-8');

  // Call the API to fetch the token by payment ID
  $response = $this->fetch_token_by_payment_id_api($payment_id);

  // Check if the response contains the required data
  if (isset($response['id']) && isset($response['token_id']) && isset($response['order_id'])) {
      // Prepare the data for the database update
      $update_data = [
          'resp_payment_id' => htmlspecialchars($response['id'], ENT_QUOTES, 'UTF-8'),
          'resp_token_id' => htmlspecialchars($response['token_id'], ENT_QUOTES, 'UTF-8')
      ];

      // Perform the database update
      $this->db->where('order_id', $response['order_id']);
      $this->db->update('master_nach_customer_order', $update_data);

      // Check if the database update was successful
      if ($this->db->affected_rows() > 0) {
          return ['status' => 1, 'message' => 'Data updated successfully'];
      } else {
          return ['status' => 0, 'message' => 'Failed to update data or no changes made'];
      }
  } else {
      // Handle API response errors
      return ['status' => 0, 'message' => 'Invalid response from API', 'response' => $response];
  }
}

public function fetch_token_by_payment_id_api($payment_id) {
  $curl = curl_init();

  curl_setopt_array($curl, [
      CURLOPT_URL => "https://api.razorpay.com/v1/payments/$payment_id",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => [
          'Content-Type: ' . $this->content_type,
          'Authorization: ' . $this->authorization
      ],
  ]);

  $response = curl_exec($curl);

  if (curl_errno($curl)) {
      // Handle curl error
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['error' => $error_msg];
  }

  curl_close($curl);

  // Decode and return the API response
  return json_decode($response, true);
}




public function create_order_to_charge_customer($data) {
  // Sanitize and convert amount
  $amount = filter_var($data['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  $sanitized_amount = intval($amount * 100); // Convert amount to paisa

  $sanitized_data = [
      'amount' => $sanitized_amount,
      'receipt' => htmlspecialchars($data['receipt'], ENT_QUOTES, 'UTF-8'),
      'notes_key_1' => htmlspecialchars($data['notes_key_1'], ENT_QUOTES, 'UTF-8'),
      'notes_key_2' => htmlspecialchars($data['notes_key_2'], ENT_QUOTES, 'UTF-8')
  ];

  // Insert the initial data into the database
  $this->db->insert('trans_nach_subsequent_payment_order', $sanitized_data);
  $insert_id = $this->db->insert_id();

  // Call the API to create an order and charge the customer
  $response = $this->create_order_to_charge_customer_api($sanitized_data);

  // Check if the API call was successful and contains an order ID
  if (isset($response['id'])) {
      // Update the database with the order ID returned by the API
      $this->db->where('id', $insert_id);
      $this->db->update('trans_nach_subsequent_payment_order', ['resp_order_id' => htmlspecialchars($response['id'], ENT_QUOTES, 'UTF-8')]);

      // Check if the database update was successful
      if ($this->db->affected_rows() > 0) {
          $response['msg'] = "Data inserted and order ID updated";
      } else {
          $response['msg'] = "Data inserted but failed to update order ID";
      }
  } else {
      $response['msg'] = "Data inserted but API call failed";
  }

  return $response;
}

public function create_order_to_charge_customer_api($data) {
  $amount = intval($data['amount']); // Use sanitized amount in paisa

  $curl = curl_init();

  // JSON encode the post fields
  $postFields = json_encode([
      "amount" => $amount,
      "currency" => "INR",
      "payment_capture" => true,
      "receipt" => $data['receipt'],
      "notes" => [
          "notes_key_1" => $data['notes_key_1'],
          "notes_key_2" => $data['notes_key_2']
      ]
  ]);

  curl_setopt_array($curl, [
      CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postFields,
      CURLOPT_HTTPHEADER => [
          'Content-Type: application/json',
          'Authorization: ' . $this->authorization
      ],
  ]);

  $response = curl_exec($curl);

  if (curl_errno($curl)) {
      // Handle cURL error
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['error' => $error_msg];
  }

  curl_close($curl);

  // Decode and return the API response
  return json_decode($response, true);
}

public function create_recurring_payment($data) {
  // Sanitize and convert amount
  $amount = filter_var($data['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  $sanitized_amount = intval($amount * 100); // Convert amount to paisa

  $sanitized_data = [
      'customer_id' => htmlspecialchars($data['customer_id'], ENT_QUOTES, 'UTF-8'),
      'token' => htmlspecialchars($data['token'], ENT_QUOTES, 'UTF-8'),
      'description' => htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8'),
      'recurring_notes_key_1' => htmlspecialchars($data['notes_key_1'], ENT_QUOTES, 'UTF-8'),
      'recurring_notes_key_2' => htmlspecialchars($data['notes_key_2'], ENT_QUOTES, 'UTF-8')
  ];

  // Update the database with sanitized data
  $this->db->where('resp_order_id', htmlspecialchars($data['order_id'], ENT_QUOTES, 'UTF-8'));
  $this->db->update('trans_nach_subsequent_payment_order', $sanitized_data);

  // Call the API to create a recurring payment
  $response = $this->create_recurring_payment_api($data);

  if (isset($response['id'])) {
      // Update the database with the payment ID returned by the API
      $this->db->where('resp_order_id', htmlspecialchars($data['order_id'], ENT_QUOTES, 'UTF-8'));
      $this->db->update('trans_nach_subsequent_payment_order', ['resp_payment_id' => htmlspecialchars($response['id'], ENT_QUOTES, 'UTF-8')]);

      // Check if the database update was successful
      if ($this->db->affected_rows() > 0) {
          $response['msg'] = "Data inserted and payment ID updated";
      } else {
          $response['msg'] = "Data inserted but failed to update payment ID";
      }
  } else {
      $response['msg'] = "Data inserted but API call failed";
  }

  return $response;
}

public function create_recurring_payment_api($data) {
  $amount = intval($data['amount']) * 100; // Convert amount to paisa

  $curl = curl_init();

  // Prepare the POST fields using json_encode for proper JSON formatting
  $postFields = json_encode([
      "email" => htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8'),
      "contact" => htmlspecialchars($data['contact'], ENT_QUOTES, 'UTF-8'),
      "amount" => $amount,
      "currency" => "INR",
      "order_id" => htmlspecialchars($data['order_id'], ENT_QUOTES, 'UTF-8'),
      "customer_id" => htmlspecialchars($data['customer_id'], ENT_QUOTES, 'UTF-8'),
      "token" => htmlspecialchars($data['token'], ENT_QUOTES, 'UTF-8'),
      "recurring" => "1",
      "description" => htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8'),
      "notes" => [
          "note_key_1" => htmlspecialchars($data['notes_key_1'], ENT_QUOTES, 'UTF-8'),
          "note_key_2" => htmlspecialchars($data['notes_key_2'], ENT_QUOTES, 'UTF-8')
      ]
  ]);

  curl_setopt_array($curl, [
      CURLOPT_URL => 'https://api.razorpay.com/v1/payments/create/recurring/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30, // Adjust the timeout if necessary
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postFields,
      CURLOPT_HTTPHEADER => [
          'Content-Type: application/json',
          'Authorization: ' . $this->authorization
      ],
  ]);

  $response = curl_exec($curl);

  // Handle cURL error if any
  if (curl_errno($curl)) {
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['error' => $error_msg];
  }

  curl_close($curl);

  // Decode the JSON response
  $responseArray = json_decode($response, true);

  // Check if decoding was successful and return the response
  if (json_last_error() === JSON_ERROR_NONE) {
      return $responseArray;
  } else {
      return ['error' => 'Failed to decode JSON response'];
  }
}

}
?>