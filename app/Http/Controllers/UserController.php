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

    public function showLogin()
    {
        return view("en.user.login_and_create");
    }

    public function login()
    {
        return redirect("/en/");
    }

    public function register()
    {
        return redirect("/en/");
    }

}