<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use View;
use DB;
use Config;

use App\Todo;
use App\Modification;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TodosController extends Controller
{
	/**
	 * Show the todo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Find the todo by id or slug
		$todo = Todo::where('id', $id)->orWhere('slug', $id)->first();

		if (!$todo) // Return error if todo is not found
			return response()->view('errors.404', [], 404);

		// Get the modifications related to the todo
		$modifications = Modification::select(DB::raw('modifications.*, tasks.name as task_name'))
										->join('tasks', function ($q) {
											$q->on('tasks.id', 'modifiable_id');
											$q->where('modifiable_type', 'App\Task');
										})->join('todos', function ($q) use ($todo) {
											$q->on('todos.id', 'todo_id');
											$q->where('todo_id', $todo->id);
										})->orderBy('modifications.created_at', 'desc')->get();

		return View::make('todos.show')->with(array('page' => 'Show Todo', 'todo' => $todo, 'modifications' => $modifications));
	}

    /*****************/
	/**** AJAX *******/
	/*****************/

	/**
	 * Create a todo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ajaxStore(Request $request)
	{
		$this->validate($request, [
			'name' => 'required'
		]);

		// Get user session
		$user = Session::get('user');

		// Create todo and save its data
		$todo = new Todo;

		$todo->name = $request->name;
		$todo->creator_id = $user->id;
		$todo->save();

		// Create a unique slug for todo and save it
		$slug = str_slug($todo->name);
		$td = Todo::where('slug', $slug)->first();
		$count = 0;

		while ($td && $todo->id != $td->id) {
			$count++;
			$slug = str_slug($todo->name . $count);
			$td = Todo::where('slug', $slug)->first();
		}

		$todo->slug = str_slug($slug);
		
		$todo->save();

		return array('status' => 'OK', 'result' => $todo);
	}

	/**
	 * Update a todo.
	 *
	 * @param  Request
	 * @param  $id
	 * @return Response
	 */
	public function ajaxUpdate(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required'
		]);

		// Find todo by id
		$todo = Todo::find($id);

		if (!$todo) // Return error if todo is not found
			return array('status' => 'ERROR', 'error' => 'Task list not found.');

		$todo->name = $request->name;
		$todo->save();

		// Create a unique slug for todo and save it
		$slug = str_slug($todo->name);
		$td = Todo::where('slug', $slug)->first();
		$count = 0;

		while ($td && $todo->id != $td->id) {
			$count++;
			$slug = str_slug($todo->name . $count);
			$td = Todo::where('slug', $slug)->first();
		}

		$todo->slug = str_slug($slug);
		
		$todo->save();
		
		$todo->save();

		return array('status' => 'OK', 'result' => $todo);
	}

	/**
	 * Show a todo.
	 *
	 * @param  $id
	 * @return Response
	 */
	public function ajaxShow($id) {
		// Find todo by id
		$todo = Todo::find($id);

		return array('status' => 'OK', 'todo' => $todo);
	}

	/**
	 * Archive a todo.
	 *
	 * @param  $id
	 * @return Response
	 */
	public function ajaxDestroy($id)
	{
		// Find todo by id
		$todo = Todo::find($id);

		if (!$todo) // Return error if todo is not found
			return array('status' => 'ERROR', 'error' => 'Task list not found.');

		// Delete the todo
		$todo->delete();

		return array('status' => 'OK');
	}

	/**
	 * Restore a todo.
	 *
	 * @param  $id
	 * @return Response
	 */
	public function ajaxRestore($id)
	{
		// Find todo by id
		$todo = Todo::withTrashed()->find($id);

		if (!$todo) // Return error if todo is not found
			return array('status' => 'ERROR', 'error' => 'Task list not found.');

		// Restore todo
		$todo->restore();

		return array('status' => 'OK');
	}

	/**
	 * Mark all tasks in a todo as 'done'.
	 *
	 * @param  $id
	 * @return Response
	 */
	public function ajaxMarkAllTasksAsDone($id)
	{
		// Get current datetime
		$now = date('Y-m-d H:i:s');

		// Find todo by id
		$todo = Todo::find($id);

		if (!$todo) // Return error if todo is not found
			return array('status' => 'ERROR', 'error' => 'Todo not found.');

		// For each of the tasks in todo, mark it as 'done'
		foreach($todo->tasks()->whereNull('done_at')->get() as $task) {
			$task->done_at = $now;
			$task->save();
		}

		return array('status' => 'OK', 'result' => $todo);
	}

	/**
	 * Mark all tasks in a todo as 'not done'.
	 *
	 * @param  $id
	 * @return Response
	 */
	public function ajaxMarkAllTasksAsNotDone($id)
	{
		// Find todo by id
		$todo = Todo::find($id);

		if (!$todo) // Return error if todo is not found
			return array('status' => 'ERROR', 'error' => 'Todo not found.');

		// For each of the tasks in todo, mark it as 'not done'
		foreach($todo->tasks()->whereNotNull('done_at')->get() as $task) {
			$task->done_at = null;
			$task->save();
		}

		return array('status' => 'OK', 'result' => $todo);
	}
}
