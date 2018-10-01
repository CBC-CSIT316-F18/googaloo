<?php

// The user comes to this page after completing their PayPal transaction (in theory).
// This script is created in Chapter 6.
// Four lines are used in an earlier version but commented out later.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user hasn't just registered, redirect them:
//redirect_invalid_user('reg_user_id');
// Above line commented out in later version of this script.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Thanks!';
include('./includes/header.html');

// Update the users table:
//if (isset($_SESSION['reg_user_id']) && filter_var($_SESSION['reg_user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
// $q = "UPDATE users SET date_expires = ADDDATE(date_expires, INTERVAL 1 YEAR) WHERE id={$_SESSION['reg_user_id']}";
// $r = mysqli_query($dbc, $q);
//}
// Above lines commented out in later version of this script.

// Unset the session var:
//unset($_SESSION['reg_user_id']);
// Above line commented out in later version of this script.

// Confirm the order with PayPal...
// Added in Chapter 12.
include('./includes/pdt.php');
?><h1>Thank You!</h1>
<p>Thank you for your payment! You may now access all of the site's content for the next year! <strong>Note: Your access to the site will automatically be renewed via PayPal each year. To disable this feature, or to cancel your account, see the "My preapproved purchases" section of your PayPal Profile page.</strong></p>

<h2>Lorem Ipsum</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur volutpat nunc, eget vulputate quam tristique sit amet. Donec suscipit mollis erat in egestas. Morbi id risus quam. Sed vitae erat eu tortor tempus consequat. Morbi quam massa, viverra sed ullamcorper sit amet, ultrices ullamcorper eros. Mauris ultricies rhoncus leo, ac vehicula sem condimentum vel. Morbi varius rutrum laoreet. Maecenas vitae turpis turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce leo turpis, faucibus et consequat eget, adipiscing ut turpis. Donec lacinia sodales nulla nec pellentesque. Fusce fringilla dictum purus in imperdiet. Vivamus at nulla diam, sagittis rutrum diam. Integer porta imperdiet euismod.</p>

<?php // Include the HTML footer:
include('./includes/footer.html');
?>