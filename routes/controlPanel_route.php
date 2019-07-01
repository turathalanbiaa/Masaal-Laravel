<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

//Routes for main
Route::get("control-panel", "ControlPanel\\MainController@index");
Route::get("control-panel/login", "ControlPanel\\LoginController@login");
Route::post("control-panel/login", "ControlPanel\\LoginController@loginValidation");
Route::get("control-panel/logout", "ControlPanel\\MainController@logout");


//Routes for admin
Route::resource("control-panel/admins", "ControlPanel\\AdminController");


/*routes for distributor*/
Route::get("/control-panel/distributor", "ControlPanel\\DistributorController@index");
Route::post("/control-panel/distributor/distribute-question/ajax", "ControlPanel\\DistributorController@distributeQuestion");
Route::post("/control-panel/distributor/delete-question/ajax", "ControlPanel\\DistributorController@deleteQuestion");
Route::post("/control-panel/distributor/change-type-question/ajax", "ControlPanel\\DistributorController@changeTypeQuestion");


//Routes for respondent
Route::get("/control-panel/respondent", "ControlPanel\\RespondentController@index");

Route::get("/control-panel/respondent/{question}/edit", "ControlPanel\\RespondentController@editQuestion");
Route::post("/control-panel/respondent/{question}", "ControlPanel\\RespondentController@answerQuestion");

Route::post("/control-panel/respondent/delete-question/ajax", "ControlPanel\\RespondentController@deleteQuestion");
Route::post("/control-panel/respondent/return-question/ajax", "ControlPanel\\RespondentController@returnQuestion");
Route::post("/control-panel/respondent/change-type-question/ajax", "ControlPanel\\RespondentController@changeTypeQuestion");

Route::get("/control-panel/respondent/my-answers", "ControlPanel\\RespondentController@myAnswers");
Route::get("/control-panel/respondent/my-answers/{question}/edit-answer", "ControlPanel\\RespondentController@editMyAnswer");
Route::post("/control-panel/respondent/my-answers/{question}/update-answer", "ControlPanel\\RespondentController@updateMyAnswer");

Route::get("/control-panel/respondent/answers", "ControlPanel\\RespondentController@answers");


//Routes for reviewer
Route::get("/control-panel/reviewer", "ControlPanel\\ReviewerController@index");
Route::get("/control-panel/reviewer/{question}/edit", "ControlPanel\\ReviewerController@editAnswer");
Route::post("/control-panel/reviewer/{question}", "ControlPanel\\ReviewerController@updateAnswer");
Route::post("/control-panel/reviewer/accept-answer/ajax", "ControlPanel\\ReviewerController@acceptAnswer");
Route::post("/control-panel/reviewer/reject-answer/ajax", "ControlPanel\\ReviewerController@rejectAnswer");
Route::post("/control-panel/reviewer/delete-question/ajax", "ControlPanel\\ReviewerController@deleteQuestion");


//Routes of post
Route::resource("/control-panel/posts", "ControlPanel\\PostController");


//Routes of announcement
Route::resource("/control-panel/announcements", "ControlPanel\\AnnouncementController");

//Routes of category
Route::resource("/control-panel/categories", "ControlPanel\\CategoryController");

//Routes of translator
Route::get("/control-panel/translator", function (){
    echo "<h1 style='text-align: center; margin-top: 300px;'>قريبا</h1>";
    return "";
});

//Routes for reports
Route::get("/control-panel/report", "ControlPanel\\ReportController@index");
Route::get("/control-panel/report/{type}/{privacy}/{category}", "ControlPanel\\ReportController@report");
