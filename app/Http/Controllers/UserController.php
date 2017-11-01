<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/31/2017
 * Time: 12:12 AM
 */

namespace App\Http\Controllers;


class UserController extends Controller
{

    public function showLogin($lang)
    {
        return view("$lang.user.login_and_create");
    }

    public function login($lang)
    {
        return redirect("/$lang/");
    }

    public function register($lang)
    {
        return redirect("/$lang/");
    }

}