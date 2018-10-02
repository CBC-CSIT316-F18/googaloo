<?php

// This page adds or removes an item to/from the user's cart.
// This script is created in Chapter 14.
// This script is used for an Ajax request.
// This script returns a simple string.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('../includes/config.inc.php');
// The config file also starts the session.
$_SESSION['user_id'] = 18;

// Need these values:
if (isset($_GET['sku'], $_GET['action']) 
	&& filter_var($_GET['page_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	&& filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	) {

	if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) {
	$uid = $_COOKIE['SESSION'];
} else {
	$uid = substr(uniqid(rand(), true), 0, 32);
}

// Send the cookie:
setcookie('SESSION', $uid, time()+(60*60*24*30));


	// What action is being taken?
	if ($_GET['action'] === 'add') {
		// Add this favorite to the database:
		$q = 'REPLACE INTO favorite_pages (user_id, page_id) VALUES (?, ?)';
	} elseif ($_GET['action'] === 'remove') {
		// Remove this favorite from the database:
		$q = 'DELETE FROM favorite_pages WHERE user_id=? AND page_id=?';
	}

	if (isset($q)) { // If the action was appropriate, run the query...

		// Require the database connection:
		require(MYSQL);	
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_id'], $_GET['page_id']);
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_affected_rows($stmt) > 0) {
			echo 'true';
			exit;
		}
	}

} // Invalid values or didn't work!
<?php

// This file manages the shopping cart.
// This script is begun in Chapter 9.

// Require the configuration before any PHP code:
require('./includes/config.inc.php');

// Check for, or create, a user session:
if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) {
	$uid = $_COOKIE['SESSION'];
} else {
	$uid = substr(uniqid(rand(), true), 0, 32);
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

echo 'false';