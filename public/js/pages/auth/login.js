// Check user has logged in via GOOGLE
var username = $('#hdn-username').val();

if (username && username != '') // If logged in via GOOGLE, execute login routine (without password)
	loginExec(username, null);

$(document).ready(function(){
	// Setup login form validator
	var $login_validator = $("#frm-login").validate({
		rules: {
			'username': { required: true },
			'password': { required: true }
		},
		messages: {
			'username': "Please enter your username.",
			'password': "Please enter your password."
		},
		highlight: function (element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function (element) {
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
		},
		errorElement: 'em',
		errorPlacement: function errorPlacement(error, element) {
		    error.addClass('invalid-feedback');

		    if (element.prop('type') === 'checkbox') {
		      error.insertAfter(element.parent('label'));
		    } else {
		      error.insertAfter(element);
		    }
		}
	});

	// Handle login form submit event
	$('#frm-login').unbind('submit').on('submit', function (event)
	{	
		event.preventDefault();

		// Validate login form
		var $valid = $("#frm-login").valid();

    	if (!$valid) { // Show errors if login form is not valid
		    $login_validator.focusInvalid();
		    return false;
		}

		// Get username and passowrd
		var username = $('#txt-username').val();		
		var password = $('#txt-password').val();

		// Execute login routine
		loginExec(username, password);
	});
});

function loginExec (username, password) {
	// Set username and password
	$('#txt-username').val(username);
	$('#txt-password').val(password);

	// Submit the form
	$('#frm-login').unbind('submit').submit();
}
