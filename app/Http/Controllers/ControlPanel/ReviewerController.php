<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
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

        return view("cPanel.$currentAdmin->lang.reviewer.questions")->with([
            "lang" => $currentAdmin->lang,
            "questions" => $questions
        ]);
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

        EventLogController::add($request, "ACCEPT ANSWER FOR QUESTION", $question->id);

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

        EventLogController::add($request, "REJECT ANSWER FOR QUESTION", $question->id);

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

        $qusTag = array();

        foreach ($question->QuestionTags as $questionTag)
            $qusTag[] = $questionTag->tagId;

        return view("cPanel.$currentAdmin->lang.reviewer.editQuestion")->with([
            "lang" => $currentAdmin->lang,
            "question" => $question,
            "categories" => $categories,
            "tags" => $tags
        ]);
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
