<?php

// This file manages the shopping cart.
// This script is begun in Chapter 9.

// Require the configuration before any PHP code:
require('./includes/config.inc.php');

// Check for, or create, a user session:
if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) {
	$uid = $_COOKIE['SESSION'];
} else {
	$uid = openssl_random_pseudo_bytes(16);
	$uid = bin2hex($uid);
}

// Send the cookie:
setcookie('SESSION', $uid, time()+(60*60*24*30));

// Include the header file:
$page_title = 'Coffee - Your Shopping Cart';
include('./includes/header.html');

// Require the database connection:
require(MYSQL);

// Need the utility functions:
include('./includes/product_functions.inc.php');

// If there's a SKU value in the URL, break it down into its parts:
if (isset($_GET['sku'])) {
	list($type, $pid) = parse_sku($_GET['sku']);
}

if (isset($pid, $type, $_GET['action']) && ($_GET['action'] === 'add') ) { // Add a new product to the cart:

	$r = mysqli_query($dbc, "CALL add_to_cart('$uid', '$type', $pid, 1)");
	
	// For debugging purposes:
	// if (!$r) echo mysqli_error($dbc);
		
} elseif (isset($type, $pid, $_GET['action']) && ($_GET['action'] === 'remove') ) { // Remove it from the cart.
	
	$r = mysqli_query($dbc, "CALL remove_from_cart('$uid', '$type', $pid)");

} elseif (isset($type, $pid, $_GET['action'], $_GET['qty']) && ($_GET['action'] === 'move') ) { // Move it to the cart.

	// Determine the quantity:
	$qty = (filter_var($_GET['qty'], FILTER_VALIDATE_INT, array('min_range' => 1)) !== false) ? $_GET['qty'] : 1;
	
	// Add it to the cart:
	$r = mysqli_query($dbc, "CALL add_to_cart('$uid', '$type', $pid, $qty)");
	
	// Remove it from the wish list:
	$r = mysqli_query($dbc, "CALL remove_from_wish_list('$uid', '$type', $pid)");

} elseif (isset($_POST['quantity'])) { // Update quantities in the cart.
	
	// Loop through each item:
	foreach ($_POST['quantity'] as $sku => $qty) {
		
		// Parse the SKU:
		list($type, $pid) = parse_sku($sku);
		
		if (isset($type, $pid)) {

			// Determine the quantity:
			$qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0)) !== false) ? $qty : 1;

			// Update the quantity in the cart:
			$r = mysqli_query($dbc, "CALL update_cart('$uid', '$type', $pid, $qty)");

		}
			
	} // End of FOREACH loop.
	
}// End of main IF.
		
// Get the cart contents:
$r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");

if (mysqli_num_rows($r) > 0) { // Products to show!
	include('./views/cart.html');
} else { // Empty cart!
	include('./views/emptycart.html');
}

// Finish the page:
include('./includes/footer.html');
?>