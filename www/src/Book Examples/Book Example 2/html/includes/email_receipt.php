<?php

// This script sends a receipt out in HTML format.
// This script is created in Chapter 10.

// Create the message body in two formats:
$body_plain = "Thank you for your order. Your order number is {$_SESSION['order_id']}. All orders are processed on the next business day. You will be contacted in case of any delays.\n\n";

$body_html = file_get_contents('includes/plain_header.html');
$body_html .=  '<p>Thank you for your order. Your order number is ' . $_SESSION['order_id'] . '. All orders are processed on the next business day. You will be contacted in case of any delays.</p>
<table border="0" cellspacing="3" cellpadding="3">
	<tr>
		<th align="center">Item</th>
		<th align="center">Quantity</th>
		<th align="right">Price</th>
		<th align="right">Subtotal</th>
	</tr>';

// Get the cart contents for the confirmation email:
$r = mysqli_query($dbc, "CALL get_order_contents({$_SESSION['order_id']})");

// Fetch each product:
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	// Add to the plain version:
	$body_plain .= "{$row['category']}::{$row['name']} ({$row['quantity']}) @ \$" . number_format($row['price_per']/100, 2) . " each: $" . number_format($row['subtotal']/100, 2) . "\n";
	
	// Add to the HTML:
	$body_html .= '<tr><td>' . $row['category'] . '::' . $row['name'] . '</td> 
		<td align="center">' . $row['quantity'] . '</td>
		<td align="right">$' . number_format($row['price_per']/100, 2) . '</td>
		<td align="right">$' . number_format($row['subtotal']/100, 2) . '</td>
	</tr>
	';
	
	// For reference after the loop:
	$shipping = number_format($row['shipping']/100, 2);
	$total = number_format($row['total']/100, 2);

} // End of WHILE loop. 

// Clear the stored procedure results:
mysqli_next_result($dbc);

// Add the shipping:
$body_plain .= "Shipping: \$$shipping\n";
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Shipping</th>
	<td align="right">$' . $shipping . '</td>
</tr>
';

// Add the total:
$body_plain .= "Total: \$$total\n";
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Total</th>
	<td align="right">$' . $total . '</td>
</tr>
';

// Complete the HTML body:
$body_html .= '</table></body></html>';

// Uses Composer to autoload the Zend Framework files:
require('includes/vendor/autoload.php');

// Create a new mail:
use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

// Create the parts:
$html = new MimePart($body_html);
$html->type = "text/html";

$plain = new MimePart($body_plain);
$plain->type = "text/plain";

// Create the message:
$body = new MimeMessage();
$body->setParts(array($plain, $html));
 
// Establish the email parameters:
$mail = new Mail\Message();
$mail->setFrom('admin@example.com');
$mail->addTo($_SESSION['email']);
$mail->setSubject("Order #{$_SESSION['order_id']} at the Coffee Site");
$mail->setEncoding("UTF-8");
$mail->setBody($body);
$mail->getHeaders()->get('content-type')->setType('multipart/alternative');
echo $body_html;
echo $body_plain; die();

// Send the email:
$transport = new Mail\Transport\Sendmail();
$transport->send($mail);
