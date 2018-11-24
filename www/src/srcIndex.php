<?php
define("HREF_ROOT", "/googaloo/www/");
define("DATA_FOLDER", "C:/wamp64/data/");

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
include "util/authentication/Login.php";
include "util/authentication/Logout.php";
include "util/io/UploadFile.php";
include "util/DTOs/LessonDTO.php";
include "util/database/GetLessons.php";
include "util/io/DownloadFile.php";

/*  functions  */
include "menuBar/menuBar.php";
include "header/header.php";
include "leftPanel/leftPanel.php";
include "centerPanel/centerPanel.php";
include "rightPanel/rightPanel.php";
include "footer/footer.php";

if(!isset($_SESSION['loginNotNeeded'])){
    /*  Logout check  */
    new src\util\authentication\Logout();
    /*  Login check  */
    new src\util\authentication\Login();
}
