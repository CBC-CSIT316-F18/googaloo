<?php

include ('./includes/header.html');
include ('./includes/leftsidebar.html');
?>
<div id="content">
    <?php
    include ('./includes/slider.html');
    ?>
<br>
<br>
<?php
// Need the form functions script, which defines create_form_input():
// The file may already have been included by the header.
include ('./includes/config.inc.php');
require_once('./includes/form_functions.inc.php');
include ('./admin/db_tools.php');
$done=false;
 //Include the header file:
$page_title = 'Register';
// For storing registration errors:

$reg_errors = array();
// Check for a form submission:
$db=new db_tools;
//$dbc=$db->db_connect();
$dbc=$db->db_connect();         
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    // Check for a first name:
    if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['first_name'])) 
    {
        $fn = escape_data($_POST['first_name'], $dbc);
    } else 
    {
        $reg_errors['first_name'] = 'Please enter your first name';
    }

    // Check for a last name:
    if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['last_name'])) 
    {
        $ln = escape_data($_POST['last_name'], $dbc);
    } else 
    {
        $reg_errors['last_name'] = 'Please enter your last name';
    }

    // Check for a username:
    if (preg_match('/^[A-Z0-9]{2,45}$/i', $_POST['username'])) 
    {
        $u = escape_data($_POST['username'], $dbc);
    } 
    else 
    {
        $reg_errors['username'] = 'Please enter a desired name using only letters and numbers!';
    }

    // Check for an email address:
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) 
    {
        $e = escape_data($_POST['email'], $dbc);
    } 
    else 
    {
        $reg_errors['email'] = 'Please enter a valid email address';
    }
    // Check for a password and match against the confirmed password:
    if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['pass1']) ) 
    {
        if ($_POST['pass1'] === $_POST['pass2'])
        {
            $p = $_POST['pass1'];
        } 
        else 
        {
            $reg_errors['pass2'] = 'Your password did not match the confirmed password';
        }
    } 
    else 
    {
        $reg_errors['pass1'] = 'Please enter a valid password';
    }

	if (empty($reg_errors)) 
        { // If everything's OK...
		// Make sure the email address and username are available:
	    $sql = "SELECT username,email FROM cuser WHERE username='$u' OR email='$e'";
            $dbc=$db->db_connect();
            $rows=$db->db_select($sql);
            $ilength = count($rows);
            
		if ($ilength === 0) { // No problems!
			
                    // Add the user to the database...
                    // Include the password_compat library, if necessary:
                    // include('./includes/lib/password.php');
                    $q="INSERT INTO cuser(`first_name`, `last_name`, `username`, `auth`, `type`,`email`) VALUES ('$fn','$ln','$u', '"  .  password_hash($p, PASSWORD_BCRYPT) .  "','member','$e')";
                    $r = $db->db_query($q);
                    if ($r) { // If it ran OK.

                            // Get the user ID:
                            // Store the new user ID in the session:
                            // Added in Chapter 6:
                            $uid = mysqli_insert_id($db->connection);
//				$_SESSION['reg_user_id']  = $uid;		

                            // Display a thanks message...
                            echo '<div id="content">';
                            echo '<div id="alert-success"><h3>Thanks!</h3><p>Thank you for registering! To complete the process activate registration, an email has been sent.</p></div>';
            
                            echo '</div>';
                            $done=true;

                            // Send a separate email?
                            $body = "Thank you for registering at custom cloud.\n\nclick here to activate your registration.";
                            //mail($_POST['email'], 'Registration Confirmation', $body, 'From: noreply@centcloud.com');                       
                           
                           
                    } 
                    else 
                    { // If it did not run OK.
                            trigger_error('You could not be registered due to a system error. We apologize for any inconvenience. We will correct the error ASAP.');
                    }

            } 
            else 
            { // The email address or username is not available.
                if ($ilength === 2) 
                { // Both are taken.

                        $reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';			
                        $reg_errors['username'] = 'This username has already been registered. Please try another.';			
                } 
                else 
                { // One or both may be taken.
                        // Get row:
                        
                        if( ($rows[0]['username'] === $_POST['username']) && ($rows[0]['email'] === $_POST['email'])) 
                        { // Both match.
                            $reg_errors['username'] = 'This username has already been registered with this email address. If you have forgotten your password, use the link at left to have your password sent to you.';         
                            $reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';	
                   
                        } 
                        elseif ($rows[0]['username'] === $_POST['username']) 
                        { // Email match.
                            $reg_errors['username'] = 'This username has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';						
                        } 
                        elseif ($rows[0]['email'] === $_POST['email']) 
                        { // Username match.
                            $reg_errors['email'] = 'This email address has already been registered. Please try another.';			
                        }
                } // End of $rows === 2 ELSE.
            } // End of $rows === 0 IF.		
	} // End of empty($reg_errors) IF.
} // End of the main form submission conditional.
 
if(!$done)
{
    echo'<form action='.htmlspecialchars($_SERVER['PHP_SELF']).' method="post" accept-charset="utf-8">';//prevents xss attack
    create_form_input('first_name', 'text', 'First Name', $reg_errors); 
    create_form_input('last_name', 'text', 'Last Name', $reg_errors); 
    create_form_input('username', 'text', 'Desired Username', $reg_errors); 
    echo '<div id="form_item_help">*Only letters and numbers are allowed.</div>';
    echo '<br>';
    echo '<br>';
    create_form_input('email', 'email', 'Email Address', $reg_errors); 
    create_form_input('pass1', 'password', 'Password', $reg_errors);
    echo '<div id="form_item_help">*Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</div>';

    create_form_input('pass2', 'password', 'Confirm Password', $reg_errors);
    echo'<input type="submit" name="submit_button" value="Next &rarr;" id="submit_button" class="btn-default" />';
    echo'</form>';
}
?>
   


</div><!--close content area-->
<?php
include ('./includes/rightsidebar.html');
include ('./includes/footer.html');    
?>
<!-- 
<div id="form_area"
<form action="register.php" method="post" accept-charset="utf-8">
<?php /*
create_form_input('first_name', 'text', 'First Name', $reg_errors); 
create_form_input('last_name', 'text', 'Last Name', $reg_errors); 
create_form_input('username', 'text', 'Desired Username', $reg_errors); 
echo '<div id="form_item_help">*Only letters and numbers are allowed.</div>';
echo '<br>';
echo '<br>';
create_form_input('email', 'email', 'Email Address', $reg_errors); 
create_form_input('pass1', 'password', 'Password', $reg_errors);
create_form_input('pass2', 'password', 'Confirm Password', $reg_errors); 
echo '<div id="form_item_help">*Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</div>';
*/?>
<input type="button" name="submit_button" value="Next &rarr;" id="submit_button" class="btn-default" />
</form>
</div><!--close form area-->