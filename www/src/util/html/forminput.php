<?php
class forminput
{
    public $errors=array();
    
    function __construct($name, $type, $label = '', $options = array()) 
    {
	// Assume no value already exists:
	$value = false;
	// Check for a value in POST:
        if (isset($_POST[$name])) 
        {
            $value = $_POST[$name];
        }
	// Strip slashes if Magic Quotes is enabled:
        if ($value && get_magic_quotes_gpc()) 
        {
            $value = stripslashes($value);
        }
	// Start the DIV:
	echo '<div class="form-group';
	// Add a class if an error exists:
        if (array_key_exists($name, $this->errors))
        {
            echo ' has-error';
        }
	// Complete the DIV:
	echo '">';
	// Create the LABEL, if one was provided:
        if (!empty($label)) 
        {
            echo '<label for="' . $name . '" class="control-label">' . $label . '</label>';           
        }

	// Conditional to determine what kind of element to create:
	if ( ($type === 'text') || ($type === 'password') || ($type === 'email')) 
        {		
            // Start creating the input:
            echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control"';
		
            // Add the value to the input:
            if ($value) echo ' value="' . htmlspecialchars($value) . '"';
		
            // Check for additional options:
            if (!empty($options) && is_array($options)) 
            {
            	foreach ($options as $k => $v) 
                {
                    echo " $k=\"$v\"";
		}
            }		
		// Complete the element:
		echo '>';		
		// Show the error message, if one exists:
		if (array_key_exists($name, $this->errors)) 
                {
                    echo '<span class="help-block">' . $this->errors[$name] . '</span>';
                }
        } 
        elseif ($type === 'textarea') 
        { // Create a TEXTAREA.
		// Show the error message above the textarea (if one exists):
            if (array_key_exists($name, $this->errors)) 
            {
                    echo '<span class="help-block">' . $this->errors[$name] . '</span>';
            }
            // Start creating the textarea:
            echo '<textarea name="' . $name . '" id="' . $name . '" class="form-control"';		
            // Check for additional options:
            if (!empty($options) && is_array($options)) 
            {
		foreach ($options as $k => $v) 
                {
                    echo " $k=\"$v\"";
                }
            }
            // Complete the opening tag:
            echo '>';		
            // Add the value to the textarea:
            if ($value) 
            {
                echo $value;       
            }
            // Complete the textarea:
            echo '</textarea>';		
	} // End of primary IF-ELSE.	
	// Complete the DIV:
	echo '</div>';
    } // End of the create_form_input() function.
}
// Omit the closing PHP tag to avoid 'headers already sent' errors!
