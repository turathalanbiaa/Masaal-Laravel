<?php


Route::post("question/new" , "API\\QuestionController@createNewQuestion");
Route::post("question/recent" , "API\\QuestionController@recentQuestionsWithAnnouncements");
Route::post("question/search" , "API\\QuestionController@search");
Route::post("question/searchByTag" , "API\\QuestionController@searchByTag");
Route::post("question/my" , "API\\QuestionController@myQuestions");


Route::post("post/recent" , "API\\PostController@recentPosts");



Route::post("tag/all" , "API\\TagController@all");