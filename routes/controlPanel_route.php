<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

/*routes for main*/
Route::get("control-panel", "ControlPanel\\MainController@index");
Route::get("control-panel/login", "ControlPanel\\LoginController@login");
Route::post("control-panel/login", "ControlPanel\\LoginController@loginValidation");
Route::get("control-panel/logout", "ControlPanel\\MainController@logout");


/*routes for admin*/
Route::resource('control-panel/admins', 'ControlPanel\\AdminController');


/*routes for distributor*/
Route::get("/control-panel/distributor", "ControlPanel\\DistributorController@index");
Route::post("/control-panel/distributor/distribute-question", "ControlPanel\\DistributorController@distributeQuestion");
Route::post("/control-panel/distributor/delete-question", "ControlPanel\\DistributorController@deleteQuestion");
Route::post("/control-panel/distributor/change-type-question", "ControlPanel\\DistributorController@changeTypeQuestion");


/*route for respondent*/
Route::get("/control-panel/respondent", "ControlPanel\\RespondentController@index");
Route::get("/control-panel/respondent/{question}/edit", "ControlPanel\\RespondentController@editQuestion");
Route::post("/control-panel/respondent/{question}", "ControlPanel\\RespondentController@answerQuestion");
Route::post("/control-panel/respondent/return-question", "ControlPanel\\RespondentController@returnQuestion");
Route::post("/control-panel/respondent/delete-question", "ControlPanel\\RespondentController@deleteQuestion");
Route::post("/control-panel/respondent/change-type-question", "ControlPanel\\RespondentController@changeTypeQuestion");

Route::get("/control-panel/respondent/my-answers", "ControlPanel\\RespondentController@myAnswers");
Route::get("/control-panel/respondent/my-answers/{question}/edit-answer", "ControlPanel\\RespondentController@editMyAnswer");
Route::post("/control-panel/respondent/my-answers/{question}/update-answer", "ControlPanel\\RespondentController@updateMyAnswer");

Route::get("/control-panel/respondent/answers", "ControlPanel\\RespondentController@answers");


/*route for reviewer*/
Route::get("/control-panel/reviewer", "ControlPanel\\ReviewerController@index");
Route::get("/control-panel/reviewer/{question}/edit", "ControlPanel\\ReviewerController@editQuestion");
Route::post("/control-panel/reviewer/{question}", "ControlPanel\\ReviewerController@updateAnswer");
Route::post("/control-panel/reviewer/accept-answer", "ControlPanel\\ReviewerController@acceptAnswer");
Route::post("/control-panel/reviewer/reject-answer", "ControlPanel\\ReviewerController@rejectAnswer");
Route::post("/control-panel/reviewer/delete-question", "ControlPanel\\ReviewerController@deleteQuestion");









/*route of post*/
Route::get("/control-panel/{lang}/posts", "ControlPanel\\PostController@posts")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:post");
Route::post("/control-panel/post/delete", "ControlPanel\\PostController@delete")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:post");
Route::get("/control-panel/{lang}/post/create", "ControlPanel\\PostController@create")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:post");
Route::post("/control-panel/{lang}/post/create", "ControlPanel\\PostController@createValidation")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:post");


/*route of announcement*/
Route::get("/control-panel/{lang}/announcements", "ControlPanel\\AnnouncementController@announcements")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:announcement");
Route::post("/control-panel/announcement/delete", "ControlPanel\\AnnouncementController@delete")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:announcement");
Route::post("/control-panel/announcement/active", "ControlPanel\\AnnouncementController@active")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:announcement");
Route::get("/control-panel/{lang}/announcement/create", "ControlPanel\\AnnouncementController@create")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:announcement");
Route::post("/control-panel/{lang}/announcement/create", "ControlPanel\\AnnouncementController@createValidation")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:announcement");