// billing.js
// This script is included by billing.html
// This script validates the form and interacts with Stripe.
// This script was written in Chapter 15.

// Watch for the document to be ready:
$(function() {

  $('#billing_form').submit(function() {
		var error = false;

		// disable the submit button to prevent repeated clicks:
		$('input[type=submit]', this).attr('disabled', 'disabled');

		// Get the values:
		var cc_number = $('#cc_number').val(), cc_cvv = $('#cc_cvv').val(), cc_exp_month = $('#cc_exp_month').val(), cc_exp_year = $('#cc_exp_year').val();
		
		// Validate the number:
		if (!Stripe.validateCardNumber(cc_number)) {
			error = true;
			reportError('The credit card number appears to be invalid.');
		}

		// Validate the CVC:
		
		// Validate the expiration:
		if (!Stripe.validateExpiry(cc_exp_month, cc_exp_year)) {
			error = true;
			reportError('The expiration date appears to be invalid.');
		}
		if (!error) {
			// Get the Stripe token:
			Stripe.createToken({
				number: cc_number,
				cvc: cc_cvv,
				exp_month: cc_exp_month,
				exp_year: cc_exp_year
			}, stripeResponseHandler);
		}

		// prevent the form from submitting with the default action
		return false;

	}); // form submission
	
}); // document ready.

// Function handles the Stripe response:
function stripeResponseHandler(status, response) {

	// Check for an error:
	if (response.error) {
		reportError(response.error.message);
	} else { // No errors, submit the form.
	  var billing_form = $('#billing_form');
	  // token contains id, last4, and card type
	  var token = response.id;
	  // insert the token into the form so it gets submitted to the server
	  billing_form.append("<input type='hidden' name='token' value='" + token + "' />");
	  // and submit
	  billing_form.get(0).submit();
	}
	
} // End of stripeResponseHandler() function.

function reportError(msg) {
	// Show the error in the form:
	$('#error_span').text(msg);
	// re-enable the submit button:
    $('input[type=submit]', this).attr('disabled', false);
	return false;
}

