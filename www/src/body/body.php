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

    $ourBodyBuilder = ElementBuilder::create("div")
        ->withAttribute("class", "app")
        ->withTextContent("This is a test of the builder!!!")
        ->buildLeaveTagOpen()
        ->printTextContent();


    $ourChildBodyBuilder = ElementBuilder::create("div")
        ->withAttribute("class", "appChild")
        ->withTextContent("More Text Here")
        ->buildLeaveTagOpen()
        ->printTextContent()
        ->buildCloseOpenTag();

    $ourBodyBuilder->buildCloseOpenTag();
}