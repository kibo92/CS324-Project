<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['cors','jsonvalidator']], function () {
	Route::post('api/users/create', 'UserController@createUser');
	Route::post('api/users/login', 'UserController@login');
});


Route::group(['middleware' => ['cors']], function () {
	Route::get('api/blogs/', 'BlogController@allBlogs');
	Route::get('api/comment/{blog_id}',['uses' =>'BlogController@allCommentsForBlog']);
});
	
Route::group(['middleware' => ['cors','token']], function () {
	Route::post('api/comment/create', 'BlogController@createComment');
});

Route::group(['middleware' => ['cors','admin','jsonvalidator']], function () {
	Route::post('api/blogs/create', 'BlogController@create');
});