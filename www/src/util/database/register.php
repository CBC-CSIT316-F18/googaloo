<?php

namespace src\util\database\register;

use src\util\database\InsertQueryBuilder\InsertQueryBuilder;
use src\util\html\FormInput\FormInput;
use src\util\database\db_tools\db_tools;

// This is the registration page for the site.
// This file both displays and processes the registration form.
// This script is begun in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
//require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
//require(MYSQL);

// Include the header file:
//$page_title = 'Register';
//include('./includes/header.html');

class Register
{
    // For storing registration errors:
    /** @var array $reg_errors */
    public $reg_errors = array();

    public $connection = null;
    /** @var db_tools $dbTools */
    public $dbTools = null;
    /** @var string $email */
    public $email = "";
    /** @var string $userName */
    public $userName = "";
    /** @var string $firstName */
    public $firstName = "";
    /** @var string $lastName */
    public $lastName = "";
    /** @var string $password */
    public $password = "";

    public function setupRegistration()
    {
        $this->dbTools = new db_tools();
        $this->connection = $this->dbTools->db_connect();
        // Check for a form submission:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post();
        } else {
            $this->alwaysAndForever();
        }
    }

    private function post()
    {
        $this->checkInputs();
        if (empty($this->reg_errors)) {
            $this->add();
        } else {
            $this->alwaysAndForever();
        }
    }

    private function add()
    { // If everything's OK...

        // Make sure the email address and username are available:
        /** @var string $q */
        $q = "SELECT email, username FROM users WHERE email='$this->email' OR username='$this->userName'";
        /** @var mysqli_result|bool $r */
        $r = mysqli_query($this->connection, $q);

        // Get the number of rows returned:
        /** @var int $rows */
        $rows = mysqli_num_rows($r);

        if ($rows === 0) { // No problems!
            $this->handleResponseRegister();
        } else { // The email address or username is not available.
            if ($rows === 2) { // Both are taken.
                $this->handleResponseUserNameEmailTaken();
            } else { // One or both may be taken.
                $this->handleResponseSomethingTaken($r);
            } // End of $rows === 2 ELSE.
            $this->alwaysAndForever();
        }
    }

    private function handleResponseUserNameEmailTaken()
    {
        $this->reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';
        $this->reg_errors['username'] = 'This username has already been registered. Please try another.';
    }

    private function handleResponseSomethingTaken($r)
    {
        // Get row:
        /** @var array|null $row */
        $row = mysqli_fetch_array($r, MYSQLI_NUM);

        if (($row[0] === $_POST['email']) && ($row[1] === $_POST['username'])) { // Both match.
            $this->reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';
            $this->reg_errors['username'] = 'This username has already been registered with this email address. If you have forgotten your password, use the link at left to have your password sent to you.';
        } elseif ($row[0] === $_POST['email']) { // Email match.
            $this->reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at left to have your password sent to you.';
        } elseif ($row[1] === $_POST['username']) { // Username match.
            $this->reg_errors['username'] = 'This username has already been registered. Please try another.';
        }
    }


    private function handleResponseRegister()
    {
        // Add the user to the database...

        // Include the password_compat library, if necessary:
        // include('./includes/lib/password.php');

        // Temporary: set expiration to a month!
        // Change after adding PayPal!
        // $q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  password_hash($p, PASSWORD_BCRYPT) .  "', '$fn', '$ln', ADDDATE(NOW(), INTERVAL 1 MONTH) )";

        // New query, updated in Chapter 6 for PayPal integration:
        // Sets expiration to yesterday:
//        $q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '" . password_hash($p, PASSWORD_BCRYPT) . "', '$fn', '$ln', SUBDATE(NOW(), INTERVAL 1 DAY) )";

        $q = (new InsertQueryBuilder())
            ->intoTable("users")
            ->withField("type", "0")
            ->withField("username", $this->userName)
            ->withField("email", $this->email)
            ->withField("pass", md5($this->password))
            ->withField("first_name", $this->firstName)
            ->withField("last_name", $this->lastName)
            ->withSpecialField("date_expires", "NULL")
            ->withSpecialField("date_created", "CURRENT_TIMESTAMP")
            ->withSpecialField("date_modified", "CURRENT_TIMESTAMP")
            ->build();

        /*
         *
         * `type`,
          `username`,
          `email`,
          `pass`,
          `first_name`,
          `last_name`,
          `date_expires`,
          `date_created`,
          `date_modified`
         */

        $r = mysqli_query($this->connection, $q);

        if (mysqli_affected_rows($this->connection) === 1) { // If it ran OK.

            // Get the user ID:
            // Store the new user ID in the session:
            // Added in Chapter 6:
            $uid = mysqli_insert_id($this->connection);
            $_SESSION['reg_user_id'] = $uid;

            // Display a thanks message...

//             Original message from Chapter 4:
            echo '<div class="alert alert-success"><h3>Thanks!</h3><p>Thank you for registering! You may now log in and access the site\'s content.</p></div>';

//            // Updated message in Chapter 6:
//            echo '<div class="alert alert-success"><h3>Thanks!</h3><p>Thank you for registering! To complete the process, please now click the button below so that you may pay for your site access via PayPal. The cost is $10 (US) per year. <strong>Note: When you complete your payment at PayPal, please click the button to return to this site.</strong></p></div>';

//            // PayPal link added in Chapter 6:
//            echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
//				<input type="hidden" name="cmd" value="_s-xclick">
//					<input type="hidden" name="email" value="' . $e . '">
//				<input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
//				<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
//				<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
//				</form>
//				';

            // Send a separate email?
            $body = "Thank you for registering at <whatever site>. Blah. Blah. Blah.\n\n";
//            mail($_POST['email'], 'Registration Confirmation', $body, 'From: admin@example.com');

            // Finish the page:
//            include('./includes/footer.html'); // Include the HTML footer.

        } else { // If it did not run OK.
            trigger_error('You could not be registered due to a system error. We apologize for any inconvenience. We will correct the error ASAP.');
            $this->alwaysAndForever();
        }

    }  // End of $rows === 0 IF.

    private function checkInputs()
    {
        // Check for a first name:
        if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['first_name'])) {
            $this->firstName = $this->dbTools->escape_data($_POST['first_name']);
        } else {
            $this->reg_errors['first_name'] = 'Please enter your first name!';
        }

        // Check for a last name:
        if (preg_match('/^[A-Z \'.-]{2,45}$/i', $_POST['last_name'])) {
            $this->lastName = $this->dbTools->escape_data($_POST['last_name']);
        } else {
            $this->reg_errors['last_name'] = 'Please enter your last name!';
        }

        // Check for a username:
        if (preg_match('/^[A-Z0-9]{2,45}$/i', $_POST['username'])) {
            $this->userName = $this->dbTools->escape_data($_POST['username']);
        } else {
            $this->reg_errors['username'] = 'Please enter a desired name using only letters and numbers!';
        }

        // Check for an email address:
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) {
            $this->email = $this->dbTools->escape_data($_POST['email']);
        } else {
            $this->reg_errors['email'] = 'Please enter a valid email address!';
        }

        // Check for a password and match against the confirmed password:
        if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['pass1'])) {
            if ($_POST['pass1'] === $_POST['pass2']) {
                $this->password = $_POST['pass1'];
            } else {
                $this->reg_errors['pass2'] = 'Your password did not match the confirmed password!';
            }
        } else {
            $this->reg_errors['pass1'] = 'Please enter a valid password!';
        }
    }

// Need the form functions script, which defines create_form_input():
// The file may already have been included by the header.
//require_once('./includes/form_functions.inc.php');
    function alwaysAndForever()
    {
        print(
        <<<EOD
<h1>Register</h1>
<p>Access to the site's content is available to registered users at a cost of $10.00 (US) per year. Use the form below to begin the registration process. <strong>Note: All fields are required.</strong> After completing this form, you'll be presented with the opportunity to securely pay for your yearly subscription via <a href="http://www.paypal.com">PayPal</a>.</p>
<form action="register.php" method="post" accept-charset="utf-8">
EOD
        );

        if (isset($this->reg_errors['first_name'])) {
            print("<div style='color: red'>{$this->reg_errors['first_name']}</div>");
        }
        new FormInput('first_name', 'text', 'First Name', ['placeholder' => 'first name']);

        if (isset($this->reg_errors['last_name'])) {
            print("<div style='color: red'>{$this->reg_errors['last_name']}</div>");
        }
        new FormInput('last_name', 'text', 'Last Name', ['placeholder' => 'last name']);

        if (isset($this->reg_errors['username'])) {
            print("<div style='color: red'>{$this->reg_errors['username']}</div>");
        }
        new FormInput('username', 'text', 'Desired Username', ['placeholder' => 'username']);

        echo '<span class="help-block">Only letters and numbers are allowed.</span>';
        if (isset($this->reg_errors['email'])) {
            print("<div style='color: red'>{$this->reg_errors['email']}</div>");
        }
        new FormInput('email', 'email', 'Email Address', ['placeholder' => 'email']);

        if (isset($this->reg_errors['pass1'])) {
            print("<div style='color: red'>{$this->reg_errors['pass1']}</div>");
        }
        new FormInput('pass1', 'password', 'Password', ['placeholder' => 'password']);

        echo '<span class="help-block">Must be at least 6 characters long, with at least one lowercase letter, one uppercase letter, and one number.</span>';
        if (isset($this->reg_errors['pass2'])) {
            print("<div style='color: red'>{$this->reg_errors['pass2']}</div>");

        }
        new FormInput('pass2', 'password', 'Confirm Password', ['placeholder' => 'password']);

        print(
        <<<EOD
<input type="submit" name="submit_button" value="Next &rarr;" id="submit_button" class="btn btn-default" />
</form>
<br>
EOD
        );
//        include('./includes/footer.html');
    }

}
