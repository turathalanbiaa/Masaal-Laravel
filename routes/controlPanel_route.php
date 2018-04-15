<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("/control-panel/{lang}/main", "ControlPanel\\MainController@index")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie");
Route::get("/control-panel/{lang}/login", "ControlPanel\\LoginController@login")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/login", "ControlPanel\\LoginController@loginValidation")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/logout", "ControlPanel\\MainController@logout")->where("lang" , "en|ar|fr");

/*route of manager*/
Route::get("/control-panel/{lang}/managers", "ControlPanel\\ManagerController@managers")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/{lang}/admin/delete", "ControlPanel\\ManagerController@delete")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::get("/control-panel/{lang}/admin/info", "ControlPanel\\ManagerController@info")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/{lang}/admin/update", "ControlPanel\\ManagerController@update")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::get("/control-panel/{lang}/admin/create", "ControlPanel\\ManagerController@create")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/{lang}/admin/create", "ControlPanel\\ManagerController@createValidation")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");

/*route of distributor*/
Route::get("/control-panel/{lang}/distribution-questions", "ControlPanel\\DistributorController@distributeQuestionsToRespondents")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");
Route::post("/control-panel/distribution", "ControlPanel\\DistributorController@distribution")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");
Route::post("/control-panel/change-question-type", "ControlPanel\\DistributorController@changeQuestionType")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");

/*route of respondent*/
Route::get("/control-panel/{lang}/my-questions","AdminController@showQuestionToRespondent")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/question","AdminController@showQuestion")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/question-answer","AdminController@questionAnswer")->where("lang" , "en|ar|fr");

/*route of reviewer*/
Route::get("/control-panel/{lang}/reviewed-questions","AdminController@reviewedQuestions")->where("lang" , "en|ar|fr");
Route::post("/control-panel/acceptAnswer","AdminController@acceptAnswer");
Route::post("/control-panel/rejectAnswer","AdminController@rejectAnswer");