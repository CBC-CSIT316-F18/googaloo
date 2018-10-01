<?php

// This file is the home page. 
// This script is begun in Chapter 3.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// To test the sidebars:
// $_SESSION['user_id'] = 1;
// $_SESSION['user_admin'] = true;

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
?><h3>Welcome</h3>
<p>Welcome to Knowledge is Power, a site dedicated to keeping you up to date on the Web security and programming information you need to know. Blah, blah, blah. Yadda, yadda, yadda.</p>

<?php // Bonus material! Referenced in Chapter 5.
// Display the most popular pages:
echo '<h3>Most Popular Pages</h3><p>';

$q = "SELECT COUNT(history.id) AS num, pages.id, pages.title FROM pages, history WHERE pages.id=history.item_id AND history.type='page' GROUP BY (history.item_id) ORDER BY num DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
$n = 1; // Counter
while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
	
	// Display each record:
	echo "<h4>$n. <a href=\"page.php?id=$row[1]\">$row[2]</a></h4>\n";
	
	// Increment the counter:
	$n++;

} // End of WHILE loop.
echo '</p>';
?>

<?php // Bonus material! Referenced in Chapter 5.
// Display the highest rated pages:
echo '<h3>Highest Rated Pages</h3><p>';

$q = "SELECT ROUND(AVG(rating),1) AS average, pages.id, pages.title FROM pages, page_ratings WHERE pages.id=page_ratings.page_id GROUP BY (page_ratings.page_id) ORDER BY average DESC LIMIT 10";
$r = mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {

	// Display each record:
	echo "<h4>$row[0] <a href=\"page.php?id=$row[1]\">$row[2]</a></h4>\n";

} // End of WHILE loop.
echo '</p>';
?>

<h3>Lorem Ipsum</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur volutpat nunc, eget vulputate quam tristique sit amet. Donec suscipit mollis erat in egestas. Morbi id risus quam. Sed vitae erat eu tortor tempus consequat. Morbi quam massa, viverra sed ullamcorper sit amet, ultrices ullamcorper eros. Mauris ultricies rhoncus leo, ac vehicula sem condimentum vel. Morbi varius rutrum laoreet. Maecenas vitae turpis turpis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce leo turpis, faucibus et consequat eget, adipiscing ut turpis. Donec lacinia sodales nulla nec pellentesque. Fusce fringilla dictum purus in imperdiet. Vivamus at nulla diam, sagittis rutrum diam. Integer porta imperdiet euismod.</p>

<?php /* PAGE CONTENT ENDS HERE! */

// Include the footer file to complete the template:
require('./includes/footer.html');
?>