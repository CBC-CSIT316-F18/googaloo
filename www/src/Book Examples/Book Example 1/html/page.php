<?php

// This page displays a specific page of HTML content.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

$_SESSION['user_id'] =12;
$_SESSION['user_not_expired'] = true;

// Validate the category ID:
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	$page_id = $_GET['id'];

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $page_id;
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) !== 1) { // Problem!
		$page_title = 'Error!';
		include('./includes/header.html');
		echo '<div class="alert alert-danger">This page has been accessed in error.</div>';
		include('./includes/footer.html');
		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];
	include('includes/header.html');
	echo '<h1>' . htmlspecialchars($page_title) . '</h1>';
	
	// Display the content if the user's account is current:
	if (isset($_SESSION['user_not_expired'])) {

		$user_id = $_SESSION['user_id'];
		
		// Bonus material! Referenced in Chapter 12.
		// Create add to favorites and remove from favorites links:
		// See if this is favorite:
		$q = 'SELECT user_id FROM favorite_pages WHERE user_id=' . $user_id . ' AND page_id=' . $page_id;
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) === 1) {
			echo '<h3 id="favorite_h3"><img src="images/heart_32.png" width="32" height="32"> <span class="label label-info">This is a favorite!</span> <a id="remove_favorite_link" href="remove_from_favorites.php?id=' . $page_id . '"><img src="images/close_32.png" width="32" height="32"></a></h3>';
		} else {
			echo '<h3 id="favorite_h3"><span class="label label-info">Make this a favorite!</span> <a id="add_favorite_link" href="add_to_favorites.php?id=' . $page_id . '"><img src="images/heart_32.png" width="32" height="32"></a></h3>';
		}

		// Show the page content:
		echo "<div>{$row['content']}</div>";
		
		// Bonus material! Referenced in Chapter 12.
		// Record this visit to the history table:
/*		$q = "INSERT INTO history (user_id, type, page_id) VALUES ({$_SESSION['user_id']}, 'page', $page_id)";
		$r = mysqli_query($dbc, $q);
*/		

		// Bonus material! Referenced in Chapter 12.
		// Allow the user to take notes:
		
		// Check for a form submission:
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (isset($_POST['notes']) && !empty($_POST['notes'])) {
				$notes = $_POST['notes'];

				$q = "REPLACE INTO notes (user_id, page_id, note) VALUES ($user_id, $page_id, '" . escape_data($notes, $dbc) . "')";
				$r = mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) > 0) {
					echo '<div class="alert alert-success">Your notes have been saved.</div>';
				}
			}
		}

		// Get the existing notes, if any:
		if (!isset($notes)) {
			$q = "SELECT note FROM notes WHERE user_id=$user_id AND page_id=$page_id";
			$r = mysqli_query($dbc, $q);
			if (mysqli_num_rows($r) === 1) {
				list($notes) = mysqli_fetch_array($r, MYSQLI_NUM);
			}
		}

		echo '<form id="notes_form" action="page.php?id=' . $page_id . '" method="post" accept-charset="utf-8">
	<fieldset><legend>Your Notes</legend>
	<textarea name="notes" id="notes" class="form-control">';

	if (isset($notes) && !empty($notes)) echo htmlspecialchars($notes);

	echo '</textarea><br>
	<input type="submit" name="submit_button" value="Save" id="submit_button" class="btn btn-default" />
	</fieldset>
</form>';

	} elseif (isset($_SESSION['user_id'])) { // Logged in but not current.
		echo '<div class="alert"><h4>Expired Account</h4>Thank you for your interest in this content, but your account is no longer current. Please <a href="renew.php">renew your account</a> in order to view this page in its entirety.</div>';
		echo '<div>' . htmlspecialchars($row['description']) . '</div>';
	} else { // Not logged in.
		echo '<div class="alert">Thank you for your interest in this content. You must be logged in as a registered user to view this page in its entirety.</div>';
		echo '<div>' . htmlspecialchars($row['description']) . '</div>';
	}

} else { // No valid ID.
	$page_title = 'Error!';
	include('includes/header.html');
	echo '<div class="alert alert-danger">This page has been accessed in error.</div>';
} // End of primary IF.

// Add the JavaScript:
// Added in Chapter 14.
echo '<script type="text/javascript">  
var page_id = ' . $page_id . ';
</script>
<script src="js/favorite.js"></script>
<script src="js/notes.js"></script>';

// Include the HTML footer:
include('./includes/footer.html');
?>