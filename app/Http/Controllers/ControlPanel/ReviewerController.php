<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\EventLogType;
use App\Models\Category;
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
    public function questions()
    {
        $currentAdmin = Input::get("currentAdmin");
        $questions = Question::where('type', $currentAdmin->type)
            ->where('lang', $currentAdmin->lang)
            ->where('status', QuestionStatus::TEMP_ANSWER)
            ->orderBy('id')
            ->paginate(20);

        return view("cPanel.$currentAdmin->lang.reviewer.questions")->with(["lang" => $currentAdmin->lang,"questions" => $questions]);
    }

    public function acceptAnswer(Request $request)
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);

        if (!$question)
            return ["question" => "NotFound"];

        $question->status = QuestionStatus::APPROVED;
        $success = $question->save();

        if (!$success)
            return ["success" => false];

        EventLogController::add($request, "ACCEPT ANSWER FOR QUESTION", EventLogType::QUESTION, $question->id);

        return ["success" => true];
    }

    public function rejectAnswer(Request $request)
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);

        if (!$question)
            return ["question" => "NotFound"];

        DB::transaction(function (){
            $question = Question::find(Input::get("questionId"));
            if (!is_null($question->image))
                Storage::delete("public/".$question->image);
            $question->image = null;
            $question->answer = null;
            $question->categoryId = null;
            $question->status = QuestionStatus::NO_ANSWER;
            $question->videoLink = null;
            $question->externalLink = null;
            $question->save();

            QuestionTag::where('questionId',$question->id)->delete();
        });

        EventLogController::add($request, "REJECT ANSWER FOR QUESTION", EventLogType::QUESTION, $question->id);

        return ["success" => true];
    }

    public function deleteQuestion(Request $request)
    {
        $questionId = Input::get("questionId");
        $question = Question::find($questionId);

        if (!$question)
            return ["question" => "NotFound"];

        DB::transaction(function (){
            $question = Question::find(Input::get("questionId"));
            if (!is_null($question->image))
                Storage::delete("public/".$question->image);

            QuestionTag::where('questionId',$question->id)->delete();
            $question->delete();
        });

        EventLogController::add($request, "THE REVIEWER IS DELETING THE QUESTION", EventLogType::QUESTION, $question->id);

        return ["success" => true];
    }

    public function infoQuestion()
    {
        $currentAdmin = Input::get("currentAdmin");
        $questionId = Input::get("id");
        $question = Question::find($questionId);

        if (!$question)
            return redirect("/control-panel/$currentAdmin->lang/reviewed-questions")->with([
                "ArInfoMessage" => "عذرا، لايوجد مثل هذا السؤال.",
                "EnInfoMessage" => "Sorry, there is no such question.",
                "FrInfoMessage" => "Désolé, il n'y a pas de telle question."
            ]);

        $categories = Category::where("type", $currentAdmin->type)
            ->where("lang", $currentAdmin->lang)
            ->get();

        $tags = Tag::where("type", 0)
            ->where("lang", $currentAdmin->lang)
            ->get();

        return view("cPanel.$currentAdmin->lang.reviewer.editQuestion")->with([
            "lang" => $currentAdmin->lang,
            "question" => $question,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }

    public function updateAnswer(Request $request)
    {
        $currentAdmin = Input::get("currentAdmin");
        $question = Question::find(Input::get("id"));

        if (!$question)
            return redirect("/control-panel/$currentAdmin->lang/reviewed-questions")->with([
                "ArInfoMessage" => "عذرا، لايوجد مثل هذا السؤال.",
                "EnInfoMessage" => "Sorry, there is no such question.",
                "FrInfoMessage" => "Désolé, il n'y a pas de telle question."
            ]);

        $rules = [
            "answer" => 'required',
            "categoryId" => "required|numeric",
            "tags" => "required",
            'image' => 'file|image|min:50|max:200',
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
            $question = Question::find(Input::get("id"));

            // Delete Old Image
            if (Input::get("delete"))
            {
                if (Storage::exists($question->image))
                {
                    Storage::delete($question->image);
                    $question->image = null;
                }
            }

            // Save new image if exist
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

            // Update info question
            $question->answer = Input::get("answer");
            $question->categoryId = Input::get("categoryId");
            $question->status = QuestionStatus::APPROVED;
            $question->videoLink = Input::get("videoLink");
            $question->externalLink = Input::get("externalLink");
            $question->save();

            // Delete all old tags
            QuestionTag::where('questionId',$question->id)->delete();

            // Save new tags
            $tags = explode(',', Input::get("tags"));
            foreach ($tags as $tag_id)
            {
                $questionTag = new QuestionTag();
                $questionTag->questionId = $question->id;
                $questionTag->tagId = $tag_id;
                $questionTag->save();
            }
        });

        EventLogController::add($request, "UPDATE AND ACCEPT ANSWER FOR QUESTION", EventLogType::QUESTION, $question->id);

        return redirect("/control-panel/$currentAdmin->lang/reviewed-questions")->with([
            "ArInfoMessage" => "رائع، تم تعديل وقبول الاجابة بنجاح.",
            "EnInfoMessage" => "Wonderful, have been modified and accept the answer successfully.",
            "FrInfoMessage" => "Merveilleux, ont été modifiés et acceptent la réponse avec succès."
        ]);
    }
}
