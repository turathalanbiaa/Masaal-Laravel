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
Route::get("/control-panel/{lang}/manager","AdminController@manager")->where("lang" , "en|ar|fr");
Route::get("/control-panel/{lang}/admin-info-{id}",function ($lang){return view("cPanel.$lang.manager.manager");})->where("lang" , "en|ar|fr");