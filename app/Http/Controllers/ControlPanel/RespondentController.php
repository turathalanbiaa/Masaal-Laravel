<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\EventLogType;
use App\Enums\QuestionType;
use App\Models\Admin;
use App\Models\Category;
use App\Models\EventLog;
use App\Models\Question;
use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class RespondentController extends Controller
{
    /**
     * Display questions.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::check();
        $currentAdmin = Admin::findOrFail(AdminController::getId());
        $lang = $currentAdmin->lang;
        $questions = $currentAdmin->unansweredQuestions()->simplePaginate(20);

        return view("control-panel.$lang.respondent.index")->with([
            "questions" => $questions
        ]);
    }

    /**
     * Show the form for editing the question.
     *
     * @param $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editQuestion($question)
    {
        Auth::check();
        $lang = AdminController::getLang();
        $type = AdminController::getType();
        $question = Question::findOrFail($question);
        $categories = Category::where('type', $type)
            ->where('lang', $lang)
            ->get();
        $tags = Tag::where('lang', $lang)
            ->get();

        return view("control-panel.$lang.respondent.edit")->with([
            "question" => $question,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    /**
     * Answer the question.
     *
     * @param Request $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function answerQuestion(Request $request, $question)
    {
        Auth::check();
        $lang = AdminController::getLang();
        $question = Question::findOrFail($question);
        $rules = [
            "answer" => 'required',
            "categoryId" => "required|numeric",
            "tags" => "required",
            "image" => 'file|image|min:50|max:500',
        ];
        $rulesMessage = [
            "ar"=>[
                "answer.required" => "لاتوجد اجابة !!!",
                "categoryId.required" => "لم تقم بأختيار صنف السؤال.",
                "tags.required" => "لم تقم بأختيار الموضوع التابع له السؤال.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 500KB."
            ],
            "fr"=>[
                "answer.required" => "Il n'y a pas de réponse !!!",
                "categoryId.required" => "Vous n'avez pas sélectionné la catégorie de question.",
                "tags.required" => "Vous n'avez pas sélectionné l'objet de la question.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 500 Ko."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Store answer
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("categoryId");
            $question->status = QuestionStatus::TEMP_ANSWER;
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");
            //Store image
            if (!is_null(request()->file("image")))
            {
                if (Storage::disk('public')->exists($question->image))
                    Storage::disk('public')->delete($question->image);
                $question->image = Storage::disk('public')->put('', request()->file("image"));
            }
            $question->save();

            //Store tags
            $tags = explode(',', Input::get("tags"));
            foreach ($tags as $tag)
            {
                $questionTag = new QuestionTag();
                $questionTag->questionId = $question->id;
                $questionTag->tagId = $tag;
                $questionTag->save();
            }

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "اجابة السؤال من قبل المجيب " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/respondent")->with([
                "ArAnswerQuestionMessage" => "تمت الأجابة على السؤال.",
                "EnAnswerQuestionMessage" => "The question has been answered.",
                "FrAnswerQuestionMessage" => "La question a été répondue."
            ]);
        else
            return redirect("/control-panel/respondent")->with([
                "ArAnswerQuestionMessage" => "لم يتم الأجابة على السؤال.",
                "EnAnswerQuestionMessage" => "The question has been not answered.",
                "FrAnswerQuestionMessage" => "La question n'a pas été répondu.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Return the question to distributor.
     *
     * @return array
     */
    public function returnQuestion()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Update question
            $question->adminId = null;
            $question->save();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم ارجاع السؤال الى الموزع من قبل المجيب " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }

    /**
     * Remove the question.
     *
     * @return array
     */
    public function deleteQuestion()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Remove question
            $question->delete();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم حذف السؤال من قبل المجيب " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }

    /**
     * Change type the question.
     *
     * @return array
     */
    public function changeTypeQuestion()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Update question
            $question->adminId = null;
            switch ($question->type)
            {
                case QuestionType::FEQHI: $question->type = QuestionType::AKAEDI; break;
                case QuestionType::AKAEDI: $question->type = QuestionType::FEQHI; break;
                default: $question->type = QuestionType::FEQHI;
            }
            $question->save();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم تغيير نوع السؤال من قبل المجيب " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }


    /**
     * Display answers for the specific respondent.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAnswers()
    {
        Auth::check();
        $lang = AdminController::getLang();
        if (is_null(Input::get("t")) && is_null(Input::get("q")))
            $questions = Question::where("adminId", AdminController::getId())
                ->where("status", "!=", QuestionStatus::NO_ANSWER)
                ->orderBy("id", "DESC")
                ->simplePaginate(20);
        else
            if (Input::get("t") == 1)
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("content", "like", "%".Input::get("q")."%")
                    ->orderBy("id", "DESC")
                    ->simplePaginate(20);
            else
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("answer", "like", "%".Input::get("q")."%")
                    ->orderBy("id", "DESC")
                    ->simplePaginate(20);


        return view("control-panel.$lang.respondent.my-answers")->with([
            "questions" => $questions
        ]);
    }

    /**
     * Show the form for editing the question.
     *
     * @param $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMyAnswer($question)
    {
        Auth::check();
        $question = Question::findOrFail($question);
        $currentAdmin = Admin::findOrFail(AdminController::getId());
        $lang = $currentAdmin->lang;
        $type = $currentAdmin->type;
        $categories = Category::where("type", $type)
            ->where("lang", $lang)
            ->get();
        $tags = Tag::where("lang", $lang)
            ->get();

        return view("control-panel.$lang.respondent.edit-answer")->with([
            "question" => $question,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    /**
     * Update the question in storage.
     *
     * @param Request $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMyAnswer(Request $request, $question)
    {
        Auth::check();
        $question = Question::findOrFail($question);
        $lang = AdminController::getLang();
        $rules = [
            "answer" => 'required',
            "categoryId" => "required|numeric",
            "tags" => "required",
            'image' => 'file|image|min:50|max:500',
        ];
        $rulesMessage = [
            "ar"=>[
                "answer.required" => "لاتوجد اجابة !!!",
                "categoryId.required" => "لم تقم بأختيار صنف السؤال.",
                "tags.required" => "لم تقم بأختيار الموضوع التابع له السؤال.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 500KB."
            ],
            "fr"=>[
                "answer.required" => "Il n'y a pas de réponse !!!",
                "categoryId.required" => "Vous n'avez pas sélectionné la catégorie de question.",
                "tags.required" => "Vous n'avez pas sélectionné l'objet de la question.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 500 Ko."
            ]
        ];

        if ($lang == "en")
            $this->validate($request, $rules, []);

        if ($lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($lang == "fr")
            $this->validate($request, $rules, $rulesMessage["fr"]);

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Delete Old Image
            if (!is_null(Input::get("delete")) && Storage::disk('public')->exists($question->image))
            {
                Storage::disk('public')->delete($question->image);
                $question->image = null;
            }

            //Store new image
            if (!is_null(request()->file("image")))
            {
                if (Storage::disk('public')->exists($question->image))
                    Storage::disk('public')->delete($question->image);
                $question->image = Storage::disk('public')->put('', request()->file("image"));
            }

            //Delete old tags
            foreach ($question->QuestionTags as $tag)
                $tag->delete();

            //Update answer
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("categoryId");
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");
            $question->save();

            //Store new tags
            $tags = explode(',', Input::get("tags"));
            foreach ($tags as $tag_id)
            {
                $questionTag = new QuestionTag();
                $questionTag->questionId = $question->id;
                $questionTag->tagId = $tag_id;
                $questionTag->save();
            }

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم تعديل الاجابة من قبل المجيب " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/respondent/my-answers")->with([
                "ArUpdateAnswerMessage" => "تم تعديل الاجابة بنجاح.",
                "EnUpdateAnswerMessage" => "Your answer has been successfully modified.",
                "FrUpdateAnswerMessage" => "Votre réponse a été modifiée avec succès."
            ]);
        else
            return redirect("/control-panel/respondent/my-answers")->with([
                "ArUpdateAnswerMessage" => "لم يتم تعديل الاجابة بنجاح.",
                "EnUpdateAnswerMessage" => "The answer has not been successfully modified.",
                "FrUpdateAnswerMessage" => "La réponse n'a pas été modifiée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Display answers.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function answers()
    {
        Auth::check();
        $currentAdminId = AdminController::getId();
        $lang = AdminController::getLang();
        $permission = AdminController::getPermission();

        if (is_null(Input::get("t")) && is_null(Input::get("q")))
            $questions = Question::where("lang", $lang)
                ->where("status", "!=", QuestionStatus::NO_ANSWER)
                ->orderBy("id", "DESC")
                ->simplePaginate(20);
        else
            if (Input::get("t") == 1)
                $questions = Question::where("lang", $lang)
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("content", "like", "%".Input::get("q")."%")
                    ->orderBy("id", "DESC")
                    ->simplePaginate(20);
            else
                $questions = Question::where("lang", $lang)
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("answer", "like", "%".Input::get("q")."%")
                    ->orderBy("id", "DESC")
                    ->simplePaginate(20);

        return view("control-panel.$lang.respondent.answers")->with([
            "currentAdminId" => $currentAdminId,
            "permission" =>$permission,
            "questions" => $questions
        ]);
    }
}
