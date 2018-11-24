<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 10/3/2018
 * Time: 9:56 PM
 */

/* set this so login will be bypassed. */
$_SESSION['loginNotNeeded'] = true;

define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");

include DIR_ROOT . "src/srcIndex.php";
use src\util\database\register\Register;
use src\util\html\ElementBuilder\ElementBuilder;

/** @var Register $register */
$register = new Register();

printheader();
print("<link rel=\"stylesheet\" type=\"text/css\" href=\"/googaloo/www/styles/newRegister.css\">");

    /** @var ElementBuilder $ourBodyBuilder */
$ourBodyBuilder = ElementBuilder::create("div")
    ->withAttribute("class", "newRegisterContainer")
    /* Only start the tag, leave it open for children to be added to it  */
    ->buildLeaveTagOpen();

$register->setupRegistration();

$ourBodyBuilder->buildCloseOpenTag();

printfooter();


// Saving for later, in case we want an admin page for registering users.

// /** @var Register $register */
// $register = new Register();

// printheader();
// printMenuBar("Menu Bar. (Nevermind the colors, they are there just to show the bounding boxes)");
// printLeftPanel();

// /**  @var ElementBuilder $ourBodyBuilder */
// $ourBodyBuilder = ElementBuilder::create("div")
//     ->withAttribute("id", "centerpanel")
//     ->withAttribute("class", "app")
//     /* Only start the tag, leave it open for children to be added to it  */
//     ->buildLeaveTagOpen();

//     /** @var ElementBuilder $bodySpacer */
// $bodySpacer = ElementBuilder::create("div")
//     ->withAttribute("class", "centerPanelSpacer")
//     /* Only start the tag, leave it open for children to be added to it  */
//     ->buildLeaveTagOpen();

// $register->setupRegistration();

// $bodySpacer->buildCloseOpenTag();
// $ourBodyBuilder->buildCloseOpenTag();

// printRightPanel();
// printfooter();
