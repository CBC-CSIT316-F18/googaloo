<?php
include 'db_tools.php';
include 'forminput.php';
include "header.php";
include "src/body/body.php";
include "src/util/html/ElementBuilder.php";

printheader();
printBody();

//create_form_input('email', 'email', '', $login_errors, array('placeholder'=>'Email address')); 
$txtemail=new forminput('email', 'email', '', array('placeholder'=>'Email address'));

print($txtemail->errors);

//$db=new db_tools;
//$db->db_connect();
//$sql = "SELECT * FROM `users`";
//$rows=$db->db_select($sql);
//
//$ilength = count($rows);
//for($i = 0; $i < $ilength; $i++) 
//{
//    $jlength = count($rows[$i]);
//    $row=$rows[$i];
//   for($j = 0; $j < $jlength; $j++) 
//    {    
//        echo $row['id'];
//         echo $row['first_name'];
//          echo $row['last_name'];
//           echo $row['email'];
//            echo $row['username'];
//        echo "<br>";
//    }
//}

printfooter();