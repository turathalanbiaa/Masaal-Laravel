<?php


Route::get("question/new" , "API\\QuestionController@createNewQuestion");
Route::get("question/recent" , "API\\QuestionController@recentQuestionsWithAnnouncements");