<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{

    public function managers()
    {
        $currentAdmin = Input::get("currentAdmin");

        if (!is_null(Input::get("query")))
        {
            $query = Input::get("query");
            $admins = Admin::where("name", "like", "%" . $query . "%")
                ->where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("name")
                ->simplePaginate(25);
        } else {
            $admins = Admin::where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("id")
                ->simplePaginate(25);
        }

        return view("cPanel.$currentAdmin->lang.manager.managers")->with(["admins" => $admins, "lang" => $currentAdmin->lang]);
    }

    public function delete(Request $request)
    {
        $id = Input::get("id");
        $admin = Admin::find($id);

        if (!$admin)
            return ["notFound"=>true];

        $success = $admin->delete();
        if (!$success)
        {
            return ["success"=>false];
        }
        else
        {
            EventLogController::add($request, "DELETE ADMIN", $id);
            return ["success"=>true];
        }
    }

    public function info()
    {
        $currentAdmin = Input::get("currentAdmin");
        $id = Input::get("id");
        $admin = Admin::find($id);

        if (!$admin)
            return redirect("/control-panel/$currentAdmin->lang/managers")->with("InfoMessage","لا يوجد مثل هذا الحساب لكي يتم عرض معلوماته.");;

        return view("cPanel.$currentAdmin->lang.manager.info")->with(["admin"=>$admin, "lang"=>$currentAdmin->lang]);
    }

    public function update(Request $request, $lang)
    {
        $id = Input::get("id");
        $admin = Admin::find($id);

        if (!$admin)
            return redirect("/control-panel/$lang/managers")->with("UpdateMessage","لا يوجد مثل هذا الحساب لكي تتم عملية التعديل.");

        $rules = [
            "name" => "required|min:6",
            "username" => ['required','min:6',Rule::unique('admin')->ignore($id)],
            'password' => "confirmed"

        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ],
            "fr"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $admin->name = Input::get("name");
        $admin->username = Input::get("username");
        if (!is_null(Input::get("password")))
            $admin->password = md5(Input::get("password"));
        $admin->manager = Input::get("manager") ?: 0;
        $admin->reviewer = Input::get("reviewer") ?: 0;
        $admin->distributor = Input::get("distributor") ?: 0;
        $admin->respondent = Input::get("respondent") ?: 0;
        $admin->post = Input::get("post") ?: 0;
        $admin->announcement = Input::get("announcement") ?: 0;
        $success = $admin->save();

        EventLogController::add($request, "UPDATE ADMIN", $admin->id);

        if (!$success)
            return redirect("/control-panel/$lang/admin/info?id=$admin->id")->with("UpdateMessage","لم يتم التعديل، اعد المحاولة مرة اخرى.");

        return redirect("/control-panel/$lang/admin/info?id=$admin->id")->with("UpdateMessage","تم التعديل بنجاح.");
    }

    public function create($lang)
    {
        return view("cPanel.$lang.manager.create")->with(["lang" => $lang]);
    }

    public function createValidation(Request $request, $lang)
    {
        $rules = [
            "name" => "required|min:6",
            "username" => "required|min:6|unique:admin,username",
            'password' => "required|min:6|confirmed",
        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.required' => "كلمة المرور فارغة.",
                'password.min' => 'كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ],
            "fr"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.required' => "كلمة المرور فارغة.",
                'password.min' => 'كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $currentAdmin = Input::get("currentAdmin");

        $admin = new Admin();
        $admin->name = Input::get("name");
        $admin->username = Input::get("username");
        $admin->password = md5(Input::get("password"));
        $admin->type = $currentAdmin->type;
        $admin->lang = $currentAdmin->lang;
        $admin->date = date("Y-m-d");
        $admin->manager = Input::get("manager") ?: 0;
        $admin->reviewer = Input::get("reviewer") ?: 0;
        $admin->distributor = Input::get("distributor") ?: 0;
        $admin->respondent = Input::get("respondent") ?: 0;
        $admin->post = Input::get("post") ?: 0;
        $admin->announcement = Input::get("announcement") ?: 0;
        $success = $admin->save();

        EventLogController::add($request, "CREATE ADMIN", $admin->id);

        if (!$success)
            return redirect("/control-panel/$lang/admin/create")->with("CreateMessage","لم يتم انشاء الحساب بصورة صحيحة، اعد المحاولة مرة اخرى.");

        return redirect("/control-panel/$lang/admin/create")->with("CreateMessage","تم انشاء الحساب بنجاح.");
    }
}
