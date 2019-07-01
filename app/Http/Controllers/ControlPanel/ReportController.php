<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\QuestionStatus;
use App\Enums\QuestionType;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        Auth::check();
        $lang = AdminController::getLang();
        $fCategories = Category::where("lang", "ar")->where("type", QuestionType::FEQHI)->get();
        $aCategories = Category::where("lang", "ar")->where("type", QuestionType::AKAEDI)->get();

        return view("control-panel.$lang.report.index")->with([
            "fCategories" => $fCategories,
            "aCategories" => $aCategories
        ]);
    }

    public function report($type, $privacy, $category)
    {
        Auth::check();
        $category = ($category==0)?null:$category;
        $lang = AdminController::getLang();
        $questions = Question::where("type", $type)
            ->where("categoryId", $category)
            ->where("privacy", $privacy)
            ->where("lang", $lang)
            ->where("status", QuestionStatus::APPROVED)
            ->get();
        $category = is_null($category)?"بدون قسم":Category::find($category)->category;

        return view("control-panel.$lang.report.questions")->with([
            "questions" => $questions,
            "type" => ($type==QuestionType::FEQHI)?"الفقه":"العقائد",
            "category" => $category
        ]);
    }
}
