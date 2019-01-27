<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use View;
use DB;
use Config;

use App\Todo;
use App\Modification;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Show To-Do List page.
     *
     * @param  Request
     * @return View
     */
	public function todos(Request $request) {
		// Get user session
		$user = Session::get('user');

		// Get the active to-do lists of the user
		$todos = Todo::where('creator_id', $user->id)->orderBy('updated_at', 'desc')->get();

		// Get the archived to-do lists of the user
		$archives = Todo::withTrashed()->whereNotNull('deleted_at')->where('creator_id', $user->id)->orderBy('updated_at', 'desc')->get();

		return View::make('todos')->with(array(
												'page' => 'Todos',
												'todos' => $todos,
												'archives' => $archives
											));
	}
}
