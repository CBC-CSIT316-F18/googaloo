<?php

// This page is used by an administrator to create a specific page of HTML content.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');

// If the user isn't logged in as an administrator, redirect them:
redirect_invalid_user('user_admin');

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Add a Site Content Page';
include('./includes/header.html');

// For storing errors:
$add_page_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {	
	
	// Check for a title:
	if (!empty($_POST['title'])) {
		$t = escape_data(strip_tags($_POST['title']), $dbc);
	} else {
		$add_page_errors['title'] = 'Please enter the title!';
	}
	
	// Check for a category:
	if (filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$cat = $_POST['category'];
	} else { // No category selected.
		$add_page_errors['category'] = 'Please select a category!';
	}

	// Check for a description:
	if (!empty($_POST['description'])) {
		$d = escape_data(strip_tags($_POST['description']), $dbc);
	} else {
		$add_page_errors['description'] = 'Please enter the description!';
	}
		
	// Check for the content:
	if (!empty($_POST['content'])) {
		$allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote>';
		$c = escape_data(strip_tags($_POST['content'], $allowed), $dbc);
	} else {
		$add_page_errors['content'] = 'Please enter the content!';
	}
		
	if (empty($add_page_errors)) { // If everything's OK.

		// Add the page to the database:
		$q = "INSERT INTO pages (categories_id, title, description, content) VALUES ($cat, '$t', '$d', '$c')";
		$r = mysqli_query($dbc, $q);

		if (mysqli_affected_rows($dbc) === 1) { // If it ran OK.
	
			// Print a message:
			echo '<div class="alert alert-success"><h3>The page has been added!</h3></div>';
			
			// Clear $_POST:
			$_POST = array();
			
			// Send an email to the administrator to let them know new content was added?
			
		} else { // If it did not run OK.
			trigger_error('The page could not be added due to a system error. We apologize for any inconvenience.');
		}
		
	} // End of $add_page_errors IF.
	
} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
require('includes/form_functions.inc.php');
?>
<h1>Add a Site Content Page</h1>
<form action="add_page.php" method="post" accept-charset="utf-8">

	<fieldset><legend>Fill out the form to add a page of content:</legend>
<div class="form-group">
<label for="status" class="control-label">Status</label>
<select name="status" class="form-control"><option value="draft">Draft</option>
<option value="live">Live</option>
</select></div>

<?php
create_form_input('title', 'text', 'Title', $add_page_errors); 

// Add the category drop down menu:
echo '<div class="form-group';
if (array_key_exists('category', $add_page_errors)) echo ' has-error'; 

/*
echo '"><label for="category" class="control-label">Category</label>
<select name="category" class="form-control">
<option>Select One</option>';
*/

// Bonus material!
// Added in Chapter 12.
// Allow for multiple categories:
echo '"><label for="category" class="control-label">Category</label>
<select name="category[]" class="form-control" multiple size="5">';

// Retrieve all the categories and add to the pull-down menu:
$q = "SELECT id, category FROM categories ORDER BY category ASC";
$r = mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
	echo "<option value=\"$row[0]\"";
	// Check for stickyness:
	if (isset($_POST['category']) && ($_POST['category'] == $row[0]) ) echo ' selected="selected"';
	echo ">$row[1]</option>\n";
}

echo '</select>';
if (array_key_exists('category', $add_page_errors)) echo '<span class="help-block">' . $add_page_errors['category'] . '</span>';
echo '</div>';

create_form_input('description', 'textarea', 'Description', $add_page_errors); 
create_form_input('content', 'textarea', 'Content', $add_page_errors); 
?>
		
		<input type="submit" name="submit_button" value="Add This Page" id="submit_button" class="btn btn-default" />
	
	</fieldset>

</form> 

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		selector : "#content",
		width : 800,
		height : 400,
		browser_spellcheck : true,
		
		plugins: "paste,searchreplace,fullscreen,hr,link,anchor,image,charmap,media,autoresize,autosave,contextmenu,wordcount",

		toolbar1: "cut,copy,paste,|,undo,redo,removeformat,|hr,|,link,unlink,anchor,image,|,charmap,media,|,search,replace,|,fullscreen",
		toolbar2:	"bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignjustify,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,",

		// Example content CSS (should be your site CSS)
		content_css : "/ex1/html/css/bootstrap.min.css",

	});
</script>
<!-- /TinyMCE -->

<?php /* PAGE CONTENT ENDS HERE! */

// Include the footer file to complete the template:
include('./includes/footer.html');
?>