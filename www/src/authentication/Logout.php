<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/13/2018
 * Time: 8:21 PM
 */

namespace src\authentication;



class Logout
{
    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['ThisSessionWillFadeLikeTearsInTheRain'])) {
            setcookie(session_name(), '', 100);
            session_unset();
            session_destroy();
            $_SESSION = [];
        }
    }
}