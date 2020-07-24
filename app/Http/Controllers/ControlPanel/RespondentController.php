<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\EventLogType;
use App\Enums\QuestionType;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Comment;
use App\Models\EventLog;
use App\Models\Question;
use App\Models\QuestionTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
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
        $questions = $currentAdmin->questionsUnanswered()->paginate(25);

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
            "category" => "required|numeric",
            "tags" => "required",
            "image" => 'file|image|min:50|max:500',
        ];
        $rulesMessage = [
            "ar" => [
                "answer.required" => "حقل الإجابة مطلوب.",
                "category.required" => "حقل الصنف مطلوب.",
                "tags.required" => "حقل الموضوع(المواضيع) مطلوب.",
                "image.file" => "يجب أن تكون الصورة صورة.",
                "image.image" => "يجب أن تكون الصورة صورة.",
                "image.min" => "يجب أن تكون الصورة لا تقل عن 50 كيلو بايت.",
                "image.max" => "يجب أن لا تكون الصورة أكبر من 500 كيلو بايت."
            ],
            "fr" => [
                "answer.required" => "Le champ de réponse est obligatoire.",
                "category.required" => "Le champ catégorie est obligatoire.",
                "tags.required" => "Le champ balises est obligatoire.",
                "image.file" => "L'image doit être une image.",
                "image.image" => "L'image doit être une image.",
                "image.min" => "L'image doit faire au moins 50 kilo-octets.",
                "image.max" => "L'image ne doit pas dépasser 500 kilo-octets."
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
            $question->categoryId = Input::get("category");
            $question->status = QuestionStatus::TEMP_ANSWER;
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");
            $question->image = is_null(request()->file("image")) ?
                null :
                Storage::disk('public')->put('', request()->file("image"));
            $question->save();

            //Store tags
            $tags = explode(',', Input::get("tags"));
            foreach ($tags as $tag) {
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
                "ArAnswerQuestionMessage" => "تمت الأجابة على السؤال",
                "EnAnswerQuestionMessage" => "The question has been answered",
                "FrAnswerQuestionMessage" => "La question a été répondue"
            ]);
        else
            return redirect("/control-panel/respondent/$question->id/edit")->with([
                "ArAnswerQuestionMessage" => "لم يتم الأجابة على السؤال",
                "EnAnswerQuestionMessage" => "The question has been not answered",
                "FrAnswerQuestionMessage" => "La question n'a pas été répondu",
            ]);
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

            $question->type = QuestionType::FEQHI;

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
   public function changeTypeQuestion2()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Update question
            $question->adminId = null;


                    $question->type = QuestionType::AKAEDI;


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
   public function changeTypeQuestion3()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Update question
            $question->adminId = null;

                    $question->type = QuestionType::QURAN;

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
   public function changeTypeQuestion4()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question) {
            //Update question
            $question->adminId = null;

                    $question->type = QuestionType::SOCIAL;

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
    public function DeleteComment($lang, $id, $comment_id)
    {

        $comment = Comment::find($comment_id);

        $comment->delete();


       return  redirect("/control-panel/respondent/single-comment/$lang/$id");

    }

    public function SingleComment($lang, $id)
    {
        $SQL = "SELECT question.id ,question.`type` AS `type` , question.categoryId AS categoryId, content , user.name AS userDisplayName , category.category AS category , `time` , answer , image , status , videoLink , externalLink 
                FROM question LEFT JOIN category ON categoryId = category.id LEFT JOIN user ON userId = user.id
                WHERE question.id = ?";


        $questions = DB::select($SQL, [$id]);
        $question = array_values($questions)[0];


        $SQL = "SELECT * , comment.id as  comment_id   , user.name as username  FROM comment LEFT JOIN user ON user_id = user.id WHERE comment.question_id = ?  and status = 1  ORDER by comment.id";

        $comments = DB::select($SQL, [$id]);

        return view("control-panel.$lang.respondent.single_question", ["question" => $question, "comments" => $comments]);
    }

    public function myAnswers()
    {
        Auth::check();
        $lang = AdminController::getLang();
        if (is_null(Input::get("t")) && is_null(Input::get("q")))
            $questions = Question::where("adminId", AdminController::getId())
                ->where("status", "!=", QuestionStatus::NO_ANSWER)
                ->orderBy("id", "DESC")
                ->paginate(25);
        else
            if (is_null(Input::get("t")) || Input::get("t") == 1)
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("content", "like", "%" . Input::get("q") . "%")
                    ->orderBy("id", "DESC")
                    ->paginate(25);
            else
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("answer", "like", "%" . Input::get("q") . "%")
                    ->orderBy("id", "DESC")
                    ->paginate(25);


        return view("control-panel.$lang.respondent.my-answers")->with([
            "questions" => $questions
        ]);
    }

    public function myComments()
    {

        Auth::check();
        $lang = AdminController::getLang();
        if (is_null(Input::get("t")) && is_null(Input::get("q")))

            $questions = Question::RightJoin('comment', 'question.id', '=', 'comment.question_id')
                ->where("adminId", AdminController::getId())
                ->where("question.status", "!=", QuestionStatus::NO_ANSWER)
                ->select('*', 'question.id', 'comment.type as comment_type', 'comment.id as comment_id', 'question.type as type', 'question.categoryId as categoryId', 'comment.content as comment_content', 'question.content as question_content')
                ->orderBy("comment.id", "DESC")
                ->paginate(25);


        else
            if (is_null(Input::get("t")) || Input::get("t") == 1)
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("content", "like", "%" . Input::get("q") . "%")
                    ->select('*', 'question.id', 'comment.type as comment_type', 'comment.id as comment_id', 'question.type as type', 'question.categoryId as categoryId', 'comment.content as comment_content', 'question.content as question_content')
                    ->orderBy("id", "DESC")
                    ->paginate(25);
            else
                $questions = Question::where("adminId", AdminController::getId())
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("answer", "like", "%" . Input::get("q") . "%")
                    ->select('*', 'question.id', 'comment.type as comment_type', 'comment.id as comment_id', 'question.type as type', 'question.categoryId as categoryId', 'comment.content as comment_content', 'question.content as question_content')
                    ->orderBy("id", "DESC")
                    ->paginate(25);


        return view("control-panel.$lang.respondent.my-comments")->with([
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
            "category" => "required|numeric",
            "tags" => "required",
            "image" => 'file|image|min:50|max:500',
        ];
        $rulesMessage = [
            "ar" => [
                "answer.required" => "حقل الإجابة مطلوب.",
                "category.required" => "حقل الصنف مطلوب.",
                "tags.required" => "حقل الموضوع(المواضيع) مطلوب.",
                "image.file" => "يجب أن تكون الصورة صورة.",
                "image.image" => "يجب أن تكون الصورة صورة.",
                "image.min" => "يجب أن تكون الصورة لا تقل عن 50 كيلو بايت.",
                "image.max" => "يجب أن لا تكون الصورة أكبر من 500 كيلو بايت."
            ],
            "fr" => [
                "answer.required" => "Le champ de réponse est obligatoire.",
                "category.required" => "Le champ catégorie est obligatoire.",
                "tags.required" => "Le champ balises est obligatoire.",
                "image.file" => "L'image doit être une image.",
                "image.image" => "L'image doit être une image.",
                "image.min" => "L'image doit faire au moins 50 kilo-octets.",
                "image.max" => "L'image ne doit pas dépasser 500 kilo-octets."
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
            //Remove Old Image
            if (!is_null(Input::get("delete"))) {
                Storage::disk('public')->delete($question->image);
                $question->image = null;
            }

            //Remove old tags
            foreach ($question->QuestionTags as $tag)
                $tag->delete();

            //Update answer
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("category");
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");

            //Store new image
            if (!is_null(request()->file("image"))) {
                Storage::disk('public')->delete($question->image);
                $question->image = Storage::disk('public')->put('', request()->file("image"));
            }

            //Update question
            $question->save();

            //Store new tags
            $tags = explode(',', Input::get("tags"));
            foreach ($tags as $tag_id) {
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
                "ArUpdateAnswerMessage" => "تم تعديل الاجابة بنجاح",
                "EnUpdateAnswerMessage" => "Your answer has been successfully modified",
                "FrUpdateAnswerMessage" => "Votre réponse a été modifiée avec succès"
            ]);
        else
            return redirect("/control-panel/respondent/my-answers/$question->id/edit-answer")->with([
                "ArUpdateAnswerMessage" => "لم يتم تعديل الاجابة بنجاح",
                "EnUpdateAnswerMessage" => "The answer has not been successfully modified",
                "FrUpdateAnswerMessage" => "La réponse n'a pas été modifiée avec succès"
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
        $type = AdminController::getType();
        $permission = AdminController::getPermission();

        if (is_null(Input::get("t")) && is_null(Input::get("q")))
            $questions = Question::where("lang", $lang)
                ->where("status", "!=", QuestionStatus::NO_ANSWER)
                ->where("type", $type)
                ->orderBy("id", "DESC")
                ->paginate(25);
        else
            if (is_null(Input::get("t")) || Input::get("t") == 1)
                $questions = Question::where("lang", $lang)
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("type", $type)
                    ->where("content", "like", "%" . Input::get("q") . "%")
                    ->orderBy("id", "DESC")
                    ->paginate(25);
            else
                $questions = Question::where("lang", $lang)
                    ->where("status", "!=", QuestionStatus::NO_ANSWER)
                    ->where("type", $type)
                    ->where("answer", "like", "%" . Input::get("q") . "%")
                    ->orderBy("id", "DESC")
                    ->paginate(25);

        return view("control-panel.$lang.respondent.answers")->with([
            "currentAdminId" => $currentAdminId,
            "permission" => $permission,
            "questions" => $questions
        ]);
    }
}
