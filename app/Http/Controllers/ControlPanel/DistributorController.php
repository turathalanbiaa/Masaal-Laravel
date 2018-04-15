<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\QuestionType;
use App\Models\Admin;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DistributorController extends Controller
{
    public function distributeQuestionsToRespondents()
    {
        $currentAdmin = Input::get("currentAdmin");

        $questions = Question::where('type', $currentAdmin->type)
            ->where('adminId',null)
            ->where('lang', $currentAdmin->lang)
            ->orderBy("id")
            ->simplePaginate(25);

        $respondents = Admin::where('type', $currentAdmin->type)
            ->where('lang', $currentAdmin->lang)
            ->where('respondent', 1)
            ->orderBy("id")
            ->get();

        return view("cPanel.$currentAdmin->lang.distributor.distributor")->with([
            "lang" => $currentAdmin->lang,
            "questions" => $questions,
            "respondents" => $respondents
        ]);
    }

    public function distribution(Request $request)
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

        EventLogController::add($request, "DISTRIBUTE QUESTION", $question->id);

        return ["success" => true];
    }

    public function changeQuestionType(Request $request)
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

        EventLogController::add($request, "CHANGE TYPE QUESTION", $question->id);

        return ["success" => true];
    }
}
