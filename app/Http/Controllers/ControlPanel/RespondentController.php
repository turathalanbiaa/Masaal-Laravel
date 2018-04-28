<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\TargetName;
use App\Models\Category;
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
    public function questions()
    {
        $currentAdmin = Input::get("currentAdmin");
        $questions = Question::where('type', $currentAdmin->type)
            ->where('lang', $currentAdmin->lang)
            ->where('adminId', $currentAdmin->id)
            ->where('status',QuestionStatus::NO_ANSWER)
            ->orderBy('id')
            ->simplePaginate(20);

        return view("cPanel.$currentAdmin->lang.respondent.questions")->with([
            "lang" => $currentAdmin->lang,
            "questions" => $questions
        ]);
    }

    public function question(Request $request)
    {
        $currentAdmin = Input::get("currentAdmin");
        $questionId = Input::get("id");
        $question = Question::find($questionId);
        $categories = Category::where('type', $currentAdmin->type)
            ->where('lang', $currentAdmin->lang)
            ->get();

        $tags = Tag::where('lang', $currentAdmin->lang)
            ->get();

        if (!$question)
            return redirect("/control-panel/$currentAdmin->lang/my-questions")->with([
                "ArInfoMessage" => "عذرا، لايوجد مثل هذا السؤال.",
                "EnInfoMessage" => "Sorry, there is no such question.",
                "FrInfoMessage" => "Désolé, il n'y a pas de telle question."
            ]);

        EventLogController::add($request, "SHOW QUESTION", TargetName::QUESTION, $question->id);

        return view("cPanel.$currentAdmin->lang.respondent.question")->with([
            "lang" => $currentAdmin->lang,
            "question" => $question,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function answer(Request $request)
    {
        $currentAdmin = Input::get("currentAdmin");
        $question = Question::find(Input::get("questionId"));

        if (!$question)
            return redirect("/control-panel/$currentAdmin->lang/my-questions")->with([
                "ArInfoMessage" => "عذرا، لايوجد مثل هذا السؤال.",
                "EnInfoMessage" => "Sorry, there is no such question.",
                "FrInfoMessage" => "Désolé, il n'y a pas de telle question."
            ]);

        $rules = [
            "answer" => 'required',
            "categoryId" => "required|numeric",
            "tags" => "required",
            "image" => 'file|image|min:50|max:200',
        ];

        $rulesMessage = [
            "ar"=>[
                "answer.required" => "لاتوجد اجابة !!!",
                "categoryId.required" => "لم تقم بأختيار صنف السؤال.",
                "tags.required" => "لم تقم بأختيار الموضوع التابع له السؤال.",
                "image.file" => "انت تحاول رفع ملف ليس بصورة.",
                "image.image" => "انت تحاول رفع ملف ليس بصورة.",
                "image.min" => "انت تقوم برفع صورة صغيرة جداً.",
                "image.max" => "حجم الصورة يجب ان لايتعدى 200KB."
            ],
            "fr"=>[
                "answer.required" => "Il n'y a pas de réponse !!!",
                "categoryId.required" => "Vous n'avez pas sélectionné la catégorie de question.",
                "tags.required" => "Vous n'avez pas sélectionné l'objet de la question.",
                "image.file" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.image" => "Vous essayez de télécharger un fichier qui n'est pas dans un format.",
                "image.min" => "Vous soulevez une très petite image.",
                "image.max" => "La taille de l'image ne doit pas dépasser 200 Ko."
            ]
        ];

        if ($currentAdmin->lang == "en")
            $this->validate($request, $rules, []);

        if ($currentAdmin->lang == "ar")
            $this->validate($request, $rules, $rulesMessage["ar"]);

        if ($currentAdmin->lang == "fr")
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

            $tags = explode(',', Input::get("tags"));

            foreach ($tags as $tag)
            {
                $questionTag = new QuestionTag();
                $questionTag->questionId = $question->id;
                $questionTag->tagId = $tag;
                $questionTag->save();
            }
        });

        EventLogController::add($request, "ANSWER QUESTION", TargetName::QUESTION, $question->id);

        return redirect("/control-panel/$currentAdmin->lang/my-questions")->with([
            "ArInfoMessage" => "تمت الأجابة على السؤال.",
            "EnInfoMessage" => "The question has been answered.",
            "FrInfoMessage" => "La question a été répondue."
        ]);
    }
}
