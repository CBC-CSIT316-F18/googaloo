<?php
//session_start();
//setcookie(session_name(), '', 100);
//session_unset();
//session_destroy();
//$_SESSION = [];

define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");
// print DIR_ROOT;
include "src/srcIndex.php";


printheader();
printMenuBar("Menu Bar. (Nevermind the colors, they are there just to show the bounding boxes)");
printLeftPanel();
printCenterPanel();
printRightPanel();
printfooter();