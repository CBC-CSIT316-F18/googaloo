<?php

// This page adds a page of content to the list of the user's favorites.
// This is bonus material based upon recommendations suggested in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't active, redirect them:
redirect_invalid_user('user_not_expired');

// Require the database connection:
require(MYSQL);

// Validate the page ID:
if (filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	$page_id = $_GET['id'];

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $page_id;
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		include('./includes/header.html');
		echo '<p class="error">This page has been accessed in error.</p>';
		include('./includes/footer.html');
		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];
	include('includes/header.html');
	echo "<h3>$page_title</h3>";
	
	// Add this favorite to the database:
	$q = 'REPLACE INTO favorite_pages (user_id, page_id) VALUES (' . $_SESSION['user_id'] . ', ' . $_GET['id'] . ')';
	$r = mysqli_query($dbc, $q);
	if (mysqli_affected_rows($dbc) == 1) {
			echo '<p><img src="/images/heart_48.png" border="0" width="48" height="48" align="middle" /> This has been added to your favorites! <a href="remove_from_favorites.php?id=' . $_GET['id'] . '"><img src="/images/cross_48.png" border="0" width="48" height="48" align="middle" /></a></p>';
	} else {
		trigger_error('A system error occurred. We apologize for any inconvenience.');
	}

	// Show the page content:
	echo "<div>{$row['content']}</div>";
		
} else { // No valid ID.
	$page_title = 'Error!';
	include('includes/header.html');
	echo '<p class="error">This page has been accessed in error.</p>';
} // End of primary IF.

// Include the HTML footer:
include('./includes/footer.html');
?>