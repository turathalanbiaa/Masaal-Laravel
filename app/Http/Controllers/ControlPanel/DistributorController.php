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
     * Display questions to distribute it's to respondents
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Auth::check();
        $lang = MainController::getLanguage();
        $type = MainController::getType();

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
     * Distribution operation
     *
     * @param Request $request
     * @return array
     */
    public function distributeQuestion(Request $request)
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
        $event = "توزيع السؤال على المجيب " . $respondent->name;
        EventLog::create($target, $type, $event);

        return ["success" => true];
    }


    /**
     * Remove the question
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteQuestion(Request $request)
    {
        Auth::check();

        //Transaction
        $exception = DB::transaction(function () {
            //Remove question
           $question = Question::findOrFail(Input::get("question"));
           $question->delete();

           //Store event log
            $target = $question->id;
            $type = EventLogType::QUESTION;
            $event = "تم حذف السؤال من قبل الموزع " . MainController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/distributors")->with([
                "ArDeleteQuestionMessage" => "تم حذف السؤال بنجاح.",
                "EnDeleteQuestionMessage" => "Question successfully deleted.",
                "FrDeleteQuestionMessage" => "Question supprimée avec succès."
            ]);
        else
            return redirect("/control-panel/distributors")->with([
                "ArDeleteQuestionMessage" => "لم يتم حذف السؤال بنجاح.",
                "EnDeleteQuestionMessage" => "The question was not deleted successfully.",
                "FrDeleteQuestionMessage" => "La question n'a pas été supprimée avec succès.",
                "TypeMessage" => "Error"
            ]);
    }


    /**
     * Change type for the question
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeTypeQuestion(Request $request)
    {
        Auth::check();

        //Transaction
        $exception = DB::transaction(function () {
            //Change type question
            $question = Question::findOrFail(Input::get("question"));
            $question->status = QuestionStatus::NO_ANSWER;
            $question->adminId = null;
            $question->categoryId = null;

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
            $event = "تم تغيير نوع السؤال من قبل الموزع " . MainController::getName();
            EventLog::create($target, $type, $event);
        });

        if (is_null($exception))
            return redirect("/control-panel/distributors")->with([
                "ArChangeTypeQuestionMessage" => "تم تغيير نوع السؤال بنجاح.",
                "EnChangeTypeQuestionMessage" => "Question type changed successfully.",
                "FrChangeTypeQuestionMessage" => "Le type de question a été modifié avec succès."
            ]);
        else
            return redirect("/control-panel/distributors")->with([
                "ArChangeTypeQuestionMessage" => "لم يتم تغيير نوع السؤال بنجاح.",
                "EnChangeTypeQuestionMessage" => "The question type was not changed successfully.",
                "FrChangeTypeQuestionMessage" => "Le type de question n'a pas été modifié avec succès.",
                "TypeMessage" => "Error"
            ]);
    }
}
