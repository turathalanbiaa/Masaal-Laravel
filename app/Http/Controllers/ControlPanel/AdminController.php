<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\EventLogType;
use App\Models\Admin;
use App\Models\EventLog;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::check();
        $lang = self::getLang();
        $type = self::getType();
        $query = Input::get("query");
        $admins = is_null($query)?
            Admin::where("lang", $lang)
                ->where("type", $type)
                ->simplePaginate(20):
            $admins = Admin::where("name", "like", "%" . $query . "%")
                ->where("lang", $lang)
                ->where("type", $type)
                ->simplePaginate(20);

        return view("control-panel.$lang.admin.index")->with([
            "admins" => $admins
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::check();
        $lang = self::getLang();
        return view("control-panel.$lang.admin.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Auth::check();
        $lang = self::getLang();
        $type = self::getType();
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

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($lang, $type) {
            //Store Admin
            $admin = new Admin();
            $admin->name = Input::get("name");
            $admin->username = Input::get("username");
            $admin->password = md5(Input::get("password"));
            $admin->type = $type;
            $admin->lang = $lang;
            $admin->last_login_date = null;
            $admin->remember_token = null;
            $admin->save();

            //Store permission for the admin
            $permission = new Permission();
            $permission->admin_id = $admin->id;
            $permission->manager = Input::get("manager") ?: 0;
            $permission->distributor = Input::get("distributor") ?: 0;
            $permission->respondent = Input::get("respondent") ?: 0;
            $permission->reviewer = Input::get("reviewer") ?: 0;
            $permission->post = Input::get("post") ?: 0;
            $permission->announcement = Input::get("announcement") ?: 0;
            $permission->translator = Input::get("translator") ?: 0;
            $permission->save();

            //Store event log
            $target = $admin->id;
            $type = EventLogType::ADMIN;
            $event = "اضافة حساب من قبل المدير " . self::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/admins/create")->with([
                "ArCreateAdminMessage" => "تم انشاء الحساب بنجاح.",
                "EnCreateAdminMessage" => "Account successfully created.",
                "FrCreateAdminMessage" => "compte supprimé avec succès."
            ]);
        else
            return redirect("/control-panel/admins/create")->with([
                "ArCreateAdminMessage" => "لم يتم انشاء الحساب بصورة صحيحة، يرجى اعادة المحاولة.",
                "EnCreateAdminMessage" => "Account not created correctly, please try again.",
                "FrCreateAdminMessage" => "Le compte n'a pas été créé correctement. Veuillez réessayer.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        Auth::check();
        $lang = self::getLang();
        return view("control-panel.$lang.admin.edit")->with([
            "admin"=>$admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Admin $admin)
    {
        Auth::check();
        $lang = self::getLang();
        $rules = [
            "name" => "required|min:6",
            "username" => ['required','min:6',Rule::unique('admin')->ignore($admin->id)]
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

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($lang, $admin) {
            //Update Admin
            $admin->name = Input::get("name");
            $admin->username = Input::get("username");
            $admin->save();

            //Update permission for the admin
            $permission = $admin->permission;
            $permission->manager = Input::get("manager") ?: 0;
            $permission->distributor = Input::get("distributor") ?: 0;
            $permission->respondent = Input::get("respondent") ?: 0;
            $permission->reviewer = Input::get("reviewer") ?: 0;
            $permission->post = Input::get("post") ?: 0;
            $permission->announcement = Input::get("announcement") ?: 0;
            $permission->translator = Input::get("translator") ?: 0;
            $permission->save();

            //Store event log
            $target = $admin->id;
            $type = EventLogType::ADMIN;
            $event = "تحديث معلومات الحساب من قبل المدير " . self::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/admins")->with([
                "ArUpdateAdminMessage" => "تم حفظ التغييرات بنجاح.",
                "EnUpdateAdminMessage" => "Changes saved successfully.",
                "FrUpdateAdminMessage" => "Les modifications ont bien été enregistrées."
            ]);
        else
            return redirect("/control-panel/admins/$admin->id/edit")->with([
                "ArUpdateAdminMessage" => "لم يتم حفظ أي تغييرات ، يرجى اعادة المحاولة.",
                "EnUpdateAdminMessage" => "No changes saved, please try again.",
                "FrUpdateAdminMessage" => "Aucun changement enregistré, veuillez réessayer."
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Admin $admin
     * @return array
     * @throws \Exception
     */
    public function destroy(Admin $admin)
    {
        Auth::check();
        if (!$admin)
            return ["notFound"=>true];

        //Transaction
        $exception = DB::transaction(function () use ($admin){
            //Remove permission
            $admin->permission->delete();

            //Remove admin
            $admin->delete();

            //Store event log
            $target = $admin->id;
            $type = EventLogType::ADMIN;
            $event = "حذف الحساب من قبل المدير " . self::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success"=>true];
        else
            return ["success"=>false];
    }

    /**
     * Get current admin id.
     * @return mixed
     */
    public static function getId()
    {
        return session()->get("MASAEL_CP_ADMIN_ID");
    }

    /**
     * Get current admin name.
     *
     * @return mixed
     */
    public static function getName()
    {
        return session()->get("MASAEL_CP_ADMIN_NAME");
    }

    /**
     * Get current admin language.
     *
     * @return mixed
     */
    public static function getLang()
    {
        return session()->get("MASAEL_CP_ADMIN_LANG");
    }

    /**
     * Get current admin type.
     *
     * @return mixed
     */
    public static function getType()
    {
        return session()->get("MASAEL_CP_ADMIN_TYPE");
    }

    public static function getPermission()
    {
        return session()->get("MASAEL_CP_PERMISSION");
    }
}
