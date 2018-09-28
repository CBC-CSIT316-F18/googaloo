<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 9/19/2018
 * Time: 11:10 PM
 */

/**
 * @param $menuTitle string
 */
function printMenuBar($menuTitle){
    // put in some dummy data
    $menuItems = [
        [
            'href' => 'https://www.google.com',
            'name' => 'Google',
        ],
        [
            'href' => 'https://www.columbiabasin.edu',
            'name' => 'CBC',
        ],
    ];

    /*  start the menu bar  */
    print('<div class="mainMenu">');

    print('<div class="menuTitle">'.$menuTitle.'</div>');

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