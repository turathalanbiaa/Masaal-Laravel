<?php


Route::get("question/new" , "API\\QuestionController@createNewQuestion");
Route::post("question/recent" , "API\\QuestionController@recentQuestionsWithAnnouncements");