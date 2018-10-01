<?php

// This page is used to change an existing password.
// Users must be logged in to access this page.
// This script is created in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Change Your Password';
include('./includes/header.html');

// For storing errors:
$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
	// Check for the existing password:
	if (!empty($_POST['current'])) {
		$current = $_POST['current'];
	} else {
		$pass_errors['current'] = 'Please enter your current password!';
	}
	
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
	
		// Check the current password:
		$q = "SELECT pass FROM users WHERE id={$_SESSION['user_id']}";	
		$r = mysqli_query($dbc, $q);
		list($hash) = mysqli_fetch_array($r, MYSQLI_NUM);
		
		// Validate the password:
		// Include the password_compat library, if necessary:
		// include('./includes/lib/password.php');
		if (password_verify($current, $hash)) { // Correct!

			// Define the query:
			$q = "UPDATE users SET pass='"  .  password_hash($p, PASSWORD_BCRYPT) .  "' WHERE id={$_SESSION['user_id']} LIMIT 1";	
			if ($r = mysqli_query($dbc, $q)) { // If it ran OK.

				// Send an email, if desired.

				// Let the user know the password has been changed:
				echo '<h1>Your password has been changed.</h1>';
				include('./includes/footer.html'); // Include the HTML footer.
				exit();

			} else { // If it did not run OK.

				trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

			}

		} else { // Invalid password.
			$pass_errors['current'] = 'Your current password is incorrect!';
		}

	} // End of empty($pass_errors) IF.
	
} // End of the form submission conditional.

// Need the form functions script, which defines create_form_input():
// The file may already have been included by the header.
require_once('./includes/form_functions.inc.php');
?><h1>Change Your Password</h1>
<p>Use the form below to change your password.</p>
<form action="change_password.php" method="post" accept-charset="utf-8">
	<?php
	create_form_input('current', 'password', 'Current Password', $pass_errors);
	create_form_input('pass1', 'password', 'Password', $pass_errors);
	echo '<span class="help-block">Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</span>';
	create_form_input('pass2', 'password', 'Confirm Password', $pass_errors); 
	?>
	<input type="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="btn btn-default" />
</form>

<?php // Include the HTML footer:
include('./includes/footer.html');
?>