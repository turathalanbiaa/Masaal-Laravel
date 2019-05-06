<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\TargetName;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{

    /**
     * Display managers
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                ->simplePaginate(20);
        } else {
            $admins = Admin::where("lang", $currentAdmin->lang)
                ->where("type", $currentAdmin->type)
                ->orderBy("id")
                ->simplePaginate(20);
        }

        return view("cPanel.$currentAdmin->lang.manager.managers")->with([
            "admins" => $admins,
            "lang" => $currentAdmin->lang
        ]);
    }

    /**
     * Remove manager
     *
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $id = Input::get("id");
        $admin = Admin::find($id);

        if (!$admin)
            return ["notFound"=>true];

        $success = $admin->delete();

        if (!$success)
            return ["success"=>false];

        EventLogController::add($request, "DELETE ADMIN", TargetName::ADMIN, $id);
        return ["success"=>true];
    }

    /**
     * Edit account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        $currentAdmin = Input::get("currentAdmin");
        $id = Input::get("id");
        $admin = Admin::findOrFail($id);

        return view("cPanel.$currentAdmin->lang.manager.info")->with([
            "admin"=>$admin,
            "lang"=>$currentAdmin->lang
        ]);
    }

    /**
     * Update account
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $currentAdmin = Input::get("currentAdmin");
        $id = Input::get("id");
        $admin = Admin::findOrFail($id);

        $rules = [
            "name" => "required|min:6",
            "username" => ['required','min:6',Rule::unique('admin')->ignore($id)],
            'password' => "min:6|confirmed"
        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.min' => 'يجب ان تكون كلمة المرور لا تقل عن 6 حروف.',
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ],
            "fr"=>[
                "name.required" => "Le vrai nom est vide.",
                "name.min" => "Le vrai nom doit comporter au moins 6 caractères.",
                "username.required" => "Le nom d'utilisateur est vide.",
                "username.min" => "Le nom d'utilisateur doit comporter au moins 6 caractères.",
                "username.unique" => "Un autre utilisateur portant le même nom, veuillez utiliser un nouveau nom d'utilisateur.",
                'password.min' => 'Le mot de passe doit comporter au moins 6 caractères.',
                'password.confirmed' => 'Les deux mots de passe ne correspondent pas.'
            ]
        ];

        if ($currentAdmin->lang == "en")
            $this->validate($request, $rules, []);

        if ($currentAdmin->lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($currentAdmin->lang == "fr")
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

        EventLogController::add($request, "UPDATE ADMIN", TargetName::ADMIN, $admin->id);

        if (!$success)
            return redirect("/control-panel/$currentAdmin->lang/admin/info?id=$admin->id")->with([
                "ArInfoMessage" => "لم يتم حفظ أي تغييرات ، يرجى اعادة المحاولة.",
                "EnInfoMessage" => "No changes saved, please try again.",
                "FrInfoMessage" => "Aucun changement enregistré, veuillez réessayer."
            ]);

        return redirect("/control-panel/$currentAdmin->lang/admin/info?id=$admin->id")->with([
            "ArInfoMessage" => "تم حفظ التغييرات بنجاح.",
            "EnInfoMessage" => "Changes saved successfully.",
            "FrInfoMessage" => "Les modifications ont bien été enregistrées."
        ]);
    }

    /**
     * Create new account
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $currentAdmin = Input::get("currentAdmin");
        return view("cPanel.$currentAdmin->lang.manager.create")->with([
            "lang" => $currentAdmin->lang
        ]);
    }

    /**
     * Store account
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $currentAdmin = Input::get("currentAdmin");

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
                "password.required" => "كلمة المرور فارغة.",
                "password.min" => "يجب ان تكون كلمة المرور لاتقل عن 6 حروف.",
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ],
            "fr"=>[
                "name.required" => "Le vrai nom est vide.",
                "name.min" => "Le vrai nom doit comporter au moins 6 caractères.",
                "username.required" => "Le nom d'utilisateur est vide.",
                "username.min" => "Le nom d'utilisateur doit comporter au moins 6 caractères.",
                "username.unique" => "Un autre utilisateur portant le même nom, veuillez utiliser un nouveau nom d'utilisateur.",
                "password.required" => "Le mot de passe est vide.",
                "password.min" => "Le mot de passe doit comporter au moins 6 caractères.",
                'password.confirmed' => 'Les deux mots de passe ne correspondent pas.'
            ]
        ];

        if ($currentAdmin->lang == "en")
            $this->validate($request, $rules, []);

        if ($currentAdmin->lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($currentAdmin->lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

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

        EventLogController::add($request, "CREATE ADMIN",TargetName::ADMIN, $admin->id);

        if (!$success)
            return redirect("/control-panel/$currentAdmin->lang/admin/create")->with([
                "ArInfoMessage" => "لم يتم انشاء الحساب بصورة صحيحة، يرجى اعادة المحاولة.",
                "EnInfoMessage" => "Account not created correctly, please try again.",
                "FrInfoMessage" => "Le compte n'a pas été créé correctement. Veuillez réessayer."
            ]);

        return redirect("/control-panel/$currentAdmin->lang/admin/create")->with([
            "ArInfoMessage" => "تم انشاء الحساب بنجاح.",
            "EnInfoMessage" => "Account successfully created.",
            "FrInfoMessage" => "Compte créé avec succès."
        ]);
    }
}