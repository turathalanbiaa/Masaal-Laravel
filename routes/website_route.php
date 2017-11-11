<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("/" , function(){return redirect("/ar/");});
Route::get("/{lang}" , "QuestionController@index")->where("lang" , "en|ar|fr");
Route::get("/{lang}/" , "QuestionController@index")->where("lang" , "en|ar|fr");
Route::get("/{lang}/index" , "QuestionController@index")->where("lang" , "en|ar|fr");
Route::get("/{lang}/my-questions" , "QuestionController@my")->where("lang" , "en|ar|fr");
Route::post("/{lang}/search" , "QuestionController@search")->where("lang" , "en|ar|fr");
Route::get("/{lang}/search" , "QuestionController@searchBy")->where("lang" , "en|ar|fr");
Route::get("/{lang}/q-a" , "QuestionController@q_a")->where("lang" , "en|ar|fr");
Route::get("/{lang}/categories" , "QuestionController@showCategories")->where("lang" , "en|ar|fr");

Route::get("/{lang}/posts" , "PostController@index")->where("lang" , "en|ar|fr");
Route::get("/{lang}/send-question" , "QuestionController@showSendQuestion")->where("lang" , "en|ar|fr");


Route::get("/{lang}/app" , "OtherController@showApp")->where("lang" , "en|ar|fr");

Route::get("/{lang}/login" , "UserController@showLogin")->where("lang" , "en|ar|fr");
Route::get("/{lang}/register" , "UserController@showLogin")->where("lang" , "en|ar|fr");
Route::post("/{lang}/login" , "UserController@login")->where("lang" , "en|ar|fr");
Route::post("/{lang}/register" , "UserController@register")->where("lang" , "en|ar|fr");
Route::get("/{lang}/single-question/{id}" , "QuestionController@showQuestion")->where("lang" , "en|ar|fr")->where("id" ,"[0-9]+");

