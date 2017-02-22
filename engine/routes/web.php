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
    return view('index');
});

Auth::routes();

Route::group(['prefix' => 'dashboard'], function() {
  Route::get('/', 'DashboardController@index');

  // Dashboard Route
  Route::get('users', 'DashboardController@users');
});

// Developer Route
Route::group(['prefix' => 'developer', 'middleware' => 'auth'], function(){
  Route::get('/', 'DeveloperController@index');

  // XML Route
  Route::group(['prefix' => 'xml'], function(){
    Route::post('validator', 'DeveloperController@parseXML');
  });
});
