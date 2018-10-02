<?php

// This page adds or removes a favorite for the user.
// This script is created in Chapter 14.
// This script is used for an Ajax request.
// This script returns a simple string.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('../includes/config.inc.php');
// The config file also starts the session.

// Need these values:
if (isset($_GET['page_id'], $_GET['action'], $_SESSION['user_id']) 
	&& filter_var($_GET['page_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	&& filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	) {

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
echo 'false';