<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("/control-panel/{lang}/main", "ControlPanel\\MainController@index")
    ->where("lang" , "en|ar|fr")
    ->middleware("loginAdminFromCookie");

Route::get("/control-panel/{lang}/login", "ControlPanel\\LoginController@login")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/login", "ControlPanel\\LoginController@loginValidation")->where("lang" , "en|ar|fr");

/*route of manager*/
Route::get("/control-panel/{lang}/managers","ControlPanel\\ManagerController@managers")
    ->where("lang" , "en|ar|fr")
    ->middleware("loginAdminFromCookie", "permission:manager");

Route::post("/control-panel/{lang}/admin/delete","ControlPanel\\ManagerController@delete")
    ->where("lang" , "en|ar|fr")
    ->middleware("loginAdminFromCookie", "permission:manager");

Route::get("/control-panel/{lang}/admin/info","ControlPanel\\ManagerController@info")
    ->where("lang" , "en|ar|fr")
    ->middleware("loginAdminFromCookie", "permission:manager");

Route::post("/control-panel/{lang}/admin/update","ControlPanel\\ManagerController@adminUpdate")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/admin/create","ControlPanel\\ManagerController@adminCreate")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/admin/create/validation","ControlPanel\\ManagerController@adminCreateValidation")->where("lang" , "en|ar|fr");






/*route of distributor*/
Route::get("/control-panel/{lang}/distribution-questions","AdminController@distributeQuestionsToRespondents")->where("lang" , "en|ar|fr");
Route::post("/control-panel/distribution","AdminController@distribution");
Route::post("/control-panel/change-question-type","AdminController@changeQuestionType");

/*route of respondent*/
Route::get("/control-panel/{lang}/my-questions","AdminController@showQuestionToRespondent")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/question","AdminController@showQuestion")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/question-answer","AdminController@questionAnswer")->where("lang" , "en|ar|fr");

/*route of reviewer*/
Route::get("/control-panel/{lang}/reviewed-questions","AdminController@reviewedQuestions")->where("lang" , "en|ar|fr");
Route::post("/control-panel/acceptAnswer","AdminController@acceptAnswer");
Route::post("/control-panel/rejectAnswer","AdminController@rejectAnswer");