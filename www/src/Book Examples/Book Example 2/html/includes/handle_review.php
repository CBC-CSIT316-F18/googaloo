<?php

// This script handles the review form.
// This script is included by browse.php

// For storing errors:
$review_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Check for a name:
	if (preg_match ('/^[A-Z \'.-]{2,60}$/i', $_POST['name'])) {
		$name  = $_POST['name'];
	} else {
		$review_errors['name'] = 'Please enter your name!';
	}

	// Check for an email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email = $_POST['email'];
	} else {
		$review_errors['email'] = 'Please enter a valid email address!';
	}

	// Check for the review:
	$review = strip_tags($_POST['review']);
	if (empty($review)) {
		$review_errors['review'] = 'Please enter your review!';
	}

	if (empty($review_errors)) { // If everything's OK...
	
		// Add the review to the database...
		
		// Call the stored procedure:
		$r = mysqli_query($dbc, "CALL add_review('$type', $sp_cat, '$name', '$email', '$review')");
		//if (!$r) echo mysqli_error($dbc);

		// Confirm that it worked:
		if (mysqli_affected_rows($dbc) > 0) {

			$message = 'Thank you for your review!';

		}

		$_POST = array();

	} // Errors occurred IF.

}