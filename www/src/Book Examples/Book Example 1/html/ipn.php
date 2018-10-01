<?php

// This page handles the Instant Payment Notification communications with PayPal.
// Most of the code comes from PayPal's documentation.
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Check for a POST request, with a provided transaction ID:
if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['txn_id']) && ($_POST['txn_type'] === 'web_accept') ) {
	
	// Create the cURL handler:
	$ch = curl_init();
	
	// Configure the request:
	curl_setopt_array($ch, array (
	    CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => http_build_query(array('cmd' => '_notify-validate') + $_POST),
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_HEADER => false
	));
	
	// Execute the request:
	$response = curl_exec($ch);
	
	// Get the status code:
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	// Close the connection:
	curl_close($ch);

	// Check that it worked:
	if ($status === 200 && $response === 'VERIFIED') {
	
		// Check for the right values:
		if ( isset($_POST['payment_status'])
		 && ($_POST['payment_status'] === 'Completed')
		 && ($_POST['receiver_email'] === 'seller_1281297018_biz@mac.com')
		 && ($_POST['mc_gross'] === 10.00)
		 && ($_POST['mc_currency']  === 'USD') 
		 && (!empty($_POST['txn_id']))
		) {

			// Need the database connection now:
			require(MYSQL);
			
			// Check for this transaction in the database:
			$txn_id = escape_data($_POST['txn_id'], $dbc);			
			$q = "SELECT id FROM orders WHERE transaction_id='$txn_id'";
			$r = mysqli_query($dbc, $q);
			if (mysqli_num_rows($r) === 0) { // Add this new transaction:
				
				$uid = (isset($_POST['custom'])) ? (int) $_POST['custom'] : 0;
				$status = escape_data($_POST['payment_status'], $dbc);
				$amount = (int) ($_POST['mc_gross'] * 100);
				$q = "INSERT INTO orders (user_id, transaction_id, payment_status, payment_amount) VALUES ($uid, '$txn_id', '$status', $amount)";
				$r = mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) === 1) {
					
					if ($uid > 0) {
	
						// Update the users table:
						$q = "UPDATE users SET date_expires = IF(date_expires > NOW(), ADDDATE(date_expires, INTERVAL 1 YEAR), ADDDATE(NOW(), INTERVAL 1 YEAR)), date_modified=NOW() WHERE id=$uid";
						$r = mysqli_query($dbc, $q);
						if (mysqli_affected_rows($dbc) !== 1) {
							trigger_error('The user\'s expiration date could not be updated!');
						}
	
					} // No user ID.
					
				} else { // Problem inserting the order!
					trigger_error('The transaction could not be stored in the orders table!');						
				}
		
			} // The order has already been stored, nothing to do!
		
		} // The right values don't exist in $_POST!
		
	} else { // Bad response!
		// Log for further investigation.		
	}
	
	// Open the text file:
	// Change this path to make it accurate.
	// The text file must be writable by PHP!
	$file = fopen('pp_log.txt', 'a');

	// Write the POST data to the file:
	fwrite($file, "Received:\n");
	ksort($_POST); // Better to be in alpha order
	fwrite($file, print_r($_POST, true));
	fwrite($file, "\n");
	fwrite($file, "Status: $status\nResponse: $response\n");
	// Indicate the end of this transaction in the text file:
	fwrite($file, "--------------\n");
	fclose($file);
	
} else { // This page was not requested via POST, no reason to do anything!
	echo 'Nothing to do.';
}
?>