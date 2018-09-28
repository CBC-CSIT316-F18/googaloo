<?php
include ('./includes/config.inc.php');
include ('./includes/header.html');
include ('./includes/leftsidebar.html');
?>
<?php
include 'db_tools.php';
$db=new db_tools;
$db->db_connect();
$sql = "SELECT * FROM `cuser`";
$rows=$db->db_select($sql);

$ilength = count($rows);
for($i = 0; $i < $ilength; $i++) 
{
    $jlength = count($rows[$i]);
    $row=$rows[$i];
   for($j = 0; $j < $jlength; $j++) 
    {    
        echo $row['ID'];
         echo $row['firstname'];
          echo $row['lastname'];
           echo $row['email'];
            echo $row['auth'];
        echo "<br>";
    }
}
?>
<?php
include ('./includes/rightsidebar.html');
include ('./includes/footer.html');    
?>