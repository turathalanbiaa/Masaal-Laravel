<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function login($lang)
    {
        return view("cPanel.$lang.main.login")->with(["lang"=>$lang]);
    }

    public function loginValidation(Request $request ,$lang)
    {
        $this->validate($request, [
            "username" => "required|min:6",
            "password" => "required|min:6"
        ], [
            "username.required" => "اسم المستخدم فارغ.",
            "username.min:6" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
            "password.required" => "كلمة المرور غير موجودة.",
            "password.min:6" => "يجب ان لاتقل كلمة المرور عن 6 حروف.",
        ]);

        $username = Input::get("username");
        $password = md5(Input::get("password"));

        $admin = Admin::where("username","=",$username)->where("password","=",$password)->first();

        if (is_null($admin))
            return redirect("/control-panel/$lang/login")->with('LoginMessage', "فشل تسجيل الدخول !!! أعد المحاولة مرة أخرى.");

        $_SESSION["ADMIN_ID"] = $admin->id;
        $_SESSION["ADMIN_NAME"] = $admin->name;
        $_SESSION["ADMIN_LANG"] = $admin->lang;
        $_SESSION["ADMIN_TYPE"] = $admin->type;
        $_SESSION["ADMIN_MANAGER"] = $admin->manager;
        $_SESSION["ADMIN_REVIEWER"] = $admin->reviewer;
        $_SESSION["ADMIN_DISTRIBUTOR"] = $admin->distributor;
        $_SESSION["ADMIN_RESPONDENT"] = $admin->respondent;
        $_SESSION["ADMIN_POST"] = $admin->post;
        $_SESSION["ADMIN_ANNOUNCEMENT"] = $admin->announcement;

        return redirect("/control-panel/$lang/main");
    }

    public function main($lang)
    {
        return view("cPanel.$lang.main.main");
    }

    public function manager($lang)
    {
        $admins = Admin::where("lang","=",$_SESSION["ADMIN_LANG"])
            ->where("type","=",$_SESSION["ADMIN_TYPE"])->get();

        return view("cPanel.$lang.manager.manager")->with(["admins" => $admins, "lang" => $lang]);
    }
}
