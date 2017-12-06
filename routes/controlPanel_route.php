<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

Route::get("/control-panel/{lang}/login", "AdminController@login")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/login/validation", "AdminController@loginValidation")->where("lang" , "en|ar|fr");

Route::get("/control-panel/{lang}/main", "AdminController@main")->where("lang" , "en|ar|fr");

/*route of manager*/
Route::get("/control-panel/{lang}/managers","AdminController@manager")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/managers/search","AdminController@searchManager")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/admin/info","AdminController@adminInfo")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/admin/delete","AdminController@adminDelete")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/admin/update","AdminController@adminUpdate")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/admin/create","AdminController@adminCreate")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/admin/create/validation","AdminController@adminCreateValidation")->where("lang" , "en|ar|fr");

/*route of distributor*/
Route::get("/control-panel/{lang}/distribution-questions","AdminController@distributeQuestionsToRespondents")->where("lang" , "en|ar|fr");
Route::post("/control-panel/distribution","AdminController@distribution");
Route::post("/control-panel/change-question-type","AdminController@changeQuestionType");

/*route of respondent*/
Route::get("/control-panel/{lang}/my-questions","AdminController@showQuestionToRespondent")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/question","AdminController@showQuestion")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/question-answer","AdminController@questionAnswer")->where("lang" , "en|ar|fr");

/*route of reviewer*/