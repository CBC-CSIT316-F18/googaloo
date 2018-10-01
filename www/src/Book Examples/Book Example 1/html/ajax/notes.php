<?php

// This page adds or updates notes for a user.
// This script is created in Chapter 14.
// This script is used for an Ajax request.
// This script returns a simple string.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('../includes/config.inc.php');
// The config file also starts the session.

// Need these values:
if (isset($_POST['page_id'], $_POST['notes'], $_SESSION['user_id']) 
	&& filter_var($_POST['page_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	&& filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))
	) {

	// Require the database connection:
	require(MYSQL);	

	// Update or delete notes?
	if (empty($_POST['notes'])) {
		
		// Remove from the database:
		$q = 'DELETE FROM notes WHERE user_id=? AND page_id=?';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_id'], $_POST['page_id']);
	
	} else {

		// INSERT or UPDATE:
		$q = 'REPLACE INTO notes (user_id, page_id, note) VALUES (?, ?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'iis', $_SESSION['user_id'], $_POST['page_id'], $_POST['notes']);
	}

	mysqli_stmt_execute($stmt);
	if (mysqli_stmt_affected_rows($stmt) > 0) {
		echo 'true';
		exit;
	}

} // Invalid values or didn't work!
echo 'false';