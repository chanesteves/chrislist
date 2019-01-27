<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use View;
use DB;
use Config;

use App\Task;
use App\Modification;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TasksController extends Controller
{
    /*****************/
	/**** AJAX *******/
	/*****************/

	/**
     * Create a task.
     *
     * @param  Request
     * @return Response
     */
	public function ajaxStore(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'todo_id' => 'required'
		]);

		// Get user session
		$user = Session::get('user');

		// Create new task and save the passed data
		$task = new Task;

		$task->name = $request->name;
		$task->todo_id = $request->todo_id;
		$task->save();

		// Create new modification record and log a 'create' activity
		$modification = new Modification;

		$modification->modifiable_id = $task->id;
		$modification->modifiable_type = get_class($task);
		$modification->type = 'create';
		$modification->performer_id = $user->id;
		$modification->save();

		return array('status' => 'OK', 'result' => $task, 'temp_id' => $request->temp_id);
	}

	/**
     * Create a task.
     *
     * @param  id
     * @return Response
     */
	public function ajaxMarkAsDone($id)
	{
		// Get current datetime
		$now = date('Y-m-d H:i:s');

		// Get user session
		$user = Session::get('user');

		// Find the task by id
		$task = Task::find($id);

		if (!$task) // Return error if task is not found
			return array('status' => 'ERROR', 'error' => 'Task not found.');

		// Save task data
		$task->done_at = $now;
		$task->save();

		// Create new modification record and log a 'done' activity
		$modification = new Modification;

		$modification->modifiable_id = $task->id;
		$modification->modifiable_type = get_class($task);
		$modification->type = 'done';
		$modification->performer_id = $user->id;
		$modification->save();

		return array('status' => 'OK', 'result' => $task);
	}

	/**
     * Create a task.
     *
     * @param  id
     * @return Response
     */
	public function ajaxMarkAsNotDone($id)
	{
		// Get user session
		$user = Session::get('user');

		// Find the task by id
		$task = Task::find($id);

		if (!$task) // Return error if task is not found
			return array('status' => 'ERROR', 'error' => 'Task not found.');

		// Save task data
		$task->done_at = null;
		$task->save();

		// Create new modification record and log a 'undone' activity
		$modification = new Modification;

		$modification->modifiable_id = $task->id;
		$modification->modifiable_type = get_class($task);
		$modification->type = 'undone';
		$modification->performer_id = $user->id;
		$modification->save();

		return array('status' => 'OK', 'result' => $task);
	}

	/**
     * Create a task.
     *
     * @param  id
     * @return Response
     */
	public function ajaxDestroy($id)
	{
		// Get user session
		$user = Session::get('user');

		// Find the task by id
		$task = Task::find($id);

		if (!$task) // Return error if task is not found
			return array('status' => 'ERROR', 'error' => 'Task not found.');

		// Delete the task
		$task->delete();

		// Create new modification record and log a 'destroy' activity
		$modification = new Modification;

		$modification->modifiable_id = $task->id;
		$modification->modifiable_type = get_class($task);
		$modification->type = 'destroy';
		$modification->performer_id = $user->id;
		$modification->save();

		return array('status' => 'OK', 'result' => $task);
	}

	/**
     * Create a task.
     *
     * @param  Request
     * @param  id
     * @return Response
     */
	public function ajaxUpdate(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required'			
		]);

		// Get user session
		$user = Session::get('user');

		// Find the task by id
		$task = Task::find($id);

		if (!$task) // Return error if task is not found
			return array('status' => 'ERROR', 'error' => 'Task not found.');

		// Save the task data
		$task->name = $request->name;
		$task->save();

		// Create new modification record and log a 'update' activity
		$modification = new Modification;

		$modification->modifiable_id = $task->id;
		$modification->modifiable_type = get_class($task);
		$modification->type = 'update';
		$modification->performer_id = $user->id;
		$modification->save();

		return array('status' => 'OK', 'result' => $task, 'temp_id' => $request->temp_id);
	}
}
