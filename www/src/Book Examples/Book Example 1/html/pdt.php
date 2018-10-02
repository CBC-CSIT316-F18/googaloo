<?php

// This page handles the Payment Data Transfer communications with PayPal.
// This script is created in Chapter 12.

// Need a transaction ID in order to do anything:
if (isset($_GET['tx'])) {

	$txn_id = $_GET['tx'];
	
	// Confirm the results with PayPal:
	$ch = curl_init();

	// Set request options
	curl_setopt_array($ch, array (
	    CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
	    CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query(array (
			'cmd' => '_notify-synch',
			'tx' => $txn_id,
			'at' => '_hesfjTfdMEF5aNimrA2oWnRSQSUyaSHadiCEAY5_II-3h2vpLLxujY3JXq'
			)),
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_HEADER => false
	));
	
	// Execute the request:
	$response = curl_exec($ch);
	
	// Get the status code:
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	// Close the connection:
	curl_close($ch);
		echo '<pre>' . print_r($response, 1) . '</pre>';
		echo '<pre>' . print_r($status, 1) . '</pre>';
exit;
	// Check the status code:
	if ($status === 200) {

		// Convert the response to an array of lines:
		$lines = explode("\n", urldecode($response));

		// Convert the array of lines into a more usable array:
		$data = array();

		// The first line is SUCCESS/FAIL:
		$data['result'] = array_shift($lines);

		// Convert the remaining lines:
		foreach ($lines as $line) {
			if (stristr($line, '=')) {
				list ($k, $v) = explode('=', $line);
				$data[$k] = $v;
			}
		}

		// Check the results:
		if ( ($data['result'] === 'SUCCESS')
		&& isset($data['payment_status'])
		&& ($data['payment_status'] === 'Completed')
		&& ($data['receiver_email'] === 'seller_1281297018_biz@mac.com')
		&& ($data['mc_gross'] === 10.00)
		&& ($data['mc_currency'] === 'USD') 
		) { // Hooray!

			// Check for this transaction in the database:
			$q = "SELECT id FROM orders WHERE transaction_id='$txn_id'";
			$r = mysqli_query($dbc, $q);
			if (mysqli_num_rows($r) === 0) { // Add this new transaction:
				
				// Get the values to create the order:
				$uid = (isset($data['custom'])) ? (int) $data['custom'] : 0;
				$amount = (int) ($data['mc_gross'] * 100);
				$q = "INSERT INTO orders (user_id, transaction_id, payment_status, payment_amount) VALUES ($uid, '$txn_id', '{$data['result']}', $amount)";
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
		} // Not valid response.
	} // Can't confirm the PDT.
} // No $_GET['tx'].
?>