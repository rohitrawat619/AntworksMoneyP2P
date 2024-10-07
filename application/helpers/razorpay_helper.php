<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Make a request to the Razorpay API to create a new contact.
 *
 * @param string $name Contact name.
 * @param string $email Contact email.
 * @param int $contact Contact number.
 * @param string $type Type of the contact.
 * @param string $reference_id Reference ID.
 * @param string $batch_id Batch ID.
 * @param array $notes Additional notes.
 * @return mixed API response.
 */
function create_razorpay_contact($name, $email, $contact, $type, $reference_id, $batch_id, $notes_input) {
    $curl = curl_init();
		
		$notes = array(
        "random_key_1" => $notes_input,
        "random_key_2" => "Tea. Earl Grey. Hot."
    );
	
    $postFields = json_encode(array(
        "name" => $name,
        "email" => $email,
        "contact" => $contact,
        "type" => $type,
        "reference_id" => $reference_id,
        "batch_id" => $batch_id,
        "notes" => $notes
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/contacts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic ' . 'cnpwX3Rlc3RfcGl6S2NTV293U004enE6ZTdjVWs3eHJKaEI1cG8zYXF6NW1GdFN1'// Replace with actual credentials
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $response = curl_error($curl);
    }

    curl_close($curl);

    return $response;
}



/**
 * Create a new fund account in Razorpay.
 *
 * @param string $contact_id The contact ID associated with the fund account.
 * @param string $account_type The type of fund account (e.g., 'bank_account').
 * @param array $bank_account Details of the bank account.
 * @return mixed API response.
 */
function create_razorpay_fund_account($contact_id, $account_type,$customer_name,$ifsc,$account_number) {
    $curl = curl_init();

  $bank_account = array(
            "name" => $customer_name, //"Dheeraj Dutta",
            "ifsc" => $ifsc, // "ICIC000235512",
            "account_number" => $account_number, //"23545501504975"
        );
    // Prepare POST fields
    $postFields = json_encode(array(
        "contact_id" => $contact_id,
        "account_type" => $account_type,
        "bank_account" => $bank_account
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/fund_accounts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
             'Authorization: Basic ' . 'cnpwX3Rlc3RfcGl6S2NTV293U004enE6ZTdjVWs3eHJKaEI1cG8zYXF6NW1GdFN1'// Replace with actual credentials
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $response = curl_error($curl);
    }

    curl_close($curl);

    return $response;
}




/**
 * Perform a payout request to Razorpay.
 *
 * @param array $data The data to send in the request.
 * @return mixed The response from the cURL request.
 */
function perform_razorpay_payout($data,$investment_no){ // Dated: 2024-august-08 trans_razorpay_payouts table created
    // Initialize cURL session
    $curl = curl_init();
    
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/payouts', // https://webhook.site/fc632a70-6366-410c-8673-f6e5a0ba7bbc//
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
		
		CURLOPT_HTTPHEADER => array(
    'X-Payout-Idempotency: '.$investment_no, //53cda91c-9f81-4e77-bbb9-7388f4ac6b',
    'Content-Type: application/json',
    'Authorization: Basic   cnpwX2xpdmVfcmtJdVFSTVJraUhKek06bnF3S0lkUDBCcmtIc2VuV3V1d1VNT05Q'
  ),
  
    ));
    
    // Execute the cURL request and get the response
    $response = curl_exec($curl);
    
    // Check for cURL errors
    if (curl_errno($curl)) {
        $response = curl_error($curl);
    }
    
    // Close cURL session
    curl_close($curl);
    
    return $response;
		}


