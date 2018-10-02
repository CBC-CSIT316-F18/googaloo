<?php

// This page is used to renew an inactive account.
// Users must be logged in to access this page.
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Renew Your Account';
include('./includes/header.html');

?><h1>Thanks!</h1><p>Thank you for your interest in renewing your account! To complete the process, please now click the button below so that you may pay for your renewal via PayPal. The cost is $10 (US) per year. <strong>Note: After renewing your membership at PayPal, you must logout and log back in at this site in order process the renewal.</strong></p>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="custom" value="<?php echo $_SESSION['user_id']; ?>">
<input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
<input type="submit" name="submit_button" value="Renew &rarr;" id="submit_button" class="btn btn-default" />
</form>

<?php // Include the HTML footer:
include('./includes/footer.html');
?>