<?php

include ('./includes/config.inc.php');
include ('./includes/header.html');
include ('./includes/leftsidebar.html');
?>
<div id="content">
    <?php
    include ('./includes/slider.html');
    ?>
<div class="content_item">
<h2  style="text-align: left;">Contact Us</h2>
<p  style="text-align: left;"><span>Name:</span>&nbsp;&nbsp; <input  class="contact"
name="your_name"  value=""  type="text"></p>
<p  style="text-align: left;"><span>Email Address: </span>&nbsp;&nbsp; <input
class="contact"  name="your_email"  value=""  type="text"></p>
<p  style="text-align: left;"><span>Message</span>: &nbsp;&nbsp;
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; </p>
<p  style="text-align: left;"><textarea  class="contact textarea"  rows="8"
cols="50"  name="your_message"></textarea></p>
<p  style="padding: 10px 0px; text-align: left;">Please enter the answer
to this simple math question (to prevent spam)</p>
<p  style="text-align: left;"><span>Maths Question: 9 + 3 = ?&nbsp; </span><input
name="user_answer"  class="contact"  type="text"></p>
<p  style="padding-top: 15px; text-align: left;"><span>&nbsp;</span><input
class="submit"  name="contact_submitted"  value="Send"  type="submit"></p><br>	
</div><!--close site_content-->
</div>
<?php
include ('./includes/rightsidebar.html');
include ('./includes/footer.html');    
?>