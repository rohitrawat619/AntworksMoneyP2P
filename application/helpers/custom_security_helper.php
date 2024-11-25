<?php
// application/helpers/custom_security_helper.php
		// using in Borrower_registration.php file dated: 27-sept-2023
if (!function_exists('sanitize_input_data')) {
    function sanitize_input_data($input) {
        $CI = &get_instance(); // Get the CI super object
		$xss_clean_data = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
       // return  $CI->db->escape($xss_clean_data);
	    return  str_replace("'","",$CI->db->escape($xss_clean_data));
    }
}


	if(!function_exists('encrypt_string')){
		function encrypt_string($string){
			
			// Store a string into the variable which
			// need to be Encrypted
			
			  
			// Display the original string
			//echo "Original String: " . $string;
			  
			// Store the cipher method
			$ciphering = "AES-128-CTR";
			  
			// Use OpenSSl Encryption method
			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;
			  
			// Non-NULL Initialization Vector for encryption
			$encryption_iv = '1234567891011121';
			  
			// Store the encryption key
			$encryption_key = "antworksSme";
			  
			// Use openssl_encrypt() function to encrypt the data
		return $encryption = openssl_encrypt($string, $ciphering,
					$encryption_key, $options, $encryption_iv);
		 
		}
	}
	
	
	if(!function_exists('decrypt_string')){
		function decrypt_string($encryption){
			 //Store the cipher method
			$ciphering = "AES-128-CTR";
			// Use OpenSSl Encryption method
			$iv_length = openssl_cipher_iv_length($ciphering);
			$options = 0;
			
			// Non-NULL Initialization Vector for decryption
			$decryption_iv = '1234567891011121';
			  
			// Store the decryption key
			$decryption_key = "antworksSme";
			  
			// Use openssl_decrypt() function to decrypt the data
			return $decryption=openssl_decrypt ($encryption, $ciphering, 
					$decryption_key, $options, $decryption_iv);
		 
		}
	}

?>