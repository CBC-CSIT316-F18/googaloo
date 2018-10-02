<?php

// This page adds a review
// This script is created in Chapter 14.
// This script is used for an Ajax request.
// This script returns JSON data.

$review_errors = array();

if (filter_var($_POST['item'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	$item = $_POST['item'];
} else {
	$review_errors = 'No item ID was provided.';
}

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
	$r = mysqli_query($dbc, "CALL add_review('$type', $page_id, '$name', '$email', '$review')");

}

echo json_encode($review_errors);