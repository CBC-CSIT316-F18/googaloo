<?php
    class Emp 
    {
        public $fname = "";
        public $lname  = "";
    }
    
    $e = new Emp();
    $e->fname = "hello";
    $e->lname  = "world"; 
    header("Content-Type: application/json");
    header("Cache-Control: no-cache");
    echo json_encode($e);
?>
