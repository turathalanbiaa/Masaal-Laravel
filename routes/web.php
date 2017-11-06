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

Route::get("/" , function(){return redirect("/ar/");});
Route::get("/{lang}" , "QuestionController@index")->where("lang" , "en|ar|fr");
Route::get("/{lang}/" , "QuestionController@index")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/index" , "QuestionController@index")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/my-questions" , "QuestionController@my")->where("lang" , "en|ar|fr");;
Route::post("/{lang}/search" , "QuestionController@search")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/search" , "QuestionController@searchBy")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/q-a" , "QuestionController@q_a")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/categories" , "QuestionController@showCategories")->where("lang" , "en|ar|fr");;

Route::get("/{lang}/posts" , "PostController@index")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/send-Question" , "QuestionController@showSendQuestion")->where("lang" , "en|ar|fr");;


Route::get("/{lang}/app" , "OtherController@showApp")->where("lang" , "en|ar|fr");;

Route::get("/{lang}/login" , "UserController@showLogin")->where("lang" , "en|ar|fr");;
Route::get("/{lang}/register" , "UserController@showLogin")->where("lang" , "en|ar|fr");;
Route::post("/{lang}/login" , "UserController@login")->where("lang" , "en|ar|fr");;
Route::post("/{lang}/register" , "UserController@register")->where("lang" , "en|ar|fr");;

