<?php

// The user comes to this page after canceling their PayPal transaction (in theory).
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Oops!';
include('./includes/header.html');

/* PAGE CONTENT STARTS HERE! */
?><h1>Oops!</h1>
<p>The payment through PayPal was not completed. You now have a valid membership at this site, but you will not be able to view any content until you complete the PayPal transaction. You can do so by clicking on the Renew link after logging in.</p>

<h2>Lorem Ipsum</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur volutpat nunc, eget vulputate quam tristique sit amet. Donec suscipit mollis erat in egestas. Morbi id risus quam. Sed vitae erat eu tortor tempus consequat. Morbi quam massa, viverra sed ullamcorper sit amet, ultrices ullamcorper eros. Mauris ultricies rhoncus leo, ac vehicula sem condimentum vel. Morbi varius rutrum laoreet. Maecenas vitae turpis turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce leo turpis, faucibus et consequat eget, adipiscing ut turpis. Donec lacinia sodales nulla nec pellentesque. Fusce fringilla dictum purus in imperdiet. Vivamus at nulla diam, sagittis rutrum diam. Integer porta imperdiet euismod.</p>

<?php // Include the HTML footer:
include('./includes/footer.html');
?>