<?php

use src\util\html\ElementBuilder\ElementBuilder;

function printLeftPanel()
{

    /** @var ElementBuilder $leftPanel */
    $leftPanel = ElementBuilder::create("div")
        ->withAttribute("id", "leftPanel")
        ->buildLeaveTagOpen();

    /*  No need to save this to a variable as it is only used here once.  */
    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("Profile")
        ->buildCompleteTagWithTextContent();

    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("My Lessons")
        ->buildCompleteTagWithTextContent();

    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("<a href='" . HREF_ROOT . "src/pages/uploadLesson.php'>Upload Lessons</a>")
        ->buildCompleteTagWithTextContent();

    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("All Lessons")
        ->buildCompleteTagWithTextContent();

    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("Search Lessons")
        ->buildCompleteTagWithTextContent();

    ElementBuilder::create("div")
        ->withAttribute("class", "leftPanelItem")
        ->withTextContent("Billing")
        ->buildCompleteTagWithTextContent();



    $leftPanel->buildCloseOpenTag();

}
