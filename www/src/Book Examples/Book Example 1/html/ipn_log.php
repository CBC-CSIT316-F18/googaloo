<?php

// This page handles the Instant Payment Notification communications with PayPal.
// Most of the code comes from PayPal's documentation.
// This script is created in Chapter 6.
// This is a modified version of ipn.php that logs all transactions to a text file.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Open the text file:
// Change this path to make it accurate.
// The text file must be writable by PHP!
$file = fopen('../ipn.txt', 'a');

// Write the POST data to the file:
fwrite($file, "Received:\n");
fwrite($file, print_r($_POST, true));
fwrite($file, "\n");

// Start by creating a request variable:
$req = 'cmd=_notify-validate';

// Add each received key=value pair to the request:
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// Open a socket connection to PayPal:
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); // Test
//$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); // Live

if (!$fp) { // If we couldn't connect, send an email:

	trigger_error('Could not connect for the IPN!');
	
} else { // Send the request to PayPal:
	
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	fputs ($fp, $header . $req);

	// Write the PayPal request to the text file:
	fwrite($file, "Sent:\n");
	fwrite($file, "$header\n");
	fwrite($file, "$req\n");
	
	// Read in the response:
	while (!feof($fp)) {

		$res = fgets ($fp, 1024);

		// Write the PayPal response to the text file:
		fwrite($file, "Received:\n");
		fwrite($file, "$res\n");

		if (strcmp ($res, "VERIFIED") == 0) {
			
			// Check for the right values:
			if ( ($_POST['payment_status'] == 'Completed')
			 && ($_POST['receiver_email'] == 'seller_1281297018_biz@mac.com')
			 && ($_POST['mc_gross'] == 10.00)
			 && ($_POST['mc_currency']  == 'USD') 
			 && (!empty($_POST['txn_id']))
			) {
				
				// Need the database connection now:
				require(MYSQL);
				
				// Check for this transaction in the database:
				$txn_id = mysqli_real_escape_string($dbc, $_POST['txn_id']);				
				$q = "SELECT id FROM orders WHERE transaction_id='$txn_id'";
				$r = mysqli_query($dbc, $q);
				if (mysqli_num_rows($r) == 0) { // Add this new transaction:
					
					$uid = (int) $_POST['custom'];
					$status = mysqli_real_escape_string($dbc, $_POST['payment_status']);
					$amount = (float) $_POST['mc_gross'];
					$q = "INSERT INTO orders (user_id, transaction_id, payment_status, payment_amount) VALUES ($uid, '$txn_id', '$status', $amount)";
					$r = mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						
						// Update the users table:
						$q = "UPDATE users SET date_expires = IF(date_expires > NOW(), ADDDATE(date_expires, INTERVAL 1 YEAR), ADDDATE(NOW(), INTERVAL 1 YEAR)), date_modified=NOW() WHERE id=$uid";
						$r = mysqli_query($dbc, $q);
						if (mysqli_affected_rows($dbc) != 1) {
							trigger_error('The user\'s expiration date could not be updated!');
						}
						
					} else { // Problem inserting the order!
						trigger_error('The transaction could not be stored in the orders table!');						
					}
					
				} // The order has already been stored!
				
			} // The right values don't exist in $_POST!

		} elseif (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
		}

	} // End of the WHILE loop.
	
	// Close the connection:
	fclose ($fp);

} // End of $fp IF-ELSE.

// Inidicate the end of this transaction in the text file:
fwrite($file, "--------------\n");
fclose($file);

?>