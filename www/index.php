<?php
include 'db_tools.php';
include 'forminput.php';
include "header.php";

printheader();
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