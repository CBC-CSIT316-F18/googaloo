<?php

// This page is used to change an existing password when a user resets it
// This script is created in Chapter 12.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Reset Your Password';
include('./includes/header.html');

// For storing reset error only:
$reset_error = '';

// For storing password errors:
$pass_errors = array();

if (isset($_GET['t']) && (strlen($_GET['t']) === 64) ) { // First access
	$token = $_GET['t'];
	
	// Fetch the user ID:
	$q = 'SELECT user_id FROM access_tokens WHERE token=? AND date_expires > NOW()';
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 's', $token);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	if (mysqli_stmt_num_rows($stmt) === 1) {
		mysqli_stmt_bind_result($stmt, $user_id);
		mysqli_stmt_fetch($stmt);

		// Create a new session ID:
		session_regenerate_id(true);
		$_SESSION['user_id'] = $user_id;

		// Clear the token:
		$q = 'DELETE FROM access_tokens WHERE token=?';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 's', $token);
		mysqli_stmt_execute($stmt);

	} else {
		$reset_error = 'Either the provided token does not match that on file or your time has expired. Please resubmit the "Forgot your password?" form.';
	}
	mysqli_stmt_close($stmt);

} else { // No token!
	$reset_error = 'This page has been accessed in error.';
}

// If it's a POST request, handle the form submission:
if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_SESSION['user_id'])) {

	// Okay to change password:
	$reset_error = '';
			
	// Check for a password and match against the confirmed password:
	if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = $_POST['pass1'];
		} else {
			$pass_errors['pass2'] = 'Your password did not match the confirmed password!';
		}
	} else {
		$pass_errors['pass1'] = 'Please enter a valid password!';
	}
	
	if (empty($pass_errors)) { // If everything's OK.

		// Define the query:
		$q = 'UPDATE users SET pass=? WHERE id=? LIMIT 1';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'si', $pass, $_SESSION['user_id']);
		$pass = password_hash($p, PASSWORD_BCRYPT);
		mysqli_stmt_execute($stmt);

		if (mysqli_stmt_affected_rows($stmt) === 1) {

			// Send an email, if desired.

			// Let the user know the password has been changed:
			echo '<h1>Your password has been changed.</h1>';
			include('./includes/footer.html'); // Include the HTML footer.
			exit();

		} else { // If it did not run OK.

			trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

		}

	} // End of empty($pass_errors) IF.
	
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$reset_error = 'This page has been accessed in error.';
} // End of the form submission conditional.

// If it's safe to change the password, show the form:
if (empty($reset_error)) {

	// Need the form functions script, which defines create_form_input():
	// The file may already have been included by the header.
	require_once('./includes/form_functions.inc.php');

	echo '<h1>Change Your Password</h1>
	<p>Use the form below to change your password.</p>
	<form action="reset.php" method="post" accept-charset="utf-8">';

	create_form_input('pass1', 'password', 'Password', $pass_errors);

	echo '<span class="help-block">Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</span>';

	create_form_input('pass2', 'password', 'Confirm Password', $pass_errors); 

	echo '<input type="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="btn btn-default" />
</form>';

} else {
	echo '<div class="alert alert-danger">' . $reset_error . '</div>';
}

include('./includes/footer.html');
?>