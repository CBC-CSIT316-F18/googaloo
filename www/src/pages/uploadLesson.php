<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 11/23/2018
 * Time: 11:56 PM
 */


define("DIR_ROOT",preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/googaloo/www/");

include DIR_ROOT . "src/srcIndex.php";
use src\util\io\UploadFile\UploadFile;
use src\util\html\ElementBuilder\ElementBuilder;


printheader();
printMenuBar("Menu Bar");
printLeftPanel();
print("<link rel=\"stylesheet\" type=\"text/css\" href=\"/googaloo/www/styles/uploadLesson.css\">");

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


/** @var bool $goodToGo */
$goodToGo = true;

$fileIdnetifier = "lesson";

$values = [
    "name" => '',
    "description" => '',
];

if (isset($_POST['name'])) {
    $values['name'] = addslashes($_POST['name']);
    $goodToGo &= true;
} else {
    $goodToGo &= false;
}

if (!empty($_POST['description'])) {
    $values['description'] = addslashes($_POST['description']);
    $goodToGo &= true;
} else {
    $goodToGo &= false;
}

if (isset($_FILES['lesson'])) {
    $goodToGo &= true;
} else {
    $goodToGo &= false;
}

if($goodToGo){
    new UploadFile($fileIdnetifier, $_POST['name'], $_POST['description']);
} else {

    $placeHolder = "Input Valid Value";

    print(<<<HTML
<h2>Enter the information for the bug report</h2>
<div><p>Please provide all required fields</p></div>
<form method="POST" enctype="multipart/form-data">
<p>Name <input required="true" type="text" name="name" value="{$values['name']}" placeholder="$placeHolder"/></p>
<p>Description <input required="true" type="text" name="description" value="{$values['description']}" placeholder="$placeHolder"/></p>
<p>Photo <input required="true" type="file" name="$fileIdnetifier" accept=".pdf"/></p>
<p><input type="submit" value="Submit" /></p>
HTML
    );
}
 $bodySpacer->buildCloseOpenTag();
 $ourBodyBuilder->buildCloseOpenTag();


printRightPanel();
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
