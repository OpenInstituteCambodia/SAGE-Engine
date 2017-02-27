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
    return view('index')->name('frontpage');
});

Auth::routes();

// Dashboard Routes
Route::group(['prefix' => 'dashboard'], function() {
  Route::get('/', 'DashboardController@index');

  // Dashboard Route
  Route::get('users', 'UsersController@index');
});

// Project Routes
Route::group(['prefix' => 'project'], function(){
  Route::get('/', 'ProjectController@index')->name('projects');

  // Function
  Route::post('create', 'ProjectController@create');
  Route::post('upload', 'ProjectController@upload');
  Route::get('edit/{projectName}', 'ProjectController@edit');
  Route::get('delete/{projectName}', 'ProjectController@delete');
});

// Developer Routes
Route::group(['prefix' => 'developer', 'middleware' => 'auth'], function(){
  Route::get('/', 'DeveloperController@index');


  Route::group(['prefix' => 'template'], function(){
    Route::get('info', 'DeveloperController@getActiveTemplateInfo');
    Route::post('update', 'DeveloperController@updateIonicTemplate');
  });

  // XML Route
  Route::group(['prefix' => 'xml'], function(){

    // Function
    Route::post('validator', 'DeveloperController@parseXML');
  });
});
