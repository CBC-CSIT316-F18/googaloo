<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 9/19/2018
 * Time: 11:10 PM
 */
use src\util\html\ElementBuilder\ElementBuilder;
/**
 * @param $menuTitle string
 */
function printMenuBar($menuTitle){
    // put in some dummy data
    $menuItems = [
        [
            'href' => '/googaloo/www/index.php',
            'name' => 'Home',
        ],
    ];

    /*  start the menu bar  */
    print('<div class="mainMenu" id="topPanel">');

    $login =

    ElementBuilder::create("div")
        ->withAttribute("class", "menuLogout")
        ->withAttribute("onClick", "document.querySelector(\"form#IveSeenThingsYouWouldntBelieve\").submit();")
        ->withTextContent("Logout")
        ->buildCompleteTagWithTextContent();

    print("<form action='/googaloo/www/index.php' id='IveSeenThingsYouWouldntBelieve' method='post' hidden='true'><input name='ThisSessionWillFadeLikeTearsInTheRain' value='AllThoseMomentsWillBeLostInTime' /></form>");

    print('<div class="menuTitle">'.$menuTitle.'</div>');

    ElementBuilder::create("div")
        ->withAttribute("class", "menuUserInfo")
        ->withTextContent("Welcome {$_SESSION['userFirstName']} {$_SESSION['userLastName']}")
        ->buildCompleteTagWithTextContent();

    print('<div class="menuLinks">');
    /* fill the menu bar  */
    printMenuItem($menuItems);
    print('</div>');

    /*  end the menu bar  */
    print('</div>');


}

function printMenuItem($menuItems){

    foreach($menuItems as $links){
        print('<div class="menuItem"><a href="'
            .$links["href"]
            .'">'.$links["name"]
            .'</a>'
            .'</div>'
        );
    }

}