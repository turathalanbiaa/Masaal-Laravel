<?php


Route::post("question/new" , "API\\QuestionController@createNewQuestion");
Route::post("question/recent" , "API\\QuestionController@recentQuestionsWithAnnouncements");
Route::post("question/search" , "API\\QuestionController@search");
Route::post("question/searchByTag" , "API\\QuestionController@searchByTag");
Route::post("question/my" , "API\\QuestionController@myQuestions");

Route::post("post/recent" , "API\\PostController@recentPosts");

Route::post("tag/all" , "API\\TagController@all");


Route::post("settings/change/name" , "API\\SettingsController@changeName");

Route::get("notification/send-to-device" , "API\\NotificationController@sendToDevice");
Route::post("notification/set-firebase-token" , "API\\NotificationController@registerToken");

Route::post("setup" , "API\\SettingsController@setup");



Route::get("aqaed/getSubject/{root_id}" , "API\\AqaedController@getSubject");
Route::get("aqaed/getContent/{id}" , "API\\AqaedController@getContent");