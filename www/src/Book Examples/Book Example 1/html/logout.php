<?php

// This is the logout page for the site.
// This script is created in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Destroy the session:
$_SESSION = array(); // Destroy the variables.
session_destroy(); // Destroy the session itself.
setcookie (session_name(), '', time()-300); // Destroy the cookie.

// Header file needs the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Logout';
include('./includes/header.html');

// Print a customized message:
echo '<h1>Logged Out</h1><p>Thank you for visiting. You are now logged out. Please come back soon!</p>';

// Include the HTML footer:
include('./includes/footer.html');
?>