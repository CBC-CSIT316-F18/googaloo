<?php

// This is the receipt page. 
// This script is created in Chapter 13.

// Require the configuration before any PHP code:
require('./includes/config.inc.php');

if (!isset($_GET['x'], $_GET['y']) || !filter_var($_GET['x'], FILTER_VALIDATE_INT,  array('min_range' => 1)) || (strlen($_GET['y']) !== 40) ) { // Redirect the user.
	$location = 'https://' . BASE_URL . 'index.php';
	header("Location: $location");
	exit();
} else {
	$order_id = $_GET['x'];
	$email_hash = $_GET['y'];
}

// Require the database connection:
require(MYSQL);

// Set the page title and include the header:
include('./includes/plain_header.html');

// Fetch the order information:
$q = 'SELECT FORMAT(total/100, 2) AS total, FORMAT(shipping/100,2) AS shipping, credit_card_number, DATE_FORMAT(order_date, "%a %b %e, %Y at %h:%i%p") AS od, email, CONCAT(last_name, ", ", first_name) AS name, CONCAT_WS(" ", address1, address2, city, state, zip) AS address, phone, CONCAT_WS(" - ", ncc.category, ncp.name) AS item, quantity, FORMAT(price_per/100,2) AS price_per FROM orders AS o INNER JOIN customers AS c ON (o.customer_id = c.id) INNER JOIN order_contents AS oc ON (oc.order_id = o.id) INNER JOIN non_coffee_products AS ncp ON (oc.product_id = ncp.id AND oc.product_type="goodies") INNER JOIN non_coffee_categories AS ncc ON (ncc.id = ncp.non_coffee_category_id) WHERE o.id=? AND SHA1(email)=?
UNION 
SELECT FORMAT(total/100, 2), FORMAT(shipping/100,2), credit_card_number, DATE_FORMAT(order_date, "%a %b %e, %Y at %l:%i%p"), email, CONCAT(last_name, ", ", first_name), CONCAT_WS(" ", address1, address2, city, state, zip), phone, CONCAT_WS(" - ", gc.category, s.size, sc.caf_decaf, sc.ground_whole) AS item, quantity, FORMAT(price_per/100,2)  FROM orders AS o INNER JOIN customers AS c ON (o.customer_id = c.id) INNER JOIN order_contents AS oc ON (oc.order_id = o.id) INNER JOIN specific_coffees AS sc ON (oc.product_id = sc.id AND oc.product_type="coffee") INNER JOIN sizes AS s ON (s.id=sc.size_id) INNER JOIN general_coffees AS gc ON (gc.id=sc.general_coffee_id) WHERE o.id=? AND SHA1(email)=?';

// Prepare the statement:
$stmt = mysqli_prepare($dbc, $q);

// Bind the variables:
mysqli_stmt_bind_param($stmt, 'isis', $order_id, $email_hash, $order_id, $email_hash);

// Execute the query:
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) { // Display the order info:

	echo '<h3>Your Order</h3>';

	// Bind the result:
	mysqli_stmt_bind_result($stmt, $total, $shipping, $cc_num, $order_date, $email, $name, $address, $phone, $item, $quantity, $price);
		
	// Get the first row:
	mysqli_stmt_fetch($stmt);

	// Display the order and customer information:
	echo '<p><strong>Order ID</strong>: ' . $order_id . '</p><p><strong>Order Date</strong>: ' . $order_date . '</p><p><strong>Customer Name</strong>: ' . htmlspecialchars($name) . '</p><p><strong>Shipping Address</strong>: ' . htmlspecialchars($address) . '</p><p><strong>Customer Email</strong>: ' . htmlspecialchars($email) . '</p><p><strong>Customer Phone</strong>: ' . htmlspecialchars($phone) . '</p><p><strong>Credit Card Number Used</strong>: *' . $cc_num . '</p>';

	// Create the table:
	echo '<table border="0" cellspacing="3" cellpadding="3">
	<thead>
		<tr>
	    <th align="center">Item</th>
	    <th align="center">Quantity</th>
	    <th align="right">Price</th>
	    <th align="right">Subtotal</th>
	  </tr>
	</thead>
	<tbody>';
	
	// Print each item:
	do {
		
		// Create a row:
		echo '<tr>
		    <td align="left">' . $item . '</td>
		    <td align="center">' . $quantity . '</td>
		    <td align="right">$' . $price . '</td>
		    <td align="right">$' . number_format($price * $quantity, 2) . '</td>
		</tr>';
								
	} while (mysqli_stmt_fetch($stmt));

	// Show the shipping and total:
	echo '<tr>
	    <td align="right" colspan="3"><strong>Shipping</strong></td>
	    <td align="right">$' . $shipping . '</td>
	</tr>';
	echo '<tr>
	    <td align="right" colspan="3"><strong>Total</strong></td>
	    <td align="right">$' . $total . '</td>
	</tr>';

	// Complete the table and the form:
	echo '</tbody></table>';
	
} else { // No records returned!
	echo '<h3>Error!</h3><p>This page has been accessed in error.</p>';
}

include('./includes/plain_footer.html');
?>