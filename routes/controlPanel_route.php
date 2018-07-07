<?php
/**
 * Created by PhpStorm.
 * User: Emad
 * Date: 11/11/2017
 * Time: 2:12 PM
 */

/*route of main*/
Route::get("/control-panel/{lang}/", "ControlPanel\\MainController@index")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie");
Route::get("/control-panel/{lang}/main", "ControlPanel\\MainController@index")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie");
Route::get("/control-panel/{lang}/login", "ControlPanel\\LoginController@login")->where("lang" , "en|ar|fr");
Route::post("/control-panel/{lang}/login", "ControlPanel\\LoginController@loginValidation")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/logout", "ControlPanel\\MainController@logout")->where("lang" , "en|ar|fr");


/*route of manager*/
Route::get("/control-panel/{lang}/managers", "ControlPanel\\ManagerController@managers")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/admin/delete", "ControlPanel\\ManagerController@delete")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::get("/control-panel/{lang}/admin/info", "ControlPanel\\ManagerController@info")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/{lang}/admin/update", "ControlPanel\\ManagerController@update")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::get("/control-panel/{lang}/admin/create", "ControlPanel\\ManagerController@create")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");
Route::post("/control-panel/{lang}/admin/create", "ControlPanel\\ManagerController@createValidation")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:manager");


/*route of distributor*/
Route::get("/control-panel/{lang}/distribution-questions", "ControlPanel\\DistributorController@distributeQuestionsToRespondents")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");
Route::post("/control-panel/distributor/delete-question", "ControlPanel\\DistributorController@deleteQuestion")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");
Route::post("/control-panel/distribution", "ControlPanel\\DistributorController@distribution")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");
Route::post("/control-panel/change-question-type", "ControlPanel\\DistributorController@changeQuestionType")->where("lang" , "en|ar|fr")->middleware("loginAdminFromCookie", "permission:distributor");


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