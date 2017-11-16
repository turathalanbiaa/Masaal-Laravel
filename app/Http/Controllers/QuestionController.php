<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 10/30/2017
 * Time: 10:02 PM
 */

namespace App\Http\Controllers;


use App\Enums\QuestionStatus;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Question;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{

    public function index($lang, $type)
    {

        $questions = Question::where("lang", $lang)->where("type", $type)->where("status", QuestionStatus::APPROVED)->get();
        $announcements = Announcement::where("lang", $lang)->where("type", $type)->get();

        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => [$announcements]]);
    }

    public function my($lang)
    {
        $type = "1";
        $userId = 1;
        $questions = Question::where("lang", $lang)->where("type", $type)->where("userId", $userId)->where("status", QuestionStatus::APPROVED)->get();

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);
    }

    public function search($lang)
    {

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => []]);

    }

    public function searchBy($lang)
    {
        $type = Input::get("type");
        $id = Input::get("id");


        $questions = Question::where("lang", $lang)->where("type", $type)->where("categoryId", $id)->where("status", QuestionStatus::APPROVED)->get();

        return view("$lang.Question.questions", ["page_title" => "My Questions", "questions" => [$questions]]);

    }

    public function showSendQuestion($lang)
    {
        return view("$lang.Question.send_question");
    }


    public function showCategories($lang)
    {


        $first_categorys = Category::where("lang", $lang)->where("type", 1)->get();
        $second_categorys = Category::where("lang", $lang)->where("type", 2)->get();

        return view("$lang.Question.categories", ["first_categorys" => $first_categorys, "second_categorys" => $second_categorys]);
    }

    public function showQuestion($lang, $id)
    {

        $question = Question::find($id);

        return view("$lang.Question.single_question", ["question" => $question]);
    }

    public function tagQuestion($lang, $tag)
    {

        $questions = DB::table('question')
            ->join('question_tag', 'question.id', '=', 'question_tag.question_id')
            ->join('tag', 'tag.id', '=', 'question_tag.tag_id')
            ->select('question.*', 'tag.tag')->where("tag.tag", $tag)
            ->get();

        return view("$lang.Question.questions", ["page_title" => "Home", "questions" => [$questions], "announcements" => null]);
    }
}