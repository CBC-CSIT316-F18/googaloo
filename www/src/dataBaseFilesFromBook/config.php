<?php
/* 	*
	* Title: config.inc.php
	* Configuration file does the following things:
	* - Has site settings in one location.
	* - Stores URLs and URIs as constants.
	* - Starts the session.
	* - Sets how errors will be handled.
	* - Defines a redirection function.
*/
// ************ SETTINGS ************ //
// Are we live?
define('LIVE', false);
if (!defined('LIVE')) DEFINE('LIVE', true);

// Errors are emailed here:
DEFINE('CONTACT_EMAIL', 'beejosh@yahoo.com');

// ********************************** //
// ************ CONSTANTS *********** //
// Determine location of files and the URL of the site:
define('BASE_URI', 'c:\wamp\customcloud');
define('BASE_URL', 'http://localhost/customcloud/');
define('MYSQL', BASE_URI . '\admin\db_tools.php');
// For the complex HTML:
define('BOX_BEGIN', '<!-- box begin --><div class="box alt"><div class="left-top-corner"><div class="right-top-corner"><div class="border-top"></div></div></div><div class="border-left"><div class="border-right"><div class="inner">');
define('BOX_END', '</div></div></div><div class="left-bot-corner"><div class="right-bot-corner"><div class="border-bot"></div></div></div></div><!-- box end -->');
define ('CONFIG','c:\wamp\config.ini');
// For Authorize.net:
define('API_LOGIN_ID', '23hxJ9Gg');
define('TRANSACTION_KEY', '8EKf5a663gC3jqD2');
session_start();//start the session
// ************ CONSTANTS *********** //
// ********************************** //

// ****************************************** //
// ************ ERROR MANAGEMENT ************ //
// Function for handling errors.
// Takes five arguments: error number, error message (string), name of the file where the error occurred (string) 
// line number where the error occurred, and the variables that existed at the time (array).
// Returns true.
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Build the error message:
	$message = "An error occurred in script '$e_file' on line $e_line:\n$e_message\n";
	
	// Add the backtrace:
	$message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";
	
	// Or just append $e_vars to the message:
	//	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n";

	if (!LIVE) { // Show the error in the browser.
		
		echo '<div class="error">' . nl2br($message) . '</div>';

	} else { // Development (print the error).

		// Send the error in an email:
		error_log ($message, 1, CONTACT_EMAIL, 'From:admin@centcloud.com');
		
		// Only print an error message in the browser, if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div>';
		}

	} // End of $live IF-ELSE.
	
	return true; // So that PHP doesn't try to handle the error, too.

} // End of my_error_handler() definition.

// Use my error handler:
set_error_handler ('my_error_handler');
// ************ ERROR MANAGEMENT ************ //
// ****************************************** //
// This function redirects invalid users.
// It takes two arguments: 
// - The session element to check
// - The destination to where the user will be redirected. 
function redirect_invalid_user($check = 'user_id', $destination = 'index.php', $protocol = 'http://') {
	
	// Check for the session item:
	if (!isset($_SESSION[$check])) {
		$url = $protocol . BASE_URL . $destination; // Define the URL.
		header("Location: $url");
		exit(); // Quit the script.
	}
	
} // End of redirect_invalid_user() function.

// Omit the closing PHP tag to avoid 'headers already sent' errors!
function redirect($location)
{
    \header("Location: ".$location); /* Redirect browser */
/* Make sure that code below does not get executed when we redirect. */
exit;
}