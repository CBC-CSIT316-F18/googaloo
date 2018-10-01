<?php

// This is the adminstrative home page.
// This script is created in Chapter 11.

// Require the configuration before any PHP code as configuration controls error reporting.
require('../includes/config.inc.php');

// Set the page title and include the header:
$page_title = 'Coffee - Administration';
include('./includes/header.html');
// The header file begins the session.
?>

<h3>Links</h3>
<ul>
<li><a href="add_specific_coffees.php">Add Coffee Products</a></li>
<li><a href="add_other_products.php">Add Non-Coffee Products</a></li>
<li><a href="add_inventory.php">Add Inventory</a></li>
</ul>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dapibus, felis at hendrerit commodo, nisl risus gravida quam, vel consequat leo quam suscipit purus. Proin purus justo, ornare vitae luctus sit amet, placerat quis dolor. Cras sit amet erat id quam posuere bibendum vitae non orci. Phasellus lacus sem, egestas sit amet scelerisque sit amet, venenatis ut elit. Maecenas diam nisi, tempor eu vestibulum placerat, varius in massa. Aenean scelerisque neque vel mi porta accumsan. Pellentesque euismod ipsum nec dui blandit at facilisis felis commodo. Suspendisse egestas mi et magna venenatis aliquam. Integer scelerisque ligula et dolor pulvinar dignissim. Ut interdum fringilla dignissim. Mauris eu fringilla felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas in ipsum dui, at gravida elit. Donec tincidunt scelerisque faucibus. Vivamus eget metus lectus. Aliquam erat volutpat.</p>

<?php include('./includes/footer.html'); ?>