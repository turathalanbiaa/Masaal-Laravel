<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\EventLogType;
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

class ReviewerController extends Controller
{
    /**
     * Display the questions.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::check();
        $lang = AdminController::getLang();
        $type = AdminController::getType();
        $questions = Question::where('type', $type)
            ->where('lang', $lang)
            ->where("status", QuestionStatus::TEMP_ANSWER)
            ->paginate(25);

        return view("control-panel.$lang.reviewer.index")->with([
            "questions" => $questions
        ]);
    }

    /**
     * Show the form for editing the answer.
     *
     * @param $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAnswer($question)
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

        return view("control-panel.$lang.reviewer.edit")->with([
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
    public function updateAnswer(Request $request, $question)
    {
        Auth::check();
        $question = Question::findOrFail($question);
        $lang = AdminController::getLang();
        $rules = [
            "answer" => 'required',
            "category" => "required|numeric",
            "tags" => "required",
            'image' => 'file|image|min:50|max:500',
        ];
        $rulesMessage = [
            "ar"=>[
                "answer.required" => "حقل الإجابة مطلوب.",
                "category.required" => "حقل الصنف مطلوب.",
                "tags.required" => "حقل الموضوع(المواضيع) مطلوب.",
                "image.file" => "يجب أن تكون الصورة صورة.",
                "image.image" => "يجب أن تكون الصورة صورة.",
                "image.min" => "يجب أن تكون الصورة لا تقل عن 50 كيلو بايت.",
                "image.max" => "يجب أن لا تكون الصورة أكبر من 500 كيلو بايت."


            ],
            "fr"=>[
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
            if (!is_null(Input::get("delete")))
            {
                Storage::disk('public')->delete($question->image);
                $question->image = null;
            }

            //Remove old tags
            foreach ($question->QuestionTags as $tag)
                $tag->delete();

            //Update answer
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("category");
            $question->status = QuestionStatus::APPROVED;
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");

            //Store new image
            if (!is_null(request()->file("image")))
            {
                Storage::disk('public')->delete($question->image);
                $question->image = Storage::disk('public')->put('', request()->file("image"));
            }

            //Update question
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
            $event = "تم تعديل وقبول الاجابة من قبل المدقق " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/reviewer")->with([
                "ArUpdateAnswerMessage" => "تم تعديل وقبول الاجابة بنجاح.",
                "EnUpdateAnswerMessage" => "The answer was successfully modified and accepted.",
                "FrUpdateAnswerMessage" => "La réponse a été modifiée et acceptée avec succès."
            ]);
        else
            return redirect("/control-panel/reviewer")->with([
                "ArUpdateAnswerMessage" => "لم يتم تعديل وقبول الاجابة بنجاح.",
                "EnUpdateAnswerMessage" => "The answer has not been successfully modified and accepted.",
                "FrUpdateAnswerMessage" => "La réponse n'a pas été modifiée et acceptée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }

    /**
     * Accept answer for the question.
     *
     * @return array
     */
    public function acceptAnswer()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question){
            //update question
            $question->status = QuestionStatus::APPROVED;
            $question->save();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم قبول الاجابة من قبل المدقق " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }

    /**
     * Reject answer for the question.
     *
     * @return array
     */
    public function rejectAnswer()
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question){
            //Remove tags
            foreach ($question->QuestionTags as $tag)
                $tag->delete();

            //Remove image
            Storage::disk('public')->delete($question->image);

            //update question
            $question->image = null;
            $question->answer = null;
            $question->categoryId = null;
            $question->status = QuestionStatus::NO_ANSWER;
            $question->videoLink = null;
            $question->externalLink = null;
            $question->save();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم رفض الاجابة من قبل المدقق " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }

    /**
     * Remove the question
     *
     * @param Request $request
     * @return array
     */
    public function deleteQuestion(Request $request)
    {
        Auth::check();
        $question = Question::find(Input::get("question"));
        if (!$question)
            return ["question" => "NotFound"];

        //Transaction
        $exception = DB::transaction(function () use ($question){
            //Remove tags
            foreach ($question->QuestionTags as $tag)
                $tag->delete();

            //Remove image
            Storage::disk('public')->delete($question->image);

            //Remove question
            $question->delete();

            //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم حذف السؤال من قبل المدقق " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }
}
