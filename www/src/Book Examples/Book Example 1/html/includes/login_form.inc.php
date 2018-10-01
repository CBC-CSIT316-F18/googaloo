<?php

// This script displays the login form.
// This script is included by header.html, if the user isn't logged in.
// This script is created in Chapter 4.

// Create an empty error array if it doesn't already exist:
if (!isset($login_errors)) $login_errors = array();

// Need the form functions script, which defines create_form_input():
require('./includes/form_functions.inc.php');
?>
<form action="index.php" method="post" accept-charset="utf-8">
	<fieldset>
		<legend>Login</legend>
		<?php 
		if (array_key_exists('login', $login_errors)) {
			echo '<div class="alert alert-danger">' . $login_errors['login'] . '</div>';
		}
		create_form_input('email', 'email', '', $login_errors, array('placeholder'=>'Email address')); 
		create_form_input('pass', 'password', '', $login_errors, array('placeholder'=>'Password')); 
		echo '<span class="help-block"><a href="forgot_password.php">Forgot?</a></span>';
		?>
	<button type="submit" class="btn btn-default">Login &rarr;</button>
	</fieldset>
</form>			