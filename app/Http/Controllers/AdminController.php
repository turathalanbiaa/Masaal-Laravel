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


    /* Respondent */
    public function showQuestionToRespondent($lang)
    {
        $questions = Question::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('lang',$_SESSION["ADMIN_LANG"])
            ->where('adminId',$_SESSION['ADMIN_ID'])
            ->where('status',QuestionStatus::NO_ANSWER)
            ->orderBy('id')
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
                $Path = Storage::putFile("public", request()->file("image"));
                $imagePath = explode('/',$Path);
                $question->image = $imagePath[1];
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

    /* Reviewer */
    public function reviewedQuestions($lang)
    {
        $questions = Question::where('type',$_SESSION["ADMIN_TYPE"])
            ->where('lang',$_SESSION["ADMIN_LANG"])
            ->where('status',QuestionStatus::TEMP_ANSWER)
            ->orderBy('id')
            ->paginate(20);

        return view("cPanel.$lang.reviewer.reviewedQuestions")->with(["lang" => $lang, "questions" => $questions]);
    }

    public function acceptAnswer()
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);
        if (!$question)
            return ["question" => "NotFound"];

        if ($_SESSION["ADMIN_REVIEWER"] == 1)
        {
            $question->status = QuestionStatus::APPROVED;
            $success = $question->save();
            if (!$success)
                return ["success" => false];

            return ["success" => true];
        }

        return ["Admin" => "NotReviewer"];
    }

    public function rejectAnswer()
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);
        if (!$question)
            return ["question" => "NotFound"];

        if ($_SESSION["ADMIN_REVIEWER"] == 1)
        {
            DB::transaction(function (){
                $question = Question::find(Input::get("questionId"));
                Storage::delete("public/".$question->image);
                $question->image = null;
                $question->answer = null;
                $question->categoryId = null;
                $question->status = QuestionStatus::NO_ANSWER;
                $question->videoLink = null;
                $question->externalLink = null;
                $question->save();
                QuestionTag::where('question_id',$question->id)->delete();
            });
            return ["success" => true];
        }

        return ["Admin" => "NotReviewer"];
    }

    public function questionInfo($lang)
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);
        if (!$question)
            return redirect();
        return view();
    }

    public function updateAnswer($lang)
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);
        if (!$question)
            return redirect();
        return view();
    }
}
