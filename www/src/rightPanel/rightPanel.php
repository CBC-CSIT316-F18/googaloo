<?php

use src\util\html\ElementBuilder\ElementBuilder;
use src\util\DTOs\LessonDTO;
use src\util\database\GetLessons\GetLessons;

function printRightPanel()
{
    /** @var ElementBuilder $leftPanel */
    $rightPanel = ElementBuilder::create("div")
        ->withAttribute("id", "rightPanel")
        ->buildLeaveTagOpen();

    /*  No need to save this to a variable as it is only used here once.  */

    $lessons = GetLessons::getLessons();
    $downloadHref = HREF_ROOT . "src/pages/download.php?id=";

    foreach ($lessons as $lesson) {
        $id = $lesson->getId();
        ElementBuilder::create("div")
            ->withAttribute("class", "rightPanelItem")
            ->withAttribute("title", $lesson->getFiledescription())
            ->withTextContent("<a href='${downloadHref}${id}'>" . $lesson->getTitle() . "</a>")
            ->buildCompleteTagWithTextContent();
    }





    $rightPanel->buildCloseOpenTag();
}