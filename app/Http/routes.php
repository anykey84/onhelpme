<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('home', 'HomeController@index');
Route::get('login', 'Auth\AuthController@getLogin');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::post('getfilelist', 'AdminController@getFileList');
Route::get('getfilelist', 'AdminController@getFileList');
Route::get('backup', 'AdminController@backup');
Route::post('backup', 'AdminController@backup');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//
Route::group(['middleware' => ['web']], function () {
    //
});

//Route::group(['prefix'=>'admin','middleware'=>'auth'], function()
//{
//    Route::get('/', 'AdminController@index');
//});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
    Route::get('/home', ['as' => 'index', 'uses' => 'HomeController@index']);

    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/backup', 'AdminController@backup');
});
