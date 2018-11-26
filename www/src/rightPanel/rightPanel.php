<?php

use src\util\html\ElementBuilder\ElementBuilder;
use src\util\DTOs\LessonDTO\LessonDTO;
use src\util\database\GetLessons\GetLessons;

function printRightPanel()
{
    /** @var ElementBuilder $leftPanel */
    $rightPanel = ElementBuilder::create("div")
        ->withAttribute("id", "rightPanel")
        ->buildLeaveTagOpen();



    $lessons = GetLessons::getLessons();
    $downloadHref = HREF_ROOT . "src/pages/download.php?id=";

    /** @var LessonDTO $lesson */
    foreach ($lessons as $lesson) {
        $id = $lesson->getId();
        ElementBuilder::create("div")
            ->withAttribute("class", "rightPanelItem")
            /*  Set the click event so that the div will trigger the click of its link  */
            ->withAttribute("onClick", 'document.querySelector(".rightPanelItem a.rightPanelLink' . $id . '").click();')
            ->withAttribute("title", $lesson->getFiledescription())
            /*  add a link to the lesson's download  */
            ->withTextContent("<a class='rightPanelLink$id' href='${downloadHref}${id}'>" . $lesson->getTitle() . "</a>")
            ->buildCompleteTagWithTextContent();
    }





    $rightPanel->buildCloseOpenTag();
}