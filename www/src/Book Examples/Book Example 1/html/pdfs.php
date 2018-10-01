<?php

// This page displays the available PDFs.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'PDFs';
include('./includes/header.html');

// Print a page header:
echo '<h1>PDF Guides</h1>';

// Print a message if they're not an active user:
if (isset($_SESSION['user_id']) && !isset($_SESSION['user_not_expired'])) {
	echo '<div class="alert"><h4>Expired Account</h4>Thank you for your interest in this content, but your account is no longer current. Please <a href="renew.php">renew your account</a> in order to view any of the PDFs listed below.</div>';
} elseif (!isset($_SESSION['user_id'])) {
	echo '<div class="alert">Thank you for your interest in this content. You must be logged in as a registered user to view any of the PDFs listed below.</div>';
}

// Get the PDFs:
$q = 'SELECT tmp_name, title, description, size FROM pdfs ORDER BY date_created DESC';
$r = mysqli_query($dbc, $q);
if (mysqli_num_rows($r) > 0) { // If there are some...
	
	// Fetch every one:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

		// Display each record:
		echo '<div><h4><a href="view_pdf.php?id=' . htmlspecialchars($row['tmp_name']) . '">' . htmlspecialchars($row['title']) . ' </a> (' . $row['size'] . 'kb)</h4><p>' . htmlspecialchars($row['description']) . '</p></div>';

	} // End of WHILE loop.
	
} else { // No PDFs!
	echo '<div class="alert alert-danger">There are currently no PDFs available to view. Please check back again!</div>';
}

// Include the HTML footer:
include('./includes/footer.html');
?>