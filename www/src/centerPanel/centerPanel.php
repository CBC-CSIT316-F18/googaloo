<?php
/**
 * Created by PhpStorm.
 * User: TyckoFranklin
 * Date: 9/27/2018
 * Time: 9:53 PM
 */
use src\util\html\ElementBuilder\ElementBuilder;
use src\util\database\db_tools\db_tools;

function printCenterPanel()
{

    /*  Fluent interfaces and builder classes for the win!  */
    /**  @var ElementBuilder $ourBodyBuilder */
    $ourBodyBuilder = ElementBuilder::create("div")
        ->withAttribute("id", "centerpanel")
        ->withAttribute("class", "app")
        /* Only start the tag, leave it open for children to be added to it  */
        ->buildLeaveTagOpen();

    $bodySpacer = ElementBuilder::create("div")
        ->withAttribute("class", "centerPanelSpacer")
        /* Only start the tag, leave it open for children to be added to it  */
        ->buildLeaveTagOpen()
        ->withTextContent("This is a test of the builder!!!")
        ->printTextContent();

    /*  No need to save this to a variable as it is only used here once.  */
    ElementBuilder::create("div")
        ->withAttribute("class", "appChild")
        ->withTextContent("More Text Here")
        ->buildLeaveTagOpen()
        ->printTextContent()
        ->buildCloseOpenTag();

        /** @var db_tools $db */
        $db=new db_tools;
        $db->db_connect();
        $sql = "SELECT * FROM `users`";
        $rows=$db->db_select($sql);

        $ilength = count($rows);
        for($i = 0; $i < $ilength; $i++)
        {
           $jlength = count($rows[$i]);
           $row=$rows[$i];
          for($j = 0; $j < $jlength; $j++)
           {
               echo $row['id'];
                echo $row['first_name'];
                 echo $row['last_name'];
                  echo $row['email'];
                   echo $row['username'];
               echo "<br>";
           }
        }

    /*  Now close the tag since we have added the child we wanted to add  */
    $bodySpacer->buildCloseOpenTag();
    $ourBodyBuilder->buildCloseOpenTag();
}