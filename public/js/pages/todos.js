var todos = new Todos();

function Todos(){
    
}

Todos.prototype.bindTodos = function () {

	// Set up 'Add To-Do List' form validator
	var $add_todo_validator = $("#frm-add-todo").validate({
		rules: {
			'name': { required: true }
		},
		messages: {
			'name': "Please enter the name."
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
		},
		highlight: function highlight(element) {
		    $(element).addClass('is-invalid').removeClass('is-valid');
		},
		unhighlight: function unhighlight(element) {
		    $(element).addClass('is-valid').removeClass('is-invalid');
		}
	});

	// Handle 'Add To-Do List' form submit
	$('#frm-add-todo').unbind('submit').on('submit', function (e) {
		e.preventDefault();

		// Validate 'Add To-Do List' form 
		var $valid = $("#frm-add-todo").valid();

    	if (!$valid) { // If 'Add To-Do List' form is invalid, show the errors
		    $add_todo_validator.focusInvalid();
		    return false;
		}

		// Get todo data
		var name = $('#txt-add-todo-name').val();

		var todo_obj = {
			'name' : name
		};

		// Hide 'Add To-Do List' modal and show a processing modal
		$('#modal-add-todo').modal('hide');
		modal.show('info', 'fa-refresh fa-spin', 'Saving...', 'Please wait while we are adding the task list.', null);
		
		// Create the todo
		todo.store(todo_obj, function (data) {
			if (data.status == 'OK') // Show success modal if creation is successful
				modal.set('success', 'fa-check-circle', 'Success', 'Task list successfully added.', { ok : function () {
					window.location.reload();
				}});
			else // Show error modal if creation failed
				modal.set('danger', 'fa-times-circle', 'Oops', data.error, { ok : true });
		});
	});

	// Handle 'Edit' button click event of each todo item
	$('.todo-edit').unbind('click').on('click', function () {
		var id = $(this).data('id');

		// Show todo data
		todo.show(id, function (data) {
			if (data.status == 'OK') {
				$('#hdn-edit-todo-id').val(data.todo.id);
				$('#txt-edit-todo-name').val(data.todo.name);
			}
		});
	});

	// Handle 'Edit To-Do List' form submit
	$('#frm-edit-todo').unbind('submit').on('submit', function (e) {
		e.preventDefault();

		// Valdiate the 'Edit To-Do List'form
		var $valid = $("#frm-edit-todo").valid();

    	if (!$valid) { // If 'Edit To-Do List' form is invalid, show the errors
		    $edit_todo_validator.focusInvalid();
		    return false;
		}

		// Prepare todo data
		var id = $('#hdn-edit-todo-id').val();
		var name = $('#txt-edit-todo-name').val();

		var todo_obj = {
			'id' : id,
			'name' : name
		};

		// Hide 'Edit To-Do List' modal and show a processing modal
		$('#modal-edit-todo').modal('hide');
		modal.show('info', 'fa-refresh fa-spin', 'Saving...', 'Please wait while we are updating the task list.', null);
		
		// Update the todo
		todo.update(todo_obj, function (data) {
			if (data.status == 'OK') // Show success modal if update is successful
				modal.set('success', 'fa-check-circle', 'Success', 'Task List successfully updated.', { ok : function () {
					window.location.reload();
				}});
			else // Show error modal if creation failed
				modal.set('danger', 'fa-times-circle', 'Oops', data.error, { ok : true });
		});
	});

	// Handle 'Archive' button click event of each todo item
	$('.todo-remove').unbind('click').on('click', function () {
		var id = $(this).data('id');

		// Show confirm modal
		modal.show('warning', 'fa-question', 'Are You Sure?', 'This task list will be moved to <i>Archive</i>.', { 'no' : function () {
			modal.hide();
		}, 'yes' : function () { // If user responds 'Yes'
			// Show processing modal
			modal.set('info', 'fa-refresh fa-spin', 'Saving...', 'Please wait while we are archiving the task list.', null);

			// Archive the todo
			todo.destroy(id, function (data) {
				if (data.status == 'OK') // Show success modal if delete is successful
					modal.set('success', 'fa-check-circle', 'Success', 'Task list successfully moved to archive.', { ok : function () {
						window.location.reload();
					}});
				else // Show error modal if delete failed
					modal.set('danger', 'fa-times-circle', 'Oops', data.error, { ok : true });
			});
		}});
	});

	// Handle 'Restore' button click event of each todo item
	$('.todo-restore').unbind('click').on('click', function () {
		var id = $(this).data('id');

		// Show processing modal
		modal.show('info', 'fa-refresh fa-spin', 'Saving...', 'Please wait while we are archiving the task list.', null);

		// Restore the todo
		todo.restore(id, function (data) {
			if (data.status == 'OK') // Show success modal if restoration is successful
				modal.set('success', 'fa-check-circle', 'Success', 'Task list successfully restored.', { ok : function () {
					window.location.reload();
				}});
			else // Show error modal if restoration failed
				modal.set('danger', 'fa-times-circle', 'Oops', data.error, { ok : true });
		});
	});
}

Todos.prototype.reloadPageContent = function (data, message, callback) {
    todos.bindTodos();
}

$(document).ready(function(){
	todos.bindTodos();
});