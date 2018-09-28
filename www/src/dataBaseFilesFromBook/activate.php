<?php
include ('./includes/config.inc.php');
include ('./includes/header.html');
include ('./includes/leftsidebar.html');
?>
<div id="content">
    <?php
    include ('./includes/slider.html');
    ?>
<br>
<br>
<?php
  
    function check_user($reg_errors)
    {
        include ('./admin/db_tools.php');
        // Check for a form submission:
        $db=new db_tools;
        //$dbc=$db->db_connect();
        $dbc=$db->db_connect();         
            // Check for an email address:
        if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) === $_GET['email']) 
        {
            $e = escape_data($_GET['email'], $dbc);
            $k=escape_data($_GET['key'], $dbc);
        } 
        else 
        {
            $reg_errors['email'] = 'not a valid email address';
        }

            if (empty($reg_errors)) 
            { // If everything's OK...                  
                $sql = "SELECT `email`, `activation` FROM `cuser` WHERE `email`= '".$e."'";
                $dbc=$db->db_connect();
                $rows=$db->db_select($sql);
                $ilength = count($rows);
                    if($rows==false)
                    {
                        $reg_errors['email'] = 'This email address has already been registered or you have not registered';	
                    }
                    else 
                    {                   
                        if ($ilength === 1) 
                        { // No problems!
                            // Add the user to the database...
                            // Include the password_compat library, if necessary:
                            // include('./includes/lib/password.php');
                            if($rows[0]['activation']==null)
                            {
                                $q="UPDATE `cuser` SET `activation`='".$k."' WHERE `email` = '".$e."'";
                                $r = $db->db_query($q);
                                if ($r) 
                                { // If it ran OK.


                                        // Get the user ID:
                                        // Store the new user ID in the session:
                                        $uid = mysqli_insert_id($db->connection);
                //				$_SESSION['reg_user_id']  = $uid;		

                                        // Display a thanks message...
                                        echo '<div id="content">';
                                        echo '<div id="alert-success"><h3>Thank You</h3><br><p>Your account has been validated.</p></div>';
                                        echo '</div>';             
                                } 
                                else 
                                { // If it did not run OK.
                                        $reg_errors['email']='Your account has already been activated';
                                }
                            }
                             else 
                                { // If it did not run OK.
                                        $reg_errors['email']='Your account has already been activated';
                                }

                        } 
                   } // End of empty($reg_errors) IF.
            }
            else
            {
                 $reg_errors['email']='activation error';
            }
            
     // End of the main form submission conditional.
            return $reg_errors;
    }

   $reg_errors=Array();
    if ($_SERVER['REQUEST_METHOD'] === 'GET'&&isset($_GET['email'])) 
    {
        $reg_errors=check_user($reg_errors);
    }
    else 
    {
        $reg_errors['email']='No data to validate...';
        
    }
    
    if (!empty($reg_errors))
    {
          echo '<br>';
          echo implode(",", $reg_errors);
          echo '<br>';
          echo '<br>';
          echo '<br>';
          echo '<br>';
    }
    

?>
</div><!--close content area-->
<?php
include ('./includes/rightsidebar.html');
include ('./includes/footer.html');    
?>
