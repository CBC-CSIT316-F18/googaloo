<?php
include 'db_tools.php';
include 'forminput.php';
include "header.php";
include "src/body/body.php";
include "src/util/html/ElementBuilder.php";

printheader();
printBody();

//create_form_input('email', 'email', '', $login_errors, array('placeholder'=>'Email address')); 
// $txtemail=new forminput('email', 'email', '', array('placeholder'=>'Email address'));

// print($txtemail->errors);



printfooter();