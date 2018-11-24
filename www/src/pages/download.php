<?php
/**
 * Created by PhpStorm.
 * User: Tycko Franklin
 * Date: 11/24/2018
 * Time: 1:24 PM
 */

use src\util\io\DownloadFile\DownloadFile;

define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");

include DIR_ROOT . "src/srcIndex.php";

new DownloadFile($_GET["id"]);
