<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("control-panel", "ControlPanel\\MainController@index");
Route::get("control-panel/login", "ControlPanel\\LoginController@login");
Route::post("control-panel/login", "ControlPanel\\LoginController@loginValidation");
Route::get("control-panel/logout", "ControlPanel\\MainController@logout");

Route::resource('control-panel/admins', 'ControlPanel\\AdminController');

Route::get("/control-panel/distributor", "ControlPanel\\DistributorController@index");
Route::post("/control-panel/distributor/distribute-question", "ControlPanel\\DistributorController@distributeQuestion");
Route::post("/control-panel/distributor/delete-question", "ControlPanel\\DistributorController@deleteQuestion");
Route::post("/control-panel/distributor/change-type-question", "ControlPanel\\DistributorController@changeTypeQuestion");


/*route of respondent*/
Route::get("/control-panel/{lang}/my-questions", "ControlPanel\\RespondentController@questions")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:respondent");
Route::get("/control-panel/{lang}/question", "ControlPanel\\RespondentController@question")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:respondent");
Route::post("/control-panel/{lang}/question-answer", "ControlPanel\\RespondentController@answer")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:respondent");
Route::post("/control-panel/respondent/delete-question", "ControlPanel\\RespondentController@deleteQuestion")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:respondent");


/*route of reviewer*/
Route::get("/control-panel/{lang}/reviewed-questions", "ControlPanel\\ReviewerController@questions")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");
Route::post("/control-panel/acceptAnswer", "ControlPanel\\ReviewerController@acceptAnswer")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");
Route::post("/control-panel/rejectAnswer", "ControlPanel\\ReviewerController@rejectAnswer")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");
Route::post("/control-panel/reviewer/delete-question", "ControlPanel\\ReviewerController@deleteQuestion")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");
Route::get("/control-panel/{lang}/info-question", "ControlPanel\\ReviewerController@infoQuestion")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");
Route::post("/control-panel/{lang}/update-answer", "ControlPanel\\ReviewerController@updateAnswer")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:reviewer");


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