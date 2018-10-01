<?php

// This page displays a list of the user's history.
// This is bonus material based upon recommendations suggested in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Include the header file:
$page_title = 'Your Viewing History';
include('./includes/header.html');

echo '<h3>Your Viewing History</h3>';

// Require the database connection:
require(MYSQL);

// Get the page info:
// Query to select all pages and indicate favorites, for future reference:
//$q = 'SELECT id, title, description, IF(favorite_pages.user_id=' . $_SESSION['user_id'] .', true, false) FROM pages LEFT JOIN favorite_pages ON (pages.id=favorite_pages.page_id) ORDER BY title';

// Get the pages they've viewed
$q = 'SELECT pages.id, title, description, DATE_FORMAT(history.date_created, "%M %d, %Y") FROM pages LEFT JOIN history ON (pages.id=history.page_id) WHERE history.user_id=' . $_SESSION['user_id'] . ' GROUP BY (history.page_id) ORDER BY history.date_created DESC';
$r = mysqli_query($dbc, $q);

echo '<h4>Pages You Have Viewed</h4>';

if (mysqli_num_rows($r) > 0) {
	
	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
		// Display each record:
		echo "<div><h4><a href=\"page.php?id=$row[0]\">$row[1]</a></h4><p>$row[2]<br />Last viewed: $row[3]</p></div>\n";
	}

} else { // No pages available.
	echo '<p>You have not yet viewed any pages.</p>';
}

// Get the pages they've viewed
$q = 'SELECT pdfs.tmp_name, title, description, DATE_FORMAT(history.date_created, "%M %d, %Y") FROM pdfs LEFT JOIN history ON (pdfs.id=history.pdf_id) WHERE history.user_id=' . $_SESSION['user_id'] . ' GROUP BY (history.pdf_id) ORDER BY history.date_created DESC';
$r = mysqli_query($dbc, $q);

echo '<h4>PDFs You Have Viewed</h4>';

if (mysqli_num_rows($r) > 0) {
	
	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
		// Display each record:
		echo "<div><h4><a href=\"view_pdf.php?id=$row[0]\">$row[1]</a></h4><p>$row[2]<br />Last viewed: $row[3]</p></div>\n";
	}

} else { // No pages available.
	echo '<p>You have not yet viewed any PDFs.</p>';
}

// Include the HTML footer:
include('./includes/footer.html');
?>