<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    public function login($lang)
    {
        return view("cPanel.$lang.main.login")->with(["lang"=>$lang]);
    }

    public function loginValidation(Request $request ,$lang)
    {
        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $rulesMessage = [
            "ar"=>[
                "username.required" => "يرجى ادخال اسم المستخدم.",
                "password.required" => "يرجى ادخال كلمة المرور."
            ],
            "fr"=>[
                "username.required" => "اسم المستخدم فارغ.",
                "password.required" => "كلمة المرور غير موجودة."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $username = Input::get("username");
        $password = md5(Input::get("password"));

        $admin = Admin::where("username","=",$username)->where("password","=",$password)->first();

        if (!$admin)
            return redirect("/control-panel/$lang/login")->with('ErrorRegisterMessage', "فشل تسجيل الدخول !!! أعد المحاولة مرة أخرى.");

        $session = md5(uniqid());
        $admin->session = $session;
        $admin->save();
        $request->session()->put('ADMIN_SESSION' , $admin->session);

        return redirect("/control-panel/$lang/main")->withCookie(cookie('ADMIN_SESSION' , $admin->session , 1000000000));
    }
}
