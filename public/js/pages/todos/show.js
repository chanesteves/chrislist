var oTable;

$(document).ready(function(){
    // Bind the events to items
    bindItems();    

    // Reinitializae the 'Activity' table
    initializeTable();

    // Set up 'Add Task' form validator
    var $add_task_validator = $("#frm-add-task").validate({
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

    // Handle submit of 'Add Task' form
    $('#frm-add-task').unbind('submit').on('submit', function (e) {
        e.preventDefault();

        // validate 'Add Task' form
        var $valid = $("#frm-add-task").valid();

        if (!$valid) { // If 'Add Task' form is not valid, show the errors
            $add_task_validator.focusInvalid();
            return false;
        }

        // Get task data
        var name = $('#txt-add-task-name').val();
        var todo_id = $('#hdn-add-task-todo-id').val();
        var temp_id = util.generateID(); // Generate a temporary id before creation of task

        // Animate inserting of task to the list
        $('<div class="task row">'
        +   '<div class="view-mode">'
        +       '<div class="col-xs-8">'
        +           '<label class="checkbox inline-block">'
        +               '<input type="checkbox" data-id="' + temp_id + '" data-name="' + name + '" name="checkbox-inline">'
        +           '<i></i><span>' + name + '</span>'
        +          '</label>'
        +       '</div>'
        +       '<div class="col-xs-4">'
        +           '<div class="pull-right">'
        +               '<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>'
        +               '&nbsp;'
        +               '<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>'
        +           '</div>'
        +       '</div>'
        +   '</div>'
        +   '<div class="edit-mode">'
        +       '<form class="task-edit-form" method="POST">'
        +           '<input class="form-control task-edit-name" value="" />'
        +       '</form>'
        +   '</div>'
        + '</div>').insertAfter('.todo .extra-task').hide().show('fast');
    
        // Recount the task items
        recountItems();

        // Bind the events of the task items
        bindItems();

        // Show a popup message
        popMessage ('', 'Task successfully <b>created</b>', 'primary', 'fa-plus');

        // Append activity data
        var dt = new Date();

        $('<tr>'
        +   '<td style="display: none;">'
        +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
        +   '</td>'
        +   '<td>'
        +       '<div class="col-xs-2 col-sm-1">'
        +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
        +       '</div>'
        +       '<div class="col-xs-10 col-sm-11">'
        +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
        +           '<span class="label label-primary">Created</span> the task <strong>' + name + '</strong>'
        +       '</div>'
        +   '</td>'
        +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

        // Reinitializae the 'Activity' table
        initializeTable();

        $('#txt-add-task-name').val('');

        // Prepare task data
        var task_obj = {
            'name' : name,
            'todo_id' : todo_id,
            'temp_id' : temp_id
        };
        
        // Create the task
        task.store(task_obj, function (data) {
            if (data.status == 'OK') { // If task creation is successful, show the success modal
                $('input[data-id=' + data.temp_id + ']').attr('data-id', data.result.id);

                modal.set('success', 'fa-check-circle', 'Success', 'Todo successfully added.', { ok : function () {
                    window.location.reload();
                }});
            }
            else {  // If task creation failed, show the error modal
                modal.set('danger', 'fa-times-circle', 'Oops', data.error, { ok : true });
            }
        });
    });

    // Handle 'Mark All As Done' button
    $('#lnk-all-done').unbind('click').on('click', function () {
        var todo_id = $('#hdn-add-task-todo-id').val();

        // Loop through each task in the "To Do's" list
        $('.todo .task .view-mode input').each(function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');

            // Animate insert of the task from the "To Do's" list to the "Already Done" list
            $('<div class="task row">'
            +   '<div class="view-mode">'
            +       '<div class="col-xs-8">'
            +           '<label class="checkbox inline-block">'
            +               '<input type="checkbox" data-id="' + id + '" data-name="' + name + '" name="checkbox-inline" checked>'
            +           '<i></i><del><span>' + name + '</span></del>'
            +          '</label>'
            +       '</div>'
            +       '<div class="col-xs-4">'
            +           '<div class="pull-right">'
            +               '<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>'
            +               '&nbsp;'
            +               '<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>'
            +           '</div>'
            +       '</div>'
            +   '</div>'
            +   '<div class="edit-mode">'
            +       '<form class="task-edit-form" method="POST">'
            +           '<input class="form-control task-edit-name" value="" />'
            +       '</form>'
            +   '</div>'
            + '</div>').insertAfter('.done .extra-task').hide().show('fast');

            $(this).closest('.task').hide('fast', function () {
                $(this).remove();
            });

            // Recount the task items
            recountItems();

            // Bind the events of the task items
            bindItems();

            // Show a popup message
            popMessage ('', 'Tasks successfully marked as <b>Done</b>', 'success', 'fa-check');

            // Append activity data
            var dt = new Date();

            $('<tr>'
            +   '<td style="display: none;">'
            +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
            +   '</td>'
            +   '<td>'
            +       '<div class="col-xs-2 col-sm-1">'
            +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
            +       '</div>'
            +       '<div class="col-xs-10 col-sm-11">'
            +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
            +           'Marked the task <strong>' + name + '</strong> as <span class="label label-success">Done</span>'
            +       '</div>'
            +   '</td>'
            +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

            // Reinitializae the 'Activity' table
            initializeTable();

            // Mark all tasks as 'done'
            todo.markAllTasksAsDone(todo_id, function (data) {
                // insert code here
            });
        });
    });

    // Handle 'Mark All As Not Done' button
    $('#lnk-all-not-done').unbind('click').on('click', function () {
        var todo_id = $('#hdn-add-task-todo-id').val();

        // Loop through each task in the "Already Done" list
        $('.done .task .view-mode input').each(function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');

            // Animate insert of the task from the "Already Done" list to the "To Do's" list
            $('<div class="task row">'
            +   '<div class="view-mode">'
            +       '<div class="col-xs-8">'
            +           '<label class="checkbox inline-block">'
            +               '<input type="checkbox" data-id="' + id + '" data-name="' + name + '" name="checkbox-inline">'
            +           '<i></i><span>' + name + '</span>'
            +          '</label>'
            +       '</div>'
            +       '<div class="col-xs-4">'
            +           '<div class="pull-right">'
            +               '<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>'
            +               '&nbsp;'
            +               '<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>'
            +           '</div>'
            +       '</div>'
            +   '</div>'
            +   '<div class="edit-mode">'
            +       '<form class="task-edit-form" method="POST">'
            +           '<input class="form-control task-edit-name" value="" />'
            +       '</form>'
            +   '</div>'
            + '</div>').insertAfter('.todo .extra-task').hide().show('fast');

            $(this).closest('.task').hide('fast', function () {
                $(this).remove();
            });

            // Recount the task items
            recountItems();

            // Bind the events of the task items
            bindItems();

            // Show a popup message
            popMessage ('', 'Tasks successfully marked as <b>Not Done</b>', 'default', 'fa-times');

            // Append activity data
            var dt = new Date();

            $('<tr>'
            +   '<td style="display: none;">'
            +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
            +   '</td>'
            +   '<td>'
            +       '<div class="col-xs-2 col-sm-1">'
            +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
            +       '</div>'
            +       '<div class="col-xs-10 col-sm-11">'
            +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
            +           'Marked the task <strong>' + name + '</strong> as <span class="label label-default">Not Done</span>'
            +       '</div>'
            +   '</td>'
            +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

            // Reinitializae the 'Activity' table
            initializeTable();

            // Mark as tasks as 'Not Done'
            todo.markAllTasksAsNotDone(todo_id, function (data) {
                // insert code here
            });
        });
    });

    // Prepare CSS for printing the to-do list
    var cssLink1 = document.createElement("link");
        cssLink1.href = print_todo_url;
        cssLink1.rel = "stylesheet"; 
        cssLink1.type = "text/css"; 
        cssLink1.media = "print";
    
    frames['iframe_todo'].document.head.appendChild(cssLink1);

    var cssLink2 = document.createElement("link");
        cssLink2.href = font_awesome_url;
        cssLink2.rel = "stylesheet"; 
        cssLink2.type = "text/css"; 
        cssLink2.media = "print";
    
    frames['iframe_todo'].document.head.appendChild(cssLink2);

    // Handle click of 'Print' button
    $('#btn-print').unbind('click').on('click', function () {
        // Loop through to-do tasks and append them to the panel for printing
        $('.todo .task .view-mode input').each(function () {
            var name = $(this).attr('data-name');

            $('.print-test-list').append('<li><i class="fa fa-circle-o"></i>&nbsp;' + name + '</li>');
        });

        // Loop through done tasks and append them to the panel for printing
        $('.done .task .view-mode input').each(function () {
            var name = $(this).attr('data-name');

            $('.print-test-list').append('<li><i class="fa fa-check-circle"></i>&nbsp;<del>' + name + '</del></li>');
        });

        // Place the panel for printing to the iframe
        window.frames["iframe_todo"].document.body.innerHTML = document.getElementsByClassName('print-todo-paper')[0].outerHTML;
        setTimeout(function() { 
            // Print the iframe
            window.frames["iframe_todo"].window.focus();
            window.frames["iframe_todo"].window.print();
        }, 500);
    });

    // Reinitialize the 'Activity' table
    function initializeTable () {
        if (oTable)
            oTable.fnDestroy();

        oTable = $('#tbl-modifications').dataTable({
            "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],  
            "bFilter" : false,
            "bSort" : false,
            "oLanguage": {
              "sEmptyTable": "No activity yet."
            },
            "iDisplayLength" : 5
        });

        oTable.fnDraw();
    }

    // Recount the task items
    function recountItems () {
        var todo_count = $('.todo .task').length; // Count items in the "To Do's" list
        var done_count = $('.done .task').length; // Count items in the "Already Done" list

        // Show the count in the footer of each list
        $('.todo-footer label').text(todo_count + ' item' + (todo_count > 1 ? 's' : '') + ' left');
        $('.done-footer label').text(done_count + ' item' + (done_count > 1 ? 's' : '') + ' left');

        var percent = 0;

        if ((todo_count + done_count) > 0)
            percent = done_count / (todo_count + done_count) * 100;

        if (percent > 75)
            $('.todo-header .status').html('<span class="label label-success">' + parseInt(percent) + '% DONE</span>');
        else if (percent > 50)
            $('.todo-header .status').html('<span class="label label-primary">' + parseInt(percent) + '% DONE</span>');
        else if (percent > 25)
            $('.todo-header .status').html('<span class="label label-warning">' + parseInt(percent) + '% DONE</span>');
        else
            $('.todo-header .status').html('<span class="label label-danger">' + parseInt(percent) + '% DONE</span>');
    }

    // Bind events to the task items
    function bindItems () {
        // If an item in the "To Do's" list is clicked
        $('.todo .task .view-mode input').unbind('click').on('click', function () {
            if ($(this).prop('checked')) { // If item is checked
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');

                // Animate insert of item from the "To Do's" list to the "Already Done" list
                $('<div class="task row">'
                +   '<div class="view-mode">'
                +       '<div class="col-xs-8">'
                +           '<label class="checkbox inline-block">'
                +               '<input type="checkbox" data-id="' + id + '" data-name="' + name + '" name="checkbox-inline" checked>'
                +           '<i></i><del><span>' + name + '</span></del>'
                +          '</label>'
                +       '</div>'
                +       '<div class="col-xs-4">'
                +           '<div class="pull-right">'
                +               '<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>'
                +               '&nbsp;'
                +               '<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>'
                +           '</div>'
                +       '</div>'
                +   '</div>'
                +   '<div class="edit-mode">'
                +       '<form class="task-edit-form" method="POST">'
                +           '<input class="form-control task-edit-name" value="" />'
                +       '</form>'
                +   '</div>'
                + '</div>').insertAfter('.done .extra-task').hide().show('fast');

                $(this).closest('.task').hide('fast', function () {
                    $(this).remove();
                });

                // Recount the task items
                recountItems();

                // Bind the events of the task items
                bindItems();

                // Show a popup message
                popMessage ('', 'Task successfully marked as <b>Done</b>', 'success', 'fa-check');

                // Append activity data
                var dt = new Date();

                $('<tr>'
                +   '<td style="display: none;">'
                +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
                +   '</td>'
                +   '<td>'
                +       '<div class="col-xs-2 col-sm-1">'
                +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
                +       '</div>'
                +       '<div class="col-xs-10 col-sm-11">'
                +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
                +           'Marked the task <strong>' + name + '</strong> as <span class="label label-success">Done</span>'
                +       '</div>'
                +   '</td>'
                +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

                // Reinitializae the 'Activity' table
                initializeTable();

                // Mark the task as 'Done'
                task.markAsDone(id, function (data) {
                    // insert code here
                });
            }
        });

        // If an item in the "Already Done" list is clicked
        $('.done .task .view-mode input').unbind('click').on('click', function () {
            if (!$(this).prop('checked')) { // If item is unchecked
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');

                // Animate insert of item from the "Already Done" list to the "To Do's" list
                $('<div class="task row">'
                +   '<div class="view-mode">'
                +       '<div class="col-xs-8">'
                +           '<label class="checkbox inline-block">'
                +               '<input type="checkbox" data-id="' + id + '" data-name="' + name + '" name="checkbox-inline">'
                +           '<i></i><span>' + name + '</span>'
                +          '</label>'
                +       '</div>'
                +       '<div class="col-xs-4">'
                +           '<div class="pull-right">'
                +               '<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>'
                +               '&nbsp;'
                +               '<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>'
                +           '</div>'
                +       '</div>'
                +   '</div>'
                +   '<div class="edit-mode">'
                +       '<form class="task-edit-form" method="POST">'
                +           '<input class="form-control task-edit-name" value="" />'
                +       '</form>'
                +   '</div>'
                + '</div>').insertAfter('.todo .extra-task').hide().show('fast');

                $(this).closest('.task').hide('fast', function () {
                    $(this).remove();
                });

                // Recount the task items
                recountItems();

                // Bind the events of the task items
                bindItems();

                // Show a popup message
                popMessage ('', 'Task successfully marked as <b>Not Done</b>', 'default', 'fa-times');

                // Append activity data
                var dt = new Date();

                $('<tr>'
                +   '<td style="display: none;">'
                +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
                +   '</td>'
                +   '<td>'
                +       '<div class="col-xs-2 col-sm-1">'
                +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
                +       '</div>'
                +       '<div class="col-xs-10 col-sm-11">'
                +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
                +           'Marked the task <strong>' + name + '</strong> as <span class="label label-default">Not Done</span>'
                +       '</div>'
                +   '</td>'
                +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

                // Reinitializae the 'Activity' table
                initializeTable();

                // Mark the task as 'Done'
                task.markAsNotDone(id, function (data) {
                    // insert code here
                });
            }
        });

        // If 'Delete' button of an item in either list is clicked
        $('.task .task-remove').unbind('click').on('click', function () {
            var id = $(this).closest('.task').find('input').attr('data-id');
            var name = $(this).closest('.task').find('input').attr('data-name');

            // Animate removing of item from the list
            $(this).closest('.task').hide('fast', function () {
                $(this).remove();
            });

            // Recount the task items
            recountItems();

            // Append activity data
            var dt = new Date();

            $('<tr>'
            +   '<td style="display: none;">'
            +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
            +   '</td>'
            +   '<td>'
            +       '<div class="col-xs-2 col-sm-1">'
            +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
            +       '</div>'
            +       '<div class="col-xs-10 col-sm-11">'
            +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
            +           '<span class="label label-danger">Deleted</span> the task <strong>' + name + '</strong>'
            +       '</div>'
            +   '</td>'
            +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

            // Reinitializae the 'Activity' table
            initializeTable();

            // Show popup message
            popMessage ('', 'Task successfully <b>removed</b>', 'danger', 'fa-trash');

            // Delete the task
            task.destroy(id, function (data) {
                // insert code here
            });            
        });

        // If 'Edit' button of an item in either list is clicked
        $('.task .task-edit').unbind('click').on('click', function (e) {
            e.stopPropagation();

            // Show all items in view mode, except the item being edited
            $('.view-mode').show();
            $('.edit-mode').hide();

            var name = $(this).closest('.task').find('.view-mode input').attr('data-name');

            $(this).closest('.task').find('.edit-mode input').val(name);

            $(this).closest('.task').find('.view-mode').hide();
            $(this).closest('.task').find('.edit-mode').show();

            $(this).closest('.task').find('.edit-mode input').focus();
        });

        // If an item in edit mode is submitted
        $('.edit-mode form').unbind('submit').on('submit', function (e) {
            e.preventDefault();

            // Get task data including its new name
            var id = $(this).closest('.task').find('.view-mode input').attr('data-id');
            var name = $(this).find('input').val();

            // Show the item in view mode with the new name
            $(this).closest('.task').find('.view-mode input').attr('data-name', name);
            $(this).closest('.task').find('.view-mode span').text(name);

            $(this).closest('.task').find('.view-mode').show();
            $(this).closest('.task').find('.edit-mode').hide();

            // Append activity data
            var dt = new Date();

            $('<tr>'
            +   '<td style="display: none;">'
            +       dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDay() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds()
            +   '</td>'
            +   '<td>'
            +       '<div class="col-xs-2 col-sm-1">'
            +           '<img src="' + $('#img-logged-in').attr('src') + '" alt="me" width="30" class="offline" />'
            +       '</div>'
            +       '<div class="col-xs-10 col-sm-11">'
            +           '<span class="pull-right"><i>' + util.dateToString(dt) + '</i></span>'
            +           '<span class="label label-primary">Edited</span> the task <strong>' + name + '</strong>'
            +       '</div>'
            +   '</td>'
            +  '</tr>').insertBefore('#tbl-modifications tbody tr:first-child');

            // Reinitializae the 'Activity' table
            initializeTable();

            // Show popup message
            popMessage ('', 'Task successfully <b>edited</b>', 'primary', 'fa-pencil');

            // Prepare task data
            var task_obj = {
                id : id,
                name : name
            };

            // Update the task
            task.update(task_obj, function (data) {
                // insert code here
            });
        });

        // Show all items in view mode when an item in edit mode lose focus
        $(document).on('click', function (e) {
            if (!$(e.target).hasClass('task-edit-name')) {
                $('.view-mode').show();
                $('.edit-mode').hide();
            }
        });
    }

    // Show popup message
    function popMessage (title, body, status, icon) {
        var color = '#dc3545';

        if (status == 'success')
            color = '#28a745';
        else if (status == 'primary')
            color = '#007bff';
        else if (status == 'warning')
            color = '#ffc107';

        $.smallBox({
            title : title,
            content : body,
            color : color,
            iconSmall : "fa " + icon + " bounce animated",
            timeout : 5000
        });
    }
});