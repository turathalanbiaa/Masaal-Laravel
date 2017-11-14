<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Null_;

class AdminController extends Controller
{
    public function login($lang)
    {
        return view("cPanel.$lang.main.login")->with(["lang"=>$lang]);
    }

    public function loginValidation(Request $request ,$lang)
    {
        $rules = [
            "username" => "required|min:6",
            "password" => "required|min:6"
        ];

        $rulesMessage = [
            "ar"=>[
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:6" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "password.required" => "كلمة المرور غير موجودة.",
                "password.min:6" => "يجب ان لاتقل كلمة المرور عن 6 حروف."
            ],
            "fr"=>[
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:6" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "password.required" => "كلمة المرور غير موجودة.",
                "password.min:6" => "يجب ان لاتقل كلمة المرور عن 6 حروف."
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
        $admins = Admin::where("lang","=",$_SESSION["ADMIN_LANG"])->where("type","=",$_SESSION["ADMIN_TYPE"])->get();
        return view("cPanel.$lang.manager.managers")->with(["admins" => $admins, "lang" => $lang]);
    }

    public function searchManager($lang)
    {
        $query = Input::get("query");
        $admins = Admin::where("lang","=",$_SESSION["ADMIN_LANG"])
            ->where("type","=",$_SESSION["ADMIN_TYPE"])
            ->where("name","LIKE","%".$query."%")
            ->get();
        return view("cPanel.$lang.manager.managers")->with(["admins" => $admins, "lang" => $lang]);
    }

    public function adminInfo($lang)
    {
        $id = Input::get("id");
        $admin = Admin::find($id);

        if (is_null($admin))
            return redirect("/control-panel/$lang/manager")->with("InfoManagerMessage","لا يوجد مثل هذا الحساب لكي يتم عرض معلوماته.");;

        return view("cPanel.$lang.manager.admin_info")->with(["admin"=>$admin, "lang"=>$lang]);
    }

    public function adminDelete($lang)
    {
        $id = Input::get("adminId");
        $admin = Admin::find($id);

        if (is_null($admin))
            return redirect("/control-panel/$lang/managers")->with("DeleteManagerMessage","لا يوجد مثل هذا الحساب لكي يتم حذفه.");

        $success = $admin->delete();

        if (!$success)
            return redirect("/control-panel/$lang/managers")->with("DeleteManagerMessage","لم يتم حذف الحساب ، اعد المحاولة مرة أخرى.");

        return redirect("/control-panel/$lang/managers")->with("DeleteManagerMessage","تم حذف الحساب بشكل الصحيح.");
    }

    public function adminUpdate(Request $request, $lang)
    {
        $id = Input::get("id");

        $rules = [
            "name" => "required|min:6",
            "username" => ['required','min:6',Rule::unique('admin')->ignore($id)]
        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min:6" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:6" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد."
            ],
            "fr"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min:6" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min:6" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $manager = Input::get("manager") ?: 0;
        $manager = Input::get("manager") ?: 0;
        $manager = Input::get("manager") ?: 0;
        $manager = Input::get("manager") ?: 0;
        $manager = Input::get("manager") ?: 0;
        $manager = Input::get("manager") ?: 0;
    }
}
