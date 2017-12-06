<?php

namespace App\Http\Controllers;

use App\Enums\QuestionStatus;
use App\Enums\QuestionType;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

    /* Managers */
    public function manager($lang)
    {
        $admins = Admin::where("lang",$_SESSION["ADMIN_LANG"])->where("type",$_SESSION["ADMIN_TYPE"])->get();
        return view("cPanel.$lang.manager.managers")->with(["admins" => $admins, "lang" => $lang]);
    }

    public function searchManager($lang)
    {
        $query = Input::get("query");
        $admins = Admin::where("lang",$_SESSION["ADMIN_LANG"])
            ->where("type",$_SESSION["ADMIN_TYPE"])
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
        $admin = Admin::find($id);

        if (is_null($admin))
            return redirect("/control-panel/$lang/managers")->with("UpdateManagerMessage","لا يوجد مثل هذا الحساب لكي يتم عملية التعديل.");

        $rules = [
            "name" => "required|min:6",
            "username" => ['required','min:6',Rule::unique('admin')->ignore($id)]
        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد."
            ],
            "fr"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد."
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
        $admin->manager = Input::get("manager") ?: 0;
        $admin->reviewer = Input::get("reviewer") ?: 0;
        $admin->distributor = Input::get("distributor") ?: 0;
        $admin->respondent = Input::get("respondent") ?: 0;
        $admin->post = Input::get("post") ?: 0;
        $admin->announcement = Input::get("announcement") ?: 0;
        $success = $admin->save();

        if (!$success)
            return redirect("/control-panel/$lang/admin/info?id=$admin->id")->with("UpdateManagerMessage","لم يتم التعديل، اعد المحاولة مرة اخرى.");

        return redirect("/control-panel/$lang/admin/info?id=$admin->id")->with("UpdateManagerMessage","تم التعديل بنجاح.");
    }

    public function adminCreate($lang)
    {
        return view("cPanel.$lang.manager.admin_create")->with(["lang" => $lang]);
    }

    public function adminCreateValidation(Request $request, $lang)
    {
        $rules = [
            "name" => "required|min:6",
            "username" => "required|min:6|unique:admin,username",
            'password' => "required|min:6|confirmed",
            'password_confirmation' => "required|min:6",
        ];

        $rulesMessage = [
            "ar"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.required' => "كلمة المرور فارغة.",
                'password_confirmation.required' => 'حقل اعد كتابة كلمة المرور فارغ.',
                'password.min' => 'كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password_confirmation.min' => 'اعد كتابة كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ],
            "fr"=>[
                "name.required" => "الاسم الحقيقي فارغ.",
                "name.min" => "يجب ان يكون الاسم الحقيقي لايقل عن 6 حروف.",
                "username.required" => "اسم المستخدم فارغ.",
                "username.min" => "يجب ان يكون اسم المستخدم لايقل عن 6 حروف.",
                "username.unique" => "يوجد مستخدم أخر بنفس الاسم، يرجى استخدام اسم مستخدم جديد.",
                'password.required' => "كلمة المرور فارغة.",
                'password_confirmation.required' => 'حقل اعد كتابة كلمة المرور فارغ.',
                'password.min' => 'كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password_confirmation.min' => 'اعد كتابة كلمة المرور قصيرة,يجب ان تتكون كلمة المرور من 6 أحرف على الأقل.',
                'password.confirmed' => 'كلمتا المرور غير متطابقتين.'
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        $admin = new Admin;
        $admin->name = Input::get("name");
        $admin->username = Input::get("username");
        $admin->password = md5(Input::get("password"));
        $admin->type = $_SESSION["ADMIN_TYPE"];
        $admin->lang = $_SESSION["ADMIN_LANG"];
        $admin->date = date("Y-m-d");
        $admin->manager = Input::get("manager") ?: 0;
        $admin->reviewer = Input::get("reviewer") ?: 0;
        $admin->distributor = Input::get("distributor") ?: 0;
        $admin->respondent = Input::get("respondent") ?: 0;
        $admin->post = Input::get("post") ?: 0;
        $admin->announcement = Input::get("announcement") ?: 0;
        $success = $admin->save();

        if (!$success)
            return redirect("/control-panel/$lang/admin/create")->with("CreateManagerMessage","لم يتم انشاء الحساب بصورة صحيحة، اعد المحاولة مرة اخرى.");

        return redirect("/control-panel/$lang/admin/create")->with("CreateManagerMessage","تم انشاء الحساب بنجاح.");
    }

    /* Distributor */
    public function distributeQuestionsToRespondents($lang)
    {
        $questions = Question::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('adminId',null)
            ->where('lang',$lang)
            ->paginate(20);

        $respondents = Admin::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('lang',$lang)
            ->where('respondent',1)
            ->get();

        return view("cPanel.$lang.distributor.distributor")->with(["lang" => $lang, "questions" => $questions, "respondents" => $respondents]);
    }

    public function distribution()
    {
        $questionId = Input::get("questionId");
        $respondentId = Input::get("respondentId");
        $question = Question::find($questionId);
        $respondent = Admin::find($respondentId);

        if (!$question)
            return ["question" => "NotFound"];

        if (!$respondent)
            return ["respondent" => "NotFound"];

        $question->adminId = $respondentId;
        $success = $question->save();

        if (!$success)
            return ["success" => false];

        return ["success" => true];
    }

    public function changeQuestionType()
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);

        if (!$question)
            return ["question" => "NotFound"];

        $question->status = QuestionStatus::NO_ANSWER;
        $question->adminId = null;
        $question->categoryId = null;
        switch ($question->type)
        {
            case QuestionType::FEQHI: $question->type = QuestionType::AKAEDI; break;
            case QuestionType::AKAEDI: $question->type = QuestionType::FEQHI; break;
            default: $question->type = QuestionType::FEQHI;

        }
        $success = $question->save();
        if (!$success)
            return ["success" => false];

        return ["success" => true];
    }

    /* Respondent */
    public function showQuestionToRespondent($lang)
    {
        $questions = Question::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('lang',$_SESSION["ADMIN_LANG"])
            ->where('adminId',$_SESSION['ADMIN_ID'])
            ->where('status',QuestionStatus::NO_ANSWER)
            ->paginate(20);

        return view("cPanel.$lang.respondent.my_questions")->with(["lang" => $lang, "questions" => $questions]);
    }

    public function showQuestion($lang)
    {
        $questionId = Input::get("id");
        $question = Question::find($questionId);
        $categories = Category::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('lang',$_SESSION["ADMIN_LANG"])
            ->get();

        $tags = Tag::where('lang',$_SESSION["ADMIN_LANG"])->get();

        if (!$question)
            return redirect("/control-panel/$lang/my-questions");

        return view("cPanel.$lang.respondent.question")->with(["lang"=>$lang, "question"=>$question, "categories"=>$categories, "tags"=>$tags]);
    }

    public function questionAnswer(Request $request, $lang)
    {
        $question = Question::find(Input::get("questionId"));

        if (is_null($question))
            return redirect("/control-panel/$lang/question");

        $rules = [
            "questionId" => "required|numeric",
            "answer" => 'required',
            "categoryId" => "required|numeric",
            "tags" => "required",
            'image' => 'file|image|min:0|max:100',
        ];

        $rulesMessage = [
            "ar"=>[
                "questionId.required" => "رقم السؤال لم يرسل.",
                "answer.required" => "لاتوجد اجابة !!!",
                "categoryId.required" => "لم تقم بأختيار صنف السؤال.",
                "tags.required" => "لم تقم بأختيار الموضوع التابع له السؤال.",
                "attachmentName.file" => "قم برفع ملف.",
                "attachmentName.image" => "انت تحاول رفع ملف ليس بصورة.",
                "attachmentName.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "attachmentName.max" => "حجم الصورة يجب ان لايتعدى 100 كيلوبايت."
            ],
            "fr"=>[
                "questionId.required" => "رقم السؤال لم يرسل.",
                "answer.required" => "لاتوجد اجابة !!!",
                "categoryId.required" => "لم تقم بأختيار صنف السؤال.",
                "tags.required" => "لم تقم بأختيار الموضوع التابع له السؤال.",
                "attachmentName.file" => "قم برفع ملف.",
                "attachmentName.image" => "انت تحاول رفع ملف ليس بصورة.",
                "attachmentName.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "attachmentName.max" => "حجم الصورة يجب ان لايتعدى 100 كيلوبايت."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);


        DB::transaction(function () {
            $question = Question::find(Input::get("questionId"));
            if (!is_null(request()->file("image")))
            {
                if (Storage::exists($question->image))
                {
                    Storage::delete($question->image);
                    $question->image = null;
                }

                $imagePath = Storage::putFile('public/answerImages', request()->file("image"));
                $question->image = $imagePath;
            }
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("categoryId");
            $question->status = QuestionStatus::TEMP_ANSWER;
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");
            $question->save();
            $tags = explode(',',Input::get("tags"));
            foreach ($tags as $tag_id)
            {
                $questionTag = new QuestionTag();
                $questionTag->question_id = $question->id;
                $questionTag->tag_id = $tag_id;
                $questionTag->save();
            }
        });

        return redirect("/control-panel/$lang/my-questions")->with("AnswerQuestionMessage","تمت الأجابة عن السؤال");
    }
}
