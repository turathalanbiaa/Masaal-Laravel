<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\QuestionType;
use App\Enums\EventLogType;
use App\Models\Admin;
use App\Models\EventLog;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DistributorController extends Controller
{
    /**
     * Display questions to distribute it's to respondents.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::check();
        $lang = AdminController::getLang();
        $type = AdminController::getType();
        $questions = Question::where('type', $type)
            ->where('adminId', null)
            ->where('lang', $lang)
            ->simplePaginate(20);
        $respondents = Admin::where('type', $type)
            ->where('lang', $lang)
            ->get()
            ->filter(function ($admin){
            return ($admin->permission->respondent == 1);
        });

        return view("control-panel.$lang.distributor.index")->with([
            "questions" => $questions,
            "respondents" => $respondents
        ]);
    }

    /**
     * Distribute the question to the respondent.
     *
     * @return array
     */
    public function distributeQuestion()
    {
        Auth::check();
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

        //Store event log
        $target = $question->id;
        $type = EventLogType::QUESTION;
        $event = "توزيع السؤال على المجيب " . $respondent->name . "من قبل الموزع " . AdminController::getName();
        EventLog::create($target, $type, $event);

        return ["success" => true];
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
            $event = "تم حذف السؤال من قبل الموزع " . AdminController::getName();
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
            $event = "تم تغيير نوع السؤال من قبل الموزع " . AdminController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return ["success" => true];
        else
            return ["success" => false];
    }
}
