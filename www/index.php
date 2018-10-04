<?php
define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");
// print DIR_ROOT;
include "src/srcIndex.php";


printheader();
printLeftPanel();
printCenterPanel();
printRightPanel();
printfooter();