<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    if(Auth::guest())

        return view('welcome');

    return redirect('/home');
    
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

        Route::get('/home', 'HomeController@index')->name('home');

        Route::resource('tasks',TaskController::class);

        Route::resource('task_activities',TaskActivityController::class);

        Route::resource('activity_files',TaskActivityFilesController::class);

        Route::resource('users',UserController::class);

        Route::resource('user_tasks',TaskUserController::class);

});

