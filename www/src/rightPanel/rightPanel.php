<?php

use src\util\html\ElementBuilder\ElementBuilder;

function printRightPanel()
{
    /** @var ElementBuilder $leftPanel */
    $rightPanel = ElementBuilder::create("div")
        ->withAttribute("id", "rightPanel")
        ->buildLeaveTagOpen();

    /*  No need to save this to a variable as it is only used here once.  */

    for ($i = 1; $i < 16; $i++) {
        ElementBuilder::create("div")
            ->withAttribute("class", "rightPanelItem")
            ->withTextContent("Latest Lesson ($i)")
            ->buildCompleteTagWithTextContent();
    }





    $rightPanel->buildCloseOpenTag();
}