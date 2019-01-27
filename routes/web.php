<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check())
        return redirect('/todos');
    else
        return redirect('/auth/login');
});

// Todo routes
Route::post('todos/ajaxStore', 'TodosController@ajaxStore');
Route::post('todos/{todo}/ajaxUpdate', 'TodosController@ajaxUpdate');
Route::post('todos/{todo}/ajaxDestroy', 'TodosController@ajaxDestroy');
Route::post('todos/{todo}/ajaxShow', 'TodosController@ajaxShow');
Route::post('todos/{todo}/ajaxRestore', 'TodosController@ajaxRestore');

Route::post('todos/{todo}/ajaxMarkAllTasksAsDone', 'TodosController@ajaxMarkAllTasksAsDone');
Route::post('todos/{todo}/ajaxMarkAllTasksAsNotDone', 'TodosController@ajaxMarkAllTasksAsNotDone');

// Task routes
Route::post('tasks/ajaxStore', 'TasksController@ajaxStore');
Route::post('tasks/{task}/ajaxUpdate', 'TasksController@ajaxUpdate');
Route::post('tasks/{task}/ajaxDestroy', 'TasksController@ajaxDestroy');
Route::post('tasks/{task}/ajaxShow', 'TasksController@ajaxShow');
Route::post('tasks/{task}/ajaxMarkAsDone', 'TasksController@ajaxMarkAsDone');
Route::post('tasks/{task}/ajaxMarkAsNotDone', 'TasksController@ajaxMarkAsNotDone');

// Person routes
Route::post('persons/{person}/ajaxUploadImage', 'PeopleController@ajaxUploadImage');

// Page routes
Route::get('todos', 'PagesController@todos');
Route::get('todos/{todo}', 'TodosController@show');

// Authentication routes
Route::get('auth/register', 'Auth\RegisterController@getRegister');
Route::get('auth/login', 'Auth\LoginController@getLogin');
Route::get('auth/logout', 'Auth\LoginController@getLogout');

Route::post('auth/ajaxRegister', 'Auth\RegisterController@ajaxRegister');
Route::post('auth/ajaxChangePassword', 'Auth\AuthController@ajaxChangePassword');
Route::post('auth/login', 'Auth\LoginController@postLogin');

// GOOGLE login routes
Route::get('auth/google', 'Auth\AuthController@redirectToGoogle');
Route::get('google/callback', 'Auth\AuthController@handleGoogleCallback');