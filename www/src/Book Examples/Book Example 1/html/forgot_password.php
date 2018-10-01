<?php

// This page is used to reset a forgotten password.
// A new password is generated and sent to the registered email address.
// This script is created in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Forgot Your Password?';
include('./includes/header.html');

// For storing errors:
$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Validate the email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		$email = $_POST['email'];
	
		// Check for the existence of that email address...
		$q = 'SELECT id FROM users WHERE email="'.  escape_data($email, $dbc) . '"';
		$r = mysqli_query($dbc, $q);
		
		if (mysqli_num_rows($r) === 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array($r, MYSQLI_NUM); 
		} else { // No database match made.
			$pass_errors['email'] = 'The submitted email address does not match those on file!';
		}
		
	} else { // No valid address submitted.
		$pass_errors['email'] = 'Please enter a valid email address!';
	} // End of $_POST['email'] IF.
	
	if (empty($pass_errors)) { // If everything's OK.

		// Original code below...
/*
		// Create a new, random password:
		$p = substr(md5(uniqid(rand(), true)), 10, 15);

		// Include the password_compat library, if necessary:
		// include('./includes/lib/password.php');

		// Update the database:
		$q = "UPDATE users SET pass='" .  password_hash($p, PASSWORD_BCRYPT) . "' WHERE id=$uid LIMIT 1";
		$r = mysqli_query($dbc, $q);

		if (mysqli_affected_rows($dbc) === 1) { // If it ran OK.
		
			// Send an email:
			$body = "Your password to log into <whatever site> has been temporarily changed to '$p'. Please log in using that password and this email address. Then you may change your password to something more familiar.";
			mail($_POST['email'], 'Your temporary password.', $body, 'From: admin@example.com');
			
			// Print a message and wrap up:
			echo '<h1>Your password has been changed.</h1><p>You will receive the new, temporary password via email. Once you have logged in with this new password, you may change it by clicking on the "Change Password" link.</p>';
			include('./includes/footer.html');
			exit(); // Stop the script.
			
		} else { // If it did not run OK.

			trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

		}
*/

		// Bonus material! 
		// Referenced in Chapter 12:
		$token = openssl_random_pseudo_bytes(32);
		$token = bin2hex($token);

		// Store the token in the database:
		$q = 'REPLACE INTO access_tokens (user_id, token, date_expires) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'is', $uid, $token);
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_affected_rows($stmt) > 0) {
			$url = 'https://' . BASE_URL . 'reset.php?t=' . $token;
			$body = "This email is in response to a forgotten password reset request at 'Knowledge is Power'. If you did make this request, click the following link to be able to access your account:
$url
For security purposes, you have 15 minutes to do this. If you do not click this link within 15 minutes, you'll need to request a password reset again.
If you have _not_ forgotten your password, you can safely ignore this message and you will still be able to login with your existing password. ";
			mail($email, 'Password Reset at Knowledge is Power', $body, 'FROM: ' . CONTACT_EMAIL);
			
			echo '<h1>Reset Your Password</h1><p>You will receive an access code via email. Click the link in that email to gain access to the site. Once you have done that, you may then change your password.</p>';
			include('./includes/footer.html');
			exit(); // Stop the script.

		} else { // If it did not run OK.

			trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

		}

	} // End of empty($pass_errors) IF.

} // End of the main Submit conditional.

// Need the form functions script, which defines create_form_input():
// The file may already have been included by the header.
require_once('./includes/form_functions.inc.php');
?><h1>Reset Your Password</h1>
<p>Enter your email address below to reset your password.</p> 
<form action="forgot_password.php" method="post" accept-charset="utf-8">
	<?php create_form_input('email', 'text', 'Email Address', $pass_errors); ?>
	<input type="submit" name="submit_button" value="Reset &rarr;" id="submit_button" class="btn btn-default" />
</form>

<?php // Include the HTML footer:
include('./includes/footer.html');
?>