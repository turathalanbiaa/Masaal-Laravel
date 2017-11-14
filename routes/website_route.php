<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("/" , function(){return redirect("/ar/1");});
Route::get("/{lang}/{type}" , "QuestionController@index")->where("lang" , "en|ar|fr")->where("type" , "1|2");
Route::get("/{lang}/{type}" , "QuestionController@index")->where("lang" , "en|ar|fr")->where("type" , "1|2");
Route::get("/{lang}/index/{type}" , "QuestionController@index")->where("lang" , "en|ar|fr")->where("type" , "1|2");
Route::get("/{lang}/my-questions" , "QuestionController@my")->where("lang" , "en|ar|fr");
Route::post("/{lang}/search" , "QuestionController@search")->where("lang" , "en|ar|fr");
Route::get("/{lang}/search" , "QuestionController@searchBy")->where("lang" , "en|ar|fr");
Route::get("/{lang}/q-a" , "QuestionController@q_a")->where("lang" , "en|ar|fr");
Route::get("/{lang}/categories" , "QuestionController@showCategories")->where("lang" , "en|ar|fr");

Route::get("/{lang}/posts/{type}" , "PostController@index")->where("lang" , "en|ar|fr")->where("type" , "1|2");
Route::get("/{lang}/send-question" , "QuestionController@showSendQuestion")->where("lang" , "en|ar|fr");


Route::get("/{lang}/app" , "OtherController@showApp")->where("lang" , "en|ar|fr");

Route::get("/{lang}/login" , "UserController@showLogin")->where("lang" , "en|ar|fr");
Route::get("/{lang}/register" , "UserController@showLogin")->where("lang" , "en|ar|fr");
Route::post("/{lang}/login" , "UserController@login")->where("lang" , "en|ar|fr");
Route::post("/{lang}/register" , "UserController@register")->where("lang" , "en|ar|fr");
Route::get("/{lang}/single-question/{id}" , "QuestionController@showQuestion")->where("lang" , "en|ar|fr")->where("id" ,"[0-9]+");

