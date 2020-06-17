<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/31/2017
 * Time: 12:12 AM
 */

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function showLogin(Request $request, $lang )
    {

        if ($request->session()->has('USER_ID'))
            return redirect("/$lang/1");

        return view("$lang.user.login_and_create");
    }

    public function login(Request $request  , $lang)
    {

        $username = Input::get("username", "");
        $password = Input::get("password" , "");

        $user = User::where("username" , $username)->where("password" , $password)->first();
        if($user)
        {
            $request->session()->put("USER_ID" , $user->id);
            $session = md5(uniqid());
            $user->session = $session;
            $user->save();
            return redirect("/$lang/1")->withCookie(cookie('SESSION' , $session))->withCookie(cookie('USER_ID' , $user->id));
        }
        else
        {
            return redirect()->back()->withErrors(['USERNAME OR PASSWORD INCORRECT']);
        }
    }

    public function logout(Request $request , $lang)
    {
        $request->session()->remove('USER_ID');
        return redirect("/$lang/login")->withCookie(cookie('SESSION' , null , -1))->withCookie(cookie('USER_ID' , null , -1));
    }


    public function register($lang, Request $request)
    {

        $rules = [
            "username" => "required|min:4|unique:user,username",
            "password" => "required|min:6",
            "name" => "required|min:6"
        ];

        $rulesMessage = [
            "ar" => [
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:4" => "يجب ان يكون اسم المستخدم لايقل عن 4 حروف.",
                "username.unique" => "هذا المُعرف مستخدم",
                "password.required" => "اكتب كلمة المرور.",
                "password.min:6" => "يجب ان لاتقل كلمة المرور عن 6 حروف.",
                "name.required" => "حقل الاسم فارغ.",
                "name.min:6" => "يجب ان الاسم عن 6 حروف."

            ],
            "fr" => [
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:4" => "يجب ان يكون اسم المستخدم لايقل عن 4 حروف.",
                "username.unique" => "هذا المُعرف مستخدم",
                "password.required" => "اكتب كلمة المرور.",
                "password.min:6" => "يجب ان لاتقل كلمة المرور عن 6 حروف.",
                "name.required" => "حقل الاسم فارغ.",
                "name.min:6" => "يجب ان الاسم عن 6 حروف."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $name = Input::get("name");
        $password = Input::get("password");
        $username = Input::get("username");
        $time = date("Y-m-d h:m:s");
        $deviceType = 3;
        $deviceUUID = "";
        $user = new User();
        $user->name = $name;
        $user->password = $password;
        $user->registrationDate = $time;
        $user->username = $username;
        $user->deviceType = $deviceType;
        $user->deviceUUID = $deviceUUID;

        $session = md5(uniqid());
        $user->session = $session;
        $user->save();

        $request->session()->put("USER_ID" , $user->id);

        return redirect("/$lang/1")->withCookie(cookie('SESSION' , $session));
    }


}