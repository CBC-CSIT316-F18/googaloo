<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/13/2018
 * Time: 8:21 PM
 */

namespace src\util\authentication;

use src\util\database\SelectQueryBuilder\SelectQueryBuilder;
use src\util\database\db_tools\db_tools;


class Login
{
    /** @var string $password */
    private $password = "";
    /** @var string $emailOrUsername */
    private $emailOrUsername = "";
    /** @var db_tools $dbTools */
    private $dbTools = null;

    public function __construct()
    {
        if (!isset($_SESSION['userID'])) {
            if ($_SERVER['REQUEST_METHOD'] === "POST"
                && isset($_POST['loginForm'])
                && $_POST['loginForm'] === 'true') {
                $this->checkLogin();
            }
            if (!isset($_SESSION['userID'])) {
                $this->createLoginPageOnly();
            }
        }
    }

    private function createLoginPageOnly()
    {
        printheader();
        print(<<<FORMOUTPUT
<link rel="stylesheet" type="text/css" href="/googaloo/www/styles/login.css">
<div class="container">
    <h1 class="">Login Form</h1>
    <div class="login-form">
        <div class="">
            <div class="">
                <h2>Login</h2>
                <p>Please enter your email or username, and password</p>
            </div>
            <form id="Login" method="post" >

                <div class="">


                    <input type="text" class="" name="emailOrUsername" id="emailOrUsername" placeholder="Email or Username">

                </div>
                   <br>
                <div class="form-group">

                    <input type="password" class="" name="password" id="password" placeholder="Password">

                </div>
                   <br>
                   <input hidden="true" value="true" name="loginForm">
                <input type="submit" >

            </form>
        </div>
        <p class="botto-text"> CBC k-12 Charter</p>
    </div>
</div>
FORMOUTPUT
        );

        printfooter();
        exit();
    }

    private function checkLogin()
    {
        $this->dbTools = new db_tools();
        $dbc = $this->dbTools->db_connect();

//        if(!isset($_POST['password']) || !isset($_POST['emailOrUsername']))

        $this->password = $_POST['password'];
        $this->emailOrUsername = $this->dbTools->escape_data($_POST['emailOrUsername']);


        $q = (new SelectQueryBuilder())
            ->withFields("id, username, email, type, pass, IF(!isnull(date_expires) or date_expires <= NOW(), true, false) AS expired")
            ->fromTable("users")
            ->withWhere("username = '$this->emailOrUsername' or email = '$this->emailOrUsername'")
            ->build();

        $r = mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) === 1) { // A match was made.

            // Get the data:
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            // Validate the password:
            if (password_verify($this->password, $row['pass'])) { // Correct!

                // If the user is an administrator, create a new session ID to be safe:
                // This code is created at the end of Chapter 4:
                if ($row['type'] === '1') {
                    session_regenerate_id(true);
                    $_SESSION['userAdmin'] = true;
                }

                // Store the data in a session:
                $_SESSION['userID'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Only indicate if the user's account is not expired:
                if ($row['expired'] === 0) {
                    $_SESSION['user_not_expired'] = true;
                }

            } else { // Right email address, invalid password.
//                $login_errors['login'] = 'The email address and password do not match those on file.';
            }

        } else { // No match was made. (technically, only the email address failed)
//            $login_errors['login'] = 'The email address and password do not match those on file.';
        }
    }

}