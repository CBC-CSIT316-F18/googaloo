<?php

// This page displays a list of the user's favorites.
// This is bonus material based upon recommendations suggested in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Include the header file:
$page_title = 'Your Favorite Pages';
include('./includes/header.html');

echo '<h3>Your Favorite Pages</h3>';

// Require the database connection:
require(MYSQL);

// Get the page info:
// Query to select all pages and indicate favorites, for future reference:
//$q = 'SELECT id, title, description, IF(favorite_pages.user_id=' . $_SESSION['user_id'] .', true, false) FROM pages LEFT JOIN favorite_pages ON (pages.id=favorite_pages.page_id) ORDER BY title';

// Get only the favorites:
$q = 'SELECT id, title, description FROM pages LEFT JOIN favorite_pages ON (pages.id=favorite_pages.page_id) WHERE favorite_pages.user_id=' . $_SESSION['user_id'] . ' ORDER BY title';
$r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0) {

	while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
		// Display each record:
		echo "<div><h4><a href=\"page.php?id=$row[0]\">$row[1]</a></h4><p>$row[2]</p></div>\n";
	}

} else { // No pages available.
	echo '<p>There are currently no pages of content available. Please check back again!</p>';
}

// Include the HTML footer:
include('./includes/footer.html');
?>