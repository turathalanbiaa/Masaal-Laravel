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

Route::get("/en" , "QuestionController@index");
Route::get("/en/" , "QuestionController@index");
Route::get("/en/index" , "QuestionController@index");
Route::get("/en/my-questions" , "QuestionController@my");
Route::post("/en/search" , "QuestionController@search");
Route::get("/en/search" , "QuestionController@searchBy");
Route::get("/en/q-a" , "QuestionController@q_a");
Route::get("/en/categories" , "QuestionController@showCategories");

Route::get("/en/posts" , "PostController@index");
Route::get("/en/send-question" , "QuestionController@showSendQuestion");


Route::get("/en/app" , "OtherController@showApp");

Route::get("/en/login" , "UserController@showLogin");
Route::get("/en/register" , "UserController@showLogin");
Route::post("/en/login" , "UserController@login");
Route::post("/en/register" , "UserController@register");

