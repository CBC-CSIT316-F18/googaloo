<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/3/2018
 * Time: 9:56 PM
 */

define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");
include DIR_ROOT . "src/srcIndex.php";
use src\util\database\register\Register;
use src\util\html\ElementBuilder\ElementBuilder;

/** @var Register $register */
$register = new Register();

printheader();
printLeftPanel();

/**  @var ElementBuilder $ourBodyBuilder */
$ourBodyBuilder = ElementBuilder::create("div")
    ->withAttribute("id", "centerpanel")
    ->withAttribute("class", "app")
    /* Only start the tag, leave it open for children to be added to it  */
    ->buildLeaveTagOpen();

    /** @var ElementBuilder $bodySpacer */
$bodySpacer = ElementBuilder::create("div")
    ->withAttribute("class", "centerPanelSpacer")
    /* Only start the tag, leave it open for children to be added to it  */
    ->buildLeaveTagOpen();

$register->setupRegistration();

$bodySpacer->buildCloseOpenTag();
$ourBodyBuilder->buildCloseOpenTag();

printRightPanel();
printfooter();