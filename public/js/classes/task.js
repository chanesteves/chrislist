var task = new Task();

function Task(){
    
}

// AJAX call to create a task
Task.prototype.store = function (param, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	data = { 
				_token: CSRF,
				'name' : param.name,
				'todo_id' : param.todo_id,
				'temp_id' : param.temp_id
			};

	$.ajax({
		url: '/tasks/ajaxStore',
		type: 'POST',
		dataType: "json",
		data: data,
		success: function(data){
			if (callback)
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}

// AJAX call to mark task as 'done'
Task.prototype.markAsDone = function (id, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	data = { 
				_token: CSRF
			};

	$.ajax({
		url: '/tasks/' + id + '/ajaxMarkAsDone',
		type: 'POST',
		dataType: "json",
		data: data,
		success: function(data){
			if (callback)
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}

// AJAX call to mark task as 'not done'
Task.prototype.markAsNotDone = function (id, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	data = { 
				_token: CSRF
			};

	$.ajax({
		url: '/tasks/' + id + '/ajaxMarkAsNotDone',
		type: 'POST',
		dataType: "json",
		data: data,
		success: function(data){
			if (callback)
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}

// AJAX call to update a task
Task.prototype.update = function (param, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	data = { 
				_token: CSRF,
				'name' : param.name
			};

	$.ajax({
		url: '/tasks/' + param.id + '/ajaxUpdate',
		type: 'POST',
		dataType: "json",
		data: data,
		success: function(data){
			if (callback)
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}

// AJAX call to delete a task
Task.prototype.destroy = function (id, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	data = { 
				_token: CSRF
			};

	$.ajax({
		url: '/tasks/' + id + '/ajaxDestroy',
		type: 'POST',
		dataType: "json",
		data: data,
		success: function(data){
			if (callback)
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}

// AJAX call to show a task
Task.prototype.show = function (id, callback) {
	CSRF = $("meta[name='csrf-token']").attr('content');

	$.ajax({
		url: '/tasks/' + id + '/ajaxShow',
		type: 'POST',
		dataType: "json",
		data: {_token: CSRF},
		success: function(data){
			if (data.status == 'OK')
				callback(data);
		}, error:function (xhr, error, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	});
}