<?php

/*  Start session if session has not already been started  */
if (!isset($_SESSION)) {
    session_start();
}

/*  classes  */
include 'util/database/db_tools.php';
include "util/database/InsertQueryBuilder.php";
include "util/database/SelectQueryBuilder.php";
include 'util/html/forminput.php';
include "util/html/ElementBuilder.php";
include "util/database/register.php";
include "authentication/Login.php";
include "authentication/Logout.php";

/*  functions  */
include "menuBar/menuBar.php";
include "header/header.php";
include "leftPanel/leftPanel.php";
include "centerPanel/centerPanel.php";
include "rightPanel/rightPanel.php";
include "footer/footer.php";


/*  Logout check  */
new src\authentication\Logout();
/*  Login check  */
new src\authentication\Login();
