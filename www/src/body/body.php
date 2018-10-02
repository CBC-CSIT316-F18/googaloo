<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 9/27/2018
 * Time: 9:53 PM
 */
use src\util\html\ElementBuilder\ElementBuilder;
function printBody()
{

    /*  Fluent interfaces and builder classes for the win!  */
    /*  @var ElementBuilder */
    $ourBodyBuilder = ElementBuilder::create("div")
        ->withAttribute("class", "app")
        ->withTextContent("This is a test of the builder!!!")
        /* Oonly start the tag, leave it open for children to be added to it  */
        ->buildLeaveTagOpen()
        ->printTextContent();

    /*  No need to save this to a variable as it is only used here once.  */
    /*  @var ElementBuilder */
    ElementBuilder::create("div")
        ->withAttribute("class", "appChild")
        ->withTextContent("More Text Here")
        ->buildLeaveTagOpen()
        ->printTextContent()
        ->buildCloseOpenTag();

    /*  Now close the tag since we have added the child we wanted to add  */
    $ourBodyBuilder->buildCloseOpenTag();
}