$(document).ready(function(){
	// Check password strength for every keyup
	$('#txt-password').keyup(function() {
		$('#result').html(checkStrength($('#txt-password').val()))
	});

	// Set up regiration form validator
	var $register_validator = $("#frm-register").validate({
		rules: {
			'first_name': { required: true },
			'last_name': { required: true },
			'gender': { required: true },
			'email': { required: true },
			'username': { required: true },
			'password': { required: true },
			'confirm_password': { required: true, equalTo: "#txt-password" }
		},
		messages: {
			'first_name': "Please enter your first name.",
			'last_name': "Please enter your last name.",
			'gender': "Please enter your gender.",
			'email': "Please enter your email.",
			'username': "Please enter your username.",
			'password': "Please enter your password.",
			'confirm_password': { required : "Please confirm your password.", equalTo : "Your passwords do not match." }
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

	// Handle registration form submit event
	$('#frm-register').unbind('submit').on('submit', function (event)
	{		
		event.preventDefault();

		// Validate registration form
		var $valid = $("#frm-register").valid();

    	if (!$valid) { // Show errors if regisration form is not valid
		    $register_validator.focusInvalid();
		    return false;
		}

		// Get inputs
		var first_name = $('#txt-first-name').val();
		var last_name = $('#txt-last-name').val();
		var email = $('#txt-email').val();
		var gender = $('#ddl-gender').val();

		var password = $('#txt-password').val();

		var register_obj = {
			'first_name' : first_name,
			'last_name' : last_name,
			'email' : email,
			'username' : email,
			'gender' : gender,
			'password' : password
		}

		var CSRF = $("meta[name='csrf-token']").attr('content');

		var data = { 
					_token: CSRF,
					first_name: register_obj.first_name,
					last_name: register_obj.last_name,
					email: register_obj.email,
					gender: register_obj.gender,
					username: register_obj.username,
					password: register_obj.password
				};

		// Disable 'Register' button
		$('#btn-register').html('<i class="fa fa-refresh fa-spin"></i> Register').attr('disabled', true);

		// AJAX call registration function
		$.ajax({
			url: '/auth/ajaxRegister',
			type: 'POST',
			dataType: "json",
			data: data,
			success: function(data){				
				$('#btn-register').html('Register').removeAttr('disabled'); // Enable 'Regration' button
				$('#pnl-register-form').hide(); // Hide regiration form
				$('#pnl-register-message').show(); // Show message panel

				if (data.status == 'OK') { // If registration is successful, show the success message
					$('#pnl-register-message h1').text('You Are Now Registered!');
					$('#pnl-register-message .message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> You may now log in to your account.</div>');
					$('.buttons-success').show();
					$('.buttons-error').hide();
				}
				else { // If registration failed, show the error message
					$('#pnl-register-message h1').text('Oops!');
					$('#pnl-register-message .message').html('<div class="alert alert-danger"><i class="fa fa-times-circle"></i> ' + data.error + '</div>');				
					$('.buttons-success').hide();
					$('.buttons-error').show();
				}

			}, error:function (xhr, error, ajaxOptions, thrownError){
				console.log(xhr.responseText);
				$('#lbl-error').html('<i class="fa fa-times"></i>' + xhr.responseText).show();
			}
		});
	});

	// Handle 'Back' button from message panel
	$('#btn-register-back').unbind('click').on('click', function () {
		$('#pnl-register-message').hide(); // Hide the message panel
		$('#pnl-register-form').show(); // Show the regisration form
	});

	// Check password strength
	function checkStrength(password) {
		// Show the password strength evaluation message
		$('#result').parent().parent().find('.pass-label').show();

		var strength = 0
		// If password length is less than 6, it is too short
		if (password.length < 6) {
			$('#result').removeClass()
			$('#result').addClass('text-danger')
			return 'Too short'
		}
		if (password.length > 7) strength += 1
		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))strength += 1
		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// If it has two special characters, increase strength value.
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// Calculated strength value, we can return messages
		
		if (strength < 2) { // If value is less than 2, password is 'Weak'
			$('#result').removeClass()
			$('#result').addClass('text-danger')
			return 'Weak'
		} else if (strength == 2) { // If value is 2, password is 'Good'
			$('#result').removeClass()
			$('#result').addClass('text-warning')
			return 'Good'
		}  else if (strength == 3) { // If value is 3, password is 'Strong'
			$('#result').removeClass()
			$('#result').addClass('text-success')
			return 'Strong'
		} else { // Else, password is 'Very Strong'
			$('#result').removeClass()
			$('#result').addClass('txt-color-green')
			return 'Very Strong'
		}
	}
});

