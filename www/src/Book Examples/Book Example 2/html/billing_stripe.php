<?php

// This file is the second step in the checkout process.
// It takes and validates the billing information.
// This updated versions uses Stripe.
// This script is created in Chapter 15.

// Require the configuration before any PHP code:
require('./includes/config.inc.php');

// Start the session:
session_start();

// The session ID is the user's cart ID:
$uid = session_id();

// Check that this is valid:
if (!isset($_SESSION['customer_id'])) { // Redirect the user.
	$location = 'https://' . BASE_URL . 'checkout.php';
	header("Location: $location");
	exit();
}

// Require the database connection:
require(MYSQL);

// Validate the billing form...

// For storing errors:
$billing_errors = array();



// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (get_magic_quotes_gpc()) {
		$_POST['cc_first_name'] = stripslashes($_POST['cc_first_name']);
		// Repeat for other variables that could be affected.
	}

	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['cc_first_name'])) {
		$cc_first_name = $_POST['cc_first_name'];
	} else {
		$billing_errors['cc_first_name'] = 'Please enter your first name!';
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['cc_last_name'])) {
		$cc_last_name  = $_POST['cc_last_name'];
	} else {
		$billing_errors['cc_last_name'] = 'Please enter your last name!';
	}
	
	// Check for a Stripe token:
	if (isset($_POST['token'])) {
		$token = $_POST['token'];		
	} else {
		$message = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
		$billing_errors['token'] = true;
	}

	
	// Check for a street address:
	if (preg_match ('/^[A-Z0-9 \',.#-]{2,160}$/i', $_POST['cc_address'])) {
		$cc_address  = $_POST['cc_address'];
	} else {
		$billing_errors['cc_address'] = 'Please enter your street address!';
	}
		
	// Check for a city:
	if (preg_match ('/^[A-Z \'.-]{2,60}$/i', $_POST['cc_city'])) {
		$cc_city = $_POST['cc_city'];
	} else {
		$billing_errors['cc_city'] = 'Please enter your city!';
	}

	// Check for a state:
	if (preg_match ('/^[A-Z]{2}$/', $_POST['cc_state'])) {
		$cc_state = $_POST['cc_state'];
	} else {
		$billing_errors['cc_state'] = 'Please enter your state!';
	}

	// Check for a zip code:
	if (preg_match ('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['cc_zip'])) {
		$cc_zip = $_POST['cc_zip'];
	} else {
		$billing_errors['cc_zip'] = 'Please enter your zip code!';
	}
	
	if (empty($billing_errors)) { // If everything's OK...

		// Check for an existing order ID:
		if (isset($_SESSION['order_id'])) { // Use existing order info:
			$order_id = $_SESSION['order_id'];
			$order_total = $_SESSION['order_total'];
		} else { // Create a new order record:


			// Get the last four digits of the credit card number:
			// Temporary solution for Stripe:
			$cc_last_four = 1234;
//			$cc_last_four = substr($cc_number, -4);

			// Call the stored procedure:
			$shipping = $_SESSION['shipping'] * 100;
//			$r = mysqli_query($dbc, "CALL add_order({$_SESSION['customer_id']}, '$uid', $shipping, $cc_last_four, @total, @oid)");

			// Confirm that it worked:
			if ($r) {

				// Retrieve the order ID and total:
				$r = mysqli_query($dbc, 'SELECT @total, @oid');
				if (mysqli_num_rows($r) == 1) {
					list($order_total, $order_id) = mysqli_fetch_array($r);
					
					// Store the information in the session:
					$_SESSION['order_total'] = $order_total;
					$_SESSION['order_id'] = $order_id;
					
				} else { // Could not retrieve the order ID and total.
					unset($cc_number, $cc_cvv, $_POST['cc_number'], $_POST['cc_cvv']);
					trigger_error('Your order could not be processed due to a system error. We apologize for the inconvenience.');
				}
			} else { // The add_order() procedure failed.
				trigger_error('Your order could not be processed due to a system error. We apologize for the inconvenience.');
			}
			
		} // End of isset($_SESSION['order_id']) IF-ELSE.
		
		// ------------------------
		// Process the payment!
		if (isset($order_id, $order_total)) {

			try {

				// Include the Stripe library:
				require_once('includes/Stripe.php');

				// set your secret key: remember to change this to your live secret key in production
				// see your keys here https://manage.stripe.com/account
				Stripe::setApiKey('sk_test_cyFiWIBiAhaZiW2WiURm4MNw');

				// Charge the order:
				$charge = Stripe_Charge::create(array(
					'amount' => $order_total,
					'currency' => 'usd',
					'card' => $token,
					'description' => $_SESSION['email'],
					'capture' => false
					)
				);

//				echo '<pre>' . print_r($charge, 1) . '</pre>';exit;

				// Did it work?
				if ($charge->paid == 1) {

					// Add slashes to two text values:
					$full_response = addslashes(serialize($charge));

					// Record the transaction:
					$r = mysqli_query($dbc, "CALL add_charge('{$charge->id}', $order_id, 'auth_only', $order_total, '$full_response')");				
					
					// Add the transaction info to the session:
					$_SESSION['response_code'] = $charge->paid;
					
					// Redirect to the next page:
					$location = 'https://' . BASE_URL . 'final.php';
					header("Location: $location");
					exit();

				} else { // Charge was not paid!	
					$message = $charge->response_reason_text;
				}

			} catch (Stripe_CardError $e) { // Stripe declined the charge.
				$e_json = $e->getJsonBody();
				$err = $e_json['error'];
				$message = $err['message'];
			} catch (Exception $e) { // Try block failed somewhere else.
				trigger_error(print_r($e, 1));

			}

		} // End of isset($order_id, $order_total) IF.
		// Above code added as part of payment processing.
		// ------------------------

	} // Errors occurred IF

} // End of REQUEST_METHOD IF.
							
// Include the header file:
$page_title = 'Coffee - Checkout - Your Billing Information';
include('./includes/checkout_header.html');

// Get the cart contents:
$r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");

if (mysqli_num_rows($r) > 0) { // Products to show!
	if (isset($_SESSION['shipping_for_billing']) && ($_SERVER['REQUEST_METHOD'] !== 'POST')) {
		$values = 'SESSION';
	} else {
		$values = 'POST';
	}
	include('./views/billing_stripe.html');
} else { // Empty cart!
	include('./views/emptycart.html');
}

// Finish the page:
include('./includes/footer.html');
?>