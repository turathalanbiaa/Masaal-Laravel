<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\EventLogType;
use App\Enums\QuestionType;
use App\Models\Admin;
use App\Models\EventLog;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
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
        $admins = is_null(Input::get("q"))?
            Admin::where("lang", $lang)
                ->where("type", $type)
                ->paginate(25):
            Admin::where("name", "like", "%".Input::get("q")."%")
                ->where("lang", $lang)
                ->where("type", $type)
                ->paginate(25);

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
                "name.required" => "حقل الاسم مطلوب.",
                "name.min" => "يجب أن يكون الاسم من 6 احرف على الأقل.",
                "username.required" => "حقل اسم المستخدم مطلوب.",
                "username.min" => "يجب أن يكون اسم المستخدم من 6 أحرف على الأقل.",
                "username.unique" => "اسم المستخدم مأخوذ بالفعل.",
                "password.required" => "حقل كلمة المرور مطلوب.",
                "password.min" => "يجب أن تكون كلمة المرور من 6 أحرف على الأقل.",
                'password.confirmed' => "تأكيد كلمة المرور غير متطابق."
            ],
            "fr"=>[
                "name.required" => "Le champ Nom est obligatoire.",
                "name.min" => "Le nom doit comporter au moins 6 caractères.",
                "username.required" => "Le champ Nom d'utilisateur est obligatoire.",
                "username.min" => "Le nom d'utilisateur doit comporter au moins 6 caractères.",
                "username.unique" => "Le nom d'utilisateur est déjà pris.",
                "password.required" => "Le champ mot de passe est obligatoire.",
                "password.min" => "Le mot de passe doit comporter au moins 6 caractères.",
                'password.confirmed' => "La confirmation du mot de passe ne correspond pas."
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

            //Store permission
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
                "ArCreateAdminMessage" => "تم انشاء الحساب بنجاح",
                "EnCreateAdminMessage" => "Account successfully created",
                "FrCreateAdminMessage" => "compte supprimé avec succès"
            ]);
        else
            return redirect("/control-panel/admins/create")->with([
                "ArCreateAdminMessage" => "لم يتم انشاء الحساب بصورة صحيحة، يرجى اعادة المحاولة",
                "EnCreateAdminMessage" => "Account not created correctly, please try again",
                "FrCreateAdminMessage" => "Le compte n'a pas été créé correctement. Veuillez réessayer",
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
        return abort(404);
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
                "name.required" => "حقل الاسم مطلوب.",
                "name.min" => "يجب أن يكون الاسم من 6 احرف على الأقل.",
                "username.required" => "حقل اسم المستخدم مطلوب.",
                "username.min" => "يجب أن يكون اسم المستخدم من 6 أحرف على الأقل.",
                "username.unique" => "اسم المستخدم مأخوذ بالفعل."
            ],
            "fr"=>[
                "name.required" => "Le champ Nom est obligatoire.",
                "name.min" => "Le nom doit comporter au moins 6 caractères.",
                "username.required" => "Le champ Nom d'utilisateur est obligatoire.",
                "username.min" => "Le nom d'utilisateur doit comporter au moins 6 caractères.",
                "username.unique" => "Le nom d'utilisateur est déjà pris."
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
            //Update admin
            $admin->name = Input::get("name");
            $admin->username = Input::get("username");
            $admin->save();

            //Update permission
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
                "ArUpdateAdminMessage" => "تم حفظ التغييرات بنجاح",
                "EnUpdateAdminMessage" => "Changes saved successfully",
                "FrUpdateAdminMessage" => "Les modifications ont bien été enregistrées"
            ]);
        else
            return redirect("/control-panel/admins/$admin->id/edit")->with([
                "ArUpdateAdminMessage" => "لم يتم حفظ أي تغييرات ، يرجى اعادة المحاولة",
                "EnUpdateAdminMessage" => "No changes saved, please try again",
                "FrUpdateAdminMessage" => "Aucun changement enregistré, veuillez réessayer"
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
        //Transaction
        $exception = DB::transaction(function () use ($admin){
            //Change specific respondent to default respondent
            self::changeRespondent($admin);

            dd("Stop");
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
            return redirect("/control-panel/admins")->with([
                "ArDeleteAdminMessage" => "تم حذف الحساب بنجاح",
                "EnDeleteAdminMessage" => "Account successfully deleted",
                "FrDeleteAdminMessage" => "Compte supprimé avec succès"
            ]);
        else
            return redirect("/control-panel/admins")->with([
                "ArDeleteAdminMessage" => "لم يتم حذف الحساب بنجاح",
                "EnDeleteAdminMessage" => "The account was not deleted successfully",
                "FrDeleteAdminMessage" => "Le compte n'a pas été supprimé avec succès",
                "TypeMessage" => "Error"
            ]);
    }

    public static function changeRespondent($admin)
    {
        self::changeRespondentQuestionsUnanswered($admin);
        self::changeRespondentQuestionsUnderReview($admin);
        self::changeRespondentQuestionsPublished($admin);
    }

    public static function changeRespondentQuestionsUnanswered($currentAdmin)
    {
        $questions = $currentAdmin->questionsUnanswered()->get();
        if (!is_null($questions))
            foreach ($questions as $question)
            {
                $question->adminId = null;
                $question->save();
            }
    }

    public static function changeRespondentQuestionsUnderReview($currentAdmin)
    {
        $questions = $currentAdmin->questionsUnanswered()->get();
        if (!is_null($questions))
            foreach ($questions as $question)
            {
                //Remove tags
                foreach ($question->QuestionTags as $tag)
                    $tag->delete();

                //Remove image
                Storage::disk('public')->delete($question->image);

                //Remove answer
                $question->image = null;
                $question->answer = null;
                $question->categoryId = null;
                $question->status = QuestionStatus::NO_ANSWER;
                $question->videoLink = null;
                $question->externalLink = null;
                $question->adminId = null;
                $question->save();
            }
    }

    public static function changeRespondentQuestionsPublished($currentAdmin)
    {
        $experimentalAdminId = self::getExperimentalAdminId();
        $questions = $currentAdmin->questionsPublished()->get();
        if (!is_null($questions))
            foreach ($questions as $question)
            {
                $question->adminId = $experimentalAdminId;
                $question->save();
            }
    }

    public static function getExperimentalAdminId()
    {
        $lang = AdminController::getLang();
        $type = AdminController::getType();

        switch ($lang)
        {
            case "ar":
                switch ($type)
                {
                    case QuestionType::FEQHI: return 16; break;
                    case QuestionType::AKAEDI: return 17; break;
                } break;
            case "en":
                switch ($type)
                {
                    case QuestionType::FEQHI: return 18; break;
                    case QuestionType::AKAEDI: return 19; break;
                } break;
            case "fr":
                switch ($type)
                {
                    case QuestionType::FEQHI: return 20; break;
                    case QuestionType::AKAEDI: return 21; break;
                } break;
        }
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
