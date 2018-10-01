<?php

// This file is the home page. 
// This script is begun in Chapter 3.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// To test the sidebars:
$_SESSION['user_id'] = 1;
$_SESSION['user_admin'] = true;
$_SESSION['user_not_expired'] = true;
//$_SESSION=array();

// Require the database connection:
require(MYSQL);

// Next block added in Chapter 4:
// If it's a POST request, handle the login attempt:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include('./includes/login.inc.php');
}

// Include the header file:
include('./includes/header.html');

/* PAGE CONTENT STARTS HERE! */
?><h1>Welcome</h1>
 <p class="lead">Welcome to Knowledge is Power, a site dedicated to keeping you up-to-date on the Web security and programming information you need to know. Blah, blah, blah. Yadda, yadda, yadda.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur volutpat nunc, eget vulputate quam tristique sit amet. Donec suscipit mollis erat in egestas. Morbi id risus quam. Sed vitae erat eu tortor tempus consequat. Morbi quam massa, viverra sed ullamcorper sit amet, ultrices ullamcorper eros. Mauris ultricies rhoncus leo, ac vehicula sem condimentum vel. Morbi varius rutrum laoreet. Maecenas vitae turpis turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce leo turpis, faucibus et consequat eget, adipiscing ut turpis. Donec lacinia sodales nulla nec pellentesque. Fusce fringilla dictum purus in imperdiet. Vivamus at nulla diam, sagittis rutrum diam. Integer porta imperdiet euismod.</p>

<h3>Lorem Ipsum</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur volutpat nunc, eget vulputate quam tristique sit amet. Donec suscipit mollis erat in egestas. Morbi id risus quam. Sed vitae erat eu tortor tempus consequat. Morbi quam massa, viverra sed ullamcorper sit amet, ultrices ullamcorper eros. Mauris ultricies rhoncus leo, ac vehicula sem condimentum vel. Morbi varius rutrum laoreet. Maecenas vitae turpis turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce leo turpis, faucibus et consequat eget, adipiscing ut turpis. Donec lacinia sodales nulla nec pellentesque. Fusce fringilla dictum purus in imperdiet. Vivamus at nulla diam, sagittis rutrum diam. Integer porta imperdiet euismod.</p>

<?php /* PAGE CONTENT ENDS HERE! */

// Include the footer file to complete the template:
include('./includes/footer.html');
?>